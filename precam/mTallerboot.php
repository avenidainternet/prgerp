<?php
	session_start();
	include_once("../conexionli.php");
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
	<div class="col-sm-2">
		<?php 
			$fechaAntSemana = date("Y-m-d",strtotime($fSem."- 7 days"));
		?>
		<a class="btn btn-danger btn-lg btn-block" href="index.php?fechaAntSemana=<?php echo $fechaAntSemana; ?>">Anterior</a>
	</div>
	<div class="col-sm-8">
		<!--
		<button type="button" class="btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#myModal">
    		Agregar PRECAM
  		</button>	
		-->	
		<a class="btn btn-primary btn-lg btn-block" href="#" data-bs-toggle="modal" data-bs-target="#myModal">Agregar PreCAM</a>
	</div>
	<div class="col-sm-2">
		<?php 
			$fechaSigSemana = date("Y-m-d",strtotime($fSem."+ 7 days"));
		?>
		<a class="btn btn-success btn-lg btn-block" href="index.php?fechaSigSemana=<?php echo $fechaSigSemana; ?>">Siguiente</a>
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
			<div class="col-sm text-center">
				<?php echo '<h5>'.$dias[$i+1].'<br>'.$fSem.'</h5>'; ?>
			</div>
			<?php
		}
	?>
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
			<div class="col-sm text-center">
				<?php
					$link=Conectarse();
					$item = '';
					$sqlm = "SELECT * FROM precam Where Estado = 'on' and  (fechaPreCAM >= '$fechaInicio' or fechaPreCAM = '$fechaFin')  Order By fechaPreCAM";
					//echo $sqlm;
					$bdm = $link->query($sqlm);
					while($rowm=mysqli_fetch_array($bdm)){
							if($fSem >= $rowm['fechaPreCAM'] and $fSem <= $rowm['fechaPreCAM']){
								$fechaActual = date('Y-m-d');
								$class = 'table table-hover bg-success text-white';

								if($fechaActual > $rowm['fechaPreCAM']){
									$class = 'table table-hover bg-danger text-white';
								}elseif($fechaActual == $rowm['fechaPreCAM']){
									$class = 'table table-hover bg-warning text-dark';
								}
								?>
								<table class="<?php echo $class; ?>">
									<tbody>
									<tr>
										<td>
											<form name="form" action="index.php" method="post" enctype="multipart/form-data">
												<a class="<?php echo $classboton; ?>" href="mSolicitud.php?RAM=<?php echo $fdIt[0]; ?>">
													<h4><?php echo $rowm['idPreCAM']; ?></h4>
												</a>
											</form>
										</td>
									</tr>
									</tbody>
								</table>
								<?php
							}
						
					}
					$link->close();
				?>
			</div>
			<?php
		}
	?>


</div>


<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Registro PreCAM Nº <b>{{idPreCAM}}</b></h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        Modal body..
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
