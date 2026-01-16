	<?php
	if($Cliente){?>
		<table class="table table-dark">
			<thead>
			<tr class="table-success">
				<th>
					<span class="tituloFormulario"><strong>Grabar Datos</strong></span>
					<button class="btn btn-primary" name="GuardarFacturacion" title="Guardar datos de Facturación" style="float:right; ">
						<img src="../gastos/imagenes/guardar.png" width="50" height="50">
					</button>
				</th>
			</tr>
		</table>
		<?php
	}
	?>


	<?php
		if($Cliente){
			if($nSolicitud > 0){?>
				<div class="container-fluid" style="margin-top: 5px;">
					<div class="card">
						<div class="card-header bg-secondary text-white"><h5>Asociar CAMs y RAMs</h5></div>
							<div class="card-body">
								Registro de Trabajos Terminados para Facturar (AM) <?php echo $RAM; ?>
								<div class="row">
									<div class="col-6">
						                <table id="usuarios" class="display" style="width:100%">
						                    <thead>
						                        <tr>
						                            <th>Disponibles     </th>
						                            <th>Monto       	</th>
						                            <th>Acciones    </th>
						                        </tr>
						                    </thead>
						                    <tbody>
												<?php
													$link=Conectarse();
													$bdPr=$link->query("SELECT * FROM Cotizaciones Where RutCli = '".$RutCli."' and informeUP = 'on' and Facturacion != 'on' and Archivo != 'on'");
													while ($row=mysqli_fetch_array($bdPr)){?>
															<tr>
																<td style="padding:10px; border-bottom:1px solid #000;">
																	<?php 
																		echo 'RAM-'.$row['RAM'].' CAM-'.$row['CAM'];
																		if($row['Fan'] > 0){
																			echo '<br><img src="../imagenes/extra_column.png" align="left" width="32" title="CLON" style="padding:10px;">';
																		}
																	?>
																</td>
																<td style="border-bottom:1px solid #000;">
																	<strong style="font-size:12px;">
																		<?php echo 			number_format($row['BrutoUF'], 2, ',', '.'); ?>
																	</strong>
																</td>
																<td style="border-bottom:1px solid #000;">
																		<a href="formSolicitaFactura.php?RutCli=<?php echo $RutCli;?>&Proceso=<?php echo $Proceso; ?>&accionCAM=Agregar&nSolicitud=<?php echo $nSolicitud; ?>&CAM=<?php echo $row['CAM'];?>"><img src="../imagenes/add_32.png"></a>
																</td>
															</tr>
															<?php
													}
													$link->close();
												?>

						                    </tbody>
						                </table>
						            </div>
									<div class="col-6">
						                <table id="usuarios" class="display" style="width:100%">
						                    <thead>
						                        <tr>
						                            <th>Incluidos     </th>
						                            <th>Monto       	</th>
						                            <th>Acciones    </th>
						                        </tr>
						                    </thead>
						                    <tbody>
												<?php
													$link=Conectarse();
													$bdPr=$link->query("SELECT * FROM Cotizaciones Where RutCli = '".$RutCli."' and nSolicitud = '$nSolicitud'");
													while ($row=mysqli_fetch_array($bdPr)){?>
															<tr>
																<td style="padding:10px; border-bottom:1px solid #000;">
																	<?php 
																		echo 'RAM-'.$row['RAM'].' CAM-'.$row['CAM'];
																		if($row['Fan'] > 0){
																			echo '<br><img src="../imagenes/extra_column.png" align="left" width="32" title="CLON" style="padding:10px;">';
																		}
																	?>
																</td>
																<td style="border-bottom:1px solid #000;">
																	<strong style="font-size:12px;">
																		<?php echo 			number_format($row['BrutoUF'], 2, ',', '.'); ?>
																	</strong>
																</td>
																<td style="border-bottom:1px solid #000;">
																		<a href="formSolicitaFactura.php?RutCli=<?php echo $RutCli;?>&Proceso=<?php echo $Proceso; ?>&accionCAM=Quitar&nSolicitud=<?php echo $nSolicitud; ?>&CAM=<?php echo $row['CAM'];?>"><img src="../imagenes/delete_32.png"></a>
																</td>
															</tr>
															<?php
													}
													$link->close();
												?>
						                    </tbody>
						                </table>
						            </div>

						       	</div>
							</div>


							<div class="card">
								<div class="card-header bg-secondary text-white"><h5>Detalle Facturación</h5></div>
									<div class="card-body">
									
										<table  class="table table-bordered">
											<thead>
												<tr>
											  		<th>ITEMS</td>
											  		<th>CANTIDAD</td>
											  		<th>ESPECIFICACION</td>
											  		<th>Valor Unitario</td>
											  		<th>VALOR TOTAL</td>
											  		<th>Acciones</td>
												</tr>
											</thead>
											<tbody>
											<?php
											$nItems = 0;
											$NetoExcepcion = $Neto;
											$Neto 	= 0;
											$netoUF = 0;
											$link=Conectarse();
											$bddSol=$link->query("SELECT * FROM detSolFact WHERE nSolicitud = '".$nSolicitud."'");
											if ($rowdSol=mysqli_fetch_array($bddSol)){
												do{?>
													<tr>
														<td  height="30" align="center">
															<?php 
																echo $rowdSol['nItems'];
																$nItems = $rowdSol['nItems'];
															?>
														</td>
														<td  height="30" align="center">
															<?php echo $rowdSol['Cantidad'];?>
														</td>
														<td>
															<?php echo $rowdSol['Especificacion'];?>
														</td>
														<td align="right">
															<?php 
																if($tipoValor=='U'){
																	echo $rowdSol['valorUnitarioUF'];
																}else{
																	echo $rowdSol['valorUnitario'];
																}
															?>
														<td align="right">
															<?php 
																if($tipoValor=='U'){
																	echo $rowdSol['valorTotalUF'];
																	if($Exenta=='on'){
																		$netoUF 	+= $rowdSol['valorTotalUF'];
																		$ivaUF		= 0;
																		$brutoUF	= $netoUF;
																	}else{
																		$netoUF 	+= $rowdSol['valorTotalUF'];
																		$ivaUF		= $netoUF * 0.19;
																		$brutoUF	= $netoUF * 1.19;
																	}
																}else{
																	echo $rowdSol['valorTotal'];
																	if($Exenta=='on'){
																		$Neto 	+= $rowdSol['valorTotal'];
																		$Iva	= 0;
																		$Bruto	= $Neto;
																	}else{
																		if($Excepcion != 'on'){
																			$Neto 	+= $rowdSol['valorTotal'];
																			//$Iva	= intval($Neto * 0.19);
																			//$Bruto	= intval($Neto * 1.19);
																			if($Redondear=='on'){
																				//$Iva	= round(($Neto * 0.19),0);
																				//$Bruto	= round(($Neto * 1.19),0);
																			}
																		}else{
																			$Neto = 1000;
																		}
																	}
																}
																$Neto = $NetoExcepcion;
															?>
														</td>
														<td align="center">
															<?php
																echo '<a href="formSolicitaFactura.php?Proceso=4&RutCli='.$rowdSol['RutCli'].'&nSolicitud='.$rowdSol['nSolicitud'].'&nItems='.$rowdSol['nItems'].'"><img src="../gastos/imagenes/delete_32.png" width="32" height="32" title="Eliminar Items">	</a>';
															?>
														</td>
													</tr>
													<?php
												}while ($rowdSol=mysqli_fetch_array($bddSol));
											}
											$link->close();
											?>
											<tr>
												<td  height="30" align="center">
													<?php 
														$nItems++;
														echo $nItems;
														$Cantidad 		= 0;
														$Especificacion = "";
														$valorUnitarioUF= 0;
														$valorTotalUF	= 0;
														$valorUnitario	= 0;
														$valorTotal		= 0;
													?>
													<input name="nItems" 	type="hidden" id="nItems" value="<?php echo $nItems;?>" size="3" maxlength="3">
												</td>
												<td  height="30" align="center">
													<input name="Cantidad" tabindex="1"	type="text" id="Cantidad" value="<?php echo $Cantidad;?>" size="4" maxlength="4" ng-model="Cantidad" ng-init="Cantidad='<?php echo $Cantidad;?>'" autofocus />
												</td>
												<td>
													<input name="Especificacion" type="text" tabindex="2" id="Especificacion" value="<?php echo $Especificacion;?>" size="88" maxlength="88">
												</td>
												<td align="right">
													<?php if($tipoValor=='U'){ ?>
														<input name="valorUnitarioUF" tabindex="3"	type="text" id="valorUnitarioUF" value="<?php echo $valorUnitarioUF;?>" size="10" maxlength="10"></td>
													<?php }else{?>
														<input name="valorUnitario" tabindex="3"	type="text" id="valorUnitario" ng_model="valorUnitario" ng-init="valorUnitario='<?php echo $valorUnitario;?>'" value="<?php echo $valorUnitario;?>" size="10" maxlength="10"></td>
													<?php } ?>
												<td align="right">

        <li>Number 1: <input type="hidden" ng-model="one">  
        <li>Number 2: <input type="hidden" ng-model="two">
        <li>Number 2: <input type="text" ng-model="vt" ng-init="vt='{{total}}'">
        <li>Total <input type="hidden" value="{{total()}}">       


													<?php if($tipoValor=='U'){?>
														<input name="valorTotalUF" tabindex="4"	type="text" id="valorTotalUF" value="<?php echo $valorTotalUF;?>" size="10" maxlength="10">
													<?php }else{?>
														Tot <input type="text" ng-model="valorTotal" ng-Init="valorTotal='{{total}}'"> Tot 
													<?php } ?>
												</td>
												<td width="2%" align="center">
												Excepción
												<?php
												if($Excepcion=='on'){
													echo '<input name="Excepcion" type="checkbox" checked>';
												}else{
													echo '<input name="Excepcion" type="checkbox">';
												}
												?>
												
													<?php
													//echo '<a href="registrafacturas.php?Proceso=2&RutProv='.$row['RutProv'].'&nFactura='.$row['nFactura'].'&Periodo='.$row['PeriodoPago'].'"><img src="../gastos/imagenes/corel_draw_128.png"   	width="32" height="32" title="Editar Items"></a>&nbsp;';
													//echo '<a href="registrafacturas.php?Proceso=3&RutProv='.$row['RutProv'].'&nFactura='.$row['nFactura'].'&Periodo='.$row['PeriodoPago'].'"><img src="../gastos/imagenes/delete_32.png" 			width="32" height="32" title="Eliminar">	</a>';
													?>
												</td>
											</tr>
											<tr>
											  <td  height="30" colspan="2" align="right">Informe(s) AM </td>
											  <td><textarea name="informesAM" rows="5" cols="100"><?php echo $informesAM; ?></textarea>
											  </td>
											  <td align="right">MONTO NETO </td>
											  <td align="right">
													Redondear
													<?php
														if($Redondear=='on'){
															echo '<input name="Redondear" type="checkbox" checked title="Redondeado" id="Redondear">';
														}else{
															echo '<input name="Redondear" type="checkbox" title="Sin Redondear" id="Redondear">';
														}
														$colorValor = '';
														if($Excepcion == 'on'){
															$colorValor = "background-color:#DC143C; color:#fff;";
														}
													?>
													<?php if($tipoValor=='U'){?>
														<input name="netoUF" 	tabindex="5" 	type="text" id="netoUF" value="<?php echo $netoUF; ?>" size="10" maxlength="10">
													<?php }else{ ?>
														<input name="Neto" style="<?php echo $colorValor; ?>" 		tabindex="5"	type="text" id="Neto" value="<?php echo $Neto; ?>" size="10" maxlength="10">
													<?php } ?>
											  </td>
												<td width="17%" rowspan="3" align="center">
													<div id="ImagenBarra" style="float:none; display:inline;">
														<a href="formularios/iFormulario4.php?nSolicitud=<?php echo $nSolicitud;?>" title="Imprimir Formulario N° 4">
															<img src="../gastos/imagenes/printer_128_hot.png">
														</a>
													</div>
												</td>
											</tr>
											<tr>
												<td  height="30" colspan="2" align="right">Cotización(es) CAM </td>
												<td><textarea name="cotizacionesCAM" rows="5" cols="100"><?php echo $cotizacionesCAM; ?></textarea>
												</td>
												<td align="right">IVA</td>
												<td align="right">
													<?php if($tipoValor=='U'){?>
														<input name="ivaUF" tabindex="6" 	type="text" id="ivaUF" value="<?php echo $ivaUF; ?>" size="10" maxlength="10">
													<?php }else{ ?>
														<input name="Iva" style="<?php echo $colorValor; ?>" 	tabindex="6"	type="text" id="Iva" value="<?php echo $Iva; ?>" size="10" maxlength="10">
													<?php } ?>
												</td>
											</tr>
											<tr>
											  <td  height="30" colspan="3" valign="top">
											  <br>
											  </td>
											  <td width="11%" align="right">TOTAL</td>
												<td width="18%" align="right">
													<?php if($tipoValor=='U'){?>
														<input name="brutoUF" 	tabindex="7"	type="text" id="brutoUF" value="<?php echo $brutoUF; ?>" size="10" maxlength="10">
													<?php }else{ ?>
														<input name="Bruto" style="<?php echo $colorValor; ?>" 	tabindex="7"	type="text" id="Bruto" value="<?php echo $Bruto; ?>" size="10" maxlength="10">
													<?php } ?>
											  </td>
											</tr>
											<tr>
												<td height="30" colspan="6">
													Observaciones:<br>
													<textarea class="form-control" onchange="myFunction()" name="Observa" id="Observa" cols="110" rows="5"><?php echo $Observa; ?></textarea>
													<!--
													<textarea name="Observa" id="editor" cols="110" rows="5"><?php echo $Observa; ?></textarea> -->
												</td>
											</tr>
											</tbody>
										</table>
										<?php 
									}
								}
								?>
									</div>
									<div class="card-footer bg-secondary text-white">
									<button name="GuardarFacturacion" class="btn btn-primary"  style="float:right; ">
										Grabar
									</button>										
									</div>
								</div>
							</div>







						</div>
					</div>
				</div>



		</form>

		<script>
			initSample();
		</script>
