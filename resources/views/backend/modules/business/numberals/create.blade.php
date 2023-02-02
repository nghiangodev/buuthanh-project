@php /** @var \App\Models\Numberal $numberal */
$breadcrumbs = ['breadcrumb' => 'numberals.create', 'model' => $numberal];
@endphp

@extends("$layout.app")

@push('scripts')
	<script src="{{ version('backend/js/business/numberals/form.js') }}"></script>
@endpush

@section('title', __('action.Add new Model', ['model' => $numberal->classLabel(true)]))

@section('content')
    <div class="kt-portlet kt-portlet--rounded kt-portlet--head--noborder">
        @include('backend.modules.business.numberals._form', ['caption' => __('action.Create Model', ['model' => $numberal->label('info')])])
    </div>
@endsection
