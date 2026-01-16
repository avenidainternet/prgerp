<?php
	include_once("../conexionli.php");
	$Rut = $_POST['search'];
	$link=Conectarse();
	$bdS=$link->query("SELECT * FROM Personal WHERE Run = '".$Rut."'");
	if ($rowS=mysqli_fetch_array($bdS)){
		$Paterno 	= $rowS['Paterno'];
		$Materno 	= $rowS['Materno'];
		$Nombres 	= $rowS['Nombres'];
	}
	$link->close();
	$Repuesta = $Proveedor;
	echo "$Paterno,$Materno,$Nombres";
?>