<?php

	session_start(); 
	$RutCli = '';
	include_once("conexion.php");
	if(isset($_GET['RutCli'])) { $RutCli = $_GET['RutCli']; }
	date_default_timezone_set("America/Santiago");?>
	<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloTv">
		<tr>
			<td  width="10%" align="center" height="40">RAM			 	</td>
			<td  width="10%">							Fecha		 	</td>
			<td  width="20%">							Cliente 	 	</td>
			<td  width="10%">							Días	 	 	</td>
			<td  width="40%">							Observaciones	</td>
			<td  width="10%">&nbsp;										</td>
		</tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="0" id="CajaListadoTv">
		<tr>
			<td>
				<?php
					$n 		= 0;
					$link=Conectarse();
					$bdEnc=mysql_query("SELECT * FROM registroMuestras Where situacionMuestra != 'B' Order By RAM Desc");
					//$bdEnc=mysql_query("SELECT registroMuestras.fechaRegistro FROM registroMuestras, cotizaciones");
					if($row=mysql_fetch_array($bdEnc)){
						do{
							$n++;
							echo $row['RAM'].'<br>';
/*							
							$fr = $row['fechaRegistro'];

							$fechaHoy = date('Y-m-d');
							$start_ts 	= strtotime($row['fechaRegistro']); 
							$end_ts 	= strtotime($fechaHoy); 
											
							$tDias = 1;
							$nDias = $end_ts - $start_ts;

							$nDias = round($nDias / 86400)+1;

							$tr = "bBlanca";
							if($row['situacionMuestra'] == 'R'){ // Recepcionada
								$tr = 'bRoja';
							}
							if($row['situacionMuestra'] == 'P'){ // En Proceso o Asignada
								$tr = "bVerde";
							}
							if($row['situacionMuestra'] == 'B'){ // Dado de Baja
								$tr = "bAzul";
							}
							$muestraRAM = 'Si';
								if($row['Estado'] == 'E'){
									$tr = "bVerde";
								}
								if($row['Estado'] == 'T' or $row['Estado'] == 'C'){
									$muestraRAM = "No";
								}
							
							if($row['Fan'] > 0){
								$muestraRAM = "No";
							}
								
							if($muestraRAM == 'Si'){
								echo '<tr id="'.$tr.'">';
								echo '	<td width="10%">';
										if($row['Fan'] > 0){
											echo '<span style="float:rigth;">Clon '.$row['RAM'].'-'.$row['Fan'].'</span>';
										}else{
											echo 'R'.$row['RAM'];
										}
										if($row['CAM']>0){
											echo '<br>';
											echo 'C'.$row['CAM'];
										}
								echo '	</td>';
								echo '	<td width="10%">';
											if($row['fechaRegistro'] != 0){
												$fd = explode('-', $row['fechaRegistro']);
												echo $fd[2].'/'.$fd[1];
												echo '<br>'.$row['usrRecepcion'];
											}
								echo '	</td>';
								echo '	<td width="20%">';
											$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
											if($rowCli=mysql_fetch_array($bdCli)){
												echo 	'<span style="font-size:10px;">'.substr($rowCli['Cliente'],0,20).'</span>';
											}
								echo '	</td>';
		
								echo '	<td width="10%">';
											if($row['situacionMuestra']=='R'){
												echo $nDias;
											}
								echo ' 	</td>';
		
								echo '	<td width="40%">';
											if($row['CAM']>0){
												$bdCot=mysql_query("SELECT * FROM Cotizaciones Where CAM = '".$row['CAM']."'");
												if($rowCot=mysql_fetch_array($bdCot)){
													if($rowCot['Descripcion']){
														echo $rowCot['Descripcion'];
													}else{
														echo substr($row['Descripcion'],0,100).'...';
													}
												}
											}else{
												if($row['Descripcion']){
													echo substr($row['Descripcion'],0,100).'...';
												}
											}
								echo ' 	</td>';
								$bdMue=mysql_query("SELECT * FROM Cotizaciones Where RutCli = '".$row['RutCli']."' and Estado = 'E'");
								if($_SESSION['IdPerfil'] != 4){
									if($rowMue=mysql_fetch_array($bdMue)){
										echo '	<td width="05%" align="center"><a href="recepcionMuestras.php?RutCli='.$row['RutCli'].'&accion=Filtrar"><img src="../gastos/imagenes/other_48.png" 	width="32"  title="Filtrar CAM">		</a></td>';
									}else{
										echo '	<td width="05%" align="center"><a href="../cotizaciones/plataformaCotizaciones.php?CAM=0&RutCli='.$row['RutCli'].'&accion=Filtrar"><img src="../imagenes/cotizacion.png" 	width="40"  title="Crear Cotización">	</a></td>';
									}
								}
								echo '	<td width="05%" align="center">';
									if($row['Fan']==0){ 
										echo'<a href="regMuestras.php?RAM='.$row['RAM'].'&accion=Editar"><img src="../gastos/imagenes/corel_draw_128.png" 	width="32"  title="Editar Muestra">	</a>';
									}
								echo ' </td>';
								echo '	<td width="05%" align="center">';
									if($row['Fan']==0){ 
										echo '<a href="regMuestras.php?RAM='.$row['RAM'].'&accion=Borrar"><img src="../gastos/imagenes/del_128.png"   			width="32"  title="Dar de Baja">	</a>';
									}
								echo ' </td>';
								echo '</tr>';
							}
*/							
						}while ($row=mysql_fetch_array($bdEnc));
					}


					
					mysql_close($link);
				?>
			</td>
		</tr>
	</table>
<?php
/*				
				if($RutCli){
					//$bdEnc=mysql_query("SELECT * FROM registroMuestras Where RutCli Like '%".$RutCli."%' and situacionMuestra != 'B' and situacionMuestra != 'P' Order By RAM Desc");
					$bdEnc=mysql_query("SELECT * FROM registroMuestras Where RutCli Like '%".$RutCli."%' and situacionMuestra != 'B' Order By RAM Desc");
				}else{
					//$bdEnc=mysql_query("SELECT * FROM registroMuestras Where situacionMuestra != 'B' and situacionMuestra != 'P' Order By RAM Desc");
					$bdEnc=mysql_query("SELECT * FROM registroMuestras Where situacionMuestra != 'B' Order By RAM Desc");
				}
*/				
?>
