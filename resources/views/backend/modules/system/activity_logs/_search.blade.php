<form id="logs_search_form" autocomplete="off">
	<div class="form-group row">
		<div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group">
			<label for="txt_description">@lang('Description')</label>
			<input class="form-control" name="description" id="txt_description">
		</div>
		<div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group">
			<label for="txt_from_date">{{ __('From date') }}</label>
			<input class="form-control text-datepicker" name="from_date" id="txt_from_date" value="{{ date('d-m-Y', strtotime('-1 days')) }}" autocomplete="off">
		</div>
		<div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group">
			<label for="txt_to_date">{{ __('To date') }}</label>
			<input class="form-control text-datepicker" name="to_date" id="txt_to_date" value="{{ date('d-m-Y') }}" data-date-start-date="{{ date('d-m-Y', strtotime('-1 days')) }}"
				   autocomplete="off">
		</div>
		<div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group">
			<label for="select_log_name">@lang('Log type')</label>
			<select name="log_name" id="select_log_name" class="select2 form-control">
				<option value=""></option>
				@foreach ($logNames as $logName)
					<option value="{{ $logName['log_name'] }}">{{ __($logName['log_name']) }}</option>
				@endforeach
			</select>
		</div>
		<div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group">
			<label for="select_caused_by">@lang('Caused by')</label>
			<select name="causer_id" id="select_caused_by" class="form-control" data-url="{{ route('users.list') }}">
				<option value=""></option>
			</select>
		</div>
		<div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group mt-6">
			<button class="btn-main" id="btn_filter"><span> <i class="far fa-search"></i> <span>@lang('Search')</span> </span></button>
			<button type="button" class="btn-sub" id="btn_reset_filter"><span> <i class="far fa-undo-alt"></i> <span>@lang('Reset')</span> </span></button>
		</div>
	</div>
</form>