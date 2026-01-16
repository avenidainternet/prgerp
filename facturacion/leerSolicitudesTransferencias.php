<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php");
$AgnoAct = date('Y');
$output = [];
$outp = "";
$link=Conectarse();

$filtroSQL = " ";

$SQL = "SELECT * FROM solfactura Where Eliminado != 'on' and year(fechaSolicitud) <= $AgnoAct and Transferencia = 'on' Order By nSolicitud Desc";
//$SQL = "SELECT * FROM solfactura where fechaSolicitud = '2019-06-12' Order By nSolicitud Desc";
$bd=$link->query($SQL);
while($rs = mysqli_fetch_array($bd)){
	
	$Cliente = '';
	$SQLc = "SELECT * FROM clientes where RutCli = '".$rs['RutCli']."'";
	$bdc=$link->query($SQLc);
	while($rsc = mysqli_fetch_array($bdc)){
		$Cliente = trim($rsc['Cliente']);
	    if ($outp != "") {$outp .= ",";}
	    $outp .= '{"nSolicitud":"'  . 		$rs["nSolicitud"]. 			'",';
	    $outp .= '"RutCli":"'. 				$rs["RutCli"]. 				'",';
	    $outp .= '"Estado":"'. 				$rs["Estado"]. 				'",';
	    $outp .= '"Transferencia":"'. 		$rs["Transferencia"]. 		'",';
	    $outp .= '"fechaTransferencia":"'. 	$rs["fechaTransferencia"]. 		'",';
	    $outp .= '"pagoFactura":"'. 		$rs["pagoFactura"]. 		'",';
	    $outp .= '"Saldo":"'. 				$rs["Saldo"]. 				'",';
	    $outp .= '"tipoValor":"'. 			$rs["tipoValor"]. 			'",';
	    $outp .= '"valorUF":"'. 			$rs["valorUF"]. 			'",';
	    $outp .= '"valorUS":"'. 			$rs["valorUS"]. 			'",';
	    $outp .= '"brutoUF":"'. 			$rs["brutoUF"]. 			'",';
	    $outp .= '"BrutoUS":"'. 			$rs["BrutoUS"]. 			'",';
	    $outp .= '"Bruto":"'. 				$rs["Bruto"]. 				'",';
	    $outp .= '"fechaSolicitud":"'. 		$rs["fechaSolicitud"]. 		'",';
	    $outp .= '"IdProyecto":"'. 			$rs["IdProyecto"]. 			'",';
	    $outp .= '"fechaFotocopia":"'. 		$rs["fechaFotocopia"]. 		'",';
	    $outp .= '"fechaFactura":"'. 		$rs["fechaFactura"]. 		'",';
	    $outp .= '"Factura":"'. 			$rs["Factura"]. 			'",';
	    $outp .= '"nFactura":"'. 			$rs["nFactura"]. 			'",';
	    $outp .= '"Cliente":"'. 			trim($Cliente). 			'"}';
	}
}
$outp ='{"records":['.$outp.']}';
$link->close();
echo ($outp);
?>