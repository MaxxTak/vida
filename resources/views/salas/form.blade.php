<div class="row mB-40">
	<div class="col-sm-12">
		<div class="bgc-white p-20 bd">
			{!! Form::myInput('text', 'descricao', 'Descrição') !!}

			{!! Form::mySelect('especialidade_id[]', 'Especialidade', $especialidades, $sala_especialidades, ['multiple' => 'multiple']) !!}
		</div>  
	</div>
</div>

@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
    <script type="text/javascript" src="{!! asset('/js/salas/salas.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/select2.min.js') !!}"></script>
@endpush