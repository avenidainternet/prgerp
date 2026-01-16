<?php

	$Estado = array(
					1 => 'Todos', 
					2 => 'Pendientes',
					3 => 'Terminados',
					4 => 'Sin Informe'
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
	$link=Conectarse();
	$bdInf=mysql_query("Select * From amInformes Where CodInforme = '".$CodInforme."'");
	if($rowInf=mysql_fetch_array($bdInf)){
		$nMuestras 			= $rowInf[nMuestras];
		$tipoMuestra		= $rowInf[tipoMuestra];
		$tpEnsayo			= $rowInf[tpEnsayo];
		$fechaRecepcion 	= $rowInf[fechaRecepcion];
		$fechaInforme 		= $rowInf[fechaInforme];
		$CodigoVerificacion = $rowInf[CodigoVerificacion];
		$imgQR 				= $rowInf[imgQR];
		
		if($CodigoVerificacion == ''){
			$CodigoVerificacion = '';
			
			$i=0; 
			$password=""; 
			$pw_largo = 12; 
			$desde_ascii = 50; // "2" 
			$hasta_ascii = 122; // "z" 
			$no_usar = array (58,59,60,61,62,63,64,73,79,91,92,93,94,95,96,108,111); 
			while ($i < $pw_largo) { 
				mt_srand ((double)microtime() * 1000000); 
				$numero_aleat = mt_rand ($desde_ascii, $hasta_ascii); 
				if (!in_array ($numero_aleat, $no_usar)) { 
					$password = $password . chr($numero_aleat); 
					$i++; 
				} 
			}
			$CodigoVerificacion = $password;

			$actSQL="UPDATE amInformes SET ";
			$actSQL.="CodigoVerificacion = '".$CodigoVerificacion."'";
			$actSQL.="Where CodInforme = '".$CodInforme."'";
			$bdCot=mysql_query($actSQL);

			$actSQL="UPDATE Informes SET ";
			$actSQL.="CodigoVerificacion = '".$CodigoVerificacion."'";
			$actSQL.="Where CodInforme = '".$CodInforme."'";
			$bdCot=mysql_query($actSQL);
			
		}
	}
	mysql_close($link);
?>

<form name="form" action="edicionInformes.php" method="post">
		
			<div id="BarraOpciones">
				<div id="ImagenBarraLeft">
					<a href="plataformaGenInf.php" title="Informes">
						<img src="../imagenes/Tablas.png"></a>
					<br>
					PAMs
				</div>
				<div id="ImagenBarraLeft">
					<?php
						$r = explode('-',$CodInforme);
						$cIn 	= $r[0].'-'.$r[1];
					?>
					<a href="nominaInformes.php?CodInforme=<?php echo $cIn; ?>" title="Informes">
						<img src="../imagenes/Tablas.png"></a>
					<br>
					Informes
				</div>
				<div id="ImagenBarraLeft">
					<button name="actualizaInforme" style="float:right;" title="Guardar Informe">
							<img src="../gastos/imagenes/guardar.png" width="55" height="55">
					</button>
					<br>
					Guardar
				</div>
				<div id="ImagenBarraLeft">
					<!-- <a href="#" title="Generar Word" onClick="bajarInformeWord($('#CodInforme').val(), $('#accion').val())"> -->
					<a href="exportarInforme.php?CodInforme=<?php echo $CodInforme; ?>&accion=<?php echo $accion; ?>" title="Generar Word">
						<img src="../imagenes/word.gif"></a>
					<br>
					Generar
				</div>
				<div id="ImagenBarraLeft">
					<a href="plantilla.doc" title="Bajar Plantilla">
						<img src="../imagenes/descargaword.gif"></a>
					<br>
					Plantilla
				</div>
				<div id="ImagenBarraLeft">
					<a href="#" title="Subir Imagen de Muestra" onClick="subirFotoMuestra($('#CodInforme').val(), $('#accion').val())"> 
						<img src="../imagenes/fotoMuestras.gif"></a>
					<br>
					Muestra
				</div>
				
			</div>
			
			<input name="CodInforme" 	id="CodInforme" type="hidden" value="<?php echo $CodInforme; 	?>" />
			<input name="accion" 		id="accion" 	type="hidden" value="<?php echo $accion; 		?>">
			<table width="99%"  border="0" cellpadding="0" cellspacing="0" id="cajaDeTexto">
				<tr>
					<td>
						<table width="100%" cellpadding="0" cellspacing="0" class="cuadroInformes">
							<tr>
								<td width="19%">Cliente </td>
								<td colspan="3" valign="top">:
									<?php
									$link=Conectarse();
									$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$RutCli."'");
									if($rowCli=mysql_fetch_array($bdCli)){
										echo $rowCli[Cliente];
										$Direccion = $rowCli[Direccion];
									}
									mysql_close($link);
									?>
								</td>
							</tr>
							<tr>
								<td>Direcci&oacute;n </td>
								<td colspan="3">:
									<?php
										if($Direccion){
											echo $Direccion;
										}
									?>
								</td>
							</tr>
							<tr>
								<td>Cantidad de Muestras </td>
								<td width="37%">: 
									<select name="nMuestras">
										<?php 
											for($i=1; $i<31; $i++){
												if($nMuestras == $i){?>
													<option selected value="<?php echo $i;?>"><?php echo $i; ?></option>
												<?php }else{ ?>
													<option value="<?php echo $i;?>"><?php echo $i; ?></option>
												<?php 
												}
											} ?>
									</select>
								</td>
								<td width="20%">&nbsp;</td>
								<td width="24%">&nbsp;</td>
							</tr>
							<tr>
							  <td>Tipo de Muestra </td>
							  <td colspan="3">: 
							  	<input name="tipoMuestra" id="tipoMuestra" type="text" size="50" maxlength="50" value="<?php echo $tipoMuestra; ?>">
							  </td>
						  </tr>
							<tr>
								<td>Tipo de Ensayo </td>
								<td>: 
									<select name="tpEnsayo">
										<?php
											$link=Conectarse();
											$bdEns=mysql_query("SELECT * FROM amTpEnsayo");
											if($rowEns=mysql_fetch_array($bdEns)){
												do{
													if($tpEnsayo == $rowEns[tpEnsayo]){
														?>
														<option selected value="<?php echo $rowEns[tpEnsayo];?>"><?php echo $rowEns[Ensayo]; ?></option>
													<?php
													}else{
													?>
														<option value="<?php echo $rowEns[tpEnsayo];?>"><?php echo $rowEns[Ensayo]; ?></option>
														<?php
													}
												}while($rowEns=mysql_fetch_array($bdEns));
											} 
											mysql_close($link);
										?>
									</select>
								</td>
								<td>Fecha de Recepci&oacute;n</td>
								<td>: 
									<input name="fechaRecepcion" id="fechaRecepcion" type="date" value="<?php echo $fechaRecepcion; ?>">
								</td>
							</tr>
							<tr>
								<td>Solicitante</td>
								<td>: 
									<?php
									$link=Conectarse();
									$bdCot=mysql_query("SELECT * FROM Cotizaciones Where RAM = '".$Ra[1]."'");
									if($rowCot=mysql_fetch_array($bdCot)){
										$bdCli=mysql_query("SELECT * FROM contactosCli Where RutCli = '".$rowCot[RutCli]."' and nContacto = '".$rowCot[nContacto]."'");
										if($rowCli=mysql_fetch_array($bdCli)){
											echo $rowCli[Contacto];
										}
									}
									mysql_close($link);
									?>
								</td>
								<td>Fecha Emisi&oacute;n Informe</td>
								<td>: 
							    <input name="fechaInforme" id="fechaInforme" type="date" value="<?php echo $fechaInforme; ?>"></td>
							</tr>
						</table>
					</td>
				</tr>
		</table>
		
		<table width="99%"  border="0" cellpadding="0" cellspacing="0" id="cajaDeTexto">
			<tr>
				<td>
					<?php
					$link=Conectarse();
					$bdMue=mysql_query("SELECT * FROM amMuestras Where CodInforme = '".$CodInforme."' Order By idItem Desc");
					if($rowMue=mysql_fetch_array($bdMue)){
						$idItem = $rowMue[idItem];
						$Mu 	= explode('-',$idItem);
					}
					mysql_close($link);
					$txtItemA = 'A.- Identificación de la Muestra';
					if($Mu[1]>1){
						$txtItemA = 'A.- Identificación de las Muestras';
					}
					echo '<strong>'.$txtItemA.'</strong>';
					?>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%" cellpadding="0" cellspacing="0" id="tablaIdMuestras">
						<tr bgcolor="#CCCCCC">
							<td width="10%" align="center">
								ID<br>ITEM
							</td>
							<td width="70%">
								Identificación del Cliente
							</td>
							<td width="20%" colspan="2"></td>
						</tr>
						<?php
						$link=Conectarse();
						$bdMue=mysql_query("SELECT * FROM amMuestras Where CodInforme = '".$CodInforme."' Order By idItem");
						if($rowMue=mysql_fetch_array($bdMue)){
							do{?>
								<tr>
									<td align="center"><?php echo $rowMue[idItem]; ?></td>
									<td>
										Se ha recibido una muestra, identificada por el cliente como "
										<?php 
											if($rowMue[idMuestra]) { 
												echo $rowMue[idMuestra]; 
											}else{
												echo 'SIN IDENTIFICAR'; 
											} 
										?>
										"
									</td>
									<td>
										<?php
										echo '<a href="edicionInformes.php?accion=EditarMuestra&CodInforme='.$rowMue[CodInforme].'&idItem='.$rowMue[idItem].'"	><img src="../imagenes/actividades.png" width="30" title="Editar Muestra"	>	</a>';
										?>
									</td>
									<td>
										<?php
										//echo '<a href="edicionInformes.php?accion=EliminarMuestra&CodInforme='.$row[CodInforme].'&idItem='.$rowMue[idItem].'"	><img src="../imagenes/inspektion.png"  width="30" title="Eliminar Muestra"	>	</a>';
										?>
									</td>
								</tr>
								<?php 
							}while($rowMue=mysql_fetch_array($bdMue));
						}
						mysql_close($link);
						?>
					</table>
				</td>
			</tr>
		</table>

		<table width="99%"  border="0" cellpadding="0" cellspacing="0" id="cajaDeTexto">
			<tr>
				<td>
					<?php
					$txtItemA = 'B.- Ensayos';
					echo '<strong>'.$txtItemA.'</strong>';
					?>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%" cellpadding="0" cellspacing="0" id="tablaIdMuestras">
						<tr bgcolor="#CCCCCC">
							<td width="10%" align="center">
								ID<br>
								Ensayo</td>
							<td width="15%" align="center">
								Tipo<br> de Muestra 
							</td>
							<td width="23%" align="center">Con/Sin<br> Referencia </td>
							<td align="center">Cantidad<br>Ensayos </td>
						    <td>&nbsp;</td>
						    <td align="center">T&deg;</td>
						    <td align="center">Editar<br>Muestras</td>
						</tr>
						<?php
						$link=Conectarse();
						$bdEns=mysql_query("SELECT * FROM amEnsayos Order By nEns");
						if($rowEns=mysql_fetch_array($bdEns)){
							do{?>
								<tr>
									<td align="center"><?php echo $rowEns[Ensayo]; ?></td>
									<td>
										<?php 
										$idEnsayo 	= '';
										$tpMuestra	= '';
										$Ref 		= '';
										$cEnsayos 	= '';
										$cTem 		= '';
										
										$campoTpMuestra = 'tpMuestra'.$rowEns[idEnsayo];
										$bdTabEns=mysql_query("SELECT * FROM amTabEnsayos Where CodInforme = '".$CodInforme."' and idEnsayo = '".$rowEns[idEnsayo]."'");
										if($rowTabEns=mysql_fetch_array($bdTabEns)){
											$idEnsayo  	= $rowTabEns[idEnsayo];
											$tpMuestra 	= $rowTabEns[tpMuestra];
											$Ref 		= $rowTabEns[Ref];
											$cEnsayos	= $rowTabEns[cEnsayos];
											$Ind		= $rowTabEns[Ind];
											$cTem		= $rowTabEns[Tem];
										}
										?>
							  			<select name="<?php echo $campoTpMuestra; ?>" id="tpMuestra" style="width:200px;">
											<option></option>
											<?php
												$bdTpEns=mysql_query("SELECT * FROM amTpsMuestras Where idEnsayo = '".$rowEns[idEnsayo]."'");
												if($rowTpEns=mysql_fetch_array($bdTpEns)){
													do{
														if($rowTpEns[idEnsayo] == $idEnsayo and $rowTpEns[tpMuestra] == $tpMuestra){?>
															<option selected value="<?php echo $rowTpEns[tpMuestra];?>"><?php echo $rowTpEns[Muestra]; ?></option>
														<?php
														}else{?>
															<option value="<?php echo $rowTpEns[tpMuestra];?>"><?php echo $rowTpEns[Muestra]; ?></option>
														<?php
														}
													}while($rowTpEns=mysql_fetch_array($bdTpEns));
												} 
											?>
										</select>
									
									</td>
									<td align="center">
										<?php $campoRef = 'Ref'.$rowEns[idEnsayo]; ?>
										<select name="<?php echo $campoRef; ?>">
											<option></option>
											<?php if($Ref == 'SR'){?>
												<option selected 	value="SR">Sin Referencia</option>
											<?php }else{ ?>
												<option  			value="SR">Sin Referencia</option>
											<?php } ?>
											<?php if($Ref == 'CR'){?>
												<option selected 	value="CR">Con Referencia</option>
											<?php }else{ ?>
												<option  			value="CR">Con Referencia</option>
											<?php } ?>
										</select>
									</td>
									<td width="19%"  align="center">
										<?php $campocEnsayos = 'cEnsayos'.$rowEns[idEnsayo]; ?>
							  			<input name="<?php echo $campocEnsayos; ?>" id="cEnsayos" size="3" maxlength="3" value="<?php echo $cEnsayos; ?>">
									</td>
									<td width="16%" align="right" style="padding-right:20px;">
										<?php
										if($idEnsayo == 'Du'){
											$campoInd = 'Ind'.$rowEns[idEnsayo];
											echo 'Indentaciones : ';
											echo '<select name="'.$campoInd.'">';
												for($i=1; $i<7; $i++){ 
													if($Ind == $i){
														echo '<option value="'.$i.'" selected>'.$i.'</option>';
													}else{
														echo '<option value="'.$i.'">'.$i.'</option>';
													}
												}
											echo '</select>';		
										}

										if($idEnsayo == 'Ch'){
											$campoInd = 'Ind'.$rowEns[idEnsayo];
											echo 'Impactos: ';
											echo '<select name="'.$campoInd.'">';
												for($i=3; $i<=5; $i++){ 
													if($Ind == $i){
														echo '<option value="'.$i.'" selected>'.$i.'</option>';
													}else{
														echo '<option value="'.$i.'">'.$i.'</option>';
													}
												}
											echo '</select>';		
										}
										?>
									</td>
								    <td width="17%" align="center">
										<?php
										$campoTem = 'Tem'.$rowEns[idEnsayo];
										if($idEnsayo == 'Ch'){?>
							  				<input name="<?php echo $campoTem; ?>" size="11" maxlength="11" value="<?php echo $cTem; ?>">
										<?php 
										}
										?>
									</td>
								    <td width="17%" align="center">
										<?php
											if($cEnsayos > 0){
												echo '<a href="editarTablas.php?accion=editarTablas&CodInforme='.$CodInforme.'&idEnsayo='.$rowEns[idEnsayo].'&tpMuestra='.$tpMuestra.'&Ref='.$Ref.'"	><img src="../imagenes/extra_column.png"  width="40" title="Completar Tablas"	>	</a>';
											}
										?>
									</td>
								</tr>
								<?php 
							}while($rowEns=mysql_fetch_array($bdEns));
						}
						mysql_close($link);
						?>
					</table>
				</td>
			</tr>
		</table>
		<p>
			<b>Códigos</b>
		</p>
		<table width="100%" cellpadding="0" cellspacing="0" id="tablaIdMuestras">
			<tr bgcolor="#CCCCCC">
				<td align="center">Código de Verificación</td>
				<td align="center">Código QR</td>
			</tr>
			<tr>
				<td align="center">
					<b style="font-size:18px;">
					<?php echo $CodigoVerificacion; ?>
					</b>
				</td>
				<td align="center">
					
					<?php
						if($imgQR){
							$dirImg = "http://erp.simet.cl/codigoqr/phpqrcode/temp/$imgQR";
							echo '<img src="'.$dirImg.'"><br>';
						}else{
							if($CodInforme) {
								if($CodigoVerificacion) {
									$dirinfo  = "http://www.simet.cl/mostrarPdf.php";
									$dirinfo .= '?CodInforme='.$CodInforme.'&amp;CodigoVerificacion='.$CodigoVerificacion;
									echo "<iframe scrolling='no' src='../codigoqr/phpqrcode/gQR.php?data=".$dirinfo."' width='100%' height='200px' frameborder='0' marginheight='0' marginwidth='0'></iframe>";
									$imgQR = $CodInforme.'.png';
									$link=Conectarse();
									$actSQL="UPDATE amInformes SET ";
									$actSQL.="imgQR 			= '".$imgQR.		"'";
									$actSQL.="Where CodInforme 	= '".$CodInforme.	"'";
									$bdCot=mysql_query($actSQL);
									mysql_close($link);
								}
							}
						}
					?>
				</td>
			</tr>
		</table>
</form>
		
		<span id="resultadoEdicionMuestra"></span>
		<span id="resultado"></span>
		<span id="resultadoRegistro"></span>
		<span id="resultadoSubir"></span>
