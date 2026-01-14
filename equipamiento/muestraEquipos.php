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
						informesEquipos($usrRes, $tpAccion); 
					?>
				</td>
			</tr>
		</table>
		
		<?php
		function informesEquipos($usrRes, $tpAccion){
				echo '	<table class="table table-dark table-hover" border="0" cellspacing="0" cellpadding="0" id="CajaTiluloCAM">';
				echo '		<tr>';
				echo '			<td  width="10%" align="center" height="40">Código<br>Equipo		</td>';
				echo '			<td  width="20%">							Nombre<br>Equipo		</td>';
				echo '			<td  width="08%">							Tipo<br>Equipo			</td>';
				echo '			<td  width="13%">							Ubicación.<br>Equipo	</td>';
				echo '			<td  width="08%">							Fecha<br>Calibración	</td>';
				echo '			<td  width="08%">							Fecha<br>Verificación	</td>';
				echo '			<td  width="08%">							Fecha<br>Mantención		</td>';
				echo '			<td  width="07%">							Responsable<br>Equipo	</td>';
				if($tpAccion == 'Seguimiento'){
					echo '		<td  width="18%" align="center">Acciones							</td>';
				}else{
					echo '		<td  width="18%" align="center" colspan="5">Acciones				</td>';
				}
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListadoCAM">';
				$n 		= 0;

				$link=Conectarse();
				//$sql = "SELECT * FROM accionesCorrectivas Where verCierreAccion != 'on' Order By fechaApertura Desc";
				if($tpAccion == 'Seguimiento'){
					if($usrRes){
						$sql = "SELECT * FROM equipos Where usrResponsable = '".$usrRes."' Order By nSerie";
					}
				}else{
					$sql = "SELECT * FROM equipos Order By fechaProxCal, fechaProxVer, fechaProxMan";
				}
				$bdEnc=$link->query($sql);
				if($row=mysqli_fetch_array($bdEnc)){
					do{
						$fechaHoy = date('Y-m-d');
						$tr = "bBlanca";
						$td = $tr;
						echo '<tr id="'.$tr.'">';
						echo '	<td width="10%" style="font-size:12px;" align="center">';
						echo		'<strong style="font-size:14; font-weight:700">';
						echo			$row['nSerie'];
						echo 		'</strong>';
						echo '	</td>';
						echo '	<td width="20%" style="font-size:12px;">';
									if($row['Acreditado'] == 'on'){
										echo '<span style="font-weight:700;">'.$row['nomEquipo'].' (A)</span>';
									}else{
										echo $row['nomEquipo'];
									}
						echo '	</td>';
						echo '	<td width="08%" style="font-size:12px;">';
									if($row['tipoEquipo']=='E'){
										echo 'Equipo';
									}else{
										if($row['tipoEquipo']=='I'){
											echo 'Instrumento';
										}
									}
						echo '	</td>';
						echo '	<td width="13%" style="font-size:12px;">';
									echo $row['lugar'];
						echo '	</td>';
						
						$td = 'bBlanca';
						if($row['fechaProxCal'] != '0000-00-00'){ 
							$td = 'bVerde';
							$fechaxVencer 	= strtotime ( '-'.$row['tpoAvisoCal'].' day' , strtotime ( $row['fechaProxCal'] ) );
							$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
							if($row['fechaProxCal'] != '0000-00-00' and $fechaHoy >= $fechaxVencer){ 
								$td = 'bAmarilla';
							}
							if($row['fechaProxCal'] != '0000-00-00' and $fechaHoy > $row['fechaProxCal']){ 
								$td = 'bRoja';
							}
						}
						
						//echo '	<td width="08%" style="font-size:12px;" id="'.$td.'">';
						echo '	<td width="08%" style="font-size:12px;">';
									$fd = explode('-', $row['fechaProxCal']);
									if($fd[2] > 0){
										if($row['fechaProxCal'] != '0000-00-00' and $fechaHoy > $row['fechaProxCal']){ 
											echo '<span class="atrazoEquipo">';
											echo	$fd[2].'/'.$fd[1].'/'.$fd[0];
											echo '</span>';
										}else{
											echo $fd[2].'/'.$fd[1].'/'.$fd[0];
										}
										if($td == 'bAmarilla'){
											echo '<img src="../imagenes/bola_amarilla.png" style="padding-left:5px;">';
										}
										if($td == 'bRoja'){
											echo '<img src="../imagenes/bola_roja.png" style="padding-left:5px;">';
										}
										if($td == 'bVerde'){
											echo '<img src="../imagenes/bola_verde.png" style="padding-left:5px;">';
										}
										$SQLd = "SELECT * FROM equiposForm Where nSerie = '".$row['nSerie']."' and AccionEquipo = 'Cal'";
										$bdDoc=$link->query($SQLd);
										if($rowDoc=mysqli_fetch_array($bdDoc)){
											//echo '<br><a href="../archivo/POC-'.substr($row['FormularioCal'],0,2).'/Formularios/'.$rowDoc['pdf'].'" target="_blank">					<img src="../imagenes/pdf_download.png" 	width="30" title="Descarga Formulario"></a>';
											echo '<a style="padding:5px;" href="upFormularioReg/index.php?nDocGes='.$row['nSerie'].'&AccionEquipo=Cal&FormularioCal='.$row['FormularioCal'].'">	<img src="../imagenes/pdf-upload-icon.png" 	width="30" title="Descargar/Subir Formulario">		</a>';
										}
										$SQLh = "SELECT * FROM equiposhistorial Where nSerie = '".$row['nSerie']."' and Accion = 'Cal' Order By fechaAccion Desc";
										$bdh=$link->query($SQLh);
										if($rs=mysqli_fetch_array($bdh)){
											if($rs['pdf']){
												echo '<br>';
												$formPdf = "../archivo/POC-27/Registros/".$rs['pdf'];
												echo '<a style="padding:5px;" class="btn btn-warning" href="'.$formPdf.'" target = "_blank">Formulario	</a>';
											}
										}
									}
						echo ' 	</td>';
						$td = 'bBlanca';
						if($row['fechaProxVer'] != '0000-00-00'){ 
							$td = 'bVerde';
							$fechaxVencer 	= strtotime ( '-'.$row['tpoAvisoVer'].' day' , strtotime ( $row['fechaProxVer'] ) );
							$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
							if($row['fechaProxVer'] != '0000-00-00' and $fechaHoy >= $fechaxVencer){ 
								$td = 'bAmarilla';
							}
							if($row['fechaProxVer'] != '0000-00-00' and $fechaHoy > $row['fechaProxVer']){ 
								$td = 'bRoja';
							}
						}
						echo '	<td width="08%" style="font-size:12px;">';
									$fd = explode('-', $row['fechaProxVer']);
									if($fd[2] > 0){
										if($row['fechaProxVer'] != '0000-00-00' and $fechaHoy > $row['fechaProxVer']){ 
											echo '<span class="atrazoEquipo">';
											echo	$fd[2].'/'.$fd[1].'/'.$fd[0];
											echo '</span>';
										}else{
											echo $fd[2].'/'.$fd[1].'/'.$fd[0];
										}
										if($td == 'bAmarilla'){
											echo '<img src="../imagenes/bola_amarilla.png" style="padding-left:5px;">';
										}
										if($td == 'bRoja'){
											echo '<img src="../imagenes/bola_roja.png" style="padding-left:5px;">';
										}
										if($td == 'bVerde'){
											echo '<img src="../imagenes/bola_verde.png" style="padding-left:5px;">';
										}
										$SQLd = "SELECT * FROM equiposForm Where nSerie = '".$row['nSerie']."' and AccionEquipo = 'Ver'";
										$bdDoc=$link->query($SQLd);
										if($rowDoc=mysqli_fetch_array($bdDoc)){
											echo '<a style="padding:5px;" href="upFormularioReg/index.php?nDocGes='.$row['nSerie'].'&AccionEquipo=Ver&FormularioVer='.$row['FormularioVer'].'">	<img src="../imagenes/pdf-upload-icon.png" 	width="30" title="Descargar/Subir Formulario">		</a>';
										}
										
										$SQLh = "SELECT * FROM equiposhistorial Where nSerie = '".$row['nSerie']."' and Accion = 'Ver' Order By fechaAccion Desc";
										$bdh=$link->query($SQLh);
										if($rs=mysqli_fetch_array($bdh)){
											if($rs['pdf']){
												echo '<br>';
												$formPdf = "../archivo/POC-27/Registros/".$rs['pdf'];
												echo '<a style="padding:5px;" class="btn btn-warning" href="'.$formPdf.'" target = "_blank">Formulario	</a>';
											}
										}
										
									}
						echo ' 	</td>';
						$td = 'bBlanca';
						if($row['fechaProxMan'] != '0000-00-00'){ 
							$td = 'bVerde';
							$fechaxVencer 	= strtotime ( '-'.$row['tpoAvisoMan'].' day' , strtotime ( $row['fechaProxMan'] ) );
							$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
							if($row['fechaProxMan'] != '0000-00-00' and $fechaHoy >= $fechaxVencer){ 
								$td = 'bAmarilla';
							}
							if($row['fechaProxMan'] != '0000-00-00' and $fechaHoy > $row['fechaProxMan']){ 
								$td = 'bRoja';
							}
						}
						echo '	<td width="08%" style="font-size:12px;">';
									$fd = explode('-', $row['fechaProxMan']);
									if($fd[2] > 0){
										if($row['fechaProxMan'] != '0000-00-00' and $fechaHoy > $row['fechaProxMan']){ 
											echo '<span class="atrazoEquipo">';
											echo	$fd[2].'/'.$fd[1].'/'.$fd[0];
											echo '</span>';
										}else{
											echo $fd[2].'/'.$fd[1].'/'.$fd[0];
										}
										if($td == 'bAmarilla'){
											echo '<img src="../imagenes/bola_amarilla.png" style="padding-left:5px;">';
										}
										if($td == 'bRoja'){
											echo '<img src="../imagenes/bola_roja.png" style="padding-left:5px;">';
										}
										if($td == 'bVerde'){
											echo '<img src="../imagenes/bola_verde.png" style="padding-left:5px;">';
										}
										$SQLd = "SELECT * FROM equiposForm Where nSerie = '".$row['nSerie']."' and AccionEquipo = 'Man'";
										$bdDoc=$link->query($SQLd);
										if($rowDoc=mysqli_fetch_array($bdDoc)){
											echo '<a style="padding:5px;" href="upFormularioReg/index.php?nDocGes='.$row['nSerie'].'&AccionEquipo=Man&FormularioMan='.$row['FormularioMan'].'">	<img src="../imagenes/pdf-upload-icon.png" 	width="30" title="Descargar/Subir Formulario">		</a>';
										}
										$SQLh = "SELECT * FROM equiposhistorial Where nSerie = '".$row['nSerie']."' and Accion = 'Man' Order By fechaAccion Desc";
										$bdh=$link->query($SQLh);
										if($rs=mysqli_fetch_array($bdh)){
											if($rs['pdf']){
												echo '<br>';
												$formPdf = "../archivo/POC-27/Registros/".$rs['pdf'];
												echo '<a style="padding:5px;" class="btn btn-warning" href="'.$formPdf.'" target = "_blank">Formulario	</a>';
											}
										}
									}
						echo ' 	</td>';
						echo '	<td width="07%" style="font-size:12px;">';
									echo $row['usrResponsable'];
						echo ' 	</td>';
						if($tpAccion == 'Seguimiento'){
							echo '	<td width="09%" align="center"><a href="plataformaEquipos.php?nSerie='.$row['nSerie'].'&accion=Seguimiento&tpAccion='.$tpAccion.'"	><img src="../imagenes/klipper.png" 	width="25" title="Seguimiento">						</a></td>';
							echo '	<td width="09%" align="center"><a href="plataformaEquipos.php?nSerie='.$row['nSerie'].'&accion=Imprimir"							><img src="../imagenes/informes.png" 	width="25" title="Imprimir Ficha de Equipo">		</a></td>';
						}else{
							if($row['codigo']){
								echo '<td width="04%" align="center"><a href="formularios/exportarFormularios.php?nSerie='.$row['nSerie'].'&accion=Imprimir"	><img src="../imagenes/docx.png" width="25" title="Imprimir Formularios"></a></td>';
							}else{
								echo '<td width="04%" align="center"></td>';
							}
							if($row['fechaProxCal'] != '0000-00-00' or $row['fechaProxVer'] != '0000-00-00' or $row['fechaProxMan'] != '0000-00-00'){
								echo '	<td width="04%" align="center"><a href="plataformaEquipos.php?nSerie='.$row['nSerie'].'&accion=Seguimiento"><img src="../imagenes/klipper.png" 				width="25" title="Seguimiento">						</a></td>';
							}else{
								echo '	<td width="04%" align="center">&nbsp;</td>';
							}
							echo '	<td width="04%" align="center"><a href="plataformaEquipos.php?nSerie='.$row['nSerie'].'&accion=Imprimir"	><img src="../imagenes/informes.png" 				width="25" title="Imprimir Ficha de Equipo">		</a></td>';
							echo '	<td width="04%" align="center"><a href="plataformaEquipos.php?nSerie='.$row['nSerie'].'&accion=Actualizar"	><img src="../gastos/imagenes/corel_draw_128.png" 	width="25" title="Editar Equipo">					</a></td>';
							echo '	<td width="04%" align="center"><a href="plataformaEquipos.php?nSerie='.$row['nSerie'].'&accion=Borrar"		><img src="../gastos/imagenes/del_128.png"   		width="25" title="Borrar Equipo">					</a></td>';
						}
						echo '</tr>';
					}while ($row=mysqli_fetch_array($bdEnc));
				}
				$link->close();
				echo '	</table>';
			}
			?>

