<?php
	include_once("../conexionli.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Leer Archivo Excel usando PHP</title>
    <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">

<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"> -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> -->
</head>
<body ng-app="myApp" ng-controller="ctrlEspectometro">
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
                    </div>
                </div>
            </div>
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

                $fechaHoy = date('Y-m-d');    
                $archivo = $vDir.'/Espectrometro-'.$fechaHoy.'.xlsx';
                if(file_exists($archivo)){
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
                            <th>Fecha</th>
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
                                $aTit[] = $sheet->getCell("B".$row)->getValue();
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

                            for ($row = 2; $row <= $highestRow; $row++){ 
                                if($sheet->getCell("D".$row)->getValue() == 'Average' and $sheet->getCell("C".$row)->getValue() != 'Fe-01-M' and $sheet->getCell("A".$row)->getValue() != '' and $sheet->getCell("C".$row)->getValue() != 'Al-01-M' and $sheet->getCell("C".$row)->getValue() != 'Cu-01-M'	){
                                    $num++;
                                    $fr = explode('-',$sheet->getCell("A".$row)->getValue());
                                    $Otam = $fr[0];
                                    if($fr[1]){
                                        $Otam .= '-'.$fr[1];
                                    }
                                    if(sizeof($fr) == 3){
                                        $Otam .= '-'.$fr[2];
                                        if(substr($fr[2],0,1) == 'Q'){
                                            $Encontrado = 'No';
                                            $link=Conectarse();
                                            $bd=$link->query("SELECT * FROM regquimico WHERE idItem = '$Otam'");
                                            if ($rs=mysqli_fetch_array($bd)){
                                                $Encontrado = 'Si';
                                                $cC     = 0.0000;
                                                $cSi    = 0.0000;
                                                $cMn    = 0.0000;
                                                $cP     = 0.0000;
                                                $cS     = 0.0000;
                                                $cCr    = 0.0000;
                                                $cNi    = 0.0000;
                                                $cMo    = 0.0000;
                                                $cAl    = 0.0000;
                                                $cCu    = 0.0000;
                                                $cCo    = 0.0000;
                                                $cTi    = 0.0000;
                                                $cNb    = 0.0000;
                                                $cV     = 0.0000;
                                                $cW     = 0.0000;
                                                $cB     = 0.0000;

                                                /* Leer Valores por Defecto de la BD */
                                                $actSQL="UPDATE regquimico SET ";
                                                $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '".$rs['tpMuestra']."' and Simbolo = 'C'");
                                                if ($rsd=mysqli_fetch_array($bdd)){
                                                    // $cC = substr($rsd['valorDefecto'],1);
                                                    $cC = comparaValor($sheet->getCell("E".$row)->getValue(), $rsd['valorDefecto']);
                                                }
                                                $actSQL="UPDATE regquimico SET ";
                                                $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '".$rs['tpMuestra']."' and Simbolo = 'Si'");
                                                if ($rsd=mysqli_fetch_array($bdd)){
                                                    $cSi = comparaValor($sheet->getCell("F".$row)->getValue(), $rsd['valorDefecto']);
                                                }
                                                $actSQL="UPDATE regquimico SET ";
                                                $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '".$rs['tpMuestra']."' and Simbolo = 'Mn'");
                                                if ($rsd=mysqli_fetch_array($bdd)){
                                                    $cMn = comparaValor($sheet->getCell("G".$row)->getValue(), $rsd['valorDefecto']);
                                                }
                                                $actSQL="UPDATE regquimico SET ";
                                                $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '".$rs['tpMuestra']."' and Simbolo = 'P'");
                                                if ($rsd=mysqli_fetch_array($bdd)){
                                                    $cP = comparaValor($sheet->getCell("H".$row)->getValue(), $rsd['valorDefecto']);
                                                }
                                                $actSQL="UPDATE regquimico SET ";
                                                $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '".$rs['tpMuestra']."' and Simbolo = 'S'");
                                                if ($rsd=mysqli_fetch_array($bdd)){
                                                    $cS = comparaValor($sheet->getCell("I".$row)->getValue(), $rsd['valorDefecto']);
                                                    // $cS = $sheet->getCell("G".$row)->getValue();
                                                }
                                                $actSQL="UPDATE regquimico SET ";
                                                $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '".$rs['tpMuestra']."' and Simbolo = 'Cr'");
                                                if ($rsd=mysqli_fetch_array($bdd)){
                                                    $cCr = comparaValor($sheet->getCell("J".$row)->getValue(), $rsd['valorDefecto']);
                                                }
                                                $actSQL="UPDATE regquimico SET ";
                                                $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '".$rs['tpMuestra']."' and Simbolo = 'Ni'");
                                                if ($rsd=mysqli_fetch_array($bdd)){
                                                    $cNi = comparaValor($sheet->getCell("K".$row)->getValue(), $rsd['valorDefecto']);
                                                }
                                                $actSQL="UPDATE regquimico SET ";
                                                $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '".$rs['tpMuestra']."' and Simbolo = 'Mo'");
                                                if ($rsd=mysqli_fetch_array($bdd)){
                                                    $cMo = comparaValor($sheet->getCell("L".$row)->getValue(), $rsd['valorDefecto']);
                                                }
                                                $actSQL="UPDATE regquimico SET ";
                                                $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '".$rs['tpMuestra']."' and Simbolo = 'Al'");
                                                if ($rsd=mysqli_fetch_array($bdd)){
                                                    $cAl = comparaValor($sheet->getCell("M".$row)->getValue(), $rsd['valorDefecto']);
                                                }
                                                $actSQL="UPDATE regquimico SET ";
                                                $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '".$rs['tpMuestra']."' and Simbolo = 'Cu'");
                                                if ($rsd=mysqli_fetch_array($bdd)){
                                                    $cCu = comparaValor($sheet->getCell("N".$row)->getValue(), $rsd['valorDefecto']);
                                                }
                                                $actSQL="UPDATE regquimico SET ";
                                                $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '".$rs['tpMuestra']."' and Simbolo = 'Co'");
                                                if ($rsd=mysqli_fetch_array($bdd)){
                                                    $cCo = comparaValor($sheet->getCell("O".$row)->getValue(), $rsd['valorDefecto']);
                                                }
                                                $actSQL="UPDATE regquimico SET ";
                                                $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '".$rs['tpMuestra']."' and Simbolo = 'Ti'");
                                                if ($rsd=mysqli_fetch_array($bdd)){
                                                    $cTi = comparaValor($sheet->getCell("P".$row)->getValue(), $rsd['valorDefecto']);
                                                }
                                                $actSQL="UPDATE regquimico SET ";
                                                $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '".$rs['tpMuestra']."' and Simbolo = 'Nb'");
                                                if ($rsd=mysqli_fetch_array($bdd)){
                                                    $cNb = comparaValor($sheet->getCell("Q".$row)->getValue(), $rsd['valorDefecto']);
                                                }
                                                $actSQL="UPDATE regquimico SET ";
                                                $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '".$rs['tpMuestra']."' and Simbolo = 'V'");
                                                if ($rsd=mysqli_fetch_array($bdd)){
                                                    $cV = comparaValor($sheet->getCell("R".$row)->getValue(), $rsd['valorDefecto']);
                                                }
                                                $actSQL="UPDATE regquimico SET ";
                                                $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '".$rs['tpMuestra']."' and Simbolo = 'W'");
                                                if ($rsd=mysqli_fetch_array($bdd)){
                                                    $cW = comparaValor($sheet->getCell("S".$row)->getValue(), $rsd['valorDefecto']);
                                                }
                                                $actSQL="UPDATE regquimico SET ";
                                                $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '".$rs['tpMuestra']."' and Simbolo = 'B'");
                                                if ($rsd=mysqli_fetch_array($bdd)){
                                                    $cB = comparaValor($sheet->getCell("T".$row)->getValue(), $rsd['valorDefecto']);
                                                }
                                                /* Leer Valores por Defecto de la BD */
                                                
                                                // echo $aTit[6];

/*
                                                if($sheet->getCell("E".$row)->getValue() == $cC){
                                                    $actSQL.="cC		    ='".$sheet->getCell("E".$row)->getValue().	"',";
                                                }
                                                if($sheet->getCell("E".$row)->getValue() < $cC){
                                                    $actSQL.="cC		    ='".$rsd['valorDefecto'].	"',";
                                                }
                                                if($sheet->getCell("E".$row)->getValue() > $cC){
                                                    $actSQL.="cC		    ='".$sheet->getCell("E".$row)->getValue().	"',";
                                                    // $actSQL.="cC		    ='".$rsd['valorDefecto'].	"',";
                                                }
*/
                                                $cFe     = 'Resto';
                                                $UNIX_DATE = ($sheet->getCell("B".$row)->getValue() - 25569) * 86400;
                                                $Excel_DATE = 25569 + ($UNIX_DATE / 86400);
                                                $UNIX_DATE = ($Excel_DATE - 25569) * 86400;
                                                $fechaRegistro = gmdate("d-m-Y", $UNIX_DATE);
                                                $fd = explode('-', $fechaRegistro);
                                                $fechaRegistro = $fd[2].'-'.$fd[1].'-'.$fd[0];

                                                $Temperatura        = "{{Temperatura}}";
                                                $Humedad            = "{{ Humedad }}";
                                                $Temperatura = substr($Temperatura,0);
                                                echo $Temperatura.' '.$Humedad;
                                                // $Temperatura = 19;
                                                // $Humedad = 55;
                                                $actSQL.="fechaRegistro ='".$fechaRegistro.	"',";
                                                $actSQL.="Temperatura   ='".$Temperatura.	"',";
                                                $actSQL.="Humedad       ='".$Humedad.	    "',";
                                                $actSQL.="cC		    ='".$cC.	"',";
                                                $actSQL.="cSi		    ='".$cSi.	"',";
                                                $actSQL.="cMn		    ='".$cMn.	"',";
                                                $actSQL.="cP		    ='".$cP.	"',";
                                                $actSQL.="cS		    ='".$cS.	"',";
                                                $actSQL.="cCr		    ='".$cCr.	"',";
                                                $actSQL.="cNi		    ='".$cNi.	"',";
                                                $actSQL.="cMo		    ='".$cMo.	"',";
                                                $actSQL.="cAl		    ='".$cAl.	"',";
                                                $actSQL.="cCu		    ='".$cCu.	"',";
                                                $actSQL.="cCo		    ='".$cCo.	"',";
                                                $actSQL.="cTi		    ='".$cTi.	"',";
                                                $actSQL.="cNb		    ='".$cNb.	"',";
                                                $actSQL.="cV		    ='".$cV.	"',";
                                                $actSQL.="cW		    ='".$cW.	"',";
                                                $actSQL.="cB		    ='".$cB.	"',";
                                                $actSQL.="cFe		    ='".$cFe.	"'";
                                                $actSQL.="WHERE idItem 	= '$Otam'";
                                                $bdfRAM=$link->query($actSQL);
                                                
                                            }
                                            $link->close();
                                    
                                            ?>
                                            <tr>
                                                <th scope='row'><?php echo $num.' '.$Encontrado;?></th>
                                                <td><b><?php echo $sheet->getCell("A".$row)->getValue();?></b></td>
                                                <td><?php echo $sheet->getCell("B".$row)->getValue();?></td>
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
                            }?>
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