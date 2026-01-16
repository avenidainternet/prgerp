<?php
	header('Content-Type: text/html; charset=utf-8');
	session_start(); 
	include_once("../conexionli.php");
	date_default_timezone_set("America/Santiago");

	if(isset($_GET['dBuscar'])) { $dBuscar  = $_GET['dBuscar']; 	}
	
				echo '<div>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo" width="40%">';
				echo '		<tr>';
				echo '			<td  width="10%" align="center" height="40"><strong>Prioridad		</strong></td>';
				echo '			<td  width="60%">							<strong>Perfil			</strong></td>';
				echo '			<td  width="30%" align="center" colspan="6"><strong>Acciones		</strong></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListado" width="40%">';
				$n 		= 0;
				$link=Conectarse();

				if($dBuscar){
					$bdEnc=$link->query("SELECT * FROM Perfiles Where (IdPerfil != 'WM') and (Perfil Like '%".$dBuscar."%') Order By nPerfil");
				}else{
					//$bdEnc=$link->query("SELECT * FROM Perfiles Where nPerfil != 'WM' Order By nPerfil");
					$bdEnc=$link->query("SELECT * FROM Perfiles Where IdPerfil != 'WM' Order By IdPerfil");
				}
				if ($row=mysqli_fetch_array($bdEnc)){
					do{
						$tr = "barraVerde";
						if($row['IdPerfil']==0){
							$tr = "barraAdms";
						}
						if($row['Perfil']=='Cliente' or $row['Perfil']=='Proveedor'){
							$tr = "barraAmarilla";
						}
						echo '<tr id="'.$tr.'">';
						echo '	<td width="10%" style="font-size:20px; padding:30px;">';
						echo		$row['IdPerfil'];
						echo '	</td>';
						echo '	<td width="60%" style="font-size:20px;">';
						echo		$row['Perfil'];
						echo '	</td>';
						echo '	<td width="15%" align="center"><a href="Perfiles.php?IdPerfil='.$row['IdPerfil'].'&accion=Actualizar"		><img src="../gastos/imagenes/corel_draw_128.png" 	width="40" height="40" title="Editar Usuario">		</a></td>';
						echo '	<td width="15%" align="center"><a href="Perfiles.php?IdPerfil='.$row['IdPerfil'].'&accion=Borrar"			><img src="../gastos/imagenes/del_128.png"   		width="40" height="40" title="Borrar Usuario">		</a></td>';
						echo '</tr>';
					}while ($row=mysqli_fetch_array($bdEnc));
				}
				$link->close();
				echo '	</table>';
				echo '</div>';
			?>
