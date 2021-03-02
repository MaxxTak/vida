$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#user_id').on("change", function (e){
        $('#especialidade_id option:selected').prop("selected", false);
        
        $.ajax({
            url: '/vida/profissional_procedimentos/getEspecialidadesProfissional',
            type: 'POST',
            dataType: 'JSON',
            data: {
                profissional_id: $('#user_id').val()
            },
            success: function (data) {
                var resultado = data.data;

                if(resultado.length > 0){
                    resultado.forEach(element => {
                        $("#especialidade_id option[value='" + element['especialidade_id'] + "']").prop("selected", true).change();
                    });
                }else{
                    $('#especialidade_id option').first().prop("selected", true).change();
                }
            },
        }); 
    });

    $('#especialidade_id').on("change", function (e){
        tabela_procedimentos_especialidades.clear().draw();
        tabela_procedimentos_especialidades.ajax.reload();

        tabela_procedimentos_profissional.clear().draw();
        tabela_procedimentos_profissional.ajax.reload();
    });

    $("#user_id").select2();

    $("#especialidade_id").select2();
    
    // Tabea Procedimentos por Especialidades
    var tabela_procedimentos_especialidades = $('#tabela-procedimentos-especialidades').DataTable({
        responsive: true,
        autoWidth: false,
		ordering: true,
		searching: true,
        ajax: {
            url: '/vida/profissional_procedimentos/getProcedimentosEspecialidades',
            type: 'POST',
            dataType: 'JSON',
            data: function(d){
                d.especialidades_id = $('#especialidade_id').val();
            },
        },
        columns: [
            { data: 'id' },
            { data: 'descricao' },
            { data: 'especialidade' },
            { data: '' }
        ],
        columnDefs:[
            { 
                targets: 3,
                data: null,
                defaultContent: '<ul class="list-inline">' +
                                    '<li class="list-inline-item">' +
                                        '<button class="btn btn-success btn-sm"><span class="ti-plus" title="Adicionar"></span></button>' +
                                    '</li>' +
                                '</ul>'
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
        order: [0, 'asc']
    });

    // Adiciona novo procedimento
    $('#tabela-procedimentos-especialidades tbody').on( 'click', 'button', function () {
        //Seleciona procedimento
        var procedimento = tabela_procedimentos_especialidades.row( $(this).parents('tr') ).data();
  
        if(typeof procedimento == "undefined"){
            procedimento = tabela_procedimentos_especialidades.row( this ).data();
        }

        // Verifica se possui profissional selecionado
        if(jQuery.isEmptyObject($('#user_id').val())){
            Swal({
                title: 'Nenhum profissional selecionado',
                text: 'Selecione um profissional para vincular um procedimento.',
                type: 'error'
            });
            return false;
        }

        // Verifica se procedimento já não está adicionado
        var indexes = tabela_procedimentos_profissional.rows().indexes();
        var contem = false;

        var procedimento_id = procedimento['id'];
        if(indexes.count() > 0){
            indexes.each(function(index){
                var procedimentoProfissional = tabela_procedimentos_profissional.row( index ).data();

                if(procedimentoProfissional['procedimento_id'] == procedimento_id)
                    contem = true;
            });
        }

        // Se já tiver cadastro, cancela
        if(contem){
            Swal({
                title: 'Procedimento já cadastrado para o profissional.',
                text: 'Faça a alteração acima.',
                type: 'error'
            });
        }else{
            // Senão, adiciona novo procedimento
            Swal({
                title: procedimento['descricao'] + ' / ' + procedimento['especialidade'],
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<span class="ti-check"></span>',
                cancelButtonText: '<span class="ti-close"></span>',
                // Form com valores
                html:
                    '<div class="form-group">' +
                        '<label for="valor" class="text-normal text-dark">Valor</label>' +
                        '<input id="valor" type="text" class="form-control" name="valor" autofocus>' + 
                    '</div>' +
                    '<div class="form-group">' +
                        '<label for="valor_particular" class="text-normal text-dark">Valor Particular</label>' +
                        '<input id="valor_particular" type="text" class="form-control" name="valor_particular" autofocus>' + 
                    '</div>' +
                    '<div class="form-group">' +
                        '<label for="valor_repasse" class="text-normal text-dark">Valor Repasse</label>' +
                        '<input id="valor_repasse" type="text" class="form-control" name="valor_repasse">' + 
                    '</div>' +
                    '<div class="form-group">' +
                        '<label for="percentual_repasse" class="text-normal text-dark">Percentual Repasse</label>' +
                        '<input id="percentual_repasse" type="text" class="form-control" name="percentual_repasse">' + 
                    '</div>' +
                    '<div class="form-group">' +
                        '<label for="tempo_atendimento" class="text-normal text-dark">Tempo de Atendimento</label>' +
                        '<input id="tempo_atendimento" type="text" class="form-control" name="tempo_atendimento">' + 
                    '</div>',
                focusConfirm: false,
                // Adiciona máscara aos inputs
                onOpen: () => {
                    $('#valor').mask('#.##0,00', {reverse: true});
                    $('#valor_particular').mask('#.##0,00', {reverse: true});
                    $('#valor_repasse').mask('#.##0,00', {reverse: true});
                    $('#percentual_repasse').mask('#.##0,00', {reverse: true});
                    $('#tempo_atendimento').mask('#.##0,00', {reverse: true});
                },
                //
            }).then((result) => {
                if(result.value){
                    // Corrige valores
                    var valor = $('#valor').val().replace('.', '').replace(',', '.');
                    var valor_particular = $('#valor_particular').val().replace('.', '').replace(',', '.');
                    var valor_repasse = $('#valor_repasse').val().replace('.', '').replace(',', '.');
                    var percentual_repasse = $('#percentual_repasse').val().replace('.', '').replace(',', '.');
                    var tempo_atendimento = $('#tempo_atendimento').val().replace('.', '').replace(',', '.');

                    // Não permite duplicidade de valor e percentual de repasse
                    if((valor_repasse != 0) && (percentual_repasse != 0)){
                        Swal(
                            'Repasse em duplicidade!',
                            'Defina apenas valor de repasse ou percentual de repasse.',
                            'error'
                        );
                        return false;
                    }

                    $.ajax({
                        url: '/vida/profissional_procedimentos/adicionaProcedimentoProfissional',
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                            user_id: $('#user_id').val(),
                            procedimento_id: procedimento_id,
                            valor: valor,
                            valor_particular: valor_particular,
                            valor_repasse: valor_repasse,
                            percentual_repasse: percentual_repasse,
                            tempo_atendimento: tempo_atendimento,
                        },
                        success: function (data) {
                            if(data['status'] == 'sucesso'){
                                Swal(
                                    'Sucesso!',
                                    'Procedimento cadastrado!',
                                    'success'
                                ).then(() => {
                                    // Atualiza tabela
                                    tabela_procedimentos_profissional.clear().draw();
                                    tabela_procedimentos_profissional.ajax.reload();
                                });
                            }else{
                                Swal(
                                    'Erro!',
                                    'Tente novamente!',
                                    'error'
                                );
                            }
                        },
                    }); 
                }
            });
        }

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
            data: function(d){
                d.profissional_id = $('#user_id').val();
            },
        },
        columns: [
            { data: 'id' },
            { data: 'procedimento' },
            { data: 'valor' },
            { data: 'valor_particular' },
            { data: 'valor_repasse' },
            { data: 'percentual_repasse' },
            { data: 'tempo_atendimento' },
            { data: '' },
        ],
        columnDefs:[
            {
                targets: [2],
                render: {
                    _: function ( data, type, row, meta ) {
                        return '<input type="text" value="' + data.toFixed(2) + '" class="form-control" name="valor" id="valor_' + row['id'] + '"></input>';
                    },
                    sort: function(data, type, row, meta){
                        return data;
                    }
                }
            },
            {
                targets: [3],
                render: {
                    _: function ( data, type, row, meta ) {
                        return '<input type="text" value="' + data.toFixed(2) + '" class="form-control" name="valor" id="valor_particular_' + row['id'] + '"></input>';
                    },
                    sort: function(data, type, row, meta){
                        return data;
                    }
                }
            },
            {
                targets: [4],
                render: {
                    _: function ( data, type, row, meta ) {
                        return '<input type="text" value="' + data.toFixed(2) + '" class="form-control" name="valor_repasse" id="valor_repasse_' + row['id'] + '"></input>';
                    },
                    sort: function(data, type, row, meta){
                        return data;
                    }
                }
            },
            {
                targets: [5],
                render: {
                    _: function ( data, type, row, meta ) {
                        return '<input type="text" value="' + data.toFixed(2) + '" class="form-control" name="percentual_repasse" id="percentual_repasse_' + row['id'] + '"></input>';
                    },
                    sort: function(data, type, row, meta){
                        return data;
                    }
                }
            },
            {
                targets: [6],
                render: {
                    _: function ( data, type, row, meta ) {
                        return '<input type="text" value="' + data.toFixed(2) + '" class="form-control" name="tempo_atendimento" id="tempo_atendimento_' + row['id'] + '"></input>';
                    },
                    sort: function(data, type, row, meta){
                        return data;
                    }
                }
            },
            { 
                targets: 7,
                data: null,
                render: {
                    _: function ( data, type, row, meta ) {
                        return '<ul class="list-inline">' +
                                    '<li class="list-inline-item">' +
                                        '<button class="btn btn-primary btn-sm"><span class="ti-check" title="Alterar"></span></button>' +
                                    '</li>' +
                                    '<li class="list-inline-item">' +
                                        '<a href="profissional_procedimentos/' + row['id'] + '/historico/" title="Histórico de Valores" class="btn btn-success btn-sm"><span class="ti-list"></span></a>' +
                                    '</li>' +
                                '</ul>' ;
                    },
                    sort: function(data, type, row, meta){
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
        drawCallback: function(){
            $("input[name*='valor']").mask('#.##0,00', {reverse: true});
            $("input[name*='percentual']").mask('#.##0,00', {reverse: true});
            $("input[name*='tempo']").mask('#.##0,00', {reverse: true});
        }
    });

    // Alteração de valores de procedimento
    $('#tabela-procedimentos-profissional tbody').on( 'click', 'button', function () {
        // Busca procedimento
        var procedimento = tabela_procedimentos_profissional.row( $(this).parents('tr') ).data();
  
        if(typeof procedimento == "undefined"){
            procedimento = tabela_procedimentos_profissional.row( this ).data();
        }

        var procedimento_id = procedimento['id'];

        // Corrige valores
        var valor = $('#valor_' + procedimento_id).val().replace('.', '').replace(',', '.');
        var valor_particular = $('#valor_particular_' + procedimento_id).val().replace('.', '').replace(',', '.');
        var valor_repasse = $('#valor_repasse_' + procedimento_id).val().replace('.', '').replace(',', '.');
        var percentual_repasse = $('#percentual_repasse_' + procedimento_id).val().replace('.', '').replace(',', '.');
        var tempo_atendimento = $('#tempo_atendimento_' + procedimento_id).val().replace('.', '').replace(',', '.');

        // Não permite duplicidade de valor e percentual de repasse
        if((valor_repasse != 0) && (percentual_repasse != 0)){
            Swal(
                'Repasse em duplicidade!',
                'Defina apenas valor de repasse ou percentual de repasse.',
                'error'
            );
            return false;
        }

        // Se houver alteração
        if( (valor != procedimento['valor']) || (valor_particular != procedimento['valor_particular']) || 
            (valor_repasse != procedimento['valor_repasse']) || (percentual_repasse != procedimento['percentual_repasse']) || 
            (tempo_atendimento != procedimento['tempo_atendimento'])){
            Swal({
                title: 'Confirma alteração de valores?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim!',
                cancelButtonText: 'Não!'
            }).then((result) => {
                if (result.value) {
                    // Efetua alterações
                    $.ajax({
                        url: '/vida/profissional_procedimentos/atualizaProcedimentoProfissional',
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                            procedimento_id: procedimento_id,
                            valor: valor,
                            valor_particular: valor_particular,
                            valor_repasse: valor_repasse,
                            percentual_repasse: percentual_repasse,
                            tempo_atendimento: tempo_atendimento,
                        },
                        success: function (data) {
                            if(data['status'] == 'sucesso'){
                                Swal(
                                    'Sucesso!',
                                    'Valores alterados com sucesso!',
                                    'success'
                                ).then(() => {
                                    // Atualiza tabela
                                    tabela_procedimentos_profissional.clear().draw();
                                    tabela_procedimentos_profissional.ajax.reload();
                                });
                            }else{
                                Swal(
                                    'Erro!',
                                    'Tente novamente!',
                                    'error'
                                );
                            }
                        },
                    }); 
                }
            })
        }
    });
});