@extends('layouts.basico')

@section('page-header')
    Relatório de Movimentações <small></small>
@endsection

@section('content')
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        {{ Form::open(['/vida/relatorio/movimentacoes', 'method' => 'GET']) }}
        {!! Form::mySelect('cod_pessoa', 'Pessoa', $pessoas, null, ['name' => 'cod_pessoa']) !!}
        {!! Form::mySelect('status', 'Status', \App\Models\Financeiro\Movimentacao::STATUS, null, ['name' => 'status']) !!}
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
                            <th>Data</th>
                            <th>Pessoa</th>
                            <th>Nim</th>
                            <th>Descrição</th>
                            <th>Valor</th>
                            <th>Desconto</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Data</th>
                            <th>Pessoa</th>
                            <th>Nim</th>
                            <th>Descrição</th>
                            <th>Valor</th>
                            <th>Desconto</th>
                            <th>Status</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($retorno as $parcela)
                            <tr>
                                <td>{{$parcela->id}}</td>
                                <td>{{Carbon\Carbon::parse($parcela->created_at)->format('d/m/Y')}}</td>
                                <td>{{$parcela->name}}</td>
                                <td>{{ is_null($parcela->nim) ? "--" : $parcela->nim}}</td>
                                <td>{{$parcela->descricao}}</td>
                                <td>{{ $parcela->valor }}</td>
                                <td>{{ $parcela->descontos }}</td>
                                <td>{{ \App\Models\Financeiro\Movimentacao::STATUS[$parcela->status] }}</td>
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
