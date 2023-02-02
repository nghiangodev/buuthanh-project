<form id="users_search_form" autocomplete="off">
    <div class="form-group row">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group">
            <label for="txt_username">{{ $user->label('username') }}</label>
            <input class="form-control" name="username" id="txt_username">
        </div>
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group">
            <label for="txt_name">{{ $user->label('full_name') }}</label>
            <input class="form-control" name="name" id="txt_name">
        </div>
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group">
            <label for="select_role">{{ $user->label('Role') }}</label>
            <select name="role_id" id="select_role" class="form-control select2-ajax" data-url="{{ route('roles.list') }}" multiple></select>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group">
            <label for="select_state">{{ $user->label('state') }}</label>
            <select name="state" class="form-control select2" id="select_state">
                <option value=""></option>
                @foreach ($user->states as $key => $state)
                    <option value="{{ $key }}">{{ $state }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group">
            <button class="btn-main" id="btn_filter"><span> <i class="far fa-search"></i> <span>@lang('Search')</span> </span></button>
            <button type="button" class="btn-sub" id="btn_reset_filter"><span> <i class="far fa-undo-alt"></i> <span>@lang('Reset')</span> </span></button>
        </div>
    </div>
</form>