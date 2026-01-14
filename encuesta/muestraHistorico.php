	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php
	include_once("conexion.php");

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

	//$MesHon 	= $Mm;
	$Proyecto 	= "Proyectos";
	//$MesFiltro  = "Mes";
	$Situacion 	= "Estado";
	$Agno     	= date('Y');
	
	if(isset($_GET['Proyecto']))  	{ $Proyecto  = $_GET['Proyecto']; 	}
	if(isset($_GET['MesFiltro'])) 	{ $MesFiltro = $_GET['MesFiltro']; 	}
	if(isset($_GET['Estado'])) 		{ $Situacion = $_GET['Estado']; 	}
	if(isset($_GET['Agno'])) 		{ $Agno 	 = $_GET['Agno']; 		}
	
	if(isset($_GET['dBuscar'])) 	{ $dBuscar  = $_GET['dBuscar']; 	}
	
				echo '<div>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td  width="05%" align="center" height="40"><strong>N°	</strong></td>';
				echo '			<td  width="10%" align="center"><strong>Fecha 			</strong></td>';
				echo '			<td  width="08%" align="center"><strong>Proyecto		</strong></td>';
				echo '			<td  width="15%" align="center"><strong>Cliente			</strong></td>';
				echo '			<td  width="10%" align="center"><strong>Fotocopia		</strong></td>';
				echo '			<td  width="10%" align="center"><strong>Factura			</strong></td>';
				echo '			<td  width="10%" align="center"><strong>Monto			</strong></td>';
				echo '			<td  width="10%" align="center"><strong>Acumulado		</strong></td>';
				echo '			<td  width="15%" ><strong>Estado 						</strong></td>';
				echo '			<td  width="06%" align="center" colspan="2"><strong>Acciones		</strong></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListado">';
				$n 		= 0;
				$tBruto = 0;
				$link=Conectarse();
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
				if($MesFiltro){
					$MesFiltro = intval($MesNum[ $MesFiltro ]);
					$filtroSQL = " month(fechaSolicitud) = '".$MesFiltro."'";
				}
				
				$MontoTotal = 0;
				$nSol		= 0;
				$Agno = date('Y');
				
				$bdRank=mysql_query("Delete From Rank");
				
				$bdHon=mysql_query("SELECT * FROM SolFactura Order By RutCli");
				if ($row=mysql_fetch_array($bdHon)){
					do{
						$RutCli = $row[RutCli];
						$bdRank=mysql_query("SELECT * FROM Rank Where RutCli = '".$RutCli."'");
						if($rowRank=mysql_fetch_array($bdRank)){
							$MontoTotal = $MontoTotal + $row[Bruto];
							$nSol++;
							
							$actSQL="UPDATE Rank SET ";
							$actSQL.="Ene			='".$nSol."',";
							$actSQL.="MontoTotal	='".$MontoTotal."'";
							$actSQL.="WHERE RutCli	= '".$RutCli."'";
							$bdRank=mysql_query($actSQL);
						}else{
							$nSol = 1;
							$MontoTotal = 0;
							$MontoTotal = $row[Bruto];
							mysql_query("insert into Rank(	RutCli,
															Agno,
															Ene,
															MontoTotal
														) 
												values 	(	'$RutCli',
															'$Agno',
															'$nSol',
															'$MontoTotal'
														)",$link);
						}
					}while ($row=mysql_fetch_array($bdHon));
				}
				$filtroCliente = '1';
				if($dBuscar){
					$bdPer=mysql_query("SELECT * FROM Clientes Where Cliente Like '%".$dBuscar."%' || RutCli = '".$dBuscar."'");
					//$bdPer=mysql_query("SELECT * FROM Clientes Where Cliente = '".$dBuscar."'");
					if ($rowP=mysql_fetch_array($bdPer)){
						$RutCli 		= $rowP['RutCli'];
						$filtroCliente 	= 'RutCli = "'.$RutCli.'"';
					}
					$bdHon=mysql_query("SELECT * FROM SolFactura Where RutCli = '".$RutCli."'");
					$dBuscado = '';
				}else{
					$bdHon=mysql_query("SELECT * FROM SolFactura");
					$dBuscado = '';
				}
				$bdRank=mysql_query("SELECT * FROM Rank Where ".$filtroCliente." Order By MontoTotal Desc");
				if ($rowRank=mysql_fetch_array($bdRank)){
					do{
						$sAcumulado = 0;
						if($filtroSQL){
							$filtroSQL = $filtroSQL;
						}else{
							$filtroSQL = '1';
						}
						$bdHon=mysql_query("SELECT * FROM SolFactura Where $filtroSQL && RutCli = '".$rowRank[RutCli]."'");
						if ($row=mysql_fetch_array($bdHon)){
							do{
								$fd = explode('-', $row['fechaSolicitud']);
								//if($MesFiltro == $Mes[intval($fd[1])]){
									$tr = "barraBlanca";
									if($row['Estado']=='I'){
										$tr = 'barraVerde';
									}
									if($row['Fotocopia']=='on'){
										$tr = 'barraNaranjo';
									}
									if($row['pagoFactura']=='on'){
										$tr = 'barraPagada';
									}
									echo '	<tr id="'.$tr.'">';
									echo '			<td width="05%" style="font-size:16px;">'.$row['nSolicitud'].'</td>';
									echo '			<td width="10%">';
														$fd = explode('-', $row['fechaSolicitud']);
														echo $fd[2].'-'.$fd[1].'-'.$fd[0].'<br>';						echo '			</td>';
									echo '			<td width="08%">'.$row['IdProyecto'].'</td>';
									echo '			<td width="15%">';
														$bdPer=mysql_query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
														if ($rowP=mysql_fetch_array($bdPer)){
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
															if($row['Neto']>0){
																echo $row['brutoUF'].' UF <br>';
																echo number_format($row['Bruto'], 0, ',', '.');
															}else{
																echo $row['brutoUF'].' UF';
															}
														}else{
															echo number_format($row['Bruto'], 0, ',', '.');
														}
														$tBruto 	+= $row['Bruto'];
														$sAcumulado += $row['Bruto'];
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
									echo '			<td width="6%"><a href="formSolicitaFactura.php?Proceso=2&RutCli='.$row['RutCli'].'&nSolicitud='.$row['nSolicitud'].'"><img src="../gastos/imagenes/corel_draw_128.png"   	width="32" height="32" title="Editar Solicitud de Factura">	</a></td>';
									echo '		</tr>';
								//}
							}while ($row=mysql_fetch_array($bdHon));
							
							echo '<tr id="barraBlanca">';
							echo '	<td colspan=6 width="58%" >';
										$bdPer=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowRank['RutCli']."'");
										if ($rowP=mysql_fetch_array($bdPer)){
											echo '<strong> TOTAL '.$rowP['Cliente'].'</strong>';
										}
							
							echo '	</td>';
							echo '	<td width="10%">';
										echo '<strong>'.number_format($sAcumulado, 0, ',', '.').'<strong>';
							echo ' 	</td>';
							echo '	<td width="10%">&nbsp;</td>';
							echo '	<td width="15%">&nbsp;</td>';
							echo '	<td width="06%">&nbsp;</td>';
							echo '</tr>';

							
						}
					}while ($rowRank=mysql_fetch_array($bdRank));
				}
				mysql_close($link);
				echo '	</table>';
				if($tBruto){
					echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaFinal">';
					echo '		<tr>';
					echo '			<td width="05%">&nbsp;</td>';
					echo '			<td width="10%">&nbsp;</td>';
					echo '			<td width="08%">&nbsp;</td>';
					echo '			<td width="15%">&nbsp;</td>';
					echo '			<td width="10%">&nbsp;</td>';
					echo '			<td width="05%" align="right">Total</td>';
					echo '			<td width="10%" align="right" style="font-size: 14px;">'.number_format($tBruto , 0, ',', '.').'</td>';
					echo '			<td width="15%" align="right">&nbsp;</td>';
					echo '			<td width="17%">&nbsp;</td>';
					echo '		</tr>';
					echo '	</table>';
				}
				echo '</div>';
			?>
		</div>
		