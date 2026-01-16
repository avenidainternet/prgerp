<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$dato = json_decode(file_get_contents("php://input"));
include("../conexionli.php");
$link=Conectarse();
$SQLs = "SELECT * FROM solfactura Where nSolicitud = '$dato->nSolicitud'";
$bds=$link->query($SQLs);
if($rows=mysqli_fetch_array($bds)){
    $SQL = "SELECT * FROM detsolfact Where nSolicitud = '$dato->nSolicitud' and nItems = '$dato->nItems'";
    $bd=$link->query($SQL);
    if($row=mysqli_fetch_array($bd)){
        $valorUnitario   = $row['valorUnitario'];
        $valorTotal      = $row['valorTotal'];
        $valorUnitarioUF = $row['valorUnitarioUF'];
        $valorTotalUF    = $row['valorTotalUF'];
        $valorUnitarioUS = $row['valorUnitarioUS'];
        $valorTotalUS    = $row['valorTotalUS'];
        if($rows['tipoValor'] == 'P'){
            if($row['valorUnitario'] == 0){
                if($rows['valorUF'] > 0 and $row['valorUnitarioUF'] > 0){
                    $valorUnitario = $rows['valorUF'] * $row['valorUnitarioUF'];
                }else{
                    $valorUnitario = $dato->valorUnitario;
                }
            }else{
                $valorUnitario = $dato->valorUnitario;
            }
            $valorTotal    = $dato->Cantidad * $valorUnitario;

            //$valorTotal    = $dato->Cantidad * $dato->valorUnitario;
            //$valorUnitario = $dato->valorUnitario;
        }
        if($rows['tipoValor'] == 'U'){
            $valorTotalUF    = $dato->Cantidad * $dato->valorUnitarioUF;
            $valorUnitarioUF = $dato->valorUnitarioUF;
        }
        if($rows['tipoValor'] == 'D'){
            $valorTotalUS    = $dato->Cantidad * $dato->valorUnitarioUS;
            $valorUnitarioUS = $dato->valorUnitarioUS;
        }
        $actSQL="UPDATE detsolfact SET ";
        $actSQL.="Cantidad          = '".$dato->Cantidad.       "', ";
        $actSQL.="valorUnitario     = '".$valorUnitario.        "', ";
        $actSQL.="valorTotal        = '".$valorTotal.           "', ";
        $actSQL.="valorUnitarioUF   = '".$valorUnitarioUF.      "', ";
        $actSQL.="valorTotalUF      = '".$valorTotalUF.          "', ";
        $actSQL.="valorUnitarioUS   = '".$valorUnitarioUS.      "', ";
        $actSQL.="valorTotalUS      = '".$valorTotalUS.          "', ";
        $actSQL.="Especificacion    = '".$dato->Especificacion. "' ";
        $actSQL.="Where nSolicitud  = '$dato->nSolicitud' and nItems = '$dato->nItems'";
        $bdAct=$link->query($actSQL);
    }

    $svalorTotalUS = 0;
    $svalorTotalUF = 0;
    $svalorTotal = 0;
    $SQL = "SELECT * FROM detsolfact Where nSolicitud = '$dato->nSolicitud'";
    $bd=$link->query($SQL);
    while($row=mysqli_fetch_array($bd)){
        $svalorTotalUS += $row['valorTotalUS'];
        $svalorTotalUF += $row['valorTotalUF'];
        $svalorTotal   += $row['valorTotal'];
    }
    $IvaUS = 0;
    $ivaUF = 0;
    $Iva   = 0;
    if($rows['Exenta'] != 'on'){
        $IvaUS   = ($svalorTotalUS * 19) / 100;
        $ivaUF   = ($svalorTotalUF * 19) / 100;
        $Iva     = ($svalorTotal * 19) / 100;
        if($rows['Redondear'] = 'on'){
            $IvaUS   = ($svalorTotalUS * 0.19);
            $ivaUF   = ($svalorTotalUF * 0.19);
            $Iva     = round(($svalorTotal * 0.19),0);
        }
    }
    $BrutoUS = ($svalorTotalUS + $IvaUS);
    $brutoUF = ($svalorTotalUF + $ivaUF);
    $Bruto   = ($svalorTotal + $Iva);
    if($rows['Redondear'] = 'on'){
        $BrutoUS = ($svalorTotalUS + $IvaUS);
        $brutoUF = ($svalorTotalUF + $ivaUF);
        $Bruto   = round(($svalorTotal + $Iva),0);
    }

    $actSolSQL="UPDATE solfactura SET ";
    $actSolSQL.="netoUF            = '".$svalorTotalUF. "', ";
    $actSolSQL.="ivaUF             = '".$ivaUF.         "', ";
    $actSolSQL.="brutoUF           = '".$brutoUF.       "', ";
    $actSolSQL.="NetoUS            = '".$svalorTotalUS. "', ";
    $actSolSQL.="IvaUS             = '".$IvaUS.         "', ";
    $actSolSQL.="BrutoUS           = '".$BrutoUS.       "', ";
    $actSolSQL.="Neto              = '".$svalorTotal.   "', ";
    $actSolSQL.="Iva               = '".$Iva.           "', ";
    $actSolSQL.="Bruto             = '".$Bruto.         "' ";
    $actSolSQL.="Where nSolicitud  = '$dato->nSolicitud'";
    $bdActSol=$link->query($actSolSQL);
}
$link->close();
?>