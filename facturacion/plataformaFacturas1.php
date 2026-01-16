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
		header("Location: index.php");
	}
	
	$ValorUF  = 0;
	$valorUSRef = 0;
	
	if(isset($_POST['valorUFRef'])){
		$valorUFRef = $_POST['valorUFRef'];
		$link=Conectarse();
		$actSQL="UPDATE tablaRegForm SET ";
		$actSQL.="valorUFRef	='".$valorUFRef."'";
		$bd=$link->query($actSQL);
		$link->close();
	}
	if(isset($_POST['valorUSRef'])){
		$valorUSRef = $_POST['valorUSRef'];
		$link=Conectarse();
		$actSQL="UPDATE tablaRegForm SET ";
		$actSQL.="valorUSRef	='".$valorUSRef."'";
		$bd=$link->query($actSQL);
		$link->close();
	}
	
	$link=Conectarse();
	$sql = "SELECT * FROM Ingresos";  // sentencia sql
	$result = $link->query($sql);
	$RegIngresos = $result->num_rows; // obtenemos el número de filas
	$link->close();

	if($RegIngresos==0){
		header("Location: ingresocaja.php");
	}else{
		$link=Conectarse();
		$sql = "SELECT * FROM MovGastos";  // sentencia sql
		$result = $link->query($sql);
		$numero = $result->num_rows; // obtenemos el número de filas
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
		$inicio	=	$bdGto>num_rows - $nRegistros;
		$limite	=	$bdGto>num_rows;
		$link->close();
	}
	$fechaHoy = date('Y-m-d');
	$link=Conectarse();
	$bdUf=$link->query("Select * From UF Where fechaUF = '".$fechaHoy."'");
	if($rowUf=mysqli_fetch_array($bdUf)){
		$ValorUF = $rowUf['ValorUF'];
	}
	$valorUFRef = 0;
	$valorUSRef = 0;
	$bdUfRef=$link->query("Select * From tablaRegForm");
	if($rowUfRef=mysqli_fetch_array($bdUfRef)){
		$valorUFRef = $rowUfRef['valorUFRef'];
		$valorUSRef = $rowUfRef['valorUSRef'];
	}
	$link->close();
	
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Intranet Simet</title>

	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../datatables/datatables.min.css">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<script type="text/javascript" src="../angular/angular.js"></script>
</head>

<body>
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<div id="CajaCpo">
			<div id="CuerpoTitulo"> 
				<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td width="20%">
							<img src="../gastos/imagenes/room_32.png" width="28" height="28" align="middle">
							<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
								MÃ³dulo de FacturaciÃ³n
							</strong>
						</td>
						<td width="30%">
							<form action="plataformaFacturas.php" method="post">
							<?php
								echo 'U.F. REF.  $ ';?>
								<input name="valorUFRef" size="10" maxlength="10" type="text" value="<?php echo $valorUFRef; ?>">
								Dolar Ref.
								<input name="valorUSRef" size="10" maxlength="10" type="text" value="<?php echo $valorUSRef; ?>">
								<button name="Guardar">Actualizar</button>
								<?php
								if($ValorUF > 0){
									$fdHoy = explode('-', $fechaHoy);
									echo '<br>DÃ­a '.$fdHoy[2].'/'.$fdHoy[1]. ' $ '.number_format($ValorUF,2,",","."); 
								}
							?>
							</form>
						</td>
						<td width="60%">
							<div id="ImagenBarra">
								<a href="cerrarsesion.php" title="Cerrar SesiÃ³n">
									<img src="../gastos/imagenes/preview_exit_32.png" width="32" height="32">
								</a>
							</div>
							<div id="ImagenBarra">
								<a href="../plataformaErp.php" title="MenÃº Principal">
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
						</td>
					</tr>
				</table>
			</div>
			<?php include_once('solicitudesFacturas.php'); ?> 
		</div>
		<div style="clear:both;"></div>
				
	</div>
	<br>
	
	
</body>
</html>
