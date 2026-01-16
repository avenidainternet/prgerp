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

	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
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

			<div class="card m-2">
    			<div class="card-header">
					<b>Ensayo de Dureza {{Otam}} RAM {{RAM}} CAM {{CAM}} </b>
					<p ng-if="factorY > 0">
						<!-- FORMULA: Ensayo {{tipoEnsayo}} <b>"y=(a*x)+b = ({{factorY}} * X) + {{constanteY}}"</b> -->
					</p>

					<?php
						// $aplicaFormula = 'No';
						// $factorY		= 0;
						// $constanteY		= 0;
						// $link=Conectarse();
						// $SQL = "SELECT * FROM OTAMs Where Otam = '".$Otam."'";
						// $bdOT=$link->query($SQL);
						// if($rowOT=mysqli_fetch_array($bdOT)){
						// 	$SQLMu = "SELECT * FROM amTpsMuestras Where idEnsayo = '".$rowOT['idEnsayo']."' and tpMuestra = '".$rowOT['tpMuestra']."'";
						// 	$bdTm=$link->query($SQLMu);
						// 	if($rowTm=mysqli_fetch_array($bdTm)){
						// 		if($rowTm['factorY'] > 0 and $rowTm['constanteY']){
						// 			$aplicaFormula 	= 'Si';
						// 			$factorY 		= $rowTm['factorY'];
						// 			$constanteY		= $rowTm['constanteY'];
						// 		}
						// 		// echo 'FORMULA: Ensayo '.$rowTm["tipoEnsayo"].'<b> "y=(a*x)+b = ('.$rowTm['factorY'].'*X)+'.$rowTm['constanteY'].'"</b>'; 
						// 	}
						// }
						// $link->close();
					?>
				</div>
    			<div class="card-body">
					<?php if($CodInforme){?>
						<input name="CodInforme" 	type="hidden" value="<?php echo $CodInforme; ?>">
						<input name="aplicaFormula" type="hidden" value="<?php echo $aplicaFormula; ?>">
						<input name="factorY" 		type="hidden" value="<?php echo $factorY; ?>">
						<input name="constanteY" 	type="hidden" value="<?php echo $constanteY; ?>">
					<?php } ?>
					<input name="Otam" type="hidden" 	value="<?php echo $Otam; ?>" />


					<?php
											$link=Conectarse();
											$bdOT=$link->query("SELECT * FROM OTAMs Where Otam = '".$Otam."'");
											if($rowOT=mysqli_fetch_array($bdOT)){
												$tpMuestra = $rowOT['tpMuestra'];
												$Ind = $rowOT['Ind'];
												$Tem = $rowOT['Tem'];
													?>

													<table class="table table-dark table-bordered text-center">
														<thead>
														<tr>
															<th colspan="<?php echo $Ind; ?>" align="center">Dureza<br>
														    	Rockwell <?php echo $Tem; ?>
															</th>
															<th>
																Promedio															
															</th>
														</tr>
														</thead>
														<tbody>
															<tr class="table-secondary text-dark">
																<td ng-repeat="x in dataDurezas">
																	<input class="form-control text-center" ng-change="valorIndentacion(x.nIndenta, vIndenta)" type="text" ng-model="vIndenta" ng-value="x.vIndenta">
																</td>
																<td> {{mediaDu() | number:1}} </td>
															</tr>
														</tbody>
														<br>
														<tr bgcolor="#FFFFFF" align="center">
															<?php
																$sIndenta 	= 0;
																$Media 		= 0;
																$vIndenta   = 0;
																for($in=1; $in<=$Ind; $in++) { 
																	$el_vIndenta	= 'vIndenta_'.$in.'-'.$Otam;
																	$el_nIndenta 	= 'nIndenta_'.$in.'-'.$Otam;
																	$bdRegDu=$link->query("SELECT * FROM regDoblado Where idItem = '".$Otam."' and nIndenta = '".$in."'");
																	if($rowRegDu=mysqli_fetch_array($bdRegDu)){
																		$nIndenta  = $rowRegDu['nIndenta'];
																		$vIndenta  = $rowRegDu['vIndenta'];
																	}
																	$sIndenta += $vIndenta;
																	$Media = $sIndenta / $in;
																	?>
																	<td height="30">
																		<input style="text-align:center;" class="form-control" name="<?php echo $el_vIndenta; ?>" id="<?php echo $el_vIndenta; ?>" 	type="text" size="5" maxlength="5" value="<?php echo $vIndenta; ?>" autofocus onKeyUp="myFunction();" />
																	</td>
																	<?php
																}
															?>
															<td>
																<?php //echo number_format($mDureza, 1, '.', ','); ?>
																<input class="form-control" name="Media" id="Media" 	type="text" size="9" maxlength="9" value="<?php echo number_format($Media, 1, '.', ','); ?>" readonly />
															</td>
														</tr>
														<?php if($aplicaFormula == 'Si'){?>
														<tr bgcolor="#FFFFFF" align="center">
															<?php
																$sIndenta 	= 0;
																$Media 		= 0;
																$cIndenta	= 0;
																for($in=1; $in<=$Ind; $in++) { 
																	$el_vIndenta	= 'vIndenta_'.$in.'-'.$Otam;
																	$el_vIndenta	= 'cIndenta_'.$in.'-'.$Otam;
																	$el_nIndenta 	= 'nIndenta_'.$in.'-'.$Otam;
																	$bdRegDu=$link->query("SELECT * FROM regDoblado Where idItem = '".$Otam."' and nIndenta = '".$in."'");
																	if($rowRegDu=mysqli_fetch_array($bdRegDu)){
																		$nIndenta  = $rowRegDu['nIndenta'];
																		$vIndenta  = $rowRegDu['vIndenta'];
																		$cIndenta  = $rowRegDu['cIndenta'];
																	}
																	$sIndenta += $cIndenta;
																	$Media = $sIndenta / $in;
																	?>
																	<td height="30">
																		<?php echo $cIndenta; ?>
																		<!-- <input style="text-align:center; border:0px solid #000;; background-color:#FFFFFF;;" name="<?php echo $el_vIndenta; ?>" id="<?php echo $el_vIndenta; ?>" 	type="text" size="5" maxlength="5" value="<?php echo $cIndenta; ?>" readonly /> -->
																	</td>
																	<?php
																}
															?>
															<td>
																<?php //echo number_format($mDureza, 1, '.', ','); ?>
																<input class="form-control" name="Media" id="Media" 	type="text" size="9" maxlength="9" value="<?php echo number_format($Media, 1, '.', ','); ?>" readonly />
															</td>
														</tr>
														<?php } ?>
														
													</table>
													<?php
										}
										$link->close();
										?>



					<div class="row">
						<div class="col-2">
							<div class="card m-2">
								<div class="card-header"><b>Fecha Ensayo</b></div>
								<div class="card-body">
									<input name="fechaRegistro" ng-model="fechaRegistro" type="date" class="form-control">
								</div>
							</div>
						</div>
						<div class="col-5">
							<div class="card m-2">
								<div class="card-header"><b>Descripción de ensayo</b></div>
								<div class="card-body">
									<div class="row">
										<div class="col-2">
											Tp.Ensayo
										</div>
										<div class="col-2">
											<select name="tpMuestra" class="form-control">
												<?php
													$tm = explode('-',$Otam);
													$idEnsayo = 'Du';
															
													$SQL = "SELECT * FROM amTpsMuestras Where idEnsayo = '".$idEnsayo."'";
															
													$link=Conectarse();
													$bdTm=$link->query($SQL);
													if($rowTm=mysqli_fetch_array($bdTm)){
														do{
															if($tpMuestra == $rowTm['tpMuestra']){?>
																<option selected 	value="<?php echo $rowTm['tpMuestra']; ?>"><?php echo $rowTm['Muestra']; ?></option>
															<?php 
															}else{ ?>
																<option  			value="<?php echo $rowTm['tpMuestra']; ?>"><?php echo $rowTm['Muestra']; ?></option>
															<?php 
															} 
														}while($rowTm=mysqli_fetch_array($bdTm));
													}
													$link->close();
												?>
											</select>
										</div>
										<div class="col-4">
											Indentaciones
										</div>
										<div class="col-4">
											<input type="text" name="Ind" ng-model="Ind" id="Ind" maxlength="5" size="5">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>


				</div>
				<div class="card-footer">
					<button ng-click="guardarDureza()" name="guardarIdOtam"  class="btn btn-info">Guardar</button>	
				</div>
			</div>


			<!-- </form> -->
		</div>




		<div style="clear:both;"></div>
				
	</div>
	<br>

	<script type="text/javascript" src="../angular/angular.js"></script>
	<script src="../jsboot/bootstrap.min.js"></script>
	<script src="ensayosDureza.js"></script>

	
</body>
</html>
