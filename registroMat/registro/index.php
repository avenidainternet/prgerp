<?php
	session_start(); 
	
	include_once("../conexion.php");
	$accion 	= '';
	$CAM 		= 0;
	$RAM 		= 0;
	$nContacto 	= 0;
	$Fan 		= 0;
	
	if(isset($_GET['RutCli'])) 	{	$RutCli	= $_GET['RutCli']; 	} 
	if(isset($_GET['RAM'])) 	{	$RAM 	= $_GET['RAM']; 	}
	if(isset($_GET['Fan'])) 	{	$Fan 	= $_GET['Fan']; 	}
	if(isset($_GET['accion'])) 	{	$accion = $_GET['accion']; 	}
	
	if(isset($_POST['RAM'])) 	{	$RAM 	= $_POST['RAM']; 		}
	if(isset($_POST['accion'])) {	$accion = $_POST['accion']; 	}
	
?>
<!doctype html>
 
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="shortcut icon" href="favicon.ico" />
	<link rel="apple-touch-icon" href="touch-icon-iphone.png" />
	<link rel="apple-touch-icon" href="touch-icon-ipad.png" />
	<link rel="apple-touch-icon" href="touch-icon-iphone4.png" /> 

	<title>SIMET - Recepción de Muestras</title>

	<link href="../../css/stylesTv.css" rel="stylesheet" type="text/css">
	<link href="../styles.css" rel="stylesheet" type="text/css">
	<link href="....//css/tpv.css" rel="stylesheet" type="text/css">

	<script type="text/javascript" src="../../jquery/libs/1/jquery.min.js"></script>	

	<link rel="stylesheet" type="text/css" href="../../cssboot/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

	<script type="text/javascript" src="../../angular/angular.js"></script>

	<style type="text/css">
		.verde-class{
		  background-color 	: green;
		  color 			: #fff;
		  font-weight 		: bold;
		}
		.verdechillon-class{
		  background-color 	: #33FFBE;
		  color 			: #fff;
		  font-weight 		: bold;
		}
		.azul-class{
		  background-color 	: blue;
		  color 			: #fff;
		  font-weight 		: bold;
		}
		.amarillo-class{
		  background-color 	: yellow;
		  color 			: black;
		}
		.rojo-class{
		  background-color 	: red;
		  color 			: black;
		}
		.default-color{
		  background-color 	: #fff;
		  color 			: black;
		}	
	</style>

</head>

<body ng-app="myApp" ng-controller="CtrlRAM" ng-cloak>
<!--	<input ng-model="accion" 	type="hidden" 	ng-init="accion='<?php echo $accion; ?>'"> -->
	<input ng-model="accion" 	type="hidden" 	ng-init="iniciaVariables('<?php echo $accion; ?>', '<?php echo $RAM; ?>', '<?php echo $Fan; ?>')">

	<?php 
		include_once('head.php');
	?>
	<nav class="navbar navbar-expand-lg navbar-dark bg-danger static-top">
		<div class="container-fluid">
  	    	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
	          <span class="navbar-toggler-icon"></span>
	        </button>
	    	<div class="collapse navbar-collapse" id="navbarResponsive">

				<a class="navbar-brand" href="#">
					<img src="../../imagenes/simet.png" alt="logo" style="width:40px;">
				</a>


	      		<ul class="navbar-nav ml-auto">
				  <?php if($_SESSION['IdPerfil'] != 4){?>
	        		<li class="nav-item active">
	          			<a class="nav-link" href="../../plataformaErp.php">
						  <img src="../../gastos/imagenes/Menu.png" width="20"> 
						  Principal
	              		</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link" href="../">
						  <img src="../../imagenes/materiales.png" width="20"> 
						   Muestras
	              		</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link" href="../../procesosangular/plataformaCotizaciones.php">
						  <img src="../../imagenes/other_48.png" width="20"> 
						   Procesos
	              		</a>
	        		</li>
					<?php } ?>
	        		<li class="nav-item">
	          			<a class="nav-link" href="../../RAMterminadas/ramTerminadas.php"> 
						  <img src="../../imagenes/materiales.png" width="20"> 
						  Inventario
	              		</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link" href="index.php?accion=Agrega"> 
						  <img src="../../imagenes/inventarioMuestras.png" width="20"> 
						  + Muestra
	              		</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="../../cerrarsesion.php"> Cerrar</a>
	        		</li>
	      		</ul>
	    	</div>
	  	</div>
	</nav>
	
<div class="container-fluid p-2">
	<div class="row">
		<div class="col-6">

		<form name="Muestras">
		<div class="card">
			<div class="card-header">FORMULARIO DE MUESTRAS</div>
			<div class="card-body">
				<div class="row" ng-show="tablaCAM">
					<div class="col-md-1">
						RAM 
					</div>
					<div class="col-md-2">
						<h5>{{ RAM }}</h5>
					</div>
					<div class="col-md-1">
						CAM 
					</div>
					<div class="col-md-2">
						<h5>{{ CAM }}</h5>
					</div>
					<div class="col-md-2" ng-show="Fan == 0">
						Nº CLONES
					</div>
					<div class="col-md-2" ng-show="Fan == 0">
						<input 	ng-model="Copias" 
								class="form-control"
								ng-disabled="Fan>0"
								maxsize="2"
								maxlength="2">
					</div>
					<div class="col-md-1" ng-show="Fan > 0">
						Clon
					</div>
					<div class="col-md-2" ng-show="Fan > 0">
						{{ Fan }}
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-2">
						Fecha Recepción 
					</div>
					<div class="col-md-3">
						<input type="date" class="form-control" ng-model="fechaRegistro" require>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-2">
						Cliente 
					</div>
					<div class="col-md-10">
						<select ng-model="RutCli" class="form-control" ng-change="leerContacto()" required>
	                		<option value="">Selecionar Cliente</option>
	                  		<option ng-repeat="cli in dataClientes" value="{{cli.RutCli}}">
	                    	{{cli.Cliente}}
	                  		</option>
	              		</select>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-2">
						Descripción 
					</div>
					<div class="col-md-10">
						<textarea ng-model="Descripcion" name="Descripcion" class="form-control">{{Descripcion}}</textarea>
					</div>
				</div>
			</div> 
			<div class="card-footer">
				<button ng-show="botonGuardar" 		type="button" class="btn btn-info" ng-click="guardarRAM()">Guardar</button>
				<button ng-show="botonAct" 			type="button" class="btn btn-info" ng-click="agregarRAM()">Agregar Muestra</button>
				<button ng-show="botonBaja" 		type="button" class="btn btn-danger" ng-click="bajaRAM()">Dar de Baja muestra</button> 
			</div>
		</div>
		</form>
		</div>
		<div class="col-6" ng-show="tablaCAM">
			<div class="card">
				<div class="card-header">CAM ACTIVAS</div>
					<div class="card-body">
						<?php include_once('listaCAMActivas.php'); ?> 
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

	<script src="../../jsboot/bootstrap.min.js"></script>
	<script src="../../jquery/jquery-3.3.1.min.js"></script>

	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src= "registro.js"></script>
	
</body>
</html>

