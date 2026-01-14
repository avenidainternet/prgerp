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
	$nItem 	= '';
	$nCon 	= '';
	$accion	= '';
	$nomEnc	= '';
	
	if(isset($_GET['nEnc'])) 	{	$nEnc 	= $_GET['nEnc']; 	}
	if(isset($_GET['nItem'])) 	{	$nItem 	= $_GET['nItem'];	}
	if(isset($_GET['nCon'])) 	{	$nCon 	= $_GET['nCon'];	}
	if(isset($_GET['accion'])) 	{	$accion = $_GET['accion']; 	}
	
	if(isset($_POST['nEnc'])) 	{	$nEnc 	= $_POST['nEnc']; 	}
	if(isset($_POST['nItem'])) 	{	$nItem 	= $_POST['nItem']; 	}
	if(isset($_POST['nCon'])) 	{	$nCon 	= $_POST['nCon']; 	}
	if(isset($_POST['accion'])) {	$accion = $_POST['accion']; }

	//Revisar
	echo $nItem;
	
	$link=Conectarse();
	$bdEnc=mysql_query("Select * From Encuestas Where nEnc = '".$nEnc."'");
	if($rowEnc=mysql_fetch_array($bdEnc)){
		$nomEnc = $rowEnc['nomEnc'];
	}
	$bdIt=mysql_query("Select * From itEncuesta Where nEnc = '".$nEnc."' && nItem = '".$nItem."'");
	if($rowIt=mysql_fetch_array($bdIt)){
		$titItem = $rowIt['titItem'];
	}
	mysql_close($link);
	
	if(isset($_POST['confirmarBorrar'])){
		$link=Conectarse();
		$bdEnc=mysql_query("Delete From prEncuesta Where nEnc = '".$nEnc."' && nItem = '".$nItem."' && nCon = '".$nCon."'");
		mysql_close($link);
		$nCon 	= '';
		$accion	= '';
	}
	if(isset($_POST['confirmarGuardar'])){
		$Consulta = $_POST['Consulta'];
		$link=Conectarse();
		$bdEnc=mysql_query("Select * From prEncuesta Where nEnc = '".$nEnc."' && nItem = '".$nItem."' && nCon = '".$nCon."'");
		if($rowEnc=mysql_fetch_array($bdEnc)){
			$actSQL="UPDATE prEncuesta SET ";
			$actSQL.="Consulta			='".$Consulta."'";
			$actSQL.="WHERE nEnc		= '".$nEnc."' && nItem = '".$nItem."' && nCon = '".$nCon."'";
			$bdEnc=mysql_query($actSQL);
			$accion = '';
		}else{
			mysql_query("insert into prEncuesta(nEnc,
												nItem,
												nCon,
												Consulta
												) 
									values 	(	'$nEnc',
												'$nItem',
												'$nCon',
												'$Consulta'
			)",$link);
			$nCon 	= '';
			$accion	= '';
		}
		mysql_close($link);
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
	function realizaProceso(nEnc, nItem, dBuscar){
		var parametros = {
			"nEnc" 		: nEnc,
			"nItem" 	: nItem,
			"dBuscar" 	: dBuscar
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'muestraPreguntas.php',
			type: 'get',
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}
	
	function registraEncuesta(nEnc, nItem, nCon, accion){
		var parametros = {
			"nEnc" 		: nEnc,
			"nItem" 	: nItem,
			"nCon" 		: nCon,
			"accion"	: accion
		};
		//alert(nCon);
		$.ajax({
			data: parametros,
			url: 'regPregunta.php',
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
				<img src="../imagenes/consulta.png" width="32" height="32" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					Módulo de Encuestas.Items.Consultas (<span style="color:#333333; font-weight:700; "><?php echo $nomEnc; ?></span>)
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
						var nItem 	= "<?php echo $nItem; ?>";
					</script>
					<a href="#" title="+ Consulta" onClick="registraEncuesta(nEnc, nItem, 0, 'Agrega')">
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
			<?php include_once('listaPreguntas.php'); 
			if($accion == 'Actualizar' or $accion == 'Borrar'){?>
				<script>
					var nEnc 	= "<?php echo $nEnc; ?>" ;
					var nItem 	= "<?php echo $nItem; ?>" ;
					var nCon 	= "<?php echo $nCon; ?>" ;
					var accion 	= "<?php echo $accion; ?>" ;
					registraEncuesta(nEnc, nItem, nCon, accion);
				</script>
				<?php
			}
			if($accion=='Agrega'){?>
				<script>
					var nEnc 	= "<?php echo $nEnc; ?>" ;
					var nItem 	= "<?php echo $nItem; ?>" ;
					var nCon 	= "<?php echo $nCon; ?>" ;
					var accion 	= "<?php echo $accion; ?>" ;
					registraEncuesta(nEnc, nItem, nCon, accion);
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
