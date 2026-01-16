<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php");
$outp = "";
$link=Conectarse();
$SQL = "Select * From contactoscli where RutCli = '$dato->RutCli' Order By Contacto";
$bd=$link->query($SQL);
while($rs = mysqli_fetch_array($bd)){
	if ($outp != "") {$outp .= ",";}
	$outp .= '{"RutCli":"'  . 			$rs["RutCli"]. 				'",';
	$outp .= '"nContacto":"'. 			$rs["nContacto"]. 			'",';
	$outp .= '"Contacto":"'. 			trim($rs["Contacto"]). 		'",';
	$outp .= '"Email":"'. 				trim($rs["Email"]). 		'",';
	$outp .= '"Telefono":"'. 			trim($rs["Telefono"]). 		'"}';

}
$outp ='{"records":['.$outp.']}';

$link->close();
echo ($outp);
?>