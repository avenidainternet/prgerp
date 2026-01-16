<?php
	include_once("../conexionli.php");
	include_once("../inc/funciones.php");
	date_default_timezone_set("America/Santiago");
	$dias = array(
					0 => 'Domingo',
					1 => 'Lunes', 
					2 => 'Martes',
					3 => 'Miércoles',
					4 => 'Jueves',
					5 => 'Viernes',
					6 => 'Sábado'
				);
	$fechaHoy 	= date('Y-m-d');
	$fd 			= explode('-',$fechaHoy);
	$month 		= $fd[1];
	$day 		= $fd[2];
	$year 		= $fd[0];
	$diaSemana=date("w",mktime(0,0,0,$month,$day,$year));
	$primerDia=date("d-m-Y",mktime(0,0,0,$month,$day-$diaSemana+1,$year));
?>


<div style="width:85%; float: left;">
<table cellspacing="0" cellpadding="0" border=1 id="cajaSemana">
	<tr>
		<?php
			for($i=0 ; $i<=4; $i++){
				$ds 	= strtotime ( '+'.$i.' day' , strtotime ( $primerDia ) );
				$ds 	= date ( 'Y-m-d' , $ds );
				$ffd 	= explode('-', $ds);
				echo '<td class="cajaDiasSemana">';
				echo $dias[date('N', strtotime($ds))].'<br>';
				echo $ffd[2].'-'.$ffd[1];
				echo '</td>';
			}
		?>
	</tr>
</table>
</div>
<div id="divPrg">
	En<br>
	Proceso
</div>
<div style="width:85%; float: left;">
<table  cellspacing="0" cellpadding="0" id="cajaSemana">
	<tr>
	<?php
		for($i=0 ; $i<=4; $i++){
			$ds 	= strtotime ( '+'.$i.' day' , strtotime ( $primerDia ) );
			$ds 	= date ( 'Y-m-d' , $ds );
			$ffd 	= explode('-', $ds);
			?>
			<td class="cajaDiasSemana" valign="top">
				<?php
					$vRAM = '';
					$vEnsayos = array();
					$link=Conectarse();
					$SQLe = "SELECT * FROM amensayos";
					$bde=$link->query($SQLe);
					if($rowe=mysqli_fetch_array($bde)){
						do{
							$nEns = $rowe['idEnsayo'];
							$vEnsayos[$nEns] = '';
						}while ($rowe=mysqli_fetch_array($bde));
					}
					$SQL = "SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P' and fechaTermino = '0000-00-00' Order By RAM Asc";
					$bdEnc=$link->query($SQL);
					if($row=mysqli_fetch_array($bdEnc)){
						do{
							$SQLta = "SELECT * FROM ammuestras Where idItem like '%".$row['RAM']."%' and Taller = 'on' and fechaTerminoTaller = '0000-00-00' and fechaTaller != '0000-00-00'";
							$bdTa=$link->query($SQLta);
							if($rowTa=mysqli_fetch_array($bdTa)){
								do{
									$SQLte = "SELECT * FROM Otams Where idItem = '".$rowTa['idItem']."'";
									$bdte=$link->query($SQLte);
									if($rowte=mysqli_fetch_array($bdte)){
										$vEnsayos[$rowte['idEnsayo']]++;
									}
									$fdRAM = explode('-',$rowTa['idItem']);
									if($fdRAM[0] != $vRAM){
										$vRAM = $fdRAM[0];
										list($ftermino, $dhf, $dha, $dsemana) = fnDiasHabiles($row['fechaInicio'],$row['dHabiles'],$row['horaPAM']);
										if($row['fechaPega'] != '0000-00-00'){
											$ftermino = $row['fechaPega'];
										}
										$ftermino = $rowTa['fechaTaller'];
										if($ftermino == $ds){
											$cDiv = "divBlanco";
											
			
											if($dhf > 0){ // Enviada
												$cDiv = 'divVerde';
												if($dhf == 2 or $dhf ==1){ // En Proceso
													$cDiv = "divAmarillo";
												}
											}
											if($dha > 0){ // Enviada
												$cDiv = 'divRojo';
											}
											$cDiv = "divAmarillo";
											if($row['fechaInicio'] < $fechaHoy){
												$cDiv = 'divRojo';
											}
											if($row['fechaInicio'] > $fechaHoy){
												$cDiv = 'divVerde';;
											}
											?>
											<a href="mSolicitud.php?RAM=<?php echo $vRAM; ?>">
											<div id="<?php echo $cDiv; ?>">
												<?php
													$SQLfm = "SELECT * FROM formram Where RAM = '".$row['RAM']."'";
													$bdfm=$link->query($SQLfm);
													if($rowfm=mysqli_fetch_array($bdfm)){
														echo '<span style="font-size:18px;">'.$vRAM.'</span><br>';
														echo '<span style="font-size:12px;">'.$rowfm['Obs'].'</span><br>';
														echo $rowfm['ingResponsable'].'<br>';
/*														
														$muestra = '';
														$SQLce = "SELECT * FROM amtabensayos Where idItem like '%".$row['RAM']."%'";
														$bdce=$link->query($SQLce);
														if($rowce=mysqli_fetch_array($bdce)){
															do{
																if($muestra != $rowce['idItem']){
																	//if($muestra != ''){
																		echo '<br>';
																	//}
																	$muestra = $rowce['idItem'];
																	echo $muestra.':';
																}
																echo $rowce['idEnsayo']."(".$rowce['cEnsayos'].")";
																
															}while($rowce=mysqli_fetch_array($bdce));
														}
*/


													}
												?>
											</div>
											</a>
										<?php
										}
									}
								}while ($rowTa=mysqli_fetch_array($bdTa));
							}
						}while ($row=mysqli_fetch_array($bdEnc));
					}
					$link->close();
				?>
			</td>
			<?php
		}
	?>
	</tr>
</table>	
</div>
<div id="divPrg">
				<?php
					$vRAM = '';
					$link=Conectarse();
					$SQL = "SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P' and fechaTermino = '0000-00-00' Order By RAM Asc";
					$bdEnc=$link->query($SQL);
					if($row=mysqli_fetch_array($bdEnc)){
						do{
							$SQLta = "SELECT * FROM ammuestras Where idItem like '%".$row['RAM']."%' and Taller = 'on' and fechaTaller = '0000-00-00'";
							$bdTa=$link->query($SQLta);
							if($rowTa=mysqli_fetch_array($bdTa)){
								do{
									$fdRAM = explode('-',$rowTa['idItem']);
									if($fdRAM[0] != $vRAM){
										$vRAM = $fdRAM[0];
										$cDiv = "divBlanco";?>
											<div id="<?php echo $cDiv; ?>">
												<?php
													$SQLcl = "SELECT * FROM clientes Where RutCli = '".$row['RutCli']."'";
													$bdcl=$link->query($SQLcl);
													if($rowcl=mysqli_fetch_array($bdcl)){
														echo '<span style="font-size:30px;">'.$vRAM.'</span><br>';
														//$fdIni = explode('-',$row['fechaInicio']);
														//echo $fdIni[2].'-'.$fdIni[1].'-'.$fdIni[0].'<br>';
														//echo $rowcl['Cliente'].'<br>';
														echo $row['usrResponzable']; 
													}
												?>
											</div>
									<?php
									}
								}while ($rowTa=mysqli_fetch_array($bdTa));
							}
						}while ($row=mysqli_fetch_array($bdEnc));
					}
					$link->close();
				?>

</div>

<?php
function verEnsayosenProceso($Periodo){
	?>
		<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloTv" style="font-family:Arial;">
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

		
	<?php
}

function verPreCAM($Periodo){
	?>
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
