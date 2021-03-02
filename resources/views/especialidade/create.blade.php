@extends('layouts.basico')

@section('page-header')
	Especialidades <small>{{ trans('app.add_new_item') }}</small>
@stop

@section('content')
	{!! Form::open([
			'action' => ['EspecialidadeController@store'],
		])
	!!}

	@include('especialidade.form')

	<button type="submit" class="btn btn-primary">{{ trans('app.add_button') }}</button>
		
	{!! Form::close() !!}
	
@stop
