<?php
	header('Content-Type: text/html; charset=utf-8');
	session_start(); 
	include_once("../conexionli.php");
	date_default_timezone_set("America/Santiago");
	$dBuscar = '';
	
	$Login 	= $_GET['Login'];
	$accion = $_GET['accion'];
	
	if(isset($_GET['dBuscar'])) { $dBuscar  = $_GET['dBuscar']; 	}?>
	
	<table width="99%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td width="70%" valign="top"><?php mUsrs($Login); ?></td>
			<td width="30%" valign="top"><?php nMods($Login); ?></td>
		</tr>
	</table>
	<?php
	function nMods($Login){
		$dBuscar = '';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo" width="100%">';
				echo '		<tr>';
				echo '			<td height="45"><strong><img src="../imagenes/soft.png" width="40" align="middle">Módulos</strong></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListado" width="40%">';
				$n 		= 0;
				$link=Conectarse();

				if($dBuscar){
					$bdEnc=$link->query("SELECT * FROM Modulos Where Modulo Like '%".$dBuscar."%' Order By nModulo");
				}else{
					//$bdEnc=$link->query("SELECT * FROM Perfiles Where nPerfil != 'WM' Order By nPerfil");
					$bdEnc=$link->query("SELECT * FROM Modulos Order By nModulo");
				}
				if ($row=mysqli_fetch_array($bdEnc)){
					do{
						$bdLog=$link->query("SELECT * FROM ModUsr Where usr = '".$Login."' and nModulo = '".$row['nModulo']."'");
						if ($rowLog=mysqli_fetch_array($bdLog)){
						}else{
							$tr = "barraVerde";
							echo '<tr id="'.$tr.'">';
							echo '	<td width="10%" style="font-size:20px;">';
										echo $row['Modulo'];
							echo '	</td>';
							echo '	<td width="15%" align="center"><a href="asignaModulos.php?Login='.$Login.'&nModulo='.$row['nModulo'].'&accion=Asignar"		><img src="../imagenes/agregarMod.png" 	width="40" height="40" title="Asignar Módulo">		</a></td>';
							echo '</tr>';
						}
					}while ($row=mysqli_fetch_array($bdEnc));
				}
				$link->close();
				echo '	</table>';
		}
		?>

	<?php
	function mUsrs($Login){
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo" width="100%">';
				echo '		<tr>';
				echo '			<td height="45"><strong><img src="../imagenes/soft.png" width="40" align="middle">Módulos Asignados al Usuario '.$Login.'</strong></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListado" width="40%">';
				$n 		= 0;
				$link=Conectarse();

				$bdAs=$link->query("SELECT * FROM ModUsr Where usr = '".$Login."'");
				if ($rowAs=mysqli_fetch_array($bdAs)){
					do{
						$tr = "barraAmarilla";
						echo '<tr id="'.$tr.'">';
						echo '	<td width="10%" style="font-size:20px;">';
									$bdMod=$link->query("SELECT * FROM Modulos Where nModulo = '".$rowAs['nModulo']."'");
									if ($rowMod=mysqli_fetch_array($bdMod)){
										echo $rowMod['Modulo'];
										$nModulo = $rowAs['nModulo'];
									}
						echo '	</td>';
						echo '	<td width="15%" align="center"><a href="asignaModulos.php?Login='.$Login.'&nModulo='.$nModulo.'&accion=Quitar"><img src="../imagenes/quitarMod.png" 	width="40" height="50" title="Quitar Módulo">		</a></td>';
						echo '</tr>';
					}while ($rowAs=mysqli_fetch_array($bdAs));
				}
				$link->close();
				echo '	</table>';
		}
		?>
