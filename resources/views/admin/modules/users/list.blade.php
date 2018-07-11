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
							<button type="button" class="btn btn-info">Active All</button>
							<button type="button" class="btn btn-info">Inactive All</button>
							<button type="button" class="btn btn-info">Delete All</button>
						</div>
					</div>
					<div class="box-body">
						<table id="user_table" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th><input type="checkbox" name="select_all" class="select_all" value=""/></th>
									<th>Name</th>
									<th>Username</th>
									<th>Email</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@if(isset($users) && !empty($users) && count($users)>0)
									@foreach($users as $user)
										<tr>
											<td><input type="checkbox" name="users" class="users" value="{{ $user['id'] }}"/></td>
											<td>{{ $user['first_name'].' '.$user['last_name'] }}</td>
											<td>{{ $user['username'] }}</td>
											<td>{{ $user['email'] }}</td>
											<td>{{ $user['status'] }}</td>
											<td><a href="{{ base_url('/admin/users/edit/'.$user['id']) }}"><i class="fa fa-fw fa-edit"></i></a>&nbsp;&nbsp;<a href="{{ base_url('/admin/users/delete/'.$user['id']) }}"><i class="fa fa-fw fa-remove"></i></a></td>
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
@endpush
@push('scripts')
	<script src="{{ js_url('/jquery.dataTables.min.js') }}"></script>
	<script src="{{ js_url('/dataTables.bootstrap.min.js') }}"></script>
	<script>
		$('#user_table').DataTable();
	</script>
@endpush