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
		header("Location: index.php");
	}

	$link=Conectarse();
	$sql = "SELECT * FROM Ingresos";  // sentencia sql
	$result = mysql_query($sql);
	$numero = mysql_num_rows($result); // obtenemos el número de filas
	mysql_close($link);

	if($numero==0){
		header("Location: ingresocaja.php?Proceso=1");
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
		$bdGto	=	mysql_query("SELECT * FROM MovGastos");
		$inicio	=	mysql_num_rows($bdGto) - $nRegistros;
		$limite	=	mysql_num_rows($bdGto);
		mysql_close($link);
	}
	
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Intranet Simet</title>

<link href="styles.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
</head>

<body>
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<?php //include('menulateral.php'); ?>
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				Proveedores
				<?php include('barramenu.php'); ?>
				<div id="ImagenBarra">
					<a>
					<img src="../gastos/imagenes/r_x.png"  width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="mproveedores.php?Proceso=1" title="Agregar Proveedor">
						<img src="../gastos/imagenes/student_add_32.png" width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="plataformaFacturas.php" title="Volver">
						<img src="../gastos/imagenes/preview_back_32.png" width="28" height="28">
					</a>
				</div>
				<?php
/*
				echo '				<div id="Saldos">';
										$link=Conectarse();
										$dFecha = date('Ymd');
										$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM MovGastos WHERE IdRecurso = '1' && FechaGasto = '".$dFecha."'");
										$row 	 = mysql_fetch_array($result);
				echo '					Gastos Hoy $ '.number_format($row['tBruto'], 0, ',', '.');
										$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM MovGastos WHERE IdRecurso = '1'");  
										$row 	 = mysql_fetch_array($result);
				echo '					Gastos Caja $ '.number_format($row['tBruto'], 0, ',', '.');
				
				echo '				</div>';
				echo '				<div id="Saldos">';
										$bdRec=mysql_query("SELECT * FROM Recursos WHERE IdRecurso = '1'");
										if ($rowRec=mysql_fetch_array($bdRec)){
				echo '						Saldo $ '.number_format($rowRec['Saldo'], 0, ',', '.');
											$Saldo = $rowRec['Saldo'];
										}
										mysql_close($link);
				echo '				</div>';
*/
				?>
				
			</div>
<!--
			<div id="BarraFiltro">
				<img src="imagenes/data_filter_128.png" width="28" height="28">
			</div>
-->
			<?php
				echo '<div align="center">';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td  width="10%"><strong>RUT 			</strong></td>';
				echo '			<td  width="20%"><strong>Proveedores	</strong></td>';
				echo '			<td  width="20%"><strong>Contacto		</strong></td>';
				echo '			<td  width="10%"><strong>Tp.Cta			</strong></td>';
				echo '			<td  width="10%"><strong>N° Cta			</strong></td>';
				echo '			<td  width="20%"><strong>Banco			</strong></td>';
				echo '			<td colspan="2"  width="10%"><strong>Procesos</strong></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaListado">';
				$n = 0;

				$link=Conectarse();
				$bdProv=mysql_query("SELECT * FROM Proveedores Order By Proveedor Limit $inicio, $nRegistros");
				if ($row=mysql_fetch_array($bdProv)){
					DO{
						$n++;
						echo '		<tr>';
						echo '			<td width="10%">'.$row['RutProv'].'		</td>';
						echo '			<td width="20%">'.$row['Proveedor'].'	</td>';
						echo '			<td width="20%">'.$row['Contacto'].'	</td>';
						echo '			<td width="10%">'.$row['TpCta'].'		</td>';
						echo '			<td width="10%">'.$row['NumCta'].'		</td>';
						echo '			<td width="20%">'.$row['Banco'].'		</td>';
    					echo '			<td><a href="mproveedores.php?Proceso=2&RutProv='.$row['RutProv'].'"><img src="../gastos/imagenes/corel_draw_128.png"   width="22" height="22" title="Editar Ficha"></a></td>';
    					echo '			<td><a href="mproveedores.php?Proceso=3&RutProv='.$row['RutProv'].'"><img src="../gastos/imagenes/delete_32.png" 		 width="22" height="22" title="Eliminar"	></a></td>';
						echo '		</tr>';
					}WHILE ($row=mysql_fetch_array($bdProv));
				}
				mysql_close($link);
				echo '	</table>';
				echo '</div>';
			?>


		</div>
	</div>
	<div style="clear:both; "></div>
	<br>
<!--
	<div id="CajaPie" class="degradadoNegro">
		Laboratorio Simet
	</div>
-->
</body>
</html>
