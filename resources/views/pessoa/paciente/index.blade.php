@extends('layouts.basico')

@section('content')
             <h2>Paciente</h2>
             <div class="peer mB-40">
                 <a href="/vida/registrar?tipo=2">
                     <button class="btn btn-primary">Cadastrar Novo</button>
                 </a>
             </div>
             <div class="row mB-40">
                 <div class="col-sm-12">
                     <div class="bgc-white p-20 bd">
                         {{ Form::open(array('url' => '/vida/pessoa/pesquisar')) }}

                         {!! Form::myInput('number', 'id', 'ID', ['min' => 0, 'step' => 1]) !!}

                         {!! Form::myInput('text', 'nim', 'Nim') !!}

                         {!! Form::myInput('text', 'nome', 'Nome') !!}

                         {!! Form::myInput('text', 'documento', 'Documento') !!}

                         {!! Form::myInput('number', 'titular', 'ID Titular') !!}

                         {!! Form::mySelect('status', 'Status', array(
                                            '' => 'Selecione',
                                            '1' => 'Ativo',
                                            '0' => 'Inativo',
                                        )) !!}

                         <button type="submit" class="btn btn-success">Pesquisar</button>

                         {{ Form::close() }}<br>
                     </div>
                 </div>
             </div>

             @if(count($pacientes))
                 <div id="accordion-container">
                     <h2 class="accordion-header aprovar_func">
                         <p>Pacientes Cadastrados</p>
                     </h2>
                     <div>
                         <table id="empresas" class="table table-striped" style="width:100%">
                             <thead>
                             <tr>
                                 <th>ID</th>
                                 <th>Nome</th>
                                 <th>Documento</th>
                                 <th>Nim</th>
                                 <th>Titular</th>
                                 <th>Status</th>
                                 <th>Opções</th>
                             </tr>
                             </thead>
                             <tbody>
                             @foreach($pacientes as $paciente)
                                 <tr>
                                     <td>{{ $paciente->id }}</td>
                                     <td>{{ $paciente->name }}</td>
                                     <td>{{ $paciente->cnpjcpf }}</td>
                                     @if(!is_null($paciente->nim))
                                        <td>{{ !is_null($paciente->ordem) ? $paciente->nim . "." . $paciente->ordem : $paciente->nim}}</td>
                                     @else
                                         <td> @if(isset($paciente->titular['nim'])){{ $paciente->titular['nim'] }} @if(isset($paciente->ordem)){{".".$paciente->ordem}} @else <p></p> @endif @else -- @endif </td>
                                     @endif
                                     @if(count($paciente->titular)>0)
                                        <td>{{ $paciente->titular['name'] }}</td>
                                     @else
                                         <td> -- </td>
                                     @endif
                                     <td> @if($paciente->status==0) Inativo @else Ativo @endif</td>
                                     <td>
                                         <ul class="list-inline">
                                             <li class="list-inline-item">
                                                 <a href="/vida/pessoa/edit/{{$paciente->id}}?tipo=2" title="{{ trans('app.edit_title') }}" class="btn btn-primary btn-sm"><span class="ti-pencil"></span></a>
                                             </li>
                                             <li class="list-inline-item">
                                                 <a title="Adicionar Dependente" class="btn btn-warning btn-sm" onclick="setarId({{$paciente->id}})" data-toggle="modal" data-target="#myModal"><span class="ti-list"></span></a>
                                             </li>
                                             <li class="list-inline-item">
                                                 <a id="permissao-button"  name ="permissao-button" title="Ver Permissões" class="btn btn-info btn-sm" onclick="abrirPermissoes({{$paciente->id}})"><span class="ti-info"></span></a>
                                             </li>
                                             <li class="list-inline-item">
                                                 <a id="inativar-button"  name ="inativar-button" title="Inativar" class="btn btn-outline-danger btn-sm" onclick="inativarPessoa({{$paciente->id}})"><span class="ti-info"></span></a>
                                             </li>
                                             <li class="list-inline-item">
                                                 {!! Form::open([
                                                     'class'=>'delete',
                                                     'url'  => '/vida/deletar/user/{{$paciente->id}}',
                                                     'method' => 'DELETE',
                                                     ])
                                                 !!}

                                                 <button type="submit" class="btn btn-danger btn-sm" title="{{ trans('app.delete_title') }}"><i class="ti-trash"></i></button>

                                                 {!! Form::close() !!}
                                             </li>
                                         </ul>
                                     </td>
                                 </tr>
                             @endforeach
                             </tbody>
                         </table>
                     </div>
                 </div>
             @else
                 <h3>Nada a exibir</h3>
             @endif
             <input id="idTitular" type="hidden" name="contador" value="">
             <!-- The Modal Titular -->
             <div class="modal" id="myModalPermissao">
                 <div class="modal-dialog modal-lg "><!-- modal-dialog-centered -->
                     <div class="modal-content">

                         <!-- Modal Header -->
                         <div class="modal-header">
                             <h4 class="modal-title">Grupo</h4>
                             <button type="button" class="close" data-dismiss="modal">&times;</button>
                         </div>

                         <!-- Modal body -->
                         <div class="modal-body">
                             <table id="myModalTableGrupo" class="table table-striped">

                             </table>
                             <table class="table table-striped">
                                 <thead>
                                 <tr>
                                     <th>Permissões</th>
                                 </tr>
                                 </thead>
                             </table>
                             <table id="myModalTablePermissao" class="table table-striped">

                             </table>


                         </div>
                         <!-- Modal footer -->
                         <div class="modal-footer">
                             <!-- <button  class="btn btn-primary" onclick="myPostParcela()">Create row</button> -->
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
                             <h4 class="modal-title">Adicionar Dependente</h4>
                             <button type="button" class="close" data-dismiss="modal">&times;</button>
                         </div>

                         <!-- Modal body -->
                         <div class="modal-body">
                             <form method="" action="">
                                 <label for="nome" class="text-normal text-dark">Nome ou CPF</label>
                                 <input id="nome_documento" type="text" class="form-control" name="nome" value="{{ old('nome') }}" >
                             </form>
                             <button type="button" class="btn btn-info" id="buscaTitular" onclick="buscarDependente()">
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
    <script type="text/javascript" src="{!! asset('/js/pessoa/pessoa.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/sweetalert2.min.js') !!}"></script>
@endpush
