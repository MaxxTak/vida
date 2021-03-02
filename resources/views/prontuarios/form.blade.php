<div class="row mB-40">
	<div class="col-sm-12">
		<div class="bgc-white p-20 bd">
			{!! Form::myInput('text', 'descricao', 'Descrição') !!}

			{!! Form::mySelect('especialidade_id', 'Especialidade', $especialidades) !!}
		</div>  
	</div>
</div>

<div class="row mB-40">
	<div class="col-sm-12">
		<div class="bgc-white p-20 bd">
			{!! Form::mySelect('campos', 'Campos', $campos) !!}

			<button id="btnAdicionarCampo" class="btn btn-success">{{ trans('app.add_button') }}</button>
		</div>  
	</div>
</div>

<div class="bgc-white bd bdrs-3 p-20 mB-20">
	<h4>Campos Prontuário</h4>
	<table id="tabela-campos" class="table table-striped" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>#</th>
				<th>Descrição</th>
				<th>Campo</th>
				<th>Opções</th>
			</tr>
		</thead>
		
		<tfoot>
			<tr>
				<th>#</th>
				<th>Descrição</th>
				<th>Campo</th>
				<th>Opções</th>
			</tr>
		</tfoot>
	</table>
</div>

@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
@endpush