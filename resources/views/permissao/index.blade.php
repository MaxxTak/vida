@extends('layouts.basico')

@section('page-header')
    Permissões <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')
    <div class="mB-20">
        <a href="/vida/permissao/criar" class="btn btn-info">
            {{ trans('app.add_button') }}
        </a>
    </div>
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        @if(count($permissoes))
            <div id="accordion-container">
                <div>
                    <table id="empresas" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Permissões</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>Documento</th>
                                <th>Permissões</th>
                                <th>Opções</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        @foreach($permissoes as $permissao)
                            <tr>
                                <td>{{$permissao->nome}}</td>
                                <td>{{$permissao->descricao}}</td>
                                <td>
                                    @if(isset($permissao->$permissao)))
                                        @foreach($permissao->$permissao as $p)
                                            {{ $p->$permissao->nome }} <br/>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <a href="/edit/{{$permissao->id}}" title="{{ trans('app.edit_title') }}" class="btn btn-primary btn-sm"><span class="ti-pencil"></span></a>
                                        </li>
                                        <li class="list-inline-item">
                                            {!! Form::open([
                                                'class'=>'delete',
                                                'url'  => '#',
                                                'method' => 'DELETE',
                                                ])
                                            !!}
                                                <button class="btn btn-danger btn-sm" title="{{ trans('app.delete_title') }}"><i class="ti-trash"></i></button>
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
            <h3>Nenhuma permissão cadastrada</h3>
        @endif
    </div>
@endsection

@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
    <script type="text/javascript" src="{!! asset('/js/pessoa/empresa.js') !!}"></script>
@endpush
