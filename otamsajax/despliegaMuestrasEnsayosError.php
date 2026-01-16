	<?php 	
	
	$fechaApertura 	= date('Y-m-d');
	$encNew 		= 'Si';
	$guardar		= 0;
	$idItem 		= '';
	$nInd			= '';
	$distanciaMax  	= '';
	$separacion 	= '';
	$GetidItem 		= '';
	
	if(isset($_GET['idItem'])) 		{ $GetidItem = $_GET['idItem']; 	}
	if(isset($_POST['GetidItem'])) 	{ $GetidItem = $_POST['GetidItem']; }
	?>
		<input name="GetidItem" id="GetidItem" type="hidden" value="<?php echo $GetidItem; ?>" />
	<?php
	$link=Conectarse();
	$bdMu=mysql_query("SELECT * FROM amMuestras Where idItem Like '%".$RAM."%' Order by idItem");
	if($rowMu=mysql_fetch_array($bdMu)){
		do{
			$idMuestra	= $rowMu['idMuestra'];
			$Taller		= $rowMu['Taller'];
			$conEnsayo	= $rowMu['conEnsayo'];
			$idItem		= $rowMu['idItem'];
			$idIt 		= 'idItem-'.$idItem;
			$Objetivo	= $rowMu['Objetivo'];
			$Plano		= $rowMu['Plano'];

			?>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax" align="center">
				<tr>
					<td colspan="4" bgcolor="#0099CC">
						<img src="../imagenes/poster_teachers.png" width="50" align="middle">
						<span style="color:#FFFFFF; font-size:25px; font-weight:700;">
							Id. Muestra <span style="color:#FFFF00; font-weight:700; font-size:30px; "> <?php echo $idItem; ?></span>
					  	</span>
				  	</td>
				</tr>
				<tr>
					<td colspan="4" class="lineaDerBot">
						<input name="RAM" 						id="RAM" 		type="hidden" 	value="<?php echo $RAM; 		?>" />
						<input name="<?php echo $idIt; ?>" 		id="idItem" 	type="hidden" 	value="<?php echo $idItem; 		?>" />
						<input name="accion" 					id="accion" 	type="hidden"	value="<?php echo $accion; 		?>" />
					</td>
				</tr>
				<tr>
					<td height="93">
						<table width="100%" cellpadding="0" cellspacing="0" class="cuadroInformes">
							<tr>
							  <td width="14%" height="40" valign="top">Id.Muestra Cliente </td>
							  <td colspan="4" valign="top">
								<?php $idMu = 'idMuestra-'.$idItem; ?>
							  	<?php if($idItem == $GetidItem){?>
							  		<textarea autofocus name="<?php echo $idMu; ?>" cols="100" rows="5"><?php echo $idMuestra; ?></textarea>
									<!-- <input name="<?php echo $idMu; ?>" id="idMuestra" size="80" value="<?php echo $idMuestra; ?>" autofocus> -->
								<?php }else{ ?>
							  		<textarea name="<?php echo $idMu; ?>" cols="100" rows="5"><?php echo $idMuestra; ?></textarea>
									<!-- <input name="<?php echo $idMu; ?>" id="idMuestra" size="80" value="<?php echo $idMuestra; ?>"> -->
								<?php } ?>
							  </td>
						  </tr>
							<tr>
								<td height="40" valign="top" style="border-bottom:2px solid #ccc;">Necesita Serv. Taller</td>
						      	<td width="11%" valign="top" style="border-bottom:2px solid #ccc;">
									<?php $idTa = 'Taller-'.$idItem; ?>
							  		<select name="<?php echo $idTa; ?>" onclick="activaTaller(<?php echo "'".$idItem."'"; ?>);"> 
							  		<!-- <select name="vTaller" onchange="activaTaller(<?php echo "'".$idItem."'"; ?>);"-->
										<?php if($Taller == 'on'){?>
											<option selected 	value="on" >Si</option>
											<option 			value='off'>No</option>
										<?php }else{ ?>
											<option 	 		value="on" >Si</option>
											<option selected 	value='off'>No</option>
										<?php } ?>
                              		</select>
							  </td>
					          <td width="17%" valign="top" style="border-bottom:2px solid #ccc;">
									<?php
										if($Taller == 'on'){
											$bdRAM=mysql_query("SELECT * FROM formRAM Where RAM = '".$RAM."'");
											if($rowRAM=mysql_fetch_array($bdRAM)){
												?>
													<span style="font-weight:700;">N掳 Servicio: <?php echo $rowRAM['nSolTaller']; ?></span>
												<?php
											}
										}
									?>
									
								</td>
							    <td width="11%" valign="top" style="border-bottom:2px solid #ccc;">Con Ensayo:
									
								</td>
							    <td width="47%" valign="top" style="border-bottom:2px solid #ccc;">
									<?php $conEns = 'conEnsayo-'.$idItem; ?>
							  		<select name="<?php echo $conEns; ?>" title="Con Ensayo de Laboratorio">
										<?php if($conEnsayo == 'on' or $conEnsayo == ''){?>
											<option selected 	value="on" >Si</option>
											<option 			value='off'>No</option>
										<?php }else{ ?>
											<option 	 		value="on" >Si</option>
											<option selected 	value='off'>No</option>
										<?php } ?>
                              		</select>
								</td>
							</tr>
						</table>
				</tr>
						    <tr>
								<td colspan="5" valign="top">
									  <table align="center" width="95%" style="border:1px solid #ccc;">
										  <tr bordercolor="#003366" bgcolor="#999999">
										    <td rowspan="2"><div align="center" class="Estilo2">Ensayos</div></td>
										    <td rowspan="2"><span>Cant.</span></td>
										    <td rowspan="2"><div align="center">Escala</div></td>
										    <td colspan="4" align="center">Dureza</td>
										    <td height="20" colspan="2" align="center">Charpy</td>
										    <td>&nbsp;</td>
									    </tr>
										  <tr bordercolor="#003366" bgcolor="#999999">
										    <td align="center">Tipo<br>Ensayo </td>
											  <td align="center">Distancia<br>Perfil </td>
											  <td align="center">Separaci&oacute;n</td>
											  <td align="center">Indentaciones</td>
											  <td height="20" align="center"><span>Impactos</span></td>
									      	  <td align="center"><span>T掳</span></td>
									      	  <td><span>Ref</span>.</td>
									 	  </tr>
										  <?PHP
											$SQL = "SELECT * FROM amEnsayos Order By nEns";
											$bdEns=mysql_query($SQL);
											if($rowEns=mysql_fetch_array($bdEns)){
												do{?>
													  <tr>
														  	<td>
														  		<?php
																		echo $rowEns['Ensayo']; 
																?>
															</td>
														  	<td>
															  <?php
															//$Otams = $RAM.'-'.$rowEns['Suf'];
															$Otams = $idItem.'-'.$rowEns['Suf'];
															$nEnsayos = '';
															//$sql 		= "SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otams."%'";  // sentencia sql
															$sql 		= "SELECT * FROM OTAMs Where idItem = '".$idItem."' and idEnsayo = '".$rowEns['idEnsayo']."'";  // sentencia sql
															$result 	= mysql_query($sql);
															$nEnsayos 	= mysql_num_rows($result); // obtenemos el n鷐ero de Otams Traccion
															
															$nEns = 'nEnsayos-'.$idItem.'-'.$rowEns['Suf'];
															
															?>
										  					  <input type="number" name="<?php echo $nEns; ?>" id="nEns"  min="0" max="99" value="<?php echo $nEnsayos; ?>">
														  </td>
														  <td>
															  <?php if($rowEns['Status'] == 'on'){?>
																  <?php $tpMu = 'tpMuestra-'.$idItem.'-'.$rowEns['Suf']; ?>
																  <select name="<?php echo $tpMu; ?>">
																	  <option></option>
																	  <?php
																		$idEnsayo 		= $rowEns['idEnsayo'];
																		$tpMuestra 		= '';
																		$tpMedicion		= '';
																		$distanciaMax	= '';
																		$separacion		= '';
																		$sql = "SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otams."%'";  // sentencia sql
																		$bdTm=mysql_query($sql);
																		if($rowTm=mysql_fetch_array($bdTm)){
																			$tpMuestra 		= $rowTm['tpMuestra'];
																		}
																	
																		$SQL = "SELECT * FROM amTpsMuestras Where idEnsayo = '".$idEnsayo."'";
																		$bdTm=mysql_query($SQL);
																		if($rowTm=mysql_fetch_array($bdTm)){
																			do{?>
																				  <?php if($tpMuestra == $rowTm['tpMuestra']){?>
																						  <option selected 	value="<?php echo $rowTm['tpMuestra']; ?>"><?php echo $rowTm['Muestra']; ?></option>
																				  <?php }else{ ?>
																						  <option  			value="<?php echo $rowTm['tpMuestra']; ?>"><?php echo $rowTm['Muestra']; ?></option>
																				  <?php }
																			}while($rowTm=mysql_fetch_array($bdTm));
																		}
																	?>
																  </select>
															  <?php
															}
															?>
														  </td>
														  	<td>
															 <?php 
																$tpMedicion = '';
																$tpMed = 'tpMedicion-'.$idItem.'-'.$rowEns['Suf'];
																$sql = "SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otams."%'";  // sentencia sql
																$bdTm=mysql_query($sql);
																if($rowTm=mysql_fetch_array($bdTm)){
																	$tpMedicion = $rowTm['tpMedicion'];
																}
																if($rowEns['idEnsayo'] == 'Du'){?>
																	<select name="<?php echo $tpMed; ?>">
																   		<option></option>
																		<?php if($tpMedicion == 'Medi'){?>
																			<option selected 	value="Medi">Medici贸n 	</option>
																			<option 			value="Perf">Perfil 	</option>
																		<?php } ?>
																		<?php if($tpMedicion == 'Perf'){?>
																			<option  			value="Medi">Medici贸n 	</option>
																			<option selected 	value="Perf">Perfil 	</option>
																		<?php } ?>
																		<?php if($tpMedicion == ''){?>
																			<option  			value="Medi">Medici贸n 	</option>
																			<option  		value="Perf">Perfil 	</option>
																		<?php } ?>
																 	</select>
                                                            	<?php
																}
																if($rowEns['idEnsayo'] == 'PD'){?>
																	<select name="<?php echo $tpMed; ?>">
																   		<option></option>
																		<?php if($tpMedicion == 'Medi'){?>
																			<option 			value="Perf">Perfil 	</option>
																		<?php } ?>
																		<?php if($tpMedicion == 'Perf'){?>
																			<option selected 	value="Perf">Perfil 	</option>
																		<?php } ?>
																		<?php if($tpMedicion == ''){?>
																			<option  			value="Perf">Perfil 	</option>
																		<?php } ?>
																 	</select>
                                                            	<?php
																}
																?>
														  	</td>
														  	<td>
															 <?php 
																$disMax = 'distanciaMax-'.$idItem.'-'.$rowEns['Suf'];
																$sql = "SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otams."%'";  // sentencia sql
																$bdTm=mysql_query($sql);
																if($rowTm=mysql_fetch_array($bdTm)){
																	$distanciaMax = $rowTm['distanciaMax'];
																}
																if($rowEns['idEnsayo'] == 'PD'){?>
                                                            		<input name="<?php echo $disMax; ?>" type="text" id="<?php echo $disMax; ?>" maxlength="4" size="4" value="<?php echo $distanciaMax;?>">
                                                            	<?php
																}
															?>
															</td>
														  	<td>
															 <?php 
																$separa = 'separacion-'.$idItem.'-'.$rowEns['Suf'];
																$sql = "SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otams."%'";  // sentencia sql
																$bdTm=mysql_query($sql);
																if($rowTm=mysql_fetch_array($bdTm)){
																	$separacion = $rowTm['separacion'];
																}
																if($rowEns['idEnsayo'] == 'PD'){?>
																	<input type="text" name="<?php echo $separa; ?>" id="<?php echo $separa; ?>" maxlength="5" size="5" value="<?php echo $separacion; ?>">
                                                            	<?php
																}
															?>
														  	</td>
														  	<td>
															 <?php 
															 	$Ind = 0;
																if($rowEns['idEnsayo'] == 'Du' or $rowEns['idEnsayo'] == 'PD'){
																  	$nInd = 'Ind-'.$idItem.'-'.$rowEns['Suf'];
																	$sql = "SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otams."%'";  // sentencia sql
																	$bdTm=mysql_query($sql);
																	if($rowTm=mysql_fetch_array($bdTm)){
																		$Ind = $rowTm['Ind'];
																	}
																	?>
																	<input type="text" name="<?php echo $nInd; ?>" id="<?php echo $nInd; ?>" maxlength="5" size="5" value="<?php echo $Ind; ?>">
                                                            	<?php
																}
															?>
															</td>
														  	<td>
															  <?php 
															  	$Ind = 0;
																if($rowEns['idEnsayo'] == 'Ch'){
																  	$nInd = 'Ind-'.$idItem.'-'.$rowEns['Suf'];
																	$sql = "SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otams."%'";  // sentencia sql
																	$bdTm=mysql_query($sql);
																	if($rowTm=mysql_fetch_array($bdTm)){
																		$Ind = $rowTm['Ind'];
																	}
																	?>
																		<input type="text" name="<?php echo $nInd; ?>" id="<?php echo $nInd; ?>" maxlength="5" size="5" value="<?php echo $Ind; ?>">
																	<?php 
																}
															?>
														  </td>
														  <td>
															  <?php 
															  	$Tem = '';
																if($rowEns['idEnsayo'] == 'Ch'){
																  	$nTem = 'Tem-'.$idItem.'-'.$rowEns['Suf'];
																	$sql = "SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otams."%'";  // sentencia sql
																	$bdTm=mysql_query($sql);
																	if($rowTm=mysql_fetch_array($bdTm)){
																		$Tem = $rowTm['Tem'];
																	}
																	?>
																		<input type="text" name="<?php echo $nTem; ?>" id="<?php echo $nTem; ?>" maxlength="10" size="10" value="<?php echo $Tem; ?>">
																	<?php 
																}
															?>
														  </td>
														  <td>
															  <?php if($rowEns['Status'] == 'on'){?>
																  <?php $vRef = 'Ref-'.$idItem.'-'.$rowEns['Suf']; ?>
																  <select name="<?php echo $vRef; ?>">
																	  <?php
																		$SQL = "SELECT * FROM amTabEnsayos Where idItem = '".$idItem."' and idEnsayo = '".$rowEns['idEnsayo']."'";
																		$bdTe=mysql_query($SQL);
																		if($rowTe=mysql_fetch_array($bdTe)){
																			if($rowTe['Ref'] == 'SR'){?>
																				  <option selected 	value="SR">SR</option>
																				  <option  			value="CR">CR</option>
																				  <?php 
																			}else{
																				if($rowTe['Ref'] == 'CR'){?>
																					  <option selected 	value="CR">CR</option>
																					  <option  			value="SR">SR</option>
																					  <?php 
																				}else{?>
																					  <option></option>
																					  <option 		 	value="SR">SR</option>
																					  <option  			value="CR">CR</option>
																					  <?php
																				}
																			}
																		}else{?>
																				  <option></option>
																				  <option 		 	value="SR">SR</option>
																				  <option  			value="CR">CR</option>
																		  <?php
																		}
																	?>
																  </select>
															  <?php } ?>
														  </td>
													  </tr>
												  <?php
												}while($rowEns=mysql_fetch_array($bdEns));
											}
											?>
					  		          </table></td>
						  	</tr>
						</table>
					</td>
				</tr>
		  		<tr>
					<td colspan="3" height="50" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px; ">
					<?php
						if($guardar  == 0){
							$guardar++;
							echo $accion;
							if($accion == 'Guardar' || $accion == 'Editar' || $accion == 'Actualizar'){?>
								<div id="botonImagen">
									<button name="guardarIdMuestra222" style="float:right;" title="Guardar Muestras Mantenci贸n">
										<img src="../gastos/imagenes/guardar.png" width="55" height="55">
									</button>
								</div>
								<?php
							}
							if($accion == 'Borrar'){?>
								<button name="confirmarBorrar2" style="float:right;">
									<img src="../gastos/imagenes/inspektion.png" width="55" height="55">
								</button>
								<?php
							}
						}
					?>
					</td>
		  		</tr>
		</table>
		<?php
		}while($rowMu=mysql_fetch_array($bdMu));
	}
	mysql_close($link);
	?>
