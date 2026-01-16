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
        <h2>Resultados Espectrometro</h2>
        <div class="row">
            <!--
            <div class="col-6">
                <div class="card">
                    <div class="card-header font-weight-bold bg-primary text-white">
                        <b>Archivos Asociados al Ensayo</b>
                    </div>
                    <div class="card-body">
                        <input id="archivosSeguimiento" multiple type="file"> {{pdf}}
                        <button class="btn btn-success" type="button" ng-click="enviarFormularioSeg()">
                            Subir Archivo
                        </button>
                    </div>
                </div>
            </div>
            -->
            <div class="col">
                <div class="card">
                    <div class="card-header font-weight-bold bg-primary text-white">
                        <b>Temperatura y Humedad</b>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <div class="mb-3">
                                    <label for="Temperatura" class="form-label">Temperatura</label>
                                    <input type="text" class="form-control" id="Temperatura" ng-model="Temperatura" name="Temperatura" placeholder="19">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="mb-3">
                                    <label for="Humedad" class="form-label">Humedad</label>
                                    <input type="text" class="form-control" id="Humedad" ng-model="Humedad" name="Humedad" placeholder="55">
                                </div>
                            </div>
                            <div class="col-3">
                                <label for="Temperatura" class="form-label">Fecha Ensayo(s)</label>
                                <input type="date" class="form-control" id="fechaRegistro" ng-model="fechaRegistro" name="fechaRegistro">
                            </div>
                            <div class="col-3">
                                <label for="Temperatura" class="form-label">Técnico Responsable</label>
								<select tabindex="10" class="form-control" ng-model="tecRes" name="tecRes">
									<option value="GRC">GRC </option>
									<option value="SML">SML </option>
									<option value="RPM">RPM </option>
									<option value="AVR">AVR	</option>
								</select>	
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-1">
                                <button type="button" class="btn btn-success" ng-click="registrarDatos()" >Registrar Datos</button>
                            </div>
                            <div class="col-md-10">
                                <div class="alert alert-success" ng-show="msgUsr">
                                    <h2>Información!</h2> <h4>{{msg}}</h4> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php 
//            if($_SESSION['IdPerfil'] == 'WM'){
//                ?>
<!--                
                <div class="card m-2">
                    <div class="card-title bg-primary text-white">
                        <h3 class="panel-title">PDF</h3>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-primary m-2" ng-click="mostrarTracciones(x.RAM)" ng-repeat="x in dataRAMs"> 
                            {{x.RAM}}
                        </button>
                    </div>
                </div>
-->            
//                <?php
//            }
//             ?>


        <div class="card m-2">
            <div class="card-title bg-primary text-white">
                <h3 class="panel-title">Resultados de archivo de Excel.</h3>
            </div>
            <div class="card-body">
                <div class="col-lg-12">
                
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th>#</th>
                            <th>OTAM</th>
                            <th>Programa</th>
                            <th>Tipo</th>
                            <th>C</th>
                            <th>Si</th>
                            <th>Mn</th>
                            <th>P</th>
                            <th>S</th>
                            <th>Cr</th>
                            <th>Ni</th>
                            <th>Mo</th>
                            <th>Al</th>
                            <th>Cu</th>
                            <th>Co</th>
                            <th>Ti</th>
                            <th>Nb</th>
                            <th>V</th>
                            <th>W</th>
                            <th>B</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="x in dataEspectometro"> 
                                <td>  </td>
                                <td> {{x.RAM}} </td>
                                <td> {{x.Programa}} </td>
                                <td> {{x.Tipo}} </td>
                                <td> {{x.cC}} </td>
                                <td> {{x.cSi}} </td>
                                <td> {{x.cMn}} </td>
                                <td> {{x.cP}} </td>
                                <td> {{x.cS}} </td>
                                <td> {{x.cCr}} </td>
                                <td> {{x.cNi}} </td>
                                <td> {{x.cMo}} </td>
                                <td> {{x.cAl}} </td>
                                <td> {{x.cCu}} </td>
                                <td> {{x.cCo}} </td>
                                <td> {{x.cTi}} </td>
                                <td> {{x.cNb}} </td>
                                <td> {{x.cV}} </td>
                                <td> {{x.cW}} </td>
                                <td> {{x.cB}} </td> 
                            </tr>                            
                        </tbody> 
                    </table>

            </div>	
        </div>	

    </div> 

    <script src="../bootstrap/css/bootstrap.min.js"></script>
    <script src="../angular/angular.min.js"></script>
	<script src="espectrometroJSON.js"></script>

</body>
</html>
