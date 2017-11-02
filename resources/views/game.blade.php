@extends('layout')
@section('content')
	@if(!session('status') && !$cookie)
		<h2 class="heading-1 var-center">{{ __('app.price') }}</h2>
		<p class="body-text var-center">{{ __('app.fairness-warning') }}</p>
		<time>{{ timeFormat(old('time',0)) }}</time>
		<section id="game" class="begin">
			<p class="body-text var-center var-start">{{ __('app.start-text') }}</p>
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
			@if(old('et'))
				<input type="hidden" name="et" value="{{ old('et') }}">
			@endif
			<section class="form-group">
				<label for="first-name" class="label{{ $errors->has('first_name') ? ' error' : '' }}">{{ __('app.first_name-label') }}*</label>
				<label for="last_name" class="label{{ $errors->has('last_name') ? ' error' : '' }}">{{ __('app.last_name-label') }}*</label>
			</section>
			<section class="form-group">
				<input name="first_name" class="input" id="first-name" value="{{ old('first_name') }}" required>
				<input name="last_name" class="input" id="last_name" value="{{ old('last_name') }}" required>
			</section>
			@if($errors->has('first_name') || $errors->has('last_name'))
				<section class="form-group">
					@if ($errors->has('first_name'))
						<p class="error">{{ $errors->first('first_name') }}</p>
					@endif
					@if ($errors->has('last_name'))
						<p class="error{{ (!$errors->has('first_name'))?" var-right":"" }}">{{ $errors->first('last_name') }}</p>
					@endif
				</section>
			@endif
			<label for="email" class="label{{ $errors->has('email') ? ' error' : '' }}">{{ __('app.email-label') }}*</label>
			<input name="email" type="email" class="input" id="email" value="{{ old('email') }}" required>
			@if ($errors->has('email'))
				<p class="error">{{ $errors->first('email') }}</p>
			@endif
			<label for="address" class="label{{ $errors->has('address') ? ' error' : '' }}">{{ __('app.address-label') }}*</label>
			<input name="address" class="input" id="address" value="{{ old('address') }}" required>
			@if ($errors->has('address'))
				<p class="error">{{ $errors->first('address') }}</p>
			@endif
			<section class="form-group">
				<label for="postcode" class="label{{ $errors->has('postcode') ? ' error' : '' }}">{{ __('app.postcode-label') }}*</label>
				<label for="city" class="label{{ $errors->has('city') ? ' error' : '' }}">{{ __('app.city-label') }}*</label>
			</section>
			<section class="form-group">
				<input name="postcode" class="input" id="postcode" value="{{ old('postcode') }}" required>
				<input name="city" class="input" id="city" value="{{ old('city') }}" required>
			</section>
			@if($errors->has('postcode') || $errors->has('city'))
				<section class="form-group">
					@if ($errors->has('postcode'))
						<p class="error">{{ $errors->first('postcode') }}</p>
					@endif
					@if ($errors->has('city'))
						<p class="error{{ (!$errors->has('postcode'))?" var-right":"" }}">{{ $errors->first('city') }}</p>
					@endif
				</section>
			@endif
			<section class="form-group">
				<input type="submit" class="button var-submit" value="{{ __('app.submit-button') }}">
				{{-- facebook button --}}
			</section>
		</form>
		<script src={{ asset(env('APP_URL').'/js/d3.min.js') }}></script>
		<script src="{{ asset(env('APP_URL').'/js/app.js') }}"></script>
	@elseif(session('status'))
		@if(session('status') === "ok")
			<h1 class="heading-1 var-center">{{ __('app.valid-title') }}</h1>
			<form action="{{ route('invite') }}" method="post" class="form">
				{{ csrf_field() }}
				{{ method_field('PATCH') }}
				<p class="body-text var-center">{{ __('app.friend-invite-info') }}</p>
				<label for="friend_email" class="label{{ $errors->has('friend_email') ? ' error' : '' }}">{{ __('app.friend-invite-label') }}</label>
				<input type="email" name="friend_email" id="friend_email" class="input" value="{{ old('friend_email') }}">
				@if ($errors->has('friend_email'))
					<p class="error">{{ $errors->first('friend_email') }}</p>
				@endif
				<input type="submit" value="{{ __('app.friend-invite-button') }}" class="button var-submit">
			</form>
		@endif
		@if(session('status') === "retry")
			<h1 class="heading-1 var-center">{{ __('app.retry-info') }}</h1>
			<a class="button var-center var-status" href="{{ route('play') }}">{{ __('app.retry-button') }}</a>
		@endif
		@if(session('status') === "not_played")
			<h1 class="heading-1 var-center">{{ __('app.not_played-info') }}</h1>
			<a class="button var-center var-status" href="{{ route('play') }}">{{ __('app.not_played-button') }}</a>
		@endif
	@elseif($cookie)
		<h1 class="heading-1 var-center">{{ __('app.no_double-title') }}</h1>
		<form action="{{ route('invite') }}" method="post" class="form">
			{{ csrf_field() }}
			{{ method_field('PATCH') }}
			<p class="body-text var-center">{{ __('app.friend-invite-info') }}</p>
			<label for="friend_email" class="label{{ $errors->has('friend_email') ? ' error' : '' }}">{{ __('app.friend-invite-label') }}</label>
			<input type="email" name="friend_email" id="friend_email" class="input" value="{{ old('friend_email') }}">
			@if ($errors->has('friend_email'))
				<p class="error">{{ $errors->first('friend_email') }}</p>
			@endif
			<input type="submit" value="{{ __('app.friend-invite-button') }}" class="button var-submit">
		</form>
	@endif
@endsection
