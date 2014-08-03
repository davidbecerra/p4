@extends('_master')

@section('title')
Pok&eacute;mon | {{ $output['name'] }}
@stop

@section('head')
	<link rel="stylesheet" type="text/css" href= {{ URL::asset('styles/pokemon_display.css')}} >
@stop


@section('content')

	<div class='pokemon-basic'>
		{{ $output['content'] }}
	</div>

	<table class='general-table'>
	</table>
@stop