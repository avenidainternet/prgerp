<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$dato = json_decode(file_get_contents("php://input"));
include_once("conexionli.php");
$res = '';
$link=Conectarse();
$SQL = "SELECT * FROM tablaindicadores Where agnoInd = '$dato->agnoInd' and mesInd = '$dato->mesInd'";
$bd=$link->query($SQL);
if($rs=mysqli_fetch_array($bd)){
	$bdUfRef=$link->query("Select * From tablaRegForm");
	if($rowUfRef=mysqli_fetch_array($bdUfRef)){
		$valorUFRef = $rowUfRef['valorUFRef'];
	}

	$ins45 = 'Vacio';
	$SQLts = "Select * From tablasegfacturas Where rangoDesde = 45";
	$bdts=$link->query($SQLts);
	if($rowts=mysqli_fetch_array($bdts)){
		$ins45 = $rowts['Instrucciones'];
	}	
	

	$res.= '{"agnoInd":"' 	.$rs["agnoInd"].	'",';
    $res.= '"valorUFRef":"' .$valorUFRef.		'",';
    //$res.= '"ins45":"' 		.$ins45.			'",';
    $res.= '"mesInd":"' 	.$rs["mesInd"].		'",';
    $res.= '"rCot":"'		.$rs["rCot"]. 		'",';
    $res.= '"indMin":"' 	.$rs["indMin"]. 	'",';
    $res.= '"indMeta":"' 	.$rs["indMeta"]. 	'",';
    $res.= '"indDesc":"' 	.$rs["indDesc"]. 	'",';
    $res.= '"descrDesc":"' 	.$rs["descrDesc"]. 	'",';
    $res.= '"indDesc2":"' 	.$rs["indDesc2"]. 	'",';
    $res.= '"descrDesc2":"' .$rs["descrDesc2"]. '",';
    $res.= '"indDesc3":"' 	.$rs["indDesc3"]. 	'",';
   	$res.= '"descrDesc3":"' .$rs["descrDesc3"]. '"}';
}
$link->close();
//echo '{"msg":"Busqueda Exitosa","msg2":['.$res.']}';	
echo $res;	

?>