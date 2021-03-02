/*$(function() {
    alert("passou");
    $('#btn_cadastrar').on('click', function() {
        document.location = "/vida/teste";
    });
});*/
$(document).ready( function () {

    $('body').on('click', '.btn-remover', function () {
        var num_items = $('.origem').length;
        if (num_items > 1) {
            $(this).parent().remove();
        }
    });

    window.duplicarCampos = function (div) {
        $("." + div)
            .last()
            .clone()
            .appendTo($(".destino"))
            .find("input").val("").end();
        return false;
    };


    $(window).keydown(function(event){
        if(event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    $("#Pessoal").css("display", "block");
   // $('#empresas').DataTable();

    function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        $("#endereco").val("");
        $("#bairro").val("");
        $("#cidade").val("");
        $("#uf").val("");

    }

    //Quando o campo cep perde o foco.
    $("#cep").blur(function() {

        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                $("#endereco").val("...");
                $("#bairro").val("...");
                $("#cidade").val("...");
                $("#uf").val("...");


                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#endereco").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        $("#cidade").val(dados.localidade);
                        $("#uf").val(dados.uf);

                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulário_cep();
                        alert("CEP não encontrado.");
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    });
});

function openCity(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}

function inativarPessoa(id){
    Swal({
        title: 'Inativar!',
        text: 'Deseja inativar esta pessoa?',
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
            console.log(id);
            // Altera status da pessoa
            $.ajax({
                url: '/vida/inativar/pessoa/' + id,
                type: 'GET',
                dataType: 'JSON',
                data: {},
                success: function (data) {
                    //window.location.reload();
                    console.log("sucesso");
                    location.reload();
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }


    });
}

function myCreateFunction(id,nome,documento) {
    document.getElementById("botaoTitular").style.display = "none";
   // document.getElementById("botaoDependente").style.display = "none";
    document.getElementById("delete").style.display = "block";
    var table = document.getElementById("myTable");
    var row = table.insertRow(0);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    cell1.innerHTML = id;
    cell2.innerHTML = nome;
    cell3.innerHTML = documento;

    document.getElementById("titular").value = id;
}

function addDependentes(id) {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    console.log(id);
    let id_titular = id;
    let id_dependente = $('#idTitular').val();
    console.log(id_titular)

    $.ajax({
        // the route pointing to the post function
        url: '/addDependente',
        type: 'POST',
        // send the csrf-token and the input to the controller
        data: {_token: CSRF_TOKEN, id_dependente:id_dependente, id_titular: id_titular},
        dataType: 'JSON',
        // remind that 'data' is the response of the AjaxController
        success: function (data) {
            console.log(data)
            console.log("Ok3")
            window.location.reload(true);
        },
        error: function (error){
            console.log(error)
        }
    });

};

function setarId(id){
    console.log(id);
    $('#idTitular').val(id);

}


function empresaCreate(id,nome,documento) {
    document.getElementById("botaoEmpresa").style.display = "none";
    document.getElementById("deleteEmpresa").style.display = "block";
    var table = document.getElementById("myEmpresaAddTable");
    var row = table.insertRow(0);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    cell1.innerHTML = id;
    cell2.innerHTML = nome;
    cell3.innerHTML = documento;

    document.getElementById("empresa_id").value = id;
}

function myDeleteEmpresaFunction() {
    document.getElementById("botaoEmpresa").style.display = "block";
    document.getElementById("deleteEmpresa").style.display = "none";
    document.getElementById("myEmpresaAddTable").deleteRow(0);
    document.getElementById("empresa_id").value = "";
}

function myDeleteFunction() {
    document.getElementById("botaoTitular").style.display = "block";
  //  document.getElementById("botaoDependente").style.display = "block";
    document.getElementById("delete").style.display = "none";
    document.getElementById("myTable").deleteRow(0);
    document.getElementById("titular").value = "";
}


function myDeleteDependenteFunction() {
    var count = $('#myDependenteTable tr').length;
    var caux = count;
    count -=1;
    if(count==0){
        document.getElementById("deleteDependente").style.display = "none";
        document.getElementById("myDependenteTable").deleteRow(0);
        document.getElementById("contador").value = count;
        document.getElementById("botaoTitular").style.display = "block";
        $("#dependenteNome_"+caux).remove();
        $("#dependenteDocumento_"+caux).remove();
    }else if(count > 0){
        document.getElementById("myDependenteTable").deleteRow(0);
        document.getElementById("contador").value = count;
        $("#dependenteNome_"+caux).remove();
        $("#dependenteDocumento_"+caux).remove();
    }


}

function buscarTitular() {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

   /* var count = $('#myModalTable tr').length;
    console.log("cont"+count);
    if(count > 0){
        var i=0;
        for(i=0;i< (count);i++){
            document.getElementById("myModalTable").deleteRow(i);
        }

    }*/
    $("#myModalTable tr").remove();

    var valor = document.getElementById("nome").value;
    console.log(valor);
    $.ajax({
        // the route pointing to the post function
        url: '/ajax',
        type: 'POST',
        // send the csrf-token and the input to the controller
        data: {_token: CSRF_TOKEN, nome:valor},
        dataType: 'JSON',
        // remind that 'data' is the response of the AjaxController
        success: function (data) {
            console.log(data.valors);
            var table = document.getElementById("myModalTable");
            for (row in data.valors) {
                console.log(data.valors[row].name);
                var nome = data.valors[row].name;
                var id = data.valors[row].id;
                var documento = data.valors[row].cnpjcpf;
                var row = table.insertRow(0);
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                cell1.innerHTML = id;
                cell2.innerHTML = nome;
                cell3.innerHTML = documento;
                cell4.innerHTML = '<button class="btn btn-sm btn-success" onclick="myCreateFunction('+ id +','+ '\''+nome + '\''+',' + '\''+ documento+ '\'' +')" data-dismiss="modal">Adicionar</button>';
            }

           /* $('#fk_valors_'+(idc)).empty(); // clear the current elements in select box
            for (row in data.valors) {
                $('#fk_valors_'+(idc)).append($('<option></option>').attr('value', data.valors[row].id).text(data.valors[row].valor));
            }*/
        }
    });
}

function buscarDependente() {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $("#myModalTable tr").remove();

    var valor = $('#nome_documento').val(); //document.getElementById("nome_documento").value;
    console.log(valor);
    $.ajax({
        // the route pointing to the post function
        url: '/ajax',
        type: 'POST',
        // send the csrf-token and the input to the controller
        data: {_token: CSRF_TOKEN, nome:valor},
        dataType: 'JSON',
        // remind that 'data' is the response of the AjaxController
        success: function (data) {
            console.log(data.valors);
            var table = document.getElementById("myModalTable");
            for (row in data.valors) {
                var nome = data.valors[row].name;
                var id = data.valors[row].id;
                var documento = data.valors[row].cnpjcpf;
                var row = table.insertRow(0);
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                cell1.innerHTML = id;
                cell2.innerHTML = nome;
                cell3.innerHTML = documento;
                cell4.innerHTML = '<button class="btn btn-sm btn-success" onclick="addDependentes('+ id +')">Adicionar</button>';
            }

            /* $('#fk_valors_'+(idc)).empty(); // clear the current elements in select box
             for (row in data.valors) {
                 $('#fk_valors_'+(idc)).append($('<option></option>').attr('value', data.valors[row].id).text(data.valors[row].valor));
             }*/
        }
    });
}

function buscarEmpresa() {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $("#myModalTable tr").remove();

    var valor = document.getElementById("empresa").value;
    console.log(valor);
    $.ajax({
        // the route pointing to the post function
        url: '/vida/ajax/empresa',
        type: 'POST',
        // send the csrf-token and the input to the controller
        data: {_token: CSRF_TOKEN, empresa:valor},
        dataType: 'JSON',
        // remind that 'data' is the response of the AjaxController
        success: function (data) {
            console.log(data.valors);
            var table = document.getElementById("myEmpresaTable");
            for (row in data.valors) {
                console.log(data.valors[row].name);
                var nome = data.valors[row].name;
                var id = data.valors[row].id;
                var documento = data.valors[row].cnpjcpf;
                var row = table.insertRow(0);
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                cell1.innerHTML = id;
                cell2.innerHTML = nome;
                cell3.innerHTML = documento;
                cell4.innerHTML = '<button class="btn btn-sm btn-success" onclick="empresaCreate('+ id +','+ '\''+nome + '\''+',' + '\''+ documento+ '\'' +')" data-dismiss="modal">Adicionar</button>';
            }

        }
    });
}

function adicionarDependente() {
    var a = document.getElementById("dep_nome").value;
    var b = document.getElementById("dep_nasc").value;
    var c = document.getElementById("dep_ordem").value;
    var d = document.getElementById("dep_tel").value;
    var e = document.getElementById("dep_parentesco").value;
    var f = document.getElementById("dep_resp").value;
    if (a==null || a=="",b==null || b=="",c==null || c=="",d==null || d=="",e==null || e=="",f==null || f=="" )
    {
        alert("Preencha todos os campos!");
        return false;
    }

    var x = document.createElement("INPUT");
    var pessoal = document.getElementById("Pessoal");
    var count = $('#myDependenteTable tr').length;
    count +=1;
    document.getElementById("contador").value = count;

    $('<input>').attr({
        type: 'hidden',
        id: "dependenteNome_"+count,
        name: "dependenteNome_"+count,
        value: a
    }).appendTo('formCadastro');

    x.setAttribute("id", "dependenteNome_"+count);
    x.setAttribute("name", "dependenteNome_"+count);
    x.setAttribute("type", "hidden");
    x.setAttribute("value", a);
    pessoal.appendChild(x);

    var y = document.createElement("INPUT");

    y.setAttribute("id", "dependenteNasc_"+count);
    y.setAttribute("name", "dependenteNasc_"+count);
    y.setAttribute("type", "hidden");
    y.setAttribute("value", b);
    pessoal.appendChild(y);

    var z = document.createElement("INPUT");

    z.setAttribute("id", "dependenteOrdem_"+count);
    z.setAttribute("name", "dependenteOrdem_"+count);
    z.setAttribute("type", "hidden");
    z.setAttribute("value", c);
    pessoal.appendChild(z);

    var t = document.createElement("INPUT");

    t.setAttribute("id", "dependenteTelefone_"+count);
    t.setAttribute("name", "dependenteTelefone_"+count);
    t.setAttribute("type", "hidden");
    t.setAttribute("value", d);
    pessoal.appendChild(t);

    var u = document.createElement("INPUT");

    u.setAttribute("id", "dependenteParentesco_"+count);
    u.setAttribute("name", "dependenteParentesco_"+count);
    u.setAttribute("type", "hidden");
    u.setAttribute("value", e);
    pessoal.appendChild(u);

    var v = document.createElement("INPUT");

    v.setAttribute("id", "dependenteResponsavel_"+count);
    v.setAttribute("name", "dependenteResponsavel_"+count);
    v.setAttribute("type", "hidden");
    v.setAttribute("value", f);
    pessoal.appendChild(v);

    document.getElementById("deleteDependente").style.display = "block";

    var table = document.getElementById("myDependenteTable");
    var row = table.insertRow(0);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    cell1.innerHTML =a ;
    cell2.innerHTML = b;
    cell3.innerHTML = c;
    document.getElementById("botaoTitular").style.display = "none";
    document.getElementById("dep_nome").value = "";
    document.getElementById("dep_nasc").value = "";
    document.getElementById("dep_ordem").value = "";
    document.getElementById("dep_tel").value = "";
    document.getElementById("dep_parentesco").value = "";
    document.getElementById("dep_resp").value = "";
}


function abrirPermissoes(id) {
    if(id != ""){

        $.ajax({
            // the route pointing to the post function
            url: '/vida/permissao/buscar/'+ id,
            type: 'GET',
            // send the csrf-token and the input to the controller
            // data: {_token: CSRF_TOKEN, nome:valor},
            // dataType: 'JSON',
            // remind that 'data' is the response of the AjaxController
            success: function (data) {
                $('#myModalTableGrupo').empty()

                var table = document.getElementById("myModalTableGrupo");

                //      btn.value = entry.email;
                //       td.appendChild(btn);
                if(data.valors){
                    var row = table.insertRow(0);
                    var cell1 = row.insertCell(0);
                    cell1.innerHTML = data.valors[1];

                    var row2 = table.insertRow(0);
                    var cell12 = row2.insertCell(0);
                    cell12.innerHTML = data.valors[0];


                    $('#myModalTablePermissao').empty()

                    var table2 = document.getElementById("myModalTablePermissao");

                    //      btn.value = entry.email;
                    //       td.appendChild(btn);
                    n = data.valors[2].length;
                    var i =0;
                    for(i=0;i<n;i++){
                        var rowT2 = table2.insertRow(0);
                        var cell1T2 = rowT2.insertCell(0);
                        cell1T2.innerHTML = data.valors[2][i];
                    }
                }


            }
        });
    }
    $("#myModalPermissao").modal();
}
