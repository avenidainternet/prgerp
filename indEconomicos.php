<?php
	session_start(); 
	include("conexion.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		$link->close();
	}else{
		header("Location: index.php");
	}
	if(isset($_POST['Volver'])){
		header("Location: plataformaErp.php");
	}
?>
<!doctype html>
 
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

	<link rel="shortcut icon" href="favicon.ico" />
	<link rel="apple-touch-icon" href="touch-icon-iphone.png" />
	<link rel="apple-touch-icon" href="touch-icon-ipad.png" />
	<link rel="apple-touch-icon" href="touch-icon-iphone4.png" />

	<title>Plataforma ERP de Simet</title>

	<link href="estilos.css" rel="stylesheet" type="text/css">
	<script language="javascript" src="validaciones.js"></script> 
	
</head>

<body onLoad="document.acceso.usr.focus();">
	<?php include('head.php'); ?>
	<form name="form1" method="post" action="">
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
		<tr>
    		<td colspan="4" valign="top" style="float:left; display:inline; ">
				<img src="imagenes/indicadores.png" width="100" height="100" title="Indicadoes Económicos">
				<button name="Configuracion" title="Configuraciones">
					<img src="imagenes/settings_128.png" width="100" height="100">
				</button>
				<button name="Guardar" title="Guardar">
					<img src="imagenes/guardar.png" width="100" height="100">
				</button>
				<button name="Volver" title="Volver">
					<img src="imagenes/volver.png" width="100" height="100">
				</button>
			</td>
   		</tr>
	</table>
    </form>
<div style="clear:both; "></div>
	<br>
</body>
</html>
