<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

$agnoActual = date('Y');
$ruta = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion/octmp/'.$dato->documento;
$ruta = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/SOLICITUD-FACTURA/octmp/'.$dato->documento;

if(file_exists($ruta)){
    unlink($ruta);
}
$ruta = '../tmp/'.$dato->documento;
if(file_exists($ruta)){
    unlink($ruta);
}
$ruta = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/SOLICITUD-FACTURA/octmp/'.$dato->documento;
if(file_exists($ruta)){
    unlink($ruta);
}
$ruta = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/SOLICITUD-FACTURA/SOL-'.$dato->nSolicitud.'/'.$dato->documento;
if(file_exists($ruta)){
    unlink($ruta);
}

?>