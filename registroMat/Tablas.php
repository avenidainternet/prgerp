<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include_once("../../conexionli.php");

$outp = "";

$link=Conectarse();
$SQL = "Select * From registromuestras"
$bd=$link->query($SQL);
while($rs = mysqli_fetch_array($bd)){

		$outp .= '{"CAM":"'  . 				$rs["CAM"]. 				'",';
		$outp .= '"Fan":"'. 				$rs["Fan"]. 				'",';
		$outp .= '"fechaRegistro":"'. 		$rs["fechaRegistro"]. 		'",';
		$outp .= '"usrRecepcion":"'. 		$rs["usrRecepcion"]. 		'",';
		$outp .= '"Descripcion":"'. 		$rs["Descripcion"]. 		'",';
	    $outp .= '"RutCli":"'. 			    $rs["RutCli"]. 			    '"}';
	}
}
//$outp ='{"records":['.$outp.']}';
$link->close();
echo $outp;
?>