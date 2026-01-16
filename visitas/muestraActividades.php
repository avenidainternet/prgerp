<?php
	session_start(); 
	header('Content-Type: text/html; charset=iso-8859-1');

	include_once("conexion.php");
	date_default_timezone_set("America/Santiago");

	if(isset($_GET['usrRes']))	{ $usrRes	= $_GET['usrRes'];		}
	if(isset($_GET['tpAccion'])){ $tpAccion	= $_GET['tpAccion'];	}
	
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
				echo '			<td  width="11%" align="center" height="40">Fecha<br>Visita			</td>';
				echo '			<td  width="27%">							Clientes				</td>';
				echo '			<td  width="27%">							Objetivo Visita			</td>';
				echo '			<td  width="07%" align="center">			Responsable<br>Visita	</td>';
				echo '			<td  width="18%" align="center">Acciones							</td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListadoCAM">';
				$n 		= 0;

				$link=Conectarse();
				if($tpAccion == 'Seguimiento'){
					if($usrRes){
						$sql = "SELECT * FROM Visitas Where usrResponsable = '".$usrRes."' Order By fechaRegAct Desc";
					}
				}else{
					$sql = "SELECT * FROM Visitas Order By fechaRegAct Desc";
				}
				$i = 0;
				$bdEnc=mysql_query($sql);
				if($row=mysql_fetch_array($bdEnc)){
					do{
/*					
						$i++;
						$act = $row['Actividad'];
						$actSQL="UPDATE Visitas SET ";
						$actSQL.="idVisita			='".$i."'";
						$actSQL.="WHERE Actividad 	= '".$act."'";
						$bdProd=mysql_query($actSQL);
*/
						$tr = "bVerde";
						$fechaHoy = date('Y-m-d');
						$fechaxVencer 	= strtotime ( '-'.$row['tpoAvisoAct'].' day' , strtotime ( $row['fechaProxAct'] ) );
						$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );

						if($row['RutCli'] == ''){
							$tr = "bAmarilla";
						}
						if($row['fechaRegAct'] == '0000-00-00'){
							$tr = "bRoja";
						}						
						if($row['Impresa'] == 'on'){
							$tr = "bAzul";
						}
						echo '<tr id="'.$tr.'">';
						echo '	<td width="03%" align="center">';
									echo '&nbsp;';
						echo '	</td>';
						echo '	<td width="11%" style="font-size:12px;" align="center">';
						echo		'<strong style="font-size:25; font-weight:700">';
									$fd = explode('-', $row['fechaRegAct']);
									echo	$fd[2].'/'.$fd[1].'/'.$fd[0];
						//echo			$row['idVisita'];
						echo 		'</strong>';
						echo '	</td>';
						echo '	<td width="27%" style="font-size:12px;">';
									$bdCl=mysql_query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
									if($rowCl=mysql_fetch_array($bdCl)){
										echo $rowCl['Cliente'];
									}
						echo '	</td>';
						echo '	<td width="27%" style="font-size:12px;">';
									echo $row['Actividad'];
						echo '	</td>';
						echo '	<td width="07%" style="font-size:12px;">';
									echo $row['usrResponsable'];
						echo ' 	</td>';
						echo '	<td width="06%" align="center"><a href="formularios/registroVisitas.php?idVisita='.$row['idVisita'].'&accion=Imprimir"	><img src="../imagenes/informes.png" 				width="40" height="40" title="Imprimir Reistro de Visitas">	</a></td>';
						echo '	<td width="06%" align="center"><a href="plataformaActividades.php?idVisita='.$row['idVisita'].'&accion=Actualizar"><img src="../gastos/imagenes/corel_draw_128.png" 	width="40" height="40" title="Editar Registro de Visitas">	</a></td>';
						echo '	<td width="06%" align="center"><a href="plataformaActividades.php?idVisita='.$row['idVisita'].'&accion=Borrar"	><img src="../gastos/imagenes/del_128.png"   		width="40" height="40" title="Borrar Registro de Visitas">	</a></td>';
						echo '</tr>';
					}while ($row=mysql_fetch_array($bdEnc));
				}
				mysql_close($link);
				echo '	</table>';
			}
			?>

