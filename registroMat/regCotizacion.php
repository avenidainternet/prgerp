<?php 	
	session_start(); 
	header('Content-Type: text/html; charset=iso-8859-1');
	include_once("conexion.php"); 
	$Rev 		= 0;
	$CAM 		= $_GET[CAM];
	$Rev 		= $_GET[Rev];
	$Cta 		= $_GET[Cta];
	$accion 	= $_GET[accion];
	$Cliente 	= $_GET[RutCli];
	$Estado = '';
	$fechaCotizacion = date('Y-m-d');
	$encNew = 'Si';

	//if($CAM == 0 or $accion == 'Agrega'){
	if($CAM == 0){
		$Sw = 'G';
		$link=Conectarse();
		$bdCot=mysql_query("Select * From Cotizaciones Order By CAM Desc");
		if($rowCot=mysql_fetch_array($bdCot)){
			$CAM = $rowCot[CAM] + 1;
		}
		mysql_close($link);

		$accion 	= 'Guardar';
		$Atencion 	= 'Seleccionar';
	}else{
		$link=Conectarse();
		$bdCot=mysql_query("SELECT * FROM Cotizaciones Where CAM = '".$CAM."' and Rev = '".$Rev."' and Cta = '".$Cta."'");
		if($rowCot=mysql_fetch_array($bdCot)){
			$RAM 				= $rowCot[RAM];
			$Rev 				= $rowCot[Rev];
			$Cta 				= $rowCot[Cta];
			$fechaCotizacion 	= $rowCot[fechaCotizacion];
			$usrCotizador 		= $rowCot[usrCotizador];
			$Cliente 			= $rowCot[RutCli];
			$nContacto 			= $rowCot[nContacto];
			$Atencion 			= $rowCot[Atencion];
			$correoAtencion 	= $rowCot[correoAtencion];
			$Descripcion		= $rowCot[Descripcion];
			$EstadoCot			= $rowCot[Estado];
			$Validez			= $rowCot[Validez];
			$dHabiles			= $rowCot[dHabiles];
			$obsServicios		= $rowCot[obsServicios];
			$Observacion		= $rowCot[Observacion];
			$fechaAceptacion	= $rowCot[fechaAceptacion];
			$exentoIva			= $rowCot[exentoIva];
		}
		mysql_close($link);
		$encNew = 'No';
	}
?>

<div id="bloqueoTrasperente">
	<div id="cajaRegistraPruebas">
		<center>
		<form name="form" action="modCotizacion.php" method="post">
		<table width="80%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
			<tr>
				<td colspan="4" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
					<span style="color:#FFFFFF; font-size:18px; font-weight:700;">
						COTIZACIÓN CAM 
						<?php 
							if($Rev<10){
								$Revision = '0'.$Rev;
							}else{
								$Revision = $Rev;
							}
							echo $CAM.' Rev. '.$Revision.' Cta.'.$Cta.' ('.$accion.')';
						?>
						<div id="botonImagen">
							<?php 
								$prgLink = 'plataformaCotizaciones.php';
								if($accion=="Actualiza") { $prgLink = 'modCotizacion.php?CAM='.$CAM.'&Rev='.$Rev.'&Cta='.$Cta; }; 
								if($accion=="Borrar") 	 { $prgLink = 'plataformaCotizaciones.php'; }; 
								echo '<a href="'.$prgLink.'" style="float:right;"><img src="../imagenes/no_32.png"></a>';
							?>
						</div>
					</span>
				</td>
			</tr>
			<tr>
			  <td colspan="2" rowspan="2" class="lineaDerBot">
			  	<strong style=" font-size:20px; font-weight:700; margin-left:100px;">
					CAM-
					<input name="CAM" 	 id="CAM" 	 type="text"   	value="<?php echo $CAM; ?>" size="7" maxlength="7" style="font-size:18px; font-weight:700;" />
					<input name="accion" id="accion" type="hidden" 	value="<?php echo $accion; ?>">
	                <input  name="Cta"  id="Cta" 	 type="hidden" 	value="<?php echo $Cta; ?>" size="2" maxlength="2" />
	                Rev. &nbsp;
					<input  name="Rev"  id="Rev" 	 type="text" 	value="<?php echo $Rev; ?>" size="2" maxlength="2" style="font-size:18px; font-weight:700;"  />
				</strong>
			  </td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
		  </tr>
		  <tr>
				<td width="13%" align="center">
					Validez
				</td>
			    <td width="19%" align="center">
					D&iacute;as H&aacute;biles 
				</td>
			</tr>
			<tr>
				<td width="19%">Fecha CAM </td>
				<td class="lineaDer">Responzable CAM :
				</td>
			    <td class="lineaBot" align="center">
					<?php if(!$Validez){ $Validez  = 30; } ?>
                  <select name="Validez" id="Validez" style="font-size:12px; font-weight:700;">
                    <?php 
							for($i=1; $i<=30; $i++){
								if($i == $Validez){
									echo '<option selected 	value="'.$i.'">'.$i.'</option>';
								}else{
									echo '<option  			value="'.$i.'">'.$i.'</option>';
								}
							}
						?>
                  </select>
					Días 
				</td>
			    <td class="lineaBot" align="center">
					<?php if(!$dHabiles){ $dHabiles  = 30; } ?>
                  <select name="dHabiles" id="dHabiles" style="font-size:12px; font-weight:700;">
                    <?php 
							for($i=1; $i<=30; $i++){
								if($i == $dHabiles){
									echo '<option selected 	value="'.$i.'">'.$i.'</option>';
								}else{
									echo '<option  			value="'.$i.'">'.$i.'</option>';
								}
							}
						?>
                  </select>
					Días 
				</td>
			</tr>
			<tr>
				<td class="lineaDerBot">
					<span>
				  	<input name="fechaCotizacion" 	id="fechaCotizacion" type="date"  value="<?php echo $fechaCotizacion; ?>" style="font-size:12px; font-weight:700;" autofocus>
					</span>
				</td>
				<td class="lineaDerBot">
					<select name="usrCotizador" id="usrCotizador" style="font-size:12px; font-weight:700;">
						<?php
						$link=Conectarse();
						$bdCli=mysql_query("SELECT * FROM Usuarios Order By usuario");
						if($rowCli=mysql_fetch_array($bdCli)){
							do{
								if($rowCli[nPerfil]  == 1 or $rowCli[nPerfil]  == '01' or $rowCli[nPerfil]  == '02'){
								
									if($usrCotizador){
										if($usrCotizador == $rowCli[usr]){
											echo '<option selected value='.$rowCli[usr].'>'.$rowCli[usuario].'</option>';
										}else{
											echo '<option value='.$rowCli[usr].'>'.$rowCli[usuario].'</option>';
										}
									}else{
										if($_SESSION['usr'] == $rowCli[usr]){
											echo '<option selected value='.$rowCli[usr].'>'.$rowCli[usuario].'</option>';
										}else{
											echo '<option value='.$rowCli[usr].'>'.$rowCli[usuario].'</option>';
										}
									}
								}
							}while ($rowCli=mysql_fetch_array($bdCli));
						}
						mysql_close($link);
						?>
					</select>
				</td>
		        <td colspan="2" rowspan="2" class="lineaDerBot">
<!--
					Exenta de Iva
  				  <?php if($exentoIva=='on'){?>
		            	<input type="checkbox" name="exentoIva" checked>
			        <?php }else{ ?>
		            	<input type="checkbox" name="exentoIva">
			        <?php } ?>
-->
					
		        </td>
			</tr>
			<tr>
				<td class="lineaDerBot">Empresa / Cliente  :</td>
				<td class="lineaDerBot">
					<select name="Cliente" Id="Cliente" onChange="buscarContactos($('#Cliente').val(), $('#Atencion').val(), $('#nContacto').val())" style="font-size:12px; font-weight:700;">
						<option></option>
						<?php
						$link=Conectarse();
						$bdCli=mysql_query("SELECT * FROM Clientes Order By Cliente");
						if($rowCli=mysql_fetch_array($bdCli)){
							do{
								if($rowCli[RutCli] == $Cliente){
									echo '<option selected value='.$rowCli[RutCli].'>'.$rowCli[Cliente].'</option>';
								}else{
									echo '<option value='.$rowCli[RutCli].'>'.$rowCli[Cliente].'</option>';
								}
							}while ($rowCli=mysql_fetch_array($bdCli));
						}
						mysql_close($link);
						?>
				</select>				
				</td>
	        </tr>
			<tr>
			  <td valign="top" class="lineaDerBot">Atenci&oacute;n:</td>
			  <td height="25" colspan="3" valign="top" class="lineaDerBot">
					<?php
						if($Cliente){?>
							<!-- <input name="Atencion" 		id="Atencion" 		type="hidden" value="<?php echo $Atencion; ?>"> -->
							<script>
								var Cliente   = "<?php echo $Cliente; ?>";
								var Atencion  = "<?php echo $Atencion; ?>";
								var nContacto = "<?php echo $nContacto; ?>";
								buscarContactos(Cliente, Atencion, nContacto);
								datosContactos(Cliente, Atencion, nContacto);
							</script>
							<?php
						}
					?>
					<span id="resultadoContacto"></span>
					<span id="rDatosContacto"></span>
                <!-- 					<input name="Atencion" 		id="Atencion" 		type="text" size="50" value="<?php echo $Atencion; ?>" 		style="font-size:12px; font-weight:700;"> -->		  		</td>
		    </tr>
			<tr>
				<td valign="top">Descipción CAM/RAM:</td>
				<td colspan="3" class="lineaDer">
					<textarea name="Descripcion" id="Descripcion" cols="50" rows="7" style="font-size:12px; font-weight:700;"><?php echo $Descripcion; ?></textarea>
				</td>
		    </tr>
		  <tr>
			  <td valign="top" class="lineaDer">Observaci&oacute;n servicios</td>
			  <td colspan="3" class="lineaDer">
			  	<textarea name="obsServicios" id="obsServicios" cols="50" rows="3" style="font-size:12px; font-weight:700;" placeholder="Observaciones de los servicios (Max 100 car.) ..."><?php echo $obsServicios; ?></textarea>
			  </td>
		  </tr>
		  <tr>
			  <td valign="top">Observación:</td>
			  <td colspan="3" class="lineaDer">
			  	<textarea name="Observacion" id="Observacion" cols="50" rows="7" style="font-size:12px; font-weight:700;" placeholder="Registre aquí las observaciones a la CAM..."><?php echo $Observacion; ?></textarea>
			 </td>
		  </tr>
		  <tr>
				<td colspan="4" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px; ">
					<?php
						echo $accion.' '.$Sw;
						if($accion == 'Guardar' || $accion == 'Agrega' || $accion == 'Actualiza'){?>
							<div id="botonImagen">
								<button name="confirmarGuardar" style="float:right;">
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
