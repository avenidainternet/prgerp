<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$dato = json_decode(file_get_contents("php://input"));
include("../conexionli.php");
$output = [];
$link=Conectarse();
$SQL = "SELECT * FROM detsolfact Where nSolicitud = '$dato->nSolicitud' Order By nItems";
$bd=$link->query($SQL);
while($rs=mysqli_fetch_array($bd)){
	$output[] = $rs;
}
$link->close();
echo json_encode($output);

?>