<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ejemplo de Fondo Inactivo</title>
</head>
<style type="text/css">
	body {
		z-index:1; 
	}
	h3 {
	 	text-transform:capitalize;
	  	font-family:Arial, Helvetica, sans-serif;
	}
	p {
		font-size:16px;
		font-family:Arial, Helvetica, sans-serif;
	}
	#capaVentana {
		visibility:hidden;
		position:absolute;
		padding:0px;
		left:100px;
		top:100px;
		z-index:3;
	}
	#capaFondo1 {
		visibility:hidden;
		position:absolute;
		padding:0px;
		left:0px;
		top:0px;
		right:0px;
		bottom:0px;
		background-image:url(trans01.gif);
		background-repeat:repeat;
		width:100%;
		height:596px;
		z-index:2;
	}
	#capaFondo2 {
		visibility:hidden;
		position:absolute;
		padding:0px;
		left:0px;
		top:0px;
		right:0px;
		bottom:0px;
		background-image:url(trans02.gif);
		background-repeat:repeat;
		width:100%;
		height:596px;
		z-index:2;
	}
	#capaFondo3 {
		visibility:hidden;
		position:absolute;
		padding:0px;
		left:0px;
		top:0px;
		right:0px;
		bottom:0px;
		background-image:url(trans03.gif);
		background-repeat:repeat;
		width:100%;
		height:596px;
		z-index:2;
	}
</style>

<script language="javascript">
	function abrirVentana(ventana)
	{
		if (ventana=="1")
		{
			document.getElementById("capaFondo1").style.visibility="visible";
			document.getElementById("capaFondo2").style.visibility="hidden";
			document.getElementById("capaFondo3").style.visibility="hidden";
		}
		else if (ventana=="2")
		{
			document.getElementById("capaFondo1").style.visibility="hidden";
			document.getElementById("capaFondo2").style.visibility="visible";
			document.getElementById("capaFondo3").style.visibility="hidden";
		}
		else
		{
			document.getElementById("capaFondo1").style.visibility="hidden";
			document.getElementById("capaFondo2").style.visibility="hidden";
			document.getElementById("capaFondo3").style.visibility="visible";
		}
		document.getElementById("capaVentana").style.visibility="visible";
		document.formulario.bAceptar.focus();
	}
	
	function cerrarVentana()
	{
		document.getElementById("capaFondo1").style.visibility="hidden";
		document.getElementById("capaFondo2").style.visibility="hidden";
		document.getElementById("capaFondo3").style.visibility="hidden";
		document.getElementById("capaVentana").style.visibility="hidden";
		document.formulario.bAceptar.blur();
	}
</script>
<body>
	<h3>Esto es un ejemplo de como inhabilitar/habilitar el fondo de la P�gina</h3>
	<p>
	Este es el contenido del primer p�rrafo, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla.<br />
	Este es el contenido del primer p�rrafo, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla.<br />
	Este es el contenido del primer p�rrafo, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla.<br />
	Este es el contenido del primer p�rrafo, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla.<br />
	<a href="javascript:abrirVentana('1');">Simulacro de ventana Emergente 1</a>
	</p>
	
	<p>
	Este es el contenido del segundo p�rrafo, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla.<br />
	Este es el contenido del segundo p�rrafo, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla.<br />
	Este es el contenido del segundo p�rrafo, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla.<br />
	Este es el contenido del segundo p�rrafo, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla.<br />
	<a href="javascript:abrirVentana('2');">Simulacro de ventana Emergente 2</a>
	</p>
	
	<p>
	Este es el contenido del tercer p�rrafo, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla.<br />
	Este es el contenido del tercer p�rrafo, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla.<br />
	Este es el contenido del tercer p�rrafo, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla.<br />
	Este es el contenido del tercer p�rrafo, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla.<br />
	<a href="javascript:abrirVentana('3');">Simulacro de tercer Emergente 3</a>
	</p>
	
	<div id="capaVentana">
		<table border="0" cellpadding="0" cellspacing="0" width="450">
			<tr>
				<td style="background-image:url(top-left.gif);" width="4"><img src="pixel_trans.gif" /></td>
				<td style="background-image:url(top-center.gif); background-repeat:repeat-x" width="418" align="left">
					<font color="#FFFFFF" style="font-size:14px;font-family:Arial, Helvetica, sans-serif;font-weight:600;">
						&nbsp;&nbsp;T�tulo de la Ventana</font>
				</td>
				<td style="background-image:url(boton-cerrar.gif); cursor:pointer;" height="30" width="24"
				onclick="cerrarVentana()"> <img src="pixel_trans.gif" height="25" width="22" alt="Cerrar Ventana" />
				</td>
				<td style="background-image:url(top-right.gif);" height="30" width="4"><img src="pixel_trans.gif" /></td>
			</tr>
			<tr>
				<td style="background-image:url(medio-izq.gif); background-repeat:repeat-y;" width="4">
					<img src="pixel_trans.gif" /></td>
				<td colspan="2">
					<table cellpadding="10" cellspacing="0" border="0" width="100%" style="background-color:#EFECDC">
					<tr>
						<td style="text-align:center; font-size:14px; font-family:Arial, Helvetica, sans-serif;">
							Esto es un simulacro de ventana emergente!!<br />							
							Observa que el fondo de la p�gina est� totalmente desactivado!!!<br />
							En todo este espacio de la ventana puedes colocar cualquier cosa!!<br />
							Esta ventanita fue hecha con tablas e im�genes.
						</td>
					</tr>
					<tr>
						<td style="text-align:center;">
							<form name="formulario">
								<input type="button" name="bAceptar" value="Aceptar" onclick="cerrarVentana()"/>
							</form>
						</td>
					</tr>
					</table>
				</td>
				<td style="background-image:url(medio-der.gif); background-repeat:repeat-y;" width="4">
					<img src="pixel_trans.gif" /></td>
			</tr>
			<tr>
				<td style="background-image:url(botton-left.gif);" height="4"><img src="pixel_trans.gif" /></td>
				<td style="background-image:url(botton-center.gif); background-repeat:repeat-x" height="4">
					<img src="pixel_trans.gif" /></td>
				<td style="background-image:url(botton-center.gif); background-repeat:repeat-x" height="4">
					<img src="pixel_trans.gif" /></td>
				<td style="background-image:url(botton-right.gif);" height="4" width="4"><img src="pixel_trans.gif" /></td>
			</tr>		
		</table>
	</div>
	
	<div id="capaFondo1">
	</div>
	<div id="capaFondo2">
	</div>
	<div id="capaFondo3">
	</div>
</body>
</html>
