<form id="roles_search_form" autocomplete="off">
    <div class="form-group row">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group">
            <label for="txt_role">{{ $role->label('role') }}</label>
            <input class="form-control" name="name" id="txt_role">
        </div>
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 form-group mt-6">
            <button class="btn-main" id="btn_filter"><span> <i class="far fa-search"></i> <span>@lang('Search')</span> </span></button>
            <button type="button" class="btn-sub " id="btn_reset_filter"><span> <i class="far fa-undo-alt"></i> <span>@lang('Reset')</span> </span></button>
        </div>
    </div>
</form>