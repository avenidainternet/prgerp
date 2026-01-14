<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include("../conexioncert.php");

$output = [];
$link=ConectarseCert();
$outp = "";
$SQL = "SELECT * FROM tipoaceros Order By nAcero";
$bd=$link->query($SQL);
while($rs=mysqli_fetch_array($bd)){
	if ($outp != "") {$outp .= ",";}
	$outp .= '{"nAcero":"'  . 			$rs["nAcero"]. 			'",';
	$outp .= '"Acero":"'  . 			$rs["Acero"]. 			'",';
	$outp .= '"Estado":"'. 				$rs["Estado"]. 			'"}';
}
$link->close();
$outp ='{"records":['.$outp.']}';
echo ($outp);

//echo json_encode($outp);
?>