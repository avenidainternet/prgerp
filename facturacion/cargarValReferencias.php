<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$dato = json_decode(file_get_contents("php://input"));
include_once("../conexionli.php");
$res = '';
$AgnoAct = date('Y');
$filtroFacturas = "Where Eliminado != 'on' and year(fechaSolicitud) <= $AgnoAct ";

$tDocencia 		= 0;
$facturasSP 	= 0;
$tFacturadas 	= 0;
$tSinFacturar	= 0;
$tUF 			= 0;
$tUFsFact		= 0;
$tgFacturadas	= 0;

$link=Conectarse();
$bdf=$link->query("SELECT * FROM SolFactura $filtroFacturas Order By nSolicitud Asc");
while($rowf=mysqli_fetch_array($bdf)){
	$cFree = 'NO';
	$bdc=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowf['RutCli']."'");
	if($rowc=mysqli_fetch_array($bdc)){
		$cFree = 'off';
		if($rowc['cFree'] == 'on'){
			$cFree = $rowc['cFree'];
		}
	}
							
	if($rowf['Estado'] == 'I'){
		if($cFree == 'on'){
			$tDocencia += $rowf['Bruto'];
		}else{
//			if($cFree == 'off'){
				if($rowf['pagoFactura'] != 'on'){
					$fechaHoy = date('Y-m-d');
					if($rowf['fechaSolicitud'] <= $fechaHoy){
					}
					if($rowf['Factura'] == 'on' and $rowf['Bruto'] > 0){
						$facturasSP += $rowf['Neto'];
						$tFacturadas += $rowf['Bruto'];
						$tgFacturadas += $rowf['Bruto'];
					}else{
						$facturasSP += $rowf['Neto'];
						$tSinFacturar += $rowf['Bruto'];
						$tgFacturadas += $rowf['Bruto'];
					}
					if($rowf['Factura'] == 'on' and $rowf['Bruto'] == 0 and $rowf['brutoUF'] > 0){
						$tUF += $rowf['brutoUF'];
					}else{
						$tUFsFact += $rowf['brutoUF'];
					}
				}
//			}
		}
	}
}








$SQL = "SELECT * FROM tablaregform"; 
$bd=$link->query($SQL);
if($rs=mysqli_fetch_array($bd)){
	$res.= '{"valorUFRef":"'.		$rs["valorUFRef"].	'",';
	$res.= '"tFacturadas":"'.		$tFacturadas.		'",';
	$res.= '"tSinFacturar":"'.		$tSinFacturar.		'",';
	$res.= '"facturasSP":"'.		$facturasSP.		'",';
	$res.= '"tgFacturadas":"'.		$tgFacturadas.		'",';
   	$res.= '"valorUSRef":"'. 		$rs["valorUSRef"]. 	'"}';
}
$link->close();
echo $res;	

?>
