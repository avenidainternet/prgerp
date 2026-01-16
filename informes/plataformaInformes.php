<?php
	session_start(); 
	include_once("../conexionli.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		$link->close();
	}else{
		header("Location: ../index.php");
	}
	$accion = '';
	
	if(isset($_GET['CodInforme']))	{	$CodInforme	= $_GET['CodInforme'];	}
	if(isset($_GET['accion'])) 		{	$accion 	= $_GET['accion']; 		}

	$link=Conectarse();
	$sql = "SELECT * FROM Informes";  // sentencia sql
	$result = $link->query($sql);
	$RegIngresos = $result->num_rows; // obtenemos el n�mero de filas
	$link->close();

	$nRegistros = 100;
	if(!isset($inicio)){
		$inicio = 0;
		$limite = 100;
	}
	if(isset($_GET['limite'])){
		$inicio = $_GET['limite']-1;
		$limite = $inicio+$nRegistros;
	}
	if(isset($_GET['inicio'])){
		if($_GET['inicio']==0){
			$inicio = 0;
			$limite = 100;
		}else{
			$inicio = ($_GET['inicio']-$nRegistros)+1;
			$limite = $inicio+$nRegistros;
		}
	}
	if(isset($_GET['ultimo'])){
		$link=Conectarse();
		$bdGto	=	$link->query("SELECT * FROM Informes");
		$inicio	=	mysql_num_rows($bdGto) - $nRegistros;
		$limite	=	mysql_num_rows($bdGto);
		$link->close();
	}
	
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Módulo Informes</title>
	
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	

	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<script>
	function realizaProceso(CodInforme, dBuscar, Proyecto, Estado, MesFiltro, Agno){
		var parametros = {
			"CodInforme" 	: CodInforme,
			"dBuscar" 		: dBuscar,
			"Proyecto" 		: Proyecto,
			"Estado"		: Estado,
			"MesFiltro"		: MesFiltro,
			"Agno"			: Agno
		};
		//alert(CodInforme);
		$.ajax({
			data: parametros,
			url: 'muestraInformes.php',
			type: 'get',
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}

	function subirInformePDF(accion, CodInforme){
		var parametros = {
			"accion" 		: accion,
			"CodInforme" 	: CodInforme
		};
		//alert(CodInforme);
		$.ajax({
			data: parametros,
			url: 'upInfoAM.php',
			type: 'get',
			success: function (response) {
				$("#resultadoSubir").html(response);
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
				<img src="../gastos/imagenes/room_32.png" width="28" height="28" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					Módulo de Informes
				</strong>

				<div id="ImagenBarra">
					<a href="cerrarsesion.php" title="Cerrar Sesión">
						<img src="../gastos/imagenes/preview_exit_32.png" width="32" height="32">
					</a>
				</div>
			</div>
			<?php 
				include_once('listaInformes.php'); 
				if($accion == 'SubirPdf'){?>
					<script>
						var accion 		= "<?php echo $accion;?>";
						var CodInforme 	= "<?php echo $CodInforme;?>";
						subirInformePDF(accion, CodInforme);
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
