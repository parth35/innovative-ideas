<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{{ (isset($title))?$title:'Innovative Ideas' }}</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<link rel="stylesheet" href="{{ css_url('/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ base_url('/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ css_url('/style.css') }}">
	<link rel="stylesheet" href="{{ base_url('/iCheck/square/blue.css') }}">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>
<body class="hold-transition login-page">
	<div class="login-box">
		<div class="login-logo">
			<a href="../../index2.html"><b>Innovative</b>IDEAS</a>
		</div>
		<div class="login-box-body">
			<p class="login-box-msg">Sign in to start your session</p>

			<form name="login_form" id="login_form" method="POST" action="{{ action('AuthController@doLogin') }}">
				@csrf
				<div class="form-group has-feedback @if($errors->has('email')){{'has-error'}}@endif">
					<input name="email" id="email" type="email" class="form-control" placeholder="Email" />
					<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					@if ($errors->has('email'))
						<span class="help-block">{{ $errors->first('email') }}</span>
					@endif
				</div>
				<div class="form-group has-feedback @if($errors->has('password')){{'has-error'}}@endif">
					<input name="password" id="password" type="password" class="form-control" placeholder="Password" />
					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
					@if ($errors->has('password'))
						<span class="help-block">{{ $errors->first('password') }}</span>
					@endif
				</div>
				<div class="row">
					<div class="col-xs-8">
						<div class="checkbox icheck">
							<label>
								<input type="checkbox" name="remember_me" id="remember_me" value="1"/> Remember Me
							</label>
						</div>
					</div>
					<div class="col-xs-4">
						<button type="submit" class="btn btn-primary btn-block">Sign In</button>
					</div>
				</div>
			</form>

			{{-- <div class="social-auth-links text-center">
				<p>- OR -</p>
				<a href="#" class="btn btn-block btn-social btn-facebook">
					<i class="fa fa-facebook"></i> Sign in with Facebook
				</a>
				<a href="#" class="btn btn-block btn-social btn-google">
					<i class="fa fa-google-plus"></i> Sign in using Google+
				</a>
			</div> --}}

			<a href="#">I forgot my password</a><br>
			<a href="register.html" class="text-center">Register a new membership</a>

		</div>
	</div>

	<script src="{{ js_url('/jquery.min.js') }}"></script>
	<script src="{{ js_url('/bootstrap.min.js') }}"></script>
	<script src="{{ base_url('/iCheck/icheck.min.js') }}"></script>
	<script src="{{ js_url('/jquery-validate.min.js') }}"></script>
	<script>
		$(function () {
			$('input').iCheck({
				checkboxClass: 'icheckbox_square-blue',
				radioClass: 'iradio_square-blue',
				increaseArea: '20%' /* optional */
			});
		});

		$("#login_form").validate({
			errorClass: 'help-block',
			errorElement: 'span',
			rules: {
				email: { required: true, email: true },
				password: { required: true },
			},
			messages: {
				email: { required: "The email field is required.", email: "Please enter valid email address." },
				password: { required: "The password field is required." },
			},
			errorPlacement: function(error, element) {
				error.insertAfter($(element));
				$(element).parents('div').addClass('has-error');
			},
			unhighlight: function(element, errorClass, validClass){
				$(element).parents('div').removeClass('has-error');
			}
		});
	</script>
</body>
</html>