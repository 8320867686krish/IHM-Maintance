@include('layouts.head')

<body>
<div class="bg-overlay" style="display: none;"></div>

	<div class="">


		@include('layouts.sidebar')

		<div class="dashboard-wrapper">
			@include('layouts.navbar')
			@yield('content')

			@include('layouts.footer')

		</div>

	</div>

	@include('layouts.script')
</body>

</html>
