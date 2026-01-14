<?php
	session_start(); 

    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");                      // Expira en fecha pasada 
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");        // Siempre página modificada 
    header("Cache-Control: no-cache, must-revalidate");                   // HTTP/1.1 
    header("Pragma: no-cache");  
	date_default_timezone_set("America/Santiago");

	include_once("../conexionli.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		$link->close();
	}else{
		header("Location: ..index.php"); 
	}

	
?>
<!doctype html>
 
<html lang="es">
<head>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Intranet Simet</title>

	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../datatables/datatables.min.css">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<script type="text/javascript" src="../angular/angular.js"></script>

</head>

<body ng-app="myApp" ng-controller="CtrlClientes">
	<?php include('head.php'); ?>
	<div id="linea"></div>

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
	          			<a class="btn nav-link fas fa-address-card" ng-click="verClientes()" role="button"> Clientes</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="btn nav-link fas fa-address-card" ng-click="verContactos()"> Contactos</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-address-card" href="mClientes.php?Proceso=1"> +Cliente</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="../cerrarsesion.php"> Cerrar</a>
	        		</li>

	      		</ul>
	    	</div>
	  	</div>
	</nav> 
	<div class="row bg-info text-white" style="padding: 10px;">
			<div class="col-1">
				Cliente
			</div>
			<div class="col-5">
				<input class="form-control" ng-change="loadClientes()" ng-model="bCliente" id="bCliente" type="text">
			</div>
			<div class="col-1">
				Contacto 
			</div>
			<div class="col-5">
				<input class="form-control" ng-change="loadContactos()" ng-model="bContactos" id="bContactos" type="text">
			</div>
	</div>

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
	
	<div class="container-fluid" style="margin-top: 10px;">
		<div class="spinner-border" ng-show="loading">Cargando...</div>
	  	<table class="table table-dark table-hover table-bordered" ng-show="tClientes">
	    	<thead>
	      		<tr>
			        <th>RUT</th>
			        <th>Clientes</th>
			        <th>Teléfono</th>
			        <th>Correo</th>
			        <th>Acciones</th>
	      		</tr>
	    	</thead>
	    	<tbody>
	      		<tr ng-repeat="Cliente in Clientes | filter : bCliente"
	      			ng-class="{'custom-class': Cliente.Estado == 'off', 'default-color': Cliente.Estado == 'on'}">
			        <td><b>{{Cliente.RutCli}}</b></td>
			        <td><b>{{Cliente.Cliente}}</b></td>
			        <td>{{Cliente.Telefono}}</td>
			        <td>{{Cliente.Email}}</td>
			        <td>
			        	<a 	class="btn btn-warning" role="button"
	        				href="mClientes.php?RutCli={{Cliente.RutCli}}">Editar</a>
		        		<button type="button" class="btn btn-danger">Eliminar</button>
	        		</td>
	      		</tr>
	    	</tbody>
	  </table>

	  <table class="table table-dark table-hover table-bordered" ng-show="tContactos">
	    	<thead>
	      		<tr>
			        <th>RUT</th>
			        <th>N°</th>
			        <th>Contacto</th>
			        <th>Correo</th>
			        <th>Teléfono</th>
			        <th>Acciones</th>
	      		</tr>
	    	</thead>
	    	<tbody>
	      		<tr ng-repeat="Contacto in Contactos | filter : bContactos"
	      			ng-class="{'default-color': Contacto.RutCli != ''}">
			        <td><b>{{Contacto.cCliente}}</b></td>
			        <td><b>{{Contacto.nContacto}}</b></td>
			        <td><b>{{Contacto.Contacto}}</b></td>
			        <td>{{Contacto.Email}}</td>
			        <td>{{Contacto.Telefono}}</td>
			        <td>
	        			<a 	class="btn btn-warning" role="button"
	        				href="mContacto.php?RutCli={{Contacto.RutCli}}&nContacto={{Contacto.nContacto}}&accion=Editar&Proceso=2">Editar</a>
	        			<button type="button" 
	        					ng-click="borrarContacto(Contacto.RutCli, Contacto.nContacto, Contacto.Contacto)" 
	        					class="btn btn-danger">Eliminar
	        			</button>
	        		</td>
	      		</tr>
	    	</tbody>
	  </table>

	</div>


	<div style="clear:both; "></div>
	<br>
	<script src="Clientes.js"></script>

</body>
</html>
