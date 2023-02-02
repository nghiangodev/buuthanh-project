@component('mail::message')

Xin chào {{ $name }},<br>

<p>Mã OTP của bạn là {{ $otp }}.</p>

Regards,<br>

{{ config('app.name') }}
@endcomponent