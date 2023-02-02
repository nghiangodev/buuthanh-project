@php /** @var \App\Models\Numberal $numberal */
$breadcrumbs = ['breadcrumb' => 'numberals.index'];
@endphp

@extends("$layout.app")

@push('scripts')
    <script src="{{ version('backend/js/business/numberals/index.js') }}"></script>
@endpush

@section('title', $numberal->classLabel())

@section('content')
    <div class="kt-portlet kt-portlet--rounded kt-portlet--head-noborder">
        @include('backend.layouts.partials.index._index_header', $headerConfigs)
        <div class="kt-portlet__body">
            @include('backend.layouts.partials.index._search', ['form' => view('backend.modules.business.numberals._search', ['numberal' => $numberal])])
            <table class="table table-hover nowrap" id="table_numberals">
                <thead>
                    <tr>
                        <th>@lang('No.')</th>
                        <th>{{ $numberal->label('name') }}</th>
                        <th>{{ $numberal->label('phone') }}</th>
                        <th>{{ $numberal->label('address') }}</th>
                        <th>{{ $numberal->label('birthday') }}</th>
                        <th>@lang('Actions')</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection
