@extends('layouts.basico')

@section('page-header')
	Plano de Contas <small>{{ trans('app.update_item') }}</small>
@stop

@section('content')
	<div class="row mB-40">
		<div class="col-sm-8">
			<div class="bgc-white p-20 bd">
				<div class="tab">
					<button class="tablinks active" onclick="openTab(event, 'PlanoContas')">Plano de Contas</button>
					
					@if(in_array($item->tipo, ['CR', 'CP']))
						<button class="tablinks" onclick="openTab(event, 'Acessorios')">Acessórios</button>
					@endif
				</div>
				{!! Form::model($item, [
						'action' => ['PlanoContaController@update', $item->id],
						'method' => 'put', 
					])
				!!}

				@include('plano_contas.form')

				<br />
				<button type="submit" class="btn btn-primary">{{ trans('app.edit_button') }}</button>
		
				{!! Form::close() !!}	
			</div>  
		</div>
	</div>
	
@stop
