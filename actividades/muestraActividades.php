<?php
	session_start(); 
	header('Content-Type: text/html; charset=utf-8');

	include_once("../conexionli.php");
	date_default_timezone_set("America/Santiago");

	if(isset($_GET['usrRes'])) 		{ $usrRes		= $_GET['usrRes'];		}
	if(isset($_GET['tpAccion'])) 	{ $tpAccion		= $_GET['tpAccion'];	}
	
	?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="45%" valign="top">
					<?php 
						informesActividades($usrRes, $tpAccion); 
					?>
				</td>
			</tr>
		</table>
		
		<?php
		function informesActividades($usrRes, $tpAccion){
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloCAM">';
				echo '		<tr>';
				echo '			<td  width="03%" align="center" height="40">&nbsp;					</td>';
				echo '			<td  width="10%" align="center" height="40">N°<br>Actividad			</td>';
				echo '			<td  width="23%">							Descripción Actividad	</td>';
				echo '			<td  width="08%">							Fecha<br>Prog.			</td>';
				echo '			<td  width="08%">							Fecha<br>Actividad		</td>';
				echo '			<td  width="23%">							Acreditación			</td>';
				echo '			<td  width="07%">							Responsable<br>Actividad</td>';
				echo '		<td  width="18%" align="center">Acciones								</td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListadoCAM">';
				$n 		= 0;

				$fechaHoy = date('Y-m-d');
				$link=Conectarse();
				if($tpAccion == 'Seguimiento'){
					if($usrRes){
						//$sql = "SELECT * FROM Actividades Where Estado != 'T' and usrResponsable = '".$usrRes."' Order By fechaProxAct";
						$sql = "SELECT * FROM Actividades Where usrResponsable = '".$usrRes."' Order By fechaProxAct";
					}
				}else{
					//$sql = "SELECT * FROM Actividades Where Estado != 'T' Order By fechaProxAct";
					//$sql = "SELECT * FROM Actividades Order By fechaProxAct";
					$sql = "SELECT * FROM Actividades Order By Estado, fechaAccionAct Desc";
				}
				$bdEnc=$link->query($sql);
				if($row=mysqli_fetch_array($bdEnc)){
					do{
						$tr = "bVerde";
						$fechaHoy = date('Y-m-d');
						
						$fechaxVencer 	= strtotime ( '-'.$row['tpoAvisoAct'].' day' , strtotime ( $row['fechaProxAct'] ) );
						$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );

						if($fechaHoy == $row['fechaProxAct']){
							$tr = "bAmarilla";
						}
						
						if($fechaHoy >= $fechaxVencer){
							$tr = "bAmarilla";
						}
						
						if($fechaHoy > $row['fechaProxAct']){
							$tr = "bRoja";
						}
						$Mostrar = 'Si';
						$fd = explode('-', $fechaHoy);
						
						if($row['Estado'] == 'T'){
							$tr = "bAzul";
							$fdAct = explode('-', $row['fechaAccionAct']);
							if($fdAct[0] < $fd[0]){
								$Mostrar = 'No';
							}
						}
						
						if($Mostrar == 'Si'){
							echo '<tr id="'.$tr.'">';
							echo '	<td width="03%" align="center">';
										echo '&nbsp;';
							echo '	</td>';
							echo '	<td width="10%" style="font-size:12px;" align="center">';
							echo		'<strong style="font-size:25; font-weight:700">';
							echo			$row['idActividad'];
							echo 		'</strong>';
							echo '	</td>';
							echo '	<td width="23%" style="font-size:12px;">';
										echo $row['Actividad'];
							echo '	</td>';
							echo '	<td width="08%" style="font-size:12px;">';
										$fd = explode('-', $row['prgActividad']);
										echo	$fd[2].'/'.$fd[1].'/'.$fd[0];
	/*
										if($fd[2] > 0){
											if($row[fechaProxCal] != '0000-00-00' and $fechaHoy > $row[fechaProxCal]){ 
												echo '<span class="atrazoEquipo">';
												echo	$fd[2].'/'.$fd[1].'/'.$fd[0];
												echo '</span>';
											}else{
												echo $fd[2].'/'.$fd[1].'/'.$fd[0];
											}
										}
	*/									
							echo ' 	</td>';
							echo '	<td width="08%" style="font-size:12px;">';
										$fd = explode('-', $row['fechaProxAct']);
										echo	$fd[2].'/'.$fd[1].'/'.$fd[0];
							echo ' 	</td>';
							echo '	<td width="23%" style="font-size:12px;">';
										if($row['Acreditado'] == 'on'){
											echo 'SI';
										}
										//echo $row[Comentarios];
							echo ' 	</td>';
							echo '	<td width="07%" style="font-size:12px;">';
										echo $row['usrResponsable'];
							echo ' 	</td>';
							if($tpAccion == 'Seguimiento'){
								echo '	<td width="09%" align="center"><a href="plataformaActividades.php?idActividad='.$row['idActividad'].'&accion=Seguimiento&tpAccion='.$tpAccion.'">	<img src="../imagenes/klipper.png" 			width="40" height="40" title="Seguimiento">			</a></td>';
								echo '	<td width="09%" align="center"><a href="plataformaActividades.php?idActividad='.$row['idActividad'].'&accion=Imprimir"								><img src="../imagenes/informes.png" 		width="40" height="40" title="Imprimir Actividad">	</a></td>';
							}else{
								if($row['fechaProxAct'] != '0000-00-00' or $row['fechaProxAct'] != '0000-00-00'){
									echo '	<td width="04%" align="center"><a href="plataformaActividades.php?idActividad='.$row['idActividad'].'&accion=Seguimiento"><img src="../imagenes/klipper.png" 								width="40" height="40" title="Seguimiento">						</a></td>';
								}else{
									echo '	<td width="04%" align="center">&nbsp;</td>';
								}
								echo '	<td width="04%" align="center"><a href="plataformaActividades.php?idActividad='.$row['idActividad'].'&accion=Imprimir"	><img src="../imagenes/informes.png" 									width="40" height="40" title="Imprimir Actividad">	</a></td>';
								echo '	<td width="04%" align="center"><a href="plataformaActividades.php?idActividad='.$row['idActividad'].'&accion=Actualizar"><img src="../gastos/imagenes/corel_draw_128.png" 						width="40" height="40" title="Editar Actividad">	</a></td>';
								echo '	<td width="04%" align="center"><a href="plataformaActividades.php?idActividad='.$row['idActividad'].'&accion=Borrar"	><img src="../gastos/imagenes/del_128.png"   							width="40" height="40" title="Borrar Actividad">	</a></td>';
							}
							echo '</tr>';
						}
					}while ($row=mysqli_fetch_array($bdEnc));
				}
				$link->close();
				echo '	</table>';
			}
			?>

