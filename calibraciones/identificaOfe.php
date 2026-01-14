<table width="100%" border="0" cellpadding="0" cellspacing="0" id="tablaOferta" style="border-top:4px solid#000;">
	<tr>
		<td class="titTabOferta" width="30%">Descripción Propuesta</td>
		<td width="70%">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2">
			<div style="font-weight:800;">El Servicio es solicitado por:</div>
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td style="padding-left:5%;" width="20%"><li><b>Razón Social</b></li></td>
					<td>:</td>
					<td> <?php echo $rowCli['Cliente']; ?></td>
				</tr>
				<tr>
					<td style="padding-left:5%;"><li><b>RUT</b></li></td>
					<td>:</td>
					<td> <?php echo $rowCli['RutCli']; ?></td>
				</tr>
				<tr>
					<td style="padding-left:5%;"><li><b>Contacto</b></li></td>
					<td>:</td>
					<td> <?php echo $rowCc['Contacto']; ?></td>
				</tr>
				<tr>
					<td style="padding-left:5%;"><li><b>Fono</b></li></td>
					<td>:</td>
					<td> <?php echo $rowCc['Telefono']; ?></td>
				</tr>
				<tr>
					<td style="padding-left:5%;"><li><b>Email</b></li></td>
					<td>:</td>
					<td> <?php echo $rowCc['Email']; ?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>	

<table width="100%" border="0" cellpadding="0" cellspacing="0" id="tablaOferta" style="border-top:4px solid#000;">
	<tr>
		<td class="titTabOferta" width="30%">Identificación Servicio</td>
		<td width="70%">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2">
			<ul>
			<?php
				$bdCot=mysql_query("SELECT * FROM cotizaciones Where CAM = '".$OFE."'");
				if($rowCot=mysql_fetch_array($bdCot)){
					$bdOF=mysql_query("SELECT * FROM propuestaeconomica Where OFE = '".$OFE."'");
					if($rowOF=mysql_fetch_array($bdOF)){
						$bdDp=mysql_query("SELECT * FROM descripcionpropuesta Order By itemPropuesta");
						if($rowDp=mysql_fetch_array($bdDp)){
							do{ ?>
								<li style="list-style:none; padding-left:5%;"><?php echo $rowDp['itemPropuesta'].'.- <b>'.strtoupper($rowDp['titPropuesta']).'</b>'; ?>
								<?php
								if($rowDp['descripcion']){ ?>
									<ul>
										<li style="list-style:none;">
											<?php
												$objFoco = 0;
												$Nuevo   = 'NO';
												if(strpos($rowDp['descripcion'], '$objetivoGeneral')){
													$txtSep = explode('$objetivoGeneral',$rowDp['descripcion']);
													$descripcion = '';
													$objetivoGeneral = $rowDp['descripcion'];
													$descripcion = str_replace('$objetivoGeneral',$rowOF['objetivoGeneral'],$rowDp['descripcion']);
													echo $txtSep[0];
													?>
														<input name="objetivoGeneral" value="<?php echo $rowOF['objetivoGeneral']; ?>" type="text" size="50">
													<?php
													echo $txtSep[1];
													$nOtro = 0;
													if(isset($_GET['nOtro'])){ $nOtro = $_GET['nOtro']; }
													if($nOtro == 0){
														if(isset($_GET['Quitar'])){
															if($_GET['Quitar'] > 0){
																$bdObj =mysql_query("Delete From objetivospropuestas Where OFE = '".$OFE."' and nObjetivo = '".$_GET['Quitar']."'");
															}
														}
														$objFoco = 0;
														$Nuevo 	 = 'NO';
														if(isset($_GET['Agregar'])){
															if($_GET['Agregar'] == 1){
																$Nuevo = 'SI';
																$bdObj=mysql_query("SELECT * FROM objetivospropuestas where OFE = '".$OFE."' Order By nObjetivo Desc");
																if($rowObj=mysql_fetch_array($bdObj)){
																	$nObjetivo = $rowObj['nObjetivo'] + 1;
																	$objFoco = $nObjetivo;
																	mysql_query("insert into objetivospropuestas	(
																													OFE,
																													nObjetivo
																												)	 
																										values 	(	'$OFE',
																													'$nObjetivo'
																											)",$link);
																}
															}
														}
													}
													
													$bdObj=mysql_query("SELECT * FROM objetivospropuestas where OFE = '".$OFE."'");
													if($rowObj=mysql_fetch_array($bdObj)){
													}else{
														$nObjetivo = 1;
														mysql_query("insert into objetivospropuestas	(
																										OFE,
																										nObjetivo
																									)	 
																							values 	(	'$OFE',
																										'$nObjetivo'
																								)",$link);
														
													}

													$bdObj=mysql_query("SELECT * FROM objetivospropuestas where OFE = '".$OFE."' Order By nObjetivo");
													if($rowObj=mysql_fetch_array($bdObj)){
														do{ 
															$vObj = 'Objetivos-'.$rowObj['nObjetivo'];
															?>
															<ul>
																<li>
																	<?php 
																		if($objFoco == 0){
																			?>
																				<textarea style="font-size:12px;" name="<?php echo $vObj; ?>" rows="2" cols="60"><?php echo $rowObj['Objetivos']; ?></textarea>
																			<?php
																		}else{
																			if($objFoco == $rowObj['nObjetivo']){
																				?>
																					<textarea style="font-size:12px;" name="<?php echo $vObj; ?>" rows="2" cols="60" autofocus><?php echo $rowObj['Objetivos']; ?></textarea>
																				<?php
																			}else{
																				?>
																					<textarea style="font-size:12px;" name="<?php echo $vObj; ?>" rows="2" cols="60"><?php echo $rowObj['Objetivos']; ?></textarea>
																				<?php
																			}
																		}
																	?>
																	<a href="index.php?OFE=<?php echo $OFE; ?>&accion=OFE&Quitar=<?php echo $rowObj['nObjetivo']; ?>&Agregar=">Quitar</a> 
																	<a href="index.php?OFE=<?php echo $OFE; ?>&accion=OFE&Quitar=&Agregar=1">Agregar</a> 
																</li>
															</ul>
															<?php
														}while ($rowObj=mysql_fetch_array($bdObj));
														?>
														<button name="guardarOferta" style="padding:10px; margin-left:50px; margin-top:10px;">
															<span>Guardar</span>
														</button>
														<?php
													}
	
												}else{
													if(strpos($rowDp['descripcion'], '$Habiles')){
														$txtSep = explode('$Habiles',$rowDp['descripcion']);
														$descripcion = '';
														$objetivoGeneral = $rowDp['descripcion'];
														$descripcion = str_replace('$objetivoGeneral',$rowOF['objetivoGeneral'],$rowDp['descripcion']);
														echo $txtSep[0];
														echo '<b>'.$rowCot['dHabiles'].'</b>'; 
														echo $txtSep[1]; 
													}else{
														if(strpos($rowDp['descripcion'], '$totalOfertaUF')){
															$txtSep = explode('$totalOfertaUF',$rowDp['descripcion']);
															$descripcion = '';
															$objetivoGeneral = $rowDp['descripcion'];
															$descripcion = str_replace('$objetivoGeneral',$rowOF['objetivoGeneral'],$rowDp['descripcion']);
															echo $txtSep[0];
															echo '<b>'.$rowCot['NetoUF'].'</b>'; 
															echo $txtSep[1]; 
														}else{
															echo $rowDp['descripcion'];
														}
													}
												}
												?>
										</li>
										<?php
										$bdIp=mysql_query("SELECT * FROM itempropuesta where itemPropuesta = '".$rowDp['itemPropuesta']."'");
										if($rowIp=mysql_fetch_array($bdIp)){
											do{
												?>
													<li style="list-style:none;"><b><?php echo $rowDp['itemPropuesta'].'.'.$rowIp['subItem'].' <i>'.$rowIp['titSubItem'].'</i>'; ?></b>
														<ul>
															<li style="list-style:none;"><?php echo $rowIp['descripcionSubItem']; ?></li>
															<?php
																if($rowIp['Ensayos'] == 'on'){
																	$nIdEnsayos = 0;
																	$bdEns=mysql_query("SELECT * FROM ensayosOFE Where OFE = '".$OFE."' Order By nDescEnsayo");
																	if($rowEns=mysql_fetch_array($bdEns)){
																		do{
																			$bdIe=mysql_query("SELECT * FROM ofensayos Where nDescEnsayo = '".$rowEns['nDescEnsayo']."'");
																			if($rowIe=mysql_fetch_array($bdIe)){
																					$nIdEnsayos++;
																					if($rowIe['Generico'] == 'on'){
																						?>
																							<li style="list-style:none;"><b><?php echo $rowDp['itemPropuesta'].'.'.$rowIp['subItem'].'.'.$nIdEnsayos.'.- <a href="index.php?OFE='.$OFE.'&accion=OFE&nDescEnsayo='.$rowIe['nDescEnsayo'].'&accionEnsayo=Quitar">'.$rowIe['nomEnsayo'].'</a>'; ?></b> (Clic para Quitar) </li>
																							<ul>
																								<li style="list-style:none;"><?php echo $rowIe['Descripcion']; ?></li>
																							</ul>
																							<br>
																						<?php
																					}else{
																						?>
																							<li style="list-style:none;"><b><?php echo $rowDp['itemPropuesta'].'.'.$rowIp['subItem'].'.'.$nIdEnsayos.'.- <a href="index.php?OFE='.$OFE.'&accion=OFE&nDescEnsayo='.$rowIe['nDescEnsayo'].'&accionEnsayo=Quitar">'.$rowIe['nomEnsayo'].'</a>'; ?></b> (Clic para Quitar) </li>
																							<ul>
																								<li style="list-style:none;"><?php echo $rowIe['Descripcion']; ?></li>
																							</ul>
																						<?php
																						$nOtro = 0;
																						$Nuevo = 'NO';
																						if(isset($_GET['nOtro']))		{ $nOtro 		= $_GET['nOtro']; 		}
																						if(isset($_GET['nDescEnsayo']))	{ $nDescEnsayo 	= $_GET['nDescEnsayo']; }
																						if($nOtro > 0){
																							if(isset($_GET['Quitar'])){
																								if($_GET['Quitar'] > 0){
																									$bdObj =mysql_query("Delete From otrosensayos Where OFE = '".$OFE."' and nOtro = '".$_GET['nOtro']."' and nDescEnsayo = '".$_GET['nDescEnsayo']."'");
																								}
																							}
																							if(isset($_GET['Agregar'])){
																								if($_GET['Agregar'] == 1){
																									$Nuevo = 'SI';
																									$bdNG=mysql_query("SELECT * FROM otrosensayos where OFE = '".$OFE."' Order By nOtro Desc");
																									if($rowNG=mysql_fetch_array($bdNG)){
																										$nOtro = $rowNG['nOtro'] + 1;
																										$objFoco = $nOtro;
																										mysql_query("insert into otrosensayos	(
																																				OFE,
																																				nDescEnsayo,
																																				nOtro
																																			)	 
																																	values 	(	'$OFE',
																																				'$nDescEnsayo',
																																				'$nOtro'
																																		)",$link);
																									}
																								}
																							}
																						}
																						$bdNG=mysql_query("SELECT * FROM otrosensayos Where OFE = '".$OFE."' Order By nOtro");
																						if($rowNG=mysql_fetch_array($bdNG)){
																							do{
																								$vOtros = 'Otros-'.$rowNG['nOtro'];
																								?>
																									<ul>
																										<ul>
																											<li>
																												<?php if($Nuevo == 'SI' and $nOtro == $rowNG['nOtro']){ ?>
																													<textarea style="font-size:12px;" rows="4" cols="50" name="<?php echo $vOtros; ?>" autofocus /><?php echo $rowNG['Descripcion']; ?></textarea>
																												<?php }else{ ?>
																													<textarea style="font-size:12px;" rows="4" cols="50" name="<?php echo $vOtros; ?>"><?php echo $rowNG['Descripcion']; ?></textarea>
																												<?php } ?>
																												<a href="index.php?OFE=<?php echo $OFE; ?>&accion=OFE&nOtro=<?php echo $rowNG['nOtro']; ?>&nDescEnsayo=<?php echo $rowIe['nDescEnsayo']; ?>&Quitar=1&Agregar=">Quitar</a> 
																												<a href="index.php?OFE=<?php echo $OFE; ?>&accion=OFE&nOtro=<?php echo $rowNG['nOtro']; ?>&nDescEnsayo=<?php echo $rowIe['nDescEnsayo']; ?>&Quitar=&Agregar=1">Agregar</a> 
																											</li>
																										</ul>
																									</ul>
																								<?php
																							}while ($rowNG=mysql_fetch_array($bdNG));
																							?>
																							<button name="guardarOferta" style="padding:10px; margin-left:50px; margin-top:10px;">
																								<span>Guardar</span>
																							</button>
																							<?php
																						}
																					}
																			}
																		}while ($rowEns=mysql_fetch_array($bdEns));
																	}
																	if($nIdEnsayos == 0){
																		?>
																			<div style="background-color:#FF0000; font-size:16px; color:#FFFFFF; border:1px solid #000; padding:10px;">
																				<b>No existen ensayos asociados a la OFE.</b> Seleccione Ensayos ==>
																			</div>
																		<?php
																	}
																}
															?>
														</ul>
														<br>
													</li>
												<?php
											}while ($rowIp=mysql_fetch_array($bdIp));
										}
										?>
									</ul>
									<br>
									<?php
								}
								?>
								</li>
								<?php
								$itemPropuesta = $rowDp['itemPropuesta'];
							}while ($rowDp=mysql_fetch_array($bdDp));
							?>
								<ul>
									<li style="list-style:none; padding-left:5%;"><?php echo $itemPropuesta.'.1.- <b><i>Envío de Muestras y Horario:</i></b>'; ?>
									<li style="list-style:none; padding-left:5%;"><?php echo $itemPropuesta.'.2.- <b><i>Condiciones de Pago:</i></b>'; ?>
									<li style="list-style:none; padding-left:5%;"><?php echo $itemPropuesta.'.3.- <b><i>Observaciones Generales:</i></b>'; ?>
								</ul>
							<?php
						}
					}
				}
				?>
				</ul>
				<?php
			?>
		</td>
	</tr>
</table>	
