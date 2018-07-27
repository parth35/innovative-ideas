@extends('admin.layouts.master')
@section('content')
	<section class="content-header">
		<h1>Countries</h1>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-info">
            		<div class="box-header">
						<a href="{{ base_url('/admin/countries/add') }}" class="btn btn-success">Add Country</a>
						&nbsp;&nbsp;
						<div class="btn-group">
							<a href="javascrip:void(0)" onclick="active_all('{{ base_url('/admin/countries/active_all') }}')" id="active_all" class="btn btn-info">Active All</a>
							<a href="javascrip:void(0)" onclick="inactive_all('{{ base_url('/admin/countries/inactive_all') }}')" id="inactive_all" class="btn btn-info">Inactive All</a>
							<a href="javascrip:void(0)" onclick="delete_all('{{ base_url('/admin/countries/delete_all') }}')" id="delete_all" class="btn btn-info">Delete All</a>
						</div>
					</div>
					<div class="box-body">
						<table id="country_table" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th><input type="checkbox" name="select_all" id="select_all" value=""/></th>
									<th>Name</th>
									<th>Sortname</th>
									<th>Phonecode</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@if(isset($countries) && !empty($countries) && count($countries)>0)
									@foreach($countries as $country)
										<tr>
											<td>
												<input type="checkbox" name="countries" class="data_checkbox" id="{{ $country['id'] }}"/>
											</td>
											<td>{{ $country['name'] }}</td>
											<td>{{ $country['sortname'] }}</td>
											<td>{{ ($country['phonecode'])?$country['phonecode']:'-' }}</td>
											<td>
												{!! change_status($country['status'],base_url('/admin/countries/status/'.$country['id'])) !!}
											</td>
											<td><a href="{{ base_url('/admin/countries/edit/'.$country['id']) }}"><i class="fa fa-fw fa-edit"></i></a>&nbsp;&nbsp;<a href="{{ base_url('/admin/countries/delete/'.$country['id']) }}"><i class="fa fa-fw fa-remove"></i></a></td>
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
@endpush
@push('scripts')
	<script src="{{ js_url('/jquery.fancybox.min.js') }}"></script>
	<script src="{{ js_url('/jquery.dataTables.min.js') }}"></script>
	<script src="{{ js_url('/dataTables.bootstrap.min.js') }}"></script>
	<script>
		/* Start: Datatable initialization */
		$('#country_table').DataTable({
			"columnDefs": [
				{ "targets": 0, "orderable": false },
				{ "targets": 4, "orderable": false },
				{ "targets": 5, "orderable": false }
			],
			"order": [[ 1, "asc" ]]
		});
		/* End: Datatable initialization */

		/* Start: Fancybox initialization for image viewer */
		$("a.fancy_image").fancybox();
		/* End: Fancybox initialization for image viewer */
	</script>
@endpush