<?php
	session_start(); 
	header('Content-Type: text/html; charset=iso-8859-1');
	include_once("conexion.php");
	date_default_timezone_set("America/Santiago");
		$link=Conectarse();
		$bdCli=mysql_query("SELECT * FROM SolFactura Where valorUF > 0 Order By valorUF Desc");
		if($rowCli=mysql_fetch_array($bdCli)){
			$ultUF = $rowCli[valorUF];
		}
		mysql_close($link);

	if(isset($_GET['usrFiltro'])) { $usrFiltro  = $_GET['usrFiltro']; 	}
	if(isset($_SESSION[empFiltro])) { 
		//$empFiltro  = $_GET['empFiltro']; 	
		$empFiltro = $_SESSION[empFiltro];
		$link=Conectarse();
		$bdCli=mysql_query("SELECT * FROM Clientes Where Cliente Like '%".$empFiltro."%'");
		if($rowCli=mysql_fetch_array($bdCli)){
			$filtroCli = $rowCli[RutCli];
		}
		mysql_close($link);
	}else{
		$filtroCli = '';
	}

	$usrFiltro = $_SESSION[usrFiltro];
	
	
	?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="45%" valign="top">
					<?php mCAMs($usrFiltro, $filtroCli); ?>
				</td>
				<td width="45%" valign="top">
					<?php mRAMs($usrFiltro, $filtroCli); ?>
					<?php 
						if($_SESSION[usr]=='Alfredo.Artigas' or $_SESSION[usr] == '10074437'){
							sTerminados($filtroCli); 
						}
					?>
				</td>
			</tr>
		</table>
		
		<?php
		function mCAMs($usrFiltro, $filtroCli){
				global $ultUF;
				$filtro = '';
				if($usrFiltro){
					$filtro = " and usrCotizador Like '%".$usrFiltro."%'";
				}
				if($filtroCli){
					$filtro = " and RutCli Like '%".$filtroCli."%'";
				}
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloCAM">';
				echo '		<tr>';
				echo '			<td  width="10%" align="center" height="40">CAM 		</td>';
				echo '			<td  width="08%">							Fecha		</td>';
				echo '			<td  width="28%">							Clientes	</td>';
				echo '			<td  width="14%">							Total		</td>';
				echo '			<td  width="14%">							Validez		</td>';
				echo '			<td  width="08%">							Est. 		</td>';
				echo '			<td  width="18%" align="center" colspan="3">Acciones	</td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListadoCAM">';

				$n 		 = 0;
				$tCAMsUF = 0;
				
				$link=Conectarse();
				if($_SESSION[usr]=='Alfredo.Artigas' or $_SESSION[usr] == '10074437' or substr($_SESSION[IdPerfil],0,1) == 0){
					if($filtro){
						//$bdEnc=mysql_query("SELECT * FROM Cotizaciones Where Estado != 'C' and RAM = 0 and ".$filtro."' Order By Estado Desc");
						$sql = "SELECT * FROM Cotizaciones Where Estado != 'C' and RAM = 0 ".$filtro." Order By Estado Desc";
						$bdEnc=mysql_query($sql);
						//$bdEnc=mysql_query("SELECT * FROM Cotizaciones Where Estado != 'C' and RAM = 0 and usrCotizador Like '%".$usrFiltro."%' Order By Estado Desc");
					}else{
						$bdEnc=mysql_query("SELECT * FROM Cotizaciones Where Estado != 'C' and RAM = 0 Order By Estado Desc");
					}
				}else{
					if($filtro){
						$sql = "SELECT * FROM Cotizaciones Where RAM = 0 and Estado != 'C' ".$filtro." Order By Estado Desc";
						$bdEnc=mysql_query($sql);
						//$bdEnc=mysql_query("SELECT * FROM Cotizaciones Where usrCotizador Like '".$usrFiltro."' and RAM = 0 Order By Estado Desc");
					}else{
						$bdEnc=mysql_query("SELECT * FROM Cotizaciones Where RAM = 0 and Estado != 'C' Order By Estado Desc");
						//$bdEnc=mysql_query("SELECT * FROM Cotizaciones Where RAM = 0 Order By CAM Desc");
					}
				}
				if ($row=mysql_fetch_array($bdEnc)){
					do{
						$tCAMsUF += $row[NetoUF];
						$fechaxVencer 	= strtotime ( '+'.$row[Validez].' day' , strtotime ( $row[fechaCotizacion] ) );
						$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
						
						$treinta = 30;
						$fechaaCerrar 	= strtotime ( '+'.$treinta.' day' , strtotime ( $row[fechaCotizacion] ) );
						$fechaaCerrar 	= date ( 'Y-m-d' , $fechaaCerrar );

						$fd = explode('-', $fechaxVencer);
										
						$fechaHoy = date('Y-m-d');
						$start_ts = strtotime($fechaHoy); 
						$end_ts = strtotime($fechaxVencer); 
										
						$nDias = $end_ts - $start_ts;
						$nDias = round($nDias / 86400);
						$tDias = 3;
						
						$tr = "bBlanca";
						if($row[Estado]==' '){
							$tr = "bBlanca";
						}
						if($row[Estado]=='E'){ // Enviada
							$tr = "bAmarilla";
							if($nDias <= $tDias){ // En Proceso
								$tr = 'bRoja';
							}
							if($row[proxRecordatorio] <= $fechaHoy){ // En Proceso
								$tr = 'bRoja';
							}
						}
						if($row[Estado] == 'A'){ // Aceptada
							$tr = 'bVerde';
						}
						if($row[fechaAceptacion] != '0000-00-00'){ // Aceptada
							$tr = 'bVerde';
						}
						echo '<tr id="'.$tr.'">';
						echo '	<td width="10%" style="font-size:12px;" align="center">';
									if($row[Rev]<10){
										$Revision = '0'.$row[Rev]; 
									}else{
										$Revision = $row[Rev]; 
									}
						echo		'<strong style="font-size:14; font-weight:700">'.$row[CAM].'</strong>'.'<br> Rev.'.$Revision;
									if($row[Cta]){
										echo '<br>CC';
									}
						echo '	</td>';
						echo '	<td width="08%" style="font-size:12px;">';
									$fd = explode('-', $row[fechaCotizacion]);
									echo $fd[2].'/'.$fd[1];
									echo '<br>'.$row[usrCotizador];
									//echo '<br>'.$_SESSION[usr];
						echo '	</td>';
						echo '	<td width="28%" style="font-size:12px;">';
							$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$row[RutCli]."'");
							if($rowCli=mysql_fetch_array($bdCli)){
								echo $rowCli[Cliente];
								echo '<br>'.$filtroCli;
							}
						echo '	</td>';
						echo '	<td width="12%" style="font-size:12px;">';
									if($row[Moneda] == 'P'){
										echo number_format($row[Bruto], 0, ',', '.');
									}else{
										echo number_format($row[BrutoUF], 2, ',', '.').' UF';
									}
						echo ' 	</td>';
						echo '	<td width="14%" style="font-size:12px;">';
									if($row[Validez] == 0){
										echo 'Contado';
									}else{
										//echo number_format($row[Validez], 0, ',', '.').' días';
										$fechaxVencer 	= strtotime ( '+'.$row[Validez].' day' , strtotime ( $row[fechaCotizacion] ) );
										$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );

										//echo '<br>';
										$fd = explode('-', $fechaxVencer);
										echo $fd[2].'/'.$fd[1];
										
										$fechaHoy = date('Y-m-d');
										$start_ts 	= strtotime($fechaHoy); 
										$end_ts 	= strtotime($fechaxVencer); 
										
										$nDias = $end_ts - $start_ts;
										$nDias = round($nDias / 86400);
										echo '<br>';
										if($nDias <= $tDias){ // En Proceso
											echo '<div class="pVencer" title="Cotización por vencer">';
											echo 	$nDias;
											echo '</div';
											//enviarAviso('francisco.olivares.rodriguez@gmail.com', $row[CAM], $nDias);
										}else{
											echo '<div class="sVencer" title="Días por vencer">';
											echo 	$nDias;
											echo '</div';
										}
									}
						echo ' 	</td>';
						echo '	<td width="08%">';
									if($row[enviadoCorreo] == ''){ // Sin Enviar
										echo '<img src="../imagenes/noEnviado.png" 	width="32" height="32" title="Cotización NO Enviada"><br>';
									}
									if($row[enviadoCorreo] == 'on'){ // Enviada
										if($row[proxRecordatorio] <= $fechaHoy){ // En Proceso
											echo '<img src="../imagenes/alerta.gif" 	width="50" title="Contactar con Cliente">';
										}else{
											echo '<img src="../imagenes/enviarConsulta.png" 	width="32" height="32" title="Cotización Enviada">';
										}
										echo '<br>';
										$fd = explode('-', $row[fechaEnvio]);
										echo $fd[2].'-'.$fd[1];
									}
									if($row[Estado] == 'A'){ // Aceptada
										echo '<img src="../imagenes/printing.png" 			width="32" height="32" title="Cotización Aceptada">';
										echo '<br>';
										$fd = explode('-', $row[fechaAceptacion]);
										echo $fd[2].'-'.$fd[1];
									}else{
									}
						echo ' 	</td>';
						if($row[Estado] == 'E' or $row[Estado] == 'A'){ // En Proceso
							echo '<td width="06%" align="center"><a href="plataformaCotizaciones.php?CAM='.$row[CAM].'&accion=Seguimiento"	><img src="../gastos/imagenes/klipper.png" 			width="40" height="40" title="Seguimiento">			</a></td>';
						}else{
							echo '<td width="06%" align="center"><img src="../gastos/imagenes/klipper.png" width="40" height="40" title="Seguimiento" style="opacity:0;"></td>';
						}
						echo '	<td width="06%" align="center"><a href="modCotizacion.php?CAM='.$row[CAM].'&Rev='.$Rev.'&Cta='.$row[Cta].'&accion=Actualizar"	><img src="../gastos/imagenes/corel_draw_128.png" 	width="40" height="40" title="Editar Cotización">		</a></td>';
						echo '	<td width="06%" align="center"><a href="modCotizacion.php?CAM='.$row[CAM].'&Rev='.$Rev.'&Cta='.$row[Cta].'&accion=Borrar"		><img src="../gastos/imagenes/del_128.png"   		width="40" height="40" title="Borrar Cotización">		</a></td>';
						echo '</tr>';
					}while ($row=mysql_fetch_array($bdEnc));
				}
				mysql_close($link);
					echo '<tr id="bAzul">';
					echo '	<td colspan=9 style="font-size: 18px; font-weight:700">';

								$sTotales = 0;
								$txt = 'Total CAM (Última UF '.number_format($ultUF, 2, ',', '.').') x ';
								if($tCAMsUF>0){
									$txt .= number_format($tCAMsUF, 2, ',', '.').' UF';
									$sTotales = $ultUF * $tCAMsUF;
									$txt .= ' = '.number_format($sTotales, 0, ',', '.');
								}
								echo $txt;
								
					echo '	</td>';
					echo '</tr>';
				
				echo '	</table>';
			}
			?>

<!-- 
****************************************************************************************************************
*
*             Nominas de Servicios en Procesos RAM
*
*
****************************************************************************************************************

-->
		<?php
		function mRAMs($usrFiltro, $filtroCli){
				global $ultUF;
				$filtro = '';
				if($usrFiltro){
					$filtro = " and usrResponzable Like '%".$usrFiltro."%'";
				}
				if($filtroCli){
					$filtro = " and RutCli Like '%".$filtroCli."%'";
				}
				$tRAMsUF = 0;
				$tRAMsPe = 0;
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloCAM">';
				echo '		<tr>';
				echo '			<td  width="10%" align="center" height="40">RAM			 </td>';
				echo '			<td  width="10%">							Inicio		 </td>';
				echo '			<td  width="10%">							Término		 </td>';
				echo '			<td  width="18%">							Clientes	 </td>';
				echo '			<td  width="28%">							Observaciones</td>';
				echo '			<td  width="10%">							Estado 		 </td>';
				echo '			<td  width="14%" align="center">Seguimiento	</td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListadoCAM">';
				$n 		= 0;
				$link=Conectarse();
				
				if($_SESSION[usr]=='Alfredo.Artigas' or $_SESSION[usr] == '10074437' or substr($_SESSION[IdPerfil],0,1) == 0){
					if($filtro){
						$sql = "SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P' ".$filtro." Order By RAM Asc";
						$bdEnc=mysql_query($sql);
						//$bdEnc=mysql_query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P' and usrCotizador Like '%".$usrFiltro."%' Order By RAM Asc");
					}else{
						$bdEnc=mysql_query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P' Order By RAM Asc");
					}
				}else{
					if($filtro){
						$sql = "SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P' ".$filtro." Order By RAM Asc";
						$bdEnc=mysql_query($sql);
					}else{
						$bdEnc=mysql_query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P' Order By RAM Asc");
					}
				}
				if ($row=mysql_fetch_array($bdEnc)){
					do{
						$tRAMsUF += $row[NetoUF];
						$tRAMsPe += $row[Neto];
						
						$fechaTermino 	= strtotime ( '+'.$row[dHabiles].' day' , strtotime ( $row[fechaInicio] ) );
						$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );
										
						$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
						$ft = $row[fechaInicio];
						$dh	= $row[dHabiles]-1;
						$dd	= 0;
						for($i=1; $i<=$dh; $i++){
							$ft	= strtotime ( '+'.$i.' day' , strtotime ( $row[fechaInicio] ) );
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
						
/*						

						$fd = explode('-', $fechaTermino);
										
						$fechaHoy = date('Y-m-d');
						$start_ts = strtotime($fechaHoy); 
						$end_ts   = strtotime($fechaTermino); 
										
						$nDias = $end_ts - $start_ts;
						$nDias = round($nDias / 86400);
						$tDias = 1;
*/						
						$tr = "bBlanca";
						if($row[Estado]=='P' and $nDias <= 2){ // Enviada
							$tr = "bAmarilla";
							if($nDias <= 0){ // En Proceso
								$tr = 'bRoja';
							}
						}else{
							if($row[Estado] == 'P'){ // Aceptada
								$tr = 'bVerde';
							}
						}
						echo '<tr id="'.$tr.'">';
						echo '	<td width="10%" style="font-size:12px;" align="center">';
						echo		'<strong style="font-size:14; font-weight:700">R'.$row[RAM].'</strong><br>C'.$row[CAM];
									if($row[Cta]){
										echo '<br>CC';
									}
						echo '	</td>';
						echo '	<td width="10%" style="font-size:12px;">';
									if($row[fechaInicio] != 0){
										$fd = explode('-', $row[fechaInicio]);
										echo $fd[2].'/'.$fd[1];
										echo '<br>'.$row[usrResponzable];
									}else{
										echo 'NO Asignado';
									}
						echo '	</td>';
						echo '	<td width="10%" style="font-size:12px;">';
									if($row[fechaInicio] != 0){
										echo number_format($row[dHabiles], 0, ',', '.').' días';
										$fechaTermino 	= strtotime ( '+'.$row[dHabiles].' day' , strtotime ( $row[fechaInicio] ) );
										$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );
										
										$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
										$fechaHoy = date('Y-m-d');
										
										$atrazado = 'No';
										if($fechaHoy > $fechaTermino) {
											// 29/7      28/7
											$atrazado = 'Si';
										}else{
											// 29/7      31/7
										}

										$ft = $row[fechaInicio];
										$dh	= $row[dHabiles]-1;
										$dd	= 0;
										$cDias = 0;
										for($i=1; $i<=$dh; $i++){
											$ft	= strtotime ( '+'.$i.' day' , strtotime ( $row[fechaInicio] ) );
											$ft	= date ( 'Y-m-d' , $ft );
											$dia_semana = date("w",strtotime($ft));
											if($dia_semana == 0 or $dia_semana == 6){
												$dh++;
												$dd++;
											}else{
												$cDias++;
											}
										}

										$fd = explode('-', $ft);
										echo '<br>'.$dSem[$dia_semana].'<br>'.$fd[2].'/'.$fd[1];
										
										$fechaHoy = date('Y-m-d');
										$start_ts 	= strtotime($fechaHoy); 
										$end_ts 	= strtotime($ft); 
										
										$tDias = 1;
										if($ft<$fechaHoy){
											$fIni = $ft;

											$ft = $fIni;

											$start_ts 	= strtotime($fechaHoy); 
											$end_ts 	= strtotime($ft); 
											
											$dh	= $row[dHabiles]-1;
											$dh = $start_ts - $end_ts;
											$dh = round($dh / 86400);
											
											$ddAtrazo	= 0;
											$cDias = 1;
											for($i=1; $i<=$dh; $i++){
												$ft	= strtotime ( '+'.$i.' day' , strtotime ( $fIni ) );
												$ft	= date ( 'Y-m-d' , $ft );
												$dia_semana = date("w",strtotime($ft));
												if($dia_semana == 0 or $dia_semana == 6){
													$dh++;
													$ddAtrazo++;
												}else{
													$cDias++;
												}
											}
											$nDias = $end_ts - $start_ts;
										}else{
											$nDias = $end_ts - $start_ts;
										}

										if($ft < $fechaHoy){
											$nDias = round($nDias / 86400);
											//$nDias = $nDias - $dd;
										}else{
											$nDias = round($nDias / 86400)+1;
										}
										echo '<br>';
										if($nDias <= $tDias or $ft<$fechaHoy){ // En Proceso
											echo '<div class="pVencer" title="Días de Plazo RAM">';
											if($nDias==0){ $nDias = $nDias -2; }
											echo 	$nDias;
											echo '</div';
										}else{
											echo '<div class="sVencer" title="Días plazo RAM">';
											echo 	$nDias;
											echo '</div';
										}
									}else{
										echo number_format($row[dHabiles], 0, ',', '.').' días';
										echo '<br>Sin asignar';
									}
						echo ' 	</td>';
						echo '	<td width="18%" style="font-size:12px;">';
							$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$row[RutCli]."'");
							if($rowCli=mysql_fetch_array($bdCli)){
								echo 	$rowCli[Cliente];
							}
						echo '	</td>';
						echo '	<td width="28%">';
						echo '		<strong style="font-size:10px;">';
										if($row[obsServicios]){
											echo substr($row[obsServicios],0,100).'...';
										}
						//echo 			number_format($row[BrutoUF], 2, ',', '.').' UF';
						echo '		</strong>';
						echo ' 	</td>';
						echo '	<td width="10%">';
									if($row[Estado] == 'P'){ // En Proceso
										echo '<img src="../imagenes/machineoperator_128.png" 		width="40" height="40" title="En Proceso">';
										//echo '<img src="../imagenes/settings_128.png" 		width="32" height="32" title="En Proceso">';
									}
									if($row[Estado] == 'C'){ // Cerrada
										echo '<img src="../imagenes/tpv.png" 				width="32" height="32" title="Cerrada para Cobranza">';
									}
						echo ' 	</td>';
						echo '	<td width="14%" align="center">';
								if($row[Estado] == 'P'){ // En Proceso
									echo '<a href="plataformaCotizaciones.php?CAM='.$row[CAM].'&RAM='.$row[RAM].'&accion=SeguimientoRAM"		><img src="../gastos/imagenes/klipper.png" 			width="40" height="40" title="Seguimiento">			</a>';
								}else{
									echo '<img src="../gastos/imagenes/klipper.png" width="40" height="40" title="Seguimiento" style="opacity:0;">';
								}
						echo '	</td>';
						echo '</tr>';
					}while ($row=mysql_fetch_array($bdEnc));
				}
				mysql_close($link);
					echo '<tr id="bAzul">';
					echo '	<td colspan=7 style="font-size: 18px; font-weight:700">';

								$sTotales = 0;
								$txt = 'Total RAM (Última UF '.number_format($ultUF, 2, ',', '.').') x ';
								if($tRAMsUF>0){
									$txt .= number_format($tRAMsUF, 2, ',', '.').' UF';
									$sTotales = $ultUF * $tRAMsUF;
									$txt .= ' = '.number_format($sTotales, 0, ',', '.');
								}
								echo $txt;
								
					echo '	</td>';
					echo '</tr>';
				echo '	</table>';
			}
			?>


<!-- 
****************************************************************************************************************
*
*             Nominas de Servicios Terminados
*
*
****************************************************************************************************************

-->
		<?php
		function sTerminados($filtroCli){
				global $ultUF;
				$filtro = '';
				if($usrFiltro){
					$filtro = " and usrCotizador Like '%".$usrFiltro."%'";
				}
				if($filtroCli){
					$filtro = " and RutCli Like '%".$filtroCli."%'";
				}
				$tAMsUF 	= 0;
				$tAMsPe 	= 0;
				$tAMsUFsinF = 0;
				$tAMsPesinF = 0;
				
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloCAM">';
				echo '		<tr>';
				echo '			<td  width="10%" align="center" height="40">AM					</td>';
				echo '			<td  width="10%">							Tipo Cot<br>Resp.	</td>';
				echo '			<td  width="32%">							Clientes			</td>';
				echo '			<td  width="14%">							Valor				</td>';
				echo '			<td  width="10%">							Fecha<br>Inicio		</td>';
				echo '			<td  width="10%">							Estado 				</td>';
				echo '			<td  width="14%" align="center">Seguimiento	</td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListadoCAM">';
				$n 		= 0;
				$link=Conectarse();
				
				//if($_SESSION[usr]=='Alfredo.Artigas' or $_SESSION[usr] == '10074437' or $_SESSION[IdPerfil] == 0){
				if($_SESSION[usr]=='Alfredo.Artigas' or $_SESSION[usr] == '10074437'){
					if($filtro){
						$sql = "SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'T' and Archivo != 'on' ".$filtro." Order By fechaTermino Asc";
						$bdEnc=mysql_query($sql);
						//$bdEnc=mysql_query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'T' and CAM Like '%".$dBuscar."%' Order By CAM Desc");
					}else{
						$bdEnc=mysql_query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'T' and Archivo != 'on' Order By fechaTermino Asc");
					}
				}else{
					if($dBuscar){
						$bdEnc=mysql_query("SELECT * FROM Cotizaciones Where usrResponzable = '".$_SESSION[usr]."' and RAM > 0 and Estado = 'T' and Archivo != 'on' and CAM Like '%".$dBuscar."%' Order By fechaTermino Asc");
					}else{
						$bdEnc=mysql_query("SELECT * FROM Cotizaciones Where usrResponzable = '".$_SESSION[usr]."' and RAM > 0 and Estado = 'T' and Archivo != 'on' Order By fechaTermino Asc");
					}
				}
				if ($row=mysql_fetch_array($bdEnc)){
					do{

						$tr = "bBlanca";
						if($row[Estado] == 'T'){ 
							$tr = "bBlanca";
						}
						if($row[informeUP] == 'on'){ 
							$tr = "bAmarilla";
							if($row[Facturacion] != 'on'){ 
								$tAMsUFsinF += $row[NetoUF];
								$tAMsPesinF += $row[Neto];
							}
						}
						if($row[Facturacion] == 'on'){ 
							$tr = "bVerde";
							$tAMsUF += $row[NetoUF];
							$tAMsPe += $row[Neto];
							
						}
						if($row[Archivo] == 'on'){ 
							$tr = "bAzul";
						}
						
						echo '<tr id="'.$tr.'">';
						echo '	<td width="10%" style="font-size:12px;">';
									echo 	'R'.$row[RAM].'<br>';
									echo 	'C'.$row[CAM];
									if($row[Cta]){
										echo '<br>CC';
									}
						echo '	</td>';
						echo '	<td width="10%" style="font-size:12px;">';
									if($row[oCompra]=='on'){
										echo 'OC';
									}
									if($row[oMail]=='on'){
										echo 'Mail';
									}
									if($row[oCtaCte]=='on'){
										echo 'Cta.Cte';
									}
									if($row[nOC]){
										echo '<br>'.$row[nOC];
									}
									echo '<br>'.$row[usrResponzable];
						echo '	</td>';
						echo '	<td width="32%" style="font-size:12px;">';
							$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$row[RutCli]."'");
							if($rowCli=mysql_fetch_array($bdCli)){
								echo 	$rowCli[Cliente];
							}
						echo '	</td>';
						echo '	<td width="14%">';
						echo '		<strong style="font-size:12px;">';
						echo 			number_format($row[NetoUF], 2, ',', '.').' UF';
						echo '		</strong>';
						echo ' 	</td>';
						echo '  <td width="10%">';
									$fd = explode('-', $row[fechaTermino]);
									echo $fd[2].'/'.$fd[1];
									//echo 'I'.$row[fechaInicio];
						echo '  <td>';
						echo '	<td width="10%">';
									$imgEstado = 'hourglass_clock_256.png';
									$msgEstado = 'Esperando Seguimiento';
									$fd[0] = 0;
									if($row[Estado] == 'T'){ // En Espera
										$imgEstado = 'hourglass_clock_256.png';
										$msgEstado = 'Esperando Seguimiento';
									}
									if($row[informeUP] == 'on'){ // Cerrada
										$imgEstado = 'informeUP.png';
										$msgEstado = 'Informe Subido';
										$fd = explode('-', $row[fechaInformeUP]);
									}
									if($row[Facturacion] == 'on'){ // Cerrada
										$imgEstado = 'crear_certificado.png';
										$msgEstado = 'Facturado';
										$fd = explode('-', $row[fechaFacturacion]);
									}
									if($row[Archivo] == 'on'){ // Cerrada
										$imgEstado = 'consulta.png';
										$msgEstado = 'Archivado';
										$fd = explode('-', $row[fechaArchivo]);
									}
									echo '<img src="../imagenes/'.$imgEstado.'"	width="40" height="40" title="'.$msgEstado.'">';
									if($fd[0]>0){
										echo '<br>'.$fd[2].'/'.$fd[1];
									}
						echo ' 	</td>';
						echo '	<td width="14%" align="center">';
								if($row[Estado] == 'T'){ // En Proceso
									echo '<a href="plataformaCotizaciones.php?CAM='.$row[CAM].'&RAM='.$row[RAM].'&accion=SeguimientoAM"		><img src="../gastos/imagenes/klipper.png" 			width="40" height="40" title="Seguimiento">			</a>';
								}else{
									echo '<img src="../gastos/imagenes/klipper.png" width="40" height="40" title="Seguimiento" style="opacity:0;">';
								}
						echo '	</td>';
						echo '</tr>';
					}while ($row=mysql_fetch_array($bdEnc));
				}
				mysql_close($link);
					echo '<tr id="bAzul">';
					echo '	<td colspan=6 style="font-size: 16px; font-weight:700">';
								echo 'Última UF de Referencia '.number_format($ultUF, 2, ',', '.');
/*
								$txt = '<br>Total Facturado ';
								$sTotales = 0;
								if($tAMsUF>0){
									$txt .= ' x '.number_format($tAMsUF, 2, ',', '.').' UF';
									$sTotales += $ultUF * $tAMsUF;
								}
								if($tAMsPe>0){
									$txt .= ' $ '.number_format($tAMsPe, 0, ',', '.');
									$sTotales += $tAMsPe;
								}
								$txt .= ' = $ '.number_format($sTotales, 0, ',', '.');
								echo $txt;
*/								
								
								$sTotales = 0;
								$txt = 'Total NO Facturado ';
								if($tAMsUFsinF>0){
									$txt .= number_format($tAMsUFsinF, 2, ',', '.').' UF';
									$sTotales += $ultUF * $tAMsUFsinF;
									echo '<br>'.$txt.' = $ '.number_format($sTotales, 0, ',', '.');
								}
								
								
					echo '	</td>';
					echo '</tr>';
				
				echo '	</table>';
			}
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