<?php 	
	session_start(); 
	header('Content-Type: text/html; charset=iso-8859-1');
	include_once("conexion.php"); 
	$Rev 	= 0;
	$nInformeCorrectiva = $_GET[nInformeCorrectiva];
	$accion 			= $_GET[accion];
	$fechaApertura 		= date('Y-m-d');
	$encNew = 'Si';

	if($nInformeCorrectiva == 0){
		$link=Conectarse();
		$bddCot=mysql_query("Select * From accionesCorrectivas Order By nInformeCorrectiva Desc");
		if($rowdCot=mysql_fetch_array($bddCot)){
			$nInformeCorrectiva = $rowdCot[nInformeCorrectiva] + 1;
		}else{
			$nInformeCorrectiva = 1;
		}
		mysql_close($link);
	}else{
		$link=Conectarse();
		$bdCot=mysql_query("SELECT * FROM accionesCorrectivas Where nInformeCorrectiva = '".$nInformeCorrectiva."'");
		if($rowCot=mysql_fetch_array($bdCot)){
			$fechaApertura			= $rowCot[fechaApertura];
			$usrApertura			= $rowCot[usrApertura];
			$fteRecCliExt			= $rowCot[fteRecCliExt];
			$fteNroRecCliExt		= $rowCot[fteNroRecCliExt];
			$fteRecCliInt			= $rowCot[fteRecCliInt];
			$fteNroRecCliInt		= $rowCot[fteNroRecCliInt];
			$fteAut					= $rowCot[fteAut];
			$fteAutFecha			= $rowCot[fteAutFecha];
			$fteAudInt				= $rowCot[fteAudInt];
			$fteAudIntFecha			= $rowCot[fteAudIntFecha];
			$fteAudExt				= $rowCot[fteAudExt];
			$fteAudExtFecha			= $rowCot[fteAudExtFecha];
			$fteOtros				= $rowCot[fteOtros];
			$oriSisGes				= $rowCot[oriSisGes];
			$oriSisGesFecha			= $rowCot[oriSisGesFecha];
			$oriEnsayos				= $rowCot[oriEnsayos];
			$oriNroAso				= $rowCot[oriNroAso];
			$oriLeyReg				= $rowCot[oriLeyReg];
			$oriLeyRegFecha			= $rowCot[oriLeyRegFecha];
			$oriTnc					= $rowCot[oriTnc];
			$oriTncFecha			= $rowCot[oriTncFecha];
			$oriInterLab			= $rowCot[oriInterLab];
			$oriInterLabFecha		= $rowCot[oriInterLabFecha];
			$oriOtros				= $rowCot[oriOtros];
			$desClasNoConf			= $rowCot[desClasNoConf];
			$desClasObs				= $rowCot[desClasObs];
			$desIdentificacion		= $rowCot[desIdentificacion];
			$desHallazgo			= $rowCot[desHallazgo];
			$desEvidencia			= $rowCot[desEvidencia];
			$Causa					= $rowCot[Causa];
			$accCorrecion			= $rowCot[accCorrecion];
			$accAccionCorrectiva	= $rowCot[accAccionCorrectiva];
			$accFechaImp			= $rowCot[accFechaImp];
			$accFechaTen			= $rowCot[accFechaTen];
			$accFechaApli			= $rowCot[accFechaApli];
			$accFechaVer			= $rowCot[accFechaVer];
			$verResAccCorr			= $rowCot[verResAccCorr];
			$usrEncargado			= $rowCot[usrEncargado];
			$usrResponsable		 	= $rowCot[usrResponsable];
		}
		mysql_close($link);
		$encNew = 'No';
	}
?>

<div id="bloqueoTrasperente">
	<div id="cajaRegistraPruebas">
		<center>
		<form name="form" action="accionesCorrectivasUsr.php" method="post">
		<table width="99%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
			<tr>
				<td colspan="4" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
					<img src="../imagenes/about_us_close_128.png" width="50" align="middle">
					<span style="color:#FFFFFF; font-size:25px; font-weight:700;">
						Formulario Acciones Correctivas 
						<div id="botonImagen">
							<?php 
								$prgLink = 'accionesCorrectivasUsr.php';
								echo '<a href="'.$prgLink.'" style="float:right;"><img src="../imagenes/no_32.png"></a>';
							?>
						</div>
					</span>
				</td>
			</tr>
			<tr>
			  <td colspan="2" rowspan="2" class="lineaDerBot">
			  	<strong style=" font-size:20px; font-weight:700; margin-left:10px;">
					Informe Acción Correctiva N° <?php echo $nInformeCorrectiva; ?>
					<input name="nInformeCorrectiva" 	id="nInformeCorrectiva" type="hidden" value="<?php echo $nInformeCorrectiva; ?>" size="7" maxlength="7" style="font-size:18px; font-weight:700;" />
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
						$bdCli=mysql_query("SELECT * FROM Usuarios Order By usuario");
						if($rowCli=mysql_fetch_array($bdCli)){
							do{
								$loginRes = $rowCli[usr];
								if($usrResponsable == $loginRes){
									echo '<option selected 	value='.$rowCli[usr].'>'.$rowCli[usuario].'</option>';
								}else{
									echo '<option 			value='.$rowCli[usr].'>'.$rowCli[usuario].'</option>';
								}
							}while ($rowCli=mysql_fetch_array($bdCli));
						}
						mysql_close($link);
						?>
              	</select>			  
			  </td>
			  <td class="lineaDerBot" align="center">Implementaci&oacute;n</td>
			  <td class="lineaDerBot" align="center">Cierre</td>
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
			  <td colspan="4" class="lineaDerBot">
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
						  	<input name="oriSisGesFecha" id="oriSisGesFecha" type="date" value="<?php echo $fteNroRecCliExt; ?>" style="font-size:12px; font-weight:700;" />
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
							<td colspan="4">3. Descripción del Hallazgo </td>
						</tr>
						<tr>
							<td colspan="4">a) Clasificación </td>
						</tr>
						<tr>
							<td colspan="4">
								<?php if($desClasNoConf=='on'){?>
									<input name="Clasificacion" type="radio" value="N" checked> No Conformidad 
								<?php }else{ ?>
									<input name="Clasificacion" type="radio" value="N"> No Conformidad 
								<?php } ?>
								
								<?php if($desClasObs=='on'){?>
									<input name="Clasificacion" type="radio" value="O" checked> Observación 
								<?php }else{ ?>
									<input name="Clasificacion" type="radio" value="O"> Observación 
								<?php } ?>
							</td>
						</tr>
						<tr>
							<td colspan="4">
								b)  Identificación del requerimiento normativo, legal o reglamentario afectado:
								<textarea name="desIdentificacion" cols="100" rows="5"><?php echo $desIdentificacion; ?></textarea>
							</td>
						</tr>
						<tr>
							<td colspan="4">
								c)  Hallazgo detectado:
								<textarea name="desHallazgo" cols="100" rows="5"><?php echo $desHallazgo; ?></textarea>
							</td>
						</tr>
						<tr>
							<td colspan="4">
								d)  Evidencia objetiva del hallazgo:
								<textarea name="desEvidencia" cols="100" rows="5"><?php echo $desEvidencia; ?></textarea>
							</td>
						</tr>

						<tr height="30" bgcolor="#0099CC" style="color:#000000; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px; font-weight:700;">
							<td colspan="4">4. Causa raíz Hallazgo </td>
						</tr>
						<tr>
							<td colspan="4">
								<textarea name="Causa" cols="100" rows="5"><?php echo $Causa; ?></textarea>
							</td>
						</tr>

						<tr height="30" bgcolor="#0099CC" style="color:#000000; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px; font-weight:700;">
							<td colspan="4">5. Acciones Correctivas: </td>
						</tr>
						<tr>
							<td colspan="4">
								Corrección:
								<textarea name="accCorrecion" cols="100" rows="5"><?php echo $accCorrecion; ?></textarea>
							</td>
						</tr>
						<tr>
							<td colspan="4">
								Acción Correctiva:
								<textarea name="accAccionCorrectiva" cols="100" rows="5"><?php echo $accAccionCorrectiva; ?></textarea>
							</td>
						</tr>

						<tr height="30" bgcolor="#0099CC" style="color:#000000; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px; font-weight:700;">
							<td colspan="4">6. Verificación de la implementación, efectividad y cierre de la AC </td>
						</tr>
						<tr>
							<td colspan="4">
								RESULTADO DE LA ACCIÓN CORRECTIVA:
								<textarea name="verResAccCorr" cols="100" rows="5"><?php echo $verResAccCorr; ?></textarea>
							</td>
						</tr>
						
					</table>
			  </td>
		  </tr>
		  <tr>
				<td colspan="4" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px; ">
					<?php
						echo $accion;
						if($accion == 'Guardar' || $accion == 'Agrega' || $accion == 'Actualizar'){?>
							<div id="botonImagen">
								<button name="guardarAccionCorrectiva" style="float:right;" title="Guardar Acción Correctiva">
									<img src="../gastos/imagenes/guardar.png" width="55" height="55">
								</button>
							</div>
							<?php
						}
						if($accion == 'Borrar'){?>
							<button name="confirmarBorrar" style="float:right;">
								<img src="../gastos/imagenes/inspektion.png" width="55" height="55">
							</button>
							<?php
						}
					?>
				</td>
			</tr>
		</table>
		</form>
		</center>
	</div>
</div>

<script>
	$(document).ready(function(){
	  $("#CtaCte").click(function(){
		if($("#Cta").css("visibility") == "hidden" ){
			$("#Cta").css("visibility","visible");
		}else{
			$("#Cta").css("visibility","hidden");
		}
	  });
	});
</script>
