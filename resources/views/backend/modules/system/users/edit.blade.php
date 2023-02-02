@php /** @var \App\Models\User $user */
$breadcrumbs = ['breadcrumb' => 'users.edit', 'model' => $user];
@endphp@extends("$layout.app")

@push('scripts')
    <script src="{{ version('backend/js/system/users/form.js') }}"></script>
    <script src="{{ version('backend/js/system/roles/permission.js') }}"></script>
@endpush

@section('title', __('action.Edit Model', ['model' => $user->classLabel(true)]))

@section('content')
    <div class="kt-portlet kt-portlet--rounded kt-portlet--head--noborder">
        @include('backend.modules.system.users._form')
    </div>
@endsection