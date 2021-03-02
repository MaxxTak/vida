var agendamento = -1, guia = -1;
var tabela_procedimentos_guia;

function ativaTabSituacao() {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById('Situacao').style.display = "block";
    $('#btnTabSituacao').addClass("active");
}

function getCorAgendamento(situacao) {
    var cor_aberto = '#ffc100',         // Amarelo
        cor_confirmado = 'blue',        // Azul
        cor_finalizado = 'green',       // Verde
        cor_falta = 'red',              // Vermelho
        cor_presente = '#ff4d00';              // 

    if (situacao == 'A')
        return cor_aberto;
    else if (situacao == 'C')
        return cor_confirmado;
    else if (situacao == 'F')
        return cor_finalizado;
    else if (situacao == 'T')
        return cor_falta;
    else if (situacao == 'P')
        return cor_presente;    
}

function getAgendamentos(handleData) {
    var events = [];
    $.ajax({
        url: '/vida/agendamentos/getAgendamentos',
        type: 'POST',
        dataType: 'JSON',
        data: {
            profissional_id: $('#profissional_id').val(),
            paciente_id: $('#paciente_id').val(),
            sala_id: $('#sala_id').val(),
        },
        success: function (data) {
            data['agendamentos'].forEach(element => {
                var allday = element['allDay'];
                var start, end, title;

                var textColor = 'white';
                if(allday){
                    start = moment(element['start']).format('YYYY-MM-DD');
                    end = moment(element['end']).format('YYYY-MM-DD');
                    title = element['profissional'];
                    textColor = 'white';
                }else{
                    start = moment(element['start']).format('YYYY-MM-DD HH:mm:ss');
                    end = moment(element['end']).format('YYYY-MM-DD HH:mm:ss');
                    title = element['paciente'];
                }

                events.push({
                    id: element['id'],
                    title: title,
                    start: start,
                    end: end,
                    allDay: allday,
                    description: element['profissional'],
                    backgroundColor: getCorAgendamento(element['situacao']),
                    textColor: textColor,
                    situacao: element['situacao'],
                    class: 'evento',
                    observacao: element['observacao'],
                    guia_id: element['movimentacao_guia_id'],
                    nim: element['nim'],
                    telefone: element['telefone'],
                    telefone2: element['telefone2']
                });
            });
            handleData(events);
        },
        error: function (response) {
            console.log(response);
            handleData(events);
        }
    });
}

function verificaConflito(allday, handleData) {
    var data_inicio, data_fim, profissional;

    if(allday == 'S'){
        data_inicio = moment($('#data_inicio_allday').val());
        data_fim = moment($('#data_inicio_allday').val());
        profissional = $('#profissional_allday').val();
    }else{
        data_inicio = moment($('#data_inicio').val());
        data_fim = moment($('#data_fim').val());
        profissional = $('#profissional').val();
    }

    $.ajax({
        url: '/vida/agendamentos/verificaConflito',
        type: 'POST',
        dataType: 'JSON',
        data: {
            profissional_id: profissional,
            paciente_id: $('#paciente').val(),
            sala_id: $('#sala').val(),
            start: data_inicio.format('YYYY-MM-DD HH:mm:ss'),
            start_date: data_inicio.format('YYYY-MM-DD'),
            end: data_fim.format('YYYY-MM-DD HH:mm:ss'),
            allday: allday
        },
        success: function (data) {
            handleData(data);
        },
        error: function (response) {
            console.log(response);
            handleData(response);
        }
    });
}

function inicializaCalendario() {
    $('#calendario').fullCalendar({
        defaultView: 'agendaDay',
        header: {
            left: 'prevYear, prev,next today, nextYear, exibeLegenda preCadastro',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listMonth',
        },
        fixedWeekCount: false,
        nowIndicator: true,
        slotLabelFormat: 'HH:mm',
        slotLabelInterval: "00:30",
        slotEventOverlap: false,
        customButtons: {
            exibeLegenda: {
              text: 'Legenda',
              click: function() {
                exibeLegenda();
              }
            },
            preCadastro: {
                text: 'Pré-Cadastro',
                click: function() {
                    var email = randomEmail();
                    $('#end_eletronico').val(email);
                    $('#usu').val(email);
                    $('#documento').val(gerarCpf());
                    $('#criarPreCadastroPaciente').modal('toggle');
                }
            }
        },
        events: function (start, end, timezone, callback) {
            getAgendamentos(function (output) {
                callback(output);
            });
        },
        eventRender: function (event, $element) {
            var inicio = moment(event.start).format('HH:mm:ss');
            var fim = moment(event.end).format('HH:mm:ss');
            var dia_inicio = moment(event.start).format('DD/MM/YYYY');

            if(event.allDay){
                $element.popover({
                    title: dia_inicio + ' - Agenda Fechada',
                    html: true,
                    content: function () {
                        var content = '<b>Profissional: </b>' + event['description'];
    
                        if (!jQuery.isEmptyObject(event['observacao'])) {
                            content += '<br /><b>Obs: </b>' + event['observacao'];
                        }
                        return content;
                    },
                    trigger: 'hover',
                    placement: 'top',
                    container: 'body'
                });
            }else{
                $element.popover({
                    title: inicio + " às " + fim,
                    html: true,
                    content: function () {
                        var content = '<b>Paciente: ' + event['nim'] + '</b> - ' + event['title'] +
                            '<br />' + '<b>Profissional: </b>' + event['description'];
    
                        if (!jQuery.isEmptyObject(event['telefone'])) {
                            content += '<br /><b>Telefone: </b>' + event['telefone'];
                        }
                        if (!jQuery.isEmptyObject(event['telefone2'])) {
                            content += '<br /><b>Telefone 2: </b>' + event['telefone2'];
                        }
                        if (!jQuery.isEmptyObject(event['observacao'])) {
                            content += '<br /><b>Obs: </b>' + event['observacao'];
                        }
                        return content;
                    },
                    trigger: 'hover',
                    placement: 'top',
                    container: 'body'
                });
            }
        },
        dayClick: function (date, jsEvent, view) {
            if(date['_ambigTime']){
                var dia = date.date();
                var mes = date.month() + 1;
                var ano = date.year();

                $('#data_inicio_allday').val(date.format('YYYY-MM-DD')).trigger('change');
                $('#data_fim_allday').val(date.format('YYYY-MM-DD')).trigger('change');

                $('#profissional_allday').val($('#profissional_id').val()).trigger('change');
                $('#fecharAgenda').modal('toggle');

            }else if ((view.name == 'agendaWeek') || (view.name == 'agendaDay')) {
                $('#data_inicio').val(date.format()).trigger('change');
                $('#data_fim').val(date.add(30, 'minutes').format()).trigger('change');

                $('#paciente').val($('#paciente_id').val()).trigger('change');
                $('#profissional').val($('#profissional_id').val()).trigger('change');
                $('#sala').val($('#sala_id').val()).trigger('change');
                $('#guia').val($('#guia_id').val()).trigger('change');
                $('#procedimento').val($('#procedimento_id').val()).trigger('change');

                $('#criarAgendamento').modal('toggle');
            }
        },
        eventClick: function (calEvent, jsEvent, view) {
            agendamento = calEvent['id'];
            guia = calEvent['guia_id'];

            if(calEvent['situacao'] == 'F'){
                $('#btnTabFinalizar').hide();
                $('#btnTabConsulta').hide();
            }else{
                $('#btnTabFinalizar').show();
                $('#btnTabConsulta').show();
            }            
            tabela_procedimentos_guia.clear().draw();
            tabela_procedimentos_guia.ajax.reload();

            $('#eventos').modal('toggle');
            ativaTabSituacao();
        }
    });
}

function efetuaAgendamentoAjax(data_inicio, data_fim, allday){
    var profissional, observacao;

    if(allday == 'S'){
        profissional = $('#profissional_allday').val();
        observacao = $('#observacao_allday').val();
    }else{
        profissional = $('#profissional').val();
        observacao = $('#observacao').val();
    }

    $.ajax({
        url: '/vida/agendamentos',
        type: 'POST',
        dataType: 'JSON',
        data: {
            profissional_id: profissional,
            paciente_id: $('#paciente').val(),
            sala_id: $('#sala').val(),
            start: data_inicio.format('YYYY-MM-DD HH:mm:ss'),
            end: data_fim.format('YYYY-MM-DD HH:mm:ss'),
            guia_id: $('#guia').val(),
            observacao: observacao,
            allday: allday
        },
        success: function (response) {
            if(allday == 'S')
                $('#fecharAgenda').modal('toggle');
            else
                $('#criarAgendamento').modal('toggle');

            $('#calendario').fullCalendar('refetchEvents');
            $('#observacao').val('');
            $('#observacao_allday').val('');

            if(response['retorno_guia']){
                Swal({
                    title: 'Guia criada com sucesso.',
                    html: 'Deseja adicionar procedimentos às guias?',
                    type: 'success',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<span class="ti-check"></span>',
                    cancelButtonText: '<span class="ti-close"></span>',
                    // Form com valores
                    focusConfirm: false,
                }).then((result) => {
                    if(result.value){
                        console.log(response['retorno_guia']);
                        window.open('/vida/guias/editar?paciente_id=' + response['retorno_guia'].paciente_id +
                                                    '&profissional_id=' + response['retorno_guia'].profissional_id +
                                                    '&plano_tipo=null' +
                                                    '&orcamento=A' +
                                                    '&guia_id=' + response['retorno_guia'].id,
                                                    '_blank');
                    }
                });    
            }
        },
        error: function (response) {
            console.log(response);
        }
    });
}

function efetuaAgendamento(data_inicio, data_fim, allday) {
    // Verifica se não há agendamento existente
    verificaConflito(allday, function (result) {
        if (!result['tem_conflito']) {
            efetuaAgendamentoAjax(data_inicio, data_fim, allday);
        }else if (allday != 'S') {
            var agendamento = result['agendamento'][0];
            
            if(agendamento['allDay']){
                Swal({
                    title: 'Período já possui agendamento.',
                    html: '<b>Profissional:</b> ' + agendamento['profissional'] +
                        '<br/><b>Paciente:</b> ' + agendamento['paciente'] +
                        '<br/><b>Sala:</b> ' + agendamento['sala'] +
                        '<br/><b>Início:</b> ' + moment(agendamento['start']).format('DD/MM/YYYY HH:mm:ss') +
                        '<br/><b>Fim:</b> ' + moment(agendamento['end']).format('DD/MM/YYYY HH:mm:ss') +
                        '<br/><b>Obs:</b> ' + agendamento['observacao'],
                    type: 'error',
                });
            }else{
                Swal({
                    title: 'Período já possui agendamento.',
                    html: '<b>Profissional:</b> ' + agendamento['profissional'] +
                        '<br/><b>Paciente:</b> ' + agendamento['paciente'] +
                        '<br/><b>Sala:</b> ' + agendamento['sala'] +
                        '<br/><b>Início:</b> ' + moment(agendamento['start']).format('DD/MM/YYYY HH:mm:ss') +
                        '<br/><b>Fim:</b> ' + moment(agendamento['end']).format('DD/MM/YYYY HH:mm:ss') +
                        '<br/><b>Obs:</b> ' + agendamento['observacao'] +
                        '<br />Deseja efetuar agendamento mesmo assim?.',
                    type: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<span class="ti-check"></span>',
                    cancelButtonText: '<span class="ti-close"></span>',
                    // Form com valores
                    focusConfirm: false,
                }).then((result) => {
                    if(result.value){
                        efetuaAgendamentoAjax(data_inicio, data_fim, allday);
                    }
                });
            }
        }else {
            var agendamento = result['agendamento'][0];
            
            Swal({
                title: 'Período já possui agendamento.',
                html: '<b>Profissional:</b> ' + agendamento['profissional'] +
                    '<br/><b>Paciente:</b> ' + agendamento['paciente'] +
                    '<br/><b>Sala:</b> ' + agendamento['sala'] +
                    '<br/><b>Início:</b> ' + moment(agendamento['start']).format('DD/MM/YYYY HH:mm:ss') +
                    '<br/><b>Fim:</b> ' + moment(agendamento['end']).format('DD/MM/YYYY HH:mm:ss') +
                    '<br/><b>Obs:</b> ' + agendamento['observacao'],
                type: 'error',
            });
        }
    });
}

function exibeLegenda(){
    Swal({
        // type: 'success',
        title: 'Legenda',
        html:   '<div style="background-color: ' + getCorAgendamento('A') + '; border: 0.2px solid black; box-sizing: border-box;"><span style="color: black; font-weight: bold; font-size: 12px; vertical-align: center;">Atendimento Aberto</span></div>' + 
                '<div style="background-color: ' + getCorAgendamento('T') + '; border: 0.2px solid black; box-sizing: border-box;"><span style="color: black; font-weight: bold; font-size: 12px; vertical-align: center;">Falta</span></div>' +
                '<div style="background-color: ' + getCorAgendamento('C') + '; border: 0.2px solid black; box-sizing: border-box;"><span style="color: white; font-weight: bold; font-size: 12px; vertical-align: center;">Atendimento Confirmado</span></div>' +
                '<div style="background-color: ' + getCorAgendamento('P') + '; border: 0.2px solid black; box-sizing: border-box;"><span style="color: black; font-weight: bold; font-size: 12px; vertical-align: center;">Paciente Presente</span></div>' +
                '<div style="background-color: ' + getCorAgendamento('F') + '; border: 0.2px solid black; box-sizing: border-box;"><span style="color: black; font-weight: bold; font-size: 12px; vertical-align: center;">Atendimento Finalizado</span></div>' ,
        toast: true,
        position: 'bottom-left',
        showConfirmButton: false,
    })
}

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Selects
    $("#paciente_id").select2({
        width: '100%'
    });
    $("#profissional_id").select2({
        width: '100%'
    });
    $("#sala_id").select2({
        width: '100%'
    });
    $("#guia_id").select2({
        width: '100%'
    });
    $("#procedimento_id").select2({
        width: '100%'
    });

    $('#paciente').select2({
        width: '100%'
    });
    $("#profissional").select2({
        width: '100%'
    });
    $("#sala").select2({
        width: '100%'
    });
    $("#guia").select2({
        width: '100%'
    });
    $("#procedimento").select2({
        width: '100%'
    });

    $("#profissional_allday").select2({
        width: '100%'
    });

    // Atualiza Calendário
    $('#profissional_id, #paciente_id, #sala_id').on("change", function (e) {
        $('#calendario').fullCalendar('refetchEvents');

        $.ajax({
            url: '/vida/guias/getGuiasPaciente',
            type: 'POST',
            dataType: 'JSON',
            data: {
                profissional_id: $('#profissional_id').val(),
                paciente_id: $('#paciente_id').val(),
                situacao_excluir: 'O',
            },
            success: function (response) {
                $('#guia_id option').remove();
                $('#guia option').remove();

                var guias = response['data'];

                $.each(guias, function (index, value) {

                    var opt = new Option(index + " - " + value, index, false, false);
                    $('#guia_id').append(opt);//.trigger('change');
                });

                $.each(guias, function (index, value) {

                    var opt = new Option(index + " - " + value, index, false, false);
                    $('#guia').append(opt);//.trigger('change');
                });
                $('#guia_id').trigger('change');
            },
            error: function (response) {
                console.log(response);
            }
        });
    });

    // Atualiza Guias
    $('#profissional, #paciente, #sala').on("change", function (e) {
        $.ajax({
            url: '/vida/guias/getGuiasPaciente',
            type: 'POST',
            dataType: 'JSON',
            data: {
                profissional_id: $('#profissional').val(),
                paciente_id: $('#paciente').val(),
                situacao_excluir: 'O',
            },
            success: function (response) {
                $('#guia option').remove();

                var guias = response['data'];

                $.each(guias, function (index, value) {

                    var opt = new Option(index + " - " + value, index, false, false);
                    $('#guia').append(opt);
                });
                $('#guia').trigger('change');
            },
            error: function (response) {
                console.log(response);
            }
        });
    });
    
    // Atualiza Procedimentos
    $('#guia').on("change", function (e) {
        $.ajax({
            url: '/vida/guias/getProcedimentosGuia',
            type: 'POST',
            dataType: 'JSON',
            data: {
                guia_id: $('#guia').val(),
            },
            success: function (response) {
                $('#procedimento option').remove();

                var guias = response['data'];

                $.each(guias, function (index, value) {

                    var opt = new Option(value['id_procedimento'] + " - " + value['procedimento'], value['id_procedimento'], false, false);
                    $('#procedimento').append(opt);
                });
                $('#procedimento').trigger('change');
            },
            error: function (response) {
                console.log(response);
            }
        });
    });

    $('#guia_id').on("change", function (e) {
        $.ajax({
            url: '/vida/guias/getProcedimentosGuia',
            type: 'POST',
            dataType: 'JSON',
            data: {
                guia_id: $('#guia_id').val(),
            },
            success: function (response) {
                $('#procedimento_id option').remove();
                $('#procedimento option').remove();

                var guias = response['data'];

                $.each(guias, function (index, value) {
                    var opt = new Option(value['id_procedimento'] + " - " + value['procedimento'], value['id_procedimento'], false, false);
                    $('#procedimento_id').append(opt);
                });

                $.each(guias, function (index, value) {
                    var opt = new Option(value['id_procedimento'] + " - " + value['procedimento'], value['id_procedimento'], false, false);
                    $('#procedimento').append(opt);
                });
                
                $('#procedimento').trigger('change');
            },
            error: function (response) {
                console.log(response);
            }
        });
    });

    // Atualiza tempo atendimento
    $('#procedimento').on("change", function (e) {
        $.ajax({
            url: '/vida/profissional_procedimentos/getProcedimentoProfissional',
            type: 'POST',
            dataType: 'JSON',
            data: {
                procedimento_id: $('#procedimento').val(),
                profissional_id: $('#profissional').val(),
            },
            success: function (response) {
                if(response){
                    var tempo_atendimento = response['data']['tempo_atendimento'];

                    var data_inicio = moment($('#data_inicio').val());
    
                    if((typeof(tempo_atendimento) != 'undefined') && (tempo_atendimento != 0)){
                        $('#data_fim').val(data_inicio.add(tempo_atendimento, 'minutes').format('YYYY-MM-DDTHH:mm')).trigger('change');
                    }
                }
            },
            error: function (response) {
                console.log(response);
            }
        });
    });
    
    // Calendário
    inicializaCalendario();

    // Legenda
    exibeLegenda();

    // Efetua agendamento
    $('#btnAgendar').on('click', function (e) {
        var data_atual = moment();

        var data_inicio = moment($('#data_inicio').val());
        var data_fim = moment($('#data_fim').val());

        // Verifica preenchimento de informações
        if (!$('#paciente').val()) {
            Swal({
                title: 'Nenhum paciente selecionado.',
                text: 'Selecione um paciente acima.',
                type: 'error'
            });
            return false;
        }

        if (!$('#profissional').val()) {
            Swal({
                title: 'Nenhum profissional selecionado.',
                text: 'Selecione um profissional acima.',
                type: 'error'
            });
            return false;
        }

        if (!$('#sala').val()) {
            Swal({
                title: 'Nenhuma sala selecionada.',
                text: 'Selecione uma sala acima.',
                type: 'error'
            });
            return false;
        }

        // Proíbe agendamento retroativo
        if ((data_inicio < data_atual) || (data_fim < data_atual)) {
            Swal({
                title: 'Intervalo inválido.',
                text: 'Não é permitido agendar para data retroativa. Verifique.',
                type: 'error'
            });

            return false;
        }

        // Verifica se datas são validas
        if (data_inicio.isValid() && data_fim.isValid()) {

            var diff = data_fim.diff(data_inicio);

            // Verifica se intervalo é valido
            if (diff < 0) {
                Swal({
                    title: 'Intervalo inválido.',
                    text: 'Por favor, corrija para continuar o agendamento.',
                    type: 'error'
                });
                return false;
            }

            // Se não tiver guia selecionada, pergunta
            if (jQuery.isEmptyObject($('#guia').val())) {
                Swal({
                    title: 'Nenhuma guia selecionada.',
                    text: 'Esse procedimento irá gerar uma pré guia para o paciente. Confirma?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<span class="ti-check"></span>',
                    cancelButtonText: '<span class="ti-close"></span>',
                    focusConfirm: false,
                }).then((result) => {
                    if (result.value) {
                        efetuaAgendamento(data_inicio, data_fim, 'N');
                    } else
                        return false;
                });
            } else {
                efetuaAgendamento(data_inicio, data_fim, 'N');
            }
        } else {
            Swal({
                title: 'Datas inválidas.',
                text: 'Por favor, corrija para continuar o agendamento.',
                type: 'error'
            });
            return false;
        }
    });

    // Fecha dia agenda profissional
    $('#btnFecharAgendamento').on('click', function (e) {
        var data_atual = moment();

        var data_inicio = moment($('#data_inicio_allday').val());

        // Verifica preenchimento de informações
        if (!$('#profissional_allday').val()) {
            Swal({
                title: 'Nenhum profissional selecionado.',
                text: 'Selecione um profissional acima.',
                type: 'error'
            });
            return false;
        }

        // Proíbe agendamento retroativo
        var diff_inicio = (data_inicio.diff(data_atual, 'days') < 0);

        if (diff_inicio) {
            Swal({
                title: 'Intervalo inválido.',
                text: 'Não é permitido agendar para data retroativa. Verifique.',
                type: 'error'
            });

            return false;
        }

        // Verifica se datas são validas
        if (data_inicio.isValid()) {
            efetuaAgendamento(data_inicio, data_inicio, 'S');
        } else {
            Swal({
                title: 'Datas inválidas.',
                text: 'Por favor, corrija para continuar o agendamento.',
                type: 'error'
            });
            return false;
        }
    });

    // Salva Situação Agendamento
    $('#btnSalvarSituacao').on('click', function (e){
        var situacao = '';

        if($('#confirmar').prop('checked'))
            situacao = 'C';
        else if($('#paciente_presente').prop('checked'))
            situacao = 'P';
        else if($('#falta').prop('checked'))
            situacao = 'T';
        else if($('#finalizar').prop('checked'))
            situacao = 'T';
        else if($('#reabrir').prop('checked'))
            situacao = 'A';
        else if($('#cancelar').prop('checked')){
            // Deleta guia
            Swal({
                title: 'Cancelar',
                text: 'Confirma cancelamento do agendamento?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<span class="ti-check"></span>',
                cancelButtonText: '<span class="ti-close"></span>',
                // Form com valores
                focusConfirm: false,
            }).then((result) => {
                if(result.value){
                    $.ajax({
                        url: '/vida/agendamentos/' + agendamento,
                        type: 'DELETE',
                        dataType: 'JSON',
                        data: {
                            id: agendamento,
                        },
                        success: function (data) {
                            $('#calendario').fullCalendar( 'refetchEvents' );

                            agendamento = -1;
                            $('#eventos').modal('toggle');
                            $('#confirmar').prop('checked', true);
                        },
                    });
                }
            });

            return false;
        }

        // Altera situação guia
        $.ajax({
            url: '/vida/agendamentos/' + agendamento,
            type: 'PUT',
            dataType: 'JSON',
            data: {
                id: agendamento,
                situacao: situacao
            },
            success: function (data) {
                $('#calendario').fullCalendar( 'refetchEvents' );

                $('#eventos').modal('toggle');
                $('#confirmar').prop('checked', true);
            },
        });
    });

    // Finalizar Agendamento
    $('#btnFinalizarAgendamento').on('click', function (e){
        Swal({
            title: 'Finalizar',
            text: 'Confirma finalização do agendamento?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<span class="ti-check"></span>',
            cancelButtonText: '<span class="ti-close"></span>',
            // Form com valores
            focusConfirm: false,
        }).then((result) => {
            if(result.value){
                // Pega procedimentos
                var procedimentos = tabela_procedimentos_guia.rows().data().toArray();

                procedimentos.forEach(element => {
                    element['situacao'] = $('#situacao_' + element['id']).val();
                });

                // Altera situação guia
                $.ajax({
                    url: '/vida/agendamentos/' + agendamento,
                    type: 'PUT',
                    dataType: 'JSON',
                    data: {
                        id: agendamento,
                        situacao: 'F',
                        procedimentos: procedimentos
                    },
                    success: function (data) {
                        $('#calendario').fullCalendar( 'refetchEvents' );

                        $('#eventos').modal('toggle');
                        $('#confirmar').prop('checked', true);
                        // $('#btnTabFinalizar').show();
                        // $('#btnTabSituacao').trigger('click');

                        ativaTabSituacao();
                    },
                });
            }
        });
    });

    // Abrir tela Consulta Agendamento
    $('#btnTabConsulta').on('click', function (e){
        Swal({
            title: 'Consultar',
            text: 'Deseja abrir consulta do agendamento?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<span class="ti-check"></span>',
            cancelButtonText: '<span class="ti-close"></span>',
            // Form com valores
            focusConfirm: false,
        }).then((result) => {
            if(result.value){
                window.open('/vida/agendamentos/consulta?agendamento_id=' + agendamento,'_self');
            }
        });
    });
    
    // Tabela Procedimentos Guia
    tabela_procedimentos_guia = $('#tabela-procedimentos-guia').DataTable({
        responsive: true,
        autoWidth: false,
        ordering: true,
        searching: true,
        ajax: {
            url: '/vida/guias/getProcedimentosGuia',
            type: 'POST',
            dataType: 'JSON',
            data: function (d) {
                d.guia_id = guia;
                d.is_agendamento = true;
            },
        },
        language: {
            paginate: {
                previous: "Anterior",
                next: "Próxima"
            },
            search: "Pesquisar",
            lengthMenu: "Mostrar _MENU_ resultados",
            info: "Mostrando _START_ - _END_ de _TOTAL_ resultados",
            infoEmpty: "Mostrando 0 - 0 de 0 resultados",
            emptyTable: "Nenhum resultado disponível",
            loadingRecords: "Carregando ...",
            zeroRecords: "Nenhum resultado encontrado",
            select: {
                rows: {
                    _: "%d linhas selecionadas",
                    0: "Clique em uma linha para selecionar",
                    1: "1 linha selecionada"
                }
            }
        },
        columns: [
            { data: 'procedimento' },
            { data: 'observacao' },
            { data: '' },
        ],
        columnDefs: [
            {
                targets: 2,
                data: null,
                render: {
                    _: function (data, type, row, meta) {
                        var selectedAberto = '', selectedAndamento = '';

                        if(row['situacao'] == 'A')
                            selectedAberto = 'selected';
                        else if (row['situacao'] == 'P')
                            selectedAndamento = 'selected';

                        return  '<select name="situacao" id="situacao_' + row['id'] + '">' +
                                    '<option value="A" ' + selectedAberto + '>Aberto</option>' +
                                    '<option value="P "' + selectedAndamento + '>Em andamento</option>' +
                                    '<option value="F">Finalizado</option>' +
                                '</select>';
                    },
                    sort: function (data, type, row, meta) {
                        return data;
                    }
                }
            }
        ],
        pageLength: 100,
        dom: "t",
        order: [0, 'asc'],
        createdRow: function (row, data, dataIndex) {
            // if (data['alterado'] == "S") {
            //     $(row).css('color', 'red');
            // }
        },
    });
});