@extends('layouts.basico')

@section('page-header')
    Profissionais <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')
    <div class="mB-20">
        <a href="/vida/registrar?tipo=3" class="btn btn-info">
            {{ trans('app.add_button') }}
        </a>
    </div>
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        @if(count($profissionais))
            <div id="accordion-container">
                <div>
                    <table id="tabela-profissionais" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Documento</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>Documento</th>
                                <th>Opções</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        @foreach($profissionais as $profissional)
                            <tr>
                                <td>{{$profissional->name}}</td>
                                <td>{{$profissional->cnpjcpf}}</td>
                                <td>
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <a href="/vida/pessoa/edit/{{$profissional->id}}?tipo=3" title="{{ trans('app.edit_title') }}" class="btn btn-primary btn-sm"><span class="ti-pencil"></span></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href='profissional_procedimentos?profissional={{$profissional->id}}' title="Procedimentos" class="btn btn-success btn-sm"><span class="ti-write"></span></a>
                                        </li>
                                        <li class="list-inline-item">
                                            @if(!is_null($profissional->titular_id))
                                                <a  title="Editar Titular" class="btn btn-warning btn-sm"><span class="ti-list"></span></a>
                                            @else
                                                <a  title="Adicionar Titular" class="btn btn-warning btn-sm"><span class="ti-list"></span></a>
                                            @endif
                                        </li>
                                        <li class="list-inline-item">
                                            <a id="permissao-button"  name ="permissao-button" title="Ver Permissões" class="btn btn-info btn-sm" onclick="abrirPermissoes({{$profissional->id}})"><span class="ti-info"></span></a>
                                        </li>
                                        <li class="list-inline-item">
                                            {!! Form::open([
                                                'class'=>'delete',
                                                'url'  => '#',
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
            <h3>Nenhum profissional cadastrado</h3>
        @endif
    </div>

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
@endsection

@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
    <script type="text/javascript" src="{!! asset('/js/pessoa/tab.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/pessoa/profissional.js') !!}"></script>
@endpush
