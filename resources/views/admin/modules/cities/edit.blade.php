@extends('admin.layouts.master')
@section('content')
	<section class="content-header">
		@if(isset($id) && !empty($id))
			<h1>Edit City</h1>
		@else
			<h1>Add City</h1>
		@endif
	</section>
	<section class="content-header col-md-6">
		<div class="box box-info">
			<div class="box-header with-border">
				@if(isset($id) && !empty($id))
					<h3 class="box-title">Edit City</h3>
				@else
					<h3 class="box-title">Add City</h3>
				@endif
			</div>
			<form name="city_form" id="city_form" class="form-horizontal" method="POST" action="{{ action('AdminCitiesController@savecity') }}">
				@csrf
				@if(isset($id) && !empty($id))
					<input type="hidden" id="id" name="id" value="{{ $id }}" />
				@endif
				<div class="box-body">
					<div class="form-group @if($errors->has('country_id')){{'has-error'}}@endif">
						<label for="country_id" class="col-sm-2 control-label">Countries</label>
						<div class="col-sm-10">
							<select name="country_id" id="country_id" class="form-control">
								@foreach($countries as $country)
									<option value="{{ $country['id'] }}" {{ (isset($country_id) && $country_id == $country['id'])?'selected':'' }}>{{ $country['name'] }}</option>
								@endforeach
							</select>
							@if ($errors->has('country_id'))
								<span class="help-block">{{ $errors->first('country_id') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group @if($errors->has('state_id')){{'has-error'}}@endif">
						<label for="state_id" class="col-sm-2 control-label">States</label>
						<div class="col-sm-10">
							<select name="state_id" id="state_id" class="form-control">
								<option>Select State</option>
							</select>
							@if ($errors->has('state_id'))
								<span class="help-block">{{ $errors->first('state_id') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group @if($errors->has('name')){{'has-error'}}@endif">
						<label for="name" class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{ (isset($city['name']) && !empty($city['name']))?$city['name']:'' }}">
							@if ($errors->has('name'))
								<span class="help-block">{{ $errors->first('name') }}</span>
							@endif
						</div>
					</div>
				</div>
				<div class="box-footer">
					<a href="{{ base_url('/admin/cities') }}" class="btn btn-default">Cancel</a>
					<button type="submit" class="btn btn-info pull-right">Submit</button>
				</div>
			</form>
		</div>
	</section>
@endsection

@push('scripts')
	<script src="{{ js_url('/jquery.validate.min.js') }}"></script>
	<script>
		function state_data()
		{
			$.ajax({
				type: 'POST',
				url: "{{ base_url('/admin/cities/get_data') }}",
				data: { _token: "{{ csrf_token() }}", country_id: $('#country_id').val() },
				success: function(data)
				{
					var states = JSON.parse(data);
					var option = '';
					var city_id = "{{ (isset($city['state_id']))?$city['state_id']:0 }}";
					$.each(states,function(index, state){
						if(city_id == state.id){
							option += "<option value='"+state.id+"' selected>"+state.name+"</option>";
						}
						else{
							option += "<option value='"+state.id+"' >"+state.name+"</option>";
						}
					})
					$('#state_id').html(option);
				},
				error: function( jqXhr, textStatus, errorThrown )
				{
					console.log(errorThrown);
				}
			});
		}

		$('#country_id').change(function(){
			state_data();
		})

		$(document).ready(function(){
			state_data();
		})

		$("#city_form").validate({
			errorClass: 'help-block',
			errorElement: 'span',
			rules: {
				country_id: { required: true },
				state_id: { required: true },
				name: { required: true, minlength:2, maxlength:150 },
			},
			messages: {
				country_id: { required: "The countries field is required." },
				state_id: { required: "The states field is required." },
				name: { required: "The name field is required." },
			},
			errorPlacement: function(error, element) {
				error.insertAfter($(element));
				$(element).parents('div.form-group').addClass('has-error');
			},
			unhighlight: function(element, errorClass, validClass){
				$(element).parents('div.form-group').removeClass('has-error');
			}
		});
	</script>
@endpush