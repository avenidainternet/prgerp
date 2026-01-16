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
	$usuario = $_SESSION['usuario'];
	$CAM 	= '';
	$accion	= '';
	unset($_SESSION[empFiltro]);
	if(isset($_GET[CAM])) 		{	$CAM 					= $_GET[CAM]; 		}
	if(isset($_GET[RAM])) 		{	$RAM 					= $_GET[RAM]; 		}
	if(isset($_GET[accion])) 	{	$accion 				= $_GET[accion]; 	}
	if(isset($_GET[usrFiltro])) {	$_SESSION[usrFiltro] 	= $_GET[usrFiltro]; }
	if(isset($_GET[empFiltro])) {
		$empFiltro = $_GET[empFiltro];
		unset($_SESSION[empFiltro]);
		if($empFiltro){
			$_SESSION[empFiltro] 	= $_GET[empFiltro]; 
		}
	}

	if(isset($_POST[CAM])) 		{	$CAM 	= $_POST[CAM]; 	}
	if(isset($_POST[RAM])) 		{	$RAM 	= $_POST[RAM]; 	}
	if(isset($_POST[accion])) 	{	$accion = $_POST[accion]; 	}

	if(isset($_POST[cerrarCAM])){
		$CAM 			= $_POST[CAM];
		$RAM 			= $_POST[RAM];
		$Estado			= 'C';
		$fechaCierre 	= date('Y-m-d');
		$link=Conectarse();
		$actSQL="UPDATE Cotizaciones SET ";
		$actSQL.="fechaCierre	='".$fechaCierre.	"',";
		$actSQL.="Estado		='".$Estado.		"'";
		$actSQL.="WHERE CAM 	= '".$CAM."'";
		$bdCot=mysql_query($actSQL);
		mysql_close($link);
		$CAM 	= '';
		$accion	= '';
	}
	if(isset($_POST[guardarSeguimiento])){
		$CAM 			 		= $_POST[CAM];
		$RAM 			 		= $_POST[RAM];
		$Rev 			 		= $_POST[Rev];
		$Cta 			 		= $_POST[Cta];
		$Estado 		 		= $_POST[EstadoCot];
		$oCompra 		 		= $_POST[oCompra];
		$oMail	 		 		= $_POST[oMail];
		$oCtaCte 		 		= $_POST[oCtaCte];
		$dHabiles		 		= $_POST[dHabiles];
		$nOC 		 	 		= $_POST[nOC];
		$usrResponzable	 		= $_POST[usrResponzable];
		$contactoRecordatorio 	= $_POST[contactoRecordatorio];
		$Descripcion		 	= $_POST[Descripcion];
		$accion			 		= $_POST[accion];
		
		$fechaAceptacion = '0000-00-00';
		if(isset($_POST[fechaAceptacion])){ $fechaAceptacion = $_POST[fechaAceptacion]; }

		$link=Conectarse();
		$bdCot=mysql_query("Select * From Cotizaciones Where CAM = '".$CAM."' and Cta = '".$Cta."'");
		if($rowCot=mysql_fetch_array($bdCot)){
			$fd = explode('-', $fechaAceptacion);
			//if($fechaAceptacion != '0000-00-00' or $fd[0] > 0){
			if($fd[0] > 0){
				if($RAM){
					$Estado = 'A';
				}else{
					$Estado = 'E';
				}
			}else{
				$Estado = 'E';
				if($rowCot[fechaEnvio] != '0000-00-00'){
					$Estado = 'E';
				}
			}
			if($RAM > 0){
				$Estado 	 = 'P';
				$fechaInicio = date('Y-m-d');
			}else{
				$fechaInicio = '0000-00-00';
			}
			if($rowCot[proxRecordatorio] <= date('Y-m-d')){
				if($contactoRecordatorio){
					$fechaHoy = date('Y-m-d');
					$proxRecordatorio 	= strtotime ( '+10 day' , strtotime ( $fechaHoy ) );
					$proxRecordatorio 	= date ( 'Y-m-d' , $proxRecordatorio );
				}
			}
			$actSQL="UPDATE Cotizaciones SET ";
			$actSQL.="RAM	 			 	='".$RAM.					"',";
			$actSQL.="fechaAceptacion	 	='".$fechaAceptacion.		"',";
			$actSQL.="fechaInicio	 	 	='".$fechaInicio.			"',";
			$actSQL.="dHabiles		 	 	='".$dHabiles.				"',";
			$actSQL.="usrResponzable 	 	='".$usrResponzable.		"',";
			$actSQL.="contactoRecordatorio 	='".$contactoRecordatorio.	"',";
			$actSQL.="Descripcion		 	='".$Descripcion.			"',";
			$actSQL.="proxRecordatorio 		='".$proxRecordatorio.		"',";
			$actSQL.="oCompra			 	='".$oCompra.				"',";
			$actSQL.="oMail				 	='".$oMail.					"',";
			$actSQL.="oCtaCte			 	='".$oCtaCte.				"',";
			$actSQL.="nOC			 	 	='".$nOC.					"',";
			$actSQL.="Estado			 	='".$Estado.				"'";
			$actSQL.="WHERE CAM 			= '".$CAM."' and Cta = '".$Cta."'";
			$bdCot=mysql_query($actSQL);
		}
		mysql_close($link);
		$CAM 	= '';
		$accion	= '';
	}

	if(isset($_POST[guardarSeguimientoRAM])){
		$CAM 			 = $_POST[CAM];
		$RAM 			 = $_POST[RAM];
		$Rev 			 = $_POST[Rev];
		$Cta 			 = $_POST[Cta];
		$Estado 		 = $_POST[EstadoCot];
		$dHabiles 		 = $_POST[dHabiles];
		$fechaTermino	 = $_POST[fechaTermino];
		$Descripcion	 = $_POST[Descripcion];
		$accion			 = $_POST[accion];
		
		$link=Conectarse();
		$bdCot=mysql_query("Select * From Cotizaciones Where CAM = '".$CAM."' and Rev = '".$Rev."' and Cta = '".$Cta."'");
		if($rowCot=mysql_fetch_array($bdCot)){
			$fd = explode('-', $fechaTermino);
			//if($fechaAceptacion != '0000-00-00' or $fd[0] > 0){
			if($fd[0] > 0){
				$Estado = 'T';
			}
			$actSQL="UPDATE Cotizaciones SET ";
			$actSQL.="RAM			 	='".$RAM.			"',";
			$actSQL.="dHabiles		 	='".$dHabiles.		"',";
			$actSQL.="fechaTermino	 	='".$fechaTermino.	"',";
			$actSQL.="Descripcion	 	='".$Descripcion.	"',";
			$actSQL.="Estado			='".$Estado.		"'";
			$actSQL.="WHERE CAM 		= '".$CAM."' and Rev = '".$Rev."' and Cta = '".$Cta."'";
			$bdCot=mysql_query($actSQL);
		}
		mysql_close($link);
		$CAM 	= '';
		$RAM 	= '';
		$accion	= '';
	}

	if(isset($_POST[guardarSeguimientoAM])){
		$CAM 			 	= $_POST[CAM];
		$RAM 			 	= $_POST[RAM];
		$Rev 			 	= $_POST[Rev];
		$Cta 			 	= $_POST[Cta];
		$informeUP 		 	= $_POST[informeUP];
		$fechaInformeUP	 	= $_POST[fechaInformeUP];
		$Facturacion 	 	= $_POST[Facturacion];
		$fechaFacturacion 	= $_POST[fechaFacturacion];
		$Archivo	 	 	= $_POST[Archivo];
		$fechaArchivo	 	= $_POST[fechaArchivo];
		$accion			 	= $_POST[accion];
		if($informeUP != 'on') 		{ $fechaInformeUP 	= '0000-00-00'; }
		if($Facturacion != 'on') 	{ $fechaFacturacion = '0000-00-00'; }
		if($Archivo != 'on') 		{ $fechaArchivo 	= '0000-00-00'; }
		
		$link=Conectarse();
		$bdCot=mysql_query("Select * From Cotizaciones Where CAM = '".$CAM."' and RAM = '".$RAM."' and Rev = '".$Rev."' and Cta = '".$Cta."'");
		if($rowCot=mysql_fetch_array($bdCot)){

			$fd = explode('-', $fechaArchivo);
			$actSQL="UPDATE Cotizaciones SET ";
			$actSQL.="informeUP	 		='".$informeUP.			"',";
			$actSQL.="fechaInformeUP	='".$fechaInformeUP.	"',";
			$actSQL.="Facturacion	 	='".$Facturacion.		"',";
			$actSQL.="fechaFacturacion	='".$fechaFacturacion.	"',";
			$actSQL.="Archivo		 	='".$Archivo.			"',";
			$actSQL.="fechaArchivo		='".$fechaArchivo.		"'";
			$actSQL.="WHERE CAM 		= '".$CAM."' and RAM = '".$RAM."' and Rev = '".$Rev."' and Cta = '".$Cta."'";
			$bdCot=mysql_query($actSQL);
		}
		mysql_close($link);
		$CAM 	= '';
		$RAM 	= '';
		$accion	= '';
	}
	
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Intranet Simet</title>
	
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
			url: 'muestraRAMs.php',
			type: 'get',
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}
	
	function registraEncuesta(CAM, accion){
		var parametros = {
			"CAM" 		: CAM,
			"accion"	: accion
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'regCotizacion.php',
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
				<img src="../imagenes/machineoperator_128.png" width="32" height="32" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					Registro de Materiales (RAM)
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
					<a href="#" title="Agregar Cotización" onClick="registraEncuesta(0, 'Agrega')">
						<img src="../imagenes/add_32.png" width="32" height="32">
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
				<div id="ImagenBarra">
					<a href="exportarCotizaciones.php" title="Descargar Cotizaciones...">
						<img src="../gastos/imagenes/excel_icon.png" width="32" height="32">
					</a>
				</div>
			</div>
			<?php include_once('listaRAM.php'); 
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
			if($accion == 'SeguimientoRAM'){?>
				<script>
					var CAM 	= "<?php echo $CAM; ?>" ;
					var RAM 	= "<?php echo $RAM; ?>" ;
					var Rev 	= "<?php echo $Rev; ?>" ;
					var Cta 	= "<?php echo $Cta; ?>" ;
					var accion 	= "<?php echo $accion; ?>" ;
					seguimientoRAM(CAM, RAM, Rev, Cta, accion);
				</script>
				<?php
			}
			if($accion == 'SeguimientoAM'){?>
				<script>
					var CAM 	= "<?php echo $CAM; ?>" ;
					var RAM 	= "<?php echo $RAM; ?>" ;
					var Rev 	= "<?php echo $Rev; ?>" ;
					var Cta 	= "<?php echo $Cta; ?>" ;
					var accion 	= "<?php echo $accion; ?>" ;
					seguimientoAM(CAM, RAM, Rev, Cta, accion);
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
