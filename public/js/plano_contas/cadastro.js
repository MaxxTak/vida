$(document).ready(function(){
    $('#classificacao').mask('0.0.00.00.0000');
    $('#juros').mask('#.##0,00', {reverse: true});
    $('#multa').mask('#.##0,00', {reverse: true});
    $('#mora').mask('#.##0,00', {reverse: true});
    $('#desconto').mask('#.##0,00', {reverse: true});
});