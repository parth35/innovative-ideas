	<header class="main-header">
		
		<a href="{{ admin_url('/dashboard') }}" class="logo">
			<span class="logo-mini"><b>I</b>deas</span>
			<span class="logo-lg"><b>Innovative</b>Ideas</span>
		</a>
		
		<nav class="navbar navbar-static-top">
			<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
				<span class="sr-only">Toggle navigation</span>
			</a>
			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
					<li class="dropdown user user-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<img src="{{ user_profile_image_url(Auth::user()->profile_image) }}" class="user-image" alt="User Image">
							<span class="hidden-xs">{{ Auth::user()->first_name.' '.Auth::user()->last_name }}</span>
						</a>
						<ul class="dropdown-menu">
							<li class="user-header">
								<img src="{{ user_profile_image_url(Auth::user()->profile_image) }}" class="img-circle" alt="User Image">
								<p>{{ Auth::user()->first_name.' '.Auth::user()->last_name }}
									<small>Member since - {{ date('M Y',strtotime(Auth::user()->created_at)) }}</small>
								</p>
							</li>
							<li class="user-body">
								<div class="row">
									<div class="col-xs-4 text-center">
										<a href="#">Followers</a>
									</div>
									<div class="col-xs-4 text-center">
										<a href="#">Sales</a>
									</div>
									<div class="col-xs-4 text-center">
										<a href="#">Friends</a>
									</div>
								</div>
							</li>
							<li class="user-footer">
								<div class="pull-left">
									<a href="#" class="btn btn-default btn-flat">Profile</a>
								</div>
								<div class="pull-right">
									<a href="{{ admin_url('/logout') }}" class="btn btn-default btn-flat">Sign out</a>
								</div>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
	</header>