@if ($currentUser)
    <div class="kt-header__topbar-item kt-header__topbar-item--user">
        <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
            <div class="kt-header__topbar-user d-flex">
                <span class="kt-header__topbar-welcome kt-visible-desktop">@lang('Hi'),</span>
                <span class="kt-header__topbar-username kt-visible-desktop">{{ $currentUser->username }}</span>
                {!! $currentUser->avatar_element !!}
            </div>
        </div>
        <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">
            <!--begin: Head -->
            <div class="kt-user-card kt-user-card--skin-light kt-notification-item-padding-x">
                <div class="kt-user-card__name">
                    {{ $currentUser->name ?: $currentUser->username }}
                </div>
            </div>
            <!--end: Head -->
            <!--begin: Navigation -->
            <div class="kt-notification">
                <a href="{{ route('users.profile', $currentUser) }}" class="kt-notification__item d-none">
                    <div class="kt-notification__item-icon">
                        <i class="fad fa-id-badge kt-font-info"></i>
                    </div>
                    <div class="kt-notification__item-details">
                        <div class="kt-notification__item-title kt-font-bold">
                            @lang('My profile')
                        </div>
                        <div class="kt-notification__item-time"></div>
                    </div>
                </a>
				<a href="javascript:void(0)" class="kt-notification__item" id="link_form_change_password" data-url="{{ route('users.form_change_password', $currentUser) }}">
                    <div class="kt-notification__item-icon">
                        <i class="fad fa-user-edit kt-font-info"></i>
                    </div>
                    <div class="kt-notification__item-details">
                        <div class="kt-notification__item-title kt-font-bold">
                            @lang('Change password')
                        </div>
                        <div class="kt-notification__item-time"></div>
                    </div>
                </a>
                <div class="kt-notification__custom kt-space-between">
                    <button type="button" id="btn_logout" class="btn btn-label btn-label-brand btn-sm btn-bold">
                        <i class="far fa-sign-out"></i> @lang('Sign out')
                    </button>
                    <form action="{{ route('logout') }}" method="POST" style="display: none;" class="logout-form">@csrf</form>
                </div>
            </div>
            <!--end: Navigation -->
        </div>
    </div>
{{--    @if ($currentUser->isAdmin() || $managerImpersonate->isImpersonating())--}}
{{--        <div class="kt-header__topbar-item">--}}
{{--            <div class="kt-header__topbar-wrapper">--}}
{{--                <span class="kt-header__topbar-icon" id="kt_quick_panel_toggler_btn"><i class="fad fa-window-restore"></i></span>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endif--}}
@endif