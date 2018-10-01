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
			<form name="photos_form" id="photos_form" class="form-horizontal" method="POST" action="{{ action('AdminGalleryController@savephotos') }}" enctype='multipart/form-data'>
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
									<option value="{{ $user['id'] }}" {{ (isset($photo['user_id']) && $photo['user_id'] == $user['id'])?'selected':'' }}>{{ $user['name'] }}</option>
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
							<select name="tags[]" id="tags" class="form-control" multiple data-placeholder="Select a Tags">
								@foreach($tags as $tag)
									<option value="{{ $tag['name'] }}" {{ (isset($tags_link) && count($tags_link) > 0 && in_array($tag['id'],$tags_link))?'selected':'' }}>{{ $tag['name'] }}</option>
								@endforeach
							</select>
							@if ($errors->has('tags'))
								<span class="help-block">{{ $errors->first('tags') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group @if($errors->has('place_name')){{'has-error'}}@endif">
						<label for="place_name" class="col-sm-2 control-label">Place Name</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="place_name" id="place_name" placeholder="Place Name" value="{{ (isset($photo['place_name']) && !empty($photo['place_name']))?$photo['place_name']:'' }}">
							@if ($errors->has('place_name'))
								<span class="help-block">{{ $errors->first('place_name') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group @if($errors->has('address')){{'has-error'}}@endif">
						<label for="address" class="col-sm-2 control-label">Address</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="address" id="address" rows="3" placeholder="Address">{{ (isset($photo['address']) && !empty($photo['address']))?$photo['address']:'' }}</textarea>
							@if ($errors->has('address'))
								<span class="help-block">{{ $errors->first('address') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group @if($errors->has('note')){{'has-error'}}@endif">
						<label for="note" class="col-sm-2 control-label">Note</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="note" id="note" rows="3" placeholder="Note">{{ (isset($photo['note']) && !empty($photo['note']))?$photo['note']:'' }}</textarea>
							@if ($errors->has('note'))
								<span class="help-block">{{ $errors->first('note') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group @if($errors->has('photos')){{'has-error'}}@endif">
						<label for="photos" class="col-sm-2 control-label">Photos</label>
						<div class="col-sm-10">
							@if(isset($photo['photos']) && !empty($photo['photos']))
								<input type="hidden" name="edit_photo" id="edit_photo" value="{{ $photo['photos'] }}" />
								<input type="file" class="form-control" name="photos[]" id="photos">
							@else
								<input type="file" class="form-control" name="photos[]" id="photos" multiple>
							@endif
							@if ($errors->has('photos'))
								<span class="help-block">{{ $errors->first('photos') }}</span>
							@endif
						</div>
					</div>
					@if(isset($photo['photos']) && !empty($photo['photos']))
						<div class="col-sm-2"></div>
						<div class="col-sm-10">
							<a class="fancy_image" href="{{ gallery_photo_url($photo['photos']) }}" >
								<img width="60" height="60" src="{{ gallery_photo_url($photo['photos']) }}" />
							</a>
						</div>
					@endif
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
	<link rel="stylesheet" href="{{ css_url('/jquery.fancybox.min.css') }}">
@endpush
@push('scripts')
	<script src="{{ js_url('/jquery.validate.min.js') }}"></script>
	<script src="{{ js_url('/select2.min.js') }}"></script>
	<script src="{{ js_url('/jquery.fancybox.min.js') }}"></script>
	<script>
		var photo_id = "{{ (isset($photo['id']))?$photo['id']:'' }}";
		$("#photos_form").validate({
			errorClass: 'help-block',
			errorElement: 'span',
			rules: {
				user_id: { required: true },
				place_name: { required: true, minlength:2, maxlength:150 },
				address: { required: true, minlength:2, maxlength:300 },
				"photos[]": { required: function(element){
						if(photo_id){
							return false;
						}else{
							return true;
						}
					}
				}
			},
			messages: {
				user_id: { required: "The users field is required." },
				place_name: { required: "The place name field is required." },
				address: { required: "The address field is required." },
				"photos[]": { required: "The photos field is required." }
			},
			errorPlacement: function(error, element) {
				error.insertAfter($(element));
			},
			highlight: function(element, errorClass, validClass) {
				$(element).parents('div.form-group').addClass('has-error');
			},
			unhighlight: function(element, errorClass, validClass){
				$(element).parents('div.form-group').removeClass('has-error');
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

		/* Start: Fancybox initialization for image viewer */
		$("a.fancy_image").fancybox();
		/* End: Fancybox initialization for image viewer */
	</script>
@endpush