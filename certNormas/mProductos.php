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
	if(isset($_GET['nNorma'])){
		$nNorma = $_GET['nNorma'];
	}
	if(isset($_GET['CodCertificado'])){
		$CodCertificado = $_GET['CodCertificado'];
	}
	
?>
<!doctype html>
 
<html lang="es">
<head>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Normas</title>

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
						<?php $arLink = '../certNormas/?CodCertificado='.$CodCertificado; ?>
	          			<a href="<?php echo $arLink;?>" class="nav-link fas fa-address-card text-dark"> Volver</a>
	        		</li>

	        		<li class="nav-item">
	          			<a class="nav-link fas fa-address-card text-dark" href="certTipoProductos/?CodCertificado=<?php echo $CodCertificado;?>"> Productos</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-address-card text-dark" href="../certAceros/"> ºAceros</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-address-card text-dark" href="../certNormas/"> Normas</a>
	        		</li>

					
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off text-dark" href="../cerrarsesion.php"> Cerrar</a>
	        		</li>

	      		</ul>
	    	</div>
	  	</div>
	</nav> 

<style type="text/css">
	.uppercase { text-transform: uppercase; }
</style>

	<div class="container-fluid">
		<div class="card m-2">
			<div class="card-header bg-info text-white"><h5>Descripción de Normas</h5></div>
		  	<div class="card-body">
		  		<form name="myForm" enctype="multipart/form-data">

				<div class="row">
		  			<div class="col-md-1">
					  	<div class="form-group">
				    		<label for="CodCertificado">Id.Norma:  </label><br>
				    	</div>
				    </div>
		  			<div class="col-md-1">
                        <div class="form-group">
					    	<input 	ng-model="nNorma" 
					    			name="nNorma"
					    			class="form-control uppercase" 
					    			ng-init="loadDataCertificado('<?php echo $nNorma; ?>')"
					    			type="text"
					    			size="3"
					    			maxlength="3" readonly>
                        </div>
					</div>
					<div class="col-md-1">
						<div class="form-group">
							<label for="fechaCertificado">Norma:  </label>
						</div>
					</div>
					<div class="col-md-7">
						<div class="form-group">
							<textarea ng-model="Norma" name="Norma" class="form-control" rows="5"></textarea>
							<!--
							<input 	ng-model="Norma" 
					    			name="Norma"
					    			class="form-control uppercase" 
					    			type="text" required autofocus>
							-->
						</div>
					</div>

				</div>
			</div>
			<div class="card-footer">
		  		
		  		<button type="button" 
		  				class="btn btn-info"
		  				ng-click="guardarDatosCertificado()" 
		  				>
		  				Guardar
		  		</button>
		  		<span ng-show="muestraBotones">
				  		<button type="button" ng-show="desabilitar"  	ng-click="desabilitarDatos()" class="btn btn-warning">Deshabilitar</button>
				  		<button type="button" ng-show="habilitar" 		ng-click="habilitarDatos()" class="btn btn-primary">Habilitar</button>

				</span>
		  		{{rutRes}}
		  		</div>
		  	</div>

		</div>
	</div>


	<script src="mProductos.js"></script> 
</body>
</html>