<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="UTF-8">
	<title>{{ __('app.price') }}</title>
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="{{ asset(env('app.url').'/css/app.css') }}">
</head>
<body>
<header>
	<a href="{{ route('home') }}" class="link">
		<h1 class="logo var-center">{{ __('app.company-name') }}</h1>
	</a>
	@auth
	<section class="login-box">
			<form action="{{ route('logout') }}" method="POST">
				{{ csrf_field() }}
				<input class="button var-header" type="submit" value="{{ __('app.logout-button') }}">
			</form>
	</section>
	@endauth
</header>
@yield('content')
<footer>
	<p class="copyright">© {{ date("Y") }} {{ __('app.company-name') }}</p>
	@guest
		@if(Route::currentRouteName()!=="login")
			<a class="button var-footer" href="{{ route('login') }}">{{ __('app.login-button') }}</a>
		@endif
	@endguest
</footer>
</body>