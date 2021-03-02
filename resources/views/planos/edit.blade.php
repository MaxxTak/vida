@extends('layouts.basico')

@section('page-header')
	Plano <small>{{ trans('app.update_item') }}</small>
@stop

@section('content')
	{!! Form::model($item, [
			'action' => ['PlanoController@update', $item->id],
			'method' => 'put', 
		])
	!!}

		@include('planos.form')

		<button type="submit" class="btn btn-primary">{{ trans('app.edit_button') }}</button>
		
	{!! Form::close() !!}
	
@stop