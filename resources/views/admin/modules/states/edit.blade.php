@extends('admin.layouts.master')
@section('content')
	<section class="content-header">
		@if(isset($id) && !empty($id))
			<h1>Edit State</h1>
		@else
			<h1>Add State</h1>
		@endif
	</section>
	<section class="content-header col-md-6">
		<div class="box box-info">
			<div class="box-header with-border">
				@if(isset($id) && !empty($id))
					<h3 class="box-title">Edit State</h3>
				@else
					<h3 class="box-title">Add State</h3>
				@endif
			</div>
			<form name="state_form" id="state_form" class="form-horizontal" method="POST" action="{{ action('AdminStatesController@savestate') }}">
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
									<option value="{{ $country['id'] }}" {{ (isset($state['country_id']) && $state['country_id'] == $country['id'])?'selected':'' }}>{{ $country['name'] }}</option>
								@endforeach
							</select>
							@if ($errors->has('country_id'))
								<span class="help-block">{{ $errors->first('country_id') }}</span>
							@endif
						</div>
					</div>
				</div>
				<div class="box-body">
					<div class="form-group @if($errors->has('name')){{'has-error'}}@endif">
						<label for="name" class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{ (isset($state['name']) && !empty($state['name']))?$state['name']:'' }}">
							@if ($errors->has('name'))
								<span class="help-block">{{ $errors->first('name') }}</span>
							@endif
						</div>
					</div>
				</div>
				<div class="box-footer">
					<a href="{{ base_url('/admin/states') }}" class="btn btn-default">Cancel</a>
					<button type="submit" class="btn btn-info pull-right">Submit</button>
				</div>
			</form>
		</div>
	</section>
@endsection

@push('scripts')
	<script src="{{ js_url('/jquery.validate.min.js') }}"></script>
	<script>
		$("#state_form").validate({
			errorClass: 'help-block',
			errorElement: 'span',
			rules: {
				country_id: { required: true },
				name: { required: true, minlength:2, maxlength:150 },
			},
			messages: {
				country_id: { required: "The countries field is required." },
				name: { required: "The name field is required." },
			},
			errorPlacement: function(error, element) {
				error.insertAfter($(element));
				$(element).parents('div').parents('div').addClass('has-error');
			},
			unhighlight: function(element, errorClass, validClass){
				$(element).parents('div').parents('div').removeClass('has-error');
			}
		});
	</script>
@endpush