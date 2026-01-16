<?php
    session_start(); 
	include_once("../conexionli.php");

?>
<!DOCTYPE html>
<html>
<head>
	<title>Leer Archivo Excel usando PHP</title>
    <link href="styles.css" 	rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	<script src="../jsboot/bootstrap.min.js"></script>	

<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"> -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> -->
</head>
<body ng-app="myApp" ng-controller="ctrlEspectometro">

    <?php include('head.php'); ?>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
		<div class="container-fluid">
  	    	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
	          <span class="navbar-toggler-icon"></span>
	        </button>
	    	<div class="collapse navbar-collapse" id="navbarResponsive">



				<a class="navbar-brand" href="#">
					<img src="../imagenes/simet.png" alt="logo" style="width:40px;">
				</a>



	      		<ul class="navbar-nav ml-auto">
					<?php
					if($_SESSION['IdPerfil'] != 5){?>
		        		<li class="nav-item active">
		          			<a class="nav-link fa fa-home" href="http://servidorerp/erp/plataformaErp.php"> Principal
		                	<span class="sr-only">(current)</span>
		              		</a>
		        		</li>
		        		<?php
		        	}
		        	?>
	          			<!-- <a class="nav-link fas fa-power-off" href="http://servidordata/erperp/tallerPM/pTallerPM.php"> Ensayos</a> -->
	          			<a class="nav-link fas fa-power-off" href="http://servidorerp/erp/tallerPM/pTallerPM.php"> Ensayos</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="../cerrarsesion.php"> Cerrar</a>
	        		</li>

	      		</ul>
	    	</div> 
	  	</div>
	</nav>

    <div class="container-fluid">
        <div class="card m-1">
            <div class="card-title bg-primary text-white">
                <h3 class="panel-title">Orientación</h3>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-primary m-2" ng-click="actualizarTablaEnsayos(x.RAM)" ng-repeat="x in dataRAMs"> 
                    {{x.RAM}}
                    <span class="badge badge-warning">{{x.cEnsayosP}}/{{x.cEnsayos}}</span> 
                </button>
            </div>
        </div>

        <div class="card m-1">
            <div class="card-title bg-primary text-white">
                <h3 class="panel-title">Orientaciones Ensayos {{RAM}}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="card m-1">
                            <div class="card-title bg-primary text-white">
                                <h3 class="panel-title">Ensayos</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Ensayo</th>
                                            <th>Seleccionar</th>
                                        </tr>
                                    </thead>
                                    <tbody  ng-repeat="x in dataEnsayosDisponibles">
                                        <tr>
                                            <td> {{x.idItem}}</td>
                                            <td>
                                                <button class="btn btn-success" type="button" ng-click="SelecionarEnsayo(x.idItem)">
                                                    Seleccionar
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                    <div class="card m-1">
                            <div class="card-title bg-primary text-white">
                                <h3 class="panel-title">Orientaciónes PDF</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Ensayo</th>
                                            <th>Subir</th>
                                        </tr>
                                    </thead>
                                    <tbody  ng-repeat="x in dataEnsayosSeleccionados">
                                        <tr>
                                            <td> {{x.idItem}}</td>
                                            <td>
                                                <button class="btn btn-success" type="button" ng-click="quitarEnsayo(x.idItem)">
                                                    Quitar
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                <input id="archivosSeguimiento" ng-modal="archivosSeguimiento" multiple type="file"> {{pdf}}
                                <button class="btn btn-success" type="button" ng-click="enviarFormularioSeg(x.idItem)">
                                    Subir Archivo
                                </button>

                            </div>
                        </div>

                    </div>
                </div>



                <div class="row">
                    <div class="col bg-success" ">
                       
                    </div>
                </div>
            </div>
        </div>

    </div> 

    <script src="../bootstrap/css/bootstrap.min.js"></script>
    <script src="../angular/angular.min.js"></script>
	<script src="orientacion.js"></script>

</body>
</html>
