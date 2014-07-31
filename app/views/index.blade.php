@extends('_master')

@section('content')

	<br>
	{{ Form::open(array('url' => '/pokemon', 'method' => 'POST'))}}

		{{ Form::text('query', null, array('placeholder' => 'Enter Pok&eacute;mon name', 'required')) }}

		{{ Form::submit('Search') }}

	{{ Form::close() }}

@stop