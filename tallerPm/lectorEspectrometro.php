<?php
	session_start(); 

	include_once("../conexionli.php");
    date_default_timezone_set("America/Santiago");
    $fechaHoy = date('Y-m-d');    
    if(!isset($_GET['up'])){
        $agnoActual = date('Y'); 
        $vDir = 'Y://AAA/Archivador-'.$agnoActual.'/Laboratorio/RespaldoEspectrometro'; 
        $archivo = $vDir.'/Espectrometro-'.$fechaHoy.'.xlsx';
        if(file_exists($archivo)){
            unlink($archivo);
        }
    }    
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
            <!--
            <div class="col-6">
                <div class="card">
                    <div class="card-header font-weight-bold bg-primary text-white">
                        <b>Temperatura y Humedad</b>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="Temperatura" class="form-label">Temperatura</label>
                                    <input type="text" class="form-control" id="Temperatura" ng-model="Temperatura" name="Temperatura" placeholder="19">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="Humedad" class="form-label">Humedad</label>
                                    <input type="text" class="form-control" id="Humedad" ng-model="Humedad" name="Humedad" placeholder="55">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <label for="Temperatura" class="form-label">Fecha Ensayo(s)</label>
                                <input type="date" class="form-control" id="fechaRegistro" ng-model="fechaRegistro" name="fechaRegistro">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            -->
        </div>

        <div class="card m-2">
            <div class="card-title bg-primary text-white">
                <h3 class="panel-title">Resultados de archivo de Excel.</h3>
            </div>
            <div class="card-body">
                <div class="col-lg-12">
                
                <?php
                require_once '../PHPExcel/Classes/PHPExcel.php';
                $archivo = "resultadosQu/prueba.xlsx";

                $agnoActual = date('Y'); 
                $vDir = 'Y://AAA/Archivador-'.$agnoActual.'/Laboratorio/RespaldoEspectrometro'; 

                $archivo = $vDir.'/Espectrometro-'.$fechaHoy.'.xlsx';
                
                if(file_exists($archivo)){
                    echo 'Existe ........'.$archivo;
                    // $archivo = "resultadosQu/prueba.xlsx";
                    $inputFileType = PHPExcel_IOFactory::identify($archivo);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($archivo);
                    $sheet = $objPHPExcel->getSheet(0); 
                    $highestRow = $sheet->getHighestRow(); 
                    $highestColumn = $sheet->getHighestColumn();?>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th>#</th>
                            <th>RAM</th>
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
                            <?php
                            
                            $num=0;
                            $aTit = [];
                            for ($row = 1; $row <= 1; $row++){
                                $aTit[] = $sheet->getCell("A".$row)->getValue();
                                $aTit[] = $sheet->getCell("C".$row)->getValue();
                                $aTit[] = $sheet->getCell("D".$row)->getValue();
                                $aTit[] = $sheet->getCell("E".$row)->getValue();
                                $aTit[] = $sheet->getCell("F".$row)->getValue();
                                $aTit[] = $sheet->getCell("G".$row)->getValue();
                                $aTit[] = $sheet->getCell("H".$row)->getValue();
                                $aTit[] = $sheet->getCell("I".$row)->getValue();
                                $aTit[] = $sheet->getCell("J".$row)->getValue();
                                $aTit[] = $sheet->getCell("K".$row)->getValue();
                                $aTit[] = $sheet->getCell("L".$row)->getValue();
                                $aTit[] = $sheet->getCell("M".$row)->getValue();
                                $aTit[] = $sheet->getCell("N".$row)->getValue();
                                $aTit[] = $sheet->getCell("O".$row)->getValue();
                                $aTit[] = $sheet->getCell("P".$row)->getValue();
                                $aTit[] = $sheet->getCell("Q".$row)->getValue();
                                $aTit[] = $sheet->getCell("R".$row)->getValue();
                                $aTit[] = $sheet->getCell("S".$row)->getValue();
                                $aTit[] = $sheet->getCell("T".$row)->getValue();



                            }
                            //echo $aTit[4];
                            $outp = '';

                            for ($row = 2; $row <= $highestRow; $row++){ 
                                if($sheet->getCell("D".$row)->getValue() == 'Average' and $sheet->getCell("C".$row)->getValue() != 'Fe-01-M' and $sheet->getCell("A".$row)->getValue() != '' and $sheet->getCell("C".$row)->getValue() != 'Al-01-M' and $sheet->getCell("C".$row)->getValue() != 'Cu-01-M'	){
                                //if($sheet->getCell("D".$row)->getValue() == 'Average' and  $sheet->getCell("A".$row)->getValue() != ''){
                                    $num++;
                                    $fr = explode('-',$sheet->getCell("A".$row)->getValue());
                                    $Otam = $fr[0];
                                    if($fr[1]){
                                        $Otam .= '-'.$fr[1];
                                    }
                                    if(sizeof($fr) == 3 or sizeof($fr) == 4){
                                        $Otam .= '-'.$fr[2];
                                        if(substr($fr[2],0,1) == 'Q'){
                                            $Encontrado = 'No';

                                            $RAM = $sheet->getCell("A".$row)->getValue();
                                            if ($outp != "") {$outp .= ",";}
                                            $outp .= '{"RAM":"'  			    . $RAM 			. '",'; 
                                            $outp .= '"Programa":' 	            .json_encode($sheet->getCell("C".$row)->getValue(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
                                            $outp .= '"Tipo":"'  			    . $sheet->getCell("D".$row)->getValue() 			. '",';
                                            $outp .= '"cC":"'  			        . $sheet->getCell("E".$row)->getValue() 			. '",';
                                            $outp .= '"cSi":"'  			    . $sheet->getCell("F".$row)->getValue() 			. '",';
                                            $outp .= '"cMn":"'  			    . $sheet->getCell("G".$row)->getValue() 			. '",';
                                            $outp .= '"cP":"'  			        . $sheet->getCell("H".$row)->getValue() 			. '",';
                                            $outp .= '"cS":"'  			        . $sheet->getCell("I".$row)->getValue() 			. '",';
                                            $outp .= '"cCr":"'  			    . $sheet->getCell("J".$row)->getValue() 			. '",';
                                            $outp .= '"cNi":"'  			    . $sheet->getCell("K".$row)->getValue() 			. '",';
                                            $outp .= '"cMo":"'  			    . $sheet->getCell("L".$row)->getValue() 			. '",';
                                            $outp .= '"cAl":"'  			    . $sheet->getCell("M".$row)->getValue() 			. '",';
                                            $outp .= '"cCu":"'  			    . $sheet->getCell("N".$row)->getValue() 			. '",';
                                            $outp .= '"cCo":"'  			    . $sheet->getCell("O".$row)->getValue() 			. '",';
                                            $outp .= '"cTi":"'  			    . $sheet->getCell("P".$row)->getValue() 			. '",';
                                            $outp .= '"cNb":"'  			    . $sheet->getCell("Q".$row)->getValue() 			. '",';
                                            $outp .= '"cV":"'  			        . $sheet->getCell("R".$row)->getValue() 			. '",';
                                            $outp .= '"cW":"'  			        . $sheet->getCell("S".$row)->getValue() 			. '",';
                                            $outp .= '"cB":"'  			        . $sheet->getCell("T".$row)->getValue() 			. '",';
                                            $outp .= '"cZn":"'  			    . $sheet->getCell("U".$row)->getValue() 			. '",';
                                            $outp .= '"cPb":"'  			    . $sheet->getCell("V".$row)->getValue() 			. '",';
                                            $outp .= '"cSn":"'  			    . $sheet->getCell("W".$row)->getValue() 			. '",';
                                            $outp .= '"cFe":"'  			    . $sheet->getCell("X".$row)->getValue() 			. '",';
                                            $outp .= '"cTe":"'  			    . $sheet->getCell("Y".$row)->getValue() 			. '",';
                                            $outp .= '"cAs":"'  			    . $sheet->getCell("Z".$row)->getValue() 			. '",';
                                            $outp .= '"cSb":"'  			    . $sheet->getCell("AA".$row)->getValue() 			. '",';
                                            $outp .= '"cCd":"'  			    . $sheet->getCell("AB".$row)->getValue() 			. '",';
                                            $outp .= '"cBi":"'  			    . $sheet->getCell("AC".$row)->getValue() 			. '",';
                                            $outp .= '"cAg":"'  			    . $sheet->getCell("AD".$row)->getValue() 			. '",';
                                            $outp .= '"cZr":"'  			    . $sheet->getCell("AE".$row)->getValue() 			. '",';
                                            $outp .= '"cAu":"'  			    . $sheet->getCell("AF".$row)->getValue() 			. '",';
                                            $outp .= '"cSe":"'  			    . $sheet->getCell("AG".$row)->getValue() 			. '",';
                                            $outp .= '"cMg":"'	    			. $sheet->getCell("AH".$row)->getValue()  		    . '"}';
                                            ?>
                                            <tr>
                                                <th scope='row'><?php echo $num.' '.$Encontrado;?></th>
                                                <td><b><?php echo $sheet->getCell("A".$row)->getValue();?></b></td>
                                                <td><?php echo $sheet->getCell("C".$row)->getValue();?></td>
                                                <td><?php echo $sheet->getCell("D".$row)->getValue();?></td>
                                                <td><?php echo $sheet->getCell("E".$row)->getValue();?></td>
                                                <td><?php echo $sheet->getCell("F".$row)->getValue();?></td>
                                                <td><?php echo $sheet->getCell("G".$row)->getValue();?></td>
                                                <td><?php echo $sheet->getCell("H".$row)->getValue();?></td>
                                                <td><?php echo $sheet->getCell("I".$row)->getValue();?></td>
                                                <td><?php echo $sheet->getCell("J".$row)->getValue();?></td>
                                                <td><?php echo $sheet->getCell("K".$row)->getValue();?></td>
                                                <td><?php echo $sheet->getCell("L".$row)->getValue();?></td>
                                                <td><?php echo $sheet->getCell("M".$row)->getValue();?></td>
                                                <td><?php echo $sheet->getCell("N".$row)->getValue();?></td>
                                                <td><?php echo $sheet->getCell("O".$row)->getValue();?></td>
                                                <td><?php echo $sheet->getCell("P".$row)->getValue();?></td>
                                                <td><?php echo $sheet->getCell("Q".$row)->getValue();?></td>
                                                <td><?php echo $sheet->getCell("R".$row)->getValue();?></td>
                                                <td><?php echo $sheet->getCell("S".$row)->getValue();?></td>
                                                <td><?php echo $sheet->getCell("T".$row)->getValue();?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                }
                            }
                            $outp ='{"records":['.$outp.']}';
                            
                            $json_string = $outp;
                            //$file = 'X:\tallerPM\resultadosQu\vEspectrometro.json'; 
                            $file = 'resultadosQu\vEspectrometro.json'; 
                            file_put_contents($file, $json_string);
                                 
                            echo 'Entra...';
                            ?>
                            <script>
                               //window.location.href = 'http://servidorerp/erp/tallerPM/lectorEspectrometroJSON.php';
                               window.location.href = 'lectorEspectrometroJSON.php';
                            </script>

                        </tbody>
                    </table>
                <?php
                }
            ?>
            </div>	
        </div>	
    </div>
    
    <script src="../bootstrap/css/bootstrap.min.js"></script> 
    <script src="../angular/angular.min.js"></script>
	<script src="espectrometro.js"></script>

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