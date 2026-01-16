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

	$link=Conectarse();
	$sql = "SELECT * FROM Ingresos";  // sentencia sql
	$result = $link->query($sql);
	$numero = $result->num_rows; // obtenemos el n�mero de filas
	$link->close();

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
		$bdGto	=	$link->query("SELECT * FROM MovGastos");
		$inicio	=	$bdGto>num_rows - $nRegistros;
		$limite	=	$bdGto>num_rows;
		$link->close();
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
<style type="text/css">
<!--
body {
	
	margin-top: 0px;
	margin-bottom: 0px;
	background: url(../gastos/imagenes/Usach.jpg) no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
	max-width:100%;
	width:100%;
	margin-left:auto;
	margin-right:auto;	

	
}
-->
</style>

</head>

<body>
	<?php include_once('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<?php //include_once('menulateral.php'); ?>
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				Proveedores
				<?php include_once('barramenu.php'); ?>
				<?php
/*
				echo '				<div id="Saldos">';
										$link=Conectarse();
										$dFecha = date('Ymd');
										$result  = $link->query("SELECT SUM(Bruto) as tBruto FROM MovGastos WHERE IdRecurso = '1' && FechaGasto = '".$dFecha."'");
										$row 	 = mysqli_fetch_array($result);
				echo '					Gastos Hoy $ '.number_format($row['tBruto'], 0, ',', '.');
										$result  = $link->query("SELECT SUM(Bruto) as tBruto FROM MovGastos WHERE IdRecurso = '1'");  
										$row 	 = mysqli_fetch_array($result);
				echo '					Gastos Caja $ '.number_format($row['tBruto'], 0, ',', '.');
				
				echo '				</div>';
				echo '				<div id="Saldos">';
										$bdRec=$link->query("SELECT * FROM Recursos WHERE IdRecurso = '1'");
										if ($rowRec=mysqli_fetch_array($bdRec)){
				echo '						Saldo $ '.number_format($rowRec['Saldo'], 0, ',', '.');
											$Saldo = $rowRec['Saldo'];
										}
										$link->close();
				echo '				</div>';
*/
				?>
				
			</div>
			<div id="BarraOpciones">
				<div id="ImagenBarraLeft">
					<a href="../plataformaErp.php" title="Menú Principal">
						<img src="../gastos/imagenes/Menu.png"><br>
					</a>
					Principal
				</div>
				<div id="ImagenBarraLeft">
					<a href="personal.php" title="Personal">
						<img src="../gastos/imagenes/subst_student.png" width="48"><br>
					</a>
					Personal
				</div>
				<div id="ImagenBarraLeft" title="Prestadores">
					<a href="phonorarios.php" title="Prestadores">
						<img src="../gastos/imagenes/send_48.png"><br>
					</a>
					Prestadores
				</div>
				<div id="ImagenBarraLeft" title="Proveedores">
					<a href="proveedores.php" title="Proveedores">
						<img src="../gastos/imagenes/contactus_128.png"><br>
					</a>
					Proveedores
				</div>
				<div id="ImagenBarraLeft" title="Cálculo de Sueldos">
					<a href="CalculoSueldos.php" title="Cálculo de Sueldos">
						<img src="../gastos/imagenes/purchase_128.png"><br>
					</a>
					Sueldos
				</div>
				<div id="ImagenBarraLeft" title="Cálculo de Honorarios">
					<a href="CalculoHonorarios.php" title="Servicios de Honorarios">
						<img src="../gastos/imagenes/blank_128.png"><br>
					</a>
					Honorarios
				</div>
				<!--
				<div id="ImagenBarraLeft" title="Pago Factura Proveedores">
					<a href="CalculoFacturas.php" title="Pago con Factura">
						<img src="../gastos/imagenes/crear_certificado.png"><br>
					</a>
					Facturas
				</div>
				-->
				<div id="ImagenBarraLeft" title="Informes Emitidos">
					<a href="ipdf.php" title="Informes Emitidos">
						<img src="../gastos/imagenes/pdf.png"><br>
					</a>
					Emitidos
				</div>
				<div id="ImagenBarraLeft" title="Agregar Proveedor">
					<a href="mproveedores.php?Proceso=1" title="Agregar Proveedor">
						<img src="../gastos/imagenes/student_add_32.png"><br>
					</a>
					+Proveedor
				</div>
			</div>

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
				$bdProv=$link->query("SELECT * FROM Proveedores Where TpCosto = 'S' Order By Proveedor Limit $inicio, $nRegistros");
				if ($row=mysqli_fetch_array($bdProv)){
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
					}WHILE ($row=mysqli_fetch_array($bdProv));
				}
				$link->close();
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
