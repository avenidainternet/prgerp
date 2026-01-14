			<table width="80%" align="center"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax" style="margin-top:10px;">
				<tr>
				  	<td colspan="4" class="lineaDerBot" align="center">
					  	<strong style=" font-size:20px; font-weight:700; margin-left:10px;">
							Formulario Verificación de equipo "<?php echo $nomEquipo; ?>"
							<input name="codigo" 				id="codigo" 			type="hidden" value="<?php echo $codigo; 			?>">
							<input name="accion" 				id="accion" 			type="hidden" value="<?php echo $accion; 			?>">
							<input name="fechaVerificacion"		id="fechaVerificacion"	type="hidden" value="<?php echo $fechaVerificacion; ?>">
						</strong>										
					</td>
			  	</tr>
				<tr>
					<td width="20%">Número de Formulario																			</td>
					<td>
						<input name="nFormVD" type="text" size="5" value="<?php echo $nFormVD; ?>">		
					</td>
				</tr>
				<tr>
					<td width="20%">Fecha verificación																				</td>
					<td>
						<input name="fechaVerificacion" type="date" value="<?php echo $fechaVerificacion; ?>">	
					</td>
				</tr>
				<tr>
					<td width="20%">Nombre del responsable											    							</td>
					<td><?php echo $usrResponsable; ?>																				</td>
				</tr>
				<tr>
					<td colspan="4" class="lineaDerBot">Si se usa material de referencia secundario debe considerar lo siguiente: 	</td>
				</tr>
				<tr>
					<td colspan="4" class="lineaDerBot"><b>Rango bajo (20-35 HRC)</b>												</td>
				</tr>
				<tr>
					<td width="20%">Material de referencia secundario utilizado (código)					    					</td>
					<td class="lineaDer" colspan="3">
						<input name="MaterialRef_SRB20" type="text" size="20" value="<?php echo $MaterialRef_SRB20; ?>">		
					</td>
				</tr>
				<tr>
					<td width="20%">Dureza del material de referencia					    										</td>
					<td class="lineaDer" colspan="3">
						<input name="DurezaMaterial_SRB20" type="text" size="5" value="<?php echo $DurezaMaterial_SRB20; ?>">		
					</td>
				</tr>
				<tr>
					<td width="20%">Incertidumbre del material de referencia			    										</td>
					<td class="lineaDer" colspan="3">
						<input name="IncertidumbreMaterial_SRB20" type="text" size="5" value="<?php echo $IncertidumbreMaterial_SRB20; ?>">		
					</td>
				</tr>
				
				<tr>
					<td colspan="4" class="lineaTop"><b>Rango medio (36-50 HRC)</b>												</td>
				</tr>
				<tr>
					<td width="20%">Material de referencia secundario utilizado (código)					    					</td>
					<td class="lineaDer" colspan="3">
						<input name="MaterialRef_SRM36" type="text" size="20" value="<?php echo $MaterialRef_SRM36; ?>">		
					</td>
				</tr>
				<tr>
					<td width="20%">Dureza del material de referencia					    										</td>
					<td class="lineaDer" colspan="3">
						<input name="DurezaMaterial_SRM36" type="text" size="5" value="<?php echo $DurezaMaterial_SRM36; ?>">		
					</td>
				</tr>
				<tr>
					<td width="20%">Incertidumbre del material de referencia			    										</td>
					<td class="lineaDer" colspan="3">
						<input name="IncertidumbreMaterial_SRM36" type="text" size="5" value="<?php echo $IncertidumbreMaterial_SRM36; ?>">		
					</td>
				</tr>

				<tr>
					<td colspan="4" class="lineaTop"><b>Rango alto (51-68 HRC)</b>												</td>
				</tr>
				<tr>
					<td width="20%">Material de referencia secundario utilizado (código)					    					</td>
					<td class="lineaDer" colspan="3">
						<input name="MaterialRef_SRA51" type="text" size="20" value="<?php echo $MaterialRef_SRA51; ?>">		
					</td>
				</tr>
				<tr>
					<td width="20%">Dureza del material de referencia					    										</td>
					<td class="lineaDer" colspan="3">
						<input name="DurezaMaterial_SRA51" type="text" size="5" value="<?php echo $DurezaMaterial_SRA51; ?>">		
					</td>
				</tr>
				<tr>
					<td width="20%">Incertidumbre del material de referencia			    										</td>
					<td class="lineaDer" colspan="3">
						<input name="IncertidumbreMaterial_SRA51" type="text" size="5" value="<?php echo $IncertidumbreMaterial_SRA51; ?>">		
					</td>
				</tr>
				
				<tr>
					<td colspan="4" class="lineaDerBot">
						<hr>
						<b>Si se usa material de referencia primario debe considerar lo siguiente:</b>
					</td>
				</tr>
				<tr>
					<td colspan="4" class="lineaDerBot"><b>Rango bajo (20-35 HRC)</b>												</td>
				</tr>
				<tr>
					<td width="20%">Dureza del material de referencia					    										</td>
					<td class="lineaDer" colspan="3">
						<input name="DurezaMaterial_PRB20" type="text" size="5" value="<?php echo $DurezaMaterial_PRB20; ?>">		
					</td>
				</tr>
				<tr>
					<td width="20%">Error del material de referencia			    										</td>
					<td class="lineaDer" colspan="3">
						<input name="ErrorMaterial_PRB20" type="text" size="5" value="<?php echo $ErrorMaterial_PRB20; ?>">		
					</td>
				</tr>
				
				<tr>
					<td colspan="4" class="lineaTop"><b>Rango medio (36-50 HRC)</b>												</td>
				</tr>
				<tr>
					<td width="20%">Dureza del material de referencia					    										</td>
					<td class="lineaDer"  colspan="3">
						<input name="DurezaMaterial_PRM36" type="text" size="5" value="<?php echo $DurezaMaterial_PRM36; ?>">		
					</td>
				</tr>
				<tr>
					<td width="20%">Error del material de referencia			    										</td>
					<td class="lineaDer" colspan="3">
						<input name="ErrorMaterial_PRM36" type="text" size="5" value="<?php echo $ErrorMaterial_PRM36; ?>">		
					</td>
				</tr>

				<tr>
					<td colspan="4" class="lineaTop"><b>Rango alto (51-68 HRC)</b>												</td>
				</tr>
				<tr>
					<td width="20%">Dureza del material de referencia					    										</td>
					<td class="lineaDer" colspan="3">
						<input name="DurezaMaterial_PRA51" type="text" size="5" value="<?php echo $DurezaMaterial_PRA51; ?>">		
					</td>
				</tr>
				<tr>
					<td width="20%">Error del material de referencia			    										</td>
					<td class="lineaDer" colspan="3">
						<input name="ErrorMaterial_PRA51" type="text" size="5" value="<?php echo $ErrorMaterial_PRA51; ?>">		
					</td>
				</tr>

				
				
				<tr>
					<td colspan="4" class="lineaDerBot">
						<hr>
						<b>Resultados</b>
					</td>
				</tr>
				<tr>
					<td colspan="4" class="lineaDerBot"><b>Rango bajo (20-35 HRC)</b>												</td>
				</tr>
				<tr>
					<td colspan="4" class="lineaDerBot">
						Dureza 1:
					</td>
				</tr>
				<tr>
					<td width="20%">Indentación 1			    										</td>
					<td>
						<input name="Indentacion1_BD120" type="text" size="5" value="<?php echo $Indentacion1_BD120; ?>">		
					</td>
					<td width="20%">Error			    										</td>
					<td>
						<input name="Error1_BD120" type="text" size="5" value="<?php echo $Error1_BD120; ?>">		
					</td>
				</tr>
				<tr>
					<td width="20%">Indentación 2			    										</td>
					<td>
						<input name="Indentacion2_BD120" type="text" size="5" value="<?php echo $Indentacion2_BD120; ?>">		
					</td>
					<td width="20%">Repetitividad			    										</td>
					<td>
						<input name="Repetitividad1_BD120" type="text" size="5" value="<?php echo $Repetitividad1_BD120; ?>">		
					</td>
				</tr>
				<tr>
					<td width="20%">Indentación 3			    										</td>
					<td colspan="3">
						<input name="Indentacion3_BD120" type="text" size="5" value="<?php echo $Indentacion3_BD120; ?>">		
					</td>
				</tr>

				<tr>
					<td colspan="4" class="lineaDerBot">
						<b>Dureza 2</b>
					</td>
				</tr>

				<tr>
					<td width="20%">Indentación 1			    										</td>
					<td>
						<input name="Indentacion1_BD220" type="text" size="5" value="<?php echo $Indentacion1_BD220; ?>">		
					</td>
					<td width="20%">Error			    										</td>
					<td>
						<input name="Error1_BD220" type="text" size="5" value="<?php echo $Error1_BD220; ?>">		
					</td>
				</tr>
				<tr>
					<td width="20%">Indentación 2			    										</td>
					<td>
						<input name="Indentacion2_BD220" type="text" size="5" value="<?php echo $Indentacion2_BD220; ?>">		
					</td>
					<td width="20%">Repetitividad			    										</td>
					<td>
						<input name="Repetitividad1_BD220" type="text" size="5" value="<?php echo $Repetitividad1_BD220; ?>">		
					</td>
				</tr>
				<tr>
					<td width="20%">Indentación 3			    										</td>
					<td colspan="3">
						<input name="Indentacion3_BD220" type="text" size="5" value="<?php echo $Indentacion3_BD220; ?>">		
					</td>
				</tr>

				<tr>
					<td colspan="4" class="lineaDerBot">
						<b>Dureza 3</b>
					</td>
				</tr>

				<tr>
					<td width="20%">Indentación 1			    										</td>
					<td>
						<input name="Indentacion1_BD320" type="text" size="5" value="<?php echo $Indentacion1_BD320; ?>">		
					</td>
					<td width="20%">Error			    										</td>
					<td>
						<input name="Error1_BD320" type="text" size="5" value="<?php echo $Error1_BD320; ?>">		
					</td>
				</tr>
				<tr>
					<td width="20%">Indentación 2			    										</td>
					<td>
						<input name="Indentacion2_BD320" type="text" size="5" value="<?php echo $Indentacion2_BD320; ?>">		
					</td>
					<td width="20%">Repetitividad			    										</td>
					<td>
						<input name="Repetitividad1_BD320" type="text" size="5" value="<?php echo $Repetitividad1_BD320; ?>">		
					</td>
				</tr>
				<tr>
					<td width="20%">Indentación 3			    										</td>
					<td colspan="3">
						<input name="Indentacion3_BD320" type="text" size="5" value="<?php echo $Indentacion3_BD320; ?>">		
					</td>
				</tr>



				<tr>
					<td colspan="4" class="lineaDerBot"><b>Rango medio (36-50 HRC)</b>												</td>
				</tr>
				<tr>
					<td colspan="4" class="lineaDerBot">
						Dureza 1:
					</td>
				</tr>
				<tr>
					<td width="20%">Indentación 1			    										</td>
					<td>
						<input name="Indentacion1_MD136" type="text" size="5" value="<?php echo $Indentacion1_MD136; ?>">		
					</td>
					<td width="20%">Error			    										</td>
					<td>
						<input name="Error1_MD136" type="text" size="5" value="<?php echo $Error1_MD136; ?>">		
					</td>
				</tr>
				<tr>
					<td width="20%">Indentación 2			    										</td>
					<td>
						<input name="Indentacion2_MD136" type="text" size="5" value="<?php echo $Indentacion2_MD136; ?>">		
					</td>
					<td width="20%">Repetitividad			    										</td>
					<td>
						<input name="Repetitividad1_MD136" type="text" size="5" value="<?php echo $Repetitividad1_MD136; ?>">		
					</td>
				</tr>
				<tr>
					<td width="20%">Indentación 3			    										</td>
					<td colspan="3">
						<input name="Indentacion3_MD136" type="text" size="5" value="<?php echo $Indentacion3_MD136; ?>">		
					</td>
				</tr>

				<tr>
					<td colspan="4" class="lineaDerBot">
						<b>Dureza 2</b>
					</td>
				</tr>

				<tr>
					<td width="20%">Indentación 1			    										</td>
					<td>
						<input name="Indentacion1_MD236" type="text" size="5" value="<?php echo $Indentacion1_MD236; ?>">		
					</td>
					<td width="20%">Error			    										</td>
					<td>
						<input name="Error1_MD236" type="text" size="5" value="<?php echo $Error1_MD236; ?>">		
					</td>
				</tr>
				<tr>
					<td width="20%">Indentación 2			    										</td>
					<td>
						<input name="Indentacion2_MD236" type="text" size="5" value="<?php echo $Indentacion2_MD236; ?>">		
					</td>
					<td width="20%">Repetitividad			    										</td>
					<td>
						<input name="Repetitividad1_MD236" type="text" size="5" value="<?php echo $Repetitividad1_MD236; ?>">		
					</td>
				</tr>
				<tr>
					<td width="20%">Indentación 3			    										</td>
					<td colspan="3">
						<input name="Indentacion3_MD236" type="text" size="5" value="<?php echo $Indentacion3_MD236; ?>">		
					</td>
				</tr>

				<tr>
					<td colspan="4" class="lineaDerBot">
						<b>Dureza 3</b>
					</td>
				</tr>

				<tr>
					<td width="20%">Indentación 1			    										</td>
					<td>
						<input name="Indentacion1_MD336" type="text" size="5" value="<?php echo $Indentacion1_MD336; ?>">		
					</td>
					<td width="20%">Error			    										</td>
					<td>
						<input name="Error1_MD336" type="text" size="5" value="<?php echo $Error1_MD336; ?>">		
					</td>
				</tr>
				<tr>
					<td width="20%">Indentación 2			    										</td>
					<td>
						<input name="Indentacion2_MD336" type="text" size="5" value="<?php echo $Indentacion2_MD336; ?>">		
					</td>
					<td width="20%">Repetitividad			    										</td>
					<td>
						<input name="Repetitividad1_MD336" type="text" size="5" value="<?php echo $Repetitividad1_MD336; ?>">		
					</td>
				</tr>
				<tr>
					<td width="20%">Indentación 3			    										</td>
					<td colspan="3">
						<input name="Indentacion3_MD336" type="text" size="5" value="<?php echo $Indentacion3_MD336; ?>">		
					</td>
				</tr>

				
				
				
				<tr>
					<td colspan="4" class="lineaDerBot"><b>Rango alto (51-68 HRC)</b>												</td>
				</tr>
				<tr>
					<td colspan="4" class="lineaDerBot">
						Dureza 1:
					</td>
				</tr>
				<tr>
					<td width="20%">Indentación 1			    										</td>
					<td>
						<input name="Indentacion1_AD151" type="text" size="5" value="<?php echo $Indentacion1_AD151; ?>">		
					</td>
					<td width="20%">Error			    										</td>
					<td>
						<input name="Error1_AD151" type="text" size="5" value="<?php echo $Error1_AD151; ?>">		
					</td>
				</tr>
				<tr>
					<td width="20%">Indentación 2			    										</td>
					<td>
						<input name="Indentacion2_AD151" type="text" size="5" value="<?php echo $Indentacion2_AD151; ?>">		
					</td>
					<td width="20%">Repetitividad			    										</td>
					<td>
						<input name="Repetitividad1_AD151" type="text" size="5" value="<?php echo $Repetitividad1_AD151; ?>">		
					</td>
				</tr>
				<tr>
					<td width="20%">Indentación 3			    										</td>
					<td colspan="3">
						<input name="Indentacion3_AD151" type="text" size="5" value="<?php echo $Indentacion3_AD151; ?>">		
					</td>
				</tr>

				<tr>
					<td colspan="4" class="lineaDerBot">
						<b>Dureza 2</b>
					</td>
				</tr>

				<tr>
					<td width="20%">Indentación 1			    										</td>
					<td>
						<input name="Indentacion1_AD251" type="text" size="5" value="<?php echo $Indentacion1_AD251; ?>">		
					</td>
					<td width="20%">Error			    										</td>
					<td>
						<input name="Error1_AD251" type="text" size="5" value="<?php echo $Error1_AD251; ?>">		
					</td>
				</tr>
				<tr>
					<td width="20%">Indentación 2			    										</td>
					<td>
						<input name="Indentacion2_AD251" type="text" size="5" value="<?php echo $Indentacion2_AD251; ?>">		
					</td>
					<td width="20%">Repetitividad			    										</td>
					<td>
						<input name="Repetitividad1_AD251" type="text" size="5" value="<?php echo $Repetitividad1_AD251; ?>">		
					</td>
				</tr>
				<tr>
					<td width="20%">Indentación 3			    										</td>
					<td colspan="3">
						<input name="Indentacion3_AD251" type="text" size="5" value="<?php echo $Indentacion3_AD251; ?>">		
					</td>
				</tr>

				<tr>
					<td colspan="4" class="lineaDerBot">
						<b>Dureza 3</b>
					</td>
				</tr>

				<tr>
					<td width="20%">Indentación 1			    										</td>
					<td>
						<input name="Indentacion1_AD351" type="text" size="5" value="<?php echo $Indentacion1_AD351; ?>">		
					</td>
					<td width="20%">Error			    										</td>
					<td>
						<input name="Error1_AD351" type="text" size="5" value="<?php echo $Error1_AD351; ?>">		
					</td>
				</tr>
				<tr>
					<td width="20%">Indentación 2			    										</td>
					<td>
						<input name="Indentacion2_AD351" type="text" size="5" value="<?php echo $Indentacion2_AD351; ?>">		
					</td>
					<td width="20%">Repetitividad			    										</td>
					<td>
						<input name="Repetitividad1_AD351" type="text" size="5" value="<?php echo $Repetitividad1_AD351; ?>">		
					</td>
				</tr>
				<tr>
					<td width="20%">Indentación 3			    										</td>
					<td colspan="3">
						<input name="Indentacion3_AD351" type="text" size="5" value="<?php echo $Indentacion3_AD351; ?>">		
					</td>
				</tr>


				<tr>
					<td width="20%">Observaciones			    										</td>
					<td colspan="3">
						<textarea name="Observaciones" rows="5" cols="100"><?php echo $Observaciones; ?></textarea>
					</td>
				</tr>

				<tr>
					<td width="20%">Cumple			    										</td>
					<td colspan="3">
						<?php if($Cumple == 'on'){?>
							Cumple <input name="Cumple" type="radio" value="on" checked>
						<?php }else{?>
							Cumple <input name="Cumple" type="radio" value="on">
						<?php } ?>
						<?php if($Cumple == 'off'){?>
							No Cumple <input name="Cumple" type="radio" value="off" checked>
						<?php }else{?>
							No Cumple <input name="Cumple" type="radio" value="off">
						<?php } ?>
					</td>
				</tr>
				

				
			</table>
