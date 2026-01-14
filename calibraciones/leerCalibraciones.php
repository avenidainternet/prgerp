<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include("../conexionli.php");
$link=Conectarse();
$outp = "";
$SQL = "SELECT * FROM calibraciones";
$bd=$link->query($SQL);
while($rs=mysqli_fetch_array($bd)){ 
  if ($outp != "") {$outp .= ",";}
  $outp .= '{"Equipo":"'  	        . $rs["Equipo"] 		    . '",';
  $outp .= '"calA":"' 		        . $rs["calA"]   	        . '",';
  $outp .= '"calB":"' 		        . $rs["calB"]   		    . '",';
  $outp .= '"EquilibrioX":"'        . $rs["EquilibrioX"]        . '",';
  $outp .= '"calC":"'               . $rs["calC"]               . '",';
  $outp .= '"calD":"'		        . $rs["calD"]    	        . '"}';
}
$outp ='{"records":['.$outp.']}';
$link->close();
echo($outp);

?>