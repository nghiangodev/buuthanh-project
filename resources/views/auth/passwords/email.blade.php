@extends('backend.layouts.login')@section('title', __('Forgot password'))

@section('content')
    <div class="kt-login__container">
        @if (isUseLogo())
            <div class="kt-login__logo">
                <img src="{{ getLogo() }}" alt="Brand logo">
            </div>
        @endif
        <div class="kt-login__signin">
            <div class="kt-login__head">
                <h3 class="kt-login__title">@yield('title')</h3>
                <div class="kt-login__desc">@lang('auth.Enter your email to reset your password')</div>
            </div>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form class="kt-login__form kt-form" method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group kt-form__group">
                    <input title="email" id="email" placeholder="Email" type="email"
                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} kt-input" name="email" value="{{ old('email') }}" required autocomplete="off">
                    @if ($errors->has('email'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="kt-login__actions">
                    <button id="kt_login_forgot_submit" class="btn-main btn-wide btn-elevate kt-login__btn-primary">
                        <i class="far fa-paper-plane"></i> @lang('Send')
                    </button>&nbsp;&nbsp;
                    <a href="{{ route('home') }}" id="kt_login_forgot_cancel" class="btn-sub btn-wide btn-elevate kt-login__btn-light" style="line-height: 2.5;">
                        <i class="far fa-arrow-left"></i> @lang('Back')
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
