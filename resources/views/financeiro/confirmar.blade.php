@extends('layouts.basico')

@section('page-header')
   Venda <small>{{ trans('app.manage') }}</small>
@endsection
<link href="{{ asset('/css/compartilhado/select2.min.css') }}" rel="stylesheet">

@section('content')

    <div class="bgc-white bd bdrs-3 p-20 mB-20">


        {{ Form::open(array('url' => '/vida/confirmacao')) }}
        {{ Form::hidden('user_id', $user->id, array('id' => 'user_id')) }}
        {{ Form::hidden('plano_id', $plano->id, array('id' => 'plano_id')) }}
        {{ Form::hidden('forma_pagamento', $fpg->id, array('id' => 'forma_pagamento')) }}
        {{ Form::hidden('n_parcelas', $n_parcelas, array('id' => 'n_parcelas')) }}
        {{ Form::hidden('data_pagamento', $data_pagamento, array('id' => 'data_pagamento')) }}
        <table id="tabela-venda" class="table" cellspacing="0" width="100%">
            <tr>
                <td>
                   <h4>{{ $user->name }}</h4>
                </td>
            </tr>
            <tr>
                <td>
                    {{ $plano->descricao }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ $fpg->descricao }}
                </td>
            </tr>
        </table>

        <table id="tabela-parcelas" class="table table-striped" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Número da Parcela</th>
                <th>Forma de Pagamento</th>
                <th>Dia do Vencimento</th>
                <th>Valor Parcelas</th>
                <th>Taxa</th>
                <th>Valor Total</th>
            </tr>
            </thead>
            <tbody>
            @for($i=0; $i< $n_parcelas; $i++)
                <tr>
                    <td>{{ $i + 1}}</td>
                    <td>{{ $fpg->descricao }}</td>
                    <td>{{ $data_pagamento ?? '' }}</td>
                    <td>{{ $valor_parcela }}</td>
                    <td> {{ $fpg->taxa }} %</td>
                    <td> {{ $valor_parcela + ($valor_parcela * ($fpg->taxa / 100)) }} </td>
                </tr>
            @endfor
            </tbody>
        </table>
        <h4>
            {{ Form::label('_total', 'Valor Total: R$',['id'=>'_total']) }}
            {{ Form::label('valor_total', $total,['id'=>'valor_total']) }}
        </h4>

        <div class="peer">
            <button type="submit" name="addVenda" id="addVenda" class="btn btn-primary">Confirmar</button>
        </div>
        {{ Form::close() }}
    </div>


@endsection
@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/sweetalert2.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/jquery.mask.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/select2.min.js') !!}"></script>
@endpush
