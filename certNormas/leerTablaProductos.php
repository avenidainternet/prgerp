<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include("../conexioncert.php");

$output = [];
$link=ConectarseCert();
$outp = "";
$SQL = "SELECT * FROM normas Order By nNorma";
$bd=$link->query($SQL);
while($rs=mysqli_fetch_array($bd)){
	if ($outp != "") {$outp .= ",";}
	$outp .= '{"nNorma":"'  . 			$rs["nNorma"]. 			'",';
	$outp .= '"Norma":' 			    .json_encode($rs["Norma"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
	$outp .= '"Estado":"'. 				$rs["Estado"]. 			'"}';
}
$link->close();
$outp ='{"records":['.$outp.']}';
echo ($outp);

//echo json_encode($outp);
?>