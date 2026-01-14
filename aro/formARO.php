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
	$usuario 			= $_SESSION['usuario'];

	$fteRecCliExt 		= '';
	$fteOtros 			= '';
	$oriOtros 			= '';
	$oriOtrosTxt		= '';
	$desClasNoConf 		= '';
	$desClasObs 		= '';
	$usrEncargado 		= '';
	$accCorrecion 		= '';

	$nInformePreventiva = '';
	$accion				= '';
	$usrApertura 		= $_SESSION['usr'];
	
	if(isset($_GET['nInformePreventiva']))	{ $nInformePreventiva	= $_GET['nInformePreventiva'];	}
	if(isset($_GET['accion'])) 				{ $accion				= $_GET['accion']; 				}

	if(isset($_POST['nInformePreventiva']))	{ $nInformePreventiva 	= $_POST['nInformePreventiva'];	}
	if(isset($_POST['accion'])) 			{ $accion		 		= $_POST['accion']; 			}

	if($accion=='Imprimir'){
		header("Location: iAP.php?nInformePreventiva=$nInformePreventiva");
	}
	
	if(isset($_POST['cerrarAccionPreventiva'])){
		$verCierreAccion	= 'on';
		$fechaCierre 		= date('Y-m-d');
		$link=Conectarse();
		$actSQL="UPDATE accionesPreventivas SET ";
		$actSQL.="fechaCierre				='".$fechaCierre.		"',";
		$actSQL.="verCierreAccion			='".$verCierreAccion.	"'";
		$actSQL.="WHERE nInformePreventiva 	= '".$nInformePreventiva."'";
		$bdCot=$link->query($actSQL);
		$link->close();
		$nInformePreventiva = '';
		$accion				= '';
	}

	if(isset($_POST['ReAbrirAccionPreventiva'])){
		$verCierreAccion	= ' ';
		$fechaCierre 		= '0000-00-00';
		$link=Conectarse();
		$actSQL="UPDATE accionesPrventivas SET ";
		$actSQL.="fechaCierre				='".$fechaCierre.		"',";
		$actSQL.="verCierreAccion			='".$verCierreAccion.	"'";
		$actSQL.="WHERE nInformePrevetiva 	= '".$nInformePreventiva."'";
		$bdCot=$link->query($actSQL);
		$link->close();
		$nInformePreventiva = '';
		$accion				= '';
	}

	if(isset($_POST['confirmarBorrar'])){
		$link=Conectarse();
		$bdCot =$link->query("Delete From accionesPreventivas Where nInformePreventiva = '".$nInformePreventiva."'");
		$link->close();
		$nInformePreventiva = '';
		$accion				= '';
	}
	
	if(isset($_POST['guardarAccionPreventiva'])){
		if(isset($_POST['nInformePreventiva']))	{ $nInformePreventiva		= $_POST['nInformePreventiva'];	}
		if(isset($_POST['fechaApertura']))		{ $fechaApertura 			= $_POST['fechaApertura'];		}

		if(isset($_POST['fteRecCliExt']))		{ $fteRecCliExt	 			= $_POST['fteRecCliExt'];		}
		if($fteRecCliExt=='on')	{ 
			if(isset($_POST['fteNroRecCliExt'])){ $fteNroRecCliExt 			= $_POST['fteNroRecCliExt']; 	}
		}else{
			$fteNroRecCliExt 	= ''; 
		}

		$fteRecCliInt 	= '';
		if(isset($_POST['fteRecCliInt']))		{ $fteRecCliInt	 			= $_POST['fteRecCliInt'];		}
		if($fteRecCliInt=='on')	{ 
			if(isset($_POST['fteNroRecCliInt'])){ $fteNroRecCliInt 			= $_POST['fteNroRecCliInt'];	}
		}else{
			$fteNroRecCliInt 	= '';
		}

		$fteAut			= '';
		if(isset($_POST['fteAut']))				{ $fteAut			 		= $_POST['fteAut'];				}
		if($fteAut=='on')	{ 
			if(isset($_POST['fteAutFecha']))	{ $fteAutFecha	 			= $_POST['fteAutFecha'];		}
		}else{
			$fteAutFecha	 	= '0000-00-00';
		}

		$fteAudInt		= '';
		if(isset($_POST['fteAudInt']))			{ $fteAudInt		 		= $_POST['fteAudInt'];			}
		if($fteAudInt=='on')	{ 
			if(isset($_POST['fteAudIntFecha']))	{ $fteAudIntFecha	 		= $_POST['fteAudIntFecha'];		}
		}else{
			$fteAudIntFecha	 	= '0000-00-00';
		}
		
		$fteAudExt		= '';
		if(isset($_POST['fteAudExt']))			{ $fteAudExt		 		= $_POST['fteAudExt'];			}
		if($fteAudExt=='on')	{ 
			if(isset($_POST['fteAudExtFecha']))	{ $fteAudExtFecha	 		= $_POST['fteAudExtFecha'];		}
		}else{
			$fteAudExtFecha	 	= '0000-00-00';
		}
		if(isset($_POST['fteOtros']))			{ $fteOtros		 			= $_POST['fteOtros'];			}
		if(isset($_POST['fteOtrosTxt']))		{ $fteOtrosTxt	 			= $_POST['fteOtrosTxt'];		}
		
		$oriSisGes		= '';
		if(isset($_POST['oriSisGes']))			{ $oriSisGes 				= $_POST['oriSisGes'];			}
		if($oriSisGes=='on')	{ 
			if(isset($_POST['oriSisGesFecha']))	{ $oriSisGesFecha		 	= $_POST['oriSisGesFecha'];		}
		}else{
			$oriSisGesFecha		 = '0000-00-00';
		}
		
		$oriEnsayos		= '';
		if(isset($_POST['oriEnsayos']))			{ $oriEnsayos			 	= $_POST['oriEnsayos'];			}
		if($oriEnsayos=='on')	{ 
			if(isset($_POST['oriNroAso']))		{ $oriNroAso				= $_POST['oriNroAso'];			}
		}else{
			$oriNroAso			= '';
		}

		$oriLeyReg		= '';
		if(isset($_POST['oriLeyReg']))			{ $oriLeyReg			 	= $_POST['oriLeyReg'];			}
		if($oriLeyReg=='on')	{ 
			if(isset($_POST['oriLeyRegFecha']))	{ $oriLeyRegFecha			= $_POST['oriLeyRegFecha'];		}
		}else{
			$oriLeyRegFecha		= '0000-00-00';
		}
		
		$oriTnc			= '';
		if(isset($_POST['oriTnc']))				{ $oriTnc				 	= $_POST['oriTnc'];				}
		if($oriTnc=='on')	{ 
			if(isset($_POST['oriTncFecha']))	{ $oriTncFecha				= $_POST['oriTncFecha'];		}
		}else{
			$oriTncFecha		= '0000-00-00';
		}
		
		$oriInterLab		= '';
		if(isset($_POST['oriInterLab']))		{ $oriInterLab		 		= $_POST['oriInterLab'];		}
		if($oriInterLab=='on')	{ 
			if(isset($_POST['oriInterLabFecha'])){ $oriInterLabFecha		= $_POST['oriInterLabFecha'];	}
		}else{
			$oriInterLabFecha	= '0000-00-00';
		}
		
		if(isset($_POST['oriOtros']))			{ $oriOtros			 		= $_POST['oriOtros'];			}
		if(isset($_POST['oriOtrosTxt']))		{ $oriOtrosTxt			 	= $_POST['oriOtrosTxt'];			}
		
		$Clasificacion	= '';
		if(isset($_POST['Clasificacion']))		{ $Clasificacion		 	= $_POST['Clasificacion'];		}
		if($Clasificacion=='N'){
			$desClasNoConf		= 'on';
			$desClasObs			= ' ';
		}
		if($Clasificacion=='O'){
			$desClasNoConf		= ' ';
			$desClasObs			= 'on';
		}
		if(isset($_POST['desIdentificacion']))	{ $desIdentificacion	 	= $_POST['desIdentificacion'];	}
		if(isset($_POST['desHallazgo']))		{ $desHallazgo		 		= $_POST['desHallazgo'];		}
		if(isset($_POST['desEvidencia']))		{ $desEvidencia		 		= $_POST['desEvidencia'];		}
		if(isset($_POST['Causa']))				{ $Causa				 	= $_POST['Causa'];				}
		if(isset($_POST['accCorrecion']))		{ $accCorrecion		 		= $_POST['accCorrecion'];		}
		if(isset($_POST['accAccionCorrectiva'])){ $accAccionCorrectiva		= $_POST['accAccionCorrectiva'];}

		$accFechaImp		= '0000-00-00';
		if(isset($_POST['accFechaImp'])){ 
			$fd = explode('-', $_POST['accFechaImp']);
			if($fd[0] > 0){
				$accFechaImp		= $_POST['accFechaImp'];
			}
		}		

		$accFechaTen		= '0000-00-00';
		if(isset($_POST['accFechaTen'])){ 
			$fd = explode('-', $_POST['accFechaTen']);
			if($fd[0] > 0){
				$accFechaTen		= $_POST['accFechaTen'];
			}
		}
		
		$accFechaVer		= '0000-00-00';
		if(isset($_POST['accFechaVer'])){ 
			$fd = explode('-', $_POST['accFechaVer']);
			if($fd[0] > 0){
				$accFechaVer		= $_POST['accFechaVer'];
			}
		}

		$accFechaApli		= '0000-00-00';
		if(isset($_POST['accFechaApli'])){ 
			$fd = explode('-', $_POST['accFechaApli']);
			if($fd[0] > 0){
				$accFechaApli		= $_POST['accFechaApli'];
			}
		}
				
		if(isset($_POST['verResAccCorr']))	{ $verResAccCorr		 	= $_POST['verResAccCorr'];			}
		if(isset($_POST['usrEncargado']))	{ $usrEncargado		 		= $_POST['usrEncargado'];			}
		if(isset($_POST['usrResponsable']))	{ $usrResponsable		 	= $_POST['usrResponsable'];			}
		if(isset($_POST['usrCalidad']))		{ $usrCalidad			 	= $_POST['usrCalidad'];				}
		if(isset($_POST['accion']))			{ $accion			 		= $_POST['accion'];					}
		
		$link=Conectarse();
		$bdCot=$link->query("Select * From accionesPreventivas Where nInformePreventiva = '".$nInformePreventiva."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$actSQL="UPDATE accionesPreventivas SET ";
			$actSQL.="fechaApertura				='".$fechaApertura.		"',";
			$actSQL.="usrApertura				='".$usrApertura.		"',";
			$actSQL.="fteRecCliExt				='".$fteRecCliExt.		"',";
			$actSQL.="fteNroRecCliExt			='".$fteNroRecCliExt.	"',";
			$actSQL.="fteRecCliInt				='".$fteRecCliInt.		"',";
			$actSQL.="fteNroRecCliInt			='".$fteNroRecCliInt.	"',";
			$actSQL.="fteAut					='".$fteAut.			"',";
			$actSQL.="fteAutFecha				='".$fteAutFecha.		"',";
			$actSQL.="fteAudInt					='".$fteAudInt.			"',";
			$actSQL.="fteAudIntFecha			='".$fteAudIntFecha.	"',";
			$actSQL.="fteAudExt					='".$fteAudExt.			"',";
			$actSQL.="fteAudExtFecha			='".$fteAudExtFecha.	"',";
			$actSQL.="fteOtros					='".$fteOtros.			"',";
			$actSQL.="fteOtrosTxt				='".$fteOtrosTxt.		"',";
			$actSQL.="oriSisGes					='".$oriSisGes.			"',";
			$actSQL.="oriSisGesFecha			='".$oriSisGesFecha.	"',";
			$actSQL.="oriEnsayos				='".$oriEnsayos.		"',";
			$actSQL.="oriNroAso					='".$oriNroAso.			"',";
			$actSQL.="oriLeyReg					='".$oriLeyReg.			"',";
			$actSQL.="oriLeyRegFecha			='".$oriLeyRegFecha.	"',";
			$actSQL.="oriTnc					='".$oriTnc.			"',";
			$actSQL.="oriTncFecha				='".$oriTncFecha.		"',";
			$actSQL.="oriInterLab				='".$oriInterLab.		"',";
			$actSQL.="oriInterLabFecha			='".$oriInterLabFecha.	"',";
			$actSQL.="oriOtros					='".$oriOtros.			"',";
			$actSQL.="oriOtrosTxt				='".$oriOtrosTxt.		"',";
			$actSQL.="desClasNoConf				='".$desClasNoConf.		"',";
			$actSQL.="desClasObs				='".$desClasObs.		"',";
			$actSQL.="desIdentificacion			='".$desIdentificacion.	"',";
			$actSQL.="desHallazgo				='".$desHallazgo.		"',";
			$actSQL.="desEvidencia				='".$desEvidencia.		"',";
			$actSQL.="Causa						='".$Causa.				"',";
			$actSQL.="accAccionCorrectiva		='".$accAccionCorrectiva."',";
			$actSQL.="accFechaImp				='".$accFechaImp.		"',";
			$actSQL.="accFechaTen				='".$accFechaTen.		"',";
			$actSQL.="accFechaApli				='".$accFechaApli.		"',";
			$actSQL.="accFechaVer				='".$accFechaVer.		"',";
			$actSQL.="verResAccCorr				='".$verResAccCorr.		"',";
			$actSQL.="usrEncargado				='".$usrEncargado.		"',";
			$actSQL.="usrCalidad				='".$usrCalidad.		"',";
			$actSQL.="usrResponsable			='".$usrResponsable.	"'";
			$actSQL.="WHERE nInformePreventiva 	= '".$nInformePreventiva."'";
			$bdCot=$link->query($actSQL);
		}else{
			$link->query("insert into accionesPreventivas(	
															nInformePreventiva	,
															fechaApertura		,
															usrApertura			,
															fteRecCliExt		,
															fteNroRecCliExt		,
															fteRecCliInt		,
															fteNroRecCliInt		,
															fteAut				,
															fteAutFecha			,
															fteAudInt			,
															fteAudIntFecha		,
															fteAudExt			,
															fteAudExtFecha		,
															fteOtros			,
															fteOtrosTxt			,
															oriSisGes			,
															oriSisGesFecha		,
															oriEnsayos			,
															oriNroAso			,
															oriLeyReg			,
															oriLeyRegFecha		,
															oriTnc				,
															oriTncFecha			,
															oriInterLab			,
															oriInterLabFecha	,
															oriOtros			,
															oriOtrosTxt			,
															desClasNoConf		,
															desClasObs			,
															desIdentificacion	,
															desHallazgo			,
															desEvidencia		,
															Causa				,
															accCorrecion		,
															accAccionCorrectiva	,
															accFechaImp			,
															accFechaTen			,
															accFechaApli		,
															accFechaVer			,
															verResAccCorr		,
															usrEncargado		,
															usrCalidad			,
															usrResponsable
															) 
												values 	(	
															'$nInformePreventiva'	,
															'$fechaApertura'		,
															'$usrApertura'			,
															'$fteRecCliExt'			,
															'$fteNroRecCliExt'		,
															'$fteRecCliInt'			,
															'$fteNroRecCliInt'		,
															'$fteAut'				,
															'$fteAutFecha'			,
															'$fteAudInt'			,
															'$fteAudIntFecha'		,
															'$fteAudExt'			,
															'$fteAudExtFecha'		,
															'$fteOtros'				,
															'$fteOtrosTxt'			,
															'$oriSisGes'			,
															'$oriSisGesFecha'		,
															'$oriEnsayos'			,
															'$oriNroAso'			,
															'$oriLeyReg'			,
															'$oriLeyRegFecha'		,
															'$oriTnc'				,
															'$oriTncFecha'			,
															'$oriInterLab'			,
															'$oriInterLabFecha'		,
															'$oriOtros'				,
															'$oriOtrosTxt'			,
															'$desClasNoConf'		,
															'$desClasObs'			,
															'$desIdentificacion'	,
															'$desHallazgo'			,
															'$desEvidencia'			,
															'$Causa'				,
															'$accCorrecion'			,
															'$accAccionCorrectiva'	,
															'$accFechaImp'			,
															'$accFechaTen'			,
															'$accFechaApli'			,
															'$accFechaVer'			,
															'$verResAccCorr'		,
															'$usrEncargado'			,
															'$usrCalidad'			,
															'$usrResponsable'
					)");
		}
		$link->close();
		$nInformePreventiva	= '';
		$accion				= '';
	}

	if(isset($_POST['guardarSeguimientoRAM'])){
		$verCierreAccion	= 'on';
		$fechaCierre 		= date('Y-m-d');
		$link=Conectarse();
		$actSQL="UPDATE accionesPreventivas SET ";
		$actSQL.="fechaCierre				='".$fechaCierre.		"',";
		$actSQL.="verCierreAccion			='".$verCierreAccion.	"'";
		$actSQL.="WHERE nInformePreventiva 	= '".$nInformePreventiva."'";
		$bdCot=$link->query($actSQL);
		$link->close();
		$nInformePreventiva = '';
		$accion				= '';
	}

?>
<!doctype html>
 
<html lang="es">
<head>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Acción de riesgo y oportunidades(ARO)</title>
	
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	


	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">



</head>

<body>
	<?php include('head.php'); ?>
	<div class="row bg-danger text-white">
		<div class="col-1 text-center" style="padding: 5px;">
			<img src="../imagenes/about_us_close_128.png" width="40">
		</div>
		<div class="col-10" style="padding-top: 5px;">
			<h4>Acción de riesgo y oportunidades (ARO)</h4>
		</div>
		<div class="col-1" style="padding-top: 5px;">
			<a href="cerrarsesion.php" title="Cerrar Sesión">
				<img src="../gastos/imagenes/preview_exit_32.png" width="32" height="32">
			</a>
		</div>
	</div>
	
	<?php include_once('formularioARO.php'); ?>
	
	<script src="../jsboot/bootstrap.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	
	<script>
		$(document).ready(function() {
    		$('#example').DataTable();
		} );	
	</script>

</body>
</html>
