<?php
	session_start(); 
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
	$nEnc = 0;
	
?>
<!doctype html>
 
<html lang="es">
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Masivos</title>

	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	<script type="text/javascript" src="../angular/angular.js"></script>

	<script src="../jquery/jquery-1.11.0.min.js"></script>
	<script src="../jquery/jquery-migrate-1.2.1.min.js"></script>	

	<script type="text/javascript" src="../jquery/libs/1/jquery.min.js"></script>	

	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<script>
	
	function realizaProceso(dBuscar, Marcar){
		var parametros = {
			"dBuscar" 	: dBuscar,
			"Marcar" 	: Marcar
		};
		//alert(dBuscar);
		$.ajax({
			data: parametros,
			url: 'muestraClientes.php',
			type: 'get',
			beforeSend: function () {
				$("#resultado").html("<div id='cajaRegistraPruebas'><img src='../imagenes/ajax-loader.gif'></div>");
			},
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}
	
	function enviarMasivo(Reg){
		var parametros = {
			"Reg" 		: Reg
		};
		//alert(Reg[1]);
		$.ajax({
			data: parametros,
			url: 'formCorreoMasivo.php',
			type: 'get',
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}
	</script>

</head>

<body ng-app="myApp" ng-controller="CtrlMasivos">
	<?php include('head.php'); ?>
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
	          			<a class="nav-link fas fa-power-off text-dark" href="../cerrarsesion.php"> Cerrar</a>
	        		</li>

	      		</ul>
	    	</div>
	  	</div>
	</nav> 






	<?php include_once('listaMasivos.php'); ?>



	<script src="Masivos.js"></script>

	
</body>
</html>
