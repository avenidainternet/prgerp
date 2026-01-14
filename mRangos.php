	<?php
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
					'Enero' 		=> '1', 
					'Febrero' 		=> '2',
					'Marzo' 		=> '3',
					'Abril' 		=> '4',
					'Mayo' 			=> '5',
					'Junio' 		=> '6',
					'Julio' 		=> '7',
					'Agosto' 		=> '8',
					'Septiembre'	=> '9',
					'Octubre' 		=> '10',
					'Noviembre' 	=> '11',
					'Diciembre'		=> '12'
				);

	$tEnsMes = array(
					1 => 0, 
					2 => 0,
					3 => 0,
					4 => 0,
					5 => 0,
					6 => 0,
					7 => 0,
					8 => 0,
					9 => 0,
					10 => 0,
					11 => 0,
					12 => 0
				);
	
	if($mesInd < 10){ $mesInd = '0'.$mesInd; };
	
	//contarEnsayosDelMes($mesInd, $agnoInd); 

?>

	<div class="container-fluid" style="margin-top: 5px;">
		<form name="form" action="tablaRangos.php" method="post"> 
			<input name="Proceso"  	type="hidden" value="<?php echo $Proceso; ?>">'
			<div class="row">
				<div class="col-lg-6">
					<div class="card">
						<div class="card-header bg-info"><h4>Indicador de Metas <b>{{res}}</b></div>
					  	<div class="card-body">
					  		<div class="row">
					  			<div class="col-3">
							  		<div class="form-group">
		  								<label for="usr">Periodo:</label>
									</div>
								</div>
								<div class="col-3">
							  		<div class="form-group">
										<select class="form-control input-lg" 
											ng-change="editar()"
											ng-init="seleccion = { mesnum: datos[<?php echo intval($mesInd)-1; ?>].mesnum}" 
											ng-model="seleccion" 
											ng-options="lista.descripcion for lista in datos track by lista.mesnum">
	    								</select>
  									</div>
  								</div>
								<div class="col-3">
									<input type="hidden" ng-model="agno" ng-init="agno='<?php echo $agnoInd; ?>'">
	  								<select name='agnoInd' ng-model="agnoInd" 
	  										ng-change="editarAgno()" 
	  										ng-init="agnoInd='<?php echo $agnoInd; ?>'"
	  										id='agnoInd' 
	  										class="form-control">
										<?php 
											$link=Conectarse();
											$bdInd=$link->query("Select * From tablaIndicadores Order By agnoInd Asc");
											if($rowInd=mysqli_fetch_array($bdInd)){
												$pAgno 	= $rowInd['agnoInd'];
											}
											$link->close();
											for($i=$pAgno; $i<=$fd[0]; $i++){
												if($i == $agnoInd){
													echo "<option selected 	value='".$i."'>". $i."</option>";
												}else{
													echo "<option 		 	value='".$i."'>". $i."</option>";
												} 
											}
											?>
									</select>
								</div>
							</div>
					  		<div class="row">
					  			<div class="col-3">
							  		<div class="form-group">
		  								<label for="usr">Mínimo:</label>
									</div>
								</div>
								<div class="col-3">
							  		<div class="form-group">
										<input name="indMin" ng-model="indMin" type="text" size="5" maxlength="5"  class="form-control" />
  									</div>
  									<!--
  									<div ng-show="EstadoGraba" class="alert alert-success">
  										<strong>GRABADO CON EXITO...</strong>
									</div>
									-->
  								</div>
							</div>
					  		<div class="row">
					  			<div class="col-3">
							  		<div class="form-group">
		  								<label for="usr">Meta:</label>
									</div>
								</div>
								<div class="col-3">
							  		<div class="form-group">
										<input name="indMeta" ng-model="indMeta" type="text" size="5" maxlength="5" class="form-control" />
  									</div>
  								</div>
							</div>
					  		<div class="row">
					  			<div class="col-3">
							  		<div class="form-group">
		  								<label for="usr">Descuentos:</label>
									</div>
								</div>
								<div class="col-3">
							  		<div class="form-group">
										<input name="indDesc" ng-model="indDesc" type="text" size="5" maxlength="5" class="form-control" />
  									</div>
  								</div>
								<div class="col-6">
							  		<div class="form-group">
										<textarea name="descrDesc" ng-model="descrDesc" cols="50" rows="1" class="form-control"></textarea>
  									</div>
  								</div>
							</div>
					  		<div class="row">
					  			<div class="col-3">
							  		<div class="form-group">
		  								<label for="usr">Descuentos:</label>
									</div>
								</div>
								<div class="col-3">
							  		<div class="form-group">
										<input name="indDesc2" ng-model="indDesc2" type="text" size="5" maxlength="5" class="form-control" />
  									</div>
  								</div>
								<div class="col-6">
							  		<div class="form-group">
										<textarea name="descrDesc2" ng-model="descrDesc2" cols="50" rows="1" class="form-control"></textarea>
  									</div>
  								</div>
							</div>
					  		<div class="row">
					  			<div class="col-3">
							  		<div class="form-group">
		  								<label for="usr">Descuentos:</label>
									</div>
								</div>
								<div class="col-3">
							  		<div class="form-group">
										<input name="indDesc3" ng-model="indDesc3" type="text" size="5" maxlength="5" class="form-control" />
  									</div>
  								</div>
								<div class="col-6">
							  		<div class="form-group">
										<textarea name="descrDesc3" ng-model="descrDesc3" cols="50" rows="1" class="form-control"></textarea>
  									</div>
  								</div>
							</div>
					  		<div class="row">
					  			<div class="col-3">
							  		<div class="form-group">
		  								<label for="usr">Rango Cotizaciones:</label>
									</div>
								</div>
								<div class="col-3">
							  		<div class="form-group">
										<input name="rCot" ng-model="rCot" type="text" size="5" maxlength="5" class="form-control" />
  									</div>
  								</div>
							</div>
					  		<div class="row">
					  			<div class="col-3">
							  		<div class="form-group">
		  								<label for="usr">UF Referencial:</label>
									</div>
								</div>
								<div class="col-3">
							  		<div class="form-group">
							  			<input name="valorUFRef" ng-model="valorUFRef" type="text" size="10" maxlength="10" class="form-control">
  									</div>
  								</div>
							</div>
					  </div> 
					  <div class="card-footer">
					  	<!-- <button name="Guardar" style="float:right;" class="btn btn-primary"> -->
					  	<button ng-click="modi()" style="float:right;" class="btn btn-primary">
							Guardar
						</button>
					  </div>
					</div>

				</div>

				<div class="col-lg-6">
					<div class="card">
						<div class="card-header bg-info"><h4>Instrucciones para Cobranza</h4></div>
					  	<div class="card-body">
							<?php
								$link=Conectarse();
								$bdEmp=$link->query("SELECT * FROM tablaSegFacturas Where rangoDesde	= 45");
								if($rowEmp=mysqli_fetch_array($bdEmp)){
									$ins45 	= $rowEmp['Instrucciones'];
								}
							
								$bdEmp=$link->query("SELECT * FROM tablaSegFacturas Where rangoDesde	= 60");
								if($rowEmp=mysqli_fetch_array($bdEmp)){
									$ins60 	= $rowEmp['Instrucciones'];
								}
							
								$bdEmp=$link->query("SELECT * FROM tablaSegFacturas Where rangoDesde	= 75");
								if($rowEmp=mysqli_fetch_array($bdEmp)){
									$ins75 	= $rowEmp['Instrucciones'];
								}
							
								$bdEmp=$link->query("SELECT * FROM tablaSegFacturas Where rangoDesde	= 90");
								if($rowEmp=mysqli_fetch_array($bdEmp)){
									$ins90 	= $rowEmp['Instrucciones'];
								}
								$link->close();
								
								?>
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>Rangos 			</th>
											<th>Instrucciones 	</th>
										</tr>
									</thead>
									<tr>
										<td>45 - 59</td>
										<td>
											<textarea class="form-control" name="ins45" cols="100" rows="2"><?php echo $ins45; ?></textarea>
										</td>
									</tr>
									<tr>
										<td>60 - 74</td>
										<td>
											<textarea class="form-control" name="ins60" cols="100" rows="2"><?php echo $ins60; ?></textarea>
										</td>
									</tr>
									<tr>
										<td>75 - 89</td>
										<td>
											<textarea class="form-control" name="ins75" cols="100" rows="2"><?php echo $ins75; ?></textarea>
										</td>
									</tr>
									<tr>
										<td>90 - más</td>
										<td>
											<textarea class="form-control" name="ins90" cols="100" rows="2"><?php echo $ins90; ?></textarea>
										</td>
									</tr>
								</table>



					  	</div> 
					  	<div class="card-footer">
						  	<button name="Guardar" style="float:right;" class="btn btn-primary">
								Guardar
							</button>
					  	</div>
					</div>
				</div>
			</div>
			<div class="row" style="margin-top: 10px;">

				<div class="col-lg-6">
					<div class="card">
						<div class="card-header bg-info"><h4>Rango Clientes Estrellas</h4></div>
					  	<div class="card-body">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th width="10%">Clasificación 	</th>
											<th>Desde 			</th>
											<th>Hasta 			</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="x in clasificaciones">
											<td> {{x.descripcion}} 		</td>
											<td> 
												<input 	ng-model="x.desde" 
														ng-value="x.desde"
														name="desde"
														class="form-control"
														ng-change="cambiarClasifica(x.Clasificacion, x.desde, x.hasta)">
											</td>
											<td> 
												<span ng-if="x.Clasificacion == 1">más</span>
												<span ng-if="x.Clasificacion > 1">
													<input 	
														ng-model="x.hasta" 
														ng-value="x.hasta"
														class="form-control"
														ng-change="cambiarClasifica(x.Clasificacion, x.desde, x.hasta)">
												</span>
												 			
											</td>
										</tr>
									</tbody>
								</table>



					  	</div> 
					  	<div class="card-footer">
						  	<button ng-click="ExitoClasificacion()" style="float:right;" class="btn btn-primary">
								Guardar
							</button>
					  	</div>
					</div>
				</div>

			</div>
		</form>
	</div>



<?php
function contarEnsayosMes($Periodo, $i, $agnoInd){
	$link=Conectarse();
	$SQL = "DELETE FROM estEnsayos Where Periodo = '$Periodo'";
	$bdEe=$link->query($SQL);
	$SQL = "SELECT * FROM Cotizaciones Where month(fechaInicio) = '".$i."' and year(fechaInicio) = '".$agnoInd."' and Estado != 'C'";
	$bdCot=$link->query($SQL);
	if($rowCot=mysqli_fetch_array($bdCot)){
		do{
			$nEnsayos = 0;
			if($tpMuestra){
				$SQLm = "SELECT * FROM OTAMs Where idEnsayo = '$idEnsayo' and tpMuestra = '$tpMuestra' and RAM = '".$rowCot['RAM']."'";
			}else{
				$SQLm = "SELECT * FROM OTAMs Where idEnsayo = '$idEnsayo' and RAM = '".$rowCot['RAM']."'";
			}
			$bdOT=$link->query($SQLm);
			if($rowOT=mysqli_fetch_array($bdOT)){
				do{
					$nEnsayos++;
				}while ($rowOT=mysqli_fetch_array($bdOT));
			}
			if($tpMuestra){
				$SQLe = "SELECT * FROM estEnsayos Where Periodo = '$Periodo' and idEnsayo = '$idEnsayo' and tpMuestra = '$tpMuestra'";
			}else{
				$tpMuestra = '';
				$SQLe = "SELECT * FROM estEnsayos Where Periodo = '$Periodo' and idEnsayo = '$idEnsayo'";
			}
			//echo $SQLe;
			$bdEe=$link->query($SQLe);
			if($rowEe=mysqli_fetch_array($bdEe)){
			}else{
				$link->query("insert into estEnsayos(	Periodo,
														idEnsayo,
														tpMuestra,
														nEnsayos
													) 
											values 	(	'$Periodo',
														'$idEnsayo',
														'$tpMuestra',
														'$nEnsayos'
													)");
			}
		}while ($rowCot=mysqli_fetch_array($bdCot));
	}
	$link->close();
}

function contarEnsayosDelMes($mesInd, $agnoInd){
	$link=Conectarse();
	$PeriodoActual = $mesInd.'-'.$agnoInd;
	$bdEe=$link->query("DELETE FROM estEnsayos Where Periodo = '".$PeriodoActual."'");
	$bdEn=$link->query("SELECT * FROM amEnsayos Order By nEns");
	if($rowEn=mysqli_fetch_array($bdEn)){
		do{
			if($rowEn['idEnsayo'] == 'Tr') {
				$bdtEn=$link->query("SELECT * FROM amTpsMuestras Where idEnsayo = '".$rowEn['idEnsayo']."'");
				if($rowtEn=mysqli_fetch_array($bdtEn)){
					do{
						$cEnsayo = 0;
						$bdInf=$link->query("SELECT * FROM Cotizaciones Where month(fechaInicio) = '".$mesInd."' and year(fechaInicio) = '".$agnoInd."' and Estado != 'C'");
						if($rowInf=mysqli_fetch_array($bdInf)){
							do{
								$bdOT=$link->query("SELECT * FROM OTAMs Where RAM = '".$rowInf['RAM']."' and idEnsayo = '".$rowEn['idEnsayo']."' and tpMuestra = '".$rowtEn['tpMuestra']."'");
								if($rowOT=mysqli_fetch_array($bdOT)){
									do{
										$cEnsayo++;
									}while ($rowOT=mysqli_fetch_array($bdOT));
								}
							}while ($rowInf=mysqli_fetch_array($bdInf));
						}
						$Periodo = $mesInd.'-'.$agnoInd;
						$iEns = $rowEn['idEnsayo'];
						$iMue = $rowtEn['tpMuestra'];
						$enPAM = 0;
						$link->query("insert into estEnsayos(	Periodo,
																idEnsayo,
																tpMuestra,
																nEnsayos,
																enPAM
															) 
													values 	(	'$Periodo',
																'$iEns',
																'$iMue',
																'$cEnsayo',
																'$enPAM'
															)");
					}while ($rowtEn=mysqli_fetch_array($bdtEn));
				}
			}else{
				$cEnsayo = 0;
				$bdInf=$link->query("SELECT * FROM Cotizaciones Where month(fechaInicio) = '".$mesInd."' and year(fechaInicio) = '".$agnoInd."' and Estado != 'C'");
				if($rowInf=mysqli_fetch_array($bdInf)){
					do{
						$bdOT=$link->query("SELECT * FROM OTAMs Where RAM = '".$rowInf['RAM']."' and idEnsayo = '".$rowEn['idEnsayo']."'");
						if($rowOT=mysqli_fetch_array($bdOT)){
							do{
								$cEnsayo++;
							}while ($rowOT=mysqli_fetch_array($bdOT));
						}
					}while ($rowInf=mysqli_fetch_array($bdInf));
				}
				$Periodo = $mesInd.'-'.$agnoInd;
				$iEns 	= $rowEn['idEnsayo'];
				$iMue 	= '';
				$enPAM 	= 0;
				$link->query("insert into estEnsayos(	Periodo,
														idEnsayo,
														tpMuestra,
														nEnsayos,
														enPAM
													) 
											values 	(	'$Periodo',
														'$iEns',
														'$iMue',
														'$cEnsayo',
														'$enPAM'
													)");
			}
		}while ($rowEn=mysqli_fetch_array($bdEn));
	}
	$link->close();
}
?>	