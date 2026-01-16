<?php
	session_start(); 
	date_default_timezone_set("America/Santiago");
	include_once("../conexion.php");

	$horaAct = date('H:i');
	$fechaHoy = date('Y-m-d');
	$fp = explode('-', $fechaHoy);
	$Periodo = $fp[1].'-'.$fp[0];
	
	if(isset($_GET['RAM'])) 		{	$RAM 	= $_GET['RAM']; 		}
	if(isset($_GET['accion'])) 		{	$accion = $_GET['accion']; 		}
	
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

	<link href="tpv.css" 		rel="stylesheet" type="text/css">
	<link href="stylesTv.css" 	rel="stylesheet" type="text/css">
	<link href="styles.css" 	rel="stylesheet" type="text/css">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

	<script src="../jquery/jquery-1.6.4.js"></script>
	<script src="../jquery/jquery-1.11.0.min.js"></script>
	<script src="../jquery/jquery-migrate-1.2.1.min.js"></script>	
	<script type="text/javascript" src="../jquery/libs/1/jquery.min.js"></script>	

<script>
	function muestraResultados(){
		$.ajax({
			url: 'mTaller.php',
			beforeSend: function () {
				$("#resultado").html("<div id='tablaDatosAjax'><img src='img/ajax-loader.gif'></div>");
			},
			success: function (response) {
				$("#info").html(response);
			}
		});
	}
	function boxPrg(RAM){
		var parametros = {
			"RAM" 			: RAM
		};
		//alert(RAM);
		$.ajax({
			url: 'prgTaller.php',
			beforeSend: function () {
				$("#resultado").html("<div id='tablaDatosAjax'><img src='img/ajax-loader.gif'></div>");
			},
			success: function (response) {
				$("#infoPrg").html(response);
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
.selector  { 
    text-decoration: none;
}
#cajaSemana {
	width				: 100%;
	font-family			: Arial;
	font-weight			: 800;
	border				: 1;
}
#cajaSemana a{
	text-decoration		: none;
	color				: #fff;	
}
#cajaSemana .cajaDiasSemana {
	font-family			: Arial, Helvetica, sans-serif;
	/*float				: left;*/
	width				: 20%;
	text-align  		: center;
	border				: 1px solid #000;
	/* padding				: 0.2px;*/
	background-color	: #ccc;
}
#divPrg {
	width				: 15%;
	font-family			: Arial;
	font-weight			: 800;
	float				: left;
	text-align  		: center;
	background-color	: #ccc;
	border-top			: 1px solid #000;
	border-bottom		: 1px solid #000;
}
#divPrg a{
	text-decoration		: none;
}

#divBlanco {
	background-color	: #fff; 
	border				: 1px solid #000; 
	padding				: 10px;
}
#divBlanco:hover{
	background:#a5aba1;
	color:#494c46;
	-webkit-transform: scale(.99);
	-ms-transform: scale(0.99);
	transform: scale(0.99);
	box-shadow: inset 0 0 0 1px #555953;
}


#divRojo {
	background-color	: #FE2E2E; 
	border				: 1px solid #000; 
	padding				: 10px;
	color				: #fff;
}
#divRojo:hover{
	background:#a5aba1;
	color:#494c46;
	-webkit-transform: scale(.99);
	-ms-transform: scale(0.99);
	transform: scale(0.99);
	box-shadow: inset 0 0 0 1px #555953;
}
#divAmarillo {
	background-color	: #FFFF00; 
	border				: 1px solid #000; 
	padding				: 10px;
	color				: #000;
}
#divAmarillo:hover{
	background:#a5aba1;
	color:#494c46;
	-webkit-transform: scale(0.99);
	-ms-transform: scale(0.99);
	transform: scale(0.99);
	box-shadow: inset 0 0 0 1px #555953;
}
#divVerde {
	background-color	: #04B431; 
	border				: 1px solid #000; 
	padding				: 10px;
	color				: #000;
}
#divVerde:hover{
	opacity				:.4;
	color				: #fff;	
}
</style>
</head>

<body>
	<?php include('head.php'); ?>
	<div id="linea"></div>
<div class="container">
	<div id="Cuerpo">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<img src="../imagenes/Tablas.png" width="40" height="40" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					Planificación Taller 
				</strong>

				<div id="ImagenBarra">
					<a href="cerrarsesion.php" title="Cerrar Sesión">
						<img src="../gastos/imagenes/preview_exit_32.png" width="32" height="32">
					</a>
				</div>
			</div>
			<div id="BarraOpciones">
				<div id="ImagenBarraLeft">
					<a href="index.php" title="Principal">
						<img src="../imagenes/actividades.png"></a>
					<br>
					Taller
				</div>
				<div id="ImagenBarraLeft">
					<a href="../cotizaciones/plataformaCotizaciones.php" title="Procesos">
						<img src="../imagenes/other_48.png"></a>
					<br>
					Proceso
				</div>

			</div>
		</div>
		<?php include_once('hojaEnsayos.php');?>
		<div style="clear:both;"></div>
				
	</div>
</div>	
	
	
</body>
</html>

