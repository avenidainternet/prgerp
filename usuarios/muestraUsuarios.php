<?php
	header('Content-Type: text/html; charset=utf-8');
	session_start(); 
	include_once("../conexionli.php");
	date_default_timezone_set("America/Santiago");

	if(isset($_GET['dBuscar'])) { $dBuscar  = $_GET['dBuscar']; 	}
	
				echo '<div>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td  width="20%" align="center" height="40"><strong>Usuario			</strong></td>';
				echo '			<td  width="40%">							<strong>Nombre Usuario	</strong></td>';
				echo '			<td  width="20%">							<strong>Perfil 			</strong></td>';
				echo '			<td  width="20%" align="center" colspan="6"><strong>Acciones		</strong></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListado">';
				$n 		= 0;
				$link=Conectarse();

				if($dBuscar){
					$bdEnc=$link->query("SELECT * FROM Usuarios Where (nPerfil != 'WM') and (usr Like '%".$dBuscar."%' or usuario Like '%".$dBuscar."%') Order By nPerfil");
				}else{
					//$bdEnc=$link->query("SELECT * FROM Usuarios Where usr != $login Order By nPerfil");
					$bdEnc=$link->query("SELECT * FROM Usuarios Where nPerfil != 'WM' Order By nPerfil");
				}
				if ($row=mysqli_fetch_array($bdEnc)){
					do{
						$tr = "barraVerde";
						if($row['nPerfil']==0){
							$tr = "barraAdms";
						}
						if($row['nPerfil']==9){
							$tr = "barraAmarilla";
						}
						echo '<tr id="'.$tr.'">';
						echo '	<td width="20%" style="font-size:20px; padding:15px;">';
						echo		$row['usr'];
						echo '	</td>';
						echo '	<td width="40%" style="font-size:20px;">';
									$nPerfil = $row['nPerfil'];
						echo		$row['usuario'];
						echo '	</td>';
						echo '	<td width="20%" style="font-size:20px;">';
									$bdPer=$link->query("SELECT * FROM Perfiles Where IdPerfil = '".$nPerfil."'");
									if ($rowPer=mysqli_fetch_array($bdPer)){
										echo $rowPer['Perfil'];
									}
						echo ' 	</td>';
						if($row['nPerfil'] == 0){
							echo '	<td width="05%" align="center">&nbsp;</td>';
							echo '	<td width="05%" align="center">&nbsp;</td>';
						}else{
							echo '	<td width="05%" align="center"><a href="confTablasVis.php?Login='.$row['usr'].'&accion=Actualizar"			><img src="../imagenes/Tablas.png" 					width="40" height="40" title="Visualización de Tablas">	</a></td>';
							echo '	<td width="05%" align="center"><a href="asignaModulos.php?Login='.$row['usr'].'&accion=Actualizar"			><img src="../imagenes/soft.png" 					width="40" height="40" title="Asignar Módulos">			</a></td>';
						}
						echo '	<td width="05%" align="center"><a href="plataformaUsuarios.php?Login='.$row['usr'].'&accion=Actualizar"		><img src="../gastos/imagenes/corel_draw_128.png" 	width="40" height="40" title="Editar Usuario">			</a></td>';
						if($row['usr'] == $_SESSION['usr'] ){
							echo '	<td width="05%" align="center">&nbsp;</td>';
						}else{
							echo '	<td width="05%" align="center"><a href="plataformaUsuarios.php?Login='.$row['usr'].'&accion=Borrar"			><img src="../gastos/imagenes/del_128.png"   		width="40" height="40" title="Borrar Usuario">		</a></td>';
						}							
						echo '</tr>';
					}while ($row=mysqli_fetch_array($bdEnc));
				}
				$link->close();
				echo '	</table>';
				echo '</div>';
			?>
