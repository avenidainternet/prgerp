<?php
	session_start(); 
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
		header("Location: ../index.php");
	}

	$nRegistros = 100;
	if(!isset($inicio)){
		$inicio = 0;
		$limite = 100;
	}
	if(isset($_GET['limite'])){
		$inicio = $_GET['limite']-1;
		$limite = $inicio+$nRegistros;
	}
	if(isset($_GET['inicio'])){
		if($_GET['inicio']==0){
			$inicio = 0;
			$limite = 100;
		}else{
			$inicio = ($_GET['inicio']-$nRegistros)+1;
			$limite = $inicio+$nRegistros;
		}
	}
	if(isset($_GET['ultimo'])){
		$link=Conectarse();
		$bdGto	=	$link->query("SELECT * FROM MovGastos");
		$inicio	=	mysql_num_rows($bdGto) - $nRegistros;
		$limite	=	mysql_num_rows($bdGto);
		$link->close();
	}
	
?>
<!doctype html>
 
<html lang="es">
<head>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Intranet Simet</title>

	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="..css/tpv.css" rel="stylesheet" type="text/css">
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

	<script src="../ckeditor/ckeditor.js"></script>
	<script src="../ckeditor/samples/js/sample.js"></script>
	<link rel="stylesheet" href="../ckeditor/samples/css/samples.css">
	<link rel="stylesheet" href="../ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">

	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

	<script type="text/javascript" src="../angular/angular.js"></script>
</head>

<body onLoad="document.form.Cantidad.focus();" ng-app="">
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
	          			<a class="nav-link fas fa-address-card" href="clientes.php"> Clientes</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-book" href="plataformaFacturas.php"> Solicitud</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="../cerrarsesion.php"> Cerrar</a>
	        		</li>

	      		</ul>
	    	</div>
	  	</div>
	</nav>

	<?php include_once('formularioSolicitudNew.php'); ?>

	<script src="../jsboot/bootstrap.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script>
		$(document).ready(function() {
    		$('#usuarios').DataTable({
    			"order": [[ 0, "asc" ]]
    		});

		} );	
	</script>
	
	
</body>
</html>
