<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("../conexioncertnuve.php"); 
$res = '';
	$linkn=ConectarseN();
	$SQL = "SELECT * FROM clientes'";
	$bd=$linkn->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$Hes = 'off';
		if($rs['Hes']){
			$Hes = $rs['Hes'];
		}

		$res.= '{"RutCli":"'.				$rs["RutCli"].			'",';
		$res.= '"Cliente":"'. 				$rs["Cliente"]. 		'",';
		$res.= '"Direccion":"'. 			$rs["Direccion"]. 		'",';
		$res.= '"Telefono":"'. 				$rs["Telefono"]. 		'",';
		$res.= '"Celular":"'. 				$rs["Celular"]. 		'",';
		$res.= '"Email":"'. 				$rs["Email"]. 			'",';
		$res.= '"Contacto":"'. 				$rs["Contacto"]. 		'",';
		$res.= '"nCertificados":"'. 		$rs["nCertificados"]. 	'",';
		$res.= '"Estado":"'. 				$rs["Estado"]. 			'",';
		$res.= '"Sitio":"'. 				$rs["Sitio"]. 			'",';
		$res.= '"Hes":"'. 					$Hes. 					'"}';
	}
	$linkn->close();
	echo $res;	
?>