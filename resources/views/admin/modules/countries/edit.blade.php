@extends('admin.layouts.master')
@section('content')
	<section class="content-header">
		@if(isset($id) && !empty($id))
			<h1>Edit Country</h1>
		@else
			<h1>Add Country</h1>
		@endif
	</section>
	<section class="content-header col-md-6">
		<div class="box box-info">
			<div class="box-header with-border">
				@if(isset($id) && !empty($id))
					<h3 class="box-title">Edit Country</h3>
				@else
					<h3 class="box-title">Add Country</h3>
				@endif
			</div>
			<form name="country_form" id="country_form" class="form-horizontal" method="POST" action="{{ action('AdminCountriesController@savecountry') }}">
				@csrf
				@if(isset($id) && !empty($id))
					<input type="hidden" id="id" name="id" value="{{ $id }}" />
				@endif
				<div class="box-body">
					<div class="form-group @if($errors->has('name')){{'has-error'}}@endif">
						<label for="name" class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{ (isset($country['name']) && !empty($country['name']))?$country['name']:'' }}">
							@if ($errors->has('name'))
								<span class="help-block">{{ $errors->first('name') }}</span>
							@endif
						</div>
					</div>
				</div>
				<div class="box-body">
					<div class="form-group @if($errors->has('sortname')){{'has-error'}}@endif">
						<label for="sortname" class="col-sm-2 control-label">Sortname</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="sortname" id="sortname" placeholder="Sortname" value="{{ (isset($country['sortname']) && !empty($country['sortname']))?$country['sortname']:'' }}">
							@if ($errors->has('sortname'))
								<span class="help-block">{{ $errors->first('sortname') }}</span>
							@endif
						</div>
					</div>
				</div>
				<div class="box-body">
					<div class="form-group @if($errors->has('phonecode')){{'has-error'}}@endif">
						<label for="phonecode" class="col-sm-2 control-label">Phonecode</label>
						<div class="col-sm-10">
							<input type="number" class="form-control" name="phonecode" id="phonecode" placeholder="Phonecode" value="{{ (isset($country['phonecode']) && !empty($country['phonecode']))?$country['phonecode']:'' }}">
							@if ($errors->has('phonecode'))
								<span class="help-block">{{ $errors->first('phonecode') }}</span>
							@endif
						</div>
					</div>
				</div>
				<div class="box-footer">
					<a href="{{ base_url('/admin/countries') }}" class="btn btn-default">Cancel</a>
					<button type="submit" class="btn btn-info pull-right">Submit</button>
				</div>
			</form>
		</div>
	</section>
@endsection

@push('scripts')
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
	<script>
		$("#country_form").validate({
			errorClass: 'help-block',
			errorElement: 'span',
			rules: {
				name: { required: true, minlength:2, maxlength:150 },
				sortname: { required: true, maxlength:50 },
				phonecode: { maxlength:50, number:true },
			},
			messages: {
				name: { required: "The name field is required." },
				sortname: { required: "The sortname field is required." },
				phonecode: { number: "Please enter valid number only." },
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