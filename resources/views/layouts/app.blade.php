@include('layouts.head')

<body>
<div class="bg-overlay" style="display: none;"></div>
	@include('layouts.navbar',['shiptitle'=>@$shiptitle])
	@include('layouts.sidebar')

<div class="dashboard-main-wrapper">




		<div class="dashboard-wrapper">

			@yield('content')

			@include('layouts.footer')

		</div>

	</div>

	@include('layouts.script')
</body>

</html>
