@extends('layout')
@section('content')
	<h1 class="heading-1 var-center">{{ __('app.settings-title') }}</h1>
	<form action="{{ route('update_periods') }}" method="post" class="form var-settings">
		{{ csrf_field() }}
		{{ method_field('PATCH') }}
		@foreach($periods as $period)
			<label for="start-{{ $period->id }}" class="label">{{ __('app.period-label') }} {{ $period->id }}</label>
			<section class="form-group">
				<input value="{{ old('start-'.$period->id,$period->start->format('d-m-Y')) }}" name="start-{{ $period->id }}" id="start-{{ $period->id }}" class="input" required>
				<input value="{{ old('end-'.$period->id,$period->end->format('d-m-Y')) }}" name="end-{{ $period->id }}" id="end-{{ $period->id }}" class="input" required>
			</section>
			@if($errors->has('start-'.$period->id) || $errors->has('end-'.$period->id))
				<section class="form-group">
					@if ($errors->has('start-'.$period->id))
						<p class="error">{{ $errors->first('start-'.$period->id) }}</p>
					@endif
					@if ($errors->has('end-'.$period->id))
						<p class="error{{ (!$errors->has('start-'.$period->id))?" var-right":"" }}">{{ $errors->first('end-'.$period->id) }}</p>
					@endif
				</section>
			@endif
		@endforeach
		<input type="submit" class="button var-submit" value="{{ __('app.edit-button') }}">
	</form>
	@if($players)
		<a href="{{ route('excel') }}" class="button var-icon var-right var-excel" download="Deelnemers"><img src="{{ asset('/img/excel.svg') }}" alt="excel"><p>{{ __('app.excel-download') }}</p></a>
		{{ $players->links() }}
		<table class="table">
			<thead class="table-head">
			<tr>
				<th>{{ __('app.table-first_name') }}</th>
				<th>{{ __('app.table-last_name') }}</th>
				<th>{{ __('app.table-email') }}</th>
				<th>{{ __('app.table-address') }}</th>
				<th>{{ __('app.table-city') }}</th>
				<th>{{ __('app.table-time') }}</th>
				<th>{{ __('app.table-server-time') }}</th>
				<th>{{ __('app.table-friend') }}</th>
				<th></th>
			</tr>
			</thead>
			<tbody class="table-body">
			@foreach($players as $player)
				@if($player->possible_dis)
					<tr class="var-possible-dis">
				@else
					<tr>
				@endif
						<td>{{ $player->first_name }}</td>
						<td>{{ $player->last_name }}</td>
						<td>{{ $player->email }}</td>
						<td>{{ $player->address }}</td>
						<td>{{ $player->postcode }} {{ $player->city }}</td>
						<td>{{ $player->time/10 }}</td>
						@if($player->end !== null && $player->start !== null)
							<td>{{ round($player->end - $player->start,2) }}</td>
						@else
							<td></td>
						@endif
						<td>{{ $player->friend_email }}</td>
						<td>
							<form action="{{ route('delete_player',['player' => $player->id]) }}" method="post">
								{{ csrf_field() }}
								{{ method_field('DELETE') }}
								<input type="submit" class="button var-delete" value="{{ __('app.table-delete-button') }}">
							</form>
						</td>
					</tr>
					@endforeach
			</tbody>
		</table>

		{{ $players->links() }}
	@else
		<h2 class="heading-3 var-center">{{ __('app.empty-table') }}</h2>
	@endif
@endsection