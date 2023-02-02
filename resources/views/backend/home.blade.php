@extends("$layout.app")@section('title', __('Home'))

@push('scripts')
    <script src="{{ asset('backend/js/misc/home.js') }}"></script>
@endpush

@section('content')
    <div class="form-group row">
        @foreach ($dataBoxes as $dataBox)
            <div class="col-12 col-lg-6 col-xl-3">
                <iconbox title="{{ $dataBox['title'] }}" content="{{ $dataBox['content'] }}" icon="{{ $dataBox['icon'] }}" color="{{ $dataBox['color']  }}" route="{{ $dataBox['route']  }}"/>
            </div>
        @endforeach
    </div>
@endsection
