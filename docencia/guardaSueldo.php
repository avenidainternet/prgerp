<?php
	include("conexion.php");
	$Rut = $_POST['search'];
	$link=Conectarse();
	$bdS=mysql_query("SELECT * FROM Personal WHERE Run = '".$Rut."'");
	if ($rowS=mysql_fetch_array($bdS)){
		$Paterno 	= $rowS['Paterno'];
		$Materno 	= $rowS['Materno'];
		$Nombres 	= $rowS['Nombres'];
	}
	mysql_close($link);
	$Repuesta = $Proveedor;
	echo "$Paterno,$Materno,$Nombres";
?>