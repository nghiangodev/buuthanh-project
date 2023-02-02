<!--suppress ALL -->
<div class="kt-header__topbar kt-grid__item">
	@include('backend.layouts.partials.topbar_items._search')

	@include('backend.layouts.partials.topbar_items._notification')

	@include('backend.layouts.partials.topbar_items._quick_action')

	@include('backend.layouts.partials.topbar_items._language_bar')

	@if ($currentUser)
		@include('backend.layouts.partials.topbar_items._user_info')
	@endif
</div>