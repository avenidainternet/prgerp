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

	date_default_timezone_set("America/Santiago");

	$horaAct = date('H:i');
	$fechaHoy = date('Y-m-d');
	$fp = explode('-', $fechaHoy);
	$Periodo = $fp[1].'-'.$fp[0];
	if(isset($_POST['Programar'])){
		//echo "Programado ".$_POST['fechaPrgTaller'].' '.$_POST['idItem'];
		$fdRa = explode('-', $_POST['idItem']);
		$RAM = $fdRa[0];
		$fechaFinPega = $_POST['fechaHasta'];
		if($fechaFinPega < $_POST['fechaPrgTaller']){
			$fechaFinPega = $_POST['fechaPrgTaller'];
			//echo $fechaFinPega;
		}	
		$link=Conectarse();
		$actSQL  ="UPDATE ammuestras SET ";
		$actSQL .= "fechaTaller 	= '".$_POST['fechaPrgTaller'].	"',";
		$actSQL .= "fechaHasta 		= '".$fechaFinPega.				"'";
		$actSQL .="WHERE idItem 	like '%".$RAM."%' and Taller = 'on'";
		$bdProc=$link->query($actSQL);
		$link->close();
	}
	if(isset($_POST['Transito'])){
		//echo "Programado ".$_POST['fechaPrgTaller'].' '.$_POST['idItem'];
		$fdRa = explode('-', $_POST['idItem']);
		$RAM = $fdRa[0];
		$fechaPrgTaller = '0000-00-00';
		$link=Conectarse();
		$actSQL  ="UPDATE ammuestras SET ";
		$actSQL .= "fechaTaller 	= '".$fechaPrgTaller.	"',";
		$actSQL .= "fechaHasta 		= '".$fechaPrgTaller.	"'";
		$actSQL .="WHERE idItem 	like '%".$RAM."%' and Taller = 'on'";
		$bdProc=$link->query($actSQL);
		$link->close();
	}
	if(isset($_POST['Matar'])){
		//echo "Programado ".$_POST['fechaPrgTaller'].' '.$_POST['idItem'];
		$fdRa = explode('-', $_POST['idItem']);
		$RAM = $fdRa[0];
		$fechaTerminoTaller = date('Y-m-d');
		$fechaPrgTaller = $_POST['fechaPrgTaller'];
		$link=Conectarse();
		$actSQL  ="UPDATE ammuestras SET ";
		$actSQL .= "fechaTaller 		= '".$_POST['fechaPrgTaller'].		"',";
		$actSQL .= "fechaTerminoTaller 	= '".$fechaTerminoTaller.			"'";
		$actSQL .="WHERE idItem 	like '%".$RAM."%' and Taller = 'on'";
		$bdProc=$link->query($actSQL);
		$link->close();
	}
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

	<link rel="shortcut icon" href="../../favicon.ico" />
	<link rel="apple-touch-icon" href="touch-icon-iphone.png" />
	<link rel="apple-touch-icon" href="touch-icon-ipad.png" />
	<link rel="apple-touch-icon" href="touch-icon-iphone4.png" />

	<title>Simet: Taller TV</title>

	<link href="../css/tpv.css" rel="stylesheet" type="text/css">
	<link href="styles.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	
	<script src="../jquery/jquery-1.6.4.js"></script>
	<script src="../jquery/jquery-1.11.0.min.js"></script>
	<script src="../jquery/jquery-migrate-1.2.1.min.js"></script>	
	<script type="text/javascript" src="../jquery/libs/1/jquery.min.js"></script>
	<script src="../jsboot/bootstrap.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="../angular/angular.js"></script>

<script>
	function muestraResultados(){
		$.ajax({
			url: 'mTallerboot.php',
			beforeSend: function () {
				$("#resultado").html("<div id='tablaDatosAjax'><img src='img/ajax-loader.gif'></div>");
			},
			success: function (response) {
				$("#info").html(response);
			}
		});
	}
</script>
</head>

<body ng-app="myApp" ng-controller="CtrlTaller">
	<?php include_once('head.php'); ?>
	<!-- Navigation -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
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

	<?php include_once('mTallerboot.php'); ?>

	<script src="../jquery/jquery-3.3.1.min.js"></script>
	<script src="../datatables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
	<script src="../jsboot/bootstrap.min.js"></script>	
	<script src="taller.js"></script>

</body>
</html>

