@extends('layout')
@section('content')
	<h2 class="heading-1 var-center">{{ __('home.reward-title') }}</h2>
	<p class="body-text">{{ __('home.game-information') }}
	</p>
	<a class="button var-center var-call-to-action" href="{{ route('play') }}">{{ __('home.call-to-action') }}</a>
	<section>
		<h3 class="heading-2 var-underline">{{ __('home.winners-title') }}</h3>
		<ol class="list">
			<li class="list-item">Thomas</li>
		</ol>
		<h3 class="heading-2 var-underline">{{ __('home.periods-title') }}</h3>
		<ul class="list">
			<li class="list-item">{{ __('home.periods-body',['number'=>2,'start'=>"20/10/2017 00:00",'end'=>"29/10/2017 00:00"]) }}</li>
			<li class="list-item">{{ __('home.periods-body',['number'=>3,'start'=>"20/11/2017 00:00",'end'=>"29/11/2017 00:00"]) }}</li>
			<li class="list-item">{{ __('home.periods-body',['number'=>4,'start'=>"20/12/2017 00:00",'end'=>"29/12/2017 00:00"]) }}</li>
		</ul>
	</section>
@endsection