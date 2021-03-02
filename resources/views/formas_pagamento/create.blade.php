@extends('layouts.basico')

@section('page-header')
	Formas de Pagamento <small>{{ trans('app.add_new_item') }}</small>
@stop

@section('content')
	{!! Form::open([
			'action' => ['FormasPagamentoController@store'],
		])
	!!}

	@include('formas_pagamento.form')

	<button type="submit" class="btn btn-primary">{{ trans('app.add_button') }}</button>
		
	{!! Form::close() !!}
	
@stop
