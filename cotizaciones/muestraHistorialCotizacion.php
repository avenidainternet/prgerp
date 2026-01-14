<?php
	//ini_set("session.cookie_lifetime","7200");
	//ini_set("session.gc_maxlifetime","7200");
	//header('Content-Type: text/html; charset=utf-8');
	//include_once("conexion.php");
	//include_once("../conexionli.php");
	date_default_timezone_set("America/Santiago");

	include_once("../inc/funciones.php");

	$rCot	= 0;
	
		$link=Conectarse();
		$bdCli=$link->query("SELECT * FROM SolFactura Where valorUF > 0 Order By valorUF Desc");
		if($rowCli=mysqli_fetch_array($bdCli)){
			$ultUF = $rowCli['valorUF'];
		}
		$link->close();

	if(isset($_GET['usrFiltro'])) { $usrFiltro  = $_GET['usrFiltro']; 	}
	$filtroCli 	= '';
	$empFiltro 	= '';
	$CAMRAM  	= '';
	if(isset($_GET['CAMRAM'])){ $CAMRAM = $_GET['CAMRAM']; }
	
	if(isset($_GET['empFiltro'])) { 
		$empFiltro = $_GET['empFiltro'];
		if($empFiltro){
			$link=Conectarse();
			$bdCli=$link->query("SELECT * FROM Clientes Where Cliente Like '%".$empFiltro."%'");
			if($rowCli=mysqli_fetch_array($bdCli)){
				$filtroCli = $rowCli['RutCli'];
			}
			$link->close();
		}
	}

	$usrFiltro = '';
	if(isset($_SESSION['usrFiltro'])) { $usrFiltro = $_SESSION['usrFiltro']; }
	
	
	?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="100%" valign="top">
					<?php 
						if($CAMRAM != '' or $filtroCli != '' or $bFecha != ''){
							mCAMs($usrFiltro, $filtroCli, $bFecha); 
						}
					?>
				</td>
			</tr>
		</table>
		
		<?php
		function mCAMs($usrFiltro, $filtroCli, $bFecha){
				global $ultUF;
				$filtro = '';
				$rCot	= 0;
				
				?>
				<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloSel">
					<tr>
						<td  width="5%" align="center" height="40">&nbsp; 		</td>
						<td  width="13%">							CAM 		</td>
						<td  width="11%">							Fecha		</td>
						<td  width="45%">							Clientes	</td>
						<td  width="13%">							Total		</td>
						<td  width="13%">							Cotización	</td>
					</tr>

					<?php
					$n 		 = 0;
					$tCAMsUF = 0;
					
					$link=Conectarse();
					$fechaHoy = date('Y-m-d');
					$fd = explode('-',$fechaHoy);
					
					$bdIN=$link->query("SELECT * FROM tablaIndicadores Where agnoInd = '".$fd['0']."' and mesInd = '".$fd['1']."'");
					if($rowIN=mysqli_fetch_array($bdIN)){
						$rCot = $rowIN['rCot'];
					}
					$filtro = " year(fechaCotizacion) = '".$bFecha."'";
					if($filtroCli){
						$filtro .= " and RutCli = '".$filtroCli."'";
						$sql = "SELECT * FROM Cotizaciones Where $filtro Order By Estado Asc, Facturacion";
					}					
					if(isset($_GET['CAMRAM'])){
						$CAMRAM = $_GET['CAMRAM'];
						if($CAMRAM){
							$filtro = " CAM = '".$CAMRAM."' or RAM = '".$CAMRAM."'";
						}
					}
					//$sql = "SELECT * FROM Cotizaciones Where $filtro Order By Estado Asc, Facturacion";
					$sql = "SELECT * FROM Cotizaciones Where $filtro Order By Estado Asc, fechaCotizacion Desc";
					$ctrlEstado = '';
					$bdEnc=$link->query($sql);
					if($row=mysqli_fetch_array($bdEnc)){
					do{
						//$tCAMsUF += $row[NetoUF];
						//list($ftermino, $dhf, $dha, $dsemana) = fnDiasCorridos($row['fechaCotizacion'],$row['Validez']);

						$fechaxVencer 	= strtotime ( '+'.$row['Validez'].' day' , strtotime ( $row['fechaCotizacion'] ) );
						$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
						
						$treinta = 30;
						$fechaaCerrar 	= strtotime ( '+'.$treinta.' day' , strtotime ( $row['fechaCotizacion'] ) );
						$fechaaCerrar 	= date ( 'Y-m-d' , $fechaaCerrar );

						$fd = explode('-', $fechaxVencer);
										
						$fechaHoy = date('Y-m-d');
						$start_ts = strtotime($fechaHoy); 
						$end_ts = strtotime($fechaxVencer); 
										
						$nDias = $end_ts - $start_ts;
						$nDias = round($nDias / 86400);
						$tDias = 3;
						
						$tr = "bBlancaSel";
						if($row['Estado']==' '){
							$tr = "bBlancaSel";
						}
						if($row['Estado']=='E'){ // CAM
							$tr = "bAmarillaSel";
							if($nDias <= $tDias){ // CAM
								$tr = 'bRojaSel';
							}
							if($row['proxRecordatorio'] <= $fechaHoy){ // En Proceso
								$tr = 'bRojaSel';
							}
						}
						if($row['fechaAceptacion'] != '0000-00-00'){ // Aceptada
							$tr = 'bVerdeSel';
						}
						if($row['Estado']=='N'){
							$tr = "bBlancaSel";
						}
						if($row['Estado'] == 'T' and $row['Facturacion'] != 'on'){ 
							$tr = "bAzulSel";
							$tr = "bBlancaSel";
						}
						//if($row['Estado'] == 'T' and $row['Facturacion'] == 'on'){ 
						if($row['Estado'] == 'T' and $row['Facturacion'] == 'on'){ 
							$tr = "bAzulOscuroSel";
						}

						$swMuestra = true;

						if($tr == 'bRojaSel'){
							if($row['BrutoUF'] < $rCot){
								$tr = 'bVerdeSel';
							}
							$swMuestra = false;
						}
						
						$txtEstado = '';
						
						if($row['Estado'] == 'E' or $row['Estado'] == 'P' or $row['Estado'] == 'C' or $row['Estado'] == 'N' or $row['Estado'] == ''){ 
							$txtEstado = 'NO CONSOLIDADAS'; 				
						}
						if($row['Estado'] == 'T'){ 
							$txtEstado = 'CONSOLIDADAS'; 				
						}
						
						if($row['Estado'] == 'C'){ // Aceptada
							$tr = "bBlancaSelb";
						}

						if($ctrlEstado != $txtEstado) {
							$ctrlEstado = $txtEstado;
							?>
							<tr>
								<td colspan="6" class="subTitHis"><?php echo $txtEstado; ?></td>
							</tr>
							<?php
						}
						?>
						
						<tr class="<?php echo $tr; ?>">
							<td width="5%" style="font-size:12px;" align="center">
								<?php
									$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
									if($rowCli=mysqli_fetch_array($bdCli)){
										if($rowCli['nFactPend'] > 0){?>
											<div id="precaucion">
												<img src="../imagenes/gener_32.png" align="left" width="16"><?php echo $rowCli['nFactPend']; ?>
											</div>
											<?php
										}
									}
								?>
								<div style="clear:both;"></div>
								<?php if($row['tpEnsayo'] == 2){ ?>
										<div style="background-color:#666666; color:#FFFFFF; border:1px solid #000; padding:1px;" title="Análisis de Falla">
												AF
										</div>
								<?php } 
								if($row['OFE'] == 'on'){?>
									<br>
									<div class="cOfe">
										<a href="ofe/index.php?OFE=<?php echo $row['CAM']; ?>&accion=OFE" title="Editar Oferta Económica">
											OFE
										</a>
									</div>
									<?php
								}
							echo '	</td>';
							echo '	<td width="13%" style="font-size:12px;" align="center">';
										if($row['Rev']<10){
											$Revision = '0'.$row['Rev']; 
										}else{
											$Revision = $row['Rev']; 
										}
							echo		'<strong style="font-size:14; font-weight:700">';
							echo		'C'.$row['CAM'];
							if($row['RAM']){
										echo '<br><span style="font-size:16; font-weight:700">R'.$row['RAM'].'</span>';
							}
							echo		'</strong>'.'<br> Rev.'.$Revision;
										if($row['Cta']){
											echo '<br>CC';
										}
										if($row['fechaAceptacion'] != '0000-00-00'){ // Aceptada
											echo '<br>Aceptada';
										}
										if($row['fechaTermino'] != '0000-00-00'){ // Aceptada
											echo '<br>T '.$row['fechaTermino'];
										}
										if($row['fechaInformeUP'] != '0000-00-00'){ // Aceptada
											echo '<br>IUP '.$row['fechaInformeUP'];
										}
										if($row['fechaFacturacion'] != '0000-00-00'){ // Aceptada
											echo '<br>F '.$row['fechaFacturacion'].' F '.$row['nFactura'];
										}
										if($row['fechaArchivo'] != '0000-00-00'){ // Aceptada
											echo '<br>A '.$row['fechaArchivo'].' F '.$row['nFactura'];
										}
										//echo '<br>'.$cDias;

									echo '<br>';
									// Verificar si tiene Facturas Pendientes de Pago
									$sDeuda = 0;
									$cFact	= 0;
									$fechaHoy = date('Y-m-d');
									$fecha90dias 	= strtotime ( '-90 day' , strtotime ( $fechaHoy ) );
									$fecha90dias	= date ( 'Y-m-d' , $fecha90dias );
									$bdDe=$link->query("SELECT * FROM SolFactura Where RutCli = '".$row['RutCli']."' and fechaPago = '0000-00-00'");
									if($rowDe=mysqli_fetch_array($bdDe)){
										do{
											if($rowDe['fechaFactura'] > '0000-00-00'){
												if($rowDe['fechaFactura'] < $fecha90dias){
													$sDeuda += $rowDe['Bruto'];
													$cFact++;
												}
											}
										}while ($rowDe=mysqli_fetch_array($bdDe));
									}
									if($sDeuda > 0){
										?>
										<script>
											var RutCli = '<?php echo $row["RutCli"]; ?>';
										</script>
										<?php
										echo '<br><div onClick="verDeuda(RutCli)"><img src="../imagenes/bola_amarilla.png"></div>';
										echo '<br><span style="color:#000; font-size:9px; font-weight:800;">$ '.number_format($sDeuda, 0, ',', '.').'</span>';
									}


							echo '	</td>';
							echo '	<td width="11%" style="font-size:12px;">';
										$fd = explode('-', $row['fechaCotizacion']);
										echo $fd[2].'/'.$fd[1].'/'.$fd[0];
										echo '<br>'.$row['usrCotizador'];
										//echo '<br>'.$_SESSION[usr];
							echo '	</td>';
							echo '	<td width="45%" style="font-size:12px;">';
								if($row['RutCli']){
									$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
									if($rowCli=mysqli_fetch_array($bdCli)){
										echo $rowCli['Cliente'];
										echo '<br>'.$filtroCli;
									}
								}
							echo '	</td>';
							echo '	<td width="13%" style="font-size:12px;">';
										if($row['Moneda'] == 'P'){
											echo number_format($row['Bruto'], 0, ',', '.');
										}else{
											echo number_format($row['BrutoUF'], 2, ',', '.').' UF';
											$tCAMsUF += $row['BrutoUF'];
										}
							echo ' 	</td>';
							echo '	<td width="13%" style="font-size:12px;">';
									echo '<a href="formularios/iCAM.php?CAM='.$row['CAM'].'&Rev='.$row['Rev'].'&Cta='.$row['Cta'].'&accion=Reimprime"	><img src="../imagenes/informeUP.png" 		width="40" title="Imprimir Cotización">					</a>';
							echo ' 	</td>';
/*							
							echo '	<td width="08%">';
									if($row['Estado'] != 'T'){ 
										if($row['enviadoCorreo'] == ''){ // Sin Enviar
											echo '<img src="../imagenes/noEnviado.png" 	width="32" height="32" title="Cotización NO Enviada"><br>';
										}
										if($row['enviadoCorreo'] == 'on'){ // Enviada
											if($row['proxRecordatorio'] <= $fechaHoy){ // En Proceso
												echo '<img src="../imagenes/alerta.gif" 	width="50" title="Contactar con Cliente">';
											}else{
												echo '<img src="../imagenes/enviarConsulta.png" 	width="32" height="32" title="Cotización Enviada">';
											}
											echo '<br>';
											$fd = explode('-', $row['fechaEnvio']);
											echo $fd[2].'-'.$fd[1];
										}
										if($row['Estado'] == 'A'){ // Aceptada
											echo '<img src="../imagenes/printing.png" 			width="32" height="32" title="Cotización Aceptada">';
											echo '<br>';
											$fd = explode('-', $row['fechaAceptacion']);
											echo $fd[2].'-'.$fd[1];
										}else{
										}
									}
							echo ' 	</td>';
							if($row['Estado'] == 'E' or $row['Estado'] == 'A' or $row['Estado'] == 'C'){ // En Proceso
								echo '<td width="06%" align="center" class="eImg"><a href="plataformaCotizaciones.php?CAM='.$row['CAM'].'&accion=Seguimiento"	><img src="../gastos/imagenes/klipper.png" 			width="22"  title="Seguimiento">			</a></td>';
							}else{
								echo '<td width="06%" align="center" class="eImg"><img src="../gastos/imagenes/klipper.png" width="22" title="Seguimiento" style="opacity:0;"></td>';
							}
							echo '	<td width="06%" align="center" class="eImg"><a href="modCotizacion.php?CAM='.$row['CAM'].'&Rev='.$row['Rev'].'&Cta='.$row['Cta'].'&accion=Actualizar"	><img src="../gastos/imagenes/corel_draw_128.png" 	width="22" title="Editar Cotización">		</a></td>';
							echo '	<td width="06%" align="center" class="eImg"><a href="modCotizacion.php?CAM='.$row['CAM'].'&Rev='.$row['Rev'].'&Cta='.$row['Cta'].'&accion=Borrar"		><img src="../gastos/imagenes/del_128.png"   		width="22" title="Borrar Cotización">		</a>';
							echo '  </td>';
*/							
							echo '</tr>';
						//}
					}while ($row=mysqli_fetch_array($bdEnc));
				}
				$link->close();
				echo '	</table>';
			}
			?>

<!-- 
****************************************************************************************************************
*
*             Nominas de Servicios en Procesos PAM
*
*
****************************************************************************************************************

-->
		<?php
		function mRAMs($usrFiltro, $filtroCli){
				global $ultUF;
				$filtro = '';
				if($usrFiltro){
					$filtro = " and usrResponzable Like '%".$usrFiltro."%'";
				}
				if($filtroCli){
					$filtro = " and RutCli Like '%".$filtroCli."%'";
				}
				$tRAMsUF = 0;
				$tRAMsPe = 0;
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloSel">';
				echo '		<tr>';
				echo '			<td  width="05%" align="center" height="40" >&nbsp;			</td>';
				echo '			<td  width="10%" align="center" 			>PAM 		 	</td>';
				echo '			<td  width="10%">							Inicio		 	</td>';
				echo '			<td  width="10%">							Término		 	</td>';
				echo '			<td  width="18%">							Clientes	 	</td>';
				echo '			<td  width="25%">							Observaciones	</td>';
				echo '			<td  width="10%">							Imprimir<br>RAM </td>';
				echo '			<td  width="12%" align="center">			Seg.			</td>';
				echo '		</tr>';
				//echo '	</table>';
				//echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListadoCAM">';
				$n 		= 0;
				$link=Conectarse();
				
				if($_SESSION['usr']=='Alfredo.Artigas' or $_SESSION['usr'] == '10074437' or substr($_SESSION['IdPerfil'],0,1) == 0){
					if($filtro){
						if($usrFiltro=='Baja'){
							$sql = "SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P' Order By tpEnsayo Desc, RAM Asc";
						}else{
							$sql = "SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P' ".$filtro." Order By tpEnsayo Desc, RAM Asc";
						}
						$bdEnc=$link->query($sql);
						//$bdEnc=$link->query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P' and usrCotizador Like '%".$usrFiltro."%' Order By RAM Asc");
					}else{
						$bdEnc=$link->query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P' Order By RAM Asc");
					}
				}else{
					if($filtro){
						if($usrFiltro=='Baja'){
							$sql = "SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P' Order By tpEnsayo Desc, RAM Asc";
						}else{
							$sql = "SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P' ".$filtro." Order By tpEnsayo Desc, RAM Asc";
						}
						$bdEnc=$link->query($sql);
					}else{
						$bdEnc=$link->query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P' Order By tpEnsayo Desc, RAM Asc");
					}
				}
				if ($row=mysqli_fetch_array($bdEnc)){
					do{
						$tRAMsUF += $row['NetoUF'];
						$tRAMsPe += $row['Neto'];
						
						$fechaTermino 	= strtotime ( '+'.$row['dHabiles'].' day' , strtotime ( $row['fechaInicio'] ) );
						$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );
										
						$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
						$ft = $row['fechaInicio'];
						$dh	= $row['dHabiles']-1;
						$dd	= 0;
						for($i=1; $i<=$dh; $i++){
							$ft	= strtotime ( '+'.$i.' day' , strtotime ( $row['fechaInicio'] ) );
							$ft	= date ( 'Y-m-d' , $ft );
							$dia_semana = date("w",strtotime($ft));
							if($dia_semana == 0 or $dia_semana == 6){
								$dh++;
								$dd++;
							}
						}
						
						$fd = explode('-', $ft);
										
						$fechaHoy = date('Y-m-d');
						$start_ts 	= strtotime($fechaHoy); 
						$end_ts 	= strtotime($ft); 
										
						$tDias = 1;
						$nDias = $end_ts - $start_ts;

						$nDias = round($nDias / 86400)+1;
						if($ft < $fechaHoy){
							$nDias = $nDias - $dd;
						}
						
						$tr = "bBlanca";
						list($ftermino, $dhf, $dha, $dsemana) = fnDiasHabiles($row['fechaInicio'],$row['dHabiles'],$row['horaPAM']);

						if($row['Estado']=='P' and $nDias <= 1){ // Enviada
							$tr = "bAmarillaSel";
							if($nDias <= 0){ // En Proceso
								$tr = 'bRojaSel';
							}
						}else{
							if($row['Estado'] == 'P'){ // Aceptada
								$tr = 'bVerdeSel';
							}
						}
						
						if($dhf > 0){ // Enviada
							if($dhf == 2 or $dhf == 1){ // Enviada
								$tr = 'bAmarillaSel';
							}else{
								$tr = 'bVerdeSel';
							}
						}
						if($dha > 0){ // Enviada
							$tr = "bRojaSel";
						}
						$OTAM = 'NO';
						$bRAM = $row['RAM'];
						$bdfRAM=$link->query("SELECT * FROM formRAM Where CAM = '".$row['CAM']."' and RAM = '".$row['RAM']."'");
						if($rowfRAM=mysqli_fetch_array($bdfRAM)){
							$OTAM = 'SI';
						}else{
							//$tr = 'bMorado';
							$OTAM = 'NO';
						}
						echo '<tr class="'.$tr.'">';
						echo '	<td style="font-size:12px;" align="center" valign="top">';
									$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
									if($rowCli=mysqli_fetch_array($bdCli)){
										if($rowCli['nFactPend'] > 0){
											echo '<img src="../imagenes/gener_32.png" align="left" width="16">'.$rowCli['nFactPend'];
										}
									}
									if($row['correoInicioPAM'] == 'on'){
											echo '<br><img src="../imagenes/draft_16.png" align="left">';
									}
									?>
									<div style="clear:both;"></div>
									<?php
										if($row['tpEnsayo'] == 2){
											?>
												<div style="background-color:#666666; color:#FFFFFF; border:1px solid #000; padding:2px;" title="Análisis de Falla">
													AF
												</div>
											<?php
										}
						echo '	</td>';
						echo '	<td style="font-size:12px;" align="center">';
						
						//echo fnDiasHabiles($row['fechaInicio'],$row['dHabiles'],$row['horaPAM']).'<br>';
						//echo $ft.' '.$dhf.' '.$dha;
												
						echo		'<strong style="font-size:14; font-weight:700">R'.$row['RAM'].'</strong><br>C'.$row['CAM'];
									if($row['Cta']){
										echo '<br>CC';
									}

									// Verificar si tiene Facturas Pendientes de Pago
									$sDeuda = 0;
									$cFact	= 0;
									$fechaHoy = date('Y-m-d');
									$fecha90dias 	= strtotime ( '-90 day' , strtotime ( $fechaHoy ) );
									$fecha90dias	= date ( 'Y-m-d' , $fecha90dias );
									$bdDe=$link->query("SELECT * FROM SolFactura Where RutCli = '".$row['RutCli']."' and fechaPago = '0000-00-00'");
									if($rowDe=mysqli_fetch_array($bdDe)){
										do{
											if($rowDe['fechaFactura'] > '0000-00-00'){
												if($rowDe['fechaFactura'] < $fecha90dias){
													$sDeuda += $rowDe['Bruto'];
													$cFact++;
												}
											}
										}while ($rowDe=mysqli_fetch_array($bdDe));
									}
									if($sDeuda > 0){
										?>
										<script>
											var RutCli = '<?php echo $row["RutCli"]; ?>';
										</script>
										<?php
										echo '<br><div onClick="verDeuda(RutCli)"><img src="../imagenes/bola_amarilla.png"></div>';
										echo '<br><span style="color:#000; font-weight:800;">$ '.number_format($sDeuda, 0, ',', '.').'</span>';
										//echo '<br><span style="color:#FFFF00;">'.$fecha90dias.'</span>';
										
									}
									//Fin Verificación Deuda
									
										//echo '<br>'.$sql;
						echo '	</td>';
						echo '	<td style="font-size:12px;">';
									if($row['fechaInicio'] != 0){
										$fd = explode('-', $row['fechaInicio']);
										echo $fd[2].'/'.$fd[1];
										echo '<br>'.$row['usrResponzable'];
									}else{
										echo 'NO Asignado';
									}
						echo '	</td>';
						echo '	<td style="font-size:12px;">';
									if($row['fechaInicio'] != 0){
										echo number_format($row['dHabiles'], 0, ',', '.').' días';
										$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
										$fechaHoy = date('Y-m-d');
										$dsemana = date("w",strtotime($ftermino));
										$fdt = explode('-', $ftermino);
										echo '<br>'.$dSem[$dsemana];
										echo '<br>'.$fdt[2].'/'.$fdt[1];
										if($dhf > 0 and $dha == 0){ // En Proceso
											if($dhf == 1){ // En Proceso
												echo '<div class="sVencerVerde">';
												echo 	$dhf;
												echo '</div';
											}else{
												echo '<div class="sVencer">';
												echo 	$dhf;
												echo '</div';
											}
										}
										if($dha > 0){ // En Proceso
											echo '<div class="pVencer" title="Atraso">';
											echo 	$dha;
											echo '</div';
										}
										
									}else{
										echo number_format($row['dHabiles'], 0, ',', '.').' días';
										echo '<br>Sin asignar';
									}
						echo ' 	</td>';
						echo '	<td style="font-size:12px;">';
							$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
							if($rowCli=mysqli_fetch_array($bdCli)){
								echo 	$rowCli['Cliente'];
							}
						echo '	</td>';
						echo '	<td>';
						echo '		<strong style="font-size:10px;">';
/*
										if($row[obsServicios]){
											echo substr($row[obsServicios],0,100).'...';
										}
*/										
										if($row['Descripcion']){
											echo substr($row['Descripcion'],0,100).'...';
										}
						//echo 			number_format($row[BrutoUF], 2, ',', '.').' UF';
						echo '		</strong>';
						echo ' 	</td>';
						echo '	<td>';
									if($row['Estado'] == 'P'){ // En Proceso
										$bdRAM=$link->query("SELECT * FROM registroMuestras WHERE RAM = '".$row['RAM']."'");
										if($rowRAM=mysqli_fetch_array($bdRAM)){
											echo '<a href="../registroMat/formularios/iRAM.php?RAM='.$row['RAM'].'"><img src="../imagenes/newPdf.png" 	width="22" title="RAM">					</a>';
										}
										if($OTAM == 'NO'){
											echo '<br><a href="../otams/pOtams.php?RAM='.$row['RAM'].'&CAM='.$row['CAM'].'&accion=Nuevo&prg=Procesos"><img src="../imagenes/machineoperator_128.png" 	width="22" title="Formulario RAM, Especificar Ensayos">					</a>';
										}else{
											echo '<br><a href="../otams/pOtams.php?RAM='.$row['RAM'].'&CAM='.$row['CAM'].'&accion=Old&prg="><img src="../imagenes/machineoperator_128.png" 	width="22" title="Ver Formolario RAM y Especificaciones de Ensayos">					</a>';
										}
									}
									if($row['Estado'] == 'C'){ // Cerrada
										echo '<img src="../imagenes/tpv.png" 				width="22" title="Cerrada para Cobranza">';
									}
						echo ' 	</td>';
						echo '	<td align="center">';
								if($row['Estado'] == 'P'){ // En Proceso
									echo '<a href="plataformaCotizaciones.php?CAM='.$row['CAM'].'&RAM='.$row['RAM'].'&accion=SeguimientoRAM"			><img src="../gastos/imagenes/klipper.png" 		width="22" title="Seguimiento">			</a><br>';
									echo '<a href="formularios/iCAM.php?CAM='.$row['CAM'].'&Rev='.$row['Rev'].'&Cta='.$row['Cta'].'&accion=Reimprime"	><img src="../imagenes/informeUP.png" 		width="22" title="CAM">					</a>';
								}else{
									echo '<img src="../gastos/imagenes/klipper.png" width="22" title="Seguimiento" style="opacity:0;">';
								}
						echo '	</td>';
						echo '</tr>';
					}while ($row=mysqli_fetch_array($bdEnc));
				}
				$link->close();
					echo '<tr id="bAzul">';
					echo '	<td colspan=8 style="font-size: 18px; font-weight:700">';

								$sTotales = 0;
								$txt = 'Total RAM (Última UF '.number_format($ultUF, 2, ',', '.').') x ';
								if($tRAMsUF>0){
									$txt .= number_format($tRAMsUF, 2, ',', '.').' UF';
									$sTotales = $ultUF * $tRAMsUF;
									$txt .= ' = '.number_format($sTotales, 0, ',', '.');
								}
								echo $txt;
								
					echo '	</td>';
					echo '</tr>';
				echo '	</table>';
			}
			?>


<!-- 
****************************************************************************************************************
*
*             Nominas de Servicios Terminados
*
*
****************************************************************************************************************

-->
		<?php
		function sTerminados($filtroCli){
				global $ultUF, $usrFiltro;
				$filtro = '';
				if($usrFiltro){
					$filtro = " and usrCotizador Like '%".$usrFiltro."%'";
				}
				if($filtroCli){
					$filtro = " and RutCli Like '%".$filtroCli."%'";
				}
				$tAMsUF 	= 0;
				$tAMsPe 	= 0;
				$tAMsUFsinF = 0;
				$tAMsPesinF = 0;
				
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloSel">';
				echo '		<tr>';
				echo '			<td  width="10%" align="center" height="40">AM					</td>';
				echo '			<td  width="10%">							Tipo Cot<br>Resp.	</td>';
				echo '			<td  width="22%">							Clientes			</td>';
				echo '			<td  width="14%">							Valor<br>Bruto		</td>';
				echo '			<td  width="10%">							Fecha AM<br>Fecha Up</td>';
				echo '			<td  width="10%">							Informes<br>N°/Sub.	</td>';
				echo '			<td  width="10%">							Estado 				</td>';
				echo '			<td  width="14%" align="center">Seguimiento	</td>';
				echo '		</tr>';
/*
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListadoCAM">';
*/				
				$n 		= 0;
				$link=Conectarse();
				
				//if($_SESSION[usr]=='Alfredo.Artigas' or $_SESSION[usr] == '10074437' or $_SESSION[IdPerfil] == 0){
				if($_SESSION['usr']=='Alfredo.Artigas' or $_SESSION['usr'] == '10074437'){
					if($filtro){
						//$sql = "SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'T' and Archivo != 'on' ".$filtro." Order By Facturacion, Archivo, informeUP, oCtaCte, oCompra Desc, fechaTermino Desc";
						$sql = "SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'T' and Archivo != 'on' ".$filtro." Order By Facturacion, Archivo, informeUP, fechaTermino Desc";
						$bdEnc=$link->query($sql);
					}else{
						//$bdEnc=$link->query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'T' and Archivo != 'on' Order By Facturacion, Archivo, informeUP, oCtaCte, oCompra Desc, fechaTermino Desc");
						$bdEnc=$link->query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'T' and Archivo != 'on' Order By Facturacion, Archivo, informeUP, fechaTermino Desc");
					}
				}else{
					if($dBuscar){
						$bdEnc=$link->query("SELECT * FROM Cotizaciones Where usrResponzable = '".$_SESSION['usr']."' and RAM > 0 and Estado = 'T' and Archivo != 'on' and CAM Like '%".$dBuscar."%' Order By Facturacion, Archivo, informeUP, oCtaCte, oCompra Desc, fechaTermino Desc");
					}else{
						$bdEnc=$link->query("SELECT * FROM Cotizaciones Where usrResponzable = '".$_SESSION['usr']."' and RAM > 0 and Estado = 'T' and Archivo != 'on' Order By Facturacion, Archivo, informeUP, oCtaCte, oCompra Desc, fechaTermino Desc");
					}
				}
				if ($row=mysqli_fetch_array($bdEnc)){
					do{

						$tr = "bBlancaSel";
						if($row['Estado'] == 'T'){ 
							$tr = "bBlancaSel";
						}
						if($row['informeUP'] == 'on'){ 
							$tr = "bAmarillaSel";
							if($row['Facturacion'] != 'on'){ 
								$tAMsUFsinF += $row['NetoUF'];
								$tAMsPesinF += $row['Neto'];
							}
						}
						if($row['Facturacion'] == 'on'){ 
							$tr = "bVerdeSel";
							$tAMsUF += $row['NetoUF'];
							$tAMsPe += $row['Neto'];
							
						}
						if($row['Archivo'] == 'on'){ 
							$tr = "bAzulSel";
						}
/*						
						if($row['oCtaCte'] == 'on'){ 
							$tr = "barraNaranja";
						}
*/						
						echo '<tr class="'.$tr.'">';
						echo '	<td width="10%" style="font-size:12px;">';
									echo 	'R'.$row['RAM'].'<br>';
									echo 	'C'.$row['CAM'];
									if($row['Cta']){
										echo '<br>CC';
									}
									$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
									if($rowCli=mysqli_fetch_array($bdCli)){
										if($rowCli['nFactPend'] > 0){
											echo '<br><br>';
											echo '<img src="../imagenes/gener_32.png" align="left" width="16">'.$rowCli['nFactPend'];
										}
									}
								
						echo '	</td>';
						echo '	<td width="10%" style="font-size:12px;">';
									if($row['oCompra']=='on'){
										echo 'OC';
									}
									if($row['oMail']=='on'){
										echo 'Mail';
									}
									if($row['oCtaCte']=='on'){
										echo 'Cta.Cte';
									}
									if($row['nOC']){
										echo '<br>'.$row['nOC'];
									}
									echo '<br>'.$row['usrResponzable'];
									
									echo '<br>';
									// Verificar si tiene Facturas Pendientes de Pago
									$sDeuda = 0;
									$cFact	= 0;
									$fechaHoy = date('Y-m-d');
									$fecha90dias 	= strtotime ( '-90 day' , strtotime ( $fechaHoy ) );
									$fecha90dias	= date ( 'Y-m-d' , $fecha90dias );
									$bdDe=$link->query("SELECT * FROM SolFactura Where RutCli = '".$row['RutCli']."' and fechaPago = '0000-00-00'");
									if($rowDe=mysqli_fetch_array($bdDe)){
										do{
											if($rowDe['fechaFactura'] > '0000-00-00'){
												if($rowDe['fechaFactura'] < $fecha90dias){
													$sDeuda += $rowDe['Bruto'];
													$cFact++;
												}
											}
										}while ($rowDe=mysqli_fetch_array($bdDe));
									}
									if($sDeuda > 0){
										?>
										<script>
											var RutCli = '<?php echo $row["RutCli"]; ?>';
										</script>
										<?php
										echo '<br><div onClick="verDeuda(RutCli)"><img src="../imagenes/bola_amarilla.png"></div>';
										echo '<br><span style="color:#000; font-weight:800;">$ '.number_format($sDeuda, 0, ',', '.').'</span>';
										//echo '<br><span style="color:#FFFF00;">'.$fecha90dias.'</span>';
									}
									
						echo '	</td>';
						echo '	<td width="32%" style="font-size:12px;">';
							$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
							if($rowCli=mysqli_fetch_array($bdCli)){
								echo 	$rowCli['Cliente'];
							}
						echo '	</td>';
						echo '	<td width="14%">';
						echo '		<strong style="font-size:12px;">';
						echo 			number_format($row['BrutoUF'], 2, ',', '.').' UF';
						echo '		</strong>';
						echo ' 	</td>';
						echo '  <td width="10%">';
									$fd = explode('-', $row['fechaTermino']);
									echo $fd[2].'/'.$fd[1].'/'.$fd[0];
									//echo 'I'.$row[fechaInicio];
									$CodInforme 	= 'AM-'.$row['RAM'];
									$bdInf=$link->query("SELECT * FROM Informes Where CodInforme Like '%".$CodInforme."%'");
									if($rowInf=mysqli_fetch_array($bdInf)){
										if($rowInf['informePDF']){
											echo '<br>';
											$fd = explode('-', $rowInf['fechaUp']);
											echo $fd[2].'/'.$fd[1].'/'.$fd[0];
										}
									}
						echo '  <td>';
						echo '  <td width="10%">';
							$CodInforme 	= 'AM-'.$row['RAM'];
							$infoNumero 	= 0;
							$infoSubidos 	= 0;
							$fechaUp		= '';
							$bdInf=$link->query("SELECT * FROM Informes Where CodInforme Like '%".$CodInforme."%'");
							if($rowInf=mysqli_fetch_array($bdInf)){
								do{
									$infoNumero++;
									if($rowInf['informePDF']){
										$infoSubidos++;
									}
								}while ($rowInf=mysqli_fetch_array($bdInf));
							}
							echo '<strong>'.$infoNumero.'/'.$infoSubidos.'</strong>';
						echo '  <td>';
						echo '	<td width="10%">';
									$imgEstado = 'upload2.png';
									$msgEstado = 'Esperando Seguimiento';
									$fd[0] = 0;
									if($row['Estado'] == 'T'){ // En Espera
										$imgEstado = 'upload2.png';
										$msgEstado = 'Subir Informe';
									}
									if($row['informeUP'] == 'on'){ // Cerrada
										$imgEstado = 'informeUP.png';
										$msgEstado = 'Informe Subido';
										$fd = explode('-', $row['fechaInformeUP']);
									}
									if($row['Facturacion'] == 'on'){ // Cerrada
										$imgEstado = 'crear_certificado.png';
										$msgEstado = 'Facturado';
										$fd = explode('-', $row['fechaFacturacion']);
									}
									if($row['Archivo'] == 'on'){ // Cerrada
										$imgEstado = 'consulta.png';
										$msgEstado = 'Archivado';
										$fd = explode('-', $row['fechaArchivo']);
									}
									if($row['Estado'] == 'T' and $row['informeUP'] != 'on'){ // En Espera
										$CodInforme = 'AM-'.$row['RAM'];
										echo '<a href="informes/plataformaInformes.php?CodInforme='.$CodInforme.'"><img src="../imagenes/'.$imgEstado.'"	width="40" height="40" title="'.$msgEstado.'"></a>';
									}else{
										if($row['Estado'] == 'T' and $row['informeUP'] == 'on' and $row['Facturacion'] != 'on'){ // En Espera
											echo '<a href="facturacion/formSolicitaFactura.php?RutCli='.$row['RutCli'].'&Proceso=&nSolicitud="><img src="../imagenes/tpv.png"	width="40" height="40" title="Informe(s) subido(s), ir a Solicitud de Facturación..."></a>';
										}else{
											echo '<img src="../imagenes/'.$imgEstado.'"	width="40" height="40" title="'.$msgEstado.'">';
										}
									}
									if($fd[0]>0){
										echo '<br>'.$fd[2].'/'.$fd[1];
									}
						echo ' 	</td>';
						echo '	<td width="14%" align="center">';
								if($row['Estado'] == 'T'){ // En Proceso
									echo '<a href="plataformaCotizaciones.php?CAM='.$row['CAM'].'&RAM='.$row['RAM'].'&accion=SeguimientoAM"		><img src="../gastos/imagenes/klipper.png" 			width="40" height="40" title="Seguimiento">			</a>';
								}else{
									echo '<img src="../gastos/imagenes/klipper.png" width="40" height="40" title="Seguimiento" style="opacity:0;">';
								}
						echo '	</td>';
						echo '</tr>';
					}while ($row=mysqli_fetch_array($bdEnc));
				}
				$link->close();
					echo '<tr id="bAzul">';
					echo '	<td colspan=10 style="font-size: 16px; font-weight:700">';
								echo 'Última UF de Referencia '.number_format($ultUF, 2, ',', '.');
/*
								$txt = '<br>Total Facturado ';
								$sTotales = 0;
								if($tAMsUF>0){
									$txt .= ' x '.number_format($tAMsUF, 2, ',', '.').' UF';
									$sTotales += $ultUF * $tAMsUF;
								}
								if($tAMsPe>0){
									$txt .= ' $ '.number_format($tAMsPe, 0, ',', '.');
									$sTotales += $tAMsPe;
								}
								$txt .= ' = $ '.number_format($sTotales, 0, ',', '.');
								echo $txt;
*/								
								
								$sTotales = 0;
								$txt = 'Total NO Facturado ';
								if($tAMsUFsinF>0){
									$txt .= number_format($tAMsUFsinF, 2, ',', '.').' UF';
									$sTotales += $ultUF * $tAMsUFsinF;
									echo '<br>'.$txt.' = $ '.number_format($sTotales, 0, ',', '.');
								}
								
								
					echo '	</td>';
					echo '</tr>';
				
				echo '	</table>';
			}
			?>



<?php
	function enviarAviso($e, $CAM, $nDias){
/*
		$email	 = 'simet@usach.cl'; 
		$msg 	 = 'Faltan <strong>'.$nDias.'</strong> para que se venza cotización '.$CAM;
		$headers = "From: SIMET-USACH <".$email."> \r\n"; 
		//$headers .= "Bcc: francisco.olivares.rodriguez@gmail.com \r\n"; 
		$headers .= "Content-Type: text/html; charset=iso-8859-1\n";

		$themessage = '<br> Alerta de vencimiento cotización <br><strong>'.$CAM.'.</strong><br>'; 
		$themessage = '<br> Solicito prestar atención.<br>'; 
		$themessage .= '<pre style="font-size:14; font-family:Geneva, Arial, Helvetica, sans-serif;">'.$msg.'</pre><br>'; 
		$result=mail($e, "Control CAM - SIMET ", $themessage,$headers); 
		if($result=True){ 
			echo $e.' Enviado...! <br> '; 
		}else{
			echo $e.' ERROR NO Enviado...! <br> '; 
		}
*/
	
	}
?>
<script> 
var color=false; 
function cambiar() { 
    color = !color; 
    document.getElementById("tabla").style.background= color ? "red" : "blue"; 
    setTimeout("cambiar()",1000); //1000 = 1 segundo 
} 
</script> 
