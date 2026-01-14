	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php
	include_once("conexion.php");

	if(isset($_GET['dBuscar'])) { $dBuscar  = $_GET['dBuscar']; 	}
	
				echo '<div>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td  width="05%" align="center" height="40"><strong>N°										</strong></td>';
				echo '			<td  width="38%">							<strong>Nombre Encuestas						</strong></td>';
				echo '			<td  width="10%">							<strong>Respuestas								</strong></td>';
				echo '			<td  width="10%">							<strong>Estado 									</strong></td>';
				echo '			<td  width="37%" align="center" colspan="6"><strong>Acciones								</strong></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListado">';
				$n 		= 0;
				$link=Conectarse();
				
				if($dBuscar){
					$bdEnc=mysql_query("SELECT * FROM Encuestas Where nomEnc Like '%".$dBuscar."%' Order By nEnc");
				}else{
					$bdEnc=mysql_query("SELECT * FROM Encuestas Order By nEnc");
				}
				if ($row=mysql_fetch_array($bdEnc)){
					do{
						$tr = "barraAmarilla";
						if($row['Estado']=='on'){
							$tr = 'barraVerde';
						}
						echo '<tr id="'.$tr.'">';
						echo '	<td width="05%" style="font-size:16px;">';
						echo		$row['nEnc'];
						echo '	</td>';
						echo '	<td width="38%">'.$row['nomEnc'].'</td>';
						echo '	<td width="10%" align="center">';
									echo '<strong style="font-size:25px;">'.number_format($row['nResp'], 0, ',', '.').'</strong>';
						echo ' 	</td>';
						echo '	<td width="10%">';
							if($row['Estado'] == 'on'){
								echo '<img src="../imagenes/Confirmation_32.png" 	width="32" height="32" title="Encuesta Activa">';
							}else{
								echo '<img src="../imagenes/no_32.png" 				width="32" height="32" title="Encuesta Inactiva">';
							}
						echo ' 	</td>';
						echo '		<td width="06%"><a href="enviarEncuesta.php?nEnc='.$row['nEnc'].'"								><img src="../imagenes/enviarConsulta.png" 			width="50" height="50" title="Enviar Encuestas">		</a></td>';
						echo '		<td width="07%"><a href="verEncuesta.php?nEnc='.$row['nEnc'].'&RutCli=0000000-0" target="_blank"	><img src="../imagenes/Preguntas.png" 				width="50" height="50" title="Vista Previa">			</a></td>';
						echo '		<td width="06%"><a href="datosEncuesta.php?nEnc='.$row['nEnc'].'"									><img src="../imagenes/indicadores.png" 			width="50" height="50" title="Ver Respuestas">			</a></td>';
						echo '		<td width="06%"><a href="ItemsEncuesta.php?nEnc='.$row['nEnc'].'&accion="							><img src="../imagenes/subjects_bystudent.png" 		width="40" height="40" title="Items de Consultas">		</a></td>';
						echo '		<td width="06%"><a href="plataformaEncuesta.php?nEnc='.$row['nEnc'].'&accion=Actualizar"			><img src="../gastos/imagenes/corel_draw_128.png" 	width="40" height="40" title="Editar Encuesta">			</a></td>';
						echo '		<td width="06%"><a href="plataformaEncuesta.php?nEnc='.$row['nEnc'].'&accion=Borrar"				><img src="../gastos/imagenes/del_128.png"   		width="40" height="40" title="Borrar Encuesta">			</a></td>';
						echo '</tr>';
					}while ($row=mysql_fetch_array($bdEnc));
				}
				mysql_close($link);
				echo '	</table>';
				echo '</div>';
			?>
