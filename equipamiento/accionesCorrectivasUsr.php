<?php
	session_start(); 
	include_once("conexion.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=mysql_query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysql_fetch_array($bdPer)){
			$_SESSION['Perfil']		= $rowPer['Perfil'];
			$_SESSION['IdPerfil']	= $rowPer['IdPerfil'];
		}
		mysql_close($link);
	}else{
		header("Location: ../index.php");
	}
	$usuario 			= $_SESSION['usuario'];
	$nInformeCorrectiva = '';
	$accion				= '';
	$usrApertura 		= $_SESSION['usr'];
	if(isset($_GET[nInformeCorrectiva])){ $nInformeCorrectiva	= $_GET[nInformeCorrectiva];}
	if(isset($_GET[accion])) 			{ $accion				= $_GET[accion]; 			}

	if(isset($_POST[nInformeCorrectiva])){ $nInformeCorrectiva = $_POST[nInformeCorrectiva];}
	if(isset($_POST[accion])) 			 { $accion		 		= $_POST[accion]; 			}

	if($accion=='Imprimir'){
		header("Location: iAC.php?nInformeCorrectiva=$nInformeCorrectiva");
	}

	if(isset($_POST[NOcerrarAccionCorrectiva])){
		$verCierreAccion	= 'on';
		$fechaCierre 		= date('Y-m-d');
		$link=Conectarse();
		$actSQL="UPDATE accionesCorrectivas SET ";
		$actSQL.="fechaCierre				='".$fechaCierre.		"',";
		$actSQL.="verCierreAccion			='".$verCierreAccion.	"'";
		$actSQL.="WHERE nInformeCorrectiva 	= '".$nInformeCorrectiva."'";
		$bdCot=mysql_query($actSQL);
		mysql_close($link);
		$nInformeCorrectiva = '';
		$accion				= '';
	}
	
	if(isset($_POST[guardarAccionCorrectiva])){
		$fechaApertura 		= $_POST[fechaApertura];

		$fteRecCliExt	 		= $_POST[fteRecCliExt];
		if($fteRecCliExt=='on')	{ 
			$fteNroRecCliExt 	= $_POST[fteNroRecCliExt]; 
		}else{
			$fteNroRecCliExt 	= ''; 
		}

		$fteRecCliInt	 		= $_POST[fteRecCliInt];
		if($fteRecCliInt=='on')	{ 
			$fteNroRecCliInt 	= $_POST[fteNroRecCliInt];
		}else{
			$fteNroRecCliInt 	= '';
		}

		$fteAut			 		= $_POST[fteAut];
		if($fteAut=='on')	{ 
			$fteAutFecha	 	= $_POST[fteAutFecha];
		}else{
			$fteAutFecha	 	= '0000-00-00';
		}

		$fteAudInt		 		= $_POST[fteAudInt];
		if($fteAudInt=='on')	{ 
			$fteAudIntFecha	 	= $_POST[fteAudIntFecha];
		}else{
			$fteAudIntFecha	 	= '0000-00-00';
		}
		
		$fteAudExt		 		= $_POST[fteAudExt];
		if($fteAudExt=='on')	{ 
			$fteAudExtFecha	 	= $_POST[fteAudExtFecha];
		}else{
			$fteAudExtFecha	 	= '0000-00-00';
		}
		$fteOtros		 		= $_POST[fteOtros];
		
		$oriSisGes 				= $_POST[oriSisGes];
		if($oriSisGes=='on')	{ 
			$oriSisGesFecha		 = $_POST[oriSisGesFecha];
		}else{
			$oriSisGesFecha		 = '0000-00-00';
		}
		
		$oriEnsayos			 	= $_POST[oriEnsayos];
		if($oriEnsayos=='on')	{ 
			$oriNroAso			= $_POST[oriNroAso];
		}else{
			$oriNroAso			= '';
		}

		$oriLeyReg			 	= $_POST[oriLeyReg];
		if($oriLeyReg=='on')	{ 
			$oriLeyRegFecha		= $_POST[oriLeyRegFecha];
		}else{
			$oriLeyRegFecha		= '0000-00-00';
		}
		
		$oriTnc				 	= $_POST[oriTnc];
		if($oriTnc=='on')	{ 
			$oriTncFecha		= $_POST[oriTncFecha];
		}else{
			$oriTncFecha		= '0000-00-00';
		}
		
		$oriInterLab		 	= $_POST[oriInterLab];
		if($oriInterLab=='on')	{ 
			$oriInterLabFecha	= $_POST[oriInterLabFecha];
		}else{
			$oriInterLabFecha	= '0000-00-00';
		}
		
		$oriOtros			 	= $_POST[oriOtros];
		$Clasificacion		 	= $_POST[Clasificacion];
		if($Clasificacion=='N'){
			$desClasNoConf		= 'on';
			$desClasObs			= ' ';
		}
		if($Clasificacion=='O'){
			$desClasNoConf		= ' ';
			$desClasObs			= 'on';
		}
		$desIdentificacion	 	= $_POST[desIdentificacion];
		$desHallazgo		 	= $_POST[desHallazgo];
		$desEvidencia		 	= $_POST[desEvidencia];
		$Causa				 	= $_POST[Causa];
		$accCorrecion		 	= $_POST[accCorrecion];
		$accAccionCorrectiva	= $_POST[accAccionCorrectiva];
		$fd = explode('-', $_POST[accFechaImp]);
		if($fd[0] > 0){
			$accFechaImp		= $_POST[accFechaImp];
		}else{
			$accFechaImp		= '0000-00-00';
		}
		
		$fd = explode('-', $_POST[accFechaTen]);
		if($fd[0] > 0){
			$accFechaTen		= $_POST[accFechaTen];
		}else{
			$accFechaTen		= '0000-00-00';
		}

		$fd = explode('-', $_POST[accFechaVer]);
		if($fd[0] > 0){
			$accFechaVer		= $_POST[accFechaVer];
		}else{
			$accFechaVer		= '0000-00-00';
		}

		$fd = explode('-', $_POST[accFechaApli]);
		if($fd[0] > 0){
			$accFechaApli		= $_POST[accFechaApli];
		}else{
			$accFechaApli		= '0000-00-00';
		}
		
		$verResAccCorr		 	= $_POST[verResAccCorr];
		$usrEncargado		 	= $_POST[usrEncargado];
		$usrResponsable		 	= $_POST[usrResponsable];
		$accion			 		= $_POST[accion];
		
		$link=Conectarse();
		$bdCot=mysql_query("Select * From accionesCorrectivas Where nInformeCorrectiva = '".$nInformeCorrectiva."'");
		if($rowCot=mysql_fetch_array($bdCot)){
			$actSQL="UPDATE accionesCorrectivas SET ";
			$actSQL.="fechaApertura				='".$fechaApertura.		"',";
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
			$actSQL.="usrResponsable			='".$usrResponsable.	"'";
			$actSQL.="WHERE nInformeCorrectiva	= '".$nInformeCorrectiva."'";
			$bdCot=mysql_query($actSQL);
		}else{
			mysql_query("insert into accionesCorrectivas(	
															nInformeCorrectiva,
															fechaApertura,
															usrApertura,
															fteRecCliExt,
															fteNroRecCliExt,
															fteRecCliInt,
															fteNroRecCliInt,
															fteAut,
															fteAutFecha,
															fteAudInt,
															fteAudIntFecha,
															fteAudExt,
															fteAudExtFecha,
															fteOtros,
															oriSisGes,
															oriSisGesFecha,
															oriEnsayos,
															oriNroAso,
															oriLeyReg,
															oriLeyRegFecha,
															oriTnc,
															oriTncFecha,
															oriInterLab,
															oriInterLabFecha,
															oriOtros,
															desClasNoConf,
															desClasObs,
															desIdentificacion,
															desHallazgo,
															desEvidencia,
															Causa,
															accCorrecion,
															accAccionCorrectiva,
															accFechaImp,
															accFechaTen,
															accFechaApli,
															accFechaVer,
															verResAccCorr,
															usrEncargado,
															usrResponsable
															) 
												values 	(	
															'$nInformeCorrectiva',
															'$fechaApertura',
															'$usrApertura',
															'$fteRecCliExt',
															'$fteNroRecCliExt',
															'$fteRecCliInt',
															'$fteNroRecCliInt',
															'$fteAut',
															'$fteAutFecha',
															'$fteAudInt',
															'$fteAudIntFecha',
															'$fteAudExt',
															'$fteAudExtFecha',
															'$fteOtros',
															'$oriSisGes',
															'$oriSisGesFecha',
															'$oriEnsayos',
															'$oriNroAso',
															'$oriLeyReg',
															'$oriLeyRegFecha',
															'$oriTnc',
															'$oriTncFecha',
															'$oriInterLab',
															'$oriInterLabFecha',
															'$oriOtros',
															'$desClasNoConf',
															'$desClasObs',
															'$desIdentificacion',
															'$desHallazgo',
															'$desEvidencia',
															'$Causa',
															'$accCorrecion',
															'$accAccionCorrectiva',
															'$accFechaImp',
															'$accFechaTen',
															'$accFechaApli',
															'$accFechaVer',
															'$verResAccCorr',
															'$usrEncargado',
															'$usrResponsable'
					)",
			$link);
		}
		mysql_close($link);
		$nInformeCorrectiva	= '';
		$accion				= '';
	}

	if(isset($_POST[guardarSeguimientoRAM])){
		$verCierreAccion	= 'on';
		$fechaCierre 		= date('Y-m-d');
		$link=Conectarse();
		$actSQL="UPDATE accionesCorrectivas SET ";
		$actSQL.="fechaCierre				='".$fechaCierre.		"',";
		$actSQL.="verCierreAccion			='".$verCierreAccion.	"'";
		$actSQL.="WHERE nInformeCorrectiva 	= '".$nInformeCorrectiva."'";
		$bdCot=mysql_query($actSQL);
		mysql_close($link);
		$nInformeCorrectiva = '';
		$accion				= '';
	}

?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Intranet Simet -> Acciones Correctivas</title>
	
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	

	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<script>
	function realizaProceso(dBuscar){
		var parametros = {
			"dBuscar" 	: dBuscar
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'muestraCorrectivasUsr.php',
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
			url: 'regCorrectivaUsr.php',
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

<body>
	<?php include('head.php'); ?>
	<div id="linea"></div>
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
				<div id="ImagenBarra">
					<a>
					<img src="../gastos/imagenes/r_x.png"  width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="../plataformaErp.php" title="Menú Principal">
						<img src="../gastos/imagenes/Menu.png" width="32" height="32">
					</a>
				</div>
			</div>
			<?php include_once('listaCorrectivasUsr.php'); 
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
			if($accion == 'Actualizar'){?>
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
	
	
</body>
</html>
