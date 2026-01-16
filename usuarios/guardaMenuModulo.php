<?php
	//header('Content-Type: text/html; charset=utf-8');
	include_once("../conexionli.php"); 
	
	$nMenu 		= $_POST['nMenu'];
	$nModulo 	= $_POST['nModulo'];
	$titulo 	= $_POST['titulo'];
	$enlace		= $_POST['enlace'];
	$iconoMod 	= $_POST['iconoMod'];
	
/*
		$nombre_archivo = $_FILES['iconoMenu']['name'];
		$tipo_archivo 	= $_FILES['iconoMenu']['type'];
		$tamano_archivo = $_FILES['iconoMenu']['size'];
		$desde 			= $_FILES['iconoMenu']['tmp_name'];
*/	
	$link=Conectarse();
	$bdMn=$link->query("SELECT * FROM menuItems Where nMenu = '".$nMenu."' and nModulo = '".$nModulo."'");
	if($rowMn=mysqli_fetch_array($bdMn)){
		$actSQL="UPDATE menuItems SET ";
		$actSQL.="nModulo	='".$nModulo.	"',";
		$actSQL.="titulo	='".$titulo.	"',";
		$actSQL.="enlace	='".$enlace.	"',";
		$actSQL.="iconoMod	='".$iconoMod.	"'";
		$actSQL.="WHERE nMenu	= '".$nMenu."' and nModulo = '".$nModulo."'";
		$bdEnc=$link->query($actSQL);
	}
	$link->close();
	echo 'Guardado Módulo del Items...';

?>