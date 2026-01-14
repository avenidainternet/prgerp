<?php
include_once("conexion.php");
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
<TITLE>::. Exportacion de Datos .::</TITLE>
</head>
<body>
		
		<table border="1" cellpadding="0" cellspacing="0" style="font-size:9px; ">

			<tr>
				<td colspan=7 height="40">Fecha :&nbsp;<?php echo date('Y-m-d'); ?>  </td>
			</tr>

			<tr>
				<td colspan=7 height="40">&nbsp;</td>
			</tr>
			
			<tr style="font-size:12px;" height="25">
			  	<td style="color:#FFFFFF; background-color:#006699;">&nbsp;						</td>
			  	<td style="color:#FFFFFF; background-color:#006699;">Atr.<br>Prom.				</td>
			  	<td style="color:#FFFFFF; background-color:#006699;">RAM<br>CAM					</td>
			  	<td style="color:#FFFFFF; background-color:#006699;">Fecha<br> PAM				</td>
    			<td style="color:#FFFFFF; background-color:#006699;" width="80px">Clientes		</td>
    			<td style="color:#FFFFFF; background-color:#006699;">Neto UF					</td>
    			<td style="color:#FFFFFF; background-color:#006699;">Descripción				</td>
   			</tr>
  			<?php
				$link=Conectarse();

				$n = 0;
				$bdFac=mysql_query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P' Order By RAM Asc");
				if ($rowFac=mysql_fetch_array($bdFac)){
					do{ 
						list($ftermino, $dhf, $dha, $dsemana) = fnDiasHabiles($rowFac['fechaInicio'],$rowFac['dHabiles'],$rowFac['horaPAM']);
						$n++
						?>
  						<tr>
							<td align="center" valign="middle">
								<?php
								$fechaTermino 	= strtotime ( '+'.$rowFac['dHabiles'].' day' , strtotime ( $rowFac['fechaInicio'] ) );
								$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );
												
								$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
								//              0      1      2      3       4     5      6
								
								$ft = $rowFac['fechaInicio'];
								$dh	= $rowFac['dHabiles']-1;
								$dd	= 0;
								for($i=1; $i<=$dh; $i++){
									$ft	= strtotime ( '+'.$i.' day' , strtotime ( $rowFac['fechaInicio'] ) );
									$ft	= date ( 'Y-m-d' , $ft );
									$dia_semana = date("w",strtotime($ft));
									if($dia_semana == 0 or $dia_semana == 6){
										$dh++;
										$dd++;
									}
								}
								
								$fechaHoy = date('Y-m-d');
								$fechaHoy	= strtotime ( '+1 day' , strtotime ( $fechaHoy ) );
								$fechaHoy	= date ( 'Y-m-d' , $fechaHoy );
								
								$fComprometida = $ft;
								$i 		 = 0;
								$fSw 	 = 0;
								$dAtrazo = 0;
								while($fComprometida <= $fechaHoy){
									$i++;
									$fComprometida	= strtotime ( '+1 day' , strtotime ( $fComprometida ) );
									$fComprometida	= date ( 'Y-m-d' , $fComprometida );
									$dia_semana = date("w",strtotime($fComprometida));
									if($dia_semana == 0 or $dia_semana == 6){
									}else{
										$dAtrazo++;
									}
								}
								
								$fd = explode('-', $ft);
												
								$fechaHoy = date('Y-m-d');
								$start_ts 	= strtotime($fechaHoy); 
								$end_ts 	= strtotime($ft); 
												
								$tDias = 1;
								$nDias = $end_ts - $start_ts;
		
								$nDias = round($nDias / 86400)+1;
								if($ft < $fechaHoy){
									$nDias = $nDias - $dd;
								}
								
								$scr = "";
								if($dhf > 0){
									$scr = 'amarilla';
									if($dhf == 1 or $dhf == 2){ // En Proceso
										$scr = 'roja';
										echo '<img src="http://erp.simet.cl/imagenes/bola_amarilla.png">';
									}else{
										echo '<img src="http://erp.simet.cl/imagenes/bola_verde.png">';
									}
								}
								if($dha > 0){
									echo '<img src="http://erp.simet.cl/imagenes/bola_roja.png">';
								}
								if($rowFac['Estado']=='P' and $nDias <= 2){ // Enviada
									$scr = 'amarilla';
									if($nDias <= 0){ // En Proceso
										$scr = 'roja';
										echo '<img src="http://erp.simet.cl/imagenes/bola_roja.png">';
									}else{
										echo '<img src="http://erp.simet.cl/imagenes/bola_amarilla.png">';
									}
								}else{
									if($rowFac['Estado'] == 'P'){ // Aceptada
										$scr = 'verde';
										echo '<img src="http://erp.simet.cl/imagenes/bola_verde.png">';
									}
								}
								?>
							</td>
							<td>
								<?php echo 'Atr.'.$dAtrazo.'<br>'.'Pro.'.$rowFac['dHabiles']; ?>
							</td>
  					  		<td>
								<?php 
									echo 'R'.$rowFac['RAM'].'<br>';
									echo 'C'.$rowFac['CAM'];
								?>
							</td>
  					  		<td align="center">
								<?php 
									$fd = explode('-', $rowFac['fechaInicio']);
									echo $fd[2].'/'.$fd[1].'/'.$fd[0].'<br>'; 		
									$fd = explode('-', $ft);
									echo $fd[2].'/'.$fd[1].'/'.$fd[0].'<br>'; 		
  					  				echo '<b>'.$rowFac['usrResponzable'].'</b>';
								?>
							</td>
    						<td>
								<?php 
									$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowFac['RutCli']."'");
									if ($rowCli=mysql_fetch_array($bdCli)){
										echo $rowCli['Cliente'];
									}
								?>
							</td>
    						<td align="right"><?php echo '<b>'.$rowFac['NetoUF'].'</b>'; ?></td>
    						<td><?php echo $rowFac['Descripcion']; 			?></td>
   						</tr>
						<?php
					}while ($rowFac=mysql_fetch_array($bdFac));
				}
				mysql_close($link);
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
    			<td style="color:#FFFFFF; background-color:#006699;">Situación				</td>
    			<td style="color:#FFFFFF; background-color:#006699;">Descripción			</td>
   			</tr>
  			<?php

				$link=Conectarse();
				$n = 0;
				$bdFac=mysql_query("SELECT * FROM registroMuestras Where situacionMuestra != 'B' and situacionMuestra != 'P' Order By RAM Desc");
				//$bdFac=mysql_query("SELECT * FROM registroMuestras Where RAM > 0 and situacionMuestra != 'B' Order By fechaRegistro");
				if ($rowFac=mysql_fetch_array($bdFac)){
					do{ 
						$n++;
						if($rowFac['situacionMuestra']=='B'){
							if($rowFac['CAM']>0){
								$tr = "#009966"; // Verde
								$scr = 	"http://erp.simet.cl/imagenes/bola_verde.png";
							}else{
								$tr = "#0099CC"; // Azul
								$scr = 	"http://erp.simet.cl/imagenes/bola_azul.png";
							}
						}
						if($rowFac['situacionMuestra']=='R'){
							$tr = "#FF0000"; // Roja
							$scr = 	"http://erp.simet.cl/imagenes/bola_roja.png";

							$bdRAM=mysql_query("SELECT * FROM Cotizaciones Where RAM = '".$rowFac['RAM']."'");
							if($rowRAM=mysql_fetch_array($bdRAM)){
								if($rowRAM['Estado'] == 'E'){
									$tr = "#009966"; // Verde
									$scr = 	"http://erp.simet.cl/imagenes/bola_verde.png";
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
								<?php echo $rowFac['usrRecepcion']; ?>
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
									$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowFac['RutCli']."'");
									if ($rowCli=mysql_fetch_array($bdCli)){
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
								<?php echo $rowFac['Descripcion']; 			?>
							</td>
   						</tr>
						<?php
					}while ($rowFac=mysql_fetch_array($bdFac));
				}
				mysql_close($link);
		
				?>

	

		</table>
</body>
</html>