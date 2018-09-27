	<div class="row">
		@foreach($photos as $photo)
			<div class="col-sm-6 col-md-2">
				<?php $tags = ""; ?>
				@foreach($photo->tags as $tag)
					<?php $tags .= '#'.$tag->name.' '; ?>
				@endforeach
				<a class="fancy_image" href="{{ gallery_photo_url($photo['photos']) }}" data-fancybox="gallery" data-caption="{{ 'Address - '.$photo['address'].'<br>Sent By - '.$photo->user->name.'<br>'.$tags }}">
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