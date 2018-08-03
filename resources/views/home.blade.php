@extends('master')
@section('content')
	<div class="container-fluid">
		<div class="row">
			{{-- Slider Start --}}
			<div id="home_main_slider" class="carousel slide" data-ride="carousel">
				<ol class="carousel-indicators">
					<?php $i=0; ?>
					@foreach($photos as $photo)
						<li data-slide-to="{{$i}}" class="item-dot @if($loop->first) active @endif" ></li>
						<?php $i++; ?>
					@endforeach
				</ol>
				<div class="carousel-inner" role="listbox">
					@foreach($photos as $photo)
						<div class="item @if($loop->first) active @endif">
							<img src="{{ gallery_photo_url($photo['photos']) }}" alt="{{ $photo['photos'] }}">
							<div class="carousel-caption">
								<h3>{{ ucfirst($photo['place_name']) }}</h3>
								<p>By - {{ \App\User::where('id',$photo['user_id'])->first()->first_name.' '.\App\User::where('id',$photo['user_id'])->first()->last_name }}</p>
							</div>
						</div>
					@endforeach
				</div>
				<a class="left carousel-control" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="right carousel-control" role="button" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
			{{-- Slider End --}}
		</div>
	</div>
	<div class="container">
		<div class="row">
			<h2>What are we...?</h2>
		</div>
	</div>
@endsection
@push('styles')
	<style>
		.carousel-inner > .item > img,
		.carousel-inner > .item > a > img {
			margin: auto;
			height: 650px;
		}
	</style>
@endpush
@push('scripts')
	<script>
		// Enable Carousel Controls
		$(".left").click(function(){
			$("#home_main_slider").carousel("prev");
		});
		$(".right").click(function(){
			$("#home_main_slider").carousel("next");
		});

		$('.item-dot').click(function(){
			var slide = $(this).data('slide-to');
			$("#home_main_slider").carousel(slide);
		})
	</script>
@endpush