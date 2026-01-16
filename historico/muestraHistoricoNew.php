<?php
	header('Content-Type: text/html; charset=utf-8');
	include_once("../conexionli.php");
	$MesFiltro 	= date('m');
	$dBuscar 	= '';
	$filtroSQL 	= '';
	$Clientes 	= '';
	$Estado		= '';
	
	$Estado = array(
					1 => 'Estado', 
					2 => 'Fotocopia',
					3 => 'Factura',
					4 => 'Canceladas'
				);

	$Mes = array(
					1 => 'Enero', 
					2 => 'Febrero',
					3 => 'Marzo',
					4 => 'Abril',
					5 => 'Mayo',
					6 => 'Junio',
					7 => 'Julio',
					8 => 'Agosto',
					9 => 'Septiembre',
					10 => 'Octubre',
					11 => 'Noviembre',
					12 => 'Diciembre'
				);
				
	$MesNum = array(	
					'Enero' 		=> '01', 
					'Febrero' 		=> '02',
					'Marzo' 		=> '03',
					'Abril' 		=> '04',
					'Mayo' 			=> '05',
					'Junio' 		=> '06',
					'Julio' 		=> '07',
					'Agosto' 		=> '08',
					'Septiembre'	=> '09',
					'Octubre' 		=> '10',
					'Noviembre' 	=> '11',
					'Diciembre'		=> '12'
				);

	$fd 	= explode('-', date('Y-m-d'));
	if(isset($_GET['Mm'])) { 
		$Mm 			= $_GET['Mm']; 
		$PeriodoPago 	= $MesNum[$Mm].".".$fd[0];
	}else{
		$Mm 			= $Mes[ intval($fd[1]) ];
		$PeriodoPago 	= $fd[1].".".$fd[0];
	}

	$pPago = $Mm.'.'.$fd[0];

	$Proyecto 	= "Proyectos";
	$Situacion 	= "Estado";
	$Agno     	= date('Y');

	$Estado		= '';
	$Factura	= '';
	$Canceladas	= '';
	
	if(isset($_GET['Proyecto']))  	{ $Proyecto  = $_GET['Proyecto']; 	}
	if(isset($_GET['MesFiltro'])) 	{ $MesFiltro = $_GET['MesFiltro']; 	}
	if(isset($_GET['Estado'])) 		{ $Situacion = $_GET['Estado']; 	}
	if(isset($_GET['Agno'])) 		{ $Agno 	 = $_GET['Agno']; 		}
	if(isset($_GET['AgnoHasta']))	{ $AgnoHasta = $_GET['AgnoHasta']; 	}
	if(isset($_GET['RutCli'])) 		{ $RutCli 	 = $_GET['RutCli']; 	}
	
	if(isset($_GET['dBuscar'])) 	{ $dBuscar  = $_GET['dBuscar']; 	}
	
				echo '<div>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td  width="05%" align="center" height="40"><strong>N°  </strong></td>';
				echo '			<td  width="10%" align="center"><strong>Fecha 			</strong></td>';
				echo '			<td  width="08%" align="center"><strong>Proyecto		</strong></td>';
				echo '			<td  width="15%" align="center"><strong>Cliente			</strong></td>';
				echo '			<td  width="10%" align="center"><strong>Fotocopia		</strong></td>';
				echo '			<td  width="10%" align="center"><strong>Factura			</strong></td>';
				echo '			<td  width="10%" align="center"><strong>Monto			</strong></td>';
				echo '			<td  width="10%" align="center"><strong>Acumulado		</strong></td>';
				echo '			<td  width="15%" ><strong>Estado 						</strong></td>';
				echo '			<td  width="15%" >&nbsp;</td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListado">';
				$n 		= 0;
				$tBruto = 0;
				$tDeuda	= 0; 
				if($Proyecto <> 'Proyectos'){
					$filtroSQL = " IdProyecto = '".$Proyecto."'";
				}
				if($Situacion <> 'Estado'){
					if($Situacion == 'Canceladas'){
						$filtroSQL = ' pagoFactura = "on"';
					}
					if($Situacion == 'Factura'){
						$filtroSQL = ' Factura = "on" && pagoFactura <> "on"';
					}
					if($Situacion == 'Fotocopia'){
						$filtroSQL = ' Fotocopia = "on" && pagoFactura <> "on"';
					}
					if($Situacion == 'Estado'){
						$filtroSQL = '';
					}
				}
				//echo $MesFiltro;
				if($MesFiltro){
					//$MesFiltro = intval($MesNum[ $MesFiltro ]);
					$MesFiltro = $MesFiltro;
					$filtroSQL = " month(fechaSolicitud) = '".$MesFiltro."'";
				}
				
				$MontoTotal = 0;
				$nSol		= 0;
				$vtasUltimos12m = 0;

				if($Agno == ''){
					$Agno     	= date('Y');
				}

				$fechaHoy = date('Y-m-d');
				//$fechaHoy = '2018-01-31';
				$fechaDesde 	= strtotime ( '-365 day' , strtotime ( $fechaHoy ) );
				$fechaDesde 	= date ( 'Y-m-d' , $fechaDesde );

				$fechaHasta 	= strtotime ( '-30 day' , strtotime ( $fechaHoy ) );
				$fechaHasta 	= date ( 'Y-m-d' , $fechaHasta );
				$fechaHasta 	= $fechaHoy;

				$fe = explode('-', $fechaHoy);
				$PeriodoEstrella = $fe[1].'-'.$fe[0];
				
				$link=Conectarse();
				$bdRank=$link->query("Delete From Rank");
/* Copia a la pantallaINFOTV desde Aqui */				
				$calcularEstrella = 'Si';
				$bdEs=$link->query("SELECT * FROM ClientesEstrellas Where Periodo = '".$PeriodoEstrella."'");
				if($rowEs=mysqli_fetch_array($bdEs)){
					$calcularEstrella = 'No';
				}
				if($calcularEstrella == 'Si'){
					$vtasUltimos12m = 0;
					$Clasificacion  = '';
					$actSQL="UPDATE Clientes SET ";
					$actSQL.="vtasUltimos12m	='".$vtasUltimos12m."',";
					$actSQL.="Clasificacion		='".$Clasificacion.	"'";
					//$actSQL.="WHERE RutCli	= '".$RutCli."'";
					$bdRank=$link->query($actSQL);
				}

				$bdHon=$link->query("SELECT * FROM SolFactura Where Eliminado != 'on' and year(fechaSolicitud) >= '".$Agno."' and year(fechaSolicitud) <= '".$AgnoHasta."' Order By RutCli");
				if ($row=mysqli_fetch_array($bdHon)){
					do{
						$RutCli = $row['RutCli'];

						//$bdRank=$link->query("SELECT * FROM Rank Where Agno = '".$Agno."' and RutCli = '".$RutCli."'");
						$bdRank=$link->query("SELECT * FROM Rank Where RutCli = '".$RutCli."'");
						if($rowRank=mysqli_fetch_array($bdRank)){
							$MontoTotal = $MontoTotal + $row['Bruto'];
							$nSol++;
							
							$actSQL="UPDATE Rank SET ";
							$actSQL.="Ene			='".$nSol."',";
							$actSQL.="MontoTotal	='".$MontoTotal."'";
							$actSQL.="WHERE RutCli	= '".$RutCli."'";
							$bdRank=$link->query($actSQL);
							
							if($calcularEstrella == 'Si'){
								if($row['fechaSolicitud'] >= $fechaDesde and $row['fechaSolicitud'] <= $fechaHasta){
									$SQLcl = "SELECT * FROM Clientes Where RutCli = '".$RutCli."'";
									//echo $fechaDesde.' - '.$row['fechaSolicitud'].' - '.$fechaHasta.'<br>';
									//echo $SQLcl.'<br>';
									$bdCl=$link->query($SQLcl);
									if ($rowCl=mysqli_fetch_array($bdCl)){
										
										if($rowCl['vtasUltimos12m'] > 0){
											$vtasUltimos12m = $rowCl['vtasUltimos12m'];
										}
										$vtasUltimos12m = $vtasUltimos12m + $row['Neto'];
										$Clasificacion = '';
										$bdCla=$link->query("SELECT * FROM tablaRangoEstrellas Order By Clasificacion");
										if($rowCla=mysqli_fetch_array($bdCla)){
											do{
												if($rowCla['Clasificacion'] == 1){
													if($vtasUltimos12m >= $rowCla['desde']){
														$Clasificacion = $rowCla['Clasificacion'];
													}
												}else{
													if($vtasUltimos12m >= $rowCla['desde'] and $vtasUltimos12m <= $rowCla['hasta']){
														$Clasificacion = $rowCla['Clasificacion'];
													}
												}
											}while ($rowCla=mysqli_fetch_array($bdCla));
										}
										$vtasHis = $vtasUltimos12m;
										$actSQL="UPDATE Clientes SET ";
										$actSQL.="vtasUltimos12m	='".$vtasUltimos12m."',";
										$actSQL.="Clasificacion		='".$Clasificacion."'";
										$actSQL.="WHERE RutCli	= '".$RutCli."'";
										$bdRank=$link->query($actSQL);
										
										$bdClEs=$link->query("SELECT * FROM ClientesEstrellas Where RutCli = '".$RutCli."' and Periodo = '".$PeriodoEstrella."'");
										if ($rowClEs=mysqli_fetch_array($bdClEs)){
											$actSQL="UPDATE ClientesEstrellas SET ";
											$actSQL.="vtasUltimos12m	='".$vtasHis.		"',";
											$actSQL.="Clasificacion		='".$Clasificacion.	"'";
											$actSQL.="WHERE RutCli		= '".$RutCli."' and Periodo = '".$PeriodoEstrella."'";
											$bdRank=$link->query($actSQL);
										}else{
											$link->query("insert into ClientesEstrellas(	RutCli,
																							Periodo,
																							vtasUltimos12m
																						) 
																				values 	(	'$RutCli',
																							'$PeriodoEstrella',
																							'$vtasHis'
																						)");
										}
										
									}
								}
							}
/* Copia a la pantallaINFOTV hasta Aqui */				
							
						}else{
							$nSol = 1;
							$MontoTotal = 0;
							$MontoTotal = $row['Bruto'];
							$link->query("insert into Rank(	RutCli,
															Agno,
															AgnoHasta,
															Ene,
															MontoTotal
														) 
												values 	(	'$RutCli',
															'$Agno',
															'$AgnoHasta',
															'$nSol',
															'$MontoTotal'
														)");

							if($row['fechaSolicitud'] >= $fechaDesde and $row['fechaSolicitud'] <= $fechaHasta){
								$bdCl=$link->query("SELECT * FROM Clientes Where RutCli = '".$RutCli."'");
								if ($rowCl=mysqli_fetch_array($bdCl)){
									$vtasUltimos12m = $row['Neto'];
									$actSQL="UPDATE Clientes SET ";
									$actSQL.="vtasUltimos12m	='".$vtasUltimos12m."'";
									$actSQL.="WHERE RutCli	= '".$RutCli."'";
									$bdRank=$link->query($actSQL);
								}
							}else{
								//echo $row['Neto'];
							}
														
														
						}
					}while ($row=mysqli_fetch_array($bdHon));
				}
				$link->close();
				
				$link=Conectarse();
				$filtroCliente = '1';
				if($dBuscar){
					$bdPer=$link->query("SELECT * FROM Clientes Where Cliente Like '%".$dBuscar."%' || RutCli = '".$dBuscar."'");
					//$bdPer=$link->query("SELECT * FROM Clientes Where Cliente = '".$dBuscar."'");
					if ($rowP=mysqli_fetch_array($bdPer)){
						$RutCli 		= $rowP['RutCli'];
						$filtroCliente 	= 'RutCli = "'.$RutCli.'"';
					}
					$bdHon=$link->query("SELECT * FROM SolFactura Where year(fechaSolicitud) = '".$Agno."' and RutCli = '".$RutCli."'");
					$dBuscado = '';
				}else{
					$bdHon=$link->query("SELECT * FROM SolFactura Where year(fechaSolicitud) = '".$Agno."'");
					$dBuscado = '';
				}
				$bdRank=$link->query("SELECT * FROM Rank Where Agno = '".$Agno."' and ".$filtroCliente." Order By MontoTotal Desc");
				if ($rowRank=mysqli_fetch_array($bdRank)){
					do{
						$sAcumulado = 0;
						$porCobrar	= 0;
						if($filtroSQL){
							$filtroSQL = $filtroSQL;
						}else{
							$filtroSQL = '1';
						}
						$trTot 	= "barraSubTotales";
						//$bdHon=$link->query("SELECT * FROM SolFactura Where year(fechaSolicitud) = '".$Agno."' and $filtroSQL && RutCli = '".$rowRank['RutCli']."'");
						$bdHon=$link->query("SELECT * FROM SolFactura Where year(fechaSolicitud) = '".$Agno."' and $filtroSQL && RutCli = '".$rowRank['RutCli']."'");
						if ($row=mysqli_fetch_array($bdHon)){
							do{
								$fd = explode('-', $row['fechaSolicitud']);
								//if($MesFiltro == $Mes[intval($fd[1])]){
									$tr 	= "barraVerde";
									if($row['Estado']=='I'){
										$tr = 'barraVerde';
									}
									if($row['Fotocopia']=='on'){
										$tr = 'barraNaranjo';
									}
									if($row['pagoFactura']=='on'){
										$tr = 'barraPagada';
									}
									if(isset($_GET['RutCli'])){
										if($_GET['RutCli'] == $rowRank['RutCli']){
											$trTot = 'barraTotales';
											echo '	<tr id="'.$tr.'">';
											echo '			<td width="05%" style="font-size:16px;">'.$row['nSolicitud'].'</td>';
											echo '			<td width="10%">';
																$fd = explode('-', $row['fechaSolicitud']);
																echo $fd[2].'-'.$fd[1].'-'.$fd[0].'<br>';						echo '			</td>';
											echo '			<td width="08%">'.$row['IdProyecto'].'</td>';
											echo '			<td width="15%">';
																$bdPer=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
																if ($rowP=mysqli_fetch_array($bdPer)){
																	echo '<strong>'.$rowP['Cliente'].'</strong>';
																}
											echo '			</td>';
											echo '			<td width="10%" align="center">';
																if($row['Fotocopia'] == 'on'){
																	$fd = explode('-', $row['fechaFotocopia']);
																	echo '<img src="../gastos/imagenes/Confirmation_32.png" width="14" height="14">';
																	echo $fd[2].'-'.$fd[1].'-'.$fd[0];
																}
											echo ' 			</td>';
											echo '			<td width="10%" align="center">';
																if($row['Factura'] == 'on'){
																	$fd = explode('-', $row['fechaFactura']);
																	echo '<img src="../gastos/imagenes/Confirmation_32.png" width="14" height="14">';
																	echo $fd[2].'-'.$fd[1].'-'.$fd[0].'<br>';
																	echo 'N° '.$row['nFactura'];
																}
											echo ' 			</td>';
											echo '			<td width="10%" align="center">';
																if($row['tipoValor']=='U'){
																	if($row['Bruto']>0){
																		echo $row['brutoUF'].' UF <br>';
																		echo number_format($row['Bruto'], 0, ',', '.');
																	}else{
																		echo $row['brutoUF'].' UF';
																	}
																}else{
																	echo number_format($row['Bruto'], 0, ',', '.');
																}
		
		
											echo ' 			</td>';
											echo '			<td width="10%" align="center">';
																echo '<strong>'.number_format($sAcumulado, 0, ',', '.').'<strong>';
											echo ' 			</td>';
											echo '			<td width="15%">';
																if($row['pagoFactura'] == 'on'){
																	$fd = explode('-', $row['fechaPago']);
																	echo '<img src="../gastos/imagenes/Confirmation_32.png" width="16" height="16">';
																	echo $fd[2].'-'.$fd[1].'-'.$fd[0].'<br>';
																}
											echo '			</td>';
											echo '			<td width="6%">&nbsp;</td>';
											echo '		</tr>';
										}
									}
									if($row['pagoFactura']!='on'){
										$porCobrar 	+= $row['Bruto'];
										$tDeuda 	+= $row['Bruto'];
									}

									$tBruto 	+= $row['Bruto'];
									$sAcumulado += $row['Bruto'];

							}while ($row=mysqli_fetch_array($bdHon));
							
							echo '<tr id="'.$trTot.'">';
							echo '	<td colspan=6 width="58%" >';
										$bdPer=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowRank['RutCli']."'");
										if ($rowP=mysqli_fetch_array($bdPer)){
											if($trTot == 'barraSubTotales'){
												echo $rowP['Cliente'];
											}else{
												echo '<strong><span style="font-size:20px">'.$rowP['Cliente'].'</span></strong>';
											}
										}
							echo '	</td>';
							echo '	<td width="10%" colspan="2">';
										if($trTot == 'barraSubTotales'){
											echo number_format($sAcumulado, 0, ',', '.');
											if($porCobrar){
												echo '<br>';
												echo '<span style="color:#FFFF00;font-size:20px; font-weight:700;">'.number_format($porCobrar, 0, ',', '.').'</span>';
											}
										}else{
											echo '<strong><span style="font-size:22px">'.number_format($sAcumulado, 0, ',', '.').'</span><strong>';
											if($porCobrar){
												echo '<br>';
												echo '<span style="color:#FFFF00;font-size:20px; font-weight:700;">'.number_format($porCobrar, 0, ',', '.').'</span>';
											}
										}
										$bdCl=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowRank['RutCli']."'");
										if ($rowCl=mysqli_fetch_array($bdCl)){
											if($rowCl['vtasUltimos12m'] > 0){
												echo '<br>Últ. 12 meses <br>'.number_format($rowCl['vtasUltimos12m'], 0, ',', '.');
												if($rowCl['Clasificacion'] == 1){
													echo '<br><img src="../imagenes/estrella.png" width=20>';
													echo '<img src="../imagenes/estrella.png" width=20>';
													echo '<img src="../imagenes/estrella.png" width=20>';
												}else{	
													if($rowCl['Clasificacion'] == 2){
														echo '<br><img src="../imagenes/estrella.png" width=20>';
														echo '<img src="../imagenes/estrella.png" width=20>';
													}else{
														if($rowCl['Clasificacion'] == 3){
															echo '<br><img src="../imagenes/estrella.png" width=20>';
														}
													}
												}
											}
										}
										
							echo ' 	</td>';
							echo '	<td width="10%">';
										if($trTot == 'barraSubTotales'){
											echo '<a href="plataformaHistorica.php?RutCli='.$rowRank['RutCli'].'&Agno='.$Agno.'"><img src="../imagenes/consulta.png" 			width="50" height="50" title="Ver Facturas"></a>';
										}else{
											echo '&nbsp;';
										}
							echo '	</td>';
							echo '	<td width="10%">N° Fact. '.$rowRank['Ene'].'</td>';

							echo '</tr>';
							
						}
					}while ($rowRank=mysqli_fetch_array($bdRank));
				}
				$link->close();
				echo '	</table>';
				if($tBruto){
					echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaFinal">';
					echo '		<tr>';
					echo '			<td width="05%">&nbsp;</td>';
					echo '			<td width="10%">&nbsp;</td>';
					echo '			<td width="08%">&nbsp;</td>';
					echo '			<td width="15%">&nbsp;</td>';
					echo '			<td width="10%">&nbsp;</td>';
					echo '			<td width="12%" align="right"><span style="color:#000;font-size:18px; font-weight:700;">Total $<br>Por Cobrar $</span></td>';
					echo '			<td width="10%" align="right" style="font-size: 14px;">';
					echo '<span style="color:#000;font-size:18px; font-weight:700;">'.number_format($tBruto, 0, ',', '.').'</span>';
					if($tDeuda){
						echo 			'<br>';
						echo '<span style="color:Red;font-size:18px; font-weight:700;">'.number_format($tDeuda, 0, ',', '.').'</span>';
					}
					
					echo 			'</td>';
					echo '			<td width="15%" align="right">&nbsp;</td>';
					echo '			<td width="17%">&nbsp;</td>';
					echo '		</tr>';
					echo '	</table>';
				}
				echo '</div>';
			?>
		</div>
		