@extends('layout')
@section('content')
	<h2 class="heading-1 var-center">{{ __('app.price') }}</h2>
	<section class="info-block">
		<h2 class="heading-2">spelregels</h2>
		<p class="body-text">{{ __('app.rules') }}</p>
		<ul class="list var-dash var-space-on-top">
			@php
				setlocale(LC_TIME, 'nl_BE');
			@endphp
			@foreach($periodes as $periode)
				<li class="list-item">{{ __('app.periods-body',['number' => $periode->id,'start' => $periode->start->formatLocalized('%d %b %Y'),'end' => $periode->end->formatLocalized('%d %b %Y')]) }}</li>
			@endforeach
		</ul>
	</section>
	<a class="button var-center var-call-to-action" href="{{ route('play') }}">{{ __('app.call-to-action') }}</a>

@endsection