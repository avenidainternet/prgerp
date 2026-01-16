<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$dato = json_decode(file_get_contents("php://input"));
include("../conexionli.php");
$link=Conectarse();
$actSQL="UPDATE tablaregform SET ";
$actSQL.="valorUFRef     = '".$dato->valorUFRef.  "', ";
$actSQL.="valorUSRef     = '".$dato->valorUSRef.  "' ";
$bdAct=$link->query($actSQL);
$link->close();
?>