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
	$CAM 		= 0;
	$RAM		= 0;
	$accion		= '';
	
	$tpMuestra	= '';
	$cC			= '';
	$cSi		= '';
	$cMn		= '';
	$cP			= '';
	$cS			= '';
	$cCr		= '';
	$cNi		= '';
	$cMo		= '';
	$cAl		= '';
	$cCu		= '';
	$cCo		= '';
	$cTi		= '';
	$cNb		= '';
	$cV			= '';
	$cW			= 0;
	$cPb		= 0;
	$cB			= '';
	$cSb		= 0;
	$cSn		= 0;
	$cZn		= 0;
	$cAs		= 0;
	$cBi		= 0;
	$cTa		= 0;
	$cCa		= 0;
	$cCe		= 0;
	$cZr		= 0;
	$cLa		= 0;
	$cSe		= 0;
	$cN			= 0;
	$cFe		= 0;
	$cMg		= 0;
	$cTe		= 0;
	$cCd		= 0;
	$cAg		= 0;
	$cAi 		= 0;
	$cAu		= 0;
	$Observacion		= '';
	$Temperatura		= '';
	$Humedad			= '';
	$fechaRegistro = date('Y-m-d'); 

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

	if(isset($_GET['guardarIdOtam']) or isset($_GET['guardarOtam']) or isset($_GET['guardarOtamPrecaucion'])){	
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
			if($rowOT['idEnsayo'] == 'Qu') { $tReg = 'regQuimico'; 		}
			
			
			if(isset($_GET['aIni'])) { $aIni = $_GET['aIni']; 		}
			if(isset($_GET['cFlu'])) { $cFlu = $_GET['cFlu']; 		}
			if(isset($_GET['cMax'])) { $cMax = $_GET['cMax']; 		}
			if(isset($_GET['tFlu'])) { $tFlu = $_GET['tFlu']; 		}
			if(isset($_GET['tMax'])) { $tMax = $_GET['tMax']; 		}
			if(isset($_GET['aSob'])) { $aSob = $_GET['aSob']; 		}
			if(isset($_GET['rAre'])) { $rAre = $_GET['rAre']; 		}

			if(isset($_GET['cC'])) { $cC 	= $_GET['cC']; }
			if(isset($_GET['cSi'])){ $cSi  	= $_GET['cSi'];}
			if(isset($_GET['cMn'])){ $cMn  	= $_GET['cMn'];}
			if(isset($_GET['cP'])) { $cP  	= $_GET['cP']; }
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
			if(isset($_GET['Observacion']))	{ $Observacion  	= $_GET['Observacion'];	}
			if(isset($_GET['Temperatura']))	{ $Temperatura  	= $_GET['Temperatura'];	}
			if(isset($_GET['Humedad']))		{ $Humedad  		= $_GET['Humedad'];		}
			if(isset($_GET['fechaRegistro']))	{ $fechaRegistro	= $_GET['fechaRegistro'];	}

			if(isset($_GET['Ind'])){ $Ind  = $_GET['Ind'];}

			if($rowOT['idEnsayo'] == 'Qu'){
				$Precaucion = 'off';
				if(isset($_GET['guardarOtamPrecaucion'])){
					$Precaucion = 'on';
				}

				$bdRdM=$link->query("Select * From $tReg Where idItem = '".$Otam."'");
				if($rowRdM=mysqli_fetch_array($bdRdM)){
						if($rowRdM['Precaucion']){
							$Precaucion = $rowRdM['Precaucion'];
						}
						$actSQL="UPDATE $tReg SET ";
						$actSQL.="tpMuestra		='".$tpMuestra.		"',";
						$actSQL.="Precaucion	='".$Precaucion.	"',";
						$actSQL.="cC			='".$cC.			"',";
						$actSQL.="cSi			='".$cSi.			"',";
						$actSQL.="cMn			='".$cMn.			"',";
						$actSQL.="cP			='".$cP.			"',";
						$actSQL.="cS			='".$cS.			"',";
						$actSQL.="cCr			='".$cCr.			"',";
						$actSQL.="cNi			='".$cNi.			"',";
						$actSQL.="cMo			='".$cMo.			"',";
						$actSQL.="cAl			='".$cAl.			"',";
						$actSQL.="cCu			='".$cCu.			"',";
						$actSQL.="cCo			='".$cCo.			"',";
						$actSQL.="cTi			='".$cTi.			"',";
						$actSQL.="cNb			='".$cNb.			"',";
						$actSQL.="cV			='".$cV.			"',";
						$actSQL.="cW			='".$cW.			"',";
						$actSQL.="cPb			='".$cPb.			"',";
						$actSQL.="cB			='".$cB.			"',";
						$actSQL.="cSb			='".$cSb.			"',";
						$actSQL.="cSn			='".$cSn.			"',";
						$actSQL.="cZn			='".$cZn.			"',";
						$actSQL.="cAs			='".$cAs.			"',";
						$actSQL.="cBi			='".$cBi.			"',";
						$actSQL.="cTa			='".$cTa.			"',";
						$actSQL.="cCa			='".$cCa.			"',";
						$actSQL.="cCe			='".$cCe.			"',";
						$actSQL.="cZr			='".$cZr.			"',";
						$actSQL.="cLa			='".$cLa.			"',";
						$actSQL.="cSe			='".$cSe.			"',";
						$actSQL.="cN			='".$cN.			"',";
						$actSQL.="cFe			='".$cFe.			"',";
						$actSQL.="cMg			='".$cMg.			"',";
						$actSQL.="cTe			='".$cTe.			"',";
						$actSQL.="cCd			='".$cCd.			"',";
						$actSQL.="cAg			='".$cAg.			"',";
						$actSQL.="cAu			='".$cAu.			"',";
						$actSQL.="cAi			='".$cAi.			"',";
						$actSQL.="Temperatura	='".$Temperatura.	"',";
						$actSQL.="Humedad		='".$Humedad.		"',";
						$actSQL.="Observacion 	='".$Observacion.	"',";
						$actSQL.="fechaRegistro	='".$fechaRegistro.	"'";
						$actSQL.="WHERE idItem = '".$Otam."'";
						$bdRdM=$link->query($actSQL);
				}else{
						$link->query("insert into $tReg (
																CodInforme,
																idItem,
																tpMuestra,
																Precaucion,
																cC,
																cSi,
																cMn,
																cP,
																cS,
																cCr,
																cNi,
																cMo,
																cAl,
																cCu,
																cCo,
																cTi,
																cNb,
																cV,
																cW,
																cPb,
																cB,
																cSb,
																cSn,
																cZn,
																cAs,
																cBi,
																cTa,
																cCa,
																cCe,
																cZr,
																cLa,
																cSe,
																cN,
																cFe,
																cMg,
																cTe,
																cCd,
																cAg,
																cAu,
																cAi,
																Temperatura,
																Humedad,
																Observacion,
																fechaRegistro
																) 
														values 	(	
																'$CodInforme',
																'$Otam',
																'$tpMuestra',
																'$Precaucion',
																'$cC',
																'$cSi',
																'$cMn',
																'$cP',
																'$cS',
																'$cCr',
																'$cNi',
																'$cMo',
																'$cAl',
																'$cCu',
																'$cCo',
																'$cTi',
																'$cNb',
																'$cV',
																'$cW',
																'$cPb',
																'$cB',
																'$cSb',
																'$cSn',
																'$cZn',
																'$cAs',
																'$cBi',
																'$cTa',
																'$cCa',
																'$cCe',
																'$cZr',
																'$cLa',
																'$cSe',
																'$cN',
																'$cFe',
																'$cMg',
																'$cTe',
																'$cCd',
																'$cAg',
																'$cAu',
																'$cAi',
																'$Temperatura',
																'$Humedad',
																'$Observacion',
																'$fechaRegistro'
																)");
				}
			}
		}
		$link->close();
		$accion = '';
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

	<script src="../jquery/jquery-1.11.0.min.js"></script>
	<script src="../jquery/jquery-migrate-1.2.1.min.js"></script>	

	<script type="text/javascript" src="../jquery/libs/1/jquery.min.js"></script>	

	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	<link rel="stylesheet" href="../datatables/datatables.min.css">
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

<body>
	<?php include('head.php'); ?>
	<div id="linea"></div>

	<form name="form" action="iQuimico.php" method="get">
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
								<input name="CodInforme" type="hidden" value="<?php echo $CodInforme; ?>">
								<a class="nav-link fas fa-power-off" href="../generarinformes2/edicionInformes.php?accion=Editar&CodInforme=<?php echo $CodInforme; ?>" title="Volver a Informe <?php echo $CodInforme; ?>">Volver</a>
	          					<?php  
	          				}else{?>
	          					<a class="nav-link fas fa-undo-alt"  href="../tallerPM/pTallerPM.php"> Volver</a>
	          					<?php
	          				}?>
	        		</li>
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
				$sqlTe = "SELECT * FROM amtabensayos Where idItem = '$idItem' and idEnsayo = 'Qu'";
				$bdTe=$link->query($sqlTe);
				if($rowTe=mysqli_fetch_array($bdTe)){
					$cEnsayos = $rowTe['cEnsayos'];
				}

				$sqlCe = "SELECT * FROM regquimico Where idItem like '%$idItem%'";
				//echo $sqlCe;
				$bdCe=$link->query($sqlCe);
				while($rowCe=mysqli_fetch_array($bdCe)){
					$dEnsayos++;
					//echo 'Ensayos '.$dEnsayos;
					if($rowCe['Temperatura'] > 0){
						$cEnsayos -= 1;
					}
				}
				$link->close();
			?>
			<?php
				if($cEnsayos <= 1){?>
					<button name="guardarIdOtam" class="btn btn-danger" title="Guardar">
						Guardar y cerrar ensayo <?php echo $Otam.' '.$cEnsayos.' de '.$dEnsayos; ?>
					</button>
					<?php
				}
			?>
		</div>
	</div>

	<input name="Otam" type="hidden" 	value="<?php echo $Otam; ?>" />

	<?php
		$link=Conectarse();
											$bdOT=$link->query("SELECT * FROM OTAMs Where Otam = '".$Otam."'");
											if($rowOT=mysqli_fetch_array($bdOT)){
												$tpMuestra = $rowOT['tpMuestra'];
												$bdRegQui=$link->query("SELECT * FROM regQuimico Where idItem = '".$Otam."'");
												if($rowRegQui=mysqli_fetch_array($bdRegQui)){
		echo $Otam;
													$cC  = $rowRegQui['cC'];
													$cSi = $rowRegQui['cSi'];
													$cMn = $rowRegQui['cMn'];
													$cP  = $rowRegQui['cP'];
													$cS  = $rowRegQui['cS'];
													$cCr = $rowRegQui['cCr'];
													$cNi = $rowRegQui['cNi'];
													$cMo = $rowRegQui['cMo'];
													$cAl = $rowRegQui['cAl'];
													$cCu = $rowRegQui['cCu'];
													$cCo = $rowRegQui['cCo'];
													$cTi = $rowRegQui['cTi'];
													$cNb = $rowRegQui['cNb'];
													$cV  = $rowRegQui['cV'];
													$cW  = $rowRegQui['cW'];
													$cPb = $rowRegQui['cPb'];
													$cB  = $rowRegQui['cB'];
													$cSb = $rowRegQui['cSb'];
													$cSn = $rowRegQui['cSn'];
													$cZn = $rowRegQui['cZn'];
													$cAs = $rowRegQui['cAs'];
													$cBi = $rowRegQui['cBi'];
													$cTa = $rowRegQui['cTa'];
													$cCa = $rowRegQui['cCa'];
													$cCe = $rowRegQui['cCe'];
													$cZr = $rowRegQui['cZr'];
													$cLa = $rowRegQui['cLa'];
													$cSe = $rowRegQui['cSe'];
													$cN  = $rowRegQui['cN'];
													$cFe = $rowRegQui['cFe'];
													$cMg = $rowRegQui['cMg'];
													$cTe = $rowRegQui['cTe'];
													$cCd = $rowRegQui['cCd'];
													$cAg = $rowRegQui['cAg'];
													$cAu = $rowRegQui['cAu'];
													$cAi = $rowRegQui['cAi'];
													$Observacion = $rowRegQui['Observacion'];
													$Temperatura = $rowRegQui['Temperatura'];
													$Humedad 	 = $rowRegQui['Humedad'];
													$fechaRegistro 	 = $rowRegQui['fechaRegistro'];
												}
											}
			$link->close();

			if($Temperatura == 0)	{ $Temperatura = ''; 	}
			if($Humedad == 0)		{ $Humedad 	= ''; 		}
		?>	

	<div class="row" style="padding: 10px;">
		<div class="col-10">
			<div class="card">
				<div class="card-header font-weight-bold">OTAM</div>
			  	<div class="card-body">
				  	<table class="table table-dark table-hover text-center table-bordered">
				  		<thead>
				  			<tr>
				  				<th>IDENTIFICACIÓN 					</th>
				  				<th>ALEACIÓN BASE					</th>
				  				<th colspan="2">OBSERVACIONES 		</th>
				  			</tr>
				  		</thead>
				  		<tbody>
				  			<tr class="table-info text-dark text-center font-weight-bold">
				  				<td class="text-center"><?php echo $Otam; ?>		</td>
				  				<td rowspan="2">
									<h1>
									<?php
										$tm = explode('-',$Otam);
										$idEnsayo = 'Qu';
										$link=Conectarse();
										$SQL = "SELECT * FROM amTpsMuestras Where idEnsayo = '$idEnsayo' and tpMuestra = '$tpMuestra'";
										$bdTm=$link->query($SQL);
										if($rowTm=mysqli_fetch_array($bdTm)){
											echo $rowTm['Muestra'];
										}
										$link->close();
									?>
									</h1>
				  				</td>
				  				<td colspan="2" rowspan="2">
	  								<textarea class="form-control" rows="3" name="Obs" id="Obs" readonly></textarea>			  					
				  				</td>
				  			</tr>
				  			<tr class="table-info text-dark text-center font-weight-bold">
				  				<td class="text-center">FECHA 
				  					<?php 
				  						if($fechaRegistro == '0000-00-00'){
				  							$fechaRegistro = date('Y-m-d'); 
				  						}
				  					?>
				  					<input class="form-control" name="fechaRegistro" type="date" value="<?php echo $fechaRegistro; ?>" />
				  				</td>
				  			</tr>
				  			<tr class="table-info text-dark text-center font-weight-bold">
				  				<td class="text-center">TEMPERATURA		</td>
				  				<td>
				  					<input class="form-control" name="Temperatura"	type="text" value="<?php echo $Temperatura; ?>" required autofocus />
				  				</td>
				  				<td class="text-center">HUMEDAD		</td>
				  				<td>
				  					<input class="form-control" name="Humedad"	type="text" value="<?php echo $Humedad; ?>" required autofocus />
				  				</td>
				  			</tr>
				  			<tr class="table-info text-dark text-left font-weight-bold">
				  				<td colspan="4">
									<label for="Observacion">OBSERVACIONES:</label>
	  								<textarea class="form-control" rows="5" name="Observacion" id="Observacion"><?php echo $Observacion; ?></textarea>			  					
				  				</td>
				  			</tr>
				  		</tbody>
				  	</table>

					<div class="row" style="padding: 10px;">
						<div class="col-12">

							<!-- Datos Químico -->
							<?php
								$link=Conectarse();
								$bdOT=$link->query("SELECT * FROM OTAMs Where Otam = '".$Otam."'");
								if($rowOT=mysqli_fetch_array($bdOT)){
									$tpMuestra = $rowOT['tpMuestra'];

									$bdRegQui=$link->query("SELECT * FROM regQuimico Where idItem = '".$Otam."'");
									if($rowRegQui=mysqli_fetch_array($bdRegQui)){
										$cC  = $rowRegQui['cC'];
										$cSi = $rowRegQui['cSi'];
										$cMn = $rowRegQui['cMn'];
										$cP  = $rowRegQui['cP'];
										$cS  = $rowRegQui['cS'];
										$cCr = $rowRegQui['cCr'];
										$cNi = $rowRegQui['cNi'];
										$cMo = $rowRegQui['cMo'];
										$cAl = $rowRegQui['cAl'];
										$cCu = $rowRegQui['cCu'];
										$cCo = $rowRegQui['cCo'];
										$cTi = $rowRegQui['cTi'];
										$cNb = $rowRegQui['cNb'];
										$cV  = $rowRegQui['cV'];
										$cW  = $rowRegQui['cW'];
										$cPb = $rowRegQui['cPb'];
										$cB  = $rowRegQui['cB'];
										$cSb = $rowRegQui['cSb'];
										$cSn = $rowRegQui['cSn'];
										$cZn = $rowRegQui['cZn'];
										$cAs = $rowRegQui['cAs'];
										$cBi = $rowRegQui['cBi'];
										$cTa = $rowRegQui['cTa'];
										$cCa = $rowRegQui['cCa'];
										$cCe = $rowRegQui['cCe'];
										$cZr = $rowRegQui['cZr'];
										$cLa = $rowRegQui['cLa'];
										$cSe = $rowRegQui['cSe'];
										$cN  = $rowRegQui['cN'];
										$cFe = $rowRegQui['cFe'];
										$cMg = $rowRegQui['cMg'];
										$cTe = $rowRegQui['cTe'];
										$cCd = $rowRegQui['cCd'];
										$cAg = $rowRegQui['cAg'];
										$cAu = $rowRegQui['cAu'];
										$cAi = $rowRegQui['cAl'];
										//echo 'Otam '.$Otam.' C '.$cAl;

									}
									
									if($rowOT['tpMuestra'] == 'Ac'){?>
										<table class="table table-dark table-hover">
											<thead>
												<tr>
													<th>%C 	</th>
													<th>%Si </th>
													<th>%Mn </th>
													<th>%P  </th>
													<th>%S 	</th>
													<th>%Cr </th>
													<th>%Ni </th>
													<th>%Mo </th>
													<th>%Al </th>
													<th>%Cu </th>
												</tr>
											</thead>
											<tbody>
											<tr class="table-info">
												<?php
													$clase = 'bg-light';
													if(!$cC){
														$bdQu=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'C'");
														$rowQu = $bdQu->fetch_array(MYSQLI_ASSOC);
														$cC = $rowQu['valorDefecto'];
														if($rowQu['imprimible'] == 'off') { $clase = 'bg-warning'; }
													}
												?>
												<td>
													<input class="form-control <?php echo $clase; ?>" name="cC" 	type="text" size="7" maxlength="7" value="<?php echo $cC;  ?>" autofocus />	
												</td>
												<?php
													$clase = 'bg-light';
													if(!$cSi){
														$bdQu=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Si'");
														$rowQu = $bdQu->fetch_array(MYSQLI_ASSOC);
														$cSi = $rowQu['valorDefecto'];
														if($rowQu['imprimible'] == 'off') { $clase = 'bg-warning'; }
													}
												?>
												<td>
													<input class="form-control" name="cSi" 	type="text" size="7" maxlength="7" value="<?php echo $cSi; ?>" />			
												</td>
												<?php
													$clase = 'bg-light';
													if(!$cMn){
														$bdQu=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Mn'");
														$rowQu = $bdQu->fetch_array(MYSQLI_ASSOC);
														$cMn = $rowQu['valorDefecto'];
														if($rowQu['imprimible'] == 'off') { $clase = 'bg-warning'; }
													}
												?>
												<td>
													<input class="form-control" name="cMn" 	type="text" size="7" maxlength="7" value="<?php echo $cMn; ?>" />			
												</td>
												<?php
													$clase = 'bg-light';
													if(!$cP){
														$bdQu=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'P'");
														$rowQu = $bdQu->fetch_array(MYSQLI_ASSOC);
														$cP = $rowQu['valorDefecto'];
														if($rowQu['imprimible'] == 'off') { $clase = 'bg-warning'; }
													}
												?>
															<td><input class="form-control" name="cP" 	type="text" size="7" maxlength="7" value="<?php echo $cP;  ?>" />			</td>
												<?php
													$clase = 'bg-light';
													if(!$cS){
														$bdQu=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'S'");
														$rowQu = $bdQu->fetch_array(MYSQLI_ASSOC);
														$cS = $rowQu['valorDefecto'];
														if($rowQu['imprimible'] == 'off') { $clase = 'bg-warning'; }
													}
												?>
															<td><input class="form-control" name="cS" 	type="text" size="7" maxlength="7" value="<?php echo $cS;  ?>" />			</td>
												<?php
													$clase = 'bg-light';
													if(!$cCr){
														$bdQu=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Cr'");
														$rowQu = $bdQu->fetch_array(MYSQLI_ASSOC);
														$cCr = $rowQu['valorDefecto'];
														if($rowQu['imprimible'] == 'off') { $clase = 'bg-warning'; }
													}
												?>
															<td><input class="form-control" name="cCr" 	type="text" size="7" maxlength="7" value="<?php echo $cCr; ?>" />			</td>
												<?php
													$clase = 'bg-light';
													if(!$cNi){
														$bdQu=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Ni'");
														$rowQu = $bdQu->fetch_array(MYSQLI_ASSOC);
														$cNi = $rowQu['valorDefecto'];
														if($rowQu['imprimible'] == 'off') { $clase = 'bg-warning'; }
													}
												?>
															<td><input class="form-control" name="cNi" 	type="text" size="7" maxlength="7" value="<?php echo $cNi; ?>" />			</td>
												<?php
													$clase = 'bg-light';
													if(!$cMo){
														$bdQu=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Mo'");
														$rowQu = $bdQu->fetch_array(MYSQLI_ASSOC);
														$cMo = $rowQu['valorDefecto'];
														if($rowQu['imprimible'] == 'off') { $clase = 'bg-warning'; }
													}
												?>
															<td><input class="form-control" name="cMo" 	type="text" size="7" maxlength="7" value="<?php echo $cMo; ?>" />			</td>
												<?php
													$clase = 'bg-light';
													if(!$cAl){
														$bdQu=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Al'");
														$rowQu = $bdQu->fetch_array(MYSQLI_ASSOC);
														$cAl = $rowQu['valorDefecto'];
														if($rowQu['imprimible'] == 'off') { $clase = 'bg-warning'; }
													}
												?>
															<td><input class="form-control" name="cAl" 	type="text" size="7" maxlength="7" value="<?php echo $cAl; ?>" />			</td>
												<?php
													$clase = 'bg-light';
													if(!$cCu){
														$bdQu=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Cu'");
														$rowQu = $bdQu->fetch_array(MYSQLI_ASSOC);
														$cCu = $rowQu['valorDefecto'];
														if($rowQu['imprimible'] == 'off') { $clase = 'bg-warning'; }
													}
												?>
															<td><input class="form-control" name="cCu" 	type="text" size="7" maxlength="7" value="<?php echo $cCu; ?>" />			</td>
											</tr>
											<thead>
											<tr>
												<td>%Co</td>
												<td>%Ti</td>
												<td>%Nb</td>
												<td>%V</td>
												<td>%B</td>
												<td>%W</td>
												<td>%Sn</td>
												<td>-</td>
												<td>-</td>
												<td>%Fe</td>
											</tr>
											</thead>
											<tr class="table-info">
												<?php
													$clase = 'bg-light';
													if(!$cCo){
														$bdQu=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Co'");
														$rowQu = $bdQu->fetch_array(MYSQLI_ASSOC);
														$cCo = $rowQu['valorDefecto'];
														if($rowQu['imprimible'] == 'off') { $clase = 'bg-warning'; }
													}
												?>
															<td><input class="form-control" name="cCo" 	type="text" size="7" maxlength="7" value="<?php echo $cCo; ?>" autofocus />	</td>
												<?php
													$clase = 'bg-light';
													if(!$cTi){
														$bdQu=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Ti'");
														$rowQu = $bdQu->fetch_array(MYSQLI_ASSOC);
														$cTi = $rowQu['valorDefecto'];
														if($rowQu['imprimible'] == 'off') { $clase = 'bg-warning'; }
													}
												?>
															<td><input class="form-control" name="cTi" 	type="text" size="7" maxlength="7" value="<?php echo $cTi; ?>" />			</td>
												<?php
													$clase = 'bg-light';
													if(!$cNb){
														$bdQu=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Nb'");
														$rowQu = $bdQu->fetch_array(MYSQLI_ASSOC);
														$cNb = $rowQu['valorDefecto'];
														if($rowQu['imprimible'] == 'off') { $clase = 'bg-warning'; }
													}
												?>
															<td><input class="form-control" name="cNb" 	type="text" size="7" maxlength="7" value="<?php echo $cNb; ?>" />			</td>
												<?php
													$clase = 'bg-light';
													if(!$cV){
														$bdQu=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'V'");
														$rowQu = $bdQu->fetch_array(MYSQLI_ASSOC);
														$cV = $rowQu['valorDefecto'];
														if($rowQu['imprimible'] == 'off') { $clase = 'bg-warning'; }
													}
												?>
															<td><input class="form-control" name="cV" 	type="text" size="7" maxlength="7" value="<?php echo $cV;  ?>" />			</td>
												<?php
													$clase = 'bg-light';
													if(!$cB){
														$bdQu=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'B'");
														$rowQu = $bdQu->fetch_array(MYSQLI_ASSOC);
														$cB = $rowQu['valorDefecto'];
														if($rowQu['imprimible'] == 'off') { $clase = 'bg-warning'; }
													}
												?>
												<td>
																<input class="form-control" name="cB" 	type="text" size="7" maxlength="7" value="<?php echo $cB;  ?>" />
												</td>
												<?php
													$clase = 'bg-light';
													if(!$cW){
														$bdQu=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'W'");
														$rowQu = $bdQu->fetch_array(MYSQLI_ASSOC);
														$cW = $rowQu['valorDefecto'];
														if($rowQu['imprimible'] == 'off') { $clase = 'bg-warning'; }
													}
												?>
												<td>
													<input class="form-control <?php echo $clase; ?>" name="cW" 	type="text" size="7" maxlength="7" value="<?php echo $cW;  ?>" />											
												</td>
												<?php
													$clase = 'bg-light';
													if(!$cSn){
														$bdQu=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Sn'");
														$rowQu = $bdQu->fetch_array(MYSQLI_ASSOC);
														$cSn = $rowQu['valorDefecto'];
														if($rowQu['imprimible'] == 'off') { $clase = 'bg-warning'; }
													}
												?>
												<td>
													<input class="form-control <?php echo $clase; ?>" name="cSn" 	type="text" size="7" maxlength="7" value="<?php echo $cSn;  ?>" />											
												</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<?php
													$clase = 'bg-light';
													if(!$cFe){
														$bdQu=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Fe'");
														$rowQu = $bdQu->fetch_array(MYSQLI_ASSOC);
														$cFe = $rowQu['valorDefecto'];
														if($rowQu['imprimible'] == 'off') { $clase = 'bg-warning'; }
													}
												?>
															<td>
																<input class="form-control" name="cFe" 	type="text" size="7" maxlength="7" value="<?php echo 'Resto';  ?>" />		</td>
														</tr>
										</table>
										<?php
									}
									if($rowOT['tpMuestra'] == 'Co'){?>
										<table class="table table-dark table-hover">
											<thead>
												<tr>
													<th>%Zn </th>
													<th>%Pb </th>
													<th>%Sn </th>
													<th>%P 	</th>
													<th>%Mn </th>
													<th>%Fe </th>
													<th>%Ni </th>
													<th>%Si </th>
													<th>%Mg </th>
													<th>%Cr </th>
												</tr>
											</thead>
											<tbody>
												<tr class="table-info">
													<td>
														<input name="cZn" 	type="text" id="cZn" class="form-control" value="<?php echo $cZn;  ?>" size="7" maxlength="7" autofocus />	
													</td>
													<td><input name="cPb" 	type="text" id="cPb" class="form-control" value="<?php echo $cPb; ?>"  size="7" maxlength="7" />			</td>
													<td><input name="cSn" 	type="text" id="cSn" class="form-control" value="<?php echo $cSn; ?>"  size="7" maxlength="7" />			</td>
													<td><input name="cP" 	type="text" id="cP"  class="form-control" value="<?php echo $cP;  ?>"  size="7" maxlength="7" />			</td>
													<td><input name="cMn" 	type="text" id="cMn" class="form-control" value="<?php echo $cMn;  ?>" size="7" maxlength="7" />			</td>
													<td><input name="cFe" 	type="text" id="cFe" class="form-control" value="<?php echo $cFe; ?>"  size="7" maxlength="7" />			</td>
													<td><input name="cNi" 	type="text" id="cNi" class="form-control" value="<?php echo $cNi; ?>"  size="7" maxlength="7" />			</td>
													<td><input name="cSi" 	type="text" id="cSi" class="form-control" value="<?php echo $cSi; ?>"  size="7" maxlength="7" />			</td>
													<td><input name="cMg" 	type="text" id="cMg" class="form-control" value="<?php echo $cMg; ?>"  size="7" maxlength="7" />			</td>
													<td><input name="cCr" 	type="text" id="cCr" class="form-control" value="<?php echo $cCr; ?>"  size="7" maxlength="7" />			</td>
												</tr>
												<thead>
												<tr>	
													<td>%Te</td>
													<td>%As</td>
													<td>%Sb</td>
													<td>%Cd</td>
													<td>%Bi</td>
													<td>%Ag</td>
													<td>%Co</td>
													<td>%Ai</td>
													<td>%S</td>
													<td>%Zr</td>
												</tr>
												</thead>
												<tr class="table-info">
															<td height="30"><input name="cTe" 	type="text" id="cTe" class="form-control" value="<?php echo $cTe; ?>" 	size="7" maxlength="7" autofocus />	</td>
															<td><input name="cAs" 	type="text" id="cAs" class="form-control" value="<?php echo $cAs; ?>" 	size="7" maxlength="7" />			</td>
															<td><input name="cSb" 	type="text" id="cSb" class="form-control" value="<?php echo $cSb; ?>" 	size="7" maxlength="7" />			</td>
															<td><input name="cCd" 	type="text" id="cCd" class="form-control" value="<?php echo $cCd;  ?>" 	size="7" maxlength="7" />			</td>
															<td><input name="cBi" 	type="text" id="cBi" class="form-control" value="<?php echo $cBi;  ?>" 	size="7" maxlength="7" />			</td>
															<td><input name="cAg" 	type="text" id="cAg" class="form-control" value="<?php echo $cAg;  ?>" 	size="7" maxlength="7" />			</td>
															<td><input name="cCo" 	type="text" id="cCo" class="form-control" value="<?php echo $cCo;  ?>" 	size="7" maxlength="7" />			</td>
															<td><input name="cAi" 	type="text" id="cAi" class="form-control" value="<?php echo $cAi;  ?>" 	size="7" maxlength="7" />			</td>
															<td><input name="cS" 	type="text" id="cS"  class="form-control" value="<?php echo $cS;  ?>"  	size="7" maxlength="7" />			</td>
															<td><input name="cZr" 	type="text" id="cZ" class="form-control" value="<?php echo $cZr;  ?>" 	size="7" maxlength="7" />			</td>
												</tr>
												<thead>
												<tr>
													<td>%Au</td>
													<td>%B</td>
													<td>%Ti</td>
													<td>%Se</td>
													<td>-</td>
													<td>-</td>
													<td>-</td>
													<td>-</td>
													<td>-</td>
													<td>%Cu</td>
												</tr>
												</thead>
												<tr class="table-info">
															<td height="30"><input name="cAu" 	type="text" id="cAu" 	class="form-control" value="<?php echo $cAu; ?>" 	size="7" maxlength="7" autofocus />	</td>
															<td><input name="cB" 	type="text" id="cB" 	class="form-control" value="<?php echo $cB; ?>" 	size="7" maxlength="7" />			</td>
															<td><input name="cTi" 	type="text" id="cTi" 	class="form-control" value="<?php echo $cTi; ?>" 	size="7" maxlength="7" />			</td>
															<td><input name="cSe" 	type="text" id="cSe" 	class="form-control" value="<?php echo $cSe;  ?>" size="7" maxlength="7" />			</td>
															<td>&nbsp;			</td>
															<td>&nbsp;			</td>
															<td>&nbsp;			</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td><input name="cCu" 	type="text" id="cCu" 	class="form-control" value="<?php echo $cCu;  ?>" size="7" maxlength="7" />			</td>
												</tr>
											</table>
										<?php
									}
									if($rowOT['tpMuestra'] == 'Al'){?>
										<table class="table table-dark table-hover">
											<thead>
												<tr>
													<th>%Si</th>
													<th>%Fe</th>
													<th>%Cu</th>
													<th>%Mn</th>
													<th>%Mg</th>
													<th>%Cr</th>
													<th>%Ni</th>
													<th>%Zn</th>
													<th>%Ti</th>
													<th>%Pb</th>
												</tr>
											</thead>
											<tbody>
												<tr class="table-info">
															<td height="30"><input class="form-control" name="cSi" 	type="text" size="7" maxlength="7" value="<?php echo $cSi;  ?>" autofocus />	</td>
															<td><input class="form-control" name="cFe" 	type="text" size="7" maxlength="7" value="<?php echo $cFe; ?>" 	/>				</td>
															<td><input class="form-control" name="cCu" 	type="text" size="7" maxlength="7" value="<?php echo $cCu; ?>" 	/>				</td>
															<td><input class="form-control" name="cMn" 	type="text" size="7" maxlength="7" value="<?php echo $cMn;  ?>" />				</td>
															<td><input class="form-control" name="cMg" 	type="text" size="7" maxlength="7" value="<?php echo $cMg;  ?>" />				</td>
															<td><input class="form-control" name="cCr" 	type="text" size="7" maxlength="7" value="<?php echo $cCr; ?>" 	/>				</td>
															<td><input class="form-control" name="cNi" 	type="text" size="7" maxlength="7" value="<?php echo $cNi; ?>" 	/>				</td>
															<td><input class="form-control" name="cZn" 	type="text" size="7" maxlength="7" value="<?php echo $cZn; ?>" 	/>				</td>
															<td><input class="form-control" name="cTi" 	type="text" size="7" maxlength="7" value="<?php echo $cTi; ?>" 	/>				</td>
															<td><input class="form-control" name="cPb" 	type="text" size="7" maxlength="7" value="<?php echo $cPb; ?>" 	/>				</td>
												</tr>
												<thead>
												<tr>
													<td>%Sn</td>
													<td>%Bi</td>
													<td>%Zr</td>
													<td>-</td>
													<td>-</td>
													<td>-</td>
													<td>-</td>
													<td>-</td>
													<td>-</td>
													<td>%Al</td>
												</tr>
												</thead>
												<tr class="table-info">
															<td height="30"><input class="form-control" name="cSn" 	type="text" size="7" maxlength="7" value="<?php echo $cSn; ?>" autofocus />	</td>
															<td><input class="form-control" name="cBi" 	type="text" size="7" maxlength="7" value="<?php echo $cBi; ?>" />			</td>
															<td><input class="form-control" name="cZr" 	type="text" size="7" maxlength="7" value="<?php echo $cZr; ?>" />			</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td><input class="form-control" name="cAl" 	type="text" size="7" maxlength="7" value="<?php echo $cAl;  ?>" />		</td>
												</tr>
											</tbody>
										</table>
									<?php
								}
							}
						$link->close();
					?>

<!-- Datos Químico -->





						</div>
					</div>

				</div>
			  	<div class="card-footer">
					<button name="guardarOtam" class="btn btn-warning" title="Guardar">
						Guardar Datos ensayo <?php echo $Otam; ?>
					</button>
					<button name="guardarOtamPrecaucion" class="btn btn-danger" title="Guardar">
						Guardar Datos CON PRECAUCIÓN ensayo <?php echo $Otam; ?>
					</button>
					
			  	</div>			  

			</div>



		</div>
		<div class="col-2">
			<table class="table table-dark table-bordered text-center">
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
							<?php
								$tm = explode('-',$Otam);
								$idEnsayo = 'Qu';
								$link=Conectarse();
								$SQL = "SELECT * FROM amTpsMuestras Where idEnsayo = '$idEnsayo' and tpMuestra = '$tpMuestra'";
								$bdTm=$link->query($SQL);
								if($rowTm=mysqli_fetch_array($bdTm)){
									$SQLe = "SELECT * FROM amensayos Where idEnsayo = '$idEnsayo'";
									$bdTe=$link->query($SQLe);
									if($rowTe=mysqli_fetch_array($bdTe)){
										echo $rowTe['Ensayo'].' '.$rowTm['Muestra'];
									}
								}
								$link->close();
							?>
							</h5>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

	</div>





	</form>

	<script src="../jquery/jquery-3.3.1.js"></script>
	<script src="../datatables/datatables.min.js"></script>
	<script src="../jsboot/bootstrap.min.js"></script>	
	<script src="quimicos.js"></script>

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
