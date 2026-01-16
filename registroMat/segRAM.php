<?php 	
	session_start(); 
	header('Content-Type: text/html; charset=iso-8859-1');
	include_once("conexion.php"); 
	$Rev 	= 0;
	$CAM 	= $_GET[CAM];
	$RAM 	= $_GET[RAM];
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
		$bdCot=mysql_query("SELECT * FROM Cotizaciones Where CAM = '".$CAM."' and RAM = '".$RAM."' and Cta = '".$Cta."'");
		if($rowCot=mysql_fetch_array($bdCot)){
			$RAM 				= $rowCot[RAM];
			$Rev 				= $rowCot[Rev];
			$Cta 				= $rowCot[Cta];
			$fechaCotizacion 	= $rowCot[fechaCotizacion];
			$usrCotizador 		= $rowCot[usrCotizador];
			$usrResponzable		= $rowCot[usrResponzable];
			$Cliente 			= $rowCot[RutCli];
			$nContacto 			= $rowCot[nContacto];
			$Atencion 			= $rowCot[Atencion];
			$correoAtencion 	= $rowCot[correoAtencion];
			$Descripcion		= $rowCot[Descripcion];
			$EstadoCot			= $rowCot[Estado];
			$Validez			= $rowCot[Validez];
			$dHabiles			= $rowCot[dHabiles];
			$oCompra			= $rowCot[oCompra];
			$nOC				= $rowCot[nOC];
			$oMail				= $rowCot[oMail];
			$oCtaCte			= $rowCot[oCtaCte];
			$obsServicios		= $rowCot[obsServicios];
			$Observacion		= $rowCot[Observacion];
			$fechaAceptacion	= $rowCot[fechaAceptacion];
			if($usrResponzable == ''){
				$usrResponzable = $usrCotizador;
			}
		}
		mysql_close($link);
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
				<td colspan="5" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
					<img src="../imagenes/Taller.png" width="50">
					<span style="color:#FFFFFF; font-size:18px; font-weight:700;">
						SEGUIMIENTO 
						<?php 
							if($Rev<10){
								$Revision = '0'.$Rev;
							}else{
								$Revision = $Rev;
							}
							echo 'CAM '.$CAM.'-'.$Revision.'-'.$Cta.' RAM '.$RAM.' ('.$accion.')';
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
			  <td colspan="5" class="lineaDerBot">
			  	<strong style=" font-size:20px; font-weight:700; margin-left:10px;">
					CAM-
					<input name="CAM" 	 id="CAM" 	 type="text"   value="<?php echo $CAM; ?>" size="7" maxlength="7" style="font-size:18px; font-weight:700;" readonly />
					<input name="RAM" 	 id="RAM" 	 type="text"   value="<?php echo $RAM; ?>" size="7" maxlength="7" style="font-size:18px; font-weight:700;" />
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
				<td width="48%" colspan="2" bordercolor="#FFFFFF" bgcolor="#0099CC" class="lineaDerBot">Atenci&oacute;n:</td>
				<td width="2%" rowspan="5" class="lineaBot">&nbsp;		  		</td>
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
				<td colspan="2" class="lineaDerBot"><?php echo '<span style="font-size:14px; font-weight:700;">'.$Atencion.'</span>'; ?></td>
			</tr>
			<tr>
				<td height="32" colspan="4" bgcolor="#0099CC" class="lineaDerBot Estilo1">Situaci&oacute;n / Seguimiento </td>
			</tr>
			<tr>
			  <td width="29%" height="29" valign="top" bgcolor="#CCCCCC" class="lineaDerBot"><strong>Fecha T&eacute;rmino RAM </strong></td>
			  <td width="21%" valign="top" bgcolor="#CCCCCC" class="lineaDerBot"><strong>Situación RAM</strong></td>
			  <td valign="top" bgcolor="#CCCCCC" class="lineaDerBot"><strong>D&iacute;as H&aacute;biles<!-- 					<input name="Atencion" 		id="Atencion" 		type="text" size="50" value="<?php echo $Atencion; ?>" 		style="font-size:12px; font-weight:700;"> -->    			  
              </strong></td>
		      <td valign="top" bgcolor="#CCCCCC" class="lineaDerBot"><strong>Responzable </strong></td>
			</tr>
			<tr>
			  <td height="38" valign="top" class="lineaDerBot"><span>
			    <input name="fechaTermino" 	id="fechaTermino" type="date"  value="<?php echo $fechaTermino; ?>" style="font-size:12px; font-weight:700;" autofocus />
			  </span></td>
				<td valign="top" class="lineaDerBot"><span class="lineaBot">
				  <select name="EstadoCot" id="EstadoCot" onChange="asociarSituacion($('#EstadoCot').val())" style="font-size:12px; font-weight:700;">
                    <?php if($EstadoCot == 'P'){?>
                    <option selected	value="P">En Proceso </option>
                    <option 			value="T">Terminado  </option>
                    <option 			value="N">Nula  	</option>
                    <?php } ?>
                    <?php if($EstadoCot == 'F'){?>
                    <option 			value="P">En Proceso </option>
                    <option selected	value="T">Terminado  </option>
                    <option selected	value="N">Nula  	</option>
                    <?php } ?>
                  </select>
				</span>
			  </td>
			  <td valign="top" class="lineaDerBot">
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
			  <td valign="top" class="lineaDerBot">
                    <?php
					$link=Conectarse();
					$bdUsr=mysql_query("SELECT * FROM Usuarios Where usr = '".$usrResponzable."'");
					if($rowUsr=mysql_fetch_array($bdUsr)){
                    	echo '<span style="font-size:18px;">'.$rowUsr[usuario].'</span>';
					}
					mysql_close($link);
					?>
			  </td>
			</tr>
		  </tr>
			<tr>
			  <td height="25" colspan="4" valign="top" class="lineaDerBot" style=" font-size:14px; font-weight:700; ">
					<span style=" padding:10px;">DESCRIPCIONES/OBSERVACIONES CAM/RAM:</span><br>
					<textarea name="Descripcion" cols="80" rows="7"><?php echo $Descripcion; ?></textarea>
			  </td>
		  </tr>
   		    <tr>
				<td colspan="5" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px; ">
					<?php
						echo $accion;
						if($accion == 'SeguimientoRAM'){?>
							<div id="botonImagen">
								<button name="guardarSeguimientoRAM" style="float:right;">
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
