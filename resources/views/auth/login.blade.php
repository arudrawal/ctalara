<!DOCTYPE html>

<html lang="en">

	<!--begin::Head-->
	<head>
		<base href="">
		<meta charset="utf-8" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>CTA Login</title>
		<meta name="description" content="Updates and statistics" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

		<!--end::Fonts-->

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
		<style>
		.vertical-center {
		  margin: 0;
		  padding: 50px;
		  position: absolute;
		  top: 50%;
		  -ms-transform: translateY(-50%);
		  transform: translateY(-50%);
		}
		</style>
	</head>

	<!--end::Head-->

    <!-- begin::Body -->
    <body  class="kt-login-v2--enabled kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-aside--enabled kt-aside--fixed kt-page--loading"  >

	<!-- begin:: Page -->
	<div class="kt-grid kt-grid--ver kt-grid--root">
		<!--begin::Item-->
		<div class="d-flex flex-row-fluid flex-center">
			<!--begin::Body-->
			<div class="vertical-center card" style="background:#EEFEFE">
				<!--begin::Wrapper-->
				<div class="kt-login-v2__wrapper">
					<div class="kt-login-v2__container">
						<div class="kt-login-v2__title">					
							<!--<img style='height: 90px;' src="{{ url('/')}}/assets/media/svg/logos/npm.svg" alt="CTA" /> -->
							<!--<br /><h4>Sign to Account</h4> -->
						</div>				 

						<!--begin::Form-->
						<form class="form" method="post" action="{{ route('login')}}" autocomplete="off">
							@csrf
							<div class="form-group">
								<label>User ID or E-mail:</label>
								<input class="form-control  @error('email') is-invalid @enderror" type="text" 
									placeholder="Email/Username" name="email" autocomplete="off">
								@error('email')
								<div class="invalid-feedback">{{ $message }}.</div>
								@enderror
							</div>
							<div class="form-group">
								<label>Password:</label>
								<input class="form-control @error('password') is-invalid @enderror" type="password" 
									placeholder="Password" name="password" autocomplete="off">
								@error('password')
								<div class="invalid-feedback">{{ $message }}.</div>
								@enderror
							</div>
							<!--begin::Action-->
							<div class="kt-login-v2__actions">
								<button type="submit" class="btn btn-primary">Sign In</button>
								&nbsp;&nbsp;
								<a href="{{route('password.request')}}" class="kt-link kt-link--brand">
									Forgot Password ?
								</a> 
							</div>
							<div class="kt-login-v2__signup">
								<span>Don't have an account?</span>
								<a href="{{ route('register')}}" class="kt-link kt-font-brand">Sign Up</a>
							</div> 
							<!--end::Action-->
						</form>
						<!--end::Form-->
					</div>
				</div>
				<!--end::Wrapper-->
			</div>
		</div>
		<!--end::Item-->
	<!-- end:: Page -->
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
		</script>

		<!--end::Global Config-->

		<!--begin::Global Theme Bundle(used by all pages)-->
		<script src="{{asset('plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{asset('plugins/custom/prismjs/prismjs.bundle.js')}}"></script>
		<script src="{{asset('js/scripts.bundle.js')}}"></script>

		<!--end::Global Theme Bundle-->
    </body>
    <!-- end::Body -->
</html>