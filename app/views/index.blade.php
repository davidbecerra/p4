@extends('_master')

@section('content')

	<div class='home-search'>

		{{ Form::open(array('url' => '/', 'method' => 'POST'))}}

			<b>Search for a Pok&eacute;mon</b><br> {{ Form::text('query', null, array('placeholder' => 'Enter Pok&eacute;mon name', 'required', 'class' => 'form-text')) }}

			{{ Form::submit('Search') }}

		{{ Form::close() }}

	</div>

	<!-- <img src="http://sudeshx12-pokemon.webs.com/pokedex1.gif"> -->


@stop