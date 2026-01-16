<?php
	header('Content-Type: text/html; charset=iso-8859-1');
	include_once("conexion.php");
	date_default_timezone_set("America/Santiago");

	if(isset($_GET['RutCli'])) 		{ $RutCli  		= $_GET['RutCli']; 		}
	if(isset($_GET['nContacto']))	{ $nContacto	= $_GET['nContacto'];	}
	$link=Conectarse();
	$bdCon=mysql_query("SELECT * FROM contactosCli Where RutCli = '".$RutCli."' and nContacto = '".$nContacto."'");
	if($rowCon=mysql_fetch_array($bdCon)){
		$Contacto 	= $rowCon[Contacto];
		$Email 		= $rowCon[Email];
		$Telefono	= $rowCon[Telefono];
	}
	mysql_close($link);
	?>
	<div style="clear:both;"></div>
	<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td>Contacto</td>
			<td>
				<input name="Atencion" 	id="Atencion" 	size="50" maxlength="50" style="font-size:12px; font-weight:700;" type="text" 	value="<?php echo $Contacto; ?>">
				<input name="nContacto" id="nContacto" 	size="50" maxlength="50" style="font-size:12px; font-weight:700;" type="hidden" value="<?php echo $nContacto; ?>">
			</td>
		</tr>
		<tr>
			<td>Correo</td>
			<td>
				<input name="correoAtencion" id="correoAtencion" 	size="50" maxlength="50" style="font-size:12px; font-weight:700;" type="text" value="<?php echo $Email; ?>">
			</td>
		</tr>
		<tr>
			<td>Tel&eacute;fono</td>
			<td>
	 			<input name="Telefono" 		 id="Telefono" 			size="50" maxlength="50" style="font-size:12px; font-weight:700;" type="text" value="<?php echo $Telefono; ?>"><br>
			</td>
		</tr> 
	</table>
