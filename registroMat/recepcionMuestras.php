<?php
	session_start(); 
/*
	include_once("Mobile-Detect-2.3/Mobile_Detect.php");
 	$Detect = new Mobile_Detect();
	date_default_timezone_set("America/Santiago");
		//if ($Detect->IsMobile()) {
		//	header("Location: http://simet.cl/mobil/");
		//}
*/		
	$maxCpo = '81%';
	include_once("../conexionli.php");
	$accion 	= '';
	$CAM 		= 0;
	$nContacto 	= 0;
	
	if(isset($_GET['RutCli'])) 	{	$RutCli	= $_GET['RutCli']; 	}
	if(isset($_GET['RAM'])) 	{	$RAM 	= $_GET['RAM']; 	}
	if(isset($_GET['accion'])) 	{	$accion = $_GET['accion']; 	}
	
	if(isset($_POST['RAM'])) 	{	$RAM 	= $_POST['RAM']; 		}
	if(isset($_POST['accion'])) {	$accion = $_POST['accion']; 	}
	
	if(isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']		= $rowPer['Perfil'];
			$_SESSION['IdPerfil']	= $rowPer['IdPerfil'];
		}
		$link->close();
	}else{
		//header("Location: http://simet.cl");
		header("Location: ../index.php");
	}
	if(isset($_POST['Cerrar'])){
		header("Location: cerrarsesion.php");
	}

	if(isset($_POST['imprimirRAM'])){
		$CAM = $_POST['CAM'];
		$RAM = $_POST['RAM'];
		header("Location: formularios/iRAM.php?RAM=".$RAM."&CAM=5751");
		$RAM 	= '';
		$accion	= '';
	}
	if(isset($_POST['confirmarBorrar'])){
		$link=Conectarse();
		$bdCot =$link->query("Delete From registroMuestras Where RAM = '".$RAM."'");
		$link->close();
		$RAM 	= '';
		$accion	= '';
	}

	if(isset($_POST['dardeBaja'])){
		$situacionMuestra = 'B';
		$link=Conectarse();
		$actSQL="UPDATE registroMuestras SET ";
		$actSQL.="situacionMuestra	='".$situacionMuestra.	"'";
		$actSQL.="WHERE RAM			= '".$RAM."'";
		$bdRam=$link->query($actSQL);
		$link->close();
		$RAM 	= '';
		$accion	= '';
	}

	if(isset($_POST['confirmarActivacion'])){
		$RAM = $_POST['RAM'];
		if($RAM > 0){
			$situacionMuestra 	= 'R';
			$CAM				= 0;
			$link=Conectarse();
			$actSQL="UPDATE registroMuestras SET ";
			$actSQL.="CAM				='".$CAM.				"',";
			$actSQL.="situacionMuestra	='".$situacionMuestra.	"'";
			$actSQL.="WHERE RAM			= '".$RAM."'";
			$bdRam=$link->query($actSQL);
			$link->close();
		}
		$RAM 	= '';
		$accion	= '';
	}
	
	if(isset($_POST['clonarRAM'])){
		if(isset($_POST['RAM'])) 	{	$RAM 	= $_POST['RAM'];	}
		if(isset($_POST['Copias'])) {	$Copias	= $_POST['Copias'];	}
		$CAM 			= '';
		$fechaRegistro 	= '';
		$usrRecepcion	= '';
		$RutCli			= '';
		$nContacto		= '';
		$Descripcion	= '';
		$situacionMuestra = 'R';
		$Fan			= 0;
		
		$link=Conectarse();
		$bdRAM=$link->query("Select * From registroMuestras Where RAM = '".$RAM."' and Fan = '".$Fan."'");
		if($rowRAM=mysqli_fetch_array($bdRAM)){
			$CAM 			= $rowRAM['CAM'];
			$fechaRegistro 	= $rowRAM['fechaRegistro'];
			$usrRecepcion	= $rowRAM['usrRecepcion'];
			$RutCli			= $rowRAM['RutCli'];
			$nContacto		= $rowRAM['nContacto'];
			$Descripcion	= $rowRAM['Descripcion'];
		}
		$link->close();
		if($Copias > 0){
			$link=Conectarse();
			for($Fan=1; $Fan<=$Copias; $Fan++){
				$bdRAM=$link->query("Select * From registroMuestras Where RAM = '".$RAM."' and Fan = '".$Fan."'");
				if($rowRAM=mysqli_fetch_array($bdRAM)){
				}else{
					$link->query("insert into registroMuestras(	RAM,
																CAM,
																Fan,
																fechaRegistro,
																usrRecepcion,
																RutCli,
																nContacto,
																Descripcion,
																situacionMuestra
																) 
													values 	(	'$RAM',
																'$CAM',
																'$Fan',
																'$fechaRegistro',
																'$usrRecepcion',
																'$RutCli',
																'$nContacto',
																'$Descripcion',
																'$situacionMuestra'
					)",$link);
				}
			}
			$link->close();
		}
	}
	
	if(isset($_POST['confirmarGuardar'])){
		if(isset($_POST['CAM'])) 				{ 	$CAM 				= $_POST['CAM']; 				}
		if(isset($_POST['RAM'])) 				{	$RAM 				= $_POST['RAM'];				}
		if(isset($_POST['fechaRegistro'])) 		{	$fechaRegistro		= $_POST['fechaRegistro'];		}
		if(isset($_POST['usrRecepcion'])) 		{	$usrRecepcion		= $_POST['usrRecepcion'];		}
		if(isset($_POST['RutCli'])) 			{	$RutCli				= $_POST['RutCli'];				}
		if(isset($_POST['Descripcion'])) 		{	$Descripcion		= $_POST['Descripcion'];		}
		if(isset($_POST['situacionMuestra'])) 	{	$situacionMuestra	= $_POST['situacionMuestra'];	}
		if(isset($_POST['Copias'])) 			{	$Copias				= $_POST['Copias'];				}
		if($CAM > 0){
			$situacionMuestra = 'P'; // PAM
		}else{
			$situacionMuestra = 'R'; // Muestra Registrada
		}
		if(isset($_POST['nContacto'])) 			{	$nContacto			= $_POST['nContacto'];			}
		
		$link=Conectarse();
		$bdRam=$link->query("Select * From registroMuestras Where RAM = '".$RAM."'");
		if($rowRam=mysqli_fetch_array($bdRam)){
			$actSQL="UPDATE registroMuestras SET ";
			$actSQL.="CAM	 			='".$CAM.				"',";
			$actSQL.="Copias	 		='".$Copias.			"',";
			$actSQL.="fechaRegistro	 	='".$fechaRegistro.		"',";
			$actSQL.="usrRecepcion 	 	='".$usrRecepcion.		"',";
			$actSQL.="RutCli 			='".$RutCli.			"',";
			$actSQL.="nContacto			='".$nContacto.			"',";
			$actSQL.="Descripcion		='".$Descripcion.		"',";
			$actSQL.="situacionMuestra	='".$situacionMuestra.	"'";
			$actSQL.="WHERE RAM			= '".$RAM."'";
			$bdRam=$link->query($actSQL);
		}else{
			$link->query("insert into registroMuestras(	RAM,
														CAM,
														fechaRegistro,
														usrRecepcion,
														RutCli,
														nContacto,
														Descripcion,
														situacionMuestra
														) 
											values 	(	'$RAM',
														'$CAM',
														'$fechaRegistro',
														'$usrRecepcion',
														'$RutCli',
														'$nContacto',
														'$Descripcion',
														'$situacionMuestra'
			)",$link);
		}
		if($CAM > 0){
			// Guardar RAM en la CAM
			$bdCot=$link->query("Select * From Cotizaciones Where CAM = '".$CAM."'");
			if($rowCot=mysqli_fetch_array($bdCot)){
				$actSQL="UPDATE Cotizaciones SET ";
				$actSQL.="RAM	 	= '".$RAM. "'";
				$actSQL.="WHERE CAM	= '".$CAM. "'";
				$bdCot=$link->query($actSQL);
			}
		}else{
			$bdCot=$link->query("Select * From Cotizaciones Where RAM = '".$RAM."'");
			if($rowCot=mysqli_fetch_array($bdCot)){
				$RAM = 0;
				$CAM = $rowCot['CAM'];
				$actSQL="UPDATE Cotizaciones SET ";
				$actSQL.="RAM	 	= '".$RAM. "'";
				$actSQL.="WHERE CAM	= '".$CAM. "'";
				$bdCot=$link->query($actSQL);
			}
		}
		$link->close();
		if($Copias > 0){
			$link=Conectarse();
			for($Fan=1; $Fan<=$Copias; $Fan++){
				$bdRAM=$link->query("Select * From registroMuestras Where RAM = '".$RAM."' and Fan = '".$Fan."'");
				if($rowRAM=mysqli_fetch_array($bdRAM)){
				}else{
					$link->query("insert into registroMuestras(	RAM,
																CAM,
																Fan,
																fechaRegistro,
																usrRecepcion,
																RutCli,
																nContacto,
																Descripcion,
																situacionMuestra
																) 
													values 	(	'$RAM',
																'$CAM',
																'$Fan',
																'$fechaRegistro',
																'$usrRecepcion',
																'$RutCli',
																'$nContacto',
																'$Descripcion',
																'$situacionMuestra'
					)",$link);
				}
			}
			$link->close();
		}

		//header("Location: formularios/iRAM.php?RAM=".$RAM."&CAM=5751");

		$accion = '';
	}	
	
?>
<!doctype html>
 
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="shortcut icon" href="favicon.ico" />
	<link rel="apple-touch-icon" href="touch-icon-iphone.png" />
	<link rel="apple-touch-icon" href="touch-icon-ipad.png" />
	<link rel="apple-touch-icon" href="touch-icon-iphone4.png" /> 

	<title>SIMET - Recepción de Muestras</title>

	<link href="../css/stylesTv.css" rel="stylesheet" type="text/css">
	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<script type="text/javascript" src="../jquery/libs/1/jquery.min.js"></script>	

	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>

	<script>
	function muestraInventario(RutCli, accion){
		var parametros = {
			"RutCli" 	: RutCli,
			"accion" 	: accion
		};
		//alert(RutCli);
		$.ajax({
			data: parametros,
			url: 'listaMuestras.php',
			type: 'get',
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}
	
	function muestraCAMs(RutCli, accion){
		var parametros = {
			"RutCli" 	: RutCli,
			"accion" 	: accion
		};
		//alert(RutCli);
		$.ajax({
			data: parametros,
			url: 'listaCAMs.php',
			type: 'get',
			success: function (response) {
				$("#resultadoCAMs").html(response);
			}
		});
	}

	function registrarMuestra(RAM, accion){
		var parametros = {
			"RAM" 		: RAM,
			"accion" 	: accion
		};
		//alert(accion);
		$.ajax({
			data: parametros,
			url: 'regMuestras.php',
			type: 'get',
			success: function (response) {
				$("#regMuestrasRAM").html(response);
			}
		});
	}

	function activarMuestra(RAM, accion){
		var parametros = {
			"RAM" 		: RAM,
			"accion" 	: accion
		};
		//alert(RAM);
		$.ajax({
			data: parametros,
			url: 'actMuestras.php',
			type: 'get',
			success: function (response) {
				$("#regMuestrasRAM").html(response);
			}
		});
	}

	function buscarContactos(RutCli, nContacto, RAM){
		var parametros = {
			"RutCli" 	: RutCli,
			"nContacto" : nContacto,
			"RAM" 		: RAM
		};
		//alert(RAM);
		$.ajax({
			data: parametros,
			url: 'listaContactos.php',
			type: 'get',
			success: function (response) {
				$("#resultadoContacto").html(response);
			}
		});
	}
	function verCodigoBarra(RutCli, RAM){
		var parametros = {
			"RutCli" 	: RutCli,
			"RAM"		: RAM
		};
		//alert(RAM);
		$.ajax({
			data: parametros,
			url: 'gCodBarra.php',
			type: 'get',
			success: function (response) {
				$("#CodigoDeBarra").html(response);
			}
		});
	}

	function datosContactos(RutCli, nContacto){
		var parametros = {
			"RutCli" 	: RutCli,
			"nContacto"	: nContacto
		};
		//alert(nContacto);
		$.ajax({
			data: parametros,
			url: 'datosDelContacto.php',
			type: 'get',
			success: function (response) {
				$("#rDatosContacto").html(response);
			}
		});
	}

	</script>

</head>

<body>
	<?php 
		$link=Conectarse();
		$sql = "SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P'";  // sentencia sql
		$result = $link->query($sql);
		$nRams = mysqli_num_rows($result); // obtenemos el n�mero de filas
		$link->close();

		include_once('head.php');
	?>
	<div id="linea"></div>
			<div id="CuerpoTitulo">
				<img src="../imagenes/machineoperator_128.png" width="32" height="32" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					Registro de Muestras (RAM)
				</strong>

				<div id="ImagenBarra">
					<a href="cerrarsesion.php" title="Cerrar Sesión">
						<img src="../gastos/imagenes/preview_exit_32.png" width="32" height="32">
					</a>
				</div>
			</div>

			<div id="BarraOpciones">
				<?php if($_SESSION['IdPerfil'] != 4){?>
				<div id="ImagenBarraLeft">
					<a href="../plataformaErp.php" title="Menú Principal">
						<img src="../gastos/imagenes/Menu.png"><br>
					</a>
					Principal
				</div>
				<?php } ?>
				<div id="ImagenBarraLeft">
					<a href="recepcionMuestras.php" title="Registro de Materiales">
						<img src="../imagenes/machineoperator_128.png"><br>
					</a>
					Muestras
				</div>
				<?php if($_SESSION['IdPerfil'] != 4){?>
					<div id="ImagenBarraLeft" title="Ir a Procesos...">
						<a href="../procesos/plataformaCotizaciones.php" title="Ir a Procesos">
							<img src="../imagenes/other_48.png"><br>
						</a>
						Proceso
					</div>
					<div id="ImagenBarraLeft" title="Activar Muestras dadas de Baja...">
						<a href="actMuestras.php">
							<img src="../imagenes/master.png"><br>
						</a>
						Activar
					</div>
				<?php } ?>
				<div id="ImagenBarraLeft" title="Inventario de Muestras...">
					<a href="../RAMterminadas/ramTerminadas.php">
						<img src="../imagenes/materiales.png"><br>
					</a>
					Inventario
				</div>
				<div id="ImagenBarraLeft" title="Agregar Nueva Muestra...">
					<!-- <a href="#" title="Agregar Muestra" onClick="registrarMuestra(0, 'Agrega')"> -->
					<a href="regMuestras.php?accion=Agrega" title="Agregar Muestra">
						<img src="../imagenes/inventarioMuestras.png"><br>
					</a>
					+Muestra
				</div>
			</div>
			<?php if($_SESSION['IdPerfil'] == 4){?>
			<table width="99%"  border="0" cellspacing="0" cellpadding="0" style="margin:0px;">
				<tr>
					<td valign="top" align="left">
						<?php include_once('listaMuestras.php'); ?>
					</td>
				</tr>
			</table>
			<?php }else{ ?>			
			<table width="99%"  border="0" cellspacing="0" cellpadding="0" style="margin:0px;">
				<tr>
					<td valign="top" align="left" width="50%">
						<?php include_once('listaMuestras.php'); ?>
					</td>
					<td valign="top" align="left" width="50%">
						<?php include_once('listaCAMs.php'); ?>
					</td>
				</tr>
			</table>
			<?php } ?>
			<div style="clear:both; "></div>
	<br>
	
	<script>
		$(document).ready(function() {
		    $('#RAMs').DataTable( {
		        "order": [[ 0, "asc" ]],
				"language": {
					            "lengthMenu": "Mostrar _MENU_ Reg. por P�gina",
					            "zeroRecords": "Nothing found - sorry",
					            "info": "Mostrando P�g. _PAGE_ de _PAGES_",
					            "infoEmpty": "No records available",
					            "infoFiltered": "(de _MAX_ tot. Reg.)",
					            "search":         "Filtrar RAM :",
        		}
		    } );
		} );
	</script>

	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="../jsboot/bootstrap.min.js"></script>	
	
</body>
</html>

