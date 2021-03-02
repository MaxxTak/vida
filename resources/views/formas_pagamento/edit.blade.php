@extends('layouts.basico')

@section('page-header')
	Formas de Pagamento <small>{{ trans('app.update_item') }}</small>
@stop

@section('content')
	{!! Form::model($item, [
			'action' => ['FormasPagamentoController@update', $item->id],
			'method' => 'put', 
		])
	!!}

		@include('formas_pagamento.form')

		<button type="submit" class="btn btn-primary">{{ trans('app.edit_button') }}</button>
		
	{!! Form::close() !!}
	
@stop