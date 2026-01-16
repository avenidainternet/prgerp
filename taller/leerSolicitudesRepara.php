<?php
include("../conexionli.php"); 


$link=Conectarse();
$RAM    = '';
$Estado = ''; // N = Normal A= Atrazada
$fechaHoy = date('Y-m-d');

// $SQL = "SELECT * FROM ammuestras Where CodInforme = '' and Taller = 'on' and fechaTaller > '0000-00-00' and fechaTerminoTaller = '0000-00-00' Order By fechaHasta, idItem Asc";
$SQL = "SELECT * FROM ammuestras Where Taller = 'on' and fechaTaller > '0000-00-00' and fechaTerminoTaller = '0000-00-00' Order By fechaHasta, idItem Asc";
$bd=$link->query($SQL);
while($rs = mysqli_fetch_array($bd)){
    $fs = explode('-', $rs['idItem']);
    $idItem = $rs['idItem'];
    $RAM = $fs[0];
    $SQLc = "SELECT * FROM cotizaciones Where RAM = '$RAM'";
    $bdc=$link->query($SQLc);
    if($rsc = mysqli_fetch_array($bdc)){
        if($rsc['Estado'] == 'P'){
            echo $RAM.' '.$rsc['CAM'].' '.$rsc['Estado'].' '.$rs['fechaTaller'].'<br>';
            $fechaTerminoTaller = '0000-00-00';
            $actSQL  = "UPDATE ammuestras SET ";
            $actSQL .= "fechaTerminoTaller  = '".$fechaTerminoTaller.	"'";
            $actSQL .= "Where idItem = '$idItem'";
            $bdGto = $link->query($actSQL);
        
        }
    }
}   

?>