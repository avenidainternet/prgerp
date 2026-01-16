<?php
	header('Content-Type: text/html; charset=iso-8859-1');
	include_once("conexion.php");
	date_default_timezone_set("America/Santiago");

	if(isset($_GET['dBuscar'])) { $dBuscar  = $_GET['dBuscar']; 	}
	
				echo '<div>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td  width="10%" align="center" height="40"><strong>CAM							</strong></td>';
				echo '			<td  width="08%">							<strong>Fecha						</strong></td>';
				echo '			<td  width="09%">							<strong>Resp. 						</strong></td>';
				echo '			<td  width="19%">							<strong>Clientes					</strong></td>';
				echo '			<td  width="15%">							<strong>Valor						</strong></td>';
				echo '			<td  width="08%">							<strong>Validez					</strong></td>';
				echo '			<td  width="08%">							<strong>Estado 						</strong></td>';
				echo '			<td  width="18%" align="center" colspan="6"><strong>Acciones					</strong></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListado">';
				$n 		= 0;
				$link=Conectarse();
				
				if($dBuscar){
					$bdEnc=mysql_query("SELECT * FROM Cotizaciones Where CAM Like '%".$dBuscar."%' Order By CAM Desc");
				}else{
					$bdEnc=mysql_query("SELECT * FROM Cotizaciones Order By CAM Desc");
				}
				if ($row=mysql_fetch_array($bdEnc)){
					do{
						$fechaxVencer 	= strtotime ( '+'.$row[Validez].' day' , strtotime ( $row[fechaCotizacion] ) );
						$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );

						$fd = explode('-', $fechaxVencer);
										
						$fechaHoy = date('Y-m-d');
						$start_ts = strtotime($fechaHoy); 
						$end_ts = strtotime($fechaxVencer); 
										
						$nDias = $end_ts - $start_ts;
						$nDias = round($nDias / 86400);
						$tDias = 3;
						$tr = "barraBlanca";
						if($row['Estado']==''){
						}
						if($row['Estado']=='E'){ // Enviada
							$tr = 'barraAmarilla';
							if($nDias <= $tDias){ // En Proceso
								$tr = 'barraAmarillaSinAc';
							}
						}
						if($row[Estado] == 'A'){ // Aceptada
							$tr = 'barraNaranja';
							if($nDias <= $tDias){ // En Proceso
								$tr = 'barraRojaSinAt';
							}
						}
						if($row[Estado] == 'P'){ // En Proceso
							$tr = 'barraVerde';
							if($nDias <= $tDias){ // En Proceso
								$tr = 'barraRoja';
							}
						}

						echo '<tr id="'.$tr.'">';
						echo '	<td width="10%" style="font-size:16px;" align="center">';
						echo		$row[CAM];
						echo '	</td>';
						echo '	<td width="08%" style="font-size:16px;">';
									$fd = explode('-', $row[fechaCotizacion]);
									echo $fd[2].'/'.$fd[1];
						echo '	</td>';
						echo '	<td width="09%">';
								echo 'AVR';
						echo '	</td>';
						echo '	<td width="19%" style="font-size:16px;">';
							$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$row[RutCli]."'");
							if($rowCli=mysql_fetch_array($bdCli)){
								echo 	$rowCli[Cliente];
							}
						echo '	</td>';
						echo '	<td width="15%">';
									echo '<strong style="font-size:16px;">';
									if($row[Moneda] == 'P'){
										echo 	number_format($row[Bruto], 0, ',', '.');
									}
									if($row[Moneda] == 'U'){
										echo 	number_format($row[BrutoUF], 2, ',', '.').' UF';
									}
									echo '</strong>';
						echo ' 	</td>';
						echo '	<td width="08%">';
									echo '<strong style="font-size:16px;">';
									if($row[Validez] == 0){
										echo 'Contado';
									}else{
										echo number_format($row[Validez], 0, ',', '.').' días';
										$fechaxVencer 	= strtotime ( '+'.$row[Validez].' day' , strtotime ( $row[fechaCotizacion] ) );
										$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );

										echo '<br>';
										$fd = explode('-', $fechaxVencer);
										echo $fd[2].'/'.$fd[1];
										
										$fechaHoy = date('Y-m-d');
										$start_ts = strtotime($fechaHoy); 
										$end_ts = strtotime($fechaxVencer); 
										
										$nDias = $end_ts - $start_ts;
										$nDias = round($nDias / 86400);
										echo '<br>';
										if($nDias <= $tDias){ // En Proceso
											echo '<div class="pVencer" title="Cotización por vencer">';
											echo 	$nDias;
											echo '</div';
											enviarAviso('francisco.olivares.rodriguez@gmail.com', $row[CAM], $nDias);
										}
										
									}
									echo '</strong>';
						echo ' 	</td>';
						echo '	<td width="08%">';
									if($row[Estado] == ''){ // Sin Enviar
										echo '<img src="../imagenes/noEnviado.png" 			width="32" height="32" title="Cotización NO Enviada">';
									}
									if($row[Estado] == 'E'){ // Enviada
										echo '<img src="../imagenes/enviarConsulta.png" 	width="32" height="32" title="Cotización Enviada">';
									}
									if($row[Estado] == 'A'){ // Aceptada
										echo '<img src="../imagenes/printing.png" 			width="32" height="32" title="Cotización Aceptada">';
									}
									if($row[Estado] == 'P'){ // En Proceso
										echo '<img src="../imagenes/settings_128.png" 		width="32" height="32" title="En Proceso">';
									}
									if($row[Estado] == 'C'){ // Cerrada
										echo '<img src="../imagenes/tpv.png" 				width="32" height="32" title="Cerrada para Cobranza">';
									}
						echo ' 	</td>';
						if($row[Estado] == 'P'){ // En Proceso
							echo '<td width="06%" align="center"><a href="plataformaCotizaciones.php?CAM='.$row[CAM].'&accion=Actualizar"		><img src="../gastos/imagenes/klipper.png" 			width="40" height="40" title="Seguimiento">			</a></td>';
						}else{
							echo '<td width="06%" align="center"><img src="../gastos/imagenes/klipper.png" width="40" height="40" title="Seguimiento" style="opacity:0;"></td>';
						}
						echo '	<td width="06%" align="center"><a href="plataformaCotizaciones.php?CAM='.$row[CAM].'&accion=Actualizar"		><img src="../gastos/imagenes/corel_draw_128.png" 	width="40" height="40" title="Editar Cotización">		</a></td>';
						echo '	<td width="06%" align="center"><a href="plataformaCotizaciones.php?CAM='.$row[CAM].'&accion=Borrar"			><img src="../gastos/imagenes/del_128.png"   		width="40" height="40" title="Borrar Cotización">		</a></td>';
						echo '</tr>';
					}while ($row=mysql_fetch_array($bdEnc));
				}
				mysql_close($link);
				echo '	</table>';
				echo '</div>';
			?>



<?php
	function enviarAviso($e, $CAM, $nDias){
/*
		$email	 = 'simet@usach.cl'; 
		$msg 	 = 'Faltan <strong>'.$nDias.'</strong> para que se venza cotización '.$CAM;
		$headers = "From: SIMET-USACH <".$email."> \r\n"; 
		//$headers .= "Bcc: francisco.olivares.rodriguez@gmail.com \r\n"; 
		$headers .= "Content-Type: text/html; charset=iso-8859-1\n";

		$themessage = '<br> Alerta de vencimiento cotización <br><strong>'.$CAM.'.</strong><br>'; 
		$themessage = '<br> Solicito prestar atención.<br>'; 
		$themessage .= '<pre style="font-size:14; font-family:Geneva, Arial, Helvetica, sans-serif;">'.$msg.'</pre><br>'; 
		$result=mail($e, "Control CAM - SIMET ", $themessage,$headers); 
		if($result=True){ 
			echo $e.' Enviado...! <br> '; 
		}else{
			echo $e.' ERROR NO Enviado...! <br> '; 
		}
*/
	
	}
?>