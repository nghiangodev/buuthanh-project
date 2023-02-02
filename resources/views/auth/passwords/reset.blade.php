@extends('backend.layouts.login')@section('title', __('Reset password'))

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
            </div>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form class="kt-login__form kt-form kt-form--state" method="POST" action="{{ route('password.request') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group kt-form__group row">
                    <input id="email" type="text" placeholder="{{ __('Username') }}" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }} kt-input" name="username" value="" required autofocus autocomplete="off">
                    @if ($errors->has('username'))
                        <span class="help-block">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group kt-form__group row">
                    <input id="password" placeholder="{{ __('Password') }}" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} kt-input" name="password" required>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group kt-form__group row">
                    <input id="password-confirm" placeholder="{{ __('Confirm password') }}" type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }} kt-input" name="password_confirmation" required>
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="kt-login__form-action">
                    <button type="submit" class="btn btn-brand kt-btn btn-wide btn-elevate kt-login__btn-primary">
                        <i class="far fa-save"></i><span> @lang('Reset password')
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
