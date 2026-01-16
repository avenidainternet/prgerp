<?php 	
	session_start(); 
	header('Content-Type: text/html; charset=iso-8859-1');
	include_once("conexion.php"); 

	$RAM = '';
	
	$fechaHoy 		= date('Y-m-d');
	$fechaRegistro 	= date('Y-m-d');
?>
<!doctype html>
 
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

	<link rel="shortcut icon" href="favicon.ico" />
	<link rel="apple-touch-icon" href="touch-icon-iphone.png" />
	<link rel="apple-touch-icon" href="touch-icon-ipad.png" />
	<link rel="apple-touch-icon" href="touch-icon-iphone4.png" />

	<title>SIMET - Recepción de Muestras</title>

	<link href="../css/stylesTv.css" rel="stylesheet" type="text/css">
	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<script type="text/javascript" src="../jquery/libs/1/jquery.min.js"></script>	

</head>

<body>

<div id="bloqueoTrasperente">
	<div id="cajaRegistraPruebas">
		<center>
		<form name="form" action="recepcionMuestras.php" method="post">
		<table width="59%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
			<tr>
				<td bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
					<span style="color:#FFFFFF; font-size:18px; font-weight:700;">
						ACTIVACION DE MUESTRAS REGISTRADAS (RAM)
						<div id="botonImagen">
							<?php 
								$prgLink = 'index.php';
								echo '<a href="'.$prgLink.'" style="float:right;"><img src="../imagenes/no_32.png"></a>';
							?>
						</div>
				  </span>
			  </td>
			</tr>
		  <tr>
		    <td class="lineaDerBot" style="padding:30px;">
		  	  	<strong style=" font-size:20px; font-weight:700; margin-left:5px;">
				  	RAM-
				  	<input name="RAM" 	 			id="RAM" 	 			type="text"   	value="<?php echo $RAM; ?>" size="7" maxlength="7" style="font-size:18px; font-weight:700;" autofocus />
			  	</strong>
  			</td>
		  	</tr>
			<tr>
				<td style="padding:60px; font-size:18px;">Ingrese N&deg; de RAM dada de Baja... </td>
			</tr>
		  <tr>
				<td bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px; ">
					<div id="botonImagen" title="Reactivar Muestra...">
						<button name="confirmarActivacion" style="float:right;">
							<img src="../imagenes/volver.png" width="55" height="55">
						</button>
					</div>
				</td>
			</tr>
		</table>
		</form>
		</center>
	</div>
</div>
</body>
</html>