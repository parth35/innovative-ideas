@extends('admin.layouts.master')
@section('content')
	<section class="content-header">
		@if(isset($id) && !empty($id))
			<h1>Edit Tag</h1>
		@else
			<h1>Add Tag</h1>
		@endif
	</section>
	<section class="content-header col-md-6">
		<div class="box box-info">
			<div class="box-header with-border">
				@if(isset($id) && !empty($id))
					<h3 class="box-title">Edit Tag</h3>
				@else
					<h3 class="box-title">Add Tag</h3>
				@endif
			</div>
			<form name="tag_form" id="tag_form" class="form-horizontal" method="POST" action="{{ action('AdminTagsController@savetag') }}">
				@csrf
				@if(isset($id) && !empty($id))
					<input type="hidden" id="id" name="id" value="{{ $id }}" />
				@endif
				<div class="box-body">
					<div class="form-group @if($errors->has('name')){{'has-error'}}@endif">
						<label for="name" class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{ (isset($tag['name']) && !empty($tag['name']))?$tag['name']:'' }}">
							@if ($errors->has('name'))
								<span class="help-block">{{ $errors->first('name') }}</span>
							@endif
						</div>
					</div>
				</div>
				<div class="box-footer">
					<a href="{{ base_url('/admin/tags') }}" class="btn btn-default">Cancel</a>
					<button type="submit" class="btn btn-info pull-right">Submit</button>
				</div>
			</form>
		</div>
	</section>
@endsection

@push('scripts')
	<script src="{{ js_url('/jquery.validate.min.js') }}"></script>
	<script>
		$("#tag_form").validate({
			errorClass: 'help-block',
			errorElement: 'span',
			rules: {
				name: { required: true, minlength:2, maxlength:100 },
			},
			messages: {
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