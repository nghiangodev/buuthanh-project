<div class="kt-portlet__head index-header">
	<div class="kt-portlet__head-label">
		@if(! empty($caption))
			<h3 class="kt-portlet__head-title text-capitalize">{{ $caption }}</h3>
		@else
{{--			<h3 class="kt-portlet__head-title text-capitalize">{{ __('List of') . ' ' . $model->classLabel() }}</h3>--}}
			<h3 class="kt-portlet__head-title text-capitalize">{{ __('List') }}</h3>
		@endif
	</div>
	<div class="kt-portlet__head-toolbar">
		<div class="kt-portlet__head-group">
			<a href="{{ route('home') }}" class="btn-sub d-none d-sm-inline-block">
				<i class="far fa-arrow-left"></i>
				@lang('Back')
			</a>
			{{--Button on mobile--}}
			<a href="{{ route('home') }}" class="btn btn-outline-brand btn-icon d-sm-none">
				<i class="far fa-arrow-left"></i>
			</a>
			@if(! empty($buttons))
				@foreach ($buttons as $button)
					@if (! empty($button['canDo']))
						@if (! empty($button['isLink']))
							<a href="{{ $button['route'] }}"
							   class="btn-main {{ $button['btnClass'] }} d-none d-sm-inline-block" {{ ! empty($button['isDownload']) ? 'download' : '' }}>
								<span>
									<i class="{{ $button['icon'] }}"></i>
									<span>{{ $button['text'] }}</span>
								</span>
							</a>
						@else
							<button type="button" data-url="{{ $button['route'] }}" class="btn-main {{ $button['btnClass'] }} d-none d-sm-inline-block">
								<span>
									<i class="{{ $button['icon'] }}"></i>
									<span>{{ $button['text'] }}</span>
								</span>
							</button>
						@endif
					@endif
				@endforeach
				<a href="#" class="btn btn-outline-brand btn-icon btn-icon-md d-sm-none" data-toggle="dropdown" aria-expanded="true">
					<i class="far fa-ellipsis-h"></i>
				</a>
				<div class="dropdown-menu dropdown-menu-right">
					@foreach ($buttons as $button)
						@if (! empty($button['canDo']))
							@if (! empty($button['isLink']))
								<a href="{{ $button['route'] }}" class="dropdown-item" {{ ! empty($button['isDownload']) ? 'download' : '' }}>
									<i class="{{ $button['icon'] }}"></i>
									<span>{{ $button['text'] }}</span>
								</a>
							@else
								<a href="javascript:void(0)" data-url="{{ $button['route'] }}" class="dropdown-item">
									<i class="{{ $button['icon'] }}"></i>
									<span>{{ $button['text'] }}</span>
								</a>
							@endif
						@endif
					@endforeach
				</div>
			@endif
			@if($createUrl && $model->can_be_created)
				@if(isset($isModal))
					<button type="button" id="btn_create" data-url="{{ $createUrl }}" class="btn-main">
						<span>
							<i class="far fa-plus"></i>
							{{--                            <span class="d-none d-sm-block">{{ $createText ?? __('action.Add New Model', ['model' => $model->classLabel(true)]) }}</span>--}}
							<span class="d-none d-sm-block">{{ $createText ?? __('Add new') }}</span>
						</span>
					</button>
				@else
					<a href="{{ $createUrl }}" class="btn-main d-none d-sm-inline-block">
						<span>
							<i class="far fa-plus"></i>
							{{--                            <span>{{ $createText ?? __('action.Add New Model', ['model' => $model->classLabel(true)]) }}</span>--}}
							<span>{{ $createText ?? __('Add new') }}</span>
						</span>
					</a>
				@endif
				{{--Button on mobile--}}
				<a href="{{ $createUrl }}" class="btn btn-outline-brand btn-icon kt-font-brand d-sm-none">
					<i class="far fa-plus"></i>
				</a>
			@endif
		</div>
	</div>
</div>
