<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$dato = json_decode(file_get_contents("php://input"));
include("../conexionli.php");
$output = [];
$link=Conectarse();
$SQL = "SELECT * FROM cotizaciones Where RutCli = '$dato->RutCli' and nSolicitud = '$dato->nSolicitud' and nSolicitud > 0 and RAM > 0 and Estado = 'T'";
$bd=$link->query($SQL);
while($rs=mysqli_fetch_array($bd)){
	$output[] = $rs;
}
$link->close();
echo json_encode($output);

?>