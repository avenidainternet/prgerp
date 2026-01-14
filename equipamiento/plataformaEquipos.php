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
	$nSerie 		= 0;
	$realizadaMan 	= '';
	$fechaAccionMan = '0000-00-00';
	$fechaRegMan	= '0000-00-00';
	$realizadaVer	= '';
	$registradaMan	= '';
	$registradaVer	= '';
	$realizadaVer	= '';
/*
	if($_SESSION[Perfil] != 'WebMaster'){
		header("Location: ../enConstruccion.php");
	}
*/
	$usuario 			= $_SESSION['usuario'];
	$nSerie 			= '';
	$accion				= '';
	$usrApertura 		= $_SESSION['usr'];
	$usrRes 			= $_SESSION['usr'];
	$realizadaCal 		= '';
	$registradaCal 		= '';
	$necesitaCal 		= '';
	$necesitaVer 		= '';
	$necesitaMan 		= '';
	$Referencia			= '';
	$fechaMa 			= '0000-00-00';
	$borraFormulario	= '';
	$AccionEquipo 		= '';
	$fechaAccionCal		= '0000-00-00';
	$fechaRegCal		= '0000-00-00';
	
	if(isset($_GET['nSerie']))			{ $nSerie			= $_GET['nSerie']; 			}
	if(isset($_GET['accion']))			{ $accion			= $_GET['accion']; 			}
	if(isset($_GET['tpAccion']))		{ $tpAccion			= $_GET['tpAccion']; 		}
	if(isset($_GET['borraFormulario']))	{ $borraFormulario	= $_GET['borraFormulario']; }
	if(isset($_GET['AccionEquipo']))	{ $AccionEquipo		= $_GET['AccionEquipo']; 	}

	if(isset($_POST['nSerie']))		{ $nSerie 	= $_POST['nSerie'];		}
	if(isset($_POST['accion']))		{ $accion	= $_POST['accion']; 	}
	if(isset($_POST['tpAccion']))	{ $tpAccion	= $_POST['tpAccion']; 	}

	$link=Conectarse();
	$bddCot=$link->query("Select * From equipos Order By nSerie");
	if($rowdCot=mysqli_fetch_array($bddCot)){
		//$nSerie = $rowdCot[nSerie];
	}else{
		$accion = 'Vacio';
	}
	$link->close();

	if($borraFormulario > 0){
		$link=Conectarse();
		$bdProv=$link->query("DELETE FROM equiposForm WHERE nSerie = '".$nSerie."' and AccionEquipo = '".$AccionEquipo."' and Formulario = '".$borraFormulario."'");
		$link->close();
	}
	
	if($accion=='Imprimir'){
		header("Location: formularios/fichaEquipo.php?nSerie=$nSerie");
	}
	
	if(isset($_POST['cerrarAccionCorrectiva'])){
		$verCierreAccion	= 'on';
		$fechaCierre 		= date('Y-m-d');
		$link=Conectarse();
		$actSQL="UPDATE equipos SET ";
		$actSQL.="fechaCierre		='".$fechaCierre.		"',";
		$actSQL.="verCierreAccion	='".$verCierreAccion.	"'";
		$actSQL.="WHERE nSerie 		= '".$nSerie."'";
		$bdCot=$link->query($actSQL);
		$link->close();
		$nSerie = '';
		$accion				= '';
	}

	if(isset($_POST['confirmarBorrar'])){
		$link=Conectarse();
		$bdCot =$link->query("Delete From equipos Where nSerie = '".$nSerie."'");
		$link->close();
		$nSerie = '';
		$accion	= '';
	}
	
	if(isset($_POST['guardarSeguimiento'])){
		if(isset($_POST['nSerie']))				{ $nSerie 			= $_POST['nSerie'];				}
		if(isset($_POST['realizadaCal']))		{ $realizadaCal 	= $_POST['realizadaCal'];		}
		if(isset($_POST['fechaAccionCal']))		{ $fechaAccionCal	= $_POST['fechaAccionCal'];		}
		if(isset($_POST['registradaCal']))		{ $registradaCal	= $_POST['registradaCal'];		}
		if(isset($_POST['fechaRegCal']))		{ $fechaRegCal		= $_POST['fechaRegCal'];		}

		if(isset($_POST['realizadaVer']))		{ $realizadaVer 	= $_POST['realizadaVer'];		}
		if(isset($_POST['fechaAccionVer']))		{ $fechaAccionVer	= $_POST['fechaAccionVer'];		}
		if(isset($_POST['registradaVer']))		{ $registradaVer	= $_POST['registradaVer'];		}
		if(isset($_POST['fechaRegVer']))		{ $fechaRegVer		= $_POST['fechaRegVer'];		}

		if(isset($_POST['realizadaMan']))		{ $realizadaMan 	= $_POST['realizadaMan'];		}
		if(isset($_POST['fechaAccionMan']))		{ $fechaAccionMan	= $_POST['fechaAccionMan'];		}
		if(isset($_POST['registradaMan']))		{ $registradaMan	= $_POST['registradaMan'];		}
		if(isset($_POST['fechaRegMan']))		{ $fechaRegMan		= $_POST['fechaRegMan'];		}

		if(isset($_POST['Referencia']))			{ $Referencia		= $_POST['Referencia'];			}

		$link=Conectarse();
		$bdCot=$link->query("Select * From equipos Where nSerie = '".$nSerie."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$usrResponsable 	= $rowCot['usrResponsable'];
			$fechaTentativaCal 	= $rowCot['fechaProxCal'];
			$fechaTentativaVer 	= $rowCot['fechaProxVer'];
			$fechaTentativaMan 	= $rowCot['fechaProxMan'];
			
			if($realizadaCal=='on'){
				$tpoProxCal 	= $rowCot['tpoProxCal'];
				$fechaProxCal 	= strtotime ( '+'.$tpoProxCal.' day' , strtotime ( $fechaAccionCal ) );
				$fechaProxCal 	= date ( 'Y-m-d' , $fechaProxCal );
			}
			$actSQL="UPDATE equipos SET ";
			$actSQL.="realizadaCal		='".$realizadaCal.	"',";
			$actSQL.="fechaAccionCal	='".$fechaAccionCal."',";
			$actSQL.="registradaCal		='".$registradaCal.	"',";
			$actSQL.="fechaRegCal		='".$fechaRegCal.	"',";

			if($realizadaCal=='on'){
				$actSQL.="fechaCal		='".$fechaAccionCal	."',";
				$actSQL.="fechaProxCal	='".$fechaProxCal	."',";
			}

			if($realizadaVer=='on'){
				$tpoProxVer 	= $rowCot['tpoProxVer'];
				$fechaProxVer 	= strtotime ( '+'.$tpoProxVer.' day' , strtotime ( $fechaAccionVer ) );
				$fechaProxVer 	= date ( 'Y-m-d' , $fechaProxVer );
			}
			$actSQL.="realizadaVer		='".$realizadaVer.	"',";
			$actSQL.="fechaAccionVer	='".$fechaAccionVer."',";
			$actSQL.="registradaVer		='".$registradaVer.	"',";
			$actSQL.="fechaRegVer		='".$fechaRegVer.	"',";


			if($realizadaVer=='on'){
				$actSQL.="fechaVer		='".$fechaAccionVer	."',";
				$actSQL.="fechaProxVer	='".$fechaProxVer	."',";
			}
			if($realizadaMan=='on'){
				$tpoProxMan 	= $rowCot['tpoProxMan'];
				$fechaProxMan 	= strtotime ( '+'.$tpoProxMan.' day' , strtotime ( $fechaAccionMan ) );
				$fechaProxMan 	= date ( 'Y-m-d' , $fechaProxMan );
			}
			if($realizadaMan=='on'){
				$actSQL.="fechaMan		='".$fechaAccionMan	."',";
				$actSQL.="fechaProxMan	='".$fechaProxMan	."',";
			}
			$actSQL.="realizadaMan		='".$realizadaMan.	"',";
			$actSQL.="fechaAccionMan	='".$fechaAccionMan."',";
			$actSQL.="registradaMan		='".$registradaMan.	"',";
			$actSQL.="fechaRegMan		='".$fechaRegMan.	"'";

			$actSQL.="WHERE 	nSerie	= '".$nSerie."'";
			$bdCot=$link->query($actSQL);

			if($fechaRegCal > '000-00-00'){
				$Accion = 'Cal';
				$bdHis=$link->query("Select * From equiposHistorial Where nSerie = '".$nSerie."' and fechaTentativa = '".$fechaTentativaCal."' and Accion = '".$Accion."'");
				if($rowHis=mysqli_fetch_array($bdHis)){

				}else{
					$link->query("insert into equiposHistorial(	
																nSerie,
																fechaTentativa,
																fechaAccion,
																Accion,
																fechaRegistro,
																usrResponsable
																) 
													values 	(	
																'$nSerie',
																'$fechaTentativaCal',
																'$fechaAccionCal',
																'$Accion',
																'$fechaRegCal',
																'$usrResponsable'
						)");
				}
			}

			if($fechaRegVer > '000-00-00'){
				$Accion = 'Ver';
				$bdHis=$link->query("Select * From equiposHistorial Where nSerie = '".$nSerie."' and fechaTentativa = '".$fechaTentativaVer."' and Accion = '".$Accion."'");
				if($rowHis=mysqli_fetch_array($bdHis)){

				}else{
					$link->query("insert into equiposHistorial(	
																nSerie,
																fechaTentativa,
																fechaAccion,
																Accion,
																fechaRegistro,
																usrResponsable
																) 
													values 	(	
																'$nSerie',
																'$fechaTentativaVer',
																'$fechaAccionVer',
																'$Accion',
																'$fechaRegVer',
																'$usrResponsable'
						)");
				}
			}
			
			if($fechaRegMan > '000-00-00'){
				$Accion = 'Man';
				$bdHis=$link->query("Select * From equiposHistorial Where nSerie = '".$nSerie."' and fechaTentativa = '".$fechaTentativaMan."' and Accion = '".$Accion."'");
				if($rowHis=mysqli_fetch_array($bdHis)){

				}else{
					$link->query("insert into equiposHistorial(	
																nSerie,
																fechaTentativa,
																fechaAccion,
																Accion,
																fechaRegistro,
																usrResponsable
																) 
													values 	(	
																'$nSerie',
																'$fechaTentativaMan',
																'$fechaAccionMan',
																'$Accion',
																'$fechaRegMan',
																'$usrResponsable'
						)");
				}
			}
			
		}
		$link->close();
		$nSerie	= '';
		$accion	= '';
	}
	
	if(isset($_POST['quitarFormulario'])){
		if(isset($_POST['nSerie'])) 		{ $nSerie 			= $_POST['nSerie'];			}
		if(isset($_POST['nomEquipo'])) 		{ $nomEquipo 		= $_POST['nomEquipo'];		}
		echo $nSerie;
	}
		
	if(isset($_POST['guardarEquipo']) or isset($_POST['guardarEquipoSeguir'])){
		$Acreditado = '';
		if(isset($_POST['nSerie'])) 		{ $nSerie 			= $_POST['nSerie'];			}
		if(isset($_POST['nomEquipo'])) 		{ $nomEquipo 		= $_POST['nomEquipo'];		}
		if(isset($_POST['lugar'])) 			{ $lugar	 		= $_POST['lugar'];			}
		if(isset($_POST['tipoEquipo'])) 	{ $tipoEquipo		= $_POST['tipoEquipo'];		}
		if(isset($_POST['Acreditado'])) 	{ $Acreditado		= $_POST['Acreditado'];		}

		if(isset($_POST['necesitaCal']))	{ $necesitaCal 		= $_POST['necesitaCal'];	}
		if(isset($_POST['fechaCal'])) 		{ $fechaCal	 		= $_POST['fechaCal'];		}
		if(isset($_POST['tpoProxCal'])) 	{ $tpoProxCal	 	= $_POST['tpoProxCal'];		}
		if(isset($_POST['tpoAvisoCal']))	{ $tpoAvisoCal		= $_POST['tpoAvisoCal'];	}
		if(isset($_POST['fechaProxCal'])) 	{ $fechaProxCal		= $_POST['fechaProxCal'];	}

		if(isset($_POST['necesitaVer'])) 	{ $necesitaVer 		= $_POST['necesitaVer'];	}
		if(isset($_POST['fechaVer'])) 		{ $fechaVer	 		= $_POST['fechaVer'];		}
		if(isset($_POST['tpoProxVer'])) 	{ $tpoProxVer	 	= $_POST['tpoProxVer'];		}
		if(isset($_POST['tpoAvisoVer'])) 	{ $tpoAvisoVer		= $_POST['tpoAvisoVer'];	}
		if(isset($_POST['fechaProxVer'])) 	{ $fechaProxVer		= $_POST['fechaProxVer'];	}
		
		if(isset($_POST['necesitaMan'])) 	{ $necesitaMan 		= $_POST['necesitaMan'];	}
		if(isset($_POST['fechaMan'])) 		{ $fechaMan	 		= $_POST['fechaMan'];		}
		if(isset($_POST['tpoProxMan'])) 	{ $tpoProxMan	 	= $_POST['tpoProxMan'];		}
		if(isset($_POST['tpoAvisoMan'])) 	{ $tpoAvisoMan		= $_POST['tpoAvisoMan'];	}
		if(isset($_POST['fechaProxMan'])) 	{ $fechaProxMan		= $_POST['fechaProxMan'];	}
		
		if(isset($_POST['usrResponsable'])) { $usrResponsable	= $_POST['usrResponsable'];	}

		if(isset($_POST['Referencia'])) 	{ $Referencia		= $_POST['Referencia'];		}

		if(isset($_POST['FormularioCal'])) 	{ $FormularioCal	= $_POST['FormularioCal'];		}
		if(isset($_POST['FormularioVer'])) 	{ $FormularioVer	= $_POST['FormularioVer'];		}
		if(isset($_POST['FormularioMan'])) 	{ $FormularioMan	= $_POST['FormularioMan'];		}
		$Referencia = 'POC-27';

		echo 'Entra '.$nSerie.' '.$Referencia;
		
		$Formulario		= '';
		$AccionEquipo	= '';
		
		$link=Conectarse();
		if($FormularioCal){
			$SQLFor = "Select * From equiposForm Where nSerie = '".$nSerie."' and Formulario = $FormularioCal";
			$Formulario 	= $FormularioCal;
			$AccionEquipo	= 'Cal';
			$bdEF=$link->query($SQLFor);
			if($rowEF=mysqli_fetch_array($bdEF)){
			}else{
				$link->query("insert into equiposForm(	
																nSerie,
																AccionEquipo,
																Formulario
																) 
													values 	(	
																'$nSerie',
																'$AccionEquipo',
																'$Formulario'
						)");
			}
		}
		if($FormularioVer){
			$SQLFor = "Select * From equiposForm Where nSerie = '".$nSerie."' and Formulario = $FormularioVer";
			$Formulario 	= $FormularioVer;
			$AccionEquipo	= 'Ver';
			$bdEF=$link->query($SQLFor);
			if($rowEF=mysqli_fetch_array($bdEF)){
			}else{
				$link->query("insert into equiposForm(	
																nSerie,
																AccionEquipo,
																Formulario
																) 
													values 	(	
																'$nSerie',
																'$AccionEquipo',
																'$Formulario'
						)");
			}
		}
		if($FormularioMan){
			$SQLFor = "Select * From equiposForm Where nSerie = '".$nSerie."' and Formulario = $FormularioMan";
			$Formulario 	= $FormularioMan;
			$AccionEquipo	= 'Man';
			$bdEF=$link->query($SQLFor);
			if($rowEF=mysqli_fetch_array($bdEF)){
			}else{
				$link->query("insert into equiposForm(	
																nSerie,
																AccionEquipo,
																Formulario
																) 
													values 	(	
																'$nSerie',
																'$AccionEquipo',
																'$Formulario'
						)");
			}
		}
		
		$bdCot=$link->query("Select * From equipos Where nSerie = '".$nSerie."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$actSQL="UPDATE equipos SET ";
			$actSQL.="nomEquipo			='".$nomEquipo.		"',";
			$actSQL.="lugar				='".$lugar.			"',";
			$actSQL.="tipoEquipo		='".$tipoEquipo.	"',";
			$actSQL.="Acreditado		='".$Acreditado.	"',";
			$actSQL.="necesitaCal		='".$necesitaCal.	"',";
			$actSQL.="fechaCal			='".$fechaCal.		"',";
			$actSQL.="tpoProxCal		='".$tpoProxCal.	"',";
			$actSQL.="tpoAvisoCal		='".$tpoAvisoCal.	"',";
			$actSQL.="fechaProxCal		='".$fechaProxCal.	"',";
			$actSQL.="necesitaVer		='".$necesitaVer.	"',";
			$actSQL.="fechaVer			='".$fechaVer.		"',";
			$actSQL.="tpoProxVer		='".$tpoProxVer.	"',";
			$actSQL.="tpoAvisoVer		='".$tpoAvisoVer.	"',";
			$actSQL.="fechaProxVer		='".$fechaProxVer.	"',";
			$actSQL.="necesitaMan		='".$necesitaMan.	"',";
			$actSQL.="fechaMan			='".$fechaMan.		"',";
			$actSQL.="tpoProxMan		='".$tpoProxMan.	"',";
			$actSQL.="tpoAvisoMan		='".$tpoAvisoMan.	"',";
			$actSQL.="fechaProxMan		='".$fechaProxMan.	"',";
			$actSQL.="usrResponsable	='".$usrResponsable."',";
			$actSQL.="FormularioCal		='".$FormularioCal."',";
			$actSQL.="FormularioVer		='".$FormularioVer."',";
			$actSQL.="FormularioMan		='".$FormularioMan."',";
			$actSQL.="Referencia		='".$Referencia.	"'";
			$actSQL.="WHERE 	nSerie	= '".$nSerie."'";
			$bdCot=$link->query($actSQL);
		}else{
			$link->query("insert into equipos(	
															nSerie,
															nomEquipo,
															lugar,
															tipoEquipo,
															Acreditado,
															necesitaCal,
															fechaCal,
															tpoProxCal,
															tpoAvisoCal,
															fechaProxCal,
															necesitaVer,
															fechaVer,
															tpoProxVer,
															tpoAvisoVer,
															fechaProxVer,
															necesitaMan,
															fechaMan,
															tpoProxMan,
															tpoAvisoMan,
															fechaProxMan,
															usrResponsable,
															FormularioCal,
															FormularioVer,
															FormularioMan,
															Referencia
															) 
												values 	(	
															'$nSerie',
															'$nomEquipo',
															'$lugar',
															'$tipoEquipo',
															'$Acreditado',
															'$necesitaCal',
															'$fechaCal',
															'$tpoProxCal',
															'$tpoAvisoCal',
															'$fechaProxCal',
															'$necesitaVer',
															'$fechaVer',
															'$tpoProxVer',
															'$tpoAvisoVer',
															'$fechaProxVer',
															'$necesitaMan',
															'$fechaMa',
															'$tpoProxMan',
															'$tpoAvisoMan',
															'$fechaProxMan',
															'$usrResponsable',
															'$FormularioCal',
															'$FormularioVer',
															'$FormularioMan',
															'$Referencia'
					)");
		}
		$link->close();
		$nSerie	= '';
		$accion	= '';
		if(isset($_POST['guardarEquipoSeguir'])){
			$nSerie = $_POST['nSerie'];
			$accion = 'AgrForm';
		}
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
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Intranet Simet -> Equipamiento</title>
	
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	
	<script src="../jquery/jquery-1.6.4.js"></script> 

	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	<script src="../jsboot/bootstrap.min.js"></script>	
	<script type="text/javascript" src="../angular/angular.js"></script>

	<script>
	function realizaProceso(usrRes, tpAccion){
		var parametros = {
			"usrRes" 	: usrRes,
			"tpAccion"  : tpAccion
		};
		//alert(tpAccion);
		$.ajax({
			data: parametros,
			url: 'muestraEquipos.php',
			type: 'get',
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}
	
	function registraEquipo(nSerie, accion){
		var parametros = {
			"nSerie"	: nSerie,
			"accion"	: accion
		};
		//alert(nSerie);
		$.ajax({
			data: parametros,
			url: 'regEquipo.php',
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

	function seguimientoEquipo(nSerie, accion, tpAccion){
		var parametros = {
			"nSerie" 	: nSerie,
			"accion"	: accion,
			"tpAccion"	: tpAccion
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'segEquipo.php',
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
				<img src="../imagenes/equipamiento.png" width="40" height="40" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					Mantención Equipamiento 
				</strong>

				<div id="ImagenBarra">
					<a href="cerrarsesion.php" title="Cerrar Sesión">
						<img src="../gastos/imagenes/preview_exit_32.png" width="32" height="32">
					</a>
				</div>
			</div>
			<?php include_once('listaEquipos.php'); 
			if($accion == 'Seguimiento'){?>
				<script>
					var nSerie 		= "<?php echo $nSerie; ?>" ;
					var accion 		= "<?php echo $accion; ?>" ;
					var tpAccion 	= "<?php echo $tpAccion; ?>" ;
					seguimientoEquipo(nSerie, accion, tpAccion);
				</script>
				<?php
			}
			if($accion == 'Actualizar' or $accion == 'Borrar' or $accion == 'Vacio' or $accion == 'AgrForm'){
				?>
				<script>
					var nSerie 	= "<?php echo $nSerie; ?>" ;
					var accion 	= "<?php echo $accion; ?>" ;
					registraEquipo(nSerie, accion);
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
