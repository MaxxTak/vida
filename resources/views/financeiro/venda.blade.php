@extends('layouts.basico')

@section('page-header')
   Venda <small>{{ trans('app.manage') }}</small>
@endsection
<link href="{{ asset('/css/compartilhado/select2.min.css') }}" rel="stylesheet">

@section('content')
    <div class="peer">
        @if(is_null($user))
        <a href="/vida/retroativo">
            <button class="btn btn-outline-secondary">Lançar Retroativo</button>
        </a>
        @else
            <a href="/vida/retroativo?user_id={{$user}}">
                <button class="btn btn-outline-secondary">Lançar Retroativo</button>
            </a>
        @endif
    </div>
    <br/>
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <h4>Selecione</h4>
        {!! Form::open(array('url' => '/vida/venda/confirmar')) !!}
        {{ csrf_field() }}
        {!! Form::mySelect('user_id', 'Pessoa', $pessoas, null, ['name' => 'user_id','required']) !!}
        {!! Form::mySelect('plano_id', 'Plano', $planos, null, ['name' => 'plano_id','required']) !!}

        <h4>
            {{ Form::label('_plano', 'Valor Entrada:',['id'=>'_entrada']) }}
            {{ Form::label('valor_entrada', ' 0',['id'=>'valor_entrada']) }}
        </h4>
        <h4>
            {{ Form::label('_plano', 'Valor Plano:',['id'=>'_plano']) }}
            {{ Form::label('valor_plano', ' 0',['id'=>'valor_plano']) }}
        </h4>
        <h4>
            {{ Form::label('_dependentes', 'Dependentes:',['id'=>'_dependentes']) }}
            {{ Form::label('n_dependentes', ' 0',['id'=>'n_dependentes']) }}
        </h4>
        <h4>
            {{ Form::label('_total', 'Total:',['id'=>'_total']) }}
            {{ Form::label('valor_total', ' 0',['id'=>'valor_total']) }}
        </h4>

<br/>

        {!! Form::mySelect('forma_pagamento_id', 'Forma Pagamento da Entrada', $fpg, null, ['name' => 'forma_pagamento_id','required']) !!}

        {!! Form::mySelect('n_parcelas', null, $fpg, null, ['name' => 'n_parcelas', 'style' => 'display: none;','id'=> 'n_parcelas']) !!}

        {!! Form::myInput('date', 'data_pagamento', 'Dia do Vencimento') !!}
        <div class="peer">
            <button type="submit" name="addVenda" id="addVenda" class="btn btn-primary">Adicionar</button>
        </div>

        {{ Form::close() }}
    </div>



@endsection
@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/sweetalert2.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/jquery.mask.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/select2.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/financeiro/fin.js') !!}"></script>
@endpush
