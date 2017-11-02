@extends('layout')
@section('content')
	<h1 class="heading-1 var-center">{{ __('app.settings-title') }}</h1>
	<form action="{{ route('update_periods') }}" method="post" class="form">
		{{ csrf_field() }}
		{{ method_field('PATCH') }}
		@foreach($periods as $period)
			<label for="start-{{ $period->id }}" class="label">{{ __('app.period-label') }} {{ $period->id }}</label>
			<section class="form-group">
				<input value="{{ old('start-'.$period->id,$period->start) }}" name="start-{{ $period->id }}" id="start-{{ $period->id }}" class="input" required>
				<input value="{{ old('end-'.$period->id,$period->end) }}" name="end-{{ $period->id }}" id="end-{{ $period->id }}" class="input" required>
			</section>
		@endforeach
		<input type="submit" class="button var-submit" value="{{ __('app.edit-button') }}">
	</form>
	@if($players)
		{{ $players->links() }}
		<table class="table">
			<thead class="table-head">
			<tr>
				<th>{{ __('app.table-first_name') }}</th>
				<th>{{ __('app.table-last_name') }}</th>
				<th>{{ __('app.table-email') }}</th>
				<th>{{ __('app.table-address') }}</th>
				<th>{{ __('app.table-postcode') }}</th>
				<th>{{ __('app.table-city') }}</th>
				<th>{{ __('app.table-ip') }}</th>
				<th>{{ __('app.table-time') }}</th>
				<th>{{ __('app.table-server-time') }}</th>
				<th>{{ __('app.table-friend') }}</th>
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
						<td>{{ $player->postcode }}</td>
						<td>{{ $player->city }}</td>
						<td>{{ $player->ip }}</td>
						<td>{{ $player->time/10 }}</td>
						@if($player->end !== null && $player->start !== null)
							<td>{{ round($player->end - $player->start,4) }}</td>
						@else
							<td></td>
						@endif
						<td>{{ $player->friend_email }}</td>
					</tr>
					@endforeach
			</tbody>
		</table>

		{{ $players->links() }}
	@else
		<h2 class="heading-3 var-center">{{ __('app.empty-table') }}</h2>
	@endif
@endsection