<div class="kt-header__topbar-item kt-header__topbar-item--search dropdown kt-hide" id="kt_quick_search_toggle">
	<div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
		<span class="kt-header__topbar-icon"><i class="fad fa-lg fa-search"></i></span>
	</div>
	<div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-lg">
		<div class="kt-quick-search kt-quick-search--dropdown kt-quick-search--result-compact" id="kt_quick_search_dropdown">
			<form method="get" class="kt-quick-search__form">
				<div class="input-group">
					{{--                        <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-search"></i></span></div>--}}
					<input type="text" class="form-control kt-quick-search__input" placeholder="{{ __('Search') }}">
					<div class="input-group-append"><span class="input-group-text"><i class="far fa-times kt-quick-search__close"></i></span></div>
				</div>
			</form>
			<div class="kt-quick-search__wrapper kt-scroll" data-scroll="true" data-height="325" data-mobile-height="200"></div>
		</div>
	</div>
</div>