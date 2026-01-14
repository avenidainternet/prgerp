<?php
date_default_timezone_set("America/Santiago");
include_once("../conexionli.php");
//header('Content-Type: text/html; charset=utf-8');
include_once("../inc/funciones.php");

//$Agno 	= $_GET['Agno'];
//$Mes 	= $_GET['Mes'];

//Exportar datos de php a Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Transfer-Encoding: binary ");
header("Pragma: no-cache");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=PAM.xls");
?>
<HTML LANG="es">
<head>
<TITLE>::. Exportacion de Datos .::</TITLE>
</head>
<body>
		
		<table border="1" cellpadding="0" cellspacing="0" style="font-size:9px; ">

			<tr>
				<td colspan=7 height="40" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; font-weight:800;">
					Informe PAM 
					<br>(<?php echo date('Y-m-d').' '.date('H:m'); ?>)
				</td>
			</tr>
			
			<tr style="font-size:12px;" height="25">
			  	<td style="color:#FFFFFF; background-color:#006699;">&nbsp;						</td>
			  	<td style="color:#FFFFFF; background-color:#006699;">Atr.<br>Prom.				</td>
			  	<td style="color:#FFFFFF; background-color:#006699;">RAM<br>CAM					</td>
			  	<td style="color:#FFFFFF; background-color:#006699;">Fecha<br> PAM				</td>
    			<td style="color:#FFFFFF; background-color:#006699;" width="80px">Clientes		</td>
    			<td style="color:#FFFFFF; background-color:#006699;">Neto UF					</td>
    			<td style="color:#FFFFFF; background-color:#006699;">Descripci&oacute;n			</td>
   			</tr>
  			<?php
				$link=Conectarse();

				$n = 0;
				$bdFac=$link->query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P' Order By tpEnsayo Desc, RAM Asc");
				if ($rowFac=mysqli_fetch_array($bdFac)){
					do{ 
						list($ftermino, $dhf, $dha, $dsemana) = fnDiasHabiles($rowFac['fechaInicio'],$rowFac['dHabiles'],$rowFac['horaPAM']);
						$n++;
						if($dhf > 0){
							$cTd = '#00CC33';
							if($dhf == 1 or $dhf == 2){
								$cTd = '#FFFF00';
							}
						}
						if($dha > 0){
							$cTd = '#FF0000';
						}
						$cTd = '#FFFFFF';
						?>
  						<tr style="font-weight:800; font-family:Arial, Helvetica, sans-serif; font-size:12px;">
							<td align="center" valign="middle" bgcolor="<?php echo $cTd; ?>">
								<?php
								$scr = "";
								if($dhf > 0){
									$scr = 'amarilla';
									if($dhf == 1 or $dhf == 2){ // En Proceso
										echo '<img src="http://erp.simet.cl/imagenes/bola_amarilla.png">';
									}else{
										echo '<img src="http://erp.simet.cl/imagenes/bola_verde.png">';
									}
								}
								if($dha > 0){
									echo '<img src="http://erp.simet.cl/imagenes/bola_roja.png">';
								}
								?>
							</td>
							<td bgcolor="<?php echo $cTd; ?>">
								<?php 
									echo 'Atr.';
									if($dha > 0){
										echo $dha;
									}
									echo '<br> Pro.'.$rowFac['dHabiles'];
									if($dhf > 0){
										echo '<br> Faltan '.$dhf.' d&iacute;as';
									}
									
								?>
							</td>
  					  		<td bgcolor="<?php echo $cTd; ?>" align="center">
								<?php 
									echo 'R'.$rowFac['RAM'].'<br>';
									echo 'C'.$rowFac['CAM'];
									if($rowFac['tpEnsayo'] == 2){
										echo '<br><span style="font-weight:800; font-size:18px;">AF</span>';
									}
								?>
							</td>
  					  		<td align="center" bgcolor="<?php echo $cTd; ?>">
								<?php 
									$fd = explode('-', $rowFac['fechaInicio']);
									echo $fd[2].'/'.$fd[1].'<br>'; 		
									$fd = explode('-', $ftermino);
									echo $fd[2].'/'.$fd[1].'<br>'; 		
  					  				echo '<b>'.utf8_decode($rowFac['usrResponzable']).'</b>';
								?>
							</td>
    						<td bgcolor="<?php echo $cTd; ?>">
								<?php 
									$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowFac['RutCli']."'");
									if ($rowCli=mysqli_fetch_array($bdCli)){
										echo utf8_decode($rowCli['Cliente']);
									}
								?>
							</td>
    						<td align="right" bgcolor="<?php echo $cTd; ?>"><?php echo '<b>'.$rowFac['NetoUF'].'</b>'; ?></td>
    						<td bgcolor="<?php echo $cTd; ?>"><?php echo utf8_decode($rowFac['Descripcion']); 			?></td>
   						</tr>
						<?php
					}while ($rowFac=mysqli_fetch_array($bdFac));
				}
				$link->close();
				?>

			<tr>
				<td colspan="7" style="font-size:12px; font-weight:700;" align="center">Registro de Muestras</td>
			</tr>
			<tr style="font-size:12px;" height="25">
			  	<td style="color:#FFFFFF; background-color:#006699;" width="3px;">Status	</td>
			  	<td style="color:#FFFFFF; background-color:#006699;">Receptor				</td>
			  	<td style="color:#FFFFFF; background-color:#006699;">RAM<br>CAM				</td>
    			<td style="color:#FFFFFF; background-color:#006699;">Fecha<br>RAM			</td>
    			<td style="color:#FFFFFF; background-color:#006699;">Clientes				</td>
    			<td style="color:#FFFFFF; background-color:#006699;">Situaci&oacute;n		</td>
    			<td style="color:#FFFFFF; background-color:#006699;">Descripci&oacute;n		</td>
   			</tr>
  			<?php

				$link=Conectarse();
				$n = 0;
				$ultRAM = 10800;
				$bdFac=$link->query("SELECT * FROM registroMuestras Where situacionMuestra != 'B' and situacionMuestra != 'P' and RAM >= '".$ultRAM."' Order By RAM Desc");
				//$bdFac=$link->query("SELECT * FROM registroMuestras Where situacionMuestra != 'B' and situacionMuestra != 'P' Order By RAM Desc");
				//$bdFac=$link->query("SELECT * FROM registroMuestras Where RAM > 0 and situacionMuestra != 'B' Order By fechaRegistro");
				if ($rowFac=mysqli_fetch_array($bdFac)){
					do{ 
						$n++;
						$dirServidor = "http://servidorerp/erp/imagenes/";
						//$dirServidor = "/erp/imagenes/";
						if($rowFac['situacionMuestra']=='B'){
							if($rowFac['CAM']>0){
								$tr = "#009966"; // Verde
								$scr = 	$dirServidor."bola_verde.png";
							}else{
								$tr = "#0099CC"; // Azul
								$scr = 	$dirServidor."bola_azul.png";
							}
						}
						if($rowFac['situacionMuestra']=='R'){
							$tr = "#FF0000"; // Roja
							$scr = 	$dirServidor."bola_roja.png";

							$bdRAM=$link->query("SELECT * FROM Cotizaciones Where RAM = '".$rowFac['RAM']."'");
							if($rowRAM=mysqli_fetch_array($bdRAM)){
								if($rowRAM['Estado'] == 'E'){
									$tr = "#009966"; // Verde
									$scr = 	$dirServidor."bola_verde.png";
								}
							}
							
						}
/*
						if($rowFac['situacionMuestra']=='P'){
							$tr = "#009966"; // Verde
							$scr = 	"http://erp.simet.cl/imagenes/bola_verde.png";
						}
*/						
						?>
						<!-- <tr bgcolor="<?php echo $tr; ?>"> -->
						<tr>
							<td>
								<?php echo '<img src="'.$scr.'">'; ?>
							</td>
							<td>
								<?php echo utf8_decode($rowFac['usrRecepcion']); ?>
							</td>
  					  		<td>
								<?php 
									echo 'R'.$rowFac['RAM'].'<br>';
									if($rowFac['CAM']){
										echo 'C'.$rowFac['CAM'];
									}else{
										echo 'Sin CAM';
									}
								?>
							</td>
  					  		<td>
								<?php 
									$fd = explode('-', $rowFac['fechaRegistro']);
									echo $fd[2].'/'.$fd[1].'/'.$fd[0]; 		
								?>
							</td>
    						<td>
								<?php 
									$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowFac['RutCli']."'");
									if ($rowCli=mysqli_fetch_array($bdCli)){
										echo $rowCli['Cliente'];
									}
									echo '<br>('.$rowFac['nContacto'].')';
								?>
							</td>
    						<td>
								<?php 
									if($rowFac['situacionMuestra']=='B'){
										if($rowFac['CAM']>0){
											echo 'Asignado';
										}else{
											echo 'De Baja';
										}
									}
									if($rowFac['situacionMuestra']=='R'){
										echo 'Recepcionado';
									}
									if($rowFac['situacionMuestra']=='P'){
										echo 'Asignado';
									}
								?>
							</td>
    						<td>
								<?php echo utf8_decode($rowFac['Descripcion']); 			?>
							</td>
   						</tr>
						<?php
					}while ($rowFac=mysqli_fetch_array($bdFac));
				}
				$link->close();
		
				?>

	

		</table>
</body>
</html>