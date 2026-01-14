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
		$bdPer=$link->query("SELECT * FROM perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		$link->close();
	}else{
		header("Location: ..index.php"); 
	}
	$CodCertificado = '';
	if (isset($_GET['CodCertificado'])){
		$CodCertificado = $_GET['CodCertificado'];
	}
	
?>
<!doctype html>
 
<html lang="es">
<head>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Certificado de Productos</title>

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
	          			<a class="nav-link fas fa-address-card" ng-click="verClientes()"> Clientes</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-address-card" href="mCertificados.php?CodCertificado="> +Certificado</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-address-card" href="../certrar"> Volver AR</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="../cerrarsesion.php"> Cerrar</a>
	        		</li>

	      		</ul>
	    	</div>
	  	</div>
	</nav> 

<style type="text/css">
	.uppercase { text-transform: uppercase; }
</style>

	<div class="row bg-info text-white m-1" style="padding: 10px;">
			<div class="col-2">
				Certificados AR
			</div>
			<div class="col-2">
				<input 	class 		= "form-control uppercase" 
						ng-init		= "cargarCert('<?php echo $CodCertificado; ?>')"
						ng-model	= "bCertificado" 
						type		= "text" readonly>
			</div>
			<div class="col-1">
			</div>
			<div class="col-5">
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
	  	<table class="table table-dark table-hover table-bordered" ng-show="tCertificados">
	    	<thead>
	      		<tr>
			        <th>Certificados</th>
			        <th>Clientes</th>
			        <th>Lote</th>
			        <th>Fecha Web</th>
			        <th>Acciones</th>
	      		</tr>
	    	</thead>
	    	<tbody> 
	      		<tr ng-repeat="x in Certificados | filter : bCertificado"
	      			ng-class="{'pasivo-class': x.upLoad == 'off', 'default-color': x.pdf != ''}">
			        <td><b>{{x.CodCertificado}}</b></td>
			        <td><b>{{x.Cliente}}</b></td>
			        <td>{{x.Lote}}</td>
			        <td>
						<div ng-if="x.fechaUpLoad != '0000-00-00'">
							{{x.fechaUpLoad | date:'dd-MM-yyyy'}} 
						</div>
						<br>
						{{x.pdf}} 
					</td> 
			        <td>
			        	<a 	class="btn btn-warning" role="button"
	        				href="mCertificados.php?CodCertificado={{x.CodCertificado}}">Editar</a>
	        		</td>
	      		</tr>
	    	</tbody>
	  </table>

	</div>


	<div style="clear:both; "></div>
	<br>
	<script src="Productos.js"></script>

</body>
</html>
