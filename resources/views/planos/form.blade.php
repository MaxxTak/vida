<div class="row mB-40">
	<div class="col-sm-12">
		<div class="bgc-white p-20 bd">
			{!! Form::myInput('text', 'descricao', 'Descrição') !!}

			{!! Form::myInput('text', 'valor', 'Valor') !!}
	
			{!! Form::myInput('number', 'dependentes', 'Dependentes', ['min' => 0, 'step' => 1]) !!}
	
			{!! Form::myInput('number', 'entrada', 'Entrada', ['min' => 0, 'step' => 1]) !!}

			{!! Form::myInput('number', 'meses_contrato', 'Meses Contrato', ['min' => 0, 'step' => 1]) !!}

			{!! Form::myInput('text', 'adicional_dependente', 'Adicional Dependente') !!}
			
			{!! Form::mySelect('plano_contas_id', 'Plano de Contas', $plano_contas) !!}
			
			{!! Form::mySelect('user_id', 'Empresa', $empresas) !!}
		
		</div>  
	</div>
</div>

@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
    <script type="text/javascript" src="{!! asset('/js/plano/cadastro.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/jquery.mask.min.js') !!}"></script>
@endpush