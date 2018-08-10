<!DOCTYPE html>
<html lang="en">
<head>
	<title>{{ (isset($title))?$title:'Innovative Ideas' }}</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="{{ css_url('/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ css_url('/front-main.css') }}">
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
				<a class="navbar-brand" href="{{ base_url() }}" title="Innovative Ideas"><strong>INNOVATIVE</strong> IDEAS</a>
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
					<li class="{{ (check_segment(1,'log_in'))?'active':(check_segment(1,'sign_up'))?'active':'' }}">
						<a href="{{ base_url('/log_in') }}" title="Log In/Sign Up">Log In/Sign Up</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>