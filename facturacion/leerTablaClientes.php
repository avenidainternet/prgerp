<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include("../conexionli.php");
$Periodo = date('Y');
$output = [];
$link=Conectarse();
$outp = "";
$SQL = "SELECT * FROM clientes Order By Cliente";
$bd=$link->query($SQL);
while($rs=mysqli_fetch_array($bd)){
	$output[] = $rs;	
}
$link->close();
echo json_encode($output);
?>