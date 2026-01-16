<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php");
$agnoAct = date('Y');
$mesAct = date('m');
$outp = "";
$rCot = 0;

$link=Conectarse();
$SQL = "Select * From clientes where Estado = 'on' Order By Cliente";
$bd=$link->query($SQL);
while($rs = mysqli_fetch_array($bd)){
	$nSolicitud = '';
	$SQLf = "SELECT * FROM solfactura Where RutCli like '%".$rs['RutCli']."%'"; 
	// $nSolicitud = $SQLf;
	// $bdf=$link->query($SQLf);
	// if($rsf = mysqli_fetch_array($bdf)){
	// 	$nSolicitud = $rsf['nSolicitud'];
	// }
		if ($outp != "") {$outp .= ",";}
		$outp .= '{"RutCli":"'  . 			$rs["RutCli"]. 				'",';
		$outp .= '"Cliente":' 				.json_encode($rs["Cliente"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
		$outp .= '"nSolicitud":"'. 			$nSolicitud. 				'",';
		$outp .= '"Direccion":' 				.json_encode($rs["Direccion"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
		$outp .= '"cFree":"'. 				$rs["cFree"]. 				'",';
		$outp .= '"Docencia":"'. 			$rs["Docencia"]. 			'",';
		$outp .= '"Clasificacion":"'. 		$rs["Clasificacion"]. 		'"}';
}
$outp ='{"records":['.$outp.']}';
$link->close();
echo ($outp);
?>