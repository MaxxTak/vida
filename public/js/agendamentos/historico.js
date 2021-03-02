var tabela_agendamentos;

function getAgendamentos() {
    $.ajax({
        url: '/vida/agendamentos/getAgendamentosHistorico',
        type: 'POST',
        dataType: 'JSON',
        data: {
            profissional_id: $('#profissional_id').val(),
            paciente_id: $('#paciente_id').val(),
            sala_id: $('#sala_id').val(),
            situacao: $('#situacao').val(),
            data_inicial: $('#data_inicial').val(),
            data_final: $('#data_final').val()
            // data_inicial: moment().format('YYYY-MM-DD HH:mm:ss'),
            // data_final: moment().format('YYYY-MM-DD 23:59:59'),
        },
        success: function (data) {
            $count_agendamentos = 0;
            
            tabela_agendamentos.clear().draw();

            data['agendamentos'].forEach(element => {
                $count_agendamentos++;

                tabela_agendamentos.row.add(element).draw();
            });
        },
        error: function (response) {
            console.log(response);
        }
    });

}

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    moment.locale('pt-BR');

    // Selects
    $("#profissional_id, #paciente_id, #sala_id, #situacao").select2({
        width: '100%'
    });

    // 
    $('#profissional_id, #paciente_id, #sala_id, #situacao').on("change", function (e) {
        getAgendamentos();
    });

    // Agendamentos
    tabela_agendamentos = $('#ag_tabela').DataTable({
        responsive: true,
        autoWidth: false,
        ordering: true,
        searching: true,
        order: [3, 'asc'],
        dom: "Brftip",
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
                    if ($('#sala_id').val())
                        $(win.document.body).prepend('<h2>Sala: ' + $('#sala_id').select2('data')[0].text + '</h2>');

                    if ($('#profissional_id').val())
                        $(win.document.body).prepend('<h2>Profissional: ' + $('#profissional_id').select2('data')[0].text + '</h2>');

                    if ($('#paciente_id').val())
                        $(win.document.body).prepend('<h2>Paciente: ' + $('#paciente_id').select2('data')[0].text + '</h2>');
                    
                    $(win.document.body).prepend('<h1> Agendamentos </h1>');
                    $(win.document.body).find('h1').css('text-align','center');
                    $(win.document.body).find('h1').css('font-size','18px');
                    $(win.document.body).find('h2').css('text-align','center');
                    $(win.document.body).find('h2').css('font-size','14px');
                    $(win.document.body).find( 'table' ).addClass( 'compact' ).css( 'font-size', 'inherit' );
                }
            }
        ],
        pageLength: 25,
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
            { data: 'paciente' },
            { data: 'profissional' },
            { data: 'descricao' },
            { data: 'start' },
            { data: 'start' },
            { data: 'end' },
            { data: 'situacao' },
        ],
        columnDefs: [
            {
                targets: [3],
                render: {
                    _: function (data, type, row, meta) {
                        return moment(data).format('DD/MM/YYYY');
                    },
                    sort: function (data, type, row, meta) {
                        return data;
                    }
                }
            },
            {
                targets: [4, 5],
                render: {
                    _: function (data, type, row, meta) {
                        return moment(data).format('HH:mm:ss');
                    },
                    sort: function (data, type, row, meta) {
                        return data;
                    }
                }
            },
            {
                targets: [6],
                render: {
                    _: function (data, type, row, meta) {
                        $situacao_cor = '';
                        $situacao = '';

                        console.log();
                        if(row['deleted_at']){
                            $situacao = 'Cancelado';
                            $situacao_cor = 'badge badge-pill badge-dark lh-0 p-10';
                        }else if (data == 'A'){
                            $situacao = 'Aberto';
                            $situacao_cor = 'badge badge-pill badge-warning lh-0 p-10';
                        }else if (data == 'C'){
                            $situacao = 'Confirmado';
                            $situacao_cor = 'badge badge-pill badge-info lh-0 p-10';
                        }else if (data == 'F'){
                            $situacao = 'Finalizado';
                            $situacao_cor = 'badge badge-pill badge-success lh-0 p-10';
                        }else if (data == 'T'){
                            $situacao = 'Falta';
                            $situacao_cor = 'badge badge-pill badge-danger lh-0 p-10';
                        }else if (data == 'P'){
                            $situacao = 'Presente';
                            $situacao_cor = 'badge badge-pill bgc-red-50 lh-0 p-10';
                        }

                        return '<span class="' + $situacao_cor + '">' + $situacao + '</span>';
                    },
                    sort: function (data, type, row, meta) {
                        return data;
                    }
                }
            },
        ],
    });

    getAgendamentos();
});