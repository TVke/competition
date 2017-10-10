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
<h2 class="heading-1 var-center">{{ __('app.title') }}</h2>
@yield('content')
<footer>
	<p class="copyright">© MediaMarkt 2017</p>
</footer>
</body>