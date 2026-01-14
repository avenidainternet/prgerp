<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include("../conexioncert.php"); 

$output = [];
$link=ConectarseCert();

$outp = "";
$SQL = "SELECT * FROM camar Where CAMAR > 0 and RAMAR = 0 Order By CAMAR Desc";
$bd=$link->query($SQL);
while($rs=mysqli_fetch_array($bd)){
	$SQLc = "SELECT * FROM clientes where RutCli = '".$rs['RutCli']."'";
	$Cliente = '';
	$bdc=$link->query($SQLc);
	if($rsc = mysqli_fetch_array($bdc)){
		$Cliente = trim($rsc['Cliente']); 
	}

	if ($outp != "") {$outp .= ",";}
	$outp .= '{"RutCli":"'  . 			$rs["RutCli"]. 				'",';
	$outp .= '"Cliente":"'. 			$Cliente. 					'",';
	$outp .= '"RAMAR":"'. 				$rs["RAMAR"]. 				'",';
	$outp .= '"CAMAR":"'. 				$rs["CAMAR"]. 				'",';
	$outp .= '"usrResponsable":"'. 		$rs["usrResponsable"]. 		'",';
	$outp .= '"fechaPreCAM":"'. 		$rs["fechaPreCAM"]. 		'",';
	$outp .= '"nColadas":"'. 			$rs["nColadas"]. 			'"}';
}
$link->close();
$outp ='{"records":['.$outp.']}';
echo ($outp);

//echo json_encode($outp);
?>