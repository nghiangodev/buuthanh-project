<form id="users_form" class="kt-form kt-form--state" method="post" action="{{ $action }}">
    <div class="modal-header">
        <h5 class="modal-title">@lang('action.Edit Model', ['model' => lcfirst(__('User'))])</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        @csrf
        @method('put')
        <div class="kt-portlet__body">
            <flash></flash>
            <div class="form-group row">
                <div class="col-lg-6">
                    <div class="form-group kt-form__group {{ $errors->has('state') ? 'has-danger' : ''}}">
                        <label for="select_state">{{ __('State') }}</label>
                        <select name="state" class="form-control select2" id="select_state">
                            <option></option>
                            <option value="0">@lang('Inactive')</option>
                            <option value="1">@lang('Active')</option>
                        </select>
                        <span class="form-text"></span>
                        {!! $errors->first('state', '<div class="form-control-feedback">:message</div>') !!}
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group kt-form__group {{ $errors->has('role_id') ? 'has-danger' : ''}}">
                        <label for="select_role">@lang('Role'):</label>
                        <select name="role_id" id="select_role" class="form-control kt-select2" data-url="{{ route('roles.list') }}">
                            <option></option>
                        </select>
                        <span class="form-text"></span>
                        {!! $errors->first('role_id', '<div class="form-control-feedback">:message</div>') !!}
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    <div class="form-group kt-form__group {{ $errors->has('password') ? 'has-danger' : ''}}">
                        <label for="">@lang('Password'):</label>
                        <input type="password" id="txt_password" name="password" class="form-control kt-input">
                        {!! $errors->first('password', '<div class="form-control-feedback">:message</div>') !!}
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group kt-form__group {{ $errors->has('password_confirmation') ? 'has-danger' : ''}}">
                        <label for="">@lang('Confirm password'):</label>
                        <input type="password" name="password_confirmation" class="form-control kt-input">
                        {!! $errors->first('password_confirmation', '<div class="form-control-feedback">:message</div>') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-brand">@lang('Save')</button>
        <button type="button" class="btn btn-light" data-dismiss="modal">@lang('Close')</button>
    </div>
</form>
<script src="{{ version('backend/js/system/users/form.js') }}"></script>