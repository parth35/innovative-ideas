@extends('admin.layouts.master')
@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Dashboard</h1>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-4">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">Latest Members</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse">
								<i class="fa fa-minus"></i>
							</button>
						</div>
					</div>
					<!-- /.box-header -->
					<div class="box-body no-padding">
						<ul class="users-list clearfix">
							@foreach($users as $user)
								<li>
									<img width="113" height="113" src="{{ user_profile_image_url($user['profile_image']) }}" alt="User Image">
									<a class="users-list-name" href="#">{{ $user['first_name'].' '.$user['last_name'] }}</a>
									<span class="users-list-date">{{ date('d M Y',strtotime($user['created_at'])) }}</span>
								</li>
							@endforeach
						</ul>
					</div>
					<div class="box-footer text-center">
						<a href="{{ base_url('admin/users/') }}" class="uppercase">View All Users</a>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection