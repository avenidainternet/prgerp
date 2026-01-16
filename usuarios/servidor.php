<?php
	//header('Content-Type: text/html; charset=utf-8');
	include_once("../conexionli.php"); 
	
	$nomMenu 	= $_POST['nomMenu'];
	$nMenu 		= $_POST['nMenu'];
	$iconoMenu 	= $_POST['iconoMenu'];
	
/*
		$nombre_archivo = $_FILES['iconoMenu']['name'];
		$tipo_archivo 	= $_FILES['iconoMenu']['type'];
		$tamano_archivo = $_FILES['iconoMenu']['size'];
		$desde 			= $_FILES['iconoMenu']['tmp_name'];
*/	
	$link=Conectarse();
	$bdMn=$link->query("SELECT * FROM menuGrupos Where nMenu = '".$nMenu."'");
	if($rowMn=mysqli_fetch_array($bdMn)){
		$actSQL="UPDATE menuGrupos SET ";
		$actSQL.="nomMenu	='".$nomMenu.	"',";
		$actSQL.="iconoMenu	='".$iconoMenu.	"'";
		$actSQL.="WHERE nMenu	= '".$nMenu."'";
		$bdEnc=$link->query($actSQL);
	}
	$link->close();
	echo 'Guardado Menú Items...';

?>