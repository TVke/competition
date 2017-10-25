@extends('layout')
@section('content')
	@if(session('status'))
		@if(session('status') === "ok")
			<h1 class="heading-1 var-center">{{ __('app.valid-title') }}</h1>
			<form action="{{ route('invite') }}" method="post" class="form">
				{{ csrf_field() }}
				{{ method_field('PATCH') }}
				<p class="body-text var-center">{{ __('app.friend-invite-info') }}</p>
				<label for="friend_email" class="label{{ $errors->has('friend_email') ? ' error' : '' }}">{{ __('app.friend-invite-label') }}</label>
				<input type="email" name="friend_email" id="friend_email" class="input" value="{{ old('friend_email') }}">
				<input type="submit" value="{{ __('app.friend-invite-button') }}" class="button var-submit">
			</form>
		@endif
		@if(session('status') === "retry")
			<h1 class="heading-1 var-center">{{ __('app.retry-info') }}</h1>
			<a class="button var-center" href="{{ route('play') }}">{{ __('app.retry-button') }}</a>
		@endif
	@else
		<h2 class="heading-1 var-center">{{ __('app.price') }}</h2>
		<p class="body-text var-center">{{ __('app.fairness-warning') }}</p>
		<time>00:00,0</time>
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
				<label for="first-name" class="label{{ $errors->has('first_name') ? ' error' : '' }}">{{ __('app.first-name-label') }}*</label>
				<label for="surname" class="label{{ $errors->has('surname') ? ' error' : '' }}">{{ __('app.surname-label') }}*</label>
			</section>
			<section class="form-group">
				<input name="first_name" class="input" id="first-name" value="{{ old('first_name') }}" required>
				<input name="surname" class="input" id="surname" value="{{ old('surname') }}" required>
			</section>
			<section class="form-group">
				@if ($errors->has('first_name'))
					<p class="error">{{ $errors->first('first_name') }}</p>
				@endif
				@if ($errors->has('surname'))
					<p class="error">{{ $errors->first('surname') }}</p>
				@endif
			</section>
			<label for="email" class="label{{ $errors->has('email') ? ' error' : '' }}">{{ __('app.email-label') }}*</label>
			<input name="email" type="email" class="input" id="email" value="{{ old('email') }}" required>
			@if ($errors->has('email'))
				<p class="error">{{ $errors->first('email') }}</p>
			@endif
			<label for="adres" class="label{{ $errors->has('adres') ? ' error' : '' }}">{{ __('app.adres-label') }}*</label>
			<input name="adres" class="input" id="adres" value="{{ old('adres') }}" required>
			@if ($errors->has('adres'))
				<p class="error">{{ $errors->first('adres') }}</p>
			@endif
			<section class="form-group">
				<label for="postalcode" class="label{{ $errors->has('postalcode') ? ' error' : '' }}">{{ __('app.postalcode-label') }}*</label>
				<label for="city" class="label{{ $errors->has('city') ? ' error' : '' }}">{{ __('app.city-label') }}*</label>
			</section>
			<section class="form-group">
				<input name="postalcode" class="input" id="postalcode" value="{{ old('postalcode') }}" required>
				<input name="city" class="input" id="city" value="{{ old('city') }}" required>
			</section>
			<section class="form-group">
				@if ($errors->has('postalcode'))
					<p class="error">{{ $errors->first('postalcode') }}</p>
				@endif
				@if ($errors->has('city'))
					<p class="error">{{ $errors->first('city') }}</p>
				@endif
			</section>
			<section class="form-group">
				<input type="submit" class="button var-submit" value="{{ __('app.submit-button') }}">
				{{-- facebook button --}}
				{{--<fb:login-button--}}
						{{--scope="public_profile,email"--}}
						{{--onlogin="checkLoginState();">--}}
				{{--</fb:login-button>--}}
				{{--<div class="fb-login-button" data-size="medium" data-button-type="login_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="false"></div>--}}
			</section>
		</form>
	@endif
	<script src={{ asset('/js/d3.min.js') }}></script>
	<script src="{{ asset('/js/app.js') }}"></script>
	{{--<div id="fb-root"></div>--}}
	{{--<script>(function(d, s, id) {--}}
			{{--var js, fjs = d.getElementsByTagName(s)[0];--}}
			{{--if (d.getElementById(id)) return;--}}
			{{--js = d.createElement(s); js.id = id;--}}
			{{--js.src = 'https://connect.facebook.net/nl_BE/sdk.js#xfbml=1&version=v2.10&appId=147384299052984';--}}
			{{--fjs.parentNode.insertBefore(js, fjs);--}}
		{{--}(document, 'script', 'facebook-jssdk'));</script>--}}
	{{--<script>--}}
		{{--window.fbAsyncInit = function(){FB.init({--}}
				{{--appId      : '159739291288956',--}}
				{{--cookie     : true,--}}
				{{--xfbml      : true,--}}
				{{--version    : '2.10'--}}
			{{--});FB.AppEvents.logPageView();};(function(d, s, id){var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) {return;}js = d.createElement(s); js.id = id;js.src = "https://connect.facebook.net/en_US/sdk.js";fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));--}}
	{{--</script>--}}
@endsection
