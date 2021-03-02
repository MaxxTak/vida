function getAgendamentos() {
    $('#ag_data').html(moment().format('DD MMMM YYYY'));

    var tabela_agendamentos = $('#ag_tabela').DataTable({
        responsive: true,
        autoWidth: false,
        ordering: true,
        searching: true,
        order: [3, 'asc'],
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
            { data: 'profissional', class: 'text-success' },
            { data: 'descricao' },
            { data: 'start' },
            { data: 'end' },
            { data: 'situacao' },
        ],
        columnDefs: [
            {
                targets: [3, 4],
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
                targets: [5],
                render: {
                    _: function (data, type, row, meta) {
                        $situacao_cor = '';
                        $situacao = '';

                        if (data == 'A'){
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

    $.ajax({
        url: '/vida/agendamentos/getAgendamentosData',
        type: 'POST',
        dataType: 'JSON',
        data: {
            data_inicial: moment().format('YYYY-MM-DD HH:mm:ss'),
            data_final: moment().format('YYYY-MM-DD 23:59:59'),
        },
        success: function (data) {
            $count_agendamentos = 0;
            data['agendamentos'].forEach(element => {
                $count_agendamentos++;

                tabela_agendamentos.row.add(element).draw();

                // $('#ag_tabela > tbody:last-child').append('<tr>' +
                //                                             '<td class="fw-600">' + element['paciente'] + '</td>' +
                //                                             '<td><span class="text-success">' + element['profissional'] + '</span></td>' +
                //                                             '<td>' + element['descricao'] + '</td>' +
                //                                             '<td>' + moment(element['start']).format('HH:mm:ss') + '</td>' +
                //                                             '<td>' + moment(element['end']).format('HH:mm:ss') + '</td>' +
                //                                             '<td><span class="' + $situacao_cor + '">' + $situacao + '</span> </td>' +
                //                                         '</tr>')
            });

            $('#ag_total').html($count_agendamentos);
        },
        error: function (response) {
            console.log(response);
        }
    });

}

$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    moment.locale('pt-BR');

    getAgendamentos();
});
