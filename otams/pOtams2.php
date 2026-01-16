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
	if(isset($_GET[accion])) 	{	$accion 	= $_GET[accion]; 	}
	if(isset($_GET[RAM])) 		{	$RAM 		= $_GET[RAM]; 		}
	if(isset($_GET[CAM])) 		{	$CAM 		= $_GET[CAM]; 		}
	if(isset($_GET[prg])) 		{	$prg 		= $_GET[prg]; 		}
	if(isset($_GET[RuCli])) 	{	$RutCli 	= $_GET[RutCli]; 	}

	if(isset($_GET[accion])) 		{ $accion 	 		= $_GET[accion]; 		}
	if(isset($_GET[Obs])) 			{ $Obs 	 			= $_GET[Obs]; 			}
	if(isset($_GET[Taller])) 		{ $Taller 			= $_GET[Taller]; 		}
	if(isset($_GET[nMuestras])) 	{ $nMuestras		= $_GET[nMuestras];		}
	if(isset($_GET[fechaInicio]))	{ $fechaInicio 		= $_GET[fechaInicio];	}
	if(isset($_GET[ingResponsable])){ $ingResponsable 	= $_GET[ingResponsable];}
	if(isset($_GET[cooResponsable])){ $cooResponsable 	= $_GET[cooResponsable];}
	
	if($accion != 'Actualizar'){
		$link=Conectarse();
		$bdCot=mysql_query("Select * From formRAM Where CAM = '".$CAM."' and RAM = '".$RAM."'");
		if($rowCot=mysql_fetch_array($bdCot)){
			$accion = 'Filtrar';
		}
		mysql_close($link);
	}

	if(isset($_GET[guardarFormularioRAM])){	
		$link=Conectarse();
		$bdfRAM=mysql_query("Select * From formRAM Where RAM = '".$RAM."'");
		if($rowfRAM=mysql_fetch_array($bdfRAM)){
			$nSolTaller = $rowfRAM[nSolTaller];
			if($Taller == 'on'){
				if($rowfRAM[nSolTaller] == 0){
					$bdNform=mysql_query("Select * From tablaRegForm");
					if($rowNform=mysql_fetch_array($bdNform)){
						$nSolTaller = $rowNform[nTaller] + 1;
						$actSQL="UPDATE tablaRegForm SET ";
						$actSQL.="nTaller		='".$nSolTaller."'";
						$bdNform=mysql_query($actSQL);
					}
				}
			}
			$nMuestrasOld = $rowfRAM[nMuestras];
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>M&oacute;dulo Administración de RAMs</title>
<link href="styles.css" rel="stylesheet" type="text/css">
<link href="../css/tpv.css" rel="stylesheet" type="text/css">
</head>

<body>
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<img src="../imagenes/Tablas.png" width="40" height="40" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					RAMs en Procesos
				</strong>

				<div id="ImagenBarra">
					<a href="cerrarsesion.php" title="Cerrar Sesión">
						<img src="../gastos/imagenes/preview_exit_32.png" width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="../plataformaErp.php" title="Menú Principal">
						<img src="../gastos/imagenes/Menu.png" width="28" height="28">
					</a>
				</div>
			</div>
			<?php 
				include_once('listaOTAMs2.php');
			?>
		</div>
		<div style="clear:both;"></div>
		
				
	</div>
	<br>
	
	
</body>
</html>
