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
	
	$accion 	= '';
	$Otam		= '';
	$CodInforme	= '';
	
	$RAM 	= 0;
	$CAM	= 0;
	
	if(isset($_GET['accion'])) 		{	$accion 	= $_GET['accion']; 		}
	if(isset($_GET['Otam'])) 		{	$Otam 		= $_GET['Otam']; 		}
	if(isset($_GET['CodInforme']))	{	$CodInforme	= $_GET['CodInforme'];	}



	$link=Conectarse();
	$SQLd = "Select * From regdoblado Where idItem = '$Otam'"; 
	$bdd=$link->query($SQLd);
	if($rsd = mysqli_fetch_array($bdd)){
	}else{
		$fd = explode('-', $Otam);
		$id = $fd[0].'-'.$fd[1];
		$SQLe = "Select * From amtabensayos Where idItem = '$id' and idEnsayo = 'Du'";
		$bde=$link->query($SQLe);
		if($rse = mysqli_fetch_array($bde)){
			$Ind 		= $rse['Ind'];
			$tpMuestra 	= $rse['tpMuestra'];
			$CodInforme	= $rse['CodInforme'];
			for($i=1; $i<=$Ind; $i++){
				$link->query("insert into regdoblado (
					CodInforme,
					idItem,
					tpMuestra,
					nIndenta
						) 
				values 	(	
					'$CodInforme',
					'$Otam',
					'$tpMuestra',
					'$i'
				)");
			}
		}
	}
	$link->close();






	if($accion != 'Actualizar'){
		$link=Conectarse();
		$bdCot=$link->query("Select * From formRAM Where CAM = '".$CAM."' and RAM = '".$RAM."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$accion = 'Filtrar';
		}
		$link->close();
	}

	if(isset($_GET['guardarIdOtam'])){	
		$link=Conectarse();
		$bdOT=$link->query("Select * From OTAMs Where Otam = '".$Otam."'");
		if($rowOT=mysqli_fetch_array($bdOT)){
			$Estado 	= 'R';
			$tpMuestra 	= $rowOT['tpMuestra'];

			if(isset($_GET['tpMuestra'])) { $tpMuestra = $_GET['tpMuestra']; }
			
			$actSQL="UPDATE OTAMs SET ";
			$actSQL.="tpMuestra		='".$tpMuestra.	"',";
			$actSQL.="Estado		='".$Estado.	"'";
			$actSQL.="WHERE Otam 	= '".$Otam."'";
			$bdfRAM=$link->query($actSQL);

			$tm = explode('-',$Otam);
			$tReg = 'regDureza';
			
			if(isset($_GET['aIni'])) 			{ $aIni 	 		= $_GET['aIni']; 			}
			if(isset($_GET['cFlu'])) 			{ $cFlu 	 		= $_GET['cFlu']; 			}
			if(isset($_GET['cMax'])) 			{ $cMax 	 		= $_GET['cMax']; 			}
			if(isset($_GET['tFlu'])) 			{ $tFlu 	 		= $_GET['tFlu']; 			}
			if(isset($_GET['tMax'])) 			{ $tMax 	 		= $_GET['tMax']; 			}
			if(isset($_GET['aSob'])) 			{ $aSob 	 		= $_GET['aSob']; 			}
			if(isset($_GET['rAre'])) 			{ $rAre 	 		= $_GET['rAre']; 			}

			if(isset($_GET['cC'])) { $cC 	= $_GET['cC']; }
			if(isset($_GET['cSi'])){ $cSi  	= $_GET['cSi'];}
			if(isset($_GET['cMn'])){ $cMn  	= $_GET['cMn'];}
			if(isset($_GET['cP'])) { $cP 	= $_GET['cP']; }
			if(isset($_GET['cS'])) { $cS 	= $_GET['cS']; }
			if(isset($_GET['cCr'])){ $cCr  	= $_GET['cCr'];}
			if(isset($_GET['cNi'])){ $cNi  	= $_GET['cNi'];}
			if(isset($_GET['cMo'])){ $cMo  	= $_GET['cMo'];}
			if(isset($_GET['cAl'])){ $cAl  	= $_GET['cAl'];}
			if(isset($_GET['cCu'])){ $cCu  	= $_GET['cCu'];}
			if(isset($_GET['cCo'])){ $cCo  	= $_GET['cCo'];}
			if(isset($_GET['cTi'])){ $cTi  	= $_GET['cTi'];}
			if(isset($_GET['cNb'])){ $cNb  	= $_GET['cNb'];}
			if(isset($_GET['cV'])) { $cV   	= $_GET['cV']; }
			if(isset($_GET['cW'])) { $cW   	= $_GET['cW']; }
			if(isset($_GET['cPb'])){ $cPb  	= $_GET['cPb'];}
			if(isset($_GET['cB'])) { $cB   	= $_GET['cB']; }
			if(isset($_GET['cSb'])){ $cSb  	= $_GET['cSb'];}
			if(isset($_GET['cSn'])){ $cSn  	= $_GET['cSn'];}
			if(isset($_GET['cZn'])){ $cZn  	= $_GET['cZn'];}
			if(isset($_GET['cAs'])){ $cAs  	= $_GET['cAs'];}
			if(isset($_GET['cBi'])){ $cBi  	= $_GET['cBi'];}
			if(isset($_GET['cTa'])){ $cTa  	= $_GET['cTa'];}
			if(isset($_GET['cCa'])){ $cCa  	= $_GET['cCa'];}
			if(isset($_GET['cCe'])){ $cCe  	= $_GET['cCe'];}
			if(isset($_GET['cZr'])){ $cZr  	= $_GET['cZr'];}
			if(isset($_GET['cLa'])){ $cLa  	= $_GET['cLa'];}
			if(isset($_GET['cSe'])){ $cSe  	= $_GET['cSe'];}
			if(isset($_GET['cN'])) { $cN   	= $_GET['cN']; }
			if(isset($_GET['cFe'])){ $cFe  	= $_GET['cFe'];}
			if(isset($_GET['cMg'])){ $cMg  	= $_GET['cMg'];}
			if(isset($_GET['cTe'])){ $cTe  	= $_GET['cTe'];}
			if(isset($_GET['cCd'])){ $cCd  	= $_GET['cCd'];}
			if(isset($_GET['cAg'])){ $cAg  	= $_GET['cAg'];}
			if(isset($_GET['cAu'])){ $cAu  	= $_GET['cAu'];}
			if(isset($_GET['cAi'])){ $cAi  	= $_GET['cAi'];}
			$aplicaFormula = '';
			if(isset($_GET['Ind']))				{ $Ind  			= $_GET['Ind'];				}
			if(isset($_GET['aplicaFormula']))	{ $aplicaFormula  	= $_GET['aplicaFormula'];	}
			if(isset($_GET['factorY']))			{ $factorY  		= $_GET['factorY'];			}
			if(isset($_GET['constanteY']))		{ $constanteY  		= $_GET['constanteY'];		}
			if(isset($_GET['fechaRegistro']))	{ $fechaRegistro  	= $_GET['fechaRegistro'];	}
			
				for($in=1; $in<=$Ind; $in++) { 
					$el_nIndenta 	= 'nIndenta_'.$in.'-'.$Otam;
					$el_vIndenta	= 'vIndenta_'.$in.'-'.$Otam;
					if(isset($_GET[$el_nIndenta]))		{ $el_nIndenta		= $_GET[$el_nIndenta];		}
					if(isset($_GET[$el_vIndenta]))		{ $el_vIndenta		= $_GET[$el_vIndenta];		}
					$cIndenta = 0;
					if($aplicaFormula == 'Si'){
						$cIndenta = (intval($factorY) * intval($el_vIndenta)) + intval($constanteY);
					}
					$bdRegDo=$link->query("SELECT * FROM regDoblado Where idItem = '".$Otam."' and nIndenta = '".$in."'");
					if($rowRegDo=mysqli_fetch_array($bdRegDo)){
						$actSQL="UPDATE regDoblado SET ";
						$actSQL.="fechaRegistro ='".$fechaRegistro.	"',";
						$actSQL.="vIndenta 		='".$el_vIndenta.	"',";
						$actSQL.="cIndenta 		='".$cIndenta.		"'";
						$actSQL.="WHERE idItem 	= '".$Otam."' and nIndenta = '".$in."'";
						$bdRegDo=$link->query($actSQL);
					}else{
						$link->query("insert into regDoblado(
																CodInforme,
																idItem,
																tpMuestra,
																fechaRegistro,
																nIndenta,
																vIndenta,
																cIndenta
																) 
														values 	(	
																'$CodInforme',
																'$Otam',
																'$tpMuestra',
																'$fechaRegistro',
																'$in',
																'$el_vIndenta',
																'$cIndenta'
								)");
					}
				}
		}
		$link->close();
		$accion = '';
	}
	$link=Conectarse();
	$fechaRegistro = date('Y-m-d');
	$bdRegDu=$link->query("SELECT * FROM regDoblado Where idItem = '".$Otam."'");
	if($rowRegDu=mysqli_fetch_array($bdRegDu)){
		if(!$rowRegDu['fechaRegistro']){
			$fechaRegistro = $rowRegDu['fechaRegistro'];
		}
	}
	$link->close();

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

	<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	


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

<body ng-app="myApp" ng-controller="ctrlDoblados" ng-init="loadEnsayo('<?php echo $Otam; ?>')">
	<?php include('head.php'); ?>
	
	<nav class="navbar navbar-expand-lg navbar-dark bg-danger static-top">
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
	          			<a class="nav-link fa fa-home" href="../plataformaErp.php"> Principal
	                	<span class="sr-only">(current)</span>
	              		</a>
	        		</li>
	        		<li class="nav-item active" ng-show="ensayoDureza">
	          			<a class="nav-link fa fa-table" href="#" ng-click="tablaBrinell()"> Tabla Brinell</a>
	        		</li>
	        		<li class="nav-item active"  ng-show="bdBrinell">
	          			<a class="nav-link fa fa-table" href="#" ng-click="tablaEnsayo()"> Ensayo Dureza</a>
	        		</li>
	        		<li class="nav-item active">
						<?php 
							if($CodInforme){
								$fr = explode('-',$CodInforme);
								$RAM = $fr[1];
								?>
								<a class="nav-link fas fa-undo-alt"  href="../generarinformes2/edicionInformes.php?accion=Editar&CodInforme=<?php echo $CodInforme; ?>&RAM=<?php echo $CodInforme; ?>"> Volver</a>
							<?php
							}else{?>
	          					<a class="nav-link fas fa-undo-alt"  href="../tallerPM/pTallerPM.php"> Volver</a>
							<?php
							}
						?>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="../cerrarsesion.php"> Cerrar</a>
	        		</li>
	      		</ul>
	    	</div>
	  	</div>
	</nav>





	<div id="Cuerpo">
		<div id="CajaCpo">


			<!-- <form name="form" action="iDureza.php" method="get"> -->

			<div class="card m-2" ng-show="ensayoDureza">
    			<div class="card-header">
					<b>Ensayo de Dureza {{Otam}} RAM {{RAM}} CAM {{CAM}} {{tpMuestra}} </b>
					<p ng-if="factorY > 0">
						<!-- FORMULA: Ensayo {{tipoEnsayo}} <b>"y=(a*x)+b = ({{factorY}} * X) + {{constanteY}}"</b> -->
					</p>

				</div>
    			<div class="card-body">



					<div class="row">
						<div class="col-2">
							<div class="card m-2">
								<div class="card-header"><b>Fecha Ensayo</b></div>
								<div class="card-body">
									<input name="fechaRegistro" ng-change="registraDatosFijos()" ng-model="fechaRegistro" type="date" class="form-control">
								</div>
							</div>
						</div>
						<div class="col-7">
							<div class="card m-2">
								<div class="card-header"><b>Descripción de ensayo</b></div>
								<div class="card-body">
									<div class="row">
										<div class="col-2">
											<label for="Tipo">Tipo:</label> 
											<select ng-model="tpEnsayoDureza" class="form-control" ng-change="showTipoDureza()">
				                  				<option ng-repeat="tpEnsayoDureza in tipotpEnsayoDurezaData" value="{{tpEnsayoDureza.codEstado}}">
				                    			{{tpEnsayoDureza.descripcion}}
				                  				</option>
				              				</select>
										</div>
										<div class="col-2">
											<label for="Tipo">Escala:</label>
											<select class="form-control" ng-model="tpMuestra" id="tpMuestra"  ng-change="showGeo(tpMuestra)">
												<option ng-repeat="x in dataEscala" value="{{x.Escala}}">{{x.Escala}}</option>
											</select>
										</div>
										<div class="col-6" ng-show="showGeometria">
											<label for="Tipo">Geometría:</label>
											<!-- <input type="text" class="form-control"  name="Geometria" ng-model="Geometria" id="Geometria"> -->
											<select class="form-control" ng-model="Geometria" id="Geometria" ng-change="guardarGeometria()">
												<option ng-repeat="x in dataGeometria" value="{{x.Geometria}}">{{x.Geometria}}</option>
											</select>
										</div>
										<div class="col-2" ng-show="showCarga">
											<label for="cargaDureza">Carga:</label>
											<select ng-model="cargaDureza" id="cargaDureza" class="form-control" ng-change="guardarCargaDureza()">
				                  				<option ng-repeat="cargaDureza in dataCargaDureza" value="{{cargaDureza.codEstado}}">
				                    			{{cargaDureza.descripcion}}
				                  				</option>
				              				</select>

										</div>
										<div class="col-2" ng-show="showInicial">
											<label for="distanciaInicial">Distancia Inicial:</label>
											<input type="text" class="form-control"  name="distanciaInicial" ng-model="distanciaInicial" id="distanciaInicial" ng-change="guardarDistanciaInicial()" maxlength="5" size="5">
										</div>
										<div class="col-2" ng-show="showEntre">
											<label for="distanciaEntreInd">Entre Indenta.:</label>
											<input type="text" class="form-control"  name="distanciaEntreInd" ng-model="distanciaEntreInd" id="distanciaEntreInd" ng-change="guardarDistanciaEntreInd()" maxlength="5" size="5">
										</div>
										<div class="col-2">
											<label for="Tipo">Indentaciones:</label>
											<input type="text" class="form-control"  name="Ind" ng-model="Ind" id="Ind" ng-change="actualizarIndentacion()" maxlength="5" size="5">
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-3">
							<div class="card m-2">
								<div class="card-header"><b>Medio ambiente</b></div>
								<div class="card-body">
									<div class="row">
										<div class="col-6">
											<label for="RTmperatura">Temperatura:</label>
											<input type="text" class="form-control"  ng-change="registraDatosFijos()" name="Temperatura" ng-model="Temperatura" id="Temperatura" maxlength="10" size="10">
										</div>
										<div class="col-6">
											<label for="Tipo">Humedad:</label>
											<input type="text" class="form-control"  ng-change="registraDatosFijos()" name="Humedad" ng-model="Humedad" id="Humedad" maxlength="3" size="3">
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
					<div class="container-fluid">
						<div class="row">
							<div class="col-2">
									Técnico Responsable: {{tecRes}}<br> 
									<input class="form-control" name="tecRes" ng-model="tecRes"	type="hidden" ng-value="tecRes" readonly />
									
									<select tabindex="10" class="form-control" ng-model="tecRes" name="tecRes" ng-change="guardarTecRes()">
										<option value="GRC">GRC </option>
										<option value="SML">SML </option>
										<option value="RPM">RPM </option>
										<option value="AVR">AVR	</option>
										<option value="GRC">GRC	</option>
										<option value="CCE">CCE	</option>
									</select>	 
							</div>
							<div class="col-10">
								<div ng-show="showPuntualHR">
									<table class="table table-dark table-bordered text-center">
										<thead>
											<tr>
												<th align="center">Nº ID
												</th>
												<th>
													{{tpMuestra | uppercase}}															
												</th>
											</tr>
										</thead>
										<tbody>
												<tr ng-repeat="x in dataDurezas" class="table-secondary text-dark">
													<td style="width:10%">
														{{x.nIndenta}}
													</td>
													<td style="width:10%">
														<input class="form-control text-center" ng-change="valorIndentacion(x.nIndenta, vIndenta)" type="text" ng-model="vIndenta" ng-value="x.vIndenta">
														<!-- <input class="form-control text-center" ng-change="valorIndentacion(x.nIndenta, vIndenta)" type="text" ng-model="vIndenta" ng-value="x.vIndenta"> -->
													</td>
												</tr>
												<tr>
													<td></td>
													<td>{{mediaDu() | number:1}}</td>
												</tr>
											
										</tbody>
									</table>
								</div>
		
								<div ng-show="showPuntualHB">
									<table class="table table-dark table-bordered text-center">
										<thead>
											<tr>
												<th align="center">Nº ID
												</th>
												<th align="center">												
													Diametro de la huella (mm)
												</th>
												<th>
													{{tpMuestra | uppercase}}R														
												</th>
											</tr>
										</thead>
										<tbody>
												<tr ng-repeat="x in dataDurezas" class="table-secondary text-dark">
													<td style="width:10%">
														{{x.nIndenta}}
													</td>
													<td style="width:10%">
														<input class="form-control text-center" ng-change="calculoHuella(x.nIndenta, diametroHuella)" ng-value="x.diametroHuella" type="text" ng-model="diametroHuella">
													</td>
													<td style="width:10%">
														{{x.vIndenta}}
														<!-- <input class="form-control text-center" type="text" ng-model="vIndenta" ng-value="x.vIndenta" readonly> -->
													</td>
												</tr>
												<tr>
													<td></td>
													<td></td>
													<td>{{mediaDu() | number:1}}</td>
												</tr>
											
										</tbody>
									</table>
								</div>
		
								<div ng-show="showPerfilHR">
									<table class="table table-dark table-bordered text-center">
										<thead>
											<tr>
												<th align="center">Nº ID
												</th>
												<th align="center">
													Distancia desde superficie (mm)
												</th>
												<th>
													{{tpMuestra | uppercase}}															
												</th>
											</tr>
										</thead>
										<tbody>
												<tr ng-repeat="x in dataDurezas" class="table-secondary text-dark">
													<td style="width:10%">
														{{x.nIndenta}}
													</td>
													<td style="width:10%">
														{{x.Distancia}}
														<!-- <input class="form-control text-center" type="text" ng-model="Distancia" ng-value="x.Distancia" readonly> -->
													</td>
													<td style="width:10%">
														<input class="form-control text-center" ng-change="valorIndentacion(x.nIndenta, vIndenta)" type="text" ng-model="vIndenta" ng-value="x.vIndenta">
														<!-- <input class="form-control text-center" ng-change="valorIndentacion(x.nIndenta, vIndenta)" type="text" ng-model="vIndenta" ng-value="x.vIndenta"> -->
													</td>
												</tr>
												<tr>
													<td></td>
													<td></td>
													<td>{{mediaDu() | number:1}}</td>
												</tr>
											
										</tbody>
									</table>
								</div>
								
								<div ng-show="showPerfilHB">
									<table class="table table-dark table-bordered text-center">
										<thead>
											<tr>
												<th align="center">Nº ID
												</th>
												<th align="center">
													Distancia desde superficie (mm)
												</th>
												<th align="center">
													Diametro de la huella (mm)
												</th>
												<th>
													{{tpMuestra | uppercase}}R															
												</th>
											</tr>
										</thead>
										<tbody>
												<tr ng-repeat="x in dataDurezas" class="table-secondary text-dark">
													<td style="width:10%">
														{{x.nIndenta}}
													</td>
													<td style="width:10%">
														{{x.Distancia}}
														<!-- <input class="form-control text-center" type="text" ng-model="Distancia" ng-value="x.Distancia" readonly> -->
													</td>
													<td style="width:10%">
														<input class="form-control text-center" ng-change="calculoHuella(x.nIndenta, diametroHuella)" ng-value="x.diametroHuella" type="text" ng-model="diametroHuella">
													</td>
													<td style="width:10%">
														{{x.vIndenta}}
														<!-- <input class="form-control text-center" type="text" ng-model="vIndenta" ng-value="x.vIndenta" readonly> -->
													</td>
												</tr>
												<tr>
													<td></td>
													<td></td>
													<td></td>
													<td>{{mediaDu() | number:1}}</td>
												</tr>
											
										</tbody>
									</table>
								</div>
							</div>
						</div>

					</div>
				</div>
				<div class="card-footer">
					<a name="imprimirOtam" ng-if="tpEnsayoDureza == 'Medi'" ng-click="imprimirDureza()" class="btn btn-warning" title="Guardar Dureza" href="formularios/otamDureza.php?accion=Imprimir&Otam={{Otam}}" role="button">
					   Guardar
					</a>	
					<a name="imprimirOtam" ng-if="tpEnsayoDureza == 'Perf'" ng-click="imprimirDurezaPerfil()" class="btn btn-warning" title="Guardar Dureza" href="formularios/otamDurezaPerfil.php?accion=Imprimir&Otam={{Otam}}" role="button">
					   Guardar
					</a>	
				</div>
			</div>

			<div class="card m-2" ng-show="bdBrinell">
    			<div class="card-header">
					<b>Tabla Cargas Brinell </b>
				</div>
    			<div class="card-body">
					<div class="container">
						<table class="table table-dark table-bordered text-center">
							<thead>
								<tr>
									<th align="center">Diametro Bola</th>
									<th>3000</th>
									<th>1500</th>
									<th>1000</th>
									<th>500</th>
									<th>250</th>
									<th>125</th>
									<th>100</th>
									<th>Acción</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="x in dataCargas" class="table-secondary text-dark">
									<td>{{x.diametroBola}}</td>
									<td>{{x.c3000}}</td>
									<td>{{x.c1500}}</td>
									<td>{{x.c1000}}</td>
									<td>{{x.c500}}</td>
									<td>{{x.c250}}</td>
									<td>{{x.c125}}</td>
									<td>{{x.c100}}</td>
									<td>
										<button type="button" ng-click="editarCarga(x.diametroBola)" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
 										 	Editar
										</button>
									</td>
								</tr>								
							</tbody>
						</table>
					</div>
				<div class="card-footer"> 
					<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
 						Agregar
					</button>
					<button ng-click="tablaEnsayo()"  class="btn btn-info">Volver</button>	
				</div>
			</div>


			<!-- </form> --> 
		</div>



		<div style="clear:both;"></div>
				
	</div>
	
	<!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Registro Carga Brimell</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
 
	  	<table class="table table-dark table-hover">
    		<thead>
      			<tr class="text-center">
        			<th>Diametro Bola</th>
        			<th>3000</th>
        			<th>1500</th>
        			<th>1000</th>
        			<th>500</th>
        			<th>250</th>
        			<th>125</th>
        			<th>100</th>
      			</tr>
    		</thead>
			<tbody>
				<tr class="text-center">
					<td>
						<input class="form-control text-center"  type="text" ng-model="diametroBola">
					</td>
					<td>
						<input class="form-control text-center"  type="text" ng-model="c3000">
					</td>
					<td>
						<input class="form-control text-center"  type="text" ng-model="c1500">
					</td>
					<td>
						<input class="form-control text-center"  type="text" ng-model="c1000">
					</td>
					<td>
						<input class="form-control text-center"  type="text" ng-model="c500">
					</td>
					<td>
						<input class="form-control text-center"  type="text" ng-model="c250">
					</td>
					<td>
						<input class="form-control text-center"  type="text" ng-model="c125">
					</td>
					<td>
						<input class="form-control text-center"  type="text" ng-model="c100">
					</td>
				</tr>
    		</tbody>
  		</table>


      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-info" ng-click="guardarCarga()" data-bs-dismiss="modal">Guardar</button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

	<script type="text/javascript" src="../angular/angular.js"></script>
	<script src="../bootstrap/js/bootstrap.min.js"></script>
	<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>

	<script src="ensayosDureza.js"></script>

	
</body>
</html>
