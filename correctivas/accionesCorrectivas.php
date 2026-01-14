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
	
	$nInformeCorrectiva = '';
	$accion				= '';
	$fteRecCliExt 		= '';
	$fteRecCliInt 		= '';
	$fteAut 			= '';
	$fteAudExt 			= '';
	$oriSisGes 			= '';
	$oriEnsayos 		= '';
	$oriLeyReg 			= '';
	$oriTnc 			= '';
	$oriInterLab 		= '';
	$Clasificacion 		= '';
	$fteAut 			= '';
	$fteAudExt 			= '';
	$fteOtrosTxt		= '';
	$oriSisGes 			= '';
	$oriEnsayos 		= '';
	$oriLeyReg 			= '';
	$oriTnc 			= '';
	$oriInterLab 		= '';
	$oriOtros 			= '';
	$oriOtrosTxt		= '';
	$desClasNoConf 		= '';
	$desClasObs 		= '';
	$usrEncargado 		= '';
	$fteAudInt 			= '';
	$actRiesgos			= 'SI';
	$hallazgo			= 'SI';
	$nCorrectiva		= 0; 
	$Apelacion				= "";
	$fteApelacion			= "";
	$Certificacion			= "";
	$oriCertificacion		= "";

	$usrApertura 		= $_SESSION['usr']; 
	if(isset($_GET['nInformeCorrectiva']))	{ $nInformeCorrectiva	= $_GET['nInformeCorrectiva'];	}
	if(isset($_GET['accion'])) 				{ $accion				= $_GET['accion']; 				}

	if(isset($_POST['nInformeCorrectiva']))	{ $nInformeCorrectiva 	= $_POST['nInformeCorrectiva'];	}
	if(isset($_POST['accion'])) 			{ $accion		 		= $_POST['accion']; 			}

	if($accion=='Imprimir'){
		header("Location: iAC.php?nInformeCorrectiva=$nInformeCorrectiva");
	}
	
	if(isset($_POST['cerrarAccionCorrectiva'])){
		$verCierreAccion	= 'on';
		$fechaCierre 		= date('Y-m-d');
		$link=Conectarse();
		$actSQL="UPDATE accionesCorrectivas SET ";
		$actSQL.="fechaCierre				='".$fechaCierre.		"',";
		$actSQL.="verCierreAccion			='".$verCierreAccion.	"'";
		$actSQL.="WHERE nInformeCorrectiva 	= '".$nInformeCorrectiva."'";
		$bdCot=$link->query($actSQL);
		$link->close();
		$nInformeCorrectiva = '';
		$accion				= '';
	}

	if(isset($_POST['ReAbrirAccionCorrectiva'])){
		$verCierreAccion	= ' ';
		$fechaCierre 		= '0000-00-00';
		$link=Conectarse();
		$actSQL="UPDATE accionesCorrectivas SET ";
		$actSQL.="fechaCierre				='".$fechaCierre.		"',";
		$actSQL.="verCierreAccion			='".$verCierreAccion.	"'";
		$actSQL.="WHERE nInformeCorrectiva 	= '".$nInformeCorrectiva."'";
		$bdCot=$link->query($actSQL);
		$link->close();
		$nInformeCorrectiva = '';
		$accion				= '';
	}

	if(isset($_POST['confirmarBorrar'])){
		$link=Conectarse();
		$bdCot =$link->query("Delete From accionesCorrectivas Where nInformeCorrectiva = '".$nInformeCorrectiva."'");
		$link->close();
		$nInformeCorrectiva = '';
		$accion				= '';
	}
	
	if(isset($_POST['guardarAccionCorrectiva'])){
		if(isset($_POST['hallazgo'])) 			{ $hallazgo					= $_POST['hallazgo'];			}
		if(isset($_POST['actRiesgos'])) 		{ $actRiesgos				= $_POST['actRiesgos'];			}
		if(isset($_POST['nCorrectiva'])) 		{ $nCorrectiva				= $_POST['nCorrectiva'];		}
		if(isset($_POST['nInformeCorrectiva'])) { $nInformeCorrectiva		= $_POST['nInformeCorrectiva'];	}
		if(isset($_POST['fechaApertura'])) 		{ $fechaApertura 			= $_POST['fechaApertura'];		}
		// echo 'Hallazgo      ....'.$hallazgo;

		if(isset($_POST['fteRecCliExt'])) 		{ $fteRecCliExt	 			= $_POST['fteRecCliExt'];		}
		if($fteRecCliExt=='on')	{ 
			if(isset($_POST['fteNroRecCliExt'])) { $fteNroRecCliExt 		= $_POST['fteNroRecCliExt']; 	}
		}else{
			$fteNroRecCliExt 	= ''; 
		}

		if(isset($_POST['fteRecCliInt'])) 		{ $fteRecCliInt	 		= $_POST['fteRecCliInt'];			}
		if($fteRecCliInt=='on')	{ 
			if(isset($_POST['fteNroRecCliInt'])) { $fteNroRecCliInt 	= $_POST['fteNroRecCliInt'];	}
		}else{
			$fteNroRecCliInt 	= '';
		}

		if(isset($_POST['fteAut'])) 			{ $fteAut			 	= $_POST['fteAut'];				}
		if($fteAut=='on')	{ 
			if(isset($_POST['fteAutFecha'])) 	{ $fteAutFecha	 		= $_POST['fteAutFecha'];		}
		}else{
			$fteAutFecha	 	= '0000-00-00';
		}

		if(isset($_POST['fteAudInt'])) 			{ $fteAudInt		 	= $_POST['fteAudInt'];			}
		if($fteAudInt=='on')	{ 
			if(isset($_POST['fteAudIntFecha'])) { $fteAudIntFecha	 	= $_POST['fteAudIntFecha'];		}
		}else{
			$fteAudIntFecha	 	= '0000-00-00';
		}
		
		if(isset($_POST['fteAudExt'])) 			{ $fteAudExt		 	= $_POST['fteAudExt'];			}
		if($fteAudExt=='on')	{ 
			if(isset($_POST['fteAudExtFecha'])) { $fteAudExtFecha	 	= $_POST['fteAudExtFecha'];		}
		}else{
			$fteAudExtFecha	 	= '0000-00-00';
		}
		if(isset($_POST['fteOtrosTxt'])) 		{ $fteOtrosTxt	 		= $_POST['fteOtrosTxt'];		}
		
		if(isset($_POST['oriSisGes'])) 			{ $oriSisGes 			= $_POST['oriSisGes'];			}
		if($oriSisGes=='on')	{ 
			if(isset($_POST['oriSisGesFecha'])) { $oriSisGesFecha		= $_POST['oriSisGesFecha'];		}
		}else{
			$oriSisGesFecha		 = '0000-00-00';
		}
		
		if(isset($_POST['oriEnsayos'])) 		{ $oriEnsayos			 = $_POST['oriEnsayos'];		}
		if($oriEnsayos=='on')	{ 
			if(isset($_POST['oriNroAso'])) 		{ $oriNroAso			= $_POST['oriNroAso'];			}
		}else{
			$oriNroAso			= '';
		}

		if(isset($_POST['oriLeyReg'])) 			{ $oriLeyReg			= $_POST['oriLeyReg'];			}
		if($oriLeyReg=='on')	{ 
			if(isset($_POST['oriLeyRegFecha'])) { $oriLeyRegFecha		= $_POST['oriLeyRegFecha'];		}
		}else{
			$oriLeyRegFecha		= '0000-00-00';
		}
		
		if(isset($_POST['oriTnc'])) 			{ $oriTnc				= $_POST['oriTnc'];			}
		if($oriTnc=='on')	{ 
			if(isset($_POST['oriTncFecha'])) 	{ $oriTncFecha			= $_POST['oriTncFecha'];	}
		}else{
			$oriTncFecha		= '0000-00-00';
		}
		
		if(isset($_POST['oriInterLab'])) 		{ $oriInterLab		 	= $_POST['oriInterLab'];	}
		if($oriInterLab=='on')	{ 
			if(isset($_POST['oriInterLabFecha'])) { $oriInterLabFecha	= $_POST['oriInterLabFecha'];}
		}else{
			$oriInterLabFecha	= '0000-00-00';
		}
		
		if(isset($_POST['Clasificacion'])) 		{ $Clasificacion		 = $_POST['Clasificacion'];	}
		if($Clasificacion=='N'){
			$desClasNoConf		= 'on';
			$desClasObs			= ' ';
		}
		if($Clasificacion=='O'){
			$desClasNoConf		= ' ';
			$desClasObs			= 'on';
		}
		if(isset($_POST['desIdentificacion'])) 	{ $desIdentificacion	= $_POST['desIdentificacion'];	}
		if(isset($_POST['desHallazgo'])) 		{ $desHallazgo		 	= $_POST['desHallazgo'];		}
		if(isset($_POST['desEvidencia'])) 		{ $desEvidencia		 	= $_POST['desEvidencia'];		}
		if(isset($_POST['Causa'])) 				{ $Causa				= $_POST['Causa'];				}
		if(isset($_POST['accCorrecion'])) 		{ $accCorrecion		 	= $_POST['accCorrecion'];		}
		if(isset($_POST['accAccionCorrectiva'])){ $accAccionCorrectiva	= $_POST['accAccionCorrectiva'];}

		$accFechaImp	= '0000-00-00';
		if(isset($_POST['accFechaImp'])){ 		
			$fd = explode('-', $_POST['accFechaImp']);
			if($fd[0] > 0){
				$accFechaImp	= $_POST['accFechaImp'];
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
		if(isset($_POST['accFechaVer'])){ 		
			$fd = explode('-', $_POST['accFechaApli']);
			if($fd[0] > 0){
				$accFechaApli		= $_POST['accFechaApli'];
			}
		}
				
		if(isset($_POST['fechaCierre']))	{ $fechaCierre			= $_POST['fechaCierre'];	}
		if(isset($_POST['accFechaApli']))	{ $accFechaApli			= $_POST['accFechaApli'];	}
		if(isset($_POST['verResAccCorr']))	{ $verResAccCorr		= $_POST['verResAccCorr'];	}
		if(isset($_POST['usrEncargado']))	{ $usrEncargado		 	= $_POST['usrEncargado'];	}
		if(isset($_POST['usrResponsable']))	{ $usrResponsable		= $_POST['usrResponsable'];	}
		if(isset($_POST['usrCalidad']))		{ $usrCalidad			= $_POST['usrCalidad'];		}
		if(isset($_POST['accion']))			{ $accion			 	= $_POST['accion'];			}
		if(isset($_POST['fteApelacion'])) 	{ $fteApelacion 		= $_POST['fteApelacion'];	}
		if(isset($_POST['Apelacion'])) 		{ $Apelacion 			= $_POST['Apelacion'];		}
		if(isset($_POST['oriCertificacion'])){ $oriCertificacion	= $_POST['oriCertificacion'];}
		if(isset($_POST['Certificacion'])) 	{ $Certificacion 		= $_POST['Certificacion'];	}

		$link=Conectarse();
		$bdCot=$link->query("Select * From accionesCorrectivas Where nInformeCorrectiva = '".$nInformeCorrectiva."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$actSQL="UPDATE accionesCorrectivas SET ";
			$actSQL.="fechaCierre				='".$fechaCierre.		"',";
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
			$actSQL.="desClasNoConf				='".$desClasNoConf.		"',";
			$actSQL.="desClasObs				='".$desClasObs.		"',";
			$actSQL.="desIdentificacion			='".$desIdentificacion.	"',";
			$actSQL.="desHallazgo				='".$desHallazgo.		"',";
			$actSQL.="desEvidencia				='".$desEvidencia.		"',";
			$actSQL.="Causa						='".$Causa.				"',";
			$actSQL.="accCorrecion				='".$accCorrecion.		"',";
			$actSQL.="accAccionCorrectiva		='".$accAccionCorrectiva."',";
			$actSQL.="accFechaImp				='".$accFechaImp.		"',";
			$actSQL.="accFechaTen				='".$accFechaTen.		"',";
			$actSQL.="accFechaApli				='".$accFechaApli.		"',";
			$actSQL.="accFechaVer				='".$accFechaVer.		"',";
			$actSQL.="verResAccCorr				='".$verResAccCorr.		"',";
			$actSQL.="usrEncargado				='".$usrEncargado.		"',";
			$actSQL.="usrCalidad				='".$usrCalidad.		"',";
			$actSQL.="hallazgo					='".$hallazgo.			"',";
			$actSQL.="actRiesgos				='".$actRiesgos.		"',";
			$actSQL.="nCorrectiva				='".$nCorrectiva.		"',";
			$actSQL.="fteApelacion				='".$fteApelacion.		"',";
			$actSQL.="Apelacion					='".$Apelacion.			"',";
			$actSQL.="oriCertificacion			='".$oriCertificacion.	"',";
			$actSQL.="Certificacion				='".$Certificacion.		"',";
			$actSQL.="usrResponsable			='".$usrResponsable.	"'";
			$actSQL.="WHERE nInformeCorrectiva	= '".$nInformeCorrectiva."'";
			$bdCot=$link->query($actSQL);
		}else{
			$link->query("insert into accionesCorrectivas(	
															nInformeCorrectiva	,
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
															'$nInformeCorrectiva'	,
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
		$nInformeCorrectiva	= '';
		$accion				= '';
	}

	if(isset($_POST['guardarSeguimientoRAM'])){
		$verCierreAccion	= 'on';
		$fechaCierre 		= date('Y-m-d');
		$link=Conectarse();
		$actSQL="UPDATE accionesCorrectivas SET ";
		$actSQL.="fechaCierre				='".$fechaCierre.		"',";
		$actSQL.="verCierreAccion			='".$verCierreAccion.	"'";
		$actSQL.="WHERE nInformeCorrectiva 	= '".$nInformeCorrectiva."'";
		$bdCot=$link->query($actSQL);
		$link->close();
		$nInformeCorrectiva = '';
		$accion				= '';
	}

?>
<!doctype html>
 
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Intranet Simet -> Acciones Correctivas</title>
	
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	
	<script type="text/javascript" src="../angular/angular.js"></script>

	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">

	<script>
	function realizaProceso(dBuscar){
		var parametros = {
			"dBuscar" 	: dBuscar
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'muestraCorrectivas.php',
			type: 'get',
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}
	
	function registraEncuesta(nInformeCorrectiva, accion){
		var parametros = {
			"nInformeCorrectiva": nInformeCorrectiva,
			"accion"			: accion
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'regCorrectiva.php',
			type: 'get',
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}
	
	function buscarContactos(Cliente){
		var parametros = {
			"Cliente" 	: Cliente
		};
		//alert(Cliente);
		$.ajax({
			data: parametros,
			url: 'listaContactos.php',
			type: 'get',
			success: function (response) {
				$("#resultadoContacto").html(response);
			}
		});
	}
	
	function datosContactos(Cliente, Atencion){
		var parametros = {
			"Cliente" 	: Cliente,
			"Atencion"	: Atencion
		};
		//alert(Atencion);
		$.ajax({
			data: parametros,
			url: 'datosDelContacto.php',
			type: 'get',
			success: function (response) {
				$("#rDatosContacto").html(response);
			}
		});
	}

	function seguimientoCAM(CAM, Rev, Cta, accion){
		var parametros = {
			"CAM" 		: CAM,
			"Rev" 		: Rev,
			"Cta" 		: Cta,
			"accion"	: accion
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'segCAM.php',
			type: 'get',
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}

	function seguimientoRAM(CAM, RAM, Rev, Cta, accion){
		var parametros = {
			"CAM" 		: CAM,
			"RAM" 		: RAM,
			"Rev" 		: Rev,
			"Cta" 		: Cta,
			"accion"	: accion
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'segRAM.php',
			type: 'get',
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}

	function seguimientoAM(CAM, RAM, Rev, Cta, accion){
		var parametros = {
			"CAM" 		: CAM,
			"RAM" 		: RAM,
			"Rev" 		: Rev,
			"Cta" 		: Cta,
			"accion"	: accion
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'segAM.php',
			type: 'get',
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}

	function cambiarMoneda(CAM, RAM, Rev, Cta, accion){
		var parametros = {
			"CAM" 		: CAM,
			"RAM" 		: RAM,
			"Rev" 		: Rev,
			"Cta" 		: Cta,
			"accion"	: accion
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'segCAMvalores.php',
			type: 'get',
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}

	function verObservaciones(Descripcion, Observaciones){
		var parametros = {
			"Descripcion"	: Descripcion,
			"Observaciones" : Observaciones
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'verDesObs.php',
			type: 'get',
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}
	
	</script>

</head>

<body ng-app="myApp" ng-controller="CtrlCorrectivas">
	<?php include('head.php'); ?>
	<div id="Cuerpo">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<img src="../imagenes/about_us_close_128.png" width="40" height="40" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					Acciones Correctivas (AC) 
				</strong>

				<div id="ImagenBarra">
					<a href="cerrarsesion.php" title="Cerrar Sesión">
						<img src="../gastos/imagenes/preview_exit_32.png" width="32" height="32">
					</a>
				</div>
			</div>
			<?php include_once('listaCorrectivas.php'); 
			if($accion == 'Seguimiento'){?>
				<script>
					var CAM 	= "<?php echo $CAM; ?>" ;
					var Rev 	= "<?php echo $Rev; ?>" ;
					var Cta 	= "<?php echo $Cta; ?>" ;
					var accion 	= "<?php echo $accion; ?>" ;
					seguimientoCAM(CAM, Rev, Cta, accion);
				</script>
				<?php
			}
			if($accion == 'Actualizar' or $accion == 'Borrar'){?>
				<script>
					var nInformeCorrectiva 	= "<?php echo $nInformeCorrectiva; ?>" ;
					var accion 				= "<?php echo $accion; ?>" ;
					registraEncuesta(nInformeCorrectiva, accion);
				</script>
				<?php
			}
			?>
		</div>
		<div style="clear:both;"></div>
				
	</div>
	<br>
	
	<script src="../jsboot/bootstrap.min.js"></script>
	<script src="correctivas.js"></script>

</body>
</html>
