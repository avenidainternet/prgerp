<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php"); 

	$link=Conectarse();
	$res = "";
	$SQL = "SELECT * FROM aminformes Where CodInforme = 'AM-16117-0202'";
	$bd=$link->query($SQL);
	if($rs=mysqli_fetch_array($bd)){
		$res.= '{"CodigoVerificacion":"'.	$rs["CodigoVerificacion"].				'",';
		$res.= '"tipoMuestra":"'. 			$rs["tipoMuestra"]. 					'",';
		$res.= '"imgQR":"'. 				$rs["imgQR"]. 							'"}';
	}
	$link->close();	
	echo $res;	
?>