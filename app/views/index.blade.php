@extends('_master')

@section('content')

	{{ Form::open(array('url' => '/pokemon', 'method' => 'POST'))}}

		{{ Form::text('query', null, array('placeholder' => 'Enter Pok&eacute;mon name')) }}

		{{ Form::submit('Search') }}

	{{ Form::close() }}

@stop