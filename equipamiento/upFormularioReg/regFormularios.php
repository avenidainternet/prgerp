			<?php 
				$fechaHoy = date('Y-m-d'); 
				$fd = explode('-', $fechaHoy);
			?>
			<table width="80%" align="center"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax" style="margin-top:10px;">
				<tr>
				  	<td colspan="4" class="lineaDerBot" align="center">
					  	<strong style=" font-size:20px; font-weight:700; margin-left:10px;">
							Subir Registro Formularios de equipo "<?php echo $nomEquipo; ?>"
							<input name="nDocGes" 				id="nDocGes" 			type="hidden" value="<?php echo $nDocGes; 			?>">
							<input name="accion" 				id="accion" 			type="hidden" value="<?php echo $accion; 			?>">
							<input name="fechaVerificacion"		id="fechaVerificacion"	type="hidden" value="<?php echo $fechaVerificacion; ?>">
						</strong>										
					</td>
			  	</tr>
				<tr>
					<td width="20%">Registro de Calibraciones
					</td>
					<td>
						<?php
							$link=Conectarse();
							$sql = "SELECT * FROM equiposForm Where nSerie = '".$nDocGes."' and AccionEquipo = 'Cal'";
							$bdEnc=$link->query($sql);
							if($row=mysqli_fetch_array($bdEnc)){
								do{
									echo '<ul>';
									$sqleq = "SELECT * FROM equipos Where nSerie = '".$row['nSerie']."'";
									$bdeq=$link->query($sqleq);
									if($roweq=mysqli_fetch_array($bdeq)){
										$sqleh = "SELECT * FROM equiposhistorial Where nSerie = '".$row['nSerie']."' Order by fechaAccion Desc";
										$bdeh=$link->query($sqleh);
										if($roweh=mysqli_fetch_array($bdeh)){
											$fichero = $roweh['pdf'];
											$directorioPOC='../../archivo/';
											$directorioPOC=$directorioPOC.$roweq['Referencia'].'/Registros/'.$fichero;
											$directorioAAA='y:/AAA/Documentos/'.$roweq['Referencia'].'/Registros/'.$fichero;

											if(file_exists($directorioPOC)){
												if($fichero){
													echo '<a href="'.$directorioPOC.'" target="_blank" class="btn btn-info">Descargar PDF</a> <br>';
												}
											}
										}
									}

									$SQLd = "SELECT * FROM docformpoc Where Formulario = '".$row['Formulario']."'";
									$bdDoc=$link->query($SQLd);
									if($rowDoc=mysqli_fetch_array($bdDoc)){
										$host = 'servidorerp';
										$host = 'http://'.$host.'/erp/archivo/POC-'.substr($row['Formulario'],0,2).'/Formularios/'.$rowDoc['pdf'];
										echo '<a style="margin:10px;" href="'.$host.'" target="_blank"><img src="../../imagenes/pdf_download.png" width="40px" title="Descargar Formulario '.$rowDoc['pdf'].'"></a>';
										echo $rowDoc['pdf'];
										$nForm = 'FCal'.$row['Formulario'];
									}						
									$nForm = 'FCal'.$row['Formulario'];
									?>
									<input type="hidden" name="MAX_FILE_SIZE" value="20480000"> 
									<input style="margin:10px;" name="<?php echo $nForm; ?>" type="file" id="<?php echo $nForm; ?>">
									</ul>
									<?php
								}while ($row=mysqli_fetch_array($bdEnc));
							}
							$link->close();
						?>
						
					</td>
				</tr>
				<tr>
					<td width="20%" style="border-top:1px dotted #ccc; background-color: #f7f7f7;">
						<b>Registro de Verificaciones</b>
					</td>
					<td  style="border-top:1px dotted #ccc; background-color: #f7f7f7;">
						<?php
							$host = gethostname();
							echo $host;
							$link=Conectarse();
							$sql = "SELECT * FROM equiposForm Where nSerie = '".$nDocGes."' and AccionEquipo = 'Ver'";
							$bdEnc=$link->query($sql);
							if($row=mysqli_fetch_array($bdEnc)){
								do{
									echo '<ul>';
									$sqleq = "SELECT * FROM equipos Where nSerie = '".$row['nSerie']."'";
									$bdeq=$link->query($sqleq);
									if($roweq=mysqli_fetch_array($bdeq)){
										$sqleh = "SELECT * FROM equiposhistorial Where nSerie = '".$row['nSerie']."' Order by fechaAccion Desc";
										$bdeh=$link->query($sqleh);
										if($roweh=mysqli_fetch_array($bdeh)){
											$fichero = $roweh['pdf'];
											$directorioPOC='../../archivo/';
											$directorioPOC=$directorioPOC.$roweq['Referencia'].'/Registros/'.$fichero;
											$directorioAAA='y:/AAA/Documentos/'.$roweq['Referencia'].'/Registros/'.$fichero;

											if(file_exists($directorioPOC)){
												if($fichero){
													echo '<a href="'.$directorioPOC.'" target="_blank" class="btn btn-info">Descargar PDF</a> <br>';
												}
											}
										}
									}
		
			
									$SQLd = "SELECT * FROM docformpoc Where Formulario = '".$row['Formulario']."'";
									$bdDoc=$link->query($SQLd);
									if($rowDoc=mysqli_fetch_array($bdDoc)){
										if(gethostname() == 'servidordata'){
											$host = 'servidorerp';
										}
										$host = 'servidorerp';
										$host = 'http://'.$host.'/erp/archivo/POC-'.substr($row['Formulario'],0,2).'/Formularios/'.$rowDoc['pdf'];
										
										echo '<a style="margin:10px;" href="'.$host.'" target="_blank"><img src="../../imagenes/pdf_download.png" width="40px" title="Descargar Formulario '.$rowDoc['pdf'].'"></a>';
										
										//echo '<a style="margin:10px;" href="../../archivo/POC-'.substr($row['Formulario'],0,2).'/Formularios/'.$rowDoc['pdf'].'" target="_blank"><img src="../../imagenes/pdf_download.png" width="40px" title="Descargar Formulario '.$rowDoc['pdf'].'"></a>';
										echo $rowDoc['pdf'];
										$nForm = 'FVer'.$row['Formulario'];
									}
									$nForm = 'FVer'.$row['Formulario'];
				
									?>
									<input type="hidden" name="MAX_FILE_SIZE" value="20480000"> 
									<input style="margin:10px;" name="<?php echo $nForm; ?>" type="file" id="<?php echo $nForm; ?>">
									<?php echo 'Formulario '.$nForm; ?>
									</ul>
									<?php
								}while ($row=mysqli_fetch_array($bdEnc));
							}
							$link->close();
						?>
					</td>
				</tr>
				<tr>
					<td width="20%"  style="border-top:1px dotted #ccc;">Registro de Mantenciones
					</td>
					<td  style="border-top:1px dotted #ccc;">
						<?php
							$link=Conectarse();
							$sql = "SELECT * FROM equiposForm Where nSerie = '".$nDocGes."' and AccionEquipo = 'Man'";
							$bdEnc=$link->query($sql);
							if($row=mysqli_fetch_array($bdEnc)){
								do{
									echo '<ul>';
									$sqleq = "SELECT * FROM equipos Where nSerie = '".$row['nSerie']."'"; 
									$bdeq=$link->query($sqleq);
									if($roweq=mysqli_fetch_array($bdeq)){
										$sqleh = "SELECT * FROM equiposhistorial Where nSerie = '".$row['nSerie']."' Order by fechaAccion Desc";
										$bdeh=$link->query($sqleh);
										if($roweh=mysqli_fetch_array($bdeh)){
											$fichero = $roweh['pdf'];
											$directorioPOC='../../archivo/';
											$directorioPOC=$directorioPOC.$roweq['Referencia'].'/Registros/'.$fichero;
											$directorioAAA='y:/AAA/Documentos/'.$roweq['Referencia'].'/Registros/'.$fichero;

											if(file_exists($directorioPOC)){
												if($fichero){
													echo '<a href="'.$directorioPOC.'" target="_blank" class="btn btn-info">Descargar PDF</a> <br>';
												}
											}
										}
									}

									$SQLd = "SELECT * FROM docformpoc Where Formulario = '".$row['Formulario']."'";
									$bdDoc=$link->query($SQLd);
									if($rowDoc=mysqli_fetch_array($bdDoc)){
										$host = 'servidorerp';
										$host = 'http://'.$host.'/erp/archivo/POC-'.substr($row['Formulario'],0,2).'/Formularios/'.$rowDoc['pdf'];
										echo '<a style="margin:10px;" href="'.$host.'" target="_blank"><img src="../../imagenes/pdf_download.png" width="40px" title="Descargar Formulario '.$rowDoc['pdf'].'"></a>';
										echo $rowDoc['pdf'];
										$nForm = 'FMan'.$row['Formulario'];
									}						
									$nForm = 'FMan'.$row['Formulario'];
									?>
									<input type="hidden" name="MAX_FILE_SIZE" value="20480000"> 
									<input style="margin:10px;" class="form-control" name="<?php echo $nForm; ?>" type="file" id="<?php echo $nForm; ?>">
									</ul>
									<?php
								}while ($row=mysqli_fetch_array($bdEnc));
							}
							$link->close();
						?>
					</td>
				</tr>
				<tr>
					<td>
							<HR>
						<button name="upFormularios" type="button" class="btn btn-primary">
							SUBIR FORMULARIO
						</button>

					</td>
				</tr>
			</table>
