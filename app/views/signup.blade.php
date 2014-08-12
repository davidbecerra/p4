@extends('_master')

@section('title')
	Sign up
@stop

@section('content')
	<h1>Sign up</h1>

	@foreach($errors->all() as $message)
		<div class='error'>{{ $message }}</div>
	@endforeach

	{{ Form::open(array('url' => '/signup', 'method' => 'POST')) }}

		Username:<br>
		{{ Form::text('username', null, array('required')) }}<br><br>

    Email:<br>
    {{ Form::text('email', null, array('required')) }}<br><br>

    Password:<br>
    {{ Form::password('password', null, array('required')) }}<br><br>

    {{ Form::submit('Sign up') }}

	{{ Form::close() }}
@stop