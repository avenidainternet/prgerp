<!-- 
****************************************************************************************************************
*
*             Registro de CAMs
*
*
****************************************************************************************************************

-->
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php
	$RutCli = '';
	if(isset($_GET['RutCli'])) { $RutCli = $_GET['RutCli']; }
	
	//header('Content-Type: text/html; charset=iso-8859-1');
	date_default_timezone_set("America/Santiago");
	echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloCAM">';
	echo '		<tr>';
	echo '			<td  width="10%" align="center" height="40">CAM 		</td>';
	echo '			<td  width="08%">							Fecha		</td>';
	echo '			<td  width="28%">							Clientes	</td>';
	echo '			<td  width="14%">							Total		</td>';
	echo '			<td  width="14%">							Validez		</td>';
	echo '			<td  width="08%">							Est. 		</td>';
	echo '			<td  width="18%" align="center" colspan="3">Acciones	</td>';
	echo '		</tr>';
	echo '	</table>';
	echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListadoCAM">';

	$n 		 = 0;
	$tCAMsUF = 0;
				
	$link=Conectarse();
	if($RutCli){
		//$bdEnc=$link->query("SELECT * FROM Cotizaciones Where Estado != 'C' and RutCli Like '".$RutCli."' Order By Estado Desc");
		$bdEnc=$link->query("SELECT * FROM Cotizaciones Where Estado != 'C' and fechaInicio = '0000-00-00' and RutCli Like '".$RutCli."' Order By Estado Desc");
	}else{
		//$bdEnc=$link->query("SELECT * FROM Cotizaciones Where Estado != 'C' Order By Estado Desc");
		$bdEnc=$link->query("SELECT * FROM Cotizaciones Where Estado != 'C' and fechaInicio = '0000-00-00' Order By Estado Desc");
	}
	if($row=mysqli_fetch_array($bdEnc)){
		do{
			$tCAMsUF += $row['NetoUF'];
			$fechaxVencer 	= strtotime ( '+'.$row['Validez'].' day' , strtotime ( $row['fechaCotizacion'] ) );
			$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
			$treinta = 30;
			$fechaaCerrar 	= strtotime ( '+'.$treinta.' day' , strtotime ( $row['fechaCotizacion'] ) );
			$fechaaCerrar 	= date ( 'Y-m-d' , $fechaaCerrar );
			$fd = explode('-', $fechaxVencer);
			$fechaHoy = date('Y-m-d');
			$start_ts = strtotime($fechaHoy); 
			$end_ts = strtotime($fechaxVencer); 
			$nDias = $end_ts - $start_ts;
			$nDias = round($nDias / 86400);
			$tDias = 3;
			$tr = "bBlanca";
			if($row['Estado']==' '){
				$tr = "bBlanca";
			}
			if($row['Estado']=='E'){ // Enviada
				$tr = "bAmarilla";
				if($nDias <= $tDias){ // En Proceso
					$tr = 'bRoja';
				}
				if($row['proxRecordatorio'] <= $fechaHoy){ // En Proceso
					$tr = 'bRoja';
				}
			}
			if($row['Estado'] == 'A'){ // Aceptada
				$tr = 'bVerde';
			}
			if($row['fechaAceptacion'] != '0000-00-00'){ // Aceptada
				$tr = 'bVerde';
			}
			if($row['RAM'] > 0){ // Aceptada
				$tr = 'bVerde';
			}
			echo '<tr id="'.$tr.'">';
			echo '	<td width="10%" style="font-size:12px;" align="center">';
						if($row['Rev']<10){
							$Revision = '0'.$row['Rev']; 
						}else{
							$Revision = $row['Rev']; 
						}
						echo		'<strong style="font-size:14; font-weight:700">';
						echo		'C'.$row['CAM'];
						if($row['RAM']){
									echo '<br><span style="font-size:16; font-weight:700">R'.$row['RAM'].'</span>';
						}
						echo		'</strong>'.'<br> Rev.'.$Revision;
									if($row['Cta']){
										echo '<br>CC';
									}
			echo '	</td>';
			echo '	<td width="08%" style="font-size:12px;">';
						$fd = explode('-', $row['fechaCotizacion']);
						echo $fd[2].'/'.$fd[1];
						echo '<br>'.$row['usrCotizador'];
			echo '	</td>';
			echo '	<td width="28%" style="font-size:12px;">';
						$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
						if($rowCli=mysqli_fetch_array($bdCli)){
							echo $rowCli['Cliente'];
							//echo '<br>'.$filtroCli;
						}
			echo '	</td>';
			echo '	<td width="12%" style="font-size:12px;">';
						if($row['Moneda'] == 'P'){
							echo number_format($row['Bruto'], 0, ',', '.');
						}else{
							echo number_format($row['BrutoUF'], 2, ',', '.').' UF';
						}
			echo ' 	</td>';
			echo '	<td width="14%" style="font-size:12px;">';
						if($row['Validez'] == 0){
							echo 'Contado';
						}else{
							$fechaxVencer 	= strtotime ( '+'.$row['Validez'].' day' , strtotime ( $row['fechaCotizacion'] ) );
							$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
										
							$fd = explode('-', $fechaxVencer);
							echo $fd[2].'/'.$fd[1];
									
							$fechaHoy = date('Y-m-d');
							$start_ts 	= strtotime($fechaHoy); 
							$end_ts 	= strtotime($fechaxVencer); 
										
							$nDias = $end_ts - $start_ts;
							$nDias = round($nDias / 86400);
							echo '<br>';
							if($nDias <= $tDias){ // En Proceso
								echo '<div class="pVencer" title="Cotización por vencer">';
								echo 	$nDias;
								echo '</div';
							}else{
								echo '<div class="sVencer" title="Días por vencer">';
								echo 	$nDias;
								echo '</div';
							}
						}
			echo ' 	</td>';
/*
			echo '	<td width="26%" style="font-size:12px;">';
						echo $row[Descripcion];
			echo ' 	</td>';
*/

			echo '	<td width="08%">';
						if($row['enviadoCorreo'] == ''){ // Sin Enviar
							echo '<img src="../imagenes/noEnviado.png" 	width="32" height="32" title="Cotización NO Enviada"><br>';
						}
						if($row['enviadoCorreo'] == 'on'){ // Enviada
							if($row['proxRecordatorio'] <= $fechaHoy){ // En Proceso
								echo '<img src="../imagenes/alerta.gif" 	width="50" title="Contactar con Cliente">';
							}else{
								echo '<img src="../imagenes/enviarConsulta.png" 	width="32" height="32" title="Cotización Enviada">';
							}
							echo '<br>';
							$fd = explode('-', $row['fechaEnvio']);
							echo $fd[2].'-'.$fd[1];
						}
						if($row['Estado'] == 'A'){ // Aceptada
							echo '<img src="../imagenes/printing.png" 			width="32" height="32" title="Cotización Aceptada">';
							echo '<br>';
							$fd = explode('-', $row['fechaAceptacion']);
							echo $fd[2].'-'.$fd[1];
						}else{
						}
			echo ' 	</td>';
			if($row['Estado'] == 'E' or $row['Estado'] == 'A'){ // En Proceso
				echo '<td width="06%" align="center"><a href="../procesos/plataformaCotizaciones.php?CAM='.$row['CAM'].'&accion=Seguimiento"	><img src="../gastos/imagenes/klipper.png" 			width="40" height="40" title="Seguimiento">			</a></td>';
			}else{
				echo '<td width="06%" align="center"><img src="../gastos/imagenes/klipper.png" width="40" height="40" title="Seguimiento" style="opacity:0;"></td>';
			}
			echo '	<td width="06%" align="center"><a href="../procesos/modCotizacion.php?CAM='.$row['CAM'].'&Rev='.$Revision.'&Cta='.$row['Cta'].'&accion=Actualizar"	><img src="../gastos/imagenes/corel_draw_128.png" 	width="40" height="40" title="Editar Cotización">		</a></td>';
			echo '	<td width="06%" align="center"><a href="../procesos/modCotizacion.php?CAM='.$row['CAM'].'&Rev='.$Revision.'&Cta='.$row['Cta'].'&accion=Borrar"		><img src="../gastos/imagenes/del_128.png"   		width="40" height="40" title="Borrar Cotización">		</a></td>';

			echo '</tr>';
		}while ($row=mysqli_fetch_array($bdEnc));
	}
	$link->close();
				
echo '	</table>';
?>
