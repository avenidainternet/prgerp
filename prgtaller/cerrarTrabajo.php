<?php
	$RAM = $_GET['RAM'];
	include_once("../conexionli.php");
	date_default_timezone_set("America/Santiago");
	$fechaHoy 	= date('Y-m-d');
	$link=Conectarse();
	$actSQL ="UPDATE amMuestras SET ";
	$actSQL .= "fechaTerminoTaller = '".$fechaHoy."' ";
	$actSQL .="WHERE idItem like '%".$RAM."%'";
	$bdCot=$link->query($actSQL);
	$link->close();
	echo '1';
?>
