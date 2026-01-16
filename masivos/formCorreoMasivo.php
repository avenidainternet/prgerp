<?php 
	set_time_limit(0);

	if(!isset($_POST['Reg'])){
		header("Location: plataformaMasivos.php");
	}
	include_once("../conexionli.php");
	$msgCorreo = '';
	$link=Conectarse();
	$bdEnc=$link->query("Delete From Masivos");
	$link->close();
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Intranet Simet</title>
	
	<script src="../jquery/jquery-1.11.0.min.js"></script>
	<script src="../jquery/jquery-migrate-1.2.1.min.js"></script>	

	<script type="text/javascript" src="../jquery/libs/1/jquery.min.js"></script>	

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
                      <?php  
$csv_end = "  ";  
$csv_sep = "|";  
$csv_file = "datas.csv";  
$csv="";  
							$Correos 	= '';
							foreach ($_POST['Reg'] as $valor) {
								list($RutCli) = explode('[,]', $valor);
    							//echo $RutCli;
								$link=Conectarse();
								$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$RutCli."'");
								if($rowCli=mysqli_fetch_array($bdCli)){
									$csv.=$rowCli['Cliente'].$csv_sep.$rowCli['Email'].$csv_end; 

									$bdCt=$link->query("SELECT * FROM contactosCli Where RutCli = '".$RutCli."' and Email != ''");
									if($rowCt=mysqli_fetch_array($bdCt)){
										do{
											if($rowCt['Email']){
/*
												if($Correos){
													$Correos .= ', '.$rowCt['Contacto'].'('.$rowCt['Email'].')';
												}else{
													$Correos = $rowCt['Contacto'].'('.$rowCt['Email'].')';
												}
*/												
												$Contacto 	= $rowCt['Contacto'];
												$Email 		= $rowCt['Email'];
												$link->query("insert into Masivos(RutCli,
																				 Contacto,
																				 Email
																				) 
																	values 		('$RutCli',
																				 '$Contacto',
																				 '$Email'
												)");
											}
										}while($rowCt=mysqli_fetch_array($bdCt));
									}
								}
								$link->close();
							}
									$Correos = '';
									$Limite = 200;
									$i = 0;
									$Grupo = 1;
									$link=Conectarse();
									$bdMm=$link->query("SELECT * FROM Masivos");
									if($rowMm=mysqli_fetch_array($bdMm)){
										do{
											if(filter_var($rowMm['Email'], FILTER_VALIDATE_EMAIL)) {
												$i++;
												if($i >= $Limite){
													echo '<hr>';
													echo 'GRUPO => '.$Grupo;
													echo '<hr>';
													echo $Correos;
													$i=0;
													$Correos = '';
													$Grupo++;
												}
												if($Correos){
													$Correos .= ',<br>'.$rowMm['Email'];
												}else{
													$Correos = $rowMm['Email'];
												}
											}
											//echo $rowMm['Contacto'].'('.$rowMm['Email'].'),<br>';
										}while($rowMm=mysqli_fetch_array($bdMm));
									}
									$link->close();
									if($Correos){
										echo '<hr>';
										echo 'GRUPO => '.$Grupo;
										echo '<hr>';
										echo $Correos;
									}
						?>					</td>
				</tr>
			</table>
			</center>
		</div>
	</div>
</body>

