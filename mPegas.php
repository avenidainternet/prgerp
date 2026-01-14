<?php
	include_once("conexionli.php");
	include_once("inc/funciones.php");
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
<table border="0" cellspacing="0" cellpadding="0" id="cajaSemana">
	<tr>
	<?php
		for($i=0 ; $i<=4; $i++){
			$ds 	= strtotime ( '+'.$i.' day' , strtotime ( $primerDia ) );
			$ds 	= date ( 'Y-m-d' , $ds );
			$ffd 	= explode('-', $ds);
			?>
				<td class="cajaDiasSemana">
					<?php 
						echo $dias[date('N', strtotime($ds))].'<br>';
						echo $ffd[2].'-'.$ffd[1];
					?>
						<?php
							$link=Conectarse();
							//$SQL = "SELECT * FROM Cotizaciones Where Estado = 'P' and fechaEstimadaTermino = '$ds' Order By RAM Asc";
							$SQL = "SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P' Order By RAM Asc";
							$bdEnc=$link->query($SQL);
							if($row=mysqli_fetch_array($bdEnc)){
								do{
									list($ftermino, $dhf, $dha, $dsemana) = fnDiasHabiles($row['fechaInicio'],$row['dHabiles'],$row['horaPAM']);
									if($row['fechaPega'] != '0000-00-00'){
										$ftermino = $row['fechaPega'];
									}
									if($ftermino == $ds){
										$cDiv = "divBlanco";
										
										$fechaTermino 	= strtotime ( '+'.$row['dHabiles'].' day' , strtotime ( $row['fechaInicio'] ) );
										$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );
				
										$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
										$ft = $row['fechaInicio'];
										$dh	= $row['dHabiles']-1;
										$dd	= 0;
										for($j=1; $j<=$dh; $j++){
											$ft	= strtotime ( '+'.$j.' day' , strtotime ( $row['fechaInicio'] ) );
											$ft	= date ( 'Y-m-d' , $ft );
											$dia_semana = date("w",strtotime($ft));
											if($dia_semana == 0 or $dia_semana == 6){
												$dh++;
												$dd++;
											}
										}
				
										$fd = explode('-', $ft);
				
										$start_ts 	= strtotime($fechaHoy); 
										$end_ts 	= strtotime($ft); 
														
										$tDias = 1;
										$nDias = $end_ts - $start_ts;
				
										$nDias = round($nDias / 86400)+1;
										if($ft < $fechaHoy){
											$nDias = $nDias - $dd;
										}

										if($dhf > 0){ // Enviada
											$cDiv = 'divVerde';
											if($dhf == 2 or $dhf ==1){ // En Proceso
												$cDiv = "divAmarillo";
											}
										}
										if($dha > 0){ // Enviada
											$cDiv = 'divRojo';
										}
										
										?>
										<!-- <div style="background-color: #fff; border: 1px solid #000; padding:5px;"> -->
										<div id="<?php echo $cDiv; ?>">
											<?php 
											$SQLcli = "SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'";
											$bdCli=$link->query($SQLcli);
											if($rowCli=mysqli_fetch_array($bdCli)){
												echo $row['RAM'].'<br>';
												echo '<span style="font-size:11px;">'.$rowCli['Cliente'].'</span><br>';
												echo $row['usrResponzable'].' - '.$row['usrPega']; 
											}
											?>
										</div>
									<?php
									}
								}while ($row=mysqli_fetch_array($bdEnc));
							}
							$link->close();
						?>
				</td>
				
			<?php
		}
	?>
				<td class="cajaDiasSemana">
					<?php
						$fechaHoy 	= date('Y-m-d');
						$fd 		= explode('-',$fechaHoy);
						$Periodo 	= $fd[1].'-'.$fd[0];
						
						verPreCAM($Periodo);
					?>
				</td>
	</tr>
</table>	

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
