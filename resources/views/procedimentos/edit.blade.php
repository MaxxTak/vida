@extends('layouts.basico')

@section('page-header')
	Procedimentos <small>{{ trans('app.update_item') }}</small>
@stop

@section('content')
	{!! Form::model($item, [
			'action' => ['ProcedimentoController@update', $item->id],
			'method' => 'put', 
		])
	!!}

		@include('procedimentos.form')

		<button type="submit" class="btn btn-primary">{{ trans('app.edit_button') }}</button>
		
	{!! Form::close() !!}
	
@stop