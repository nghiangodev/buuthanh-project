@php /** @var \App\Models\Role $role */
$breadcrumbs = ['breadcrumb' => 'roles.create', 'model' => $role];
@endphp@extends("$layout.app")

@push('styles')
    <style>
        td,
        th {
            vertical-align: top !important;
        }
    </style>
@endpush
@push('scripts')
    <script src="{{ asset('backend/js/system/roles/form.js') }}"></script>
    <script src="{{ asset('backend/js/system/roles/permission.js') }}"></script>
@endpush

@section('title', __('action.Add new Model', ['model' => $role->classLabel(true)]))

@section('content')
    <form id="role_form" class="kt-form kt-form--state" method="post" action="{{ route('roles.store') }}" data-confirm="true" data-ajax="true">
        <div class="kt-portlet kt-portlet--rounded">
            @csrf
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title text-capitalize">{{ $role->label('info') }}</h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="form-group row">
                    <div class="col-lg-3">
                        <div class="form-group kt-form__group {{ $errors->has('name') ? 'has-danger' : ''}}">
                            <label for="txt_name">{{ $role->label('role') }}</label>
                            <input class="form-control" name="name" type="text" id="txt_name" value="{{ $role->name or ''}}" required autocomplete="off">
                            <span class="form-text text-danger">{!! $errors->first('name') !!}</span>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        @include('backend.modules.system.roles._permission_table', ['groups' => $groups, 'isCreate' => true, 'disabled' => false ])
                    </div>
                </div>
            </div>
			<div class="kt-portlet__foot kt-portlet__foot--solid d-none d-sm-block">
				<div class="kt-form__actions kt-form__actions--right">
					<a href="{{ route('roles.index') }}" class="btn-sub btn-wide"><span><i class="far fa-arrow-left"></i><span>@lang('Back')</span></span></a>
					<button class="btn-main btn-wide"><span><i class="far fa-save"></i><span>@lang('Save')</span></span></button>
				</div>
			</div>
			<div class="kt-portlet__foot kt-portlet__foot--solid d-block d-sm-none">
				<div class="kt-form__actions d-inline-block">
					<a href="{{ route('roles.index') }}" class="btn-sub btn-wide"><span><i class="far fa-arrow-left"></i><span>@lang('Back')</span></span></a>
				</div>
				<div class="kt-form__actions d-inline-block float-right">
					<button class="btn-main btn-wide float-right"><span><i class="far fa-save"></i><span>@lang('Save')</span></span></button>
				</div>
			</div>
        </div>
    </form>
@endsection
