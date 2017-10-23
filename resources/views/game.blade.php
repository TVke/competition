@extends('layout')
@section('content')
	<p class="body-text var-center">Let goed op, er wordt vaak over een kleine bol gekeken!</p>
	<time>{{ old('time','00:00,0') }}</time>
	<section id="game" class="begin">
		<button id="start" class="button var-call-to-action var-center var-start">Start</button>
		<div id="dots">
			<noscript>Javascript moet aanstaan.</noscript>
			<div id="msg"><p>Gefeliciteerd! Je kan de afbeelding volledig zien.</p><p>Vul je gegevens in en maak kans op een iPhone X!</p></div>
		</div>
	</section>
	@if(session('diff'))
		<p class="heading-3 var-center">{{ session('diff') }}</p>
		@endif
	<form action="{{ route('update_user') }}" method="post" class="form">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<input type="hidden" name="time" value="{{ old('time') }}">
		<input type="hidden" name="ip" value="{{ $ip }}">
		<section class="form-group">
			<label for="first-name" class="label">voornaam*</label>
			<label for="surname" class="label">achternaam*</label>
		</section>
		<section class="form-group">
			<input name="first_name" class="input" id="first-name" value="{{ old('first_name') }}" required>
			<input name="surname" class="input" id="surname" value="{{ old('surname') }}" required>
		</section>
		<label for="email" class="label">email*</label>
		<input name="email" type="email" class="input" id="email" value="{{ old('email') }}" required>
		<label for="adres" class="label">straat + huisnummer*</label>
		<input name="adres" class="input" id="adres" value="{{ old('adres') }}" required>
		<section class="form-group">
			<label for="postcode" class="label">postcode*</label>
			<label for="city" class="label">gemeente / stad*</label>
		</section>
		<section class="form-group">
			<input name="postcode" class="input" id="postcode" value="{{ old('postcode') }}" required>
			<input name="city" class="input" id="city" value="{{ old('city') }}" required>
		</section>
		<section class="form-group">
			<input type="submit" class="button var-submit" value="neem deel">
			{{-- facebook button --}}
		</section>
	</form>
	<script src={{ asset('/js/d3.min.js') }}></script>
	<script src="{{ asset('/js/app.js') }}"></script>
@endsection
