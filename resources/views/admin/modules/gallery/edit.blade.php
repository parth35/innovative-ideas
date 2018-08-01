@extends('admin.layouts.master')
@section('content')
	<section class="content-header">
		@if(isset($id) && !empty($id))
			<h1>Edit Photos</h1>
		@else
			<h1>Add Photos</h1>
		@endif
	</section>
	<section class="content-header col-md-6">
		<div class="box box-info">
			<div class="box-header with-border">
				@if(isset($id) && !empty($id))
					<h3 class="box-title">Edit Photos</h3>
				@else
					<h3 class="box-title">Add Photos</h3>
				@endif
			</div>
			<form name="user_form" id="user_form" class="form-horizontal" method="POST" action="{{ action('AdminUserController@saveuser') }}" enctype='multipart/form-data'>
				@csrf
				@if(isset($id) && !empty($id))
					<input type="hidden" id="id" name="id" value="{{ $id }}" />
				@endif
				<div class="box-body">
					<div class="form-group @if($errors->has('user_id')){{'has-error'}}@endif">
						<label for="user_id" class="col-sm-2 control-label">Users</label>
						<div class="col-sm-10">
							<select name="user_id" id="user_id" class="form-control">
								@foreach($users as $user)
									<option value="{{ $user['id'] }}">{{ $user['first_name'].' '.$user['last_name'] }}</option>
								@endforeach
							</select>
							@if ($errors->has('user_id'))
								<span class="help-block">{{ $errors->first('user_id') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group @if($errors->has('tags')){{'has-error'}}@endif">
						<label for="tags" class="col-sm-2 control-label">Tags</label>
						<div class="col-sm-10">
							<select name="tags" id="tags" class="form-control" multiple data-placeholder="Select a Tags">
								@foreach($tags as $tag)
									<option value="{{ $tag['id'] }}">{{ $tag['name'] }}</option>
								@endforeach
							</select>
							@if ($errors->has('tags'))
								<span class="help-block">{{ $errors->first('tags') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group @if($errors->has('photos')){{'has-error'}}@endif">
						<label for="photos" class="col-sm-2 control-label">Photos</label>
						<div class="col-sm-10">
							<input type="file" class="form-control" name="photos" id="photos" multiple>
							@if ($errors->has('photos'))
								<span class="help-block">{{ $errors->first('photos') }}</span>
							@endif
						</div>
					</div>
				</div>
				<div class="box-footer">
					<a href="{{ base_url('/admin/photos') }}" class="btn btn-default">Cancel</a>
					<button type="submit" class="btn btn-info pull-right">Submit</button>
				</div>
			</form>
		</div>
	</section>
@endsection
@push('styles')
	<link rel="stylesheet" href="{{ css_url('/select2.min.css') }}">
@endpush
@push('scripts')
	<script src="{{ js_url('/jquery.validate.min.js') }}"></script>
	<script src="{{ js_url('/select2.min.js') }}"></script>
	<script>
		$("#user_form").validate({
			errorClass: 'help-block',
			errorElement: 'span',
			rules: {
				first_name: { required: true, minlength:2, maxlength:100 },
				last_name: { required: true, minlength:2, maxlength:100 },
				username: { required: true, minlength:2, maxlength:100 },
				email: { required: true, maxlength:150, email: true },
				password: { required: true }
			},
			messages: {
				first_name: { required: "The first name field is required." },
				last_name: { required: "The last name field is required." },
				username: { required: "The username field is required." },
				email: { required: "The email field is required.", email: "Please enter a valid email." },
				password: { required: "The password field is required." },
			},
			errorPlacement: function(error, element) {
				error.insertAfter($(element));
				$(element).parents('div').parents('div').addClass('has-error');
			},
			unhighlight: function(element, errorClass, validClass){
				$(element).parents('div').parents('div').removeClass('has-error');
			}
		});

		$("#tags").select2({
			tags: true,
			createTag: function (params) {
				return {
				id: params.term,
				text: params.term,
				newOption: true
				}
			},
			templateResult: function (data) {
				var $result = $("<span></span>");

				$result.text(data.text);

				if (data.newOption) {
				$result.append(" <em>(new)</em>");
				}

				return $result;
			}
		});
	</script>
@endpush