<?php
	include("conexion.php");
	$usr = "";
	if (isset ($_POST['acceso'])){
		if (isset ($_POST['usr'])){
			$link=Conectarse();
			$bdusr=mysql_query("SELECT * FROM Usuarios WHERE usr = '".$_POST['usr']."' && pwd = '".$_POST['pwd']."'");
			if ($row=mysql_fetch_array($bdusr)){
  				session_start(); 
    			$_SESSION["usr"]		= $row['usr']; 
    			$_SESSION["pwd"]		= $row['pwd'];
    			$_SESSION["usuario"]	= $row['usuario'];
    			$_SESSION["IdPerfil"]	= $row['nPerfil'];
			}
			mysql_close($link);
			if (isset ($_SESSION["usr"])){
				header("Location: plataformaFacturas.php");
			}
		}
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Intranet Simet</title>

<link href="styles.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	
	margin-top: 0px;
	margin-bottom: 0px;
	background: url(../gastos/imagenes/Usach.jpg) no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
	max-width:100%;
	width:100%;
	margin-left:auto;
	margin-right:auto;	

	
}
-->
</style>
<script language="javascript" src="../gastos/validaciones.js"></script> 
</head>

<body onLoad="document.form.usr.focus();">
	<?php include('head.php'); ?>
	<div id="linea"></div>

	<div id="CuerpoPagina">

		<div id="CajaAcceso">
			<form name="form" action="index.php" method="post">
				<table border="0" cellpadding="0" cellspacing="0" width="100%">
		        	<tr>
		            	<td width="12%">&nbsp;</td>
		                <td width="82%">&nbsp;</td>
		                <td width="6%">&nbsp;</td>
		            </tr>
		            <tr>
		            	<td>&nbsp;</td>
		                <td><div align="left" class="titulomodulo">Acceso a Facturación </div></td>
		                <td>&nbsp;</td>
		         	</tr>
		            <tr>
		            	<td>&nbsp;</td>
		               	<td>&nbsp;</td>
		                <td>&nbsp;</td>
		          	</tr>
		            <tr>
		                <td>&nbsp;</td>
		                <td class="usrpwd">Usuario</td>
		                <td>&nbsp;</td>
		          	</tr>
		            <tr>
		            	<td>&nbsp;</td>
		                <td>
							<input name="usr" type="text" id="usr" value='<?php echo $usr; ?>'>
						</td>
		                <td>&nbsp;</td>
		          	</tr>
		           	<tr>
		            	<td>&nbsp;</td>
		               	<td class="msgejazul">&nbsp;</td>
		                <td>&nbsp;</td>
		            </tr>
		            <tr>
		            	<td>&nbsp;</td>
		                <td>&nbsp;</td>
		            	<td>&nbsp;</td>
		            </tr>
		           	<tr>
		              	<td>&nbsp;</td>
		                <td class="usrpwd">Contrase&ntilde;a</td>
		                <td>&nbsp;</td>
		            </tr>
		            <tr>
		                <td>&nbsp;</td>
		                <td><input name="pwd" type="password" id="pwd"></td>
		                <td>&nbsp;</td>
		        	</tr>
		            <tr>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
		           	</tr>
		            <tr>
		                <td>&nbsp;</td>
		                <td><input type="submit" name="acceso" value="Enviar"></td>
		                <td>&nbsp;</td>
		         	</tr>
		            <tr>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
		            </tr>
		            <tr>
		                <td>&nbsp;</td>
		                <td class="alertaazul">&iquest;Olvido Contrase&ntilde;a?</td>
		                <td>&nbsp;</td>
		          	</tr>
		            <tr>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
		           	</tr>
				</table>
			</form>
		</div>
<!--
		<div id="CajaCpoDer">
			<h4>Sistema Control Laboratorio SIMET</h4>
			<p style="border-top-style:ridge; ">Acceso al Módulo Control de Gastos</p>
		</div>
-->
	</div>
	<div style="clear:both; "></div>
	<br>
</body>
</html>
