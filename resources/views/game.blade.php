@extends('layout')
@section('content')
	<time>00:00</time>
	<div id="dots">
		<noscript><p>Javascript moet aanstaan.</p></noscript>
		<div id="msg"><p>Gefeliciteerd! Je kan de foto volledig zien.</p><p>ververs de pagina om een nieuwe foto te ontdekken.</p></div>
	</div>

	<script src={{ asset('/js/d3.min.js') }}></script>
	<script type="application/javascript">
		var possible=['/img/fotos-lighter.jpg','/img/gebruik-lighter.jpg','/img/iphone.jpg','/img/mensen.jpg'];
	</script>
	<script src="{{ asset('/js/spel.js') }}"></script>
@endsection


