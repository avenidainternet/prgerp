<?php
	session_start(); 
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");                      // Expira en fecha pasada 
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");        // Siempre página modificada 
    header("Cache-Control: no-cache, must-revalidate");                   // HTTP/1.1 
    header("Pragma: no-cache");  
	date_default_timezone_set("America/Santiago");
	include_once("../conexionli.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']		= $rowPer['Perfil'];
			$_SESSION['IdPerfil']	= $rowPer['IdPerfil'];
		}
		$link->close();
	}else{
		header("Location: ../index.php");
	}
	$usuario = $_SESSION['usuario'];

	$calA 			= '';
	$calB			= '';
	$EquilibrioX	= '';
	$calC 			= '';
	$calD			= '';
	

	if(isset($_POST['calA'])) 		{	$calA 			= $_POST['calA']; 		}
	if(isset($_POST['calB'])) 		{	$calB 			= $_POST['calB']; 		}
	if(isset($_POST['EquilibrioX'])){	$EquilibrioX 	= $_POST['EquilibrioX'];}
	if(isset($_POST['calC'])) 		{	$calC 			= $_POST['calC']; 		}
	if(isset($_POST['calD'])) 		{	$calD 			= $_POST['calD']; 		}

	if(isset($_POST['guardarCalibracion'])){
		$link=Conectarse();
		$bdOFE=$link->query("Select * From calibraciones");
		if($rowOFE=mysqli_fetch_array($bdOFE)){
			$actSQL="UPDATE calibraciones SET ";
			$actSQL.="calA	 		='".$calA.			"',";
			$actSQL.="calB			='".$calB.			"',";
			$actSQL.="EquilibrioX	='".$EquilibrioX.	"',";
			$actSQL.="calC	 		='".$calC.			"',";
			$actSQL.="calD			='".$calD.			"'";
			//$actSQL.="WHERE OFE 		= '".$OFE."'";
			$bdOFE=$link->query($actSQL);
		}
		$link->close();
	}
	$link=Conectarse();
	$bdCal=$link->query("Select * From calibraciones");
	if($rowCal=mysqli_fetch_array($bdCal)){
		$calB 			= $rowCal['calB'];
		$calA 			= $rowCal['calA'];
		$EquilibrioX 	= $rowCal['EquilibrioX'];
		$calC 			= $rowCal['calC'];
		$calD 			= $rowCal['calD'];
	}
	$link->close();
?>
<!doctype html>
 
<html lang="es">
<head>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Calibraciones</title>
	
	<link href="styles.css" 	rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">
<!--	
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
-->
	<script src="../jquery/jquery-1.11.0.min.js"></script>
	<script src="../jquery/jquery-migrate-1.2.1.min.js"></script>

	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

	<link rel="stylesheet" href="../fontasome/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

	<script type="text/javascript" src="../fontasome/js/all.min.js"></script>
	<script type="text/javascript" src="../angular/angular.js"></script>

</head>

<body ng-app="myApp" ng-controller="TodoCtrl">
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<!-- Navigation -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-danger static-top">
		<div class="container-fluid">
  	    	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
	          <span class="navbar-toggler-icon"></span>
	        </button>
	    	<div class="collapse navbar-collapse" id="navbarResponsive">

				<a class="navbar-brand" href="#">
					<img src="../imagenes/simet.png" alt="logo" style="width:40px;">
				</a>

	      		<ul class="navbar-nav ml-auto">
	        		<li class="nav-item active">
	          			<a class="nav-link fa fa-home" href="../plataformaErp.php"> Principal
	                	<span class="sr-only">(current)</span>
	              		</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="../cerrarsesion.php"> Cerrar</a>
	        		</li>

	      		</ul>
	    	</div>
	  	</div>
	</nav> 

	<div class="container-fluid" style="margin-top: 5px;">
		<div class="card">
			<div class="card-header bg-secondary text-white">
				<h5>Tabla de Calibración Ensayos Charpy</h5>
			</div>
		  	<div class="card-body">
		  		<?php include_once('editarCalibracionesBoot.php'); ?>
		  	</div>
		</div>
	</div>

	<div class="row">
		<div class="col-4">
			<div class="container-fluid" style="margin-top: 5px;">
				<div class="card">
					<div class="card-header bg-secondary text-white">
						<div class="row">
							<div class="col-8">
								<h5>Tabla Parámetros Químicos (Ac)</h5>
							</div>
							<div class="col-4">
								<input type="hidden" ng-model="Muestra">
                                <a type="button" class="btn btn-success" ng-click="agregarQu('Qu', 'Ac')" data-toggle="modal" data-target="#myModal">
                                    Agregar
                                </a> 
							</div>
						</div>
					</div>
				  	<div class="card-body">
				  		<?php include_once('editarParametrosQu.php'); ?>
				  	</div>
				  	<div class="card-footer">
                        <a type="button" class="btn btn-success" ng-click="agregarQu('Qu', 'Ac')" data-toggle="modal" data-target="#myModal">
                            Agregar
	                    </a> 
				  	</div>
				</div>
			</div>
		</div>
		<div class="col-4">
			<div class="container-fluid" style="margin-top: 5px;">
				<div class="card">
					<div class="card-header bg-secondary text-white">
						<div class="row">
							<div class="col-8">
								<h5>Tabla Parámetros Químicos (Cu)</h5>
							</div>
							<div class="col-4">
								<input type="hidden" ng-model="Muestra">
                                <a type="button" class="btn btn-success" ng-click="agregarQu('Qu', 'Co')" data-toggle="modal" data-target="#myModal">
                                    Agregar
                                </a>  
							</div>
						</div>
					</div>
				  	<div class="card-body">
				  		<?php include_once('editarParametrosCo.php'); ?>
				  	</div>
				  	<div class="card-footer">
                        <a type="button" class="btn btn-success" ng-click="agregarQu('Qu', 'Co')" data-toggle="modal" data-target="#myModal">
                            Agregar
	                    </a> 
				  	</div>
				</div>
			</div>
		</div>
		<div class="col-4">
			<div class="container-fluid" style="margin-top: 5px;">
				<div class="card">
					<div class="card-header bg-secondary text-white">
						<div class="row">
							<div class="col-8">
								<h5>Tabla Parámetros Químicos (Al)</h5>
							</div>
							<div class="col-4">
								<input type="hidden" ng-model="idEnsayo">
								<input type="hidden" ng-model="tpMuestra">
                                <a type="button" class="btn btn-success" ng-click="agregarQu('Qu', 'Al')" data-toggle="modal" data-target="#myModal">
                                    Agregar
                                </a>  
							</div>
						</div>
					</div>
				  	<div class="card-body">
				  		<?php include_once('editarParametrosAl.php'); ?>
				  	</div>
				  	<div class="card-footer">
                        <a type="button" class="btn btn-success" ng-click="agregarQu('Qu', 'Al')" data-toggle="modal" data-target="#myModal">
                            Agregar
	                    </a> 
				  	</div>
				</div>
			</div>
		</div>
	</div>
	<div ng-include="'modalContent.php'"></div>


	<script src="../jsboot/bootstrap.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

	<script src="calibraciones.js"></script>

</body>
</html>
