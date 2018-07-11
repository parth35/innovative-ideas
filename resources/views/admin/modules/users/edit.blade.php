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
			<form name="user_form" id="user_form" class="form-horizontal" method="POST" action="{{ base_url('/admin/users/adduser') }}" enctype='multipart/form-data'>
				@csrf
				@if(isset($id) && !empty($id))
					<input type="hidden" id="id" name="id" value="{{ $id }}" />
				@endif
				<div class="box-body">
					<div class="form-group">
						<label for="first_name" class="col-sm-2 control-label">First Name</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" value="{{ (isset($user['first_name']) && !empty($user['first_name']))?$user['first_name']:'' }}">
							<span class="help-block"></span>
						</div>
					</div>
					<div class="form-group">
						<label for="last_name" class="col-sm-2 control-label">Last Name</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" value="{{ (isset($user['last_name']) && !empty($user['last_name']))?$user['last_name']:'' }}">
							<span class="help-block"></span>
						</div>
					</div>
					<div class="form-group">
						<label for="username" class="col-sm-2 control-label">Username</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="username" id="username" placeholder="Username" value="{{ (isset($user['username']) && !empty($user['username']))?$user['username']:'' }}">
							<span class="help-block"></span>
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="col-sm-2 control-label">Email</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="email" id="email" placeholder="Email" value="{{ (isset($user['email']) && !empty($user['email']))?$user['email']:'' }}">
							<span class="help-block"></span>
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-sm-2 control-label">Password</label>
						<div class="col-sm-10">
							<input type="password" class="form-control" name="password" id="password" placeholder="Password" >
							<span class="help-block"></span>
						</div>
					</div>
					<div class="form-group">
						<label for="profile_image" class="col-sm-2 control-label">Profile image</label>
						<div class="col-sm-10">
							@if(isset($user['profile_image']) && !empty($user['profile_image']))
								<input type="hidden" name="profileimage" value="{{ $user['profile_image'] }}" /> 
							@endif
							<input type="file" class="form-control" name="profile_image" id="profile_image">
							<span class="help-block" ></span>
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
	<script>
	</script>
@endpush