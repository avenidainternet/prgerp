<?php 	
	session_start(); 
	header('Content-Type: text/html; charset=iso-8859-1');
	include_once("conexion.php"); 
	$Rev 	= 0;
	$CAM 	= $_GET[CAM];
	$Rev 	= $_GET[Rev];
	$Cta 	= $_GET[Cta];
	$accion = $_GET[accion];
	$Estado = '';
	$fechaCotizacion = date('Y-m-d');
	$encNew = 'Si';

	if($CAM == 0){
		$accion = 'Guardar';
		$Atencion = 'Seleccionar';
	}else{
		$link=Conectarse();
		$bdCot=mysql_query("SELECT * FROM Cotizaciones Where CAM = '".$CAM."' and Cta = '".$Cta."'");
		if($rowCot=mysql_fetch_array($bdCot)){
			$RAM 					= $rowCot[RAM];
			$Rev 					= $rowCot[Rev];
			$Cta 					= $rowCot[Cta];
			$fechaCotizacion 		= $rowCot[fechaCotizacion];
			$usrCotizador 			= $rowCot[usrCotizador];
			$usrResponzable			= $rowCot[usrResponzable];
			$Cliente 				= $rowCot[RutCli];
			$nContacto 				= $rowCot[nContacto];
			$Atencion 				= $rowCot[Atencion];
			$correoAtencion 		= $rowCot[correoAtencion];
			$Descripcion			= $rowCot[Descripcion];
			$EstadoCot				= $rowCot[Estado];
			$Validez				= $rowCot[Validez];
			$dHabiles				= $rowCot[dHabiles];
			$oCompra				= $rowCot[oCompra];
			$nOC					= $rowCot[nOC];
			$oMail					= $rowCot[oMail];
			$oCtaCte				= $rowCot[oCtaCte];
			$obsServicios			= $rowCot[obsServicios];
			$Observacion			= $rowCot[Observacion];
			$fechaAceptacion		= $rowCot[fechaAceptacion];
			$proxRecordatorio		= $rowCot[proxRecordatorio];
			$contactoRecordatorio	= $rowCot[contactoRecordatorio];
			$informeUP				= $rowCot[informeUP];
			$fechaInformeUP			= $rowCot[fechaInformeUP];
			$Facturacion			= $rowCot[Facturacion];
			$fechaFacturacion		= $rowCot[fechaFacturacion];
			$Archivo				= $rowCot[Archivo];
			$fechaArchivo			= $rowCot[fechaArchivo];
			if($usrResponzable == ''){
				$usrResponzable = $usrCotizador;
			}
		}
		mysql_close($link);
		$fd = explode('-', $fechaAceptacion);
		if($fd[0] == 0 ){
			$fechaAceptacion = date('Y-m-d');
		}
		$encNew = 'No';
	}
?>
<style type="text/css">
<!--
.Estilo1 {color: #FFFFFF}
-->
</style>


<div id="bloqueoTrasperente">
	<div id="cajaRegistraPruebas">
		<center>
		<form name="form" action="plataformaCotizaciones.php" method="post">
		<table width="75%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
			<tr>
				<td colspan="4" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
					<img src="../imagenes/tpv.png" width="50">
					<span style="color:#FFFFFF; font-size:18px; font-weight:700;">
						SEGUIMIENTO 
						<?php 
							if($Rev<10){
								$Revision = '0'.$Rev;
							}else{
								$Revision = $Rev;
							}
							echo 'AM-'.$CAM.'-'.$Revision.'-'.$Cta.' ('.$accion.')';
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
			  <td colspan="4" class="lineaDerBot">
			  	<strong style=" font-size:20px; font-weight:700; margin-left:10px;">
					CAM-
					<input name="CAM" 	 id="CAM" 	 type="text"   value="<?php echo $CAM; ?>" size="7" maxlength="7" style="font-size:18px; font-weight:700;" readonly />
					<input name="RAM" 	 id="RAM" 	 type="text"   value="<?php echo $RAM; ?>" size="7" maxlength="7" style="font-size:18px; font-weight:700;" readonly />
					<input name="accion" id="accion" type="hidden" value="<?php echo $accion; ?>">
	                <input  name="Cta"   id="Cta" 	 type="hidden" value="<?php echo $Cta; ?>" size="2" maxlength="2" />
	                <input  name="Rev"   id="Rev" 	 type="hidden" value="<?php echo $Rev; ?>" size="2" maxlength="2" />
					<?php
						echo 'Rev. <span class="vizualizacion">'.$Revision.'</span>';
					?>
				</strong>
			  </td>
		  </tr>
			<tr>
				<td height="27" colspan="2" bordercolor="#FFFFFF" bgcolor="#0099CC" class="lineaDerBot">Empresa / Cliente </td>
				<td width="63%" bordercolor="#FFFFFF" bgcolor="#0099CC" class="lineaDerBot">Atenci&oacute;n:</td>
				<td width="2%" rowspan="6" class="lineaBot">&nbsp;		  		</td>
		    </tr>
			<tr>
				<td height="30" colspan="2" class="lineaDerBot">
					<span>					</span>
			        <?php
						$link=Conectarse();
						$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$Cliente."'");
						if($rowCli=mysql_fetch_array($bdCli)){
							echo '<span style="font-size:14px; font-weight:700;">'.$rowCli[Cliente].'</span>';
						}
						mysql_close($link);
					?>
				</td>
				<td class="lineaDerBot"><?php echo '<span style="font-size:14px; font-weight:700;">'.$Atencion.'</span>'; ?></td>
			</tr>
			<tr>
				<td height="32" colspan="3" bgcolor="#0099CC" class="lineaDerBot Estilo1">Situaci&oacute;n / Seguimiento </td>
			</tr>
			<tr>
			  <td width="22%" height="29" valign="top" class="lineaDerBot"><strong>Informe Subido </strong></td>
			  <td valign="top"  class="lineaDerBot">
			  	<?php if($informeUP=='on'){?>
					  	<input type="checkbox" name="informeUP" id="informeUP" checked>
				<?php }else{?>
					  	<input type="checkbox" name="informeUP" id="informeUP">
				<?php } ?>
			  </td>
		      <td valign="top"  class="lineaDerBot">
			  	<input name="fechaInformeUP" 	id="fechaInformeUP" type="date"  value="<?php echo $fechaInformeUP; ?>" style="font-size:12px; font-weight:700;" autofocus />
			  </td>
			</tr>
			<tr>
			  <td height="25" valign="top" class="lineaDerBot"><strong>Facturaci&oacute;n</strong></td>
			  <td width="13%" valign="top" class="lineaDerBot">
			  	<?php if($Facturacion=='on'){?>
			  			<input type="checkbox" name="Facturacion" id="Facturacion" checked>
				<?php }else{?>
			  			<input type="checkbox" name="Facturacion" id="Facturacion">
				<?php } ?>
			  </td>
			  <td valign="top" class="lineaDerBot">
			  	<input name="fechaFacturacion" 	id="fechaFacturacion" type="date"  value="<?php echo $fechaFacturacion; ?>" style="font-size:12px; font-weight:700;" autofocus />
			  </td>
		    </tr>
			<tr>
				<td height="25" valign="top" class="lineaDerBot"><strong>Archivado</strong></td>
				<td height="25" valign="top" class="lineaDerBot">
			  		<?php if($Archivo=='on'){?>
			  			<input type="checkbox" name="Archivo" id="Archivo" checked>
					<?php }else{?>
			  			<input type="checkbox" name="Archivo" id="Archivo">
					<?php } ?>
				  </td>
				  <td height="25" valign="top" class="lineaDerBot">
				  	<input name="fechaArchivo" 	id="fechaArchivo" type="date"  value="<?php echo $fechaArchivo; ?>" style="font-size:12px; font-weight:700;" autofocus />
				  </td>
			</tr>
		  	<tr>
				<td colspan="4" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px; ">
					<?php
						echo $accion;
						if($accion == 'SeguimientoAM'){?>
							<div id="botonImagen">
								<button name="guardarSeguimientoAM" style="float:right;" title="Guardar Seguimiento">
									<img src="../gastos/imagenes/guardar.png" width="55" height="55">
								</button>
							</div>
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
