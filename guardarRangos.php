<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$dato = json_decode(file_get_contents("php://input"));
include("conexionli.php");
$link=Conectarse();
$SQL = "SELECT * FROM tablaindicadores Where agnoInd = '$dato->agnoInd' and mesInd = '$dato->mesInd'";
$bd=$link->query($SQL);
if($row=mysqli_fetch_array($bd)){
	$actSQL="UPDATE tablaindicadores SET ";
	$actSQL.="indMin           	= '".$dato->indMin. 	"', ";
	$actSQL.="indMeta           = '".$dato->indMeta. 	"', ";
	$actSQL.="indDesc           = '".$dato->indDesc. 	"', ";
	$actSQL.="descrDesc         = '".$dato->descrDesc. 	"', ";
	$actSQL.="indDesc2          = '".$dato->indDesc2. 	"', ";
	$actSQL.="descrDesc2        = '".$dato->descrDesc2. "', ";
	$actSQL.="indDesc3          = '".$dato->indDesc3. 	"', ";
	$actSQL.="descrDesc3        = '".$dato->descrDesc3. "', ";
	$actSQL.="rCot           	= '".$dato->rCot. 		"' ";
	$actSQL.="Where agnoInd 	= '$dato->agnoInd' and mesInd = '$dato->mesInd'";
	$bdAct=$link->query($actSQL);
}else{
     $link->query("insert into tablaindicadores (
                                           	agnoInd,
                                            mesInd,
                                            indMin,
                                            indMeta,
                                            indDesc,
                                            descrDesc,
                                            indDesc2,
                                            descrDesc2,
                                            indDesc3,
                                            descrDesc3,
                                            rCot
                                        ) 
                                 values (	'$dato->agnoInd',
                                            '$dato->mesInd',
                                            '$dato->indMin',
                                            '$dato->indMeta',
                                            '$dato->indDesc',
                                            '$dato->descrDesc',
                                            '$dato->indDesc2',
                                            '$dato->descrDesc2',
                                            '$dato->indDesc3',
                                            '$dato->descrDesc3',
                                            '$dato->rCot'
                                        )"
                        );

}
$link->close();
?>