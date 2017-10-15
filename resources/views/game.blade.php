@extends('layout')
@section('content')
	<p class="body-text var-center">Let goed op, er wordt vaak over een kleine bol gekeken!</p>
	<time>{{ old('time','00:00') }}</time>
	<section id="game" class="begin">
		<button id="start" class="button var-call-to-action var-center var-start">Start</button>
		<div id="dots">
			<noscript>Javascript moet aanstaan.</noscript>
			<div id="msg"><p>Gefeliciteerd! Je kan de afbeelding volledig zien.</p><p>Vul je gegevens in en maak kans op een iPhone X!</p></div>
		</div>
	</section>
	{{--<button id="start" class="button var-call-to-action var-center var-start begin">Start</button>--}}
	{{--<div id="dots" class="begin">--}}
		{{--<noscript>Javascript moet aanstaan.</noscript>--}}
		{{--<div id="msg"><p>Gefeliciteerd! Je kan de afbeelding volledig zien.</p><p>Vul je gegevens in en maak kans op een iPhone X!</p></div>--}}
	{{--</div>--}}
	<form action="{{ route('update_user') }}" method="post">
		{{ csrf_field() }}
		<input type="hidden" name="time" value="{{ old('time') }}">
		<input type="hidden" name="ip" value="{{ $ip }}">
		<label for="first-name">voornaam</label>
		<input name="first_name" id="first-name" value="{{ old('first_name') }}">
		<label for="surname">achternaam</label>
		<input name="surname" id="surname" value="{{ old('surname') }}">
		<label for="email">email</label>
		<input name="email" id="email" value="{{ old('email') }}">
		<label for="adres">straat + huisnummer</label>
		<input name="adres" id="adres" value="{{ old('adres') }}">
		<label for="postcode">postcode</label>
		<input name="postcode" id="postcode" value="{{ old('postcode') }}">
		<label for="city">gemeente / stad</label>
		<input name="city" id="city" value="{{ old('city') }}">
		<input type="submit" value="neem deel">
	</form>
	<script src={{ asset('/js/d3.min.js') }}></script>
	<script src="{{ asset('/js/app.js') }}"></script>
@endsection
