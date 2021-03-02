@extends('layouts.basico')

@section('page-header')
	Formas de Pagamento <small>{{ trans('app.update_item') }}</small>
@stop

@section('content')
	{!! Form::model($item, [
			'action' => ['EspecialidadeController@update', $item->id],
			'method' => 'put', 
		])
	!!}

		@include('especialidade.form')

		<button type="submit" class="btn btn-primary">{{ trans('app.edit_button') }}</button>
		
	{!! Form::close() !!}
	
@stop