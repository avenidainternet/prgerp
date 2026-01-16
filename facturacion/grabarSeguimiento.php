<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$dato = json_decode(file_get_contents("php://input"));
include("../conexionli.php");
$link=Conectarse();
$RutCli = '';

$SQL = "SELECT * FROM solfactura Where nSolicitud = '$dato->nSolicitud'";
$bd=$link->query($SQL);
if($row=mysqli_fetch_array($bd)){ 
    $RutCli = $row['RutCli'];
    $Abono = 0;
    $Saldo = $row['Bruto'];
    $Abono = $row['Abono'] + $dato->montoAbonar;
    $Saldo = $dato->Bruto - $Abono;
    $actSQL="UPDATE solfactura SET ";
    $actSQL.="Fotocopia             = '".$dato->Fotocopia.              "', ";
    $actSQL.="fechaFotocopia        = '".$dato->fechaFotocopia.         "', ";
    $actSQL.="valorUF               = '".$dato->valorUF.                "', ";
    $actSQL.="valorUS               = '".$dato->valorUS.                "', ";
    $actSQL.="Neto                  = '".$dato->Neto.                   "', ";
    $actSQL.="Iva                   = '".$dato->Iva.                    "', ";
    $actSQL.="Bruto                 = '".$dato->Bruto.                  "', ";
    $actSQL.="Factura               = '".$dato->Factura.                "', ";
    $actSQL.="fechaFactura          = '".$dato->fechaFactura.           "', ";
    $actSQL.="nFactura              = '".$dato->nFactura.               "', ";
    $actSQL.="pagoFactura           = '".$dato->pagoFactura.            "', ";
    $actSQL.="fechaPago             = '".$dato->fechaPago.              "', ";
    $actSQL.="Saldo                 = '".$Saldo.                        "', ";
    $actSQL.="Abono                 = '".$Abono.                        "', ";
    $actSQL.="Transferencia         = '".$dato->Transferencia.          "', ";
    $actSQL.="fechaTransferencia    = '".$dato->fechaTransferencia.     "' ";
    $actSQL.="WHERE nSolicitud      = '".$dato->nSolicitud. "'";
    $bdAct=$link->query($actSQL); 

    $informeUP = 'on';
    $actSQL="UPDATE cotizaciones SET ";
    $actSQL.="Facturacion           = '".$dato->Factura.                "', ";
    $actSQL.="fechaFacturacion      = '".$dato->fechaFactura.           "', ";
    $actSQL.="informeUP             = '".$informeUP.                    "', ";
    $actSQL.="nFactura              = '".$dato->nFactura.               "'  ";
    $actSQL.="WHERE nSolicitud      = '".$dato->nSolicitud. "'";
    $bdAct=$link->query($actSQL); 


}

$sDeuda = 0;
$cFact	= 0;

$fechaHoy = date('Y-m-d');
$fecha90dias 	= strtotime ( '-90 day' , strtotime ( $fechaHoy ) );
$fecha90dias	= date ( 'Y-m-d' , $fecha90dias );
$bdDe=$link->query("SELECT * FROM solfactura Where RutCli = '$RutCli' and fechaPago = '0000-00-00'");
while($rowDe=mysqli_fetch_array($bdDe)){
    if($rowDe['fechaFactura'] > '0000-00-00'){
        if($rowDe['fechaFactura'] <= $fecha90dias){
            if($rowDe['Saldo'] > 0){
                $sDeuda += $rowDe['Saldo'];
                $cFact++;
                $actSQL="UPDATE clientes SET ";
                $actSQL.="nFactPend	 		= '".$cFact."',";
                $actSQL.="sDeuda 			= '".$sDeuda."'";
                $actSQL.="WHERE RutCli 		= '".$RutCli."'";
                $bdCot=$link->query($actSQL);
            }
        }
    }
}




$link->close();
?>