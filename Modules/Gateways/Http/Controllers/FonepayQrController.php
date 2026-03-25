<?php

namespace Modules\Gateways\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Modules\Gateways\Entities\PaymentRequest;
use Modules\Gateways\Traits\Processor;

class FonepayQrController extends Controller
{
    use Processor;

    private mixed $config_values;
    private string $config_mode = 'test';
    private PaymentRequest $payment;
    private string $dev_url = 'https://dev-clientapi.fonepay.com/api/merchantRequest';
    private string $live_url = 'https://clientapi.fonepay.com/api/merchantRequest';

    public function __construct(PaymentRequest $payment)
    {
        $config = $this->payment_config('fonepay_qr', 'payment_config');
        if (!is_null($config) && $config->mode == 'live') {
            $this->config_values = json_decode($config->live_values);
            $this->config_mode = 'live';
        } elseif (!is_null($config) && $config->mode == 'test') {
            $this->config_values = json_decode($config->test_values);
            $this->config_mode = 'test';
        } else {
            $this->config_values = (object)[];
        }

        $this->payment = $payment;
    }

    /**
     * Initiate Fonepay QR payment (redirect form).
     */
    public function payment(Request $req): View|Application|Factory|JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $validator = Validator::make($req->all(), [
            'payment_id' => 'required|uuid'
        ]);

        if ($validator->fails()) {
            return response()->json($this->response_formatter(GATEWAYS_DEFAULT_400, null, $this->error_processor($validator)), 400);
        }

        $data = $this->payment::where(['id' => $req['payment_id']])->where(['is_paid' => 0])->first();
        if (!isset($data)) {
            return response()->json($this->response_formatter(GATEWAYS_DEFAULT_204), 200);
        }

        $config_val = $this->config_values;
        $config_mode = $this->config_mode;

        $merchantCode = $config_val->merchant_code ?? '';
        $sharedSecret = $config_val->secret_key ?? '';
        $returnUrl = !empty($config_val->return_url) ? $config_val->return_url : route('fonepay-qr.callback');

        $amount = number_format((float)$data->payment_amount, 2, '.', '');
        $currency = 'NPR';
        $md = 'P';
        $dt = date('m/d/Y');
        $r1 = $config_val->r1 ?? '';
        $r2 = $config_val->r2 ?? 'N/A';

        // PRN max length 25. Use shortened payment uuid.
        $prn = substr(str_replace('-', '', $data->id), 0, 20);
        $data->transaction_id = $prn;
        $data->save();

        $dvMessage = implode(',', [
            $merchantCode,
            $md,
            $prn,
            $amount,
            $currency,
            $dt,
            $r1,
            $r2,
            $returnUrl
        ]);
        $dv = hash_hmac('sha512', $dvMessage, $sharedSecret);

        $paymentUrl = $config_mode === 'live' ? $this->live_url : $this->dev_url;

        return view('Gateways::payment.fonepay_qr', compact(
            'paymentUrl',
            'merchantCode',
            'md',
            'prn',
            'amount',
            'currency',
            'dt',
            'r1',
            'r2',
            'returnUrl',
            'dv',
            'config_mode'
        ));
    }

    /**
     * Fonepay QR callback (verify DV and mark payment).
     */
    public function callback(Request $request): Application|JsonResponse|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $config_val = $this->config_values;
        $sharedSecret = $config_val->secret_key ?? '';
        $merchantCode = $config_val->merchant_code ?? '';

        $prn = $request->get('PRN');
        $pid = $request->get('PID');
        $ps = $request->get('PS'); // true/false
        $rc = $request->get('RC');
        $uid = $request->get('UID');
        $bc = $request->get('BC');
        $ini = $request->get('INI');
        $pAmt = $request->get('P_AMT');
        $rAmt = $request->get('R_AMT');
        $dv = $request->get('DV');

        $dvMessage = implode(',', [
            $prn,
            $pid,
            $ps,
            $rc,
            $uid,
            $bc,
            $ini,
            $pAmt,
            $rAmt
        ]);
        $expectedDv = hash_hmac('sha512', $dvMessage, $sharedSecret);

        $payment_data = $this->payment::where(['transaction_id' => $prn])->first();
        if (!isset($payment_data)) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        $dvMatch = !empty($dv) && hash_equals(strtolower($expectedDv), strtolower($dv));
        $pidMatch = empty($merchantCode) || $merchantCode === $pid;
        $success = filter_var($ps, FILTER_VALIDATE_BOOLEAN) && $dvMatch && $pidMatch;

        if ($success) {
            $this->payment::where(['transaction_id' => $prn])->update([
                'payment_method' => 'fonepay_qr',
                'is_paid' => 1,
                'transaction_id' => $uid ?: $prn,
            ]);
            $payment_data = $this->payment::where(['transaction_id' => ($uid ?: $prn)])->first() ?? $payment_data;
            if (isset($payment_data) && function_exists($payment_data->success_hook)) {
                call_user_func($payment_data->success_hook, $payment_data);
            }
            return $this->payment_response($payment_data, 'success');
        }

        if (isset($payment_data) && function_exists($payment_data->failure_hook)) {
            call_user_func($payment_data->failure_hook, $payment_data);
        }
        return $this->payment_response($payment_data, 'fail');
    }
}
