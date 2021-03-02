@extends('vida.default')

@section('page-header')
	User <small>{{ trans('app.add_new_item') }}</small>
@stop

@section('content')
	{!! Form::open([
			'action' => ['UserController@store'],
			'files' => true
		])
	!!}

		@include('vida.users.formUsername')

		<button type="submit" class="btn btn-primary">{{ trans('app.add_button') }}</button>
		
	{!! Form::close() !!}
	
@stop
