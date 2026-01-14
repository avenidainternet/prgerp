<?php
	include_once("conexionli.php");
	include_once("inc/funciones.php");
	date_default_timezone_set("America/Santiago");
	//echo $_COOKIE["Pantalla"];
	$Pantalla = $_COOKIE["Pantalla"];
	    
	if($Pantalla == 'infoTv'){
		setcookie("Pantalla", 'pegasTv');
		muestraPantallaPAM();
	}
	if($Pantalla == 'pegasTv'){
		setcookie("Pantalla", 'infoTv');
		muestraPantallaPegas();
	}

function muestraPantallaPegas(){
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
	</tr>
</table>	
<?php
}
function muestraPantallaPAM(){
	include_once('hTv.php');
	include_once('iTv.php');
}
?>
			
