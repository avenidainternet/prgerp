<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php"); 
$res = '';
$link=Conectarse();

$SQL = "SELECT * FROM clientes Where RutCli = '$dato->RutCli'";
$bd=$link->query($SQL);
if($rs = mysqli_fetch_array($bd)){
	$HES = 'off';
	if($rs['HES']){
		$HES = $rs['HES'];
	}

	$res.= '{"RutCli":"'.				$rs["RutCli"].			'",';
	$res.= '"HES":"'. 					$HES. 					'"}';
}
$link->close();
echo $res;	
?>