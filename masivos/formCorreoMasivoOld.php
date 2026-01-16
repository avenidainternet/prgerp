<?php 
	if(!isset($_POST['Reg'])){
		header("Location: plataformaMasivos.php");
	}
	include_once("conexion.php");
	$link=Conectarse();
	$bdEnc=mysql_query("Delete From Masivos");
	mysql_close($link);
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
					<td colspan="2" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
						<span style="color:#FFFFFF; font-size:18px; font-weight:700;">
							Formulario de Correo
							<div id="botonImagen">
								<a href="plataformaMasivos.php" style="float:right;"><img src="../imagenes/no_32.png"></a>
							</div>
						</span>
					</td>
				</tr>
				<tr>
					<td width="20%">Para... </td>
					<td width="80%" align="justify">
<?php  
$csv_end = "  
";  
$csv_sep = "|";  
$csv_file = "datas.csv";  
$csv="";  

							foreach ($_POST['Reg'] as $valor) {
								list($RutCli) = split('[,]', $valor);
    							
								$Correos 	= '';
								$link=Conectarse();
								$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$RutCli."'");
								if($rowCli=mysql_fetch_array($bdCli)){
										$csv.=$rowCli[Cliente].$csv_sep.$rowCli[Email].$csv_end;  
									if($rowCli[Email]){
										
										if($Correos){
											//$Correos .= ', '.$rowCli[Cliente].'('.$rowCli[Email].')';
											$Correos .= ', '.$rowCli[Email];
										}else{
											//$Correos = $rowCli[Cliente].'('.$rowCli[Email].')';
											$Correos = $rowCli[Email];
										}

										$Contacto 	= $rowCli[Cliente];
										$Email 		= $rowCli[Email];
										mysql_query("insert into Masivos(RutCli,
																		 Contacto,
																		 Email
																		) 
															values 		('$RutCli',
																		 '$Contacto',
																		 '$Email'
										)",$link);

									}
									if($rowCli[EmailContacto]){
										if($Correos){
											$Correos .= ', '.$rowCli[Contacto].'('.$rowCli[EmailContacto].')';
										}else{
											$Correos = $rowCli[Contacto].'('.$rowCli[EmailContacto].')';
										}

										$Contacto 	= $rowCli[Contacto];
										$Email 		= $rowCli[EmailContacto];
										mysql_query("insert into Masivos(RutCli,
																		 Contacto,
																		 Email
																		) 
															values 		('$RutCli',
																		 '$Contacto',
																		 '$Email'
										)",$link);
									}
									if($rowCli[EmailContacto2]){
										if($Correos){
											$Correos .= ', '.$rowCli[Contacto2].'('.$rowCli[EmailContacto2].')';
										}else{
											$Correos = $rowCli[Contacto2].'('.$rowCli[EmailContacto2].')';
										}

										$Contacto 	= $rowCli[Contacto2];
										$Email 		= $rowCli[EmailContacto2];
										mysql_query("insert into Masivos(RutCli,
																		 Contacto,
																		 Email
																		) 
															values 		('$RutCli',
																		 '$Contacto',
																		 '$Email'
										)",$link);
									}
									if($rowCli[EmailContacto3]){
										if($Correos){
											$Correos .= ', '.$rowCli[Contacto3].'('.$rowCli[EmailContacto3].')';
										}else{
											$Correos = $rowCli[Contacto3].'('.$rowCli[EmailContacto3].')';
										}

										$Contacto 	= $rowCli[Contacto3];
										$Email 		= $rowCli[EmailContacto3];
										mysql_query("insert into Masivos(RutCli,
																		 Contacto,
																		 Email
																		) 
															values 		('$RutCli',
																		 '$Contacto',
																		 '$Email'
										)",$link);
									}
									if($rowCli[EmailContacto4]){
										if($Correos){
											$Correos .= ', '.$rowCli[Contacto4].'('.$rowCli[EmailContacto4].')';
										}else{
											$Correos = $rowCli[Contacto4].'('.$rowCli[EmailContacto4].')';
										}

										$Contacto 	= $rowCli[Contacto4];
										$Email 		= $rowCli[EmailContacto4];
										mysql_query("insert into Masivos(RutCli,
																		 Contacto,
																		 Email
																		) 
															values 		('$RutCli',
																		 '$Contacto',
																		 '$Email'
										)",$link);
									}
									echo $Correos.'<br>';
								}
								mysql_close($link);

//Generamos el csv de todos los datos  
if (!$handle = fopen($csv_file, "w")) {  
    echo "Cannot open file";  
    exit;  
}  
if (fwrite($handle, utf8_decode($csv)) === FALSE) {  
    echo "Cannot write to file";  
    exit;  
}  
fclose($handle);  
								
							}
							
						?>
					</td>
				</tr>
				<tr>
					<td colspan="2">Escriba el Mensaje a ser enviado :</td>
				</tr>
				<form name="form" action="masivo.php" method="post">
				<tr>
					<td colspan="2">
						<textarea name="msgCorreo" id="msgCorreo" cols="100" rows="30"><?php echo $msgCorreo; ?></textarea>					
						<?php echo '
									<input name="tablaReg" type="hidden" value="$tablaReg">
									';
						?>
					</td>
				</tr>
				<tr>
					<td colspan="2" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px; ">
						<div id="botonImagen">
							<button name="enviarMensaje" style="float:right;" title="Enviar Correo Masivo...">
								<img src="../imagenes/mail_html.png" width="60%">
							</button>
						</div>
					</td>
				</tr>
				</form>
			</table>
			</center>
		</div>
	</div>
</body>

