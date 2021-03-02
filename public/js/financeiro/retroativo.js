$(document).ready(function(){
    $("#n_parcelas").focusin(function(){
        $(this).css("background-color", "#FFFFCC");
    });
    $("#n_parcelas").focusout(function(){
        var parcelas =  document.getElementById("n_parcelas").value;
        $('#parcelas_table').empty()
        var table = document.getElementById("parcelas_table");

        for (i = 0; i < parcelas; i++) {

            var row = table.insertRow(0);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            cell1.innerHTML = i +1;
            cell2.innerHTML = '<input id="valor_'+i+'" type="number" step="0.01" min="0" class="form-control" name="valor_'+i+'" placeholder="Valor" value="" required>';
            cell3.innerHTML = '<input id="parcela_'+i+'" type="date" class="form-control" name="parcela_'+i+'" value="" required>';

        }

        document.getElementById("parcelas_table").style.display = "block";
        console.log(parcelas);
        $(this).css("background-color", "#FFFFFF");
    });
});