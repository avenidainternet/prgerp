<?php
	session_start(); 
	header('Content-Type: text/html; charset=iso-8859-1');
	include_once("conexion.php");
	date_default_timezone_set("America/Santiago");
		$link=Conectarse();
		$bdCli=mysql_query("SELECT * FROM SolFactura Where valorUF > 0 Order By valorUF Desc");
		if($rowCli=mysql_fetch_array($bdCli)){
			$ultUF = $rowCli[valorUF];
		}
		mysql_close($link);

	if(isset($_GET['usrFiltro'])) { $usrFiltro  = $_GET['usrFiltro']; 	}
	if(isset($_SESSION[empFiltro])) { 
		//$empFiltro  = $_GET['empFiltro']; 	
		$empFiltro = $_SESSION[empFiltro];
		$link=Conectarse();
		$bdCli=mysql_query("SELECT * FROM Clientes Where Cliente Like '%".$empFiltro."%'");
		if($rowCli=mysql_fetch_array($bdCli)){
			$filtroCli = $rowCli[RutCli];
		}
		mysql_close($link);
	}else{
		$filtroCli = '';
	}

	$usrFiltro = $_SESSION[usrFiltro];
	
	
	?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="45%" valign="top">
					<?php mRAMs($usrFiltro, $filtroCli); ?>
				</td>
				<td width="45%" valign="top">
					<?php mCAMs($usrFiltro, $filtroCli); ?>
				</td>
			</tr>
		</table>
		
		<?php
		function mRAMs($usrFiltro, $filtroCli){
				global $filtroRAM;
				$filtro = '';
				if($usrFiltro){
					$filtro = " and usrCotizador Like '%".$usrFiltro."%'";
				}
				if($filtroCli){
					$filtro = " and RutCli Like '%".$filtroCli."%'";
				}
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloCAM">';
				echo '		<tr>';
				echo '			<td  width="10%" align="center" height="40">RAM 		</td>';
				echo '			<td  width="08%">							Fecha		</td>';
				echo '			<td  width="28%">							Clientes	</td>';
				echo '			<td  width="28%">							Descripcion	</td>';
				echo '			<td  width="18%" align="center" colspan="3">Acciones	</td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListadoCAM">';

				$n 		 = 0;
				
				$link=Conectarse();
				if($filtro){
					$sql = "SELECT * FROM Cotizaciones Where RAM > 0 ".$filtro." Order By Estado Desc";
					$bdEnc=mysql_query($sql);
				}else{
					$bdEnc=mysql_query("SELECT * FROM Cotizaciones Where RAM > 0 Order By Estado Desc");
				}
				if ($row=mysql_fetch_array($bdEnc)){
					do{
						$n++;
						if($n==1){
							$filtroRAM = $row[RAM];
						}
						$tr = "bBlanca";
						if($row[Estado]==' '){
							$tr = "bBlanca";
						}
						if($row[Estado]=='E'){ // Enviada
							$tr = "bAmarilla";
							if($nDias <= $tDias){ // En Proceso
								$tr = 'bRoja';
							}
							if($row[proxRecordatorio] <= $fechaHoy){ // En Proceso
								$tr = 'bRoja';
							}
						}
						if($row[Estado] == 'A'){ // Aceptada
							$tr = 'bVerde';
						}
						if($row[fechaAceptacion] != '0000-00-00'){ // Aceptada
							$tr = 'bVerde';
						}
						echo '<tr id="'.$tr.'">';
						echo '	<td width="10%" style="font-size:12px;" align="center">';
						echo		'<strong style="font-size:14; font-weight:700">'.$row[RAM].'</strong>';
						echo '	</td>';
						echo '	<td width="08%" style="font-size:12px;">';
									$fd = explode('-', $row[fechaCotizacion]);
									echo $fd[2].'/'.$fd[1];
									echo '<br>'.$row[usrCotizador];
									//echo '<br>'.$_SESSION[usr];
						echo '	</td>';
						echo '	<td width="28%" style="font-size:12px;">';
							$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$row[RutCli]."'");
							if($rowCli=mysql_fetch_array($bdCli)){
								echo $rowCli[Cliente];
								echo '<br>'.$filtroCli;
							}
						echo '	</td>';
						echo '	<td width="28%" style="font-size:12px;">';
									echo $row[Descripcion];
						echo '	</td>';
						if($row[Estado] == 'E' or $row[Estado] == 'A'){ // En Proceso
							echo '<td width="06%" align="center"><a href="plataformaCotizaciones.php?CAM='.$row[CAM].'&accion=Seguimiento"	><img src="../gastos/imagenes/klipper.png" 			width="40" height="40" title="Seguimiento">			</a></td>';
						}else{
							echo '<td width="06%" align="center"><img src="../gastos/imagenes/klipper.png" width="40" height="40" title="Seguimiento" style="opacity:0;"></td>';
						}
						echo '	<td width="06%" align="center"><a href="modCotizacion.php?CAM='.$row[CAM].'&Rev='.$Rev.'&Cta='.$row[Cta].'&accion=Actualizar"	><img src="../gastos/imagenes/corel_draw_128.png" 	width="40" height="40" title="Editar Cotización">		</a></td>';
						echo '	<td width="06%" align="center"><a href="modCotizacion.php?CAM='.$row[CAM].'&Rev='.$Rev.'&Cta='.$row[Cta].'&accion=Borrar"		><img src="../gastos/imagenes/del_128.png"   		width="40" height="40" title="Borrar Cotización">		</a></td>';
						echo '</tr>';
					}while ($row=mysql_fetch_array($bdEnc));
				}
				mysql_close($link);

				echo '	</table>';
			}
			?>

<!-- 
****************************************************************************************************************
*
*             Nominas de Servicios en Procesos CAMs
*
*
****************************************************************************************************************

-->
		<?php
		function mCAMs($usrFiltro, $filtroCli){
				global $filtroRAM;
				$filtro = '';
				if($usrFiltro){
					$filtro = " and usrCotizador Like '%".$usrFiltro."%'";
				}
				if($filtroCli){
					$filtro = " and RutCli Like '%".$filtroCli."%'";
				}
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloCAM">';
				echo '		<tr>';
				echo '			<td  width="10%" align="center" height="40">CAM '.$filtroRAM.'		</td>';
				echo '			<td  width="08%">							Fecha		</td>';
				echo '			<td  width="28%">							Clientes	</td>';
				echo '			<td  width="28%">							Descripcion	</td>';
				echo '			<td  width="18%" align="center" colspan="3">Acciones	</td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListadoCAM">';

				$n 		 = 0;
				$tCAMsUF = 0;
				
				$link=Conectarse();
				if($filtro){
					$sql = "SELECT * FROM Cotizaciones Where RAM = '".$filtroRAM."' ".$filtro." Order By Estado Desc";
					$bdEnc=mysql_query($sql);
				}else{
					$bdEnc=mysql_query("SELECT * FROM Cotizaciones Where RAM = '".$filtroRAM."' Order By Estado Desc");
				}
				if ($row=mysql_fetch_array($bdEnc)){
					do{
						$tr = "bBlanca";
						if($row[Estado]==' '){
							$tr = "bBlanca";
						}
						if($row[Estado]=='E'){ // Enviada
							$tr = "bAmarilla";
							if($nDias <= $tDias){ // En Proceso
								$tr = 'bRoja';
							}
							if($row[proxRecordatorio] <= $fechaHoy){ // En Proceso
								$tr = 'bRoja';
							}
						}
						if($row[Estado] == 'A'){ // Aceptada
							$tr = 'bVerde';
						}
						if($row[fechaAceptacion] != '0000-00-00'){ // Aceptada
							$tr = 'bVerde';
						}
						echo '<tr id="'.$tr.'">';
						echo '	<td width="10%" style="font-size:12px;" align="center">';
						echo		'<strong style="font-size:14; font-weight:700">'.$row[CAM].'</strong>';
						echo '	</td>';
						echo '	<td width="08%" style="font-size:12px;">';
									$fd = explode('-', $row[fechaCotizacion]);
									echo $fd[2].'/'.$fd[1];
									echo '<br>'.$row[usrCotizador];
									//echo '<br>'.$_SESSION[usr];
						echo '	</td>';
						echo '	<td width="28%" style="font-size:12px;">';
							$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$row[RutCli]."'");
							if($rowCli=mysql_fetch_array($bdCli)){
								echo $rowCli[Cliente];
								echo '<br>'.$filtroCli;
							}
						echo '	</td>';
						echo '	<td width="28%" style="font-size:12px;">';
									echo $row[Descripcion];
						echo '	</td>';
						if($row[Estado] == 'E' or $row[Estado] == 'A'){ // En Proceso
							echo '<td width="06%" align="center"><a href="plataformaCotizaciones.php?CAM='.$row[CAM].'&accion=Seguimiento"	><img src="../gastos/imagenes/klipper.png" 			width="40" height="40" title="Seguimiento">			</a></td>';
						}else{
							echo '<td width="06%" align="center"><img src="../gastos/imagenes/klipper.png" width="40" height="40" title="Seguimiento" style="opacity:0;"></td>';
						}
						echo '	<td width="06%" align="center"><a href="modCotizacion.php?CAM='.$row[CAM].'&Rev='.$Rev.'&Cta='.$row[Cta].'&accion=Actualizar"	><img src="../gastos/imagenes/corel_draw_128.png" 	width="40" height="40" title="Editar Cotización">		</a></td>';
						echo '	<td width="06%" align="center"><a href="modCotizacion.php?CAM='.$row[CAM].'&Rev='.$Rev.'&Cta='.$row[Cta].'&accion=Borrar"		><img src="../gastos/imagenes/del_128.png"   		width="40" height="40" title="Borrar Cotización">		</a></td>';
						echo '</tr>';
					}while ($row=mysql_fetch_array($bdEnc));
				}
				mysql_close($link);

				echo '	</table>';
			}
			?>
