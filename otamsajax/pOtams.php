<?php
	session_start(); 
	include_once("../conexionli.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		$link->close();
	}else{
		header("Location: ../index.php");
	}
	$accion = ''; 
	$CAM	= 0;
	$RAM	= 0;
	$OCP 	= '';
	
	if(isset($_GET['accion'])) 	{	$accion 	= $_GET['accion']; 	} 
	if(isset($_GET['RAM'])) 	{	$RAM 		= $_GET['RAM']; 	}
	if(isset($_GET['CAM'])) 	{	$CAM 		= $_GET['CAM']; 	}
	if(isset($_GET['prg'])) 	{	$prg 		= $_GET['prg']; 	}
	if(isset($_GET['RuCli'])) 	{	$RutCli 	= $_GET['RutCli']; 	}
	if(isset($_GET['OCP'])) 	{	$OCP 		= $_GET['OCP']; 	}

	if(isset($_GET['accion'])) 			{ $accion 	 		= $_GET['accion']; 			}
	if(isset($_GET['Obs'])) 			{ $Obs 	 			= $_GET['Obs']; 			}
	if(isset($_GET['Taller'])) 			{ $Taller 			= $_GET['Taller']; 			}
	if(isset($_GET['nMuestras'])) 		{ $nMuestras		= $_GET['nMuestras'];		}
	if(isset($_GET['fechaInicio']))		{ $fechaInicio 		= $_GET['fechaInicio'];		}
	if(isset($_GET['ingResponsable']))	{ $ingResponsable 	= $_GET['ingResponsable'];	}
	if(isset($_GET['cooResponsable']))	{ $cooResponsable 	= $_GET['cooResponsable'];	}
	
	if($accion != 'Actualizar'){
		$link=Conectarse();
		$bdCot=$link->query("Select * From formRAM Where CAM = '".$CAM."' and RAM = '".$RAM."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$accion = 'Filtrar';
		}
		$link->close();
	}

	if(isset($_GET['guardarFormularioRAM'])){	
		$link=Conectarse();
		$bdfRAM=$link->query("Select * From formRAM Where RAM = '".$RAM."'");
		if($rowfRAM=mysqli_fetch_array($bdfRAM)){
			$nSolTaller = $rowfRAM['nSolTaller'];
			if($Taller == 'on'){
				if($rowfRAM['nSolTaller'] == 0){
					$bdNform=$link->query("Select * From tablaRegForm");
					if($rowNform=mysqli_fetch_array($bdNform)){
						$nSolTaller = $rowNform['nTaller'] + 1;
						$actSQL="UPDATE tablaRegForm SET ";
						$actSQL.="nTaller		='".$nSolTaller."'";
						$bdNform=$link->query($actSQL);
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
			$bdfRAM=$link->query($actSQL);
			
			if($nMuestrasOld > $nMuestras){
				for($i=($nMuestras+1); $i<=$nMuestrasOld; $i++){
					$idItem = $RAM.'-'.$i;
					if($i<10) { $idItem = $RAM.'-0'.$i; }
					$bdMu =$link->query("Delete From amMuestras Where idItem = '".$idItem."'");
					$bdMu =$link->query("Delete From OTAMs Where idItem = '".$idItem."'");
				}
			}
			
			for($i=1; $i<=$nMuestras; $i++){
				$idItem = $RAM.'-'.$i;
				if($i<10) { $idItem = $RAM.'-0'.$i; }
				
				$bdMu=$link->query("Select * From amMuestras Where idItem = '".$idItem."'");
				if($rowMu=mysqli_fetch_array($bdMu)){
					
				}else{
					$link->query("insert into amMuestras(
														idItem
														) 
												values 	(	
														'$idItem'
														)");
				}
			}
			
		}else{
			$link->query("insert into formRAM(
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
					)");
			for($i=1; $i<=$nMuestras; $i++){
				$idItem = $RAM.'-'.$i;
				if($i<10) { $idItem = $RAM.'-0'.$i; }
				
				$bdMu=$link->query("Select * From amMuestras Where idItem = '".$idItem."'");
				if($rowMu=mysqli_fetch_array($bdMu)){
					
				}else{
					$link->query("insert into amMuestras(
														idItem
														) 
												values 	(	
														'$idItem'
														)");
				}
			}
		}
		$link->close();
		$accion = '';
	}
	
?>
<!doctype html>
 
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Procesos PAMs</title>

<!--
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
-->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<link href="styles.css" rel="stylesheet" type="text/css">
<link href="../css/tpv.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script type="text/javascript" src="../angular/angular.min.js"></script>

<script>
	function realizaProceso(CAM, RAM, dBuscar, accion){
		var parametros = {
			"CAM" 			: CAM,
			"RAM" 			: RAM,
			"dBuscar" 		: dBuscar,
			"accion" 		: accion
		};
		//alert(accion);
		$.ajax({
			data: parametros,
			url: 'muestraOTAMs.php',
			type: 'get',
			beforeSend: function () {
				$("#resultado").html("<div id='Layer1' style='position:absolute; left:209px; top:350px; width:406px; height:216px; z-index:1'><img src='../imagenes/enProceso.gif' width='50'>Cargando...</div>");
			},
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}

	function registraFormRAM(RAM, CAM, accion, prg){
		var parametros = {
			"RAM"			: RAM,
			"CAM"			: CAM,
			"accion"		: accion,
			"prg"			: prg
		};
		//alert(prg);
		$.ajax({
			data: parametros,
			url: 'genFormRAM.php',
			type: 'get',
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}
	
	</script>
</head>

<body ng-app="myApp" ng-controller="custCtr" ng-init="inicializar('<?php echo $OCP; ?>')"> 
	<?php include('head.php'); ?>
	<div id="linea"></div>
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
	        		<!-- <li class="nav-item" ng-if="OCP!=''"> -->
	        		<li class="nav-item">
	          			<a class="nav-link far fa-file-alt" href="../certrar/?ar={{OCP}}"> OCP</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link far fa-file-alt" href="../procesosangular/plataformaCotizaciones.php"> PROCESOS</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="cerrarsesion.php"> Cerrar</a>
	        		</li>

	      		</ul>
	    	</div>
	  	</div>
	</nav>
	<form action="pOtams.php" method="post">
		<?php
			include_once('muestraOTAMs.php'); 
		?>
	</form>
	<script>
		$(document).ready(function() {
		    $('#Cajon').DataTable( {
		        "order": [[ 0, "asc" ]],
				"language": {
					            "lengthMenu": "Mostrar _MENU_ Reg. por Página",
					            "zeroRecords": "Nothing found - sorry",
					            "info": "Mostrando Pág. _PAGE_ de _PAGES_",
					            "infoEmpty": "No records available",
					            "infoFiltered": "(de _MAX_ tot. Reg.)",
					            "search":         "Filtrar RAM :",
        		}
		    } );
		} );
	</script>

	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="../jsboot/bootstrap.min.js"></script>	


<script src="otams.js"></script>

</body>
</html>
