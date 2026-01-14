<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<?php 	
	include_once("conexion.php"); 
	$Logos = '';
	if(isset($_GET['nEnc'])) 	{ $nEnc 	= $_GET['nEnc']; 	}
	if(isset($_GET['RutCli'])) 	{ $RutCli	= $_GET['RutCli'];	}

	$link=Conectarse();
	$bdEnc=mysql_query("Select * From Encuestas Where nEnc = '".$nEnc."'");
	if($rowEnc=mysql_fetch_array($bdEnc)){
		$nomEnc 	= $rowEnc['nomEnc'];
		$infoEnc 	= $rowEnc['infoEnc'];
	}
	$bdCli=mysql_query("Select * From Clientes Where RutCli = '".$RutCli."'");
	if($rowCli=mysql_fetch_array($bdCli)){
		$Cliente 		= $rowCli['Cliente'];
		$Logo 			= $rowCli['Logo'];
		$Email 			= $rowCli['Email'];
		$Contacto 		= $rowCli['Contacto'];
		$EmailContacto	= $rowCli['EmailContacto'];
		$Contacto2 		= $rowCli['Contacto2'];
		$EmailContacto2 = $rowCli['EmailContacto2'];
		$Contacto3 		= $rowCli['Contacto3'];
		$EmailContacto3 = $rowCli['EmailContacto3'];
		$Contacto4 		= $rowCli['Contacto4'];
		$EmailContacto4 = $rowCli['EmailContacto4'];
	}
	mysql_close($link);

?>

<div id="bloqueoTrasperente">
	<div id="cajaRegistraPruebas">
		<center>
		<form name="form" action="enviarEncuesta.php" method="post">
		<table width="95%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
			<tr>
				<td colspan="2" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
					<span style="color:#FFFFFF; font-size:18px; font-weight:700;">
						Enviando Encuesta (<?php echo $nomEnc; ?>)
						<div id="botonImagen">
							<a href="enviarEncuesta.php?nEnc=<?php echo $nEnc; ?>" style="float:right;"><img src="../imagenes/no_32.png"></a>
						</div>
					</span>
				</td>
			</tr>
			<tr>
				<td align="left"><img src="../imagenes/logoSimetEnc.png"></td>
				<td align="right">
					<?php 
						if($Logos){
							$mLogo = "http://simet.cl/intranet/logos/".$Logo;
							echo '<img src="'.$mLogo.'">';
						}
					?>
					<input name="nEnc" 		id="nEnc" 	type="hidden" value="<?php echo $nEnc; ?>">
					<input name="RutCli" 	id="RutCli" type="hidden" value="<?php echo $RutCli; ?>">
				</td>
			</tr>
			<tr>
				<td colspan="2" align="justify" style="padding:20px; font-size:24px; ">
			  		<?php
					
						echo 'Estimado Cliente '.$Cliente.':<br><br>';
						$cabezeraCorreo = 'Debido a un problema generado en nuestra plataforma informática, la encuesta previamente ';
						$cabezeraCorreo .= 'enviada posee errores. Es por este motivo que en este correo reenviamos la encuesta, ';
						$cabezeraCorreo .= 'esperamos que este problema no les haya ocasionado algún inconveniente.';
/*						
						$cabezeraCorreo = 'Laboratorio SIMET-USACH estamos interesados en evaluar la eficiencia de nuestros procesos, ';
						$cabezeraCorreo .= 'para esto les solicitamos su ayuda contestando la siguiente encuesta:';
*/
						echo '<textarea style="font-size:20px;" name="cabezeraCorreo" cols="80" rows="10">'.$cabezeraCorreo.'</textarea>';
						
					?>
			  	</td>
		   	</tr>
			<tr>
			  <td colspan="2"><hr></td>
		  	</tr>
			<tr>
				<td colspan="2" style=" margin:20px 5px; padding:20px; font-size:24px; ">
					Correos de Envio :
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<table cellpadding="0" cellspacing="0" border="1" width="98%">
						<tr bgcolor="#CCCCCC">
							<td>Cumplimenteros</td>
							<td>Correos</td>
						</tr>
						
						$bdCc=mysql_query("SELECT * FROM contactosCli Where RutCli = '".$row['RutCli']."'");
											if($rowCc=mysql_fetch_array($bdCc)){
												do{
													if($row['Email']){
														$Correos .= $rowCc['Email'].'<br>';
													}
												}while ($rowTp=mysql_fetch_array($bdTp));
											}
						
						<tr>
							<td><input style="font-size:20px;" name="Contacto" 		id="Contacto" 		type="text" size="50" maxlength="50" value="<?php echo $Contacto; ?>"></td>
							<td><input style="font-size:20px;" name="EmailContacto" id="EmailContacto"  type="text" size="50" maxlength="50" value="<?php echo $EmailContacto; ?>"></td>
						</tr>
						<?php if($Contacto2){?>
							<tr>
								<td><input style="font-size:20px;" name="Contacto2" 		id="Contacto2" 		type="text" size="50" maxlength="50" value="<?php echo $Contacto2; ?>"></td>
								<td><input style="font-size:20px;" name="EmailContacto2"    id="EmailContacto2" type="text" size="50" maxlength="50" value="<?php echo $EmailContacto2; ?>"></td>
							</tr>
						<?php } ?>
						<?php if($Contacto3){?>
							<tr>
								<td><input style="font-size:20px;" name="Contacto3" 		id="Contacto3" 		type="text" size="50" maxlength="50" value="<?php echo $Contacto3; ?>"></td>
								<td><input style="font-size:20px;" name="EmailContacto3"    id="EmailContacto3" type="text" size="50" maxlength="50" value="<?php echo $EmailContacto3; ?>"></td>
							</tr>
						<?php } ?>
						<?php if($Contacto4){?>
							<tr>
								<td><input style="font-size:20px;" name="Contacto4" 		id="Contacto4" 		type="text" size="50" maxlength="50" value="<?php echo $Contacto4; ?>"></td>
								<td><input style="font-size:20px;" name="EmailContacto4"    id="EmailContacto4" type="text" size="50" maxlength="50" value="<?php echo $EmailContacto4; ?>"></td>
							</tr>
						<?php } ?>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px; ">
							<div id="botonImagen">
								<button name="enviarCorreoEncuesta" style="float:right;">
									<img src="../imagenes/enviarConsulta.png" width="80" height="80">
								</button>
							</div>
				</td>
			</tr>
		</table>
		</form>
		</center>
	</div>
</div>