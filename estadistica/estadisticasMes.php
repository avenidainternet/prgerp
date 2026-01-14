<?php
	session_start(); 
	include("conexion.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=mysql_query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysql_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		mysql_close($link);
	}else{
		header("Location: estadisticas.php");
	}

?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Intranet Simet</title>

	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>

</head>

<body>
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<img src="../gastos/imagenes/room_32.png" width="28" height="28" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					Módulo Estadísticas
				</strong>

				<div id="ImagenBarra">
					<a href="cerrarsesion.php" title="Cerrar Sesión">
						<img src="../gastos/imagenes/preview_exit_32.png" width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="../plataformaErp.php" title="Menú Principal">
						<img src="../gastos/imagenes/Menu.png" width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a>
					<img src="../gastos/imagenes/r_x.png"  width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="#" title="Descargar Estadística">
						<img src="../gastos/imagenes/excel_icon.png" width="32" height="32">
					</a>
				</div>

			
			</div>
			
			<div id="BarraFiltro">
				<img src="../gastos/imagenes/data_filter_128.png" width="28" height="28">
				<div style="padding-left:15px; display:inline;">
					<?php
						if(isset($_POST['filtroPeriodo'])){
							$fechaDesde = $_POST['fechaDesde'];
							$fechaHasta = $_POST['fechaHasta'];
						}else{
							$fechaDesde = $Agno.'-01-01';
							$fechaHasta = date('Y-m-d');
						}
					?>
					<form name="form" action="estadisticas.php" method="post" style="display:inline; ">
						Fechas :
							<input name="fechaDesde" id='fechaDesde' type="date" value="<?php echo $fechaDesde; ?>">
						-	<input name="fechaHasta" id='fechaHasta' type="date" value="<?php echo $fechaHasta; ?>">
						<button name="filtroPeriodo">
							Filtrar
						</button>
					</form>
				</div>
			</div>
			<?php include_once('estadisticaVentasMes.php'); ?>
		</div>
		<div style="clear:both;"></div>
				
	</div>
	<br>
	
	
</body>
</html>
