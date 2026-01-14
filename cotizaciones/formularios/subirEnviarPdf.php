<?php
	session_start();
	include_once("../../conexionli.php");
	header('Content-Type: text/html; charset=utf-8');

	$pCot 			= '';
	$dAdjunto 		= '';
	$Contacto		= '';
	$Email			= '';
	$Cliente		= '';
	$obsServicios 	= '';
	$Observacion 	= '';
	$usrCotizador 	= '';
	$ccEmail		= '';
	$cContacto 		= 0;
	$qEmail			= '';
	
	if(isset($_GET['CAM'])) 		{ $CAM 			= $_GET['CAM']; 		}
	if(isset($_GET['cContacto'])) 	{ $cContacto 	= $_GET['cContacto']; 	}
	if(isset($_GET['Email'])) 		{ $Email 		= $_GET['Email']; 		}
	if(isset($_GET['qEmail'])) 		{ $qEmail 		= $_GET['qEmail']; 		}
	
	$link=Conectarse();
	$bdCot=$link->query("SELECT * FROM cotizaciones WHERE CAM = '".$CAM."'");
	if($rowCot=mysqli_fetch_array($bdCot)){
		$RutCli			= $rowCot['RutCli'];
		$nContacto		= $rowCot['nContacto'];
		$obsServicios 	= $rowCot['obsServicios'];
		$usrCotizador 	= $rowCot['usrCotizador'];
		$Observacion 	= $rowCot['Observacion'];;
		
		if($Email == ''){
			$bdCli=$link->query("SELECT * FROM clientes WHERE RutCli = '".$rowCot['RutCli']."'");
			if($rowCli=mysqli_fetch_array($bdCli)){
				$Cliente = $rowCli['Cliente'];
				$bdcCli=$link->query("SELECT * FROM contactoscli WHERE RutCli = '".$rowCot['RutCli']."' and nContacto = '".$rowCot['nContacto']."'");
				if($rowcCli=mysqli_fetch_array($bdcCli)){
					$Contacto 	= $rowcCli['Contacto'];
					$Email 		= $rowcCli['Email'];
				}			
			}
		}
		$fdCorreos = '';
		if(isset($_GET['cContacto'])){
			$bdcCli=$link->query("SELECT * FROM contactoscli WHERE RutCli = '".$rowCot['RutCli']."' and nContacto = '".$cContacto."'");
			if($rowcCli=mysqli_fetch_array($bdcCli)){
				$Email 		.= ','.$rowcCli['Email'];
			}
		}
			$fdCorreos = explode(',',$Email);
		if(isset($_GET['qEmail'])){
			$qEmail = $_GET['qEmail'];
			$Email 	= $fdCorreos[0];
			$i 		= 0;
			
			foreach ($fdCorreos as &$vCorreo) {
				$i++;
				if($i > 1){
					if($vCorreo != $qEmail){
						$Email .= ','.$vCorreo;
					}
				}
			}
			$fdCorreos = explode(',',$Email);
		}
	}
	$mail_copias = 'simet@usach.cl';
	//$bdMa=$link->query("SELECT * FROM usuarios");
	$bdMa=$link->query("SELECT * FROM usuarios WHERE responsableInforme = 'on'");
	//$bdMa=$link->query("SELECT * FROM usuarios WHERE usr = '".$_SESSION['usr']."'");
	if($rowMa=mysqli_fetch_array($bdMa)){
		do{
			if($rowMa['nPerfil'] != 'WM'){
				$mail_copias .= ','.$rowMa['email'];
			}
		}while($rowMa=mysqli_fetch_array($bdMa));
			
	}


	/* DESPUES BORRAR DESDE AQUI ARA QUE L ENVIE EL CORREO AL CLIENTE
	$bdMa=$link->query("SELECT * FROM usuarios WHERE usr = '".$_SESSION['usr']."'");
	if($rowMa=mysqli_fetch_array($bdMa)){
		$Email = $rowMa['email'];
	}
	 DESPUES BORRAR HASTA AQUI
	*/


	$link->close();
	$pCot = 'CAM-'.$CAM.'.pdf';
	
	$UN_SALTO="\r\n"; 
  	$DOS_SALTOS="\r\n\r\n"; 

	$UN_SALTO="<br>"; 
  	$DOS_SALTOS="<br><br>"; 

	
	$asunto = 'Envío Cotización CAM '.$CAM.' Solicitada';
	$mensaje  = 'Estimados : '.$UN_SALTO;
	$mensaje .= $Cliente.$DOS_SALTOS;
	$mensaje .= 'Atenci&oacute;n: '.$Contacto.$DOS_SALTOS;
	$txt 	= 'En el archivo adjunto se env&iacute;a cotizaci&oacute;n CAM ';
	$txt2 	= ' seg&uacute;n servicios solicitados, correspondiente a ';
	$obsServicios = $obsServicios;
	$mensaje .= $txt.$CAM.$txt2.$obsServicios.'.'.$DOS_SALTOS;
	
?>

<!doctype html>
 
<html lang="es">
<head>

<title>Eviar Cotización</title>
<link href="../styles.css" rel="stylesheet" type="text/css">
	<script src="../../ckeditor/ckeditor.js"></script>
	<script src="../../ckeditor/samples/js/sample.js"></script>
	<link rel="stylesheet" href="../../ckeditor/samples/css/samples.css">
	<link rel="stylesheet" href="../../ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">

</head>
<body>

<form action="https://simet.cl/erp/cotizaciones/recibePdf.php" method="post" enctype="multipart/form-data">
	<input name="CAM" 				type="hidden" id="CAM" 					value="<?php echo $CAM; ?>">
	<input name="mail_copias" 		type="hidden" id="mail_copias" 			value="<?php echo $mail_copias; ?>">
	<input name="mail_destinatario" type="hidden" id="mail_destinatario" 	value="<?php echo $Email; ?>">
	<input name="Cliente" 			type="hidden" id="Cliente" 				value="<?php echo $Cliente; ?>">
	<input name="Contacto" 			type="hidden" id="Contacto" 			value="<?php echo $Contacto; ?>">
	<input name="Observacion" 		type="hidden" id="Observacion" 			value="<?php echo $Observacion; ?>">
	
	<table width="80%"  border="0" align="center" cellpadding="0" cellspacing="0" id="cajaCorreo">
		<tr>
			<td class="tituloTrianguloCorreo"><div class="triangulo"></div></td>
		  	<td class="tituloCorreo">
		  		Enviar Correo Cotización <?php echo $pCot; ?>
				<div id="botonImagen">
					<?php 
						$prgLink = '../modCotizacion.php?CAM='.$CAM.'&Rev=0&Cta=0';
						echo '<a href="'.$prgLink.'" style="float:right;"><img src="../../imagenes/no_32.png"></a>';
					?>
				</div>
		  	</td>
		</tr>
		<tr>
			<td>Para:</td>
			<td>
				<?php 
					if($fdCorreos != ''){
						$i = 0;
						foreach ($fdCorreos as &$vCorreo) {
							$i++;
							if($i == 1){
								echo $fdCorreos[0];
							}else{
								?>
									,<a href="subirEnviarPdf.php?CAM=<?php echo $CAM; ?>&qEmail=<?php echo $vCorreo; ?>&Email=<?php echo $Email; ?>"><?php echo $vCorreo; ?></a>
								<?php
							}
						}
					}else{
						echo $Email;
					}
					
				?>
			</td>
		</tr>
		<tr>
			<td>Agregar a:</td>
			<td>
				<?php
					$ccEmail = 0;
					$link=Conectarse();
					$bdcCli=$link->query("SELECT * FROM contactoscli WHERE RutCli = '".$rowCot['RutCli']."' and nContacto != '".$nContacto."'");
					if($rowcCli=mysqli_fetch_array($bdcCli)){
						do{
							$ccEmail++;
							if($ccEmail > 1){ echo '<br>'; }
							//Verificar si ya esta el correo 
							$Mostrar = 'SI';
							if($fdCorreos != ''){
								foreach ($fdCorreos as &$vCorreo) {
									if($rowcCli['Email'] == $vCorreo){
										$Mostrar = 'NO';
									}
								}
							}

							//if($cContacto != $rowcCli['nContacto']){
							if($Mostrar == 'SI'){
								?>
									<a href="subirEnviarPdf.php?CAM=<?php echo $CAM; ?>&cContacto=<?php echo $rowcCli['nContacto']; ?>&Email=<?php echo $Email; ?>"><?php echo $rowcCli['Contacto'].'('.$rowcCli['Email'].')'; ?></a>
								<?php
							}
						}while($rowcCli=mysqli_fetch_array($bdcCli));
					}			
					$link->close();
				?>
			</td>
		</tr>
		<tr>
			<td>De :</td>
			<td>simet@usach.cl</td>
		</tr>
		<tr>
			<td>cc :</td>
			<td>
				<textarea name="mail_copias" id="mail_copias" rows="2" cols="100" readonly /><?php echo $mail_copias; ?></textarea>			
			</td>
		</tr>
		<tr>
			<td>Asunto :</td>
			<td><textarea name="asunto" rows="2" cols="100" required /><?php echo $asunto; ?></textarea></td>
		</tr>
		<tr>
			<td colspan="2">
				<textarea name="mensaje" id="editor"  rows="20" cols="110"><?php echo $mensaje; ?></textarea>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				Observaciones
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<textarea name="Observacion" id="editor" rows="7" cols="110"><?php echo $Observacion; ?></textarea>
			</td>
		</tr>
  		<tr>
  			<td colspan="2">
				Adjuntar: 
    			<input type="hidden" name="MAX_FILE_SIZE" value="1024000"> 
				<input name="dAdjunto" type="file" id="dAdjunto" required />
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input name="Subir" type="submit" class="titulopromocion" id="Subir" value="Enviar..."> 
			</td>
		</tr>
  </table>
</form> 
</body>
</html>

<script>
	initSample();
</script>
