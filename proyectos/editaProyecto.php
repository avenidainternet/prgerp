	<br>
	<center>
		<form name="form" action="actualizaProyecto.php" method="post">
			<table width="99%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
				<tr>
					<td colspan="4" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
						<img src="../gastos/imagenes/centrotrabajo.png" width="50" align="middle">
						<span style="color:#FFFFFF; font-size:25px; font-weight:700;">
							Actualiza Proyecto <?php echo $IdProyecto; ?> 
							<div id="botonImagen">
								<?php 
									$prgLink = 'plataformaProyectos.php';
									echo '<a href="'.$prgLink.'" style="float:right;"><img src="../imagenes/no_32.png"></a>';
								?>
							</div>
						</span>
					</td>
				</tr>
				<tr>
				  	<td colspan="4" class="lineaDerBot">
						<input name="IdProyecto" 	id="IdProyecto" type="hidden" value="<?php echo $IdProyecto; ?>" />
						<input name="accion" 		id="accion" 	type="hidden" value="<?php echo $accion; ?>"	 />
					</td>
			  	</tr>
				<tr>
					<td>Identificar Proyecto </td>
			        <td><span class="lineaDerBot"><span class="lineaDer">RUN</span> </span></td>
			        <td><span class="lineaDerBot"><span class="lineaDer">Jefe Proyecto</span></span></td>
			        <td><span class="lineaDerBot">Email</span></td>
			  </tr>
				<tr>
					<td width="19%" class="lineaDerBot">
						<textarea name="Proyecto" id="Proyecto" cols="50" rows="5" required><?php echo $Proyecto; ?></textarea>
					</td>
					<td valign="top" class="lineaDerBot">
						<textarea name="Rut_JefeProyecto" id="Rut_JefeProyecto" cols="12" rows="5" required><?php echo $Rut_JefeProyecto; ?></textarea>
					</td>
				    <td valign="top" class="lineaDerBot">
						<textarea name="JefeProyecto" id="JefeProyecto" cols="25" rows="5" required><?php echo $JefeProyecto; ?></textarea>
					</td>
				    <td valign="top" class="lineaDerBot">
						<textarea name="Email" id="Email" cols="30" rows="5" required><?php echo $Email; ?></textarea>
					</td>
		      	</tr>
				<tr>
			  	<td colspan="4" class="lineaDerBot">
			  		
					<table cellpadding="0" cellspacing="0" width="100%" style="border: 1px solid #000;">
						<tr height="30" bgcolor="#0099CC" style="color:#000000; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px; font-weight:700;">
							<td colspan="2">
								Bancos</td>
						</tr>
						<tr>
							<td class="lineaDerBot">Cuenta Corriente </td>
							<td class="lineaDerBot">Banco</td>
				      	</tr>
						<tr>
							<td class="lineaDerBot">
						    	<input name="Cta_Corriente" id="Cta_Corriente" value="<?php echo $Cta_Corriente; ?>" style="font-size:12px; font-weight:700;" requiered />
							</td>
						  	<td class="lineaDerBot">
						    	<input name="Banco" id="Banco" value="<?php echo $Banco; ?>" style="font-size:12px; font-weight:700;" Reuiered />
						  	</td>
					  	</tr>
						<tr>
							<td class="lineaDerBot">
						    	<input name="Cta_Corriente2" id="Cta_Corriente2" value="<?php echo $Cta_Corriente2; ?>" style="font-size:12px; font-weight:700;" />
							</td>
						  	<td class="lineaDerBot">
						    	<input name="Banco2" id="Banco2" value="<?php echo $Banco2; ?>" style="font-size:12px; font-weight:700;" />
						  	</td>
					  	</tr>

					</table>
			  </td>
		  </tr>
		  <tr>
				<td colspan="4" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px; ">
					<?php
						echo $accion;
						if($accion == 'Agrega' or $accion == 'Actualizar'){?>
							<div id="botonImagen">
								<button name="guardarProyecto" style="float:right;" title="Guardar Proyecto">
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