<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$dato = json_decode(file_get_contents("php://input"));
include("../conexionli.php");
$nItems = 1;
$link=Conectarse();
$SQLs = "SELECT * FROM solfactura Where nSolicitud = '$dato->nSolicitud'";
$bds=$link->query($SQLs);
if($rows=mysqli_fetch_array($bds)){
    $RutCli = $rows['RutCli'];
    $SQL = "SELECT * FROM detsolfact Where nSolicitud = '$dato->nSolicitud' Order By nItems Desc";
    $bd=$link->query($SQL);
    if($row=mysqli_fetch_array($bd)){
        $nItems = $row['nItems'] + 1;
    }
    $valorUnitario      = 0;
    $valorTotal         = 0;
    $valorUnitarioUF    = 0;
    $valorTotalUF       = 0;
    if($dato->tipoValor == 'U'){
        $valorTotalUF    = $dato->Cantidad * $dato->valorUnitario;
        $valorUnitarioUF = $dato->valorUnitario;
    }
    if($dato->tipoValor == 'P'){ 
        $valorTotal     = $dato->Cantidad * $dato->valorUnitario;
        $valorUnitario  = $dato->valorUnitario;
    }
     $link->query("insert into detsolfact (
                                            nItems          ,
                                            nSolicitud      ,
                                            RutCli          ,
                                            Cantidad        ,
                                            Especificacion  ,
                                            valorUnitario   ,
                                            valorTotal      ,
                                            valorUnitarioUF ,
                                            valorTotalUF
                                        ) 
                                 values (   
                                            '$nItems'               ,
                                            '$dato->nSolicitud'     ,
                                            '$RutCli'               ,
                                            '$dato->Cantidad'       ,
                                            '$dato->Especificacion' ,
                                            '$valorUnitario'        ,
                                            '$valorTotal'           ,
                                            '$valorUnitarioUF'      ,
                                            '$valorTotalUF'
                                        )"
                        );

    $svalorTotalUF = 0;
    $svalorTotal = 0;
    $SQL = "SELECT * FROM detsolfact Where nSolicitud = '$dato->nSolicitud'";
    $bd=$link->query($SQL);
    while($row=mysqli_fetch_array($bd)){
        $svalorTotalUF += $row['valorTotalUF'];
        $svalorTotal   += $row['valorTotal'];
    }
    $ivaUF = 0;
    $Iva   = 0;
    if($rows['Exenta'] != 'on'){
        $ivaUF   = ($svalorTotalUF * 19) / 100;
        $Iva     = ($svalorTotal * 19) / 100;
        if($rows['Redondear'] = 'on'){
            $ivaUF   = ($svalorTotalUF * 0.19);
            $Iva     = round(($svalorTotal * 0.19),0);
        }
    }
    $brutoUF = ($svalorTotalUF + $ivaUF);
    $Bruto   = ($svalorTotal + $Iva);
    if($rows['Redondear'] = 'on'){
        $brutoUF = ($svalorTotalUF + $ivaUF);
        $Bruto   = round(($svalorTotal + $Iva),0);
    }

    $actSolSQL="UPDATE solfactura SET ";
    $actSolSQL.="netoUF            = '".$svalorTotalUF. "', ";
    $actSolSQL.="ivaUF             = '".$ivaUF.         "', ";
    $actSolSQL.="brutoUF           = '".$brutoUF.       "', ";
    $actSolSQL.="Neto              = '".$svalorTotal.   "', ";
    $actSolSQL.="Iva               = '".$Iva.           "', ";
    $actSolSQL.="Bruto             = '".$Bruto.         "' ";
    $actSolSQL.="Where nSolicitud  = '$dato->nSolicitud'";
    $bdActSol=$link->query($actSolSQL);


}

$link->close();
?>