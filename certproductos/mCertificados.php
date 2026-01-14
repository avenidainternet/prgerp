<?php
	session_start();
	$_SESSION['Grabado'] = "NO";
	$MsgUsr ="";	
	
	include_once("../conexionli.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		$link->close();
	}else{
		header("Location: index.php");
	}

	$CodCertificado = '';
	$accion = 'New';
	$ar = 'AR-';
	if(isset($_GET['CodCertificado'])){
		$CodCertificado = $_GET['CodCertificado'];
		$far = explode('-', $CodCertificado);
		$ar .= $far[1];
		if($CodCertificado){$accion = 'Old';}
		 
	}
	
?>
<!doctype html>
 
<html lang="es">
<head>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Mantención de Certificado</title>

	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<!-- <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css"> -->
	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<script type="text/javascript" src="../angular/angular.js"></script>


  	<script src="../bootstrap/js/jquery.slim.min.js"></script>
  	<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>






<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
input.mayusculas{text-transform:uppercase;}
</style>
</head>

<body ng-app="myApp" ng-controller="CtrlClientes" ng-init="loadDataCertificado('<?php echo $CodCertificado; ?>')">
	<?php include('head.php'); ?>
	<!-- Navigation -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-danger static-top">
		<div class="container-fluid">
  	    	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
	          <span class="navbar-toggler-icon"></span>
	        </button>
	    	<div class="collapse navbar-collapse" id="navbarResponsive">

				<a class="navbar-brand" href="#">
					<img src="../imagenes/simet.png" alt="logo" style="width:40px;">
				</a>
	      		<ul class="navbar-nav ml-auto">
	        		<li class="nav-item active">
	          			<a class="nav-link fa fa-home" href="../plataformaErp.php"> Principal
	                	<span class="sr-only">(current)</span>
	              		</a>
	        		</li>
	        		<li class="nav-item">
						<?php $arLink = '../certMAr/?ar='.$ar; ?>
	          			<a href="<?php echo $arLink;?>" class="nav-link fas fa-address-card"> Certificados</a>
	        		</li>

	        		<li class="nav-item">
	          			<a class="nav-link fas fa-address-card" href="../certTipoProductos/?CodCertificado=<?php echo $CodCertificado;?>"> Productos</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-address-card" href="../certAceros/?CodCertificado=<?php echo $CodCertificado;?>"> ºAceros</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-address-card" href="../certNormas/?CodCertificado=<?php echo $CodCertificado;?>"> Normas</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-address-card" href="#" ng-click="leerObservaciones()" data-toggle="modal" data-target="#admObservaciones"> 
							Observaciones
						</a>
	        		</li>



					
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="../cerrarsesion.php"> Cerrar</a>
	        		</li>

	      		</ul>
	    	</div>
	  	</div>
	</nav> 
	<div class="row bg-info text-white text-center" style="padding: 10px;">
		<div class="col-12">
			<h5>CERTIFICADO DE CONFORMIDAD</h5>
		</div>
		<div class="col-12">
			<h5>AR-ID CERTIFICADO <span ng-if="CodCertificado!=''">{{CodCertificado}}</span></h5>
		</div>
	</div>

<style type="text/css">
	.uppercase { text-transform: uppercase; }
</style>

	<div class="container-fluid">
		<div class="card m-2">
			<div class="card-header bg-info text-white"><h5>Identificación del Certificado</h5></div>
		  	<div class="card-body">
		  		<form name="myForm" enctype="multipart/form-data">

				<div class="row">
		  			<div class="col-md-2">
					  	<div class="form-group">
				    		<label for="CodCertificado">Id.Certificado:  </label><br>
				    	</div>
				    </div>
		  			<div class="col-md-2">
                        <div class="form-group">
					    	<input 	ng-model	= "CodCertificado" 
					    			name		= "CodCertificado"
					    			class		= "form-control uppercase" 
					    			type		= "text"
					    			size		= "12"
					    			maxlength	= "12"
					    			placeholder	= "AR-0000-0000" readonly>
                        </div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label for="fechaCertificado">Fecha Emisión:  </label>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<input 	ng-model	= "fechaCertificado" 
					    			name		= "fechaCertificado"
									ng-change	= "gardarFechaEmision()"
					    			class		= "form-control uppercase" 
					    			type		= "date" required>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card m-2">
			<div class="card-header bg-info text-white"><h5>Identificación del Cliente</h5></div>
		  	<div class="card-body">
				<div class="row">
		  			<div class="col-md-1">
				    	<label for="Cliente">Solicitante:  </label> 
				    </div>
		  			<div class="col-md-5">
                        <div class="form-group">
							<input ng-model = "RutCli" type="hidden">
							<input 	ng-model	= "Cliente" 
					    			name		= "Cliente"
					    			class		= "form-control uppercase" 
					    			type		= "text" readonly>
<!--
                            <select class="form-control" ng-model="RutCli" name="RutCli">
                              	<option value="" selected>Seleccionar Cliente</option>
                                <option ng-repeat="x in dataCli" value="{{x.RutCli}}">{{x.Cliente}}</option>
                            </select>
-->
                        </div>
					</div>
		  			<div class="col-md-1">
				    	<label for="Direccion">Dirección:  </label>  
				    </div>
		  			<div class="col-md-5">
                        <div class="form-group">
							<input 	ng-model="Direccion" 
					    			name="Direccion"
					    			class="form-control uppercase" 
					    			type="text" readonly>
                        </div>
					</div>
				</div>
				<div class="row">
		  			<div class="col-md-1">
				    	<label for="Contacto">Atención:  </label>  
				    </div>
		  			<div class="col-md-5">
                        <div class="form-group">
							<input 	ng-model="Contacto" 
					    			name="Contacto"
					    			class="form-control" 
									ng-change = "guardaContacto()"
					    			type="text" required autofocus>
                        </div>
					</div>
				</div>
				<hr>
				<div class="row">
		  			<div class="col-md-2"> 
				    	<label for="Contacto">Informe Asociado:  </label><br>  
                        <div class="form-group">
							<select class="form-control" ng-model="CodInformeAM" name="CodInformeAM" ng-change="mostrarQR(CodInformeAM)">
                              	<option value="" selected>Informe Asociado</option>
                                <option ng-repeat="x in dataInfo" value="{{x.CodInforme}}">{{x.CodInforme}}</option>
                            </select>
                        </div>
					</div>
		  			<div class="col-md-2">
				    	<label for="Contacto">Fecha de Ensayos:  </label><br>  
                        <div class="form-group">
							<input 	ng-model="fechaTerminoTaller" 
					    			name="fechaTerminoTaller"
					    			id="fechaTerminoTaller"
					    			class="form-control" 
					    			type="date" readonly>
                        </div>
					</div>
		  			<div class="col-md-2">
				    	<label for="Contacto">Código de Verificación:  </label><br>  
                        <div class="form-group">
							<input 	ng-model="CodigoVerificacionAM" 
					    			name="CodigoVerificacionAM"
					    			id="CodigoVerificacionAM"
					    			class="form-control uppercase" 
					    			type="text" readonly>
                        </div>
					</div>
		  			<div class="col-md-4">
				    	<label for="Contacto">Id Muestra:  </label><br>  
                        <div class="form-group">
							<!--
							<textarea ng-model="idMuestra" 
					    			name="idMuestra"
					    			id="idMuestra"
					    			class="form-control" readonly></textarea>
							-->
							<textarea ng-model="idCertificado" 
					    			name="idCertificado"
					    			id="idCertificado"
					    			class="form-control" readonly></textarea>

                        </div>
					</div>
		  			<div class="col-md-2">
				    	<label for="Contacto">Código QR: {{imgQR}}  </label><br>  
                        <div class="form-group">
							<img ng-if="imgQR!=''" src="../codigoqr/phpqrcode/temp/{{imgQR}}">
                        </div>
					</div>
				</div>
			</div>
		</div>
		<div class="card m-2">
			<div class="card-header bg-info text-white"><h5>Identificación del Producto</h5></div>
		  	<div class="card-body">
				<div class="row">
					<div class="col-md-2">
						<label for="nProducto">Tipo de Producto:  </label>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<select class="form-control" ng-model="nProducto" name="nProducto" ng-change="mostrarProducto(x.Producto)">
                              	<option value="" selected>Tipo de Producto</option>
                                <option ng-repeat="x in dataProductos" value="{{x.nProducto}}">{{x.Producto}}</option>
                            </select>
						</div>
					</div>
					<div class="col-md-2">
						<label for="nAcero">Grado de Acero:  </label>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<select class="form-control" ng-model="nAcero" name="nAcero" ng-change="mostrarAcero()">
                              	<option value="" selected>Grado de Acero</option>
                                <option ng-repeat="x in dataAceros" value="{{x.nAcero}}">{{x.Acero}}</option>
                            </select>
						</div>
					</div>
						
				</div>

				<div class="row">
					<div class="col-md-2">
						<label for="Lote">Id.Lote:  </label><br>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<input 	ng-model="Lote" 
									name="Lote"
									class="form-control" 
									type="text"
									size="50"
									maxlength="50"
									ng-change="gardarLote()"
									placeholder="Lote..." required>
						</div>
					</div>
					<div class="col-md-2">
						<label for="Dimension">Dimensiones (mm):  </label><br>
					</div>
					<div class="col-md-1">
						<div class="form-group">
							<input 	ng-model="Dimension" 
									name="Dimension"
									ng-change="guardarDimension()"
									class="form-control" 
									type="text"
									size="50"
									maxlength="50" required>
						</div>
					</div>
					<div class="col-md-2">
						<label for="Peso">Peso (kg):  </label><br>
					</div>
					<div class="col-md-1">
						<div class="form-group">
							<input 	ng-model="Peso" 
									name="Peso"
									ng-change="guardarPeso()"
									class="form-control" 
									type="text"
									size="50"
									maxlength="50" required>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<label for="Lote">Normas de Referencia:  </label><br>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<button type="button" class="btn btn-primary" ng-click="leerNormas()" data-toggle="modal" data-target="#myReferencia">
    							Agregar Referencia
  							</button>

							<div class="card mt-2">
								<div class="card-header">Normas de Referencias Asignadas</div>
								<div class="card-body" ng-init="leerNormasRefAsignadas()"> 

									<table class="table table-dark table-hover table-bordered">
										<thead>
											<tr>
												<th># 				</th>
												<th>Normas 			</th>
												<th>Acciones		</th>
											</tr>
										</thead>
										<tbody> 
											<tr ng-repeat="x in dataNormasRefAs">
												<td><b>{{x.nNorma}}</b></td>
												<td><b>{{x.Norma}}</b></td>
												<td>
													<a class="btn btn-warning" role="button" ng-click="quitarNormaRef(CodCertificado, x.nNorma)">Quitar</a>
												</td>
											</tr>
										</tbody>
									</table>



								</div>
							</div>


						</div>
					</div>
					<div class="col-md-2">
						<label for="Lote">Normas respectivas de aceptación o rechazo:  </label><br>
					</div>
					<div class="col-md-4">
					<div class="form-group">
							<button type="button" class="btn btn-primary" ng-click="leerNormasAc()" data-toggle="modal" data-target="#myAceptacionRechazo">
    							Agregar Aceptación o Rechazo
  							</button>

							<div class="card mt-2">
								<div class="card-header">Normas de Aceptación o Rechazo</div>
								<div class="card-body" ng-init="leerNormasAceptacionRechazo()">

									<table class="table table-dark table-hover table-bordered">
										<thead>
											<tr>
												<th># 				</th>
												<th>Normas 			</th>
												<th>Acciones		</th>
											</tr>
										</thead>
										<tbody> 
											<tr ng-repeat="x in dataNormasAcRe">
												<td><b>{{x.nNorma}}</b></td>
												<td><b>{{x.Norma}}</b></td>
												<td>
													<a class="btn btn-warning" role="button" ng-click="quitarNormaAcRe(CodCertificado, x.nNorma)">Quitar</a>
												</td>
											</tr>
										</tbody>
									</table>



								</div>
							</div>


						</div>
					</div>
				</div>

				<div ng-if="resultadoCertificacion == ''" class="alert alert-secondary text-center">
  					<strong>Resultados de la certificación ISO CASCO 7 según esquema de certificación IOC-101801</strong>
				</div>
				<div ng-if="resultadoCertificacion == 'A'" class="alert alert-success text-center">
  					<strong>Resultados de la certificación ISO CASCO 7 según esquema de certificación IOC-101801</strong>
				</div>
				<div ng-if="resultadoCertificacion == 'R'" class="alert alert-danger text-center">
  					<strong>Resultados de la certificación ISO CASCO 7 según esquema de certificación IOC-101801</strong>
				</div>

					<div class="row">
						<div class="col-md-6">
							<label for="tpEnsayo" ng-if="resultadoCertificacion != ''">Condición de Lote <b>{{Lote}} {{resultadoCertificacion}}</b>, vigente desde la fecha de emisión del presente certificado de conformidad.</label>
							<!-- <label for="tpEnsayo" ng-if="resultadoCertificacion">Seleccione la Condición de Lote <b>{{Lote}}.</label> -->
						</div>
						<div class="col-md-6 text-center">
							<label for="tpEnsayo"><h5>Certificado de Conformidad</h5></label>
							<!-- <label for="tpEnsayo" ng-if="resultadoCertificacion">Seleccione la Condición de Lote <b>{{Lote}}.</label> -->
						</div>
					</div>
					<div class="row">
						<div class="col-md-7">	
							<select ng-model="resultadoCertificacion" class="form-control" ng-change="cambiarResultado()">
								<option ng-repeat="resultadoCertificacion in tipoResultados" value="{{resultadoCertificacion.codRes}}">
									{{resultadoCertificacion.descripcion}}
								</option>
							</select>
						</div>
						<div class="col-md-5">
							<div class="row">
								<div class="col-12 text-center">
									<label for="tpEnsayo" ng-if="resultadoCertificacion != ''"><h5>{{CodCertificado}}</h5></label>
								</div>
								<div class="col-6">
									<div class="row">
										<div class="col-6 text-center">
											<h5>Código QR <br> {{CodigoVerificacion}}</h5>
										</div>
										<div class="col-6">
											<?php
												if($CodCertificado) {
													$dirinfo  = "http://www.simet.cl/certificados/certificadosQR.php";
													$dirinfo .= '?CodCertificado='.$CodCertificado;
													echo "<iframe scrolling='no' src='http://servidorerp/erp/codigoqr/phpqrcode/cQR.php?CodCertificado=$CodCertificado&data=$dirinfo' width='100%' height='200px' frameborder='0' marginheight='0' marginwidth='0'></iframe>";
												}
											?>
										</div>
									</div>
							</div>
							</div>
						</div>

					</div>

				<div class="alert alert-secondary mt-5">
  					<strong>OBSERVACIONES</strong>
				</div>


				<div class="form-group">
							<button type="button" class="btn btn-primary" ng-click="leerObservaciones()" data-toggle="modal" data-target="#myObservaciones">
    							Agregar OBSERVACIONES
  							</button>

							<div class="card mt-2">
								<div class="card-header">Observaiones Asignadas</div>
								<div class="card-body" ng-init="leerObservacionesAsignadas()">

									<table class="table table-dark table-hover table-bordered">
										<thead>
											<tr>
												<th># 				</th>
												<th>Observaciones 			</th>
												<th>Acciones		</th>
											</tr>
										</thead>
										<tbody> 
											<tr ng-repeat="x in dataObservacionesAs">
												<td><b>{{x.nObservacion}}</b></td>
												<td><b>{{x.Observacion}}</b></td>
												<td>
													<a class="btn btn-warning" role="button" ng-click="quitarObservaciones(CodCertificado, x.nObservacion)">Quitar</a>
												</td>
											</tr>
										</tbody>
									</table>



								</div>
							</div>


				</div>




		  		<div class="row">
		  			<div class="col-md-1">
				    	<label for="pdf">PDF Certificado:  </label>
				    </div>
		  			<div class="col-md-5">
                        <div class="form-group">

                            <input id="archivos" multiple type="file" ng-model="pdf">
                            <button class="btn btn-primary btn-flat pull-right" ng-click="enviarFormulario()"><i class="fa fa-plus"></i> Agregar</button>
                             Certificado {{pdf}}
                        </div>
					</div>
				</div>
				<hr>


				</form>
		  	</div>
		  	<div class="card-footer">
		  		<!--
		  		<a	href="pCertificado.php?CodCertificado={{CodCertificado}}"
					type="button" 
		  			class="btn btn-info">
		  			PDF
				</a>
				-->

		  		<a	href="dCertificado.php?CodCertificado={{CodCertificado}}"  
					type="button" 
		  			class="btn btn-info">
		  			Descargar
				</a>
		  		<span ng-show="muestraBotones">
				  		<button type="button" ng-click="desabilitarDatos()" class="btn btn-warning">Deshabilitar</button>
				  		<button type="button" ng-click="eliminarDatos()" class="btn btn-danger">Eliminar</button>
				  		<button type="button" ng-click="habilitarDatos()" class="btn btn-primary">Habilitar</button>
				  		<span ng-show="botonesUpCertificado">
				  		<button  	type="button" 
				  					ng-click="upCertificado()"
				  					class="btn btn-success">
				  				Up Certificado
				  		</button>

						<a 	href="https://simet.cl/certificados/certificados/leerbd.php" 
							class="btn btn-primary" 
							ng-click="msgActivacion()"> 
							Activar Certificado en la Web 
						</a>
						</span>

				</span>
		  		{{rutRes}}
		  		</div>
		  	</div>

		</div>
	</div>


	<!-- The Modal Observaciones -->
	<div class="modal fade" id="admObservaciones">
		<div class="modal-dialog modal-lg">
		<div class="modal-content">
		
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Mantención Observaciones</h4>
				<button type="button" ng-click="activarNormalidad()" class="close" data-dismiss="modal">&times;</button>
			</div>
			
			<!-- Modal body -->
			<div class="modal-body">
				<div class="card">
  					<div class="card-header">Observaciones</div>
  					<div class="card-body" ng-init="leerTodasObservaciones()">

					  	<table class="table table-dark table-hover table-bordered" ng-show="muestraData">
	    					<thead>
	      						<tr>
							        <th># 					</th>
							        <th>Observaciones 		</th>
							        <th>Acciones			</th>
	      						</tr>
	    					</thead>
	    					<tbody> 
	      						<tr ng-repeat="x in dataTodasObservaciones">
							        <td>
										<b>
										{{x.nObservacion}}
										</b>
									</td>
							        <td>
										<b><a href="" ng-click="editarData(x.nObservacion, x.Observacion)" style="text-decoration:none; color:#ccc;">{{x.Observacion}}</a></b>
									</td>
							        <td>
										<a class="btn btn-danger" 	ng-if="x.Estado == 'on'"  role="button" ng-click="deshabilitaObservaciones(x.nObservacion)">Deshabilita</a>
										<a class="btn btn-warning" 	ng-if="x.Estado == 'off'" role="button" ng-click="habilitaObservaciones(x.nObservacion)">Activar</a>
	        						</td>
	      						</tr>
	    					</tbody>
							
	  					</table>

						<div ng-show="actualizaData">
							<div class="row">
								<div class="col-3">Id. Obs: </div>
								<div class="col-9"><b>{{nObservacion}}</b></div>
							</div>
							<div class="row">
								<div class="col-3">
									Observación:
								</div>
								<div class="col-9">
									<div class="form-group">
										<textarea class="form-control" name="Observacion" ng-model="Observacion" cols="50" rows="3" class="form-control"></textarea>
									</div>
								</div>
							</div>
							<div class="row">
									<div class="col">
										<button type="button" ng-click="guardarData()" class="btn btn-danger">Guardar</button>
									</div>
							</div>
						</div>

						<div ng-show="agregarDataObservacion">
							<div class="row">
								<div class="col-3">Id. Obs: </div>
								<div class="col-9"><b>{{nObservacion}}</b></div>
							</div>
							<div class="row">
								<div class="col-3">
									Observación:
								</div>
								<div class="col-9">
									<div class="form-group">
										<textarea class="form-control" name="Observacion" ng-model="Observacion" cols="50" rows="3" class="form-control"></textarea>
									</div>
								</div>
							</div>
							<div class="row">
									<div class="col">
										<button type="button" ng-click="guardarData()" class="btn btn-danger">Guardar</button>
									</div>
							</div>
						</div>



					</div>

					<div class="card-footer">


					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-info" ng-show="btnAgregarObs" ng-click="agregarObservacion()">Agregar Obs</button>
					<button type="button" class="btn btn-danger" ng-click="activarNormalidad()" data-dismiss="modal">Close</button>
				</div>
			</div>
			
			<!-- Modal footer -->
			
		</div>
		</div>
	</div>





	<!-- The Modal Observaciones -->
	<div class="modal fade" id="myObservaciones">
		<div class="modal-dialog modal-lg">
		<div class="modal-content">
		
			<!-- Modal Header -->
			<div class="modal-header">
			<h4 class="modal-title">Asociar Observaciones al Certificado</h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			
			<!-- Modal body -->
			<div class="modal-body">
				<div class="card">
  					<div class="card-header">Observaciones</div>
  					<div class="card-body" ng-init="leerObservaciones()">

					  	<table class="table table-dark table-hover table-bordered">
	    					<thead>
	      						<tr>
							        <th># 					</th>
							        <th>Observaciones 		</th>
							        <th>Acciones			</th>
	      						</tr>
	    					</thead>
	    					<tbody> 
	      						<tr ng-repeat="x in dataObservaciones">
							        <td><b>{{x.nObservacion}}</b></td>
							        <td><b>{{x.Observacion}}</b></td>
							        <td>
							        	<!-- <a class="btn btn-warning" role="button" href="#?CodCertificado={{CodCertificado}}&nNorma={{x.nNorma}}">Asociar</a> -->
							        	<a class="btn btn-warning" role="button" ng-click="asignarObservaciones(CodCertificado, x.nObservacion)">Asociar</a>
	        						</td>
	      						</tr>
	    					</tbody>
	  					</table>



					</div>
				</div>
			</div>
			
			<!-- Modal footer -->
			<div class="modal-footer">
			<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
			
		</div>
		</div>
	</div>



	<!-- The Modal Normas de Referencia -->
	<div class="modal fade" id="myReferencia">
		<div class="modal-dialog modal-lg">
		<div class="modal-content">
		
			<!-- Modal Header -->
			<div class="modal-header">
			<h4 class="modal-title">Asociar Normas de Referencias al Certificado</h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			
			<!-- Modal body -->
			<div class="modal-body">
				<div class="card">
  					<div class="card-header">Normas</div>
  					<div class="card-body" ng-init="leerNormas()">

					  	<table class="table table-dark table-hover table-bordered">
	    					<thead>
	      						<tr>
							        <th># 				</th>
							        <th>Normas 			</th>
							        <th>Acciones		</th>
	      						</tr>
	    					</thead>
	    					<tbody> 
	      						<tr ng-repeat="x in dataNormas">
							        <td><b>{{x.nNorma}}</b></td>
							        <td><b>{{x.Norma}}</b></td>
							        <td>
							        	<!-- <a class="btn btn-warning" role="button" href="#?CodCertificado={{CodCertificado}}&nNorma={{x.nNorma}}">Asociar</a> -->
							        	<a class="btn btn-warning" role="button" ng-click="asignarNormaRef(CodCertificado, x.nNorma)">Asociar</a>
	        						</td>
	      						</tr>
	    					</tbody>
	  					</table>



					</div>
				</div>
			</div>
			
			<!-- Modal footer -->
			<div class="modal-footer">
			<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
			
		</div>
		</div>
	</div>

	<!-- The Modal Normas de Referencia -->
	<div class="modal fade" id="myAceptacionRechazo">
		<div class="modal-dialog modal-lg">
		<div class="modal-content">
		
			<!-- Modal Header -->
			<div class="modal-header">
			<h4 class="modal-title">Asociar Normas de Aceptación o Rechazo</h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			
			<!-- Modal body -->
			<div class="modal-body">
				<div class="card">
  					<div class="card-header">Normas</div>
  					<div class="card-body" ng-init="leerNormasAc()">

					  	<table class="table table-dark table-hover table-bordered">
	    					<thead>
	      						<tr>
							        <th># 				</th>
							        <th>Normas 			</th>
							        <th>Acciones		</th>
	      						</tr>
	    					</thead>
	    					<tbody> 
	      						<tr ng-repeat="x in dataNormasAc">
							        <td><b>{{x.nNorma}}</b></td>
							        <td><b>{{x.Norma}}</b></td>
							        <td>
							        	<a class="btn btn-warning" role="button" ng-click="asignarNormaAc(CodCertificado, x.nNorma)">Asociar</a>
	        						</td>
	      						</tr>
	    					</tbody>
	  					</table>



					</div>
				</div>
			</div>
			
			<!-- Modal footer -->
			<div class="modal-footer">
			<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
			
		</div>
		</div>
	</div>












	<script src="mCertificados.js"></script>
</body>
</html>