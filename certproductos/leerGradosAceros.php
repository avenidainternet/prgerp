<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("../conexioncert.php"); 
$link=ConectarseCert();
$outp = "";
$SQL = "SELECT * FROM tipoaceros Where Estado = 'on'";
$bd=$link->query($SQL);
while($rs=mysqli_fetch_array($bd)){
  if ($outp != "") {$outp .= ",";}
  $outp .= '{"nAcero":"'  		        . $rs["nAcero"] 		. '",';
  $outp .= '"Acero":"'	                . $rs["Acero"]      	. '",';
  $outp .= '"Estado":"'	                . $rs["Estado"]      	. '"}';
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