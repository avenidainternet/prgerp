<?php
	header('Content-Type: text/html; charset=utf-8');
	session_start(); 
	include_once("../conexionli.php");
	date_default_timezone_set("America/Santiago");

	if(isset($_GET['dBuscar'])) { $dBuscar  = $_GET['dBuscar']; 	}
	
				echo '<div>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo" width="40%">';
				echo '		<tr>';
				echo '			<td  width="10%" align="center" height="20"><strong>N°				</strong></td>';
				echo '			<td  width="10%">							<strong>Módulos			</strong></td>';
				echo '			<td  width="40%">							<strong>Links / Enlaces	</strong></td>';
				echo '			<td  width="10%">							<strong>Icono			</strong></td>';
				echo '			<td  width="30%" align="center" colspan="6"><strong>Acciones		</strong></td>';
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
						$tr = "barraVerde";
						echo '<tr id="'.$tr.'">';
						echo '	<td width="10%" style="font-size:20px; padding:30px;">';
						echo		$row['nModulo'];
						echo '	</td>';
						echo '	<td width="10%" style="font-size:20px;">';
						echo		$row['Modulo'];
						echo '	</td>';
						echo '	<td width="40%" style="font-size:20px;">';
						echo		$row['dirProg'];
						echo '	</td>';
						echo '	<td width="10%" style="font-size:20px;">';
									if($row['iconoMod']){
										$mIcono = 'iconos/'.$row['iconoMod'];
										?>
										<img src="<?php echo $mIcono; ?>" width="42">
										<?php
									}
						echo '	</td>';
						echo '	<td width="15%" align="center"><a href="Modulos.php?nModulo='.$row['nModulo'].'&accion=Actualizar"		><img src="../gastos/imagenes/corel_draw_128.png" 	width="40" height="40" title="Editar Módulo">		</a></td>';
						echo '	<td width="15%" align="center"><a href="Modulos.php?nModulo='.$row['nModulo'].'&accion=Borrar"			><img src="../gastos/imagenes/del_128.png"   		width="40" height="40" title="Borrar Módulo">		</a></td>';
						echo '</tr>';
					}while ($row=mysqli_fetch_array($bdEnc));
				}
				$link->close();
				echo '	</table>';
				echo '</div>';
			?>
