	<div id="cajaRegistraPruebas">
		<center>
		<form name="form" action="plataformaActividades.php" method="post">
			<table width="99%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
				<tr>
					<td colspan="4" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
						<img src="../imagenes/poster_teachers.png" width="50" align="middle">
						<span style="color:#FFFFFF; font-size:25px; font-weight:700;">
							Programaci&oacute;n de Actividad 
							<div id="botonImagen">
								<?php 
									if($accion=='Vacio'){
										$prgLink = '../plataformaErp.php';
										$accion = 'Agrega';
									}else{
										$prgLink = 'plataformaActividades.php';
									}
									echo '<a href="'.$prgLink.'" style="float:right;"><img src="../imagenes/no_32.png"></a>';
								?>
							</div>
						</span>
					</td>
				</tr>
				<tr>
				  	<td colspan="4" class="lineaDerBot">
					  	<strong style=" font-size:20px; font-weight:700; margin-left:10px;">
							Actividad N° 
							<?php
								if($accion == 'Actualizar' or $accion == 'Borrar'){ 
									echo $idActividad;?>
									<input name="idActividad" 	id="idActividad" type="hidden" value="<?php echo $idActividad; ?>" size="7" maxlength="7" style="font-size:18px; font-weight:700;" />
									<?php
								}
								if($accion == 'Agrega'){ 
									?>
									<input name="idActividad" 	id="idActividad" type="text" value="<?php echo $idActividad; ?>" size="20" maxlength="20" style="font-size:18px; font-weight:700;" autofocus />
									<?php
								}
							?>
							<input name="accion" 				id="accion" 			type="hidden" value="<?php echo $accion; ?>">
						</strong>										
					</td>
			  	</tr>
				<tr>
					<td colspan="4">Identificar Actividad </td>
			  </tr>
				<tr>
					<td width="19%" rowspan="5" class="lineaDerBot">
						<textarea name="Actividad" id="Actividad" cols="50" rows="5"><?php echo $Actividad; ?></textarea>
					</td>
					<td valign="top" class="lineaDerBot"><span class="lineaDer">Actividad <br>
					  Repetitiva </span>
					</td>
				    <td valign="top" class="lineaDerBot"><span class="lineaDer">Actividad <br>
				      Acreditaci&oacute;n</span>
					</td>
				    <td valign="top" class="lineaDerBot"><span class="lineaDer">Responzable <br>
				      Actividad</span>
					</td>
		      	</tr>
				<tr>
				  <td valign="top" class="lineaDerBot"><?php
							if($actRepetitiva=='on'){?>
                    <input type="checkbox" name="actRepetitiva" id="actRepetitiva" checked>
                    <?php }else{ ?>
                    <input type="checkbox" name="actRepetitiva" id="actRepetitiva">
                    <?php } ?></td>
			      <td valign="top" class="lineaDerBot"><?php
							if($Acreditado=='on'){?>
                    <input type="checkbox" name="Acreditado" id="Acreditado" checked>
                    <?php }else{ ?>
                    <input type="checkbox" name="Acreditado" id="actRepetitiva">
                    <?php } ?></td>
			      <td valign="top" class="lineaDerBot"><select name="usrResponsable" id="usrResponsable" style="font-size:12px; font-weight:700;">
                    <option></option>
                    <?php
								$link=Conectarse();
								$bdCli=mysql_query("SELECT * FROM Usuarios Order By usuario");
								if($rowCli=mysql_fetch_array($bdCli)){
									do{
										$loginRes = $rowCli[usr];
										if($usrResponsable == $loginRes){
											echo '<option selected 	value='.$rowCli[usr].'>'.$rowCli[usuario].'</option>';
										}else{
											echo '<option 			value='.$rowCli[usr].'>'.$rowCli[usuario].'</option>';
										}
									}while ($rowCli=mysql_fetch_array($bdCli));
								}
								mysql_close($link);
								?>
                  </select></td>
			  </tr>
				<tr>
				  <td valign="top" class="lineaDer">&nbsp;</td>
			      <td valign="top" class="lineaDer">&nbsp;</td>
			      <td valign="top" class="lineaDer">&nbsp;</td>
			  </tr>
				<tr>
				  <td valign="top" class="lineaDer">&nbsp;</td>
			      <td valign="top" class="lineaDer">&nbsp;</td>
			      <td valign="top" class="lineaDer">&nbsp;</td>
			  </tr>
				<tr>
				  <td valign="top" class="lineaDer">&nbsp;</td>
			      <td valign="top" class="lineaDer">&nbsp;</td>
			      <td valign="top" class="lineaDer">&nbsp;</td>
			  </tr>
				<tr>
			  	<td colspan="4" class="lineaDerBot">
			  		
					<table cellpadding="0" cellspacing="0" width="100%" style="border: 1px solid #000;">
						<tr height="30" bgcolor="#0099CC" style="color:#000000; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px; font-weight:700;">
							<td colspan="4">
								Programaci&oacute;n Actividad</td>
						</tr>
						<tr>
							<td class="lineaDerBot">Fecha Programaci&oacute;n Actividad </td>
							<td class="lineaDerBot">Pr&oacute;xima  (D&iacute;as) </td>
							<td class="lineaDerBot">Avisar (D&iacute;as) </td>
							<td class="lineaDerBot">Fecha Ejecuci&oacute;n Actividad </td>
				      	</tr>
						<tr>
							<td class="lineaDerBot">
						    	<input name="prgActividad" id="prgActividad" type="date" value="<?php echo $prgActividad; ?>" style="font-size:12px; font-weight:700;" />
							</td>
						  	<td class="lineaDerBot">
						    	<input name="tpoProx" id="tpoProx" type="text" size="3" maxlength="3" value="<?php echo $tpoProx; ?>" style="font-size:12px; font-weight:700;" />
						  	</td>
						  	<td class="lineaDerBot">
								<input name="tpoAvisoAct" id="tpoAvisoAct" type="text" size="3" maxlength="3" value="<?php echo $tpoAvisoAct; ?>" style="font-size:12px; font-weight:700;" />
							</td>
						  	<td class="lineaDerBot">
						    	<input name="fechaProxAct" id="fechaProxAct" type="date" value="<?php echo $fechaProxAct; ?>" style="font-size:12px; font-weight:700;" />
						  	</td>
					  	</tr>

					</table>
			  </td>
		  </tr>
		  <tr>
				<td colspan="4" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px; ">
					<?php
						echo $accion;
						if($accion == 'Guardar' || $accion == 'Agrega' || $accion == 'Actualizar'){?>
							<div id="botonImagen">
								<button name="guardarActividad" style="float:right;" title="Guardar Actividad">
									<img src="../gastos/imagenes/guardar.png" width="55" height="55">
								</button>
							</div>
							<?php
						}
						if($accion == 'Borrar'){?>
							<button name="confirmarBorrar" style="float:right;">
								<img src="../gastos/imagenes/inspektion.png" width="55" height="55">
							</button>
							<?php
						}
					?>
				</td>
		  </tr>
		</table>
		</form>
		</center>
	</div>
