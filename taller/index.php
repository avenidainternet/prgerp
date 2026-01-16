<?php
	session_start();
	include_once("../conexionli.php");
	if(isset($_GET['fechaSigSemana'])){ 
		$_SESSION['fechaSigSemana'] = $_GET['fechaSigSemana'];
		$_SESSION['fechaAntSemana'] = $_GET['fechaSigSemana'];
		$_SESSION['fechaHoy'] = date('Y-m-d');
	}else{
		$_SESSION['fechaHoy'] = date('Y-m-d');
		unset($_SESSION['fechaSigSemana']); 
	}
	if(isset($_GET['fechaAntSemana'])){ 
		$_SESSION['fechaAntSemana'] = $_GET['fechaAntSemana'];
		$_SESSION['fechaSigSemana'] = $_GET['fechaAntSemana'];
		$_SESSION['fechaHoy'] = date('Y-m-d');
	}else{
		$_SESSION['fechaHoy'] = date('Y-m-d');
		unset($_SESSION['fechaAntSemana']);
	}

	//nclude_once("Mobile-Detect-2.3/Mobile_Detect.php");
 	//$Detect = new Mobile_Detect();
	date_default_timezone_set("America/Santiago");
	include_once("../conexionli.php");

	$horaAct = date('H:i');
	$fechaHoy = date('Y-m-d');
	$fp = explode('-', $fechaHoy);
	$Periodo = $fp[1].'-'.$fp[0];
	
?>
<!doctype html>
 
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- <meta content="30" http-equiv="REFRESH"> </meta> -->

	<meta name="description" 	content="Laboratorio Universidad Santiago de Chile Metalurgica" />
	<meta name="keywords" 		content="Laboratorio Materiales, USACH, Simet, Ensayos de Traccóon, Ensayos de Impacto, " />
	<meta name="author" 		content="Francisco Olivares">
	<meta name="robots" 		content="índice, siga" />
	<meta name="revisit-after" 	content="3 mes" />

	<link rel="shortcut icon" href="../favicon.ico" />
	<link rel="apple-touch-icon" href="touch-icon-iphone.png" />
	<link rel="apple-touch-icon" href="touch-icon-ipad.png" />
	<link rel="apple-touch-icon" href="touch-icon-iphone4.png" /> 

	<title>Simet: Taller TV</title>

	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	
	<script src="../jquery/jquery-1.6.4.js"></script>
	<script src="../jquery/jquery-1.11.0.min.js"></script>
	<script src="../jquery/jquery-migrate-1.2.1.min.js"></script>	
	<script type="text/javascript" src="../jquery/libs/1/jquery.min.js"></script>
	<script src="../jsboot/bootstrap.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="../angular/angular.js"></script>

	<style type="text/css">
		.custom-class{
		  background-color: gray
		}
		.pasivo-class{
		  background-color: red
		}
		.default-color{
		  background-color: green
		}	
		.amarillo-color{
		  background-color: yellow;
		  color: black;
		  font-weight: bold;
		}	
	</style>

</head>

<body ng-app="myApp" ng-controller="CtrlTaller">

	<div class="container-fluid" style="margin-top: 10px;">
		<div class="row bg-info text-white" style="padding: 10px;">
			<div class="col-2">
				Filtrar RAM
			</div>
			<div class="col-2">
				<input class="form-control uppercase" ng-model="bRAM" type="text" size="12" maxlength="12" >
			</div>
			<div class="col-1">
			</div>
			<div class="col-5">
			</div>
		</div>

	  	<table class="table table-dark table-hover table-bordered">
	    	<thead>
	      		<tr>
			        <th>Fechas Prog.			</th>
			        <th>Solicitud				</th>
			        <th>RAM						</th>
			        <th>Descripción 			</th>
			        <th>Acciones				</th> 
	      		</tr>
	    	</thead>
	    	<tbody> 
	      		<tr ng-repeat="x in trabajoTaller  | filter : bRAM"
				  	ng-class="{'default-color': x.Estado == 'N', 'pasivo-class': x.Estado == 'A', 'amarillo-color': x.Estado == 'P'}">

			        <td><b>Inicio {{x.fechaTaller | date:'dd-MM'}} <br> Hasta {{x.fechaHasta | date:'dd-MM'}}</b></td>
			        <td>{{x.nSolTaller}} 			</td>
			        <td>{{x.RAM}}					</td>
			        <td WIDTH="50%">{{x.Objetivo}}	</td>
			        <td>
			        	<!-- <a 	class="btn btn-warning" role="button" href="../certproductos?CodCertificado={{x.ar}}">Editar</a> -->
			        	<a 	class="btn btn-warning" role="button" href="mSolicitud.php?RAM={{x.RAM}}">Editar</a>
	        		</td>
	      		</tr> 
	    	</tbody>
	  	</table>
	</div>

	<script src="../jquery/jquery-3.3.1.min.js"></script>
	<script src="../datatables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
	<script src="../jsboot/bootstrap.min.js"></script>	
	<script src="taller2.js"></script>  

</body>
</html>

