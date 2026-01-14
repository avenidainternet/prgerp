<?php
	session_start(); 
	//nclude_once("Mobile-Detect-2.3/Mobile_Detect.php");
 	//$Detect = new Mobile_Detect();
	date_default_timezone_set("America/Santiago");
	include_once("conexionli.php");

	$horaAct = date('H:i');
	$fechaHoy = date('Y-m-d');
	$fp = explode('-', $fechaHoy);
	$Periodo = $fp[1].'-'.$fp[0];
	
	$maxCpo = '81%';

	if(isset($_GET['CAM'])) 		{	$CAM 	= $_GET['CAM']; 		}
	if(isset($_GET['RAM'])) 		{	$RAM 	= $_GET['RAM']; 		}
	if(isset($_GET['accion'])) 		{	$accion = $_GET['accion']; 		}
	
	if(isset($_POST['CAM'])) 		{	$CAM 	= $_POST['CAM']; 		}
	if(isset($_POST['RAM'])) 		{	$RAM 	= $_POST['RAM']; 		}
	if(isset($_POST['accion'])) 	{	$accion = $_POST['accion']; 	}

?>
<!doctype html>
 
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<!-- <meta content="30" http-equiv="REFRESH"> </meta> -->

	<meta name="description" 	content="Laboratorio Universidad Santiago de Chile Metalurgica" />
	<meta name="keywords" 		content="Laboratorio Materiales, USACH, Simet, Ensayos de Traccóon, Ensayos de Impacto, " />
	<meta name="author" 		content="Francisco Olivares">
	<meta name="robots" 		content="índice, siga" />
	<meta name="revisit-after" 	content="3 mes" />

	<link rel="shortcut icon" href="favicon.ico" />
	<link rel="apple-touch-icon" href="touch-icon-iphone.png" />
	<link rel="apple-touch-icon" href="touch-icon-ipad.png" />
	<link rel="apple-touch-icon" href="touch-icon-iphone4.png" />

	<title>Simet Ingeniería y Servicios Tecnológicos :: Laboratorio de Ensayos de Materiales</title>

	<link href="css/tpv.css" 		rel="stylesheet" type="text/css">
	<link href="css/stylesTv.css" 	rel="stylesheet" type="text/css">

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	

	<script language="javascript" src="validaciones.js"></script> 
<script>
	function muestraResultados(){
		$.ajax({
			url: 'mPegas.php',
			beforeSend: function () {
				$("#resultado").html("<div id='tablaDatosAjax'><img src='img/ajax-loader.gif'></div>");
			},
			success: function (response) {
				$("#info").html(response);
			}
		});
	}
</script>
<script type="text/javascript">
	var int=self.setInterval("refresh()",5000);
	function refresh()
	{
		muestraResultados();
	}	
</script>
<style>
.cajaDiasSemana {
	font-family			: Arial, Helvetica, sans-serif;
	/*font-weight			: 800;*/
	float				: left;
	width				: 16.5%;
	text-align  		: center;
	border				: 1px solid #000;
	padding				: 0.2px;
	background-color	: #ccc;
}
#cajaSemana {
	width		: 100%;
	font-family:Arial, Helvetica, sans-serif;
}
#divBlanco {
	background-color	: #fff; 
	border				: 1px solid #000; 
	padding				: 5px;
}
#divRojo {
	background-color	: #FE2E2E; 
	border				: 1px solid #000; 
	padding				: 5px;
	color				: #fff;
}
#divAmarillo {
	background-color	: #FFFF00; 
	border				: 1px solid #000; 
	padding				: 5px;
	color				: #000;
}
#divVerde {
	background-color	: #04B431; 
	border				: 1px solid #000; 
	padding				: 5px;
	color				: #000;
}
</style>
</head>

<body>
	<div id="info"></div>

	<div style="clear:both; "></div>
</body>
</html>

