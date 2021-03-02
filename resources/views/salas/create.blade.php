@extends('layouts.basico')

@section('page-header')
	Salas <small>{{ trans('app.add_new_item') }}</small>
@stop

@section('content')
	{!! Form::open([
			'action' => ['SalaController@store'],
		])
	!!}

	@include('salas.form')

	<button type="submit" class="btn btn-primary">{{ trans('app.add_button') }}</button>
		
	{!! Form::close() !!}
	
@stop
