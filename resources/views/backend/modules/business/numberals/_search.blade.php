<form id="numberals_search_form" autocomplete="off">
    <div class="form-group row">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group">
            <label for="txt_name">{{ $numberal->label('name') }}</label>
            <input class="form-control" name="name" id="txt_name">
        </div>
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group">
            <label for="txt_address">{{ $numberal->label('address') }}</label>
            <input class="form-control" name="customer.address" id="txt_address">
        </div>
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group">
            <label for="txt_phone">{{ $numberal->label('phone') }}</label>
            <input class="form-control text-phone" name="customer.phone" id="txt_phone">
        </div>
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group {{ $errors->has('dob') ? 'has-danger' : ''}}">
            <label for="txt_dob">{{ $numberal->label('dob') }}</label>
            <input class="form-control text-datepicker-dob"  name="dob" type="text" id="txt_dob">
            <span class="form-text text-danger">{!! $errors->first('dob') !!}</span>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 mt-6">
            <button class="btn-main" id="btn_filter">
                <span><i class="far fa-search"></i><span>@lang('Search')</span></span>
            </button>
            <button type="button" class="btn-sub" id="btn_reset_filter">
                <span><i class="far fa-undo-alt"></i><span>@lang('Reset')</span></span>
            </button>
        </div>
    </div>
</form>
