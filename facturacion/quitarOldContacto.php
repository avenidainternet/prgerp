<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$dato = json_decode(file_get_contents("php://input"));
include("../conexionli.php");
$link=Conectarse();
$SQLs = "SELECT * FROM solfactura Where nSolicitud = '$dato->nSolicitud'";
$bds=$link->query($SQLs);
if($rows=mysqli_fetch_array($bds)){
    $RutCli = $rows['RutCli'];
    $correosFactura = $rows['correosFactura'];
    $Contacto       = $rows['Atencion'];
    $SQL = "SELECT * FROM contactoscli Where RutCli = '$dato->RutCli' and nContacto = '$dato->nContacto'";
    $bd=$link->query($SQL);
    if($row=mysqli_fetch_array($bd)){
        if($correosFactura){
            $correosFactura .= ', '.$row['Email'];
            $Contacto       .= ', '.$row['Contacto'];
        }else{
            $correosFactura = 'simet@usach.cl, '.$row['Email'];
            $Contacto       = $row['Contacto'];
        }
    }

    $actSolSQL="UPDATE solfactura SET ";
    $actSolSQL.="correosFactura    = '".$correosFactura. "', ";
    $actSolSQL.="Atencion          = '".$Contacto.       "' ";
    $actSolSQL.="Where nSolicitud  = '$dato->nSolicitud'";
    $bdActSol=$link->query($actSolSQL);

}

$link->close();
?>