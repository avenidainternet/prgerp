<?php 	
	session_start(); 
	header('Content-Type: text/html; charset=utf-8');
	include_once("../conexionli.php"); 
	$Rev 	= 0;
	$nInformeCorrectiva = '';
	if(isset($_GET['nInformeCorrectiva'])) 	{ $nInformeCorrectiva 	= $_GET['nInformeCorrectiva'];	}
	if(isset($_GET['accion'])) 				{ $accion 				= $_GET['accion'];				}
	$fechaApertura 			= date('Y-m-d');
	$encNew = 'Si';
	
	$oriOtrosTxt 			= '';
	$accFechaTen 			= '0000-00-00';
	$accFechaApli 			= '0000-00-00';
	$usrResponsable 		= '';
	$usrCalidad 			= '';
	$accFechaImp 			= '0000-00-00';
	$fechaCierre 			= '0000-00-00';
	$fteRecCliExt 			= '';
	$fteNroRecCliExt 		= '';
	$oriSisGesFecha 		= '0000-00-00';
	$fteRecCliInt 			= '';
	$oriSisGes 				= '';
	$fteNroRecCliInt 		= 0;
	$oriNroAso 				= 0;
	$fteAut 				= '';
	$fteAutFecha 			= '0000-00-00';
	$oriLeyRegFecha 		= '0000-00-00';
	$fteAudInt 				= '';
	$fteAudIntFecha 		= '0000-00-00';
	$oriTncFecha 			= '0000-00-00';
	$fteAudExt 				= '';
	$fteAudExtFecha 		= '0000-00-00';
	$oriInterLabFecha 		= '0000-00-00';
	$fteOtros 				= '';
	$fteOtrosTxt 			= '';
	$desClasNoConf 			= '';
	$oriEnsayos 			= '';
	$oriLeyReg 				= '';
	$oriTnc 				= '';
	$oriInterLab 			= '';
	$oriOtros 				= '';
	$desClasObs 			= '';
	$desIdentificacion 		= '';
	$desHallazgo			= '';
	$desEvidencia			= '';
	$Causa					= '';
	$accCorrecion			= '';
	$accAccionCorrectiva 	= '';
	$verResAccCorr			= '';
	$actRiesgos				= "";
	$hallazgo				= "";
	$nCorrectiva			= "";
	$Apelacion				= "";
	$fteApelacion			= "";
	$Certificacion			= "";
	$oriCertificacion		= "";

	if($nInformeCorrectiva == 0){
		$link=Conectarse();
		$bddCot=$link->query("Select * From accionesCorrectivas Order By nInformeCorrectiva Desc");
		if($rowdCot=mysqli_fetch_array($bddCot)){
			$nInformeCorrectiva = $rowdCot['nInformeCorrectiva'] + 1;
		}else{
			$nInformeCorrectiva = 1;
		}
		$link->close();
	}else{
		$link=Conectarse();
		$bdCot=$link->query("SELECT * FROM accionesCorrectivas Where nInformeCorrectiva = '".$nInformeCorrectiva."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$fechaApertura			= $rowCot['fechaApertura'];
			$usrApertura			= $rowCot['usrApertura'];
			$fteRecCliExt			= $rowCot['fteRecCliExt'];
			$fteNroRecCliExt		= $rowCot['fteNroRecCliExt'];
			$fteRecCliInt			= $rowCot['fteRecCliInt'];
			$fteNroRecCliInt		= $rowCot['fteNroRecCliInt'];
			$fteAut					= $rowCot['fteAut'];
			$fteAutFecha			= $rowCot['fteAutFecha'];
			$fteAudInt				= $rowCot['fteAudInt'];
			$fteAudIntFecha			= $rowCot['fteAudIntFecha'];
			$fteAudExt				= $rowCot['fteAudExt'];
			$fteAudExtFecha			= $rowCot['fteAudExtFecha'];
			$fteOtros				= $rowCot['fteOtros'];
			$fteOtrosTxt			= $rowCot['fteOtrosTxt'];
			$oriSisGes				= $rowCot['oriSisGes'];
			$oriSisGesFecha			= $rowCot['oriSisGesFecha'];
			$oriEnsayos				= $rowCot['oriEnsayos'];
			$oriNroAso				= $rowCot['oriNroAso'];
			$oriLeyReg				= $rowCot['oriLeyReg'];
			$oriLeyRegFecha			= $rowCot['oriLeyRegFecha'];
			$oriTnc					= $rowCot['oriTnc'];
			$oriTncFecha			= $rowCot['oriTncFecha'];
			$oriInterLab			= $rowCot['oriInterLab'];
			$oriInterLabFecha		= $rowCot['oriInterLabFecha'];
			$oriOtros				= $rowCot['oriOtros'];
			$oriOtrosTxt			= $rowCot['oriOtrosTxt'];
			$desClasNoConf			= $rowCot['desClasNoConf'];
			$desClasObs				= $rowCot['desClasObs'];
			$desIdentificacion		= $rowCot['desIdentificacion'];
			$desHallazgo			= $rowCot['desHallazgo'];
			$desEvidencia			= $rowCot['desEvidencia'];
			$Causa					= $rowCot['Causa'];
			$accCorrecion			= $rowCot['accCorrecion'];
			$accAccionCorrectiva	= $rowCot['accAccionCorrectiva'];
			$accFechaImp			= $rowCot['accFechaImp'];
			$accFechaTen			= $rowCot['accFechaTen'];
			$accFechaApli			= $rowCot['accFechaApli'];
			$accFechaVer			= $rowCot['accFechaVer'];
			$verResAccCorr			= $rowCot['verResAccCorr'];
			$usrEncargado			= $rowCot['usrEncargado'];
			$usrCalidad				= $rowCot['usrCalidad'];
			$usrResponsable		 	= $rowCot['usrResponsable'];
			$fechaCierre			= $rowCot['fechaCierre'];
			$verCierreAccion		= $rowCot['verCierreAccion'];
			$actRiesgos				= $rowCot['actRiesgos'];
			$hallazgo				= $rowCot['hallazgo'];
			$nCorrectiva			= $rowCot['nCorrectiva'];
			$Apelacion				= $rowCot['Apelacion'];
			$fteApelacion			= $rowCot['fteApelacion'];
			$Certificacion			= $rowCot['Certificacion'];
			$oriCertificacion		= $rowCot['oriCertificacion'];
		}
		$link->close();
		$encNew = 'No';
	}
?>

<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Intranet Simet -> Acciones Correctivas</title>
	
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	
	<script type="text/javascript" src="../angular/angular.js"></script>

	<link href="styles.css" rel="stylesheet" type="text/css">
	<!--
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">
-->
	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">

<body ng-app="myApp" ng-controller="CtrlCorrectivas" ng-init="loadData('<?php echo $nInformeCorrectiva; ?>')">

	<div class="container-fluid" >
		<form name="form" action="accionesCorrectivas.php" method="post">
			<table width="99%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
				<tr>
					<td colspan="5" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
						<img src="../imagenes/about_us_close_128.png" width="50" align="middle">
						<span style="color:#FFFFFF; font-size:25px; font-weight:700;">
							Formulario Acciones Correctivas 
							<div id="botonImagen">
								<?php 
									$prgLink = 'accionesCorrectivas.php';
									echo '<a href="'.$prgLink.'" style="float:right;"><img src="../imagenes/no_32.png"></a>';
								?>
							</div>
						</span>
					</td>
				</tr>
				<tr>
					<td colspan="3" rowspan="2" class="lineaDerBot">
						<strong style=" font-size:20px; font-weight:700; margin-left:10px;">
							Informe Acciónes Correctivas N°  {{nInformeCorrectiva}}
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
							Verificación Real 
					</td>
				</tr>
				<tr>
					<td width="19%">Fecha Apertura Acción </td>
					<td class="lineaDer">Responsable Implementación Acción:
					</td>
					<td class="lineaDer">Encargado de Calidad: </td>
					<td class="lineaBot" align="center">
						<input class="form-control" name="accFechaTen" id="accFechaTen" type="date"  value="<?php echo $accFechaTen; ?>" style="font-size:12px; font-weight:700;">
					</td>
					<td class="lineaBot" align="center">
						<input class="form-control" name="accFechaApli" id="accFechaApli" type="date"  value="<?php echo $accFechaApli; ?>" style="font-size:12px; font-weight:700;">
					</td>
				</tr>
				<tr>
					<td rowspan="2" class="lineaDerBot">
						<input class="form-control" ng-model="fechaApertura" name="fechaApertura" id="fechaApertura" type="date"  value="<?php echo $fechaApertura; ?>" style="font-size:12px; font-weight:700;" autofocus />
					</td>
					<td rowspan="2" class="lineaDerBot">

						<!-- <select ng-model="usrResponsable" class="form-control" required>
	                		<option value="">Responsable</option>
	                  		<option ng-repeat="x in dataUsuarios">
	                    		{{x.usrResponsable}}
	                  		</option>
	              		</select>
						{{usrResponsable}} <?php echo $usrResponsable; ?> -->


						<select class="form-control" name="usrResponsable" id="usrResponsable" style="font-size:12px; font-weight:700;">
							<?php
								$link=Conectarse();
								$bdCli=$link->query("SELECT * FROM Usuarios Order By usuario");
								while($rowCli=mysqli_fetch_array($bdCli)){
									$loginRes = $rowCli['usr'];
									if($rowCli['usr'] == $usrResponsable){
										echo '<option selected 	value='.$rowCli['usr'].'>'.$rowCli['usuario'].'</option>';
									}else{
										echo '<option 			value='.$rowCli['usr'].'>'.$rowCli['usuario'].'</option>';
									}
								}
								$link->close();
							?>
						</select>			  
					</td>
						<td rowspan="2" class="lineaDerBot">
							<select class="form-control" name="usrCalidad" id="usrCalidad" style="font-size:12px; font-weight:700;">
								<?php
								$link=Conectarse();
								$bdCli=$link->query("SELECT * FROM Usuarios Order By usuario");
								if($rowCli=mysqli_fetch_array($bdCli)){
									do{
										$loginRes = $rowCli['usr'];
										if($rowCli['usr'] == $usrCalidad){
											echo '<option selected 	value='.$rowCli['usr'].'>'.$rowCli['usuario'].'</option>';
										}else{
											echo '<option 			value='.$rowCli['usr'].'>'.$rowCli['usuario'].'</option>';
										}
									}while ($rowCli=mysqli_fetch_array($bdCli));
								}
								$link->close();
								?>
							</select>
						</td>
					<td class="lineaDerBot" align="center">Implementación</td>
					<td class="lineaDerBot" align="center">Fecha de Cierre</td>
				</tr>
				<tr>
					<td class="lineaBot" align="center">
						<input class="form-control" name="accFechaImp" id="accFechaImp" type="date"  value="<?php echo $accFechaImp; ?>" style="font-size:12px; font-weight:700;">
					</td>
					<td class="lineaBot" align="center">
						<input class="form-control" name="fechaCierre" id="fechaCierre" type="date"  value="<?php echo $fechaCierre; ?>" style="font-size:12px; font-weight:700;">
					</td>
				</tr>
				<tr>
					<td colspan="5" class="lineaDerBot">
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
										N° Reclamo 
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
									<input name="oriSisGesFecha" id="oriSisGesFecha" type="date" value="<?php echo $oriSisGesFecha; ?>" style="font-size:12px; font-weight:700;" />
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
										Nº Asociado
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
									<td>
										<?php
										if($fteApelacion=='on'){?>
											<input type="checkbox" name="fteApelacion" checked>
										<?php }else{ ?>
											<input type="checkbox" name="fteApelacion">
										<?php } ?>
										Apelación 
									</td>
									<td class="lineaDer">
										<input name="Apelacion"  id="Apelacion" name="Apelacion" type="text" size="50" maxlength="50" value="<?php echo $Apelacion; ?>" style="font-size:12px; font-weight:700;" />
									</td>
									<td>
										<?php
										if($oriCertificacion=='on'){?>
											<input type="checkbox" name="oriCertificacion" checked>
										<?php }else{ ?>
											<input type="checkbox" name="oriCertificacion">
										<?php } ?>
										Certificación 
									</td>
									<td>
										<input name="Certificacion" id="Certificacion" type="text" size="50" maxlength="50" value="<?php echo $Certificacion; ?>" style="font-size:12px; font-weight:700;" />
									</td>
								</tr>






								<tr>
									<td colspan="4">
										<hr>
										<b>En caso de tener otra fuente u origen, indicar a continuación:</b><br><br>
										<textarea class="form-control" rows="5" name="fteOtrosTxt" id="fteOtrosTxt"><?php echo $fteOtrosTxt; ?></textarea>
										<br>
									</td>
								</tr>
								<tr height="30" bgcolor="#0099CC" style="color:#000000; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px; font-weight:700;">
									<td colspan="4">3. Descripción del Hallazgo </td>
								</tr>
								<tr>
									<td colspan="4">
										<div class="row m-2">
											<div class="col-md-12">
												<b>¿El hallazgo es similar a otros ya existentes o es potencialmente probable de ocurrir?</b>
											</div>
											<div class="col-md-12">
												<?php
													if($hallazgo == "SI"){?>
														<input class="control-form m-2" ng-click="corrRelacionada=true" type="radio" name="hallazgo" value="SI" checked>Si
														<?php
													}else{?>
														<input class="control-form m-2" ng-click="corrRelacionada=true" type="radio" name="hallazgo"  value="SI">Si
													<?php
													}
												?>
												<?php
													if($hallazgo == "NO"){?>
														<input class="control-form m-2" type="radio" ng-click="corrRelacionada=false" name="hallazgo" value="NO" checked>NO
														<?php
													}else{?>
														<input class="control-form m-2" type="radio" ng-click="corrRelacionada=false" name="hallazgo"  value="NO">NO
													<?php
													}
												?>

												<label ng-show="corrRelacionada">AC Relacionada <input class="control-form m-2" type="text" name="nCorrectiva" size="10"></label>
											</div>
										</div>
										<div class="row m-2">
											<div class="col-md-12">
												<b>a) Clasificación </b>
											</div>
											<div class="col-md-12">
												<?php if($desClasNoConf=='on'){?>
													<input class="control-form m-2" name="Clasificacion" type="radio" value="N" checked> No Conformidad 
												<?php }else{ ?>
													<input class="control-form m-2" name="Clasificacion" type="radio" value="N"> No Conformidad 
												<?php } ?>
												<?php if($desClasObs=='on'){?>
													<input class="control-form m-2" name="Clasificacion" type="radio" value="O" checked> Observación 
												<?php }else{ ?>
													<input class="control-form m-2" name="Clasificacion" type="radio" value="O"> Observación 
												<?php } ?>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="4">
										<div class="row m-2">
											<div class="col-md-12">
												<b>b) Identificación del requerimiento normativo, legal o reglamentario afectado:</b>
											</div>
											<div class="col-md-12 p-1">
												<textarea class="form-control" name="desIdentificacion" cols="100" rows="5"><?php echo $desIdentificacion; ?></textarea>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="4">
										<div class="row m-2">
											<div class="col-md-12">
												<b>c) Hallazgo detectado:</b>
											</div>
											<div class="col-md-12 p-1">
												<textarea class="form-control" name="desHallazgo" cols="100" rows="5"><?php echo $desHallazgo; ?></textarea>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="4">
										<div class="row m-2">
											<div class="col-md-12">
												<b>d) Evidencia objetiva del hallazgo:</b>
											</div>
											<div class="col-md-12 p-1">
												<textarea class="form-control" name="desEvidencia" cols="100" rows="5"><?php echo $desEvidencia; ?></textarea>
											</div>
									</td>
								</tr>

								<tr height="30" bgcolor="#0099CC" style="color:#000000; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px; font-weight:700;">
									<td colspan="4">4. Causa raíz Hallazgo </td>
								</tr>
								<tr>
									<td colspan="4">
										<textarea class="form-control" name="Causa" cols="100" rows="5"><?php echo $Causa; ?></textarea>
									</td>
								</tr>

								<tr height="30" bgcolor="#0099CC" style="color:#000000; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px; font-weight:700;">
									<td colspan="4">5. Acciones Correctivas: </td>
								</tr>
								<tr>
									<td colspan="4">
										<div class="row m-2">
											<div class="col-md-12">
												<b>Corrección:</b>
											</div>
											<div class="col-md-12 p-1">
												<textarea class="form-control" name="accCorrecion" cols="100" rows="5"><?php echo $accCorrecion; ?></textarea>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="4">
										<div class="row m-2">
											<div class="col-md-12">
												<b>Acción Correctiva:</b>
											</div>
											<div class="col-md-12 p-1">
												<textarea class="form-control" name="accAccionCorrectiva" cols="100" rows="5"><?php echo $accAccionCorrectiva; ?></textarea>
											</div>
										</div>
									</td>
								</tr>

								<tr height="30" bgcolor="#0099CC" style="color:#000000; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px; font-weight:700;">
									<td colspan="4">6. Verificación de la implementación, efectividad y cierre de la AC </td>
								</tr>
								<tr>
									<td colspan="4">
										<div class="row m-2">
											<div class="col-md-12">
												<b>RESULTADO DE LA ACCIÓN CORRECTIVA:</b>
											</div>
											<div class="col-md-12 p-1">
												<textarea class="form-control" name="verResAccCorr" cols="100" rows="5"><?php echo $verResAccCorr; ?></textarea>
											</div>
											<div class="col-md-12">
												<b>¿ES NECESARIO ACTUALIZAR LOS RIESGOS Y OPORTUNIDADES?</b>
											</div>
											<div class="col-md-12 p-1">
												<?php
													if($actRiesgos == "SI"){?>
														<input class="control-form m-2" type="radio" name="actRiesgos" value="SI" checked>Si
														<?php
													}else{?>
														<input class="control-form m-2" type="radio" name="actRiesgos" value="SI">Si
													<?php
													}
												?>
												<?php
													if($actRiesgos == "NO"){?>
														<input class="control-form m-2" type="radio" name="actRiesgos" value="NO" checked>NO
														<?php
													}else{?>
														<input class="control-form m-2" type="radio" name="actRiesgos" value="NO">NO
													<?php
													}
												?>
											</div>
									</td>
								</tr>
								
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="5" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px; ">
							<?php
								// echo $accion;
								if($accion == 'Guardar' || $accion == 'Agrega' || $accion == 'Actualizar'){?>
									<!-- <a href="#" ng-click="guardarCorrectivas()" class="btn btn-info" role="button">Guardar</a> -->
									<button name="guardarAccionCorrectiva" style="float:right;" title="Guardar Acción Correctiva" class="btn btn-info m-2">
										<img src="../gastos/imagenes/guardar.png" width="55" height="55"><br>Guardar
									</button>

									<a href="#" style="float:right;" ng-click="subirArchivos()" class="btn btn-warning m-2" role="button" data-toggle="modal" data-target="#myModal">
										<img src="../imagenes/open_48.png" width="55" height="55"><br>Anexos
									</a>

									<?php
									if($accion == 'Guardar' || $accion == 'Actualizar'){
										if($verCierreAccion == 'on'){?>
											<div id="botonImagen">
												<button name="ReAbrirAccionCorrectiva" style="float:right;" title="Abrir Acción Correctiva" class="btn btn-success m-2">
													<img src="../imagenes/lock_128.png" width="55" height="55"><br>Abrir
												</button>
											</div>
										<?php }else{ ?>
											<div id="botonImagen">
												<button name="cerrarAccionCorrectiva" style="float:right;" title="Cerrar Acción Correctiva" class="btn btn-primary m-2">
													<img src="../imagenes/lock_128.png" width="55" height="55"><br>Cerrar
												</button>
											</div>
										<?php
										}
									}
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
	</div>

	<div class="container">
		<div class="card m-5">
			<div class="card-header bg-info text-white">
				Anexos
			</div>
			<div class="card-body">
				<?php
				$ruta = 'Y://AAA/LE/CALIDAD/AC/AC-'.$nInformeCorrectiva.'/Anexos/'; 

				if(file_exists($ruta)){
					$gestorDir = opendir($ruta);
					while(false !== ($nombreDir = readdir($gestorDir))){
						if($nombreDir != 'Thumbs.db' and $nombreDir != '.' and $nombreDir != '..'){
							?>
								<div class="row">
									<?php 
										$nombreDir = utf8_decode($nombreDir); 
										$nombreNew = str_replace('?', "", $nombreDir);
										// echo $nombreNew;

										//rename($nombreDir, $nombreNew);
									?>

									<div class="col-10 m-1">
										<a href="<?php echo 'tmp/'.$nombreDir; ?>" class="btn btn-primary  btn-block" target="_blank" role="button">
											<b><?php echo $nombreDir; ?></b>
										</a>
									</div>
									<div class="col-1 m-1">
										<a href="#" ng-click="borrarDoc('<?php echo $nInformeCorrectiva;?>','<?php echo $nombreDir;?>')" class="btn btn-danger" role="button">
											<b>X</b>
										</a>
									</div>
								</div>
							<?php
						}
					}
				}
				?>


			</div>
		</div>
	</div>

<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Anexos Acción Correctiva {{nInformeCorrectiva}} </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
		<div class="row">
			<div class="col-sm-12">
				<div class="alert alert-danger">
					  <h2><strong>Precaución!</strong><br>Cuide que el documento a NO tenga <b>Tilde</b>...</h2>
				</div>
			</div>
			<div class="col-sm-12 m-5">
				<input id="archivosSeguimiento" multiple type="file"> {{pdf}}
			  	<button class="btn btn-success" type="button" ng-click="enviarFormularioSeg()">
					Subir Evidencia PDF
			  	</button>
			</div>
		</div>

      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" ng-click="cargarNuevamente()" data-dismiss="modal">Close</button>
      </div>

    </div> 
  </div>
</div>





	<script src="../jsboot/bootstrap.min.js"></script>
	<script src="correctivas.js"></script>

</body>
</html>
