<?php 	
	session_start(); 
	header('Content-Type: text/html; charset=iso-8859-1');

	include_once("../conexionli.php"); 
	$RAM 		= $_GET[RAM];
	$idItem 	= $_GET[idItem];
	$accion  	= $_GET[accion];

	$fechaApertura 	= date('Y-m-d');
	$encNew = 'Si';

	$link=Conectarse();
	$bdMu=$link->query("SELECT * FROM amMuestras Where idItem = '".$idItem."'");
	if($rowMu=mysqli_fetch_array($bdMu)){
		$idMuestra	= $rowMu[idMuestra];
		$Taller		= $rowMu[Taller];
	}
	
	$OtamsT = $RAM.'-T';
	
	$sql 		= "SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$OtamsT."%'";  // sentencia sql
	$result 	= $link->query($sql);
	$nTraccion 	= mysqli_num_rows($result); // obtenemos el número de Otams Traccion

	$OtamsQ = $RAM.'-Q';
	
	$sql 		= "SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$OtamsQ."%'";  // sentencia sql
	$result 	= $link->query($sql);
	$nQuimico 	= mysqli_num_rows($result); // obtenemos el n�mero de Otams Qu�micos

	$OtamsCh = $RAM.'-Ch';
	
	$sql 		= "SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$OtamsCh."%'";  // sentencia sql
	$result 	= $link->query($sql);
	$nCharpy 	= mysqli_num_rows($result); // obtenemos el n�mero de Otams Qu�micos

	$OtamsD = $RAM.'-D';
	
	$sql 		= "SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$OtamsD."%'";  // sentencia sql
	$result 	= $link->query($sql);
	$nDureza 	= mysqli_num_rows($result); // obtenemos el n�mero de Otams Qu�micos

	$OtamsO = $RAM.'-O';
	
	$sql 		= "SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$OtamsO."%'";  // sentencia sql
	$result 	= $link->query($sql);
	$nOtra 	= mysqli_num_rows($result); // obtenemos el n�mero de Otams Qu�micos
	
	$link->close();
?>

<style>
.Estilo2 {color: #FFFFFF; font-weight: bold; }
</style>
<script language="javascript">
	document.getElementById("Cuerpo").style.visibility="hidden";
	document.getElementById("cajaRegistraPruebas").style.visibility="visible";
</script>
<div id="bloqueoTrasperente">
	<div id="cajaRegistraPruebas">
		<center>
		<form name="form" action="idMuestras.php" method="get">
			<table width="99%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
				<tr>
					<td colspan="4" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
						<img src="../imagenes/poster_teachers.png" width="50" align="middle">
						<span style="color:#FFFFFF; font-size:25px; font-weight:700;">
							Identificaci&oacute;n de Muestras Formulario RAM <?php echo $RAM; ?> muestra Id.SIMET <span style=" color:#FFFF00; font-weight:700; "> <?php echo $idItem; ?></span>
							<?php echo $Existe;?>
							<div id="botonImagen">
								<?php 
									$prgLink = 'idMuestras.php?accion=Ver&RAM='.$RAM;
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
							<input name="accion" 		id="accion" 	type="hidden" value="<?php echo $accion; 		?>">
						</strong>										
					</td>
			  	</tr>
				<tr>
					<td height="93">
						<table width="100%" cellpadding="0" cellspacing="0" class="cuadroInformes">
							<tr>
							  <td height="40" valign="top">Necesita S. a Taller </td>
							  <td width="62%" valign="top">
							  	<select name="Taller">
									<?php if($Taller == 'on'){?>
											<option selected 	value="on" >Si</option>
											<option 			value='off'>No</option>
									<?php }else{ ?>
											<option 	 		value="on" >Si</option>
											<option selected 	value='off'>No</option>
									<?php } ?>
                              	</select>
							  </td>
							  <td width="20%" rowspan="2">
								  <table align="center" width="30%" style="border:1px solid #ccc;">
									  <tr bordercolor="#003366" bgcolor="#999999">
										  <td height="60"><div align="center" class="Estilo2">Ensayos</div></td>
										  <td><span class="Estilo2">Cant.</span></td>
										  <td><div align="center" class="Estilo2">Tipo<br>Ensayo</div></td>
									      <td><span class="Estilo2">Ind.<br>Imp.</span></td>
									      <td><span class="Estilo2">Tem.</span></td>
									      <td><span class="Estilo2">Ref</span>.</td>
									  </tr>
									  <tr>
									  	  <td height="40">Tracci&oacute;n</td>
									  	  <td align="center">
										  	<input type="number" name="nTraccion" id="nTraccion"  min="0" max="99" value="<?php echo $nTraccion; ?>">
										  </td>
									  	  <td align="right">
										  	<select name="tpMuestraTr">
												<option></option>
										  		<?php
													$idEnsayo = 'Tr';
													$sql = "SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$OtamsT."%'";  // sentencia sql
													$link=Conectarse();
													$bdTm=$link->query($sql);
													if($rowTm=mysqli_fetch_array($bdTm)){
														$tpMuestraTr = $rowTm['tpMuestra'];
													}
													
													$SQL = "SELECT * FROM amTpsMuestras Where idEnsayo = '".$idEnsayo."'";
													$bdTm=$link->query($SQL);
													if($rowTm=mysqli_fetch_array($bdTm)){
														do{?>
																<?php if($tpMuestraTr == $rowTm[tpMuestra]){?>
																		<option selected 	value="<?php echo $rowTm[tpMuestra]; ?>"><?php echo $rowTm[Muestra]; ?></option>
																<?php }else{ ?>
																		<option  			value="<?php echo $rowTm[tpMuestra]; ?>"><?php echo $rowTm[Muestra]; ?></option>
																<?php } ?>
															<?php
														}while($rowTm=mysqli_fetch_array($bdTm));
													}
													$link->close();
										  		?>
										  	</select>
										  </td>
									      <td align="center">&nbsp;</td>
									      <td align="center">&nbsp;</td>
									      <td align="center">
										  	<select name="RefTr">
												<option></option>
										  		<?php
													$link=Conectarse();
													$SQL = "SELECT * FROM amTabEnsayos Where idItem = '".$idItem."' and idEnsayo = 'Tr'";
													$bdTe=$link->query($SQL);
													if($rowTe=mysqli_fetch_array($bdTe)){
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
																<option 		 	value="SR">SR</option>
																<option  			value="CR">CR</option>
																<?php
															}
														}
													}else{?>
															<option 		 	value="SR">SR</option>
															<option  			value="CR">CR</option>
													<?php
													}
													$link->close();
										  		?>
										  	</select>
										  </td>
									  </tr>
									  <tr>
										  <td height="40">Qu&iacute;mico</td>
									  	  <td align="center"><input type="number" name="nQuimico" id="nQuimico"  min="0" max="99" value="<?php echo $nQuimico; ?>"></td>
									  	  <td align="right">
										  	<select name="tpMuestraQu">
												<option></option>
										  		<?php
													$idEnsayo = 'Qu';

													$sql = "SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$OtamsQ."%'";  // sentencia sql
													$link=Conectarse();
													$bdTm=$link->query($sql);
													if($rowTm=mysqli_fetch_array($bdTm)){
														$tpMuestraQu = $rowTm['tpMuestra'];
													}
													
													$SQL = "SELECT * FROM amTpsMuestras Where idEnsayo = '".$idEnsayo."'";
													$bdTm=$link->query($SQL);
													if($rowTm=mysqli_fetch_array($bdTm)){
														do{?>
																<?php if($tpMuestraQu == $rowTm[tpMuestra]){?>
																		<option selected 	value="<?php echo $rowTm[tpMuestra]; ?>"><?php echo $rowTm[Muestra]; ?></option>
																<?php }else{ ?>
																		<option  			value="<?php echo $rowTm[tpMuestra]; ?>"><?php echo $rowTm[Muestra]; ?></option>
																<?php } ?>
															<?php
														}while($rowTm=mysqli_fetch_array($bdTm));
													}
													$link->close();
										  		?>
										  	</select>
										  
										  </td>
									      <td align="center">&nbsp;</td>
									      <td align="center">&nbsp;</td>
									      <td align="center">
										  	<select name="RefQu">
												<option></option>
										  		<?php
													$link=Conectarse();
													$SQL = "SELECT * FROM amTabEnsayos Where idItem = '".$idItem."' and idEnsayo = 'Qu'";
													$bdTe=$link->query($SQL);
													if($rowTe=mysqli_fetch_array($bdTe)){
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
																<option 		 	value="SR">SR</option>
																<option  			value="CR">CR</option>
																<?php
															}
														}
													}else{?>
															<option 		 	value="SR">SR</option>
															<option  			value="CR">CR</option>
													<?php
													}
													$link->close();
										  		?>
										  	</select>
										  </td>
									  </tr>
									  <tr>
									    <td height="40">Charpy</td>
									  	  <td align="center"><input type="number" name="nCharpy" id="nCharpy"  min="0" max="99" value="<?php echo $nCharpy; ?>"></td>
									  	  <td align="right">
										  	<select name="tpMuestraCh">
												<option></option>
										  		<?php
													$idEnsayo = 'Ch';

													$sql = "SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$OtamsCh."%'";  // sentencia sql
													$link=Conectarse();
													$bdTm=$link->query($sql);
													if($rowTm=mysqli_fetch_array($bdTm)){
														$tpMuestraCh 	= $rowTm['tpMuestra'];
														$Imp 			= $rowTm['Ind'];
														$Tem 			= $rowTm['Tem'];
													}

													$SQL = "SELECT * FROM amTpsMuestras Where idEnsayo = '".$idEnsayo."'";
													$link=Conectarse();
													$bdTm=$link->query($SQL);
													if($rowTm=mysqli_fetch_array($bdTm)){
														do{?>
																<?php if($tpMuestraCh == $rowTm[tpMuestra]){?>
																		<option selected 	value="<?php echo $rowTm[tpMuestra]; ?>"><?php echo $rowTm[Muestra].' '.$Imp; ?></option>
																<?php }else{ ?>
																		<option  			value="<?php echo $rowTm[tpMuestra]; ?>"><?php echo $rowTm[Muestra].' '.$Imp; ?></option>
																<?php } ?>
															<?php
														}while($rowTm=mysqli_fetch_array($bdTm));
													}
													$link->close();
										  		?>
										  	</select>
										  
										  </td>
									      <td align="center">
												<input type="text" name="Imp" id="Imp" maxlength="5" size="5" value="<?php echo $Imp; ?>">
										  </td>
									      <td align="center">
												<input type="text" name="Tem" id="Tem" maxlength="10" size="10" value="<?php echo $Tem; ?>">
										  </td>
									      <td align="center">
										  	<select name="RefCh">
												<option></option>
										  		<?php
													$link=Conectarse();
													$SQL = "SELECT * FROM amTabEnsayos Where idItem = '".$idItem."' and idEnsayo = 'Ch'";
													$bdTe=$link->query($SQL);
													if($rowTe=mysqli_fetch_array($bdTe)){
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
																<option 		 	value="SR">SR</option>
																<option  			value="CR">CR</option>
																<?php
															}
														}
													}else{?>
															<option 		 	value="SR">SR</option>
															<option  			value="CR">CR</option>
													<?php
													}
													$link->close();
										  		?>
										  	</select>
										  </td>
									  </tr>
									  <tr>
									    <td height="40">Dureza</td>
									  	  <td align="center"><input type="number" name="nDureza" id="nDureza"  min="0" max="99" value="<?php echo $nDureza; ?>"></td>
									  	  <td align="right">
										  	<select name="tpMuestraDu">
												<option></option>
										  		<?php
													$idEnsayo = 'Du';

													$sql = "SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$OtamsD."%'";  // sentencia sql
													$link=Conectarse();
													$bdTm=$link->query($sql);
													if($rowTm=mysqli_fetch_array($bdTm)){
														$tpMuestraDu 	= $rowTm['tpMuestra'];
														$Ind 			= $rowTm['Ind'];
													}

													$SQL = "SELECT * FROM amTpsMuestras Where idEnsayo = '".$idEnsayo."'";
													$link=Conectarse();
													$bdTm=$link->query($SQL);
													if($rowTm=mysqli_fetch_array($bdTm)){
														do{?>
																<?php if($tpMuestraDu == $rowTm[tpMuestra]){?>
																		<option selected 	value="<?php echo $rowTm[tpMuestra]; ?>"><?php echo $rowTm[Muestra]; ?></option>
																<?php }else{ ?>
																		<option  			value="<?php echo $rowTm[tpMuestra]; ?>"><?php echo $rowTm[Muestra]; ?></option>
																<?php } ?>
															<?php
														}while($rowTm=mysqli_fetch_array($bdTm));
													}
													$link->close();
										  		?>
										  	</select>
										  
										  </td>
									      <td align="center">
												<input type="number" name="Ind" id="Ind" min="0" max="9" value="<?php echo $Ind; ?>">
										  </td>
									      <td align="center">&nbsp;</td>
									      <td align="center">
										  	<select name="RefDu">
												<option></option>
										  		<?php
													$link=Conectarse();
													$SQL = "SELECT * FROM amTabEnsayos Where idItem = '".$idItem."' and idEnsayo = 'Du'";
													$bdTe=$link->query($SQL);
													if($rowTe=mysqli_fetch_array($bdTe)){
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
																<option 		 	value="SR">SR</option>
																<option  			value="CR">CR</option>
																<?php
															}
														}
													}else{?>
															<option 		 	value="SR">SR</option>
															<option  			value="CR">CR</option>
													<?php
													}
													$link->close();
										  		?>
										  	</select>
										  </td>
									  </tr>
									  <tr>
									    <td height="40">Otra</td>
									  	  <td align="center"><input type="number" name="nOtra" id="nOtra" min="0" max="99" value="<?php echo $nOtra; ?>"></td>
									  	  <td align="center">&nbsp;
										  </td>
									      <td align="center">&nbsp;</td>
									      <td align="center">&nbsp;</td>
									      <td align="center">&nbsp;</td>
									  </tr>
							  	</table>
							  </td>
						  </tr>
							<tr>
								<td width="18%" height="40" valign="top">Id.Muestra Cliente </td>
								<td valign="top">
									<textarea name="idMuestra" id="idMuestra" cols="30" rows="10" autofocus><?php echo $idMuestra; ?></textarea>
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
								<button name="guardarIdMuestra" style="float:right;" title="Guardar Muestras">
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
