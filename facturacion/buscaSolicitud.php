<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$dato = json_decode(file_get_contents("php://input"));
include_once("../conexionli.php");
$res = '';
$link=Conectarse();
/*
$ultObserva = '';
$SQL = "SELECT * FROM solfactura Where RutCli = '$dato->RutCli' and pagoFactura = 'on' Order By fechaPago Desc";
$bd=$link->query($SQL);
if($rs=mysqli_fetch_array($bd)){
    $ultObserva = $row['Observa'];
}
*/

$SQL = "SELECT * FROM solfactura Where nSolicitud = '$dato->nSolicitud'";
$bd=$link->query($SQL);
if($rs=mysqli_fetch_array($bd)){
	$Incluidos = '';
	if($rs['correosFactura']){
		$fd = explode(', ', $rs['correosFactura']);
		$SQLcon = "SELECT * FROM contactoscli Where RutCli = '".$rs['RutCli']."' and Email = '".$fd[0]."'";
		$bdcon=$link->query($SQLcon);
		if($rscon=mysqli_fetch_array($bdcon)){
			$Incluidos = $rscon['Contacto'];
		}
	}

	$SQLcl = "SELECT * FROM clientes Where RutCli = '".$rs['RutCli']."'";
	$bdcl=$link->query($SQLcl);
	$rscl=mysqli_fetch_array($bdcl);

    $res.= '{"fechaSolicitud":"'.       $rs["fechaSolicitud"].           '",';
    $res.= '"Incluidos":"'.             $Incluidos.                      '",';
    $res.= '"Exenta":"'.                $rs["Exenta"].                   '",';
    $res.= '"Redondear":"'.             $rs["Redondear"].                '",';
    $res.= '"Estado":"'.                $rs["Estado"].                   '",';
    $res.= '"informesAM":"'.            $rs["informesAM"].               '",';
    $res.= '"cotizacionesCAM":"'.       $rs["cotizacionesCAM"].          '",';
    $res.= '"Observa":'.                json_encode($rs["Observa"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE)  .',';
    $res.= '"Atencion":"'.              $rs["Atencion"].                 '",';
    $res.= '"IdProyecto":"'.            $rs["IdProyecto"].               '",';
    $res.= '"nOrden":"'.                $rs["nOrden"].                   '",';
    $res.= '"tipoValor":"'.             $rs["tipoValor"].                '",';
    $res.= '"valorUF":"'.               $rs["valorUF"].                  '",';
    $res.= '"fechaUF":"'.               $rs["fechaUF"].                  '",';
    $res.= '"netoUF":"'.                $rs["netoUF"].                   '",';
    $res.= '"ivaUF":"'.                 $rs["ivaUF"].                    '",';
    $res.= '"brutoUF":"'.               $rs["brutoUF"].                  '",';
    $res.= '"Neto":"'.                  $rs["Neto"].                     '",';
    $res.= '"Iva":"'.                   $rs["Iva"].                      '",';
    $res.= '"Bruto":"'.                 $rs["Bruto"].                    '",';
    $res.= '"NetoUS":"'.                $rs["NetoUS"].                   '",';
    $res.= '"IvaUS":"'.                 $rs["IvaUS"].                    '",';
    $res.= '"BrutoUS":"'.               $rs["BrutoUS"].                  '",';
    $res.= '"enviarFactura":"'.         $rs["enviarFactura"].            '",';
    $res.= '"vencimientoSolicitud":"'.  $rs["vencimientoSolicitud"].     '",';
    $res.= '"Contacto":"'.              $rs["Contacto"].                 '",';
    $res.= '"Atencion":"'.              $rs["Atencion"].                 '",';
    $res.= '"correosFactura":"'.        $rs["correosFactura"].           '"}';
}
$link->close();
//echo '{"msg":"Busqueda Exitosa","msg2":['.$res.']}';	
echo $res;  

?>
