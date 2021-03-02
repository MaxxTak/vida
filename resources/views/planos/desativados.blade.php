@extends('layouts.basico')

@section('page-header')
    Planos <small>Consultar Deletados</small>
@endsection

@section('content')

    <div class="mB-20">
        <a href="{{ route(VIDA . '.planos.create') }}" class="btn btn-info">
            {{ trans('app.add_button') }}
        </a>
    </div>


    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <!--<table id="table-planos" class="table table-striped table-bordered" cellspacing="0" width="100%">-->
        <table id="tabela-planos" class="table table-striped" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Descrição</th>
                    <th>Dependentes</th>
                    <th>Valor</th>
                    <th>Adicional Dependente</th>
                    <th>Entrada</th>
                    <th>Contrato</th>
                    <th>Opções</th>
                </tr>
            </thead>
            
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Descrição</th>
                    <th>Dependentes</th>
                    <th>Valor</th>
                    <th>Adicional Dependente</th>
                    <th>Entrada</th>
                    <th>Contrato</th>
                    <th>Opções</th>
                </tr>
            </tfoot>
            
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td><a href="{{ route(VIDA . '.planos.edit', $item->id) }}">{{ $item->id }}</a></td>
                        <td><a href="{{ route(VIDA . '.planos.edit', $item->id) }}">{{ $item->descricao }}</a></td>
                        <td>{{ $item->dependentes }}</td>
                        <td>{{ number_format($item->valor, 2) }}</td>
                        <td>{{ number_format($item->adicional_dependente, 2) }}</td>
                        <td>{{ $item->entrada }}</td>
                        <td>{{ $item->meses_contrato }}</td>
                        <td>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a href="{{ route(VIDA . '.planos.historico', $item->id) }}" title="Histórico de Valores" class="btn btn-success btn-sm"><span class="ti-list"></span></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="{{ route(VIDA . '.planos.restore', $item->id) }}" title="{{ trans('app.restore_title') }}" class="btn btn-danger btn-sm"><span class="ti-reload"></span></a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        
        </table>
    </div>
@endsection
@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
    <script type="text/javascript" src="{!! asset('/js/plano/plano.js') !!}"></script>
@endpush