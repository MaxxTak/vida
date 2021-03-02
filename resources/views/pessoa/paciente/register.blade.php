@extends('layouts.basico')

@section('page-header')
    Cadastro de Paciente <small>Clique na abas para inserir as informações</small>

    <style>
        .form_container_aut {

            padding: 20px;
            border: 1px solid gray;
            margin-top: 10px;
        }
    </style>
@stop


@section('content')
    <div class="row mB-40">
        <div class="col-sm-8">
            <div class="bgc-white p-20 bd">

                     <form id="formCadastro" method="POST" action="/vida/registrar" autocomplete="false">
                         {{ csrf_field() }}
                         <input type="hidden" id="tipo" name="tipo" value="2">
         <!-- =======================================TAB PESSOAL================================================================= -->
                         <div id="Pessoal" class="">
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

                             <div class="form-group{{ $errors->has('nim') ? ' has-error' : '' }}">
                                 <label for="nim" class="text-normal text-dark">Nim</label>
                                 <input id="nim" type="text" class="form-control" name="nim" value="{{ old('nim') }}" >

                                 @if ($errors->has('nim'))
                                     <span class="form-text text-danger">
                                    <small>{{ $errors->first('nim') }}</small>
                            </span>
                                 @endif
                             </div>

                             <div class="form-group{{ $errors->has('documento') ? ' has-error' : '' }}">
                                 <label for="documento" class="text-normal text-dark">Documento</label>
                                 <input id="documento" type="text" class="form-control" name="documento" value="{{ old('documento') }}" required >

                                 @if ($errors->has('documento'))
                                     <span class="form-text text-danger">
                                    <small>{{ $errors->first('documento') }}</small>
                                </span>
                                 @endif
                             </div>


                             <div class="form-group{{ $errors->has('data_nasc') ? ' has-error' : '' }}">
                                 <label for="data_nasc" class="text-normal text-dark">Data Nascimento</label>
                                 <input id="data_nasc" type="date" class="form-control" name="data_nasc" value="{{ old('data_nasc') }}" >

                                 @if ($errors->has('data_nasc'))
                                     <span class="form-text text-danger">
                                    <small>{{ $errors->first('data_nasc') }}</small>
                                </span>
                                 @endif
                             </div>

                             <div class="form-group{{ $errors->has('profissao') ? ' has-error' : '' }}">
                                 <label for="profissao" class="text-normal text-dark">Profissão</label>
                                 <input id="profissao" type="text" class="form-control" name="profissao" value="{{ old('profissao') }}" >

                                 @if ($errors->has('profissao'))
                                     <span class="form-text text-danger">
                                    <small>{{ $errors->first('profissao') }}</small>
                                </span>
                                 @endif
                             </div>

                             <div class="form-group{{ $errors->has('end_eletronico') ? ' has-error' : '' }}">
                                 <label for="end_eletronico" class="text-normal text-dark">E-mail</label>
                                 <input id="end_eletronico" type="end_eletronico" class="form-control" name="end_eletronico" value="{{ old('end_eletronico') }}">

                                 @if ($errors->has('end_eletronico'))
                                     <span class="form-text text-danger">
                                    <small>{{ $errors->first('end_eletronico') }}</small>
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
                             <div class="form-group{{ $errors->has('telefone2') ? ' has-error' : '' }}">
                                 <label for="telefone2" class="text-normal text-dark">Telefone Secundário</label>
                                 <input id="telefone2" type="text" class="form-control" name="telefone2" value="{{ old('telefone2') }}" required>

                                 @if ($errors->has('telefone2'))
                                     <span class="form-text text-danger">
                                    <small>{{ $errors->first('telefone2') }}</small>
                            </span>
                                 @endif
                             </div>
                         </div>

                         <!-- =======================================TAB ENDEREÇO================================================================= -->
                         <div id="Endereco" class="">
                             <h3>Endereço</h3>
                             <br />
                             <div class="form-group{{ $errors->has('cep') ? ' has-error' : '' }}">
                                 <label for="cep" class="text-normal text-dark">CEP</label>
                                 <input id="cep" type="text" class="form-control" name="cep" value="{{ old('cep') }}" >

                                 @if ($errors->has('cep'))
                                     <span class="form-text text-danger">
                                    <small>{{ $errors->first('cep') }}</small>
                                </span>
                                 @endif
                             </div>

                             <div class="form-group{{ $errors->has('endereco') ? ' has-error' : '' }}">
                                 <label for="endereco" class="text-normal text-dark">Endereço</label>
                                 <input id="endereco" type="text" class="form-control" name="endereco" value="{{ old('endereco') }}" >

                                 @if ($errors->has('endereco'))
                                     <span class="form-text text-danger">
                                    <small>{{ $errors->first('endereco') }}</small>
                                </span>
                                 @endif
                             </div>

                             <div class="form-group{{ $errors->has('numero') ? ' has-error' : '' }}">
                                 <label for="numero" class="text-normal text-dark">Número</label>
                                 <input id="numero" type="text" class="form-control" name="numero" value="{{ old('numero') }}" >

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
                                 <input id="bairro" type="text" class="form-control" name="bairro" value="{{ old('bairro') }}" >

                                 @if ($errors->has('bairro'))
                                     <span class="form-text text-danger">
                                    <small>{{ $errors->first('bairro') }}</small>
                                </span>
                                 @endif
                             </div>

                             <div class="form-group{{ $errors->has('cidade') ? ' has-error' : '' }}">
                                 <label for="cidade" class="text-normal text-dark">Cidade</label>
                                 <input id="cidade" type="text" class="form-control" name="cidade" value="{{ old('cidade') }}" >

                                 @if ($errors->has('cidade'))
                                     <span class="form-text text-danger">
                                    <small>{{ $errors->first('cidade') }}</small>
                                </span>
                                 @endif
                             </div>

                             <div class="form-group{{ $errors->has('uf') ? ' has-error' : '' }}">
                                 <label for="uf" class="text-normal text-dark">Estado</label>
                                 <input id="uf" type="uf" class="form-control" name="uf" value="{{ old('uf') }}" >

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
                         </div>-->
                         <!-- =======================================END TAB CONTATO================================================================= -->
                         <!-- =======================================TAB USUARIO ================================================================= -->

                         <div id="Usuario" class="">
                             <h3>Usuário</h3>
                             <div class="form-group{{ $errors->has('usu') ? ' has-error' : '' }}">
                                 <label for="usu" class="text-normal text-dark">Usuário</label>
                                 <input id="usu" type="text" class="form-control" name="usu" value="{{ old('usu') }}" autocomplete="false" >

                                 @if ($errors->has('usu'))
                                     <span class="form-text text-danger">
                            <small>{{ $errors->first('usu') }}</small>
                        </span>
                                 @endif
                             </div>

                             <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                 <label for="password" class="text-normal text-dark">Senha</label>
                                 <input autocomplete="off" id="password" type="password" class="form-control" name="password" autocomplete="false">

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
                         <!-- Button to Open the Modal -->
                         <button id="botaoTitular" type=button class="btn btn-outline-secondary" data-toggle="modal" data-target="#myModal">
                             Titular
                         </button>
                         <!--               <button id="botaoDependente" type=button class="btn btn-outline-dark" data-toggle="modal" data-target="#myDependenteModal">
                                            Dependentes
                                        </button> -->
                         <br>
                         <table id="myDependenteTable" class="table table-striped">

                         </table>
                         <input id="contador" type="hidden" name="contador" value="">
                         <br>
                         <table id="myTable" class="table table-striped">

                         </table>
                         <input id="titular" type="hidden" name="titular" value="">
                         <button id="delete" type=button class="btn btn-danger btn-sm" style="display: none;" onclick="myDeleteFunction()">Delete row</button>
                         <button id="deleteDependente" type=button class="btn btn-danger btn-sm" style="display: none;" onclick="myDeleteDependenteFunction()">Delete</button>


                         <div id="origem" class="origem form_container_aut">

                            <h4>Dependente</h4>
                                 <label for="dep_nome_label" class="text-normal text-dark">Nome</label>
                                 <input id="dep_nome" type="text" class="form-control" name="data[dep_nome][]" value="" >

                             <label for="dep_doc_label" class="text-normal text-dark">Documento</label>
                             <input id="dep_doc" type="text" class="form-control" name="data[dep_doc][]" value="" >

                             <label for="dep_email_label" class="text-normal text-dark">Email</label>
                             <input id="dep_email" type="text" class="form-control" name="data[dep_email][]" value="" >

                                 <label for="dep_nasc_label" class="text-normal text-dark">Data Nascimento</label>
                                 <input id="dep_nasc" type="date" class="form-control" name="data[dep_nasc][]" value="" >

                                 <label for="dep_tel_label" class="text-normal text-dark">Telefone</label>
                                 <input id="dep_tel" type="text" class="form-control" name="data[dep_tel][]" value="" >

                                 <label for="dep_parentesco_label" class="text-normal text-dark">Grau de Parentesco</label>
                                 <input id="dep_parentesco" type="text" class="form-control" name="data[dep_parentesco][]" value="" >

                                 <label for="dep_resp_label" class="text-normal text-dark">Nome Responsável</label>
                                 <input id="dep_resp" type="text" class="form-control" name="data[dep_resp][]" value="" >

                                 <label for="dep_ordem_label" class="text-normal text-dark">Ordem</label>
                                 <input id="dep_ordem" type="text" class="form-control" name="data[dep_ordem][]" value="" >

                             <label for="cep" class="text-normal text-dark">CEP</label>
                             <input id="cep2" type="text" class="form-control" name="data[cep][]" value="" >

                             <label for="endereco" class="text-normal text-dark">Endereço</label>
                             <input id="endereco2" type="text" class="form-control" name="data[endereco][]" value="" >

                             <label for="numero" class="text-normal text-dark">Número</label>
                             <input id="numero2" type="text" class="form-control" name="data[numero][]" value="" >

                             <label for="complemento" class="text-normal text-dark">Complemento</label>
                             <input id="complemento2" type="text" class="form-control" name="data[complemento][]" value="">

                             <label for="bairro" class="text-normal text-dark">Bairro</label>
                             <input id="bairro2" type="text" class="form-control" name="data[bairro][]" value="" >

                             <label for="cidade" class="text-normal text-dark">Cidade</label>
                             <input id="cidade2" type="text" class="form-control" name="data[cidade][]" value="" >

                             <label for="uf" class="text-normal text-dark">Estado</label>
                             <input id="uf2" type="uf" class="form-control" name="data[uf][]" value="" >

                             <br>


                             <img class="btn-remover" src="/images/icon_menos.png" style="cursor: pointer;"></br>
                         </div>
                         <div id="destino" class="destino">
                         </div></br>

                         <img src="/images/icon_add.png" style="cursor: pointer;" onclick="duplicarCampos('origem');"></br>
         <!-- =======================================END TAB PESSOAL================================================================= -->


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

    <!-- The Modal Dependente-->
    <div class="modal" id="myDependenteModal">
        <div class="modal-dialog modal-lg "><!-- modal-dialog-centered -->
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Atribuir dependentes</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form method="" action="">
                        <label for="dep_nome_label" class="text-normal text-dark">Nome</label>
                        <input id="dep_nome" type="text" class="form-control" name="dep_nome" value="" >

                        <label for="dep_nasc_label" class="text-normal text-dark">Data Nascimento</label>
                        <input id="dep_nasc" type="date" class="form-control" name="dep_nasc" value="" >

                        <label for="dep_tel_label" class="text-normal text-dark">Telefone</label>
                        <input id="dep_tel" type="text" class="form-control" name="dep_tel" value="" >

                        <label for="dep_parentesco_label" class="text-normal text-dark">Grau de Parentesco</label>
                        <input id="dep_parentesco" type="text" class="form-control" name="dep_parentesco" value="" >

                        <label for="dep_resp_label" class="text-normal text-dark">Nome Responsável</label>
                        <input id="dep_resp" type="text" class="form-control" name="dep_resp" value="" >

                        <label for="dep_ordem_label" class="text-normal text-dark">Ordem</label>
                        <input id="dep_ordem" type="text" class="form-control" name="dep_ordem" value="" >
                    </form>
                    <br>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="adicionarDependente()" data-dismiss="modal">Create row</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>


    <!-- The Modal Titular -->
    <div class="modal" id="myModal">
        <div class="modal-dialog modal-lg "><!-- modal-dialog-centered -->
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Atribuir um titular</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form method="" action="">
                        <label for="nome" class="text-normal text-dark">Nome ou CPF</label>
                        <input id="nome" type="text" class="form-control" name="nome" value="{{ old('nome') }}" >
                    </form>
                    <button type="button" class="btn btn-info" id="buscaTitular" onclick="buscarTitular()">
                        <span class="glyphicon glyphicon-search"></span> Search
                    </button>
                    <br>
                    <table id="myModalTable" class="table table-striped">

                    </table>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <!--<button class="btn btn-primary" onclick="myCreateFunction()">Create row</button> -->
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
    <script type="text/javascript" src="{!! asset('/js/pessoa/tab.js') !!}"></script>
@endpush
