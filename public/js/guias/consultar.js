function getProcedimentosGuia(guia_id, callback) {
    $.ajax({
        url: '/vida/guias/getProcedimentosGuia',
        type: 'POST',
        dataType: 'JSON',
        data: {
            guia_id: guia_id,
        },
        success: function (data) {
            var procedimentos_guia = data.data;
            callback(procedimentos_guia);
        },
        error: function(data){
            console.log(data);
        }
    });
}

function getAgendamentos(guia_id, callback) {
    $.ajax({
        url: '/vida/agendamentos/getAgendamentos',
        type: 'POST',
        dataType: 'JSON',
        data: {
            guia_id: guia_id,
            situacao: ['A', 'C']
        },
        success: function (data) {
            callback(data['agendamentos']);
        },
        error: function (response) {
            console.log(response);
            callback([]);
        }
    });
}

$(document).ready(function () {
    var guia;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Paciente
    $("#paciente_id").select2();

    var paciente_id = getParameterByName('paciente_id');

    if(paciente_id != ""){
        $('#paciente_id').val(paciente_id).trigger('change');
    }

    // Profissional
    $("#profissional_id").select2();

    var profissional_id = getParameterByName('profissional_id');

    if(profissional_id != ""){
        $('#profissional_id').val(profissional_id).trigger('change');
    }

    // Situacao
    $("#situacao").select2({
        minimumResultsForSearch: -1
    });

    // Plano Tipo
    $("#plano_tipo").select2({
        minimumResultsForSearch: -1
    });

    var plano_tipo = getParameterByName('plano_tipo');

    if(plano_tipo != ""){
        $('#plano_tipo').val(plano_tipo).trigger('change');
    }
    
    // Atribui data de hoje ao componente
    var hoje = new Date();

    var dia = ("0" + hoje.getDate()).slice(-2);
    var mes = ("0" + (hoje.getMonth() + 1)).slice(-2);

    hoje = hoje.getFullYear() + "-" + mes + "-" + dia;


    $('#data_cadastro_inicial').val(hoje).trigger('change');

    // Atualiza Guias
    $('#profissional_id, #paciente_id, #situacao, #plano_tipo').on("change", function (e) {
        tabela_guias.clear().draw();
        tabela_guias.ajax.reload();
    });

    $('#data_cadastro_inicial').on("change", function (e) {
        var data_inicial = moment($('#data_cadastro_inicial').val());
        var data_final = moment($('#data_cadastro_final').val());

        var diff = data_final.diff(data_inicial);

        if (diff < 0)
            $('#data_cadastro_final').val($('#data_cadastro_inicial').val()).trigger('change');

        tabela_guias.clear().draw();
        tabela_guias.ajax.reload();
    });

    $('#data_cadastro_final').on("change", function (e) {
        var data_inicial = moment($('#data_cadastro_inicial').val());
        var data_final = moment($('#data_cadastro_final').val());

        var diff = data_final.diff(data_inicial);

        if (diff < 0)
            $('#data_cadastro_inicial').val($('#data_cadastro_final').val()).trigger('change');

        tabela_guias.clear().draw();
        tabela_guias.ajax.reload();
    });

    // Seleciona guia se tiver como parametro
    var guia_id = getParameterByName('guia_id');
    
    // Tabela Guias
    var tabela_guias = $('#tabela-guias').DataTable({
        responsive: true,
        autoWidth: false,
        ordering: true,
        searching: true,
        select: {
            style: 'single'
        },
        ajax: {
            url: '/vida/guias/getGuias',
            type: 'POST',
            dataType: 'JSON',
            data: function (d) {
                d.profissional_id = $('#profissional_id').val();
                d.paciente_id = $('#paciente_id').val();
                d.situacao = $('#situacao').val();
                d.plano_tipo = $('#plano_tipo').val();
                d.data_cadastro_inicial = $('#data_cadastro_inicial').val();
                d.data_cadastro_final = $('#data_cadastro_final').val();
            },
        },
        columns: [
            { data: 'id' },
            { data: 'paciente' },
            { data: 'profissional' },
            { data: 'valor_total' },
            { data: 'valor_repasse' },
            { data: 'plano_tipo' },
            { data: '' },
        ],
        columnDefs: [
            {
                targets: [3, 4],
                render: {
                    _: function (data, type, row, meta) {
                        return 'R$ ' + formataNumeroController(data);
                    },
                    sort: function (data, type, row, meta) {
                        return data;
                    }
                }
            },
            {
                targets: 6,
                data: null,
                render: {
                    _: function (data, type, row, meta) {
                        var btn_orcamento = '';
                        if(row['situacao'] == 'O'){
                            btn_orcamento = '<li class="list-inline-item">' +
                                                '<button class="btn btn-success btn-sm btn-orcamento"><span class="ti-check-box" title="Confirmar Orçamento"></span></button>' +
                                            '</li>';
                        }
                        return '<ul class="list-inline">' +
                                    '<li class="list-inline-item">' +
                                        '<button class="btn btn-danger btn-sm btn-excluir"><span class="ti-trash" title="Remover"></span></button>' +
                                    '</li>' +
                                     '<li class="list-inline-item">' +
                                        '<button class="btn btn-primary btn-sm btn-editar"><span class="ti-pencil" title="Editar"></span></button>' +
                                    '</li>' +
                                    '<li class="list-inline-item">' +
                                        '<button class="btn btn-info btn-sm btn-imprimir"><span class="ti-printer" title="Imprimir"></span></button>' +
                                    '</li>' +
                                    btn_orcamento +
                                '</ul>';
                    },
                    sort: function (data, type, row, meta) {
                        return null;
                    }
                }
            },
            {
                targets: 5,
                visible: false
            }
        ],
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
        buttons: [
            { extend: "colvis",
                className: "btn btn-info",
                text: "Colunas"
            },
            {
                extend: "excel",
                className: "btn btn-info",
                text: 'E<u>x</u>cel',
                footer: true,
                exportOptions: {
                columns: ':visible'
                },
            },
            {
                extend: "pdfHtml5",
                className: "btn-sm",
                footer: true,
                text: '<u>P</u>DF',
                exportOptions: {
                columns: ':visible'
                },
            },
            {
                extend: "print",
                className: "btn-sm",
                text: '<u>I</u>mprimir',
                footer: true,
                exportOptions: {
                columns: ':visible'
                },
                title: '',
                customize: function(win) {
                    $(win.document.body).prepend('<h1> Guias </h1>');
                    $(win.document.body).find('h1').css('text-align','center');
                    $(win.document.body).find('h1').css('font-size','18px');
                    $(win.document.body).find( 'table' ).addClass( 'compact' ).css( 'font-size', 'inherit' );
                }
            }
        ],
        pageLength: 10,
        dom: "Brftip",
        order: [0, 'asc'],
        createdRow: function (row, data, dataIndex) {
            if(guia_id == data['id'])
                tabela_guias.row(':eq(' + dataIndex + ')').select();

            if (data['situacao'] == "A") {
                $(row).css('color', 'red');
            } else if (data['situacao'] == "P") {
                $(row).css('color', 'blue');
            } else if (data['situacao'] == "F") {
                $(row).css('color', 'green');
            } else if (data['situacao'] == "O") {
                $(row).css('color', 'black');
            }
        },
        footerCallback: function (row, data, start, end, display) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\R$,.]/g, '') * 0.01 :
                    typeof i === 'number' ?
                        i : 0;
            };

            var valor_total = api
                .column(3, { search: 'applied' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            var valor_repasse = api
                .column(4, { search: 'applied' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            valor_total = 'R$ ' + formataNumero(valor_total);
            valor_repasse = 'R$ ' + formataNumero(valor_repasse);

            $(api.column(3).footer()).html(valor_total);
            $(api.column(4).footer()).html(valor_repasse);
        },
    });

    tabela_guias.on('select', function (e, dt, type, indexes) {
        var rows = tabela_guias.rows({
            selected: true
        }).data().toArray()[0];

        guia = rows['id'];

        tabela_procedimentos_guia.clear().draw();
        tabela_procedimentos_guia.ajax.reload();
    })
    .on('deselect', function (e, dt, type, indexes) {
        tabela_procedimentos_guia.clear().draw();
    });

    // Excluir guia
    $('#tabela-guias tbody').on('click', 'button.btn-excluir', function () {
        var guia = tabela_guias.row($(this).parents('tr')).data();

        if (typeof guia == "undefined") {
            guia = tabela_guias.row(this).data();
        }

        // Não permite edição de guia já em andamento ou finalizada
        if ((guia['situacao'] != 'A') && (guia['situacao'] != 'O')) {
            Swal({
                title: 'Atenção!',
                text: 'Só é possível excluir guia em aberto ou orçamento.',
                type: 'error'
            });
            return false;
        }

        Swal({
            title: 'Tem certeza?',
            text: 'Deseja continuar ?',
            type: 'error',
            showCancelButton: true,
            confirmButtonColor: 'null',
            cancelButtonColor: 'null',
            confirmButtonClass: 'btn btn-danger',
            cancelButtonClass: 'btn btn-primary',
            confirmButtonText: 'Sim!', // Oui, sûr
            cancelButtonText: 'Cancelar', // Annuler
        }).then(res => {
            if (res.value) {
                $.ajax({
                    url: '/vida/guias/' + guia['id'],
                    type: 'DELETE',
                    dataType: 'JSON',
                    data: {
                        id: guia['id']
                    },
                    success: function (data) {
                        tabela_guias.clear().draw();
                        tabela_guias.ajax.reload();
                        tabela_procedimentos_guia.clear().draw();
                        tabela_procedimentos_guia.ajax.reload();
                    },
                });
            }
        });
    });

    // Editar guia
    $('#tabela-guias tbody').on('click', 'button.btn-editar', function () {
        var guia = tabela_guias.row($(this).parents('tr')).data();

        if (typeof guia == "undefined") {
            guia = tabela_guias.row(this).data();
        }

        // Não permite edição de guia já em andamento ou finalizada
        if ((guia['situacao'] != 'A') && (guia['situacao'] != 'O')) {
            Swal({
                title: 'Atenção!',
                text: 'Só é possível modificar guia em aberto ou orçamento.',
                type: 'error'
            });
            return false;
        }

        Swal({
            title: 'Tem certeza?',
            text: 'Deseja continuar ?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'null',
            cancelButtonColor: 'null',
            confirmButtonClass: 'btn btn-danger',
            cancelButtonClass: 'btn btn-primary',
            confirmButtonText: 'Sim!', // Oui, sûr
            cancelButtonText: 'Cancelar', // Annuler
        }).then(res => {
            if (res.value) {
                window.open('/vida/guias/editar?paciente_id=' + guia['paciente_id'] +
                                                    '&profissional_id=' + guia['profissional_id'] +
                                                    '&plano_tipo=' + guia['plano_tipo'] +
                                                    '&orcamento=' + guia['situacao'] +
                                                    '&guia_id=' + guia['id'],
                                                    '_self');
            }
        });
    });

     // Confirmar orçamento
     $('#tabela-guias tbody').on('click', 'button.btn-orcamento', function () {
        var guia = tabela_guias.row($(this).parents('tr')).data();

        if (typeof guia == "undefined") {
            guia = tabela_guias.row(this).data();
        }

        // Permite apenas modificar orçamento
        if (guia['situacao'] != 'O') {
            Swal({
                title: 'Atenção!',
                text: 'Só é possível confirmar orçamento.',
                type: 'error'
            });
            return false;
        }

        Swal({
            title: 'Tem certeza?',
            text: 'Deseja continuar ?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'null',
            cancelButtonColor: 'null',
            confirmButtonClass: 'btn btn-danger',
            cancelButtonClass: 'btn btn-primary',
            confirmButtonText: 'Sim!', // Oui, sûr
            cancelButtonText: 'Cancelar', // Annuler
        }).then(res => {
            if (res.value) {
                $.ajax({
                    url: '/vida/guias/alteraSituacaoGuia',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        id: guia['id'],
                        situacao: 'A'
                    },
                    success: function (data) {
                        console.log(data);
                        tabela_guias.clear().draw();
                        tabela_guias.ajax.reload();
                        tabela_procedimentos_guia.clear().draw();
                        tabela_procedimentos_guia.ajax.reload();
                    },
                });
            }
        });
    });

    // Imprimir guia
    $('#tabela-guias tbody').on('click', 'button.btn-imprimir', function () {
        var guia = tabela_guias.row($(this).parents('tr')).data();

        if (typeof guia == "undefined") {
            guia = tabela_guias.row(this).data();
        }

        console.log(guia);
        imprimeGuia(guia);

    //     if(guia['situacao'] == 'O'){
    //         getProcedimentosGuia(guia['id'], function (result) {
    //             var hoje = moment().format('DD/MM/YYYY - HH:mm:ss');
    
    //             var iframe = document.getElementById("impressaoOrcamento");
    
    //             var elementos = $( "#impressaoOrcamento" ).contents();
    
    //             // Data
    //             elementos.find('*[id*=data]').html('<b>Data Orçamento:</b> ' + hoje);

    //             // Verificar NIM
    //             elementos.find('*[id*=nim]').text(guia['id']);
                
    //             // Paciente
    //             elementos.find('*[id*=nome]').text(guia['paciente']);
    
    //             // Profissional
    //             elementos.find('*[id*=profissional]').text(guia['profissional']);
                
    //             // Remove antigos procedimentos
    //             elementos.find('*[id*=proc_]').remove();
    //             elementos.find('*[id*=prep_]').remove();
    
    //             // Adiciona novos procedimentos
    //             var i = 0;
    //             var temPreparo = false;

    //             result.forEach(element => {
    //                 elementos.find('#procedimentos_1').after('<tr id="proc_1_' + i + '">' + 
    //                                                                 '<td>' + element['quantidade'] + 'x ' + element['procedimento'] + '</td>' +
    //                                                                 '<td>' + element['quantidade'] + 'x R$ ' + formataNumeroController(element['valor']) + ' = R$ ' + formataNumeroController(element['valor_total']) + '</td>' +
    //                                                             '</tr>');   
    //                 i++;
    
    //                 // Adiciona preparos
    //                 if(!jQuery.isEmptyObject(element['preparo'])){
    //                     if(!temPreparo){
    //                         elementos.find('#preparos_1').after('<tr id="prep_titulo_1">' + 
    //                                                                 '<td colspan="2"><br /><b>Preparos: </b></td>' +
    //                                                             '</tr>');   
    //                         elementos.find('#prep_titulo_1').after('<tr id="prep_1_' + i + '">' + 
    //                                                                     '<td colspan="2">' + element['preparo'] + '</td>' +
    //                                                                 '</tr>');   
    //                         temPreparo = true;
    //                     }else{
    //                         elementos.find('#prep_titulo_1').after('<tr id="prep_1_' + i + '">' + 
    //                                                                     '<td colspan="2">' + element['preparo'] + '</td>' +
    //                                                                 '</tr>');
    //                     }
    //                 }
    //             });
                
    //             elementos.find('*[id*=valor_total]').html('<br /> R$ ' + formataNumeroController(guia['valor_total']));

    //             // Efetua impressão
    //             iframe.contentWindow.print();
    //         });
    //     }else{            
    //         getProcedimentosGuia(guia['id'], function (result) {
    //             var hoje = moment().format('DD/MM/YYYY - HH:mm:ss');
    
    //             var iframe = document.getElementById("impressaoGuia");
    
    //             var elementos = $( "#impressaoGuia" ).contents();
                
    //             // Verificar NIM
    //             elementos.find('*[id*=nim]').text(guia['id']);
                
    //             // Paciente
    //             elementos.find('*[id*=nome]').text(guia['paciente']);
    
    //             // Profissional
    //             elementos.find('*[id*=profissional]').text(guia['profissional']);
                
    //             // Remove antigos procedimentos
    //             elementos.find('*[id*=proc_]').remove();
    //             elementos.find('*[id*=prep_]').remove();
    
    //             // Adiciona novos procedimentos
    //             var i = 0;
    //             var temPreparo = false;
    //             result.forEach(element => {
    //                 elementos.find('#procedimentos_1').after('<tr id="proc_1_' + i + '">' + 
    //                                                                 '<td>' + element['quantidade'] + 'x ' + element['procedimento'] + '</td>' +
    //                                                             '</tr>');   
    //                 elementos.find('#procedimentos_2').after('<tr id="proc_2_' + i + '">' + 
    //                                                                 '<td>' + element['quantidade'] + 'x ' + element['procedimento'] + '</td>' +
    //                                                             '</tr>');                                                              
    //                 i++;
    
    //                 // Adiciona preparos
    //                 if(!jQuery.isEmptyObject(element['preparo'])){
    //                     if(!temPreparo){
    //                         elementos.find('#preparos_1').after('<tr id="prep_titulo_1">' + 
    //                                                                 '<td><br /><b>Preparos: </b></td>' +
    //                                                             '</tr>');   
    //                         elementos.find('#prep_titulo_1').after('<tr id="prep_1_' + i + '">' + 
    //                                                                 '<td>' + element['preparo'] + '</td>' +
    //                                                             '</tr>');   
    //                         elementos.find('#preparos_2').after('<tr id="prep_titulo_2">' + 
    //                                                                 '<td><br /><b>Preparos: </b></td>' +
    //                                                             '</tr>');   
    //                         elementos.find('#prep_titulo_2').after('<tr id="prep_2_' + i + '">' + 
    //                                                                 '<td>' + element['preparo'] + '</td>' +
    //                                                             '</tr>');  
    //                         temPreparo = true;
    //                     }else{
    //                         elementos.find('#prep_titulo_1').after('<tr id="prep_1_' + i + '">' + 
    //                                                                 '<td>' + element['preparo'] + '</td>' +
    //                                                             '</tr>');
    //                         elementos.find('#prep_titulo_2').after('<tr id="prep_2_' + i + '">' + 
    //                                                                 '<td>' + element['preparo'] + '</td>' +
    //                                                             '</tr>');
    //                     }
    //                 }
    //             });
    
    //             // Adiciona agendamentos
    //             var dataAgendamento;
    //             getAgendamentos(guia['id'], function (result) {
    //                 // Remove antigos agendamentos
    //                 elementos.find('*[id*=ag_]').remove();
                    
    //                 var a = 0;
    //                 result.forEach(element => {
    //                     dataAgendamento = moment(element['start']).format('DD/MM/YYYY - HH:mm:ss');
    
    //                     elementos.find('#agendamentos_1').after('<tr id="ag_1_' + a + '">' + 
    //                                                                     '<td>' + dataAgendamento + '</td>' +
    //                                                                 '</tr>'); 
    //                     elementos.find('#agendamentos_2').after('<tr id="ag_2_' + a + '">' + 
    //                                                                     '<td>' + dataAgendamento + '</td>' +
    //                                                                 '</tr>'); 
    //                 });
    //                 a++;
    
    //                 // Efetua impressão
    //                 iframe.contentWindow.print();
    //             });
    //         });
    //     }
    });

    // Tabela Procedimentos Guia
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
                d.guia_id = guia;
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
            { data: 'valor' },
            { data: 'quantidade' },
            { data: 'valor_total' },
            { data: 'situacao' },
            { data: 'observacao' },
            { data: 'alterado' },
        ],
        columnDefs: [
            {
                targets: [1, 3],
                render: {
                    _: function (data, type, row, meta) {
                        return 'R$ ' + formataNumeroController(data);
                    },
                    sort: function (data, type, row, meta) {
                        return data;
                    }
                }
            },
            {
                targets: [4],
                render: {
                    _: function (data, type, row, meta) {
                        if(data == 'A')
                            return 'Aberto';
                        else if (data == 'P')
                            return 'Em Andamento';
                        else if (data == 'F')
                            return 'Finalizado';
                    },
                    sort: function (data, type, row, meta) {
                        if(data == 'A')
                            return 'Aberto';
                        else if (data == 'P')
                            return 'Em Andamento';
                        else if (data == 'F')
                            return 'Finalizado';
                    }
                }
            },
            {
                targets: 6,
                visible: false
            }
        ],
        buttons: [
            { extend: "colvis",
                className: "btn btn-info",
                text: "Colunas"
            },
            {
                extend: "excel",
                className: "btn btn-info",
                text: 'E<u>x</u>cel',
                footer: true,
                exportOptions: {
                columns: ':visible'
                },
            },
            {
                extend: "pdfHtml5",
                className: "btn-sm",
                footer: true,
                text: '<u>P</u>DF',
                exportOptions: {
                columns: ':visible'
                },
            },
            {
                extend: "print",
                className: "btn-sm",
                text: '<u>I</u>mprimir',
                footer: true,
                exportOptions: {
                columns: ':visible'
                },
                title: '',
                customize: function(win) {
                    var guia_selecionada = tabela_guias.rows({
                        selected: true
                    }).data().toArray()[0];

                    if(typeof(guia_selecionada) != 'undefined'){
                        $(win.document.body).prepend('<h1> Profissional: ' + guia_selecionada['profissional'] + ' </h1>');
                        $(win.document.body).prepend('<h1> Paciente: ' + guia_selecionada['paciente'] + ' </h1>');
                        $(win.document.body).prepend('<h1> Guia ' + guia_selecionada['id'] + ' </h1>');

                    }
                    $(win.document.body).find('h1').css('text-align','center');
                    $(win.document.body).find('h1').css('font-size','18px');
                    $(win.document.body).find( 'table' ).addClass( 'compact' ).css( 'font-size', 'inherit' );

                    
                }
            }
        ],
        pageLength: 10,
        dom: "Brftip",
        order: [0, 'asc'],
        createdRow: function (row, data, dataIndex) {
            if (data['alterado'] == "S") {
                $(row).css('color', 'red');
            }
        },
        footerCallback: function (row, data, start, end, display) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\R$,.]/g, '') * 0.01 :
                    typeof i === 'number' ?
                        i : 0;
            };

            var quantidade = api
                .column(2, { search: 'applied' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            var valor_total = api
                .column(3, { search: 'applied' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            valor_total = 'R$ ' + formataNumero(valor_total);

            $(api.column(2).footer()).html(quantidade);
            $(api.column(3).footer()).html(valor_total);
        },
    });
});