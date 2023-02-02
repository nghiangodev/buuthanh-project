<script src="{{ version('backend/js/system/users/change_password.js') }}"></script>
<form id="form_change_password" class="kt-login__form kt-form kt-form--state" method="POST" action="{{ route('users.change_password', $currentUser) }}" autocomplete="off">
	<div class="modal-header">
		<h5 class="modal-title">@lang('Reset password')</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body">
		<div class="kt-scrollable" data-scrollable="true" data-height="500" data-mobile-height="500">
			@csrf
			<div class="form-group kt-form__group">
				<label>{{ __('Current password') }}</label>
				<password name="current_password" id="txt_current_password" placeholder="{{ __('Current password') }}"></password>
			</div>
			<div class="form-group kt-form__group">
				<label>{{ __('Password') }}</label>
				<password placeholder="{{ __('Password') }}"></password>
			</div>
			<div class="form-group kt-form__group">
				<label>{{ __('Confirm password') }}</label>
				<password name="password_confirmation" id="txt_password_confirmation" placeholder="{{ __('Confirm password') }}"></password>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="submit" class="btn btn-brand btn-wide"><span><i class="far fa-save"></i><span>@lang('Reset password')</span></span></button>
		<button type="button" class="btn btn-outline-hover-brand btn-wide" data-dismiss="modal"><span><i class="far fa-ban"></i><span>@lang('Close')</span></span></button>
	</div>
</form>