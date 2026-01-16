<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php");
$Periodo = date('Y');
$output = [];
$fd = [];
$link=Conectarse();
$outp = "";
$SQLsol = "SELECT * FROM solfactura Where nSolicitud = '$dato->nSolicitud'";
$bdsol=$link->query($SQLsol);
if($rssol=mysqli_fetch_array($bdsol)){
	$fd = explode(', ', $rssol['correosFactura']);
	$SQL = "SELECT * FROM contactoscli Where RutCli = '$dato->RutCli' and Contacto != '' Order By nContacto";
	$bd=$link->query($SQL);
	while($rs=mysqli_fetch_array($bd)){
		if(in_array($rs['Email'], $fd)){
			$output[] = $rs;
		}
	}
}
$link->close();
echo json_encode($output);
?>