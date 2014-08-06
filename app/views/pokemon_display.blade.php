@extends('_master')

@section('title')
Pok&eacute;mon | {{ $pokemon->name }}
@stop

@section('head')
	<link rel="stylesheet" type="text/css" href= {{ URL::asset('styles/pokemon_display.css')}} >
@stop


@section('content')
	
	<div class='pokemon-basic'>

		<div class='pokemon-image'>
			<span class='pokemon-name'><h1>{{ $pokemon->name }} #{{ $pokemon->index }}</h1></span><br>
			<img src={{ $pokemon->image}}><br>
		</div>

		<div class='general-table'>
			<table class='general-table'>
				<thead>
					<tr><th colspan='2'>General Information</th></tr>
				</thead>
				<tbody>
					<tr>
						<td><b>Type:</b></td>
						<td>
							@foreach ($pokemon->types as $type)
								<span class="type-container inline-type background-color-{{ strtolower($type->name) }}"> {{ $type->name }}</span>
							@endforeach
						</td>
					</tr>
					<?php $ability_name = $pokemon->abilities->pop()->name ?>
					@if ($pokemon->abilities->count() > 0)
						<?php $ability_name .= "<br>" . $pokemon->abilities->pop()->name ?>
					@endif
					<tr><td><b>Ability:</b></td><td>{{ $ability_name }}</td></tr>
					<tr><td><b>Weight:</b></td><td>{{ $pokemon->weight }}</td></tr>
					<tr><td><b>Height:</b></td><td>{{ $pokemon->height }}</td></tr>
				</tbody>
				<tfoot><tr><td><br></td></tr></tfoot>	
			</table>
		</div>

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