<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include_once("../conexionli.php");


if($dato->accion == "buscarEnsayos"){
	$res = '';
	$link=Conectarse();
	//$SQL = "Select * From ammuestras Where idItem = '$dato->idItem'";
	$SQL = "Select * From ammuestras Where idItem = '$dato->idItem'";
	$bd=$link->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$res.= '{"idItem":"'.				$rs["idItem"].				'",';
		$res.= '"CodInforme":"'. 			$rs["CodInforme"]. 			'",';
		$res.= '"idMuestra":' 				.json_encode($rs["idMuestra"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
		$res.= '"Objetivo":' 				.json_encode($rs["Objetivo"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
		$res .= '"Taller":"'. 				$rs["Taller"]. 				'",';
		$res .= '"conEnsayo":"'. 			$rs["conEnsayo"]. 			'"}';
	}
	$link->close();
	echo $res;	

}

?>