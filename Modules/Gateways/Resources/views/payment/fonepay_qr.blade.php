@extends('Gateways::payment.layouts.master')

@section('title', 'Fonepay QR')

@section('content')
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="mb-2">Redirecting to Fonepay QR...</h4>
                <p class="mb-4">Please wait while we take you to the payment page.</p>

                <form id="fonepay-qr-form" method="POST" action="{{ $paymentUrl }}">
                    <input type="hidden" name="PID" value="{{ $merchantCode }}">
                    <input type="hidden" name="MD" value="{{ $md }}">
                    <input type="hidden" name="PRN" value="{{ $prn }}">
                    <input type="hidden" name="AMT" value="{{ $amount }}">
                    <input type="hidden" name="CRN" value="{{ $currency }}">
                    <input type="hidden" name="DT" value="{{ $dt }}">
                    <input type="hidden" name="R1" value="{{ $r1 }}">
                    <input type="hidden" name="R2" value="{{ $r2 }}">
                    <input type="hidden" name="RU" value="{{ $returnUrl }}">
                    <input type="hidden" name="DV" value="{{ $dv }}">
                    <noscript>
                        <button type="submit" class="btn btn-primary">Proceed to Fonepay QR</button>
                    </noscript>
                </form>
            </div>
        </div>
    </div>

    <script>
        window.onload = function () {
            var form = document.getElementById('fonepay-qr-form');
            if (form) {
                form.submit();
            }
        };
    </script>
@endsection
