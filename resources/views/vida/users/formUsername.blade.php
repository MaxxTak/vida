<div class="row mB-40">
	<div class="col-sm-8">
		<div class="bgc-white p-20 bd">
			{!! Form::myInput('text', 'name', 'Nome') !!}
		
			{!! Form::myInput('text', 'username', 'Usuário') !!}
			
			{!! Form::myInput('email', 'email', 'E-mail') !!}
		
			{!! Form::myInput('password', 'password', 'Senha') !!}
		
			{!! Form::myInput('password', 'password_confirmation', 'Confirmar senha') !!}
		
			{!! Form::mySelect('role', 'Tipo', config('variables.role'), null, ['class' => 'form-control select2']) !!}
		
			<!-- {!! Form::myFile('avatar', 'Avatar') !!} -->
		
			{!! Form::myTextArea('bio', 'Biografia') !!}
		</div>  
	</div>
</div>