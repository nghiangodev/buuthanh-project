@extends('backend.layouts.login')@section('title', __('Register'))

@push('styles')
	<link rel="stylesheet" href="{{ asset('backend/css/register.css') }}">
@endpush

@push('scripts')
	<script src="{{ version('backend/js/register.js') }}"></script>
@endpush

@section('content')
    <div class="kt-login__container">
        @if (isUseLogo())
            <div class="kt-login__logo">
                <img src="{{ getLogo() }}" alt="Brand logo">
            </div>
        @endif
        <div class="kt-login__signin">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form class="kt-login__form kt-form" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group kt-form__group">
                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }} kt-input" name="name" placeholder="{{ __('Full name') }}" value="{{ old('name') }}" required autofocus>
                    @if ($errors->has('name'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group kt-form__group">
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} kt-input" name="email" placeholder="{{ __('Email') }}" value="{{ old('email') }}" required>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group kt-form__group">
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} kt-input" placeholder="{{ __('Password') }}" name="password" required>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group kt-form__group">
                    <input id="password-confirm" type="password" class="form-control kt-input" name="password_confirmation" placeholder="{{ __('Confirm password') }}" required>
                </div>
                <div class="kt-login__form-action text-center">
                    <button type="submit" class="btn btn-brand btn-elevate kt-login__btn-primary">
                        <i class="far fa-check"></i> @lang('Register')
                    </button>
                    <a href="{{ route('home') }}" class="btn btn-outline-brand kt-btn kt-login__btn">
                        <i class="far fa-arrow-left"></i> @lang('Back')
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
