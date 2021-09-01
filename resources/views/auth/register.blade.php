<!DOCTYPE html>

<html lang="en">

	<!--begin::Head-->
	<head>
		<base href="">
		<meta charset="utf-8" />
		<title>CTA Register</title>
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
		<link rel="shortcut icon" href="{{asset('favicon.ico')}}" />
		<style>
		.vertical-center {
		  margin: 0;
		  padding: 50;
		  position: absolute;
		  top: 50%;
		  -ms-transform: translateY(-50%);
		  transform: translateY(-50%);
		}
		</style>
	</head>

	<!--end::Head-->

    <!-- begin::Body -->
<body id="kt_body" class="quick-panel-right demo-panel-right offcanvas-right header-fixed header-mobile-fixed subheader-enabled aside-enabled aside-fixed aside-minimize-hoverable page-loading">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Login-->
			<div class="login login-2 login-signin-on d-flex flex-column flex-column-fluid position-relative overflow-hidden" id="kt_login">
				<!--begin::Header-->
				<div class="login-header py-10 flex-column-auto">
					<div class="container d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-between">
						<!--begin::Logo-->
						<!-- <a href="#" class="flex-column-auto py-5 py-md-0">
							<img src="/keen/theme/demo1/dist/assets/media/logos/logo-6.svg" alt="logo" class="h-50px" />
						</a> -->
						<!--end::Logo-->
						<!--<span class="text-muted font-weight-bold font-size-h4">New Here? 
						<a href="javascript:;" id="kt_login_signup" class="text-primary font-weight-bolder">Create an Account</a></span>-->
					</div>
				</div>
				<!--end::Header-->			
				<!--begin::Body-->
				<div class="login-body d-flex flex-column-fluid align-items-stretch justify-content-center">
					<div class="container row">
						<div class="col-lg-6 d-flex align-items-center bg-white">
							<!--begin::Signup-->
							<div class="login-form login-signup">
								<!--begin::Form-->
								<form class="form w-xxl-550px rounded-lg p-20" novalidate="novalidate" 
									id="kt_login_signup_form" method="POST" action="{{route('register')}}">
									@csrf
									<!--begin::Title-->
									<div class="pb-13 pt-lg-0 pt-5">
										<h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Sign Up</h3>
										<p class="text-muted font-weight-bold font-size-h4">Enter your details to create your account</p>
									</div>
									<!--end::Title-->
									<!--begin::Form group-->
									<div class="form-group">
										<input class="form-control form-control-solid @error('name') is-invalid @enderror" 
										type="text" placeholder="Fullname" name="name" autocomplete="off"/>
										@error('name')
										<div class="invalid-feedback">{{ $message }}.</div>
										@enderror
									</div>
									<!--end::Form group-->
									<!--begin::Form group-->
									<div class="form-group">
										<input class="form-control form-control-solid @error('email') is-invalid @enderror" 
										type="email" placeholder="Email" name="email" autocomplete="off" />
										@error('email')
										<div class="invalid-feedback">{{ $message }}.</div>
										@enderror
									</div>
									<!--end::Form group-->
									<!--begin::Form group-->
									<div class="form-group">
										<input class="form-control form-control-solid @error('password') is-invalid @enderror" 
											type="password" placeholder="Password" name="password" autocomplete="off" />
										@error('password')
										<div class="invalid-feedback">{{ $message }}.</div>
										@enderror
									</div>
									<!--end::Form group-->
									<!--begin::Form group-->
									<div class="form-group">
										<input class="form-control form-control-solid @error('cpassword') is-invalid @enderror" 
											type="password" placeholder="Confirm password" name="password_confirmation" autocomplete="off" />
										@error('password_confirmation')
										<div class="invalid-feedback">{{ $message }}.</div>
										@enderror
									</div>
									<!--end::Form group-->
									<!--begin::Form group-->
									<div class="form-group">
										<div class="checkbox-inline">
											<label class="checkbox">
											<input type="checkbox" name="agree" />
											<span></span>I Agree the 
											<a href="#" class="ml-1">terms and conditions</a>.</label>
										</div>
									</div>
									<!--end::Form group-->
									<!--begin::Form group-->
									<div class="form-group d-flex flex-wrap pb-lg-0 pb-3">
										<button type="submit" id="kt_login_signup_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-4">Submit</button>
										<a href="{{route('login')}}" type="button" id="kt_login_signup_cancel" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3">Cancel</a>
									</div>
									<!--end::Form group-->
								</form>
								<!--end::Form-->
							</div>
							<!--end::Signup-->
						</div>
						<!--
						<div class="col-lg-6 bgi-size-contain bgi-no-repeat bgi-position-y-center bgi-position-x-center min-h-150px mt-10 m-md-0" 
							style="background-image: url(/keen/theme/demo1/dist/assets/media/svg/illustrations/accomplishment.svg)"></div>
						-->
					</div>
				</div>
				<!--end::Body-->
				<!--begin::Footer-->
				<div class="login-footer py-10 flex-column-auto">
					<div class="container d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-between">
						<!--<div class="font-size-h6 font-weight-bolder order-2 order-md-1 py-2 py-md-0">
							<span class="text-muted font-weight-bold mr-2">2021©</span>
							<a href="https://keenthemes.com/keen" target="_blank" class="text-dark-50 text-hover-primary">Keenthemes</a>
						</div>
						<div class="font-size-h5 font-weight-bolder order-1 order-md-2 py-2 py-md-0">
							<a href="#" class="text-primary">Terms</a>
							<a href="#" class="text-primary ml-10">Plans</a>
							<a href="#" class="text-primary ml-10">Contact Us</a>
						</div> -->
					</div>
				</div>
				<!--end::Footer-->
			</div>
			<!--end::Login-->
		</div>
	<!-- end:: Page -->
		<script>var HOST_URL = "/keen/theme/tools/preview";</script>
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