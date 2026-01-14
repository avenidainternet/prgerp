	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php
	include_once("conexion.php");
	$Enviados = 'No';
	if(isset($_GET['nEnc'])) 	{ $nEnc 	= $_GET['nEnc']; 	}
	if(isset($_GET['dBuscar'])) { 
		if($_GET['dBuscar'] == 'Enviados') { 
			$Enviados = 'Si';
		}else{
			$dBuscar  = $_GET['dBuscar']; 
		}
	}
	
				echo '<div>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td  width="05%" align="center" height="40"><strong>N°			</strong></td>';
				echo '			<td  width="36%">							<strong>Clientes	</strong></td>';
				echo '			<td  width="42%">							<strong>Correos		</strong></td>';
				echo '			<td  width="16%" align="center" colspan="2"><strong>Acciones	</strong></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListado">';
				$n 		= 0;
				$link=Conectarse();
				
				if($dBuscar){
					$bdEnc=mysql_query("SELECT * FROM Clientes Where Cliente Like '%".$dBuscar."%' Order By Cliente");
				}else{
					$bdEnc=mysql_query("SELECT * FROM Clientes Order By Cliente");
				}
				if ($row=mysql_fetch_array($bdEnc)){
					do{
						$tr = 'barraAmarilla';
						$Mostrar = 'Si';
						$bdTp=mysql_query("SELECT * FROM foliosEncuestas Where RutCli = '".$row['RutCli']."' && nEnc = '".$nEnc."'");
						if($rowTp=mysql_fetch_array($bdTp)){
							$tr = 'barraVerde';
							$Mostrar = 'No';
							if($Enviados == 'Si'){
								if($rowTp['fechaEnvio'] <> '0000-00-00'){
									$Mostrar = 'Si';
								}else{
									$Mostrar = 'No';
								}
							}else{
								$Mostrar = 'Si';
							}
						}
						if($Mostrar == 'Si'){
							echo '<tr id="'.$tr.'">';
							echo '	<td width="05%" style="font-size:16px;">';
							echo		$row['RutCli'].' - '.$Enviados;
							echo '	</td>';
							echo '	<td width="36%"><p>'.$row['Cliente'].'</p></td>';
							echo '	<td width="42%">';
							echo ' 		<p>';
										$Correos = '';
										$bdTp=mysql_query("SELECT * FROM foliosEncuestas Where RutCli = '".$row['RutCli']."' && nEnc = '".$nEnc."'");
										if($rowTp=mysql_fetch_array($bdTp)){
											do{
												if($rowTp['fechaRespuesta'] <> '0000-00-00'){
													$Correos .= 'Folio N° '.$rowTp['nFolio'].' -> '.$rowTp['Email'].' Resp.'.$rowTp['fechaRespuesta'].'<br>';
												}else{
													$Correos .= 'Folio N° '.$rowTp['nFolio'].' -> '.$rowTp['Email'].'<br>';
												}
											}while ($rowTp=mysql_fetch_array($bdTp));
										}else{
											$Correos = '';

											$bdCc=mysql_query("SELECT * FROM contactosCli Where RutCli = '".$row['RutCli']."'");
											if($rowCc=mysql_fetch_array($bdCc)){
												do{
													if($row['Email']){
														$Correos .= $rowCc['Email'].'<br>';
													}
												}while ($rowTp=mysql_fetch_array($bdTp));
											}

										}
							echo 			$Correos;
							echo '		</p>';
							echo '	</td>';
							echo '	<td width="10%" align="center">';
	
										$bdTp=mysql_query("SELECT * FROM foliosEncuestas Where RutCli = '".$row['RutCli']."' && nEnc = '".$nEnc."'");
										if($rowTp=mysql_fetch_array($bdTp)){
											echo '<a href="enviarEncuesta.php?nEnc='.$nEnc.'&RutCli='.$row['RutCli'].'" title="Enviar encuesta...">';
											echo '	<img src="../imagenes/enviadoOk.png" 			width="100" title="Encuesta Enviada el '.$rowTp['fechaEnvio'].'"> ' .$rowTp['fechaEnvio'];
											echo '</a>';
										}else{
											echo '
													<a href="enviarEncuesta.php?nEnc='.$nEnc.'&RutCli='.$row['RutCli'].'" title="Enviar encuesta...">
														<img src="../imagenes/enviarConsulta.png" width="50" height="50">
													</a>
												';
										}
										
							echo ' 	</td>';
							echo ' 	</td>';
							if($rowTp['fechaRespuesta']){
								echo '		<td width="06%"><a href="encCumplementero.php?nEnc='.$nEnc.'&RutCli='.$row['RutCli'].'"					><img src="../imagenes/consultas1.png" 		width="50" height="50" title="Revisar Encuesta Cumplimentero...">		</a></td>';
							}else{
								echo '		<td width="06%">&nbsp;</td>';
							}
							echo '</tr>';
						}
					}while ($row=mysql_fetch_array($bdEnc));
				}
				mysql_close($link);
				echo '	</table>';
				echo '</div>';
			?>
