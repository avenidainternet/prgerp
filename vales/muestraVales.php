			<div id="accordion">
				<?php
					$mes 	= 0;
					$c 		= 0;
					$totalV = 0;
					$fechaHoy = date('Y-m-d');
					$fa = explode('-',$fechaHoy);
					$tMes = array(0,0,0,0,0,0,0,0,0,0,0,0,0);
					$tMesA = array(0,0,0,0,0,0,0,0,0,0,0,0,0);
					$filtro = " year(fechaVale) = '".$fa[0]."'";
					if($_SESSION['usr'] != 'Alfredo.Artigas'){
						$filtro .= " and usrResponsable != 'Alfredo.Artigas' ";
					}
					$link=Conectarse();
					$bdGto=mysql_query("SELECT * FROM vales Where $filtro Order By fechaVale Desc");
					if ($row=mysql_fetch_array($bdGto)){
						do{
							$fd 	= explode('-', $row['fechaVale']);
							$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
							$tMesA[intval($fd[1])] += $row['Ingreso'];
						}while ($row=mysql_fetch_array($bdGto));
					}
					
					$bdGto=mysql_query("SELECT * FROM vales Where $filtro Order By fechaVale Desc");
					if ($row=mysql_fetch_array($bdGto)){
						do{
							$totalV += $row['Ingreso'];
							$tr = "bVerdeSel";
							if($row['usrResponsable'] == 'Alfredo.Artigas'){
								$tr = "bNegraSel";
							}
							$fd 	= explode('-', $row['fechaVale']);
							$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
							$totalM += $row['Ingreso'];
							$tMes[intval($fd[1])] += $row['Ingreso'];
							if($fd[1] != $mes){
								if($c >= 1){
									?>
											<tr height="50">
												<td colspan="4" align="right">Total Mes</td>
												<td width="10%" style="text-align:center;">
													<?php echo number_format($tMes[intval($mes)], 0, ',', '.'); ?>
												</td>
												<td colspan="3">&nbsp;</td>
											</tr>
										</table>
									</div>
									<?php
								}
								$c++;
								$mes = $fd[1];
								?>
								<h3 style="font-size:14px;"><?php echo $Mes[intval($fd[1])]. '<span style="float:right;"> $ '.number_format($tMesA[intval($mes)], 0, ',', '.').'</span>'; ?></h3>
								<?php 
									$totalM	= 0; 
									$totalM += $row['Ingreso'];
								?>
								<div id="infoCotizacion">
									<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloSel">
										<tr class="CabTit">
											<td  width="05%"><strong>N°						</strong></td>
											<td  width="10%"><strong>Fecha 					</strong></td>
											<td  width="40%"><strong>Descripción			</strong></td>
											<td  width="10%"><strong>Resp.<br>Registro		</strong></td>
											<td  width="10%"><strong>Total					</strong></td>
											<td colspan="3"  width="15%" align="center">	<strong>Procesos</strong></td>
										</tr>
										<tr class="<?php echo $tr; ?>">
											<td width=" 5%" style="text-align:right;"><?php echo $row['nVale']; ?>									</td>
											<td width="10%" style="text-align:center;"><?php echo $Fecha; ?>										</td>
											<td width="40%"><?php echo $row['Descripcion']; ?>														</td>
											<td width="10%" style="text-align:center;"><?php echo $row['usrResponsable']; ?>						</td>
											<td width="10%" style="text-align:center;"><?php echo number_format($row['Ingreso'], 0, ',', '.');?>	</td>
											<td width=" 5%"><a href="newVale.php?nVale=<?php echo $row['nVale']; ?>&accion=Seguimiento">	<img src="../gastos/imagenes/klipper.png" 			width="32" height="32" title="Seguimiento">	</a></td>
											<td width=" 5%"><a href="newVale.php?nVale=<?php echo $row['nVale']; ?>&accion=Actualizar">		<img src="../gastos/imagenes/corel_draw_128.png" 	width="32" height="32" title="Editar">		</a></td>
											<td width=" 5%"><a href="newVale.php?nVale=<?php echo $row['nVale']; ?>&accion=Borrar">			<img src="../gastos/imagenes/inspektion.png" 		width="32" height="32" title="Borrar">		</a></td>
										</tr>
								<?php
							}else{
										?>
										<tr class="<?php echo $tr; ?>">
											<td width=" 5%" style="text-align:right;"><?php echo $row['nVale']; ?>							</td>
											<td width="10%" style="text-align:center;"><?php echo $Fecha; ?>									</td>
											<td width="40%"><?php echo $row['Descripcion']; ?>														</td>
											<td width="10%" style="text-align:center;"><?php echo $row['usrResponsable']; ?>					</td>
											<td width="10%" style="text-align:center;"><?php echo number_format($row['Ingreso'], 0, ',', '.');?>	</td>
											<td width=" 5%"><a href="newVale.php?nVale=<?php echo $row['nVale']; ?>&accion=Seguimiento">	<img src="../gastos/imagenes/klipper.png" 			width="32" height="32" title="Seguimiento">	</a></td>
											<td width=" 5%"><a href="newVale.php?nVale=<?php echo $row['nVale']; ?>&accion=Actualizar">		<img src="../gastos/imagenes/corel_draw_128.png" 	width="32" height="32" title="Editar">		</a></td>
											<td width=" 5%"><a href="newVale.php?nVale=<?php echo $row['nVale']; ?>&accion=Borrar">			<img src="../gastos/imagenes/inspektion.png" 		width="32" height="32" title="Borrar">		</a></td>
										</tr>
								<?php
							}
						}while ($row=mysql_fetch_array($bdGto));
					}
					mysql_close($link);
				?>
											<tr height="50">
												<td colspan="4" align="right">Total Mes</td>
												<td width="10%" style="text-align:center;">
													<?php echo number_format($tMes[intval($mes)], 0, ',', '.'); ?>
												</td>
												<td colspan="3">&nbsp;</td>
											</tr>
									</table>
								</div>
			</div>
			<div>
				Total <?php echo number_format($totalV, 0, ',', '.'); ?>
			</div>