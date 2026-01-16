<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$dato = json_decode(file_get_contents("php://input"));
include("../conexionli.php");

if($dato->accion == "SolNew"){
    $link=Conectarse();
    $RutCli = '';
    $RAM    = '';
    $SQL = "SELECT * FROM cotizaciones Where CAM = '$dato->CAM'";
    $bd=$link->query($SQL);
    if($rs=mysqli_fetch_array($bd)){
        $RutCli     = $rs['RutCli'];
        $RAM        = $rs['RAM'];
        $CAM        = $rs['CAM'];
        $Facturacion = 'on';
        $actSQL="UPDATE cotizaciones SET ";
        $actSQL.="nSolicitud            = '".$dato->nSolicitud.              "', ";
        $actSQL.="Facturacion           = '".$Facturacion.                  "' ";
        $actSQL.="WHERE CAM             = '".$dato->CAM. "'";
        $bdAct=$link->query($actSQL);

    }

         $link->query("insert into solfactura (
                                                nSolicitud                  ,
                                                RutCli                      ,
                                                fechaSolicitud              ,
                                                nOrden                      ,
                                                cotizacionesCAM             ,
                                                informesAM
                                            ) 
                                     values (	
                                                '$dato->nSolicitud'         ,
                                                '$RutCli'                   ,
                                                '$dato->fechaSolicitud'     ,
                                                '$dato->nOrden'             ,
                                                '$CAM'                      ,
                                                '$RAM'
                                            )"
                            );
    

    $link->close();
}

if($dato->accion == "SolOld"){
    $fechaUF = $dato->fechaUF;
    $valorUF = $dato->valorUF;

    $link=Conectarse();

    $SQL = "SELECT * FROM clientes Where RutCli = '$dato->RutCli'";
    $bd=$link->query($SQL);
    if($row=mysqli_fetch_array($bd)){
        $actSQL="UPDATE clientes SET ";
        $actSQL.="Telefono              = '".$dato->Telefono.               "', ";
        $actSQL.="Direccion             = '".$dato->Direccion.              "' ";
        $actSQL.="WHERE RutCli          = '".$dato->RutCli. "'";
        $bdAct=$link->query($actSQL);
    }
    $SQL = "SELECT * FROM solfactura Where nSolicitud = '$dato->nSolicitud'";
    $bd=$link->query($SQL);
    if($row=mysqli_fetch_array($bd)){
        $actSQL="UPDATE solfactura SET ";
        $actSQL.="RutCli                = '".$dato->RutCli.                 "', ";
        $actSQL.="fechaSolicitud        = '".$dato->fechaSolicitud.         "', ";
        $actSQL.="Atencion              = '".$dato->Atencion.               "', ";
        $actSQL.="correosFactura        = '".$dato->correosFactura.         "', ";
        $actSQL.="nOrden                = '".$dato->nOrden.                 "', ";
        $actSQL.="Observa               = '".$dato->Observa.                "', ";
        $actSQL.="vencimientoSolicitud  = '".$dato->vencimientoSolicitud.   "', ";
        $actSQL.="Exenta                = '".$dato->Exenta.                 "', ";
        $actSQL.="Redondear             = '".$dato->Redondear.              "', ";
        $actSQL.="tipoValor             = '".$dato->tipoValor.              "', ";
        // $actSQL.="valorUF               = '".$valorUF.                      "', ";
        // $actSQL.="fechaUF               = '".$fechaUF.                      "', ";
        $actSQL.="enviarFactura         = '".$dato->enviarFactura.          "', ";
        $actSQL.="cotizacionesCAM       = '".$dato->cotizacionesCAM.        "', ";
        $actSQL.="informesAM            = '".$dato->informesAM.             "', ";
        $actSQL.="IdProyecto            = '".$dato->IdProyecto.             "' ";
        $actSQL.="WHERE nSolicitud      = '".$dato->nSolicitud. "'";
        $bdAct=$link->query($actSQL);
    }else{
         $link->query("insert into solfactura (
                                                   nSolicitud,
                                                RutCli,
                                                fechaSolicitud,
                                                Atencion,
                                                nOrden,
                                                vencimientoSolicitud,
                                                Exenta,
                                                tipoValor,
                                                valorUF,
                                                fechaUF,
                                                enviarFactura,
                                                IdProyecto
                                            ) 
                                     values (	
                                                '$dato->nSolicitud',
                                                '$dato->RutCli',
                                                '$dato->fechaSolicitud',
                                                '$dato->Atencion',
                                                '$dato->nOrden',
                                                '$dato->vencimientoSolicitud',
                                                '$dato->Exenta',
                                                '$dato->tipoValor',
                                                '$valorUF',
                                                '$fechaUF',
                                                '$dato->enviarFactura',
                                                '$dato->IdProyecto'
                                            )"
                            );
    
    }
    $link->close();
}

?>