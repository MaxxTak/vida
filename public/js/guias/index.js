function adicionaProcedimentoGuia($tabela_procedimentos_guia, $procedimento) {
    var procedimento_id = $procedimento['id'];

    // Corrige valores
    var valor = $('#valor_' + procedimento_id).val().replace('.', '').replace(',', '.');
    var valorAnterior = $procedimento['valor'];

    if (valor != $procedimento['valor'])
        $procedimento['alterado'] = 'S';
    else
        $procedimento['alterado'] = 'N';

    $procedimento['valor'] = parseFloat(valor);

    Swal({
        title: $procedimento['procedimento'],
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '<span class="ti-check"></span>',
        cancelButtonText: '<span class="ti-close"></span>',
        // Form com valores
        html:
            '<div class="form-group">' +
                '<label for="valor" class="text-normal text-dark">Valor</label>' +
                '<input id="valor" type="text" class="form-control" name="valor" value="' + valor + '" disabled>' +
            '</div>' +
            '<div class="form-group">' +
                '<label for="quantidade" class="text-normal text-dark">Quantidade</label>' +
                '<input id="quantidade" type="text" class="form-control" name="quantidade" placeholder="1" autofocus>' +
            '</div>' +
            '<div class="form-group">' +
                '<label for="sessoes" class="text-normal text-dark">Sessões</label>' +
                '<input id="sessoes" type="text" class="form-control" name="sessoes" placeholder="1">' +
            '</div>' +
            '<div class="form-group">' +
                '<label for="observacao" class="text-normal text-dark">Observação</label>' +
                '<input id="observacao" type="text" class="form-control" name="observacao">' +
            '</div>',
        focusConfirm: false,
        // Adiciona máscara aos inputs
        onOpen: () => {
            $('#valor').mask('#.##0,00', { reverse: true });
            $('#quantidade').mask('#0', { reverse: true });
            $('#sessoes').mask('#0', { reverse: true });
        },
    }).then((result) => {
        if (result.value) {
            // Corrige valores
            var quantidade = $('#quantidade').val();
            if (jQuery.isEmptyObject(quantidade))
                quantidade = 1;
            quantidade = parseInt(quantidade);

            // Número de sessões
            var sessoes = $('#sessoes').val();
            if (jQuery.isEmptyObject(sessoes))
                sessoes = 0;
            sessoes = parseInt(sessoes);

            $procedimento['quantidade'] = quantidade;
            $procedimento['valor_total'] = valor * quantidade;
            $procedimento['observacao'] = $('#observacao').val();

            $tabela_procedimentos_guia.row.add($procedimento).draw();

            if(sessoes > 1){
                for(var i = 1; i < sessoes; i++){
                    var procedimento_sessao = $.extend( true, {}, $procedimento );;

                    procedimento_sessao['quantidade'] = 1;
                    procedimento_sessao['valor_total'] = 0;
                    procedimento_sessao['valor'] = 0;
                    procedimento_sessao['observacao'] = 'Sessão ' + (i + 1) + '/' + sessoes;

                    $tabela_procedimentos_guia.row.add(procedimento_sessao).draw();
                }
            }
        }
    });
}

$(document).ready(function () {
    var paciente_anterior, profissional_anterior, plano_anterior;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Orçamento
    $("#orcamento").select2({
        width: '100%',
        minimumResultsForSearch: -1
    });

    // Controla alteração de pacientes. Zera procedimentos
    $("#paciente_id").select2({
        width: '100%'
    });

    $('#paciente_id').on('select2:selecting', function (evt) {
        paciente_anterior = $('#paciente_id').val();
    });

    $('#paciente_id').on('select2:select', function (evt) {
        if (!jQuery.isEmptyObject(paciente_anterior)) {
            Swal({
                title: 'Atenção!',
                text: 'Alterar o paciente resultará na perda de todas alterações. Deseja continuar?',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<span class="ti-check"></span>',
                cancelButtonText: '<span class="ti-close"></span>',
                // Form com valores
                focusConfirm: true,
                type: 'warning',
            }).then((result) => {
                if (result.value) {
                    tabela_procedimentos_guia.clear().draw();
                } else {
                    $('#paciente_id').val(paciente_anterior).trigger('change');
                }
            });
        }
    });

    // Controla alteração de planos. Zera procedimentos
    $("#plano_tipo").select2({
        width: '100%',
        minimumResultsForSearch: -1
    });

    $('#plano_tipo').on('select2:selecting', function (evt) {
        plano_anterior = $('#plano_tipo').val();
    });

    $('#plano_tipo').on('select2:select', function (evt) {
        if (!jQuery.isEmptyObject(plano_anterior)) {
            Swal({
                title: 'Atenção!',
                text: 'Alterar o plano resultará na perda de todas alterações. Deseja continuar?',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<span class="ti-check"></span>',
                cancelButtonText: '<span class="ti-close"></span>',
                // Form com valores
                focusConfirm: true,
                type: 'warning',
            }).then((result) => {
                if (result.value) {
                    tabela_procedimentos_guia.clear().draw();
                } else {
                    $('#plano_tipo').val(plano_anterior).trigger('change');
                }
            });
        }
    });

    // Controla alteração de pacientes. Zera procedimentos
    $("#profissional_id").select2({
        width: '100%'
    });

    $('#profissional_id').on('select2:selecting', function (evt) {
        profissional_anterior = $('#profissional_id').val();
    });

    $('#profissional_id').on('select2:select', function (evt) {
        if (!jQuery.isEmptyObject(profissional_anterior)) {
            Swal({
                title: 'Atenção!',
                text: 'Alterar o profissional resultará na perda de todas alterações. Deseja continuar?',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<span class="ti-check"></span>',
                cancelButtonText: '<span class="ti-close"></span>',
                // Form com valores
                focusConfirm: true,
                type: 'warning',
            }).then((result) => {
                if (result.value) {
                    tabela_procedimentos_guia.clear().draw();
                } else {
                    $('#profissional_id').val(profissional_anterior).trigger('change');
                }
            });
        }
    });

    // Atualiza Procedimentos Profissional
    $('#profissional_id, #plano_tipo').on("change", function (e) {
        tabela_procedimentos_profissional.clear().draw();
        tabela_procedimentos_profissional.ajax.reload();
    });

    // Table Procedimentos Profissional
    var tabela_procedimentos_profissional = $('#tabela-procedimentos-profissional').DataTable({
        responsive: true,
        autoWidth: false,
        ordering: true,
        searching: true,
        ajax: {
            url: '/vida/profissional_procedimentos/getProcedimentosProfissional',
            type: 'POST',
            dataType: 'JSON',
            data: function (d) {
                d.profissional_id = $('#profissional_id').val();
                // Verificar através do usuário
                d.plano_tipo = $('#plano_tipo').val();
            },
            error: function (d) {
                console.log(d);
            }
        },
        columns: [
            { data: 'id' },
            { data: 'procedimento' },
            { data: 'especialidade' },
            { data: 'valor' },
        ],
        columnDefs: [
            {
                targets: [3],
                render: {
                    _: function (data, type, row, meta) {
                        return '<input type="text" value="' + data.toFixed(2) + '" class="form-control" name="valor" id="valor_' + row['id'] + '"></input>';
                    },
                    sort: function (data, type, row, meta) {
                        return data;
                    }
                }
            },
            {
                targets: 4,
                data: null,
                render: {
                    _: function (data, type, row, meta) {
                        return '<ul class="list-inline">' +
                            '<li class="list-inline-item">' +
                            '<button class="btn btn-success btn-sm"><span class="ti-plus" title="Adicionar"></span></button>' +
                            '</li>' +
                            '</ul>';
                    },
                    sort: function (data, type, row, meta) {
                        return null;
                    }
                }
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
        pageLength: 10,
        dom: "rftip",
        order: [0, 'asc'],
        drawCallback: function () {
            $("input[name*='valor']").mask('#.##0,00', { reverse: true });
            $("input[name*='percentual']").mask('#.##0,00', { reverse: true });
        }
    });

    // Cadastro de procedimento Guia
    $('#tabela-procedimentos-profissional tbody').on('click', 'button', function () {
        if ($('#paciente_id').val()) {
            // Busca procedimento
            var procedimento = tabela_procedimentos_profissional.row($(this).parents('tr')).data();

            if (typeof procedimento == "undefined") {
                procedimento = tabela_procedimentos_profissional.row(this).data();
            }

            // Verifica se procedimento já não está adicionado
            var indexes = tabela_procedimentos_guia.rows().indexes();
            var contem = false;

            var procedimento_id = procedimento['id'];

            if (indexes.count() > 0) {
                indexes.each(function (index) {
                    var procedimentosGuia = tabela_procedimentos_guia.row(index).data();

                    if (procedimentosGuia['id'] == procedimento_id)
                        contem = true;
                });
            }

            if (contem) {
                Swal({
                    title: 'Atenção!',
                    text: 'Procedimento já cadastrado para a guia. Deseja incluir novamente?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<span class="ti-check"></span>',
                    cancelButtonText: '<span class="ti-close"></span>',
                    focusConfirm: false,
                    focusCancel: true,
                }).then((result) => {
                    if (result.value) {
                        adicionaProcedimentoGuia(tabela_procedimentos_guia, procedimento);
                    }
                });
            } else {
                adicionaProcedimentoGuia(tabela_procedimentos_guia, procedimento);
            }

        } else {
            Swal({
                title: 'Nenhum paciente selecionado.',
                text: 'Selecione um paciente acima.',
                type: 'error'
            });
        }
    });

    // Tabela Procedimentos Guia
    var tabela_procedimentos_guia = $('#tabela-procedimentos-guia').DataTable({
        responsive: true,
        autoWidth: false,
        ordering: true,
        searching: true,
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
            { data: 'observacao' },
            { data: '' },
        ],
        columnDefs: [
            {
                targets: [1, 3],
                render: {
                    _: function (data, type, row, meta) {
                        return 'R$ ' + data.toFixed(2);
                    },
                    sort: function (data, type, row, meta) {
                        return data;
                    }
                }
            },
            {
                targets: 5,
                data: null,
                render: {
                    _: function (data, type, row, meta) {
                        return '<ul class="list-inline">' +
                            '<li class="list-inline-item">' +
                            '<button class="btn btn-danger btn-sm"><span class="ti-close" title="Remover"></span></button>' +
                            '</li>' +
                            '</ul>';
                    },
                    sort: function (data, type, row, meta) {
                        return null;
                    }
                }
            }
        ],
        pageLength: 10,
        dom: "rftip",
        order: [0, 'asc'],
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

            console.log(valor_total);
            valor_total = 'R$ ' + addCommas(valor_total.toFixed(2).replace('.', ','));

            $(api.column(2).footer()).html(quantidade);
            $(api.column(3).footer()).html(valor_total);
        },
    });

    // Exclusão de procedimentos Guia
    $('#tabela-procedimentos-guia tbody').on('click', 'button', function () {
        // Busca procedimento
        var row = tabela_procedimentos_guia.row($(this).parents('tr'));
        var procedimento = row.data();

        if (typeof procedimento == "undefined") {
            row = tabela_procedimentos_guia.row(this);
            procedimento = row.data();
        }

        Swal({
            title: procedimento['procedimento'],
            text: 'Confirma exclusão do procedimento?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<span class="ti-check"></span>',
            cancelButtonText: '<span class="ti-close"></span>',
            // Form com valores
            focusConfirm: false,
            // Adiciona máscara aos inputs
        }).then((result) => {
            if (result.value) {
                tabela_procedimentos_guia.row(row).remove().draw();
            }
        });
    });

    // Gravar guia
    $('#btnEnviar').on('click', function (e) {
        if (!$('#paciente_id').val()) {
            Swal({
                title: 'Nenhum paciente selecionado.',
                text: 'Selecione um paciente acima.',
                type: 'error'
            });
            return false;
        }

        if (!$('#profissional_id').val()) {
            Swal({
                title: 'Nenhum profissional selecionado.',
                text: 'Selecione um profissional acima.',
                type: 'error'
            });
            return false;
        }
        var procedimentos = tabela_procedimentos_guia.rows().data().toArray();

        if (procedimentos.length == 0) {
            Swal({
                title: 'Nenhum procedimento selecionado.',
                text: 'Selecione um procedimento acima.',
                type: 'error'
            });
            return false;
        }

        var titulo = "";

        if($('#orcamento').val() == 'O')
            titulo = "Gravar Orçamento";
        else
            titulo = "Gravar Guia";

        Swal({
            title: titulo,
            text: 'Confirma  procedimento?',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<span class="ti-check"></span>',
            cancelButtonText: '<span class="ti-close"></span>',
        }).then((result) => {
            if (result.value) {
                console.log("Entrou para mandar post");
                $.ajax({
                    url: '/vida/guias',
                    type: 'POST',
                    dataType: '',
                    data: {
                        profissional_id: $('#profissional_id').val(),
                        paciente_id: $('#paciente_id').val(),
                        plano_tipo: $('#plano_tipo').val(),
                        orcamento: $('#orcamento').val(),
                        procedimentos: procedimentos
                    },
                    success: function (data) {
                        console.log("data: "+data);
                        if (data['status'] == 'sucesso') {
                            var guia = data['guia']
                            Swal({
                                title: 'Guia ' + guia['id'],
                                text: 'Valor total: R$ ' + guia['valor_total'].toFixed(2),
                            });

                            window.open('/vida/guias/consultar?paciente_id=' + $('#paciente_id').val() +
                                '&profissional_id=' + $('#profissional_id').val() +
                                '&plano_tipo=' + $('#plano_tipo').val() +
                                '&guia_id=' + guia['id'],
                                '_self');

                            $("#paciente_id").val(null).trigger('change');
                            $("#profissional_id").val(null).trigger('change');
                            tabela_procedimentos_guia.clear().draw();

                        } else {
                            Swal({
                                title: 'Erro!',
                                text: 'Erro ao gravar guia, tente novamente.',
                                type: 'error'
                            });
                        }
                    },
                    error: function(jqXHR, exception){
                        Swal({
                            title: 'Erro!',
                            text: 'Erro ao gravar guia, tente novamente.',
                            type: 'error'
                        });
                        //console.log(jqXHR);
                        console.log(exception);
                    }
                });
            }
        });
    });
});