@extends('admin.layouts.master')
@section('content')
	<section class="content-header">
		<h1>States</h1>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-info">
            		<div class="box-header">
						<a href="{{ base_url('/admin/states/add') }}" class="btn btn-success">Add State</a>
						&nbsp;&nbsp;
						<div class="btn-group">
							<a href="javascrip:void(0)" onclick="active_all('{{ base_url('/admin/states/active_all') }}')" id="active_all" class="btn btn-info">Active All</a>
							<a href="javascrip:void(0)" onclick="inactive_all('{{ base_url('/admin/states/inactive_all') }}')" id="inactive_all" class="btn btn-info">Inactive All</a>
							<a href="javascrip:void(0)" onclick="delete_all('{{ base_url('/admin/states/delete_all') }}')" id="delete_all" class="btn btn-info">Delete All</a>
						</div>
					</div>
					@if(isset($countries) && !empty($countries) && count($countries)>0)
						<div class="box-header">
							<div class="form-group col-xs-3">
								<label>Countries</label>
								<select name="countries_list" id="countries_list" class="form-control">
									@foreach($countries as $country)
										<option value="{{ $country['id'] }}">{{ $country['name'] }}</option>
									@endforeach
								</select>
							</div>
						</div>
					@endif
					<div class="box-body">
						<table id="state_table" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th><input type="checkbox" name="select_all" id="select_all" value=""/></th>
									<th>Name</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								
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
		$('#state_table').DataTable({
			"columnDefs": [
				{ "targets": 0, "orderable": false },
				{ "targets": 2, "orderable": false },
				{ "targets": 3, "orderable": false }
			],
			"order": [[ 1, "asc" ]]
		});
		/* End: Datatable initialization */

		/* Start: Fancybox initialization for image viewer */
		$("a.fancy_image").fancybox();
		/* End: Fancybox initialization for image viewer */

		function state_data()
		{
			$.ajax({
				type: 'POST',
				url: "{{ base_url('/admin/states/get_data') }}",
				data: { _token: "{{ csrf_token() }}", country_id: $('#countries_list').val() },
				success: function(data)
				{
					if(data != '[]')
					{
						$('#state_table').dataTable().fnClearTable();
						$('#state_table').dataTable().fnAddData(JSON.parse(data));
					}
					else{
						$('#state_table').dataTable().fnClearTable();
					}
				},
				error: function( jqXhr, textStatus, errorThrown )
				{
					console.log(errorThrown);
				}
			});
		}

		$('#countries_list').change(function(){
			state_data();
		})

		$(document).ready(function(){
			state_data();
		})
		
	</script>
@endpush