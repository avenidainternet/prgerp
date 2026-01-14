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
		header("Location: http://simet.cl/erp");
	}
	
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Intranet Simet</title>

	<script src="../jquery/jquery-1.11.0.min.js"></script>
	<script src="../jquery/jquery-migrate-1.2.1.min.js"></script>	
	<script type="text/javascript" src="../jquery/libs/1/jquery.min.js"></script>	

	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">
	<link href="../css/stylesCalendario.css" rel="stylesheet" type="text/css">

	<script src="//cdn.ckeditor.com/4.8.0/full/ckeditor.js"></script>

	<script>
	function subirPDF(accion, nDocGes){
		var parametros = {
			"accion" 	: accion,
			"nDocGes" 	: nDocGes
		};
		alert(nDocGes);
		$.ajax({
			data: parametros,
			url: 'upPDF.php',
			type: 'get',
			success: function (response) {
				$("#resultadoSubir").html(response);
			}
		});
	}
	function marcaDesmarca(accion, nDocGes){
		var parametros = {
			"accion" 	: accion,
			"nDocGes" 	: nDocGes
		};
		alert(nDocGes);
		$.ajax({
			data: parametros,
			url: 'upPDF.php',
			type: 'get',
			success: function (response) {
				$("#resultadoSubir").html(response);
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
				<img src="../gastos/imagenes/poster_teachers.png" width="28" height="28" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					Días Feriados
				</strong>

				<div id="ImagenBarra">
					<a href="cerrarsesion.php" title="Cerrar Sesión">
						<img src="../gastos/imagenes/preview_exit_32.png" width="32" height="32">
					</a>
				</div>
			</div>
			<?php include_once('mostrarCalendario.php'); ?>
		</div>
		<div style="clear:both;"></div>
		<div id="resultadoSubir"></div>
	</div>
	<br>
	
	
</body>
</html>
