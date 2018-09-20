@extends('master')
@section('content')
	<section class="sec-one ptb-60">
		<div class="container">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<div class="sec-ttl">
						<h2>Photos</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<form action="/action_page.php">
					<div class="form-group row">
						<div class="form-group">
							<div class="col-xs-2">
							</div>
							<div class="col-xs-4">
								<input type="text" class="form-control" id="by_tags" placeholder="By Tags" name="by_tags">
							</div>
							<div class="col-xs-4">
								<input type="text" class="form-control" id="by_place" placeholder="By Place" name="by_place">
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<hr>
		<br>
		@if(isset($photos) && count($photos) > 0)
			<div class="container-fluid">
				<div class="row">
					@foreach($photos as $photo)
						<div class="col-sm-6 col-md-2">
							<a class="fancy_image" href="{{ gallery_photo_url($photo['photos']) }}" data-fancybox="gallery" data-caption="{{ 'Address - '.$photo['address'].'<br>Sent By - '.$photo->user->name }}">
								<img src="{{ gallery_photo_url($photo['photos']) }}" height="170px" width="220px"/>
								<p>{{ $photo['place_name'] }}</p>
							</a>
						</div>
					@endforeach
				</div>
				<div class="text-center">
					<nav aria-label="Page navigation example">
						{{ $photos->links() }}
					</nav>
				</div>
			</div>
		@endif
	</section>
@endsection
@push('styles')
	<link rel="stylesheet" href="{{ css_url('/jquery-ui.css') }}">
	<link rel="stylesheet" href="{{ css_url('/jquery.fancybox.min.css') }}">
@endpush
@push('scripts')
	<script src="{{ js_url('/jquery-ui.js') }}"></script>
	<script src="{{ js_url('/jquery.fancybox.min.js') }}"></script>

	<script>
	/* Start: Fancybox initialization for image viewer */
	$("a.fancy_image").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	600, 
		'speedOut'		:	200, 
		'overlayShow'	:	false,
		buttons: [
			"zoom",
			"share",
			"slideShow",
			"fullScreen",
			"download",
			"thumbs",
			"close"
		],
	});
	/* End: Fancybox initialization for image viewer */

	$("#by_tags").autocomplete({
		minLength: 3,
		source: function (query, result) {
			$.ajax({
				url: "{{ base_url().'/get_tags' }}",
				data: { tags: $('#by_tags').val(), _token: '{{ csrf_token() }}' },
				dataType: "json",
				type: "POST",
				success: function (data) {
					result($.map(data, function (item) {
						return item;
					}));
				}
			});
		}
	});
	$("#by_place").autocomplete({
		minLength: 3,
		source: function (query, result) {
			$.ajax({
				url: "{{ base_url().'/get_places' }}",
				data: { places: $('#by_place').val(), _token: '{{ csrf_token() }}' },
				dataType: "json",
				type: "POST",
				success: function (data) {
					result($.map(data, function (item) {
						return item;
					}));
				}
			});
		}
	});
</script>
@endpush