<?php
	session_start(); 
	include_once("../conexionli.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']		= $rowPer['Perfil'];
			$_SESSION['IdPerfil']	= $rowPer['IdPerfil'];
		}
		$link->close();
	}else{
		header("Location: ../index.php");
	}
	
	$CodInforme = '';
	$accion 	= '';
	$Espesor = 0;
	$Ancho	= 0;
	$tFlu	= 0;
	$cMax	= 0;
	$Li		= 0;
	$Lf		= 0;
	$aIni	= 0;
	$cFlu	= 0;
	$fMax	= 0;
	$aSob	= 0;
	$tMax	= 0;
	$Di		= 0;
	$Df		= 0;
	$rAre	= '';

	$Temperatura 	= '';
	$Humedad	 	= '';
	$Aporciento	 	= '';
	$Zporciento	 	= '';
	$UTS	 		= '';
	$Observacion	= '';
	$fechaRegistro = date('Y-m-d'); 
	$agnoActual = date('Y'); 

	$RAM	= 0;
	$CAM 	= 0;
	$cC 	= 0;
	$cSi  	= 0;
	$cMn  	= 0;
	$cP  	= 0;
	$cS 	= 0;
	$cCr  	= 0;
	$cNi  	= 0;
	$cMo  	= 0;
	$cAl  	= 0;
	$cCu  	= 0;
	$cCo  	= 0;
	$cTi  	= 0;
	$cNb  	= 0;
	$cV   	= 0;
	$cW   	= 0;
	$cPb  	= 0;
	$cB   	= 0;
	$cSb  	= 0;
	$cSn  	= 0;
	$cZn  	= 0;
	$cAs  	= 0;
	$cBi  	= 0;
	$cTa  	= 0;
	$cCa  	= 0;
	$cCe  	= 0;
	$cZr  	= 0;
	$cLa  	= 0;
	$cSe  	= 0;
	$cN   	= 0;
	$cFe  	= 0;
	$cMg  	= 0;
	$cTe  	= 0;
	$cCd  	= 0;
	$cAg  	= 0;
	$cAu  	= 0;
	$cAi  	= 0;

	if(isset($_GET['accion'])) 		{	$accion 	= $_GET['accion']; 		}
	if(isset($_GET['Otam'])) 		{	$Otam 		= $_GET['Otam']; 		}
	if(isset($_GET['CodInforme']))	{	$CodInforme	= $_GET['CodInforme'];	}

	if($CodInforme){
		// **************************************************************************
		// Crea carpetas tanto en AAA como en el Local si no existiesen
		// **************************************************************************
		$am = explode('-',$CodInforme);
		$ramAm 	= $am[1];
		$RAM 	= $am[1];
	}
	if($Otam){
		$am = explode('-',$Otam);
		$ramAm 	= $am[0];
		$RAM 	= $am[0];
	}
	if($ramAm){
		// **************************************************************************
		// Crea carpetas tanto en AAA como en el Local si no existiesen
		// **************************************************************************

		$agnoActual = date('Y'); 

		$directorioAM = 'Y://AAA/Archivador-'.$agnoActual.'/Laboratorio/Archivador-AM/'.$ramAm;
		$directorioAM = 'Y://AAA/LE/LABORATORIO/'.$agnoActual.'/'.$ramAm;
		if(!file_exists($directorioAM)){
			mkdir($directorioAM);
		}

		$directorioImpactosLocal = '../Archivador-AM/'.$agnoActual;
		if(!file_exists($directorioImpactosLocal)){
			mkdir($directorioImpactosLocal);
			$directorioImpactosLocalRam = $directorioImpactosLocal.'/'.$ramAm;
			if(!file_exists($directorioImpactosLocalRam)){
				mkdir($directorioImpactosLocalRam);
			}
		}else{
			$directorioImpactosLocalRam = $directorioImpactosLocal.'/'.$ramAm;
			if(!file_exists($directorioImpactosLocalRam)){
				mkdir($directorioImpactosLocalRam);
			}
		}
	}



	if($accion != 'Actualizar'){
		$link=Conectarse();
		$bdCot=$link->query("Select * From formRAM Where CAM = '".$CAM."' and RAM = '".$RAM."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$accion = 'Filtrar';
		}
		$link->close();
	}

	if(isset($_GET['guardarIdOtamssssss']) or isset($_GET['guardarOtamsssss'])){	
		$link=Conectarse();
		$bdOT=$link->query("Select * From OTAMs Where Otam = '".$Otam."'");
		if($rowOT=mysqli_fetch_array($bdOT)){
			$Estado = '';
			if(isset($_GET['guardarIdOtam'])){	
				$Estado 	= 'R';
			}
			$tpMuestra 	= $rowOT['tpMuestra'];

			if(isset($_GET['tpMuestra'])) { $tpMuestra = $_GET['tpMuestra']; }
			
			$actSQL="UPDATE OTAMs SET ";
			$actSQL.="tpMuestra		='".$tpMuestra.	"',";
			$actSQL.="Estado		='".$Estado.	"'";
			$actSQL.="WHERE Otam 	= '".$Otam."'";
			$bdfRAM=$link->query($actSQL);

			$tm = explode('-',$Otam);
			$tReg = 'regTraccion';
			echo 'Entra aqui...'.$tReg;
			
			if(isset($_GET['aIni'])) 		{ $aIni 	 		= $_GET['aIni']; 		}
			if(isset($_GET['cFlu'])) 		{ $cFlu 	 		= $_GET['cFlu']; 		}
			if(isset($_GET['cMax'])) 		{ $cMax 	 		= $_GET['cMax']; 		}
			if(isset($_GET['tFlu'])) 		{ $tFlu 	 		= $_GET['tFlu']; 		}
			if(isset($_GET['tMax'])) 		{ $tMax 	 		= $_GET['tMax']; 		}
			if(isset($_GET['aSob'])) 		{ $aSob 	 		= $_GET['aSob']; 		}
			if(isset($_GET['rAre'])) 		{ $rAre 	 		= $_GET['rAre']; 		}
			if(isset($_GET['Espesor'])) 	{ $Espesor 	 		= $_GET['Espesor']; 	}
			if(isset($_GET['Ancho'])) 		{ $Ancho 	 		= $_GET['Ancho']; 		}
			if(isset($_GET['Li'])) 			{ $Li 	 			= $_GET['Li']; 			}
			if(isset($_GET['Lf'])) 			{ $Lf 	 			= $_GET['Lf']; 			}
			if(isset($_GET['Di'])) 			{ $Di 	 			= $_GET['Di']; 			}
			if(isset($_GET['Df'])) 			{ $Df 	 			= $_GET['Df']; 			}

			if(isset($_GET['Temperatura']))	{ $Temperatura  = $_GET['Temperatura'];	}
			if(isset($_GET['Humedad']))		{ $Humedad  	= $_GET['Humedad'];		}
			if(isset($_GET['Aporciento']))	{ $Aporciento  	= $_GET['Aporciento'];	}
			if(isset($_GET['Zporciento']))	{ $Zporciento  	= $_GET['Zporciento'];	}
			if(isset($_GET['UTS']))			{ $UTS  		= $_GET['UTS'];			}
			if(isset($_GET['Observacion']))	{ $Observacion	= $_GET['Observacion'];	}
			if(isset($_GET['fechaRegistro']))	{ $fechaRegistro	= $_GET['fechaRegistro'];	}

				$bdRdM=$link->query("Select * From $tReg Where idItem = '".$Otam."'");
				if(!$rowRdM=mysqli_fetch_array($bdRdM)){
					$link->query("insert into $tReg (
															CodInforme,
															idItem,
															tpMuestra,
															Temperatura,
															Humedad,
															Observacion,
															fechaRegistro
															) 
													values 	(	
															'$CodInforme',
															'$Otam',
															'$tpMuestra',
															'$Temperatura',
															'$Humedad',
															'$Observacion',
															'$fechaRegistro'
															)");
				}
				$bdRdM=$link->query("Select * From $tReg Where idItem = '".$Otam."'");
				if($rowRdM=mysqli_fetch_array($bdRdM)){
					/* Cálculo de Tracción*/
					$g 	= 9.80665; 
					$pi = 3.1416;
					
					if($tpMuestra == 'Pl'){
						$aIni 	= $Espesor * $Ancho;
						$aIni 	= number_format($aIni, 2, ',', '.');
						
						if($Espesor > 0 and $Ancho > 0 and $tFlu > 0){
							$cFlu	= (($tFlu * $Espesor * $Ancho) / $g);
							$cFlu 	= number_format($cFlu, 0, ',', '.');
						}

						if($Espesor > 0 and $Ancho > 0 and $cMax > 0){
							$tMax	= (($cMax / ($Espesor * $Ancho)) * $g);
							$tMax 	= number_format($tMax, 0, ',', '.');
						}

						if($Lf > 0 and $Li > 0 ){
							$aSob	= ((($Lf - $Li) / $Li) * 100);
							$aSob 	= number_format($aSob, 2, ',', '.');
							$Aporciento = (($Lf - $Li) / $Li) * 100;
						}
					}
					if($tpMuestra == 'Re'){
						if($Di > 0){
							$aIni 	= (pow($Di, 2) / 4) * $pi;
							$aIni 	= number_format($aIni, 2, ',', '.');
						}

						if($Di > 0 and $tFlu > 0){
							$cFlu	= ($tFlu * ((pow($Di, 2) / 4) * $pi)) / $g;
							$cFlu 	= number_format($cFlu, 0, ',', '.');
						}

						if($Di > 0){
							$tMax	= ((4 * intval($cMax)) / (pow($Di, 2) * $pi)) * $g ;
							$tMax 	= number_format($tMax, 0, ',', '.');
						}						
						if($Li > 0){
							$aSob	= ((($Lf - $Li) / $Li) * 100);
							$aSob 	= number_format($aSob, 0, ',', '.');
							$Aporciento = (($Lf - $Li) / $Li) * 100;
						}						
						if($Di > 0){
							$rAre	= (((pow($Di, 2) - pow($Df, 2)) / pow($Di, 2)) * 100);
							$rAre 	= number_format($rAre, 2, ',', '.');

							$aInicial 	= (pow($Di, 2) / 4) * $pi;
							$aInicial 	= number_format($aInicial, 2, '.', ',');
							$aFinal 	= (pow($Df, 2) / 4) * $pi;
							$aFinal 	= number_format($aFinal, 2, '.', ',');
							$Zporciento = ((intval($aInicial) - intval($aFinal)) / intval($aInicial)) * 100;
							$Zporciento	= number_format($Zporciento, 2, '.', ',');
							//echo $aInicial.' '.$aFinal.' '.round(($aInicial - $aFinal),2).' '.$Zporciento;
						}

					}
					if($cMax > 0 and $aIni > 0){
						$UTS = ($cMax * $g);
						$UTS = $UTS / floatval($aIni);
					}
					$actSQL="UPDATE $tReg SET ";
					$actSQL.="tpMuestra		='".$tpMuestra.		"',";
					$actSQL.="Espesor		='".$Espesor.		"',";
					$actSQL.="Ancho			='".$Ancho.			"',";
					$actSQL.="Li			='".$Li.			"',";
					$actSQL.="Lf			='".$Lf.			"',";
					$actSQL.="Di			='".$Di.			"',";
					$actSQL.="Df			='".$Df.			"',";
					$actSQL.="aIni			='".$aIni.			"',";
					$actSQL.="cFlu			='".$cFlu.			"',";
					$actSQL.="cMax			='".$cMax.			"',";
					$actSQL.="tFlu			='".$tFlu.			"',";
					$actSQL.="tMax			='".$tMax.			"',";
					$actSQL.="aSob			='".$aSob.			"',";
					$actSQL.="rAre			='".$rAre.			"',";
					$actSQL.="Observacion	='".$Observacion.	"',";
					$actSQL.="Aporciento	='".$Aporciento.	"',";
					$actSQL.="Zporciento	='".$Zporciento.	"',";
					$actSQL.="Temperatura	='".$Temperatura.	"',";
					$actSQL.="Humedad		='".$Humedad.		"',";
					$actSQL.="UTS			='".$UTS.			"',";
					$actSQL.="fechaRegistro	='".$fechaRegistro.	"'";
					$actSQL.="WHERE idItem = '".$Otam."'";
					$bdRdM=$link->query($actSQL);
				}
		}
		$link->close();
		$accion = '';
        $fr = explode('-',$Otam);
        $RAM = $fr[0];
		echo 'Todo Bien';
		//if($CodInforme){
			//header('Location: formularios/otamTraccion.php?accion=Imprimir&RAM='.$RAM.'&Otam='.$Otam.'&CodInforme='.$CodInforme);
			//header('Location: pTallerPM.php');
		//}

	}
?>
<!doctype html>
 
<html lang="es">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

<title>Taller Propiedades Mecánicas</title>
	
	<link href="styles.css" 	rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	

	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	<script src="../angular/angular.min.js"></script>


	<script>
	function realizaProceso(accion){
		var parametros = {
			"accion" 		: accion
		};
		//alert(accion);
		$.ajax({
			data: parametros,
			url: 'mSolEnsayos.php',
			type: 'get',
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}

	function registraOtams(Otam, accion){
		var parametros = {
			"Otam"			: Otam,
			"accion"		: accion
		};
		//alert(RAM);
		$.ajax({
			data: parametros,
			url: 'rValoresOtam.php',
			type: 'get',
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}
	
	</script>

</head>

<body ng-app="myApp" ng-controller="ctrlEnsayos" ng-init="loadEnsayo('<?php echo $Otam; ?>', '<?php echo $CodInforme; ?>')">
	
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<form name="form" action="iTraccion.php" method="get">

	<nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
		<div class="container-fluid">
  	    	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
	          <span class="navbar-toggler-icon"></span>
	        </button>
	    	<div class="collapse navbar-collapse" id="navbarResponsive">



				<a class="navbar-brand" href="#">
					<img src="../imagenes/simet.png" alt="logo" style="width:40px;">
				</a>



	      		<ul class="navbar-nav ml-auto">

	        		<li class="nav-item active">
					
						<?php 
							if($CodInforme){?>
								<input name="CodInforme" type="hidden" ng-model="<?php echo $CodInforme; ?>" value="<?php echo $CodInforme; ?>">
								<a class="nav-link fas fa-power-off" href="../generarinformes2/edicionInformes.php?accion=Editar&CodInforme=<?php echo $CodInforme; ?>" title="Volver a Informe <?php echo $CodInforme; ?>">Volver</a>
	          					<?php  
	          				}else{
								  if($_SESSION['IdPerfil'] == 1){?>
								  	<input name="CodInforme" type="hidden" value="<?php echo $CodInforme; ?>">
									<a class="nav-link fas fa-power-off" href="../generarinformes2/edicionInformes.php?accion=Editar&CodInforme=<?php echo $CodInforme; ?>" title="Volver a Informe <?php echo $CodInforme; ?>">Volver</a>
								    <?php
								  }else{?>
									  <a class="nav-link fas fa-undo-alt"  href="../tallerPM/pTallerPM.php"> Volver</a>
								  	<?php
								  } ?>
	          					<?php
	          				}?>
	        		</li>
					<?php
						if(file_exists('resultadoTr/'.$Otam.'/Resultados.htm')){
							?>
							<li class="nav-item">
								<a class="nav-link fas fa-power-off" href="resultadoTr/<?php echo $Otam.'/Resultados.htm'; ?>" target="_blank"> Gráfica Ensayo</a>
							</li>
							<?php
						}
					?>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="../cerrarsesion.php"> Cerrar</a>
	        		</li>

	      		</ul>
	    	</div>
	  	</div>
	</nav>

	<div class="row bg-info text-white" style="padding: 15px;">
		<div class="col-2">
			<h4><?php echo $Otam; ?></h4>
		</div>
		<div class="col-2">
			
			<?php
				$boton = "btn btn-danger disabled";
				$link=Conectarse();
				$fdItem = explode('-', $Otam);
				$idItem = $fdItem[0].'-'.$fdItem[1];
				$cEnsayos = 0;
				$dEnsayos = 0;
				$sqlTe = "SELECT * FROM amtabensayos Where idItem = '$idItem' and idEnsayo = 'Tr'";
				$bdTe=$link->query($sqlTe);
				if($rowTe=mysqli_fetch_array($bdTe)){
					$cEnsayos = $rowTe['cEnsayos'];
				}

				$sqlCe = "SELECT * FROM regtraccion Where idItem like '%$idItem%'";
				$bdCe=$link->query($sqlCe);
				while($rowCe=mysqli_fetch_array($bdCe)){
					$dEnsayos++;
					if($rowCe['Temperatura'] > 0){
						$cEnsayos -= 1;
					}
				}
				$link->close();
			?>
		</div>
	</div>
	
	<div class="row" style="padding: 10px;">
		<div class="col-8">
			<div class="card">

			  <div class="card-header font-weight-bold">OTAM</div>
			  <div class="card-body">





			  	<table class="table table-dark table-hover text-center table-bordered">
			  		<thead>
			  			<tr>
			  				<th colspan="2">IDENTIFICACIÓN		</th>
			  				<th colspan="4">RESULTADOS 			</th>
			  			</tr>
			  		</thead>
			  		<tbody>
			  			<tr class="table-info text-dark text-center font-weight-bold">
			  				<td>OTAM</td>
			  				<td>
							  	<?php echo $Otam; ?>
							</td>
			  				<td>Diametro Inicial</td>
			  				<td>
							  	<div ng-show="muestraRedonda"> 
									<input class="form-control" ng-model="Di" name="Di"	type="text" autofocus />
								</div>
							  	<div ng-show="muestraEspecial"> 
									<input class="form-control" ng-model="Di" name="Di"	type="text" autofocus />
								</div>
								</div>
								<div ng-show="muestraPlana"> 
							  		<input  class="form-control" type="text" readonly />
								</div>
			  				</td>
			  				<td>Diametro Final</td>
			  				<td>
							  	<div ng-show="muestraRedonda"> 
									<input class="form-control" ng-model="Df" name="Df"	type="text" autofocus />
								</div>
							  	<div ng-show="muestraEspecial"> 
									<input class="form-control" ng-model="Df" name="Df"	type="text" autofocus />
								</div>
								<div ng-show="muestraPlana"> 
							  		<input  class="form-control" type="text" readonly />
								</div>
			  				</td>
			  			</tr>

						  
			  			<tr class="table-info text-dark font-weight-bold"> 
			  				<td>FECHA Registro			</td>
			  				<td>
							  	<input class="form-control" ng-model="fechaRegistro" name="fechaRegistro" type="date" />
							</td>
			  				<td>Espesor				</td>
			  				<td>	
							  	<div ng-show="muestraPlana">
									<input  class="form-control" ng-model="Espesor" name="Espesor"	type="text" value="<?php echo $Espesor; ?>" autofocus />
								</div>
							  	<div ng-show="muestraEspecial">
									<input  class="form-control" ng-model="Espesor" name="Espesor"	type="text" value="<?php echo $Espesor; ?>" autofocus />
								</div>
								<div ng-if="tpMuestra == 'Re'">
									<input class="form-control" name="Espesor" type="text" readonly />
								</div>
						
			  				</td>
			  				<td>Ancho							</td>
			  				<td>
							  	<div ng-show="muestraPlana">
									<input class="form-control"  ng-model="Ancho"  name="Ancho"	type="text"  autofocus />
								</div>
							  	<div ng-show="muestraEspecial">
									<input class="form-control"  ng-model="Ancho"  name="Ancho"	type="text"  autofocus />
								</div>
							  	<div ng-show="muestraRedonda">
									<input class="form-control"  ng-model="Ancho"  name="Ancho"	type="text"  readonly />
								</div>
								<!-- <input ng-if="tpMuestra != 'Pl'" class="form-control"   name="Ancho"	type="text"  readonly /> -->
			  				</td>
			  			</tr>


			  			<tr class="table-info text-dark font-weight-bold">
			  				<td>Fluencia (MPa)					</td>
			  				<td>
							  	<input  class="form-control" ng-model="tFlu" name="tFlu"	type="text" autofocus />
			  				</td>
			  				<td>Temperatura					</td>
			  				<td>
							  	<input class="form-control" ng-model="Temperatura" name="Temperatura"	type="text" required />
			  				</td>
			  				<td>Humedad							</td>
			  				<td>
							  	<input class="form-control" ng-model="Humedad" name="Humedad"	type="text"  required />
			  				</td>
			  			</tr>

						  
			  			<tr class="table-info text-dark font-weight-bold">
			  				<td>Carga Máxima (kgf)					</td>
			  				<td>
							  	<input class="form-control" ng-model="cMax" name="cMax" type="text" size="9" maxlength="9" />
			  				</td>
			  				<td>Largo Inicial					</td>
			  				<td>
							  <input class="form-control" ng-model="Li" name="Li"	type="text" size="9" maxlength="9" />							
			  				</td>
			  				<td>Largo Final							</td>
			  				<td>
							  <input class="form-control"  ng-model="Lf" name="Lf" type="text" size="9" maxlength="9" />	
			  				</td>
			  			</tr>

			  			<tr class="table-info text-dark text-left font-weight-bold"> 
						  	<td colspan="2">
								Técnico Responsable<br> 

								<select   class="form-control" 
                                          ng-model="tecRes">
                                	<option value="" selected>Sel.Operador</option>
                                	<option ng-repeat="x in dataOperador" value="{{x.tecRes}}">{{x.tecRes}}</option>
                                </select>


							</td>
			  				<td colspan="10">
								<label for="Observacion">OBSERVACION:</label>
  								<textarea class="form-control" ng-model="Observacion" rows="5" name="Observacion" id="Observacion"></textarea>			  					
			  				</td>
			  			</tr>
			  		</tbody>
			  	</table>







			  	<!-- Resultados -->
				<input name="Otam" type="hidden" 	value="<?php echo $Otam; ?>" />
				<div class="row" style="padding: 10px;">
					<div class="col-12">
						<div ng-show="muestraPlana">
								<div  class="list-group">
									<table class="table table-dark table-bordered text-center font-weight-bold">
										<thead>
											<tr>
												<th>Área<br>Inicial<br>(mm<sup>2</sup>)				</th>
												<th>Carga Fluencia<br>0,2 % Def,<br>(Kgf)			</th>
												<th>Carga<br>Máxima<br>(Kgf) 						</th>
												<th>Tensión de<br>Fluencia<br>0,2% Def,<br>(MPa) 	</th>
												<th>Tensión<br>Máxima<br>(MPa) 						</th>
												<th>Alarg,<br>Sobre {{Li | number:0}} <br>mm<br>(%) 				</th>
											</tr>
										</thead>
										<tbody>
											<tr class="table-light text-dark">
												<td> {{aIni}} 							</td>
												<td> {{cFlu}}							</td>
												<td> 
													{{vcMax | formatoNumero }}
												</td>
												<td>
													{{tFlu | formatoNumero }}
												</td>
												<td>
													{{tMax | formatoNumero }}
													<!-- <?php echo number_format(intval($tMax), 0, ',', '.'); ?>							 -->
												</td>
												<td>
													{{aSob}}%
													<!-- <?php echo number_format(intval($aSob), 0, ',', '.'). '%'; ?>				 -->
												</td>
											</tr>
										</tbody>
									</table>
								</div>
						</div>
						<div ng-show="muestraRedonda">

								<div ng-if="tpMuestra == 'Re'" class="list-group">
									<table class="table table-dark table-bordered text-center">
										</thead>
										<tr>
											<td>Área<br>Inicial<br>(mm<sup>2</sup>)				</td>
											<td>Carga Fluencia<br>0,2 % Def,<br>(Kgf)			</td>
											<td>Carga<br>Máxima<br>(Kgf) 						</td>
											<td>Tensión de<br>Fluencia<br>0,2% Def,<br>(MPa) 	</td>
											<td>Tensión<br>Máxima<br>(MPa) 						</td>
											<td>Alarg,<br>Sobre {{Li| number:0}}<br>mm<br>(%) 				</td>
											<td>Red.<br>de Área<br>%) 							</td>
										</tr>
										</thead>
										<tbody>
										<tr class="table-light text-dark font-weight-bold">
											<td>{{aIni}} 
												<!-- <?php echo $aIni; ?>	 -->
											</td>
											<td>{{cFlu  }}  
												<!-- <?php echo $cFlu; ?>				 -->
											</td>
											<td>{{vcMax | formatoNumero }} 
												<!-- <?php echo number_format(intval($cMax), 0, ',', '.'); ?>				 -->
											</td>
											<td>{{tFlu | formatoNumero }} 
												<!-- <?php echo number_format(intval($tFlu), 0, ',', '.'); ?>				 -->
											</td>
											<td>{{tMax | formatoNumero }}  
												<!-- <?php echo $tMax; ?>				 -->
											</td>
											<td>{{aSob | formatoNumero }}%
												<!-- <?php echo number_format(intval($aSob), 0, ',', '.'). '%'; ?>							 -->
											</td>
											<td>{{rAre}}%
												<!-- <?php echo number_format(intval($rAre), 0, ',', '.'). '%'; ?>							 -->
											</td>
										</tr>
										</tbody>
									</table>
								</div>
						</div>
					</div>
				</div>
			  	<!-- Resultados -->



			  </div> 
			  <div class="card-footer">
				<div class="row">
					<div class="col-sm-6">
						<!-- window.location.href = 'formularios/otamTraccion.php?accion=Imprimir&RAM='+RAM+'&Otam='+$scope.Otam+'&CodInforme='; -->

						<!-- <a class="btn btn-primary" ng-click="Actualizando()" href="formularios/otamTraccion.php?accion=Imprimir&RAM={{RAM}}&Otam={{Otam}}&CodInforme=" role="button"> -->
						<a class="btn btn-primary" ng-click="Actualizando()" role="button"> 
							<i class="fas fa-calculator"></i> 
							Actualizar registro Tracción 
						</a>
					</div>
					<!--
					<div class="col-sm-6">
						<a class="btn btn-danger" ng-click="ActualizandoCerrado()" href="#" role="button"  title="Guardar y cerrar ensayo...">
							Guardar y cerrar ensayo <?php echo $Otam.' '.$cEnsayos.' de '.$dEnsayos; ?>
						</a>
					</div>
					-->
				</div>

			  </div>			  
			</div>	
		</div>
		<div class="col-4">
			<table class="table table-dark table-bordered text-center bg-info text-white">
				<thead>
					<tr>
						<th  colspan="2">Datos previos Ensayo</th>
					</tr>
				</thead>
				<tbody>
					<tr class="table-light text-dark">
						<td>Tp.Muestra</td> 
						<td>
							<h5>
								<select   class="form-control" 
                                          ng-model="tpMuestra"
										  ng-change="grabarDataMuestra()">
                                	<option value="" selected>Sel.Muestra</option>
                                	<option ng-repeat="x in dataMuestras" value="{{x.tpMuestra}}">{{x.Muestra}}</option>
                                </select>
								<!-- {{Muestra}} -->
							</h5>
						</td>
					</tr>
					<tr class="table-light text-dark">
						<td>Factor Gravedad estándar </td>
						<td>
							<?php $factor = 9.80665; ?>
							<input class="form-control" name="Diametro"	type="text" value="<?php echo $factor; ?>" />
						</td>
					</tr>
				</tbody>
			</table>
			<div class="card">

			  	<div class="card-header font-weight-bold bg-info text-white"><b>Archivos Asociados al Ensayo</b></div>
			  	<div class="card-body">
					  <input id="archivosSeguimiento" multiple type="file"> {{pdf}}
				</div>
				<!-- <li ng-repeat="f in dataFicheros">{{y.ficheros}}</li> -->
				<?php 
				
					$tr = "bVerde";
					$fd = explode('-',$Otam);
					$RAM = $fd[0];
				
					$agnoActual = date('Y'); 
					$ruta = 'Y://AAA/Archivador-'.$agnoActual.'/Laboratorio/Archivador-AM/'.$RAM.'/Tr'; 

					if(file_exists($ruta)){
						$gestorDir = opendir($ruta);
						while(false !== ($nombreDir = readdir($gestorDir))){
							if($nombreDir != '.' and $nombreDir != '..'){
								$nombreDirFalso = 'Tr-'.$nombreDir;
								$fd = explode($Otam, $nombreDirFalso);
								// echo $nombreDir;
								// if(substr($nombreDir, 0, strlen($Otam)) == $Otam or substr($nombreDir,0,4) == 'Otam'){
								if(substr($nombreDir, 0, strlen($Otam)) == $Otam){
									?>
									<div class="row">
										<div class="col m-1">
											<a href="<?php echo 'tmp/'.$nombreDir; ?>" class="btn btn-primary  btn-block" target="_blank" role="button">
												<b><?php echo $nombreDir; ?></b>
											</a>
										</div>
										<!-- <div class="col-3 m-1">
											<button type="button" class="btn btn-danger">Quitar</button>
										</div> -->
									</div>
								<?php
								}
							}
						}
					}
				?>

				<div class="card-footer"> 
				<button class="btn btn-success" type="button" ng-click="enviarFormularioSeg()">
					Subir Archivo
				</button>
				</div>
			</div>

		</div>

	</div>


	</form>
	<br>

	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="../jsboot/bootstrap.min.js"></script>	
	<script src="ensayos.js"></script>

	<script>
		$(document).ready(function() {
		    $('#tabla').DataTable( {
		        "order": [[ 0, "asc" ]],
				"language": {
					            "lengthMenu": "Mostrar _MENU_ Reg. por Página",
					            "zeroRecords": "Nothing found - sorry",
					            "info": "Mostrando Pág. _PAGE_ de _PAGES_",
					            "infoEmpty": "No records available",
					            "infoFiltered": "(de _MAX_ tot. Reg.)",
					            "loadingRecords": "Cargando...",
					            "search":         "Buscar:",
								"paginate": {
								        "first":      "Ultimo",
								        "last":       "Anterior",
								        "next":       "Siguiente",
								        "previous":   "Anterior"
								    },        		
								}
		    } );
		} );
	</script>
	
	
</body>
</html>
