<?php
	$Proceso = '';
	$rango 	= 0;
	
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
	$valorUFRef		= 0;
	
	$link=Conectarse();
	$bd=$link->query("SELECT * FROM tablaregform" );
	if($row=mysqli_fetch_array($bd)){
		$rCot 		= $row['rCot'];
		$ufRefPesos = $row['valorUFRef'] * $row['rCot'];
		$valorUFRef = $row['valorUFRef'];
	}
	$link->close();
	if($rango == 0){ $rango = 5; }
	if($rango > 0){
		$link=Conectarse();
		$bdTs=$link->query("SELECT * FROM tablaSegAM Where rangoDesde = '".$rango."' Order By rangoDesde" );
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
										 5 => ' 5 - 15',
										16 => '16 - 30',
										31 => '31 - 45',
										46 => '46 - 60',
										61 => '61 - más'
									);
					$vRango = array(0, 5, 16, 31, 46, 61);
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
<!--
				<div class="botonBarraOpciones">
					<a href="plataformaFacturas.php?rango=5" title="5 a 44" style="background-color:#0066CC;">
						5 - 44
					</a>
				</div>
				<div class="botonBarraOpciones">
					<a href="plataformaFacturas.php?rango=45" title="45 a 59">
						45 - 59
					</a>
				</div>
				<div class="botonBarraOpciones">
					<a href="plataformaFacturas.php?rango=60" title="45 a 59">
						60 - 74
					</a>
				</div>
				<div class="botonBarraOpciones">
					<a href="plataformaFacturas.php?rango=75" title="45 a 59">
						75 - 90
					</a>
				</div>
				<div class="botonBarraOpciones">
					<a href="plataformaFacturas.php?rango=90" title="45 a 59">
						90 - más
					</a>
				</div>
-->				
			</div>
			<?php if($Instrucciones){ ?>
			<div id="BarraOpciones">
				<div style="color:#FFFFFF; font-size:18px; padding:10px;">
					<?php 
						$fd = explode('-',$fechaIni);
						//echo $Instrucciones;
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
				echo '			<td  width="10%" align="center"><strong>AM							</strong></td>';
				echo '			<td  width="08%" align="center"><strong>Resp.						</strong></td>';
				echo '			<td  width="15%" align="center"><strong>Cliente						</strong></td>';
				echo '			<td  width="10%" align="center"><strong>Valor						</strong></td>';
				echo '			<td  width="10%" align="center"><strong>Termino<br>Sol.Fact.<br>Up Inf.	</strong></td>';
				echo '			<td  width="25%" align="center"><strong>Estado						</strong></td>';
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
				$filtroSQL = "Where Estado = 'T' and Facturacion != 'on' and nSolicitud = 0 and RAM > 0 and Archivo != 'on' and (fechaTermino >= '".$fechaIni."' and fechaTermino <= '".$fechaTer."')";

/*				
				$bdHon=$link->query("SELECT * FROM Cotizaciones $filtroSQL Order By  fechaTermino Asc" );
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
*/
				$bdHon=$link->query("SELECT * FROM Cotizaciones $filtroSQL Order By Eliminado, fechaTermino Asc" );
				if($row=mysqli_fetch_array($bdHon)){
					do{
						$cFree = 'off';
						$bdPer=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
						if ($rowP=mysqli_fetch_array($bdPer)){
							if($rowP['cFree'] == 'on'){
								$cFree = 'on';
							}
							if($rowP['Docencia'] == 'on'){
								$cFree = 'on';
							}
						}
						$fd = explode('-', $row['fechaTermino']);
						if($cFree == 'off'){
							$tr = "barraBlanca";
							if($row['Estado']=='I'){
								$tr = 'barraVerde';
							}
							if($row['informeUP']=='on'){
								$tr = 'barraAmarilla';
							}
							if($row['Seguimiento'] == 'on'){
								//$tr = 'barraRoja';
							}
							$tr = 'barraRoja';

							$bd=$link->query("SELECT * FROM seguimientoam Where CAM = '".$row['CAM']."' Order By fechaContacto Desc" );
							if($rowSeg=mysqli_fetch_array($bd)){
								$tr = 'barraAmarilla';
							}
							if($row['NetoUF'] == 0){
								if($row['Neto'] >= $ufRefPesos){
									//$tr = 'barraRoja';
								}
							}else{
								if($row['NetoUF'] >= $rCot){
									//$tr = 'barraRoja';
								}
							}
							if($row['Eliminado'] == 'on'){
								$tr = 'barraAzul';
								$totalIncobrable += $row['Bruto'];
							}
							if($rango < 31){
								$tr = 'barraAmarilla';
							}

							if(!empty($rowSeg['fechaProxContacto'])){
								if($rowSeg['fechaProxContacto'] <= date('Y-m-d')){
									$tr = 'barraRoja';
								}
							}

							echo '	<tr id="'.$tr.'">';
							echo '			<td width="05%" style="font-size:16px;">';
							echo '			</td>';
							echo '			<td width="10%">';
												echo 'RAM-'.$row['RAM'].'<br>';
												echo 'CAM-'.$row['CAM'].'<br>';
												//echo 'Rango-'.$rango.'<br>';

							echo '			</td>';
							echo '			<td width="08%">';
												echo $row['usrResponzable'].'<br>';
							echo '			</td>';
							echo '			<td width="15%">';
												$bdPer=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
												if ($rowP=mysqli_fetch_array($bdPer)){
													echo '<strong>'.$rowP['Cliente'].'</strong>';
												}
							echo '			</td>';
							echo '			<td width="10%" align="center">';
													echo $row['BrutoUF'].' UF';
													if($row['Bruto'] > 0){
														echo '<br>'.number_format($row['Bruto'], 0, ',', '.');
													}else{
														echo '<br> $ '.number_format($row['BrutoUF']*$valorUFRef, 0, ',', '.');
														$totalDeuda += ($row['BrutoUF']*$valorUFRef);
													}
							echo ' 			</td>';
							echo '			<td width="10%" align="center">';
												$fd = explode('-', $row['fechaTermino']);
												echo 'Ter.'.$fd[2].'-'.$fd[1].'-'.$fd[0];
												if($row['fechaFacturacion'] > '0000-00-00'){
													$fd = explode('-', $row['fechaFacturacion']);
													echo '<br>Sol.'.$fd[2].'-'.$fd[1].'-'.$fd[0];
												}
												if($row['fechaInformeUP'] > '0000-00-00'){
													$fd = explode('-', $row['fechaInformeUP']);
													echo '<br>UP.'.$fd[2].'-'.$fd[1].'-'.$fd[0];
												}
							echo ' 			</td>';
							echo '			<td width="25%">';
												$bdFac=$link->query("SELECT * FROM seguimientoAM Where CAM = '".$row['CAM']."' Order By fechaContacto Desc");
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
							echo '			</td>';
							//echo '			<td width="17%" colspan=3 align="center"><a href=""><img src="../gastos/imagenes/klipper.png"   		width="32" height="32" title="Seguimiento">					</a></td>';
							echo '			<td width="17%" colspan=3 align="center"><a href="seguimientoSolicitudes.php?Proceso=2&RutCli='.$row['RutCli'].'&CAM='.$row['CAM'].'&rango='.$rango.'"><img src="../gastos/imagenes/klipper.png"   		width="32" height="32" title="Seguimiento">					</a></td>';
							echo '	</tr>';
						}
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
				echo '			<td  width="10%" align="center"><strong>Total			</strong></td>';
				echo '			<td  width="10%" align="center"><strong>'.number_format($totalDeuda, 0, ',', '.').'</strong></td>';
				echo '			<td  width="15%" align="center"></td>';
				echo '			<td  width="10%" align="center"></td>';
				echo '			<td  width="15%" ><strong>';
										if($totalIncobrable > 0){
											echo number_format($totalIncobrable, 0, ',', '.');
										}
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
		