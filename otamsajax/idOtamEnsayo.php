<?php 	
	session_start(); 
	header('Content-Type: text/html; charset=iso-8859-1');

	include_once("conexion.php"); 
	$RAM 		= $_GET[RAM];
	$idItem 	= $_GET[idItem];
	$Otam 		= $_GET[Otam];
	$accion  	= $_GET[accion];

	$fechaApertura 	= date('Y-m-d');
	$encNew = 'Si';

	$link=Conectarse();

	$bdMu=mysql_query("SELECT * FROM amMuestras Where idItem = '".$idItem."'");
	if($rowMu=mysql_fetch_array($bdMu)){
		$idMuestra		= $rowMu[idMuestra];
	}

	$bdOT=mysql_query("SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam = '".$Otam."'");
	if($rowOT=mysql_fetch_array($bdOT)){
		$ObsOtam		= $rowOT[ObsOtam];
		$tpMuestra		= $rowOT[tpMuestra];
		$Ind			= $rowOT[Ind];
		$Tem			= $rowOT[Tem];
		$rTaller		= $rowOT[rTaller];
	}
	
	mysql_close($link);
?>

<style>
.Estilo3 {color: #FFFFFF}
</style>
<script language="javascript">
	document.getElementById("Cuerpo").style.visibility="hidden";
	document.getElementById("cajaRegistraPruebas").style.visibility="visible";
</script>
<div id="bloqueoTrasperente">
	<div id="cajaRegistraPruebas">
		<center>
		<form name="form" action="idOtams.php" method="get">
			<table width="99%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
				<tr>
					<td colspan="4" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
						<img src="../imagenes/poster_teachers.png" width="50" align="middle">
						<span style="color:#FFFFFF; font-size:25px; font-weight:700;">
							Identificaci&oacute;n de 
								OTAM  		<span style=" color:#FFFF00; font-weight:700; "> <?php echo $Otam; ?>	</span>
								- 			<span style=" color:#FFFF00; font-weight:700; "> 
												<?php 
													$tm = explode('-',$Otam);
													if(substr($tm[1],0,1) == 'T'){ echo 'Tracción'; }
													if(substr($tm[1],0,1) == 'C'){ echo 'Charpy'; 	}
													if(substr($tm[1],0,1) == 'Q'){ echo 'Químico'; 	}
													if(substr($tm[1],0,1) == 'D'){ echo 'Dureza'; 	}
												?>
											</span>
								Id.SIMET 	<span style=" color:#FFFF00; font-weight:700; "> <?php echo $idItem; ?>	</span>
							<?php echo $Existe;?>
							<div id="botonImagen">
								<?php 
									$prgLink = 'idOtams.php?accion=Muestra&RAM='.$RAM.'&idItem='.$idItem;
									echo '<a href="'.$prgLink.'" style="float:right;"><img src="../imagenes/no_32.png"></a>';
								?>
							</div>
					  </span>
				  </td>
				</tr>
				<tr>
				  	<td colspan="4" class="lineaDerBot">
					  	<strong style=" font-size:20px; font-weight:700; margin-left:10px;">
							<input name="RAM" 			id="RAM" 		type="hidden" value="<?php echo $RAM; 			?>" />
							<input name="idItem" 		id="idItem" 	type="hidden" value="<?php echo $idItem; 		?>" />
							<input name="Otam" 			id="Otam" 		type="hidden" value="<?php echo $Otam; 			?>" />
							<input name="accion" 		id="accion" 	type="hidden" value="<?php echo $accion; 		?>">
						</strong>										
					</td>
			  	</tr>
				<tr>
					<td height="93">
						<table width="100%" cellpadding="0" cellspacing="0" class="cuadroInformes">
							<tr>
								<td width="14%" height="40" valign="top"><strong>Objetivo Servicio</strong></td>
								<td valign="top">
									<textarea name="ObsOtam" id="ObsOtam" cols="70" rows="10" autofocus><?php echo $ObsOtam; ?></textarea>
								</td>
								<td>
									<table align="center" width="30%" style="border:1px solid #ccc;">
										<tr bgcolor="#666666">
										  <td height="40" colspan="2"><div align="center"><span class="Estilo3">Descripci&oacute;n Ensayo</span></div></td>
									  </tr>
										<tr>
										  	<td height="40">Tp.Ensayo</td>
										  	<td>
												<select name="tpMuestra">
												<?php
													$tm = explode('-',$Otam);
													if(substr($tm[1],0,1) == 'T'){ $idEnsayo = 'Tr'; }
													if(substr($tm[1],0,1) == 'Q'){ $idEnsayo = 'Qu'; }
													if(substr($tm[1],0,1) == 'C'){ $idEnsayo = 'Ch'; }
													if(substr($tm[1],0,1) == 'D'){ $idEnsayo = 'Du'; }
													
													$SQL = "SELECT * FROM amTpsMuestras Where idEnsayo = '".$idEnsayo."'";
													
													$link=Conectarse();
													$bdTm=mysql_query($SQL);
													if($rowTm=mysql_fetch_array($bdTm)){
														do{?>
																<?php if($tpMuestra == $rowTm[tpMuestra]){?>
																		<option selected 	value="<?php echo $rowTm[tpMuestra]; ?>"><?php echo $rowTm[Muestra]; ?></option>
																<?php }else{ ?>
																		<option  			value="<?php echo $rowTm[tpMuestra]; ?>"><?php echo $rowTm[Muestra]; ?></option>
																<?php } ?>
															<?php
														}while($rowTm=mysql_fetch_array($bdTm));
													}
													mysql_close($link);
												?>
												</select>
											</td>
										</tr>
										<?php
											if(substr($tm[1],0,1) == 'D' or substr($tm[1],0,1) == 'C'){?>
												<tr>
													<td height="40">
														<?php
														if(substr($tm[1],0,1) == 'D'){
															echo 'Indentaciones';
														}
														if(substr($tm[1],0,1) == 'C'){
															echo 'Impactos';
														}
														?>
													</td>
													<td>
														<input type="text" name="Ind" id="Ind" maxlength="5" size="5" value="<?php echo $Ind; ?>">
													</td>
												</tr>
										<?php
										}
										?>
										<?php
											if(substr($tm[1],0,1) == 'C'){?>
												<tr>
												  <td height="40">T&deg;</td>
													<td>
														<input type="text" name="Tem" id="Tem" maxlength="10" size="10" value="<?php echo $Tem; ?>">
													</td>
												</tr>
										<?php
										}
										?>
										<tr>
										  <td height="40">Serv.Taller</td>
										  	<td>
												<select name="rTaller">
													<?php if($rTaller == 'on'){?>
														<option 			value="off">No</option>
														<option selected 	value="on" >Si</option>
													<?php }else{?>
														<option selected	value="off">No</option>
														<option 		 	value="on" >Si</option>
													<?php } ?>
												</select>
											</td>
										</tr>
									</table>
								
								</td>
							</tr>
						</table>
					</td>
				</tr>
		  		<tr>
					<td colspan="3" height="50" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px; ">
					<?php
						echo $accion;
						if($accion == 'Guardar' || $accion == 'Editar' || $accion == 'Actualizar'){?>
							<div id="botonImagen">
								<button name="guardarIdOtam" style="float:right;" title="Guardar Identificación OTAM">
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
