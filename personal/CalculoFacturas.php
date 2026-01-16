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
	//header("Location: formularios/contrato.php?Run=10074437-6&nBoleta=22");
	
	$Mes = array(
					1 => 'Enero', 
					2 => 'Febrero',
					3 => 'Marzo',
					4 => 'Abril',
					5 => 'Mayo',
					6 => 'Junio',
					7 => 'Julio',
					8 => 'Agosto',
					9 => 'Septiembre',
					10 => 'Octubre',
					11 => 'Noviembre',
					12 => 'Diciembre'
				);
				
	$MesNum = array(	
					'Enero' 		=> '01', 
					'Febrero' 		=> '02',
					'Marzo' 		=> '03',
					'Abril' 		=> '04',
					'Mayo' 			=> '05',
					'Junio' 		=> '06',
					'Julio' 		=> '07',
					'Agosto' 		=> '08',
					'Septiembre'	=> '09',
					'Octubre' 		=> '10',
					'Noviembre' 	=> '11',
					'Diciembre'		=> '12'
				);

	$fd 	= explode('-', date('Y-m-d'));
	if(isset($_GET['Mm'])) { 
		$Mm = $_GET['Mm']; 
		$PeriodoPago = $MesNum[$Mm].".".$fd[0];
	}else{
		$Mm = $Mes[ intval($fd[1]) ];
		$PeriodoPago = $fd[1].".".$fd[0];
	}

	$pPago = $Mm.'.'.$fd[0];

	$MesHon 	= $Mm;

	$Proyecto 	= "";
	$Estado = '';
	
	$link=Conectarse();
	$bdPr=$link->query("SELECT * FROM Proyectos");
	if ($row=mysqli_fetch_array($bdPr)){
		$Proyecto 	= $row['IdProyecto'];
	}
	$link->close();
	if(isset($_POST['Proyecto']))	{ $Proyecto = $_POST['Proyecto']; 	}
	if(isset($_GET['MesHon']))		{ $MesHon 	= $_GET['MesHon']; 		}
	if(isset($_GET['Proyecto']))	{ $Proyecto = $_GET['Proyecto']; 	}
	if(isset($_GET['Estado']))		{ $Estado 	= $_GET['Estado']; 		}

	if(isset($_GET['Mm'])) { 
		$Mm = $_GET['Mm']; 
		$PeriodoPago = $MesNum[$Mm].".".$fd[0];
	}else{
		$Mm = $Mes[ intval($fd[1]) ];
		$PeriodoPago = $fd[1].".".$fd[0];
	}

	$pPago = $Mm.'.'.$fd[0];
	
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
		$bdGto	=	$link->query("SELECT * FROM Facturas");
		$inicio	=	$bdGto>num_rows - $nRegistros;
		$limite	=	$bdGto>num_rows;
		$link->close();
	}
	
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>M&oacute;dulo de Sueldos</title>

<link href="styles.css" rel="stylesheet" type="text/css">
<script src="../jquery/jquery-1.6.4.js"></script>

	<link href="../visitas/styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">


<script>
$(document).ready(function(){
  	$("#Imprimir").click(function(){
		$("#ventanita").css({"visibility":"visible"});  
	});
  	$("#cerrarventanita").click(function(){
		$("#ventanita").css({"visibility":"hidden"});  
	});
});
</script>
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
	/*background: url(../gastos/imagenes/Usach.jpg) no-repeat center center fixed;*/
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
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
</head>

<body>
	
	<?php include_once('head.php'); ?>
	<div id="linea"></div>
	<!-- <form action="formularios/contrato.php" method="post"> -->
	<form action="formularios/F7exentas.php" method="post">
	<div id="Cuerpo">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<img src="../gastos/imagenes/crear_certificado.png" width="28" height="28" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					<?php echo 'Facturas <span id="BoxPeriodo">'.$pPago.'</span>'; ?>
				</strong>
				<?php include_once('barramenu.php'); ?>
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
						<img src="../gastos/imagenes/subst_student.png"><br>
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
				<div id="ImagenBarraLeft" title="Pago Factura Proveedores">
					<a href="CalculoFacturas.php" title="Pago con Factura">
						<img src="../gastos/imagenes/crear_certificado.png"><br>
					</a>
					Facturas
				</div>
				<div id="ImagenBarraLeft" title="Informes Emitidos">
					<a href="ipdf.php" title="Informes Emitidos">
						<img src="../gastos/imagenes/pdf.png"><br>
					</a>
					Emitidos
				</div>
				<div id="ImagenBarraLeft" title="Agregar Boleta Honorario">
					<?php
					echo '<a href="registrafacturas.php?Proceso=1&Periodo='.$PeriodoPago.'" title="Nueva Factura">';
					echo '	<img src="../gastos/imagenes/export_32.png"><br>';
					echo '</a>';
					?>
					+Factura
				</div>
			</div>

			
			<div id="BarraFiltro">
				<img src="../gastos/imagenes/data_filter_128.png" width="28" height="28">
					<!-- Fitra por Proyecto -->
	  				<select name="Proyecto" id="Proyecto" onChange="window.location = this.options[this.selectedIndex].value; return true;">
						<?php 
							$link=Conectarse();
							$bdPr=$link->query("SELECT * FROM Proyectos");
							if ($row=mysqli_fetch_array($bdPr)){
								DO{
			    					if($Proyecto == $row['IdProyecto']){
										echo "	<option selected 	value='CalculoFacturas.php?Proyecto=".$row['IdProyecto']."&MesHon=".$MesHon."&Estado=".$Estado."&Mm=".$MesHon."'>".$row['IdProyecto']."</option>";
									}else{
										echo "	<option  			value='CalculoFacturas.php?Proyecto=".$row['IdProyecto']."&MesHon=".$MesHon."&Estado=".$Estado."&Mm=".$MesHon."'>".$row['IdProyecto']."</option>";
									}
								}WHILE ($row=mysqli_fetch_array($bdPr));
							}
							$link->close();
						?>
					</select>

					<!-- Fitra por Fecha -->
	  					<select name='MesHon' id='MesHon' onChange='window.location = this.options[this.selectedIndex].value; return true;'>
							<?php
								for($i=1; $i <=12 ; $i++){
									if($Mes[$i]==$MesHon){
										echo '		<option selected 									value="CalculoFacturas.php?Proyecto='.$Proyecto.'&MesHon='.$Mes[$i].'&Estado='.$Estado.'&Mm='.$Mes[$i].'">'.$Mes[$i].'</option>';
									}else{
										if($i > strval($fd[1])){
											//echo '	<option style="opacity:.5; color:#ccc;" disabled 	value="CalculoFacturas.php?Proyecto='.$Proyecto.'&MesHon='.$Mes[$i].'&Estado='.$Estado.'&Mm='.$Mes[$i].'">'.$Mes[$i].'</option>';
											echo '	<option 											value="CalculoFacturas.php?Proyecto='.$Proyecto.'&MesHon='.$Mes[$i].'&Estado='.$Estado.'&Mm='.$Mes[$i].'">'.$Mes[$i].'</option>';
										}else{
											echo '	<option 											value="CalculoFacturas.php?Proyecto='.$Proyecto.'&MesHon='.$Mes[$i].'&Estado='.$Estado.'&Mm='.$Mes[$i].'">'.$Mes[$i].'</option>';
										}
									}
								}
							?>
						</select>
					<!-- Fin Filtro -->

					<!-- Fitra por Fecha -->
	  					<select name='Estado' id='Estado' onChange='window.location = this.options[this.selectedIndex].value; return true;'>
							<?php
							if($Estado=='P'){
								echo '<option  			value="CalculoFacturas.php?Proyecto='.$Proyecto.'&Mm='.$MesHon.'&MesHon='.$MesHon.'&Estado=" >Sin Firmar</option>';
								echo '<option selected  value="CalculoFacturas.php?Proyecto='.$Proyecto.'&Mm='.$MesHon.'&MesHon='.$MesHon.'&Estado=P">Informados</option>';
							}else{
								echo '<option selected	value="CalculoFacturas.php?Proyecto='.$Proyecto.'&Mm='.$MesHon.'&MesHon='.$MesHon.'&Estado=" >Sin Firmar</option>';
								echo '<option   		value="CalculoFacturas.php?Proyecto='.$Proyecto.'&Mm='.$MesHon.'&MesHon='.$MesHon.'&Estado=P">Informados</option>';
							}
							?>
						</select>
					<!--
					<div id="ImagenBarra" style="float:none; display:inline;">
						<?php 
            				echo '<input style="display:inline; float:none;"  name="Imprimir" type="image"  src="../gastos/imagenes/printer_128_hot.png" width="20" height="20" title="Imprimir Formulario N°7, de todas las Facturas Seleccionadas">';
							//echo '<a href="formularios/iContratos.php?Proyecto='.$Proyecto.'&Periodo='.$PeriodoPago.'" title="Imprimir Formulario N°5, Contratos Asociados ">'; 
							//echo '<a href="#" id="Imprimir" title="Imprimir Formulario N°7, de todas las Facturas Seleccionadas">';
							//echo '<img src="../gastos/imagenes/printer_128_hot.png" width="20" height="20"></a>';
						?>
						<div id="ventanita" style="visibility:hidden; position:absolute;">
							<div id="CajaFlotante">
								Concepto <input name="Concepto" type="text" size="50" maxlength="50">
								<input name="aceptarnueva" id="cerrarventanita" type="submit" value="Imprimir">
							</div>
						</div> 
							
					</div>
					-->
					<div id="ImagenBarra" style="float:none; display:inline;">
						<?php 
							echo '<a href="CalculoFacturas.php" title="Actualizar Página">'; ?>
							<img src="../gastos/imagenes/refresh_128.png" width="20" height="20"></a>
					</div>
			</div>



			<?php
				echo '<div >';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td  width="08%">				<strong>N°	 			</strong></td>';
				echo '			<td  width="10%">				<strong>Factura			</strong></td>';
				echo '			<td  width="10%" align="center"><strong>Estado de Pago			</strong></td>';
				echo '			<td  width="10%" align="center"><strong>RUT				</strong></td>';
				echo '			<td  width="30%">				<strong>Proveedor		</strong></td>';
				echo '			<td  width="10%" align="center"><strong>Costo			</strong></td>';
				echo '			<td  width="10%" align="center"><strong>Bruto			</strong></td>';
				echo '			<td colspan="4"  width="12%" align="center"><strong>Mes.'.$PeriodoPago.'</strong></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaListado">';
				$n 		= 0;
				$tBruto = 0;
				$link=Conectarse();
				//$bdHon=$link->query("SELECT * FROM Formularios Where IdProyecto = '".$Proyecto."' && Reembolso = '' && Fecha ='".$PeriodoPago."' Limit $inicio, $nRegistros");
				//$bdHon=$link->query("SELECT * FROM Formularios Where Formulario = 'F7(Factura)'");
				$SQLfac = "SELECT * FROM Facturas Where PeriodoPago = '$PeriodoPago'";
				$bdFac=$link->query($SQLfac);
				if($rowFac=mysqli_fetch_array($bdFac)){
					do{
							$fd = explode('-', $rowFac['FechaFactura']);
							if($fd[1] == 0){
								$fd[1] = substr($PeriodoPago,0,2);
							}
							//echo $rowFac['FechaFactura'].'<br>';
							if($Mes[intval($fd[1])]==$MesHon){
								$n++;
								$tBruto += $row['Bruto'];
								$tr = 'barraBlanca';
								if($rowFac['Estado'] == 'P'){
									$tr = "barraVerde";
								}
								echo '<tr id="'.$tr.'">';
								echo '			<td width="08%">'.$n.'</td>';
								echo '			<td width="10%">';
								echo 				$rowFac['nFactura'].'<br>';
													$fd = explode('-', $rowFac['FechaPago']);
													echo $fd[2].'-'.$fd[1].'-'.$fd[0];
								echo '			</td>';
								echo '			<td width="10%">';
													$fd = explode('-', $rowFac['FechaPago']);
													if($fd[1]>0){
														echo $fd[2].'-'.$fd[1].'-'.$fd[0];
													}else{
														echo 'Pendiente';
													}
								echo '			</td>';
								echo '			<td width="10%">'.$rowFac['RutProv'].'</td>';
								echo '			<td width="30%">';
												$bdPer=$link->query("SELECT * FROM Proveedores Where RutProv = '".$rowFac['RutProv']."'");
												if ($rowP=mysqli_fetch_array($bdPer)){
													echo $rowP['Proveedor'];
												}
								echo '			</td>';
								echo '			<td width="10%" align="right">';
													if($rowFac['TpCosto']=="E"){ echo 'Esporadico'; }
													if($rowFac['TpCosto']=="M"){ echo 'Mensual'; }
													if($rowFac['TpCosto']=="I"){ echo 'Inversión'; }
								echo ' 			</td>';

								echo '			<td width="10%" align="right">';
								echo 				number_format($rowFac['Bruto'], 0, ',', '.');
								echo ' 			</td>';
								echo '			<td width="3%"><a href="seguimientoFacturas.php?RutProv='.$rowFac['RutProv'].'&nFactura='.$rowFac['nFactura'].'&Periodo='.$rowFac['PeriodoPago'].'"><img src="../gastos/imagenes/klipper.png"   			width="22" height="22" title="Seguimiento Facturas">	</a></td>';
								echo '			<td width="3%"><a href="registrafacturas.php?Proceso=2&RutProv='.$rowFac['RutProv'].'&nFactura='.$rowFac['nFactura'].'&Periodo='.$rowFac['PeriodoPago'].'"><img src="../gastos/imagenes/corel_draw_128.png"   	width="22" height="22" title="Editar Boleta Honorario">	</a></td>';
								echo '			<td width="3%"><a href="registrafacturas.php?Proceso=3&RutProv='.$rowFac['RutProv'].'&nFactura='.$rowFac['nFactura'].'&Periodo='.$rowFac['PeriodoPago'].'"><img src="../gastos/imagenes/delete_32.png" 			width="22" height="22" title="Eliminar">				</a></td>';
								echo '			<td width="3%"><a href="../gastos/formularios/F7exento.php?RutProv='.$rowFac['RutProv'].'&nFactura='.$rowFac['nFactura'].'&Periodo='.$rowFac['PeriodoPago'].'"><img src="../gastos/imagenes/pdf.png" 						width="22" height="22" title="Formulario 7: Solicitud de Pago de Factura">				</a></td>';
								echo '		</tr>';
						}
					}WHILE ($rowFac=mysqli_fetch_array($bdFac));
				}
				$link->close();
				echo '	</table>';
				if($tBruto){
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaFinal">';
				echo '		<tr>';
				echo '			<td width="70%" align="right">Total Faturas del Mes de <strong>'.$MesHon.'</strong></td>';
				echo '			<td width="10%" align="right">'.number_format($tBruto , 0, ',', '.').'			</td>';
    			echo '			<td width="12%">&nbsp;</td>';
				echo '		</tr>';
				echo '	</table>';
				}
				echo '</div>';
			?>


		</div>
	</div>
	</form>
	<div style="clear:both; "></div>
	<br>
<!--
	<div id="CajaPie" class="degradadoNegro">
		Laboratorio Simet
	</div>
-->
</body>
</html>
