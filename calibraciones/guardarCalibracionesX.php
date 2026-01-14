<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$dato = json_decode(file_get_contents("php://input")); 
include("../conexionli.php");
$link=Conectarse();
$SQL = "SELECT * FROM calibraciones Where Equipo = '$dato->Equipo'";
$bd=$link->query($SQL);
if($row=mysqli_fetch_array($bd)){
	$actSQL="UPDATE calibraciones SET ";
	$actSQL.="calA        	= '".$dato->calA.         	"', ";
    $actSQL.="calB        	= '".$dato->calB.           "', ";
    $actSQL.="EquilibrioX 	= '".$dato->EquilibrioX. 	"', ";
    $actSQL.="calC  		= '".$dato->calC.   		"', ";
    $actSQL.="calD          = '".$dato->calD.           "' ";
    $actSQL.="WHERE Equipo	= '$dato->Equipo'";
	$bdAct=$link->query($actSQL);
}
$link->close();
?>