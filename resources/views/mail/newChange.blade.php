@extends('layout')
@section('content')
	<h1 class="heading-1 var-center">{{ __('app.new-change-mail-title') }}</h1>
	<p class="body-text var-center">{{ __('app.new-change-mail-explanation') }}</p>
	<a class="button var-center var-call-to-action" href="{{ route('home') }}">{{ __('app.new-change-mail-action') }}</a>
@endsection