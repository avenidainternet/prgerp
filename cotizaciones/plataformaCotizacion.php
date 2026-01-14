<?php
	ini_set("session.cookie_lifetime","1209600");
	ini_set("session.gc_maxlifetime","1209600");
	session_start(); 
	include_once("conexion.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=mysql_query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysql_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		mysql_close($link);
	}else{
		header("Location: ../index.php");
	}
	$nEnc 	= '';
	$accion	= '';
	
	if(isset($_GET[CAM])) 		{	$nEnc 	= $_GET[CAM]; 		}
	if(isset($_GET[accion])) 	{	$accion = $_GET[accion]; 	}
	
	if(isset($_POST[CAM])) 		{	$nEnc 	= $_POST[CAM]; 		}
	if(isset($_POST[accion])) 	{	$accion = $_POST[accion]; 	}
	
	if(isset($_POST[confirmarBorrar])){
		$link=Conectarse();
		$bdEnc=mysql_query("Delete From Encuestas Where nEnc = '".$nEnc."'");
		mysql_close($link);
		$nEnc 	= '';
		$accion	= '';
	}
	if(isset($_POST[confirmarGuardar])){
		$nomEnc 	= $_POST[nomEnc];
		$infoEnc 	= $_POST[infoEnc];
		$Estado 	= $_POST[Estado];

		$link=Conectarse();
		$bdEnc=mysql_query("Select * From Encuestas Where nEnc = '".$nEnc."'");
		if($rowEnc=mysql_fetch_array($bdEnc)){
			$actSQL="UPDATE Encuestas SET ";
			$actSQL.="nomEnc			='".$nomEnc."',";
			$actSQL.="infoEnc			='".$infoEnc."',";
			$actSQL.="Estado			='".$Estado."'";
			$actSQL.="WHERE nEnc		= '".$nEnc."'";
			$bdEnc=mysql_query($actSQL);
		}else{
			mysql_query("insert into Encuestas(	nEnc,
												nomEnc,
												infoEnc,
												Estado
												) 
									values 	(	'$nEnc',
												'$nomEnc',
												'$infoEnc',
												'$Estado'
			)");
			$nEnc 	= '';
			$accion	= '';
		}
		mysql_close($link);
		$nEnc 	= '';
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
			url: 'muestraCotizacion.php',
			type: 'get',
			beforeSend: function () {
				$("#resultado").html("<div id='cajaRegistraPruebas'><img src='../imagenes/ajax-loader.gif'></div>");
			},
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}
	
	function registraEncuesta(nEnc, accion){
		var parametros = {
			"nEnc" 		: nEnc,
			"accion"	: accion
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'regCotizacion.php',
			type: 'get',
			beforeSend: function () {
				$("#resultadoRegistro").html("<div style='position:absolute; left:159px; top:66px; width:470px; height:187px; z-index:1; border: 5px solid #000; background-color: #fff; border-radius: 5px 5px 0px 0px; -moz-border-radius: 5px 0px 5px 0px; '><img src='../imagenes/ajax-loader.gif'></div>");
			},
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});

	function buscarContactos(Cliente){
		var parametros = {
			"Cliente" 	: Cliente
		};
		alert(Cliente);
		$.ajax({
			data: parametros,
			url: 'listaContactos.php',
			type: 'get',
			beforeSend: function () {
				$("#resultadoContacto").html("<div style='position:absolute; left:159px; top:66px; width:470px; height:187px; z-index:1; border: 5px solid #000; background-color: #fff; border-radius: 5px 5px 0px 0px; -moz-border-radius: 5px 0px 5px 0px; '><img src='../imagenes/ajax-loader.gif'></div>");
			},
			success: function (response) {
				$("#resultadoContacto").html(response);
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
				<img src="../imagenes/consulta.png" width="32" height="32" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					Módulo Cotizaciones
				</strong>
				<?php //include('barramenu.php'); ?>

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
					<a href="#" title="Descargar Resultado Encuestas...">
						<img src="../gastos/imagenes/excel_icon.png" width="32" height="32">
					</a>
				</div>
			</div>
			<?php include_once('listaCotizacion.php'); 
			if($nEnc){?>
				<script>
					var nEnc 	= "<?php echo $nEnc; ?>" ;
					var accion 	= "<?php echo $accion; ?>" ;
					registraEncuesta(nEnc, accion);
				</script>
				<?php
			}
			?>
		</div>
		<div style="clear:both;"></div>
		<span id="registroDeudas"></span>
				
	</div>
	<br>
	
	
</body>
</html>
