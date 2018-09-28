<!DOCTYPE html>
<html lang="en">
<head>
	<title>{{ (isset($title))?$title:'Travel History' }}</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="{{ css_url('/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ css_url('/front-main.css') }}">
	<link rel="stylesheet" href="{{ base_url('/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ css_url('/toastr-message.min.css') }}">
	@stack('styles')
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ base_url() }}" title="Travel History"><strong>TRAVEL</strong> HISTORY</a>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-right">
					<li class="{{ (check_segment(1,''))?'active':'' }}">
						<a href="{{ base_url() }}" title="Home">Home</a>
					</li>
					<li class="{{ (check_segment(1,'about'))?'active':'' }}">
						<a href="{{ base_url('/about') }}" title="About">About</a>
					</li>
					<li class="{{ (check_segment(1,'photos'))?'active':'' }}">
						<a href="{{ base_url('/photos') }}" title="Photos">Photos</a>
					</li>
					<li class="{{ (check_segment(1,'send_photo'))?'active':'' }}">
						<a href="{{ base_url('/send_photo') }}" title="Send Photo">Send Photo</a>
					</li>
					@if(Auth::check())
						<li class="{{ (check_segment(1,'log_out'))?'active':'' }}">
							<a href="{{ base_url('/log_out') }}" title="{{ Auth::user()->name }}">Log Out</a>
						</li>
					@else
						<li class="{{ (check_segment(1,'log_in'))?'active':'' }}">
							<a href="{{ base_url('/log_in') }}" title="Log In">Log In</a>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>
	<div class="min-sec-height">