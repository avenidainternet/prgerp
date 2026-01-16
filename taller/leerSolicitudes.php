<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
date_default_timezone_set("America/Santiago");

$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php"); 

$outp = '';

$link=Conectarse();
$RAM    = '';
$Estado = ''; // N = Normal A= Atrazada
$fechaHoy = date('Y-m-d');

// $SQL = "SELECT * FROM ammuestras Where CodInforme = '' and Taller = 'on' and fechaTaller > '0000-00-00' and fechaTerminoTaller = '0000-00-00' Order By fechaHasta, idItem Asc";
$SQL = "SELECT * FROM ammuestras Where Taller = 'on' and fechaTaller > '0000-00-00' and fechaTerminoTaller = '0000-00-00' Order By fechaHasta, idItem Asc";
$bd=$link->query($SQL);
while($rs = mysqli_fetch_array($bd)){       
    $fd = explode('-', $rs['idItem']);
    $RAMv = $fd[0];
    $Objetivo = '';
    if($RAM != $RAMv){
        $nSolTaller = 0;
        $SQLs = "SELECT * FROM formram Where RAM = '$RAMv'";
        $bds=$link->query($SQLs); 
        if($rss = mysqli_fetch_array($bds)){
            $nSolTaller = $rss['nSolTaller'];
        }
        $RAM = $RAMv;
        $Estado = 'N';
        if($rs['fechaHasta'] < $fechaHoy){
            $Estado = 'A';
        }
        if($rs['fechaHasta'] == $fechaHoy){
            $Estado = 'P';
        }
        $ft = strtotime ( '+1 day' , strtotime ( $fechaHoy ) );
        $fXVencer = date ( 'Y-m-d' , $ft );

        if($rs['fechaHasta'] > $fechaHoy){
            $ft = strtotime ( '+1 day' , strtotime ( $fechaHoy ) );
            $fXVencer = date ( 'Y-m-d' , $ft );
            if($fXVencer == $rs['fechaHasta']){
                $Estado = 'P';
            }else{
                $ft = strtotime ( '+2 day' , strtotime ( $fechaHoy ) );
                $fXVencer = date ( 'Y-m-d' , $ft );
                if($fXVencer == $rs['fechaHasta']){
                    $Estado = 'N';
                }
            }
        }
        // if($fXVencer >= $fechaHoy and fXVencer <= $fechaHoy){
        //     $Estado = 'P';
        // }
        if ($outp != "") {$outp .= ",";}
        $outp .= '{"idItem":"'  . 			$rs["idItem"]. 				'",';
        $outp .= '"RAM":"'  . 		        $RAMv. 		                '",';
        $outp .= '"fechaTaller":"'  . 		$rs["fechaTaller"]. 		'",';
        $outp .= '"fechaHasta":"'  . 		$rs["fechaHasta"]. 		    '",';
        $outp .= '"Estado":"'  . 		    $Estado. 		            '",';
        $outp .= '"fXVencer":"'  . 		    $fXVencer. 		            '",';
        $outp .= '"nSolTaller":"'  . 		$nSolTaller. 		        '",';
        $outp.= '"Objetivo":' 			    .json_encode($rss["Obs"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
        $outp .= '"Taller":"'. 		        $rs["Taller"]. 		        '"}';
    }
    
}
$outp ='{"records":['.$outp.']}';
$link->close();
echo ($outp);

// echo json_encode($outp);
?>