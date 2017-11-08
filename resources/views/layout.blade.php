<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="UTF-8">
	<title>{{ __('app.price') }}</title>
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="{{ asset(env('APP_URL').'/css/app.css') }}">
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	<link rel="manifest" href="/manifest.json">
	<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#df0000">
	<meta name="theme-color" content="#df0000">
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
		@if(Route::currentRouteName()!=="login" && Route::currentRouteName()!=="friend_invite")
			<a class="button var-footer" href="{{ route('login') }}">{{ __('app.login-button') }}</a>
		@endif
	@endguest
</footer>
</body>