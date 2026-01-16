<?php
	$dato = json_decode(file_get_contents("php://input"));

	include_once("conexion.php");
	$link=Conectarse();
	$bdMu=mysql_query("SELECT * FROM formram Where RAM = '".$dato->RAM."'");
	if($rowMu=mysql_fetch_array($bdMu)){
		$actSQL="UPDATE formram SET ";
		$actSQL.="Obs	   		= '".$dato->Obs.		"', ";
		$actSQL.="Taller	   	= '".$dato->Taller.		"', ";
		$actSQL.="nMuestras	   	= '".$dato->nMuestras.	"' ";
		$actSQL.="WHERE RAM 	= '".$dato->RAM."'";
		$bdOt=mysql_query($actSQL);
	}
	mysql_close($link);
	echo '{"msg":"Datos Actualizados"}';		
?>