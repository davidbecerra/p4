@extends('_master')

@section('head')
	<link rel="stylesheet" type="text/css" href= {{ URL::asset('styles/pokemon_display.css')}} >
@stop


@section('content')

	<div class='pokemon-basic'>
		{{ $output }}
	</div>

	<table class='general-table'>
		<tr><td>Type: Water</td><tr>
		<tr><td>Abilities: Torrent/Something Else</td></tr>
		<tr><td>Height: 1000m</td></tr>
		<tr><td>Weigth: 1000lbs</td></tr>
	</table>
@stop