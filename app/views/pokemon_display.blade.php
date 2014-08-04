@extends('_master')

@section('title')
Pok&eacute;mon | {{ $pokemon->name }}
@stop

@section('head')
	<link rel="stylesheet" type="text/css" href= {{ URL::asset('styles/pokemon_display.css')}} >
@stop


@section('content')

	<div class='pokemon-basic'>
		<img src={{ $pokemon->image}}><br>
		<span class='pokemon-name'>{{ $pokemon->name }} #{{ $pokemon->index }}</span>
	</div>
	<br><br>

	<div class='general-table'>
		<table class='general-table'>
			<tbody>
				<?php $type1 = $pokemon->types->pop()->name ?>
				<tr><td>Type:<br>
					<span class="type-container inline-type background-color-{{ strtolower($type1) }}"> {{ $type1 }}</span>
					@if ($pokemon->types->count() > 0)
						<?php $type2 = $pokemon->types->pop()->name ?>
						<span class="type-container inline-type background-color-{{ strtolower($type2) }}"> {{ $type2 }}</span>
					@endif
				</td></tr>
				<?php $ability_name = $pokemon->abilities->pop()->name ?>
				@if ($pokemon->abilities->count() > 0)
					<?php $ability_name .= "/" . $pokemon->abilities->pop()->name ?>
				@endif
				<tr><td>Ability: {{ $ability_name }}</td></tr>
				<tr><td>Weight: {{ $pokemon->weight }}</td></tr>
				<tr><td>Height: {{ $pokemon->height }}</td></tr>
			</tbody>
		</table>
	</div>

	<br><br>
	<div class='moves-table'>
		<table>
			@foreach ($pokemon->moves as $move)
				<tr><td>{{ $move->pivot->level }}</td><td>{{ $move->name }}</td></tr>
			@endforeach
		</table>
	</div>
@stop