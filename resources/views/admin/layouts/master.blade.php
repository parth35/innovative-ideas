<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{{ (isset($title))?$title:'Innovative Ideas' }}</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="{{ css_url('/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ base_url('/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ css_url('/style.css') }}">
	<link rel="stylesheet" href="{{ css_url('/toastr-message.min.css') }}">
	
	<!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="{{ css_url('/skins/_all-skins.min.css') }}">
	<!-- Google Font -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

	@stack('styles')

</head>
<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">

	@include('admin.layouts.header')
	@include('admin.layouts.sidebar')
	<div class="content-wrapper">
		@yield('content')
	</div>
	@include('admin.layouts.footer')

	<!-- jQuery 3 -->
	<script src="{{ js_url('/jquery.min.js') }}"></script>
	<!-- jQuery UI 1.11.4 -->
	<script src="{{ js_url('/jquery-ui.min.js') }}"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="{{ js_url('/bootstrap.min.js') }}"></script>
	<script src="{{ js_url('/admin.js') }}"></script>
	<script src="{{ js_url('/toastr-message.min.js') }}"></script>

	@stack('scripts')
	<script>
		/* Start: Select all check box for list view */
		$('#select_all').click(function(event) {
			if (this.checked) {
				$(':checkbox').prop('checked', true);
			} else {
				$(':checkbox').prop('checked', false);
			}
		});
		/* End: Select all check box for list view */

		/* Start: Active all button action */
		function active_all(url)
		{
			if($('.data_checkbox').is(":checked"))
			{
				var allObj = {'_token':"{{ csrf_token() }}"};
				allObj.datachecked = [];
				$('.data_checkbox:checked').each(function(){
					var id = $(this).attr('id');
					allObj.datachecked.push(id);
				})
				allObj.datachecked.push();
				$.ajax({
					type: "post",
					url: url,
					data: allObj,
					success: function(html)
					{
						window.location.href='';
					}
				});
			}
			else
			{
				warning_message("Please check at least one checkbox.");
			}
		}
		/* End: Active all button action */

		/* Start: Inactive all button action */
		function inactive_all(url)
		{
			if($('.data_checkbox').is(":checked"))
			{
				var allObj = {'_token':"{{ csrf_token() }}"};
				allObj.datachecked = [];
				$('.data_checkbox:checked').each(function(){
					var id = $(this).attr('id');
					allObj.datachecked.push(id);
				})
				allObj.datachecked.push();
				$.ajax({
					type: "post",
					url: url,
					data: allObj,
					success: function(html)
					{
						window.location.href='';
					}
				});
			}
			else
			{
				warning_message("Please check at least one checkbox.");
			}
		}
		/* End: Inactive all button action */

		/* Start: Delete all button action */
		function delete_all(url)
		{
			if($('.data_checkbox').is(":checked"))
			{
				var allObj = {'_token':"{{ csrf_token() }}"};
				allObj.datachecked = [];
				$('.data_checkbox:checked').each(function(){
					var id = $(this).attr('id');
					allObj.datachecked.push(id);
				})
				allObj.datachecked.push();
				$.ajax({
					type: "post",
					url: url,
					data: allObj,
					success: function(html)
					{
						window.location.href='';
					}
				});
			}
			else
			{
				warning_message("Please check at least one checkbox.");
			}
		}
		/* End: Delete all button action */

		function warning_message(message)
        {
            toastr.warning(message,{
                timeOut: 10000,
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut",
                "tapToDismiss": false
            })
        }

        function success_message(message)
        {
            toastr.success(message,{
                timeOut: 10000,
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut",
                "tapToDismiss": false
            })
		}

		function error_message(message)
        {
            toastr.error(message,{
                timeOut: 10000,
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut",
                "tapToDismiss": false
            })
		}
		
		/* suuccess message initialization */
		@if(session()->has('success'))
			success_message("{{ session()->get('success') }}");
		@endif
		/* suuccess message initialization */

		/* warning message initialization */
		@if(session()->has('warning'))
			warning_message("{{ session()->get('warning') }}");
		@endif
		/* warning message initialization */

		/* error message initialization */
		@if(session()->has('error'))
			error_message("{{ session()->get('error') }}");
		@endif
		/* error message initialization */
	</script>
</body>
</html>