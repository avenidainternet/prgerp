<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include("../conexioncert.php");

$output = [];
$link=ConectarseCert();
$outp = "";
$SQL = "SELECT * FROM tipoProductos Order By nProducto";
$bd=$link->query($SQL);
while($rs=mysqli_fetch_array($bd)){
	if ($outp != "") {$outp .= ",";}
	$outp .= '{"nProducto":"'  . 		$rs["nProducto"]. 			'",';
	$outp .= '"Producto":"'  . 			$rs["Producto"]. 			'",';
	$outp .= '"Estado":"'. 				$rs["Estado"]. 				'"}';
}
$link->close();
$outp ='{"records":['.$outp.']}';
echo ($outp);

//echo json_encode($outp);
?>