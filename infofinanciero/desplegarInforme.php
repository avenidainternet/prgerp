	<div>
		<div style="font-family:Arial; font-size:30px; color:#000; padding:15px; align:center;"> Informe Financiero de <?php echo $Cliente; ?></div>
		<table class="table table-dark table-hover">
			<thead>
				<tr>
					<th>Fecha 			</th>
					<th>Factura			</th>
					<th>OC				</th>
					<th>Contacto		</th>
					<th>CAM				</th>
					<th>Informes		</th>
					<th>Total			</th>
					<th>Estado			</th>
					<th>Saldo			</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$n 		= 0;
				$tBruto = 0;
				$link=Conectarse();

				$m = intval($MesNum[$MesFiltro]);
				if($Agno != $AgnoAct){
					$filtroSQL = "Where Eliminado != 'on' and year(fechaSolicitud) <= $Agno and ";
				}else{
					$filtroSQL = "Where Eliminado != 'on' and year(fechaSolicitud) <= $AgnoAct and ";
				}
				$enTransito = 0;
				$Canceladas = 0;
				$enProceso	= 0;
	
				$bdPer=$link->query("SELECT * FROM Clientes Where Cliente Like '%".$dBuscado."%' or RutCli = '".$dBuscado."'");
				if ($rowP=mysqli_fetch_array($bdPer)){
					$SQL = "SELECT * FROM SolFactura $filtroSQL RutCli = '".$rowP['RutCli']."' Order By fechaSolicitud Desc";
					$bdHon=$link->query($SQL);
				}
				
				while ($row=mysqli_fetch_array($bdHon)){
					$RutCli = $rowP['RutCli'];
					$fd = explode('-', $row['fechaSolicitud']);
					$tr = "bg-light text-dark";
					if($row['Estado']=='I'){
						$tr = 'bg-success text-white';
					}
					if($row['Fotocopia']=='on' && $row['Factura'] == 'on'){
						$tr = 'bg-warning text-white';
					}
					if($row['Fotocopia']=='on' && ($row['Factura'] == '' or $row['Factura'] == '0')){
						$tr = 'bg-danger text-white';
					}
					if($row['pagoFactura']=='on'){
						$tr = 'bg-primary text-white';
					}?>
					<tr class=<?php echo $tr; ?>>
						<td>
							<?php
								$fd = explode('-', $row['fechaFactura']);
								echo $fd[2].'-'.$fd[1].'-'.$fd[0];
							?>
						</td>
						<td>
							<?php
								if($row['nFactura'] > 0){
									echo 'Fac.: '.$row['nFactura'];
									echo '<br>Sol.: '.$row['nSolicitud'];
								}else{
									echo 'Sol.: '.$row['nSolicitud'];
								}
							?>
						</td>
						<td>
							<?php
								if($row['nOrden']){
									echo '<br>OC-'.$row['nOrden'];
								}
							?>
						</td>
						<td>
							<?php
								echo $row['Contacto'];
							?>
						</td>
						<td>
							<?php
								echo $row['informesAM'];
							?>
						</td>
						<td>
							<?php
								echo $row['cotizacionesCAM'];
							?>
						</td>
						<td>
							<?php
								if($row['Saldo'] == 0){
									if($row['Bruto'] > 0){
										echo number_format($row['Bruto'], 0, ',', '.');
									}else{
										echo $row['brutoUF'].' UF <br>';
									}
								}
							?>
						</td>
						<td>
							<?php
								if($tr == 'bg-primary text-white'){
									$Canceladas += $row['Bruto'];
									echo 'Cancelada';
								}
								if($tr == 'bg-warning text-white'){
									$enProceso += $row['Bruto'];
									echo 'Vigente';
								}
								if($tr == 'bg-success text-white' or $tr == 'bg-danger text-white'){
									$enTransito += $row['Bruto'];
									echo 'En Transito';
								}
							?>
						</td>
						<td>
							<?php
								if($row['Saldo'] > 0){
									echo number_format($row['Saldo'], 0, ',', '.');
								}
							?>
						</td>
					</tr>
					<?php
				}
				$link->close();
			?>
			</tbody>
		</table>
		<div style="font-family:Arial; font-size:20px; color:#000; padding:15px; align:center;"> 
			Solicitudes Canceladas: 		<?php echo '$ '.number_format($Canceladas, 0, ',', '.'); ?>
			<br>Solicitudes en Proceso : 	<?php echo '$ '.number_format($enProceso, 0, ',', '.'); ?>
			<br>Solicitudes en Transito : 	<?php echo '$ '.number_format($enTransito, 0, ',', '.'); ?>
		</div>
	</div>
<table class="table table-dark table-hover">
	<thead>
		<tr>
			<th>AM 			</th>
			<th>Resp.		</th>
			<th>FechaUP		</th>
			<th>Monto 		</th>
			<th>Informes 	</th>
			<th>Atención 	</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$montoTotal = 0;
			$link=Conectarse();
			$SQL = "SELECT * FROM Cotizaciones Where RutCli = '".$RutCli."' and Estado = 'T' and Archivo != 'on' and informeUP = 'on' and Facturacion != 'on' Order By Facturacion, Archivo, informeUp, fechaTermino Desc";
			$bd=$link->query($SQL);
			while ($row=mysqli_fetch_array($bd)){
				if($row['Estado'] == 'T') 		{ $tr = 'bg-light text-dark'; 		} // Barra Blanca
				if($row['informeUP'] == 'on')	{ $tr = 'bg-warning text-dark'; 	} // Barra Amarilla
				if($row['Facturacion'] == 'on')	{ $tr = 'bg-success text-white'; 	} // Barra Verde
				if($row['Archivo'] == 'on')		{ $tr = 'bg-primary text-white'; 	} // Barra Azul
				
				?>
					<tr class=<?php echo $tr; ?>>
						<td>
							<?php echo 'RAM'.$row['RAM'].'<br>CAM'.$row['CAM']; ?>
						</td>
						<td>
							<?php
								echo $row['usrResponzable'];
							?>
						</td>
						<td>
							<?php
								$fd = explode('-',$row['fechaInformeUP']);
								echo $fd[2].'-'.$fd[1].'-'.$fd[0];
							?>							
						</td>
						<td>
							<?php
								if($row['Bruto'] > 0){
									echo '$ '.number_format($row['Bruto'],0,',','.');
									$montoTotal += $row['Bruto'];
								}else{
									echo number_format($row['BrutoUF'],2,',','.').' UF';
								}
							?>
						</td>
						<td>
							<?php
								$informes = '';
								$SQLi = "SELECT * FROM informes Where CodInforme Like '%".$row['RAM']."%'";
								$bdi=$link->query($SQLi);
								while ($rowi=mysqli_fetch_array($bdi)){
									if($informes == ''){
										$informes = $rowi['informePDF'];
									}else{
										$informes .= ', '.$rowi['informePDF'];
									}
								}
								echo $informes;
							?>
						</td>
						<td>
							<?php
								$SQLa = "SELECT * FROM contactoscli Where RutCli = '".$RutCli."' and nContacto Like '%".$row['nContacto']."%'";
								$bda=$link->query($SQLa);
								if ($rowa=mysqli_fetch_array($bda)){
									echo $rowa['Contacto'];
								}
							?>
						</td>
					</tr>
				<?php
			}
			$link->close();
		?>
	</tbody>
	<tfoot>
		<tr>
			<th> 		</th>
			<th>		</th>
			<th>		</th>
			<th>
				<?php echo '$ '.number_format($montoTotal,0,',','.'); ?>
			</th>
			<th> 		</th>
			<th> 		</th>
		</tr>
	</tfoot>
</table>