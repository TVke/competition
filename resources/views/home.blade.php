@extends('layout')
@section('content')
	<section class="info-block var-medium var-space-on-bottom">
		<p class="body-text var-center">{{ __('app.win-information') }}</p>
		<p class="body-text var-center">{{ __('app.game-information') }}</p>
	</section>

	<a class="button var-center var-call-to-action" href="{{ route('play') }}">{{ __('app.call-to-action') }}</a>
	<a class="button var-center var-action-sub" href="{{ route('rules') }}">{{ __('app.rules') }}</a>
	<section class="info-block var-small var-space">
		@if(count($winners) > 0)
			<h3 class="heading-3 var-underline">{{ __('app.winners-title') }}</h3>
			<ol class="list">
				@foreach($winners as $winner)
					<li class="list-item">{{ $winner->winners->first_name }}</li>
				@endforeach
			</ol>
		@endif
			@php
				setlocale(LC_TIME, 'nl_BE');
			@endphp
		<h3 class="heading-3 var-space-on-top var-center">{{ __('app.periods-title',['end' => $end_date->formatLocalized('%d %b %Y')]) }}</h3>
	</section>
@endsection