@extends('admin.layouts.master')
@section('content')
	<section class="content-header">
		<h1>Cities</h1>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-info">
            		<div class="box-header">
						<a href="{{ base_url('/admin/cities/add') }}" class="btn btn-success">Add City</a>
						&nbsp;&nbsp;
						<div class="btn-group">
							<a href="javascrip:void(0)" onclick="active_all('{{ base_url('/admin/cities/active_all') }}')" id="active_all" class="btn btn-info">Active All</a>
							<a href="javascrip:void(0)" onclick="inactive_all('{{ base_url('/admin/cities/inactive_all') }}')" id="inactive_all" class="btn btn-info">Inactive All</a>
							<a href="javascrip:void(0)" onclick="delete_all('{{ base_url('/admin/cities/delete_all') }}')" id="delete_all" class="btn btn-info">Delete All</a>
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
					<div class="box-header">
						<div class="form-group col-xs-3">
							<label>States</label>
							<select name="states_list" id="states_list" class="form-control">
								<option>Select State</option>
							</select>
						</div>
					</div>
					<div class="box-body">
						<table id="city_table" class="table table-bordered table-striped">
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
	<link rel="stylesheet" href="{{ css_url('/responsive.dataTables.min.css') }}">
@endpush
@push('scripts')
	<script src="{{ js_url('/jquery.dataTables.min.js') }}"></script>
	<script src="{{ js_url('/dataTables.bootstrap.min.js') }}"></script>
	<script src="{{ js_url('/dataTables.responsive.min.js') }}"></script>
	<script>
		/* Start: Datatable initialization */
		$('#city_table').DataTable({
			responsive: true,
			"columnDefs": [
				{ "targets": 0, "orderable": false },
				{ "targets": 2, "orderable": false },
				{ "targets": 3, "orderable": false }
			]
		});
		/* End: Datatable initialization */

		function state_data()
		{
			$.ajax({
				type: 'POST',
				url: "{{ base_url('/admin/cities/get_data') }}",
				data: { _token: "{{ csrf_token() }}", country_id: $('#countries_list').val() },
				success: function(data)
				{
					var states = JSON.parse(data);
					var option = '';
					$.each(states,function(index, state){
						option += "<option value='"+state.id+"'>"+state.name+"</option>";
					})
					$('#states_list').html(option);
					city_data();
				},
				error: function( jqXhr, textStatus, errorThrown )
				{
					console.log(errorThrown);
				}
			});
		}

		function city_data()
		{
			$.ajax({
				type: 'POST',
				url: "{{ base_url('/admin/cities/get_city_data') }}",
				data: { _token: "{{ csrf_token() }}", state_id: $('#states_list').val() },
				success: function(data)
				{
					if(data != '[]')
					{
						$('#city_table').dataTable().fnClearTable();
						$('#city_table').dataTable().fnAddData(JSON.parse(data));
					}
					else{
						$('#city_table').dataTable().fnClearTable();
					}
				},
				error: function( jqXhr, textStatus, errorThrown )
				{
					console.log(errorThrown);
				}
			});
		}

		$('#states_list').change(function(){
			city_data();
		})
		
		$('#countries_list').change(function(){
			state_data();
		})

		$(document).ready(function(){
			state_data();
		})
	</script>
@endpush