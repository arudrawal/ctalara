<!DOCTYPE html>

<html lang="en">

	<!--begin::Head-->
	<head>
		<base href="">
		<meta charset="utf-8" />
		<title>Clinical Trial Pad</title>
		<meta name="description" content="Clinical Trial Pad" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

		<!--end::Fonts-->

		<!--begin::Page Vendors Styles(used by this page)-->
		<link href="{{asset('plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
		@yield('page_plugins_css')
		<!--begin::Page Vendors Styles(used by this page)-->

		<!--begin::Global Theme Styles(used by all pages)-->
		<link href="{{asset('/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{asset('/css/style.bundle.css')}} " rel="stylesheet" type="text/css" />

		<!--end::Global Theme Styles-->
		
		<!--begin::Layout Themes(used by all pages)-->
		<link href="{{asset('css/themes/layout/header/base/light.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('css/themes/layout/header/menu/light.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('css/themes/layout/brand/dark.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('css/themes/layout/aside/dark.css')}}" rel="stylesheet" type="text/css" />

		<!--end::Layout Themes-->
		<link rel="shortcut icon" href="{{asset('favicon.ico')}}" />
	</head>

	<!--end::Head-->

	<!--begin::Body-->
	<body id="kt_body" class="quick-panel-right demo-panel-right offcanvas-right header-fixed header-mobile-fixed subheader-enabled aside-enabled aside-fixed aside-minimize-hoverable page-loading">

		<!--[html-partial:include:{"file":"layout.html"}]/-->
		@include('layout')

		<!--[html-partial:include:{"file":"partials/_extras/offcanvas/quick-user.html"}]/-->
		@include('partials._extras.offcanvas.quick-user')

		<!--[html-partial:include:{"file":"partials/_extras/offcanvas/quick-panel.html"}]/-->
		@include('partials._extras.offcanvas.quick-panel')

		<!--[html-partial:include:{"file":"partials/_extras/chat.html"}]/-->
		@include('partials._extras.chat')

		<!--[html-partial:include:{"file":"partials/_extras/scrolltop.html"}]/-->
		@include('partials._extras.scrolltop')

		<!-- WE DON'T USE THESE -->
		<!--[html-partial:include:{"file":"partials/_extras/toolbar.html"}]/-->
		<!--[html-partial:include:{"file":"partials/_extras/offcanvas/demo-panel.html"}]/-->

		<script>
			var HOST_URL = "https://preview.keenthemes.com/keen/theme/tools/preview";
		</script>

		<!--begin::Global Config(global config for global JS scripts)-->
		<script>
			var KTAppSettings = {
				"breakpoints": {
					"sm": 576,
					"md": 768,
					"lg": 992,
					"xl": 1200,
					"xxl": 1400
				},
				"colors": {
					"theme": {
						"base": {
							"white": "#ffffff",
							"primary": "#3E97FF",
							"secondary": "#E5EAEE",
							"success": "#08D1AD",
							"info": "#844AFF",
							"warning": "#F5CE01",
							"danger": "#FF3D60",
							"light": "#E4E6EF",
							"dark": "#181C32"
						},
						"light": {
							"white": "#ffffff",
							"primary": "#DEEDFF",
							"secondary": "#EBEDF3",
							"success": "#D6FBF4",
							"info": "#6125E1",
							"warning": "#FFF4DE",
							"danger": "#FFE2E5",
							"light": "#F3F6F9",
							"dark": "#D6D6E0"
						},
						"inverse": {
							"white": "#ffffff",
							"primary": "#ffffff",
							"secondary": "#3F4254",
							"success": "#ffffff",
							"info": "#ffffff",
							"warning": "#ffffff",
							"danger": "#ffffff",
							"light": "#464E5F",
							"dark": "#ffffff"
						}
					},
					"gray": {
						"gray-100": "#F3F6F9",
						"gray-200": "#EBEDF3",
						"gray-300": "#E4E6EF",
						"gray-400": "#D1D3E0",
						"gray-500": "#B5B5C3",
						"gray-600": "#7E8299",
						"gray-700": "#5E6278",
						"gray-800": "#3F4254",
						"gray-900": "#181C32"
					}
				},
				"font-family": "Poppins"
			};
		function selectSponsor(sponsor_id) {
			var feForm = document.getElementById('sponsor_menu_form');
			alert('select called: ' + feForm);
			var feSponsor = document.getElementById('sponsor_id');
			if (feSponsor) {
				feSponsor.value = sponsor_id;
			}
			console.log('selecting sponsor: %d', sponsor_id);
			feForm.submit();
		}
		</script>

		<!--end::Global Config-->

		<!--begin::Global Theme Bundle(used by all pages)-->
		<script src="{{asset('plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{asset('plugins/custom/prismjs/prismjs.bundle.js')}}"></script>
		<script src="{{asset('js/scripts.bundle.js')}}"></script>

		<!--end::Global Theme Bundle-->

		<!--begin::Page Vendors(used by this page)-->
		<script src="{{asset('plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script>
		@yield('page_plugins_js')
		<!--end::Page Vendors-->

		<!--begin::Page Scripts(used by this page)-->
		<script src="{{asset ('js/pages/widgets.js')}}"></script>
		@yield('page_specific_js')
		<!--end::Page Scripts-->
	</body>

	<!--end::Body-->
</html>