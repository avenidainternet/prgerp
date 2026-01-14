<?php 	
	//ini_set("session.cookie_lifetime","36000");
	//ini_set("session.gc_maxlifetime","36000");
	session_start(); 
	header('Content-Type: text/html; charset=utf-8');
	include_once("../conexionli.php"); 
	include_once("../inc/funciones.php");
	$Rev = 0;
	$CAM = 0;
	
	if(isset($_GET['CAM'])) 	{ $CAM 		= $_GET['CAM'];		}
	if(isset($_GET['RAM'])) 	{ $RAM 		= $_GET['RAM'];		}
	if(isset($_GET['Rev'])) 	{ $Rev 		= $_GET['Rev'];		}
	if(isset($_GET['Cta'])) 	{ $Cta 		= $_GET['Cta'];		}
	if(isset($_GET['accion'])) 	{ $accion 	= $_GET['accion'];	}
	$Estado = '';
	$fechaCotizacion = date('Y-m-d');
	$fechaTermino 	 = date('Y-m-d');
	
	$encNew = 'Si';

	if($CAM == 0){
		$accion = 'Guardar';
		$Atencion = 'Seleccionar';
	}else{
		$link=Conectarse();
		$bdCot=$link->query("SELECT * FROM Cotizaciones Where CAM = '".$CAM."' and RAM = '".$RAM."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			list($ftermino, $dhf, $dha, $dsemana) = fnDiasHabiles($rowCot['fechaInicio'],$rowCot['dHabiles'],$rowCot['horaPAM']);
			$RAM 				= $rowCot['RAM'];
			$Rev 				= $rowCot['Rev'];
			$Fan 				= $rowCot['Fan'];
			$Cta 				= $rowCot['Cta'];
			$fechaCotizacion 	= $rowCot['fechaCotizacion'];
			$usrCotizador 		= $rowCot['usrCotizador'];
			$usrResponzable		= $rowCot['usrResponzable'];
			$usrPega			= $rowCot['usrPega'];
			$fechaPega			= $rowCot['fechaPega'];
			$Cliente 			= $rowCot['RutCli'];
			$nContacto 			= $rowCot['nContacto'];
			$Atencion 			= $rowCot['Atencion'];
			$correoAtencion 	= $rowCot['correoAtencion'];
			$Descripcion		= $rowCot['Descripcion'];
			$EstadoCot			= $rowCot['Estado'];
			$Validez			= $rowCot['Validez'];
			$dHabiles			= $rowCot['dHabiles'];
			$oCompra			= $rowCot['oCompra'];
			$nOC				= $rowCot['nOC'];
			$oMail				= $rowCot['oMail'];
			$oCtaCte			= $rowCot['oCtaCte'];
			$obsServicios		= $rowCot['obsServicios'];
			$Observacion		= $rowCot['Observacion'];
			$fechaAceptacion	= $rowCot['fechaAceptacion'];
			$tpEnsayo			= $rowCot['tpEnsayo'];
			if($usrResponzable == ''){
				$usrResponzable = $usrCotizador;
			}
		}
		$link->close();
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
				<td colspan="6" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
					<img src="../imagenes/Taller.png" width="50">
					<span style="color:#FFFFFF; font-size:18px; font-weight:700;">
						SEGUIMIENTOS  
						<?php 
							if($Rev<10){
								$Revision = '0'.$Rev;
							}else{
								$Revision = $Rev;
							}
							echo 'CAM '.$CAM.'-'.$Revision.'-'.$Cta.' RAM '.$RAM;
							if($Fan>0){ echo '-'.$Fan; echo ' Clon'; }
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
			  <td colspan="6" class="lineaDerBot">
			  	<strong style=" font-size:20px; font-weight:700; margin-left:10px;">
					CAM-
					<input name="CAM" 	 id="CAM" 	 type="text"   value="<?php echo $CAM; ?>" size="7" maxlength="7" style="font-size:18px; font-weight:700;" readonly />
					<input name="RAM" 	 id="RAM" 	 type="text"   value="<?php echo $RAM; ?>" size="7" maxlength="7" style="font-size:18px; font-weight:700;" readonly />
					<?php 
						if($Fan > 0){?>
							Clon <input name="Fan" 	 id="Fan" 	 type="text"   value="<?php echo $Fan; ?>" size="1" maxlength="1" style="font-size:18px; font-weight:700;" readonly />
							<?php 
						}
					?>
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
				<td colspan="4" bordercolor="#FFFFFF" bgcolor="#0099CC" class="lineaDerBot">Atenci&oacute;n:</td>
		    </tr>
			<tr>
				<td height="30" colspan="2" class="lineaDerBot">
					<span>					</span>
			        <?php
						$link=Conectarse();
						$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$Cliente."'");
						if($rowCli=mysqli_fetch_array($bdCli)){
							echo '<span style="font-size:14px; font-weight:700;">'.$rowCli['Cliente'].'</span>';
						}
						$link->close();
					?>
				</td>
				<td colspan="4" class="lineaDerBot"><?php echo '<span style="font-size:14px; font-weight:700;">'.$Atencion.'</span>'; ?></td>
			</tr>
			<tr>
				<td height="32" colspan="6" bgcolor="#0099CC" class="lineaDerBot Estilo1">Situaci&oacute;n / Seguimiento </td>
			</tr>
			<tr>
			  <td width="20%" height="29" valign="top" bgcolor="#CCCCCC" class="lineaDerBot"><strong>Fecha<br>T&eacute;rmino RAM 	</strong></td>
			  <td width="20%" valign="top" bgcolor="#CCCCCC" class="lineaDerBot"><strong>OC										</strong></td>
			  <td width="10%" valign="top" bgcolor="#CCCCCC" class="lineaDerBot"><strong>Situación<br>RAM						</strong></td>
			  <td width="13%" valign="top" bgcolor="#CCCCCC" class="lineaDerBot"><strong>D&iacute;as<br> H&aacute;biles				</strong></td>
		      <td width="18%" valign="top" bgcolor="#CCCCCC" class="lineaDerBot"><strong>Responsable 							</strong></td>
			  <td width="18%" valign="top" bgcolor="#CCCCCC" class="lineaDerBot">Tipo Ensayo 									</td>
			</tr>
			<tr>
				<td height="38" valign="top" class="lineaDerBot">
					<input name="fechaTermino" 	id="fechaTermino" type="date"  value="<?php echo $fechaTermino; ?>" style="font-size:12px; font-weight:700;" autofocus />
				</td>
				<td valign="top" class="lineaDerBot">
					<input name="nOC" id="nOC" type="text" value="<?php echo $nOC; ?>">
				</td>
				<td valign="top" class="lineaDerBot"><span class="lineaBot">
				  <select name="EstadoCot" id="EstadoCot" onChange="asociarSituacion($('#EstadoCot').val())" style="font-size:12px; font-weight:700;">
                    <?php if($EstadoCot == 'P'){?>
                    <option selected	value="P">En Proceso </option>
                    <option 			value="T">Terminado  </option>
                    <option 			value="N">Nula  	</option>
                    <?php } ?>
                    <?php if($EstadoCot == 'T'){?>
                    <option 			value="P">En Proceso </option>
                    <option selected	value="T">Terminado  </option>
                    <option 			value="N">Nula  	</option>
                    <?php } ?>
                  </select>
				</span>
			  </td>
			  <td valign="top" class="lineaDerBot">
					<?php if(!$dHabiles){ $dHabiles  = 90; } ?>
	                  <select name="dHabiles" id="dHabiles" style="font-size:12px; font-weight:700;">
    	                <?php 
							for($i=1; $i<=90; $i++){
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
			    <select name="usrResponzable" id="usrResponzable">
                  <?php
					$link=Conectarse();
					$bdUsr=$link->query("SELECT * FROM Usuarios");
					if($rowUsr=mysqli_fetch_array($bdUsr)){
						do{
							//if($rowCli[nPerfil]  == 1 or $rowCli[nPerfil]  == '01' or $rowCli[nPerfil]  == '02'){
							if(intval($rowUsr['nPerfil'])  === 1 or $rowUsr['nPerfil']  === '01' or $rowUsr['nPerfil']  === '02'){
								if($usrResponzable == $rowUsr['usr']){?>
								  <option selected	value="<?php echo $rowUsr['usr'];?>"><?php echo $rowUsr['usuario']; ?></option>
								  <?php
											}else{?>
								  <option  			value="<?php echo $rowUsr['usr'];?>"><?php echo $rowUsr['usuario']; ?></option>
								  <?php
								}
							}
						}while ($rowUsr=mysqli_fetch_array($bdUsr));
					}
					$link->close();
					
					?>
                </select>
			  </td>
			  <td valign="top" class="lineaDerBot">
			  	<select name="tpEnsayo">
					<?php
						$link=Conectarse();
						$bdTe=$link->query("SELECT * FROM tipoensayo Order By tpEnsayo");
						if($rowTe=mysqli_fetch_array($bdTe)){
							do{
								if($tpEnsayo == $rowTe['tpEnsayo']){
									?>
										<option selected value="<?php echo $rowTe['tpEnsayo']; ?>"><?php echo $rowTe['nomTipoEnsayo']; ?></option>
									<?php
								}
								?>
									<option value="<?php echo $rowTe['tpEnsayo']; ?>"><?php echo $rowTe['nomTipoEnsayo']; ?></option>
								<?php
							}while ($rowTe=mysqli_fetch_array($bdTe));
						}
						$link->close();
					?>
				</select>
			  </td>
			</tr>
			<tr>
				<td height="32" colspan="6" bgcolor="#ffff00" class="lineaDerBot Estilo1"><span style="color:#0101df; font-weight: bold; font-family: Arial;">ASIGNACIÓN PEGAS</span> </td>
			</tr>

			<tr>
			  <td width="20%" height="29" valign="top" bgcolor="#ffbf00" class="lineaDerBot"><span style="color:#0101df; font-weight: bold; font-family: Arial;">Fecha<br>PEGA 		</span></td>
		      <td width="80%" colspan="5" valign="top" bgcolor="#ffbf00" class="lineaDerBot"><span style="color:#0101df; font-weight: bold; font-family: Arial;">Responsable PEGA	</span></td>
			</tr>
			<tr>
				<td height="38" valign="top" class="lineaDerBot">
					<?php 
						if($fechaPega == '0000-00-00'){
							$fechaPega = $ftermino;
						}
					?>
					<input name="fechaPega" 	id="fechaPega" type="date"  value="<?php echo $fechaPega; ?>" style="font-size:12px; font-weight:700;" autofocus />
				</td>
				<td colspan="5" valign="top" class="lineaDerBot">
					<select name="usrPega" id="usrPega">
					<?php
					$link=Conectarse();
					$bdUsr=$link->query("SELECT * FROM Usuarios");
					if($rowUsr=mysqli_fetch_array($bdUsr)){
						do{
							//if($rowCli[nPerfil]  == 1 or $rowCli[nPerfil]  == '01' or $rowCli[nPerfil]  == '02'){
							if(intval($rowUsr['nPerfil'])  === 1 or $rowUsr['nPerfil']  === '01' or $rowUsr['nPerfil']  === '02'){
								if($usrPega == $rowUsr['usr']){?>
								  <option selected	value="<?php echo $rowUsr['usr'];?>"><?php echo $rowUsr['usuario']; ?></option>
								  <?php
											}else{?>
								  <option  			value="<?php echo $rowUsr['usr'];?>"><?php echo $rowUsr['usuario']; ?></option>
								  <?php
								}
							}
						}while ($rowUsr=mysqli_fetch_array($bdUsr));
					}
					$link->close();
					
					?>
					</select>
				</td>
			</tr>


			
		  </tr>
			<tr>
			  <td height="25" colspan="5" valign="top" class="lineaDerBot" style=" font-size:14px; font-weight:700; ">
					<span style=" padding:10px;">DESCRIPCIONES/OBSERVACIONES CAM/RAM:</span><br>
					<textarea name="Descripcion" cols="80" rows="7"><?php echo $Descripcion; ?></textarea>
			  </td>
		  </tr>
   		    <tr>
				<td colspan="6" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px; ">
					<?php
						//echo $accion;
						if($accion == 'SeguimientoRAM'){?>
							<div id="botonImagen">
								<button name="guardarSeguimientoRAM" style="float:right;">
									<img src="../gastos/imagenes/guardar.png" width="55" height="55">
								</button>
								<button name="volverCAM" style="float:left;" title="Volver a CAM">
									<img src="../imagenes/volver.png" width="55" height="55">
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
