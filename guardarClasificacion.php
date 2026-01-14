<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$dato = json_decode(file_get_contents("php://input"));
include("conexionli.php");
$link=Conectarse();
$SQL = "SELECT * FROM tablarangoestrellas Where Clasificacion = '$dato->Clasificacion'";
$bd=$link->query($SQL);
if($row=mysqli_fetch_array($bd)){
	$actSQL="UPDATE tablarangoestrellas SET ";
	$actSQL.="desde           	    = '".$dato->desde. 	    "', ";
	$actSQL.="hasta           	    = '".$dato->hasta. 		"' ";
	$actSQL.="Where Clasificacion 	= '$dato->Clasificacion'";
	$bdAct=$link->query($actSQL);
}else{
     $link->query("insert into tablarangoestrellas (
                                           	Clasificacion,
                                            desde,
                                            hasta
                                        ) 
                                 values (	'$dato->Clasificacion',
                                            '$dato->desde',
                                            '$dato->hasta'
                                        )"
                        );

}
$link->close();
?>