@extends('layouts.basico')

@section('page-header')
    Cadastro de Empresa <small>Clique na abas para inserir as informações</small>
@stop

@section('content')
    <div class="row mB-40">
        <div class="col-sm-8">
            <div class="bgc-white p-20 bd">
                 <div class="tab">
                     <button class="tablinks active" onclick="openCity(event, 'Pessoal')">Empresa</button>
                     <button class="tablinks" onclick="openCity(event, 'Endereco')">Endereço</button>
                     <!--    <button class="tablinks" onclick="openCity(event, 'Contato')">Contato</button>-->
                     <button class="tablinks" onclick="openCity(event, 'Usuario')">Usuário</button>
                 </div>

                <form method="POST" action="/vida/registrar">
                    {{ csrf_field() }}
                    <input type="hidden" id="tipo" name="tipo" value="1">
                    <!-- =======================================TAB PESSOAL================================================================= -->
                    <div id="Pessoal" class="tabcontent">
                        <br />
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="text-normal text-dark">Razão Social</label>
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="form-text text-danger">
                                    <small>{{ $errors->first('name') }}</small>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('nome_fantasia') ? ' has-error' : '' }}">
                            <label for="nome_fantasia" class="text-normal text-dark">Nome Fantasia</label>
                            <input id="nome_fantasia" type="text" class="form-control" name="nome_fantasia" value="{{ old('nome_fantasia') }}" required>

                            @if ($errors->has('nome_fantasia'))
                                <span class="form-text text-danger">
                                    <small>{{ $errors->first('nome_fantasia') }}</small>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('documento') ? ' has-error' : '' }}">
                            <label for="documento" class="text-normal text-dark">CNPJ</label>
                            <input id="documento" type="documento" class="form-control" name="documento" value="{{ old('documento') }}" required>

                            @if ($errors->has('documento'))
                                <span class="form-text text-danger">
                                    <small>{{ $errors->first('documento') }}</small>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('end_eletronico') ? ' has-error' : '' }}">
                            <label for="end_eletronico" class="text-normal text-dark">E-mail</label>
                            <input id="end_eletronico" type="end_eletronico" class="form-control" name="end_eletronico" value="{{ old('end_eletronico') }}" required>

                            @if ($errors->has('end_eletronico'))
                                <span class="form-text text-danger">
                                <   small>{{ $errors->first('end_eletronico') }}</small>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('telefone') ? ' has-error' : '' }}">
                            <label for="telefone" class="text-normal text-dark">Telefone</label>
                            <input id="telefone" type="text" class="form-control" name="telefone" value="{{ old('telefone') }}" required>

                            @if ($errors->has('telefone'))
                                <span class="form-text text-danger">
                                    <small>{{ $errors->first('telefone') }}</small>
                            </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('ramo_atividade') ? ' has-error' : '' }}">
                            <label for="ramo_atividade" class="text-normal text-dark">Ramo de Atividade</label>
                            <input id="ramo_atividade" type="text" class="form-control" name="ramo_atividade" value="{{ old('ramo_atividade') }}">

                            @if ($errors->has('ramo_atividade'))
                                <span class="form-text text-danger">
                                    <small>{{ $errors->first('ramo_atividade') }}</small>
                                </span>
                            @endif
                        </div>

                    </div>
                    <!-- =======================================END TAB PESSOAL================================================================= -->

                    <!-- =======================================TAB ENDEREÇO================================================================= -->
                    <div id="Endereco" class="tabcontent">
                        <br />
                        <div class="form-group{{ $errors->has('cep') ? ' has-error' : '' }}">
                            <label for="cep" class="text-normal text-dark">CEP</label>
                            <input id="cep" type="text" class="form-control" name="cep" value="{{ old('cep') }}" required>

                            @if ($errors->has('cep'))
                                <span class="form-text text-danger">
                                    <small>{{ $errors->first('cep') }}</small>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('endereco') ? ' has-error' : '' }}">
                            <label for="endereco" class="text-normal text-dark">Endereço</label>
                            <input id="endereco" type="text" class="form-control" name="endereco" value="{{ old('endereco') }}" required>

                            @if ($errors->has('endereco'))
                                <span class="form-text text-danger">
                                    <small>{{ $errors->first('endereco') }}</small>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('numero') ? ' has-error' : '' }}">
                            <label for="numero" class="text-normal text-dark">Número</label>
                            <input id="numero" type="text" class="form-control" name="numero" value="{{ old('numero') }}" required>

                            @if ($errors->has('numero'))
                                <span class="form-text text-danger">
                                    <small>{{ $errors->first('numero') }}</small>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('complemento') ? ' has-error' : '' }}">
                            <label for="complemento" class="text-normal text-dark">Complemento</label>
                            <input id="complemento" type="text" class="form-control" name="complemento" value="">

                            @if ($errors->has('complemento'))
                                <span class="form-text text-danger">
                                    <small>{{ $errors->first('complemento') }}</small>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('bairro') ? ' has-error' : '' }}">
                            <label for="bairro" class="text-normal text-dark">Bairro</label>
                            <input id="bairro" type="text" class="form-control" name="bairro" value="{{ old('bairro') }}" required>

                            @if ($errors->has('bairro'))
                                <span class="form-text text-danger">
                                    <small>{{ $errors->first('bairro') }}</small>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('cidade') ? ' has-error' : '' }}">
                            <label for="cidade" class="text-normal text-dark">Cidade</label>
                            <input id="cidade" type="text" class="form-control" name="cidade" value="{{ old('cidade') }}" required>

                            @if ($errors->has('cidade'))
                                <span class="form-text text-danger">
                                    <small>{{ $errors->first('cidade') }}</small>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('uf') ? ' has-error' : '' }}">
                            <label for="uf" class="text-normal text-dark">Estado</label>
                            <input id="uf" type="uf" class="form-control" name="uf" value="{{ old('uf') }}" required>

                            @if ($errors->has('uf'))
                                <span class="form-text text-danger">
                                    <small>{{ $errors->first('uf') }}</small>
                                </span>
                            @endif
                        </div>


                    </div>
                    <!-- =======================================END TAB PESSOAL================================================================= -->

                    <!-- =======================================TAB CONTATO ================================================================= -->
                <!--    <div id="Contato" class="tabcontent">
                        <br />
                        <div class="form-group{{ $errors->has('celular') ? ' has-error' : '' }}">
                            <label for="celular" class="text-normal text-dark">Celular</label>
                            <input id="celular" type="text" class="form-control" name="celular" value="{{ old('celular') }}" required>

                            @if ($errors->has('celular'))
                            <span class="form-text text-danger">
                                <small>{{ $errors->first('celular') }}</small>
                            </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('telefone') ? ' has-error' : '' }}">
                            <label for="telefone" class="text-normal text-dark">Telefone</label>
                            <input id="telefone" type="text" class="form-control" name="telefone" value="{{ old('telefone') }}">

                            @if ($errors->has('telefone'))
                            <span class="form-text text-danger">
                                <small>{{ $errors->first('telefone') }}</small>
                            </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('telefone2') ? ' has-error' : '' }}">
                            <label for="telefone2" class="text-normal text-dark">Telefone 2</label>
                            <input id="telefone2" type="text" class="form-control" name="telefone2" value="{{ old('telefone2') }}">

                            @if ($errors->has('telefone2'))
                            <span class="form-text text-danger">
                                <small>{{ $errors->first('telefone2') }}</small>
                            </span>
                            @endif
                        </div>
                    </div> -->
                    <!-- =======================================END TAB CONTATO================================================================= -->

                     <!-- =======================================TAB USUARIO ================================================================= -->
                    <div id="Usuario" class="tabcontent">
                        <br />
                        <div class="form-group{{ $errors->has('usu') ? ' has-error' : '' }}">
                            <label for="usu" class="text-normal text-dark">Usuário</label>
                            <input id="usu" type="text" class="form-control" name="usu" value="{{ old('usu') }}" required>

                            @if ($errors->has('usu'))
                                <span class="form-text text-danger">
                                    <small>{{ $errors->first('usu') }}</small>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="text-normal text-dark">Senha</label>
                            <input autocomplete="off" id="password" type="password" class="form-control" name="password" required>

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
                     <!-- =======================================BOTÕES ================================================================= -->
                    <div class="form-group">
                        <div class="peers ai-c jc-sb fxw-nw">
                            <div class="peer">
                                <a href="/login">Retornar para home</a>
                            </div>
                            <div class="peer">
                                <button class="btn btn-primary">{{ trans('app.add_button') }}</button>
                            </div>
                        </div>
                    </div>
                     <!-- =======================================END BOTÕES ================================================================= -->
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
    <script type="text/javascript" src="{!! asset('/js/pessoa/tab.js') !!}"></script>
@endpush
