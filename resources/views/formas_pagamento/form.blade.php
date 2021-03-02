<div class="row mB-40">
	<div class="col-sm-12">
		<div class="bgc-white p-20 bd">
			{!! Form::myInput('text', 'descricao', 'Descrição') !!}

			{!! Form::myInput('text', 'acrescimo', 'Acréscimos (%)') !!}
	
			{!! Form::myInput('text', 'abatimento', 'Abatimentos (%)') !!}
		</div>  
	</div>
</div>

@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
    <script type="text/javascript" src="{!! asset('/js/formas_pagamento/cadastro.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/jquery.mask.min.js') !!}"></script>
@endpush