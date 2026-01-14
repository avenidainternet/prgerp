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
	if(isset($_GET['Colada']))	{ $Colada 	= $_GET['Colada']; 		}
	if(isset($_GET['CAMAR']))	{ $CAMAR 	= $_GET['CAMAR']; 		}
	//echo $CAMAR;

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

<body ng-app="myApp" ng-controller="CtrlClientes" ng-init="inicializarVariables('<?php echo $CAMAR; ?>', '<?php echo $Colada; ?>')">
	<?php include('head.php'); ?>
	<!-- Navigation -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-warning static-top">
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
	          			<a class="nav-link fa fa-home text-dark" href="../plataformaErp.php"> Principal
	                	<span class="sr-only">(current)</span>
	              		</a>
	        		</li>
	        		<li class="nav-item">
	          			<a href="../certdCAMAR/?CAMAR=<?php echo $CAMAR; ?>" class="nav-link fas fa-address-card text-dark"> Volver </a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off text-dark" href="../cerrarsesion.php"> Cerrar</a>
	        		</li>

	      		</ul>
	    	</div>
	  	</div>
	</nav> 
	<div class="row bg-info text-white text-center" style="padding: 10px;">
		<div class="col-12">
			<h5>PRE-COTIZACIÓN  <span ng-if="CAMAR!=''">CAMAR <?php echo $CAMAR; ?> Colada <?php echo $Colada; ?></span></h5>
		</div>
	</div>

<style type="text/css">
	.uppercase { text-transform: uppercase; }
</style>

	<div class="container-fluid">
		<div class="card m-2">
			<div class="card-header bg-info text-white"><h5>Identificación del Colada</h5></div>
		  	<div class="card-body">
		  		<form name="myForm" enctype="multipart/form-data">

				<div class="row">
		  			<div class="col-md-2">
					  	<div class="form-group">
				    		<label for="CAMAR">Id.CAMAR:  </label><br>
				    	</div>
				    </div>
		  			<div class="col-md-2">
                        <div class="form-group">
					    	<input 	ng-model	= "CAMAR" 
					    			name		= "CAMAR"
					    			class		= "form-control uppercase" 
					    			type		= "text" readonly>
                        </div>
					</div>
		  			<div class="col-md-2">
					  	<div class="form-group">
				    		<label for="Colada">Colada:  </label><br>
				    	</div>
				    </div>
		  			<div class="col-md-2">
                        <div class="form-group">
					    	<input 	ng-model="Colada" 
					    			name="Colada"
					    			class="form-control uppercase" 
					    			type="text" readonly>
                        </div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label for="fechaCertificado">Fecha Pre-Cotización:  </label>
						</div>
					</div>
					<div class="col-md-2">
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
							<input 	ng-model	= "Lote" 
									name		= "Lote"
									class		= "form-control" 
									type		= "text"
									size		= "50"
									maxlength	= "50"
									ng-change	= "gardarLote()"
									placeholder	= "Lote..." required>
						</div>
					</div>
					<div class="col-md-2">
						<label for="Dimension">Dimensiones (mm):  </label><br>
					</div>
					<div class="col-md-1">
						<div class="form-group">
							<input 	ng-model	= "Dimension" 
									name		= "Dimension"
									ng-change	= "guardarDimension()"
									class		= "form-control" 
									type		= "text"
									size		= "50"
									maxlength	= "50" required>
						</div>
					</div>
					<div class="col-md-2">
						<label for="Peso">Peso (kg):  </label><br>
					</div>
					<div class="col-md-1">
						<div class="form-group">
							<input 	ng-model	= "Peso" 
									name		= "Peso"
									ng-change 	= "guardarPeso()"
									class		= "form-control" 
									type		= "text"
									size		= "50"
									maxlength	= "50" required>
						</div>
					</div>
				</div>







				</form>
		  	</div>
		  	<div class="card-footer">

		  		<a	ng-click="gardarCambiosPreCam()"
					type="button" 
		  			class="btn btn-info">
		  			Guardar
				</a>
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