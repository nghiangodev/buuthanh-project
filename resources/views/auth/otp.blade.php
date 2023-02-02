@extends('backend.layouts.login')@section('title', __('OTP'))

@push('scripts')
    <script src="{{ version('backend/js/misc/otp.js') }}"></script>
@endpush

@section('content')
    <div class="kt-login__container">
        @if (isUseLogo())
            <div class="kt-login__logo">
                <img src="{{ getLogo() }}" alt="Brand logo">
            </div>
        @endif
        <div class="kt-login__signin">
            <div class="kt-login__head">
                <h3 class="kt-login__title">@lang('Confirm OTP')</h3>
                <div class="kt-login__desc">{{ $responseText }}</div>
                <flash></flash>
            </div>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form class="kt-login__form kt-form" method="POST" action="{{ route('login_otp') }}">
                @csrf
                <div class="form-group kt-form__group">
                    <input placeholder="OTP" type="text" class="form-control{{ $errors->has('otp') ? ' is-invalid' : '' }} kt-input" name="otp" value="{{ old('otp') }}" required autocomplete="off">
                    <input type="hidden" name="password">
                    @if ($errors->has('otp'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('otp') }}</strong>
                        </span>
                    @endif
                    @if ($errors->has('phone'))
                        <span class="help-block">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="kt-login__form-action">
                    <button type="submit" class="btn-main btn-wide btn-brand kt-btn btn-wide btn-elevate kt-login__btn">
                        <i class="far fa-paper-plane"></i> @lang('Send')
                    </button>
                    <button type="button" id="btn_resend_otp" data-url="{{ route('resend_otp') }}" class="btn-sub btn-wide kt-btn btn-wide kt-login__btn">
                        <i class="far fa-redo"></i> @lang('Resend OTP')
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
