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
	$Mm = "Junio";
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
	
	$link=Conectarse();
	$bdPr=mysql_query("SELECT * FROM Proyectos");
	if ($row=mysql_fetch_array($bdPr)){
		$Proyecto 	= $row['IdProyecto'];
	}
	mysql_close($link);
	$Estado = "";
	if(isset($_POST['Proyecto']))	{ $Proyecto = $_POST['Proyecto']; 	}
	if(isset($_GET['MesHon']))		{ $MesHon 	= $_GET['MesHon']; 		}
	if(isset($_GET['Proyecto']))	{ $Proyecto = $_GET['Proyecto']; 	}
	if(isset($_GET['Estado']))		{ $Estado 	= $_GET['Estado']; 		}
	
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
		$bdGto	=	mysql_query("SELECT * FROM Honorarios");
		$inicio	=	mysql_num_rows($bdGto) - $nRegistros;
		$limite	=	mysql_num_rows($bdGto);
		mysql_close($link);
	}
	
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>M&oacute;dulo de Sueldos</title>

<link href="styles.css" rel="stylesheet" type="text/css">
<script src="../jquery/jquery-1.6.4.js"></script>

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
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<!-- <form action="formularios/contrato.php" method="post"> -->
	<form action="f.php" method="post">
	<div id="Cuerpo">
		<?php //include('menulateral.php'); ?>
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<img src="../gastos/imagenes/blank_128.png" width="28" height="28" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					<?php echo 'Honorarios '.$pPago; ?>
				</strong>
				<?php include('barramenu.php'); ?>
				<div id="ImagenBarra">
					<a>
					<img src="../gastos/imagenes/r_x.png"  width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<?php
					echo '<a href="cHonorarios.php?Proceso=1&Periodo='.$PeriodoPago.'" title="Nueva Boleta Honorario">';
					echo '	<img src="../gastos/imagenes/export_32.png" width="28" height="28">';
					echo '</a>';
					?>
				</div>
<!--
				<div id="ImagenBarra">
					<?php
						echo '<a href="gHonorarios.php?Periodo='.$PeriodoPago.'&Proyecto='.$Proyecto.'" title="Generar Boletas Honorarios Funcionarios Internos">'; 
					?>
						<img src="../gastos/imagenes/single_class.png" width="28" height="28">
					</a>
				</div>
-->
				<div id="ImagenBarra">
					<a href="sueldos.php" title="Volver">
						<img src="../gastos/imagenes/preview_back_32.png" width="28" height="28">
					</a>
				</div>
			</div>
			<div id="BarraFiltro">
				<img src="../gastos/imagenes/data_filter_128.png" width="28" height="28">
					<!-- Fitra por Proyecto -->
	  				<select name="Proyecto" id="Proyecto" onChange="window.location = this.options[this.selectedIndex].value; return true;">
						<?php 
							$link=Conectarse();
							$bdPr=mysql_query("SELECT * FROM Proyectos");
							if ($row=mysql_fetch_array($bdPr)){
								DO{
			    					if($Proyecto == $row['IdProyecto']){
										echo '	<option selected 	value="CalculoHonorarios.php?Proyecto='.$row['IdProyecto'].'&MesHon='.$MesHon.'&Estado='.$Estado.'&Mm='.$MesHon.'">'.$row['IdProyecto'].'</option>';
									}else{
										echo '	<option 			value="CalculoHonorarios.php?Proyecto='.$row['IdProyecto'].'&MesHon='.$MesHon.'&Estado='.$Estado.'&Mm='.$MesHon.'">'.$row['IdProyecto'].'</option>';
									}
								}WHILE ($row=mysql_fetch_array($bdPr));
							}
							mysql_close($link);
						?>
					</select>
					<input name="Proyecto" type="hidden" value="<?php echo $Proyecto;?>">
					<!-- Fitra por Fecha -->
	  					<select name='MesHon' id='MesHon' onChange='window.location = this.options[this.selectedIndex].value; return true;'>
							<?php
								for($i=1; $i <=12 ; $i++){
									if($Mes[$i]==$MesHon){
										echo '		<option selected 									value="CalculoHonorarios.php?Proyecto='.$Proyecto.'&MesHon='.$Mes[$i].'&Estado='.$Estado.'&Mm='.$Mes[$i].'">'.$Mes[$i].'</option>';
									}else{
										if($i > strval($fd[1])){
											echo '	<option style="opacity:.5; color:#ccc;" disabled 	value="CalculoHonorarios.php?Proyecto='.$Proyecto.'&MesHon='.$Mes[$i].'&Estado='.$Estado.'&Mm='.$Mes[$i].'">'.$Mes[$i].'</option>';
										}else{
											echo '	<option 											value="CalculoHonorarios.php?Proyecto='.$Proyecto.'&MesHon='.$Mes[$i].'&Estado='.$Estado.'&Mm='.$Mes[$i].'">'.$Mes[$i].'</option>';
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
								echo '<option  			value="CalculoHonorarios.php?Proyecto='.$Proyecto.'&Mm='.$MesHon.'&MesHon='.$MesHon.'&Estado=" >Sin Firmar</option>';
								echo '<option selected  value="CalculoHonorarios.php?Proyecto='.$Proyecto.'&Mm='.$MesHon.'&MesHon='.$MesHon.'&Estado=P">Informados</option>';
							}else{
								echo '<option selected	value="CalculoHonorarios.php?Proyecto='.$Proyecto.'&Mm='.$MesHon.'&MesHon='.$MesHon.'&Estado=" >Sin Firmar</option>';
								echo '<option   		value="CalculoHonorarios.php?Proyecto='.$Proyecto.'&Mm='.$MesHon.'&MesHon='.$MesHon.'&Estado=P">Informados</option>';
							}
							?>
						</select>
					<div id="ImagenBarra" style="float:none; display:inline;">
						<?php 
            				echo '<input style="display:inline; float:none;"  name="Imprimir" type="image" id="Imprimir" src="../gastos/imagenes/printer_128_hot.png" width="20" height="20" title="Imprimir Formularios">';
							//echo '<a href="formularios/iContratos.php?Proyecto='.$Proyecto.'&Periodo='.$PeriodoPago.'" title="Imprimir Formulario N°5, Contratos Asociados ">'; ?>
							<!-- <img src="../gastos/imagenes/printer_128_hot.png" width="20" height="20"></a> -->
					</div>
					<div id="ImagenBarra" style="float:none; display:inline;">
						<?php 
							echo '<a href="CalculoHonorarios.php" title="Actualizar Página">'; ?>
							<img src="../gastos/imagenes/refresh_128.png" width="20" height="20"></a>
					</div>
			</div>
			<?php
				echo '<div >';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td  width="05%" align="center"><strong>N°	 			</strong></td>';
				echo '			<td  width="05%" align="center"><strong>Boleta			</strong></td>';
				echo '			<td  width="09%" align="center"><strong>Contrato/Pago	</strong></td>';
				echo '			<td  width="10%" align="center"><strong>RUT				</strong></td>';
				echo '			<td  width="13%" align="center"><strong>Nombres			</strong></td>';
				echo '			<td  width="05%" align="center"><strong>Costo			</strong></td>';

				echo '			<td  width="08%" align="center"><strong>Desde			</strong></td>';
				echo '			<td  width="08%" align="center"><strong>Hasta			</strong></td>';

				echo '			<td  width="09%" align="center"><strong>Total			</strong></td>';
				echo '			<td  width="08%" align="center"><strong>Retención		</strong></td>';
				echo '			<td  width="08%" align="center"><strong>Líquido			</strong></td>';
				echo '			<td colspan="4"  width="12%" align="center"><strong>Mes.'.$PeriodoPago.'</strong></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaListado">';
				$n = 0;
				$tTot = 0;
				$tRet = 0;
				$tLiq = 0;
				$link=Conectarse();
				$bdHon=mysql_query("SELECT * FROM Honorarios Where IdProyecto = '".$Proyecto."' && Estado = '".$Estado."' && PeriodoPago ='".$PeriodoPago."' Limit $inicio, $nRegistros");
				if ($row=mysql_fetch_array($bdHon)){
					DO{
						$fd = explode('-', $row['FechaPago']);
						if($Mes[intval($fd[1])]==$MesHon){
							$n++;
							$tTot += $row['Total'];
							$tRet += $row['Retencion'];
							$tLiq += $row['Liquido'];
							if($row['Estado'] == 'P'){
								echo '<tr bgcolor="#FFFF66">';
							}else{
								echo '<tr>';
							}
							echo '			<td width="05%">'.$n.'</td>';
							echo '			<td width="05%">';
							echo 				$row['nBoleta'];
							echo '			</td>';
							echo '			<td width="09%">';
												$fd = explode('-', $row['FechaPago']);
												if($fd[1]>0){
													echo $fd[2].'-'.$fd[1].'-'.$fd[0];
												}else{
													echo 'Pendiente';
												}
							echo '			</td>';
							echo '			<td width="10%">'.$row['Run'].'</td>';
							echo '			<td width="13%">';
											$bdPer=mysql_query("SELECT * FROM PersonalHonorarios Where Run = '".$row['Run']."'");
											if ($rowP=mysql_fetch_array($bdPer)){
												echo $rowP['Paterno'].' '.$rowP['Materno'].' '.$rowP['Nombres'];
											}
							echo '			</td>';
							echo '			<td width="05%" align="right">';
												if($row['TpCosto']=="E"){ echo 'Esp.'; }
												if($row['TpCosto']=="M"){ echo 'Men.'; }
												if($row['TpCosto']=="I"){ echo 'Inv.'; }
							echo ' 			</td>';

							echo '			<td width="08%" align="right">';
												$fd = explode('-', $row['PerIniServ']);
							echo 				$fd[2].'-'.$fd[1].'-'.$fd[0];
							echo ' 			</td>';
							echo '			<td width="08%" align="right">';
												$fd = explode('-', $row['PerTerServ']);
							echo 				$fd[2].'-'.$fd[1].'-'.$fd[0];
							echo ' 			</td>';

							echo '			<td width="09%" align="right">';
							echo 				number_format($row['Total'], 0, ',', '.');
							echo ' 			</td>';
							echo '			<td width="08%" align="right">';
							echo 				number_format($row['Retencion'], 0, ',', '.');
							echo ' 			</td>';
							echo '			<td width="08%" align="right">';
							echo 				number_format($row['Liquido'], 0, ',', '.');
							echo ' 			</td>';
	    					echo '			<td width="3%"><a href="cHonorarios.php?Proceso=2&Run='.$row['Run'].'&nBoleta='.$row['nBoleta'].'&Periodo='.$PeriodoPago.'"><img src="../gastos/imagenes/corel_draw_128.png"   	width="22" height="22" title="Editar Boleta Honorario">	</a></td>';
	    					echo '			<td width="3%"><a href="cHonorarios.php?Proceso=3&Run='.$row['Run'].'&nBoleta='.$row['nBoleta'].'&Periodo='.$PeriodoPago.'"><img src="../gastos/imagenes/delete_32.png" 		width="22" height="22" title="Eliminar Boleta de Honorarios">				</a></td>';
	    					echo '			<td width="3%"><a href="formularios/contrato.php?Run='.$row['Run'].'&nBoleta='.$row['nBoleta'].'&Periodo='.$PeriodoPago.'"><img src="../gastos/imagenes/pdf.png" 				width="22" height="22" title="Imprimir Contrato">				</a></td>';
	    					echo '			<td width="3%"><input name="Reg[]" type="checkbox" value="'.$row['Run'].','.$row['nBoleta'].','.$Proyecto.','.$PeriodoPago.'" title="Seleccionar"></td>';
							echo '		</tr>';
						}else{
							$n++;
							$tTot += $row['Total'];
							$tRet += $row['Retencion'];
							$tLiq += $row['Liquido'];
							if($row['Estado'] == 'P'){
								echo '<tr bgcolor="#FFFF66">';
							}else{
								echo '<tr>';
							}
							echo '			<td width="05%">'.$n.'</td>';
							echo '			<td width="05%">'.$row['nBoleta'].'</td>';
							echo '			<td width="09%">';
												$fd = explode('-', $row['FechaPago']);
												if($fd[1]>0){
													echo $fd[2].'-'.$fd[1].'-'.$fd[0];
												}else{
													echo 'Pendiente';
												}
							echo '			</td>';
							echo '			<td width="10%">'.$row['Run'].'</td>';
							echo '			<td width="10%">';
											$bdPer=mysql_query("SELECT * FROM PersonalHonorarios Where Run = '".$row['Run']."'");
											if ($rowP=mysql_fetch_array($bdPer)){
												echo $rowP['Paterno'].' '.$rowP['Materno'].' '.$rowP['Nombres'];
											}
							echo '			</td>';
							echo '			<td width="05%" align="right">';
												if($row['TpCosto']=="E"){ echo 'Esp.'; }
												if($row['TpCosto']=="M"){ echo 'Men.'; }
												if($row['TpCosto']=="I"){ echo 'Inv.'; }
							echo ' 			</td>';

							echo '			<td width="08%" align="right">';
												$fd = explode('-', $row['PerIniServ']);
							echo 				$fd[2].'-'.$fd[1].'-'.$fd[0];
							echo ' 			</td>';
							echo '			<td width="08%" align="right">';
												$fd = explode('-', $row['PerTerServ']);
							echo 				$fd[2].'-'.$fd[1].'-'.$fd[0];
							echo ' 			</td>';

							echo '			<td width="09%" align="right">';
							echo 				number_format($row['Total'], 0, ',', '.');
							echo ' 			</td>';
							echo '			<td width="08%" align="right">';
							echo 				number_format($row['Retencion'], 0, ',', '.');
							echo ' 			</td>';
							echo '			<td width="08%" align="right">';
							echo 				number_format($row['Liquido'], 0, ',', '.');
							echo ' 			</td>';
	    					echo '			<td width="3%"><a href="cHonorarios.php?Proceso=2&Run='.$row['Run'].'&nBoleta='.$row['nBoleta'].'&Periodo='.$PeriodoPago.'"><img src="../gastos/imagenes/corel_draw_128.png"   	width="22" height="22" title="Editar Boleta Honorario">	</a></td>';
	    					echo '			<td width="3%"><a href="cHonorarios.php?Proceso=3&Run='.$row['Run'].'&nBoleta='.$row['nBoleta'].'&Periodo='.$PeriodoPago.'"><img src="../gastos/imagenes/delete_32.png" 		width="22" height="22" title="Eliminar Boleta de Honorarios">				</a></td>';
	    					echo '			<td width="3%"><a href="formularios/contrato.php?Run='.$row['Run'].'&nBoleta='.$row['nBoleta'].'&Periodo='.$PeriodoPago.'"><img src="../gastos/imagenes/pdf.png" 				width="22" height="22" title="Imprimir Contrato">				</a></td>';
	    					echo '			<td width="3%"><input name="Reg[]" type="checkbox" value="'.$row['Run'].','.$row['nBoleta'].','.$Proyecto.','.$PeriodoPago.'" title="Seleccionar"></td>';
							echo '		</tr>';
						}
					}WHILE ($row=mysql_fetch_array($bdHon));
				}
				mysql_close($link);
				echo '	</table>';
				if($tTot){
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaFinal">';
				echo '		<tr>';
				echo '			<td width="60%" align="right">Total Página</td>';
				echo '			<td width="09%" align="right">'.number_format($tTot , 0, ',', '.').'			</td>';
				echo '			<td width="08%" align="right">'.number_format($tRet , 0, ',', '.').'			</td>';
				echo '			<td width="08%" align="right">'.number_format($tLiq , 0, ',', '.').'			</td>';
    			echo '			<td width="05%">&nbsp;</td>';
    			echo '			<td width="05%">&nbsp;</td>';
    			echo '			<td width="05%">&nbsp;</td>';
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
