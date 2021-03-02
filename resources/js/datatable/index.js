import * as $ from 'jquery';
import 'datatables.net';

export default (function () {
	$.extend( true, $.fn.dataTable.defaults, {
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
		pageLength: 10,
		dom: "Brftip",
		//aaSorting: []
	} );

	$('#dataTable').DataTable();
}());
