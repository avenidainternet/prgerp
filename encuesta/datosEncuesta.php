<?php
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
		header("Location: index.php");
	}
	$nEnc 	= '';
	$accion	= '';
	$nItem	= 0;
	
	if(isset($_GET['nEnc'])) 	{	$nEnc 	= $_GET['nEnc']; 	}
	if(isset($_GET['nItem'])) 	{	$nItem 	= $_GET['nItem']; 	}
	
	if(isset($_POST['nEnc'])) 	{	$nEnc 	= $_POST['nEnc']; 	}
	if(isset($_POST['nItem'])) 	{	$nItem 	= $_POST['nItem']; 	}

	$link=Conectarse();
	$bdEnc=mysql_query("Select * From Encuestas Where nEnc = '".$nEnc."'");
	if($rowEnc=mysql_fetch_array($bdEnc)){
		$nomEnc = $rowEnc['nomEnc'];
	}
	mysql_close($link);
	
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
	function realizaProceso(nEnc, dBuscar){
		var parametros = {
			"nEnc" 		: nEnc,
			"dBuscar" 	: dBuscar
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'muestraDatos.php',
			type: 'get',
			beforeSend: function () {
				$("#resultado").html("<div id='cajaRegistraPruebas'><img src='../imagenes/ajax-loader.gif'></div>");
			},
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}
	
	function registraEncuesta(nEnc, nItem, accion){
		var parametros = {
			"nEnc" 		: nEnc,
			"nItem" 	: nItem,
			"accion"	: accion
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'regItems.php',
			type: 'get',
			beforeSend: function () {
				$("#resultadoRegistro").html("<div style='position:absolute; left:159px; top:66px; width:470px; height:187px; z-index:1; border: 5px solid #000; background-color: #fff; border-radius: 5px 5px 0px 0px; -moz-border-radius: 5px 0px 5px 0px; '><img src='../imagenes/ajax-loader.gif'></div>");
			},
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
				<img src="../imagenes/consulta.png" width="32" height="32" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					Módulo Estadística (<span style="color:#333333; font-weight:700; "><?php echo $nomEnc; ?></span>)
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
					<script>
						var nEnc 	= "<?php echo $nEnc; ?>" ;
					</script>
					<a href="#" title="Agregar Items" onClick="registraEncuesta(nEnc, 0, 'Agrega')">
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
					<a href="clientes.php" title="Clientes">
						<img src="../gastos/imagenes/contactus_128.png" width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="plataformaEncuesta.php" title="Nominas de Encuestas">
						<img src="../imagenes/consulta.png" width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="#" title="Descargar Resultado Encuestas...">
						<img src="../gastos/imagenes/excel_icon.png" width="32" height="32">
					</a>
				</div>
			</div>
			<?php include_once('listaDatos.php'); 
			if($nItem){?>
				<script>
					var nEnc 	= "<?php echo $nEnc; ?>" ;
					var nItem 	= "<?php echo $nItem; ?>" ;
					var accion 	= "<?php echo $accion; ?>" ;
					registraEncuesta(nEnc, nItem, accion);
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
