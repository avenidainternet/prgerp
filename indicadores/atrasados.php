<?php
	session_start(); 
	date_default_timezone_set("America/Santiago");
	
	include_once("../conexionli.php");
    include_once("../conexioncert.php");

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
			
			
			<form class="form-inline" action="atrasados.php" method="post">
				<input class="form-control mr-sm-2" name="pAgno" type="text" value="<?php echo $pAgno; ?>" placeholder="Año"/>
				<button class="btn btn-success" type="submit">Filtrar</button>
			</form>			
		</ul>
	</nav>
	<div class="container-fluid">
		<?php // include_once('mIndicadores.php'); ?>
		<?php // include_once('mIndicadorCotizaciones.php'); ?> 
		<?php include_once('mInformesAtrasados.php'); ?>
		<?php include_once('mInformesAtrasados2.php'); ?>
		<?php //include_once('mInformesEmitidos.php'); ?>
		<?php //include_once('mIndicadorEnsayos.php'); ?>
		<?php //include_once('mIndicadorProcesos.php'); ?>
		<?php //include_once('mIndicadorRevisiones.php'); ?>
		<?php //include_once('mIndicadorProductividad.php'); ?>
		<?php //include_once('mProductividadInformes.php'); ?>
		<?php //include_once('mProductividadInformesRes.php'); ?>
		<?php //cuentaEnsayosActivos('10-2017'); ?>
	</div>
	<script src="indicadores.js"></script> 


</body>
</html>