<?php 	
	session_start(); 
	header('Content-Type: text/html; charset=utf-8');

	include_once("conexion.php"); 
	
	$Cliente		= '';
	$Contacto		= '';
	$nMuestras		= 0;
	$fechaInicio	= '0000-00-00';
	$ingResponsable	= '';
	$cooResponsable	= '';
	$Taller			= '';
	$Obs			= '';
	$prg			= '';
	
	if(isset($_GET['RAM'])) 	{ $RAM 		= $_GET['RAM'];		}
	if(isset($_GET['CAM'])) 	{ $CAM 		= $_GET['CAM'];		}
	if(isset($_GET['accion'])) 	{ $accion  	= $_GET['accion'];	}
	if(isset($_GET['prg'])) 	{ $prg	 	= $_GET['prg'];		}

	$fechaApertura 	= date('Y-m-d');
	$encNew = 'Si';

	$link=Conectarse();
	$bdfRAM=mysql_query("SELECT * FROM formRAM Where RAM = '".$RAM."' and CAM = '".$CAM."'");
	if($rowfRAM=mysql_fetch_array($bdfRAM)){
		$nMuestras		= $rowfRAM['nMuestras'];
		$fechaInicio	= $rowfRAM['fechaInicio'];
		$ingResponsable	= $rowfRAM['ingResponsable'];
		$cooResponsable	= $rowfRAM['cooResponsable'];
		$Obs			= $rowfRAM['Obs'];
		$Taller			= $rowfRAM['Taller'];
	}
	$bdCot=mysql_query("SELECT * FROM Cotizaciones Where RAM = '".$RAM."' and CAM = '".$CAM."'");
	if($rowCot=mysql_fetch_array($bdCot)){
		$RutCli			= $rowCot['RutCli'];
		$nContacto		= $rowCot['nContacto'];
		$fechaInicio	= $rowCot['fechaInicio'];
		$ingResponsable	= $rowCot['usrResponzable'];
	}
	$bdCot=mysql_query("SELECT * FROM Clientes Where RutCli = '".$RutCli."'");
	if($rowCot=mysql_fetch_array($bdCot)){
		$Cliente	= $rowCot['Cliente'];
	}
	$bdCot=mysql_query("SELECT * FROM contactosCli Where RutCli = '".$RutCli."' and nContacto = '".$nContacto."'");
	if($rowCot=mysql_fetch_array($bdCot)){
		$Contacto	= $rowCot['Contacto'];
	}
	mysql_close($link);
?>

<style></style>
<script language="javascript">
	document.getElementById("Cuerpo").style.visibility="hidden";
	document.getElementById("cajaRegistraPruebas").style.visibility="visible";
</script>
<div id="bloqueoTrasperente">
	<div id="cajaRegistraPruebas">
		<center>
		<form name="form" action="pOtams.php" method="get">
			<table width="99%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
				<tr>
					<td colspan="4" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
						<img src="../imagenes/consulta.png" width="50" align="middle">
						<span style="color:#FFFFFF; font-size:25px; font-weight:700;">
							Generación de Formulario RAM <?php echo $RAM.'-'.$CAM; ?>
							<div id="botonImagen">
								<?php 
									$prgLink = 'pOtams.php';
									if($prg=='Procesos'){
										$prgLink = '../cotizaciones/plataformaCotizaciones.php';
									}
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
							<input name="CAM" 			id="CAM" 		type="hidden" value="<?php echo $CAM; 			?>" />
							<input name="RutCli" 		id="RutCli" 	type="hidden" value="<?php echo $RutCli;		?>" />
							<input name="accion" 		id="accion" 	type="hidden" value="<?php echo $accion; 		?>">
						</strong>										
					</td>
			  	</tr>
				<tr>
					<td height="93">
						<table width="100%" cellpadding="0" cellspacing="0" class="cuadroInformes">
							<tr>
								<td width="19%" height="40">Cliente </td>
								<td colspan="3" valign="top">: <?php echo $Cliente; ?></td>
							</tr>
							<tr>
								<td height="40">Solicitante</td>
								<td colspan="3">: <?php echo $Contacto; ?></td>
							</tr>
							<tr>
								<td height="40">Cantidad de Muestras </td>
								<td width="27%">: 
									<select name="nMuestras">
										<?php 
											for($i=1; $i<=100; $i++){
												if($nMuestras == $i){
												?>
													<option selected value="<?php echo $i;?>"><?php echo $i; ?></option>
												<?php }else{ ?>
													<option value="<?php echo $i;?>"><?php echo $i; ?></option>
												<?php
												} 
											} 
										?>
									</select>
								</td>
								<td width="19%">Fecha Inicio</td>
								<td width="35%">: 
									<input name="fechaInicio" id="fechaInicio" type="date" value="<?php echo $fechaInicio; ?>">
								</td>
							</tr>
							<tr>
							  <td height="40">Responsable</td>
							  <td>: 
							    <select name="ingResponsable">
                                	<?php
										$link=Conectarse();
										$bdUsr=mysql_query("SELECT * FROM Usuarios Where responsableInforme = 'on'");
										if($rowUsr=mysql_fetch_array($bdUsr)){
											do{
												if($rowUsr['usr'] == $ingResponsable){
													?>
                                						<option selected 	value="<?php echo $rowUsr['usr'];?>"><?php echo $rowUsr['usuario']; ?></option>
                                					<?php 
													}else{
													?>
                                						<option 			value="<?php echo $rowUsr['usr'];?>"><?php echo $rowUsr['usuario']; ?></option>
                                					<?php
												}
											}while($rowUsr=mysql_fetch_array($bdUsr));
										} 
										mysql_close($link);
									?>
                              		</select>
								</td>
							  <td>Corresponsable</td>
							  <td>: 
							    <select name="cooResponsable">
                                <option></option>
                                	<?php
									$link=Conectarse();
									$bdUsr=mysql_query("SELECT * FROM Usuarios Where responsableInforme = 'on'");
									if($rowUsr=mysql_fetch_array($bdUsr)){
										do{
											if($rowUsr['usr'] == $cooResponsable ){
												?>
	    	                            			<option selected value="<?php echo $rowUsr['usr'];?>"><?php echo $rowUsr['usuario']; ?></option>
												<?php }else{ ?>
    	                            				<option value="<?php echo $rowUsr['usr'];?>"><?php echo $rowUsr['usuario']; ?></option>
        	                        			<?php 
											}
										}while($rowUsr=mysql_fetch_array($bdUsr));
									} 
									mysql_close($link);
									?>
                              	</select>
							  </td>
						  </tr>
							<tr>
							  <td height="40">Necesita S. a Taller </td>
							  <td colspan="3">: 
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
						  	</tr>
							<tr>
								<td height="40" valign="top">Observaciones</td>
								<td colspan="3">
							    <textarea name="Obs" cols="80" rows="10"><?php echo $Obs; ?></textarea></td>
							</tr>
						</table>
					</td>
				</tr>
		  		<tr>
					<td colspan="4" height="50" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px; ">
					<?php
						echo $accion;
						if($accion == 'Guardar' || $accion == 'Nuevo' || $accion == 'Actualizar'){?>
							<div id="botonImagen">
								<button name="guardarFormularioRAM" style="float:right;" title="Guardar Muestras">
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
