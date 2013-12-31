
function calculaDigito(valores) {
         pesos = new Array(1, 2, 4, 8, 5, 10, 9, 7, 3, 6);
         d = 0;
         for (i=0; i<=9; i++) {
           d += parseInt(valores.charAt(i)) * pesos[i];
         }
         d = 11 - (d % 11);
         if (d==11) d=0;
         if (d==10) d=1;
         return d;
}

function calcularDC(banco,entidad,cuenta){
        banco = banco.toString();
        entidad = entidad.toString();
        cuenta = cuenta.toString();
        d1 = calculaDigito('00'+banco+entidad);
        d2 = calculaDigito(cuenta);
        return d1.toString()+d2.toString();
}

var banco = "2100";
var entidad = "0509";
var cuenta = "0100050958";

console.log(calcularDC(banco,entidad,cuenta));

// Modulo 97 for huge numbers given as digit strings.
function mod97(digit_string)
{
  var m = 0;
  for (var i = 0; i < digit_string.length; ++i)
    m = (m * 10 + parseInt(digit_string.charAt(i))) % 97;
  return m;
}

function capital2digits(ch)
{
  var capitals = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  for (var i = 0; i < capitals.length; ++i)
    if (ch == capitals.charAt(i))
      break;
  return i + 10;
}

function calcIBANforSpain(banco, entidad, dc, cuenta){
    //Adapted from http://toms-cafe.de/iban/iban.js
  var code     = 'ES';
  var bban     = banco.trim() + entidad.trim() + dc.trim() + cuenta.trim()

  // Assemble digit string
  var digits = "";
  for (var i = 0; i < bban.length; ++i)
  {
    var ch = bban.charAt(i).toUpperCase();
    if ("0" <= ch && ch <= "9")
      digits += ch;
    else
      digits += capital2digits(ch);
  }
  for (var i = 0; i < code.length; ++i)
  {
    var ch = code.charAt(i);
    digits += capital2digits(ch);
  }

  checksum = 98 - mod97(digits);
  return code + checksum + bban;
}

