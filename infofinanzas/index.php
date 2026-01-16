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
	
	if(isset($_POST['valorUFRef'])){
		$valorUFRef = $_POST['valorUFRef'];
		$link=Conectarse();
		$actSQL="UPDATE tablaRegForm SET ";
		$actSQL.="valorUFRef	='".$valorUFRef."'";
		$bd=$link->query($actSQL);
		$link->close();
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
	$fechaHoy = date('Y-m-d');
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
				<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td>
							<img src="../imagenes/estadoFinanciero.png" width="28" height="28" align="middle">
							<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
								Informe Financiero
							</strong>
						</td>
						<td width="60%">
							<div id="ImagenBarra">
								<a href="cerrarsesion.php" title="Cerrar Sesión">
									<img src="../gastos/imagenes/preview_exit_32.png" width="32" height="32">
								</a>
							</div>
						</td>
					</tr>
				</table>
			</div>
			<?php include_once('muestraInforme.php'); ?> 
		</div>
		<div style="clear:both;"></div>
				
	</div>
	<br>
	
	
</body>
</html>
