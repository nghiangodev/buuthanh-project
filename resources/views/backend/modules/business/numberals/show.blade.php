@php /** @var \App\Models\Numberal $numberal */
$breadcrumbs = ['breadcrumb' => 'numberals.show', 'model' => $numberal];
@endphp

@extends("$layout.app")

@push('scripts')

@endpush

@section('title', __('action.View Model', ['model' => $numberal->classLabel(true)]))

@section('content')
    <div class="kt-content kt-form">
        <div class="kt-portlet kt-portlet--rounded">
            <div class="kt-portlet__body">
                <div class="form-group">
                    <table class="table table-bordered table-striped">
                        <tbody>
                        <tr>
                                                <th class="w-25"> {{ $numberal->label('name') }} </th>
                                                <td> {{ $numberal->name }} </td>
                                              </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="kt-portlet__foot kt-portlet__foot--solid">
                <div class="kt-form__actions kt-form__actions--right">
                    @if ($numberal->can_be_edited)
                        <a href="{{ route('numberals.edit', $numberal) }}" class="btn-main btn-wide"><span><i class="far fa-edit"></i><span>@lang('Edit')</span></span></a>
                    @endif
                    <a href="{{ route('numberals.index') }}" class="btn-sub btn-wide"><span><i class="far fa-arrow-left"></i><span>@lang('Back')</span></span></a>
                </div>
            </div>
        </div>
    </div>
@endsection
