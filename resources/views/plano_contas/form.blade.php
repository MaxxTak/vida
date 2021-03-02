
<div id="PlanoContas" class="tabcontent" style="display: block;">
	<br />
	{!! Form::myInput('text', 'descricao', 'Descrição') !!}

	@if(empty($item))
		{!! Form::myInput('text', 'classificacao', 'Classificação', ['placeholder' => '_._.__.__.____']) !!}
	@else
		{!! Form::myInput('text', 'classificacao', 'Classificação', ['placeholder' => '_._.__.__.____', 'disabled' => 'disabled']) !!}
	@endif

	@if(empty($item))
		{!! Form::mySelect('tipo', 'Tipo', ['SS' => 'SS', 'AA' => 'AA', 'CX' => 'CX', 'CB' => 'CB', 'CR' => 'CR', 'CP' => 'CP']) !!}
	@else
		{!! Form::mySelect('tipo', 'Tipo', ['SS' => 'SS', 'AA' => 'AA', 'CX' => 'CX', 'CB' => 'CB', 'CR' => 'CR', 'CP' => 'CP'], null, ['disabled' => 'disabled']) !!}
	@endif
</div>

<div id="Acessorios" class="tabcontent">
	<br />
	{!! Form::myInput('text', 'juros', 'Juros (%)') !!}

	{!! Form::myInput('text', 'multa', 'Multa (%)') !!}

	{!! Form::myInput('text', 'desconto', 'Descontos (%)') !!}

</div>
		

@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
    <script type="text/javascript" src="{!! asset('/js/plano_contas/cadastro.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/jquery.mask.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/tab.js') !!}"></script>
@endpush