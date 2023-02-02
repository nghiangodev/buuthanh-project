@php /** @var \App\Models\User $user */
$breadcrumbs = ['breadcrumb' => 'users.index'];
@endphp@extends("$layout.app")

@push('scripts')
	<script src="{{ version('backend/js/system/users/index.js') }}"></script>
@endpush

@section('title', $user->classLabel())

@section('content')
	<div class="kt-portlet kt-portlet--rounded kt-portlet--head-noborder">
		@include('backend.layouts.partials.index._index_header', $headerConfigs)
		<div class="kt-portlet__body">
			@include('backend.layouts.partials.index._search', ['form' => view('backend.modules.system.users._search', ['user' => $user])])
			<table class="table table-hover nowrap" id="table_users">
				<thead>
				<tr>
					<th>@lang('No.')</th>
					<th>{{ $user->label('username') }}</th>
					<th>{{ $user->label('full_name') }}</th>
					<th>{{ $user->label('phone') }}</th>
					<th>{{ $user->label('email') }}</th>
					<th>{{ $user->label('role') }}</th>
					<th>{{ $user->label('state') }}</th>
					<th>{{ $user->label('last_login_at') }}</th>
					<th style="width: 4%">@lang('Actions')</th>
				</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
	</div>
@endsection

