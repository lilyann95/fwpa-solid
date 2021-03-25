<!DOCTYPE html>
<html lang="en">
<head>
	<title>Friends With a Purpose</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/logo.jpg')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('fonts/Linearicons-Free-v1.0.0/icon-font.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('vendor/animate/animate.css')}}">	
	<link rel="stylesheet" type="text/css" href="{{asset('vendor/css-hamburgers/hamburgers.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('vendor/animsition/css/animsition.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('vendor/select2/select2.min.css')}}">	
	<link rel="stylesheet" type="text/css" href="{{asset('vendor/daterangepicker/daterangepicker.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/main.css')}}">
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-form-title" style="background-image: url(images/bg-01.jpg);">
					<span class="login100-form-title-1">
						Sign In
					</span>
				</div>

				<form class="login100-form validate-form" method="POST" action="{{ route('login') }}">
					@if ($status==="newMember")
						<div>
							<div class="alert alert-danger" style="font-size: 12px;" role="alert">
								Your Accout is<strong> not active</strong> now, please contact the chairman for activation
							</div>
							<a class="btn btn-sm btn-outline-primary" href="{{route('login')}}"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> back to login</a>
						</div>
					@endif
					@if ($status==="inactive")
						<div>
							<div class="alert alert-danger" style="font-size: 12px;" role="alert">
								If<strong> you didn't login</strong> successfully, your account is inactive. please contact the chairman for activation
							</div>
							<a class="btn btn-sm btn-outline-primary" href="{{route('login')}}"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> back to login</a>
						</div>
					@endif
					@if ($status === "login")
							@csrf
						<div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
							<span class="label-input100">Email</span>
							<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
							<span class="focus-input100">
								@error('email')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
							</span>
						</div>

						<div class="wrap-input100 validate-input m-b-18" data-validate = "Password is required">
							<span class="label-input100">Password</span>
							<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
							<span class="focus-input100">
								@error('password')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
							</span>
						</div>

						<div class="flex-sb-m w-full p-b-30">
							<div>
								<a href="{{ route('register') }}" class="txt1">
									Don't have account
								</a>
							</div>
							
							<!--<div>-->
							<!--	@if (Route::has('password.request'))-->
							<!--		<a href="{{ route('password.request') }}" class="txt1">-->
							<!--			{{ __('Forgot Your Password?') }}-->
							<!--		</a>-->
							<!--	@endif-->
							<!--</div>-->
						</div>

						<div class="container-login100-form-btn">
							<button class="login100-form-btn" type="submit">
								Login
							</button>
						</div>
					@endif
				</form>
			</div>
		</div>
	</div>
	
<!--===============================================================================================-->
	<script src="{{asset('vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('vendor/animsition/js/animsition.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('vendor/bootstrap/js/popper.js')}}"></script>
	<script src="{{asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('vendor/select2/select2.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('vendor/daterangepicker/moment.min.js')}}"></script>
	<script src="{{asset('vendor/daterangepicker/daterangepicker.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('vendor/countdowntime/countdowntime.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('js/main.js')}}"></script>

</body>
</html>