<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php"); 
include("../conexioncert.php"); 

$link=Conectarse();
$linkc=ConectarseCert();

$outp = "";
// $SQL = "SELECT * FROM aminformes Where tpEnsayo = '5' and RutCli = '90844000-5' and imgQR != ''";
// $SQL = "SELECT * FROM aminformes Where tpEnsayo = '5' and RutCli = '$dato->RutCli' and imgQR != ''";
$SQL = "SELECT * FROM aminformes Where tpEnsayo = '5' and RutCli = '$dato->RutCli'";
$bd=$link->query($SQL);
while($rs=mysqli_fetch_array($bd)){
  $muestraInforme = 'No';
  if($rs['fechaUp'] == '0000-00-00'){
    $muestraInforme = 'Si';
  }
  if($rs['CodInforme'] == $dato->CodInforme){
    $muestraInforme = 'Si';
  }

 // if($rs['CodInforme'] == $dato->CodInforme){
 //   $muestraCertificado = 'Si';
 // }else{
    /*
        $SQLc = "SELECT * FROM certificado Where RutCli = '$dato->RutCli' and CodInforme = ''";
        $bdc=$linkc->query($SQLc);
        if($rsc=mysqli_fetch_array($bdc)){
          $muestraCertificado = 'Si'
        }
        */
  //}
  

  if($muestraInforme == 'Si'){
    if ($outp != "") {$outp .= ",";}
    $outp .= '{"RutCli":"'  		          . $rs["RutCli"] 		              . '",';
    $outp .= '"CodigoVerificacion":"'	    . $rs["CodigoVerificacion"]      	. '",';
    $outp .= '"imgQR":"'	                . $rs["imgQR"]      	            . '",';
    $outp .= '"fechaInforme":"'	          . $rs["fechaInforme"]      	      . '",';
    $outp .= '"CodInforme":"'	            . $rs["CodInforme"]      	        . '"}';
  }
}
$outp ='{"records":['.$outp.']}';
$link->close();
$linkc->close();

$json_string = $outp;
$file = 'info.json';
file_put_contents($file, $json_string);

echo($outp);
?>