@php /** @var \App\Models\User $user */
$breadcrumbs = ['breadcrumb' => 'roles.show', 'model' => $role];
@endphp@extends("$layout.app")

@push('scripts')
	<style>
		td,
		th {
			vertical-align: top !important;
		}
	</style>
	<script src="{{ asset('backend/js/system/roles/form.js') }}"></script>
	<script src="{{ asset('backend/js/system/roles/permission.js') }}"></script>
@endpush

@section('title', __('action.View Model', ['model' => lcfirst(__('Role'))]))

@section('content')
	<div class="kt-content">
		<div class="kt-portlet kt-portlet--rounded kt-portlet--bordered-semi">
			<div class="kt-form">
				<div class="kt-portlet__body">
					<div class="form-group kt-form__group row">
						<div class="col-lg-4">
							<div class="form-group kt-form__group">
								<label for="txt_name">{{ __('Role') }}</label>
								<input class="form-control" name="name" type="text" id="txt_name" value="{{ $role->name }}" disabled>
							</div>
						</div>
					</div>
					<div class="form-group kt-form__group row">
						<div class="col-lg-12">
							@include('backend.modules.system.roles._permission_table', ['groups' => $groups, 'disabled' => true ])
						</div>
					</div>
				</div>
				<div class="kt-portlet__foot kt-portlet__foot--solid">
					<div class="kt-form__actions kt-form__actions--right">
						@if($role->can_be_edited)
							<a href="{{ route('roles.edit', $role) }}" class="btn-main btn-wide"><span><i class="far fa-edit"></i><span>@lang('Edit')</span></span></a>
						@endif
						<a href="{{ route('roles.index') }}" class="btn-sub btn-wide"><span><i class="far fa-arrow-left"></i><span>@lang('Back')</span></span></a>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
