<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("conexionli.php");
$outp = "";

$link=Conectarse();
$SQL = "Select * From tablarangoestrellas Order By Clasificacion Desc";
$bd=$link->query($SQL);
while($rs = mysqli_fetch_array($bd)){
	if ($outp != "") {$outp .= ",";}
	$outp .= '{"Clasificacion":"'  . 	$rs["Clasificacion"]. 		'",';
	$outp .= '"descripcion":"'. 		$rs["descripcion"]. 		'",';
	$outp .= '"desde":"'. 				$rs["desde"]. 				'",';
	$outp .= '"hasta":"'. 				$rs["hasta"]. 				'"}';
}
$outp ='{"records":['.$outp.']}';
$link->close();
echo ($outp);
?>