@extends('master')
@section('content')
	<section class="sec-one ptb-60">
		<div class="container">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<div class="sec-ttl">
						<h2>Send Photos</h2>
					</div>
				</div>
			</div>
			<form action="{{ base_url().'/photos_form' }}" method="POST" id="photos_form" enctype="multipart/form-data">
				@csrf
				<div class="form-group">
					<div class="row">
						<div class="col-xs-5">
							<label class="pull-right">Place Name :</label>
						</div>
						<div class="col-xs-4">
							<input type="text" class="form-control" id="place_name" placeholder="Place Name" name="place_name">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-xs-5">
							<label class="pull-right">Tags :</label>
						</div>
						<div class="col-xs-4">
							<select name="tags[]" id="tags" class="form-control" multiple data-placeholder="Select a Tags">
								@foreach($tags as $tag)
									<option value="{{ $tag['name'] }}">{{ $tag['name'] }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-xs-5">
							<label class="pull-right">Address :</label>
						</div>
						<div class="col-xs-4">
							<textarea class="form-control" rows="5" id="address" placeholder="Address" name="address"></textarea>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-xs-5">
							<label class="pull-right">Note :</label>
						</div>
						<div class="col-xs-4">
							<textarea class="form-control" rows="5" id="note" placeholder="Note" name="note"></textarea>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-xs-5">
							<label class="pull-right">Photos :</label>
						</div>
						<div class="col-xs-4">
							<input type="file" class="form-control" id="photos" name="photos[]" multiple>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-xs-5">
						</div>
						<div class="col-xs-4">
							<input type="submit" class="btn btn-success" id="submit" name="submit" value="Submit">
						</div>
					</div>
				</div>
			</form>
		</div>
	</section>
@endsection
@push('styles')
	<link rel="stylesheet" href="{{ css_url('/select2.min.css') }}">
	<style>
	.select2-container--default .select2-selection--multiple{
		border: 1px solid #ccc;
	}
	.select2-container--default.select2-container--focus .select2-selection--multiple
	{
		border-color: #66afe9;
	    outline: 0;
    	-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102,175,233,.6);
    	box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102,175,233,.6);
	}
	</style>
@endpush
@push('scripts')
	<script src="{{ js_url('/jquery.validate.min.js') }}"></script>
	<script src="{{ js_url('/select2.min.js') }}"></script>
	<script>

		$("#photos_form").validate({
			errorClass: 'help-block',
			errorElement: 'span',
			rules: {
				place_name: { required: true, minlength:2, maxlength:150 },
				address: { required: true, minlength:2, maxlength:300 },
				"photos[]": { required: true }
			},
			messages: {
				place_name: { required: "The place name field is required." },
				address: { required: "The address field is required." },
				"photos[]": { required: "The photos field is required." }
			},
			errorPlacement: function(error, element) {
				error.insertAfter($(element));
			},
			highlight: function(element, errorClass, validClass) {
				$(element).parents('div').addClass('has-error');
			},
			unhighlight: function(element, errorClass, validClass) {
				$(element).parents('div').removeClass('has-error');
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