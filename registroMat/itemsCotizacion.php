<?php

	$Estado = array(
					1 => 'Estado', 
					2 => 'Fotocopia',
					3 => 'Factura',
					4 => 'Canceladas'
				);

	$Mes = array(
					1 => 'Enero', 
					2 => 'Febrero',
					3 => 'Marzo',
					4 => 'Abril',
					5 => 'Mayo',
					6 => 'Junio',
					7 => 'Julio',
					8 => 'Agosto',
					9 => 'Septiembre',
					10 => 'Octubre',
					11 => 'Noviembre',
					12 => 'Diciembre'
				);
				
	$MesNum = array(	
					'Enero' 		=> '01', 
					'Febrero' 		=> '02',
					'Marzo' 		=> '03',
					'Abril' 		=> '04',
					'Mayo' 			=> '05',
					'Junio' 		=> '06',
					'Julio' 		=> '07',
					'Agosto' 		=> '08',
					'Septiembre'	=> '09',
					'Octubre' 		=> '10',
					'Noviembre' 	=> '11',
					'Diciembre'		=> '12'
				);

	$fd 	= explode('-', date('Y-m-d'));

	$Agno     	= date('Y');
	
	$dBuscado = '';
	if(isset($_GET['dBuscado'])) 	{ $dBuscado  = $_GET['dBuscado']; 	}
	
?>

			<div id="BarraOpciones">
				<div id="ImagenBarraLeft">
					<a href="plataformaCotizaciones.php" title="Cotizaciones">
						<img src="../imagenes/other_48.png">
					</a>
				</div>
				<div id="ImagenBarraLeft">
					<input name="CAM" id="CAM" type="hidden" value="<?php echo $CAM;?>">
					<input name="Rev" id="Rev" type="hidden" value="<?php echo $Rev;?>">
					<input name="Cta" id="Cta" type="hidden" value="<?php echo $Cta;?>">
					<a href="#" title="Editar Datos Cotización" onClick="registraEncuesta($('#CAM').val(), $('#Rev').val(), $('#Cta').val(), 'Actualiza')">
						<img src="../imagenes/editarCotizacion.png">
					</a>
				</div>
				<?php
					if($CAM){?>
						<div id="ImagenBarraLeft" title="Enviar Cotización">
							<input name="CAM" id="CAM" type="hidden" value="<?php echo $CAM;?>">
							<input name="Rev" id="Rev" type="hidden" value="<?php echo $Rev;?>">
							<input name="Cta" id="Cta" type="hidden" value="<?php echo $Cta;?>">
<!--
							<a href="#" title="Enviar Cotización" onClick="enviarCotizacion($('#CAM').val(), $('#Rev').val(), $('#Cta').val())">
								<img src="../imagenes/enviarConsulta.png">
							</a>
-->							
							<a href="formularios/iCAM.php?CAM=<?php echo $CAM;?>&Rev=<?php echo $Rev;?>&Cta=<?php echo $Cta;?>" title="Enviar Cotización">
								<img src="../imagenes/enviarConsulta.png">
							</a>
						</div>
						<?php
					}
				?>
				<?php
					if($Moneda == 'P'){?>
						<div id="ImagenBarraLeft">
							<input name="CAM" id="CAM" type="hidden" value="<?php echo $CAM;?>">
							<input name="Rev" id="Rev" type="hidden" value="<?php echo $Rev;?>">
							<input name="Cta" id="Cta" type="hidden" value="<?php echo $Cta;?>">
							<a href="#" title="Cotización en U.F." onClick="cambiarMoneda($('#CAM').val(), $('#Rev').val(), $('#Cta').val(), 'UF')">
								<img src="../imagenes/uf.png">
							</a>
						</div>
						<?php
					}else{?>
						<div id="ImagenBarraLeft">
							<input name="CAM" id="CAM" type="hidden" value="<?php echo $CAM;?>">
							<input name="Rev" id="Rev" type="hidden" value="<?php echo $Rev;?>">
							<input name="Cta" id="Cta" type="hidden" value="<?php echo $Cta;?>">
							<a href="#" title="Cotización en Pesos" onClick="cambiarMoneda($('#CAM').val(), $('#Rev').val(), $('#Cta').val(), 'Pesos')">
								<img src="../imagenes/pesos.png">
							</a>
						</div>
						<?php
					}
				?>
			</div>
			<?php
//				if($oCtaCte){?>
					<div id="barraCAM">
						CAM-
						<?php
							$ctlCam = '';
							$link=Conectarse();
							$bdCAM=mysql_query("Select * From Cotizaciones Where RutCli = '".$Cliente."' and (Estado != 'P' and Estado != 'T') Order By CAM");
							if($rowCAM=mysql_fetch_array($bdCAM)){
								do{
									if($ctlCam != $rowCAM[CAM]){
										$ctlCam = $rowCAM[CAM];
										echo '<a href="modCotizacion.php?CAM='.$rowCAM[CAM].'&Cta='.$rowCAM[Cta].'&Rev='.$rowCAM[Rev].'">'.$rowCAM[CAM].'</a>';
									}
								}while($rowCAM=mysql_fetch_array($bdCAM));
							}
							mysql_close($link);
						?>
					</div>
					<div id="barraRev">
						Rev-
						<?php
							$ctlRev = '';
							$link=Conectarse();
							$bdCAM=mysql_query("Select * From Cotizaciones Where RutCli = '".$Cliente."' and Estado != 'F' and CAM = '".$CAM."' Order By CAM");
							if($rowCAM=mysql_fetch_array($bdCAM)){
								do{
									if($ctlRev != $rowCAM[Rev]){
										$ctlRev = $rowCAM[Rev];
										if($rowCAM[Rev]<10){
											$mRev = '0'.$rowCAM[Rev];
										}
										echo '<a href="modCotizacion.php?CAM='.$rowCAM[CAM].'&Cta='.$rowCAM[Cta].'&Rev='.$rowCAM[Rev].'">'.$mRev.'</a>';
									}
								}while($rowCAM=mysql_fetch_array($bdCAM));
							}
							mysql_close($link);
						?>
					</div>
				<?php
//				}
			?>			
			<div id="accordion">
			<?php
				$link=Conectarse();
				$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$Cliente."'");
				if($rowCli=mysql_fetch_array($bdCli)){
					$Cliente = $rowCli[Cliente];
				}
				$bdUsr=mysql_query("SELECT * FROM Usuarios Where usr = '".$usrCotizador."'");
				if($rowUsr=mysql_fetch_array($bdUsr)){
					$usrCotizador = $rowUsr[usuario];
				}
				mysql_close($link);
			?>

  			<h3 style="font-size:14px;"><?php echo $Cliente.' ('.$Atencion.') - Resp. CAM '.$usrCotizador; ?></h3>
			<div id="infoCotizacion">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td height="36" valign="top" width="7%">Descripción General del Servicio: </td>
						<td valign="top" width="48%">
							<textarea name="Descripcion" id="Descripcion" cols="90" rows="5" style="font-size:12px; border:2px solid #000;" readonly><?php echo $Descripcion; ?></textarea>
						</td>
					    <td width="1%" valign="top" style="border-left:1px solid #ccc;">&nbsp;</td>
					    <td width="44%" valign="top">

                            <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                            	<tr>
                            	  <td>Fecha CAM </td>
                            	  <td colspan="5"><input name="fechaCotizacion" id="fechaCotizacion" type="date" value="<?php echo $fechaCotizacion; ?>" readonly>								  </td>
                           	  </tr>
                            	<tr>
                            	  <td>Situación</td>
                            	  <td width="13%">Correo
								  </td>
                           	      <td width="12%">Aceptado</td>
                           	      <td width="12%">Taller</td>
                           	      <td>Estado</td>
                           	      <td>&nbsp;</td>
                           	  </tr>
                            	<tr>
                                	<td width="18%">&nbsp;</td>
                                    <td align="center">
										<?php
										if($row[enviadoCorreo] == ''){ // Sin Enviar
											echo '<img src="../imagenes/noEnviado.png" 			width="32" height="32" title="Cotización NO Enviada">';
										}
										if($row[enviadoCorreo] == 'on'){ // Enviada
											echo '<img src="../imagenes/siEnviado.png" 	width="32" height="32" title="Cotización Enviada"><br>';
											echo $fechaEnvio;
										}
										?>
									</td>
                                    <td align="center">
										<?php
										if($row[Estado] == 'A'){ // Aceptada
											echo '<img src="../imagenes/printing.png" 			 width="32" height="32" title="Cotización Aceptada"><br>';
											if($fechaAceptacion<>"0000-00-00"){
												echo '<br><span style="font-size:10px;">'.$fechaAceptacion.'</span>';
											}
										}else{
											echo '<img src="../imagenes/hourglass_clock_256.png" width="32" height="32" title="Esperando Respuesta"><br>';
										}
										?>
									</td>
                                    <td align="center">
										<?php
										if($row[Estado] == 'P'){ // En Proceso
											echo '<img src="../imagenes/settings_128.png" 		width="32" height="32" title="En Proceso">';
										}else{
											echo '<img src="../imagenes/hourglass_clock_256.png" width="32" height="32" title="Esperando Respuesta"><br>';
										}
										?>
									</td>
                                    <td width="10%" align="center">
										<?php
										if($row[Estado] == 'C'){ // Cerrada
											echo '<img src="../imagenes/tpv.png" 				width="32" height="32" title="Cerrada para Cobranza">';
										}else{
											echo '<img src="../imagenes/hourglass_clock_256.png" 				width="32" height="32" title="Abierta">';
										}
										?>
									</td>
                                    <td width="35%">&nbsp;</td>
                            	</tr>
                                 <tr>
                                   <td>&nbsp;</td>
                                   <td>&nbsp;</td>
                                   <td>&nbsp;</td>
                                   <td>&nbsp;</td>
                                   <td>&nbsp;</td>
                                   <td>&nbsp;</td>
                                 </tr>
                                 <tr>
                                   <td>&nbsp;</td>
                                   <td>Validez</td>
                                   <td>Vence</td>
                                   <td>&nbsp;</td>
                                   <td>&nbsp;</td>
                                   <td>&nbsp;</td>
                                 </tr>
                                 <tr>
                                   <td>&nbsp;</td>
                                   <td><?php
											if($Validez){
												echo '<span style="font-size:10px; color:#fff;">'.$Validez.' días </span>';
											}
										?></td>
                                   <td>
									   	<?php
										$fechaxVencer 	= strtotime ( '+'.$Validez.' day' , strtotime ( $fechaCotizacion ) );
										$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );

										$fd = explode('-', $fechaxVencer);
										echo '<span style="font-size:10px; color:#fff;">'.$fd[2].'/'.$fd[1].'</span>';
										?>
								   </td>
                                   <td>&nbsp;</td>
                                   <td>&nbsp;
								   </td>
                                   <td>&nbsp;</td>
                                 </tr>
                         	</table>
							
						
						</td>
					</tr>
				</table>
			</div>			
			
			</div>
			<?php
			if($dBuscado==''){?>
				<script>
					var dBuscar = '';
					var CAM		= '<?php echo $CAM; ?>';
					var Rev		= '<?php echo $Rev; ?>';
					var Cta		= '<?php echo $Cta; ?>';
					realizaProceso(CAM, Rev, Cta);
				</script>					
			<?php
			}
			?>
			<span id="resultado"></span>
			<span id="resultadoRegistro"></span>
			<span id="cajaDeEnvio"></span>
			<span id="cajaServicios"></span>
			