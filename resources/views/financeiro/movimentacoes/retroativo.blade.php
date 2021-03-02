@extends('layouts.basico')

@section('page-header')
   Venda <small>{{ trans('app.manage') }}</small>
@endsection
<link href="{{ asset('/css/compartilhado/select2.min.css') }}" rel="stylesheet">

@section('content')

    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <h4>Selecione</h4>
        {!! Form::open(array('url' => '/vida/venda/retroativa')) !!}
        {{ csrf_field() }}
        {!! Form::mySelect('user_id', 'Pessoa', $pessoas, null, ['name' => 'user_id','required']) !!}
        {!! Form::mySelect('plano_id', 'Plano', $planos, null, ['name' => 'plano_id','required']) !!}
        {{ Form::label('_parcelas', 'Quantidade de parcelas pagas:',['id'=>'_parcelas']) }}
        {!! Form::number('parcelas_pagas', $value='0' , ['min' => '0' ,'class' => 'form-control', 'id' => 'parcelas_pagas']) !!}


        {{ Form::label('_parcelas', 'Quantidade de parcelas restantes:',['id'=>'_parcelas']) }}
        {!! Form::number('n_parcelas', $value='1' , ['min' => '1' ,'class' => 'form-control', 'id' => 'n_parcelas','required']) !!}



<br/>

        {!! Form::mySelect('forma_pagamento_id', 'Forma Pagamento da Entrada', $fpg, null, ['name' => 'forma_pagamento_id','required']) !!}

        <h4>
            {{ Form::label('_parcelas_l', 'Parcelas restantes:',['id'=>'_parcelas_l']) }}
        </h4>

        <table id="parcelas_table" class="table table-striped" style="display: none;">
            <tr>
                <th>#Número</th>
                <th>#Valor</th>
                <th>#Vencimento</th>
            </tr>
        </table>

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
    <script type="text/javascript" src="{!! asset('/js/financeiro/retroativo.js') !!}"></script>
@endpush
