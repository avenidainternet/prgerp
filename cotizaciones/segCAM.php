<?php 	
	//ini_set("session.cookie_lifetime","36000");
	//ini_set("session.gc_maxlifetime","36000");
	session_start(); 
	header('Content-Type: text/html; charset=utf-8');
	include_once("../conexionli.php"); 
	$Rev 		= 0;
	$Consultar = '';
	$CAM 		= $_GET['CAM'];
	$Rev 		= $_GET['Rev'];
	$Cta 		= $_GET['Cta'];
	$accion 	= $_GET['accion'];
	$Consultar 	= $_GET['Consultar'];
	$nOC 		= $_GET['nOC'];
	$Estado 	= '';
	$fechaCotizacion = date('Y-m-d');
	$encNew = 'Si';
	$tpEnsayo	= 0;
	
	if($CAM == 0){
		$accion = 'Guardar';
		$Atencion = 'Seleccionar';
	}else{
		$link=Conectarse();
		$bdCot=$link->query("SELECT * FROM Cotizaciones Where CAM = '".$CAM."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$RAM 					= $rowCot['RAM'];
			$Rev 					= $rowCot['Rev'];
			$Fan					= $rowCot['Fan'];
			$Cta 					= $rowCot['Cta'];
			$fechaCotizacion 		= $rowCot['fechaCotizacion'];
			$usrCotizador 			= $rowCot['usrCotizador'];
			$usrResponzable			= $rowCot['usrResponzable'];
			$Cliente 				= $rowCot['RutCli'];
			$nContacto 				= $rowCot['nContacto'];
			$Atencion 				= $rowCot['Atencion'];
			$correoAtencion 		= $rowCot['correoAtencion'];
			$Descripcion			= $rowCot['Descripcion'];
			$EstadoCot				= $rowCot['Estado'];
			$Validez				= $rowCot['Validez'];
			$dHabiles				= $rowCot['dHabiles'];
			$oCompra				= $rowCot['oCompra'];
			if($nOC){
				$nOC = $nOC;
			}else{
				$nOC					= $rowCot['nOC'];
			}
			$oMail					= $rowCot['oMail'];
			$oCtaCte				= $rowCot['oCtaCte'];
			$obsServicios			= $rowCot['obsServicios'];
			$Observacion			= $rowCot['Observacion'];
			$fechaAceptacion		= $rowCot['fechaAceptacion'];
			$fechaEstimadaTermino	= $rowCot['fechaEstimadaTermino'];
			$proxRecordatorio		= $rowCot['proxRecordatorio'];
			$contactoRecordatorio	= $rowCot['contactoRecordatorio'];
			$correoInicioPAM		= $rowCot['correoInicioPAM'];
			$tpEnsayo				= $rowCot['tpEnsayo'];
			if($usrResponzable == ''){
				$usrResponzable = $usrCotizador;
			}
		}


		$siRAM = 'NO';
		$bdRAM=$link->query("SELECT * FROM registroMuestras Where RutCli = '".$rowCot['RutCli']."' and situacionMuestra = 'R'");
		if($rowRAM=mysqli_fetch_array($bdRAM)){
			$siRAM = 'SI';
		}


		$link->close();
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
		<table width="95%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
			<tr>
				<td colspan="6" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
					<img src="../imagenes/seguimiento.png" width="50">
					<span style="color:#FFFFFF; font-size:18px; font-weight:700;">
						SEGUIMIENTO 
						<?php 
							if($Rev<10){
								$Revision = '0'.$Rev;
							}else{
								$Revision = $Rev;
							}
							echo 'CAM '.$CAM.'-'.$Revision.'-'.$Cta.' ('.$accion.')';
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
						<input name="CAM" 	 	id="CAM" 	 	type="text"   value="<?php echo $CAM; ?>" 		size="7" maxlength="7" style="font-size:18px; font-weight:700;" readonly />
						<input name="accion" 	id="accion" 	type="hidden" value="<?php echo $accion; ?>">
						<input  name="Cta"   	id="Cta" 	 	type="hidden" value="<?php echo $Cta; ?>" 		/>
						<input  name="Rev"   	id="Rev" 	 	type="hidden" value="<?php echo $Rev; ?>" 	 	/>
						<input  name="dHabiles" id="dHabiles" 	type="hidden" value="<?php echo $dHabiles; ?>"  />
						<?php
							echo 'Rev. <span class="vizualizacion">'.$Revision.'</span>';
						?>
					</strong>
				</td>
			</tr>
			<tr>
				<td height="40" colspan="2" bordercolor="#FFFFFF" bgcolor="#0099CC" class="lineaDerBot">
					Empresa / Cliente 
				</td>
				<td colspan="3" bordercolor="#FFFFFF" bgcolor="#0099CC" class="lineaDerBot">
					Atención:
				</td>
			</tr>
			<tr>
				<td height="40" colspan="2" class="lineaDerBot">
			        <?php
						$link=Conectarse();
						$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$Cliente."'");
						if($rowCli=mysqli_fetch_array($bdCli)){
							echo '<span style="font-size:14px; font-weight:700;">'.$rowCli['Cliente'].'</span>';
						}
						$link->close();
					?>
				</td>
				<td colspan="3" class="lineaDerBot">
					<span style="font-size:16px; font-weight:700;">
						<?php echo $Atencion; ?>
					</span>
				</td>
			</tr>
			<tr>
				<td height="32" colspan="5" bgcolor="#0099CC" class="lineaDerBot Estilo1">Situación / Seguimiento </td>
			</tr>
			<tr>
			  <td width="29%" height="29" valign="top" bgcolor="#CCCCCC" class="lineaDerBot" align="center">
			  	<strong>Fecha Aceptaci&oacute;n CAM </strong>
			  </td>
			  <td colspan="2" valign="top" bgcolor="#CCCCCC" class="lineaDerBot" align="center">
			  	<strong>
					Tipo CAM
              	</strong>
			   </td>
		      <td width="16%" valign="top" bgcolor="#CCCCCC" class="lineaDerBot" align="center">
			  	<!-- D&iacute;as Habiles -->
				Fecha Estimada
			  </td>
			  <td width="17%" valign="top" bgcolor="#CCCCCC" class="lineaDerBot" align="center">Enviar Correo </td>
			</tr>
			<tr>
			  <td height="38" valign="top" class="lineaDerBot">
			  	<span>
			    	<input name="fechaAceptacion" 	id="fechaAceptacion" type="date"  value="<?php echo $fechaAceptacion; ?>" style="font-size:12px; font-weight:700;" autofocus />
			  	</span>
			   </td>
			   <td colspan="2" valign="top" class="lineaDerBot" align="center">
			    <span class="lineaBot">
				</span>OC
                    <?php 
						if($oCompra=='on'){
							echo '<input name="oCompra" 	type="checkbox" checked>';
						}else{
							echo '<input name="oCompra" 	type="checkbox">';
						}
					?>
					Correo
					<?php 
						if($oMail=='on'){
							echo '<input name="oMail" 	type="checkbox" checked>';
						}else{
							echo '<input name="oMail" 	type="checkbox">';
						}
					?>
					Cta.Cte
					<?php 
						if($oCtaCte=='on'){
							echo '<input name="oCtaCte" id="CtaCte" 	type="checkbox" checked>';
						}else{
							echo '<input name="oCtaCte" id="CtaCte" 	type="checkbox">';
						}
					?>
                  </span></td>
			    <td valign="top" class="lineaDerBot" align="center">
					<!-- Dias Habiles -->
					<?php
						
						$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
						$fechaHoy = date('Y-m-d');
						$ft = $fechaHoy;
						$dh	= $dHabiles - 1;

						$dd	= 0;
						for($i=1; $i<=$dh; $i++){
							$ft	= strtotime ( '+'.$i.' day' , strtotime ( $fechaHoy ) );
							$ft	= date ( 'Y-m-d' , $ft );
							$dia_semana = date("w",strtotime($ft));
							if($dia_semana == 0 or $dia_semana == 6){
								$dh++;
								$dd++;
							}
							$SQL = "SELECT * FROM diasferiados Where fecha = '".$ft."'";
							$link=Conectarse();
							$bdDf=$link->query($SQL);
							if($row=mysqli_fetch_array($bdDf)){
								$dh++;
								$dd++;
							}
							$link->close();
						}
						$fechaEstimadaTermino = $ft;
					?>
			    	<input name="fechaEstimadaTermino" 	id="fechaEstimadaTermino" type="date"  value="<?php echo $fechaEstimadaTermino; ?>" style="font-size:12px; font-weight:700;" />
					<!-- Dias Habiles -->
					<?php //if(!$dHabiles){ $dHabiles  = 90; } ?>
<!--					
	                  <select name="dHabiles" id="dHabiles" style="font-size:12px; font-weight:700;">
    	                <?php 
							//for($i=1; $i<=90; $i++){
							//	if($i == $dHabiles){
							//		echo '<option selected 	value="'.$i.'">'.$i.'</option>';
							//	}else{
							//		echo '<option  			value="'.$i.'">'.$i.'</option>';
							//	}
							//}
						?>
                  	</select>
					Días 
-->					
				</td>
			    <td valign="top" class="lineaDerBot" align="center">
					<select name="correoInicioPAM" id="correoInicioPAM" style="font-size:12px; font-weight:700;">
						<?php 
						if($Fan > 0){?>
							<option selected value="off">No</option>
							<?php
						}else{?>
							<?php if($correoInicioPAM == 'Si'){?>
									<option selected value="on">  Si</option>
									<option  		 value="off"> No</option>
							<?php }else{ ?>
									<option selected value="on">   Si</option>
									<option  		 value="off">  No</option>
							<?php }	
						}	
						?>
                  	</select>
				</td>
			</tr>
			<tr>
			  <td height="25" valign="top" bgcolor="#CCCCCC" class="lineaDerBot"><strong>N&ordm; Orden Compra </strong></td>
			  <td width="21%" valign="top" bgcolor="#CCCCCC" class="lineaDerBot"><strong>RAM</strong></td>
			  <td valign="top" bgcolor="#CCCCCC" class="lineaDerBot">Responsable</td>
		      <td valign="top" bgcolor="#CCCCCC" class="lineaDerBot">&nbsp;</td>
		      <td valign="top" bgcolor="#CCCCCC" class="lineaDerBot">Tipo Ensayo </td>
			</tr>
			<tr>
			  <td height="32" valign="top" class="lineaDerBot">
			  		<span class="lineaBot">
						<input name="nOC" id="nOC" list="OCs" type="text" size="24" maxlength="24" value="<?php echo $nOC; ?>">
						<datalist id="OCs">
							<?php
								$link=Conectarse();
								$bdCAM=$link->query("SELECT * FROM cotizaciones Where RutCli = $Cliente and nOC != ''");
								if($rowCAM=mysqli_fetch_array($bdCAM)){
									do{?>
										<option value="<?php echo $rowCAM['nOC'].' RAM '.$rowCAM['RAM']; ?>">
										<?php
									}while ($rowCAM=mysqli_fetch_array($bdCAM));
								}
							?>
						</datalist>
						<?php
							if($Consultar == 'Si'){
								?>
								<div style="text-align: center; background-color:Red; font-size:18px; font-family: Arial, Georgia, Serif; color:#fff; padding:15px; border: 1px solid #ccc;">
									<div style="padding:10px;">
										¿OC ya Utilizada desea volver a utilizarla?<br>
										<select name="respOC" required style="font-size:30px; margin:5px;">
											<option></option>
											<option value="Si">Si</option>
											<option value="No">No</option>
										</select>
									</div>
								</div>
								<?php
							}
						?>
				  	</span>
			  </td>
			  <td valign="top" class="lineaDerBot">
			  	<span class="lineaBot">

					<?php if($siRAM == 'SI'){?>
						<select name="RAM" 	id="RAM">
							<?php
							if($RAM > 0 and $Fan > 0){?>
								<option selected value="<?php echo $RAM.'-'.$Fan; ?>"><?php echo $RAM.'-'.$Fan; ?></option>
								<?php
							}else{
								if($RAM > 0 and $Fan == 0){?>
									<option selected value="<?php echo $RAM.'-'.$Fan; ?>"><?php echo $RAM; ?></option>
								<?php
								}else{?>
									<option></option>
								<?php
								}
							}?>
							<?php
							$link=Conectarse();
							$bdCon=$link->query("SELECT * FROM registroMuestras Where RutCli = '".$Cliente."' and situacionMuestra = 'R'");
							if($rowCon=mysqli_fetch_array($bdCon)){
								do{
									if($RAM > 0){
										if($rowCon['RAM'] == $RAM){
											if($Fan > 0){
												if($rowCon['Fan'] == $Fan){
													echo '	<option selected 	value="'.$rowCon['RAM'].'-'.$rowCon['Fan'].'" title="'.$rowCon['Descripcion'].'">'.$rowCon['RAM'].'-'.$rowCon['Fan'].'</option>';
												}else{
													if($rowCon['Fan'] > 0){
														echo '	<option  			value="'.$rowCon['RAM'].'-'.$rowCon['Fan'].'" title="'.$rowCon['Descripcion'].'">'.$rowCon['RAM'].'-'.$rowCon['Fan'].'</option>';
													}else{
														echo '	<option  			value="'.$rowCon['RAM'].'-'.$rowCon['Fan'].'" title="'.$rowCon['Descripcion'].'">'.$rowCon['RAM'].'</option>';
													}
												}
											}else{
												if($rowCon['Fan'] > 0){
													echo '	<option  			value="'.$rowCon['RAM'].'-'.$rowCon['Fan'].'" title="'.$rowCon['Descripcion'].'">'.$rowCon['RAM'].'-'.$rowCon['Fan'].'</option>';
												}else{
													echo '	<option selected 	value="'.$rowCon['RAM'].'-'.$rowCon['Fan'].'" title="'.$rowCon['Descripcion'].'">'.$rowCon['RAM'].'</option>';
												}
											}
										}
									}else{
										if($rowCon['Fan'] > 0){
											echo '	<option  			value="'.$rowCon['RAM'].'-'.$rowCon['Fan'].'" title="'.$rowCon['Descripcion'].'">'.$rowCon['RAM'].'-'.$rowCon['Fan'].'</option>';
										}else{
											echo '	<option  			value="'.$rowCon['RAM'].'-'.$rowCon['Fan'].'" title="'.$rowCon['Descripcion'].'">'.$rowCon['RAM'].'</option>';
										}
									}
								}while ($rowCon=mysqli_fetch_array($bdCon));
							}
							$link->close();
							?>
						</select>
					<?php }else{?>
			    		<input name="RAM" id="RAM" type="text" size="12" maxlength="12" value="<?php echo $RAM; ?>">
					<?php } ?>
				
			  	</span>
			  </td>
			  <td colspan="2" valign="top" class="lineaDerBot"><span class="lineaBot">
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
			  </span></td>
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
				<td height="25" colspan="5" valign="top" bgcolor="#CCCCCC" class="lineaDerBot"><strong>Seguimiento Contacto Cliente </strong></td>
			</tr>
			<tr>
				<td height="25" colspan="5" valign="top" class="lineaDerBot" bgcolor="#FFFF33">
					<?php
						$link=Conectarse();
						$bdCs=$link->query("SELECT * FROM cotizacionessegimiento Where CAM = '".$CAM."' Order By fechaContacto" );
						if($rowCs=mysqli_fetch_array($bdCs)){?>
							<div style="border:1px dotted #98bf21; padding:5px; background-color:#FFFFFF; margin:5px;">
								<?php
								do{
									$fd = explode('-', $rowCs['fechaContacto']);
									echo '<li>'.$fd[2].'/'.$fd[1].'/'.$fd[0].' - '.$rowCs['contactoRecordatorio'].'</li>';
								}while ($rowCs=mysqli_fetch_array($bdCs));
								?>
							</div>
							<?php
						}
						$link->close();
					?>
					<textarea name="contactoRecordatorio" cols="80" rows="7"></textarea>
				</td>
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
						if($accion == 'Seguimiento'){?>
							<div id="botonImagen">
								<button name="guardarSeguimiento" style="float:right;" title="Guardar Seguimiento">
									<img src="../gastos/imagenes/guardar.png" width="55" height="55">
								</button>
							</div>
							<?php if($EstadoCot == 'C'){?>
										<div id="botonImagen">
											<button name="activarCAM" style="float:left;" title="Activar CAM" >
												<img src="../imagenes/actualiza.png" width="55" height="55">
											</button>
										</div>
							<?php }else{ ?>
										<div id="botonImagen">
											<button name="cerrarCAM" style="float:left;" title="Cerrar CAM" >
												<img src="../imagenes/lock_128.png" width="55" height="55">
											</button>
										</div>
							<?php }
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
