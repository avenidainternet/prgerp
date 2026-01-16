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
	$Mm = "Junio";
	if(isset($_GET['Agno'])) { 
		$Agno 	= $_GET['Agno']; 
	}else{
		$Agno = $fd[0];
	}
	if(isset($_GET['Mm'])) { 
		$Mm 	= $_GET['Mm']; 
		$PeriodoPago = $MesNum[$Mm].".".$Agno;
		//$PeriodoPago = $MesNum[$Mm].".".$fd[0];
	}else{
		$Mm = $Mes[ intval($fd[1]) ];
		$PeriodoPago = $fd[1].".".$fd[0];
		$Agno = $fd[0];
	}

	$pPago = $Mm.'.'.$Agno;
	//$pPago = $Mm.'.'.$fd[0];

	$MesHon 	= $Mm;
	
	$Proyecto 	= "";
	
	$link=Conectarse();
	$bdPr=$link->query("SELECT * FROM Proyectos");
	if ($row=mysqli_fetch_array($bdPr)){
		$Proyecto 	= $row['IdProyecto'];
	}
	$link->close();
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
		$bdGto	=	$link->query("SELECT * FROM Honorarios");
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

	<link href="../visitas/styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

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
	/*background: url(../gastos/imagenes/Usach.jpg) no-repeat center center fixed;*/
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
	max-width:100%;
	width:100%;
	margin-left:auto;
	margin-right:auto;
	font-family:Arial, Helvetica, sans-serif;

	
}
-->
</style>
</head>

<body>
	<?php include_once('head.php'); ?>
	<div id="linea"></div>
	<!-- <form action="formularios/contrato.php" method="post"> -->
	<form action="f.php" method="post">
	<div id="Cuerpo">
		<?php //include_once('menulateral.php'); ?>
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<img src="../gastos/imagenes/blank_128.png" width="28" height="28" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					<?php echo 'Honorarios '.$pPago; ?>
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
				<div id="ImagenBarraLeft" title="Agregar Boleta Honorario">
					<?php
					echo '<a href="cHonorarios.php?Proceso=1&Periodo='.$PeriodoPago.'" title="Nueva Boleta Honorario">';
					echo '	<img src="../gastos/imagenes/export_32.png"><br>';
					echo '</a>';
					?>
					+ Boleta
				</div>
			</div>
			
			
			
			<div id="BarraFiltro" style="border-top:2px solid #000;">
				<img src="../gastos/imagenes/data_filter_128.png" width="28" height="28">
					<!-- Fitra por Proyecto -->
	  				<select name="Proyecto" id="Proyecto" onChange="window.location = this.options[this.selectedIndex].value; return true;">
						<?php 
							$link=Conectarse();
							$bdPr=$link->query("SELECT * FROM Proyectos");
							if ($row=mysqli_fetch_array($bdPr)){
								do{
			    					if($Proyecto == $row['IdProyecto']){
										echo '	<option selected 	value="CalculoHonorarios.php?Proyecto='.$row['IdProyecto'].'&MesHon='.$MesHon.'&Agno='.$Agno.'&Estado='.$Estado.'&Mm='.$MesHon.'">'.$row['IdProyecto'].'</option>';
									}else{
										echo '	<option 			value="CalculoHonorarios.php?Proyecto='.$row['IdProyecto'].'&MesHon='.$MesHon.'&Agno='.$Agno.'&Estado='.$Estado.'&Mm='.$MesHon.'">'.$row['IdProyecto'].'</option>';
									}
								}while($row=mysqli_fetch_array($bdPr));
							}
							$link->close();
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
											//echo '	<option style="opacity:.5; color:#ccc;" disabled 	value="CalculoHonorarios.php?Proyecto='.$Proyecto.'&MesHon='.$Mes[$i].'&Estado='.$Estado.'&Mm='.$Mes[$i].'">'.$Mes[$i].'</option>';
											echo '	<option style="opacity:.5; color:#ccc;" value="CalculoHonorarios.php?Proyecto='.$Proyecto.'&MesHon='.$Mes[$i].'&Agno='.$Agno.'&Estado='.$Estado.'&Mm='.$Mes[$i].'">'.$Mes[$i].'</option>';
										}else{
											echo '	<option 											value="CalculoHonorarios.php?Proyecto='.$Proyecto.'&MesHon='.$Mes[$i].'&Agno='.$Agno.'&Estado='.$Estado.'&Mm='.$Mes[$i].'">'.$Mes[$i].'</option>';
										}
									}
								}
							?>
						</select>

	  					<select name='Agno' id='Agno' onChange='window.location = this.options[this.selectedIndex].value; return true;'>
							<?php
							for($i=2014; $i<=$fd[0]; $i++){
								if($i==$Agno){
									echo '<option selected	value="CalculoHonorarios.php?Proyecto='.$Proyecto.'&Mm='.$MesHon.'&MesHon='.$MesHon.'&Agno='.$i.'&Estado=" >'.$i.'</option>';
								}else{								
									echo '<option 			value="CalculoHonorarios.php?Proyecto='.$Proyecto.'&Mm='.$MesHon.'&MesHon='.$MesHon.'&Agno='.$i.'&Estado=" >'.$i.'</option>';
								}
							}			 
							?>
						</select>
					<!-- Fin Filtro -->

					<!-- Fitra por Fecha -->
	  					<select name='Estado' id='Estado' onChange='window.location = this.options[this.selectedIndex].value; return true;'>
							<?php
							if($Estado=='P'){
								echo '<option  			value="CalculoHonorarios.php?Proyecto='.$Proyecto.'&Mm='.$MesHon.'&MesHon='.$MesHon.'&Agno='.$Agno.'&Estado=" >Sin Firmar</option>';
								echo '<option selected  value="CalculoHonorarios.php?Proyecto='.$Proyecto.'&Mm='.$MesHon.'&MesHon='.$MesHon.'&Agno='.$Agno.'&Estado=P">Informados</option>';
							}else{
								echo '<option selected	value="CalculoHonorarios.php?Proyecto='.$Proyecto.'&Mm='.$MesHon.'&MesHon='.$MesHon.'&Agno='.$Agno.'&Estado=" >Sin Firmar</option>';
								echo '<option   		value="CalculoHonorarios.php?Proyecto='.$Proyecto.'&Mm='.$MesHon.'&MesHon='.$MesHon.'&Agno='.$Agno.'&Estado=P">Informados</option>';
							}
							?>
						</select>
					<div id="ImagenBarra" style="float:none; display:inline;">
						<?php 
            				echo '<input style="display:inline; float:none;"  name="Imprimir" type="image" id="Imprimir" src="../gastos/imagenes/printer_128_hot.png" width="20" height="20" title="Imprimir Formulario Honorarios">';
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
				echo '			<td  width="05%" align="center"><strong>N° 	 			</strong></td>';
				echo '			<td  width="05%" align="center"><strong>Boleta			</strong></td>';
				echo '			<td  width="09%" align="center"><strong>Contrato		</strong></td>';
				echo '			<td  width="10%" align="center"><strong>RUT				</strong></td>';
				echo '			<td  width="12%" align="center"><strong>Nombres			</strong></td>';
				echo '			<td  width="04%" align="center"><strong>Costo			</strong></td>';

				echo '			<td  width="07%" align="center"><strong>Desde			</strong></td>';
				echo '			<td  width="07%" align="center"><strong>Hasta			</strong></td>';

				echo '			<td  width="08%" align="center"><strong>Bruto			</strong></td>';
				echo '			<td colspan="6"  width="30%" align="center"><strong>Mes.'.$PeriodoPago.'</strong></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaListado">';
				$n = 0;
				$tTot = 0;
				$tRet = 0;
				$tLiq = 0;
				$link=Conectarse();
				//$bdHon=$link->query("SELECT * FROM Honorarios Where IdProyecto = '".$Proyecto."' && Cancelado <> 'on' && PeriodoPago ='".$PeriodoPago."' Order By Run");
				$bdHon=$link->query("SELECT * FROM Honorarios Where IdProyecto = '".$Proyecto."' and PeriodoPago ='".$PeriodoPago."' Order By Run");
				if($row=mysqli_fetch_array($bdHon)){
					do{
						if($row['fechaCancelacion'] != '0000-00-00'){
							$fd = explode('-', $row['fechaCancelacion']);
						}else{
							$fd = explode('-', $row['FechaPago']);
						}
						if($fd[1] == 0){
							$fd[1] = substr($PeriodoPago,0,2);
						}
						$fh = explode('.', $row['PeriodoPago']);
						if($Mes[intval($fh[0])]==$MesHon){
							$n++;
							$tTot += $row['Total'];
							$tRet += $row['Retencion'];
							$tLiq += $row['Liquido'];
							$tr = 'barraBlanca';
							if($row['Estado'] == 'P'){
								$tr='barraVerde';
							}
							if($row['Cancelado'] == 'on'){
								$tr='barraVerdeTransparente';
							}
							
							echo '<tr id="'.$tr.'">';
							echo '			<td width="05%">'.$n.'</td>';
							echo '			<td width="05%">';
							echo 				$row['nBoleta'];
							echo '			</td>';
							echo '			<td width="10%">';
												$fd = explode('-', $row['FechaPago']);
												if($fd[1]>0){
													echo $fd[2].'-'.$fd[1].'-'.$fd[0];
												}else{
													echo 'Pendiente';
												}
							echo '			</td>';
							echo '			<td width="10%">'.$row['Run'].'</td>';
							echo '			<td width="12%">';
											$bdPer=$link->query("SELECT * FROM PersonalHonorarios Where Run = '".$row['Run']."'");
											if ($rowP=mysqli_fetch_array($bdPer)){
												echo $rowP['Paterno'].' '.$rowP['Materno'].' '.$rowP['Nombres'];
											}
							echo '			</td>';
							echo '			<td width="04%" align="right">';
												if($row['TpCosto']=="E"){ echo 'Esp.'; }
												if($row['TpCosto']=="M"){ echo 'Men.'; }
												if($row['TpCosto']=="I"){ echo 'Inv.'; }
							echo ' 			</td>';

							echo '			<td width="07%" align="right">';
												$fd = explode('-', $row['PerIniServ']);
							echo 				$fd[2].'-'.$fd[1];
							echo ' 			</td>';
							echo '			<td width="07%" align="right">';
												$fd = explode('-', $row['PerTerServ']);
							echo 				$fd[2].'-'.$fd[1];
							echo ' 			</td>';

							echo '			<td width="08%" align="right">';
							echo 				number_format($row['Total'], 0, ',', '.');
							echo ' 			</td>';
							echo '			<td width="05%"><a href="seguimientoHonorarios.php?Run='.$row['Run'].'&nBoleta='.$row['nBoleta'].'&Periodo='.$PeriodoPago.'"><img src="../gastos/imagenes/klipper.png"   			width="32" height="32" title="Seguimiento">						</a></td>';
	    					echo '			<td width="05%"><a href="cHonorarios.php?Proceso=2&Run='.$row['Run'].'&nBoleta='.$row['nBoleta'].'&Periodo='.$PeriodoPago.'"><img src="../gastos/imagenes/corel_draw_128.png"   	width="32" height="32" title="Editar Boleta Honorario">			</a></td>';
	    					echo '			<td width="05%"><a href="cHonorarios.php?Proceso=3&Run='.$row['Run'].'&nBoleta='.$row['nBoleta'].'&Periodo='.$PeriodoPago.'"><img src="../gastos/imagenes/delete_32.png" 			width="32" height="32" title="Eliminar Boleta de Honorarios">	</a></td>';
	    					echo '			<td width="05%"><a href="formularios/contratoNew.php?Run='.$row['Run'].'&nBoleta='.$row['nBoleta'].'&Periodo='.$PeriodoPago.'"><img src="../gastos/imagenes/pdf.png" 					width="32" height="32" title="Imprimir Contrato">				</a></td>';
	    					echo '			<td width="05%"><a href="formularios/informeAct.php?Run='.$row['Run'].'&nBoleta='.$row['nBoleta'].'&Periodo='.$PeriodoPago.'"><img src="../imagenes/newPdf.png" 					width="32" height="32" title="Imprimir Informe de Actividades">				</a></td>';
	    					echo '			<td width="05%"><a href="formPagoHonorarios.php?Run='.$row['Run'].'&nBoleta='.$row['nBoleta'].'&Periodo='.$PeriodoPago.'"><img src="../imagenes/printer_128_hot.png" 					width="32" height="32" title="Imprimir Formulario de Honorarios">				</a></td>';
	    					echo '			<td width="05%"><input name="Reg[]" type="checkbox" value="'.$row['Run'].','.$row['nBoleta'].','.$Proyecto.','.$PeriodoPago.'" title="Seleccionar"></td>';
							echo '		</tr>';
						}else{
							$n++;
							$tTot += $row['Total'];
							$tRet += $row['Retencion'];
							$tLiq += $row['Liquido'];
							$tr = 'barraBlanca';
							if($row['Estado'] == 'P'){
								$tr='barraVerde';
							}
							echo '<tr id="'.$tr.'">';
							echo '			<td width="05%">'.$n.'</td>';
							echo '			<td width="05%">'.$row['nBoleta'].'</td>';
							echo '			<td width="10%">';
												$fd = explode('-', $row['FechaPago']);
												if($fd[1]>0){
													echo $fd[2].'-'.$fd[1].'-'.$fd[0];
												}else{
													echo 'Pendiente';
												}
							echo '			</td>';
							echo '			<td width="10%">'.$row['Run'].'</td>';
							echo '			<td width="12%">';
											$bdPer=$link->query("SELECT * FROM PersonalHonorarios Where Run = '".$row['Run']."'");
											if ($rowP=mysqli_fetch_array($bdPer)){
												echo $rowP['Paterno'].' '.$rowP['Materno'].' '.$rowP['Nombres'];
											}
							echo '			</td>';
							echo '			<td width="04%" align="right">';
												if($row['TpCosto']=="E"){ echo 'Esp.'; }
												if($row['TpCosto']=="M"){ echo 'Men.'; }
												if($row['TpCosto']=="I"){ echo 'Inv.'; }
							echo ' 			</td>';

							echo '			<td width="07%" align="right">';
												$fd = explode('-', $row['PerIniServ']);
							echo 				$fd[2].'-'.$fd[1];
							echo ' 			</td>';
							echo '			<td width="07%" align="right">';
												$fd = explode('-', $row['PerTerServ']);
							echo 				$fd[2].'-'.$fd[1];
							echo ' 			</td>';

							echo '			<td width="08%" align="right">';
							echo 				number_format($row['Total'], 0, ',', '.');
							echo ' 			</td>';
							echo '			<td width="05%"><a href="seguimientoHonorarios.php?Run='.$row['Run'].'&nBoleta='.$row['nBoleta'].'&Periodo='.$PeriodoPago.'"><img src="../gastos/imagenes/klipper.png"   			width="32" height="32" title="Seguimiento">						</a></td>';
	    					echo '			<td width="05%"><a href="cHonorarios.php?Proceso=2&Run='.$row['Run'].'&nBoleta='.$row['nBoleta'].'&Periodo='.$PeriodoPago.'"><img src="../gastos/imagenes/corel_draw_128.png"   	width="32" height="32" title="Editar Boleta Honorario">	</a></td>';
	    					echo '			<td width="05%"><a href="cHonorarios.php?Proceso=3&Run='.$row['Run'].'&nBoleta='.$row['nBoleta'].'&Periodo='.$PeriodoPago.'"><img src="../gastos/imagenes/delete_32.png" 			width="32" height="32" title="Eliminar Boleta de Honorarios">				</a></td>';
	    					echo '			<td width="05%"><a href="formularios/contratoNew.php?Run='.$row['Run'].'&nBoleta='.$row['nBoleta'].'&Periodo='.$PeriodoPago.'"><img src="../gastos/imagenes/pdf.png" 					width="32" height="32" title="Imprimir Contrato">				</a></td>';?>
								
								<td width="05%">
									<?php
										if($row['actRealizada']){?>
											<a href="formularios/informeAct.php?Run=<?php echo $row['Run']; ?>&Periodo=<?php echo $PeriodoPago; ?>">
												<img src="../imagenes/newPdf.png" width="32" height="32" title="Imprimir Informe de Actividades">
											</a>
										<?php
										}
										?>
								</td>
								
								<?php
	    					echo '			<td width="05%"><input name="Reg[]" type="checkbox" value="'.$row['Run'].','.$row['nBoleta'].','.$Proyecto.','.$PeriodoPago.'" title="Seleccionar"></td>';
							echo '		</tr>';
						}
					}WHILE ($row=mysqli_fetch_array($bdHon));
				}
				$link->close();
				echo '	</table>';
				if($tTot){
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaFinal">';
				echo '		<tr>';
    			echo '			<td width="05%">&nbsp;</td>';
    			echo '			<td width="05%">&nbsp;</td>';
    			echo '			<td width="10%">&nbsp;</td>';
    			echo '			<td width="13%">&nbsp;</td>';
    			echo '			<td width="05%">&nbsp;</td>';
    			echo '			<td width="08%">&nbsp;</td>';
				echo '			<td width="08%" align="right">Total</td>';
				echo '			<td width="11%" align="right">'.number_format($tTot , 0, ',', '.').'			</td>';
    			echo '			<td width="05%">&nbsp;</td>';
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
