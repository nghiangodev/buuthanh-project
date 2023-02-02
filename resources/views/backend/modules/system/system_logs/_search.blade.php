<form id="system_logs_search_form">
    <div class="form-group row">
        <div class="col-lg-3 col-xs-6">
            <label for="select_level">@lang('Log')</label>
            <select name="level" class="select" id="select_level">
                <option value=""></option>
                @foreach (App\Entities\Core\SystemLog::getLevels() as $level)
                    <option value="{{ $level }}">{{ ucfirst($level) }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-lg-12">
            <button class="btn-main kt-btn kt-btn--icon" id="btn_filter"><span> <i class="far fa-search"></i> <span>@lang('Search')</span> </span></button>
            <button type="button" class="btn-sub btn-wide kt-btn kt-btn--icon" id="btn_reset_filter"><span> <i class="far fa-undo-alt"></i> <span>@lang('Reset')</span> </span></button>
        </div>
    </div>
</form>