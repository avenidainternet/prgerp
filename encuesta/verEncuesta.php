<?php 	
	include_once("conexion.php"); 
	date_default_timezone_set("America/Santiago");
	$nEnc 	= 0;
	$nItem 	= 0;
	$accion = '';
	$Email 	= '';
	$nFolio = 0;
	$Cumplimentado = '';
	$Cargo = '';
	
	if(isset($_GET['nEnc'])) 	{ $nEnc 	= $_GET['nEnc']; 	}
	if(isset($_GET['RutCli'])) 	{ $RutCli	= $_GET['RutCli'];	}
	if(isset($_GET['nFolio'])) 	{ $nFolio	= $_GET['nFolio'];	}
	if(isset($_GET['accion'])) 	{ $accion 	= $_GET['accion'];	}

	if(isset($_POST['nEnc'])) 			{ $nEnc 			= $_POST['nEnc']; 			}
	if(isset($_POST['RutCli'])) 		{ $RutCli 			= $_POST['RutCli']; 		}
	if(isset($_POST['rTexto'])) 		{ $rTexto 			= $_POST['rTexto']; 		}
	if(isset($_POST['Cumplimentado']))	{ $Cumplimentado 	= $_POST['Cumplimentado'];	}
	if(isset($_POST['Cargo']))			{ $Cargo 			= $_POST['Cargo']; 			}
	if(isset($_POST['Email'])) 			{ $Email 			= $_POST['Email']; 			}
	if(isset($_POST['nFolio'])) 		{ $nFolio 			= $_POST['nFolio']; 		}

	$encNew = 'Si';
	$link=Conectarse();
	$bdEnc=mysql_query("SELECT * FROM Encuestas Where nEnc = '".$nEnc."'");
	if($rowEnc=mysql_fetch_array($bdEnc)){
		$nomEnc 	= $rowEnc['nomEnc'];
		$infoEnc 	= $rowEnc['infoEnc'];
		$Estado 	= $rowEnc['Estado'];
	}
						
	$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$RutCli."'");
	if($rowCli=mysql_fetch_array($bdCli)){
		$Cliente = $rowCli['Cliente'];
	}
	$OkGuardar = 'NoOk';

	if(isset($_POST['confirmarGuardarOld'])){
		$bdFol=mysql_query("SELECT * FROM foliosEncuestas Where RutCli = '".$RutCli."' && nEnc = '".$nEnc."'");
		if($rowFol=mysql_fetch_array($bdFol)){
			if(isset($_POST['confirmarGuardar'])){
				$OkGuardar = 'Ok';
			}else{
				mensajeError($nEnc, $RutCli);
			}
		}else{
			mensajeError($nEnc, $RutCli);
		}
	}
	$swEnc = false;

//	if($OkGuardar == 'Ok'){

	if(isset($_POST['confirmarGuardar'])){
		$OkGuardar = 'Ok';
		$swEnc = true;
		$fechaRespuesta = date('Y-m-d');
		$bdFol=mysql_query("SELECT * FROM foliosEncuestas Where RutCli = '".$RutCli."' && nEnc = '".$nEnc."' && Email = '".$Email."'");
		if($rowFol=mysql_fetch_array($bdFol)){
			$nFolio	= $rowFol['nFolio'];
			$actSQL="UPDATE foliosEncuestas SET ";
			$actSQL.="Cumplimentado		='".$Cumplimentado."',";
			$actSQL.="Cargo				='".$Cargo."',";
			$actSQL.="fechaRespuesta	='".$fechaRespuesta."'";
			$actSQL.="Where RutCli = '".$RutCli."' && nEnc = '".$nEnc."' && Email = '".$Email."'";
			$bdFol=mysql_query($actSQL);
		}else{
			$swEnc = true;
			
			$sql = "SELECT * FROM foliosEncuestas";  // sentencia sql
			$result = mysql_query($sql);
			$nFolio = mysql_num_rows($result)+1; // obtenemos el número de filas
			$fechaEnvio = date('Y-m-d');

			mysql_query("insert into foliosEncuestas(	nFolio,
														nEnc,
														RutCli,
														Cumplimentado,
														Email,
														fechaEnvio,
														fechaRespuesta
													) 
											values 	(	'$nFolio',
														'$nEnc',
														'$RutCli',
														'$Cumplimentado',
														'$Email',
														'$fechaEnvio',
														'$fechaRespuesta'
			)",$link);
		
		}
		$bdEnc=mysql_query("SELECT * FROM Encuestas Where nEnc = '".$nEnc."'");
		if($rowEnc=mysql_fetch_array($bdEnc)){
			$nResp = $rowEnc['nResp'];
			$nResp++;
			$actSQL="UPDATE Encuestas SET ";
			$actSQL.="nResp			='".$nResp."'";
			$actSQL.="Where nEnc 	= '".$nEnc."'";
			$bdEnc=mysql_query($actSQL);
			
		}

		$bdIt=mysql_query("SELECT * FROM itEncuesta Where nEnc = '".$nEnc."'");
		if($rowIt=mysql_fetch_array($bdIt)){
			do{
				$nItem 		= $rowIt['nItem'];
				
				$bdPr=mysql_query("SELECT * FROM prEncuesta Where nEnc = '".$nEnc."' && nItem = '".$rowIt['nItem']."'");
				if($rowPr=mysql_fetch_array($bdPr)){
					do{
						$nCon 		= $rowPr['nCon'];
						
						$rEscala 	= 0;
						$rSiNo		= 0;
						
						if($rowIt['tpEva'] == 1){
							$nrEscala 	= 'rEsc'.$rowPr['nCon'];
							$rEscala  	= $_POST[$nrEscala];
						}
						if($rowIt['tpEva'] == 2){
							$nrSiNo = 'rSiNo'.$rowPr['nCon'];
							$rSiNo  = $_POST[$nrSiNo];
							if($rSiNo == 'Si'){ $rSiNo = 1; }else{ $rSiNo = 0; }
						}
			
						// echo '<span style="font-size:20px; color:000; background-color:#FFFFFF;">nCon...'.$rowPr[nCon].'</span><br>';

						$bdRes=mysql_query("SELECT * FROM respEncuesta Where nFolio = '".$nFolio."' && RutCli = '".$RutCli."' && nEnc = '".$nEnc."' && nItem = '".$rowIt['nItem']."' && nCon = '".$rowPr['nCon']."'");
						if($rowRes=mysql_fetch_array($bdRes)){
							
						}else{
							mysql_query("insert into respEncuesta(	nFolio,
																	RutCli,
																	nEnc,
																	nItem,
																	ncon,
																	rEscala,
																	rSiNo
																) 
														values 	(	'$nFolio',
																	'$RutCli',
																	'$nEnc',
																	'$nItem',
																	'$nCon',
																	'$rEscala',
																	'$rSiNo'
							)",$link);
						}
					}while ($rowPr=mysql_fetch_array($bdPr));
				}


				if($rowIt['nItem'] == 3){
					$nCon++;
					$bdRes=mysql_query("SELECT * FROM respEncuesta Where nFolio = '".$nFolio."' && RutCli = '".$RutCli."' && nEnc = '".$nEnc."' && nItem = '".$rowIt['nItem']."'");
					if($rowRes=mysql_fetch_array($bdRes)){
							
					}else{
						mysql_query("insert into respEncuesta(		nFolio,
																	RutCli,
																	nEnc,
																	nItem,
																	nCon,
																	rTexto
																) 
														values 	(	'$nFolio',
																	'$RutCli',
																	'$nEnc',
																	'$nItem',
																	'$nCon',
																	'$rTexto'
							)",$link);
					}						
				}
			}while ($rowIt=mysql_fetch_array($bdIt));
		}
	}
	

	mysql_close($link);
	$abc = array('0','A', 'B', 'C', 'D', 'E', 'F', 'G');
	
	$rEscala = array(
					1 => 0, 
					2 => 0,
					3 => 0,
					4 => 0,
					5 => 0,
					6 => 0
				);

	$Mes = array(
					1 => 'Enero', 
					2 => 'Febrero',
					3 => 'Marzo',
					4 => 'Abril',
					5 => 'Mayo',
					6 => 'Junio',
					7 => 'Julio',
					8 => 'Agosto',
					9 => 'Septiembre',
					10 => 'Octubre',
					11 => 'Noviembre',
					12 => 'Diciembre'
				);

	function mensajeError($nEnc, $RutCli){
		echo '
		<div style="position:absolute; left:100px; top:40px; width:90%; height:800px; z-index:10000;">
			<div id="bloqueoTrasperente">
				<div id="cajaRegistraPruebas">
				<table width="95%" border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
					<tr>
						<td colspan="2" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px;">
							<span style="color:#FFFFFF; font-size:18px; font-weight:700;">
								'.$nomEnc.'
								<div id="botonImagen">
									<a href="verEncuesta.php?nEnc='.$nEnc.'&RutCli='.$RutCli.'" style="float:right;"><img src="../imagenes/no_32.png"></a>
								</div>
							</span>
						</td>
					</tr>
					<tr>
						<td colspan="2"><img src="../imagenes/logoSimetEnc.png"></td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" style="font-size:40px;">Favor de ingresar datos validos...</td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
				</table>
			</div>
		</div>
		</div>
		';
	}

?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Encuesta SIMET-USACH</title>
	
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	

	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<script>
	function realizaProceso(dBuscar){
		var parametros = {
			"dBuscar" 	: dBuscar
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'muestraEncuestas.php',
			type: 'get',
			beforeSend: function () {
				$("#resultado").html("<div id='cajaRegistraPruebas'><img src='../imagenes/ajax-loader.gif'></div>");
			},
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}
	
	function registraEncuesta(nEnc, accion){
		var parametros = {
			"nEnc" 		: nEnc,
			"accion"	: accion
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'regEncuesta.php',
			type: 'get',
			beforeSend: function () {
				$("#resultadoRegistro").html("<div style='position:absolute; left:159px; top:66px; width:470px; height:187px; z-index:1; border: 5px solid #000; background-color: #fff; border-radius: 5px 5px 0px 0px; -moz-border-radius: 5px 0px 5px 0px; '><img src='../imagenes/ajax-loader.gif'></div>");
			},
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}
	</script>
</head>

<body>
	<?php //include('headEnc.php'); ?>

	<div id="bloqueoTrasperente">
		<div id="cajaRegistraPruebas">
			<center>
			<?php
			if($swEnc == false){?>
				<form name="form" action="verEncuesta.php" method="post">
				<table width="95%" border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
					<tr>
						<td colspan="2" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px;">
							<span style="color:#FFFFFF; font-size:18px; font-weight:700;">
								<?php echo $nomEnc; ?>
								<div id="botonImagen">
									<a href="http://simet.cl" style="float:right;"><img src="../imagenes/no_32.png"></a>
								</div>
							</span>
						</td>
					</tr>
					<tr>
						<td colspan="2"><img src="../imagenes/logoSimetEnc.png"></td>
					</tr>
					<tr>
						<td align="center" colspan="2">
							<span style="font-size:24px; font-weight:700;">
							<?php echo $nomEnc; ?>
							</span>
							<input name="nEnc" 		id="nEnc" 	type="hidden" value="<?php echo $nEnc; ?>">
							<input name="nItem" 	id="nItem" 	type="hidden" value="<?php echo $nItem; ?>">
							<input name="accion" 	id="accion" type="hidden" value="<?php echo $accion; ?>">
							<input name="RutCli" 	id="RutCli" type="hidden" value="<?php echo $RutCli; ?>">
							<input name="Email" 	id="Email" 	type="hidden" value="<?php echo $Email; ?>">
							<input name="nFolio" 	id="Email" 	type="hidden" value="<?php echo $nFolio; ?>">
						</td>
					</tr>
					<tr>
						<td colspan="2" align="justify" style="padding:30px;">
							<span style="font-size:20px; font-weight:600; padding:30px;">
								<?php echo '<strong>Estimado cliente '.$Cliente.'</strong>:<br><br>'; ?>
							</span>
							<span style="font-size:20px; font-weight:600; padding:30px;">
								<?php echo $infoEnc; ?>
							</span>
						</td>
					</tr>
						<?php
							$link=Conectarse();
							$bdEnc=mysql_query("SELECT * FROM itEncuesta Where nEnc = $nEnc Order By nItem");
							if ($row=mysql_fetch_array($bdEnc)){
								do{
									?>
									<tr>
										<td colspan=2><hr></td>
									</tr>
									<tr>
										<td align="center" width="05%" valign="top" style="padding:30px; font-size:24px; font-weight:700; ">
											<?php echo $abc[$row['nItem']]; ?>&nbsp;)
										</td>
										<td align="justify" width="95" valign="top" style="padding:30px; font-size:22px;">
											<?php 
												echo $row['titItem'].'<br>';
												if($row['tpEva'] == 1){
													$nItem = $row['nItem'];
													echo '<br>';
													echo '<table cellpadding="0" cellspacing="0" border="1" width="80%" align="center">';
													echo '	<tr>';
													$bdtEsc=mysql_query("SELECT * FROM tpEscala Where nEnc = $nEnc && nItem = $nItem Order By nEscala");
													if ($rowtEsc=mysql_fetch_array($bdtEsc)){
														do{
															echo '	<td align="center">';
																echo $rowtEsc['desEscala'];
															echo '	</td>';
														}while ($rowtEsc=mysql_fetch_array($bdtEsc));
													}
													echo '	</tr>';
													echo '	<tr>';
													$bdtEsc=mysql_query("SELECT * FROM tpEscala Where nEnc = $nEnc && nItem = $nItem Order By nEscala");
													if ($rowtEsc=mysql_fetch_array($bdtEsc)){
														do{
															echo '	<td align="center">';
																if($rowtEsc['nEscala'] == 0){
																	echo 'N.P.';
																}else{
																	echo $rowtEsc['nEscala'];
																}
															echo '	</td>';
														}while ($rowtEsc=mysql_fetch_array($bdtEsc));
													}
													echo '	</tr>';
													echo '</table>';
												}
											?>
											<br>
											<?php
											if($row['tpEva'] <> 3){
												?>
												<table cellpadding="0" cellspacing="0" border="0" width="100%">
													<?php
														$nItem = $row['nItem'];
														$bdPr=mysql_query("SELECT * FROM prEncuesta Where nEnc = $nEnc && nItem = $nItem Order By nCon");
														if ($rowPr=mysql_fetch_array($bdPr)){
															do{?>
																<tr>
																	<td><?php echo $rowPr['nCon']; 	?></td>
																	<td><?php echo $rowPr['Consulta'];?></td>
																	<td>
																		<?php
																			if($row['tpEva']==1){
																				$nrEscala = 'rEsc'.$rowPr['nCon'];
																				//echo $nrEscala;
																				?>
																				<select name="<?php echo $nrEscala; ?>" class="selectMediana">
																					<option value=""></option>
																					<option value="1">1</option>
																					<option value="2">2</option>
																					<option value="3">3</option>
																					<option value="4">4</option>
																					<option value="0">NP</option>
																				</select>
																				<?php
																			}
																			?>
																			<?php
																			if($row['tpEva']==2){
																				$nrSiNo = 'rSiNo'.$rowPr['nCon'];
																				?>
																				<select name="<?php echo $nrSiNo; ?>" class="selectMediana">
																					<option value=""></option>
																					<option value="Si">Si</option>
																					<option value="No">No</option>
																				</select>
																				<?php
																			}
																			?>
																		</td>
																	</tr>
																<?php
															}while ($rowPr=mysql_fetch_array($bdPr));
														}
														?>
												</table>
												<?php
											}else{
												echo '<textarea name="rTexto" id="rTexto" cols="50%" rows="10" class="selectMediana"></textarea>';
											}
											?>
										</td>
									</tr>
									
									<?php
								}while ($row=mysql_fetch_array($bdEnc));
							}
							mysql_close($link);
						?>							
					<tr>
						<td colspan="2" bgcolor="#FFFFFF" style="font-size:18px; ">
							<?php
							$link=Conectarse();
							$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$RutCli."'");
							if($rowCli=mysql_fetch_array($bdCli)){?>
								<table cellpadding="0" cellspacing="0" border="0" width="100%">
									<tr>
										<td width="10%">&nbsp;</td>
										<td width="20%">Empresa: </td>
										<td width="70%"><?php echo $rowCli['Cliente']; ?></td>
									</tr>
									<tr>
										<td width="10%">&nbsp;</td>
										<td width="20%">Realizado por: </td>
										<td width="70%"><input name="Cumplimentado" id="Cumplimentado" type="text" size="40" maxlength="50" class="selectMediana" value="<?php echo $Cumplimentado; ?>" placeholder="Nombre quien realizó la encuesta..."></td>
									</tr>
									<tr>
										<td width="10%">&nbsp;</td>
										<td width="20%">Cargo: </td>
										<td width="70%"><input name="Cargo" id="Cargo" type="text" size="40" maxlength="50" class="selectMediana" value="<?php echo $Cargo; ?>" placeholder="Cargo ..."></td>
									</tr>
									<tr>
										<td width="10%">&nbsp;</td>
										<td width="20%">Correo: </td>
										<td width="70%"><input name="Email" id="Email" type="text" size="40" maxlength="100" class="selectMediana" value="<?php echo $Email; ?>"  placeholder="Correo ..."></td>
									</tr>
									<tr>
										<td width="10%">&nbsp;</td>
										<td width="90%" colspan="2" align="right">
											<?php
												$fechaEncuesta = date('Y-m-d');
												$fd 	= explode('-', $fechaEncuesta);
												$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
												echo '<span style="padding:30px; font-size:24px;">'.$fd[2] . ' de ' . $Mes[intval($fd[1])] . ' de ' . $fd[0].'</span>';
											?>
										</td>
									</tr>
								</table>
								<?php
							}
							mysql_close($link);
							?>
						</td>
					</tr>
					<tr>
						<td colspan="2" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px; ">
							<div id="botonImagen" title="Enviar...">
								<button name="confirmarGuardar" style="float:right;">
									<img src="../imagenes/enviarConsulta.png" width="80" height="80">
								</button>
							</div>
						</td>
					</tr>
				</table>
				</form>
			<?php }else{ ?>
				<table width="95%" border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
					<tr>
						<td colspan="2" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px;">
							<span style="color:#FFFFFF; font-size:18px; font-weight:700;">
								<?php echo $nomEnc; ?>
								<div id="botonImagen">
									<a href="http://simet.cl" style="float:right;"><img src="../imagenes/no_32.png"></a>
								</div>
							</span>
						</td>
					</tr>
					<tr>
						<td colspan="2"><img src="../imagenes/logoSimetEnc.png"></td>
					</tr>
					<tr>
						<td colspan="2" align="justify" style="padding:30px;">
							<span style="font-size:20px; font-weight:600; padding:30px;">
								<?php echo '<strong>Estimado cliente '.$Cliente.'</strong>:<br><br>'; ?>
							</span>
							<span style="font-size:20px; font-weight:600; padding:30px;">
								<?php echo 'Se le agradece haber respondido encuesta...'; ?>
							</span>
						</td>
					</tr>
				</table>
			<?php } ?>
			</center>
		</div>
	</div>
