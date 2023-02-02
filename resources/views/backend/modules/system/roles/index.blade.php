@php /** @var \App\Models\Role $role */
$breadcrumbs = ['breadcrumb' => 'roles.index'];
@endphp@extends("$layout.app")

@push('scripts')
    <script src="{{ asset('backend/js/system/roles/index.js') }}"></script>
@endpush

@section('title', $role->classLabel())

@section('content')
    <div class="kt-content">
        <div class="kt-portlet kt-portlet--rounded kt-portlet--head-noborder">
            @include('backend.layouts.partials.index._index_header', $headerConfigs)
            <div class="kt-portlet__body">
                @include('backend.layouts.partials.index._search', ['form' => view('backend.modules.system.roles._search')->with('role', $role)])
                <table class="table table-hover nowrap" id="table_roles" style="width: 100%">
                    <thead>
                    <tr>
                        {{--<th width="5%"><label class="kt-checkbox kt-checkbox--all kt-checkbox--solid kt-checkbox--brand"><input type="checkbox"><span></span></label></th>--}}
                        <th>@lang('Role')</th>
                        <th>@lang('Actions')</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
