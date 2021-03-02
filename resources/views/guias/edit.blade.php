@extends('layouts.basico')

@section('page-header')
    Guia <span id="guia_id"></span> <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')

    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        {!! Form::mySelect('paciente_id', 'Paciente', $pacientes, null, ['name' => 'paciente_id', 'disabled']) !!}
        {!! Form::mySelect('plano_tipo', 'Plano', ['C' => 'Conveniado', 'P' => 'Particular'], null, ['name' => 'plano_tipo']) !!}
        {!! Form::mySelect('profissional_id', 'Profissional', $profissionais, null, ['name' => 'profissional_id']) !!}
        {!! Form::mySelect('orcamento', 'Orçamento', ['A' => 'Não', 'O' => 'Sim'], null, ['name' => 'orcamento']) !!}
    </div>

    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <h4>Procedimentos / Profissional</h4>
        <table id="tabela-procedimentos-profissional" class="table table-striped" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Descrição</th>
                    <th>Especialidade</th>
                    <th>Valor</th>
                    <th>Opções</th>
                </tr>
            </thead>
            
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Descrição</th>
                    <th>Especialidade</th>
                    <th>Valor</th>
                    <th>Opções</th>
                </tr>
            </tfoot>
        </table>
    </div>
    
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <h4>Procedimentos / Guia</h4>
        <table id="tabela-procedimentos-guia" class="table table-striped" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Quantidade</th>
                    <th>Valor Total</th>
                    <th>Observação</th>
                    <th>Opções</th>
                </tr>
            </thead>
            
            <tfoot>
                <tr>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Quantidade</th>
                    <th>Valor Total</th>
                    <th>Observação</th>
                    <th>Opções</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="bgc-white bd bdrs-3 p-20 mB-20" style="text-align: center;">
        <button id="btnEnviar" class="btn btn-md btn-success" style="width: 100%;">Gravar</button>
    </div>
@endsection
@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/funcoes.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/sweetalert2.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/guias/edit.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/jquery.mask.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/select2.min.js') !!}"></script>
@endpush