<?php
	include_once("conexionli.php");
	include_once("inc/funciones.php");

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
<table class="table table-dark table-hover table-bordered">
	<thead class="thead-dark text-center">

	<tr>
		<?php
			$link=Conectarse();
			$SQL = "SELECT * FROM Usuarios Where responsableInforme = 'on' and cargoUsr != 'Director' Order By usuario";
			$bdEnc=$link->query($SQL);
			if($row=mysqli_fetch_array($bdEnc)){
				do{?>
					<td  valign="top">
						<?php 
							echo '<b>'.$row['usr'].'</b>';
							$cDiv = "divBlanco";
							$SQLcot = "SELECT * FROM Cotizaciones Where Estado = 'P' and (usrResponzable = '".$row['usr']."' or usrPega = '".$row['usr']."') Order By RAM";
							$bdCot=$link->query($SQLcot);
							if($rowCot=mysqli_fetch_array($bdCot)){
								do{
									
									
									list($ftermino, $dhf, $dha, $dsemana) = fnDiasHabiles($rowCot['fechaInicio'],$rowCot['dHabiles'],$rowCot['horaPAM']);
									if($rowCot['fechaPega'] != '0000-00-00'){
										$ftermino = $rowCot['fechaPega'];
									}
										$cDiv = "divBlanco";
										
										$fechaTermino 	= strtotime ( '+'.$rowCot['dHabiles'].' day' , strtotime ( $rowCot['fechaInicio'] ) );
										$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );
				
										$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
										$ft = $rowCot['fechaInicio'];
										$dh	= $rowCot['dHabiles']-1;
										$dd	= 0;
										for($j=1; $j<=$dh; $j++){
											$ft	= strtotime ( '+'.$j.' day' , strtotime ( $rowCot['fechaInicio'] ) );
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
									
									
									
									
									$usrPega = '';
									$usrPega = $rowCot['usrPega'];
									if(strlen($usrPega) > 0){
										if($rowCot['usrPega'] == $row['usr']){
											$SQLcli = "SELECT * FROM Clientes Where RutCli = '".$rowCot['RutCli']."'";
											$bdCli=$link->query($SQLcli);
											if($rowCli=mysqli_fetch_array($bdCli)){?>
												<div class="row">
													<div class="col" id="<?php echo $cDiv; ?>">
														<?php
															echo $rowCot['RAM'].'<br>(';
															echo '<span>'.$rowCli['Cliente'].'</span>)<br>';
															echo $rowCot['usrResponzable'];
															if($rowCot['usrPega']){
																echo ' - '.$rowCot['usrPega'];
															}
														?>
													</div>
												</div>
												<?php
											}
										}
									}else{
									if(strlen($usrPega) == 0){
										$SQLcli = "SELECT * FROM Clientes Where RutCli = '".$rowCot['RutCli']."'";
										$bdCli=$link->query($SQLcli);
										if($rowCli=mysqli_fetch_array($bdCli)){?>
											<div class="row">
												<div class="col" id="<?php echo $cDiv; ?>">
													<?php
														echo $rowCot['RAM'].'<br>(';
														echo '<span style="font-size:11px;">'.$rowCli['Cliente'].'</span>)<br>';
														echo $rowCot['usrResponzable'].' '.strlen($usrPega);
													?>
												</div>
											</div>
											<?php
										}
									}
									}
								}while ($rowCot=mysqli_fetch_array($bdCot));
							}
						?>
					</td>
					<?php
					}while ($row=mysqli_fetch_array($bdEnc));
				}
				$link->close();
			?>
	</tr>
	</thead>
</table>	
