@extends('layouts.basico')

@section('page-header')
    Editar Paciente <small>Clique na abas para inserir as informações</small>
@stop


@section('content')
    <div class="row mB-40">
        <div class="col-sm-8">
            <div class="bgc-white p-20 bd">

                <div class="tab">
                    <button class="tablinks" onclick="openCity(event, 'Pessoal')">Paciente</button>
                    <button class="tablinks" onclick="openCity(event, 'Endereco')">Endereço</button>
                <!--    <button class="tablinks" onclick="openCity(event, 'Contato')">Contato</button>-->
                    <button class="tablinks" onclick="openCity(event, 'Usuario')">Usuário</button>
                </div>
                <form id="formCadastro" method="POST" action="/vida/put/pessoa/{{$paciente->id}}">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="PUT" />
                    <input type="hidden" id="tipo" name="tipo" value="2">
                    <!-- =======================================TAB PESSOAL================================================================= -->
                    <div id="Pessoal" class="tabcontent">
                        <h3>Pessoal</h3>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="text-normal text-dark">Nome</label>
                            <input id="name" type="text" class="form-control" name="name" value="{{ $paciente->name }}"  autofocus>

                            @if ($errors->has('name'))
                                <span class="form-text text-danger">
                                    <small>{{ $errors->first('name') }}</small>
                            </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('nim') ? ' has-error' : '' }}">
                            <label for="nim" class="text-normal text-dark">Nim</label>
                            <input id="nim" type="text" class="form-control" name="nim" value="{{ $paciente->nim ?? isset($paciente->titular) ? $paciente->titular->nim . "." . $paciente->ordem : ''}}" >

                            @if ($errors->has('nim'))
                                <span class="form-text text-danger">
                                    <small>{{ $errors->first('nim') }}</small>
                            </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('documento') ? ' has-error' : '' }}">
                            <label for="documento" class="text-normal text-dark">Documento</label>
                            <input id="documento" type="text" class="form-control" name="documento" value="{{ $paciente->cnpjcpf }}" >

                            @if ($errors->has('documento'))
                                <span class="form-text text-danger">
                                    <small>{{ $errors->first('documento') }}</small>
                                </span>
                            @endif
                        </div>


                        <div class="form-group{{ $errors->has('data_nasc') ? ' has-error' : '' }}">
                            <label for="data_nasc" class="text-normal text-dark">Data Nascimento</label>
                            <input id="data_nasc" type="date" class="form-control" name="data_nasc" value="{{ $paciente->paciente->data_nascimento }}" >

                            @if ($errors->has('data_nasc'))
                                <span class="form-text text-danger">
                                    <small>{{ $errors->first('data_nasc') }}</small>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('profissao') ? ' has-error' : '' }}">
                            <label for="profissao" class="text-normal text-dark">Profissão</label>
                            <input id="profissao" type="text" class="form-control" name="profissao" value="{{ $paciente->paciente->profissao }}" >

                            @if ($errors->has('profissao'))
                                <span class="form-text text-danger">
                                    <small>{{ $errors->first('profissao') }}</small>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('end_eletronico') ? ' has-error' : '' }}">
                            <label for="end_eletronico" class="text-normal text-dark">E-mail</label>
                            <input id="end_eletronico" type="end_eletronico" class="form-control" name="end_eletronico" value="{{ $paciente->email }}" >

                            @if ($errors->has('end_eletronico'))
                                <span class="form-text text-danger">
                                    <small>{{ $errors->first('end_eletronico') }}</small>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('telefone') ? ' has-error' : '' }}">
                            <label for="telefone" class="text-normal text-dark">Telefone</label>
                            <input id="telefone" type="text" class="form-control" name="telefone" value="{{ $paciente->telefone }}" >

                            @if ($errors->has('telefone'))
                                <span class="form-text text-danger">
                                    <small>{{ $errors->first('telefone') }}</small>
                            </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('telefone2') ? ' has-error' : '' }}">
                            <label for="telefone2" class="text-normal text-dark">Telefone Secundário</label>
                            <input id="telefone2" type="text" class="form-control" name="telefone2" value="{{ $paciente->telefone2 }}" >

                            @if ($errors->has('telefone2'))
                                <span class="form-text text-danger">
                                    <small>{{ $errors->first('telefone2') }}</small>
                            </span>
                            @endif
                        </div>

                        <br>
                        <table id="myDependenteTable" class="table table-striped">
                            @if(count($paciente->dependente) > 0)
                                <h5>Dependentes</h5>
                                @foreach($paciente->dependente as $dependente)
                                    <tr>
                                        <td>{{ $dependente->name }}</td>
                                        <td>{{ $dependente->cnpjcpf }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </table>

                        <br>
                        <table id="myTable" class="table table-striped">
                            @if(!is_null($paciente->titular))
                                <h5>Titular</h5>
                                <tr>
                                    <td>{{ $paciente->titular->id }}</td>
                                    <td>{{ $paciente->titular->name }}</td>
                                    <td>{{ $paciente->titular->cnpjcpf }}</td>
                                </tr>
                            @endif
                        </table>

                    </div>
                    <!-- =======================================END TAB PESSOAL================================================================= -->
                    <!-- =======================================TAB ENDEREÇO================================================================= -->
                    <div id="Endereco" class="tabcontent">
                        <br />
                        <div class="form-group{{ $errors->has('cep') ? ' has-error' : '' }}">
                            <label for="cep" class="text-normal text-dark">CEP</label>
                            <input id="cep" type="text" class="form-control" name="cep" value="{{ $paciente->endereco->cep }}" >

                            @if ($errors->has('cep'))
                                <span class="form-text text-danger">
                                    <small>{{ $errors->first('cep') }}</small>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('endereco') ? ' has-error' : '' }}">
                            <label for="endereco" class="text-normal text-dark">Endereço</label>
                            <input id="endereco" type="text" class="form-control" name="endereco" value="{{ $paciente->endereco->endereco }}" >

                            @if ($errors->has('endereco'))
                                <span class="form-text text-danger">
                                    <small>{{ $errors->first('endereco') }}</small>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('numero') ? ' has-error' : '' }}">
                            <label for="numero" class="text-normal text-dark">Número</label>
                            <input id="numero" type="text" class="form-control" name="numero" value="{{ $paciente->endereco->numero }}" >

                            @if ($errors->has('numero'))
                                <span class="form-text text-danger">
                                    <small>{{ $errors->first('numero') }}</small>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('complemento') ? ' has-error' : '' }}">
                            <label for="complemento" class="text-normal text-dark">Complemento</label>
                            <input id="complemento" type="text" class="form-control" name="complemento" value="{{ $paciente->endereco->complemento }}">

                            @if ($errors->has('complemento'))
                                <span class="form-text text-danger">
                                    <small>{{ $errors->first('complemento') }}</small>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('bairro') ? ' has-error' : '' }}">
                            <label for="bairro" class="text-normal text-dark">Bairro</label>
                            <input id="bairro" type="text" class="form-control" name="bairro" value="{{ $paciente->endereco->bairro }}" >

                            @if ($errors->has('bairro'))
                                <span class="form-text text-danger">
                                    <small>{{ $errors->first('bairro') }}</small>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('cidade') ? ' has-error' : '' }}">
                            <label for="cidade" class="text-normal text-dark">Cidade</label>
                            <input id="cidade" type="text" class="form-control" name="cidade" value="{{ $paciente->endereco->cidade }}" >

                            @if ($errors->has('cidade'))
                                <span class="form-text text-danger">
                                    <small>{{ $errors->first('cidade') }}</small>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('uf') ? ' has-error' : '' }}">
                            <label for="uf" class="text-normal text-dark">Estado</label>
                            <input id="uf" type="uf" class="form-control" name="uf" value="{{ $paciente->endereco->UF }}" >

                            @if ($errors->has('uf'))
                                <span class="form-text text-danger">
                                    <small>{{ $errors->first('uf') }}</small>
                                </span>
                            @endif
                        </div>


                    </div>
                    <!-- =======================================END TAB ENDERECO================================================================= -->
                    <!-- =======================================TAB CONTATO ================================================================= -->
                <!--       <div id="Contato" class="tabcontent">
                        <br />
                        <div class="form-group{{ $errors->has('celular') ? ' has-error' : '' }}">
                            <label for="celular" class="text-normal text-dark">Celular</label>
                            <input id="celular" type="text" class="form-control" name="celular" value="{{ old('celular') }}" >

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
                        <h3>Usuário</h3>
                        <div class="form-group{{ $errors->has('usu') ? ' has-error' : '' }}">
                            <label for="usu" class="text-normal text-dark">Usuário</label>
                            <input id="usu" type="text" class="form-control" name="username" value="{{ $paciente->username }}" >

                            @if ($errors->has('usu'))
                                <span class="form-text text-danger">
                            <small>{{ $errors->first('usu') }}</small>
                        </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="text-normal text-dark">Senha</label>
                            <input id="password" type="password" class="form-control" name="password" >

                            @if ($errors->has('password'))
                                <span class="form-text text-danger">
                            <small>{{ $errors->first('password') }}</small>
                        </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="text-normal text-dark">Confirmar Senha</label>
                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" >

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
                                <button type="submit" class="btn btn-primary">Cadastrar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>





@endsection

@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
    <script type="text/javascript" src="{!! asset('/js/pessoa/tab.js') !!}"></script>
@endpush
