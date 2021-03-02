<div class="row mB-40">
	<div class="col-sm-12">
		<div class="bgc-white p-20 bd">
			{!! Form::myInput('text', 'titulo', 'Título') !!}
			
			{!! Form::myTextArea('descricao', 'Descrição') !!}
		</div>  
	</div>
</div>

@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
@endpush