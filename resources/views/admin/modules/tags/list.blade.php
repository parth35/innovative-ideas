@extends('admin.layouts.master')
@section('content')
	<section class="content-header">
		<h1>Tags</h1>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-info">
            		<div class="box-header">
						<a href="{{ base_url('/admin/tags/add') }}" class="btn btn-success">Add Tag</a>
						&nbsp;&nbsp;
						<div class="btn-group">
							<a href="javascrip:void(0)" onclick="active_all('{{ base_url('/admin/tags/active_all') }}')" id="active_all" class="btn btn-info">Active All</a>
							<a href="javascrip:void(0)" onclick="inactive_all('{{ base_url('/admin/tags/inactive_all') }}')" id="inactive_all" class="btn btn-info">Inactive All</a>
							<a href="javascrip:void(0)" onclick="delete_all('{{ base_url('/admin/tags/delete_all') }}')" id="delete_all" class="btn btn-info">Delete All</a>
						</div>
					</div>
					<div class="box-body">
						<table id="tag_table" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th><input type="checkbox" name="select_all" id="select_all" value=""/></th>
									<th>Name</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@if(isset($tags) && !empty($tags) && count($tags)>0)
									@foreach($tags as $tag)
										<tr>
											<td>
												<input type="checkbox" name="tags" class="data_checkbox" id="{{ $tag['id'] }}"/>
											</td>
											<td>{{ $tag['name'] }}</td>
											<td>
												{!! change_status($tag['status'],base_url('/admin/tags/status/'.$tag['id'])) !!}
											</td>
											<td><a title='Edit' href="{{ base_url('/admin/tags/edit/'.$tag['id']) }}"><i class="fa fa-fw fa-edit"></i></a>&nbsp;&nbsp;<a title='Delete' href="{{ base_url('/admin/tags/delete/'.$tag['id']) }}"><i class="fa fa-fw fa-remove"></i></a></td>
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
	<link rel="stylesheet" href="{{ css_url('/responsive.dataTables.min.css') }}">
@endpush
@push('scripts')
	<script src="{{ js_url('/jquery.dataTables.min.js') }}"></script>
	<script src="{{ js_url('/dataTables.bootstrap.min.js') }}"></script>
	<script src="{{ js_url('/dataTables.responsive.min.js') }}"></script>
	<script>
		/* Start: Datatable initialization */
		$('#tag_table').DataTable({
			responsive: true,
			"columnDefs": [
				{ "targets": 0, "orderable": false },
				{ "targets": 2, "orderable": false },
				{ "targets": 3, "orderable": false }
			],
			"order": [[ 1, "asc" ]]
		});
		/* End: Datatable initialization */
	</script>
@endpush