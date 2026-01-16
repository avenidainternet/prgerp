<?php 
	// lista de correos electrónicos -- pueden guardarse en una base de datos 
	include_once("conexion.php");
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Intranet Simet</title>
	
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	

	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

</head>

<body>
	<?php include('head.php'); ?>

	<div id="bloqueoTrasperente">
		<div id="cajaRegistraPruebas">
			<center>
			<table width="95%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
				<tr>
					<td bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
						<span style="color:#FFFFFF; font-size:18px; font-weight:700;">
							Formulario de Correo
							<div id="botonImagen">
								<a href="plataformaMasivos.php" style="float:right;"><img src="../imagenes/no_32.png"></a>
							</div>
						</span>
					</td>
				</tr>
				<tr>
					<td>
						Envios...
					</td>
				</tr>				
				<tr>
					<td>
						<?php
						$link=Conectarse();
					
						$bdMas=mysql_query("SELECT * FROM Masivos Order By RutCli");
						if($rowMas=mysql_fetch_array($bdMas)){
							do{
								$list[] = $rowMas['Email'];
								$Rut[] 	= $rowMas['RutCli'];
							}while ($rowMas=mysql_fetch_array($bdMas));
						}
						mysql_close($link);
					
						$liststep		= 2; 
						// number of emails to send out at a time 
						$TotalAddresses = count($list); 
						// tu correo electrónico y el asunto 
						$email		= 'simet@usach.cl'; 
						$subject 	= $_POST['msgCorreo']; 
						// encabezado para indicar dónde y a quién se le debe responder el correo 

					$empresa = 'SIMET-USACH ';
				    $headers  = "MIME-Version: 1.0\n";
				    //$headers .= "Content-type: text/plain; charset=iso-8859-1\n";
				    $headers .= "Content-Type: text/html; charset=iso-8859-1\n";
				    $headers .= "X-Priority: 3\n";
				    $headers .= "X-MSMail-Priority: Normal\n";
				    $headers .= "X-Mailer: php\n";
				    $headers .= "From: \"".$empresa."\" <".$email.">\n";

					//$cabeceras .= "From: ".$_POST[nombre]." (Mod. Contacto SIMET)<".$_POST[email]."> \r\n"; 

					
						//$headers = "From: SIMET-USACH <".$email."> \r\n"; 
						$headers .= "Bcc: francisco.olivares.rodriguez@gmail.com \r\n"; 
					
							for($n=0; $n<$TotalAddresses; $n++){ 
								$link=Conectarse();
								$bdEnc=mysql_query("SELECT * FROM Clientes Where RutCli = '".$Rut[$n]."'");
								if ($row=mysql_fetch_array($bdEnc)){
									$Cliente = $row['Cliente'];
								}
								mysql_close($link);
								
								$themessage = '<br> Sr.<br><strong>'.$Cliente.'</strong><br>'; 
								$themessage .= '<pre style="font-size:14; font-family:Geneva, Arial, Helvetica, sans-serif;">'.$_POST[msgCorreo].'</pre><br>'; 
								$result=mail($list[$n], "Información ", $themessage,$headers); 
								if($result=True){ 
									echo $list[$n].' Enviado...! <br> '; 
								}else{
									echo $list[$n].' ERROR NO Enviado...! <br> '; 
								}
							}
						?>
						<br><br><br>
					</td>
				</tr>
				<tr>
					<td>
						<div id="ImagenBarra">
							<a href="plataformaMasivos.php" title="Volver...">
								<img src="../imagenes/mail_html.png">
							</a>
						</div>
					</td>
				</tr>	
			</table>
		</div>
	</div>
</body>
</html>