@extends('layout')
@section('content')
	<h1 class="heading-1 var-center">{{ __('app.friend-mail-title',['friend'=>$name]) }}</h1>
	<p class="body-text var-center">{{ __('app.friend-mail-explanation',['friend'=>$name]) }}</p>
	<a class="button var-center var-call-to-action" href="{{ route('friend_accepted',['token'=> $token]) }}">{{ __('app.friend-mail-action') }}</a>
@endsection