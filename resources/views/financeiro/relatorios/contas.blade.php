@extends('layouts.basico')

@section('page-header')
    Permissões <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        {{ Form::open(['/vida/relatorio/contas', 'method' => 'GET']) }}
        {!! Form::mySelect('cod_pessoa', 'Pessoa', $pessoas, null, ['name' => 'cod_pessoa']) !!}
        {!! Form::mySelect('status', 'Status', \App\Models\Financeiro\Parcela::STATUS, null, ['name' => 'status']) !!}
        {!! Form::myInput('date', 'data_inicio', 'Data Cadastro Inicial') !!}
        {!! Form::myInput('date', 'data_fim', 'Data Cadastro Final') !!}
        <button type="submit" class="btn btn-primary">Pesquisar</button>
        {{ Form::close() }}
    </div>
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        @if(count($retorno))
            <div id="accordion-container">
                <div>
                    <table id="empresas" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Data Vencimento</th>
                                <th>Pessoa</th>
                                <th>Forma de Pagamento</th>
                                <th>Valor</th>
                                <th>Taxa</th>
                                <th>Status</th>
                                <th>Cód. Movimentação</th>
                                <th>Número Parcela</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Data Vencimento</th>
                                <th>Pessoa</th>
                                <th>Forma de Pagamento</th>
                                <th>Valor</th>
                                <th>Taxa</th>
                                <th>Status</th>
                                <th>Cód. Movimentação</th>
                                <th>Número Parcela</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        @foreach($retorno['parcelas'] as $parcela)
                            <tr>
                                <td>{{$parcela->id}}</td>
                                <td>{{$parcela->data_vencimento}}</td>
                                <td>{{$parcela->name}}</td>
                                <td>{{$parcela->forma_pagamento}}</td>
                                <td>{{ $parcela->valor }}</td>
                                <td>{{ $parcela->taxa }}</td>
                                <td>{{ \App\Models\Financeiro\Parcela::STATUS[$parcela->status] }}</td>
                                <td>{{ $parcela->movimentacao_id }}</td>
                                <td>{{ $parcela->numero_parcela }}/{{ $parcela->total_parcelas }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <h3>Vazio</h3>
        @endif
    </div>
@endsection

@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
@endpush
