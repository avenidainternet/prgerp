<?php
	$Proceso = '';
	$rango 	= 0;
	
	if(isset($_POST['borrarSolicitud'])){ 
		if(isset($_POST['nSolicitud'])) { $nSolicitud  = $_POST['nSolicitud']; 	}
		if(isset($_POST['RutCli'])) 	{ $RutCli   	= $_POST['RutCli']; 	}
		$link=Conectarse();
		$bdDet=$link->query("SELECT * FROM Clientes WHERE RutCli = '".$RutCli."'");
		if($rowDet=mysqli_fetch_array($bdDet)){ 
			$Cliente = $rowDet['Cliente'];
		}
		$link->close();
		$link=Conectarse();
		$bdSol=$link->query("SELECT * FROM SolFactura WHERE nSolicitud = '".$nSolicitud."'");
		if($rowSol=mysqli_fetch_array($bdSol)){
			$bdSol=$link->query("DELETE FROM SolFactura WHERE nSolicitud = '".$nSolicitud."'");
			$bdDet=$link->query("DELETE FROM detSolFact WHERE nSolicitud = '".$nSolicitud."'");
		}
		$link->close();
		$RutCli 	= "";
		$nSolicitud = "";
	}

	$Estado = array(
					1 => 'Estado', 
					2 => 'Fotocopia',
					3 => 'Factura',
					4 => 'Canceladas'
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
				
	$MesNum = array(	
					'Enero' 		=> '01', 
					'Febrero' 		=> '02',
					'Marzo' 		=> '03',
					'Abril' 		=> '04',
					'Mayo' 			=> '05',
					'Junio' 		=> '06',
					'Julio' 		=> '07',
					'Agosto' 		=> '08',
					'Septiembre'	=> '09',
					'Octubre' 		=> '10',
					'Noviembre' 	=> '11',
					'Diciembre'		=> '12'
				);

	//$MesHon 	= $Mm;
	$Proyecto 	= "Proyectos";
	//$MesFiltro  = "Mes";
	$Situacion 	= "Estado";
	$Agno     	= date('Y');
	$AgnoAct	= date('Y');
	
	if(isset($_GET['Proyecto']))  	{ $Proyecto  = $_GET['Proyecto']; 	}
	if(isset($_GET['MesFiltro'])) 	{ $MesFiltro = $_GET['MesFiltro']; 	}
	if(isset($_GET['Estado'])) 		{ $Situacion = $_GET['Estado']; 	}
	if(isset($_GET['Agno'])) 		{ $Agno 	 = $_GET['Agno']; 		}
	
	if(isset($_GET['rango'])) 		{ $rango 	 = $_GET['rango']; 		}
	
	$fechaHoy 		= date('Y-m-d');
	$fechaIni 		= '0000-00-00';
	$fechaTer 		= $fechaHoy;
	$Instrucciones = '';
	$rCot 			= 0;
	$ufRefPesos		= 0;
	
	$link=Conectarse();
	$bd=$link->query("SELECT * FROM tablaregform" );
	if($row=mysqli_fetch_array($bd)){
		$rCot 		= $row['rCot'];
		$ufRefPesos = $row['valorUFRef'] * $row['rCot'];
	}
	$link->close();
	if($rango == 0){ $rango = 5; }
	if($rango > 0){
		$link=Conectarse();
		$bdTs=$link->query("SELECT * FROM tablaSegFacturas Where rangoDesde = '".$rango."' Order By rangoDesde" );
		if ($rowTs=mysqli_fetch_array($bdTs)){
			$Instrucciones = $rowTs['Instrucciones'];
			if($rowTs['rangoHasta'] == 0){
				$fechaIni = '0000-00-00';
			}else{
				$fechaIni 	= strtotime ( '-'.$rowTs['rangoHasta'].' day' , strtotime ( $fechaHoy ) );
				$fechaIni	= date ( 'Y-m-d' , $fechaIni );
			}	
			$fechaTer 	= strtotime ( '-'.$rowTs['rangoDesde'].' day' , strtotime ( $fechaHoy ) );
			$fechaTer	= date ( 'Y-m-d' , $fechaTer );
		}
		$link->close();
	}
	
	$dBuscado = '';
	$nOrden	  = '';
	if(isset($_POST['dBuscado'])) 	{ $dBuscado  = $_POST['dBuscado']; 	}
	if(isset($_POST['nOrden'])) 	{ $nOrden    = $_POST['nOrden']; 	}
	
?>

			<div id="BarraOpciones">
				<div id="ImagenBarraLeft">
					<a href="../plataformaErp.php" title="Menú Principal">
						<img src="../gastos/imagenes/Menu.png"><br>
					</a>
					Principal
				</div>
				<?php
					$txtRango = array( 
										 5 => ' 5 - 44',
										45 => '45 - 59',
										60 => '60 - 74',
										75 => '75 - 90',
										90 => '90 - más'
									);
					$vRango = array(0, 5, 45, 60, 75, 90);
				?>
				<?php for($i=1; $i<=5; $i++) {
					$mRango 	= $vRango[$i];
					$mEstilo 	= '';
					if($rango == $mRango) {
						$mEstilo 	= 'style="background-color:#0066CC;"';
					}
					?>
					<div class="botonBarraOpciones">
						<a href="plataformaFacturas.php?rango=<?php echo $mRango; ?>" title=<?php echo $txtRango[$mRango].' '.$mEstilo; ?> >
							<?php echo $txtRango[$mRango]; ?>
						</a>
					</div>
				<?php } ?>
			</div>
			<?php if($Instrucciones){ ?>
			<div id="BarraOpciones">
				<div style="color:#FFFFFF; font-size:18px; padding:10px;">
					<?php 
						$fd = explode('-',$fechaIni);
						echo $Instrucciones;
						echo ' Desde '.$fd[2].'-'.$fd[1].'-'.$fd[0];
						$fd = explode('-',$fechaTer);
						echo ' Hasta '.$fd[2].'-'.$fd[1].'-'.$fd[0];
					?>
				</div>
			</div>
			<?php } ?>
			<?php
				echo '<div>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td  width="05%" align="center" height="40"><strong>N°				</strong></td>';
				echo '			<td  width="10%" align="center"><strong>Fecha<br>Solicitudes			</strong></td>';
				echo '			<td  width="08%" align="center"><strong>Proyecto					</strong></td>';
				echo '			<td  width="15%" align="center"><strong>Cliente						</strong></td>';
				echo '			<td  width="10%" align="center"><strong>Fotocopia					</strong></td>';
				echo '			<td  width="10%" align="center"><strong>Factura						</strong></td>';
				echo '			<td  width="10%" align="center"><strong>Monto						</strong></td>';
				echo '			<td  width="15%" ><strong>RAM<br>CAM								</strong></td>';
				echo '			<td  width="17%" align="center" colspan="2"><strong>Seguimiento		</strong></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListado">';
				$n 		= 0;
				$tBruto = 0;
				$link=Conectarse();
				/* Inicio Filtros */

				$totalDeuda 	 = 0;
				$totalIncobrable = 0;
				$totalNoPuerto	 = 0;
				//$filtroSQL = "Where pagoFactura <> 'on' and nFactura > 0 and (fechaFactura = ".$fechaIni.")";
				$filtroSQL = "Where pagoFactura <> 'on' and nFactura > 0 and (fechaFactura >= '".$fechaIni."' and fechaFactura <= '".$fechaTer."')";
					
				$bdHon=$link->query("SELECT * FROM SolFactura $filtroSQL Order By Eliminado, fechaSolicitud Asc" );
				if($row=mysqli_fetch_array($bdHon)){
					do{
						if($rango > 5){
							if($row['Seguimiento'] == '' and $row['fechaSeguimiento'] == '0000-00-00'){
								
								$actSQL="UPDATE SolFactura SET ";
								$actSQL.="Seguimiento			= 'on'";
								$actSQL.="WHERE nSolicitud		= '".$row['nSolicitud']."' and RutCli = '".$row['RutCli']."'";
								$bdFac=$link->query($actSQL);

								$Seguimiento = 'on'; 
							}
						}
					}while ($row=mysqli_fetch_array($bdHon));
				}

				// $bdHon=$link->query("SELECT * FROM solfactura $filtroSQL and Eliminado != 'on' Order By Eliminado, fechaSolicitud Asc" );
				$bdHon=$link->query("SELECT * FROM solfactura $filtroSQL  Order By Eliminado, fechaSolicitud Asc" );
				if($row=mysqli_fetch_array($bdHon)){
					do{
						$fd = explode('-', $row['fechaSolicitud']);
						//if($MesFiltro == $Mes[intval($fd[1])]){
							$tr = "barraBlanca";
							if($row['Estado']=='I'){
								$tr = 'barraVerde';
							}
							if($row['Fotocopia']=='on' && $row['Factura'] == 'on'){
								$tr = 'barraAmarilla';
							}
							if($row['Fotocopia']=='on' && ($row['Factura'] == '' or $row['Factura'] == '0')){
								$tr = 'barraNaranjo';
							}
							if($row['pagoFactura']=='on'){
								$tr = 'barraPagada';
							}
							if($row['recepcionada'] == 'on'){
								$tr = 'barraVerde';
							}
							if($row['Seguimiento'] == 'on'){
								$tr = 'barraRoja';
							}
							$bd=$link->query("SELECT * FROM seguimientofactura Where nFactura = '".$row['nFactura']."' Order by fechaProxContacto Desc" );
							if($rowSeg=mysqli_fetch_array($bd)){
								$tr = 'barraAmarilla';
							}
							

							if($row['netoUF'] == 0){
								if($row['Neto'] >= $ufRefPesos){ 
									//$tr = 'barraRoja';
								}
							}else{
								if($row['netoUF'] >= $rCot){
									//$tr = 'barraRoja';
								}
							}
							if($rango <= 5){
								$tr = 'barraAmarilla';
							}
							$fechaActual = date('Y-m-d');
							if(!empty($rowSeg['fechaProxContacto'])){
								if($rowSeg['fechaProxContacto'] <= $fechaActual){
									$tr = 'barraRoja';
								}
							}
							if($row['Eliminado'] == 'on' and $row['noPuerto'] != 'on'){
								$tr = 'barraAzul';
								// $totalIncobrable += $row['Bruto'];
							}
							if($row['noPuerto'] == 'on'){
								$tr = 'barraNegra';
								$totalNoPuerto += $row['Bruto'];
							}
							$totalDeuda += $row['Bruto'];
							if($tr == 'barraAzul'){

							}else{
							
								echo '	<tr id="'.$tr.'">';
								echo '			<td width="05%" style="font-size:16px;">'.$row['nSolicitud'].'</td>';
								echo '			<td width="10%">';
													$fd = explode('-', $row['fechaSolicitud']);
													echo $fd[2].'-'.$fd[1].'-'.$fd[0];
													if(!empty($rowSeg['fechaProxContacto'])){
														echo '<br>';
														echo $rowSeg['fechaProxContacto'];
														//echo '<br>'.$rowSeg['fechaProxContacto'].' '.date('Y-m-d');
		
													}
								echo '			</td>';
								echo '			<td width="08%">'.$row['IdProyecto'].'</td>';
								echo '			<td width="15%">';
													$bdPer=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
													if ($rowP=mysqli_fetch_array($bdPer)){
														echo '<strong>'.$rowP['Cliente'].'</strong>';
													}
								echo '			</td>';
								echo '			<td width="10%" align="center">';
													if($row['Fotocopia'] == 'on'){
														$fd = explode('-', $row['fechaFotocopia']);
														echo '<img src="../gastos/imagenes/Confirmation_32.png" width="14" height="14">';
														echo $fd[2].'-'.$fd[1].'-'.$fd[0];
													}
													if($row['nOrden']){
														echo '<br>OC-'.$row['nOrden'];
													}
								echo ' 			</td>';
								echo '			<td width="10%" align="center">';
													if($row['Factura'] == 'on'){
														$fd = explode('-', $row['fechaFactura']);
														echo '<img src="../gastos/imagenes/Confirmation_32.png" width="14" height="14">';
														echo $fd[2].'-'.$fd[1].'-'.$fd[0].'<br>';
														echo 'N° '.$row['nFactura'];
													}
								echo ' 			</td>';
								echo '			<td width="10%" align="center">';
													if($row['tipoValor']=='U'){
														if($row['Neto']>0){
															echo $row['brutoUF'].' UF <br>';
															echo number_format($row['Bruto'], 0, ',', '.');
														}else{
															echo $row['brutoUF'].' UF';
														}
													}else{
														echo number_format($row['Bruto'], 0, ',', '.');
													}
								echo ' 			</td>';
								echo '			<td width="15%">';
													$i = 0;
													if($rango == 5){
														if($row['recepcionada'] == 'on'){
															$fd = explode('-', $row['fechaRecepcion']);
															echo 'Recepcionada: '.$fd[2].'-'.$fd[1].'-'.$fd[0]; 
															$i++;
														}
													}
													$bdFac=$link->query("SELECT * FROM seguimientofactura Where nFactura = '".$row['nFactura']."' Order By fechaContacto Desc");
													if ($rowFac=mysqli_fetch_array($bdFac)){
														do{
															$i++;
															if($i > 1) { 
																echo '<br><span style="font-family:arial; font-size:10px;"><img src="../imagenes/bola_roja.png" width=8> '.$rowFac['fechaContacto'].' '.$rowFac['txtContacto'].'</span>';
															}else{
																echo '<span style="font-family:arial; font-size:10px;"><img src="../imagenes/bola_roja.png" width=8> '.$rowFac['fechaContacto'].' '.$rowFac['txtContacto'].'</span>';
															}
														}while ($rowFac=mysqli_fetch_array($bdFac));
													}
													$txtRAM = '';
													$txtCAM = '';
													$bdCAM=$link->query("SELECT * FROM Cotizaciones where nSolicitud = '".$row['nSolicitud']."'");
													if ($rowCAM=mysqli_fetch_array($bdCAM)){
														do{
															if($txtRAM){
																$txtRAM .= ' - '.$rowCAM['RAM'];
															}else{
																$txtRAM = '<hr>RAM '.$rowCAM['RAM'];
															}
															if($txtCAM){
																$txtCAM .= ' - '.$rowCAM['CAM'];
															}else{
																$txtCAM = '<br>CAM '.$rowCAM['CAM'];
															}
														}while ($rowCAM=mysqli_fetch_array($bdCAM));
													}
													if($txtRAM){ echo $txtRAM; }
													if($txtCAM){ echo $txtCAM; }
								echo '			</td>';
								echo '			<td width="17%" colspan=3 align="center"><a href="seguimientoSolicitudes.php?Proceso=2&RutCli='.$row['RutCli'].'&nSolicitud='.$row['nSolicitud'].'&rango='.$rango.'"><img src="../gastos/imagenes/klipper.png"   		width="32" height="32" title="Seguimiento">					</a></td>';
								echo '	</tr>';

							}

						//}
					}while ($row=mysqli_fetch_array($bdHon));
				}
				$totalDeuda -= $totalIncobrable;
				$link->close();
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td  width="05%" align="center" height="40"></td>';
				echo '			<td  width="10%" align="center"></td>';
				echo '			<td  width="08%" align="center"></td>';
				echo '			<td  width="15%" align="center"></td>';
				echo '			<td  width="10%" align="center"></td>';
				echo '			<td  width="10%" align="center"><strong>Total			</strong></td>';
				echo '			<td  width="10%" align="center"><strong>'.number_format($totalDeuda, 0, ',', '.').'</strong></td>';
				echo '			<td  width="7.5%"><strong>';
										if($totalIncobrable > 0){
											echo number_format($totalIncobrable, 0, ',', '.');
										}
				echo '			</strong></td>';
				echo '			<td  width="7.5%"><strong>';
										?>
										<div style="color:#000; block:inline;">
										<?php
										if($totalNoPuerto > 0){
											echo number_format($totalNoPuerto, 0, ',', '.');
										}?>
										</div>
										<?php
				echo '			</strong></td>';
				echo '			</strong></td>';
				echo '			<td  width="17%" align="center" colspan="2"></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '</div>';
				if(isset($_GET['Proceso']) == 5){
					?>
					<div class="boxEliminacion">
						<form name="form" action="plataformaFacturas.php" method="post">
							Segro de borrar <b>Solicitud de Factura</b>?
							<br><br>
							<hr>
							<table width="100%">
								<tr>
									<td width="24%">N° Solicitud</td>
									<td>:
										<?php echo $_GET['nSolicitud']; ?>
										<input name="nSolicitud" type="hidden" value="<?php echo $_GET['nSolicitud']; ?>">
									</td>
								</tr>
								<tr>
									<td>Cliente</td>
									<td>:
										<?php 
											$link=Conectarse();
											$bdDet=$link->query("SELECT * FROM Clientes WHERE RutCli = '".$_GET['RutCli']."'");
											if($rowDet=mysqli_fetch_array($bdDet)){
												$Cliente = $rowDet['Cliente'];
											}
											$link->close();
											echo $Cliente; 
										?>
										<input name="RutCli" type="hidden" value="<?php echo $_GET['RutCli']; ?>">
									</td>
								</tr>
								<tr>
									<td>Fecha Solicitud</td>
									<td>:
										<?php 
											$link=Conectarse();
											$bdDet=$link->query("SELECT * FROM SolFactura WHERE nSolicitud = '".$_GET['nSolicitud']."'");
											if($rowDet=mysqli_fetch_array($bdDet)){
												$fechaSolicitud = $rowDet['fechaSolicitud'];
												$tipoValor 		= $rowDet['tipoValor'];
												$brutoUF 		= $rowDet['brutoUF'];
												$Bruto 			= $rowDet['Bruto'];
											}
											$link->close();
											$fd = explode('-', $fechaSolicitud);
											echo $fd[2].'-'.$fd[1].'-'.$fd[0];
										?>
									</td>
								</tr>
								<tr>
									<td>Monto</td>
									<td>:
										<?php 

											if($tipoValor == 'U'){
												echo $brutoUF.' UF';
											}
											if($tipoValor == 'P'){
												echo '$ '.number_format($Bruto, 0, ',', '.');
											}
										?>
									</td>
								</tr>
								<tr>
									<td colspan="2"><hr></td>
								</tr>
								<tr>
									<td colspan="2" align="right">							
										<button name="cancelarEliminacion" title="Cancelar">
											<img src="../gastos/imagenes/flecha_return.png" width="100" height="100">
										</button>
										<button name="borrarSolicitud" title="Borrar Solicitud de Factura">
											<img src="../gastos/imagenes/inspektion.png" width="100" height="100">
										</button>
									</td>
								</tr>
							</table>
						</form>
					</div>
					<?php
				}
			?>
		</div>
		