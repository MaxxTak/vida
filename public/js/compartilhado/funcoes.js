function addCommas(nStr) {
    nStr += '';
    var x = nStr.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + '.' + '$2');
    }
    return x1 + x2;
}
  
function formataNumero(numero){
    return addCommas(parseFloat(numero).toFixed(2).replace(',', '').replace('.', ','));
}

function formataNumeroController(numero){
    return addCommas(parseFloat(numero.replace(',', '')).toFixed(2).replace('.', ','));
}

function getParameterByName(name){
    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regexS = "[\\?&]" + name + "=([^&#]*)";
    var regex = new RegExp(regexS);
    var results = regex.exec(window.location.search);
    if(results == null)
        return "";
    else
        return decodeURIComponent(results[1].replace(/\+/g, " "));
}

// EMAIL
function randomEmail(){
    var chars = 'abcdefghijklmnopqrstuvwxyz1234567890';
    var string = '';
    for(var ii=0; ii<10; ii++){
        string += chars[Math.floor(Math.random() * chars.length)];
    }

    return string + '@email-aleatorio.com.br';
}


// CPF
function gerarCpf() {
  const n1 = aleatorio(), n2 = aleatorio(), n3 = aleatorio(), d1 = dig(n1, n2, n3);
  return `${n1}${n2}${n3}${d1}${dig(n1, n2, n3, d1)}`;
}

function dig(n1, n2, n3, n4) { 
  let nums = n1.split("").concat(n2.split(""), n3.split("")), x = 0;    
  if (n4) nums[9] = n4;
  for (let i = (n4 ? 11:10), j = 0; i >= 2; i--, j++) x += parseInt(nums[j]) * i;
  return (y = x % 11) < 2 ? 0 : 11 - (y = x % 11); 
}

function aleatorio() {
  return ("" + Math.floor(Math.random() * 999)).padStart(3, '0'); 
}