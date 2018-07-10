@extends('admin.layouts.master')
@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Users</h1>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
            		<div class="box-header">
						<a href="{{ base_url('/users/add') }}" class="btn btn-info">Add User</a>
						<div class="btn-group">
							<button type="button" class="btn btn-info">Active All</button>
							<button type="button" class="btn btn-info">Inactive All</button>
							<button type="button" class="btn btn-info">Delete All</button>
						</div>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<table id="user_table" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Rendering engine</th>
									<th>Browser</th>
									<th>Platform(s)</th>
									<th>Engine version</th>
									<th>CSS grade</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Trident</td>
									<td>Internet Explorer 4.0</td>
									<td>Win 95+</td>
									<td> 4</td>
									<td>X</td>
								</tr>
								<tr>
									<td>Trident</td>
									<td>Internet Explorer 5.0</td>
									<td>Win 95+</td>
									<td>5</td>
									<td>C</td>
								</tr>
							</tfoot>
						</table>
					</div>
		            <!-- /.box-body -->
				</div>
			</div>
		</div>
		<!-- /.row -->
	</section>
@endsection
@push('styles')
	<!-- DataTables -->
	<link rel="stylesheet" href="{{ css_url('/dataTables.bootstrap.min.css') }}">
@endpush
@push('scripts')
<!-- DataTables -->
	<script src="{{ js_url('/jquery.dataTables.min.js') }}"></script>
	<script src="{{ js_url('/dataTables.bootstrap.min.js') }}"></script>
	<script>
		$('#user_table').DataTable();
	</script>
@endpush