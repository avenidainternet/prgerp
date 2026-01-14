<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include("../conexioncert.php");
$output = [];
$link=ConectarseCert();
$outp = "";
$SQL = "SELECT * FROM clientes Order By Cliente";
$bd=$link->query($SQL);
while($rs=mysqli_fetch_array($bd)){
	$output[] = $rs;	
}
$link->close();
echo json_encode($output);
?>