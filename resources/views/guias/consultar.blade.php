@extends('layouts.basico')

@section('page-header')
    Consulta de Guias <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')

    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        {!! Form::mySelect('paciente_id', 'Paciente', $pacientes, null, ['name' => 'paciente_id']) !!}
        {!! Form::mySelect('profissional_id', 'Profissional', $profissionais, null, ['name' => 'profissional_id']) !!}
        {!! Form::mySelect('situacao', 'Situação', [ '' => 'Todos', 'A' => 'Aberto', 'P' => 'Parcial', 'F' => 'Fechado', 'O' => 'Orçamento'], null, ['name' => 'situacao']) !!}
        {!! Form::mySelect('plano_tipo', 'Tipo de Plano', ['' => 'Selecione um plano', 'C' => 'Conveniado', 'P' => 'Particular'], null, ['name' => 'plano_tipo']) !!}
        {!! Form::myInput('date', 'data_cadastro_inicial', 'Data Cadastro Inicial') !!}
        {!! Form::myInput('date', 'data_cadastro_final', 'Data Cadastro Final') !!}
    </div>

    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <h4>Guias</h4>
        <table id="tabela-guias" class="table table-striped" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Paciente</th>
                    <th>Profissional</th>
                    <th>Valor Total</th>
                    <th>Valor Repasse</th>
                    <th>Tipo</th>
                    <th>Opções</th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Paciente</th>
                    <th>Profissional</th>
                    <th>Valor Total</th>
                    <th>Valor Repasse</th>
                    <th>Tipo</th>
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
                    <th>Situação</th>
                    <th>Observação</th>
                    <th>Alterado</th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Quantidade</th>
                    <th>Valor Total</th>
                    <th>Situação</th>
                    <th>Observação</th>
                    <th>Alterado</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <iframe id="impressaoGuia" src="/print/guia.html" style="width:0;height:0;border: 0;border: none;"></iframe>
    <iframe id="impressaoOrcamento" src="/print/guia_orcamento.html" style="width:0;height:0;border: 0;border: none;"></iframe>
@endsection

@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/funcoes.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/qz-tray/escpos.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/sweetalert2.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/guias/consultar.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/guias/print.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/select2.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/qz-tray/rsvp-3.1.0.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/qz-tray/sha-256.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/qz-tray/qz-tray.js') !!}"></script>
@endpush
