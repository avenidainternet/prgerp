<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php");
$link=Conectarse();
$SQL = "DELETE FROM contactoscli Where RutCli = '$dato->RutCli' and nContacto = '$dato->nContacto'";
$bd=$link->query($SQL);
$link->close();
?>