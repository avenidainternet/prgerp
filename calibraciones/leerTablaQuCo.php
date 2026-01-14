<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include("../conexionli.php");
$link=Conectarse();
$outp = "";
$SQL = "SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Co'";
$bd=$link->query($SQL);
while($rs=mysqli_fetch_array($bd)){
  if ($outp != "") {$outp .= ",";}
  $outp .= '{"idEnsayo":"'  	. $rs["idEnsayo"] 		. '",';
  $outp .= '"tpMuestra":"' 		. $rs["tpMuestra"]   	. '",';
  $outp .= '"Simbolo":"' 		. $rs["Simbolo"]   		. '",';
  $outp .= '"valorDefecto":"' 	. $rs["valorDefecto"]   . '",';
  $outp .= '"imprimible":"'		. $rs["imprimible"]    	. '"}';
}
$outp ='{"records":['.$outp.']}';
$link->close();
echo($outp);

?>