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
<link href="../css/tpv.css" rel="stylesheet" type="text/css">

</head>

<body onLoad="document.form.dBuscado.focus();">
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<?php //include('menulateral.php'); ?>
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				Clientes
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
					<a href="plataformaFacturas.php" title="Principal Facturacion">
						<img src="../gastos/imagenes/room_48.png" width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a>
					<img src="../gastos/imagenes/r_x.png"  width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="mClientes.php?Proceso=1" title="Agregar Cliente">
						<img src="../gastos/imagenes/student_add_32.png" width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="plataformaFacturas.php" title="Volver">
						<img src="../gastos/imagenes/preview_back_32.png" width="28" height="28">
					</a>
				</div>
				
			</div>
			<div id="BarraFiltro">
				<?php
				if(isset($_POST['Buscar'])){
					$dBuscado = $_POST['dBuscado'];
				}
				?>
				<form name="form" action="clientes.php" method="post">
					<img src="../gastos/imagenes/data_filter_128.png"  width="50" height="50">
					Buscar 
					<input name="dBuscado" align="right" maxlength="50" size="50" title="Ingrese busqueda por parte del Nombre del Cliente o RUT..." style="font-size:24px;" value="<?php echo $dBuscado; ?>">
					<button name="Buscar">
						<img src="../gastos/imagenes/buscar.png"  width="32" height="32">
					</button>
				</form>
			</div>
			<?php
				echo '<div align="center">';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td  width="10%" align="center" height="40"><strong>RUT 			</strong></td>';
				echo '			<td  width="30%" align="center"><strong>Clientes		</strong></td>';
				echo '			<td  width="20%" align="center"><strong>Teléfono		</strong></td>';
				echo '			<td  width="30%" align="center"><strong>Correo			</strong></td>';
				echo '			<td colspan="2" width="10%" align="center"><strong>Procesos</strong></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListado">';
				$n = 0;

				$link=Conectarse();
				//$bdProv=mysql_query("SELECT * FROM Clientes Order By Cliente Limit $inicio, $nRegistros");
				$bdProv=mysql_query("SELECT * FROM Clientes Order By Cliente");
				if(isset($_POST['Buscar'])){
					$dBuscado = $_POST['dBuscado'];
					$bdProv=mysql_query("SELECT * FROM Clientes Where RutCli Like '%".$dBuscado."%' || Cliente Like '%".$dBuscado."%' Order By Cliente");
				}
				
				if ($row=mysql_fetch_array($bdProv)){
					DO{
						$n++;
						echo '		<tr id="barraVerde">';
						echo '			<td width="10%" align="center">'.$row['RutCli'].'		</td>';
						echo '			<td width="30%">'.$row['Cliente'].'	</td>';
						echo '			<td width="20%">'.$row['Telefono'].'	</td>';
						echo '			<td width="30%">'.$row['Email'].'		</td>';
    					echo '			<td><a href="mClientes.php?Proceso=2&RutCli='.$row['RutCli'].'"><img src="../gastos/imagenes/corel_draw_128.png"   width="32" height="32" title="Editar Ficha"></a></td>';
    					echo '			<td><a href="mClientes.php?Proceso=3&RutCli='.$row['RutCli'].'"><img src="../gastos/imagenes/delete_32.png" 		 width="32" height="32" title="Eliminar"	></a></td>';
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
</body>
</html>
