<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include_once("../conexionli.php"); 
$res = '';
$link=Conectarse();
$SQL = "SELECT * FROM clientes Where RutCli = '$dato->RutCli'"; 
$bd=$link->query($SQL);
if($rs=mysqli_fetch_array($bd)){

	$res.= '{"RutCli":"'.			$rs["RutCli"].		'",';
    $res.= '"Cliente":"'.			$rs["Cliente"]. 	'",';
    $res.= '"Giro":' 	            .json_encode($rs["Giro"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
    $res.= '"Telefono":"'.			$rs["Telefono"]. 	'",';
   	$res.= '"Direccion":"'. 		trim($rs["Direccion"]). 	'"}';
}
$link->close();
//echo '{"msg":"Busqueda Exitosa","msg2":['.$res.']}';	
echo $res;	

?>
