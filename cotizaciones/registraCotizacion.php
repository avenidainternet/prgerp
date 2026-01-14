<?php 	
	//ini_set("session.cookie_lifetime","36000");
	//ini_set("session.gc_maxlifetime","36000");
	session_start(); 
	header('Content-Type: text/html; charset=utf-8');
	include_once("../conexionli.php"); 

	$usrCotizador 		= $_SESSION['usr'];
	$CAM 				= 0;
	$Rev 				= 0;
	$Cta 				= 0;
	$Cliente 			= '';
	$nContacto 			= 0;
	$Atencion 			= '';
	$correoAtencion 	= '';
	$Descripcion		= '';
	$EstadoCot			= '';
	$Validez			= 30;
	$dHabiles			= 30;
	$obsServicios		= '';
	$Observacion		= '';
	$fechaAceptacion	= date('Y-m-d');;
	$exentoIva			= '';
	$OFE				= 'off';
	

	if(isset($_GET['CAM']))  	{ $CAM 		= $_GET['CAM']; 	}
	if(isset($_POST['CAM'])) 	{ $CAM 		= $_POST['CAM']; 	}
	
	if(isset($_GET['Rev']))  	{ $Rev 		= $_GET['Rev'];		}
	if(isset($_GET['Cta']))  	{ $Cta 		= $_GET['Cta'];		}
	if(isset($_GET['accion'])) 	{ $accion 	= $_GET['accion'];	}
	if(isset($_GET['Cliente'])) { $Cliente 	= $_GET['RutCli'];	}
	
	$Sw 				= 'G';
	$Estado 			= '';
	$fechaCotizacion 	= date('Y-m-d');
	$encNew 			= 'Si';
	$tpEnsayo			= 0;

	if($CAM == 0){
		$Sw = 'G';
/*		
		$link=Conectarse();
		$bdCot=$link->query("Select * From Cotizaciones Order By CAM Desc");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$CAM = $rowCot[CAM] + 1;
			$usrCotizador = $_SESSION[usr];
			$link->query("insert into Cotizaciones	(
														CAM,
														fechaCotizacion,
														usrCotizador
													)	 
										  values 	(	'$CAM',
										  				'$fechaCotizacion',
														'$usrCotizador'
										  			)");
		}
		$link->close();
*/
		$accion 	= 'Guardar';
		$Atencion 	= 'Seleccionar';
	}else{
		$link=Conectarse();
		$bdCot=$link->query("SELECT * FROM Cotizaciones Where CAM = '".$CAM."' and Rev = '".$Rev."' and Cta = '".$Cta."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$RAM 				= $rowCot['RAM'];
			$Rev 				= $rowCot['Rev'];
			$Cta 				= $rowCot['Cta'];
			$fechaCotizacion 	= $rowCot['fechaCotizacion'];
			$usrCotizador 		= $rowCot['usrCotizador'];
			$Cliente 			= $rowCot['RutCli'];
			$nContacto 			= $rowCot['nContacto'];
			$Atencion 			= $rowCot['Atencion'];
			$correoAtencion 	= $rowCot['correoAtencion'];
			$Descripcion		= $rowCot['Descripcion'];
			$EstadoCot			= $rowCot['Estado'];
			$Validez			= $rowCot['Validez'];
			$dHabiles			= $rowCot['dHabiles'];
			$obsServicios		= $rowCot['obsServicios'];
			$Observacion		= $rowCot['Observacion'];
			$fechaAceptacion	= $rowCot['fechaAceptacion'];
			$exentoIva			= $rowCot['exentoIva'];
			$tpEnsayo			= $rowCot['tpEnsayo'];
			$OFE				= $rowCot['OFE'];
		}
		$link->close();
		$encNew = 'No';
	}
?>


<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Intranet Simet</title>
	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">
</head>

<body onLoad="cambiar()">

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
								for($i=1; $i<=60; $i++){
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
							$bdCli=$link->query("SELECT * FROM Usuarios Order By usuario");
							if($rowCli=mysqli_fetch_array($bdCli)){
								do{
									if($rowCli['nPerfil']  == 1 or $rowCli['nPerfil']  == '01' or $rowCli['nPerfil']  == '02'){
									
										if($usrCotizador){
											if($usrCotizador == $rowCli['usr']){
												echo '<option selected value='.$rowCli['usr'].'>'.$rowCli['usuario'].'</option>';
											}else{
												echo '<option value='.$rowCli['usr'].'>'.$rowCli['usuario'].'</option>';
											}
										}else{
											if($_SESSION['usr'] == $rowCli['usr']){
												echo '<option selected value='.$rowCli['usr'].'>'.$rowCli['usuario'].'</option>';
											}else{
												echo '<option value='.$rowCli['usr'].'>'.$rowCli['usuario'].'</option>';
											}
										}
									}
								}while ($rowCli=mysqli_fetch_array($bdCli));
							}
							$link->close();
							?>
						</select>
					</td>
					<td colspan="2" rowspan="2" class="lineaDerBot">
						Exenta de Iva
					  <?php if($exentoIva=='on'){?>
							<input type="checkbox" name="exentoIva" checked>
						<?php }else{ ?>
							<input type="checkbox" name="exentoIva">
						<?php } ?>
						
					</td>
				</tr>
				<tr>
					<td class="lineaDerBot">Empresa / Cliente  :</td>
					<td class="lineaDerBot">
						<select name="Cliente" Id="Cliente" onChange="buscarContactos($('#Cliente').val(), $('#Atencion').val(), $('#nContacto').val())" style="font-size:12px; font-weight:700;">
							<option value=""></option>
							<?php
							$link=Conectarse();
							$bdCli=$link->query("SELECT * FROM Clientes Order By Cliente");
							if($rowCli=mysqli_fetch_array($bdCli)){
								do{
									if($rowCli['Estado'] == 'on'){
										if($rowCli['RutCli'] == $Cliente){
											echo '<option selected value='.$rowCli['RutCli'].'>'.$rowCli['Cliente'].'</option>';
										}else{
											echo '<option value='.$rowCli['RutCli'].'>'.$rowCli['Cliente'].'</option>';
										}
									}
								}while ($rowCli=mysqli_fetch_array($bdCli));
							}
							$link->close();
							?>
					</select>				
					</td>
				</tr>
				<tr>
				  <td valign="top" class="lineaDerBot">Atenci&oacute;n:</td>
				  <td height="25" colspan="3" valign="top" class="lineaDerBot">
						<div id="mContacto"></div>
						<?php
							if($Cliente){?>
								<!-- <input name="Atencion" 		id="Atencion" 		type="hidden" value="<?php echo $Atencion; ?>"> -->
								<?php
							}
						?>
<!--						
						<span id="resultadoContacto"></span>
-->						
						<span id="rDatosContacto"></span>
					<!-- 					<input name="Atencion" 		id="Atencion" 		type="text" size="50" value="<?php echo $Atencion; ?>" 		style="font-size:12px; font-weight:700;"> -->		  		</td>
				</tr>
				<tr>
				  <td valign="top" class="lineaDerBot">Tipo Ensayo: </td>
				  <td colspan="3" class="lineaDerBot">
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
				  <td valign="top" class="lineaDerBot">OFE</td>
				  <td colspan="3" class="lineaDerBot">
					<select name="OFE">
						<?php if($OFE == '' or $OFE == 'off'){?>
								<option selected 	value="off">Sin OFE</option>
								<option  			value="on" >Con OFE</option>
						<?php } ?>
						<?php if($OFE == 'on'){?>
								<option  			value="off">Sin OFE</option>
								<option selected 	value="on" >Con OFE</option>
						<?php } ?>
					</select>
				  </td>
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
</body>
</html>
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	

<script>
	function buscarContactos(Cliente){
		var parametros = {
			"Cliente" 	: Cliente
		};
		//alert(Cliente);
		$.ajax({
			data: parametros,
			url: 'listaContactosClientes.php',
			type: 'get',
			success: function (response) {
				$("#mContacto").html(response);
			}
		});
	}
	function datosContactos(Cliente, Atencion){
		var parametros = {
			"Cliente" 	: Cliente,
			"Atencion"	: Atencion
		};
		//alert(Atencion);
		$.ajax({
			data: parametros,
			url: 'datosDelContacto.php',
			type: 'get',
			success: function (response) {
				$("#rDatosContacto").html(response);
			}
		});
	}
	
</script>