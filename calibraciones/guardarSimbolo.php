<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$dato = json_decode(file_get_contents("php://input"));
include("../conexionli.php");
$link=Conectarse();
$SQL = "SELECT * FROM tabparensayos where idEnsayo = '$dato->idEnsayo' and tpMuestra = '$dato->tpMuestra' and Simbolo = '$dato->sQuimico'";
$bd=$link->query($SQL);
if($row=mysqli_fetch_array($bd)){
	if($dato->Imprime == 'A'){
		$dato->Imprime = $row['imprimible'];
	}else{
		if($row['imprimible'] == $dato->Imprime){
			if($row['imprimible'] == 'on'){
				$dato->Imprime = 'off';
			}else{
				$dato->Imprime = 'on';
			}
		}
	}
	$actSQL="UPDATE tabparensayos SET ";
	$actSQL.="Simbolo       	= '".$dato->sQuimico.       	"', ";
    $actSQL.="valorDefecto 		= '".$dato->vDefecto.       	"', ";
    $actSQL.="valorDefectoFe 	= '".$dato->vDefectoFe.       	"', ";
    $actSQL.="imprimible    	= '".$dato->Imprime.        	"' ";
	$actSQL.="Where idEnsayo 	= '$dato->idEnsayo' and tpMuestra = '$dato->tpMuestra' and Simbolo = '$dato->sQuimico'";
	$bdAct=$link->query($actSQL);
}else{
	$link->query("insert into tabparensayos(	idEnsayo,
												tpMuestra,
												Simbolo,
												valorDefecto,
												valorDefectoFe,
												imprimible
													) 
									values 	(	'$dato->idEnsayo',
												'$dato->tpMuestra',
												'$dato->sQuimico',
												'$dato->vDefecto',
												'$dato->vDefectoFe',
												'$dato->Imprime'
				)");

}
$link->close();
?>