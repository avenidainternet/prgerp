<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php"); 
$res = '';
$link=Conectarse();

$SQL = "SELECT * FROM solfactura Where nSolicitud = '$dato->nSolicitud'";
$bd=$link->query($SQL);
if($rs = mysqli_fetch_array($bd)){
	
	$Cliente = '';
	$SQLc = "SELECT * FROM clientes where RutCli = '".$rs['RutCli']."'";
	$bdc=$link->query($SQLc);
	if($rsc = mysqli_fetch_array($bdc)){
		$Cliente = trim($rsc['Cliente']);

		$res.= '{"nSolicitud":"'.		$rs["nSolicitud"].			'",';
	    $res.= '"Fotocopia":"'.			$rs["Fotocopia"]. 			'",';
	    $res.= '"fechaFotocopia":"'.	$rs["fechaFotocopia"]. 		'",';
	    $res.= '"nFactura":"'.			$rs["nFactura"]. 			'",';
	    $res.= '"Factura":"'.			$rs["Factura"]. 			'",';
	    $res.= '"fechaFactura":"'.		$rs["fechaFactura"]. 		'",';
	    $res.= '"pagoFactura":"'.		$rs["pagoFactura"]. 		'",';
	    $res.= '"fechaPago":"'.			$rs["fechaPago"]. 			'",';
	    $res.= '"valorUF":"'.			$rs["valorUF"]. 			'",';
	    $res.= '"netoUF":"'.			$rs["netoUF"]. 				'",';
	    $res.= '"Exenta":"'.			$rs["Exenta"]. 				'",';
	    $res.= '"ivaUF":"'.				$rs["ivaUF"]. 				'",';
	    $res.= '"brutoUF":"'.			$rs["brutoUF"]. 			'",';
	    $res.= '"valorUS":"'.			$rs["valorUS"]. 			'",';
	    $res.= '"NetoUS":"'.			$rs["NetoUS"]. 				'",';
	    $res.= '"IvaUS":"'.				$rs["IvaUS"]. 				'",';
	    $res.= '"BrutoUS":"'.			$rs["BrutoUS"]. 			'",';
	    $res.= '"Neto":"'.				$rs["Neto"]. 				'",';
	    $res.= '"Iva":"'.				$rs["Iva"]. 				'",';
	    $res.= '"Bruto":"'.				$rs["Bruto"]. 				'",';
	    $res.= '"Abono":"'.				$rs["Abono"]. 				'",';
	    $res.= '"Saldo":"'.				$rs["Saldo"]. 				'",';
	    $res.= '"Transferencia":"'.		$rs["Transferencia"]. 		'",';
	   	$res.= '"Cliente":"'. 			trim($Cliente). 			'"}';



	}
}
//$outp ='{"records":['.$outp.']}';
$link->close();
//$res ='{"records":['.$res.']}';
echo $res;	
?>