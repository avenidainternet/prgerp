<?php
	session_start(); 
	include("../conexionli.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		$link->close();
	}else{
		header("Location: index.php");
	}

	$link=Conectarse();
	$sql = "SELECT * FROM Ingresos";  // sentencia sql
	$result = $link->query($sql);
	$RegIngresos = mysqli_num_rows($result); // obtenemos el n�mero de filas
	$link->close();

	if($RegIngresos==0){
		header("Location: ingresocaja.php");
	}else{
		$link=Conectarse();
		$sql = "SELECT * FROM MovGastos";  // sentencia sql
		$result = $link->query($sql);
		$numero = mysqli_num_rows($result); // obtenemos el n�mero de filas
		$link->close();
		if($numero==0){
			header("Location: registragastos.php");
		}
	}
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
		$bdGto	=	$link->query("SELECT * FROM MovGastos");
		$inicio	=	mysqli_num_rows($bdGto) - $nRegistros;
		$limite	=	mysqli_num_rows($bdGto);
		$link->close();
	}
	$fechaHoy = date('Y-m-d');
	$link=Conectarse();
	$bdUf=$link->query("Select * From UF Where fechaUF = '".$fechaHoy."'");
	if($rowUf=mysqli_fetch_array($bdUf)){
		$ValorUF = $rowUf[ValorUF];
	}
	$link->close();
	
?>
<!doctype html>
 
<html lang="es">
<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<title>Intranet Simet</title>

<link href="styles.css" rel="stylesheet" type="text/css">
<link href="../css/tpv.css" rel="stylesheet" type="text/css">

</head>

<body>
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<img src="../gastos/imagenes/room_32.png" width="28" height="28" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					Múdulo de  Docencia
				</strong>
				<?php //include('barramenu.php'); ?>

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
					<a href="formSolicitaFactura.php" title="Solicitud de Factura">
						<img src="../gastos/imagenes/crear_certificado.png" width="32" height="32">
					</a><br>
				</div>
				<div id="ImagenBarra">
					<a href="../clientes/clientes.php" title="Clientes">
						<img src="../gastos/imagenes/contactus_128.png" width="32" height="32">
					</a>
				</div>
							
							<div id="ImagenBarra">
								<a href="exportarFacturas.php" title="Descargar Facturas Ventas">
									<img src="../gastos/imagenes/excel_icon.png" width="32" height="32">
								</a>
							</div>

			
			</div>
			<?php include_once('solicitudesFacturas.php'); ?>
		</div>
		<div style="clear:both;"></div>
				
	</div>
	<br>
	
	
</body>
</html>
