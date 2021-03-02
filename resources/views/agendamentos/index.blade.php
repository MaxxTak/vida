@extends('layouts.basico')

@section('page-header')
    Agendamentos <small>{{ trans('app.manage') }}</small>
@endsection


@section('content')

    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        {!! Form::mySelect('paciente_id', 'Paciente', $pacientes, null, ['name' => 'paciente_id']) !!}
        {!! Form::mySelect('profissional_id', 'Profissional', $profissionais, null, ['name' => 'profissional_id']) !!}
        {!! Form::mySelect('sala_id', 'Sala', $salas, null, ['name' => 'sala_id']) !!}
        {!! Form::mySelect('guia_id', 'Guias', [], null, ['name' => 'guia_id']) !!}
        {!! Form::mySelect('procedimento_id', 'Procedimentos', [], null, ['name' => 'procedimento_id']) !!}
    </div>

    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <div class="row">
            <div class="col-md-12" id="div-calendario">
                <div id="calendario"></div>
            </div>
        </div>
    </div>

    {{-- Criar Agendamento --}}
    <div class="modal fade" id="criarAgendamento">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="bd p-15">
                <h5 class="m-0">Criar Agendamento</h5>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label class="fw-500">Paciente:</label>
                        {!! Form::mySelect('paciente', null, $pacientes, null, ['name' => 'paciente', 'id' => 'paciente']) !!}          
                        {{-- <input id="paciente" type="text" class="form-control" name="paciente"> --}}
                    </div>
                    <div class="form-group">
                        <label class="fw-500">Profissional:</label>
                        {!! Form::mySelect('profissional', null, $profissionais, null, ['name' => 'profissional', 'id' => 'profissional']) !!}
                        {{-- <input id="profissional" type="text" class="form-control" name="profissional" disabled> --}}
                    </div>
                    <div class="form-group">
                        <label class="fw-500">Sala:</label>
                        {!! Form::mySelect('sala', null, $salas, null, ['name' => 'sala', 'id' => 'sala']) !!}
                        {{-- <input id="sala" type="text" class="form-control" name="sala" disabled> --}}
                    </div>
                    <div class="form-group">
                        <label class="fw-500">Guia:</label>
                        {!! Form::mySelect('guia', null, [], null, ['name' => 'guia', 'id' => 'guia']) !!}
                        {{-- <input id="guia" type="text" class="form-control" name="guia" disabled> --}}
                    </div>
                    <div class="form-group">
                        <label class="fw-500">Procedimento:</label>
                        {!! Form::mySelect('procedimento', null, [], null, ['name' => 'procedimento', 'id' => 'procedimento']) !!}
                        {{-- <input id="guia" type="text" class="form-control" name="guia" disabled> --}}
                    </div>
                    <div class="form-group">
                        <label class="fw-500">Início:</label>
                        <input id="data_inicio" type="datetime-local" class="form-control" name="data_inicio" required>
                    </div>
                    <div class="form-group">
                        <label class="fw-500">Fim:</label>
                        <input id="data_fim" type="datetime-local" class="form-control" name="data_fim" required>
                    </div>
                    <div class="form-group">
                        <label class="fw-500">Observação:</label>
                        <input id="observacao" type="text" class="form-control" name="observacao" required>
                    </div>
                    <div class="form-group">
                    </div>
                    <div class="text-right">
                        <button class="btn btn-success cur-p" id="btnAgendar">Agendar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Criar Agendamento --}}

    {{-- Fechar Agenda --}}
    <div class="modal fade" id="fecharAgenda">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="bd p-15">
                <h5 class="m-0">Fechar Agenda</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="fw-500">Profissional:</label>
                        {!! Form::mySelect('profissional_allday', null, $profissionais, null, ['name' => 'profissional_allday', 'id' => 'profissional_allday']) !!}
                        {{-- <input id="profissional" type="text" class="form-control" name="profissional" disabled> --}}
                    </div>
                    <div class="form-group">
                        <label class="fw-500">Início:</label>
                        <input id="data_inicio_allday" type="date" class="form-control" name="data_inicio_allday" required>
                    </div>
                    <div class="form-group">
                        <label class="fw-500">Observação:</label>
                        <input id="observacao_allday" type="text" class="form-control" name="observacao_allday" required>
                    </div>
                    <div class="form-group">
                    </div>
                    <div class="text-right">
                        <button class="btn btn-success cur-p" id="btnFecharAgendamento">Fechar Agendamento</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Fechar Agenda --}}

    {{-- Eventos --}}
    <div class="modal fade" id="eventos">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="bd p-15">
                <h5 class="m-0">Agendamento</h5>
                </div>
                <div class="modal-body">
                    <div class="tab">
                        <button id="btnTabSituacao" class="tablinks active" onclick="openTab(event, 'Situacao')">Situação</button>
                        <button id="btnTabFinalizar" class="tablinks" onclick="openTab(event, 'Finalizar')">Finalizar</button>
                        <button id="btnTabConsulta" class="tablinks">Consulta</button>
                    </div>
                    <div id="Situacao" class="tabcontent" style="display: block;">
                        <fieldset class="form-group">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="situacao" id="confirmar" value="C" checked>
                                    Confirmar
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="situacao" id="paciente_presente" value="P">
                                    Check-In Paciente
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="situacao" id="falta" value="T">
                                    Falta
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="situacao" id="reabrir" value="A">
                                    Reabrir
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="situacao" id="cancelar" value="X">
                                    Cancelar
                                </label>
                            </div>
                        </fieldset>
                        <div class="text-right">
                            <button class="btn btn-success cur-p" id="btnSalvarSituacao">Salvar</button>
                        </div>
                    </div>
                    <div id="Finalizar" class="tabcontent">
                        <table id="tabela-procedimentos-guia" class="table table-striped" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Descrição</th>
                                    <th>Obs</th>
                                    <th>Opções</th>
                                </tr>
                            </thead>
                        </table>

                        <div class="text-right">
                            <button class="btn btn-success cur-p" id="btnFinalizarAgendamento">Finalizar</button>
                        </div>
                    </div>
                    <div id="Consulta" class="tabcontent">
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Eventos --}}

    {{-- Criar Pre Cadastro Paciente --}}
    <div class="modal fade" id="criarPreCadastroPaciente">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="bd p-15">
                <h5 class="m-0">Pré-Cadastrar Paciente</h5>
                </div>
                <div class="modal-body">

                    <form id="formCadastro" method="POST" action="/vida/registrar" autocomplete="false">
                        {{ csrf_field() }}
                        <input type="hidden" id="pre_cadastro" name="pre_cadastro" value="true">
                        <input type="hidden" id="tipo" name="tipo" value="2">
                        <input type="hidden" id="end_eletronico" name="end_eletronico" value="">
                        <input type="hidden" id="data_nasc" name="data_nasc" value="">
                        <input type="hidden" id="documento" name="documento" value="">
                        <input type="hidden" id="usu" name="usu" value="">
                        <input type="hidden" id="password" name="password" value="123456">
                        <input type="hidden" id="password_confirmation" name="password_confirmation" value="123456">
                        <div class="form-group">
                            <label class="fw-500" for="name">Nome:</label>
                            <input id="name" type="text" class="form-control" name="name" required autofocus>
                        </div>
                        <div class="form-group">
                            <label class="fw-500" for="telefone">Telefone:</label>
                            <input id="telefone" type="text" class="form-control" name="telefone" required>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-success cur-p" id="btnPreCadastrar">Cadastrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Criar Pre Cadastro Paciente --}}
@endsection
@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/funcoes.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/fullcalendar.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/fullcalendar-pt-br.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/agendamentos/index.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/sweetalert2.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/select2.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/tab.js') !!}"></script>
@endpush