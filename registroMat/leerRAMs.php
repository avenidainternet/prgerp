<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include_once("../conexionli.php");
$agnoAct = date('Y');
$mesAct = date('m');
$rCot	= 0;

$outp = "";

$link=Conectarse(); 

$SQL = "SELECT * FROM cotizaciones Where RAM > 0 and CAM > 0 and Estado = 'E'";
$bd=$link->query($SQL);
while($rs = mysqli_fetch_array($bd)){
	$SQLr = "SELECT * FROM registroMuestras Where RAM = '".$rs['RAM']."' and Fan = '".$rs['Fan']."'";
	$bdr=$link->query($SQLr);
	if($rsr = mysqli_fetch_array($bdr)){
		$situacionMuestra = 'R';
        $actSQL="UPDATE registromuestras SET ";
        $actSQL.="situacionMuestra	='".$situacionMuestra.	    "'";
        $actSQL.="WHERE RAM = '".$rs['RAM']."' and Fan = '".$rs['Fan']."'";
        $bdAct=$link->query($actSQL);
	}
}



$SQL = "SELECT * FROM registroMuestras Where RAM > 0 and situacionMuestra = 'R'  Order By RAM Desc";
//$SQL = "SELECT * FROM registroMuestras Where RAM > 0 and situacionMuestra = 'R' or situacionMuestra = 'P' or situacionMuestra = 'T'  Order By RAM Desc";

$bd=$link->query($SQL);
while($rs = mysqli_fetch_array($bd)){
	$Cliente = '';
	$Clasificacion = 0;
	$SQLc = "SELECT * FROM clientes where RutCli = '".$rs['RutCli']."'";
	$bdc=$link->query($SQLc);
	if($rsc = mysqli_fetch_array($bdc)){
        $Cliente = trim($rsc['Cliente']);
        
        $colorCam = 'Rojo';
        if($rs['CAM'] > 0){ // Aceptada
			$colorCam = 'Verde';
		}

		if ($outp != "") {$outp .= ",";}
		$outp .= '{"RAM":"'  . 				$rs["RAM"]. 				'",';
		$outp .= '"RutCli":"'. 				$rs["RutCli"]. 				'",';
		$outp .= '"CAM":"'. 			    $rs["CAM"]. 			    '",';
		$outp .= '"fechaRegistro":"'. 	    $rs["fechaRegistro"]. 		'",';
	    $outp.= '"Descripcion":' 			.json_encode($rs["Descripcion"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
		$outp .= '"Estado":"'. 				$rs["Estado"]. 				'",';
		$outp .= '"Fan":"'. 				$rs["Fan"]. 				'",';
		$outp .= '"colorCam":"'. 			$colorCam. 					'",';
		$outp .= '"situacionMuestra":"'. 	$rs["situacionMuestra"]. 	'",';
		$outp .= '"usrRecepcion":"'. 	    $rs["usrRecepcion"]. 	    '",';
	    $outp .= '"Cliente":"'. 			trim($Cliente). 			'"}';
	}
}
$outp ='{"records":['.$outp.']}';
$link->close();
echo ($outp);
?>