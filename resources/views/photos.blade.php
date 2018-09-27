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
			<div class="container-fluid photos">
				@include('load_photos')
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
	var tag_value = "";
	var place_value = "";
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
		},
		select: function (event, ui) {
			tag_value = ui.item.data;
			getPhotos("{{ base_url().'/photos' }}",tag_value,place_value);
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
		},
		select: function (event, ui) {
			place_value = ui.item.value;
			getPhotos("{{ base_url().'/photos' }}",tag_value,place_value);
		}
	});

	$('#by_tags').on('blur',function(){
		if($(this).val().length == 0)
		{
			getPhotos("{{ base_url().'/photos' }}","",place_value);
		}
	})

	$('#by_place').on('blur',function(){
		if($(this).val().length == 0)
		{
			getPhotos("{{ base_url().'/photos' }}",tag_value,"");
		}
	})

	/* Start: Load ajax on click on pagination or update the filters */
	$('body').on('click', '.pagination a', function(e) {
		e.preventDefault();
		var url = $(this).attr('href');
		getPhotos(url,tag_value,place_value);
		window.history.pushState("", "", url);
	});

	function getPhotos(url,tags,place) {
		$.ajax({
			url : url,
			data: { tags: tags, place: place, _token: "{{ csrf_token() }}" },
		}).done(function (data) {
			$('.photos').html(data);
		}).fail(function () {
			console.log('Photos could not be loaded.');
		});
	}
	/* End: Load ajax on click on pagination or update the filters */
</script>
@endpush