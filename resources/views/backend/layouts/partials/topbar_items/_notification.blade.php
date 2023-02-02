<div class="kt-header__topbar-item dropdown {{ $customClass ?? '' }}" style="font-size: 16px">
    <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
        <span class="kt-header__topbar-icon span-bell-icon animated infinite slow">
            <i class="fad fa-md fa-bell"></i>
            <span class="kt-badge kt-badge--danger kt-badge--sm span-notification-indicator"
				  style="{{ empty($totalUnreadNotification) || $totalUnreadNotification === 0 ? 'display: none' : '' }}">
				{{ $totalUnreadNotification ?? 0 }}
			</span>
        </span>
    </div>
    <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">
        <form>
            <!--begin: Head -->
            <div class="kt-head kt-head--skin-light kt-head--fit-x kt-head--fit-b p-4" style="background-image: url({{ asset('assets/media/misc/bg-1.jpg') }})">
                <h3 class="kt-head__title pb-4 text-white">
                    User Notifications
                    <span class="font-weight-bold kt-badge kt-badge--inline kt-badge--rounded kt-badge--unified-success kt-badge--lg span-total-notification" style="display: none"></span>
                </h3>
            </div>
            <!--end: Head -->
            {{--            <div class="tab-content">--}}
            {{--                <div class="tab-pane active show" id="topbar_notifications_notifications" role="tabpanel">--}}
            <div class="kt-notification notification-section kt-margin-t-10 kt-margin-b-10 kt-scroll" data-scroll="true" data-height="300" data-mobile-height="200">
                @foreach ($notifications as $notification)
                    <div class="kt-notification__item {{ $notification->read() ? 'kt-notification__item--read' : '' }}" data-read-url="{{ route('notifications.mark_single_read', $notification) }}">
                        <div class="kt-notification__item-icon">
                            <i class="flaticon2-line-chart kt-font-success"></i>
                        </div>
                        <div class="kt-notification__item-details">
                            <div class="kt-notification__item-title">
                                {!! $notification->data['message'] !!}
                            </div>
                            <div class="kt-notification__item-time">
                                {{ $notification->created_at->fromNow() }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{--                </div>--}}
            {{--            </div>--}}
        </form>
    </div>
</div>
