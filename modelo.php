<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$dato = json_decode(file_get_contents("php://input"));
include("conexionli.php");
$link=Conectarse();
$sql = "SELECT * FROM movgastos WHERE nGasto = '$dato->nGasto'";
$bd  = $link->query($sql);
if($row=mysqli_fetch_array($bd)){
	if($row['efectivo'] == ''){
		$efectivo = 'on';
	}
	if($row['efectivo'] == 'on'){
		$efectivo = 'off';
	}
	if($row['efectivo'] == 'off'){
		$efectivo = 'on';
	}
	$actSQL="UPDATE movgastos SET ";
	$actSQL.="efectivo          = '".$efectivo."'";
	$actSQL.="WHERE nGasto      = '".$dato->nGasto. "'";
	$bdAct=$link->query($actSQL);
}
$link->close();
?>