<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php"); 
$link=Conectarse();
$outp = "";
$SQL = "SELECT * FROM aminformes Where RutCli = '$dato->RutCli' and imgQR != ''";
$bd=$link->query($SQL);
while($rs=mysqli_fetch_array($bd)){
  if ($outp != "") {$outp .= ",";}
  $outp .= '{"RutCli":"'  		        . $rs["RutCli"] 		            . '",';
  $outp .= '"CodigoVerificacion":"'	    . $rs["CodigoVerificacion"]      	. '",';
  $outp .= '"imgQR":"'	                . $rs["imgQR"]      	            . '",';
  $outp .= '"CodInforme":"'	            . $rs["CodInforme"]      	        . '"}';
}
$outp ='{"records":['.$outp.']}';
$link->close();
/*
$json_string = $outp;
$file = 'info.json';
file_put_contents($file, $json_string);
*/
echo($outp);
?>