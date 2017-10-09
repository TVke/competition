<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="UTF-8">
	<title>{{ __('home.reward-title') }}</title>
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="{{ asset('/css/app.css') }}">
</head>
<body>
<header>
	<h1 class="logo var-center">MediaMarkt</h1>
	<section class="login-box">
		@guest
			<a class="button var-header" href="{{ route('login') }}">Login</a>
		@else
			<form action="{{ route('logout') }}" method="POST">
				{{ csrf_field() }}
				<input class="button var-header" type="submit" value="Logout">
			</form>
		@endguest
	</section>
</header>
@yield('content')
<footer>
	<p class="copyright">© MediaMarkt 2017</p>
</footer>
</body>