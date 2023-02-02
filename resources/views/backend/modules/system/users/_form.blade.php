@php /** @var \App\Models\User $user */ @endphp
<form id="users_form" class="kt-form" method="post" action="{{ $action }}" data-confirm="false" data-ajax="true" autocomplete="off">
	@csrf
	@isset($method)
		@method('put')
	@endisset
	<input type="hidden" value="{{ $user->id }}" id="txt_user_id">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title text-capitalize">{{ $user->getFormTitle() }}</h3>
		</div>
	</div>
	<div class="kt-portlet__body">
		<x-accordion-section :icon="'fa fad-info'" :title="$user->label('info')" is-show="true">
			<div class="form-group row">
				<div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group {{ $errors->has('username') ? 'has-danger' : ''}}">
					<label for="txt_username">{{ $user->label('username') }} *</label>
					@if ($user->exists)
						<input type="text" id="txt_username" class="form-control bg-light" value="{{ $user->username }}" readonly>
					@else
						<input type="text" name="username" id="txt_username" class="form-control" value="{{ old('username') }}" required>
					@endif
					<span class="form-text text-danger">{!! $errors->first('username') !!}</span>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group {{ $errors->has('name') ? 'has-danger' : ''}}">
					<label for="txt_name">{{ $user->label('full_name') }}</label>
					<input type="text" name="name" id="txt_name" class="form-control text-string" value="{{ $user->name ?? old('name') }}">
					<span class="form-text text-danger">{!! $errors->first('name') !!}</span>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group {{ $errors->has('password') ? 'has-danger' : ''}}">
					<label for="txt_password">{{ $user->label('Password') . (! $user->exists ? ' *' : '') }}</label>
					<password message="{{ __('passwords.strength') }}" placeholder="{{__('Please input data')}}"></password>
					<span class="form-text text-danger">{!! $errors->first('password') !!}</span>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group {{ $errors->has('password_confirmation') ? 'has-danger' : ''}}">
					<label for="txt_password_confirmation">{{ $user->label('Confirm password') }}</label>
					<password id="txt_password_confirmation" name="password_confirmation" placeholder="{{ $user->label('Confirm password') }}"></password>
					<span class="form-text text-danger">{!! $errors->first('password_confirmation') !!}</span>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group {{ $errors->has('email') ? 'has-danger' : ''}}">
					<label for="txt_email">{{ $user->label('email') }}</label>
					<input type="email" name="email" id="txt_email" class="form-control" value="{{ $user->email ?? old('email') }}">
					<span class="form-text text-danger">{!! $errors->first('email') !!}</span>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group {{ $errors->has('phone') ? 'has-danger' : ''}}">
					<label for="txt_phone">{{ $user->label('phone') }}</label>
					<input type="text" name="phone" id="txt_phone" class="form-control text-mobile-phone" value="{{ $user->phone ?? old('phone') }}">
					<span class="form-text text-danger">{!! $errors->first('phone') !!}</span>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group {{ $errors->has('role_id') ? 'has-danger' : ''}}">
					<label for="select_role">{{ $user->label('Role') }}</label>
					<select name="role_id" id="select_role" class="form-control select2-ajax" data-url="{{ route('roles.list') }}">
						<option></option>
						@if (isset($roles) && $roles)
							<option value="{{ $roles[0]['id'] }}" selected>{{ $roles[0]['name'] }}</option>
						@endif
					</select>
					<span class="form-text text-danger">{!! $errors->first('role_id') !!}</span>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group {{ $errors->has('state') ? 'has-danger' : ''}}">
					<label for="select_state">{{ $user->label('State') }}</label>
					<select name="state" class="form-control select2" id="select_state">
						@foreach ($user->states as $key => $state)
							<option value="{{ $key }}" {{ $user->state == $key ? ' selected' : '' }}>{{ $state }}</option>
						@endforeach
					</select>
					<span class="form-text text-danger">{!! $errors->first('state') !!}</span>
				</div>
			</div>
			<div class="form-group row d-none">
				<div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group {{ $errors->has('use_otp') ? 'has-danger' : ''}}">
					<label for="select_use_otp">{{ $user->label('use_otp') }}</label>
					<select name="use_otp" class="form-control select" id="select_use_otp">
						<option></option>
						@foreach ($user->confirmations as $key => $confirmation)
							<option value="{{ $key }}" {{ $user->use_otp == $key ? ' selected' : '' }}>{{ $confirmation }}</option>
						@endforeach
					</select>
					<span class="form-text text-danger">{!! $errors->first('use_otp') !!}</span>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group {{ $errors->has('subscribe') ? 'has-danger' : ''}}">
					<label for="select_subscribe">{{ $user->label('subscribe') }}</label>
					<select name="subscribe" class="form-control select" id="select_subscribe">
						<option></option>
						@foreach ($user->confirmations as $key => $confirmation)
							<option value="{{ $key }}" {{ $user->subscribe == $key ? ' selected' : '' }}>{{ $confirmation }}</option>
						@endforeach
					</select>
					<span class="form-text text-danger">{!! $errors->first('subscribe') !!}</span>
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
								<input type="checkbox" name="subscribe_type[]"
									   value="{{ $key }}" {{ in_array($key, $user->subscribe_types, false) ? 'checked' : '' }}> {{ $communication }}
								<span></span>
							</label>
						@endforeach
					</div>
					<span class="form-text text-danger">{!! $errors->first('otp_type') !!}</span>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 m-form__group-sub {{ $errors->has('avatar') ? 'has-danger' : ''}}">
					<label for="txt_zalo_status">{{ $user->label('avatar') }}</label>
					<avatar file="{{ $user->avatar_link }}" browse-file-text="{{ $user->label('browse_file') }}"></avatar>
					<span class="form-text text-danger"></span>
				</div>
			</div>
		</x-accordion-section>

		<div class="form-group d-none">
			<x-accordion-section :icon="'fa fad-info'" :title="$user->label('direct_permission')" is-show="true">
				@include('backend.modules.system.roles._permission_table', ['groups' => $groups, 'isCreate' => ! $user->exists, 'disabled' => false ])
			</x-accordion-section>
		</div>
	</div>
	<div class="kt-portlet__foot kt-portlet__foot--solid">
		<div class="kt-form__actions kt-form__actions--right">
			@if ($user->canBeSaved())
				<button class="btn-main btn-wide"><span><i class="far fa-save"></i><span>@lang('Save')</span></span></button>
			@endif
			<a href="{{ route('users.index') }}" class="btn-sub btn-wide" id="link_back" data-should-confirm="{{ ! $user->exists }}">
				<span><i class="far fa-arrow-left"></i><span>@lang('Back')</span></span>
			</a>
		</div>
	</div>
</form>
