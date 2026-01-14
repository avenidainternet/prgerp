<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("../conexioncert.php"); 
$linkc=ConectarseCert();
$outp = "";
$SQL = "SELECT * FROM clientes";
$bd=$linkc->query($SQL);
while($rs=mysqli_fetch_array($bd)){
  if ($outp != "") {$outp .= ",";}
  $outp .= '{"RutCli":"'  		. $rs["RutCli"] 		. '",';
  $outp .= '"Cliente":"'	    . trim($rs["Cliente"])      	. '"}';
}
$outp ='{"records":['.$outp.']}';
$linkc->close();
/*
$json_string = $outp;
$file = 'clientes.json';
file_put_contents($file, $json_string);
*/
echo($outp);
?>