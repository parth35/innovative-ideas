@extends('admin.layouts.master')
@section('content')
	<section class="content-header">
		@if(isset($id) && !empty($id))
			<h1>Edit User</h1>
		@else
			<h1>Add User</h1>
		@endif
	</section>
	<section class="content-header col-md-6">
		<div class="box box-info">
			<div class="box-header with-border">
				@if(isset($id) && !empty($id))
					<h3 class="box-title">Edit User</h3>
				@else
					<h3 class="box-title">Add User</h3>
				@endif
			</div>
			<form name="user_form" id="user_form" class="form-horizontal" method="POST" action="{{ action('AdminUserController@saveuser') }}" enctype='multipart/form-data'>
				@csrf
				@if(isset($id) && !empty($id))
					<input type="hidden" id="id" name="id" value="{{ $id }}" />
				@endif
				<div class="box-body">
					<div class="form-group @if($errors->has('first_name')){{'has-error'}}@endif">
						<label for="first_name" class="col-sm-2 control-label">First Name</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" value="{{ (isset($user['first_name']) && !empty($user['first_name']))?$user['first_name']:'' }}">
							@if ($errors->has('first_name'))
								<span class="help-block">{{ $errors->first('first_name') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group @if($errors->has('last_name')){{'has-error'}}@endif">
						<label for="last_name" class="col-sm-2 control-label">Last Name</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" value="{{ (isset($user['last_name']) && !empty($user['last_name']))?$user['last_name']:'' }}">
							@if ($errors->has('last_name'))
								<span class="help-block">{{ $errors->first('last_name') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group @if($errors->has('username')){{'has-error'}}@endif">
						<label for="username" class="col-sm-2 control-label">Username</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="username" id="username" placeholder="Username" value="{{ (isset($user['username']) && !empty($user['username']))?$user['username']:'' }}">
							@if ($errors->has('username'))
								<span class="help-block">{{ $errors->first('username') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group @if($errors->has('email')){{'has-error'}}@endif">
						<label for="email" class="col-sm-2 control-label">Email</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="email" id="email" placeholder="Email" value="{{ (isset($user['email']) && !empty($user['email']))?$user['email']:'' }}">
							@if ($errors->has('email'))
								<span class="help-block">{{ $errors->first('email') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group @if($errors->has('password')){{'has-error'}}@endif">
						<label for="password" class="col-sm-2 control-label">Password</label>
						<div class="col-sm-10">
							<input type="password" class="form-control" name="password" id="password" placeholder="Password" >
							@if ($errors->has('password'))
								<span class="help-block">{{ $errors->first('password') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group @if($errors->has('profile_image')){{'has-error'}}@endif">
						<label for="profile_image" class="col-sm-2 control-label">Profile image</label>
						<div class="col-sm-10">
							@if(isset($user['profile_image']) && !empty($user['profile_image']))
								<input type="hidden" name="profileimage" value="{{ $user['profile_image'] }}" /> 
							@endif
							<input type="file" class="form-control" name="profile_image" id="profile_image">
							@if ($errors->has('profile_image'))
								<span class="help-block">{{ $errors->first('profile_image') }}</span>
							@endif
						</div>
					</div>
				</div>
				<div class="box-footer">
					<a href="{{ base_url('/admin/users') }}" class="btn btn-default">Cancel</a>
					<button type="submit" class="btn btn-info pull-right">Submit</button>
				</div>
			</form>
		</div>
	</section>
@endsection

@push('scripts')
	<script src="{{ js_url('/jquery.validate.min.js') }}"></script>
	<script>
		$("#user_form").validate({
			errorClass: 'help-block',
			errorElement: 'span',
			rules: {
				first_name: { required: true, minlength:2, maxlength:100 },
				last_name: { required: true, minlength:2, maxlength:100 },
				username: { required: true, minlength:2, maxlength:100 },
				email: { required: true, maxlength:150, email: true },
				password: { required: true }
			},
			messages: {
				first_name: { required: "The first name field is required." },
				last_name: { required: "The last name field is required." },
				username: { required: "The username field is required." },
				email: { required: "The email field is required.", email: "Please enter a valid email." },
				password: { required: "The password field is required." },
			},
			errorPlacement: function(error, element) {
				error.insertAfter($(element));
				$(element).parents('div').parents('div').addClass('has-error');
			},
			unhighlight: function(element, errorClass, validClass){
				$(element).parents('div').parents('div').removeClass('has-error');
			}
		});
	</script>
@endpush