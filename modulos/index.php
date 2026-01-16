<?php
	session_start(); 
	include_once("../conexionli.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']		= $rowPer['Perfil'];
			$_SESSION['IdPerfil']	= $rowPer['IdPerfil'];
		}
		$link->close();
	}else{
		header("Location: ../index.php");
	}
	$usuario 			= $_SESSION['usuario'];

	$usrApertura 		= $_SESSION['usr'];

	if(isset($_POST['nModulo'])){ $firstModulo = $_POST['nModulo']; }

	if(isset($_POST['GuardarModulo'])){
		if(isset($_POST['Modulo']))		{ $Modulo 	= $_POST['Modulo']; 	}
		if(isset($_POST['dirProg']))	{ $dirProg 	= $_POST['dirProg']; 	}
		if(isset($_POST['iconoMod']))	{ $iconoMod = $_POST['iconoMod']; 	}

		$link=Conectarse();
		$bd=$link->query("SELECT * FROM modulos WHERE nModulo = '$firstModulo'");
		if ($row=mysqli_fetch_array($bd)){
			$actSQL="UPDATE modulos SET ";
			$actSQL.="nModulo			= '".$firstModulo.	"',";
			$actSQL.="Modulo			= '".$Modulo.		"',";
			$actSQL.="dirProg			= '".$dirProg.		"',";
			$actSQL.="iconoMod			= '".$iconoMod.		"'";
			$actSQL.="Where  nModulo 	= '$firstModulo'";
			$bdAct = $link->query($actSQL);
		}else{
				$link->query("insert into modulos 	(	nModulo 				,
														Modulo 					,
														dirProg					,
														iconoMod
														) 
										values 		(	'$firstModulo' 			,
														'$Modulo'				,
														'$dirProg'				,
														'$iconoMod'				
														)");
		}
		$link->close();

	}

	if(isset($_POST['EliminarModulo'])){
		$link=Conectarse();
		$bdProv=$link->query("DELETE FROM modulos WHERE nModulo = '$firstModulo'");
		$link->close();
	}

?>
<!doctype html>
 
<html lang="es">
<head>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Módulos</title>
	
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	


	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

</head>

<body>
	<?php include('head.php'); ?>
	<div id="linea"></div>

	<!-- Navigation -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-danger static-top">
		<div class="container-fluid">
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
	          			<a class="nav-link fas fa-desktop" href="../modulos"> Módulos</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-stream" href="../menus"> Menú</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-cog" href="../Perfiles"> Perfiles</a>
	        		</li>

	        		<li class="nav-item">
	          			<a class="nav-link fas fa-user" href="../usr"> Usuarios</a>
	        		</li>

	        		<li class="nav-item">
	          			<a class="nav-link fas fa-cogs" href="index.php?Accion=Agregar"> Agregar</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="cerrarsesion.php"> Cerrar</a>
	        		</li>

	      		</ul>
	    	</div>
	  	</div>
	</nav>



<!--
	<div class="row bg-danger text-white" style="padding: 5px;">
		<div class="col-1 text-center">
			<img src="../imagenes/about_us_close_128.png" width="40">
		</div>
		<div class="col-10">
			<h4>Usuarios</h4>
		</div>
		<div class="col-1">
				<a href="cerrarsesion.php" title="Cerrar Sesión">
					<img src="../gastos/imagenes/preview_exit_32.png" width="32" height="32">
				</a>
		</div>
	</div>
-->
	<?php include_once('listaModulos.php'); ?>
	
	<script src="../jsboot/bootstrap.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>

<script>
	var mDatos = angular.module('myApp', []);
	mDatos.controller('custCtr', function($scope, $http){
		
		$scope.modi = function(){
			$scope.res = $scope.Modulo.$valid;
		};
	});
</script>

	<script>
		$(document).ready(function() {
    		$('#usuarios').DataTable({
    			"order": [[ 0, "asc" ]]
    		});
    		$('#modulos').DataTable({
    			"order": [[ 0, "asc" ]]
    		});

		} );	
	</script>
</body>
</html>
