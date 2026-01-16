<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php");
$fdCon = [];
$output = [];
$link=Conectarse();
if($dato->nSolicitud > 0){
	$SQL = "SELECT * FROM solfactura Where nSolicitud = '$dato->nSolicitud'";
	$bd=$link->query($SQL);
	if($rs=mysqli_fetch_array($bd)){
		if($rs['correosFactura']){
			$fdCon = explode(',', $rs['correosFactura']);
		}
	}
}
$outp = "";
$SQL = "SELECT * FROM contactoscli Where RutCli = '$dato->RutCli' and Contacto != '' Order By Contacto Asc";
$bd=$link->query($SQL);
while($rs=mysqli_fetch_array($bd)){
	if(!in_array($rs['Email'], $fdCon)){
		$output[] = $rs;
	}
}
$link->close();
echo json_encode($output);
?>