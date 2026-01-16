<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
	include_once("../conexionli.php");
	$Taller = 'off';
	if(isset($_POST['CAM']))  		{ $CAM		= $_POST['CAM']; 		} 
	if(isset($_POST['RAM']))  		{ $RAM		= $_POST['RAM']; 		}
	if(isset($_POST['tpEnsayo']))  	{ $tpEnsayo	= $_POST['tpEnsayo']; 	}
	if(isset($_GET['dBuscar']))  	{ $dBuscar  = $_GET['dBuscar']; 	}
	if(isset($_GET['accion']))  	{ $accion	= $_GET['accion']; 		}

	if(isset($_POST['gMuestrasBoot'])){
		$link=Conectarse();
		$bdMu=$link->query("SELECT * FROM formram Where RAM = '".$_POST['RAM']."'"); 
		if($rowMu=mysqli_fetch_array($bdMu)){
			$nSolTaller = 0;
			if($rowMu['nSolTaller']){
				$nSolTaller = $rowMu['nSolTaller'];
			}
			if(isset($_POST['Taller']))  		{ $Taller		= $_POST['Taller']; 		}
			if($Taller == 'on'){
				if($rowMu['nSolTaller']){
					$nSolTaller = $rowMu['nSolTaller'];
				}else{
					$bdrf=$link->query("SELECT * FROM tablaregform");
					if($rowrf=mysqli_fetch_array($bdrf)){
						$nSolTaller = $rowrf['nTaller']+1;
						$actSQL="UPDATE tablaregform SET ";
						$actSQL.="nTaller	= '".$nSolTaller."'";
						$bdOt=$link->query($actSQL);
					}				
				}
			}
			$nMuestrasAct = $rowMu['nMuestras'];
			$actSQL="UPDATE formram SET ";
			$actSQL.="ingResponsable	= '".$_POST['ingResponsable'].		"', ";
			$actSQL.="cooResponsable	= '".$_POST['cooResponsable'].		"', ";
			$actSQL.="Obs	   			= '".$_POST['Obs'].					"', ";
			$actSQL.="Taller	   		= '".$Taller.						"', ";
			$actSQL.="nSolTaller   		= '".$nSolTaller.					"', ";
			$actSQL.="nMuestras	   		= '".$_POST['nMuestras'].			"' ";
			$actSQL.="WHERE RAM 		= '".$_POST['RAM']."'";
			$bdOt=$link->query($actSQL);
			if($_POST['nMuestras'] > $nMuestrasAct){
				for ($i=1; $i <= $_POST['nMuestras']; $i++) { 
					$idItem = $RAM.'-'.$i;
					if($i < 10){
						$idItem = $RAM.'-0'.$i;
					}
					echo $idItem.'<br>';
					$bdm=$link->query("SELECT * FROM ammuestras Where idItem = '$idItem'");
					if($rowm=mysqli_fetch_array($bdm)){

					}else{
						$link->query("insert into ammuestras (idItem	) values ('$idItem')");
					}				
				}
			}
			if($_POST['nMuestras'] < $nMuestrasAct){
				for ($i= $_POST['nMuestras'] + 1; $i <= $nMuestrasAct; $i++) { 
					$idItem = $RAM.'-'.$i;
					if($i < 10){
						$idItem = $RAM.'-0'.$i;
					}
					//echo $idItem.'<br>';
					$bd =$link->query("Delete From ammuestras Where idItem = '$idItem'");
					// Recorrer amTabensayos
					$bdte=$link->query("SELECT * FROM amtabensayos Where idItem = '$idItem'");
					while($rowte=mysqli_fetch_array($bdte)){
						// Borrar los ensayos asociados a la muestra borrada
						if($rowte['idEnsayo'] == 'Qu'){ $reg = 'regquimico'; 		}
						if($rowte['idEnsayo'] == 'Tr'){ $reg = 'regtraccion'; 		}
						if($rowte['idEnsayo'] == 'Ch'){ $reg = 'regcharpy'; 		}
						if($rowte['idEnsayo'] == 'Du'){ $reg = 'regdoblado'; 		}
						if($rowte['idEnsayo'] == 'Do'){ $reg = 'regdobladosreal'; 	}
						if($reg){
							$bd =$link->query("Delete From $reg Where idItem like '%$idItem%'");
						}
					}
					$bd =$link->query("Delete From amtabensayos Where idItem = '$idItem'");
					// Borrar la Muestras de amTabEnsayos
				}
			}			
		}
		if(isset($_POST['nInforme'])){
			if(isset($_POST['tpEnsayo']))  		{ $tpEnsayo		= $_POST['tpEnsayo']; 		}
			$bdc=$link->query("SELECT * FROM cotizaciones Where RAM = '$RAM'");
			if($rowc=mysqli_fetch_array($bdc)){
				$RutCli = $rowc['RutCli'];
				//if($rowc['nInforme'] == 0){
					$actSQL="UPDATE cotizaciones SET ";
					$actSQL.="tpEnsayo			= '".$_POST['tpEnsayo']."',";
					$actSQL.="nInforme			= '".$_POST['nInforme']."'";
					$actSQL.="WHERE RAM 		= '".$RAM."'";
					$bdAc=$link->query($actSQL);
				//}

				$sqlIn = "SELECT count(*) as cInf FROM aminformes Where CodInforme like '%$RAM%'";
				$bdIn=$link->query($sqlIn);
				$rowIn=mysqli_fetch_array($bdIn);

				$nInformesReales = $rowIn['cInf']; 
				if($nInformesReales > $_POST['nInforme']){
					for($j=$_POST['nInforme']+1; $j <= $nInformesReales; $j++){
						$jam = 'AM-'.$RAM.'-'.$j;
						if($j < 10){
							$jam = 'AM-'.$RAM.'-0'.$j;
						}

						echo $jam.'<br>';
						$bd =$link->query("Delete From aminformes 	Where CodInforme like '%$jam%'");
						$bd =$link->query("Delete From informes 		Where CodInforme like'%$jam%'");

						$bdot=$link->query("SELECT * FROM amtabensayos Where CodInforme like '%$jam%'");
						if($rowot=mysqli_fetch_array($bdot)){
							$CodInformeBlanco = '';
							$actSQL="UPDATE amtabensayos SET ";
							$actSQL.="CodInforme		= '".$CodInformeBlanco."'";
							$actSQL.="WHERE CodInforme	like '%".$jam."'%";
							$bdAc=$link->query($actSQL);
						}						
						$bdot=$link->query("SELECT * FROM otams Where CodInforme = '$jam'");
						if($rowot=mysqli_fetch_array($bdot)){
							$CodInformeBlanco = '';
							$actSQL="UPDATE otams SET ";
							$actSQL.="CodInforme		= '".$CodInformeBlanco."'";
							$actSQL.="WHERE CodInforme	like '%".$jam."'%";
							$bdAc=$link->query($actSQL);
						}						
						$bdot=$link->query("SELECT * FROM regtraccion Where CodInforme = '$jam'");
						if($rowot=mysqli_fetch_array($bdot)){
							$CodInformeBlanco = '';
							$actSQL="UPDATE regtraccion SET ";
							$actSQL.="CodInforme		= '".$CodInformeBlanco."'";
							$actSQL.="WHERE CodInforme	like '%".$jam."'%";
							$bdAc=$link->query($actSQL);
						}						
						$bdot=$link->query("SELECT * FROM regquimico Where CodInforme = '$jam'");
						if($rowot=mysqli_fetch_array($bdot)){
							$CodInformeBlanco = '';
							$actSQL="UPDATE regquimico SET ";
							$actSQL.="CodInforme		= '".$CodInformeBlanco."'";
							$actSQL.="WHERE CodInforme	like '%".$jam."'%";
							$bdAc=$link->query($actSQL);
						}						
						$bdot=$link->query("SELECT * FROM regcharpy Where CodInforme = '$jam'");
						if($rowot=mysqli_fetch_array($bdot)){
							$CodInformeBlanco = '';
							$actSQL="UPDATE regcharpy SET ";
							$actSQL.="CodInforme		= '".$CodInformeBlanco."'";
							$actSQL.="WHERE CodInforme	= like '%".$jam."'%";
							$bdAc=$link->query($actSQL);
						}						
						$bdot=$link->query("SELECT * FROM regdoblado Where CodInforme = '$jam'");
						if($rowot=mysqli_fetch_array($bdot)){
							$CodInformeBlanco = '';
							$actSQL="UPDATE regdoblado SET ";
							$actSQL.="CodInforme		= '".$CodInformeBlanco."'";
							$actSQL.="WHERE CodInforme	like '%".$jam."'%";
							$bdAc=$link->query($actSQL);
						}						
						$bdot=$link->query("SELECT * FROM regdobladosreal Where CodInforme = '$jam'");
						if($rowot=mysqli_fetch_array($bdot)){
							$CodInformeBlanco = '';
							$actSQL="UPDATE regdobladosreal SET ";
							$actSQL.="CodInforme		= '".$CodInformeBlanco."'";
							$actSQL.="WHERE CodInforme	like '%".$jam."'%";
							$bdAc=$link->query($actSQL);
						}						
						$bdot=$link->query("SELECT * FROM ammuestras Where CodInforme = '$jam'");
						if($rowot=mysqli_fetch_array($bdot)){
							$CodInformeBlanco = '';
							$actSQL="UPDATE ammuestras SET ";
							$actSQL.="CodInforme		= '".$CodInformeBlanco."'";
							$actSQL.="WHERE CodInforme	like '%".$jam."'%";
							$bdAc=$link->query($actSQL);
						}						
					}
				}

				for($i=1; $i <= $_POST['nInforme']; $i++){
					$iam = 'AM-'.$RAM.'-'.$i;
					if($i < 10){
						$iam = 'AM-'.$RAM.'-0'.$i;
					}
					//echo $iam.'<br>';
					$bdiam=$link->query("SELECT * FROM aminformes Where CodInforme like '%$iam%'");
					if($rowiam=mysqli_fetch_array($bdiam)){
						$CodInforme = $rowiam['CodInforme'];
						//$tpEnsayo	= 1;
						$CodInfNew = $iam.$_POST['nInforme'];
						if($_POST['nInforme'] < 10){
							$CodInfNew = $iam.'0'.$_POST['nInforme'];
						}
						$actSQL="UPDATE aminformes SET ";
						$actSQL.="CodInforme		= '".$CodInfNew. 				"',";
						$actSQL.="tpEnsayo			= '".$tpEnsayo. 				"',";
						$actSQL.="ingResponsable	= '".$_POST['ingResponsable'].	"',";
						$actSQL.="cooResponsable	= '".$_POST['cooResponsable']. 	"',";
						$actSQL.="nroinformes		= '".$_POST['nInforme']."'";
						$actSQL.="WHERE CodInforme	= '$CodInforme'";
						$bdAc=$link->query($actSQL);

						$actSQL="UPDATE informes SET ";
						$actSQL.="CodInforme		= '".$CodInfNew. 		"',";
						$actSQL.="nInforme			= '".$_POST['nInforme']."'";
						$actSQL.="WHERE CodInforme	= '$CodInforme'";
						$bdAc=$link->query($actSQL);
					}else{
						$CodInforme 	= $iam.$_POST['nInforme'];
						$nroinformes 	= $_POST['nInforme'];
						if($_POST['nInforme'] < 10){
							$CodInforme = $iam.'0'.$_POST['nInforme'];
						}
						$ingResponsable = $_POST['ingResponsable'];
						$cooResponsable = $_POST['cooResponsable'];
						$link->query("insert into aminformes (	
																CodInforme		,
																tpEnsayo		,
																nroinformes		,
																ingResponsable	,
																cooResponsable	,
																RutCli
															) 
													values (	
																'$CodInforme'		,
																'$tpEnsayo'			,
																'$nroinformes'		,
																'$ingResponsable'	,
																'$cooResponsable'	,
																'$RutCli'
															)");

						$link->query("insert into informes (	
																CodInforme		,
																nInforme		,
																RutCli
															) 
													values (	
																'$CodInforme'	,
																'$nroinformes'	,
																'$RutCli'
															)");
					}
				}
			}
		}
		$link->close();
	}

?>
<div class="row m-2"> 
	<div class="col-5">
		<table id="Cajon" class="table table-dark table-hover table-bordered display" style="margin: 5px;">
		    <thead>
		      <tr>
		        <th>RAM</th>
		        <th>Tp</th>
		        <th>Clientes</th>
		        <th>Acción</th>
		      </tr>
		    </thead>
		    <tbody>
				<?php
					$nFicha = 0;
					$firstRAM = 0;
					$link=Conectarse();
					//if($RAM > 0){
					//	$bdCot=$link->query("SELECT * FROM cotizaciones Where RAM = $RAM and Estado = 'P' and Archivo != 'on' and Eliminado != 'on'");
					//}else{
						$bdCot=$link->query("SELECT * FROM cotizaciones Where RAM > 0 and Estado = 'P' and Archivo != 'on' and Eliminado != 'on'");
					//}
					while($rowCot=mysqli_fetch_array($bdCot)){
							if($firstRAM == 0){ $firstRAM = $rowCot['RAM']; }

							?>
							<tr class="table-light text-dark">
								<td> 
									<?php 
										echo $rowCot['RAM'];
									?>
								</td>
								<td> 

									<?php 
										$tpInforme = '';
										$tpEnsayo = $rowCot['tpEnsayo'];
										$Clase = "badge badge-secondary";
										$Tit = "";
										if($rowCot['tpEnsayo'] == 1){ 
											$tpInforme = 'IC'; 
											$Clase = "badge badge-info";
											$Tit = "Informe de Caracterización";
										}
										if($rowCot['tpEnsayo'] == 2){ 
											$tpInforme = 'AF'; 
											$Clase = "badge badge-secondary";
											$Tit = "Análisis de Fallas";
										}
										if($rowCot['tpEnsayo'] == 3){ 
											$tpInforme = 'CE'; 
											$Clase = "badge badge-primary";
											$Tit = "Certificado de Ensayos";
										}
										if($rowCot['tpEnsayo'] == 4){ 
											$tpInforme = 'IR'; 
											$Clase = "badge badge-success";
											$Tit = "Informe de Resultados";
										}
										if($rowCot['tpEnsayo'] == 5){ 
											$tpInforme = 'IO'; 
											$Clase = "badge badge-danger";
											$Tit = "Informe Oficial";
										}
										//echo $rowCot['tpEnsayo'];
									?>
									<span class="<?php echo $Clase; ?>" title="<?php echo $Tit; ?>">
										<?php echo $tpInforme; ?>
									</span>
								</td>
								<td>
									<?php 
									$bdCli=$link->query("SELECT * FROM clientes Where RutCli = '".$rowCot['RutCli']."'");
									if($rowCli=mysqli_fetch_array($bdCli)){
										echo $rowCli['Cliente'];
									}								
									?>
								</td>
								<td>
									<?php
									$bdCli=$link->query("SELECT * FROM formram Where RAM = '".$rowCot['RAM']."'");
									if($rowCli=mysqli_fetch_array($bdCli)){
										echo '<a class="btn btn-info" role="button" href="pOtams.php?RAM='.$rowCot['RAM'].'&CAM='.$rowCot['CAM'].'"	>Ver	</a>';
									}else{
										echo '<a class="btn btn-danger" role="button" href="pOtams.php?RAM='.$rowCot['RAM'].'&CAM='.$rowCot['CAM'].'"	>Crear	</a>';
									}
									?>
								</td>

							</tr>
						<?php
					}
					$link->close();
				?>
			</tbody>
		</table>
	</div>
	<div class="col-7">

		<?php
			$link=Conectarse();
			$filtroSQL = " Archivada != 'on' ";
			if(!$RAM){
				$RAM = $firstRAM;
			}
			$filtroSQL .= " and  RAM = '".$RAM."'";
			?>
			<script>
				// ram = <?php echo $RAM; ?>;
			</script>
			<?php
			$SQL = "SELECT * FROM formram Where $filtroSQL Order By fechaInicio";
			$nFicha = 0;	
			$bdfRAM=$link->query($SQL);
			if($rowfRAM=mysqli_fetch_array($bdfRAM)){
			}else{
				$fechaInicio = date('Y-m-d');
				$Archivada = 'off';
				//echo $CAM.' '.$RAM.' '.$fechaInicio;
				$bdCot=$link->query("SELECT * FROM cotizaciones Where RAM = '$RAM'");
				if($rowCot=mysqli_fetch_array($bdCot)){
					$CAM = $rowCot['CAM'];
				}
				// echo $CAM.' '. $rowCot['CAM']. ' '.$firstRAM;

				$link->query("insert into formRAM (	
														CAM				,
														RAM				,
														fechaInicio		,
														Archivada		
													) 
											values (	
														'$CAM'			,
														'$RAM'			,
														'$fechaInicio'	,
														'$Archivada'
													)");
			}
			$bdfRAM=$link->query($SQL);
			if($rowfRAM=mysqli_fetch_array($bdfRAM)){
					$tr = "bVerde";
					$Archivada = 'No';
					// echo 'CAM  de gets...'.$CAM;
					$bdCot=$link->query("SELECT * FROM cotizaciones Where RAM = '".$rowfRAM['RAM']."' and CAM = '".$CAM."'");
					if($rowCot=mysqli_fetch_array($bdCot)){
						if($rowCot['Archivo'] == 'on'){
							$Archivada = 'Si';
						}
					}
					// echo 'CAM  de gets...'.$CAM;

					if($Archivada == 'No'){?>
						<div class="card" style="margin: 10px;">
							<div class="card-header">
								<?php
									$SQLver = "SELECT * FROM cotizaciones Where RAM = '".$rowfRAM['RAM']."' and CAM = '".$CAM."'";
									// echo 'SQL '.$SQLver;

									// $bdCot=$link->query("SELECT * FROM Cotizaciones Where RAM = '".$rowfRAM['RAM']."' and CAM = '".$rowfRAM['CAM']."'");
									$bdCot=$link->query($SQLver);
									if($rowCot=mysqli_fetch_array($bdCot)){

										$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowCot['RutCli']."'");
										if($rowCli=mysqli_fetch_array($bdCli)){
											$nFicha++;?>
											<h4>
												<?php echo $rowCli['Cliente']; ?>
												(RAM <?php echo $rowfRAM['RAM']; ?> -
												 CAM <?php echo $rowCot['CAM']; ?>)
											<?php
										}								
									}
								?>
							</div>
							<div class="card-body" style="padding: 10px;">
								<input name="RAM" type="hidden" value="<?php echo $RAM; ?>">
								<input name="CAM" type="hidden" value="<?php echo $CAM; ?>">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
										  	<label for="ingResponsable">Ingenieros Responsable y Cooresponsable:</label>
  											<select name="ingResponsable" class="form-control">
												<option></option>
												<?php
													$bdir=$link->query("SELECT * FROM usuarios Where 	responsableinforme = 'on'");
													while($rowir=mysqli_fetch_array($bdir)){
														if($rowir['usr'] == $rowfRAM['ingResponsable']){?>
															<option selected value="<?php echo $rowir['usr'];	 ?>"><?php echo $rowir['usuario']; ?></option	>
															<?php
														}else{?>
															<option value="<?php echo $rowir['usr']; ?>">	<?php echo $rowir['usuario']; ?></option>
															<?php
														}
													}
												?>
											</select>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
										  	<label for="cooResponsable">Coo-Responsable:</label>
											<select name="cooResponsable" class="form-control">
												<option></option>
												<?php
													$bdir=$link->query("SELECT * FROM usuarios Where 	responsableinforme = 'on'");
													while($rowir=mysqli_fetch_array($bdir)){
														if($rowir['usr'] == $rowfRAM['cooResponsable']){?>
															<option selected value="<?php echo $rowir['usr'];	 ?>"><?php echo $rowir['usuario']; ?></option	>
															<?php
														}else{?>
															<option value="<?php echo $rowir['usr']; ?>">	<?php echo $rowir['usuario']; ?></option>
															<?php
														}
													}
												?>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group">
								  	<label for="cooResponsable">Observaciones:</label>
									<textarea class="form-control" rows="3" id="Obs" name="Obs"><?php echo $rowfRAM['Obs']; ?></textarea>
								</div>

								<div class="row">
									<div class="col-sm-4">
								  		<label for="nMuestras">Cantidad de Muestras:</label>
								  		
								  		<!--
		  								<input class="form-control" type="text" name="nMuestras" id="nMuestras" value="<?php echo $rowfRAM['nMuestras']; ?>">
										-->

										<select class="form-control" id="nMuestras" name="nMuestras">
											<?php
											for($i=1; $i<100; $i++){
												if($i == $rowfRAM['nMuestras']){?>
													<option selected value="<?php echo $i; ?>"><?php echo $i; ?></option>
													<?php
												}else{?>
													<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
													<?php
												}
											}
											?>
									  	</select>
									</div>
									<div class="col-sm-4">
								  		<label for="nMuestras">
								  			Servicio de Taller:
								  			<?php 
								  				if($rowfRAM['Taller'] == 'on'){ 
								  					echo '<b>N° '.$rowfRAM['nSolTaller'].'</b>';
								  				} 
								  			?>
								  		</label>
										<select name="Taller" class="form-control">
											<?php 
												if($rowfRAM['Taller'] == 'on'){?>
													<option value='off'>Sin Servicio</option>
													<option selected value='on'><b>Con Servicio de Taller</b></option>
													<?php
												}else{?>
													<option selected value='off'>Sin Servicio de Taller</option>
													<option value='on'><b>Servicio de Taller</b></option>
													<?php
												}
											?>
										</select>
									</div>
									<div class="col-sm-4">
								  		<label for="fechaInicio">Fecha Inicio</label>
										<?php 
											$fd = explode('-', $rowfRAM['fechaInicio']);
											echo $fd[2].'-'.$fd[1].'-'.$fd[0];
										 ?>
										 <input type="date" name="fechaInicio" value="<?php echo $rowfRAM['fechaInicio']; ?>" readonly />
									</div>									
								</div>

								<?php 
									$sqlIn = "SELECT count(*) as cInf FROM aminformes Where CodInforme like '%$RAM%'";
									$bdIn=$link->query($sqlIn);
									$rowIn=mysqli_fetch_array($bdIn);

									$nInformes = $rowIn['cInf']; 
								?>

								<div class="row" style="margin-top: 10px;">
									<div class="col-sm-5">
								  		<label for="nInforme">
								  			Cantidad de Informes asociados a la <b>RAM <?php echo $RAM; ?></b>
								  		</label>
										<select class="form-control" id="nInforme" name="nInforme">
											<?php
											for($i=0; $i<100; $i++){
												if($i == $nInformes){?>
													<option selected value="<?php echo $i; ?>"><?php echo $i; ?></option>
													<?php
												}else{?>
													<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
													<?php
												}
											}
											?>
									  	</select>
									</div>
									<div class="col-sm-5">
								  		<label for="tpEnsayo">
								  			Informe <?php //echo $rowCot['tpEnsayo']; ?>
								  		</label>
										<select class="form-control" id="tpEnsayo" name="tpEnsayo">
											<?php
												$SQLte = "Select * From amtpensayo";
												$bdte=$link->query($SQLte);
												while($rowte=mysqli_fetch_array($bdte)){
													if($rowte['tpEnsayo'] == $rowCot['tpEnsayo']){
														?>
														<option selected value="<?php echo $rowte['tpEnsayo']?>"><?php echo $rowte['Ensayo']?></option>
														<?php
													}else{
														?>
														<option value="<?php echo $rowte['tpEnsayo']?>"><?php echo $rowte['Ensayo']?></option>
														<?php
													}
												}
											?>
									  	</select>

									</div>
								</div>

							</div>
							<div class="card-footer">
								<button class="btn btn-warning" name="gMuestrasBoot">Guardar Configuración</button>
								<?php
								/*
									<button class="btn btn-warning" ng-click="modi()">Guardar</button>
									if($tr == "bVerde" or $tr == "bAmarilla"){
										echo '<a class="btn btn-warning" role="button" href="formularios/iRAM.php?accion=Imprimir&RAM='.$rowfRAM['RAM'].'&CAM='.$rowfRAM['CAM'].'"	>Guardar	</a>';
									}
								*/
								?>

								<?php
									if($tr == "bVerde" or $tr == "bAmarilla"){
										echo '<a class="btn btn-info" role="button" href="formularios/iRAM.php?accion=Imprimir&RAM='.$rowfRAM['RAM'].'&CAM='.$rowfRAM['CAM'].'"	>Imprimir RAM	</a>';
										if($rowCot['tpEnsayo'] == 5){
											echo '<a class="btn btn-warning m-1" role="button" href="formularios/iRAMAR.php?accion=Imprimir&RAM='.$rowfRAM['RAM'].'&CAM='.$rowfRAM['CAM'].'"	>Form. Inf.Oficial	</a>';
										}
									}
								?>
								<?php
									if($tr == "bVerde" or $tr == "bAmarilla"){
										echo '<a class="btn btn-info" role="button" href="pOtams.php?accion=Actualizar&RAM='.$rowfRAM['RAM'].'&CAM='.$rowfRAM['CAM'].'&prg=Proceso"	>Editar RAM	</a>';
									}
								?>
								<?php
									if($tr == "bVerde" or $tr == "bAmarilla"){
										echo '<a class="btn btn-info" role="button" href="idMuestras.php?accion=Ver&RAM='.$rowfRAM['RAM'].'&CAM='.$rowfRAM['CAM'].'&OCP='.$OCP.'"	>Muestras	</a>';
									}

								?>
								
							</div>
						</div>
						<?php 
							if($nInformes > 0){?>
								<div class="card" style="margin: 10px;">
									<div class="card-header">
										<h5>Informes</h5>
									</div>
									<div class="card-body">
										<table class="table table-dark table-hover">
										    <thead>
										      <tr>
										        <th>#</th>
										        <th>Informes</th>
										        <th>Ir a</th>
										        <th>Asociar</th>
										      </tr>
										    </thead>
										    <tbody>
												<?php
													$nInformes = 0;
													$SQLinf = "SELECT * FROM aminformes Where CodInforme Like '%$RAM%' Order By CodInforme Asc";
													$bdinf=$link->query($SQLinf);
													while($rowinf=mysqli_fetch_array($bdinf)){
														$nInformes++;?>
														<tr>
															<td><?php echo $nInformes; ?></td>
															<td><?php echo $rowinf['CodInforme']; ?></td>
															<td>
																<?php 
																	$linkInf = "../generarinformes2/edicionInformes.php?accion=Editar&CodInforme=".$rowinf['CodInforme']."&RAM=".$RAM."&RutCli=".$rowinf['RutCli'];

																	$SQLot = "SELECT * FROM otams Where CodInforme = '".$rowinf['CodInforme']."'";
																	$bdot=$link->query($SQLot);
																	if($rowot=mysqli_fetch_array($bdot)){?>
																		<a class="btn btn-danger" href="<?php echo $linkInf; ?>">Ver Informe</a>
																		<?php
																	}
																?>

															</td>
															<td>
																<?php 
																	$linkInf = "../generarinformes2/asociaMuestras.php?accion=Asocia&CodInforme=".$rowinf['CodInforme']."&RAM=".$RAM."&RutCli=".$rowinf['RutCli'];

																	$SQLot = "SELECT * FROM otams Where RAM = '".$RAM."'";
																	$bdot=$link->query($SQLot);
																	if($rowot=mysqli_fetch_array($bdot)){?>
																		<a class="btn btn-danger" href="<?php echo $linkInf; ?>">Asocia</a>
																		<?php
																	}									
																?>
															</td>
														</tr>
														<?php
													}
												?>
											</tbody>
										</table>
									</div>
								</div>						
								<?php
							}
					}
			}
			$link->close();
			
		?>
	</div>
</div>