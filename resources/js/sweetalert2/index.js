import * as $ from 'jquery';
import swal from 'sweetalert2';

export default (function () {
    $(document).on('click', "form.delete button", function(e) {
        var _this = $(this);
        e.preventDefault();
        swal({
            title: 'Tem certeza?', // Opération Dangereuse
            text: 'Deseja continuar ?', // Êtes-vous sûr de continuer ?
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
                _this.closest("form").submit();
            }
        });
    });
}())
