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

	
?>
<!doctype html>
 
<html lang="es">
<head>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Registro de Certificado</title>

	<link href="styles.css" rel="stylesheet" type="text/css">
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
</head>

<body ng-app="myApp" ng-controller="CtrlClientes">
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
	          			<a href="index.php" class="nav-link fas fa-address-card"> Certificados</a>
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
			<div class="card-header bg-info text-white"><h5>Identificación del Certificado< AR/h5></div>
		  	<div class="card-body">

				<div class="row">
		  			<div class="col-md-2">
					  	<div class="form-group">
				    		<label for="CodCertificado">Id. AR:  </label><br>
				    	</div>
				    </div>
		  			<div class="col-md-2">
                        <div class="form-group">
					    	<input 	ng-model="CodCertificado" 
					    			name="CodCertificado"
					    			class="form-control uppercase" 
					    			ng-init="loadDataCertificado('<?php echo $CodCertificado; ?>')"
					    			type="text"
					    			size="12"
					    			maxlength="12"
					    			placeholder="AR-0000-0000" required autofocus>
                        </div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label for="fechaCertificado">Fecha Inspección:  </label>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<input 	ng-model="fechaCertificado" 
					    			name="fechaCertificado"
					    			class="form-control uppercase" 
					    			type="date" required autofocus>
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
                            <select class="form-control" ng-model="RutCli" name="RutCli">
                              	<option value="" selected>Seleccionar Cliente</option>
                                <option ng-repeat="x in dataCli" value="{{x.RutCli}}">{{x.Cliente}}</option>
                            </select>
                        </div>
					</div>
		  			<div class="col-md-1">
				    	<label for="Contacto">Atención:  </label> 
				    </div>
		  			<div class="col-md-5">
                        <div class="form-group">
							<input 	ng-model="Contacto" 
					    			name="Contacto"
					    			class="form-control uppercase" 
					    			type="text" required autofocus>
                        </div>
					</div>
				</div>
			</div>
		</div>
		<div class="card m-2">


		  	<div class="card-footer">
		  		
		  		<button type="button" 
		  				class="btn btn-info"
		  				ng-click="guardarDatosCertificado()" 
		  				>
		  				Guardar
		  		</button>
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


	<script src="mCertificadosAr.js"></script>
</body>
</html>