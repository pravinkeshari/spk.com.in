<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>
        {{ translate('Esewa Payment') }}
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('Modules/Gateways/public/assets/modules/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Modules/Gateways/public/assets/modules/css/esewa.css') }}">
</head>

<body>
<pre style="padding:12px;background:#f6f6f6;border:1px solid #ddd;white-space:pre-wrap;">
amount={{ $amount }}
total_amount={{ $amount }}
transaction_uuid={{ $uuid }}
product_code={{ $config_val->merchantCode ?? '' }}
signature={{ $signature }}
success_url={{ route('esewa.verify', ['payment_id' => $uuid]) }}
failure_url={{ route('esewa.verify', ['payment_id' => $uuid]) }}
endpoint={{ $config_mode == 'test' ? 'https://rc-epay.esewa.com.np/api/epay/main/v2/form' : 'https://epay.esewa.com.np/api/epay/main/v2/form' }}
</pre>
<form action="{{ $config_mode == 'test' ? 'https://rc-epay.esewa.com.np/api/epay/main/v2/form' : 'https://epay.esewa.com.np/api/epay/main/v2/form' }}" method="POST"  name="redirect">
    <input type="hidden" id="amount" name="amount" value="{{ $amount }}" required>
    <input type="hidden" id="tax_amount" name="tax_amount" value ="0" required>
    <input type="hidden" id="total_amount" name="total_amount" value="{{ $amount }}" required>
    <input type="hidden" id="transaction_uuid" name="transaction_uuid" value="{{ $uuid }}">
    <input type="hidden" id="product_code" name="product_code" value ="{{ $config_val->merchantCode }}" required>
    <input type="hidden" id="product_service_charge" name="product_service_charge" value="0" required>
    <input type="hidden" id="product_delivery_charge" name="product_delivery_charge" value="0" required>
    <input type="hidden" id="success_url" name="success_url" value="{{ route('esewa.verify', ['payment_id' => $uuid]) }}" required>
    <input type="hidden" id="failure_url" name="failure_url" value="{{ route('esewa.verify', ['payment_id' => $uuid]) }}" required>
    <input type="hidden" id="signed_field_names" name="signed_field_names" value="total_amount,transaction_uuid,product_code" required>
    <input type="hidden" id="signature" name="signature" value="{{ $signature }}" required>
    <button class="btn btn-block click-if-alone" type="submit">
    </button>
</form>

<script>
    const form = document.forms['redirect'];
    const data = new FormData(form);
    const payload = {};
    for (const [k, v] of data.entries()) payload[k] = v;
    console.log('eSewa payload', payload);
    document.redirect.submit();
</script>
</body>

</html>
