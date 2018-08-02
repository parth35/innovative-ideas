@extends('admin.layouts.master')
@section('content')
	<section class="content-header">
		<h1>Users</h1>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-info">
            		<div class="box-header">
						<a href="{{ base_url('/admin/users/add') }}" class="btn btn-success">Add User</a>
						&nbsp;&nbsp;
						<div class="btn-group">
							<a href="javascrip:void(0)" onclick="active_all('{{ base_url('/admin/users/active_all') }}')" id="active_all" class="btn btn-info">Active All</a>
							<a href="javascrip:void(0)" onclick="inactive_all('{{ base_url('/admin/users/inactive_all') }}')" id="inactive_all" class="btn btn-info">Inactive All</a>
							<a href="javascrip:void(0)" onclick="delete_all('{{ base_url('/admin/users/delete_all') }}')" id="delete_all" class="btn btn-info">Delete All</a>
						</div>
					</div>
					<div class="box-body">
						<table id="user_table" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th><input type="checkbox" name="select_all" id="select_all" value=""/></th>
									<th>Name</th>
									<th>Username</th>
									<th>Email</th>
									<th>Profile Image</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@if(isset($users) && !empty($users) && count($users)>0)
									@foreach($users as $user)
										<tr>
											<td>
												<input type="checkbox" name="users" class="data_checkbox" id="{{ $user['id'] }}"/>
											</td>
											<td>{{ $user['first_name'].' '.$user['last_name'] }}</td>
											<td>{{ $user['username'] }}</td>
											<td><a href="{{ 'mailto:'.$user['email'] }}">{{ $user['email'] }}</a></td>
											<td>
												<a class="fancy_image" href="{{ user_profile_image_url($user['profile_image']) }}" >
													<img width="60" height="60" src="{{ user_profile_image_url($user['profile_image']) }}" />
												</a>
											</td>
											<td>
												{!! change_status($user['status'],base_url('/admin/users/status/'.$user['id'])) !!}
											</td>
											<td><a title='Edit' href="{{ base_url('/admin/users/edit/'.$user['id']) }}"><i class="fa fa-fw fa-edit"></i></a>&nbsp;&nbsp;<a title='Delete' href="{{ base_url('/admin/users/delete/'.$user['id']) }}"><i class="fa fa-fw fa-remove"></i></a></td>
										</tr>
									@endforeach
								@endif
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection
@push('styles')
	<link rel="stylesheet" href="{{ css_url('/dataTables.bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ css_url('/jquery.fancybox.min.css') }}">
	<link rel="stylesheet" href="{{ css_url('/responsive.dataTables.min.css') }}">
@endpush
@push('scripts')
	<script src="{{ js_url('/jquery.fancybox.min.js') }}"></script>
	<script src="{{ js_url('/jquery.dataTables.min.js') }}"></script>
	<script src="{{ js_url('/dataTables.bootstrap.min.js') }}"></script>
	<script src="{{ js_url('/dataTables.responsive.min.js') }}"></script>
	<script>
		/* Start: Datatable initialization */
		$('#user_table').DataTable({
			responsive: true,
			"columnDefs": [
				{ "targets": 0, "orderable": false },
				{ "targets": 4, "orderable": false },
				{ "targets": 6, "orderable": false }
			]
		});
		/* End: Datatable initialization */

		/* Start: Fancybox initialization for image viewer */
		$("a.fancy_image").fancybox();
		/* End: Fancybox initialization for image viewer */
	</script>
@endpush