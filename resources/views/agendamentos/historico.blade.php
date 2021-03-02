@extends('layouts.basico')

@section('page-header')
    Agendamentos <small> Histórico </small>
@endsection


@section('content')

    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        {!! Form::mySelect('paciente_id', 'Paciente', $pacientes, null, ['name' => 'paciente_id']) !!}
        {!! Form::mySelect('profissional_id', 'Profissional', $profissionais, null, ['name' => 'profissional_id']) !!}
        {!! Form::mySelect('sala_id', 'Sala', $salas, null, ['name' => 'sala_id']) !!}
        {!! Form::mySelect('situacao', 'Situação', [ '' => 'Todos', 'A' => 'Aberto', 'C' => 'Confirmado', 'F' => 'Finalizado', 'T' => 'Falta', 'P' => 'Presente', 'X' => 'Cancelado'], null, ['name' => 'situacao']) !!}
        {!! Form::myInput('date', 'data_inicial', 'Data Inicial') !!}
        {!! Form::myInput('date', 'data_final', 'Data Final') !!}
    </div>

    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <table class="table" id="ag_tabela">
            <thead>
                <tr>
                    <th class="bdwT-0">Paciente</th>
                    <th class="bdwT-0">Profissional</th>
                    <th class="bdwT-0">Sala</th>
                    <th class="bdwT-0">Data</th>
                    <th class="bdwT-0">Início</th>
                    <th class="bdwT-0">Término</th>
                    <th class="bdwT-0">Status</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

@endsection
@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/funcoes.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/agendamentos/historico.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/select2.min.js') !!}"></script>
@endpush