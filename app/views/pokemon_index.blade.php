@extends('_master')

@section('title')
Search for Pok&eacute;mon
@stop

@section('head')
<link rel="stylesheet" type="text/css" href={{ URL::asset('styles/types.css') }}>
<link rel="stylesheet" type="text/css" href={{ URL::asset('styles/pokemon_index.css') }}>
@stop

@section('content')

	<div class='search-wrapper'>
		<fieldset class='search'>
			<!-- <legend><h3>Basic Search:</h3></legend> -->
			<h3>Basic Search: </h3>
			{{ Form::open(array('url' => '/', 'method' => 'POST')) }}
				{{ Form::text('query', null, array('placeholder' => 'Enter Pok&eacute;mon name', 'required'))}}
			
				{{ Form::submit('Search') }}
			
			{{ Form::close() }}
		</fieldset>

		<br>

		<fieldset class='search'>
			<!-- <legend><h3>Advanced Search: </h3></legend> -->
			<h3>Advanced Search: </h3>
			{{ Form::open(array('url' => '/pokemon', 'method' => 'POST'))}}
				{{ $output }}
				{{ Form::submit('Search')}}
			{{ Form::close() }}
		</fieldset>
	</div>

	<div class='results-right'>
		@if (isset($query_results))
			{{ $query_results }}
		@endif
	</div>
@stop