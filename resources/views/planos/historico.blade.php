@extends('layouts.basico')

@section('page-header')
    <span id="idPlano">{{ $plano->id . ' - ' . $plano->descricao }}</span> <small>Histórico de Valores</small>
@endsection

@section('content')

    <div class="mB-20">
        <a href="{{ URL::previous() }}" class="btn btn-warning">
            {{ trans('app.back_button') }}
        </a>
    </div>

    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <table id="tabela-planos" class="table table-striped" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Valor</th>
                    <th>Adicional Dependente</th>
                    <th>Usuário</th>
                    <th>Data / Hora</th>
                </tr>
            </thead>
            
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Valor</th>
                    <th>Adicional Dependente</th>
                    <th>Usuário</th>
                    <th>Data / Hora</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ number_format($item->valor, 2) }}</td>
                        <td>{{ number_format($item->adicional_dependente, 2) }}</td>
                        <td>{{ $item->usuario_cadastro . ' - ' . $item->name }}</td>
                        <td>{{ $item->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        
        </table>
    </div>
@endsection
@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
    <script type="text/javascript" src="{!! asset('/js/plano/plano_historico.js') !!}"></script>
@endpush