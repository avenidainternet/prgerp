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
	if(isset($_GET[Otam])) 		{	$Otam 		= $_GET[Otam]; 		}
	if(isset($_GET[prg])) 		{	$prg 		= $_GET[prg]; 		}
	if(isset($_GET[RuCli])) 	{	$RutCli 	= $_GET[RutCli]; 	}

	if(isset($_GET[idItem])) 	{	$idItem		= $_GET[idItem]; 	}
	if(isset($_GET[tpMuestra])) {	$tpMuestra	= $_GET[tpMuestra]; }
	if(isset($_GET[ObsOtam])) 	{   $ObsOtam	= $_GET[ObsOtam]; 	}
	if(isset($_GET[Ind])) 		{   $Ind		= $_GET[Ind]; 		}
	if(isset($_GET[Tem])) 		{   $Tem		= $_GET[Tem]; 		}
	if(isset($_GET[rTaller])) 	{   $rTaller	= $_GET[rTaller]; 	}

	if(isset($_GET[guardarIdOtam])){
		$idEnsayo = '';
		$fe = explode('-',$Otam);
		if(substr($fe['1'],0,1) == 'T') { $idEnsayo = 'Tr'; }
		if(substr($fe['1'],0,1) == 'Q') { $idEnsayo = 'Qu'; }
		if(substr($fe['1'],0,1) == 'C') { $idEnsayo = 'Ch'; }
		if(substr($fe['1'],0,1) == 'D') { $idEnsayo = 'Du'; }
		if(substr($fe['1'],0,1) == 'O') { $idEnsayo = 'Ot'; }
		
		$link=Conectarse();
		$bdOT=mysql_query("Select * From OTAMs Where idItem = '".$idItem."' and Otam = '".$Otam."'");
		if($rowOT=mysql_fetch_array($bdOT)){
			$actSQL="UPDATE OTAMs SET ";
			$actSQL.="tpMuestra		='".$tpMuestra.	"',";
			$actSQL.="idEnsayo		='".$idEnsayo.	"',";
			$actSQL.="ObsOtam		='".$ObsOtam.	"',";
			$actSQL.="Ind			='".$Ind.		"',";
			$actSQL.="Tem			='".$Tem.		"',";
			$actSQL.="rTaller		='".$rTaller.	"'";
			$actSQL.="WHERE idItem = '".$idItem."' and Otam = '".$Otam."'";
			$bdOT=mysql_query($actSQL);
			
			$te = explode('-',$Otam);
			if(substr($te['1'],0,1) == 'T') { $regEns = 'regTraccion'; 	}
			if(substr($te['1'],0,1) == 'Q') { $regEns = 'regQuimico'; 	}
			if(substr($te['1'],0,1) == 'C') { $regEns = 'regCharpy'; 	}
			if(substr($te['1'],0,1) == 'D') { $regEns = 'regDoblado'; 	}

			if(substr($te['1'],0,1) == 'C' or substr($te['1'],0,1) == 'D'){
				if(substr($te['1'],0,1) == 'C'){
					for($i=1; $i<=$Ind; $i++){
						$bdCh=mysql_query("Select * From $regEns Where idItem = '".$Otam."' and nImpacto = '".$i."'");
						if($rowCh=mysql_fetch_array($bdCh)){
							$actSQL="UPDATE $regEns SET ";
							$actSQL.="tpMuestra		='".$tpMuestra.	"',";
							$actSQL.="Tem			='".$Tem.	"'";
							$actSQL.="WHERE idItem = '".$Otam."' and nImpacto = '".$i."'";
							$bdCh=mysql_query($actSQL);
						}else{
							mysql_query("insert into $regEns(
																idItem,
																tpMuestra,
																Tem,
																nImpacto
																) 
														values 	(	
																'$Otam',
																'$tpMuestra',
																'$Tem',
																'$i'
							)",$link);
						}
					}
				}
				if(substr($te['1'],0,1) == 'D'){
					for($i=1; $i<=$Ind; $i++){
						$bdCh=mysql_query("Select * From $regEns Where idItem = '".$Otam."' and nIndenta = '".$i."'");
						if($rowCh=mysql_fetch_array($bdCh)){
							$actSQL="UPDATE $regEns SET ";
							$actSQL.="tpMuestra		='".$tpMuestra.	"'";
							$actSQL.="WHERE idItem = '".$Otam."' and nIndenta = '".$i."'";
							$bdCh=mysql_query($actSQL);
						}else{
							mysql_query("insert into $regEns(
																idItem,
																tpMuestra,
																nIndenta
																) 
														values 	(	
																'$Otam',
																'$tpMuestra',
																'$i'
							)",$link);
						}
					}
				}
			}else{
				$actSQL="UPDATE $regEns SET ";
				$actSQL.="tpMuestra		='".$tpMuestra.	"'";
				$actSQL.="WHERE idItem  = '".$Otam."'";
				$bdOT=mysql_query($actSQL);
			}
			
			if($rTaller == 'on'){
				$bdfRAM=mysql_query("Select * From formRAM Where RAM = '".$RAM."'");
				if($rowfRAM=mysql_fetch_array($bdfRAM)){
					$nTaller = $rowfRAM[nSolTaller];
					if($rowfRAM[nSolTaller] == 0){
						$bdNform=mysql_query("Select * From tablaRegForm");
						if($rowNform=mysql_fetch_array($bdNform)){
							$nTaller = $rowNform[nTaller] + 1;
							$actSQL="UPDATE tablaRegForm SET ";
							$actSQL.="nTaller		='".$nTaller."'";
							$bdNform=mysql_query($actSQL);
						}
					}
					$actSQL="UPDATE formRAM SET ";
					$actSQL.="nSolTaller	='".$nTaller."'";
					$actSQL.="WHERE RAM = '".$RAM."'";
					$bdfRAM=mysql_query($actSQL);

					$actSQL="UPDATE amMuestras SET ";
					$actSQL.="nTaller	='".$nTaller."'";
					$actSQL.="WHERE idItem = '".$idItem."'";
					$bdfRAM=mysql_query($actSQL);
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
	
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	

	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<script>
	function realizaProceso(CAM, RAM, idItem, dBuscar, accion){
		var parametros = {
			"CAM" 			: CAM,
			"RAM" 			: RAM,
			"idItem" 		: idItem,
			"dBuscar" 		: dBuscar,
			"accion" 		: accion
		};
		//alert(accion);
		$.ajax({
			data: parametros,
			url: 'muestraOTs.php',
			type: 'get',
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}

	function idOtam(RAM, idItem, Otam, accion){
		var parametros = {
			"RAM"			: RAM,
			"idItem"		: idItem,
			"Otam"			: Otam,
			"accion"		: accion,
		};
		//alert(Otam);
		$.ajax({
			data: parametros,
			url: 'idOtamEnsayo.php',
			type: 'get',
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}
	
	</script>

</head>

<body>
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<img src="../imagenes/Tablas.png" width="40" height="40" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					<?php
					$link=Conectarse();
					$bdMu=mysql_query("Select * From amMuestras Where idItem = '".$idItem."'");
					if($rowMu=mysql_fetch_array($bdMu)){
						$idMuestra = $rowMu[idMuestra];
					}
					mysql_close($link);
					?>
					Definición de OTAMs - Muestra <?php echo $idItem.' - '.$idMuestra; ?>
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
				include_once('listaOT.php');
				if($accion == 'Nuevo' and $RAM > 0){
					?>
					<script>
						var RAM			= "<?php echo $RAM; 		?>" ;
						var idItem		= "<?php echo $idItem; 		?>" ;
						var Otam		= "<?php echo $Otam; 		?>" ;
						var accion 		= "<?php echo $accion; 		?>" ;
						idOtam(RAM, idItem, Otam, accion);
					</script>
					<?php
				}
				if($accion == 'Editar' and $RAM > 0){
					?>
					<script>
						var RAM			= "<?php echo $RAM; 		?>" ;
						var idItem		= "<?php echo $idItem; 		?>" ;
						var Otam		= "<?php echo $Otam; 		?>" ;
						var accion 		= "<?php echo $accion; 		?>" ;
						idOtam(RAM, idItem, Otam, accion);
					</script>
					<?php
				}
			?>
		</div>
		<div style="clear:both;"></div>
						
	</div>
	<br>
	
	
</body>
</html>
