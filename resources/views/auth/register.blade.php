@extends('layouts.formulario')

@section('content')



             <h2>Cadastro</h2>
             <p>Clique na abas para inserir as informações:</p>

                 <div class="tab">
                     <button class="tablinks" onclick="openCity(event, 'Pessoal')">Pessoal</button>
                     <button class="tablinks" onclick="openCity(event, 'Endereco')">Endereço</button>
                     <button class="tablinks" onclick="openCity(event, 'Usuario')">Usuário</button>
                 </div>
             <form method="POST" action="/vida/registrar">
                 {{ csrf_field() }}
 <!-- =======================================TAB PESSOAL================================================================= -->
                 <div id="Pessoal" class="tabcontent">
                     <h3>Pessoal</h3>
                     <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                         <label for="name" class="text-normal text-dark">Nome</label>
                         <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                         @if ($errors->has('name'))
                             <span class="form-text text-danger">
                            <small>{{ $errors->first('name') }}</small>
                    </span>
                         @endif
                     </div>

                     <div class="form-group{{ $errors->has('documento') ? ' has-error' : '' }}">
                         <label for="documento" class="text-normal text-dark">Documento</label>
                         <input id="documento" type="documento" class="form-control" name="documento" value="{{ old('documento') }}" required>

                         @if ($errors->has('documento'))
                             <span class="form-text text-danger">
                            <small>{{ $errors->first('documento') }}</small>
                        </span>
                         @endif
                     </div>

                     <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                         <label for="email" class="text-normal text-dark">E-mail</label>
                         <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                         @if ($errors->has('email'))
                             <span class="form-text text-danger">
                            <small>{{ $errors->first('email') }}</small>
                        </span>
                         @endif
                     </div>

                 </div>
 <!-- =======================================END TAB PESSOAL================================================================= -->
<!-- =======================================TAB ENDEREÇO================================================================= -->
                 <div id="Endereco" class="tabcontent">
                     <h3>Endereço</h3>
                     <p>Endereço </p>
                 </div>
<!-- =======================================END TAB PESSOAL================================================================= -->
<!-- =======================================TAB USUARIO================================================================= -->
                 <div id="Usuario" class="tabcontent">
                     <h3>Usuário</h3>
                     <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                         <label for="username" class="text-normal text-dark">Usuário</label>
                         <input id="username" type="username" class="form-control" name="username" value="{{ old('username') }}" required>

                         @if ($errors->has('username'))
                             <span class="form-text text-danger">
                    <small>{{ $errors->first('username') }}</small>
                </span>
                         @endif
                     </div>

                     <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                         <label for="password" class="text-normal text-dark">Senha</label>
                         <input id="password" type="password" class="form-control" name="password" required>

                         @if ($errors->has('password'))
                             <span class="form-text text-danger">
                    <small>{{ $errors->first('password') }}</small>
                </span>
                         @endif
                     </div>

                     <div class="form-group">
                         <label for="password_confirmation" class="text-normal text-dark">Confirmar Senha</label>
                         <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>

                     </div>


                 </div>
<!-- =======================================END TAB USUARIO================================================================= -->

<br>
        <div class="form-group">
            <div class="peers ai-c jc-sb fxw-nw">
                <div class="peer">
                    <a href="/login">Retornar para home</a>
                </div>
                <div class="peer">
                    <button class="btn btn-primary">Cadastrar</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
    <script type="text/javascript" src="{!! asset('/js/tab.js') !!}"></script>
@endpush
