$(window).on('load', function(){
    Swal({
        title: 'Sucesso!',
        text: 'Deseja atribuir plano?',
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: 'null',
        cancelButtonColor: 'null',
        confirmButtonClass: 'btn btn-danger',
        cancelButtonClass: 'btn btn-primary',
        confirmButtonText: 'Sim!', // Oui, sûr
        cancelButtonText: 'Cancelar', // Annuler
    }).then(res => {
        if (res.value) {
            var id = document.getElementById("id");
            console.log(id.value);
            window.open('/vida/venda?user_id='+id.value,
                '_self');
        }else{
            window.setTimeout(function(){
                window.location.href = '/vida/pessoa?tipo=2';
            }, 1000);
        }

    });

});