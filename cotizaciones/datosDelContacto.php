<?php
	header('Content-Type: text/html; charset=utf-8');
	include_once("../conexionli.php");
	date_default_timezone_set("America/Santiago");

	if(isset($_GET['Cliente'])) 	{ $Cliente  	= $_GET['Cliente']; 	}
	if(isset($_GET['nContacto']))	{ $nContacto	= $_GET['nContacto'];	}
	if(isset($_GET['Atencion']))	{ $Contacto		= $_GET['Atencion'];	}
	if($Contacto>0){
		$nContacto = $Contacto;
	}
	$link=Conectarse();
	$bdCon=$link->query("SELECT * FROM contactosCli Where RutCli = '".$Cliente."' and nContacto = '".$nContacto."'");
	if($rowCon=mysqli_fetch_array($bdCon)){
		$Contacto 	= $rowCon['Contacto'];
		$Email 		= $rowCon['Email'];
		$Telefono	= $rowCon['Telefono'];
	}
	$link->close();
	?>
	<div style="clear:both;"></div>
	<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td>Contacto</td>
			<td>
				<input name="Atencion" 	id="Atencion" 	size="50" maxlength="50" style="font-size:12px; font-weight:700;" type="text" 	value="<?php echo $Contacto; ?>" readonly />
				<input name="nContacto" id="nContacto" 	size="50" maxlength="50" style="font-size:12px; font-weight:700;" type="hidden" value="<?php echo $nContacto; ?>">
			</td>
		</tr>
		<tr>
			<td>Correo</td>
			<td>
				<input name="correoAtencion" id="correoAtencion" 	size="50" maxlength="50" style="font-size:12px; font-weight:700;" type="text" value="<?php echo $Email; ?>" readonly />
			</td>
		</tr>
		<tr>
			<td>Teléfono</td>
			<td>
	 			<input name="Telefono" 		 id="Telefono" 			size="50" maxlength="50" style="font-size:12px; font-weight:700;" type="text" value="<?php echo $Telefono; ?>" readonly /><br>
			</td>
		</tr>
	</table>
