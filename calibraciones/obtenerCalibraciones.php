<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$dato = json_decode(file_get_contents("php://input"));
include("../conexionli.php");
$res = '';
$link=Conectarse();
$SQL = "SELECT * FROM calibraciones";
$bd=$link->query($SQL);
if($rs=mysqli_fetch_array($bd)){
	$res.= '{"Equipo":"'.$rs["Equipo"].'",';
    $res.= '"calA":"'.$rs["calA"].'",';
    $res.= '"calB":"'.$rs["calB"].'",';
    $res.= '"EquilibrioX":"'.$rs["EquilibrioX"].'",';
    $res.= '"calC":"'.$rs["calC"].'",';
   	$res.= '"calD":"'  .$rs["calD"].'"}';
}
$link->close();
//echo '{"msg":"Busqueda Exitosa","msg2":['.$res.']}';	
echo $res;	
?>