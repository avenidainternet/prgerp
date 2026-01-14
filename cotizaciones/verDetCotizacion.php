<?php
	header('Content-Type: text/html; charset=utf-8');
	include_once("../conexionli.php");
	date_default_timezone_set("America/Santiago");
	$Rev			= 0;
	$Cta			= 0;
	$pDescuento 	= 0;
	$NetoUF 		= 0;
	$IvaUF 			= 0;
	$BrutoUF		= 0;
	
	
	if(isset($_GET['CAM'])) 	{ $CAM 		= $_GET['CAM'];		}
	if(isset($_GET['Rev'])) 	{ $Rev 		= $_GET['Rev'];		}
	if(isset($_GET['Cta'])) 	{ $Cta 		= $_GET['Cta'];		}
	if(isset($_GET['buscar'])) 	{ $buscar 	= $_GET['buscar'];	}
	?>
	<table width="98%" cellpadding="0" cellspacing="0">
		<tr>
			<td width="70%" valign="top">
				<?php
				echo '	<table width="99%" border="0" cellspacing="0" cellpadding="0" id="cajaItemsCotizacion">';
				echo '		<tr>';
				echo '			<td  width="05%" align="center" height="40"><strong>It						</strong></td>';
				echo '			<td  width="10%">							<strong>Can.					</strong></td>';
				echo '			<td  width="45%">							<strong>Servicio				</strong></td>';
				echo '			<td  width="10%">							<strong>Valor<br>Unitario		</strong></td>';
				echo '			<td  width="10%">							<strong>Total Neto				</strong></td>';
				echo '			<td  width="20%" align="center" colspan="2"><strong>Acciones				</strong></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table width="99%" border="0" cellspacing="0" cellpadding="0" id="cajaItemsListado">';
				$n 		= 0;
				$tNeto	= 0;
				$link=Conectarse();

				//$bdEnc=$link->query("SELECT * FROM dCotizacion Where CAM = '".$CAM."' and Cta = '".$Cta."' Order By nLin Asc");
				$bdEnc=$link->query("SELECT * FROM dCotizacion Where CAM = '".$CAM."' Order By nLin Asc");
				if ($row=mysqli_fetch_array($bdEnc)){
					do{
						$tr = "barraBlanca";
						echo '<tr id="'.$tr.'">';
						echo '	<td width="05%" style="font-size:16px;" align="center">';
						echo		$row['nLin'];
						echo '	</td>';
						echo '	<td width="10%" style="font-size:16px;">';
						echo 		$row['Cantidad'];
						echo '	</td>';
						echo '	<td width="45%">';
									$bdSer=$link->query("SELECT * FROM Servicios Where Estado = 'on' and nServicio = '".$row['nServicio']."'");
									if($rowSer=mysqli_fetch_array($bdSer)){
										echo 	$rowSer['Servicio'];
										$vServicio = $rowSer['ValorUF'];
									}
						echo '	</td>';
						echo '	<td width="10%">';
									echo '<strong>';
									$bdCot=$link->query("SELECT * FROM Cotizaciones Where CAM = '".$CAM."' and Cta = '".$Cta."'");
									if($rowCot=mysqli_fetch_array($bdCot)){
										$Moneda = $rowCot['Moneda'];
									}
									if($Moneda=='P'){
										echo number_format($vServicio*$rowCot['valorUF'], 0, ',', '.').'<br>';
										echo '<span style="font-size:10px;">('.number_format($vServicio, 2, ',', '.').' UF )</span>';
									}else{
										echo number_format($vServicio, 2, ',', '.');
									}
									echo '</strong>';
						echo ' 	</td>';
						echo '	<td width="10%" align="right">';
									$bdCot=$link->query("SELECT * FROM Cotizaciones Where CAM = '".$CAM."' and Cta = '".$Cta."'");
									if($rowCot=mysqli_fetch_array($bdCot)){
										$Moneda = $rowCot['Moneda'];
									}
									echo '<strong>';
									if($Moneda=='P'){
										echo number_format($row['Neto'], 0, ',', '.');
										$tNeto += $row['Neto'];
									}else{
										echo number_format($row['NetoUF'], 2, ',', '.');
										$tNeto += $row['NetoUF'];
									}
									echo '</strong>';
						echo ' 	</td>';
						echo '	<td width="10%" align="center"><a href="modCotizacion.php?CAM='.$row['CAM'].'&Rev='.$row['Rev'].'&Cta='.$Cta.'&nServicio='.$row['nServicio'].'&nLin='.$row['nLin'].'&accion=ActualizarServ"				><img src="../gastos/imagenes/corel_draw_128.png" 	width="40" height="40" title="Editar Items">		</a></td>';
						echo '	<td width="10%" align="center"><a href="modCotizacion.php?CAM='.$row['CAM'].'&Rev='.$row['Rev'].'&Cta='.$Cta.'&nServicio='.$row['nServicio'].'&nLin='.$row['nLin'].'&accion=BorrarServ"					><img src="../gastos/imagenes/del_128.png"   		width="40" height="40" title="Borrar Items">		</a></td>';
						echo '</tr>';
					}while ($row=mysqli_fetch_array($bdEnc));
					echo '<tr>';
					echo '	<td colspan="7" width="100%">';
					
					
					echo '	</td>';
					echo '</tr>';
				}else{?>
					<tr>
						<td width="100%" align="center"><span style="font-size:24px; font-weight:700;">Cotización sin Registro de Servicios </span></td>
					</tr>
					<?php
				}
				$link->close();
					echo '<tr>';
					echo '	<td colspan="7" id="barraTotCot">';
								$link=Conectarse();
								$bdCot=$link->query("SELECT * FROM Cotizaciones Where CAM = '".$CAM."' and Cta = '".$Cta."'");
								if ($rowCot=mysqli_fetch_array($bdCot)){
									$Neto 		= $rowCot['Neto'];
									$Iva 		= $rowCot['Iva'];
									$Bruto	 	= $rowCot['Bruto'];
									$NetoUF 	= $rowCot['NetoUF'];
									$IvaUF 		= $rowCot['IvaUF'];
									$BrutoUF 	= $rowCot['BrutoUF'];
									$pDescuento = $rowCot['pDescuento'];
								}
								$link->close();
					echo '		<table width="99%">';
					echo '			<tr >';
					echo '				<td style="border-right:1px solid #ccc;">';
					echo 					'Total Neto<br>';
											if($rowCot['Moneda']=='P'){
												echo 	number_format($tNeto, 0, ',', '.');
											}else{
												echo 	number_format($tNeto, 2, ',', '.');
											}
					echo '				</td>';
					echo '				<td style="border-right:1px solid #ccc;">';
					echo 					'Descuento<br>';?>
											<form name="form" action="modCotizacion.php" method="post">
												<input name="CAM" id="CAM" type="hidden" value="<?php echo $CAM; ?>" />
												<input name="Rev" id="Rev" type="hidden" value="<?php echo $Rev; ?>" />
												<input name="Cta" id="Cta" type="hidden" value="<?php echo $Cta; ?>" />
												<input name="pDescuento" id="pDescuento" size=5 value="<?php echo $pDescuento; ?>" autofocus/>
												<button name="calDescuento">
												<!-- </h1><button onClick="calculaDescuento($('#CAM').val(), $('#Rev').val(), $('#Cta').val(), $('#pDescuento').val())"> -->
													Calcular
												</button>
											</form>
											<!-- <span id="resultadoDescuento"></span> -->
											<?php
					echo '				</td>';
					echo '				<td style="border-right:1px solid #ccc;">';
					echo 					'Neto<br>';
											if($rowCot['Moneda']=='P'){
												echo number_format($Neto, 0, ',', '.');
											}else{
												echo number_format($NetoUF, 2, ',', '.');
											}
					echo '				</td>';
					echo '				<td style="border-right:1px solid #ccc;">';
					echo 					'Iva<br>';
											if($rowCot['Moneda']=='P'){
												echo number_format($Iva, 0, ',', '.');
											}else{
												echo number_format($IvaUF, 2, ',', '.');
											}
					echo '				</td>';
					echo '				<td>';
					echo 					'Total<br>';
											if($rowCot['Moneda']=='P'){
												echo number_format($Bruto, 0, ',', '.');
											}else{
												echo number_format($BrutoUF, 2, ',', '.');
											}
					echo '				</td>';
					echo '			</tr>';
					echo '		</table>';
					echo '	</td>';
					echo '</tr>';



				echo '	</table>';
				
				?>
			</td>
			<td width="30%" valign="top">
				<?php
				echo '	<table width="100%" border="0" cellspacing="0" cellpadding="0" id="cajaItemsCotizacion">';
				echo '		<tr>';
				echo '			<td height="50" style="padding:5px;">';
				echo '				<img src="../imagenes/settings_128.png" width="40" height="40" align="middle">';
				echo  				'Servicios';
				echo '				<a href="Servicios.php?CAM='.$CAM.'&Rev='.$Rev.'&Cta='.$Cta.'"><img src="../imagenes/agragarEquipo.png" width="40" height="40" align="middle"></a>';
				echo  				'Agregar Servicio';
				echo '			</td>';
				echo '		</tr>';
							?>
							<tr>
								<td>
									<?php $buscar = ''; ?>
									Servicio... <input name="buscar" id="buscar" size="40" maxlength="40" value="<?php echo $buscar;?>" onKeyUp="nominadeServicios($('#CAM').val(), 0, $('#buscar').val())" style="font-size:12px; font-weight:700;">
								</td>
							</tr>
							<?php 
				echo '	</table>';
				?>
				
				<script>
					var CAM 	= "<?php echo $CAM; ?>";
					var Cta 	= "<?php echo $Cta; ?>";
					var buscar 	= "<?php echo $buscar; ?>";
					nominadeServicios(CAM, Cta, buscar);					
				</script>
				<span id="mostrarListaServicios"></span>
			</td>
		</tr>
	</table>
