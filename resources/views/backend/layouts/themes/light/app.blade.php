<!--suppress HtmlUnknownAttribute, JSUnresolvedLibraryURL --><!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ auth()->id() }}">
    <meta name="app-name" content="{{ config('app.name') }}">
    @if (config('app.env') === 'local')
        <meta name="socket-port" content="8080">
    @else
        <meta name="socket-port" content="">
    @endif
    <title>@yield('title', config('app.name'))</title>
    <!--begin::Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap&subset=vietnamese" rel="stylesheet">
    <!--end::Fonts -->
    <!-- Styles -->
    <link href="{{ asset('backend/themes/vendors/plugins.bundle.css') }}" rel="stylesheet">
    <link href="{{ asset("backend/themes/$theme/css/style.bundle.css") }}" rel="stylesheet">
    <link href="{{ version("backend/themes/$theme/css/app.css") }}" rel="stylesheet">
	<link rel="shortcut icon" href="{{ getFavIcon() }}">
    @stack('styles')
    @routes
</head>
<body class="kt-quick-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header--minimize-menu kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-aside--enabled kt-aside--left kt-aside--fixed">
<!-- begin:: Page -->
<!-- begin:: Header Mobile -->
<div id="kt_header_mobile" class="kt-header-mobile kt-header-mobile--fixed ">
    <div class="kt-header-mobile__toolbar">
        <button class="kt-header-mobile__toolbar-toggler kt-header-mobile__toolbar-toggler--left" id="kt_aside_mobile_toggler"><span></span></button>
        {{--        <button class="kt-header-mobile__toolbar-toggler" id="kt_header_mobile_toggler"><span></span></button>--}}
        <button class="kt-header-mobile__toolbar-topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="far fa-ellipsis-h"></i></button>
    </div>
    @if (isUseLogo())
        <div class="kt-header-mobile__logo">
            <a href="{{ route('home') }}">
                <img src="{{ getLogo() }}" alt="Logo">
            </a>
        </div>
    @endif
    <div class="kt-header-mobile__toolbar">
        @include('backend.layouts.partials.topbar_items._notification', ['customClass' => 'dropdown mx-3'])
        @include('backend.layouts.partials.topbar_items._user_info')
    </div>
</div>
<!-- end:: Header Mobile -->
<div class="kt-grid kt-grid--hor kt-grid--root" id="app">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
            <!-- begin:: Header -->
            <div id="kt_header" class="kt-header  kt-header--fixed " data-ktheader-minimize="on">
                <div class="kt-container kt-container--fluid px-4">
                    @if (isUseLogo())
                        <div class="kt-header__brand kt-grid__item flex-grow-0 mr-3" id="kt_header_brand">
                            <a class="kt-header__brand-logo" href="{{ route('home') }}">
                                <img src="{{ getLogo() }}" alt="Logo">
                            </a>
                        </div>
                    @endif
                    <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="far fa-times"></i></button>
                    <div class="kt-header-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_header_menu_wrapper">
                        <button class="kt-aside-toggler kt-aside-toggler--left" id="kt_aside_toggler"><span></span></button>
                        <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile ">
                            @include('backend.layouts.partials.menu._horizontal_menu')
                        </div>
                    </div>
                    @include('backend.layouts.partials._topbar')
                </div>
            </div>
            <!-- end:: Header -->
            <!-- begin:: Aside -->
            <button class="kt-aside-close " id="kt_aside_close_btn"><i class="far fa-times"></i></button>
            <div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">
                <!-- begin:: Aside Menu -->
            @include('backend.layouts.partials.menu._vertical_menu')
            <!-- end:: Aside Menu -->
            </div>
            <!-- end:: Aside -->
            <div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
                <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
                    <!-- begin:: Subheader -->
                    <div class="kt-subheader kt-grid__item" id="kt_subheader">
                        <div class="kt-container ">
                            <div class="kt-subheader__main">
                                @includeWhen($breadcrumbs, 'backend.layouts.partials._breadcrumb', $breadcrumbs)
                            </div>
                            <div class="kt-subheader__toolbar">
                                <div class="kt-subheader__wrapper"></div>
                            </div>
                        </div>
                    </div>
                    <!-- end:: Subheader -->
                    <!-- begin:: Content -->
                    <div class="kt-container kt-grid__item kt-grid__item--fluid">
						<flash message="{{ session('message') }}" type="{{ session('level', 'success') }}"></flash>
                        @yield('content')
                    </div>
                    <!-- end:: Content -->
                </div>
            </div>
            <!-- begin:: Footer -->
            <div class="kt-footer kt-grid__item bg-transparent" id="kt_footer">
                <div class="kt-container">
                    <div class="kt-footer__wrapper justify-content-center">
                        <div class="kt-footer__copyright">
                            <a class="text-decoration-none" target="_blank" href="{{ config('theme.company_link') }}">@config('theme.copyright')</a>. All Rights Reserved.
                        </div>
                    </div>
                </div>
            </div>
            <!-- end:: Footer -->
        </div>
    </div>
</div>
<!-- end:: Page -->
<!-- begin::Quick Panel -->
@include('backend.layouts.partials._quick_panel')
<!-- end::Quick Panel -->
<!-- begin::Scrolltop -->
<div id="kt_scrolltop" class="kt-scrolltop">
    <i class="far fa-arrow-up"></i>
</div>
<!-- end::Scrolltop -->
<div class="modal modal-wide fade modal-scroll" id="modal_xl" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content"></div>
    </div>
</div>
<div class="modal modal-wide fade modal-scroll" id="modal_lg" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content"></div>
    </div>
</div>
<div class="modal modal-wide fade modal-scroll" id="modal_md" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content"></div>
    </div>
</div>
<div class="modal modal-wide fade" id="modal_sm" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content"></div>
    </div>
</div>
{{--Scripts--}}

<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
	let KTAppOptions = {
		'colors': {
			'state': {'brand': '#591df1', 'light': '#ffffff', 'dark': '#282a3c', 'primary': '#5867dd', 'success': '#34bfa3', 'info': '#36a3f7', 'warning': '#ffb822', 'danger': '#fd3995'},
			'base': {'label': ['#c5cbe3', '#a1a8c3', '#3d4465', '#3e4466'], 'shape': ['#f0f3ff', '#d9dffa', '#afb4d4', '#646c9a']},
		},
	}
</script>
<!-- end::Global Config -->
<script src="{{ route('lang') }}"></script>
<script src="{{ asset('backend/themes/vendors/plugins.bundle.js') }}"></script>
<script src="{{ asset("backend/themes/$theme/js/scripts.bundle.js") }}"></script>
<script src="{{ asset('backend/js/bootstrap.js') }}"></script>
<script src="{{ asset('backend/js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
