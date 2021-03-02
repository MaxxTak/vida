
$(function(){
    $('#forma_pagamento_id').change(function(e) {
        //perform AJAX call
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        var id = document.getElementById("forma_pagamento_id").value;

        if(id != ""){
            $.ajax({
                // the route pointing to the post function
                url: '/vida/numero/parcelas/'+ id,
                type: 'GET',
                // send the csrf-token and the input to the controller
               // data: {_token: CSRF_TOKEN, nome:valor},
               // dataType: 'JSON',
                // remind that 'data' is the response of the AjaxController
                success: function (data) {

                    var mySelect = $('#n_parcelas');
                    $('#n_parcelas').empty();
                    if(data.valors[0] <= 1){
                        document.getElementById("n_parcelas").style.display = "none";
                        mySelect.append(
                            $('<option></option>').attr('value', 1).text((1) + "X taxa: "+data.valors[1] + "%")
                        );
                    }else {
                        document.getElementById("n_parcelas").style.display = "block";
                        for (i=0; i < data.valors[0]; i++) {

                            mySelect.append(
                                $('<option></option>').attr('value', i+1).text((i+1) + "X taxa: "+data.valors[1]+ "%")
                            );

                        }
                    }

                }
            });
        }


    });

    /*$("#addVenda").click(function(){
        alert("The Button was clicked.");
    }); */

    $('#movParcela').click(function () {
        alert("The Button was clicked.");
    });


    $('#plano_id').change(function(e) {
        //perform AJAX call
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        var id = document.getElementById("plano_id").value;
        var user_id = document.getElementById("user_id").value;

        if (user_id==null || user_id=="")
        {
            document.getElementById("plano_id").value = "";
            alert("Por favor selecione um usuário");
            return false;
        }
        if (id==null || id=="")
        {
            alert("Por favor selecione um plano");
            return false;
        }
        if(id != ""){
            $.ajax({
                // the route pointing to the post function
                url: '/vida/valor/parcial/'+ id,
                type: 'GET',
                // send the csrf-token and the input to the controller
                 data: {user_id:user_id},
                // dataType: 'JSON',
                // remind that 'data' is the response of the AjaxController
                success: function (data) {

                    document.getElementById('valor_entrada').innerHTML ="R$ "+ data.valors[4];
                    document.getElementById('valor_plano').innerHTML ="R$ "+ data.valors[0] + " (x " + data.valors[3] +"meses)";
                    document.getElementById('n_dependentes').innerHTML = data.valors[1];
                    document.getElementById('valor_total').innerHTML ="R$ "+ data.valors[2] + " (x "+ data.valors[3] +"meses)";



                }
            });
        }


    });

});

function pagarParcela(id) {
    document.getElementById("parcela_id_modal").value = id;

    if(id != ""){
        $.ajax({
            // the route pointing to the post function
            url: '/vida/parcela/'+ id,
            type: 'GET',
            // send the csrf-token and the input to the controller
            // data: {_token: CSRF_TOKEN, nome:valor},
            // dataType: 'JSON',
            // remind that 'data' is the response of the AjaxController
            success: function (data) {
                $('#myModalTableMovimentacao').empty()

                var table = document.getElementById("myModalTableParcela");
                var row = table.insertRow(0);
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                cell1.innerHTML = id;
                cell2.innerHTML = data.valors[0];
                cell3.innerHTML = data.valors[1];
                document.getElementById("forma_pagamento_id_parcela").selectedIndex = data.valors[2];
            }
        });
    }


    $("#myModal").modal();
}

function GetFormattedDate(venc) {

    var todayTime = new Date(venc);
    //console.log("TIME: "+todayTime);

    var month = (todayTime.getMonth() + 1);

    var day = (todayTime.getDate() + 1);

    var year = (todayTime.getFullYear());

    return day + "/" + month + "/" + year;

}

function movDeletar(id) {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    Swal({
        title: 'Exclusão!',
        text: 'Deseja Excluir esta movimentação?',
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
                // the route pointing to the post function
                url: '/vida/ajax/deletar/movimentacao',
                type: 'POST',
                // send the csrf-token and the input to the controller
                data: {_token: CSRF_TOKEN, id:id},
                dataType: 'JSON',
                // remind that 'data' is the response of the AjaxController
                success: function (data) {
                    // console.log(data);
                    $("#myModal").modal('hide');
                    location.reload();
                },
                error: function (e) {
                    console.log(e);
                }
            });
        }
    });


}

function abrirParcela(id) {
    document.getElementById("movimentacao_id_modal").value = id;

    if(id != ""){
        $.ajax({
            // the route pointing to the post function
            url: '/vida/movimentacao/'+ id,
            type: 'GET',
            // send the csrf-token and the input to the controller
            // data: {_token: CSRF_TOKEN, nome:valor},
            // dataType: 'JSON',
            // remind that 'data' is the response of the AjaxController
            success: function (data) {
               // console.log(data);
                $('#myModalTableMovimentacao').empty();

                var n = data.valors.parcelas.length;
                var table = document.getElementById("myModalTableMovimentacao");


                for (i=0; i< n; i++) {
                    var row = table.insertRow(i);
                    var cell1 = row.insertCell(0); // id
                    var cell2 = row.insertCell(1);// Nome da pessoa
                    var cell3 = row.insertCell(2);// valor
                    var cell4 = row.insertCell(3); //data
                    var cell5 = row.insertCell(4);// opções
                    var cell6 = row.insertCell(5);// delete
                    cell1.innerHTML = data.valors.parcelas[i].id;
                    cell2.innerHTML = data.valors.pessoa.user.name;
                    cell3.innerHTML = "R$ " + data.valors.parcelas[i].valor;
                    cell4.innerHTML =  GetFormattedDate(data.valors.parcelas[i].data_vencimento);
                    var btn = document.createElement('button');
                    btn.type = "button";

                    btn.id="movParcela";
                    btn.name="movParcela";
                    btn.value = data.valors.parcelas[i].id;
                    if((data.valors.parcelas[i].status != 2)&&(data.valors.parcelas[i].status != 3)){
                        btn.className = "btn btn-success btn-sm ti-money";
                        btn.title="Pagar Parcela";
                        btn.onclick=  function() { movPagarParcela(this.value); };

                    }else if(data.valors.parcelas[i].status == 2){
                        btn.className = "btn btn-warning btn-sm ti-money";
                        btn.title="Estornar Parcela";
                        btn.onclick=  function() { movEstornarParcela(this.value); };
                    }
                    cell5.appendChild(btn);

                    let btn2 = document.createElement('button');
                    btn2.type = "button";

                    btn2.id="movParcelaDel";
                    btn2.name="movParcelaDel";
                    btn2.value = data.valors.parcelas[i].id;
                    btn2.className = "btn btn-danger btn-sm ti-trash";
                    btn2.title="DELETAR Parcela";
                    btn2.onclick=  function() { movDeletarParcela(this.value); };
                    cell6.appendChild(btn2);


                }

                //=============================== mensalidade =========================================
                //myModalTableMovimentacao2

                var n = data.valors.movimentacao == null ? 0 : data.valors.movimentacao.parcelas.length;
                var table = document.getElementById("myModalTableMovimentacao2");

               // console.log(data);
                for (i=0; i< n; i++) {
                    var row = table.insertRow(i);
                    var cell1 = row.insertCell(0);
                    var cell2 = row.insertCell(1);
                    var cell3 = row.insertCell(2);
                    var cell4 = row.insertCell(3);
                    var cell5 = row.insertCell(4);// opções
                    cell1.innerHTML = data.valors.movimentacao.parcelas[i].id;
                    cell2.innerHTML = data.valors.pessoa.user.name;
                    cell3.innerHTML = data.valors.movimentacao.parcelas[i].valor;
                    cell4.innerHTML =  GetFormattedDate(data.valors.movimentacao.parcelas[i].data_vencimento);
                    var btn = document.createElement('button');
                    btn.type = "button";

                    btn.id="movParcela";
                    btn.name="movParcela";
                    btn.value = data.valors.movimentacao.parcelas[i].id;
                    if((data.valors.movimentacao.parcelas[i].status != 2)&&(data.valors.movimentacao.parcelas[i].status != 3)){
                        btn.className = "btn btn-success btn-sm ti-money";
                        btn.title="Pagar Parcela";
                        btn.onclick=  function() { movPagarParcela(this.value); };

                    }else if(data.valors.movimentacao.parcelas[i].status == 2){
                        btn.className = "btn btn-danger btn-sm ti-trash";
                        btn.title="Estornar Parcela";
                        btn.onclick=  function() { movEstornarParcela(this.value); };
                    }
                    cell5.appendChild(btn);


                }


            }
        });
    }
    $("#myModal").modal();
}

function movPagarParcela(id) {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        // the route pointing to the post function
        url: '/vida/ajax/parcela',
        type: 'POST',
        // send the csrf-token and the input to the controller
        data: {_token: CSRF_TOKEN, id:id},
        dataType: 'JSON',
        // remind that 'data' is the response of the AjaxController
        success: function (data) {
           // console.log(data);
            $("#myModal").modal('hide');
            location.reload();
        },
        error: function (e) {
            console.log(e);
        }
    });


}

function movDeletarParcela(id) {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    Swal({
        title: 'Exclusão!',
        text: 'Deseja Excluir esta parcela?',
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
                // the route pointing to the post function
                url: '/vida/ajax/deletar/parcela',
                type: 'POST',
                // send the csrf-token and the input to the controller
                data: {_token: CSRF_TOKEN, id:id},
                dataType: 'JSON',
                // remind that 'data' is the response of the AjaxController
                success: function (data) {
                    // console.log(data);
                    $("#myModal").modal('hide');
                    location.reload();
                },
                error: function (e) {
                    console.log(e);
                }
            });
        }
    });

}

function movEstornarParcela(id) {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        // the route pointing to the post function
        url: '/vida/ajax/estornar/parcela',
        type: 'POST',
        // send the csrf-token and the input to the controller
        data: {_token: CSRF_TOKEN, id:id},
        dataType: 'JSON',
        // remind that 'data' is the response of the AjaxController
        success: function (data) {
           // console.log(data);
            $("#myModal").modal('hide');
            location.reload();
        },
        error: function (e) {
            console.log(e);
        }
    });

}


function myPostParcela() {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var id = document.getElementById("parcela_id_modal").value;
    var fpg = document.getElementById("forma_pagamento_id_parcela").value;
  //  console.log(id);
  //  console.log(fpg);

    $.ajax({
        // the route pointing to the post function
        url: '/vida/ajax/parcela',
        type: 'POST',
        // send the csrf-token and the input to the controller
        data: {_token: CSRF_TOKEN, id:id, forma_pagamento:fpg},
        dataType: 'JSON',
        // remind that 'data' is the response of the AjaxController
        success: function (data) {
          //  console.log(data);
            $("#myModal").modal('hide');
            location.reload();
        },
        error: function (e) {
            console.log(e);
        }
    });


}
