@php
	$breadcrumbs = ['breadcrumb' => 'activity_logs.index', 'label' => __('Activity log')];
@endphp@extends("$layout.app")

@push('scripts')
	<script src="{{ asset('backend/js/system/activity_logs/index.js') }}"></script>
@endpush

@section('title', __('Activity log'))

@section('content')
	<div class="kt-content">
		<div class="kt-portlet kt-portlet--rounded kt-portlet--bordered-semi">
			@include('backend.layouts.partials.index._index_header', $headerConfigs)
			<div class="kt-portlet__body">
				@include('backend.layouts.partials.index._search', ['form' => view('backend.modules.system.activity_logs._search', ['logNames' => $logNames])])
				<table class="table table-hover nowrap" id="table_logs" style="width:100%">
					<thead>
					<tr>
						<th>{{ $activityLog->label('Log type') }}</th>
						<th>{{ $activityLog->label('Caused by') }}</th>
						<th>{{ $activityLog->label('Description') }}</th>
						<th>{{ $activityLog->label('Date') }}</th>
						<th style="width: 5%">@lang('Actions')</th>
					</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
@endsection
