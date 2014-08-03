@extends('_master')

@section('title')
Search for Pok&eacute;mon
@stop

@section('head')
<link rel="stylesheet" type="text/css" href={{ URL::asset('styles/types.css') }}>
<link rel="stylesheet" type="text/css" href={{ URL::asset('styles/search_index.css') }}>
@stop

@section('content')

<h1>Pokemon!!</h1>


	<div class='search-wrapper'>
		{{ Form::open(array('url' => '/', 'method' => 'POST')) }}

			{{ Form::text('query', null, array('placeholder' => 'Enter Pok&eacute;mon name', 'required'))}}
		
			{{ Form::submit('Search') }}
		
		{{ Form::close() }}

		Advanced Search
		{{ Form::open(array('url' => '/pokemon', 'method' => 'POST'))}}
			{{ $output }}
			{{ Form::submit('Search')}}
		{{ Form::close() }}
	</div>

	<div class='results-right'>
	</div>
@stop