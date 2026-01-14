<?php
	//nclude_once("Mobile-Detect-2.3/Mobile_Detect.php");
 	//$Detect = new Mobile_Detect();
	date_default_timezone_set("America/Santiago");
	include_once("inc/funciones.php");
	include_once("conexionli.php");
	
	$horaAct = date('H:i');
	$fechaHoy = date('Y-m-d');
	$fp = explode('-', $fechaHoy);
	$Periodo = $fp[1].'-'.$fp[0];
	
	//cuentaEnsayosActivos($Periodo);
	
	if($horaAct >= "13:30" and $horaAct <= "14:00") {
		$fd = explode('-', $fechaHoy);
		$carpetaRespaldo = 'z:backup-'.$fd[2].'-'.$fd[1].'-'.$fd[0];
		if(!file_exists($carpetaRespaldo)) {
			mkdir($carpetaRespaldo, 0777, true);
		}
		$link=Conectarse();
		$tables = array();
		$result = $link->query('SHOW TABLES');
		while($row = mysqli_fetch_row($result))
		{
			$tables[] = $row[0];
		}



		foreach($tables as $table){
			$return = '';
			$result = $link->query('SELECT * FROM '.$table);
			$num_fields = mysqli_num_fields($result);
			$row2 = mysqli_fetch_row($link->query('SHOW CREATE TABLE '.$table));
			$return = 'DELETE FROM '.$table.' WHERE 1';
			$return.= ";Fin\n";
			for ($i = 0; $i < $num_fields; $i++){
				while($row = mysqli_fetch_row($result)){
					$return.= 'INSERT INTO '.$table.' VALUES(';
					for($j=0; $j<$num_fields; $j++){
						$row[$j] = utf8_decode($row[$j]);
						$Obs = str_replace("'","´",$row[$j]);
						$row[$j] = $Obs;
						if (isset($row[$j])) { $return.= "'".$row[$j]."'" ; } else { $return.= "''"; }
						if ($j<($num_fields-1)) { $return.= ','; }
					}
					$return.= ");Fin\n";
				}
			}
			$ficheroRespaldo = $carpetaRespaldo.'/'.$table.'.sql';
			$archivoBackup	= $ficheroRespaldo;
			$handle = fopen($ficheroRespaldo,'w+');
			fwrite($handle,$return);
			fclose($handle);
		}

		$link->close();








		
	}

		$nRams = 0; 
		$link=Conectarse();
		$sql 	= "SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P'";  // sentencia sql
		$result = $link->query($sql);
		$nRams 	= $result->num_rows; // obtenemos el n�mero de filas
		
		$nFactPend = 0;
		$actSQL="UPDATE Clientes SET ";
		$actSQL.="nFactPend		= '".$nFactPend."'";

		$bdCli=$link->query($actSQL);

		$bdCot=$link->query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'T' and Facturacion != 'on' Order By RutCli");
		if($row=mysqli_fetch_array($bdCot)){
			do{
				$treinta = 30;
				$fechaHoy = date('Y-m-d');
				$fecha30 	= strtotime ( '-'.$treinta.' day' , strtotime ( $fechaHoy ) );
				$fecha30 	= date ( 'Y-m-d' , $fecha30 );
					
				if($row['fechaInicio'] < $fecha30){
					$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
					if($rowCli=mysqli_fetch_array($bdCli)){
						$nFactPend = $rowCli['nFactPend'];
						$nFactPend++;
						$actSQL="UPDATE Clientes SET ";
						$actSQL.="nFactPend		= '".$nFactPend."'";
						$actSQL.="WHERE RutCli 	= '".$row['RutCli']."'";
						$bdCli=$link->query($actSQL);
					}
				}
			}while ($row=mysqli_fetch_array($bdCot));
		}

		$link->close();

?>
	
	<table width="100%"  border="0" cellspacing="0" cellpadding="0" style="margin:0px;">
		<tr>
			<td valign="top" align="left" width="10%">
				<?php
				if($nCols=1){
				}
					mRAMs(0,14);
				?>
			</td>
			<td valign="top" align="left" width="10%">
				<?php
					mRAMs(14,14);
				if($nCols>1 and $nCols<2){
				}
				?>
			</td>
			<td valign="top" align="left" width="10%">
				<?php
					mRAMs(28,14);
				if($nCols>2 and $nCols<3){
				}
				?>
			</td>
			<td valign="top" align="left" width="10%">
				<?php
					mRAMs(42,14);
				if($nCols>3){
				}
				?>
			</td>
			<td valign="top" align="left" width="10%">
				<?php
					//mRAMs(60,15);
					verEnsayosenProceso($Periodo);
				if($nCols>3){
				}
				?>
			</td>
	  	</tr>
	</table>

		<?php
		function mRAMs($il, $tl){
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloTv">';
				echo '		<tr>';
				echo '			<td  width="10%" align="center" height="40">PAM			 </td>';
				echo '			<td  width="10%">							Ini.		 </td>';
				echo '			<td  width="10%">							Tér.		 </td>';
				echo '			<td  width="10%">							Días	 	 </td>';
				echo '			<td  width="20%">							Clientes	 </td>';
				echo '			<td  width="30%">							Observaciones</td>';
				echo '			<td  width="10%">										 </td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListadoTv">';
				$n 		= 0;
				$link=Conectarse();
				
				$bdEnc=$link->query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P' Order By RAM Asc Limit $il, $tl");
				if ($row=mysqli_fetch_array($bdEnc)){
					do{
						list($ftermino, $dhf, $dha, $dsemana) = fnDiasHabiles($row['fechaInicio'],$row['dHabiles'],$row['horaPAM']);




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
						if($dhf > 0){ // Enviada
							$tr = 'bVerde';
							if($dhf == 2 or $dhf ==1){ // En Proceso
								$tr = "bAmarilla";
							}
						}
						if($dha > 0){ // Enviada
							$tr = 'bRoja';
						}

						
						echo '<tr id="'.$tr.'">';
						echo '	<td width="10%">';
								echo 	'R'.$row['RAM'].'<br>';
								echo 	'C'.$row['CAM'];
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
										echo '<br><img src="imagenes/bola_amarilla.png">';
									}
									$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
									if($rowCli=mysqli_fetch_array($bdCli)){
										if($rowCli['Clasificacion'] == 1){
											echo '<br><img src="imagenes/Estrella_Azul.png" width=10>';
											echo '<img src="imagenes/Estrella_Azul.png" width=10>';
											echo '<img src="imagenes/Estrella_Azul.png" width=10>';
										}else{	
											if($rowCli['Clasificacion'] == 2){
												echo '<br><img src="imagenes/Estrella_Azul.png" width=10>';
												echo '<img src="imagenes/Estrella_Azul.png" width=10>';
											}else{
												if($rowCli['Clasificacion'] == 3){
													echo '<br><img src="imagenes/Estrella_Azul.png" width=10>';
												}
											}
										}
										
									}
									//Fin Verificaci�n Deuda
								
						echo '	</td>';
						echo '	<td width="10%">';
									if($row['fechaInicio'] != 0){
										$fd = explode('-', $row['fechaInicio']);
										echo $fd[2].'/'.$fd[1];
										echo '<br>'.$row['usrResponzable'];
									}else{
										echo 'NO Asignado';
									}?>
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
						echo '	<td width="10%">';
									if($row['fechaInicio'] != 0){
										echo number_format($row['dHabiles'], 0, ',', '.').' días';
										$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
										$fechaHoy = date('Y-m-d');
										$dsemana = date("w",strtotime($ftermino));
										$fdt = explode('-', $ftermino);
										echo '<br>'.$dSem[$dsemana];
										echo '<br>'.$fdt[2].'/'.$fdt[1];
									}else{
										echo number_format($row['dHabiles'], 0, ',', '.').' días';
										echo '<br>Sin asignar';
									}
						echo ' 	</td>';
						echo '	<td width="10%">';
									if($row['fechaInicio'] != 0){

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

						echo '	<td width="20%">';
							$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
							if($rowCli=mysqli_fetch_array($bdCli)){
								echo 	'<span style="font-size:10px;">'.substr($rowCli['Cliente'],0,20).'</span>';
							}
						echo '	</td>';
						echo '	<td width="30%">';
									if($row['Descripcion']){
										echo substr($row['Descripcion'],0,50).'...';
									}
						echo ' 	</td>';
						echo '	<td valign="top">';
							$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
							if($rowCli=mysqli_fetch_array($bdCli)){
								if($rowCli['nFactPend'] > 0){
									echo '<img src="imagenes/gener_32.png" align="left" width="16">'.$rowCli['nFactPend'];
								}
							}
							if($row['correoInicioPAM'] == 'on'){
								echo '<br><img src="imagenes/draft_16.png" align="left">';
							}
						echo ' 	</td>';
						echo '</tr>';
					}while ($row=mysqli_fetch_array($bdEnc));
				}
				$link->close();
				echo '	</table>';
			}

function verEnsayosenProceso($Periodo){
	?>
		<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloTv">
			<tr>
				<td width="10%" align="center" height="40" style="padding-left:5px; padding-right:5px;">
					Ensayos
				</td>
				<td align="Center" style="padding-left:5px; padding-right:5px;">
					En<br> Proceso
				</td>
			</tr>
			<?php
				$link=Conectarse();
				$bdEn=$link->query("SELECT * FROM amEnsayos Where Status = 'on' Order By nEns");
				if($rowEn=mysqli_fetch_array($bdEn)){
					do{
						if($rowEn['idEnsayo'] == 'Tr'){
							$bdTp=$link->query("SELECT * FROM amTpsMuestras where idEnsayo = 'Tr' Order By idEnsayo Desc");
							if($rowTp=mysqli_fetch_array($bdTp)){
								do{?>
									<tr id="bBlanca">
										<td>
											<?php echo $rowEn['idEnsayo'].' '.$rowTp['tpMuestra']; ?>
										</td>
										<td>
											<?php 
												$bdEp=$link->query("SELECT * FROM ensayosProcesos Where Periodo = '".$Periodo."' and idEnsayo = '".$rowEn['idEnsayo']."' and tpMuestra = '".$rowTp['tpMuestra']."'");
												if($rowEp=mysqli_fetch_array($bdEp)){
													echo $rowEp['enProceso'].'('.$rowEp['conRegistro'].')'; 
												}
											?>
										</td>
									<?php
								}while ($rowTp=mysqli_fetch_array($bdTp));
							}
						}else{?>
							<tr id="bBlanca">
								<td>
									<?php echo $rowEn['idEnsayo']; ?>
								</td>
								<td>
									<?php 
										$bdEp=$link->query("SELECT * FROM ensayosProcesos Where Periodo = '".$Periodo."' and idEnsayo = '".$rowEn['idEnsayo']."'");
										if($rowEp=mysqli_fetch_array($bdEp)){
											echo $rowEp['enProceso'].'('.$rowEp['conRegistro'].')'; 
										}
									?>
								</td>
							</tr>
							<?php
						}
					}while ($rowEn=mysqli_fetch_array($bdEn));
				}
				$link->close();
			?>
		</table>

		<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloTv">
			<tr>
				<td width="35%" align="center" height="40">
					PreCAM
				</td>
				<td width="65%" align="Center">
					Correo
				</td>
			</tr>
			<?php
				$link=Conectarse();
				$bdEn=$link->query("SELECT * FROM precam Where Estado = 'on' Order By fechaPreCAM Desc");
				if($rowEn=mysqli_fetch_array($bdEn)){
					do{?>
						<tr id="bAmarilla">
							<td align="center" style="font-size:10px;">
								<b><?php echo $rowEn['usrResponsable']; 	?></b><br>
								<?php 
									$fP = explode('-', $rowEn['fechaPreCAM']);
									echo $fP[2].'-'.$fP[0].'-'.$fP[1];
								?>
							</td>
							<td>
								<?php echo substr($rowEn['Correo'],0,70); ?>...
							</td>
						<?php
					}while ($rowEn=mysqli_fetch_array($bdEn));
				}
				$link->close();
			?>
		</table>
		
	<?php
}
			
			
function cuentaEnsayosActivos($Periodo){
	$link=Conectarse();
/*	
	$bd=$link->query("SELECT * FROM ensayosProcesos Where Periodo = '".$Periodo."'");
	if($row = mysqli_fetch_array($bd)){
		
		
		
		
		
	}else{
*/		
		$cuentaEnsayos 	= 0;
		$enProceso 		= 0;
		$conRegistro	= 0;
		$bdCAM=$link->query("DELETE FROM ensayosProcesos Where Periodo = '".$Periodo."'");
		$bdCAM=$link->query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P'"); //     or RAM = 10292 or RAM = 10536 or RAM = 10666
		if($rowCAM=mysqli_fetch_array($bdCAM)){
			do{
				$sumaEnsayos = 0;
				$RAM = $rowCAM['RAM'];
				
				$bdOtam=$link->query("SELECT * FROM Otams Where RAM = '".$rowCAM['RAM']."'");
				if($rowOtam=mysqli_fetch_array($bdOtam)){
					do{
						
						$sumaEnsayos++;
						
						if($rowOtam['idEnsayo'] == 'Tr'){
							$bdEp=$link->query("SELECT * FROM ensayosProcesos Where Periodo = '".$Periodo."' and idEnsayo = '".$rowOtam['idEnsayo']."' and tpMuestra = '".$rowOtam['tpMuestra']."'");
						}else{
							$bdEp=$link->query("SELECT * FROM ensayosProcesos Where Periodo = '".$Periodo."' and idEnsayo = '".$rowOtam['idEnsayo']."'");
						}
						if($rowEp=mysqli_fetch_array($bdEp)){
							if($rowCAM['Estado'] == 'P'){
								$enProceso 		= $rowEp['enProceso'];
								$conRegistro	= $rowEp['conRegistro'];
							
								$enProceso += 1;
								if($rowOtam['Estado'] == 'R'){
									$conRegistro++;
								}
								$actSQL  ="UPDATE ensayosProcesos SET ";
								$actSQL .= "enProceso 	= '".$enProceso.	"', ";
								$actSQL .= "conRegistro = '".$conRegistro.	"' ";
								if($rowOtam['idEnsayo'] == 'Tr'){
									$actSQL .="WHERE Periodo = '".$Periodo."' and idEnsayo = '".$rowOtam['idEnsayo']."' and tpMuestra = '".$rowOtam['tpMuestra']."'";
								}else{
									$actSQL .="WHERE Periodo = '".$Periodo."' and idEnsayo = '".$rowOtam['idEnsayo']."'";
								}
								$bdProc=$link->query($actSQL);
							}
						}else{
							$idEnsayo 		= $rowOtam['idEnsayo'];
							$tpMuestra 		= $rowOtam['tpMuestra'];
							$enProceso  	= 1;
							$conRegistro 	= 0;
							if($rowOtam['Estado'] == 'R') {
								$conRegistro = 1;
							}
							$link->query("insert into ensayosProcesos	(	Periodo,
																			idEnsayo,
																			tpMuestra,
																			enProceso,
																			conRegistro
																		) 
																values 	(	'$Periodo',
																			'$idEnsayo',
																			'$tpMuestra',
																			'$enProceso',
																			'$conRegistro'
																		)"
										);
						}							
					}while ($rowOtam=mysqli_fetch_array($bdOtam));
					
				}
			}while ($rowCAM=mysqli_fetch_array($bdCAM));
		}
	//}
	$link->close();
}
?>
