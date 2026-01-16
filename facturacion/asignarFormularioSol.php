<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$dato = json_decode(file_get_contents("php://input"));
include("../conexionli.php");
$res = '';
$link=Conectarse();

$SQLs = "SELECT * FROM solfactura Order By nSolicitud Desc";
$bds=$link->query($SQLs);
if($rss=mysqli_fetch_array($bds)){
    $nSolicitud = $rss["nSolicitud"] + 1;
}


$SQL = "SELECT * FROM tablaregform"; 
$bd=$link->query($SQL);
if($rs=mysqli_fetch_array($bd)){
    //$nSolicitud = $rs["nSolFactura"] + 1;

    $res.= '{"CAM":"'.                  $rs["CAM"].                    '",';
    $res.= '"nSolicitud":"'.            $nSolicitud.                   '",';
    $res.= '"nInforme":"'.              $rs["nInforme"].               '",';
    $res.= '"valorUFRef":"'.            $rs["valorUFRef"].             '"}';

}

$actSQL="UPDATE tablaregform SET ";
$actSQL.="nSolFactura = '".$nSolicitud."'";
$bdAct=$link->query($actSQL);


$link->close();
echo $res;  
?>