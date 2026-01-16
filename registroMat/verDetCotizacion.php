<?php
	header('Content-Type: text/html; charset=iso-8859-1');
	include_once("conexion.php");
	date_default_timezone_set("America/Santiago");
	$Rev	= 0;
	$Cta	= 0;
	$CAM 	= $_GET[CAM];
	$Rev 	= $_GET[Rev];
	$Cta 	= $_GET[Cta];
	$buscar = $_GET[buscar];
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
				
				$bdEnc=mysql_query("SELECT * FROM dCotizacion Where CAM = '".$CAM."' and Cta = '".$Cta."' Order By nLin Asc");
				if ($row=mysql_fetch_array($bdEnc)){
					do{
						$tr = "barraBlanca";
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
						echo '	<td width="05%" style="font-size:16px;" align="center">';
						echo		$row[nLin];
						echo '	</td>';
						echo '	<td width="10%" style="font-size:16px;">';
						echo 		$row[Cantidad];
						echo '	</td>';
						echo '	<td width="45%">';
									$bdSer=mysql_query("SELECT * FROM Servicios Where nServicio = '".$row[nServicio]."'");
									if($rowSer=mysql_fetch_array($bdSer)){
										echo 	$rowSer[Servicio];
										$vServicio = $rowSer[ValorUF];
									}
						echo '	</td>';
						echo '	<td width="10%">';
									echo '<strong>';
									$bdCot=mysql_query("SELECT * FROM Cotizaciones Where CAM = '".$CAM."' and Cta = '".$Cta."'");
									if($rowCot=mysql_fetch_array($bdCot)){
										$Moneda = $rowCot[Moneda];
									}
									if($Moneda=='P'){
										echo number_format($vServicio*$rowCot[valorUF], 0, ',', '.').'<br>';
										echo '<span style="font-size:10px;">('.number_format($vServicio, 2, ',', '.').' UF )</span>';
									}else{
										echo number_format($vServicio, 2, ',', '.');
									}
									echo '</strong>';
						echo ' 	</td>';
						echo '	<td width="10%" align="right">';
									$bdCot=mysql_query("SELECT * FROM Cotizaciones Where CAM = '".$CAM."' and Cta = '".$Cta."'");
									if($rowCot=mysql_fetch_array($bdCot)){
										$Moneda = $rowCot[Moneda];
									}
									echo '<strong>';
									if($Moneda=='P'){
										echo number_format($row[Neto], 0, ',', '.');
										$tNeto += $row[Neto];
									}else{
										echo number_format($row[NetoUF], 2, ',', '.');
										$tNeto += $row[NetoUF];
									}
									echo '</strong>';
						echo ' 	</td>';
						echo '	<td width="10%" align="center"><a href="modCotizacion.php?CAM='.$row[CAM].'&Rev='.$Rev.'&Cta='.$Cta.'&nServicio='.$row[nServicio].'&nLin='.$row[nLin].'&accion=ActualizarServ"				><img src="../gastos/imagenes/corel_draw_128.png" 	width="40" height="40" title="Editar Items">		</a></td>';
						echo '	<td width="10%" align="center"><a href="modCotizacion.php?CAM='.$row[CAM].'&Rev='.$Rev.'&Cta='.$Cta.'&nServicio='.$row[nServicio].'&nLin='.$row[nLin].'&accion=BorrarServ"					><img src="../gastos/imagenes/del_128.png"   		width="40" height="40" title="Borrar Items">		</a></td>';
						echo '</tr>';
					}while ($row=mysql_fetch_array($bdEnc));
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
				mysql_close($link);
					echo '<tr>';
					echo '	<td colspan="7" id="barraTotCot">';
								$link=Conectarse();
								$bdCot=mysql_query("SELECT * FROM Cotizaciones Where CAM = '".$CAM."' and Cta = '".$Cta."'");
								if ($rowCot=mysql_fetch_array($bdCot)){
									$Neto 		= $rowCot[Neto];
									$Iva 		= $rowCot[Iva];
									$Bruto	 	= $rowCot[Bruto];
									$NetoUF 	= $rowCot[NetoUF];
									$IvaUF 		= $rowCot[IvaUF];
									$BrutoUF 	= $rowCot[BrutoUF];
									$pDescuento = $rowCot[pDescuento];
								}
								mysql_close($link);
					echo '		<table width="99%">';
					echo '			<tr >';
					echo '				<td style="border-right:1px solid #ccc;">';
					echo 					'Total Neto<br>';
											if($rowCot[Moneda]=='P'){
												echo 	number_format($tNeto, 0, ',', '.');
											}else{
												echo 	number_format($tNeto, 2, ',', '.');
											}
					echo '				</td>';
					echo '				<td style="border-right:1px solid #ccc;">';
					echo 					'Descuento<br>';?>
<!-- 											<input name="pDescuento" id="pDescuento" size=5 onKeyUp="calculaDescuento($('#CAM').val(), $('#Rev').val(), $('#Cta').val(), $('#pDescuento').val())" value="<?php echo $pDescuento; ?>" autofocus/> -->
 											<input name="pDescuento" id="pDescuento" size=5 value="<?php echo $pDescuento; ?>" autofocus/>
											<button onClick="calculaDescuento($('#CAM').val(), $('#Rev').val(), $('#Cta').val(), $('#pDescuento').val())">
												Cálcular
											</button>
											<span id="resultadoDescuento"></span>
											<?php
//					echo 					'<input name="pDescuento" id="pDescuento" size=5 onKeyUp="cDescuento();" autofocus/>';
					echo '				</td>';
					echo '				<td style="border-right:1px solid #ccc;">';
					echo 					'Neto<br>';
//					echo 					'<input name="NetoUF" id="NetoUF" size=10 readonly/>';
											if($rowCot[Moneda]=='P'){
												echo number_format($Neto, 0, ',', '.');
											}else{
												echo number_format($NetoUF, 2, ',', '.');
											}
					echo '				</td>';
					echo '				<td style="border-right:1px solid #ccc;">';
					echo 					'Iva<br>';
											if($rowCot[Moneda]=='P'){
												echo number_format($Iva, 0, ',', '.');
											}else{
												echo number_format($IvaUF, 2, ',', '.');
											}
					echo '				</td>';
					echo '				<td>';
					echo 					'Total<br>';
											if($rowCot[Moneda]=='P'){
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
				echo '			<td height="50" style="padding:5px;"><img src="../imagenes/settings_128.png" width="40" height="40" align="middle"> Servicios</td>';
				echo '		</tr>';
							?>
							<tr>
								<td>
									Servicio... <input name="buscar" id="buscar" size="40" maxlength="40" value="<?php echo $buscar;?>" onKeyUp="nominadeServicios($('#CAM').val(), $('#buscar').val())" style="font-size:12px; font-weight:700;">
								</td>
							</tr>
							<?php 
				echo '	</table>';
				?>
				
				<script>
					var CAM 	= "<?php echo $CAM; ?>";
					var buscar 	= "<?php echo $buscar; ?>";
					nominadeServicios(CAM, buscar);					
				</script>
				<span id="mostrarListaServicios"></span>
<?php
/*
	echo '	<table width="100%" border="0" cellspacing="0" cellpadding="0" id="cajaItemsListado">';
	$link=Conectarse();
				$bdEnc=mysql_query("SELECT * FROM Servicios Order By Servicio");
				if ($row=mysql_fetch_array($bdEnc)){
					do{
						$tr = "barraVerde";
						if($row[tpServicio]=='E'){ // Enviada
							$tr = 'barraAmarilla';
						}

						echo '<tr id="'.$tr.'">';
						echo '	<td width="35%">';
						echo 		$row[Servicio];
						echo '	</td>';
						echo '	<td width="10%">';
									echo '<strong>';
									echo number_format($row[ValorUF], 2, ',', '.');
									echo '</strong>';
						echo ' 	</td>';
						echo '	<td width="10%" align="center"><a href="modCotizacion.php?CAM='.$CAM.'&Rev='.$Rev.'&Cta='.$Cta.'&nServicio='.$row[nServicio].'&nLin=0&accion=AgregarServ"		><img src="../imagenes/carroCompras2.png"   		width="50" height="50" title="Agregar a Cotización">		</a></td>';
						echo '</tr>';
					}while ($row=mysql_fetch_array($bdEnc));
				}
		mysql_close($link);
		echo '	</table>';
*/		
				?>
			</td>
		</tr>
	</table>
