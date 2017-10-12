@extends('layout')
@section('content')
	<section class="info-block">
		<h2 class="heading-2">spelregels</h2>
		<p class="body-text">Beweeg over de bollen in het spel tot ze tot de kleinst mogelijke grootte hebben en je dus de volledige afbeelding ziet.
			Dit hoort te gebeuren in een zo kort mogelijke tijd om kans te maken.
			Wie dit spel het snelste uitspeelt krijgt op het einde van de periode een iPhone X toegestuurd.
			In geval van een ex-aequo wint de deelnemer die als eerste deze score heeft bereikt.
			MediaMarkt heeft ten alle tijden het recht een speler te diskwalificeren als er een vermoeden van vals spel is.</p>
		<ul class="list var-dash">
			<li class="list-item">{{ __('app.periods-body',['number'=>2,'start'=>"20 okt 2017 00:00",'end'=>"29 okt 2017 00:00"]) }}</li>
			<li class="list-item">{{ __('app.periods-body',['number'=>2,'start'=>"20 okt 2017 00:00",'end'=>"29 okt 2017 00:00"]) }}</li>
			<li class="list-item">{{ __('app.periods-body',['number'=>3,'start'=>"20/11/2017 00:00",'end'=>"29/11/2017 00:00"]) }}</li>
			<li class="list-item">{{ __('app.periods-body',['number'=>4,'start'=>"20/12/2017 00:00",'end'=>"29/12/2017 00:00"]) }}</li>
		</ul>
	</section>
	<a class="button var-center var-call-to-action" href="{{ route('play') }}">{{ __('app.call-to-action') }}</a>

@endsection