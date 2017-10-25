@extends('layout')

@section('content')
	<h1 class="heading-1 var-center">{{ __('app.login-title') }}</h1>
	<form action="{{ route('login') }}" method="post" class="form">
		{{ csrf_field() }}
		<label for="name" class="label{{ $errors->has('name') ? ' error' : '' }}">{{ __('app.login-user-label') }}</label>
		<input id="name" name="name" class="input" value="{{ old('name') }}" required autofocus>
		@if ($errors->has('name'))
			<p class="error">{{ $errors->first('name') }}</p>
		@endif
		<label for="password" class="label{{ $errors->has('password') ? ' error' : '' }}">{{ __('app.login-password-label') }}</label>
		<input id="password" type="password" name="password" class="input" required>
		@if ($errors->has('password'))
			<p class="error">{{ $errors->first('password') }}</p>
		@endif
		<label class="label{{ $errors->has('remember') ? ' error' : '' }}"><input type="checkbox" name="remember" class="input var-checkbox" {{ old('remember') ? 'checked' : '' }}> {{ __('app.login-remember-label') }}</label>
		<input type="submit" value="{{ __('app.login-button') }}" class="button var-submit">
	</form>
@endsection
