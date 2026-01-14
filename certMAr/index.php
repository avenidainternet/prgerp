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

	$ar = 'AR-';
	if(isset($_GET['ar'])){
		$ar = $_GET['ar']; 		 
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
	          			<a href="../certrar/" class="nav-link fas fa-address-card text-dark"> Volver Id-AR</a>
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
			<h5>IDENTIFICACIÓN</h5>
		</div>
		<div class="col-12">
			<h5>AR-ID CERTIFICADO <span ng-if="ar!=''">{{ar}} </span></h5>
		</div>
	</div>

<style type="text/css">
	.uppercase { text-transform: uppercase; }
</style>

	<div class="container-fluid">
		<div class="card m-2">
			<div class="card-header bg-info text-white"><h5>Identificación del Certificado</h5></div>
		  	<div class="card-body">
				<div class="row">
		  			<div class="col-md-1">
					  	<div class="form-group">
				    		<label for="codAr">Id :  </label><br>
				    	</div>
                        <div class="form-group">
					    	<input 	ng-model="ar" 
					    			class="form-control uppercase" 
					    			ng-init="loadDataCertificado('<?php echo $ar; ?>')"
					    			type="text"
					    			size="12"
					    			maxlength="12"
					    			placeholder="AR-0000" readonly >
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
							<label for="fechaInspeccion">Fecha Inspección:  </label>
						</div>
						<div class="form-group">
							<input 	ng-model="fechaInspeccion" 
									id="fechaInspeccion"
									ng-change="grabarFechaInspeccion()"
					    			class="form-control uppercase" 
					    			type="date" required autofocus>
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
							<label for="Inspector">Inspector:  </label>
						</div>

						<div class="form-group">
                            <select class="form-control" ng-model="usr" id="usr" name="usr">
                              	<option value="" selected>Seleccionar Inspector</option>
                                <option ng-repeat="x in dataIns" value="{{x.usr}}">{{x.usuario}}</option>
                            </select>
                        </div>
                    </div>

				</div>
			</div>
			<div class="card-footer"> 
				<a 	class="btn btn-warning" ng-click="crearCertificado()" 	role="button" ng-if="Situacion=='New'">Crear AR {{ar}}</a>
				<a 	class="btn btn-info" 	ng-click="crearCertificado()" 	role="button" ng-if="Situacion=='Old'">Actualizar AR {{ar}}</a>
				<a 	class="btn btn-success" ng-click="informarLE()" 		role="button" ng-if="certAsociado=='No'">Informar a LE {{ar}}</a>
				<a 	class="btn btn-info" 	href="../certdCAMAR/formularios/iCAMAR.php?CAM={{CAMAR}}" 	ng-if="Situacion=='Old'"	role="button"">Imprimir PreCAM {{CAMAR}}</a>

				
				<div class="alert alert-info m-2" ng-if="RAMAR > 0">
  					<strong>Info!</strong> Ya se cuenta con una <b>RAMAR "{{RAMAR}}"</b> asociada en LE.
				</div>
				<div class="alert alert-danger m-2" ng-if="RAMAR == 0">
  					<strong>Info!</strong> No se ha asociado aun una RAMAR con LE. <b>Debe informar a LE</b>.
				</div>
			</div>
		</div>
	</div>

	<div class="card m-2" ng-show="Certificados">
		<div class="card-header bg-info text-white"><h5>Certificados de Conformidad</h5></div>
		<div class="card-body">
			<table class="table table-dark table-hover table-bordered">
				<thead>
					<tr>
						<th>Certificados</th>
						<th>Clientes	</th>
						<th>Lote		</th>
						<th>Peso (Tn)		</th>
						<th>Fecha Web	</th>
						<th>Acciones	</th>
					</tr>
				</thead>
				<tbody> 
					<tr ng-repeat="x in Certificados | filter : bCertificado"
						ng-class="{'pasivo-class': x.upLoad == 'off', 'default-color': x.pdf != ''}">
						<td><b>{{x.CodCertificado}}</b></td>
						<td><b>{{x.Cliente}}</b></td>
						<td>{{x.Lote}}</td>
						<td>{{x.Peso}}</td>
						<td>
							<div ng-if="x.fechaUpLoad != '0000-00-00'">
								{{x.fechaUpLoad | date:'dd-MM-yyyy'}} 
							</div>
							<br>
							{{x.pdf}}  
						</td> 
						<td>
							<a 	class="btn btn-warning" role="button"
								href="../certproductos/mCertificados.php?CodCertificado={{x.CodCertificado}}">Editar</a>
						</td>
					</tr>
				</tbody>
			</table>

		</div>
	</div>

	<script src="ar.js"></script> 
</body>
</html>