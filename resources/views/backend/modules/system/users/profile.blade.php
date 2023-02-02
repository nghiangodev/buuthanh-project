@php /** @var \App\Models\User $user */
$breadcrumbs = ['breadcrumb' => 'users.edit', 'model' => $user, 'label' => __('Edit profile')];
@endphp@extends("$layout.app")

@push('scripts')
    <script src="{{ version('backend/js/system/users/form.js') }}"></script>
@endpush

@section('title', __('Edit profile'))

@section('content')
    <form id="profile_form" class="kt-form kt-form--label-align-right kt-form--state" method="post" action="{{ $action }}" data-confirm="true">
        @csrf
        @method('post')
        <div class="kt-content">
            <div class="row">
                <div class="kt-portlet">
                    <form class="kt-form kt-form--fit kt-form--label-align-right">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title text-capitalize">{{ $user->label('info') }}</h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="form-group row">
                                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group {{ $errors->has('name') ? 'has-danger' : ''}}">
                                    <label for="txt_name">{{ $user->label('name') }}</label>
                                    <input type="text" name="name" id="txt_name" class="form-control text-string" value="{{ $user->name ?? old('name') }}">
                                    <span class="form-text text-danger">{!! $errors->first('name') !!}</span>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group {{ $errors->has('email') ? 'has-danger' : ''}}">
                                    <label for="txt_email">{{ $user->label('email') }}</label>
                                    <input type="email" name="email" id="txt_email" class="form-control" value="{{ $user->email ?? old('email') }}">
                                    <span class="form-text text-danger">{!! $errors->first('email') !!}</span>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group {{ $errors->has('phone') ? 'has-danger' : ''}}">
                                    <label for="txt_phone">{{ $user->label('phone') }}</label>
                                    <input type="text" name="phone" id="txt_phone" class="form-control text-phone" value="{{ $user->phone ?? old('phone') }}" maxlength="11">
                                    <span class="form-text text-danger">{!! $errors->first('phone') !!}</span>
                                </div>
                            </div>
                            <div class="form-group row">
{{--                                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group {{ $errors->has('use_otp') ? 'has-danger' : ''}}">--}}
{{--                                    <label for="select_use_otp">{{ $user->label('use_otp') }}</label>--}}
{{--                                    <select name="use_otp" class="form-control select2" id="select_use_otp">--}}
{{--                                        <option></option>--}}
{{--                                        @foreach ($user->confirmations as $key => $confirmation)--}}
{{--                                            <option value="{{ $key }}" {{ $user->use_otp == $key ? ' selected' : '' }}>{{ $confirmation }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                    <span class="form-text text-danger">{!! $errors->first('use_otp') !!}</span>--}}
{{--                                </div>--}}
{{--                                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group {{ $errors->has('subscribe') ? 'has-danger' : ''}}">--}}
{{--                                    <label for="select_subscribe">{{ $user->label('subscribe') }}</label>--}}
{{--                                    <select name="subscribe" class="form-control select2" id="select_subscribe">--}}
{{--                                        <option></option>--}}
{{--                                        @foreach ($user->confirmations as $key => $confirmation)--}}
{{--                                            <option value="{{ $key }}" {{ $user->subscribe == $key ? ' selected' : '' }}>{{ $confirmation }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                    <span class="form-text text-danger">{!! $errors->first('subscribe') !!}</span>--}}
{{--                                </div>--}}
                                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group {{ $errors->has('password') ? 'has-danger' : ''}}">
                                    <label for="txt_password">{{ $user->label('Password') . (! $user->exists ? ' *' : '') }}</label>
                                    <password message="{{ __('validation.custom.password.regex') }}" placeholder="{{ __('Password') }}"></password>
                                    <span class="form-text text-danger">{!! $errors->first('password') !!}</span>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group {{ $errors->has('password_confirmation') ? 'has-danger' : ''}}">
                                    <label for="txt_password_confirmation">{{ $user->label('Confirm password') }}</label>
                                    <password id="txt_password_confirmation" name="password_confirmation" placeholder="{{ $user->label('Confirm password') }}"></password>
                                    <span class="form-text text-danger">{!! $errors->first('password_confirmation') !!}</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group {{ ! $user->exists || ! $user->is_use_otp ? 'd-none' : ''}}" id="otp_type_section">
                                    <label for="select_otp_type">{{ $user->label('otp_type') }}</label>
                                    <div class="kt-checkbox-inline">
                                        @foreach ($user->communications as $key => $communication)
                                            <label class="kt-checkbox kt-checkbox--brand kt-checkbox--bold">
                                                <input type="checkbox" name="otp_type[]" value="{{ $key }}" {{ in_array($key, $user->otp_types, false) ? 'checked' : '' }}> {{ $communication }}
                                                <span></span>
                                            </label>
                                        @endforeach
                                    </div>
                                    <span class="form-text text-danger">{!! $errors->first('otp_type') !!}</span>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group {{ ! $user->exists || ! $user->is_subscribe ? 'd-none' : ''}}" id="subscribe_type_section">
                                    <label for="select_subscribe_type">{{ $user->label('subscribe_type') }}</label>
                                    <div class="kt-checkbox-inline">
                                        @foreach ($user->communications as $key => $communication)
                                            <label class="kt-checkbox kt-checkbox--brand kt-checkbox--bold">
                                                <input type="checkbox" name="subscribe_type[]" value="{{ $key }}" {{ in_array($key, $user->subscribe_types, false) ? 'checked' : '' }}> {{ $communication }}
                                                <span></span>
                                            </label>
                                        @endforeach
                                    </div>
                                    <span class="form-text text-danger">{!! $errors->first('otp_type') !!}</span>
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__foot kt-portlet__foot--solid">
                            <div class="kt-form__actions kt-form__actions--right">
                                <button class="btn-main btn-wide"><span><i class="far fa-save"></i><span>@lang('Save')</span></span></button>
                                <a href="{{ route('users.index') }}" class="btn-sub btn-wide"><span><i class="far fa-arrow-left"></i><span>@lang('Back')</span></span></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </form>
@endsection