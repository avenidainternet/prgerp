<?php
	session_start(); 
	include_once("conexion.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=mysql_query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysql_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		mysql_close($link);
	}else{
		header("Location: ../index.php");
	}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>M&oacute;dulo Administración de RAMs</title>
<!--
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
-->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<link href="styles.css" rel="stylesheet" type="text/css">
<link href="../css/tpv.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
<!--
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
-->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
</head>
<body>
	<?php include('head.php'); ?>
	<!-- Navigation -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
		<div class="container-fluid">
			<form class="form-inline" action="pOtams.php?RAM=" method="get">
		    	<input class="form-control mr-sm-2" type="text" name="RAM" placeholder="Buscar RAM">
		    	<button class="btn btn-success" type="submit">Buscar</button>
		  	</form>
  	    	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
	          <span class="navbar-toggler-icon"></span>
	        </button>
	    	<div class="collapse navbar-collapse" id="navbarResponsive">
	      		<ul class="navbar-nav ml-auto">
	        		<li class="nav-item active">
	          			<a class="nav-link fa fa-home" href="../plataformaErp.php"> Principal
	                	<span class="sr-only">(current)</span>
	              		</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link far fa-file-alt" href="../cotizaciones/plataformaCotizaciones.php"> Proceso</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="cerrarsesion.php"> Cerrar</a>
	        		</li>

	      		</ul>
	    	</div>
	  	</div>
	</nav>

	<div ng-app="myApp" ng-controller="myCtrl">
	
	<?php include_once('muestraOTAMs.php'); ?>

	</div>

<script>
	var mDatos = angular.module('myApp', []);
	mDatos.controller('myCtrl', function($scope, $http){
	$scope.res="Bienvenido aquí se mostrara el resultado de sus Acciones"; 
	/*
	$scope.modi = function(){
		if($scope.RAM){
	    	$http.post('mMuestras.php',{accion:2, RAM:$scope.RAM, Obs:$scope.Obs, nMuestras:$scope.nMuestras})
	        .success(function (response) {
	        	$scope.res = response.msg;	                      
	        });
	    }else{
	    	alert("Debe Introducir Usuario y Contraseña");
	        $scope.res="Para realizar la Busqueda debe introducir Usuario y Contraseña";
	    }
	   */
	});
</script>


</body>
</html>