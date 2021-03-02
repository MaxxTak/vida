@extends('layouts.basico')

@section('page-header')
	Procedimentos <small>{{ trans('app.add_new_item') }}</small>
@stop

@section('content')
	{!! Form::open([
			'action' => ['ProcedimentoController@store'],
		])
	!!}

	@include('procedimentos.form')

	<button type="submit" class="btn btn-primary">{{ trans('app.add_button') }}</button>
		
	{!! Form::close() !!}
@stop
