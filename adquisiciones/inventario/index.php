<?php
	session_start(); 
	date_default_timezone_set("America/Santiago");

	include_once("../../app/controladores/conexionli.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		$link->close();
	}else{
		header("Location: ../../index.php"); 
	}

	
?>
<!doctype html>
 
<html lang="es">
<head>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Inventario</title>

	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../../css/tpv.css" rel="stylesheet" type="text/css">

	<link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../app/css/coloresbarra.css">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

	<style type="text/css">
		.uppercase { text-transform: uppercase; }
	</style>

</head>

<body ng-app="myApp" ng-controller="CtrlAdquisiciones"  ng-init="loadInventario()">

	<?php include('../../app/directivas/templates/head.php'); ?>
	<?php include('../../app/directivas/templates/navInventario.php'); ?>
	
	<?php include('../../app/src/inventario.php'); ?>

	<script type="text/javascript" src="../../angular/angular.js"></script>
	<script type="text/javascript" src="../../bootstrap/css/bootstrap.js"></script>

	<script src="../../app/scripts/adquisiciones.js"></script> 

</body>
</html>
