@extends('_master')

@section('content')

	{{ Form::open(array('url' => '/', 'method' => 'POST'))}}

		Search for a Pok&eacute;mon: {{ Form::text('query', null, array('placeholder' => 'Enter Pok&eacute;mon name', 'required')) }}

		{{ Form::submit('Search') }}

	{{ Form::close() }}

@stop