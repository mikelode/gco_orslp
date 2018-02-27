<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}">

@include('partials.htmlheader')

<body>

	@include('partials.contentheader')
	@include('partials.mainheader')

	<div class="main">
		@yield('main-content')
	</div>

	@include('partials.controlsidebar')

	@include('partials.extrafooter')
	@include('partials.footer')
	@include('partials.scripts')

	@yield('custom-scripts')

</body>
</html>