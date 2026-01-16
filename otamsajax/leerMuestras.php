<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include_once("../conexionli.php");

if($dato->accion == "lectura"){
	$outp = "";
	$link=Conectarse();
	$SQL = "Select * From ammuestras Where idItem Like '%$dato->RAM%' Order By idItem";
	$bd=$link->query($SQL);
	while($rs = mysqli_fetch_array($bd)){
			$cEnsayos = 0;
			$i = 0;
			$idEnsayo = '';
			$txtEnsayos ='';
			$SQLc = "Select * From amtabensayos Where idItem = '".$rs['idItem']."'";
			$bdc=$link->query($SQLc);
			while($rowc=mysqli_fetch_array($bdc)){
				$idEnsayo = $rowc['idEnsayo'];
				$cEnsayos = $rowc['cEnsayos'];
				$i++;
				if($i > 1){ 
					$txtEnsayos .= ', '.$rowc['idEnsayo'].'('.$rowc['cEnsayos'].'';
				}else{
					$txtEnsayos = $rowc['idEnsayo'].'('.$rowc['cEnsayos'].')';
				}

			}
			$nSolTaller = '';
			if($rs["Taller"] == 'on'){
				$bdCot=$link->query("Select * From formRAM Where RAM = '$dato->RAM'");
				if($rowCot=mysqli_fetch_array($bdCot)){
					$nSolTaller = $rowCot['nSolTaller'];
				}
			}
			if ($outp != "") {$outp .= ",";}
			$outp .= '{"CodInforme":"'  . 		$rs["CodInforme"]. 			'",';
			$outp .= '"idItem":"'. 				$rs["idItem"]. 				'",';
			$outp.= '"idMuestra":' 				.json_encode($rs["idMuestra"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
			$outp.= '"Objetivo":' 				.json_encode($rs["Objetivo"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
			$outp .= '"Taller":"'. 				$rs["Taller"]. 				'",';
			$outp .= '"idEnsayo":"'. 			$idEnsayo. 					'",';
			$outp .= '"nSolTaller":"'. 			$nSolTaller. 				'",';
			$outp .= '"cEnsayos":"'. 			$cEnsayos. 					'",';
			$outp .= '"txtEnsayos":"'. 			$txtEnsayos. 				'",';
		    $outp .= '"conEnsayo":"'. 			$rs["conEnsayo"]. 			'"}';
	}
	$outp ='{"records":['.$outp.']}';
	$link->close();
	echo ($outp);
}

if($dato->accion == "buscar"){
	$res = '';
	$link=Conectarse();
	//$SQL = "Select * From ammuestras Where idItem = '$dato->idItem'";
	$SQL = "Select * From ammuestras Where idItem = '$dato->idItem'";
	$bd=$link->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$nSolTaller = 1000;
		$fd = explode('-', $dato->idItem);
		$RAM = $fd[0];
			$bdCot=$link->query("Select * From formRAM Where RAM = '$RAM'");
			if($rowCot=mysqli_fetch_array($bdCot)){
				$nSolTaller = $rowCot['nSolTaller'];
			}
			//$nSolTaller = 1000;
			
		$res.= '{"idItem":"'.				$rs["idItem"].				'",';
		$res.= '"CodInforme":"'. 			$rs["CodInforme"]. 			'",';
		$res.= '"idMuestra":' 				.json_encode($rs["idMuestra"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
		$res.= '"Objetivo":' 				.json_encode($rs["Objetivo"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
		$res .= '"Taller":"'. 				$rs["Taller"]. 				'",';
		$res .= '"nSolTaller":"'. 			$nSolTaller. 				'",';
		$res .= '"conEnsayo":"'. 			$rs["conEnsayo"]. 			'"}';
	}
	$link->close();
	echo $res;	

}

if($dato->accion == "guardar"){
	$res = '';
	$OK = 'NO';
	$link=Conectarse();
	//$SQL = "Select * From ammuestras Where idItem = '$dato->idItem'";
	$SQL = "Select * From ammuestras Where idItem = '$dato->idItem'";
	$bd=$link->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE ammuestras SET ";
        $actSQL.="Taller      		='".$dato->Taller.      "',";
        $actSQL.="conEnsayo    		='".$dato->conEnsayo.   "',";
        $actSQL.="Objetivo    		='".$dato->Objetivo.   	"',";
        $actSQL.="idMuestra       	='".$dato->idMuestra.   "'";
        $actSQL.="WHERE idItem      = '$dato->idItem'";
        $bdAct=$link->query($actSQL);
		$OK = $bdAct;
	}
	$link->close();
	$res.= '{"estatus":"'.				$OK.				'"}';
	echo $res;	
}

?>