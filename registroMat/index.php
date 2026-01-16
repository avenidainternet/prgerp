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
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

	<script type="text/javascript" src="../angular/angular.js"></script>

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
	<style type="text/css">
		.verde-class{
		  background-color 	: green;
		  color 			: #fff;
		  font-weight 		: bold;
		}
		.verdechillon-class{
		  background-color 	: #33FFBE;
		  color 			: #fff;
		  font-weight 		: bold;
		}
		.azul-class{
		  background-color 	: blue;
		  color 			: #fff;
		  font-weight 		: bold;
		}
		.amarillo-class{
		  background-color 	: yellow;
		  color 			: black;
		}
		.rojo-class{
		  background-color 	: red;
		  color 			: black;
		}
		.default-color{
		  background-color 	: #fff;
		  color 			: black;
		}	
	</style>

</head>

<body ng-app="myApp" ng-controller="CtrlRAM" ng-cloak>

	<?php 
		$link=Conectarse();
		$sql = "SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P'";  // sentencia sql
		$result = $link->query($sql);
		$nRams = mysqli_num_rows($result); // obtenemos el n�mero de filas
		$link->close();

		include_once('head.php');
	?>
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
				  <?php if($_SESSION['IdPerfil'] != 4){?>
	        		<li class="nav-item active">
	          			<a class="nav-link" href="../plataformaErp.php">
						  <img src="../gastos/imagenes/Menu.png" width="20"> 
						  Principal
	              		</a>
	        		</li>
	        		<li class="nav-item" ng-show="filtrado">
	          			<a 	class="nav-link"
						   	href=""
							ng-click="quitarFiltro()"
						  	>
						  <img src="../imagenes/data_filter_128.png" width="20"> 
						   Quitar filtro
	              		</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link" href="../procesosangular/plataformaCotizaciones.php">
						  <img src="../imagenes/other_48.png" width="20"> 
						   Procesos
	              		</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link" href="actMuestras.php"> 
						  <img src="../imagenes/master.png" width="20"> 
						  Activar RAM
	              		</a>
	        		</li>
					<?php } ?>
	        		<li class="nav-item">
	          			<a class="nav-link" href="../RAMterminadas/ramTerminadas.php"> 
						  <img src="../imagenes/materiales.png" width="20"> 
						  Inventario
	              		</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link" href="registro?accion=Agrega"> 
						  <img src="../imagenes/inventarioMuestras.png" width="20"> 
						  + Muestra
	              		</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="../cerrarsesion.php"> Cerrar</a>
	        		</li>
	      		</ul>
	    	</div>
	  	</div>
	</nav>


			<?php if($_SESSION['IdPerfil'] == 4){?>
			<table width="99%"  border="0" cellspacing="0" cellpadding="0" style="margin:0px;">
				<tr>
					<td valign="top" align="left">
						<?php include_once('listaMuestras.php'); ?>
					</td>
				</tr>
			</table>
			<?php }else{ ?>	
			<div class="row">
				<div class="col-6">		
					<?php include_once('listaRAMActivas.php'); ?>
				</div>
				<div class="col-6">		
					<?php include_once('listaCAMActivas.php'); ?>
				</div>
			</div>
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
	<script src="../jsboot/bootstrap.min.js"></script>
	<script src="../jquery/jquery-3.3.1.min.js"></script>

	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="muestras.js"></script> 
	
</body>
</html>

