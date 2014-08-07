@extends('_master')

@section('title')
	Log in
@stop

@section('content')
<h1>Log in</h1>

{{ Form::open(array('url' => '/login')) }}

    Email:<br>
    {{ Form::text('email', null, array('required')) }}<br><br>

    Password:<br>
    {{ Form::password('password', null, array('required')) }}<br><br>

    {{ Form::checkbox('remember') }}
    Remember me <br><br>

    {{ Form::submit('Log in') }}

{{ Form::close() }}
@stop