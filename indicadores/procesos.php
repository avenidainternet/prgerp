<?php
	session_start(); 
	date_default_timezone_set("America/Santiago");
	
	include_once("../conexionli.php");
	include_once("../conexioncert.php");
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
	$usuario 	= $_SESSION['usuario'];
	$accion 	= '';
	
	if($accion=='Imprimir'){
		//header("Location: formularios/fichaEquipo.php?nSerie=$nSerie");
	}

	$fechaHoy 	= date('Y-m-d');
	$fd 		= explode('-', $fechaHoy);
	$mesInd 	= $fd[1];
	$agnoInd 	= $fd[0];

	$pAgno = date('Y');
	if(isset($_POST['pAgno'])) { $pAgno = $_POST['pAgno']; }
	
$Mes = array(
				1 => 'Enero', 
				2 => 'Febrero',
				3 => 'Marzo',
				4 => 'Abril',
				5 => 'Mayo',
				6 => 'Junio',
				7 => 'Julio',
				8 => 'Agosto',
				9 => 'Septiembre',
				10 => 'Octubre',
				11 => 'Noviembre',
				12 => 'Diciembre'
			);
			
$MesNum = array(	
				'Enero' 		=> '01', 
				'Febrero' 		=> '02',
				'Marzo' 		=> '03',
				'Abril' 		=> '04',
				'Mayo' 			=> '05',
				'Junio' 		=> '06',
				'Julio' 		=> '07',
				'Agosto' 		=> '08',
				'Septiembre'	=> '09',
				'Octubre' 		=> '10',
				'Noviembre' 	=> '11',
				'Diciembre'		=> '12'
			);

$fd 	= explode('-', date('Y-m-d'));

$Agno     	= date('Y');

$dBuscado = '';

if(isset($_GET['dBuscado'])) 	{ $dBuscado  = $_GET['dBuscado']; 	}
?>

<!doctype html>
<html ng-app>
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title>Indicadores</title>
	
	<link href="../css/styles.css" 	rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" 	rel="stylesheet" type="text/css">
	<link href="../estilos.css" 	rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="../cssboot/bootstrap.min.css">

	<script type="text/javascript" src="../angular/angular.min.js"></script>
	<script src="../jquery/jquery-3.3.1.min.js"></script>
	<script src="../jquery/ajax/popper.min.js"></script>
	<script src="../jsboot/bootstrap.min.js"></script>
	<script type="text/javascript" src="../jquery/libs/1/jquery.min.js"></script>


	<script>
		function muestraRAMatrazadas(){
			var parametros = {
				"CAM" 		: CAM,
				"RAM" 		: RAM,
				"Rev" 		: Rev,
				"Cta" 		: Cta,
				"accion"	: accion
			};
			alert('Atrazadas');
			$.ajax({
				data: parametros,
				url: 'segAM.php',
				type: 'get',
				success: function (response) {
					$("#resultadoAM").html(response);
				}
			});
		}
	</script>

</head>

<body ng-app="myApp" ng-controller="CtrlIndicadores">
	<?php include_once('head.php'); ?>
	<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
		<!-- Brand/logo -->
		<a class="navbar-brand" href="#">
			<img src="../imagenes/simet.png" alt="logo" style="width:40px;">
		</a>
		
		<!-- Links -->
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" href="../plataformaErp.php" title="Volver al Principal"><img src="../gastos/imagenes/Menu.png" width="40"></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="cerrarsesion.php" title="Carrar Sesión"><img src="../gastos/imagenes/preview_exit_32.png" width="40"></a>
			</li>
			
			
			<form class="form-inline" action="procesos.php" method="post">
				<input class="form-control mr-sm-2" name="pAgno" type="text" value="<?php echo $pAgno; ?>" placeholder="Año"/>
				<button class="btn btn-success" type="submit">Filtrar</button>
			</form>			
		</ul>
	</nav>
	<div class="container-fluid">
		<?php //include_once('mIndicadores.php'); ?>
		<?php //include_once('mIndicadorCotizaciones.php'); ?>
		<?php //include_once('mInformesAtrasados.php'); ?>
		<?php //include_once('mInformesAtrasados2.php'); ?>
		<?php //include_once('mInformesEmitidos.php'); ?>
		<?php //include_once('mIndicadorEnsayos.php'); ?> 
		<?php //include_once('mIndicadorProcesos.php'); ?>
		<?php //include_once('mIndicadorRevisiones.php'); ?>
		<?php //include_once('mIndicadorProductividad.php'); ?>
		<?php //include_once('mProductividadInformes.php'); ?>
		<?php include_once('mProductividadInformesRes.php'); ?>
		<?php //cuentaEnsayosActivos('10-2017'); ?>
	</div>
	<script src="indicadores.js"></script> 


</body>
</html>


<?php
function contarEnsayosDelMes($mesInd, $agnoInd){
	$link=Conectarse();
	$PeriodoActual = $mesInd.'-'.$agnoInd;
	//$PeriodoActual = '09-'.$agnoInd;
	//$mesInd = '09';
	//echo $PeriodoActual;
	$bdEe=$link->query("DELETE FROM estEnsayos Where Periodo = '".$PeriodoActual."'");
	$bdEn=$link->query("SELECT * FROM amEnsayos Order By nEns");
	if($rowEn=mysqli_fetch_array($bdEn)){
		do{
			if($rowEn['idEnsayo'] == 'Tr') {
				$bdtEn=$link->query("SELECT * FROM amTpsMuestras Where idEnsayo = '".$rowEn['idEnsayo']."'");
				if($rowtEn=mysqli_fetch_array($bdtEn)){
					do{
						$cEnsayo = 0;
						$bdInf=$link->query("SELECT * FROM Cotizaciones Where month(fechaInicio) = '".$mesInd."' and year(fechaInicio) = '".$agnoInd."' and Estado != 'C'");
						if($rowInf=mysqli_fetch_array($bdInf)){
							do{
								$bdOT=$link->query("SELECT * FROM OTAMs Where RAM = '".$rowInf['RAM']."' and idEnsayo = '".$rowEn['idEnsayo']."' and tpMuestra = '".$rowtEn['tpMuestra']."' and month(fechaCreaRegistro) = '".$mesInd."' and year(fechaCreaRegistro) = '".$agnoInd."'");
								if($rowOT=mysqli_fetch_array($bdOT)){
									do{
										$cEnsayo++;
									}while ($rowOT=mysqli_fetch_array($bdOT));
								}
							}while ($rowInf=mysqli_fetch_array($bdInf));
						}
						$Periodo = $mesInd.'-'.$agnoInd;
						$iEns = $rowEn['idEnsayo'];
						$iMue = $rowtEn['tpMuestra'];
						$enPAM = 0;
						$link->query("insert into estEnsayos(	Periodo,
																idEnsayo,
																tpMuestra,
																nEnsayos,
																enPAM
															) 
													values 	(	'$Periodo',
																'$iEns',
																'$iMue',
																'$cEnsayo',
																'$enPAM'
															)");
					}while ($rowtEn=mysqli_fetch_array($bdtEn));
				}
			}else{
				$cEnsayo = 0;
				$bdInf=$link->query("SELECT * FROM Cotizaciones Where month(fechaInicio) = '".$mesInd."' and year(fechaInicio) = '".$agnoInd."' and Estado != 'C'");
				if($rowInf=mysqli_fetch_array($bdInf)){
					do{
						//$bdOT=$link->query("SELECT * FROM OTAMs Where RAM = '".$rowInf['RAM']."' and idEnsayo = '".$rowEn['idEnsayo']."'");
						$bdOT=$link->query("SELECT *   FROM OTAMs Where RAM = '".$rowInf['RAM']."' and idEnsayo = '".$rowEn['idEnsayo']."' and month(fechaCreaRegistro) = '".$mesInd."' and year(fechaCreaRegistro) = '".$agnoInd."'");
						if($rowOT=mysqli_fetch_array($bdOT)){
							do{
								$cEnsayo++;
							}while ($rowOT=mysqli_fetch_array($bdOT));
						}
					}while ($rowInf=mysqli_fetch_array($bdInf));
				}
				$Periodo = $mesInd.'-'.$agnoInd;
				$iEns 	= $rowEn['idEnsayo'];
				$iMue 	= '';
				$enPAM 	= 0;
				$link->query("insert into estEnsayos(	Periodo,
														idEnsayo,
														tpMuestra,
														nEnsayos,
														enPAM
													) 
											values 	(	'$Periodo',
														'$iEns',
														'$iMue',
														'$cEnsayo',
														'$enPAM'
													)");
			}
		}while ($rowEn=mysqli_fetch_array($bdEn));
	}
	$link->close();
}
function cuentaEnsayosActivos($Periodo){
		$link=Conectarse();
		$cuentaEnsayos 	= 0;
		$enProceso 		= 0;
		$conRegistro	= 0;
		$bdCAM=$link->query("DELETE FROM ensayosProcesos Where Periodo = '".$Periodo."'");
		$bdCAM=$link->query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P'"); //     or RAM = 10292 or RAM = 10536 or RAM = 10666
		if($rowCAM=mysqli_fetch_array($bdCAM)){
			do{
				$sumaEnsayos = 0;
				$RAM = $rowCAM['RAM'];
				
				$bdOtam=$link->query("SELECT * FROM Otams Where RAM = '".$rowCAM['RAM']."'");
				if($rowOtam=mysqli_fetch_array($bdOtam)){
					do{
						
						$sumaEnsayos++;
						
						if($rowOtam['idEnsayo'] == 'Tr'){
							$bdEp=$link->query("SELECT * FROM ensayosProcesos Where Periodo = '".$Periodo."' and idEnsayo = '".$rowOtam['idEnsayo']."' and tpMuestra = '".$rowOtam['tpMuestra']."'");
						}else{
							$bdEp=$link->query("SELECT * FROM ensayosProcesos Where Periodo = '".$Periodo."' and idEnsayo = '".$rowOtam['idEnsayo']."'");
						}
						if($rowEp=mysqli_fetch_array($bdEp)){
							if($rowCAM['Estado'] == 'P'){
								$enProceso 		= $rowEp['enProceso'];
								$conRegistro	= $rowEp['conRegistro'];
							
								$enProceso += 1;
								if($rowOtam['Estado'] == 'R'){
									$conRegistro++;
								}
								$actSQL  ="UPDATE ensayosProcesos SET ";
								$actSQL .= "enProceso 	= '".$enProceso.	"', ";
								$actSQL .= "conRegistro = '".$conRegistro.	"' ";
								if($rowOtam['idEnsayo'] == 'Tr'){
									$actSQL .="WHERE Periodo = '".$Periodo."' and idEnsayo = '".$rowOtam['idEnsayo']."' and tpMuestra = '".$rowOtam['tpMuestra']."'";
								}else{
									$actSQL .="WHERE Periodo = '".$Periodo."' and idEnsayo = '".$rowOtam['idEnsayo']."'";
								}
								$bdProc=$link->query($actSQL);
							}
						}else{
							$idEnsayo 		= $rowOtam['idEnsayo'];
							$tpMuestra 		= $rowOtam['tpMuestra'];
							$enProceso  	= 1;
							$conRegistro 	= 0;
							if($rowOtam['Estado'] == 'R') {
								$conRegistro = 1;
							}
							$link->query("insert into ensayosProcesos	(	Periodo,
																			idEnsayo,
																			tpMuestra,
																			enProceso,
																			conRegistro
																		) 
																values 	(	'$Periodo',
																			'$idEnsayo',
																			'$tpMuestra',
																			'$enProceso',
																			'$conRegistro'
																		)"
										);
						}							
					}while ($rowOtam=mysqli_fetch_array($bdOtam));
					
				}
			}while ($rowCAM=mysqli_fetch_array($bdCAM));
		}
	//}
	$link->close();
}
?>
