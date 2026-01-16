<?php
	session_start(); 
	include_once("../conexionli.php");
	$accion = '';
	$CAM 	= 0;
	$RAM	= 0;
	
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
	if(isset($_GET['accion'])) 	{	$accion 	= $_GET['accion']; 	}
	if(isset($_GET['Otam'])) 	{	$Otam 		= $_GET['Otam']; 	}

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

			if(isset($_GET['tpMuestra'])) 	{ $tpMuestra 	 	= $_GET['tpMuestra']; 	}
			
			$actSQL="UPDATE OTAMs SET ";
			$actSQL.="tpMuestra		='".$tpMuestra.	"',";
			$actSQL.="Estado		='".$Estado.	"'";
			$actSQL.="WHERE Otam = '".$Otam."'";
			$bdfRAM=$link->query($actSQL);

			$tm = explode('-',$Otam);
			if($rowOT['idEnsayo'] == 'Tr') { $tReg = 'regTraccion'; }
			if($rowOT['idEnsayo'] == 'Qu') { $tReg = 'regQuimico'; }
			if($rowOT['idEnsayo'] == 'Ch') { $tReg = 'regCharpy'; }
			if($rowOT['idEnsayo'] == 'Du') { $tReg = 'regDoblado'; }
			if($rowOT['idEnsayo'] == 'Do') { $tReg = 'regdobladosReal'; }

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

			if(isset($_GET['Ind'])){ $Ind  = $_GET['Ind'];}
			
			if(substr($tm[1],0,1) == 'C'){
				for($in=1; $in<=$Ind; $in++) { 
					$el_nImpacto 	= 'nImpacto_'.$in.'-'.$Otam;
					$el_vImpacto	= 'vImpacto_'.$in.'-'.$Otam;
					if(isset($_GET[$el_nImpacto]))		{ $el_nImpacto		= $_GET[$el_nImpacto];		}
					if(isset($_GET[$el_vImpacto]))		{ $el_vImpacto		= $_GET[$el_vImpacto];		}

					$link=Conectarse();
					$bdRegCh=$link->query("SELECT * FROM regCharpy Where idItem = '".$Otam."' and nImpacto = '".$in."'");
					if($rowRegCh=mysqli_fetch_array($bdRegCh)){
						$actSQL="UPDATE regCharpy SET ";
						$actSQL.="vImpacto 	   ='".$el_vImpacto.	"'";
						$actSQL.="WHERE idItem = '".$Otam."' and nImpacto = '".$in."'";
						$bdRegCh=$link->query($actSQL);
					}else{
						$link->query("insert into regCharpy(
																CodInforme,
																idItem,
																tpMuestra,
																nImpacto,
																vImpacto
																) 
														values 	(	
																'$CodInforme',
																'$Otam',
																'$tpMuestra',
																'$in',
																'$el_vImpacto'
								)");
					}
					$link->close();
				}
			}

			if(substr($tm[1],0,1) == 'D'){
				for($in=1; $in<=$Ind; $in++) { 
					$el_nIndenta 	= 'nIndenta_'.$in.'-'.$Otam;
					$el_vIndenta	= 'vIndenta_'.$in.'-'.$Otam;
					if(isset($_GET[$el_nIndenta]))		{ $el_nIndenta		= $_GET[$el_nIndenta];		}
					if(isset($_GET[$el_vIndenta]))		{ $el_vIndenta		= $_GET[$el_vIndenta];		}

					$link=Conectarse();
					$bdRegDo=$link->query("SELECT * FROM regDoblado Where idItem = '".$Otam."' and nIndenta = '".$in."'");
					if($rowRegDo=mysqli_fetch_array($bdRegDo)){
						$actSQL="UPDATE regDoblado SET ";
						$actSQL.="vIndenta 		='".$el_vIndenta.	"'";
						$actSQL.="WHERE idItem 	= '".$Otam."' and nIndenta = '".$in."'";
						$bdRegDo=$link->query($actSQL);
					}else{
						$link->query("insert into regDoblado(
																CodInforme,
																idItem,
																tpMuestra,
																nIndenta,
																vIndenta
																) 
														values 	(	
																'$CodInforme',
																'$Otam',
																'$tpMuestra',
																'$in',
																'$el_vIndenta'
								)");
					}
					$link->close();
				}
			}

			if(substr($tm[1],0,1) == 'T' or substr($tm[1],0,1) == 'Q'){
			
				$bdRdM=$link->query("Select * From $tReg Where idItem = '".$Otam."'");
				if($rowRdM=mysqli_fetch_array($bdRdM)){
	
					if(substr($tm[1],0,1) == 'T'){
						$actSQL="UPDATE $tReg SET ";
						$actSQL.="tpMuestra	='".$tpMuestra.	"',";
						$actSQL.="aIni		='".$aIni.		"',";
						$actSQL.="cFlu		='".$cFlu.		"',";
						$actSQL.="cMax		='".$cMax.		"',";
						$actSQL.="tFlu		='".$tFlu.		"',";
						$actSQL.="tMax		='".$tMax.		"',";
						$actSQL.="aSob		='".$aSob.		"',";
						$actSQL.="rAre		='".$rAre.		"'";
						$actSQL.="WHERE idItem = '".$Otam."'";
						$bdRdM=$link->query($actSQL);
					}
	
					if(substr($tm[1],0,1) == 'Q'){
						$actSQL="UPDATE $tReg SET ";
						$actSQL.="tpMuestra	='".$tpMuestra.	"',";
						$actSQL.="cC		='".$cC.		"',";
						$actSQL.="cSi		='".$cSi.		"',";
						$actSQL.="cMn		='".$cMn.		"',";
						$actSQL.="cP		='".$cP.		"',";
						$actSQL.="cS		='".$cS.		"',";
						$actSQL.="cCr		='".$cCr.		"',";
						$actSQL.="cNi		='".$cNi.		"',";
						$actSQL.="cMo		='".$cMo.		"',";
						$actSQL.="cAl		='".$cAl.		"',";
						$actSQL.="cCu		='".$cCu.		"',";
						$actSQL.="cCo		='".$cCo.		"',";
						$actSQL.="cTi		='".$cTi.		"',";
						$actSQL.="cNb		='".$cNb.		"',";
						$actSQL.="cV		='".$cV.		"',";
						$actSQL.="cW		='".$cW.		"',";
						$actSQL.="cPb		='".$cPb.		"',";
						$actSQL.="cB		='".$cB.		"',";
						$actSQL.="cSb		='".$cSb.		"',";
						$actSQL.="cSn		='".$cSn.		"',";
						$actSQL.="cZn		='".$cZn.		"',";
						$actSQL.="cAs		='".$cAs.		"',";
						$actSQL.="cBi		='".$cBi.		"',";
						$actSQL.="cTa		='".$cTa.		"',";
						$actSQL.="cCa		='".$cCa.		"',";
						$actSQL.="cCe		='".$cCe.		"',";
						$actSQL.="cZr		='".$cZr.		"',";
						$actSQL.="cLa		='".$cLa.		"',";
						$actSQL.="cSe		='".$cSe.		"',";
						$actSQL.="cN		='".$cN.		"',";
						$actSQL.="cFe		='".$cFe.		"',";
						$actSQL.="cMg		='".$cMg.		"',";
						$actSQL.="cTe		='".$cTe.		"',";
						$actSQL.="cCd		='".$cCd.		"',";
						$actSQL.="cAg		='".$cAg.		"',";
						$actSQL.="cAu		='".$cAu.		"',";
						$actSQL.="cAi		='".$cAi.		"'";
						$actSQL.="WHERE idItem = '".$Otam."'";
						$bdRdM=$link->query($actSQL);
					}
				}else{
				 
					/* Inicio Guarda TracciÃ³n */
					
					if(substr($tm[1],0,1) == 'T'){
						$link->query("insert into $tReg (
																idItem,
																tpMuestra,
																aIni,
																cFlu,
																cMax,
																tFlu,
																tMax,
																aSob,
																rAre
																) 
														values 	(	
																'$Otam',
																'$tpMuestra',
																'$aIni',
																'$cFlu',
																'$cMax',
																'$tFlu',
																'$tMax',
																'$aSob',
																'$rAre'
																)");
					}
					/* Fin Tracción */
	
					/* Inicio Químicos */
	
					if(substr($tm[1],0,1) == 'Q'){
						$link->query("insert into $tReg (
																idItem,
																tpMuestra,
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
																cAi
																) 
														values 	(	
																'$Otam',
																'$tpMuestra',
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
																'$cAi'
																)");
					}
					/* Fin Químico */
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

<title>Taller Propiedades Mecánicas</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="shortcut icon" href="../favicon.ico" />
	
	<link href="styles.css" 	rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<!-- <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>-->
	<!-- <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	-->

	<script type="text/javascript" src="../jquery/jquery.min.js"></script>	

	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"> -->
	<script src="../angular.min.js"></script>
	<!--<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script> -->

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
					<?php
					if($_SESSION['IdPerfil'] != 5){?> 
		        		<li class="nav-item active">
		          			<a class="nav-link fa fa-home" href="../plataformaErp.php"> Principal
		                	<span class="sr-only">(current)</span>
		              		</a>
		        		</li>
		        		<?php
		        	}
		        	?>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="Espectrometro.php">| Espectrometro</a>
	        		</li>
	        		<!-- <li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="orientacion.php"> Orientacion | </a>
	        		</li> -->
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="lectorTracciones.php"> Traccciones</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="lectorDurezas.php"> | Durezas |</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="../cerrarsesion.php"> Cerrar</a>
	        		</li>

	      		</ul>
	    	</div> 
	  	</div>
	</nav>
	<?php 
		include_once('listaEnsayos.php');
		if($accion == 'Registrar' and $Otam > 0){
			?>
			<script>
				var Otam		= "<?php echo $Otam; 		?>" ;
				var accion 		= "<?php echo $accion; 		?>" ;
				registraOtams(Otam, accion);
			</script>
			<?php
		}
	?>
				

	<!-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> -->
	<!-- <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> -->
	<script src="../jsboot/bootstrap.min.js"></script>	

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
