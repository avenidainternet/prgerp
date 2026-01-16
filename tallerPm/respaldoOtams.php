<?php
	session_start();
    include_once("../conexionli.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Leer Archivo Excel usando PHP</title>
    <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">

    <link href="styles.css" 	rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	<script src="../jsboot/bootstrap.min.js"></script>	

<body ng-app="myApp" ng-controller="ctrlEspectometro" ng-cloak>
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
	          			<a class="nav-link fas fa-power-off" href="Espectrometro.php"> Espectrometro</a>
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
            <div class="col">
                <div class="card">
                    <div class="card-header font-weight-bold bg-primary text-white">
                        <b>Respaldos Otams</b>
                    </div>
                    <div class="card-body">

                        <?php

                            // 1. Cargar el contenido del archivo
                            $json_data = file_get_contents('resultadosQu/vEspectrometro.json');

                            // 2. Decodificar el JSON a un array asociativo de PHP
                            $data = json_decode($json_data, true);

                            
                            // 3. Verificar si existen registros y recorrerlos
                            if (isset($data['records'])) {
                                $link=Conectarse();

                                $ramOld = '';
                                foreach ($data['records'] as $item) {

                                    // Acceder al valor de idItem
                                    $idItem = htmlspecialchars($item['idItem']);
                                    $fd = explode('-', $idItem);
                                    $RAM = $fd[0];

                                    if($RAM != $ramOld){
                                        $SQL = "SELECT * FROM otams Where otam = '$idItem' and Respaldado != 'on'";
                                        $bd=$link->query($SQL);
                                        if($rs=mysqli_fetch_array($bd)){?>
                                            <a href="formularios/otamQuimicoEspPruebas.php?idItem=<?php echo $idItem; ?>" type="button" class="btn btn-danger">Respaldar OTAM <?php echo $RAM; ?></a>
                                            <?php
                                        }
                                        $ramOld = $RAM;
                                    }
                                }
                                $link->close();
                                
                            }

                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="../bootstrap/css/bootstrap.min.js"></script> 
    <script src="../angular/angular.min.js"></script>
	<script src="espectrometroXXX.js"></script>

</body>
</html>
