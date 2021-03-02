@extends('layouts.basico')

@section('page-header')
	Salas <small>{{ trans('app.update_item') }}</small>
@stop

@section('content')
	{!! Form::model($item, [
			'action' => ['SalaController@update', $item->id],
			'method' => 'put', 
		])
	!!}

		@include('salas.form')

		<button type="submit" class="btn btn-primary">{{ trans('app.edit_button') }}</button>
		
	{!! Form::close() !!}
	
@stop