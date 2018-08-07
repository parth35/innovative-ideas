@extends('master')
@section('content')
	<div class="container-fluid" style="background:  linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ (isset($section_back_image['photos']))?gallery_photo_url($section_back_image['photos']):'' }}') no-repeat center; background-size: cover;">
		<div class="login-page" style="">
			<div class="wrap-login">
				<form action="" method="" class="login-form">
					@csrf
					<span class="login-form-title">Welcome</span>

					<div class="wrap-input m-t-85 m-b-35">
						<input type="text" name="email" id="email" class="input" >
						<span class="focus-input" data-placeholder="Email"></span>
					</div>

					<div class="wrap-input m-b-50">
						<input type="password" name="password" id="password" class="input">
						<span class="focus-input" data-placeholder="Password"></span>
					</div>

					<div class="container-login-form-btn">
						<button type="submit" class="login-form-btn">Login</button>
					</div>
				</form>
				<ul class="login-more p-t-150">
					<li class="m-b-8">
						<span class="txt1">Forgot</span>
						<a href="{{ base_url('/forgot_password') }}" class="txt2"><strong>Password?</strong></a>
					</li>
					<li>
						<span class="txt1">Don’t have an account?</span>
						<a href="{{ base_url('/sign_up') }}" class="txt2"><strong>Sign up</strong></a>
					</li>
				</ul>
			</div>
		</div>
	</div>
@endsection
@push('scripts')
<script>
	$('.input').each(function(){
		$(this).on('blur', function(){
			if($(this).val().trim() != "") {
				$(this).addClass('has-val');
			}
			else {
				$(this).removeClass('has-val');
			}
		})
	})
</script>
@endpush