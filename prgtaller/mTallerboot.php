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
	$link=Conectarse();
	$sqlm = "SELECT * FROM ammuestras Where CodInforme = '' and Taller = 'on' and fechaTaller > '0000-00-00' and fechaTerminoTaller = '0000-00-00' Order By fechaTaller Desc";
	$bdm = $link->query($sqlm);
	if($rowm=mysqli_fetch_array($bdm)){
		$_SESSION['fechaUltimaMuestra'] = $rowm['fechaTaller'];
	}

	$sqlm = "SELECT * FROM ammuestras Where CodInforme = '' and Taller = 'on' and fechaTaller > '0000-00-00' and fechaTerminoTaller = '0000-00-00' Order By fechaTaller Asc";
	$bdm = $link->query($sqlm);
	if($rowm=mysqli_fetch_array($bdm)){
		$_SESSION['fechaPrimeraMuestra'] = $rowm['fechaTaller'];
		$_SESSION['fechaHoy'] = $rowm['fechaTaller'];
	}
	$link->close();

	if(isset($_SESSION['fechaHoy'])){ 
		$fechaHoy = $_SESSION['fechaHoy']; 
	}else{
		$fechaHoy 	= date('Y-m-d');
	}
	if(isset($_SESSION['fechaSigSemana'])){ 
		$fechaHoy = $_SESSION['fechaSigSemana']; 
	}
	if(isset($_SESSION['fechaAntSemana'])){ 
		$fechaHoy = $_SESSION['fechaAntSemana']; 
	}



	$fd 		= explode('-',$fechaHoy);
	$month 		= $fd[1];
	$day 		= $fd[2];
	$year 		= $fd[0];
	$diaSemana=date("w",mktime(0,0,0,$month,$day,$year));
	$primerDia=date("d-m-Y",mktime(0,0,0,$month,$day-$diaSemana+1,$year));

	$diaInicio="Monday";
	$diaFin="Friday";

	$strFecha = strtotime($fechaHoy);

	$fechaInicio = date('Y-m-d',strtotime('last '.$diaInicio,$strFecha));
	$fechaFin = date('Y-m-d',strtotime('next '.$diaFin,$strFecha));

	if(date("l",$strFecha)==$diaInicio){
	   $fechaInicio= date("Y-m-d",$strFecha);
	}
	if(date("l",$strFecha)==$diaFin){
	    $fechaFin= date("Y-m-d",$strFecha);
	}			
	//echo $fechaInicio.' '.$fechaFin.' Dia '.$diaSemana.' '.$primerDia.'<br>';
	for($i=0; $i<=4; $i++){
		$fSem = date("d-m-Y",strtotime($fechaInicio."+ $i days"));
		$fdDia = explode('-',$fSem);
		$month 		= $fdDia[1];
		$day 		= $fdDia[2];
		$year 		= $fdDia[0];
		//echo $fSem.' '.date("w",mktime(0,0,0,$month,$day,$year)).' '.$fdDia[1].'/'.$fdDia[2].'/'.'<br>';

	}

?>
<div class="row bg-primary text-white">
	<div class="col-xl-2">
		<?php 
			$fechaAntSemana = date("Y-m-d",strtotime($fSem."- 7 days"));
			//echo '1ra '.$_SESSION['fechaPrimeraMuestra'].' ';
			//echo $fechaAntSemana.' > 1ra. '.$_SESSION['fechaPrimeraMuestra'];
			//if($fechaAntSemana > $_SESSION['fechaPrimeraMuestra']){?>
				<a class="btn btn-danger btn-lg btn-block" href="index.php?fechaAntSemana=<?php echo $fechaAntSemana; ?>">Anterior</a>
				<?php
			//}
		?>
	</div>
	<div class="col-xl-8">
		<div class="row text-center">
			<div class="col-xl-2">
				<?php 
					if(isset($_SESSION['fechaPrimeraMuestra'])){
						echo '<b>Primera <br>'.$_SESSION['fechaPrimeraMuestra'].'</b>'; 
					}
				?>
			</div>
			<div class="col-xl-8"><h4>Planificación Taller Mecánicos</h4></div>
			<div class="col-xl-2">
				<?php 
					if(isset($_SESSION['fechaUltimaMuestra'])){
						echo '<b>Última <br>'.$_SESSION['fechaUltimaMuestra'].'</b>'; 
					}
				?>
			</div>
		</div>
	</div>
	<div class="col-xl-2">
		<?php 
			$fechaSigSemana = date("Y-m-d",strtotime($fSem."+ 7 days"));
			//echo $fechaSigSemana.' < Últ. '.$_SESSION['fechaUltimaMuestra'];
			//if($fechaSigSemana >= $_SESSION['fechaUltimaMuestra']){?>
				<a class="btn btn-success btn-lg btn-block" href="index.php?fechaSigSemana=<?php echo $fechaSigSemana; ?>">Siguiente</a>
				<?php
			//}
		?>
	</div>
</div>

<div class="row bg-secondary text-white" style="padding: 10px;">
	<?php
		for($i=0; $i<=4; $i++){
			$fSem = date("d-m-Y",strtotime($fechaInicio."+ $i days"));
			$fdDia = explode('-',$fSem);
			$month 		= $fdDia[1];
			$day 		= $fdDia[2];
			$year 		= $fdDia[0];
			?>
			<div class="col-xl-2 text-center">
				<?php echo '<h5>'.$dias[$i+1].'<br>'.$fSem.'</h5>'; ?>
			</div>
			<?php
		}
	?>
	<div class="col-xl-2 text-center">
		<h5>En Transito</h5>
	</div>
</div>
<div class="row">
	<?php
		for($i=0; $i<=4; $i++){
			$fSem = date("Y-m-d",strtotime($fechaInicio."+ $i days"));
			$fdDia = explode('-',$fSem);
			$month 		= $fdDia[1];
			$day 		= $fdDia[2];
			$year 		= $fdDia[0];
			?>
			<div class="col-xl-2 text-center">
				<?php
					$link=Conectarse();
					$item = '';
					$sqlm = "SELECT * FROM ammuestras Where CodInforme = '' and Taller = 'on' and fechaTaller != '0000-00-00' and fechaHasta != '0000-00-00' and fechaTaller >= '$fechaInicio' or fechaHasta = '$fechaFin' Order By fechaTaller";
					//echo $sqlm;
					$bdm = $link->query($sqlm);
					while($rowm=mysqli_fetch_array($bdm)){
						$it = explode('-',$rowm['idItem']);
						$itDb = $it[0];
						$sqlc = "SELECT * FROM cotizaciones Where RAM = '$itDb'";
						//echo $sqlc;
						$bdc = $link->query($sqlc);
						if($rowc=mysqli_fetch_array($bdc)){
							if($rowc['Estado'] == 'T'){
								$item = $itDb;
							}
							//echo $rowc['Estado'];
						}
						if($item != $itDb){
							$item = $itDb;
							if($fSem >= $rowm['fechaTaller'] and $fSem <= $rowm['fechaHasta']){
								$fechaActual = date('Y-m-d');
								//echo $fechaActual.' Hasta '.$rowm['fechaHasta'];
								$class = 'table table-hover bg-success text-white';

								if($fechaActual > $rowm['fechaHasta']){
									$class = 'table table-hover bg-danger text-white';
								}elseif($fechaActual == $rowm['fechaHasta']){
									$class = 'table table-hover bg-warning text-dark';
								}
								if($rowm['fechaTerminoTaller'] > '0000-00-00'){
									$class = 'table table-hover bg-primary text-white';
								}
								?>
								<table class="<?php echo $class; ?>">
									<tbody>
									<tr>
										<td>
											<form name="form" action="index.php" method="post" enctype="multipart/form-data">
											<?php
												$fechaPrg = $rowm['fechaTaller'];
												$fdIt = explode('-',$rowm['idItem']);?>
												<h4><?php echo $fdIt[0]; ?></h4>
												<input name="idItem" type="hidden" value="<?php echo $rowm['idItem']?>">

													<label for="fechaPrgTaller">Desde:</label>
													<input class="form-control" name="fechaPrgTaller" type="date" value="<?php echo $rowm['fechaTaller']; ?>">

													<label for="fechaHasta">Hasta:</label>
													<input class="form-control" name="fechaHasta" type="date" value="<?php echo $rowm['fechaHasta']; ?>">

												<?php
												if($fSem == $rowm['fechaHasta']){?>
												<div class="btn-group">
													<button class="btn btn-info" name="Programar">Reprograma</button>
													<button class="btn btn-warning" name="Transito">Transito</button>
													<button class="btn btn-danger" name="Matar">Matar</button>
												</div>
												<?php
												}else{?>
												<div class="btn-group">
													<button class="btn btn-info disabled" name="Programar">Reprograma</button>
													<button class="btn btn-warning disabled" name="Transito">Transito</button>
													<button class="btn btn-danger disabled" name="Matar">Matar</button>
												</div>
													<?php
												}
												//echo '<h4>'.$fdIt[0].'</h4>';
												$sqlf = "SELECT * FROM formram Where RAM = '".$fdIt[0]."'";
												$bdf = $link->query($sqlf);
												if($rowf=mysqli_fetch_array($bdf)){
													echo '<b>'.$rowf['Obs'].'</b><br>';
												}
											?>
											</form>
										</td>
									</tr>
									</tbody>
								</table>
								<?php
							}
						}
					}
					$link->close();
				?>
			</div>
			<?php
		}
	?>

	<div class="col-xl-2 bg-warning text-dark">
		<table class="table table-hover">
			<tbody>
				<?php
					$link=Conectarse();
					//$bdCot=$link->query("SELECT * FROM cotizaciones Where RAM > 0 and Estado = 'P' and Archivo != 'on' and Eliminado != 'on'");
					$sql = "SELECT * FROM cotizaciones Where RAM > 0 and Estado = 'P' and Archivo != 'on' and Eliminado != 'on' Order By fechaInicio Asc";
					$bd = $link->query($sql);
					while($row=mysqli_fetch_array($bd)){
						$item = '';
						$sqlm = "SELECT * FROM ammuestras Where idItem like '%".$row['RAM']."%' and Taller = 'on' and fechaTaller = '0000-00-00'";
						$bdm = $link->query($sqlm);
						while($rowm=mysqli_fetch_array($bdm)){
							if($item == ''){
								$item = $rowm['idItem'];
								$fechaPrg = date('Y-m-d');
								?>
								<tr>
									<td>
										<form name="form" action="index.php" method="post" enctype="multipart/form-data">
										<?php 
											$fdIt = explode('-',$rowm['idItem']);
											echo '<h4>'.$fdIt[0].'</h4>';?>
											<input name="idItem" type="hidden" value="<?php echo $rowm['idItem']?>">
											<div class="form-group">
												<label for="fechaPrgTaller">Desde:</label>
												<input class="form-control" name="fechaPrgTaller" type="date" value="<?php echo $fechaPrg; ?>">
											</div>
											<div class="form-group">
												<label for="fechaHasta">Hasta:</label>
												<input class="form-control" name="fechaHasta" type="date" value="<?php echo $fechaPrg; ?>">
											</div>
											<div class="btn-group">
												<button class="btn btn-info" name="Programar">Programar</button>
												<button class="btn btn-danger" name="Matar">Matar</button>
											</div>
											<div>
											<?php
											$sqlf = "SELECT * FROM formram Where RAM = '".$fdIt[0]."'";
											$bdf = $link->query($sqlf);
											if($rowf=mysqli_fetch_array($bdf)){
												echo '<b>'.$rowf['Obs'].'</b><br>';
											}
											$sqle = "SELECT * FROM amtabensayos Where idItem like '%".$rowm['idItem']."%'";
											$bde = $link->query($sqle);
											while($rowe=mysqli_fetch_array($bde)){
												if($rowe['idEnsayo'] == 'Tr' or $rowe['idEnsayo'] == 'Ch' or $rowe['idEnsayo'] == 'Do' or $rowe['idEnsayo'] == 'Du' or $rowe['idEnsayo'] == 'Qu'){

													echo $rowe['idEnsayo'].'(<b>'.$rowe['cEnsayos'].'</b>)';
												}
											}
											?>
											</div>
										</form>
									</td>
								</tr>
								<?php
							}
						}
					}
					$link->close();
				?>
			</tbody>
		</table>

	</div>
</div>
