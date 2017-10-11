<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="UTF-8">
	<title>{{ __('app.title') }}</title>
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="{{ asset('/css/app.css') }}">
</head>
<body>
<header>
	<a href="{{ route('home') }}" class="link">
		<h1 class="logo var-center">MediaMarkt</h1>
	</a>
	<section class="login-box">
		@auth
			<form action="{{ route('logout') }}" method="POST">
				{{ csrf_field() }}
				<input class="button var-header" type="submit" value="Logout">
			</form>
		@endauth
	</section>
</header>
<h2 class="heading-1 var-center">{{ __('app.title') }}</h2>
@yield('content')
<footer>
	<p class="copyright">© MediaMarkt 2017</p>
	@guest
		<a class="button var-footer" href="{{ route('login') }}">Admin</a>
	@endguest
</footer>
</body>