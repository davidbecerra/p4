@extends('_master')

@section('title')
Search for Pok&eacute;mon
@stop

@section('head')
<link rel="stylesheet" type="text/css" href={{ URL::asset('styles/pokemon_index.css') }}>
@stop

@section('content')

	<div class='search-wrapper'>
		<fieldset class='search'>
			<h3>Basic Search: </h3>
			{{ Form::open(array('url' => '/', 'method' => 'POST')) }}
				{{ Form::text('query', null, array('placeholder' => 'Enter Pok&eacute;mon name', 'required'))}}
				{{ Form::submit('Search') }}
			{{ Form::close() }}
		</fieldset>

		<br>

		<fieldset class='search'>
			<h3>Advanced Search: </h3>
			{{ Form::open(array('url' => '/pokemon', 'method' => 'POST'))}}
				{{ $output }}

				Order by: {{ Form::select('ordering', array(
			    'ID', 'Alphabetical'
				))}}<br><br>

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