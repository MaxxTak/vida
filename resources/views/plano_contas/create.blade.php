@extends('layouts.basico')

@section('page-header')
	Plano de Contas <small>{{ trans('app.add_new_item') }}</small>
@stop

@section('content')
	<div class="row mB-40">
		<div class="col-sm-8">
			<div class="bgc-white p-20 bd">
				<div class="tab">
					<button class="tablinks active" onclick="openTab(event, 'PlanoContas')">Plano de Contas</button>
				</div>

				{!! Form::open([
						'action' => ['PlanoContaController@store'],
					])
				!!}

				@include('plano_contas.form')

				<br />
				<button type="submit" class="btn btn-primary">{{ trans('app.add_button') }}</button>
					
				{!! Form::close() !!}
			</div>  
		</div>
	</div>
	
@stop
