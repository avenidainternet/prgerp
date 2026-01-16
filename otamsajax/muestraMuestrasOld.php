<?php
	//session_start(); 
	//include_once("conexion.php");
	$link=Conectarse();
	$tEns = 0;
	if(isset($_GET['CAM']))  		{ $CAM		= $_GET['CAM']; 		}
	if(isset($_GET['RAM']))  		{ $RAM		= $_GET['RAM']; 		}
	if(isset($_GET['dBuscar']))  	{ $dBuscar  = $_GET['dBuscar']; 	} 
	if(isset($_GET['accion']))  	{ $accion	= $_GET['accion']; 		}
	
	if(isset($_POST['CAM']))  		{ $CAM		= $_POST['CAM']; 		}
	if(isset($_POST['RAM']))  		{ $RAM		= $_POST['RAM']; 		}
	if(isset($_POST['idItem']))  	{ $idItem	= $_POST['idItem']; 	}
	if(isset($_POST['idEnsayo']))  	{ $idEnsayo	= $_POST['idEnsayo']; 	}
	if(isset($_POST['accion']))  	{ $accion	= $_POST['accion']; 	}

	$agnoActual = date('Y'); 
	// $vDir = 'Y://AAA/Archivador-'.$agnoActual.'/Laboratorio/Archivador-AM/'.$RAM.'/Du/Planos'; 
	$vDir = 'Y://AAA/Archivador-'.$agnoActual.'/Laboratorio/Archivador-AM/'.$RAM; 
	if(!file_exists($vDir)){
		mkdir($vDir);
	}
	$vDir = 'Y://AAA/Archivador-'.$agnoActual.'/Laboratorio/Archivador-AM/'.$RAM.'/Du'; 
	if(!file_exists($vDir)){
		mkdir($vDir);
	}
	$vDir = 'Y://AAA/Archivador-'.$agnoActual.'/Laboratorio/Archivador-AM/'.$RAM.'/Du/Planos'; 
	if(!file_exists($vDir)){
		mkdir($vDir);
	}

	$link=Conectarse();
	$vDirEnsayos = 'Y://AAA/Archivador-'.$agnoActual.'/Laboratorio/Archivador-AM/'.$RAM; 
	if(!file_exists($vDirEnsayos)){
		mkdir($vDirEnsayos);
	}

	$sqlOtam = "SELECT * FROM otams Where idItem like '%$RAM%' Order By idEnsayo";
	$bdOT=$link->query($sqlOtam);
	while($rowOT=mysqli_fetch_array($bdOT)){
		$vDirEnsayos = 'Y://AAA/Archivador-'.$agnoActual.'/Laboratorio/Archivador-AM/'.$RAM.'/'.$rowOT['idEnsayo']; 
		if(!file_exists($vDirEnsayos)){
			mkdir($vDirEnsayos);
		}	
	}
	// $link->close();





	

	$carpeta = 'Planos/AM-'.$RAM.'/';

	if(isset($_POST['quitarEnsayo']))	{ 
		$bd =$link->query("Delete From amtabensayos Where idItem = '$idItem' and idEnsayo = '$idEnsayo'");
		$bd =$link->query("Delete From regquimico 		Where idItem like '%$idItem%'");
		$bd =$link->query("Delete From regtraccion 		Where idItem like '%$idItem%'");
		$bd =$link->query("Delete From regcharpy 		Where idItem like '%$idItem%'");
		$bd =$link->query("Delete From regdoblado 		Where idItem like '%$idItem%'");
		$bd =$link->query("Delete From regdobladosreal 	Where idItem like '%$idItem%'");
		$bd =$link->query("Delete From otams 			Where idItem = '$idItem' and idEnsayo = '$idEnsayo'");

	}
	if(isset($_POST['guardarEnsayo']))	{ 
		
		//echo $_POST['idItem'].'<br>';
		//echo $_POST['idEnsayo'].'<br>';
		/*
		echo $_POST['Ref'].'<br>';
		*/

		$Ind 		= 0;
		$Tem 		= '';
		$tpMedicion = '';
		$tpMuestra = '';
		if(isset($_POST['Ind']))  		{ $Ind			= $_POST['Ind']; 		}
		if(isset($_POST['Tem']))  		{ $Tem			= $_POST['Tem']; 		}
		if(isset($_POST['tpMedicion'])) { $tpMedicion	= $_POST['tpMedicion']; }
		if(isset($_POST['tpMuestra'])) 	{ $tpMuestra	= $_POST['tpMuestra']; }
		//echo 'Tipo de Muestra: '.$tpMuestra;
		$sql = "SELECT * FROM amtabensayos Where idItem = '$idItem' and idEnsayo = '$idEnsayo'";
		$bd=$link->query($sql);
		if($row=mysqli_fetch_array($bd)){
			$actSQL="UPDATE amtabensayos SET ";
			$actSQL.="cEnsayos		='".$_POST['cEnsayos'].		"',";
			$actSQL.="Ref			='".$_POST['Ref'].			"',";
			$actSQL.="Ind			='".$Ind.					"',";
			$actSQL.="Tem			='".$Tem.					"',";
			$actSQL.="tpMedicion	='".$tpMedicion.			"',";
			$actSQL.="tpMuestra		='".$tpMuestra.				"'";
			$actSQL.="WHERE idItem 	= '$idItem' and idEnsayo = '$idEnsayo'";
			$bdAct=$link->query($actSQL);
		}else{
			$tpMuestra 	= '';
			$Ref 		= 'SR';
			$cEnsayos	= 0;
			if(isset($_POST['tpMuestra'])) 	{ $tpMuestra	= $_POST['tpMuestra']; 	}
			if(isset($_POST['Ref'])) 		{ $Ref			= $_POST['Ref']; 		}
			if(isset($_POST['cEnsayos'])) 	{ $cEnsayos		= $_POST['cEnsayos']; 	}
			$link->query("insert into amtabensayos(
													idItem			,
													idEnsayo		,
													tpMuestra		,
													Ref				,
													cEnsayos		,
													Ind				,
													Tem				,
													tpMedicion		
												) 
										values 	(	
													'$idItem'		,
													'$idEnsayo'		,
													'$tpMuestra'	,
													'$Ref'			,
													'$cEnsayos'		,
													'$Ind'			,
													'$Tem'			,
													'$tpMedicion'	
												)");

		}
		
		$reg = '';
		if($idEnsayo == 'Qu'){ $reg = 'regquimico'; 	}
		if($idEnsayo == 'Tr'){ $reg = 'regtraccion'; 	}
		if($idEnsayo == 'Ch'){ $reg = 'regcharpy'; 		}
		if($idEnsayo == 'Du'){ $reg = 'regdoblado'; 	}
		if($idEnsayo == 'Do'){ $reg = 'regdobladosreal'; }
		if($reg){
			if(isset($_POST['tpMuestra'])) { $tpMuestra	= $_POST['tpMuestra']; }

			$sql = "SELECT count(*) as cEns FROM $reg Where idItem like '%$RAM%' and tpMuestra = '$tpMuestra'";
			$bd=$link->query($sql);
			$row=mysqli_fetch_array($bd);
			
			$cEns = $row['cEns'];

			if(isset($_POST['cEnsayos'])) 	{ $cEnsayos		= $_POST['cEnsayos']; 	}
			$sqly = "SELECT * FROM amensayos Where idEnsayo = '$idEnsayo'";
			$bdy=$link->query($sqly);
			if($rowy=mysqli_fetch_array($bdy)){
			}
			$idOtam = $idItem;
			for($e=1; $e <= $cEnsayos; $e++ ){
				$idOtam = $idItem.'-'.$rowy['Suf'].$e;
				if($e < 10){
					$idOtam = $idItem.'-'.$rowy['Suf'].'0'.$e;
				}
				//echo $tpMuestra;
				$sqlr = "SELECT * FROM $reg Where idItem = '$idOtam' and tpMuestra = '$tpMuestra'";
				$bdr=$link->query($sqlr);
				if($rowr=mysqli_fetch_array($bdr)){

				}else{
					if($idEnsayo == 'Ch' or $idEnsayo == 'Du'){
						if($idEnsayo == 'Ch'){
							for($ch = 1; $ch<= $Ind; $ch++){
								$link->query("insert into $reg(idItem	, tpMuestra, nImpacto  ) 
												  	values ('$idOtam'	,'$tpMuestra', '$ch')");

							}
						}
						if($idEnsayo == 'Du'){
							for($ch = 1; $ch<= $Ind; $ch++){
								$link->query("insert into $reg(idItem	, tpMuestra, nIndenta  ) 
												  	values ('$idOtam'	,'$tpMuestra', '$ch')");

							}
						}
					}else{
						$link->query("insert into $reg(idItem	, tpMuestra  ) 
										  	values ('$idOtam'	,'$tpMuestra')");

					}

					$Tem 		= 'Normal';
					if(isset($_POST['tpMuestra'])) 	{ $tpMuestra	= $_POST['tpMuestra']; 	}
					if(isset($_POST['Tem']))  		{ $Tem			= $_POST['Tem']; 		}
					$fechaCreaRegistro = date('Y-m-d');
					/*
					$sqlinset = "insert into otams (
														RAM				,
														CAM				,
														fechaCreaRegistro,
														idItem			,
														Otam			,
														tpMuestra		,
														idEnsayo		,
														Ind				,
														Tem				,
														tpMedicion		
													) 
										  	values ( 	
										  				'$RAM'			,
										  				'$CAM'			,
										  				'$fechaCreaRegistro',
										  				'$idItem'		,
										  				'$idOtam'		,
										  				'$tpMuestra'	,
										  				'$idEnsayo'		,
										  				'$Ind'			,
										  				'$Tem'			,
										  				'$tpMedicion'
										  			)";
					*/
					//echo $sqlinset;

					$link->query("insert into otams (
														CAM				,
														RAM				,
														fechaCreaRegistro,
														idItem			,
														Otam			,
														idEnsayo		,
														tpMuestra		,
														Ind				,
														Tem				,
														tpMedicion
													) 
										  	values ( 	
										  				'$CAM'			,
										  				'$RAM'			,
										  				'$fechaCreaRegistro',
										  				'$idItem'		,
										  				'$idOtam'		,
										  				'$idEnsayo'		,
										  				'$tpMuestra'	,
										  				'$Ind'			,
										  				'$Tem'			,
										  				'$tpMedicion'
										  			)");

				}

			}
			$e--;
			if($cEns > $e){
				$idOtam = $idItem;
				for($i=$e+1; $i <= $cEns; $i++ ){
					$idOtam = $idItem.'-'.$rowy['Suf'].$i;
					if($i < 10){
						$idOtam = $idItem.'-'.$rowy['Suf'].'0'.$i;
					}
					$bd =$link->query("Delete From $reg Where idItem = '$idOtam' and tpMuestra = '$tpMuestra'");
				}
			}
		}else{
			$tpMuestra 	= '';
			if(isset($_POST['cEnsayos'])) 	{ $cEnsayos		= $_POST['cEnsayos']; 	}
			$fechaCreaRegistro = date('Y-m-d');
			for($e=1; $e <= $cEnsayos; $e++ ){
				$idOtam = $idItem.'-'.$idEnsayo.$e;
				if($e < 10){
					$idOtam = $idItem.'-'.$idEnsayo.'0'.$e;
				}
				$link->query("insert into otams (
														CAM				,
														RAM				,
														fechaCreaRegistro,
														idItem			,
														Otam			,
														idEnsayo		,
														tpMuestra		,
														Ind				,
														Tem				,
														tpMedicion
													) 
										  	values ( 	
										  				'$CAM'			,
										  				'$RAM'			,
										  				'$fechaCreaRegistro',
										  				'$idItem'		,
										  				'$idOtam'		,
										  				'$idEnsayo'		,
										  				'$tpMuestra'	,
										  				'$Ind'			,
										  				'$Tem'			,
										  				'$tpMedicion'
										  			)");
			}
			
		}




	}
	if(isset($_POST['guardarMuestra']))	{ 
		//echo $_POST['idMuestra'];
		//echo $_POST['conEnsayo'].'<br>';
		//echo $_POST['Taller'];
		//echo $_POST['Objetivo'];
		//echo $_FILES['Plano']['name'].'<br>';
		//echo $_FILES['Plano']['type'].'<br>';
		//echo $_FILES['Plano']['tmp_name'];
		//echo $_FILES['Plano']['size'];
		$archivo = '';
		if(isset($_FILES['Plano']['name'])){
			if($_FILES['Plano']['name']){
				$aExt = '';
				if($_FILES['Plano']['type'] == 'application/pdf'){ $aExt = '.pdf'; }
				if($_FILES['Plano']['type'] == 'image/jpeg'){ $aExt = '.jpg'; }
				if($_FILES['Plano']['type'] == 'image/png'){ $aExt = '.png'; }
				if($_FILES['Plano']['type'] == 'application/vnd.ms-excel'){ $aExt = '.xls'; }
				if($_FILES['Plano']['type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'){ $aExt = '.docx'; }
				$archivo = $_FILES['Plano']['name'];
				if($aExt){
					$archivo = 'Plano-'.$RAM.'.'.$aExt;
				}
				if (move_uploaded_file($_FILES['Plano']['tmp_name'], $vDir."/".$archivo)){

				}
			}
		}
		if(isset($_POST['idItem']))  	{ $idItem	= $_POST['idItem']; 	}
		$sql = "SELECT * FROM amMuestras Where idItem = '$idItem'";
		$bd=$link->query($sql);
		if($row=mysqli_fetch_array($bd)){
			if(!$archivo){
				$archivo = $row['Plano'];
			}
			$actSQL="UPDATE amMuestras SET ";
			$actSQL.="idMuestra		='".$_POST['idMuestra'].	"',";
			$actSQL.="conEnsayo		='".$_POST['conEnsayo'].	"',";
			$actSQL.="Taller		='".$_POST['Taller'].		"',";
			$actSQL.="Objetivo		='".$_POST['Objetivo'].		"',";
			$actSQL.="Plano			='".$archivo.				"'";
			$actSQL.="WHERE idItem 	= '$idItem'";
			$bdAct=$link->query($actSQL);
		}
	}

	$txtEnsayos = '';
?>
<form action="idMuestras.php" method="post" enctype="multipart/form-data">
<div class="row">
	<div class="col-4">
		<table id="Muestras" class="table table-dark  table-bordered" style="margin: 5px;">
			<thead>
				<tr>
					<th height="40"><strong>Id.SIMET				</strong></th>
					<th>			<strong>Identificación Cliente 	</strong></th>
					<th>			<strong>Serv.<br>Taller 		</strong></th>
					<th>			<strong>OTAMs 					</strong></th>
					<th colspan="3"><strong>Acciones				</strong></th>
				</tr>
			</thead>
			<tbody>
<!--			
				<tr ng-repeat = "x in regMuestras"
				ng-class="verColorLineaPAM(x.idMuestra)">
					<td>
						{{x.idItem}}
					</td>
					<td>
						{{x.idMuestra}}
					</td>
					<td>
						{{x.nSolTaller}}
					</td>
					<td>
						{{x.txtEnsayos}}
					</td>
					<td>
						<a href="" class="btn btn-info" ng-click="editarMuestra(x.idItem)">Editar</a>
					</td>
				</tr>
-->




				<?php
				$firstidItem = '';
				if(isset($_GET['idItem']))  	{ $firstidItem	= $_GET['idItem']; 		}
				$bdfRAM=$link->query("SELECT * FROM amMuestras Where idItem Like '%".$RAM."%' Order By idItem");
				while($rowfRAM=mysqli_fetch_array($bdfRAM)){
					if(!$firstidItem){
						$firstidItem = $rowfRAM['idItem'];
					}
					$txtEnsayos = '';
					$tr = "bg-secondary text-white"; //"Blanca";
					if($rowfRAM['idMuestra'] != ''){
						$tr = "bg-danger text-white"; //"bRoja";
						$i = 0;
						$txtEnsayos = '';
						$SQL = "Select * From amtabensayos Where idItem = '".$rowfRAM['idItem']."'";
						//echo $SQL.'<br>';
						$bdCot=$link->query($SQL);
						while($rowCot=mysqli_fetch_array($bdCot)){
								$tr = "bg-success text-white"; // "bVerde";
								$i++;
								if($i > 1){ 
									$txtEnsayos .= ', '.$rowCot['idEnsayo'].'('.$rowCot['cEnsayos'].'';
								}else{
									$txtEnsayos = $rowCot['idEnsayo'].'('.$rowCot['cEnsayos'].')';
								}
						}
					}
					?>
					<tr class="<?php echo $tr; ?>">
							<td width="08%" style="font-size:16px;"  align="center">
								<?php echo $rowfRAM['idItem']; ?>
							</td>
							<td width="40%" style="font-size:16px;">
								<?php echo $rowfRAM['idMuestra']; ?>
							</td>
							<td width="10%" style="font-size:16px;">
								<?php
									if($rowfRAM['Taller'] == 'on'){
										$bdCot=$link->query("Select * From formRAM Where RAM = '".$RAM."'");
										if($rowCot=mysqli_fetch_array($bdCot)){
											echo $rowCot['nSolTaller'];
										}
									}
								?>
							</td>
							<td width="20%" style="font-size:12px;" align="left">
								<?php echo $txtEnsayos; ?>
							</td>
							<td width="18%" colspan="3" align="center">
								<a class="btn btn-info" href="idMuestras.php?idItem=<?php echo $rowfRAM['idItem']; ?>&RAM=<?php echo $RAM; ?>&CAM=<?php echo $CAM; ?>&accion=">Editar
								</a>
							</td>
						</tr>
						<?php
				}
				?>
			</tbody>			
		</table>
	</div>

	<div class="col-8">
		<input name="CAM" 		type="hidden"  	value="<?php echo $CAM; ?>">
		<input name="RAM" 		type="hidden"  	value="<?php echo $RAM; ?>">
		<input name="idItem" 	type="hidden" 	value="<?php echo $firstidItem; ?>">
		<input name="accion" 	type="hidden" 	value="<?php echo $accion; ?>">

<!--
		<div class="card" style="margin: 10px;" ng-show="formMuestra">
			<div class="card-header">
				<h5>Muestras {{idItem}} Servicio de Taller {{nSolTaller}}</h5>
			</div>
			<div class="card-body" style="padding:10px;">
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text">Id. Muestra</span>
					</div>
					<input type="text" ng-model="idMuestra" class="form-control">
				</div>				
				<div class="row">
					<div class="col-6">
						<div class="form-group">
							<label for="conEnsayo">Con Ensayo:</label>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="Taller">Servicio de Taller:</label>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<select class     = "form-control"
                      				ng-model  = "conEnsayo" 
                      				ng-options  = "conEnsayo.codEnsayo as conEnsayo.descripcion for conEnsayo in ensayar" >
                			<option value="off">{{conEnsayo}}</option>
              				</select>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<select class     = "form-control"
                      				ng-model  = "Taller" 
                      				ng-options  = "Taller.codTaller as Taller.descripciontaller for Taller in ServicioTaller" >
                			<option value="off">{{Taller}}</option>
              				</select>
						</div>
					</div>
					<div class="col-12">
						<div class="form-group">
							Objetivo
						</div>
					</div>
					<div class="col-12">
						<div class="form-group">
							<textarea class="form-control" ng-model="Objetivo" rows="4">{{Objetivo}}</textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<a href="" class="btn btn-warning" ng-click="guardarConfiguracionMuestra()">Guardar Muestra</a>
				<span class="alert alert-success alert-dismissible" ng-show="msgGraba">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
  					<strong>Información!</strong> {{resp}}.
				</span>
			</div>
		</div>
-->
		<?php
			if(isset($_POST['idItem'])){ $firstidItem = $_POST['idItem']; }
			$bdm=$link->query("SELECT * FROM amMuestras Where idItem = '$firstidItem'");
			if($rowm=mysqli_fetch_array($bdm)){?>
				<div class="card" style="margin: 10px;">
					<div class="card-header">
						<h5>Muestras <?php echo $firstidItem; ?> 
						<?php
				  			if($rowm['Taller'] == 'on'){
								$bdCot=$link->query("Select * From formRAM Where RAM = '".$RAM."'");
								if($rowCot=mysqli_fetch_array($bdCot)){
				  					?>
									Serv. Taller (<?php echo $rowCot['nSolTaller']; ?>)
									<?php
								}
							}
						?>
						</h5>
					</div>
					<div class="card-body" style="padding:10px;">
						<div class="input-group mb-3">
						     <div class="input-group-prepend">
						       <span class="input-group-text">Id. Muestra</span>
						    </div>
						    <input type="text" name="idMuestra" class="form-control" value="<?php echo $rowm['idMuestra']; ?>">
						 </div>				
						 <div class="row">
						 	<div class="col-6">
								<div class="form-group">
								  <label for="conEnsayo">Con Ensayo:</label>
								  <select class="form-control" name="conEnsayo">
								  	<?php 
								  		if($rowm['conEnsayo'] == 'on'){?>
										    <option selected value='on'>Con Ensayo</option>
								    		<option value='off'>Sin Ensayo</option>
								  			<?php
								  		}elseif($rowm['conEnsayo'] == 'off'){?>
								    		<option value='on'>Con Ensayo</option>
										    <option selected value='off'>Sin Ensayo</option>
								  			<?php
								  		}else{?>
								    		<option value='on'>Con Ensayo</option>
										    <option value='off'>Sin Ensayo</option>
								  			<?php
								  		}
								  	?>
								  </select>
								</div>
							</div>
							<div class="col-6">
								<div class="form-group">
								  <label for="Taller">Servicio de Taller:</label>
								  <select class="form-control" name="Taller">
								  	<?php 
								  		if($rowm['Taller'] == 'off'){?>
								    		<option selected value='off'>Sin Taller</option>
								    		<option value='on'>Con Servicio de Taller</option>
								    		<?php
								    	}elseif($rowm['Taller'] == 'on'){?>
								    		<option value='off'>Sin Taller</option>
								    		<option selected value='on'>Con Servicio de Taller</option>
								    		<?php
								    	}else{?>
								    		<option value='off'>Sin Taller</option>
								    		<option value='on'>Con Servicio de Taller</option>
								    		<?php
								    	}
								    ?>
								  </select>
								</div>
								<div class="form-group">
								  <label for="Objetivo">Objetivo:</label>
								  <textarea class="form-control" name="Objetivo" rows="2"><?php echo $rowm['Objetivo']; ?></textarea>
								</div>

							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<div class="form-group">
								  <label for="Plano">Plano:</label>
								  <input class="form-control-file border" name="Plano" type="file">
								</div>
							</div>
							<div class="col-6">
								<?php 
									if($rowm['Plano']){?>
										<img width="50%" src="<?php echo $carpeta.$rowm['Plano']; ?>" class="img-thumbnail" alt="Plano">
										<?php
									}
								?>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<button class="btn btn-warning" name="guardarMuestra">Guardar Muestra</button>
					</div>
				</div>
				<?php
				if($rowm['idMuestra']){?>
					<div class="card" style="margin: 10px;">
						<div class="card-header">
							<b>Seleccionar tipo de Ensayos para la Muestra <?php echo $firstidItem; ?></b>
						</div>
						<div class="card-body">
							<?php
								$firstidEnsayo = '';
								$Tem = '';
								$bde=$link->query("SELECT * FROM amensayos");
								while($rowe=mysqli_fetch_array($bde)){
									$bdte=$link->query("SELECT * FROM amtabensayos Where idItem = '$firstidItem' and idEnsayo = '".$rowe['idEnsayo']."'");
									if($rowte=mysqli_fetch_array($bdte)){
										if(!$firstidEnsayo){
											$firstidEnsayo = $rowte['idEnsayo'];
										}
										?>
										<a class="btn btn-success" href="idMuestras.php?idItem=<?php echo $firstidItem; ?>&RAM=<?php echo $RAM; ?>&CAM=<?php echo $CAM; ?>&idEnsayo=<?php echo $rowe['idEnsayo']; ?>&accion"><?php echo $rowe['idEnsayo']; ?>
											<span class="badge badge-pill badge-warning"><?php echo $rowte['cEnsayos']; ?></span>
										</a>
										<?php
									}else{?>
										<a class="btn btn-danger" href="idMuestras.php?idItem=<?php echo $firstidItem; ?>&RAM=<?php echo $RAM; ?>&CAM=<?php echo $CAM; ?>&idEnsayo=<?php echo $rowe['idEnsayo']; ?>&accion"><?php echo $rowe['idEnsayo']; ?>
											<span class="badge badge-pill badge-warning">0</span>
										</a>
										<?php
									}
								}
							?>
						</div>
					</div>

					<?php
						if(isset($_GET['idEnsayo'])){ $firstidEnsayo = $_GET['idEnsayo']; }
						if($firstidEnsayo){?>
							<!-- Ensayos -->
							<div class="card" style="margin: 10px;">
								<div class="card-header">
									<?php 
										if(isset($_GET['idEnsayo'])) { 
											$firstidEnsayo = $_GET['idEnsayo'];
										}
										if(isset($_POST['idEnsayo'])) { 
											$firstidEnsayo = $_POST['idEnsayo'];
										}
										$bde=$link->query("SELECT * FROM amensayos Where idEnsayo = '$firstidEnsayo'");
										if($rowe=mysqli_fetch_array($bde)){
											echo '<h4>Ensayo(s) '.$rowe['Ensayo'].'</h4>';
										}
									?>
								</div>
								<div class="card-body" style="padding:10px;">
									<?php
										$bdte=$link->query("SELECT * FROM amtabensayos Where idEnsayo ='$firstidEnsayo' and idItem = '$firstidItem'");
										if($rowte=mysqli_fetch_array($bdte)){
										}
									?>
									<input name="idEnsayo" type="hidden" value="<?php echo $firstidEnsayo; ?>">
									
									<div class="row">
										<div class="col-4">
											<div class="form-grup">
												<label for="cEnsayo">Cantidad de <?php echo $rowe['Ensayo']; ?>(s):</label>
												<select name="cEnsayos" class="form-control bg-secondary text-white">
													<?php
														for($i=1; $i<=100; $i++){
															if($i == $rowte['cEnsayos']){?>
																<option selected value="<?php echo $i; ?>"><?php echo $i; ?>
																</option>
																<?php
															}?>
															<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
															<?php
														}
													?>
												</select>
											</div>
										</div>
										<div class="col-4">
											<?php
												$sqltp = "SELECT * FROM amtpsmuestras Where idEnsayo = '$firstidEnsayo'";
												$bdtm=$link->query($sqltp);
												if($rowtm=mysqli_fetch_array($bdtm)){?>
													<div class="form-grup">
														<label for="tpMuestra">Tp.Muestra:</label>
														<select name="tpMuestra" class="form-control bg-secondary text-white">
															<?php
																$sqltp = "SELECT * FROM amtpsmuestras Where idEnsayo = '$firstidEnsayo'";
																$bdtm=$link->query($sqltp);
																while($rowtm=mysqli_fetch_array($bdtm)){
																	if($rowte['tpMuestra'] == $rowtm['tpMuestra']){?>
																		<option selected value="<?php echo $rowtm['tpMuestra']; ?>"><?php echo $rowtm['Muestra']; ?>
																		</option>
																		<?php
																	}
																	?>
																	<option value="<?php echo $rowtm['tpMuestra']; ?>"><?php echo $rowtm['Muestra']; ?>
																	</option>
																	<?php
																}
															?>
														</select>
													</div>
													<?php 
												}
											?>
										</div>
										<div class="col-4">
											<div class="form-grup">
												<label for="Ref">Referencia:</label>
												<select name="Ref" class="form-control bg-secondary text-white">
													<?php
														if($rowte['Ref'] == 'SR'){?>
															<option value="SR">Sin Referencia</option>
															<?php
														}
														if($rowte['Ref'] == 'CR'){?>
															<option value="CR">Con Referencia</option>
															<?php
														}
													?>
													<option value="SR">Sin Referencia</option>
													<option value="CR">Con Referencia</option>
												</select>
											</div>
										</div>
									</div>


									<?php 
										if($firstidEnsayo == 'Du'){?>
											<div class="row">
												<div class="col-6">
													<div class="form-grup">
														<label for="tpMedicion">Medición:</label>
														<select name="tpMedicion" class="form-control bg-secondary text-white">
															<?php
																if($rowte['tpMedicion'] == 'Medi'){?>
																	<option selected value="Medi">Medición</option>
																	<?php
																}
															?>
															<?php
																if($rowte['tpMedicion'] == 'Perf'){?>
																	<option selected value="Perf">Perfil</option>
																	<?php
																}
															?>
															<option value="Medi">Medición</option>
															<option value="Perfil">Perfil</option>
														</select>
													</div>
												</div>
												<div class="col-6">
													<div class="form-grup">
														<label for="Ind">Indentaciones:</label>
														<input name="Ind" type="number" value="<?php echo $rowte['Ind']; ?>" class="form-control bg-secondary text-white" required>
													</div>
												</div>
											</div>
											<?php
										}
									?>

									<?php 
										if($firstidEnsayo == 'Ch'){?>
											<div class="row">
												<div class="col-6">
													<div class="form-grup">
														<label for="Ind">Impáctos:</label>
														<input name="Ind" type="number" value="<?php echo $rowte['Ind']; ?>" class="form-control bg-secondary text-white" required>
													</div>
												</div>
												<div class="col-6">
													<div class="form-grup ">
														<label for="Tem">Temperatura:</label>
														<input name="Tem" type="text" value="<?php echo $Tem; ?>" class="form-control bg-secondary text-white" required>
													</div>
												</div>
											</div>
											<?php
										}
									?>

									<div class="card-footer">
										<button class="btn btn-warning" name="guardarEnsayo">Guardar Ensayo</button> 
										<button class="btn btn-danger" name="quitarEnsayo">Quitar <?php echo $rowe['Ensayo']; ?></button>
									</div>
								</div>
							</div>
							<?php
						}
				}
				?>


			</div>
		</div>
		<?php
	}
	$link->close();
?>
</form>