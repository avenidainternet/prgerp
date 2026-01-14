<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include("../conexioncert.php"); 

$output = [];
$link=ConectarseCert();

/*
$SQL = "SELECT * FROM ar";
$bd=$link->query($SQL);
while($rs=mysqli_fetch_array($bd)){
	$ar = $rs['ar'];
	$SQLp = "SELECT * FROM certificado Where CodCertificado like '%".$rs['ar']."%'";
	$bdp=$link->query($SQLp);
	if($rsp=mysqli_fetch_array($bdp)){
		if($rsp['CodInforme']){
			$fd = explode('-', $rsp['CodInforme']);
			$RAMAR = $fd[1];

			$actSQL="UPDATE ar SET ";
			$actSQL.="RAMAR     = '".$RAMAR. 	"' ";
			$actSQL.="WHERE ar 	= '$ar'";
			$bdAct = $link->query($actSQL);

			$actSQL="UPDATE certificado SET ";
			$actSQL.="RAMAR     = '".$RAMAR. 	"' ";
			$actSQL.="WHERE CodCertificado 	like '%$ar%'";
			$bdAct = $link->query($actSQL);
	
		}
	}
	
}
*/

$outp = "";
$SQL = "SELECT * FROM ar Order By codAr Desc";
$bd=$link->query($SQL);
while($rs=mysqli_fetch_array($bd)){
	$SQLc = "SELECT * FROM clientes where RutCli = '".$rs['RutCli']."'";
	$Cliente = '';
	$bdc=$link->query($SQLc);
	if($rsc = mysqli_fetch_array($bdc)){
		$Cliente = trim($rsc['Cliente']); 
	}
	$pdf = 'pdf';
	$SQLp = "SELECT * FROM certificado Where CodCertificado like '%".$rs['ar']."%' and pdf = ''";
	$bdp=$link->query($SQLp);
	if($rsp=mysqli_fetch_array($bdp)){
		$pdf = '';
	}

	if ($outp != "") {$outp .= ",";}
	$outp .= '{"RutCli":"'  . 			$rs["RutCli"]. 				'",';
	$outp .= '"Cliente":"'. 			$Cliente. 					'",';
	$outp .= '"pdf":"'. 				$pdf. 						'",';
	$outp .= '"ar":"'. 					$rs["ar"]. 					'",';
	$outp .= '"codAr":"'. 				$rs["codAr"]. 				'",';
	$outp .= '"RAMAR":"'. 				$rs["RAMAR"]. 				'",';
	$outp .= '"fechaInspeccion":"'. 	$rs["fechaInspeccion"]. 	'",';
	$outp .= '"nColadas":"'. 			$rs["nColadas"]. 			'"}';
}
$link->close();
$outp ='{"records":['.$outp.']}';
echo ($outp);

//echo json_encode($outp);
?>