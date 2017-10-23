<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="UTF-8">
	<title>{{ __('app.price') }}</title>
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="{{ asset('/css/app.css') }}">
</head>
<body>
<header>
	<a href="{{ route('home') }}" class="link">
		<h1 class="logo var-center">MediaMarkt</h1>
	</a>
	@auth
	<section class="login-box">
			<form action="{{ route('logout') }}" method="POST">
				{{ csrf_field() }}
				<input class="button var-header" type="submit" value="Logout">
			</form>
	</section>
	@endauth
</header>
@yield('content')
<footer>
	<p class="copyright">© {{ date("Y") }} MediaMarkt</p>
	@guest
		<a class="button var-footer" href="{{ route('login') }}">Admin</a>
	@endguest
</footer>
</body>