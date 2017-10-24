@extends('layout')
@section('content')
	@if(session('status'))
		<p class="heading-3 var-center">{{ session('status') }}</p>
		@if(session('status') === "ok")
			<h1 class="heading-1 var-center">{{ __('app.valid-title') }}</h1>
			<p>nodig een vriend uit</p>
		@endif
		@if(session('status') === "retry")
			<a class="button" href="{{ route('play') }}">{{ __('app.retry-button') }}</a>
		@endif
	@else
		@if($errors->any())
			@foreach($errors as $error)
				{{ $error }}
			@endforeach
		@endif
		<h2 class="heading-1 var-center">{{ __('app.price') }}</h2>
		<p class="body-text var-center">{{ __('app.fairness-warning') }}</p>
		<time>{{ old('time','00:00,0') }}</time>
		<section id="game" class="begin">
			<button id="start" class="button var-call-to-action var-center var-start">{{ __('app.start-button') }}</button>
			<div id="dots">
				<noscript>{{ __('app.js-error') }}</noscript>
				<div id="msg">
					<p>{{ __('app.win-message') }}</p>
					<p>{{ __('app.win-action-message') }}</p>
				</div>
			</div>
		</section>
		<form action="{{ route('update_user') }}" method="post" class="form">
			{{ csrf_field() }}
			{{ method_field('PUT') }}
			<input type="hidden" name="time" value="{{ old('time') }}">
			<input type="hidden" name="ip" value="{{ $ip }}">
			<section class="form-group">
				<label for="first-name" class="label">{{ __('app.first-name-label') }}*</label>
				<label for="surname" class="label">{{ __('app.surname-label') }}*</label>
			</section>
			<section class="form-group">
				<input name="first_name" class="input" id="first-name" value="{{ old('first_name') }}" required>
				<input name="surname" class="input" id="surname" value="{{ old('surname') }}" required>
			</section>
			<label for="email" class="label">{{ __('app.email-label') }}*</label>
			<input name="email" type="email" class="input" id="email" value="{{ old('email') }}" required>
			<label for="adres" class="label">{{ __('app.adres-label') }}*</label>
			<input name="adres" class="input" id="adres" value="{{ old('adres') }}" required>
			<section class="form-group">
				<label for="postalcode" class="label">{{ __('app.postalcode-label') }}*</label>
				<label for="city" class="label">{{ __('app.city-label') }}*</label>
			</section>
			<section class="form-group">
				<input name="postalcode" class="input" id="postalcode" value="{{ old('postalcode') }}" required>
				<input name="city" class="input" id="city" value="{{ old('city') }}" required>
			</section>
			<section class="form-group">
				<input type="submit" class="button var-submit" value="{{ __('app.submit-button') }}">
				{{-- facebook button --}}
			</section>
		</form>
	@endif
	<script src={{ asset('/js/d3.min.js') }}></script>
	<script src="{{ asset('/js/app.js') }}"></script>
@endsection
