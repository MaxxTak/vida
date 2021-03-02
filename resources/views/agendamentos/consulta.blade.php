@extends('layouts.basico')

@section('page-header')
    Agendamentos <small>Consulta</small>
@endsection


@section('content')

    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <div class="row">
            <div class="col-md-4">
              <div class="bdrs-3 ov-h bgc-white bd">
                <div class="bgc-deep-purple-500 ta-c p-30">
                  <h1 class="fw-300 mB-5 lh-1 c-white"><span id="data_agendamento" class="fsz-def">18/01/2019 23:00:00</span></h1>
                  <h3 class="c-white" id="paciente">Alexis Heijmeijer</h3>
                </div>

                <div class="pos-r" id="lista_procedimentos">
                  <table id="tabela-procedimentos-guia" class="table table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Descrição</th>
                            <th>Obs</th>
                            <th>Opções</th>
                        </tr>
                    </thead>
                  </table>
                </div>
                <div class="pos-r" id="lista_opcoes">
                  <ul class="m-0 p-0 mT-20">
                    <li class="bdB peers ai-c jc-sb fxw-nw">
                      <button id="btnFinalizarAgendamento" class="btn btn-md btn-success" style="width: 100%;">Finalizar Agendamento</button>
                    </li>
                  </ul>
                </div>


              </div>
            </div>
            <div class="col-md-8">
                <div class="tab">
                    <button id="btnTabPacientes" class="tablinks active" onclick="openTab(event, 'Paciente')">Paciente</button>
                    <button id="btnTabProntuario" class="tablinks" onclick="openTab(event, 'Prontuario')">Prontuário</button>
                    <button id="btnTabHistorico" class="tablinks" onclick="openTab(event, 'Historico')">Histórico</button>
                    <button id="btnTabEvolucao" class="tablinks" onclick="openTab(event, 'Evolucao')">Evolução</button>
                </div>
                <div id="Paciente" class="tabcontent" style="display: block;">
                    
                </div>
                <div id="Prontuario" class="tabcontent">
                    <div class="form-group">
                        {!! Form::mySelect('prontuario', null, $prontuarios, null, ['name' => 'prontuario', 'id' => 'prontuario']) !!}
                    </div>

                    <form id="formProntuario">
                        <div id="prontuario_campos" class="row">
                    
                        </div>
                    </form>
                </div>
                <div id="Historico" class="tabcontent">
                    <div class="form-group">
                        {!! Form::mySelect('historico_prontuario', null, $prontuarios, null, ['name' => 'historico_prontuario', 'id' => 'historico_prontuario']) !!}
                    </div>

                    <div id="historico_prontuario_campos" class="row">
                    
                    </div>	
                </div>
                <div id="Evolucao" class="tabcontent">
                    
                </div>
            </div>
          </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/funcoes.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/agendamentos/consulta.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/sweetalert2.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/select2.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/tab.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/jquery.mask.min.js') !!}"></script>
@endpush