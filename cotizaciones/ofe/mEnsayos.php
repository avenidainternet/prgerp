<?php
	date_default_timezone_set("America/Santiago");
	session_start(); 
	include_once("../../conexionli.php"); 
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
	$usuario = $_SESSION['usuario'];

	$OFE 			= 0;
	$accion			= '';
	$accionEnsayo	= '';

	if(isset($_GET['OFE'])) 			{	$OFE 			= $_GET['OFE']; 			}
	if(isset($_GET['accion'])) 			{	$accion 		= $_GET['accion']; 			}
	if(isset($_GET['accionEnsayo'])) 	{	
		$accionEnsayo	= $_GET['accionEnsayo'];
		if(isset($_GET['nDescEnsayo'])) {	$nDescEnsayo	= $_GET['nDescEnsayo']; 	}
		if($_GET['accionEnsayo'] == 'Quitar') 	{
			$link=Conectarse();
			$bdEo =$link->query("Delete From ensayosofe Where OFE = '".$OFE."' and nDescEnsayo = '".$nDescEnsayo."'");
			$link->close();
		}
		if($_GET['accionEnsayo'] == 'Agregar') 	{
			$link=Conectarse();
			$bdEo=$link->query("Select * From ensayosofe Where OFE = '".$OFE."' and nDescEnsayo = '".$nDescEnsayo."'");
			if($rowEo=mysqli_fetch_array($bdEo)){
			}else{
				$link->query("insert into ensayosofe	(
																OFE,
																nDescEnsayo
															)	 
													values 	(	'$OFE',
																'$nDescEnsayo'
														)");
			}
			$link->close();
		}
	}
	/* Verificar Cirerre de CAM con 60 Días */

	if(isset($_POST['OFE'])) 			{	$OFE 			= $_POST['OFE']; 			}
	if(isset($_POST['accion'])) 		{	$accion 		= $_POST['accion']; 		}

	if(isset($_POST['guardarOferta'])){
		$fechaAprobacion 	= '0000-00-00';
		$usrAprobado 		= '';
		
		if(isset($_POST['tituloOferta']))		{	$tituloOferta 		= $_POST['tituloOferta'];		}
		if(isset($_POST['usrAprobado']))		{	$usrAprobado 		= $_POST['usrAprobado'];		}
		
		if($usrAprobado){ $fechaAprobacion = date('Y-m-d'); }
		
		if(isset($_POST['objetivoGeneral']))	{	$objetivoGeneral 	= $_POST['objetivoGeneral'];	}
		
		$link=Conectarse();
		$bdOFE=$link->query("Select * From propuestaeconomica Where OFE = '".$OFE."'");
		if($rowOFE=mysqli_fetch_array($bdOFE)){
			$actSQL="UPDATE propuestaeconomica SET ";
			$actSQL.="tituloOferta	 	='".$tituloOferta.		"',";
			$actSQL.="objetivoGeneral	='".$objetivoGeneral.	"',";
			$actSQL.="usrAprobado	 	='".$usrAprobado.		"',";
			$actSQL.="fechaAprobacion 	='".$fechaAprobacion.	"'";
			$actSQL.="WHERE OFE 		= '".$OFE."'";
			$bdOFE=$link->query($actSQL);


			$bdObj=$link->query("SELECT * FROM objetivospropuestas where OFE = '".$OFE."'");
			if($rowObj=mysqli_fetch_array($bdObj)){
				do{ 
					$nObjetivo = $rowObj['nObjetivo'];
					$dObj = '';
					
					$vObj = 'Objetivos-'.$rowObj['nObjetivo'];
					if(isset($_POST[$vObj]))	{ $dObj 	= $_POST[$vObj]; 	}
					
					$actSQL="UPDATE objetivospropuestas SET ";
					$actSQL.="Objetivos	 	='".$dObj."'";
					$actSQL.="WHERE OFE 	= '".$OFE."' and nObjetivo = '".$nObjetivo."'";
					$bdOFE=$link->query($actSQL);
					
				}while ($rowObj=mysqli_fetch_array($bdObj));
			}

		}else{
			$link->query("insert into propuestaeconomica	(
															OFE,
															tituloOferta,
															objetivoGeneral,
															usrAprobado,
															fechaAprobacion
														)	 
										  		values 	(	'$OFE',
										  					'$tituloOferta',
										  					'$objetivoGeneral',
										  					'$usrAprobado',
										  					'$fechaAprobacion'
										  			)");
		}
		$link->close();
	}
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Intranet Simet</title>
	
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	

	<link href="../styles.css" rel="stylesheet" type="text/css">
	<link href="../../css/tpv.css" rel="stylesheet" type="text/css">

  	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  	<link rel="stylesheet" href="/resources/demos/style.css">

	<script>
	  $(function() {
		$( "#accordion" ).accordion({
		  collapsible: true,
		  icons: { "header": "ui-icon-plus", "activeHeader": "ui-icon-minus" },
		  active: false
		});
	  });

		function realizaProceso(dBuscar){
			var parametros = {
				"dBuscar" 	: dBuscar
			};
			//alert(Proyecto);
			$.ajax({
				data: parametros,
				url: 'muestraCotizacion.php',
				type: 'get',
				success: function (response) {
					$("#resultado").html(response);
				}
			});
		}
	</script>

</head>

<body>
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="CuerpoTitulo">
		<img src="../../imagenes/other_48.png" width="32" height="32" align="middle">
		<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
			Oferta Económica 
		</strong>
		<div id="ImagenBarra">
			<a href="../cerrarsesion.php" title="Cerrar Sesión">
					<img src="../../gastos/imagenes/preview_exit_32.png" width="32" height="32">
			</a>
		</div>
	</div>
	<?php 
		include_once('BarraEns.php');
		$link=Conectarse();
		include_once('nominaEnsayos.php');
		$link->close(); 
	?>
</body>
</html>
