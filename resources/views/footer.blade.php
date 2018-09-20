	</div>
	<footer class="text-center">
			<p>© {{ date('Y') }} Innovative Ideas</p>
	</footer>
	<script src="{{ js_url('/jquery.min.js') }}"></script>
	<script src="{{ js_url('/bootstrap.min.js') }}"></script>
	<script src="{{ js_url('/toastr-message.min.js') }}"></script>
	<script>
		function warning_message(message)
        {
            toastr.warning(message,{
				"closeButton": true,
				"debug": false,
				"newestOnTop": false,
				"progressBar": false,
				"positionClass": "toast-bottom-right",
				"preventDuplicates": false,
				"onclick": null,
				"showDuration": "300",
				"hideDuration": "1000",
				"timeOut": "10000",
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
                "closeButton": true,
				"debug": false,
				"newestOnTop": false,
				"progressBar": false,
				"positionClass": "toast-bottom-right",
				"preventDuplicates": false,
				"onclick": null,
				"showDuration": "300",
				"hideDuration": "1000",
				"timeOut": "10000",
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
                "closeButton": true,
				"debug": false,
				"newestOnTop": false,
				"progressBar": false,
				"positionClass": "toast-bottom-right",
				"preventDuplicates": false,
				"onclick": null,
				"showDuration": "300",
				"hideDuration": "1000",
				"timeOut": "10000",
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
	@stack('scripts')
</body>
</html>