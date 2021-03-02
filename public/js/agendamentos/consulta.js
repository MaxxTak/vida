function getAgendamento(handleData){
    // Get Agendamento
    $.ajax({
        url: '/vida/agendamentos/getAgendamento',
        type: 'POST',
        dataType: 'JSON',
        data: {
            agendamento_id: getParameterByName('agendamento_id'),
        },
        success: function (data) {
            handleData(data['agendamento']);
        },
        error: function (response) {
            console.log(response);
            handleData(response);
        }
    });
}

function getProcedimentosGuia(guia_id, handleData){
    // Get Agendamento
    $.ajax({
        url: '/vida/guias/getProcedimentosGuia',
        type: 'POST',
        dataType: 'JSON',
        data: {
            guia_id: guia_id,
            is_agendamento: true,
        },
        success: function (data) {
            handleData(data['data']);
        },
        error: function (response) {
            console.log(response);
            handleData(response);
        }
    });
}

function getTipoCampo(campo_atributos, disabled, handleData){
    var campo = campo_atributos['campo'];
    var descricao = campo_atributos['descricao'];
    var valor = campo_atributos['valor'];

    if(typeof(valor) == 'undefined')
        valor = '';

    switch(campo){
        case 'observacoes':
            handleData( '<div class="form-group col-md-12">' +
                            '<label for="' + campo + '" class="text-normal text-dark">' + descricao + '</label>' +
                            '<textarea id="' + campo + '" class="form-control" rows="5" name="' + campo + '" cols="50" ' + disabled + '>' + valor + '</textarea>' +
                        '</div>');
            break;
        case 'hma':
        case 'tratamentos_previos':
        case 'exames_complementares':
        case 'inspecao':
        case 'palpacao':
        case 'adm_ativa':
        case 'adm_passiva':
        case 'tuc':
        case 'testes_especiais':
            handleData( '<div class="form-group col-md-6">' +
                            '<label for="' + campo + '" class="text-normal text-dark">' + descricao + '</label>' +
                            '<textarea id="' + campo + '" class="form-control" rows="2" name="' + campo + '" cols="50" ' + disabled + '>' + valor + '</textarea>' +
                        '</div>');
            break;
        case 'ocupacao':
        case 'motivo_consulta':
        case 'encaminhado':
        case 'doencas':
        case 'medicamentos':
        case 'atividades_fisicas':
        case 'exames':
        case 'intestino':
        case 'hidratacao':
        case 'peso_atual':
        case 'altura':
        case 'imc':
        case 'percentual_gordura':
        case 'pressao_pulso':
        case 'pressao_arterial':
        case 'ab':
        case 'quadril':
        case 'metas':
        case 'diagnostico_clinico':
        case 'qualidade_dor':
        case 'profundidade_dor':
        case 'frequencia_dor':
        case 't1':
        case 't2':
        case 't3':
        case 'queixa_principal':
            handleData( '<div class="form-group col-md-6">' +
                            '<label for="' + campo + '" class="text-normal text-dark">' + descricao + '</label>' +
                            '<input id="' + campo + '" type="text" class="form-control" name="' + campo + '" value="' + valor + '" ' + disabled + '>' +
                        '</div>');
            break;
        case 'sinais_vitais':
            handleData( '<div class="form-group col-md-6">' +
                            '<label for="' + campo + '" class="text-normal text-dark">' + descricao + '</label>' +
                            '<select id="' + campo + '" class="form-control" name="' + campo + '" value="' + valor + '" ' + disabled + '>' +
                                '<option value="PA">PA</option>' + 
                                '<option value="FC">FC</option>' + 
                            '</select>' +
                        '</div>');
            break;
        default:
            handleData('');
            break;
    }
}

function adicionaMascaraCampo(campo){
    switch(campo){
        case 'peso_atual':
        case 'altura':
        case 'imc':
        case 'percentual_gordura':
        case 'ab':
        case 'quadril': 
            $('#' + campo).mask('#.##0,00', { reverse: true });
            break;
        default:
            break;
    }
}

function montaProntuario(campos){
    $('#prontuario_campos').empty();

    campos.forEach(element => {
        getTipoCampo(element, '', function(campo){
            $('#prontuario_campos').append(campo);
            adicionaMascaraCampo(element['campo']);
        });
    });
}

function montaProntuarioHistorico(campos){
    $('#historico_prontuario_campos').empty();

    campos.forEach(element => {
        getTipoCampo(element, 'disabled', function(campo){
            $('#historico_prontuario_campos').append(campo);
            adicionaMascaraCampo(element['campo']);
        });
    });
}

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var agendamento_id = getParameterByName('agendamento_id');

    // Redireciona pra index
    if(agendamento_id == '')
        window.open('/vida/','_self');
    
    // Select Prontuários
    $("#prontuario").select2({
        width: '100%'
    });

    // Atualiza Prontuário
    $('#prontuario').on("change", function (e) {
        $.ajax({
            url: '/vida/prontuarios/getCamposProntuario',
            type: 'POST',
            dataType: 'JSON',
            data: {
                prontuario_id: $('#prontuario').val(),
            },
            success: function (response) {
                montaProntuario(response['campos']);
            },
            error: function (response) {
                console.log(response);
            }
        });
    });

    // Select Histórico Prontuários
    $("#historico_prontuario").select2({
        ajax: {
            url:  '/vida/prontuarios/getProntuariosPaciente',
            dataType: 'JSON',
            type: 'POST',
            data: function (params) {
                var query = {
                    term: params.term,
                }
                return query;
            },
            processResults: function (data) {
                var results = data.results;
                var prontuarios = [];
                
                prontuarios.push({
                    id: '',
                    text: 'Selecione um prontuário'
                });

                results.forEach(element => {
                    var data_prontuario = moment(element['created_at']).format('DD/MM/YYYY HH:mm:ss');
                    prontuarios.push({
                        id: element['id'],
                        text: data_prontuario + ' - ' + element['descricao']
                    });
                });

                return {
                    results: prontuarios
                };
            }
        },
        width: '100%'
    });

    $('#historico_prontuario').on("change", function (e) {
        $.ajax({
            url: '/vida/prontuarios/getCamposProntuarioPaciente',
            type: 'POST',
            dataType: 'JSON',
            data: {
                prontuario_paciente_id: $('#historico_prontuario').val(),
            },
            success: function (response) {
                montaProntuarioHistorico(response['campos']);
            },
            error: function (response) {
                console.log(response);
            }
        });
    });

    getAgendamento(function(agendamento){
        // Data agendamento
        var start = moment(agendamento['start']);
        var end = moment(agendamento['end']);
        $('#data_agendamento').text(start.format('DD/MM/YYYY HH:mm') + ' - ' + end.format('DD/MM/YYYY HH:mm'));

        // Paciente
        $('#paciente').text(agendamento['paciente'])

        // Tabela Procedimentos Guia (Agendamento)
        var tabela_procedimentos_guia = $('#tabela-procedimentos-guia').DataTable({
            responsive: true,
            autoWidth: false,
            ordering: true,
            searching: true,
            ajax: {
                url: '/vida/guias/getProcedimentosGuia',
                type: 'POST',
                dataType: 'JSON',
                data: function (d) {
                    d.guia_id = agendamento['movimentacao_guia_id'];
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
                        url: '/vida/agendamentos/' + getParameterByName('agendamento_id'),
                        type: 'PUT',
                        dataType: 'JSON',
                        data: {
                            id: getParameterByName('agendamento_id'),
                            situacao: 'F',
                            procedimentos: procedimentos
                        },
                        success: function (data) {
                            // Grava Prontuário
                            $.ajax({
                                url: '/vida/prontuarios/gravaProntuario',
                                type: 'POST',
                                dataType: 'JSON',
                                data: {
                                    paciente_id: agendamento['paciente_id'],
                                    profissional_id: agendamento['profissional_id'],
                                    prontuario_id: $('#prontuario').val(),
                                    campos: $("#formProntuario :input")
                                                .filter(function(index, element) {
                                                    return $(element).val() != '';
                                                })
                                                .serializeArray()
                                },
                                success: function (data) {
                                    window.open('/vida/agendamentos','_self');
                                },
                                error: function (data) {
                                    console.log(data);
                                },
                            });
                        },
                    });
                }
            });
        });
        // getProcedimentosGuia(agendamento['movimentacao_guia_id'], function(procedimentos){
            
        //     // Pega lista e limpa
        //     var lista_procedimentos = $('#lista_procedimentos');
        //     lista_procedimentos.empty();
            

        //     // Cria procedimentos
        //     var html = '<ul class="m-0 p-0 mT-20">';
            
        //     procedimentos.forEach(element => {
        //         var selectedAberto = "", selectedAndamento = "";

        //         if(element['situacao'] == 'A')
        //             selectedAberto = 'selected';
        //         else if (element['situacao'] == 'P')
        //             selectedAndamento = 'selected';

        //         html += '<li class="bdB peers ai-c jc-sb fxw-nw">' +
        //                     '<a class="td-n p-20 peers fxw-nw mR-20 peer-greed c-grey-900">' +
        //                         '<div class="peer mR-15">' + 
        //                             '<i class="fa fa-fw fa-clock-o c-red-500"></i>' +
        //                         '</div>' +
        //                         '<div class="peer">' +
        //                             '<span class="fw-600">' + element['procedimento'] + '</span>' +
        //                         '</div>' +
        //                     '</a>' +
        //                     '<div class="peers mR-15">' + 
        //                         '<div class="peer">' +
        //                             '<select name="situacao" id="situacao_' + element['id'] + '">' +
        //                                 '<option value="A" ' + selectedAberto + '>Aberto</option>' +
        //                                 '<option value="P" ' + selectedAndamento + '>Em andamento</option>' +
        //                                 '<option value="F">Finalizado</option>' +
        //                             '</select>'
        //                         '</div>' +
        //                         '<div class="peer">' +
        //                         '</div>' +
        //                     '</div>' +
        //                 '</li>';
        //     });
        //     html += '</ul>';

        //     lista_procedimentos.append(html);
        // });
    });
});