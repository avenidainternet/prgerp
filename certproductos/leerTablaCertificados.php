<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include("../conexioncert.php");

$output = [];
$link=ConectarseCert();
$outp = "";
$SQL = "SELECT * FROM certificado Order By CodCertificado";
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
	$outp .= '"fechaUpLoad":"'. 		$rs["fechaUpLoad"]. 		'",';
	$outp .= '"CodCertificado":"'. 		$rs["CodCertificado"]. 		'",';
	$outp .= '"CodigoVerificacion":"'. 	$rs["CodigoVerificacion"]. 	'",';
	$outp .= '"Lote":"'. 				$rs["Lote"]. 				'",';
	$outp .= '"nDescargas":"'. 			$rs["nDescargas"]. 			'",';
	$outp .= '"upLoad":"'. 				$rs["upLoad"]. 				'",';
	$outp .= '"Estado":"'. 				$rs["Estado"]. 				'",';
	$outp .= '"pdf":"'. 				$rs["pdf"]. 				'"}';
}
$link->close();
$outp ='{"records":['.$outp.']}';
echo ($outp);

//echo json_encode($outp);
?>