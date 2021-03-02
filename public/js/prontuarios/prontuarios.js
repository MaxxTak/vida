$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#especialidade_id").select2({
        width: '100%'
    });

    $("#campos").select2({
        width: '100%'
    });

    // Table Campos Prontuario
    var tabela_campos_prontuario = $('#tabela-campos').DataTable({
        responsive: true,
        autoWidth: false,
		ordering: true,
        searching: true,
        rowReorder: {
            dataSrc: 'sequencial',
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
            { data: 'sequencial' },
            { data: 'descricao' },
            { data: 'campo' },
            { data: '' }
        ],
        columnDefs:[
            { 
                targets: 3,
                data: null,
                defaultContent: '<ul class="list-inline">' +
                                    '<li class="list-inline-item">' +
                                        '<button class="btn btn-danger btn-sm"><span class="ti-trash" title="Remover"></span></button>' +
                                    '</li>' +
                                '</ul>'
            }
        ],
		pageLength: 10,
        dom: "rftip",
    });

    // Adicionar Campo Prontuário
    $('#btnAdicionarCampo').on('click', function(){
        var campo = $('#campos').select2('data')[0];

        // Verifica se campo já não está adicionado
        var indexes = tabela_campos_prontuario.rows().indexes();
        var contem = false;
        var sequencial = 0;

        if(indexes.count() > 0){
            indexes.each(function(index){
                var campos = tabela_campos_prontuario.row( index ).data();

                if(campos['campo'] == campo.id)
                    contem = true;
                
                if(campos['sequencial'] > sequencial)
                sequencial = campos['sequencial'];
            });
        }

        if(contem){
            Swal({
                title: 'Campo já cadastrado para o prontuário.',
                text: 'Faça a alteração acima.',
                type: 'error'
            });
        }else{
            sequencial = sequencial + 1;
            var campo_prontuario = {
                'sequencial': sequencial,
                'campo': campo.id,
                'descricao': campo.text,
            };

            tabela_campos_prontuario.row.add(campo_prontuario).draw();
        }
    });

    // Remover Campo Prontuário
    $('#tabela-campos tbody').on('click', 'button', function () {
        // Busca Campo
        var row = tabela_campos_prontuario.row($(this).parents('tr'));
        var campo = row.data();

        if (typeof campo == "undefined") {
            row = tabela_campos_prontuario.row(this);
            campo = row.data();
        }

        Swal({
            title: campo['descricao'],
            text: 'Confirma exclusão do campo?',
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
                tabela_campos_prontuario.row(row).remove().draw();
            }
        });
    });

    // Gravar Prontuário
    $('#btnEnviar').on('click', function(){
        if(jQuery.isEmptyObject($('#descricao').val())){
            Swal({
                title: 'Descrição inválida.',
                text: 'Digite uma descrição acima.',
                type: 'error'
            });
            return false;
        }

        if(!$('#especialidade_id').val()){
            Swal({
                title: 'Nenhuma especialidade selecionada.',
                text: 'Selecione uma especialidade acima.',
                type: 'error'
            });
            return false;
        }

        var campos = tabela_campos_prontuario.rows().data().toArray();

        if (campos.length == 0) {
            Swal({
                title: 'Nenhum campo selecionado.',
                text: 'Selecione os campos para o prontuário acima.',
                type: 'error'
            });
            return false;
        }

        $.ajax({
            url: '/vida/prontuarios',
            type: 'POST',
            dataType: 'JSON',
            data: {
                especialidade_id: $('#especialidade_id').val(),
                descricao: $('#descricao').val(),
                campos: campos
            },
            success: function (response) {
                if(response['status'] == 'sucesso'){
                    Swal({
                        title: response['prontuario']['descricao'],
                        text: 'Prontuário cadastrado com sucesso',
                    });

                    $('#especialidade_id').val(null).trigger('change');
                    $('#descricao').val('');
                    tabela_campos_prontuario.clear().draw();
                }
            },
            error: function (response) {
                console.log(response);
            }
        });
    });
});