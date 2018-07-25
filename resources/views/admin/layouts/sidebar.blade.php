	<!-- Left side column. contains the logo and sidebar -->
	<aside class="main-sidebar">
		<!-- sidebar: style can be found in sidebar.less -->
		<section class="sidebar">
			<!-- Sidebar user panel -->
			<div class="user-panel">
				<div class="pull-left image">
					<img src="{{ user_profile_image_url(Auth::user()->profile_image) }}" class="img-circle" alt="User Image">
				</div>
				<div class="pull-left info">
					<p>{{ Auth::user()->first_name.' '.Auth::user()->last_name }}</p>
				</div>
			</div>
			<!-- sidebar menu: : style can be found in sidebar.less -->
			<ul class="sidebar-menu" data-widget="tree">
				<li><a href="{{ admin_url('/users') }}"><i class="fa fa-book"></i> <span>Users</span></a></li>
			</ul>
		</section>
		<!-- /.sidebar -->
	</aside>