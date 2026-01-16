<?php
	session_start(); 
	include_once("../../conexionli.php");
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
	
	if(isset($_GET['Borrar'])){
		$link=Conectarse();
		if(isset($_GET['nCuenta']))				{ $nCuenta 			= $_GET['nCuenta'];			}
		if(isset($_GET['nDocumento']))			{ $nDocumento		= $_GET['nDocumento'];		}
		if(isset($_GET['nTransaccion']))		{ $nTransaccion		= $_GET['nTransaccion'];	}
		$fCta = explode('|',$_GET['nCuenta']);
		$bdProv=$link->query("DELETE FROM ctasctesmovi WHERE nCuenta = '".$fCta[0]."' and nTransaccion = $nTransaccion");
		$link->close();
	}
	
	if(isset($_GET['Guardar'])){
		$nCuenta 		= '';
		$nDocumento 	= '';
		$nTransaccion 	= '0';
		if(isset($_GET['nCuenta']))				{ $nCuenta 			= $_GET['nCuenta'];			}
		if(isset($_GET['MesFiltro']))			{ $MesFiltro 		= $_GET['MesFiltro'];		}
		if(isset($_GET['Agno']))				{ $Agno				= $_GET['Agno'];			}
		if(isset($_GET['fechaTransaccion']))	{ $fechaTransaccion	= $_GET['fechaTransaccion'];}
		if(isset($_GET['tpTransaccion']))		{ $tpTransaccion	= $_GET['tpTransaccion'];	}
		if(isset($_GET['Descripcion']))			{ $Descripcion		= $_GET['Descripcion'];		}
		if(isset($_GET['nDocumento']))			{ $nDocumento		= $_GET['nDocumento'];		}
		if(isset($_GET['nTransaccion']))		{ $nTransaccion		= $_GET['nTransaccion'];	}
		if(isset($_GET['Monto']))				{ $Monto			= $_GET['Monto'];			}
		$fCta = explode('|',$_GET['nCuenta']);
		$SQL = "Select * From ctasctesmovi Where nCuenta = '".$fCta[0]."' and nTransaccion = $nTransaccion";
		//echo $SQL;
		$link=Conectarse();
		$bdCot=$link->query($SQL);
		if($rowCot=mysqli_fetch_array($bdCot)){
			$actSQL="UPDATE ctasctesmovi SET ";
			$actSQL.="fechaTransaccion		='".$fechaTransaccion.	"',";
			$actSQL.="Descripcion			='".$Descripcion.		"',";
			$actSQL.="tpTransaccion			='".$tpTransaccion.		"',";
			$actSQL.="nDocumento			='".$nDocumento.		"',";
			$actSQL.="nTransaccion			='".$nTransaccion.		"',";
			$actSQL.="Monto					='".$Monto.				"'";
			$actSQL.="WHERE nCuenta	= '".$fCta[0]."' and nTransaccion = $nTransaccion";
			$bdCot=$link->query($actSQL);
		}else{
			$usr = $_SESSION['usr'];
			$nCuentaG = $fCta[0];
			$link->query("insert into ctasctesmovi(	
																nCuenta,
																usr,
																fechaTransaccion,
																Descripcion,
																tpTransaccion,
																nTransaccion,
																Monto
																) 
													values 	(	
																'$nCuentaG',
																'$usr',
																'$fechaTransaccion',
																'$Descripcion',
																'$tpTransaccion',
																'$nTransaccion',
																'$Monto'
				)");
		}
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
	$nCuenta = '';
		$fCta = explode('|',$_GET['nCuenta']);
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM ctasctescargo Where nCuenta = '".$fCta[0]."'");
		if ($rowP=mysqli_fetch_array($bdPer)){
			$nombreTitular 	= $rowP['nombreTitular'];
			$nCuenta 		= $rowP['nCuenta'];
			$Banco			= $rowP['Banco'];
		}
		$link->close();
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Intranet Simet</title>

<link href="../styles.css" rel="stylesheet" type="text/css">
<link href="../../css/tpv.css" rel="stylesheet" type="text/css">

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
							<img src="../../imagenes/ctacte.png" width="28" height="28" align="middle">
							<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
								Movimiento Cuenta Corriente <?php echo $nCuenta.' ('.$Banco.')'; ?>
							</strong>
						</td>
						<td width="50%">
							<div id="ImagenBarra">
								<a href="cerrarsesion.php" title="Cerrar Sesión">
									<img src="../../gastos/imagenes/preview_exit_32.png" width="32" height="32">
								</a>
							</div>
						</td>
					</tr>
				</table>
			</div>
			<?php include_once('muestraCartola.php'); ?> 
		</div>
		<div style="clear:both;"></div>
				
	</div>
	<br>
	
	
</body>
</html>
