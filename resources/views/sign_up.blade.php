@extends('master')
@section('content')
	<div class="container-fluid" style="background:  linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ (isset($section_back_image['photos']))?gallery_photo_url($section_back_image['photos']):'' }}') no-repeat center; background-size: cover;">
		<div class="login-page" style="">
			<div class="wrap-login">
				<form action="" method="" class="login-form">
					@csrf
					<span class="login-form-title">Sign up</span>

					<div class="wrap-input m-t-85 m-b-35">
						<input type="text" name="first_name" id="first_name" class="input" >
						<span class="focus-input" data-placeholder="First Name"></span>
					</div>

					<div class="wrap-input m-b-50">
						<input type="text" name="last_name" id="last_name" class="input" >
						<span class="focus-input" data-placeholder="Last Name"></span>
					</div>

					<div class="wrap-input m-b-50">
						<input type="text" name="username" id="username" class="input" >
						<span class="focus-input" data-placeholder="Username"></span>
					</div>
					
					<div class="wrap-input m-b-50">
						<input type="text" name="email" id="email" class="input" >
						<span class="focus-input" data-placeholder="Email"></span>
					</div>

					<div class="wrap-input m-b-50">
						<input type="password" name="password" id="password" class="input">
						<span class="focus-input" data-placeholder="Password"></span>
					</div>

					<div class="wrap-input m-b-50">
						<input type="file" name="profile_image" id="profile_image" class="input">
						<span class="focus-input" data-placeholder="Profile Image"></span>
					</div>

					<div class="container-login-form-btn">
						<button type="submit" class="login-form-btn">Submit</button>
					</div>
				</form>
				<ul class="login-more p-t-150">
					<li class="m-b-8">
						<span class="txt1">Back to </span>
						<a href="{{ base_url('/log_in') }}" class="txt2"><strong>Log in</strong></a>
					</li>
				</ul>
			</div>
		</div>
	</div>
@endsection