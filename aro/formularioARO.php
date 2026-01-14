<?php 	

	$Rev 				= 0;
	$accFechaTen 		= '0000-00-00';
	$accFechaApli 		= '0000-00-00';
	$accFechaImp 		= '0000-00-00';
	$fechaCierre 		= '0000-00-00';
	$fteAutFecha 		= '0000-00-00';
	$oriLeyRegFecha 	= '0000-00-00';
	$fteAudIntFecha 	= '0000-00-00';
	$oriTncFecha 		= '0000-00-00';
	$fteAudExtFecha 	= '0000-00-00';
	$oriInterLabFecha 	= '0000-00-00';
	$verResAccCorr		= '';
	$accAccionCorrectiva= '';
	$accCorrecion		= '';
	$Causa				= '';
	$desEvidencia		= '';
	$desHallazgo		= '';
	$desIdentificacion	= '';
	$fteOtrosTxt 		= '';
	$oriOtrosTxt 		= '';
	$usr 				= '';
	$usrResponsable 	= '';
	$usuario 			= '';
	$usrCalidad 		= '';
	$fteRecCliExt 		= '';
	$fteNroRecCliExt	= '';
	$fteRecCliInt 		= '';
	$oriEnsayos 		= '';
	$fteAut 			= '';
	$oriLeyReg 			= '';
	$fteAudInt 			= '';
	$oriTnc 			= '';
	$fteAudExt 			= '';
	$oriInterLab 		= '';
	$fteOtros 			= '';
	$oriOtros 			= '';
	$desClasNoConf 		= '';
	$desClasObs 		= '';
	$fteNroRecCliInt 	= 0;
	$oriNroAso 			= 0;
	$oriSisGes 			= '';
	$oriSisGesFecha 	= '0000-00-00';
	$nInformePreventiva	= 0;
	$verCierreAccion	= '';
		
	if(isset($_GET['nInformePreventiva'])) 	{ $nInformePreventiva 	= $_GET['nInformePreventiva'];	}
	if(isset($_GET['accion'])) 				{ $accion 				= $_GET['accion'];				}
	
	$fechaApertura 		= date('Y-m-d');
	$encNew = 'Si';
	if($nInformePreventiva == 0){
		$link=Conectarse();
		$bddCot=$link->query("Select * From accionesPreventivas Order By nInformePreventiva Desc");
		if($rowdCot=mysqli_fetch_array($bddCot)){
			$nInformePreventiva = $rowdCot['nInformePreventiva'] + 1;
		}else{
			$nInformePreventiva = 1;
		}
		$link->close();
	}else{
		$link=Conectarse();
		$bdCot=$link->query("SELECT * FROM accionesPreventivas Where nInformePreventiva = '".$nInformePreventiva."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$fechaApertura			= $rowCot['fechaApertura'];
			$usrApertura			= $rowCot['usrApertura'];
			$fteRecCliExt			= $rowCot['fteRecCliExt'];
			$fteNroRecCliExt		= $rowCot['fteNroRecCliExt'];
			$fteRecCliInt			= $rowCot['fteRecCliInt'];
			$fteNroRecCliInt		= $rowCot['fteNroRecCliInt'];
			$fteAut					= $rowCot['fteAut'];
			$fteAutFecha			= $rowCot['fteAutFecha'];
			$fteAudInt				= $rowCot['fteAudInt'];
			$fteAudIntFecha			= $rowCot['fteAudIntFecha'];
			$fteAudExt				= $rowCot['fteAudExt'];
			$fteAudExtFecha			= $rowCot['fteAudExtFecha'];
			$fteOtros				= $rowCot['fteOtros'];
			$fteOtrosTxt			= $rowCot['fteOtrosTxt'];
			$oriSisGes				= $rowCot['oriSisGes'];
			$oriSisGesFecha			= $rowCot['oriSisGesFecha'];
			$oriEnsayos				= $rowCot['oriEnsayos'];
			$oriNroAso				= $rowCot['oriNroAso'];
			$oriLeyReg				= $rowCot['oriLeyReg'];
			$oriLeyRegFecha			= $rowCot['oriLeyRegFecha'];
			$oriTnc					= $rowCot['oriTnc'];
			$oriTncFecha			= $rowCot['oriTncFecha'];
			$oriInterLab			= $rowCot['oriInterLab'];
			$oriInterLabFecha		= $rowCot['oriInterLabFecha'];
			$oriOtros				= $rowCot['oriOtros'];
			$oriOtrosTxt			= $rowCot['oriOtrosTxt'];
			$desClasNoConf			= $rowCot['desClasNoConf'];
			$desClasObs				= $rowCot['desClasObs'];
			$desIdentificacion		= $rowCot['desIdentificacion'];
			$desHallazgo			= $rowCot['desHallazgo'];
			$desEvidencia			= $rowCot['desEvidencia'];
			$Causa					= $rowCot['Causa'];
			$accCorrecion			= $rowCot['accCorrecion'];
			$accAccionCorrectiva	= $rowCot['accAccionCorrectiva'];
			$accFechaImp			= $rowCot['accFechaImp'];
			$accFechaTen			= $rowCot['accFechaTen'];
			$accFechaApli			= $rowCot['accFechaApli'];
			$accFechaVer			= $rowCot['accFechaVer'];
			$verResAccCorr			= $rowCot['verResAccCorr'];
			$usrEncargado			= $rowCot['usrEncargado'];
			$usrCalidad				= $rowCot['usrCalidad'];
			$usrResponsable		 	= $rowCot['usrResponsable'];
			$fechaCierre			= $rowCot['fechaCierre'];
			$verCierreAccion		= $rowCot['verCierreAccion'];
			$resultado				= $rowCot['resultado'];
		}
		$link->close();
		$encNew = 'No';
	}
?>


<form name="form" action="accionesPreventivas.php" method="post">
<div class="row">
    <div class="col-lg-12">
    	<div class="card">
            <div class="card-header">
            	Formulario Acción de riesgo y oportunidades (ARO)
            </div>
            <div class="card-body">
				
					<table class="table table-bordered">
						<tbody>
						<tr>
							<td colspan="5" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">

								<img src="../imagenes/about_us_close_128.png" width="50" align="middle">
								<span style="color:#FFFFFF; font-size:25px; font-weight:700;">
									Formulario Acción de riesgo y oportunidades (ARO) 
									<div id="botonImagen">
										<?php 
											$prgLink = 'accionesPreventivas.php';
											echo '<a href="'.$prgLink.'" style="float:right;"><img src="../imagenes/no_32.png"></a>';
										?>
									</div>
								</span>
							</td>
						</tr>
						<tr>
						  <td colspan="3" rowspan="2" class="lineaDerBot">
						  	<strong style=" font-size:20px; font-weight:700; margin-left:10px;">
								Informe Acción N° 
								<?php
									if($accion == 'Actualizar' or $accion == 'Borrar'){ 
										echo $nInformePreventiva;?>
										<input name="nInformePreventiva" 	id="nInformePreventiva" type="hidden" value="<?php echo $nInformePreventiva; ?>" size="7" maxlength="7" style="font-size:18px; font-weight:700;" />
										<?php
									}
									if($accion == ''){ 
										?>
										<input name="nInformePreventiva" 	id="nInformePreventiva" type="text" value="<?php echo $nInformePreventiva; ?>" size="7" maxlength="7" style="font-size:18px; font-weight:700;" autofocus />
										<?php
									}
								?>
								<input name="accion" 				id="accion" 			type="hidden" value="<?php echo $accion; ?>">
							</strong>
						  </td>
						  <td colspan="2" align="center" class="lineaBot">Fechas de Control </td>
					  </tr>
					  <tr>
							<td width="13%" align="center" class="lineaDerBot">
								Tentativa
							</td>
						    <td width="19%" align="center" class="lineaDerBot">
								Verificaci&oacute;n Real </td>
						</tr>
						<tr>
							<td width="19%">Fecha Apertura Acci&oacute;n </td>
							<td class="lineaDer">Responzable Implementaci&oacute;n Acci&oacute;n:
							</td>
						    <td class="lineaDer">Encargado de Calidad: </td>
						    <td class="lineaBot" align="center">
							  	<input name="accFechaTen" id="accFechaTen" type="date"  value="<?php echo $accFechaTen; ?>" style="font-size:12px; font-weight:700;">
							</td>
						    <td class="lineaBot" align="center">
							  	<input name="accFechaApli" id="accFechaApli" type="date"  value="<?php echo $accFechaApli; ?>" style="font-size:12px; font-weight:700;">
							</td>
						</tr>
						<tr>
							<td rowspan="2" class="lineaDerBot">
						    	<input name="fechaApertura" id="fechaApertura" type="date"  value="<?php echo $fechaApertura; ?>" style="font-size:12px; font-weight:700;" autofocus />
							</td>
						  	<td rowspan="2" class="lineaDerBot">
						  		<select name="usrResponsable" id="usrResponsable" style="font-size:12px; font-weight:700;">
			                	<?php
									$link=Conectarse();
									$bdCli=$link->query("SELECT * FROM Usuarios Order By usuario");
									if($rowCli=mysqli_fetch_array($bdCli)){
										do{
											$loginRes = $rowCli['usr'];
											//if($usrResponsable == $loginRes){
											if($rowCli['usr'] == $_SESSION['usr']){
												echo '<option selected 	value='.$rowCli['usr'].'>'.$rowCli['usuario'].'</option>';
											}else{
												echo '<option 			value='.$rowCli['usr'].'>'.$rowCli['usuario'].'</option>';
											}
										}while ($rowCli=mysqli_fetch_array($bdCli));
									}
									$link->close();
									?>
			              	</select>			  
						  </td>
						    <td rowspan="2" class="lineaDerBot">
							<select name="usrCalidad" id="usrCalidad" style="font-size:12px; font-weight:700;">
			                  <?php
									$link=Conectarse();
									$bdCli=$link->query("SELECT * FROM Usuarios Order By usuario");
									if($rowCli=mysqli_fetch_array($bdCli)){
										do{
											$loginRes = $rowCli['usr'];
											//if($usrCalidad == $loginRes){
											if($rowCli['usr'] == $_SESSION['usr']){
												echo '<option selected 	value='.$rowCli['usr'].'>'.$rowCli['usuario'].'</option>';
											}else{
												echo '<option 			value='.$rowCli['usr'].'>'.$rowCli['usuario'].'</option>';
											}
										}while ($rowCli=mysqli_fetch_array($bdCli));
									}
									$link->close();
									?>
			                </select></td>
					      <td class="lineaDerBot" align="center">Implementaci&oacute;n</td>
						  <td class="lineaDerBot" align="center">Fecha de Cierre</td>
					  </tr>
						<tr>
							<td class="lineaBot" align="center">
							  <input name="accFechaImp" id="accFechaImp" type="date"  value="<?php echo $accFechaImp; ?>" style="font-size:12px; font-weight:700;">
							</td>
					        <td class="lineaBot" align="center">
					          <input name="fechaCierre" id="fechaCierre" type="date"  value="<?php echo $fechaCierre; ?>" style="font-size:12px; font-weight:700;">
					        </td>
						</tr>
						<tr>
						  <td colspan="5" class="lineaDerBot">
						  		<table cellpadding="0" cellspacing="0" width="100%" style="border: 1px solid #000;">
									<tr height="30" bgcolor="#0099CC" style="color:#000000; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px; font-weight:700;">
										<td width="50%" colspan="2">1. Fuente </td>
										<td width="50%" colspan="2">2. Origen </td>
									</tr>
									<tr>
									  	<td>
									  	<?php
										if($fteRecCliExt=='on'){?>
											<input type="checkbox" name="fteRecCliExt" checked>
										<?php }else{ ?>
											<input type="checkbox" name="fteRecCliExt">
										<?php } ?>
										
									  	Reclamo de Cliente Externo	
									  	</td>
									  	<td class="lineaDer">
										N&deg; Reclamo 
									  	<input name="fteNroRecCliExt" id="fteNroRecCliExt" type="text" size="10" maxlength="10" value="<?php echo $fteNroRecCliExt; ?>" style="font-size:12px; font-weight:700;" />
									  	</td>
									  	<td>
									  	<?php
										if($oriSisGes=='on'){?>
											<input type="checkbox" name="oriSisGes" checked>
										<?php }else{ ?>
											<input type="checkbox" name="oriSisGes">
										<?php } ?>
										
									  	Sistema	de Gesti&oacute;n 
									  	</td>
								      	<td>
										Fecha
									  	<input name="oriSisGesFecha" id="oriSisGesFecha" type="date" value="<?php echo $oriSisGesFecha; ?>" style="font-size:12px; font-weight:700;" />
									  	</td>
								  	</tr>

								  	<tr>
										<td>
											<?php
											if($fteRecCliInt=='on'){?>
												<input type="checkbox" name="fteRecCliInt" checked>
											<?php }else{ ?>
												<input type="checkbox" name="fteRecCliInt">
											<?php } ?>
											
											Reclamo de Cliente Interno </td>
											<td class="lineaDer">
											N&deg; Reclamo 
											<input name="fteNroRecCliInt" id="fteNroRecCliInt" type="text" size="10" maxlength="10" value="<?php echo $fteNroRecCliInt; ?>" style="font-size:12px; font-weight:700;" />
									  	</td>
									  	<td>
											<?php
											if($oriEnsayos=='on'){?>
												<input type="checkbox" name="oriEnsayos" checked>
											<?php }else{ ?>
												<input type="checkbox" name="oriEnsayos">
											<?php } ?>
											Ensayos
										</td>
								      	<td>
											N&deg; Asociado
											<input name="oriNroAso" id="oriNroAso" type="text" size="10" maxlength="10" value="<?php echo $oriNroAso; ?>" style="font-size:12px; font-weight:700;" />
									  	</td>
									</tr>

								  	<tr>
										<td>
											<?php
											if($fteAut=='on'){?>
												<input type="checkbox" name="fteAut" checked>
											<?php }else{ ?>
												<input type="checkbox" name="fteAut">
											<?php } ?>
											
											Autodetectada
										</td>
										<td class="lineaDer">
											Fecha
											<input name="fteAutFecha" id="fteAutFecha" type="date" size="10" maxlength="10" value="<?php echo $fteAutFecha; ?>" style="font-size:12px; font-weight:700;" />
									  	</td>
									  	<td>
											<?php
											if($oriLeyReg=='on'){?>
												<input type="checkbox" name="oriLeyReg" checked>
											<?php }else{ ?>
												<input type="checkbox" name="oriLeyReg">
											<?php } ?>
											Leyes / Reglamentos
										</td>
								      	<td>
											Fecha
											<input name="oriLeyRegFecha" id="oriLeyRegFecha" type="date" value="<?php echo $oriLeyRegFecha; ?>" style="font-size:12px; font-weight:700;" />
										</td>
									</tr>

								  	<tr>
										<td>
											<?php
											if($fteAudInt=='on'){?>
												<input type="checkbox" name="fteAudInt" checked>
											<?php }else{ ?>
												<input type="checkbox" name="fteAudInt">
											<?php } ?>
											
											Auditoría Interna
										</td>
										<td class="lineaDer">
											Fecha
											<input name="fteAudIntFecha" id="fteAudIntFecha" type="date" value="<?php echo $fteAudIntFecha; ?>" style="font-size:12px; font-weight:700;" />
									  	</td>
									  	<td>
											<?php
											if($oriTnc=='on'){?>
												<input type="checkbox" name="oriTnc" checked>
											<?php }else{ ?>
												<input type="checkbox" name="oriTnc">
											<?php } ?>
											TNC
										</td>
								      	<td>
											Fecha
											<input name="oriTncFecha" id="oriTncFecha" type="date" value="<?php echo $oriTncFecha; ?>" style="font-size:12px; font-weight:700;" />
										</td>
									</tr>

								  	<tr>
										<td>
											<?php
											if($fteAudExt=='on'){?>
												<input type="checkbox" name="fteAudExt" checked>
											<?php }else{ ?>
												<input type="checkbox" name="fteAudExt">
											<?php } ?>
											
											Auditoría Externa
										</td>
										<td class="lineaDer">
											Fecha
											<input name="fteAudExtFecha" id="fteAudExtFecha" type="date" value="<?php echo $fteAudExtFecha; ?>" style="font-size:12px; font-weight:700;" />
									  	</td>
									  	<td>
											<?php
											if($oriInterLab=='on'){?>
												<input type="checkbox" name="oriInterLab" checked>
											<?php }else{ ?>
												<input type="checkbox" name="oriInterLab">
											<?php } ?>
											Interlaboratorios
										</td>
								      	<td>
											Fecha
											<input name="oriInterLabFecha" id="oriInterLabFecha" type="date" value="<?php echo $oriInterLabFecha; ?>" style="font-size:12px; font-weight:700;" />
										</td>
									</tr>

								  	<tr>
										<td colspan="2" class="lineaDer">
											<?php
											if($fteOtros=='on'){?>
												<input type="checkbox" name="fteOtros" checked>
											<?php }else{ ?>
												<input type="checkbox" name="fteOtros">
											<?php } ?>
											Otros
											<input name="fteOtrosTxt" id="fteOtrosTxt" type="text" size="50" maxlength="50" value="<?php echo $fteOtrosTxt; ?>" style="font-size:12px; font-weight:700;" />
									  	</td>
										<td colspan="2">
											<?php
											if($oriOtros=='on'){?>
												<input type="checkbox" name="oriOtros" checked>
											<?php }else{ ?>
												<input type="checkbox" name="oriOtros">
											<?php } ?>
											Otros
											<input name="oriOtrosTxt" id="oriOtrosTxt" type="text" size="50" maxlength="50" value="<?php echo $oriOtrosTxt; ?>" style="font-size:12px; font-weight:700;" />
										</td>
									</tr>

									<tr height="30" bgcolor="#0099CC" style="color:#000000; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px; font-weight:700;">
										<td colspan="4">3. Descripción del ARO </td>
									</tr>
									<tr>
										<td colspan="4">
										  <label for="desIdentificacion">
										  	a)  Identificación del requerimiento normativo, legal o reglamentario afectado:
										  </label>
										  <textarea name="desIdentificacion" class="form-control" rows="5" id="desIdentificacion"><?php echo $desIdentificacion; ?></textarea>											
										</td>
									</tr>
									<tr>
										<td colspan="4">
										  	<label for="desHallazgo">
												b)  Hallazgo detectado:
											</label>
											 <textarea name="desHallazgo" class="form-control" rows="5" id="desHallazgo"><?php echo $desHallazgo; ?></textarea>
										</td>
									</tr>
									<tr>
										<td colspan="4">
											<label for="desEvidencia">
												c)  Evidencia objetiva:
											</label>
											  <textarea name="desEvidencia" class="form-control" id="desEvidencia" rows="5"><?php echo $desEvidencia; ?></textarea>
										</td>
									</tr>

									<tr height="30" bgcolor="#0099CC" style="color:#000000; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px; font-weight:700;">
										<td colspan="4">4. Causa raíz: </td>
									</tr>
									<tr>
										<td colspan="4">
											<textarea name="Causa" class="form-control" rows="5" id="Causa"><?php echo $Causa; ?></textarea>
										</td>
									</tr>

									<tr height="30" bgcolor="#0099CC" style="color:#000000; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px; font-weight:700;">
										<td colspan="4">5. Acciones: </td>
									</tr>
									<tr>
										<td colspan="4">
											<textarea name="accAccionCorrectiva" class="form-control" rows="5" id="accAccionCorrectiva"><?php echo $accAccionCorrectiva; ?></textarea>
										</td>
									</tr>

									<tr height="30" bgcolor="#0099CC" style="color:#000000; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px; font-weight:700;">
										<td colspan="4">6. Verificación de la implementación, efectividad y cierre: </td>
									</tr>
									<tr>
										<td colspan="4">
											RESULTADO:
											<select name="resultado" id="resultado">
											    <option></option>
											    <?php 
											    if($resultado == 'R'){?>
											    	<option selected value="R"	> Riesgo      </option>
											    	<option value="O"			> Oportunidad </option>
											    	<?php
											    }else{
												    if($resultado == 'O'){?>
												    	<option value="R" 			> Riesgo 	</option>
												    	<option selected value="O"	> Oportunidad</option>
												    	<?php
												    }else{?>
												    	<option value="R" >Riesgo</option>
												    	<option value="O">Oportunidad</option>
												    	<?php
												    }
												}
											    ?>
											</select>											
											<div>
											<label for="verResAccCorr">
												Descripción:
											</label>
											<textarea name="verResAccCorr" class="form-control" rows="5" id="verResAccCorr"><?php echo $verResAccCorr; ?></textarea>
											</div>
										</td>
									</tr>
									
								</table>
						  </td>
					  	</tr>
						</tbody>
					</table>
				
			</div>
			<div class="card-footer">
				<?php
					$accion = 'Guardar';
					if($accion == 'Guardar' or $accion == 'Agrega' or $accion == 'Actualizar'){?>
						<button name="guardarAccionPreventiva" type="submit" class="btn btn-primary">
							Guardar
						</button>
						<?php
							if($accion == 'Guardar' || $accion == 'Actualizar'){
								if($verCierreAccion == 'on'){?>
									<button name="ReAbrirAccionPreventiva" type="submit" class="btn btn-warning">
										Activar
									</button>
							<?php }else{ ?>
									<button name="cerrarAccionPreventiva" type="submit" class="btn btn-danger">
										Cerrar ARO
									</button>
									<?php
								}
							}
						
					}
					if($accion == 'Borrar'){?>
						<button name="cerrarAccionPreventiva" type="submit" class="btn btn-danger">
							Borrar
						</button>
						<?php
					}
				?>

			</div>
		</div>
	</div>
</div>
</form>