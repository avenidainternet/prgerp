<?
include("conexion.php");
$Agno 	= $_GET['Agno'];
$Mes 	= $_GET['Mes'];

//Exportar datos de php a Word
header("Content-Type: application/vnd.ms-word");
header("content-disposition: attachment;filename=Actividad.doc");

header("Content-Transfer-Encoding: binary ");
header("Pragma: no-cache");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
?>
<HTML LANG="es">
<head>
	<TITLE>::. Exportacion de Datos .::</TITLE>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">
</head>
<body>
		
		<table border="1" cellpadding="0" cellspacing="0">

			<tr>
				<td colspan=11 height="40">Fecha :&nbsp;<?php echo date('Y-m-d'); ?>  </td>
			</tr>

			<tr>
				<td colspan=11 height="40">&nbsp;</td>
			</tr>
			
			<tr style="color:#FFFFFF; background-color:#006699; font-size:18px;" height="25">
			  	<td width="3px;">&nbsp;		</td>
			  	<td>PAM						</td>
			  	<td>Fecha RAM				</td>
			  	<td>Responsable				</td>
    			<td>Clientes				</td>
    			<td>Neto UF					</td>
    			<td>IVA	 UF					</td>
    			<td>Bruto UF				</td>
    			<td>Neto					</td>
    			<td>IVA						</td>
    			<td>Bruto					</td>
    			<td>Descripción				</td>
   			</tr>
  			<?php
				$link=Conectarse();
				$n = 0;
				$bdFac=mysql_query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P' Order By RAM Asc");
				if ($rowFac=mysql_fetch_array($bdFac)){
					do{ 
						$n++
						?>
  						<tr>
							<td>
								<?php
								$fechaTermino 	= strtotime ( '+'.$rowFac[dHabiles].' day' , strtotime ( $rowFac[fechaInicio] ) );
								$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );
												
								$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
								$ft = $rowFac[fechaInicio];
								$dh	= $rowFac[dHabiles]-1;
								$dd	= 0;
								for($i=1; $i<=$dh; $i++){
									$ft	= strtotime ( '+'.$i.' day' , strtotime ( $rowFac[fechaInicio] ) );
									$ft	= date ( 'Y-m-d' , $ft );
									$dia_semana = date("w",strtotime($ft));
									if($dia_semana == 0 or $dia_semana == 6){
										$dh++;
										$dd++;
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
								if($rowFac[Estado]=='P' and $nDias <= 2){ // Enviada
									$scr = 'amarilla';
									if($nDias <= 0){ // En Proceso
										$scr = 'roja';
										echo '<img src="http://erp.simet.cl/imagenes/bola_roja.png">';
									}else{
										echo '<img src="http://erp.simet.cl/imagenes/bola_amarilla.png">';
									}
								}else{
									if($rowFac[Estado] == 'P'){ // Aceptada
										$scr = 'verde';
										echo '<img src="http://erp.simet.cl/imagenes/bola_verde.png">';
									}
								}
								?>
							</td>
  					  		<td>
								<?php 
									echo 'R'.$rowFac['RAM'].'<br>';
									echo 'C'.$rowFac['CAM'];
								?>
							</td>
  					  		<td>
								<?php 
									$fd = explode('-', $rowFac[fechaCotizacion]);
									echo $fd[2].'/'.$fd[1]; 		
								?>
							</td>
  					  		<td><?php echo $rowFac['usrResponzable']; 		?></td>
    						<td>
								<?php 
									$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowFac['RutCli']."'");
									if ($rowCli=mysql_fetch_array($bdCli)){
										echo $rowCli['Cliente'];
									}
								?>
							</td>
    						<td><?php echo $rowFac['NetoUF']; 				?></td>
    						<td><?php echo $rowFac['IvaUF']; 				?></td>
    						<td><?php echo $rowFac['BrutoUF']; 				?></td>
    						<td><?php echo $rowFac['Neto']; 				?></td>
    						<td><?php echo $rowFac['Iva']; 					?></td>
    						<td><?php echo $rowFac['Bruto']; 				?></td>
    						<td><?php echo $rowFac['Descripcion']; 			?></td>
   						</tr>
						<?php
					}while ($rowFac=mysql_fetch_array($bdFac));
				}
				mysql_close($link);
				?>

				
			<tr>
				<td colspan=10 height="40">&nbsp;</td>
			</tr>


			<tr style="color:#FFFFFF; background-color:#006699; font-size:18px;" height="25">
			  	<td width="3px;">&nbsp;		</td>
			  	<td>RAM<br>CAM				</td>
			  	<td>Fecha RAM				</td>
			  	<td>Responsable				</td>
    			<td colspan=3>Clientes		</td>
    			<td>Contacto				</td>
    			<td colspan=3>Descripción	</td>
    			<td>Situación				</td>
   			</tr>
  			<?php
				$link=Conectarse();
				$n = 0;
				$bdFac=mysql_query("SELECT * FROM registroMuestras Where RAM > 0 and situacionMuestra != 'B' Order By RAM Desc");
				if ($rowFac=mysql_fetch_array($bdFac)){
					do{ 
						$n++;
						if($rowFac[situacionMuestra]=='B'){
							if($rowFac[CAM]>0){
								$tr = "#009966"; // Verde
								$scr = 	"http://erp.simet.cl/imagenes/bola_verde.png";
							}else{
								$tr = "#0099CC"; // Azul
								$scr = 	"http://erp.simet.cl/imagenes/bola_azul.png";
							}
						}
						if($rowFac[situacionMuestra]=='R'){
							$tr = "#FF0000"; // Roja
							$scr = 	"http://erp.simet.cl/imagenes/bola_roja.png";
						}
						if($rowFac[situacionMuestra]=='P'){
							$tr = "#009966"; // Verde
							$scr = 	"http://erp.simet.cl/imagenes/bola_verde.png";
						}
						?>
						<!-- <tr bgcolor="<?php echo $tr; ?>"> -->
						<tr>
							<td>
								<?php echo '<img src="'.$scr.'">'; ?>
							</td>
  					  		<td>
								<?php 
									echo 'R'.$rowFac['RAM'].'<br>';
									echo 'C'.$rowFac['CAM'];
								?>
							</td>
  					  		<td>
								<?php 
									$fd = explode('-', $rowFac[fechaRegistro]);
									echo $fd[2].'/'.$fd[1]; 		
								?>
							</td>
  					  		<td><?php echo $rowFac['usrRecepcion']; 		?></td>
    						<td colspan=3>
								<?php 
									$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowFac['RutCli']."'");
									if ($rowCli=mysql_fetch_array($bdCli)){
										echo $rowCli['Cliente'];
									}
								?>
							</td>
    						<td><?php echo $rowFac['nContacto']; 			?></td>
    						<td colspan=3>
								<?php echo $rowFac['Descripcion']; 			?>
							</td>
    						<td>
								<?php 
									if($rowFac['situacionMuestra']=='B'){
										if($rowFac[CAM]>0){
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
   						</tr>
						<?php
					}while ($rowFac=mysql_fetch_array($bdFac));
				}
				mysql_close($link);
				?>

				
			<tr>
				<td colspan=10 height="40">&nbsp;</td>
			</tr>

		</table>
</body>
</html>