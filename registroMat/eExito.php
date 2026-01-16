<?php 	
	session_start(); 
	header('Content-Type: text/html; charset=iso-8859-1');
	include_once("conexion.php"); 
	$CAM 	= $_GET[CAM];
	$Rev 	= $_GET[Rev];
	$Cta 	= $_GET[Cta];

	$link=Conectarse();
	$bdCot=mysql_query("SELECT * FROM Cotizaciones Where CAM = '".$CAM."' and Rev = '".$Rev."' and Cta = '".$Cta."'");
	if($rowCot=mysql_fetch_array($bdCot)){
		$fechaCotizacion 	= $rowCot[fechaCotizacion];
		$usrCotizador 		= $rowCot[usrCotizador];
		$Cliente 			= $rowCot[RutCli];
		$Atencion 			= $rowCot[Atencion];
		$correoAtencion 	= $rowCot[correoAtencion];
		$Descripcion		= $rowCot[Descripcion];
		$EstadoCot			= $rowCot[Estado];
		$Validez			= $rowCot[Validez];
		$dHabiles			= $rowCot[dHabiles];
		$oCompra			= $rowCot[oCompra];
		$nOC				= $rowCot[nOC];
		$oMail				= $rowCot[oMail];
		$oCtaCte			= $rowCot[oCtaCte];
		$fechaAceptacion	= $rowCot[fechaAceptacion];
	}
	mysql_close($link);
?>

<div id="bloqueoTrasperente">
	<div id="cajaRegistraPruebas">
		<center>
		<form name="form" action="modCotizacion.php" method="post">
		<table width="95%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
			<tr>
				<td colspan="3" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
					<span style="color:#FFFFFF; font-size:18px; font-weight:700;">
						<img src="../imagenes/enviarConsulta.png" width="50" align="middle"> ENVIO COTIZACIÓN <?php echo 'CAM-'.$CAM; ?>
						<div id="botonImagen">
							<?php 
								$prgLink = 'modCotizacion.php?CAM='.$CAM.'&Rev='.$Rev.'&Cta='.$Cta; 
								echo '<a href="'.$prgLink.'" style="float:right;"><img src="../imagenes/no_32.png"></a>';
							?>
						</div>
					</span>
				</td>
			</tr>
			<tr>
			  <td width="37%" valign="top" style="font-size:16px; font-weight:700; border-right:1px solid #ccc;border-bottom:1px solid #ccc;">
			  	De:<br><hr>
			  	<?php
						$link=Conectarse();
						$bdCli=mysql_query("SELECT * FROM Usuarios Where usr = '".$usrCotizador."'");
						if($rowCli=mysql_fetch_array($bdCli)){
							echo $rowCli[usuario];
						}
						mysql_close($link);
				?>
			  </td>
			  <td colspan="4"style="font-size:16px; font-weight:700;border-bottom:1px solid #ccc;">
			  	Para:<br><hr>
			  	<?php
						$link=Conectarse();
						$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$Cliente."'");
						if($rowCli=mysql_fetch_array($bdCli)){
							echo $rowCli[Cliente];
						}
						mysql_close($link);
				?>
			   </td>
			 
			</tr>
			<tr>
				<td rowspan="5" style="border-right:1px solid #ccc; " align="center"><span style="color:#FF0000;">ENVIO EXITOSO </span>
				<td width="28%" style="border-bottom:1px solid #ccc; border-right:1px solid #ccc;">Contactos / Atención : </td>
		        <td width="35%" style="border-bottom:1px solid #ccc;">Correos
				</td>
			</tr>
			<tr>
				<td><input name="Atencion" 			id="Atencion" 		type="text" size="40"  value="<?php echo $Atencion; ?>" 	  style="font-size:12px; font-weight:700;" readonly></td>
			    <td><input name="correoAtencion" 	id="correoAtencion" type="mail" size="40"  value="<?php echo $correoAtencion; ?>" style="font-size:12px; font-weight:700;" readonly></td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
		    </tr>
			<tr>
				<td colspan="2">
					Fecha Envio :	
					  <input name="fechaCotizacion" 	id="fechaCotizacion" type="date"  value="<?php echo $fechaCotizacion; ?>" style="font-size:12px; font-weight:700;" readonly>
					  <input name="CAM" 	id="CAM" 	type="hidden" value="<?php echo $CAM; ?>">
					  <input name="Rev" 	id="Rev" 	type="hidden" value="<?php echo $Rev; ?>">
					  <input name="Cta" 	id="Cta" 	type="hidden" value="<?php echo $Cta; ?>">
				</td>
		    </tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
		</table>
		</form>
		</center>
	</div>
</div>