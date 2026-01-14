<?php
	session_start();
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

	$CAMAR = '';
	if(isset($_GET['CAMAR'])){
		$CAMAR = $_GET['CAMAR']; 		 
	}
	//echo $ar;
?>
<!doctype html>
 
<html lang="es">
<head>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<title>Mantención de Certificado</title>

	<link href="../css/styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<script type="text/javascript" src="../angular/angular.js"></script>



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

<style type="text/css">
		.custom-class{
		  background-color: gray
		}
		.pasivo-class{
		  background-color: red
		}
		.default-color{
		  background-color: green
		}	
	</style>

</head>

<body ng-app="myApp" ng-controller="CtrlAR"> 
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
	          			<a href="../certCamar/" class="nav-link fas fa-address-card text-dark"> Volver Pre Cotizaciones</a>
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
			<h5>PRE-COTIZACIÓN  <span ng-if="CAMAR!=''">CAMAR {{CAMAR}} </span></h5>
		</div>
	</div>

<style type="text/css">
	.uppercase { text-transform: uppercase; }
</style>

	<div class="container-fluid">
		<div class="card m-2">
			<div class="card-header bg-info text-white"><h5>Identificación Pre-CAMAR</h5></div>
		  	<div class="card-body">
				<div class="row">
		  			<div class="col-md-1">
					  	<div class="form-group">
				    		<label for="codAr">Id CAMAR :  </label><br>
				    	</div>
                        <div class="form-group">
					    	<input 	ng-model="CAMAR" 
					    			class="form-control uppercase" 
					    			ng-init="loadDataCertificado('<?php echo $CAMAR; ?>')"
					    			type="text"
					    			size="12"
					    			maxlength="12"
					    			placeholder="CAMAR" readonly >
                        </div>
					</div>
					<div class="col-md-1">
						<div class="form-group">
							<label for="nColadas">Coladas:  </label>
						</div>
						<div class="form-group" ng-show="Bloqueo">
							<input 	ng-model="nColadas" 
									id="nColadas"
					    			class="form-control uppercase" 
					    			type="text" readonly >
						</div>
						<div class="form-group" ng-show="noBloqueo">
							<input 	ng-model="nColadas" 
									id="nColadas"
					    			class="form-control uppercase" 
					    			type="text" required >
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label for="fechaPreCAM">Fecha Pre-CAMAR:  </label>
						</div>
						<div class="form-group">
							<input 	ng-model	= "fechaPreCAM" 
									id			= "fechaPreCAM"
									ng-change	= "grabarFechaInspeccion()"
					    			class		= "form-control uppercase" 
					    			type		= "date" required autofocus>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="Cliente">Cliente:  </label>
						</div>

						<div class="form-group">
                            <select class="form-control" ng-model="RutCli" id="RutCli" name="RutCli" required>
                              	<option value="" selected>Seleccionar Cliente</option>
                                <option ng-repeat="x in dataCli" value="{{x.RutCli}}">{{x.Cliente}}</option>
                            </select>
                        </div>
                    </div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="Inspector">Responsable Pre-Cotización:  </label>
						</div>

						<div class="form-group">
                            <select class="form-control" ng-model="usr" id="usr" name="usr">
                              	<option value="" selected>Seleccionar Responsable</option>
                                <option ng-repeat="x in dataIns" value="{{x.usr}}">{{x.usuario}}</option>
                            </select>
                        </div>
                    </div>

				</div>
			</div>
			<div class="card-footer"> 
				<a 	class="btn btn-warning" ng-click="crearCertificado()" 	role="button" 	ng-if="Situacion=='New'">Crear PreCAM {{CAMAR}}</a>
				<a 	class="btn btn-info" 	ng-click="actualiazaPreCAM()" 	role="button" 	ng-if="Situacion=='Old'">Actualizar PreCAM {{CAMAR}}</a>
				<a 	class="btn btn-info" 	href="formularios/iCAMAR.php?CAM={{CAMAR}}" 	ng-if="Situacion=='Old'"	role="button"">Imprimir PreCAM {{CAMAR}}</a>
				<a 	class="btn btn-warning" ng-click="asignarRAMAR()" 	role="button" 		ng-if="Situacion=='Old'">Asigna RAMAR a CAMAR {{CAMAR}}</a>
				<a 	class="btn btn-warning" ng-click="ira()" 	role="button" 				ng-if="ar != ''">Ir a Certificado{{}}</a>
				<!-- <a 	class="btn btn-success" ng-click="informarLE()" 		role="button" ng-if="certAsociado=='No'">Informar a LE {{ar}}</a> -->
				
			</div>
		</div>
	</div>

	<div class="card m-2" ng-show="Certificados">
		<div class="card-header bg-info text-white"><h5>Id. Coladas</h5></div>
		<div class="card-body">
			<table class="table table-dark table-hover table-bordered">
				<thead>
					<tr>
						<th>Id.Colada</th>
						<th>Peso (Tn)		</th>
						<th>Lote 		</th>
						<th>Acciones	</th>
					</tr>
				</thead>
				<tbody> 
					<tr ng-repeat="x in Certificados | filter : bCertificado"
						ng-class="{'pasivo-class': x.upLoad == 'off', 'default-color': x.pdf != ''}">
						<td><b>{{x.Colada}}</b></td>
						<td>{{x.Peso}}</td>
						<td>{{x.Lote}}</td>
						<td>
							<a 	class="btn btn-warning" role="button"
								href="../certPreCamar/mCertificados.php?CAMAR={{CAMAR}}&Colada={{x.Colada}}">Editar</a>
						</td>
					</tr>
				</tbody>
			</table>

		</div>
	</div>

	<script src="ar.js"></script> 
</body>
</html>