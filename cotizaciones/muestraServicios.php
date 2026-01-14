<?php
	header('Content-Type: text/html; charset=utf-8');
	include_once("../conexionli.php");
	date_default_timezone_set("America/Santiago");

	if(isset($_GET['dBuscar'])) { $dBuscar  = $_GET['dBuscar']; 	}
	
				echo '<div>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td  width="10%" align="center" height="40"><strong>N°			</strong></td>';
				echo '			<td  width="63%">							<strong>Servicio	</strong></td>';
				echo '			<td  width="10%">							<strong>Valor UF 	</strong></td>';
				echo '			<td  width="17%" align="center" colspan="6"><strong>Acciones	</strong></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListado">';
				$n 		= 0;
				$link=Conectarse();
				
				if($dBuscar){
					$bdEnc=$link->query("SELECT * FROM Servicios Where Servicio Like '%".$dBuscar."%' Order By nServicio Asc");
				}else{
					$bdEnc=$link->query("SELECT * FROM Servicios Order By nServicio Asc");
				}
				if ($row=mysqli_fetch_array($bdEnc)){
					do{
						$tr = "barraVerde";
						if($row['tpServicio']=='E'){
							$tr = "barraAmarilla";
						}
						if($row['Estado'] == 'off'){
							$tr = "barraRoja";
						}

						echo '<tr id="'.$tr.'">';
						echo '	<td width="10%" style="font-size:20px;" align="center">';
						echo		$row['nServicio'];
						echo '	</td>';
						echo '	<td width="63%" style="font-size:20px;">';
						echo		$row['Servicio'];
						echo '	</td>';
						echo '	<td width="10%" style="font-size:20px;">';
									echo number_format($row['ValorUF'], 2, ',', '.').' UF';
						echo ' 	</td>';
						echo '	<td width="08%" align="center"><a href="Servicios.php?nServicio='.$row['nServicio'].'&accion=Actualizar"		><img src="../gastos/imagenes/corel_draw_128.png" 	width="40" height="40" title="Editar Servicio">		</a></td>';
						echo '	<td width="09%" align="center"><a href="Servicios.php?nServicio='.$row['nServicio'].'&accion=Borrar"			><img src="../gastos/imagenes/del_128.png"   		width="40" height="40" title="Borrar Servicio">		</a></td>';
						echo '</tr>';
					}while ($row=mysqli_fetch_array($bdEnc));
				}
				$link->close();
				echo '	</table>';
				echo '</div>';
			?>
