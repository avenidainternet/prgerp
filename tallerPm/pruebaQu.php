<?php
	session_start(); 

	include_once("../conexionli.php");
    // include_once('../PHPExcel/Classes/PHPExcel.php');

    
    date_default_timezone_set("America/Santiago");
    $fechaRegistro = date('Y-m-d');
    $Otam = $_GET['Otam'];

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

</head>
<body ng-app="myApp" ng-controller="ctrlEspectometro">
    {{5+5}}
    <?php echo $fechaRegistro; ?>

    <?php
        require_once '../PHPExcel/Classes/PHPExcel.php';

        $archivo = 'resultadoTr/'.$Otam.'/Traccion.xlsx';
        if(file_exists($archivo)){
            echo 'Existe...';
            $inputFileType = PHPExcel_IOFactory::identify($archivo);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($archivo);
            $sheet = $objPHPExcel->getSheet(0); 
            $highestRow = $sheet->getHighestRow(); 
            $highestColumn = $sheet->getHighestColumn();

            ?>
            <div class='container'>

                <table class="table table-bordered">
                    <thead>
                     <tr>
                         <th>Data</th>
                         <th>Valor</th>
                     </tr>
                    </thead>
                    <tbody>
                        <?php
                            $num=0;
                            $aTit = [];
                            for ($row = 8; $row <= $highestRow; $row++){
                                echo '<tr>';
                                        $aTit[] = $sheet->getCell("K".$row)->getValue();
                                        $aTit[] = $sheet->getCell("N".$row)->getValue();
                                echo '  <td>';
                                        echo $sheet->getCell("K".$row)->getValue();
                                echo '  </td>';
                                echo '  <td>';
                                        // echo $sheet->getCell("N".$row)->getValue();
                                        if($row == 8){
                                            $RAM = $sheet->getCell("N".$row)->getValue();
                                            echo $_GET['Otam'];
                                        }
                                        if($row == 9){
                                            echo $sheet->getCell("N".$row)->getValue();
                                        }
                                        if($row == 10){
                                            $Operador = $sheet->getCell("N".$row)->getValue();
                                            echo $Operador;
                                        }
                                        if($row == 11){
                                            $Humedad = $sheet->getCell("N".$row)->getValue();
                                            echo $Humedad;
                                        }
                                        if($row == 12){
                                            $Temperatura = $sheet->getCell("N".$row)->getValue();
                                            echo $Temperatura;
                                        }
                                        if($row == 14){
                                            $Fecha = $sheet->getCell("N".$row)->getValue();
                                            $Fecha = date('d-m-Y', $Fecha);
                                            echo $Fecha;
                                        }
                                        if($row == 16){
                                            echo $sheet->getCell("N".$row)->getValue();
                                        }

                                        if($row == 17){
                                            $Data = $sheet->getCell("N".$row)->getValue();
                                            $fd = explode('*', $Data);
                                            $Ancho = $fd[0];
                                            $Espesor = $fd[1];
                                            echo ' Ancho '.$Ancho. ' X Espesor '.$Espesor;
                                        }
                                        if($row == 18){
                                            $aIni = $sheet->getCell("N".$row)->getValue();
                                            echo $aIni;
                                        }

                                        if($row == 20){
                                            $cFlu = $sheet->getCell("N".$row)->getValue();
                                            echo $cFlu;
                                        }
                                        if($row == 21){
                                            $cMax = $sheet->getCell("N".$row)->getValue();
                                            echo 'cMax '.$cMax;
                                        }
                                        if($row == 22){
                                            $tFlu = $sheet->getCell("N".$row)->getValue();
                                            echo $tFlu;
                                        }
                                        if($row == 23){
                                            $tMax = $sheet->getCell("N".$row)->getValue();
                                            echo 'tMax '.$tMax;
                                        }
                                        if($row == 25){
                                            $Li = $sheet->getCell("N".$row)->getValue();
                                            echo $Li;
                                        }
                                        if($row == 26){
                                            $Lf = $sheet->getCell("N".$row)->getValue();
                                            echo $Lf;
                                        }
                                        if($row == 27){
                                            $Aporciento = $sheet->getCell("N".$row)->getValue();
                                            echo $Aporciento;
                                        }
                                        if($row == 28){
                                            $Data = $sheet->getCell("N".$row)->getValue();
                                            $fd = explode('*', $Data);
                                            $Di = $fd[0];
                                            $Df = $fd[1];
                                            echo ' Di '.$Di. ' X Df '.$Df;
                                        }
                                        if($row == 29){
                                            $Zporciento = $sheet->getCell("N".$row)->getValue();
                                            echo $Zporciento;
                                        }

                                echo '  </td>';
                                echo '</tr>';
                            }
                        ?>


                    </tbody>
                </table>

            </div>


            <?php

            $link=Conectarse();
            $SQL = "SELECT * FROM regtraccion Where idItem = '$Otam'";
            echo $SQL;
            $bd=$link->query($SQL);
            if($rs = mysqli_fetch_array($bd)){
                $aSob           = 0;
                $rAre           = 0;
                $Observacion    = '';
                $vbIngeniero    = '';
                echo 'Entra...';

                $actSQL="UPDATE regtraccion SET ";
                $actSQL.="aIni			    = '".$aIni.	            "',";
                $actSQL.="cFlu	            = '".$cFlu.	            "',";
                $actSQL.="cMax	            = '".$cMax.	            "',";
                $actSQL.="tFlu	            = '".$tFlu.	            "',";
                $actSQL.="tMax	            = '".$tMax.	            "',";
                $actSQL.="aSob	            = '".$aSob.	            "',";
                $actSQL.="rAre              = '".$rAre.             "',";
                $actSQL.="Espesor			= '".$Espesor.	        "',";
                $actSQL.="Ancho			    = '".$Ancho.	        "',";
                $actSQL.="Li	            = '".$Li.	            "',";
                $actSQL.="Lf	            = '".$Lf.	            "',";
                $actSQL.="Di	            = '".$Di.               "',";
                $actSQL.="Df	            = '".$Df.               "',";
                $actSQL.="Temperatura		= '".$Temperatura.	    "',";
                $actSQL.="Humedad		    = '".$Humedad.	        "',";
                $actSQL.="UTS               = '".$tMax.              "',"; // No Esta
                $actSQL.="Aporciento	    = '".$Aporciento.	    "',";
                $actSQL.="Zporciento	    = '".$Zporciento.       "',";
                $actSQL.="Observacion	    = '".$Observacion.      "',";
                $actSQL.="vbIngeniero	    = '".$vbIngeniero.      "',";
                $actSQL.="fechaRegistro	    = '".$fechaRegistro.	"'";
                $actSQL.="WHERE idItem	    = '$Otam'";
                $bdCot=$link->query($actSQL);
                
                $actSQL="UPDATE otams SET ";
                $actSQL.="tecRes	        = '".$Operador.	            "'";
                $actSQL.="WHERE Otam	    = '$Otam'";
                $bdCot=$link->query($actSQL);
                $link->close();

            }

        }
    ?>


    <script src="../bootstrap/css/bootstrap.min.js"></script> 
    <script src="../angular/angular.js"></script>
	<script src="pruebaQu.js"></script>

</body>
</html>