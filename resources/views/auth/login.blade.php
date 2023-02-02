@extends('backend.layouts.login')

@section('content')
    <div class="kt-login__container">
        @if (isUseLogo())
            <div class="kt-login__logo">
{{--                <img src="{{ getLogo() }}" alt="Brand logo">--}}
					<h1 style="color: #000">PHƯỚC THẠNH</h1>
            </div>
        @endif
        <div class="kt-login__signin">
            <div class="kt-login__head">
                <h3 class="kt-login__title">ĐĂNG NHẬP HỆ THỐNG</h3>
            </div>
            <form class="kt-form" method="POST" action="{{ route('login') }}" id="form_login">
                @csrf
                <div class="form-group kt-form__group {{ $errors->has('username') ? 'has-danger' : ''}}">
                    <input id="username" type="text" class="form-control kt-input" name="username" value="{{ old('username') }}" placeholder="{{ __('Username or Email') }}" title="{{ __('Username or Email') }}" required autofocus autocomplete="off">
                    @if ($errors->has('username'))
                        <span class="form-text text-danger"><strong>{{ $errors->first('username') }}</strong></span>
                    @endif
                    @if ($errors->has('otp_error'))
                        <span class="form-text text-danger"><strong>{{ $errors->first('otp_error') }}</strong></span>
                    @endif
                </div>
                <div class="form-group kt-form__group {{ $errors->has('password') ? 'has-danger' : ''}}">
                    <password placeholder="{{ __('Password') }}"></password>
                    @if ($errors->has('password'))
                        <span class="form-text text-danger"><strong>{{ $errors->first('password') }}</strong></span>
                    @endif
                    @if ($errors->has('message'))
                        <span class="form-text text-danger"><strong>{{ $errors->first('message') }}</strong></span>
                    @endif
                </div>
                <div class="row kt-login__extra">
                    <div class="col">
                        <label class="kt-checkbox kt-checkbox--brand">
                            <input type="checkbox" class="kt-brand" name="remember" {{ old('remember') ? 'checked' : '' }}> @lang('Remember me')
                            <span></span>
                        </label>
                    </div>
                    <div class="col kt-align-right">
                        <a href="{{ route('password.request') }}" id="kt_login_forgot" class="kt-link kt-link--brand">
                            @lang('Forget password') ?
                        </a>
                    </div>
                </div>
                <div class="kt-login__actions">
                    <button id="kt_login_signin_submit" type="submit" class="btn btn-brand btn-elevate kt-login__btn-primary">
                        <i class="far fa-sign-in"></i> @lang('Sign in')
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
