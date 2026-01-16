<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$dato = json_decode(file_get_contents("php://input"));
include("../conexionli.php");
$link=Conectarse();
$SQL = "SELECT * FROM cotizaciones Where CAM = '$dato->CAM'";
$bd=$link->query($SQL);
$nSolicitud = 0;
$Facturacion = '';
if($row=mysqli_fetch_array($bd)){
    $actSQL="UPDATE cotizaciones SET ";
    $actSQL.="nSolicitud     = '".$nSolicitud.  "', ";
    $actSQL.="Facturacion    = '".$Facturacion. "' ";
    $actSQL.="WHERE CAM      = '".$dato->CAM. "'";
    $bdAct=$link->query($actSQL);
}

$cotizacionesCAM  	= '';
$informesAM 		= '';

$SQL = "SELECT * FROM cotizaciones Where nSolicitud = '$dato->nSolicitud'";
$bd=$link->query($SQL);
while($row=mysqli_fetch_array($bd)){
	if($cotizacionesCAM){
		$cotizacionesCAM 	.= '-'.$row['CAM'];
		$informesAM 		.= '-'.$row['RAM'];
	}else{
		$cotizacionesCAM 	= $row['CAM'];
		$informesAM 		= $row['RAM'];
	}
}

$actSQL="UPDATE solfactura SET ";
$actSQL.="cotizacionesCAM   = '".$cotizacionesCAM. 	"', ";
$actSQL.="informesAM     	= '".$informesAM. 	 	"' ";
$actSQL.="WHERE nSolicitud  = '$dato->nSolicitud'";
$bdAct=$link->query($actSQL);

$link->close();
?>