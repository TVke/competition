@extends('layout')
@section('content')
	<section class="info-block var-medium var-space-on-bottom">
		<p class="body-text var-center">{{ __('app.win-information') }}</p>
		<p class="body-text var-center">{{ __('app.game-information') }}</p>
	</section>

	<a class="button var-center var-call-to-action" href="{{ route('play') }}">{{ __('app.call-to-action') }}</a>
	<a class="button var-center var-action-sub" href="{{ route('rules') }}">{{ __('app.rules') }}</a>
	<section class="info-block var-small var-space">
		@if(true)
			<h3 class="heading-3 var-underline">{{ __('app.winners-title') }}</h3>
			<ol class="list">
				<li class="list-item">Thomas</li>
			</ol>
		@endif
		<h3 class="heading-3 var-space-on-top">{{ __('app.periods-title',['end'=>'20 okt 2017']) }}</h3>
		{{--<ul class="list var-dash">--}}
			{{--<li class="list-item">{{ __('app.periods-body',['number'=>2,'start'=>"20 okt 2017 00:00",'end'=>"29 okt 2017 00:00"]) }}</li>--}}
			{{--<li class="list-item">{{ __('app.periods-body',['number'=>3,'start'=>"20/11/2017 00:00",'end'=>"29/11/2017 00:00"]) }}</li>--}}
			{{--<li class="list-item">{{ __('app.periods-body',['number'=>4,'start'=>"20/12/2017 00:00",'end'=>"29/12/2017 00:00"]) }}</li>--}}
		{{--</ul>--}}
	</section>
@endsection