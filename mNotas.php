	<div id="Cuerpo">
		<form name="form" action="datosNotas.php" method="post">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<img src="imagenes/desactivadoPdf.png" width="32" height="32" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					Notas Informes
				</strong>
			</div>
			<!-- Fin Caja Cuerpo -->
			<?php
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo" style="margin:5px 5px 0px 5px;">';
				echo '		<tr height="50">';
				echo '			<td style="padding:10px;"><strong style="font-size:24px;">Notas Informes</strong>';?>
									<button name="Guardar" style="float:right; ">
										<img src="imagenes/guardar.png" width="50" height="50">
									</button>
									<?php
				echo '			</td>';
				echo '		</tr>';
				echo '	</table>';

				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaDocumentos" style="font-size:18px;">';
				echo '		<tr>';
				echo '			<td width="20%">Rut: </td>';
				echo '			<td width="80%">';
									echo '<input name="RutEmp" 		type="text" size="10" maxlength="10" value="'.$RutEmp.'" readonly>';
									echo '<input name="Proceso"  	type="hidden" value="'.$Proceso.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Institución: </td>';
				echo '			<td>';
				echo '				<input name="NombreEmp" 	type="text" size="100" maxlength="100" value="'.$NombreEmp.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Dirección: </td>';
				echo '			<td>';
				echo '				<input name="Direccion" 	type="text" size="50" maxlength="50" value="'.$Direccion.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Comuna: </td>';
				echo '			<td>';
				echo '				<input name="Comuna" 	type="text" size="50" maxlength="50" value="'.$Comuna.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Banco: </td>';
				echo '			<td>';
				echo '				<input name="Banco" 	type="text" size="50" maxlength="50" value="'.$Banco.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Cuenta Corriente: </td>';
				echo '			<td>';
				echo '				<input name="CtaCte" 	type="text" size="50" maxlength="50" value="'.$CtaCte.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '	</table>';
				
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td><strong style="font-size:14px;">Departamento</strong></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaDocumentos">';
				echo '		<tr style="margin-top:10px;">';
				echo '			<td  width="20%">Departamento: </td>';
				echo '			<td  width="80%">';
				echo '				<input name="nDepartamento" 	type="text" size="10" maxlength="10" value="'.$nDepartamento.'" Readonly>';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Nombre Departamento: </td>';
				echo '			<td>';
				echo '				<input name="NomDpto" 	type="text" size="40" maxlength="40" value="'.$NomDpto.'" placeholder="Nombre del Departamento...">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>RUN Director Depto.: </td>';
				echo '			<td>';
				echo '				<input name="RutDirector" 	type="text" size="10" maxlength="10" value="'.$RutDirector.'" placeholder="RUN del Director del Departamento...">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Director: </td>';
				echo '			<td>';
				echo '				<input name="NomDirector" 	type="text" size="50" maxlength="50" value="'.$NomDirector.'" placeholder="Nombre del Director del Departamento...">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Cargo: </td>';
				echo '			<td>';
				echo '				<input name="Cargo" 	type="text" size="50" maxlength="50" value="'.$Cargo.'" placeholder="Cargo...">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Correo Departamento: </td>';
				echo '			<td>';
				echo '				<input name="EmailDepto" 	type="text" size="50" maxlength="50" value="'.$EmailDepto.'" placeholder="Correo del Departamento...">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Sub Director de Proyectos: </td>';
				echo '			<td>';
				echo '				<input name="SubDirectorProyectos" 	type="text" size="50" maxlength="50" value="'.$SubDirectorProyectos.'" placeholder="Sub-Director del Departamento...">';
				echo '			</td>';
				echo '		</tr>';
				echo '	</table>';

				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td><strong style="font-size:14px;">Datos Bancarios</strong></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaDocumentos">';
				echo '		<tr style="margin-top:10px;">';
				echo '			<td  width="20%">Cta.Cte. 			</td>';
				echo '			<td  width="30%">Banco 				</td>';
				echo '			<td  width="30%">Titular 			</td>';
				echo '			<td  width="20%">Rut <br>Titular 	</td>';
				echo '		</tr>';
				echo '	</table>';?>

				<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaDocumentos">
					<?php
					$nCuenta 	= "";
					$Banco		= "";
					$rutRitular	= "";
					$link=Conectarse();
					$bdObj=$link->query("SELECT * FROM ctasctescargo Order By aliasRecurso");
					if($rowObj=mysqli_fetch_array($bdObj)){
						do{
							$nCta 	= 'nCuenta-'.$rowObj['aliasRecurso'];
							$nBco	= 'Banco-'.$rowObj['aliasRecurso'];
							$rTit	= 'rutTitular-'.$rowObj['aliasRecurso'];
							$nTit	= 'nombreTitular-'.$rowObj['nombreTitular'];

							$nTit 	= $rowObj['nombreTitular'];
							if($nTit == ''){
								$bdRec=$link->query("SELECT * FROM proyectos Where Rut_JefeProyecto = '".$rowObj['rutTitular']."'");
								if($rowRec=mysqli_fetch_array($bdRec)){
									$rutTitular 	= $rowObj['rutTitular'];
									$JefeProyecto 	= $rowRec['JefeProyecto'];
									$actSQL="UPDATE ctasctescargo SET ";
									$actSQL.="nombreTitular		='".$JefeProyecto."'";
									$actSQL.="WHERE rutTitular 	= '".$rutTitular."'";
									$bdDp=$link->query($actSQL);
									$nTit	= 'nombreTitular-'.$rowRec['JefeProyecto'];
								}
							}else{
								$nTit	= 'nombreTitular-'.$rowObj['nombreTitular'];
							}
							
							?>
							<tr style="margin-top:10px;">
								<td  width="20%"><input name="<?php echo $nCta; ?>" size="15" maxlength="15" value="<?php echo $rowObj['nCuenta'];?>">			</td>
								<td  width="30%"><input name="<?php echo $nBco; ?>" size="15" maxlength="15" value="<?php echo $rowObj['Banco']; ?>">			</td>
								<td  width="30%"><input name="<?php echo $nTit; ?>" size="30" maxlength="30" value="<?php echo $rowObj['nombreTitular']; ?>">	</td>
								<td  width="20%"><input name="<?php echo $rTit; ?>" size="15" maxlength="15" value="<?php echo $rowObj['rutTitular']; ?>">		</td>
							</tr>
							<?php
						}while ($rowObj=mysqli_fetch_array($bdObj));
					}
					$link->close();?>
				</table>

		</div>
		</form>
	</div>
