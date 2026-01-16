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
	$accion = ''; 
	$CAM	= 0;
	$RAM	= 0;
	
	if(isset($_GET['accion'])) 	{	$accion 	= $_GET['accion']; 	}
	if(isset($_GET['RAM'])) 	{	$RAM 		= $_GET['RAM']; 	}
	if(isset($_GET['CAM'])) 	{	$CAM 		= $_GET['CAM']; 	}
	if(isset($_GET['prg'])) 	{	$prg 		= $_GET['prg']; 	}
	if(isset($_GET['RuCli'])) 	{	$RutCli 	= $_GET['RutCli']; 	}

	if(isset($_GET['accion'])) 			{ $accion 	 		= $_GET['accion']; 			}
	if(isset($_GET['Obs'])) 			{ $Obs 	 			= $_GET['Obs']; 			}
	if(isset($_GET['Taller'])) 			{ $Taller 			= $_GET['Taller']; 			}
	if(isset($_GET['nMuestras'])) 		{ $nMuestras		= $_GET['nMuestras'];		}
	if(isset($_GET['fechaInicio']))		{ $fechaInicio 		= $_GET['fechaInicio'];		}
	if(isset($_GET['ingResponsable']))	{ $ingResponsable 	= $_GET['ingResponsable'];	}
	if(isset($_GET['cooResponsable']))	{ $cooResponsable 	= $_GET['cooResponsable'];	}
	
	if($accion != 'Actualizar'){
		$link=Conectarse();
		$bdCot=mysql_query("Select * From formRAM Where CAM = '".$CAM."' and RAM = '".$RAM."'");
		if($rowCot=mysql_fetch_array($bdCot)){
			$accion = 'Filtrar';
		}
		mysql_close($link);
	}

	if(isset($_GET['guardarFormularioRAM'])){	
		$link=Conectarse();
		$bdfRAM=mysql_query("Select * From formRAM Where RAM = '".$RAM."'");
		if($rowfRAM=mysql_fetch_array($bdfRAM)){
			$nSolTaller = $rowfRAM['nSolTaller'];
			if($Taller == 'on'){
				if($rowfRAM['nSolTaller'] == 0){
					$bdNform=mysql_query("Select * From tablaRegForm");
					if($rowNform=mysql_fetch_array($bdNform)){
						$nSolTaller = $rowNform['nTaller'] + 1;
						$actSQL="UPDATE tablaRegForm SET ";
						$actSQL.="nTaller		='".$nSolTaller."'";
						$bdNform=mysql_query($actSQL);
					}
				}
			}
			$nMuestrasOld = $rowfRAM['nMuestras'];
			$actSQL="UPDATE formRAM SET ";
			$actSQL.="fechaInicio		='".$fechaInicio.		"',";
			$actSQL.="Taller			='".$Taller.			"',";
			$actSQL.="nSolTaller		='".$nSolTaller.		"',";
			$actSQL.="Obs				='".$Obs.				"',";
			$actSQL.="nMuestras			='".$nMuestras.			"',";
			$actSQL.="ingResponsable	='".$ingResponsable.	"',";
			$actSQL.="cooResponsable	='".$cooResponsable.	"'";
			$actSQL.="WHERE RAM = '".$RAM."'";
			$bdfRAM=mysql_query($actSQL);
			
			if($nMuestrasOld > $nMuestras){
				for($i=($nMuestras+1); $i<=$nMuestrasOld; $i++){
					$idItem = $RAM.'-'.$i;
					if($i<10) { $idItem = $RAM.'-0'.$i; }
					$bdMu =mysql_query("Delete From amMuestras Where idItem = '".$idItem."'");
					$bdMu =mysql_query("Delete From OTAMs Where idItem = '".$idItem."'");
				}
			}
			
			for($i=1; $i<=$nMuestras; $i++){
				$idItem = $RAM.'-'.$i;
				if($i<10) { $idItem = $RAM.'-0'.$i; }
				
				$bdMu=mysql_query("Select * From amMuestras Where idItem = '".$idItem."'");
				if($rowMu=mysql_fetch_array($bdMu)){
					
				}else{
					mysql_query("insert into amMuestras(
														idItem
														) 
												values 	(	
														'$idItem'
														)",
					$link);
				}
			}
			
		}else{
			mysql_query("insert into formRAM(
												CAM,
												RAM,
												fechaInicio,
												Obs,
												nMuestras,
												ingResponsable,
												cooResponsable
												) 
										values 	(	
												'$CAM',
												'$RAM',
												'$fechaInicio',
												'$Obs',
												'$nMuestras',
												'$ingResponsable',
												'$cooResponsable'
					)",
			$link);
			for($i=1; $i<=$nMuestras; $i++){
				$idItem = $RAM.'-'.$i;
				if($i<10) { $idItem = $RAM.'-0'.$i; }
				
				$bdMu=mysql_query("Select * From amMuestras Where idItem = '".$idItem."'");
				if($rowMu=mysql_fetch_array($bdMu)){
					
				}else{
					mysql_query("insert into amMuestras(
														idItem
														) 
												values 	(	
														'$idItem'
														)",
					$link);
				}
			}
		}
		mysql_close($link);
		$accion = '';
	}
	
?>
<!doctype html>
 
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Muestras</title>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<link href="styles.css" rel="stylesheet" type="text/css">
<link href="../css/tpv.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script type="text/javascript" src="../angular/angular.min.js"></script>

</head>

<body ng-app="myApp" ng-controller="CtrlMuestras">
	<?php include('head.php'); ?>
	<!-- Navigation -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
		<div class="container-fluid">
	    	<div class="collapse navbar-collapse" id="navbarResponsive">
	      		<ul class="navbar-nav ml-auto">
	        		<li class="nav-item active">
	          			<a class="nav-link fa fa-home" href="../plataformaErp.php"> Principal
	                	<span class="sr-only">(current)</span>
	              		</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link far fa-file-alt" href="../procesos/plataformaCotizaciones.php"> Procesos</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link far fa-file-alt" href="../procesosangular/plataformaCotizaciones.php"> PROCESOS NEW</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="cerrarsesion.php"> Cerrar</a>
	        		</li>

	      		</ul>
	    	</div>
	  	</div>
	</nav>
    {{5+5}}
	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="../jsboot/bootstrap.min.js"></script>	


    <script src="muestras.js"></script>

</body>
</html>
