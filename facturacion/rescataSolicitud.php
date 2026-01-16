<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$dato = json_decode(file_get_contents("php://input")); 
include("../conexionli.php");


if($dato->accion == "copiaCAM"){
    $res = '';
    $link=Conectarse();
    $SQL = "SELECT * FROM cotizaciones Where nSolicitud = '$dato->nSolicitud'";
    $bd=$link->query($SQL);
    if($rs=mysqli_fetch_array($bd)){
        $res.= '{"nSolicitud":"'.           $dato->nSolicitud.                 '",';
        $res.= '"CAM":"'.                   $rs["CAM"].                  '",';
        $res.= '"RAM":"'.                   $rs["RAM"].                  '"}';
    }
    $link->close();
    echo $res;  

}
if($dato->accion == "New"){ 
    $res = '';
    $link=Conectarse();
    //$SQL = "SELECT * FROM solfactura Where nOrden = '$dato->nOrden' and cotizacionesCAM = ''";
    //$SQL = "SELECT * FROM solfactura Where nOrden = 'PC00026111-3' and cotizacionesCAM = ''";
    $SQL = "SELECT * FROM cotizaciones Where CAM = '$dato->CAM'";
    $bd=$link->query($SQL);
    if($rs=mysqli_fetch_array($bd)){
        $RutCli         = $rs["RutCli"];
        $nOrden         = $rs["nOC"];
        $CAM            = $rs['CAM'];
        $RAM            = $rs['RAM'];
        $fechaSolicitud = date('Y-m-d');

        $SQLs = "SELECT * FROM solfactura Order By nSolicitud Desc";
        $bds=$link->query($SQLs);
        if($rss=mysqli_fetch_array($bds)){
            $nSolicitud = $rss["nSolicitud"] + 1;
            $res.= '{"nSolicitud":"'.           $nSolicitud.                    '",';
            $res.= '"nOrden":"'.                $rs["nOC"].                  '",';
            $res.= '"RutCli":"'.                $rs["RutCli"].                  '"}';
        }

        $Facturacion = 'on';
        $actSQL="UPDATE cotizaciones SET ";
        $actSQL.="nSolicitud            = '".$nSolicitud.                       "', ";
        $actSQL.="Facturacion           = '".$Facturacion.                      "' ";
        $actSQL.="WHERE CAM             = '".$dato->CAM. "'";
        $bdAct=$link->query($actSQL);
   

        $link->query("insert into solfactura (
            nSolicitud                  ,
            RutCli                      ,
            fechaSolicitud              ,
            nOrden                      ,
            cotizacionesCAM             ,
            informesAM
                ) 
         values (	
            '$nSolicitud'               ,
            '$RutCli'                   ,
            '$fechaSolicitud'           ,
            '$nOrden'                   ,
            '$CAM'                      ,
            '$RAM'
        )"
);






    }
    
    
    $link->close();
    echo $res;  
}
?>