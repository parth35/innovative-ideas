@extends('master')
@section('content')
	<section class="sec-one ptb-60">
		<div class="container">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<div class="sec-ttl">
						<h2>Filters</h2>
					</div>
				</div>
			</div>
			<form action="/action_page.php">
				<div class="form-group row">
					<div class="form-group">
						<div class="col-xs-4">
							<select class="form-control" id="by_user" placeholder="By User" name="by_user">
								<option>By User</option>
								@foreach($users as $user)
									<option value="{{ $user->user_id }}">{{ $user->name }}</option>
								@endforeach
							</select>
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
	</section>
@endsection
@push('styles')
	<link rel="stylesheet" href="{{ css_url('/jquery-ui.css') }}">
@endpush
@push('scripts')
	<script src="{{ js_url('/jquery-ui.js') }}"></script>
	<script>
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
</script>
@endpush