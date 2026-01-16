<?php
	session_start(); 

	include_once("../conexionli.php");
    date_default_timezone_set("America/Santiago");
    $fechaHoy = date('Y-m-d');    
    if(!isset($_GET['up'])){
        $agnoActual = date('Y'); 
        //$vDir = 'Y://AAA/Archivador-'.$agnoActual.'/Laboratorio/RespaldoTracciones'; 
        $vDir = 'Y://AAA/LE/LABORATORIO/'.$agnoActual.'/RespaldoTracciones'; 
        if(!file_exists($vDir)){
            mkdir($vDir);
        }
    }    
?>
<!DOCTYPE html>
<html>
<head>
	<title>Tracciones</title>
    <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">

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
        <div class="card mt-2">
            <div class="card-header font-weight-bold bg-primary text-white"> 
                <b>Tracciones a Ensayar </b>

            </div>
            <div class="card-body">
                <button type="button" class="btn btn-primary m-2" ng-click="mostrarTracciones(x.RAM)" ng-repeat="x in dataTracciones"> 
                    {{x.RAM}} 
                    <span class="badge badge-warning">{{x.cEnsayosP}}/{{x.cEnsayos}}</span> 
                </button>
            </div>
        </div>

        <div class="card mt-2" ng-show="muestraOtamsTracciones">
            <div class="card-header font-weight-bold bg-primary text-white">
                <b>Tracción <h4>{{RAM}}</h4> </b>
            </div>
            <div class="card-body">
                <div class='row'>
                    <div col="col bg-primary">
                        <!-- <button type="button" class="btn btn-info m-2" ng-if="x.equipo == 'Tr-30'" ng-click="cargarResultadosEnsayos(x.idItem)" ng-repeat="x in dataTraccionesOtam">  -->
                        <button type="button" class="btn btn-info m-2" ng-click="cargarResultadosEnsayos(x.idItem)" ng-repeat="x in dataTraccionesOtam"> 
                            {{x.idItem}} 
                            <span class="badge badge-warning">{{x.tpMuestra}}</span> 
                            <div>{{x.equipo}}</div>
                        </button>
                    </div>
                </div>

                <!-- <div class='row'>
                    <div class="col bg-warning">
                        <button type="button" class="btn btn-info m-2" ng-if="x.equipo == 'Tr-100'" ng-click="cargarResultadosEnsayosTr100(x.idItem)" ng-repeat="x in dataTraccionesOtam"> 
                            {{x.idItem}} 
                            <span class="badge badge-warning">{{x.tpMuestra}}</span> 
                            <div>{{x.equipo}}</div>
                        </button>
                    </div>
                </div> -->

                <!-- <div class='row'>
                    <div class="col bg-danger">
                        <button type="button" class="btn btn-info m-2" ng-if="x.equipo == ''" ng-click="cargarResultadosEnsayosTr100(x.idItem)" ng-repeat="x in dataTraccionesOtam"> 
                            {{x.idItem}} 
                            <span class="badge badge-warning">{{x.tpMuestra}}</span> 
                            <div>{{x.equipo}}</div>
                        </button>
                    </div>
                </div> -->
            </div>
        </div>

<!--
        <h2>Resultados Tracciones {{Otam}}</h2>
        <?php
        /*
            $from = 'D:\\Data\Usuario\Desktop\MT';
            chdir($from);
            $dir = opendir($from);

            //Recorro el directorio para leer los archivos que tiene
            while(($file = readdir($dir)) !== false){
                //Leo todos los archivos excepto . y ..
                if(strpos($file, '.') !== 0){
                    //Copio el archivo manteniendo el mismo nombre en la nueva carpeta
                    ?>
                    <button type="button" class="btn btn-primary m-2" ng-click="anexaCarpeta('<?php echo $file; ?>')"><?php echo $file; ?></button>
                    <?php
                    // echo $file.'<br>';
                    // if(!file_exists($to)){
                    //     mkdir($to);
                    // }
                
                    // echo $from.'/'.$file.' a '. $to.'/'.$file.'<br>';
                    // copy($from.'/'.$file, $to.'/'.$file);
                }
            }
            */
        ?>
-->
        <div class="row" ng-show="ficherosTracciones">
                <div class="card">
                    <div class="card-header font-weight-bold bg-primary text-white">
                        <b>Selecciones Archivos Asociados al Ensayo de Tracción Maquina Tr-30 <b>{{Otam}}</b> </b>
                    </div>
                    <div class="card-body">
                        <input id="archivosSeguimiento" ng-modal="archivosSeguimiento" multiple type="file"> {{pdf}}
                        <button class="btn btn-success" type="button" ng-click="enviarFormularioSeg()">
                            Subir Archivo
                        </button>
                    </div>
                </div>
        </div>

        <div class="row" ng-show="ficherosTraccionesTr100"> 
                <div class="card">
                    <div class="card-header font-weight-bold bg-primary text-white">
                        <b>Selecciones Archivos Asociados al Ensayo de Tracción  <b>{{Otam}}</b> </b>
                    </div>
                    <div class="card-body">
                        <input id="archivosSeguimientoT100" ng-modal="archivosSeguimientoT100" multiple type="file"> {{pdf}}
                        <button class="btn btn-success" type="button" ng-click="enviarFormularioTr100()">
                            Subir Archivo
                        </button>
                    </div>
                </div>
        </div>


        <div class="card m-2" ng-show="resultadosTracciones">
            <div class="card-title bg-primary text-white">
                <h3 class="panel-title">Tabla de Resultados ensayo <h4>{{idItem}}</4></h3>
            </div>
            <div class="card-body  text-center">
                <div class="row">
                    <div class="col-1">
                        <div class="form-group">
                            <label for="idItem">Ensayo:</label>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group">
                            <label for="fechaRegistro">Fecha:</label>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group">
                            <label for="Humedad">Humedad:</label>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group">
                            <label for="Temperatura">Temperatura:</label>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group">
                            <label for="Espesor" ng-if="Espesor > 0">Espesor:</label>
                            <label for="Espesor" ng-if="Di > 0">Diametros:</label>
                        </div>
                    </div>
                    <div class="col-1" ng-if="Ancho > 0">
                        <div class="form-group">
                            <label for="Ancho">Ancho:</label>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group">
                            <label for="Area">Área:</label>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group">
                            <label for="CargaFluencia">Carga de Fluencia:</label>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group">
                            <label for="CargaFluencia">Carga de UTS:</label>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group">
                            <label for="CargaFluencia">Tensión de Fluencia:</label>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group">
                            <label for="CargaFluencia">Tensión de UTS:</label>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group">
                            <label for="CargaFluencia">Alargamiento:</label>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-1">
                        <div class="form-group">
                            <b>{{idItem}}</b>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group">
                            <b>{{fechaRegistro | date:'dd-MM-yyyy'}}</b>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group">
                            <b>{{Humedad}}</b>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group">
                            <b>{{Temperatura}}</b>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group">
                            <div ng-if="Espesor > 0">
                                <b>{{Espesor}}</b>
                            </div>
                            <div ng-if="Di > 0">
                                <b>{{Di}} - {{Df}}</b>
                            </div>
                        </div>
                    </div>
                    <div class="col-1"  ng-if="Ancho > 0">
                        <div class="form-group">
                            <b>{{Ancho}}</b>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group">
                            <b>{{aIni}}</b>
                        </div>
                    </div>                    
                    <div class="col-1">
                        <div class="form-group">
                            <b>{{cFlu}}</b>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group">
                            <b>{{cMax}}</b>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group">
                            <b>{{tFlu}}</b>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group">
                            <b>{{tMax}}</b>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group">
                            <b>{{aSob}}</b>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-1">
                        <div class="form-group">
                            <label for="CargaFluencia">Length Inicial:</label>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group">
                            <label for="CargaFluencia">Length Final:</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-1">
                        <div class="form-group">
                            <b>{{Li}}</b>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group">
                            <b>{{Lf}}</b>
                        </div>
                    </div>

                </div>
            </div>	

        </div>	
    </div>
    
    <script src="../bootstrap/css/bootstrap.min.js"></script>  
    <script src="../angular/angular.min.js"></script>
	<script src="tracciones.js"></script>

</body>
</html>

<?php
function comparaValor($vExcel, $vDefecto){
   $resultado = '';
   $vDefectoBd = $vDefecto;
   $vDefecto = substr($vDefecto,1);
   if($vExcel == $vDefecto){
        $resultado = $vExcel;
        // $actSQL.="cC		    ='".$sheet->getCell("E".$row)->getValue().	"',";
    }
    if($vExcel < $vDefecto){
        $resultado = $vDefectoBd;
        // $actSQL.="cC		    ='".$rsd['valorDefecto'].	"',";
    }
    if($vExcel > $vDefecto){
        $resultado = $vExcel;
        // $actSQL.="cC		    ='".$sheet->getCell("E".$row)->getValue().	"',";
    }
    return $resultado;
}
?>