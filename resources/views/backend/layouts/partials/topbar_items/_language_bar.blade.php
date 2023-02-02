<div class="kt-header__topbar-item kt-header__topbar-item--langs mr-0">
	<div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
		<span class="kt-header__topbar-icon">
			<img class="" src="{{ asset('assets/media/flags/'.App::getLocale().'.svg') }}" alt=""/>
		</span>
	</div>
	<div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim">
		<ul class="kt-nav kt-margin-t-10 kt-margin-b-10">
			<li class="kt-nav__item {{ config('app.locale') === 'vi' ? 'kt-nav__item--active' : '' }}">
				<a href="{{ route('change_language', ['locale' => 'vi']) }}" class="kt-nav__link">
					<span class="kt-nav__link-icon"><img src="{{ asset('assets/media/flags/vi.svg') }}" alt=""/></span>
					<span class="kt-nav__link-text">Tiếng Việt</span>
				</a>
			</li>
			<li class="kt-nav__item {{ config('app.locale') === 'en' ? 'kt-nav__item--active' : '' }}">
				<a href="{{ route('change_language', ['locale' => 'en']) }}" class="kt-nav__link">
					<span class="kt-nav__link-icon"><img src="{{ asset('assets/media/flags/en.svg') }}" alt=""/></span>
					<span class="kt-nav__link-text">English</span>
				</a>
			</li>
		</ul>
	</div>
</div>
