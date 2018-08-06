	<footer class="text-center">
			<p>© {{ date('Y') }} Innovative Ideas</p>
	</footer>
	<script src="{{ js_url('/jquery.min.js') }}"></script>
	<script src="{{ js_url('/bootstrap.min.js') }}"></script>
	@stack('scripts')
</body>
</html>