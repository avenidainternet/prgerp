<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php"); 
$link=Conectarse();
$outp = "";
$SQL = "SELECT * FROM usuarios where nPerfil = 1 and Inspector = 'on'";
$bd=$link->query($SQL);
while($rs=mysqli_fetch_array($bd)){
  if ($outp != "") {$outp .= ",";}
  $outp .= '{"usr":"'  		. $rs["usr"] 		    . '",';
  $outp .= '"usuario":"'	. $rs["usuario"]      	. '"}';
}
$outp ='{"records":['.$outp.']}';
$link->close();

$json_string = $outp;
$file = 'usuarios.json';
file_put_contents($file, $json_string);

echo($outp);
?>