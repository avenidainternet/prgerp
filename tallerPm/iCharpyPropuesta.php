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
	$CodInforme = '';
	$Entalle	= 'Con';
	
	$CAM		= 0;
	$RAM		= 0;
	$mm			= 0.0;
	$vImpacto 	= 0;
	if(isset($_GET['accion'])) 		{	$accion 	= $_GET['accion']; 		}
	if(isset($_GET['Otam'])) 		{	$Otam 		= $_GET['Otam']; 		}
	if(isset($_GET['CodInforme']))	{	$CodInforme	= $_GET['CodInforme'];	}


	$link=Conectarse();
	$SQLd = "Select * From regcharpy Where idItem = '$Otam'"; 
	$bdd=$link->query($SQLd);
	if($rsd = mysqli_fetch_array($bdd)){
	}else{
		$fd = explode('-', $Otam);
		$id = $fd[0].'-'.$fd[1];
		$SQLe = "Select * From amtabensayos Where idItem = '$id' and idEnsayo = 'Ch'";
		$bde=$link->query($SQLe);
		if($rse = mysqli_fetch_array($bde)){
			$Ind 		= $rse['Ind'];
			$tpMuestra 	= $rse['tpMuestra'];
			$CodInforme	= $rse['CodInforme'];
			for($i=1; $i<=$Ind; $i++){
				$link->query("insert into regcharpy (
					CodInforme,
					idItem,
					tpMuestra,
					nImpacto
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










	if($CodInforme){
		// **************************************************************************
		// Crea carpetas tanto en AAA como en el Local si no existiesen
		// **************************************************************************
		$am = explode('-',$CodInforme);
		$ramAm = $am[1];
	}
	if($Otam){
		$am = explode('-',$Otam);
		$ramAm = $am[0];
	}
	if($ramAm){
		$agnoActual = date('Y'); 

		$directorioAM = 'Y://AAA/Archivador-'.$agnoActual.'/Laboratorio/Archivador-AM/'.$ramAm;
		$directorioAM = 'Y://AAA/LE/LABORATORIO/'.$agnoActual.'/'.$ramAm;
		if(!file_exists($directorioAM)){
			// mkdir($directorioAM);
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

	if(isset($_GET['guardarIdOtam'])){	
		$link=Conectarse();
		$bdOT=$link->query("Select * From OTAMs Where Otam = '".$Otam."'");
		if($rowOT=mysqli_fetch_array($bdOT)){

			$calA = 0.9061;
			//$calB = 2.7885;
			$calB = 0.7885;
			
			$bdCAL=$link->query("Select * From calibraciones Where idEnsayo = 'Ch'");
			if($rowCAL=mysqli_fetch_array($bdCAL)){
					$calA 			= $rowCAL['calA'];
					$calB 			= $rowCAL['calB'];
					$EquilibrioX 	= $rowCAL['EquilibrioX'];
					$calC 			= $rowCAL['calC'];
					$calD 			= $rowCAL['calD'];
			}
			$Estado 	= 'R';
			$tpMuestra 	= $rowOT['tpMuestra'];

			if(isset($_GET['tpMuestra'])) { $tpMuestra = $_GET['tpMuestra']; }
			
			$actSQL="UPDATE OTAMs SET ";
			$actSQL.="tpMuestra		='".$tpMuestra.	"',";
			$actSQL.="Estado		='".$Estado.	"'";
			$actSQL.="WHERE Otam 	= '".$Otam."'";
			$bdfRAM=$link->query($actSQL);

			$tm = explode('-',$Otam);
			$tReg = 'regCharpy';
			$Ind = 3;
			if(isset($_GET['Ind'])){ $Ind  = $_GET['Ind']; }
			$Ind = $rowOT['Ind'];
			for($in=1; $in<=$Ind; $in++) { 
				$el_nImpacto 	= 'nImpacto_'.$in.'-'.$Otam;
				$el_vImpacto	= 'vImpacto_'.$in.'-'.$Otam;
				$el_vAncho		= 'Ancho_'.$in.'-'.$Otam;
				$el_vAlto		= 'Alto_'.$in.'-'.$Otam;
				$el_vresEquipo	= 'resEquipo_'.$in.'-'.$Otam;
				if(isset($_GET[$el_nImpacto]))		{ $el_nImpacto		= $_GET[$el_nImpacto];		}
				if(isset($_GET[$el_vImpacto]))		{ $el_vImpacto		= $_GET[$el_vImpacto];		}
				if(isset($_GET[$el_vAncho]))		{ $el_vAncho		= $_GET[$el_vAncho];		}
				if(isset($_GET[$el_vAlto]))			{ $el_vAlto			= $_GET[$el_vAlto];			}
				if(isset($_GET[$el_vresEquipo]))	{ $el_vresEquipo	= $_GET[$el_vresEquipo];	}
				if(isset($_GET['mm']))				{ $mm				= $_GET['mm'];				}
				if(isset($_GET['Entalle']))			{ $Entalle			= $_GET['Entalle'];			}
				if(isset($_GET['Tem']))				{ $Tem				= $_GET['Tem'];				}
				if(isset($_GET['fechaRegistro']))	{ $fechaRegistro	= $_GET['fechaRegistro'];	}
				
				$y 	= 0;
				$criterio = 80;
				if($mm == 10 ) { $criterio = 80; }
				if($mm == 7.5) { $criterio = 60; } // 60
				if($mm == 6.7) { $criterio = 53.6; }
				if($mm == 5	 ) { $criterio = 40; }
				if($mm == 3.3) { $criterio = 26.4; }
				if($mm == 2.5) { $criterio = 20;  } 

				if($el_vresEquipo <= $EquilibrioX){
					// 15 <= 57.20
					if(($el_vAncho * $el_vAlto) > 0){
						// 10 * 15 = 150
						if($mm < 10 and $Entalle == 'Sin'){
							$Entalle = 'Con';
						}
						if($Entalle == 'Con'){
							$y = ($el_vresEquipo * $criterio) / ($el_vAncho * ($el_vAlto - 2));
							// y = (15 * 60) / (10 * (15 -2))
							// y = 900 / 130 = 6.92
						}
						if($Entalle == 'Sin'){
							$criterio = 100;
							$y = ($el_vresEquipo * $criterio) / ($el_vAncho * $el_vAlto);
						}
					}
					$vImpacto = ($calA * $y) + ($calB);
					// vImpacto = (1.0681 * 6.92) + (0.8145) = 8.21
				}
				if($el_vresEquipo > $EquilibrioX){
					if(($el_vAncho * $el_vAlto) > 0){
						if($mm < 10 and $Entalle == 'Sin'){
							$Entalle = 'Con';
						}
						if($Entalle == 'Con'){
							$y = ($el_vresEquipo * $criterio) / ($el_vAncho * ($el_vAlto - 2));
						}
						if($Entalle == 'Sin'){
							$criterio = 100;
							$y = ($el_vresEquipo * $criterio) / ($el_vAncho * $el_vAlto);
						}
					}
					$vImpacto = ($calC * $y) + ($calD);
				}
				
				$bdRegCh=$link->query("SELECT * FROM regCharpy Where idItem = '".$Otam."' and nImpacto = '".$in."'");
				if($rowRegCh=mysqli_fetch_array($bdRegCh)){
					$actSQL="UPDATE regCharpy SET ";
					$actSQL.="fechaRegistro ='".$fechaRegistro.	"',"; 
					$actSQL.="Ancho 	   	='".$el_vAncho.		"',";
					$actSQL.="Alto 	   		='".$el_vAlto.		"',";
					$actSQL.="mm   			='".$mm.			"',";
					$actSQL.="Tem			='".$Tem.			"',";
					$actSQL.="Entalle		='".$Entalle.		"',";
					$actSQL.="resEquipo   	='".$el_vresEquipo.	"',";
					$actSQL.="vImpacto 	   	='".$vImpacto.		"'";
					$actSQL.="WHERE idItem 	= '".$Otam."' and nImpacto = '".$in."'";
					$bdRegCh=$link->query($actSQL);
					
					$actSQL="UPDATE regCharpy SET ";
					$actSQL.="Entalle		='".$Entalle.		"'";
					$actSQL.="WHERE idItem 	= '".$Otam."'";
					$bdRegCh=$link->query($actSQL);
				}else{
					$link->query("insert into regCharpy(
															CodInforme,
															idItem,
															tpMuestra,
															fechaRegistro,
															Alto,
															Ancho,
															mm,
															Entalle,
															Tem,
															resEquipo,
															nImpacto,
															vImpacto
															) 
													values 	(	
															'$CodInforme',
															'$Otam',
															'$tpMuestra',
															'$fechaRegistro',
															'$el_vAlto',
															'$el_vAncho',
															'$mm',
															'$Entalle',
															'$Tem',
															'$el_vresEquipo',
															'$in',
															'$vImpacto'
							)");
				}
			}
				
		}
		$link->close();
		$accion = '';
	}
	$fechaRegistro = date('Y-m-d');
	$link=Conectarse();
	$fechaRegistro = date('Y-m-d');
	
	$bdRegDu=$link->query("SELECT * FROM regCharpy Where idItem = '$Otam'");
	if($rowRegDu=mysqli_fetch_array($bdRegDu)){
		if($rowRegDu['fechaRegistro']){
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

    <link rel="stylesheet" type="text/css" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">

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
	
	function volver(){
		history.go(-1);
	}

	</script>

</head>

<body ng-app="myApp" ng-controller="CtrlImpactos" ng-init="Otam='<?php echo $Otam; ?>'">
    <input ng-model="accion" 	type="hidden" 	ng-init="iniciaVariables('<?php echo $Otam; ?>')">
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
				  	<?php
						if($_SESSION['IdPerfil'] != 5){
						?>
	        			<li class="nav-item active">
	          				<a class="nav-link fa fa-home" href="../plataformaErp.php"> Principal
	                		<span class="sr-only">(current)</span>
	              			</a>
	        			</li>
					<?php } ?>
					<!--
	        		<li class="nav-item active">
	          			<a class="nav-link fa fa-home" href="pTallerPM.php"> Ensayo</a>
	        		</li>
					-->
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

	<style>
		.contenedor{
			margin-bottom: 20px;
			background: #0d6efd;
			color: #fff;
			margin:5px;
		}
		.contenedor > div{
			background: rgba(255, 255, 255, .2);
			padding: 15px;
			border: 1px solid #0d6efd;
		}
	</style>

<div class="container-fluid">
	<div class="card m-2">
    	<div class="card-header">
			<b>Ensayo de Charpy <?php echo $Otam; ?></b>
		</div>
    	<div class="card-body">
			<div class="row">
				<div class="col">
					<div class="contenedor d-md-flex">
						<div class="col">
							Fecha Ensayo
							<div class="contenedor d-md-flex">
								<div class="col">
									<input class="form-control" type="date" ng-model="fechaRegistro" tabindex="1" ng-change="cambiaFecha()">
								</div>
								<div class="col">Equipo<br>
								
									<select class="form-control" ng-model="Equipo" ng-change="guardarRegEquipo(Equipo)">
        								<option value="Imp-01">Imp-01</option>
        								<option value="Imp-02">Imp-02</option>
    								</select>

								</div>
								<div class="col">Tº Enss.</div>
								<div class="col"><input class="form-control" type="text" tabindex="2" ng-model="Tem" ng-change="cambiaTem()"></div>
								<div class="col">Tº Amb.</div>
								<div class="col"><input class="form-control" type="text" tabindex="3" ng-model="TemAmb" ng-change="cambiaTemAmb()"></div>
								<div class="col">% Hum.</div>
								<div class="col"><input class="form-control" type="text" tabindex="4" ng-model="Hum" ng-change="cambiaHum()"></div>
							</div>
						</div>
						<div class="col">
							Descripción del Ensayo
							<div class="contenedor d-md-flex">
								<div class="col">TpEnsayo</div>
								<div class="col"><input class="form-control" type="text" ng-model="tpMuestra" readonly></div>
								<div class="col">Impactos</div>
								<div class="col"><input class="form-control" type="text" ng-model="nImpacto" readonly ></div>
								<div class="col">Entalle</div>
								<div class="col">
									<select tabindex="5" class="form-control" ng-model="Entalle" ng-change="cambiaEntalle()">
										<option value="Con">Con</option>
										<option value="Sin">Sin</option>
									</select>
								</div>
								<div class="col">Tamaño</div>
								<div class="col">
									<!-- <input class="form-control" type="text" ng-model="mm" > -->
									<!-- <select class="form-control" id="mm" ng-model="mm">
										<option value=""></option>
										<option ng-repeat="x in dataMilimetros" value="x.dataMm">{{x.descripcion}}</option>
									</select> -->

									<select class="form-control" ng-model="mm" ng-change="cambiaMm()">
										<option value="10.0">10.0 </option>
										<option value="7.5">7.5 </option>
										<option value="6.7">6.7	</option>
										<option value="5.0">5.0	</option>
										<option value="3.3">3.3	</option>
										<option value="2.5">2.5	</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="contenedor d-md-flex">
						<div class="col">
							Registro de Impactos
							<div class="row p-2">
								<table class="table table-dark table-hover table-bordered">
									<thead>
										<tr>
											<th scope="col">
												Id.Impacto
											</th>
											<th scope="col" title="Costado de la probeta">
												Costado < 4Ra
											</th>
											<th scope="col" title="Caras del entalle">
												Entalle < 2 Ra		
											</th>
											<th scope="col" title="La probeta mide 55 +0/ -2,5 mm">
												Probeta 55 +0/-2,5mm			
											</th>
											<th scope="col" title="El centro del entalle está a 27 +/- 1 mm">
												Centro entalle  27 +/-1mm
											</th>
											<th scope="col" title="El ángulo del entalle de es 45º +/- 1º">
												Ángulo entalle  45º +/-1º	
											</th>
											<th scope="col" title="La profundidad del entalle de es 2 mm">
												Prof. entalle 2mm	
											</th>
											<th scope="col" title="El radio de curvatura es de 0,25 mm +/- 0.025 mm">
												Curv. 0,25mm +/-0.025mm
											</th>
											<th scope="col">Ancho</th>
											<th scope="col">Alto</th>
											<th scope="col">Equipo</th>
											<?php if($_SESSION['IdPerfil'] != 5){?>
												<th scope="col" ng-show="mostrarValImpacto">Energía</th>
											<?php } ?>
										</tr>
									</thead>
									<tbody class="table-striped">
										<?php $tabindex = 6; ?>
										<tr class="table-primary text-center" ng-repeat="x in dataImpactos">
											
											<th scope="row"> 
												<div ng-if="x.actCheck == 1">
													<a href="#" type="button" class="btn btn-primary" ng-click="activarDesactivar(x.nImpacto)">{{x.nImpacto}}</a>
												</div>
												<div ng-if="x.actCheck == 0">
													<a href="#" type="button" class="btn btn-danger" ng-click="activarDesactivar(x.nImpacto)">{{x.nImpacto}}</a>
												</div>
											</th>
											<td>
												<div ng-if="x.CosProbMen4Ra == 'on'">
													<input class="form-check-input" type="checkbox" ng-model="CosProbMen4Ra" ng-init="CosProbMen4Ra=true" ng-change="guardarReg4Ra(CosProbMen4Ra, x.nImpacto)">
												</div>
												
												<div ng-if="x.CosProbMen4Ra != 'on'">
													<input class="form-check-input" type="checkbox" ng-model="CosProbMen4Ra" ng-init="CosProbMen4Ra=false" ng-change="guardarReg4Ra(CosProbMen4Ra, x.nImpacto)">
												</div>
											</td>
											<td>
												<div ng-if="x.CarEntMen2Ra == 'on'">
													<input class="form-check-input" type="checkbox" ng-model="CarEntMen2Ra" ng-init="CarEntMen2Ra=true" ng-change="guardarReg2Ra(CarEntMen2Ra, x.nImpacto)">
												</div>
												
												<div ng-if="x.CarEntMen2Ra != 'on'">
													<input class="form-check-input" type="checkbox" ng-model="CarEntMen2Ra" ng-init="CarEntMen2Ra=false" ng-change="guardarReg2Ra(CarEntMen2Ra, x.nImpacto)">
												</div>
											</td>
											<td>
												<div ng-if="x.Prob55 == 'on'">
													<input class="form-check-input" type="checkbox" ng-model="Prob55" ng-init="Prob55=true" ng-change="guardarReg55(Prob55, x.nImpacto)">
												</div>
												
												<div ng-if="x.Prob55 != 'on'">
													<input class="form-check-input" type="checkbox" ng-model="Prob55" ng-init="Prob55=false" ng-change="guardarReg55(Prob55, x.nImpacto)">
												</div>
											</td>
											<td>
												<div ng-if="x.CentEnt27 == 'on'">
													<input class="form-check-input" type="checkbox" ng-model="CentEnt27" ng-init="CentEnt27=true" ng-change="guardarReg27(CentEnt27, x.nImpacto)">
												</div>
												
												<div ng-if="x.CentEnt27 != 'on'">
													<input class="form-check-input" type="checkbox" ng-model="CentEnt27" ng-init="CentEnt27=false" ng-change="guardarReg27(CentEnt27, x.nImpacto)">
												</div>
											</td>
											<td>
												<div ng-if="x.AngEnt45 == 'on'">
													<input class="form-check-input" type="checkbox" ng-model="AngEnt45" ng-init="AngEnt45=true" ng-change="guardarReg45(AngEnt45, x.nImpacto)">
												</div>
												
												<div ng-if="x.AngEnt45 != 'on'">
													<input class="form-check-input" type="checkbox" ng-model="AngEnt45" ng-init="AngEnt45=false" ng-change="guardarReg45(AngEnt45, x.nImpacto)">
												</div>
											</td>
											<td>
												<div ng-if="x.ProfEnt2mm == 'on'">
													<input class="form-check-input" type="checkbox" ng-model="ProfEnt2mm" ng-init="ProfEnt2mm=true" ng-change="guardarReg2mm(ProfEnt2mm, x.nImpacto)">
												</div>
												
												<div ng-if="x.ProfEnt2mm != 'on'">
													<input class="form-check-input" type="checkbox" ng-model="ProfEnt2mm" ng-init="ProfEnt2mm=false" ng-change="guardarReg2mm(ProfEnt2mm, x.nImpacto)">
												</div>
											</td>
											<td>
												<div ng-if="x.RadCorv025 == 'on'">
													<input class="form-check-input" type="checkbox" ng-model="RadCorv025" ng-init="RadCorv025=true" ng-change="guardarReg025(RadCorv025, x.nImpacto)">
												</div>
												
												<div ng-if="x.RadCorv025 != 'on'"> 
													<input class="form-check-input" type="checkbox" ng-model="RadCorv025" ng-init="RadCorv025=false" ng-change="guardarReg025(RadCorv025, x.nImpacto)">
												</div>
											</td>

											<td>												
												<input tabindex="{{$index + 6}}" type="text" maxlength="5" size="5"  ng-model="x.Ancho"   ng-change="guardarRegAnc(x.Ancho, x.nImpacto)">
											</td>
											<td>
												<input tabindex="{{$index + 6}}" type="text" maxlength="5" size="5" ng-model="x.Alto"   ng-change="guardarRegAlt(x.Alto, x.nImpacto)">
											</td>
											<td>
												<input tabindex="{{$index + 6}}" type="text" maxlength="5" size="5" ng-model="x.resEquipo"   ng-change="guardarRegEqui(x.resEquipo, x.nImpacto)">
											</td>
											<?php if($_SESSION['IdPerfil'] != 5){?>
												<td ng-show="mostrarValImpacto">{{x.vImpacto}}</td>
											<?php } ?>
										</tr>
									</tbody>
									<tfoot class="table-primary">
										<tr class="text-center">
											<td colspan="2">
												Técnico Responsable<br>
												<select tabindex="10" class="form-control" ng-model="tecRes" ng-change="cambiaTecRes()">
													<option value="GRC">GRC </option>
													<option value="RPM">RPM </option>
													<option value="AVR">AVR	</option>
													<option value="RCG">RCG	</option>
												</select>

											</td>
											<td colspan="8">
												<p class="text-left"><b>Observaciones</b></p>

												<textarea tabindex="11" class="form-control" ng-model="ObsOtam" rows="3" ng-change="cambiaObs()"></textarea>
											</td>
											<td><B ng-show="mostrarValImpacto">MEDIA</B></td>
											<?php if($_SESSION['IdPerfil'] != 5){?>
												<td ng-show="mostrarValImpacto">{{getMedia() | number : 2}}</td>
											<?php } ?>
										</tr>
										<tr class="text-center">
											<td colspan="12">
												<?php
												$fr = explode('-', $Otam);
												$RAM = $fr[0];
												?>
												<a tabindex="12" class="btn btn-primary" target="_blank" ng-click="Actualizando()" href="formularios/otamCharpy.php?accion=Imprimir&RAM=<?php echo $RAM; ?>&Otam={{Otam}}&CodInforme=<?php echo $CodInforme; ?>" role="button">
													<i class="fas fa-calculator"></i> 
													Guardar / actualizar registro de ensayo
												</a>
												<?php if($_SESSION['IdPerfil'] == 5){?>
													<button type="button" class="btn btn-danger" ng-click="cerrarEnsayo()">
														<i class="fas fa-calculator"></i>
														<b>Cerrar Ensayo</b>
													</button>
													<?php
												}
												?>
												<?php if($_SESSION['IdPerfil'] == 1){?>
													<button type="button" class="btn btn-danger" ng-click="cerrarEnsayoIngeniero()">
														<i class="fas fa-calculator"></i>
														<b>Cerrar Ensayo</b>
													</button>
													<?php
												}
												?>
											</td>
										</tr>

									</tfoot>
								</table>						
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<!--
	<div id="Cuerpo">
		<div id="CajaCpo">



			<form name="form" action="iCharpy.php" method="get">


			<div class="card m-2">
    			<div class="card-header">
					<b>Ensayo de Charpy <?php echo $Otam; ?></b>
				</div>
    			<div class="card-body">



				<input name="CodInforme" type="hidden" 	value="<?php echo $CodInforme; ?>" />
				<input name="Otam" type="hidden" 	value="<?php echo $Otam; ?>" />
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top" style="padding:5px;">
						<?php
							$link=Conectarse();
							$bdOT=$link->query("SELECT * FROM OTAMs Where Otam = '".$Otam."'");
							if($rowOT=mysqli_fetch_array($bdOT)){
								$tpMuestra 	= $rowOT['tpMuestra'];
								$Ind 		= $rowOT['Ind'];
								$Tem 		= $rowOT['Tem'];
								?>
								<table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #ccc; margin-top:5px;" align="center">
									<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
										<td colspan="<?php echo $Ind+1; ?>" align="center">Energía de impacto a <?php echo $Tem; ?><br>
											(Joule) 
										</td>
									</tr>
									<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
										<?php for($in=1; $in<=$Ind; $in++) { ?>
											<td align="center">
												Muestra <?php echo 'N° '.$in; ?>
											</td>
										<?php } ?>
										<td align="center">
											&nbsp;&nbsp;
										</td>
									</tr>
									<tr bgcolor="#FFFFFF" align="center">
										<?php
											$sImpactos 	= 0;
											$Media 		= 0;
											for($in=1; $in<=$Ind; $in++) { 
												$el_vImpacto	= 'vImpacto_'.$in.'-'.$Otam;
												$el_nImpacto 	= 'nImpacto_'.$in.'-'.$Otam;
												$el_vAncho 		= 'Ancho_'.$in.'-'.$Otam;
												$el_vAlto 		= 'Alto_'.$in.'-'.$Otam;
												$el_vresEquipo 	= 'resEquipo_'.$in.'-'.$Otam;
												$vAncho = '';
												$vAlto = '';
												$vresEquipo = '';
												$mm = '';
												$Entalle = '';
												$bdRegCh=$link->query("SELECT * FROM regCharpy Where idItem = '".$Otam."' and nImpacto = '".$in."'");
												if($rowRegCh=mysqli_fetch_array($bdRegCh)){
													$nImpacto  	= $rowRegCh['nImpacto'];
													$vImpacto  	= $rowRegCh['vImpacto'];
													$vAncho  	= $rowRegCh['Ancho'];
													$vAlto  	= $rowRegCh['Alto'];
													$vresEquipo = $rowRegCh['resEquipo'];
													$mm 		= $rowRegCh['mm'];
													$Entalle 	= $rowRegCh['Entalle'];
													$Tem 		= $rowRegCh['Tem'];
												}
												?>
												<td height="30">
													Ancho<br>
													<input style="text-align:center;" name="<?php echo $el_vAncho; ?>" 		id="<?php echo $el_vAncho; ?>" 		type="text" size="5" maxlength="5" value="<?php echo $vAncho; ?>" autofocus /><br>
													Alto<br>
													<input style="text-align:center;" name="<?php echo $el_vAlto; ?>" 		id="<?php echo $el_vAlto; ?>" 		type="text" size="5" maxlength="5" value="<?php echo $vAlto; ?>"   			/><br>
													Equipo<br>
													<input style="text-align:center;" name="<?php echo $el_vresEquipo; ?>" 	id="<?php echo $el_vresEquipo; ?>" 	type="text" size="5" maxlength="5" value="<?php echo $vresEquipo; ?>"   	/>
												</td>
												<?php
											}
										?>
										<td>
											&nbsp;&nbsp;
										</td>
									</tr>
								</table>

								<table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #ccc; margin-top:5px;" align="center">
									<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
										<td colspan="<?php echo $Ind+1; ?>" align="center">Energía de impacto a <?php echo $Tem; ?><br>
											(Joule) 
										</td>
									</tr>
									<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
										<?php for($in=1; $in<=$Ind; $in++) { ?>
											<td align="center">
												Muestra <?php echo 'N° '.$in; ?>
											</td>
										<?php } ?>
										<td align="center">
											Promedio
										</td>
									</tr>
									<tr bgcolor="#FFFFFF" align="center">
										<?php
											$sImpactos 	= 0;
											$Media 		= 0;
											for($in=1; $in<=$Ind; $in++) { 
												$el_vImpacto	= 'vImpacto_'.$in.'-'.$Otam;
												$el_nImpacto 	= 'nImpacto_'.$in.'-'.$Otam;
												$bdRegCh=$link->query("SELECT * FROM regCharpy Where idItem = '".$Otam."' and nImpacto = '".$in."'");
												if($rowRegCh=mysqli_fetch_array($bdRegCh)){
													$nImpacto  = $rowRegCh['nImpacto'];
													$vImpacto  = $rowRegCh['vImpacto'];
												}
												$sImpactos += $vImpacto;
												$Media = $sImpactos / $in;
												?>
												<td height="30" style="font-size:22px; font-weight:700;">
													<?php echo $vImpacto; ?>
												</td>
												<?php
											}
										?>
										<td>
											<?php //echo number_format($mDureza, 1, '.', ','); ?>
											<input style="text-align:center;" name="Media" id="Media" 	type="text" size="9" maxlength="9" value="<?php echo number_format($Media, 1, '.', ','); ?>" readonly />
										</td>
									</tr>
								</table>
							<?php
							}
							$link->close();
						?>
					</td>
					<td valign="top" style="padding:5px; ">
						<table align="center" width="100%" style="border:1px solid #999; color:#FFFFFF;">
							<tr bgcolor="#666666">
								<td height="40" colspan="2" align="center">Descripci&oacute;n Ensayo</td>
							</tr>
							<tr>
								<td height="40" style="color:#333333;">Tp.Ensayo</td>
								<td>
									<select name="tpMuestra">
										<?php
											$tm = explode('-',$Otam);
											$idEnsayo = 'Ch';
													
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
								</td>
							</tr>
							<tr>
								<td height="40" style="color:#333333;">
									Impactos
								</td>
								<td>
									<input type="text" name="Ind" id="Ind" maxlength="5" size="5" value="<?php echo $Ind; ?>">
								</td>
							</tr>
							<tr>
								<td height="40" style="color:#333333;">T&deg;</td>
								<td>
									<input type="text" name="Tem" id="Tem" maxlength="10" size="10" value="<?php echo $Tem; ?>">
								</td>
							</tr>
							<tr>
								<td height="40" style="color:#333333;">Entalle</td> 
									<td>
										<select name="Entalle" id="Entalle">
											<?php if($Entalle ==  'Con') { ?>
														<option selected 	value="Con">Con Entalle </option>
														<option 			value="Sin">Sin Entalle </option>
											<?php 	}else{
														if($Entalle == 'Sin'){ ?>
															<option  			value="Con">Con Entalle </option>
															<option selected	value="Sin">Sin Entalle </option>
											<?php 		}else{ ?>
															<option value="Con">Con Entalle </option>
															<option value="Sin">Sin Entalle </option>
														<?php
														}
													} 
											?>
										</select>
									</td>
								</tr>
								<tr>
									<td height="40" style="color:#333333;">Tamaño</td> 
									<td>
										<select name="mm" id="mm">
											<?php if($mm ==  10) { ?>
														<option selected 	value="10">	10 </option>
														<option 			value="7.5">7.5 </option>
														<option 			value="6.7">6.7	</option>
														<option 			value="5">	5	</option>
														<option 			value="3.3">3.3	</option>
														<option 			value="2.5">2.5	</option>
											<?php }else{ ?>
											<?php if($mm == 7.5){ ?>
														<option 		 	value="10">	10 </option>
														<option selected	value="7.5">7.5 </option>
														<option 			value="6.7">6.7	</option>
														<option 			value="5">	5	</option>
														<option 			value="3.3">3.3	</option>
														<option 			value="2.5">2.5	</option>
											<?php }else{; ?>
											<?php if($mm == 6.7){?>
														<option 		 	value="10">	10 </option>
														<option 			value="7.5">7.5 </option>
														<option selected	value="6.7">6.7	</option>
														<option 			value="5">	5	</option>
														<option 			value="3.3">3.3	</option>
														<option 			value="2.5">2.5	</option>
											<?php }else{ ?>
											<?php if($mm == 5){ ?>
														<option 		 	value="10">	10 </option>
														<option 			value="7.5">7.5 </option>
														<option 			value="6.7">6.7	</option>
														<option selected	value="5">	5	</option>
														<option 			value="3.3">3.3	</option>
														<option 			value="2.5">2.5	</option>
											<?php }else{; ?>
											<?php if($mm == 3.3) {?>
														<option 		 	value="10">	10 </option>
														<option 			value="7.5">7.5 </option>
														<option 			value="6.7">6.7	</option>
														<option 			value="5">	5	</option>
														<option selected 	value="3.3">3.3	</option>
														<option 			value="2.5">2.5	</option>
											<?php }else{; ?>
											<?php if($mm == 2.5){?>
														<option 		 	value="10">	10 </option>
														<option 			value="7.5">7.5 </option>
														<option 			value="6.7">6.7	</option>
														<option 			value="5">	5	</option>
														<option 		 	value="3.3">3.3	</option>
														<option selected	value="2.5">2.5	</option>
											<?php }else{ ?>
														<option selected 	value="10">	10 </option>
														<option 			value="7.5">7.5 </option>
														<option 			value="6.7">6.7	</option>
														<option 			value="5">	5	</option>
														<option 		 	value="3.3">3.3	</option>
														<option 			value="2.5">2.5	</option>
											<?php }}}}}} ?>
										</select>
									</td>
								</tr>
								
								
						</table>
					</td>
				</tr>
			</table>



				<div class="row">
					<div class="col-2">
						<div class="card m-2">
							<div class="card-header"><b>Fecha Ensayo</b></div>
							<div class="card-body">
								<input name="fechaRegistro" type="date" class="form-control" value="<?php echo $fechaRegistro; ?>">
							</div>
						</div>
					</div>
				</div>


				</div>
    			<div class="card-footer">
					<button type="submit" name="guardarIdOtam"  class="btn btn-info">Guardar</button>	
				</div>
			</div>


			</form>
		</div>
		<img src="Charpy.jpg"> 
				
	</div>
	<br>
-->

	<script type="text/javascript" src="../angular/angular.js"></script>
	<script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
	<script src="CharpyPropuesta.js"></script>
	
	
</body> 
</html>
