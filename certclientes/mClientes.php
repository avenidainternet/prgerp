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

	$RutCli = '';
	$accion = 'New';
	if(isset($_GET['RutCli'])){
		$RutCli = $_GET['RutCli'];
		if($RutCli){$accion = 'Old';}
		 
	}
	
?>
<!doctype html>
 
<html lang="es">
<head>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Mantención de Clientes</title>

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
<script src="../jquery/jquery-1.6.4.js"></script>
</head>

<body ng-app="myApp" ng-controller="CtrlClientes">
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
	          			<a href="clientes.php" class="nav-link fas fa-address-card text-dark"> Clientes</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-address-card text-dark" href="mClientes.php?Proceso=1"> +Cliente</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off text-dark" href="../cerrarsesion.php"> Cerrar</a>
	        		</li>

	      		</ul>
	    	</div>
	  	</div>
	</nav> 
	<div class="row bg-info text-white" style="padding: 10px;">
		<div class="col-12">
			<h5>FORMULARIO DE CLIENTES </h5>
		</div>
	</div>
	<div class="container-fluid">
		<div class="card" style="margin: 10px; margin: 10px 50px 50px;">
			<div class="card-header">Identificación del Cliente <b>{{rutRes}}</b></div>
		  	<div class="card-body">
		  		<form name="myForm">
		  		<div class="row">
		  			<div class="col-md-1">
				    	<label for="Cliente">Rut Cliente:  </label>
				    </div>
		  			<div class="col-md-2">
					  	<div class="form-group">
					    	<input 	ng-model="RutCli" 
					    			class="form-control" 
					    			type="text" 	
					    			size="10"
					    			maxlength="10"
					    			ng-change="loadDataCliente(RutCli)"
					    			placeholder="Rut Cliente..." 
					    			ng-init="loadDataCliente('<?php echo $RutCli; ?>')"
					    			autofocus="" required >
					  		
					    </div>
					</div>
				</div>




		  		<div class="row">
		  			<div class="col-md-1">
				    	<label for="Cliente">Cliente:  </label>
				    </div>
		  			<div class="col-md-11">
					  	<div class="form-group">
					    	<input 	ng-model="Cliente" 
					    			name="Cliente"
					    			class="form-control" 
					    			type="text"
					    			ng-disabled="Situacion < 10" 	
					    			size="50"
					    			maxlength="50"
					    			placeholder="Cliente..." required>
					    	<div 	class="alert alert-danger" 
					    			ng-show="myForm.Cliente.$touched && myForm.Cliente.$invalid"
					    			style="margin: 5px;">
    							<strong>Alerta!</strong> Datos del Cliente requerido....
  							</div>
					    </div>
					</div>

		  			<div class="col-md-1">
				    	<label for="Cliente">Dirección:  </label>
				    </div>
		  			<div class="col-md-11">
					  	<div class="form-group">
					    	<input 	ng-model="Direccion" 
					    			name="Direccion"
					    			class="form-control" 
					    			type="text"
					    			ng-disabled="Situacion < 10" 	
					    			size="50"
					    			maxlength="50"
					    			placeholder="Dirección..." required>
					    	
					    </div>
					</div>

		  			<div class="col-md-1">
				    	<label for="Cliente">Contacto:  </label>
				    </div>
		  			<div class="col-md-11">
					  	<div class="form-group">
					    	<input 	ng-model="Contacto" 
					    			name="Contacto"
					    			class="form-control" 
					    			type="text"
					    			ng-disabled="Situacion < 10" 	
					    			size="50"
					    			maxlength="50"
					    			placeholder="Contacto..." required>
					    </div>
					</div>

		  			<div class="col-md-1">
				    	<label for="Cliente">Teléfono:  </label>
				    </div>
		  			<div class="col-md-5">
					  	<div class="form-group">
					    	<input 	ng-model="Telefono" 
					    			name="Telefono"
					    			class="form-control" 
					    			type="text"
					    			ng-disabled="Situacion < 10" 	
					    			size="50"
					    			maxlength="50"
					    			placeholder="Telefono..." required>
					    </div>
					</div>
		  			<div class="col-md-1">
				    	<label for="Cliente">Celular:  </label>
				    </div>
		  			<div class="col-md-5">
					  	<div class="form-group">
					    	<input 	ng-model="Celular" 
					    			name="Celular"
					    			class="form-control" 
					    			type="text"
					    			ng-disabled="Situacion < 10" 	
					    			size="50"
					    			maxlength="50"
					    			placeholder="Celular..." required>
					    </div>
					</div>
		  			<div class="col-md-1">
				    	<label for="Cliente">Email:  </label>
				    </div>
		  			<div class="col-md-5">
					  	<div class="form-group">
					    	<input 	ng-model="Email" 
					    			name="Email"
					    			class="form-control" 
					    			type="email"
					    			ng-disabled="Situacion < 10" 	
					    			size="50"
					    			maxlength="50"
					    			placeholder="Email..." required>
					    </div>
					</div>
		  			<div class="col-md-1">
				    	<label for="Cliente">Sitio:  </label>
				    </div>
		  			<div class="col-md-5">
					  	<div class="form-group">
					    	<input 	ng-model="Sitio" 
					    			name="Sitio"
					    			class="form-control" 
					    			type="text"
					    			ng-disabled="Situacion < 10" 	
					    			size="50"
					    			maxlength="50"
					    			placeholder="Sitio...">
					    </div>
					</div>
				</div>
				</form>
		  	</div>
		  	<div class="card-footer">
		  		
		  		<button type="button" 
		  				ng-click="guardarDatos()" 
		  				ng-disabled="myForm.RutCli.$invalid || myForm.Cliente.$invalid || myForm.Direccion.$invalid || myForm.Email.$invalid || myForm.Contacto.$invalid || myForm.Telefono.$invalid || myForm.Celular.$invalid"
		  				class="btn btn-info">
		  				Guardar
		  		</button>
		  		<?php 
		  			if($accion == 'Old'){?>
				  		<button type="button" ng-click="desabilitarDatos()" class="btn btn-warning">Deshabilitar</button>
				  		<button type="button" ng-click="eliminarDatos()" class="btn btn-danger">Eliminar</button>
				  		<button type="button" ng-click="habilitarDatos()" class="btn btn-primary">Habilitar</button>
		  				<?php
		  			}
		  		?>
		  		</div>
		  	</div>

		</div>
	</div>


	<script src="mClientes.js"></script>
</body>
</html>