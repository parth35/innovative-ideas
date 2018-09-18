@extends('master')
@section('content')
	<div class="container-fluid" style="background:  linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ (isset($section_back_image['photos']))?gallery_photo_url($section_back_image['photos']):'' }}') no-repeat center; background-size: cover;">
		<div class="login-page" style="">
			<div class="wrap-login">
				<form action="" method="" class="login-form">
					@csrf
					<span class="login-form-title">Welcome</span>

					<div class="m-t-85 m-b-35">
					</div>

					<div class="box">
						<div class="box-body">
							<a href="{{ base_url('login/facebook') }}" class="btn btn-block btn-social btn-facebook">
								<i class="fa fa-facebook"></i> Sign in with Facebook
							</a>
						</div>
					</div>
					<div class="box">
						<div class="box-body">
							<a href="{{ base_url('login/google') }}" class="btn btn-block btn-social btn-facebook">
								<i class="fa fa-facebook"></i> Sign in with Google
							</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection