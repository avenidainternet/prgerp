	<div id="Cuerpo">
		<form action="datosEmpresa.php" method="post" enctype="multipart/form-data">

		<div id="CajaCpo">
			<!-- Fin Caja Cuerpo -->
			<?php
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo" style="margin:5px 5px 0px 5px;">';
				echo '		<tr height="50">';
				echo '			<td style="padding:10px;"><strong style="font-size:24px;">Ficha Institución</strong>';?>
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
				echo '			<td>Inicio Funciones: </td>';
				echo '			<td>';
				echo '				<input name="fechaInicio" 	type="date" value="'.$fechaInicio.'" placeholder="Cargo...">';
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
?>

				<div class="card m-2">
    				<div class="card-header" ng-init="cargarDatosSupervisor()">
						<h4>Datos del Supervisor</h4>
					</div>
    				<div class="card-body">

						<div class="row m-2">
							<div class="col-sm-2">
								RUT Supervisor:
							</div>
							<div class="col-sm-2">
								<input type="text" class="form-control" id="rutSuper" ng-model="rutSuper" maxlength="13">
							</div>
							<div class="col-sm-8">
								<div class="alert alert-danger" ng-show="errorSupervisor">
    								<strong>Precaución!</strong> No existen datos ingresados para el Supervisor...
  								</div>
							</div>
						</div>
						<div class="row m-2">
							<div class="col-sm-2">
								Nombre Supervisor:
							</div>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="nombreSuper" ng-model="nombreSuper">
							</div>
						</div>
						<div class="row m-2">
							<div class="col-sm-2">
								Cargo Supervisor:
							</div>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="cargoSuper" ng-model="cargoSuper">
							</div>
						</div>
						<div class="row m-2">
							<div class="col-sm-2">
								Firma Supervisor:
							</div>
							<div class="col-sm-8">
								<input type="hidden" name="MAX_FILE_SIZE" value="1024000"> 
								<input name="firmaSuper" type="file" id="firmaSuper" />
							</div>
						</div>
						
					</div>
					<div class="card-footer">
						<button type="button" class="btn btn-primary" ng-click="grabarSupervisor()">Guardar Datos Supervisor</button>
					</div>

				</div>

				<div ng-repeat="x in dataProyectos">
					<div class="card m-2">
						<div class="card-header">
							<h4>Datos de Proyectos {{x.IdProyecto}} </h4>
						</div>
						<div class="card-body">

							<div class="row m-2">
								<div class="col-sm-2">
									Id Proyecto:
								</div>
								<div class="col-sm-2">
									<input type="text" class="form-control" id="IdProyecto" ng-model="IdProyecto" ng-value="x.IdProyecto">
								</div>
							</div>
							<div class="row m-2">
								<div class="col-sm-2">
									Descripción Proyecto:
								</div>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="Proyecto" ng-model="x.Proyecto" ng-value="x.Proyecto">
								</div>
							</div>
							<div class="row m-2">
								<div class="col-sm-2">
									RUT Jefe Proyecto:
								</div>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="Rut_JefeProyecto" ng-model="x.Rut_JefeProyecto" ng-value="x.Rut_JefeProyecto">
								</div>
							</div>
							<div class="row m-2">
								<div class="col-sm-2">
									Nombre Jefe Proyecto:
								</div>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="JefeProyecto" ng-model="x.JefeProyecto" ng-value="x.JefeProyecto">
								</div>
							</div>
							<div class="row m-2">
								<div class="col-sm-2">
									Correo:
								</div>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="Email" ng-model="x.Email" ng-value="x.Email">
								</div>
							</div>
							<div class="row m-2">
								<div class="col-sm-2">
									Banco:
								</div>
								<div class="col-sm-4">
									<input type="text" class="form-control" id="Banco" ng-model="x.Banco" ng-value="x.Banco">
								</div>
								<div class="col-sm-2">
									Cta. Corriente:
								</div>
								<div class="col-sm-4">
									<input type="text" class="form-control" id="Cta_Corriente" ng-model="x.Cta_Corriente" ng-value="x.Cta_Corriente">
								</div>
							</div>
							<div class="row m-2">
								<div class="col-sm-2">
									Firma Jefe Proyecto:
								</div>
								<div class="col-sm-8">
									<input type="hidden" name="MAX_FILE_SIZE" value="1024000"> 
									<input name="firmaJefe" type="file" id="firmaJefe" />
								</div>
							</div>
							
						</div>
						<div class="card-footer">
							<button type="button" class="btn btn-primary" ng-click="grabarProyecto(x.IdProyecto, x.Proyecto, x.Rut_JefeProyecto, x.JefeProyecto, x.Email, x.Banco, x.Cta_Corriente)">Guardar Datos Proyecto {{x.IdProyecto}}</button>
						</div>

					</div>
				</div>




<?php

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
