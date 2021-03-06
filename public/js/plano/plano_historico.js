$(document).ready(function(){
    $('#tabela-planos').DataTable({
        responsive: true,
        autoWidth: false,
		ordering: true,
		searching: true,
        //select: true,
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
                    $(win.document.body).prepend('<h1> ' + $('#idPlano').text() + ' </h1>');
                    $(win.document.body).prepend('<h1> Histórico de Alteração de Valores </h1>');
                    $(win.document.body).find('h1').css('text-align','center');
                    $(win.document.body).find('h1').css('font-size','18px');
                    $(win.document.body).find( 'table' ).addClass( 'compact' ).css( 'font-size', 'inherit' );
                }
            }
        ],
        columnDefs:[
            {
                targets: [1, 2],
                render: {
                    _: function ( data, type, row, meta ) {
                        return 'R$ ' + data.replace('.', ',');
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
                        moment.locale('pt-br'); 
                        return moment(data).format('llll');
                    },
                    sort: function(data, type, row, meta){
                        return data;
                    }
                }
            }
        ],
		pageLength: 10,
        dom: "Brftip",
        order: [0, 'desc']
    });
});