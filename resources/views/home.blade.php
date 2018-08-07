@extends('master')
@section('content')
	<div class="container-fluid">
		<div class="row">
			{{-- Slider Start --}}
			@if(isset($photos) && !empty($photos) && count($photos)>0)
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
			@endif
			{{-- Slider End --}}
		</div>
	</div>
	<section class="sec-one ptb-60">
		<div class="container">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<div class="sec-ttl">
						<h2 data-line="What are we...?">What are we...?</h2>
					</div>
					<div class="row">
						<div class="col-md-3">
							<h3>Overview</h3>
							<div class="h3-btm-devider"></div>
						</div>
						<div class="col-md-9">
							<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
							<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, but also the leap into electronic typesetting, remaining essentially unchanged when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="sec-two">
		<div class="table-cell" style="background: url('{{ (isset($section_back_image['photos']))?gallery_photo_url($section_back_image['photos']):'' }}') no-repeat center; background-size: cover;">
			<div class="col-md-12 table-cell" style="background:rgba(0, 0, 0,0.7);">
				<div class="centered">
					<h2>Help Us To Grow</h2>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, incididunt magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, incididunt magna aliqua.</p>
				</div>
			</div>
		</div>
	</section>
	<section class="ptb-60">
		<div class="container">
			<div class="media-container-row">
				<div class="card p-3 col-12 col-md-6 col-lg-4">
					<div class="card-img pb-3">
						<span class="mbr-iconfont mbri-users" style="color: rgb(0, 0, 0);" media-simple="true"></span>
					</div>
					<div class="card-box">
						<h4 class="card-title py-3 mbr-fonts-style display-5">Creativity</h4>
						<p class="mbr-text mbr-fonts-style display-7">It's the ability to think outside the box. We make decisions, create something new and generate a lot of ideas.</p>
					</div>
				</div>
				<div class="card p-3 col-12 col-md-6 col-lg-4">
					<div class="card-img pb-3">
						<span class="mbr-iconfont mbri-globe" style="color: rgb(0, 0, 0);" media-simple="true"></span>
					</div>
					<div class="card-box">
						<h4 class="card-title py-3 mbr-fonts-style display-5">Worldwide</h4>
						<p class="mbr-text mbr-fonts-style display-7">All sites you make with Mobirise are mobile-friendly. You don't have to create a special mobile version of your site.</p>
					</div>
				</div>
				<div class="card p-3 col-12 col-md-6 col-lg-4">
					<div class="card-img pb-3">
						<span class="mbr-iconfont mbri-smile-face" style="color: rgb(0, 0, 0);" media-simple="true"></span>
					</div>
					<div class="card-box">
						<h4 class="card-title py-3 mbr-fonts-style display-5">Unique Styles</h4>
						<p class="mbr-text mbr-fonts-style display-7">Mobirise offers many site blocks in several themes, and though these blocks are pre-made, they are flexible.</p>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection
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