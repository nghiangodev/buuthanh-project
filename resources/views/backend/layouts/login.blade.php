<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- Fonts -->
	<link rel="dns-prefetch" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap&subset=vietnamese" rel="stylesheet">
	<title>@yield('title', __('Sign in'))</title>
	<!-- Styles -->
	<link href="{{ asset('backend/themes/vendors/plugins.bundle.css') }}" rel="stylesheet">
	<link href="{{ asset("backend/themes/$theme/css/style.bundle.css") }}" rel="stylesheet">
	<link href="{{ asset('backend/css/login.css') }}" rel="stylesheet">
	<link rel="shortcut icon" href="{{ getFavIcon() }}">
</head>
<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">
<!-- begin:: Page -->
<div class="kt-grid kt-grid--hor kt-grid--root" id="app">
	<div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v3 kt-login--signin" id="kt_login">
		<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">
			<div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
				<!-- begin:: Content -->
				<div class="kt-container kt-grid__item kt-grid__item--fluid">
{{--					<flash message="{{ session('message') }}" type="{{ session('type', 'success') }}"></flash>--}}
					@yield('content')
				</div>
				<!-- end:: Content -->
			</div>
		</div>
		<!-- begin:: Footer -->
		<div class="kt-footer kt-grid__item bg-transparent" id="kt_footer">
			<div class="kt-container">
				<div class="kt-footer__wrapper justify-content-center">
					<div class="kt-footer__copyright text-white">
						<a class="text-decoration-none" target="_blank" href="{{ config('theme.company_link') }}">{{ config('theme.copyright') }}</a>. All Rights Reserved.
					</div>
				</div>
			</div>
		</div>
		<!-- end:: Footer -->
	</div>
</div>
<!-- end:: Page -->
<!-- Scripts -->
<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
	var KTAppOptions = {
		'colors': {
			'state': {
				'brand': '#5d78ff',
				'dark': '#282a3c',
				'light': '#ffffff',
				'primary': '#5867dd',
				'success': '#34bfa3',
				'info': '#36a3f7',
				'warning': '#ffb822',
				'danger': '#fd3995',
			},
			'base': {
				'label': ['#c5cbe3', '#a1a8c3', '#3d4465', '#3e4466'],
				'shape': ['#f0f3ff', '#d9dffa', '#afb4d4', '#646c9a'],
			},
		},
	}
</script>
<!-- end::Global Config -->
<script src="{{ route('lang') }}"></script>
<script src="{{ asset("backend/themes/vendors/plugins.bundle.js") }}"></script>
<script src="{{ asset("backend/themes/$theme/js/scripts.bundle.js") }}"></script>
<script src="{{ asset('backend/js/bootstrap_login.js') }}"></script>
<script src="{{ asset('backend/js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
