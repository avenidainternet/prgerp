				<?php
				global $ultUF;
				?>
					<table border="0" cellspacing="0" cellpadding="0" width="100%" bgcolor="#CCCCCC">
						<tr>
							<td height="60">
								<div id="BarraOpciones">
									<div id="ImagenBarraLeft">
										<a href="cotizaciones/exportarAM.php" title="Descargar AM..." style="padding:15p; float:right; ">
											<img src="../imagenes/AM.png" width="50" height="50">
										</a>
									</div>
								</div>							
							</td>
						</tr>
					</table>

				<?php 
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloCAM">';
				echo '		<tr>';
				echo '			<td  width="10%" align="center" height="40">AM					</td>';
				echo '			<td  width="10%">							Tipo Cot<br>Resp.	</td>';
				echo '			<td  width="22%">							Clientes			</td>';
				echo '			<td  width="14%">							Valor<br>			</td>';
				echo '			<td  width="10%">							Fecha AM<br>Fecha Up</td>';
				echo '			<td  width="10%">							Informes<br>N°/Sub.	</td>';
				echo '			<td  width="10%">							Estado 				</td>';
				echo '			<td  width="14%" align="center">Seguimiento	</td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListadoCAM">';
				$n 		= 0;
				$link=Conectarse();
				
				$bdEnc=mysql_query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'T' and Archivo != 'on' Order By Facturacion, Archivo, informeUP, oCtaCte, oCompra Desc, fechaTermino Desc");
				//$bdEnc=mysql_query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'T' and Archivo != 'on' Order By Facturacion, oCtaCte, Archivo, informeUP, oCompra Desc, fechaTermino Desc");
				if ($row=mysql_fetch_array($bdEnc)){
					do{
						if($row[informeUP] == 'on'){ 
							if($row[Facturacion] != 'on'){ 
								$tAMsUFsinF += $row[NetoUF];
								$tAMsPesinF += $row[Neto];
							}
						}
						
						$tr = "bBlanca";
						if($row[Estado] == 'T'){ 
							$tr = "bBlanca";
						}
						if($row[informeUP] == 'on'){ 
							$tr = "bAmarilla";
						}
						if($row[Facturacion] == 'on'){ 
							$tr = "bVerde";
						}
						if($row[Archivo] == 'on'){ 
							$tr = "bAzul";
						}
						if($row[oCtaCte] == 'on' and $row[Facturacion] != 'on'){ 
							$tr = "barraNaranja";
						}
						
						echo '<tr id="'.$tr.'">';
						echo '	<td width="10%" style="font-size:12px;" align="center">';
						echo		'<strong style="font-size:14; font-weight:700"></strong>';
									echo '<br>RAM-'.$row[RAM];
									echo '<br>CAM-'.$row[CAM];
									if($row[Cta]){
										echo '<br>CC';
									}
						echo '	</td>';
						echo '	<td width="10%" style="font-size:12px;">';
									if($row[oCompra]=='on'){
										echo 'OC';
									}
									if($row[oMail]=='on'){
										echo 'Mail';
									}
									if($row[oCtaCte]=='on'){
										echo 'Cta.Cte';
									}
									if($row[nOC]){
										echo '<br>'.$row[nOC];
									}
									echo '<br>'.$row[usrResponzable];
						echo '	</td>';
						echo '	<td width="22%" style="font-size:12px;">';
							$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$row[RutCli]."'");
							if($rowCli=mysql_fetch_array($bdCli)){
								echo 	$rowCli[Cliente];
							}
						echo '	</td>';
						echo '	<td width="14%">';
						echo '		<strong style="font-size:12px;">';
						echo 			number_format($row[BrutoUF], 2, ',', '.').' UF';
						echo '		</strong>';
						echo ' 	</td>';
						echo '  <td width="10%">';
									$fd = explode('-', $row[fechaTermino]);
									echo $fd[2].'/'.$fd[1].'/'.$fd[0];
									//echo 'I'.$row[fechaInicio];
									$CodInforme 	= 'AM-'.$row[RAM];
									$bdInf=mysql_query("SELECT * FROM Informes Where CodInforme Like '%".$CodInforme."%'");
									if($rowInf=mysql_fetch_array($bdInf)){
										if($rowInf[informePDF]){
											echo '<br>';
											$fd = explode('-', $rowInf[fechaUp]);
											echo $fd[2].'/'.$fd[1].'/'.$fd[0];
										}
									}
						echo '  <td>';
						echo '  <td width="10%">';
							$CodInforme 	= 'AM-'.$row[RAM];
							$infoNumero 	= 0;
							$infoSubidos 	= 0;
							$fechaUp		= '';
							$bdInf=mysql_query("SELECT * FROM Informes Where CodInforme Like '%".$CodInforme."%'");
							if($rowInf=mysql_fetch_array($bdInf)){
								do{
									$infoNumero++;
									if($rowInf[informePDF]){
										$infoSubidos++;
									}
								}while ($rowInf=mysql_fetch_array($bdInf));
							}
							echo '<strong>'.$infoNumero.'/'.$infoSubidos.'</strong>';
						echo '  <td>';
						echo '	<td width="10%">';
									$imgEstado = 'upload2.png';
									$msgEstado = 'Esperando Seguimiento';
									$fd[0] = 0;
									if($row[Estado] == 'T'){ // En Espera
										$imgEstado = 'upload2.png';
										$msgEstado = 'Subir Informe';
									}
									if($row[informeUP] == 'on'){ // Cerrada
										$imgEstado = 'informeUP.png';
										$msgEstado = 'Informe Subido';
										$fd = explode('-', $row[fechaInformeUP]);
									}
									if($row[Facturacion] == 'on'){ // Cerrada
										$imgEstado = 'crear_certificado.png';
										$msgEstado = 'Facturado';
										$fd = explode('-', $row[fechaFacturacion]);
									}
									if($row[Archivo] == 'on'){ // Cerrada
										$imgEstado = 'consulta.png';
										$msgEstado = 'Archivado';
										$fd = explode('-', $row[fechaArchivo]);
									}
									if($row[Estado] == 'T' and $row[informeUP] != 'on'){ // En Espera
										$CodInforme = 'AM-'.$row[RAM];
										echo '<a href="informes/plataformaInformes.php?CodInforme='.$CodInforme.'"><img src="../imagenes/'.$imgEstado.'"	width="40" height="40" title="'.$msgEstado.'"></a>';
									}else{
										if($row[Estado] == 'T' and $row[informeUP] == 'on' and $row[Facturacion] != 'on'){ // En Espera
											echo '<a href="facturacion/formSolicitaFactura.php?RutCli='.$row[RutCli].'&Proceso=&nSolicitud="><img src="../imagenes/tpv.png"	width="40" height="40" title="Informe(s) subido(s), ir a Solicitud de Facturación..."></a>';
										}else{
											echo '<img src="../imagenes/'.$imgEstado.'"	width="40" height="40" title="'.$msgEstado.'">';
										}
									}
									if($fd[0]>0){
										echo '<br>'.$fd[2].'/'.$fd[1];
									}
						echo ' 	</td>';
						echo '	<td width="14%" align="center">';
								if($row[Estado] == 'T'){ // En Proceso
									echo '<a href="plataformaErp.php?CAM='.$row[CAM].'&RAM='.$row[RAM].'&accion=SeguimientoAM"		><img src="../gastos/imagenes/klipper.png" 			width="40" height="40" title="Seguimiento">			</a>';
								}else{
									echo '<img src="../imagenes/klipper.png" width="40" height="40" title="Seguimiento" style="opacity:0;">';
								}
						echo '	</td>';
						echo '</tr>';
					}while ($row=mysql_fetch_array($bdEnc));
				}
				mysql_close($link);

					echo '<tr id="bAzul">';
					echo '	<td colspan=10 style="font-size: 16px; font-weight:700">';
								echo 'Última UF de Referencia '.number_format($ultUF, 2, ',', '.');
								
								$sTotales = 0;
								$txt = 'Total NO Facturado ';
								if($tAMsUFsinF>0){
									$txt .= number_format($tAMsUFsinF, 2, ',', '.').' UF';
									$sTotales += $ultUF * $tAMsUFsinF;
									echo '<br>'.$txt.' = $ '.number_format($sTotales, 0, ',', '.');
								}
								
					echo '	</td>';
					echo '</tr>';

				echo '	</table>';
				?>
				