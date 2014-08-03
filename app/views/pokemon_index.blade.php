@extends('_master')

@section('title')
Search for Pok&eacute;mon
@stop

@section('head')
<link rel="stylesheet" type="text/css" href={{ URL::asset('styles/types.css') }}>
<link rel="stylesheet" type="text/css" href={{ URL::asset('styles/search_index.css') }}>
@stop

@section('content')

	<div class='search-wrapper'>
		<h3>Basic Search: </h3>
		{{ Form::open(array('url' => '/', 'method' => 'POST')) }}

			{{ Form::text('query', null, array('placeholder' => 'Enter Pok&eacute;mon name', 'required'))}}
		
			{{ Form::submit('Search') }}
		
		{{ Form::close() }}

		<h3>Advanced Search: </h3>
		{{ Form::open(array('url' => '/pokemon', 'method' => 'POST'))}}
			{{ $output }}
			{{ Form::submit('Search')}}
		{{ Form::close() }}
	</div>

	<div class='results-right'>
		@if (isset($query_results))
			{{ $query_results }}
		@endif
	</div>
@stop