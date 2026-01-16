	<div>
		<div style="font-family:Arial; font-size:30px; color:#000; padding:15px; align:center;"> Informe Financiero de <?php echo $Cliente; ?></div>
		<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
			<tr>
				<td  width="08%" align="center"><strong>Fecha 			</strong></td>
				<td  width="08%" align="center"><strong>Factura			</strong></td>
				<td  width="10%" align="center"><strong>OC				</strong></td>
				<td  width="15%" align="center"><strong>Contacto		</strong></td>
				<td  width="15%" align="center"><strong>CAM				</strong></td>
				<td  width="15%" align="center"><strong>Informes		</strong></td>
				<td  width="12%" ><strong>Total							</strong></td>
				<td  width="07%" ><strong>Estado						</strong></td>
				<td  width="10%" ><strong>Saldo							</strong></td>
			</tr>
		</table>
		<table border="0" cellspacing="0" cellpadding="0" id="CajaListado">
			<?php
				$n 		= 0;
				$tBruto = 0;
				$link=Conectarse();
				/* Inicio Filtros */

				$m = intval($MesNum[$MesFiltro]);
				if($Agno != $AgnoAct){
					$filtroSQL = "Where Eliminado != 'on' and year(fechaSolicitud) <= $Agno and ";
				}else{
					$filtroSQL = "Where Eliminado != 'on' and year(fechaSolicitud) <= $AgnoAct and ";
				}
	
				$bdPer=$link->query("SELECT * FROM Clientes Where Cliente Like '%".$dBuscado."%' or RutCli = '".$dBuscado."'");
				if ($rowP=mysqli_fetch_array($bdPer)){
					$SQL = "SELECT * FROM SolFactura $filtroSQL RutCli = '".$rowP['RutCli']."' Order By fechaSolicitud Desc";
					$bdHon=$link->query($SQL);
				}
				
				//echo $SQL;
				$enTransito = 0;
				$Canceladas = 0;
				$enProceso	= 0;
				if ($row=mysqli_fetch_array($bdHon)){
					do{
						$fd = explode('-', $row['fechaSolicitud']);
						//if($MesFiltro == $Mes[intval($fd[1])]){
							$tr = "barraBlanca";
							if($row['Estado']=='I'){
								$tr = 'barraVerde';
							}
							if($row['Fotocopia']=='on' && $row['Factura'] == 'on'){
								$tr = 'barraAmarilla';
							}
							if($row['Fotocopia']=='on' && ($row['Factura'] == '' or $row['Factura'] == '0')){
								$tr = 'barraNaranjo';
							}
							if($row['pagoFactura']=='on'){
								$tr = 'barraPagada';
							}
							echo '	<tr id="'.$tr.'">';
							echo '			<td width="8%">';
												$fd = explode('-', $row['fechaFactura']);
												echo $fd[2].'-'.$fd[1].'-'.$fd[0];
							echo '			</td>';
							echo '			<td width="8%">';
												if($row['nFactura'] > 0){
													echo 'Fac.: '.$row['nFactura'];
													echo '<br>Sol.: '.$row['nSolicitud'];
												}else{
													echo 'Sol.: '.$row['nSolicitud'];
												}
							echo ' 			</td>';
							echo '			<td width="10%">';
												if($row['nOrden']){
													echo '<br>OC-'.$row['nOrden'];
												}
							echo ' 			</td>';
							echo '			<td width="15%" align="center">';
												echo $row['Contacto'];
							echo ' 			</td>';
							echo '			<td width="15%">';
												echo $row['informesAM'];
							echo '			</td>';
							echo '			<td width="15%">';
												echo $row['cotizacionesCAM'];
							echo '			</td>';
							echo '			<td width="12%" align="center">';
												if($row['Saldo'] == 0){
													if($row['Bruto'] > 0){
														echo number_format($row['Bruto'], 0, ',', '.');
													}else{
														echo $row['brutoUF'].' UF <br>';
													}
												}
							echo ' 			</td>';
							echo '			<td width="7%" align="center">';
												if($tr == 'barraPagada'){
												$Canceladas += $row['Bruto'];
													echo 'Cancelada';
												}
												if($tr == 'barraAmarilla'){
													$enProceso += $row['Bruto'];
													echo 'Vigente';
												}
												if($tr == 'barraVerde' or $tr == 'barraNaranjo'){
													$enTransito += $row['Bruto'];
													echo 'En Transito';
												}
							echo ' 			</td>';
							echo '			<td width="10%" align="center">';
												if($row['Saldo'] > 0){
													echo number_format($row['Saldo'], 0, ',', '.');
												}
							echo ' 			</td>';
							echo '		</tr>';
						//}
					}while ($row=mysqli_fetch_array($bdHon));
				}
				$link->close();
			?>
		</table>
		<div style="font-family:Arial; font-size:20px; color:#000; padding:15px; align:center;"> 
			Solicitudes Canceladas: 		<?php echo '$ '.number_format($Canceladas, 0, ',', '.'); ?>
			<br>Solicitudes en Proceso : 	<?php echo '$ '.number_format($enProceso, 0, ',', '.'); ?>
			<br>Solicitudes en Transito : 	<?php echo '$ '.number_format($enTransito, 0, ',', '.'); ?>
		</div>
	</div>
