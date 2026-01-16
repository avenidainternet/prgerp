<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include("../conexionli.php");
$Periodo = date('Y');
$link=Conectarse();
$outp = "";
$SQL = "SELECT * FROM tablaregform";
$bd=$link->query($SQL);
while($rs=mysqli_fetch_array($bd)){
  if ($outp != "") {$outp .= ",";}
  $outp .= '{"valorUFRef":"'.$rs["valorUFRef"].'",';
  $outp .= '"valorUSRef":"'.$rs["valorUSRef"].'"}';
}
$link->close();
echo $outp;
?>