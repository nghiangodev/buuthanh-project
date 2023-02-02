@php
$breadcrumbs = ['breadcrumb' => 'system_logs.index'];
@endphp

@extends("$layout.app")

@push('scripts')
    <script src="{{ asset('backend/js/system/system_logs/index.js') }}"></script>
@endpush

@section('title', __('System log'))

@section('content')
    <div class="kt-content">
        <div class="kt-portlet kt-portlet--rounded kt-portlet--bordered-semi">
            {{--@include('backend.layouts.partials.index_header', ['modelName' => __('Activity Log'), 'model' => 'log', 'createUrl' => ''])--}}
            <div class="kt-portlet__body">
                @include('backend.layouts.partials.index._search', ['form' => view('backend.modules.system.system_logs._search')])
                <table class="table table-hover" id="table_system_logs" style="width: 100%">
                    <thead>
                    <tr>
{{--                        <th>@lang('Environment')</th>--}}
                        <th>@lang('Level')</th>
                        <th>@lang('Date')</th>
                        <th>@lang('Content')</th>
                        <th>@lang('Actions')</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
