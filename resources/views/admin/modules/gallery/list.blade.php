@extends('admin.layouts.master')
@section('content')
	<section class="content-header">
		<h1>Photos</h1>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-info">
            		<div class="box-header">
						<a href="{{ base_url('/admin/photos/add') }}" class="btn btn-success">Add Photos</a>
						&nbsp;&nbsp;
						<div class="btn-group">
							<a href="javascrip:void(0)" onclick="active_all('{{ base_url('/admin/photos/active_all') }}')" id="active_all" class="btn btn-info">Approve All</a>
							<a href="javascrip:void(0)" onclick="inactive_all('{{ base_url('/admin/photos/inactive_all') }}')" id="inactive_all" class="btn btn-info">Disapprove All</a>
							<a href="javascrip:void(0)" onclick="delete_all('{{ base_url('/admin/photos/delete_all') }}')" id="delete_all" class="btn btn-info">Delete All</a>
						</div>
					</div>
					<div class="box-body">
						<table id="photo_table" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th><input type="checkbox" name="select_all" id="select_all" value=""/></th>
									<th>Name</th>
									<th>Place Name</th>
									<th>Address</th>
									<th>Photo</th>
									<th>Show In Slider</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@if(isset($photos) && !empty($photos) && count($photos)>0)
									@foreach($photos as $photo)
										<tr>
											<td>
												<input type="checkbox" name="photos" class="data_checkbox" id="{{ $photo['id'] }}"/>
											</td>
											<td>{{ \App\User::where('id',$photo['user_id'])->first()->name }}</td>
											<td>{{ $photo['place_name'] }}</td>
											<td>{{ $photo['address'] }}</td>
											<td>
												<a class="fancy_image" href="{{ gallery_photo_url($photo['photos']) }}" >
													<img width="60" height="60" src="{{ gallery_photo_url($photo['photos']) }}" />
												</a>
											</td>
											<td>
												@if($photo['show_in_slider'] == 'yes')
													<a class='edt-dlt' href='{{ base_url('/admin/photos/show_in_slider/'.$photo['id']) }}' style='color:green'><b>Yes</b></a>
												@else
													<a href='{{ base_url('/admin/photos/show_in_slider/'.$photo['id']) }}' style='color:red'><b>No</b></a>
												@endif
											</td>
											<td>
												{!! photo_approve($photo['approve'],base_url('/admin/photos/status/'.$photo['id'])) !!}
											</td>
											<td><a title='Edit' href="{{ base_url('/admin/photos/edit/'.$photo['id']) }}"><i class="fa fa-fw fa-edit"></i></a>&nbsp;&nbsp;<a title='Delete' href="{{ base_url('/admin/photos/delete/'.$photo['id']) }}"><i class="fa fa-fw fa-remove"></i></a></td>
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
		$('#photo_table').DataTable({
			responsive: true,
			"columnDefs": [
				{ "targets": 0, "orderable": false },
				{ "targets": 4, "orderable": false },
				{ "targets": 7, "orderable": false }
			]
		});
		/* End: Datatable initialization */

		/* Start: Fancybox initialization for image viewer */
		$("a.fancy_image").fancybox();
		/* End: Fancybox initialization for image viewer */
	</script>
@endpush