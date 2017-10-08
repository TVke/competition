<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Wedstrijd</title>
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="{{ asset('/css/app.css') }}">
</head>
<body>
<header>
	<h1>MediaMarkt</h1>
	<section>
		@guest
			<a href="{{ route('login') }}">Login</a>
		@else
			<form action="{{ route('logout') }}" method="POST">
				{{ csrf_field() }}
				<input type="submit" value="logout">
			</form>
		@endguest
	</section>
</header>
@yield('content')
</body>