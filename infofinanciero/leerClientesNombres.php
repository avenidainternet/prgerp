<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php"); 
$res = '';
$link=Conectarse();

$SQL = "SELECT * FROM clientes Where Estado != 'off' and Cliente like '%$dato->Cliente%'"; 
$bd=$link->query($SQL);
if($rs = mysqli_fetch_array($bd)){
	$SQLf = "SELECT * FROM solfactura Where RutCli = '".$rs['RutCli']."'"; 
	$bdf=$link->query($SQLf);
	if($rsf = mysqli_fetch_array($bdf)){

		$res.= '{"RutCli":"'.				$rs["RutCli"].						'",';
	   	$res.= '"Cliente":"'. 				trim($rs["Cliente"]). 				'"}';
	
	}

}
$link->close();
echo $res;	
?>