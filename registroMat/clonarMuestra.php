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
	include_once("conexion.php");
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
		$bdPer=mysql_query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysql_fetch_array($bdPer)){
			$_SESSION['Perfil']		= $rowPer['Perfil'];
			$_SESSION['IdPerfil']	= $rowPer['IdPerfil'];
		}
		mysql_close($link);
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
		$bdCot =mysql_query("Delete From registroMuestras Where RAM = '".$RAM."'");
		mysql_close($link);
		$RAM 	= '';
		$accion	= '';
	}

	if(isset($_POST['dardeBaja'])){
		$situacionMuestra = 'B';
		$link=Conectarse();
		$actSQL="UPDATE registroMuestras SET ";
		$actSQL.="situacionMuestra	='".$situacionMuestra.	"'";
		$actSQL.="WHERE RAM			= '".$RAM."'";
		$bdRam=mysql_query($actSQL);
		mysql_close($link);
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
			$bdRam=mysql_query($actSQL);
			mysql_close($link);
		}
		$RAM 	= '';
		$accion	= '';
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
		$bdRam=mysql_query("Select * From registroMuestras Where RAM = '".$RAM."'");
		if($rowRam=mysql_fetch_array($bdRam)){
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
			$bdRam=mysql_query($actSQL);
		}else{
			mysql_query("insert into registroMuestras(	RAM,
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
			$bdCot=mysql_query("Select * From Cotizaciones Where CAM = '".$CAM."'");
			if($rowCot=mysql_fetch_array($bdCot)){
				$actSQL="UPDATE Cotizaciones SET ";
				$actSQL.="RAM	 	= '".$RAM. "'";
				$actSQL.="WHERE CAM	= '".$CAM. "'";
				$bdCot=mysql_query($actSQL);
			}
		}else{
			$bdCot=mysql_query("Select * From Cotizaciones Where RAM = '".$RAM."'");
			if($rowCot=mysql_fetch_array($bdCot)){
				$RAM = 0;
				$CAM = $rowCot['CAM'];
				$actSQL="UPDATE Cotizaciones SET ";
				$actSQL.="RAM	 	= '".$RAM. "'";
				$actSQL.="WHERE CAM	= '".$CAM. "'";
				$bdCot=mysql_query($actSQL);
			}
		}
		mysql_close($link);
		if($Copias > 0){
			$link=Conectarse();
			for($Fan=1; $Fan<=$Copias; $Fan++){
				$bdRAM=mysql_query("Select * From registroMuestras Where RAM = '".$RAM."' and Fan = '".$Fan."'");
				if($rowRAM=mysql_fetch_array($bdRAM)){
				}else{
					mysql_query("insert into registroMuestras(	RAM,
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
			mysql_close($link);
		}

		//header("Location: formularios/iRAM.php?RAM=".$RAM."&CAM=5751");

		$accion = '';
	}	
	
?>
<!doctype html>
 
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

	<link rel="shortcut icon" href="favicon.ico" />
	<link rel="apple-touch-icon" href="touch-icon-iphone.png" />
	<link rel="apple-touch-icon" href="touch-icon-ipad.png" />
	<link rel="apple-touch-icon" href="touch-icon-iphone4.png" />

	<title>SIMET - Recepción de Muestras</title>

	<link href="../css/stylesTv.css" rel="stylesheet" type="text/css">
	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<script type="text/javascript" src="../jquery/libs/1/jquery.min.js"></script>	

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
		$result = mysql_query($sql);
		$nRams = mysql_num_rows($result); // obtenemos el n�mero de filas
		mysql_close($link);

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
			</div>
			<form name="form" action="recepcionMuestras.php" method="post">
				<center>
				<table width="75%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax" style="margin-top:10px;">
					<tr>
					  <td style="padding:10px;">
							<strong style="font-size:20px; font-weight:700; margin-left:10px;">
								RAM-
								<input name="RAM" 	 id="RAM" 	 type="text"   size="7" maxlength="7" style="font-size:18px; font-weight:700;" autofocus required />
								N° Clones
								<select name="Copias">
									<?php 
									if($Copias > 0){?>
										<option value='<?php echo $Copias; ?>'><?php echo $Copias; ?></option>
									<?php
									}
									?>
									<option value='1'>1</option>
									<option value='2'>2</option>
									<option value='3'>3</option>
									<option value='4'>4</option>
									<option value='5'>5</option>
									<option value='6'>6</option>
									<option value='7'>7</option>
									<option value='8'>8</option>
									<option value='9'>9</option>
								</select>
							</strong>
						</td>
					</tr>
					<tr>
						<td  style="padding:10px; font-size:14px; font-family:arial;">
							Indique RAM a ser Clonada...
						</td>
					<td>
					<tr>
						<td  style="padding:10px; font-size:14px; font-family:arial;">
							<button name="clonarRAM">
								Clonar
							</button>
						</td>
					<td>
				</table>
				</center>
			</form>
			<div style="clear:both; "></div>
	<br>
</body>
</html>

