@php /** @var \App\Models\Numberal $numberal */
$breadcrumbs = ['breadcrumb' => 'numberals.edit', 'model' => $numberal];
@endphp

@extends("$layout.app")

@push('scripts')
	<script src="{{ version('backend/js/business/numberals/form.js') }}"></script>
@endpush

@section('title', __('Edit') . " $numberal->model_title")

@section('content')
    <div class="kt-portlet kt-portlet--rounded kt-portlet--head--noborder">
        @include('backend.modules.business.numberals._form', ['caption' => __('action.Edit Model', ['model' => $numberal->classLabel(true)])])
    </div>
@endsection
