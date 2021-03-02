@extends('layouts.basico')

@section('page-header')
	Plano <small>{{ trans('app.add_new_item') }}</small>
@stop

@section('content')
	{!! Form::open([
			'action' => ['PlanoController@store'],
		])
	!!}

		@include('planos.form')

		<button type="submit" class="btn btn-primary">{{ trans('app.add_button') }}</button>
		
	{!! Form::close() !!}
	
@stop
