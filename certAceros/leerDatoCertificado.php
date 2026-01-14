<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));
	
$Sitio = '';
if(isset($dato->Sitio)){ $Sitio = $dato->Sitio; } 

include("../conexioncert.php"); 
include("../conexionli.php"); 

$res = '';
if($dato->accion == 'rescataCodigos'){

	$linkc=ConectarseCert(); 
	$SQL = "SELECT * FROM certificado Where CodCertificado = '$dato->CodCertificado'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
	    $actSQL="UPDATE certificado SET ";
	    $actSQL.="CodInforme        	= '".$dato->CodInforme.         	"' ";
	    $actSQL.="WHERE CodCertificado 	= '$dato->CodCertificado'";
	    $bdAct=$linkc->query($actSQL);
	}
	$linkc->close();

	$link=Conectarse();
	$res = "";
	$SQL = "SELECT * FROM aminformes Where CodInforme = '$dato->CodInforme'";
	$bd=$link->query($SQL);
	if($rs=mysqli_fetch_array($bd)){
		$idMuestra = '';
		$SQLm = "SELECT * FROM ammuestras Where CodInforme = '$dato->CodInforme'";
		$bdm=$link->query($SQLm);
		if($rsm=mysqli_fetch_array($bdm)){
			$idMuestra = $rsm['idMuestra'];
		}
		$res.= '{"CodigoVerificacion":"'.	$rs["CodigoVerificacion"].				'",';
		$res.= '"tipoMuestra":"'. 			$rs["tipoMuestra"]. 					'",';
		$res.= '"idMuestra":"'. 			$idMuestra. 							'",';
		$res.= '"imgQR":"'. 				$rs["imgQR"]. 							'"}';
	}
	$link->close();	
	echo $res;	

	$json_string = $res;
	$file = 'aminformes.json';
	file_put_contents($file, $json_string);

}  

if($dato->accion == 'L'){   
	$linkc=ConectarseCert(); 
	$SQL = "SELECT * FROM tipoaceros Where nAcero = '$dato->nAcero'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$res.= '{"nAcero":"'.				$rs["nAcero"].				'",';
		$res.= '"Acero":' 					.json_encode($rs["Acero"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
		$res.= '"Estado":"'. 				$rs["Estado"]. 					'"}';
	}else{
		$SQL = "SELECT * FROM tipoaceros Order By nAcero Desc";
		$bd=$linkc->query($SQL);
		if($rs = mysqli_fetch_array($bd)){
			$nAcero = $rs["nAcero"] + 1;
			$Acero  = 'Acero nuevo...';
			$Estado = 'on';
			$res.= '{"nAcero":"'.				$nAcero.				'",';
			$res.= '"Acero":"'. 				$Acero. 				'",';
			$res.= '"Estado":"'. 				$Estado.				'"}';
		}else{
			$nAcero = 1;
			$Acero  = 'Nuevo Acero...';
			$Estado = 'on';
			$res.= '{"nAcero":"'.				$nAcero.				'",';
			$res.= '"Acero":"'. 				$Acero. 				'",';
			$res.= '"Estado":"'. 				$Estado.				'"}';
		}
	}
	$linkc->close();
	echo $res;	
}


if($dato->accion == 'G'){
	$Estado = 'on';
	$linkc=ConectarseCert();
	$SQL = "SELECT * FROM tipoaceros Where nAcero = '$dato->nAcero'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){

	    $actSQL="UPDATE tipoaceros SET ";
	    $actSQL.="nAcero             	= '".$dato->nAcero.             "', ";
	    $actSQL.="Acero        			= '".$dato->Acero.         		"' ";
	    $actSQL.="WHERE nAcero 			= '".$dato->nAcero. 			"'";
	    $bdAct=$linkc->query($actSQL);
	}else{
     	$linkc->query("insert into tipoaceros (
												nAcero				,
												Acero				,
	                                            Estado 						
                                        ) 
                                 values (	
	                                            '$dato->nAcero' 		,
	                                            '$dato->Acero' 			,
	                                            '$Estado' 					
                                        )"
                        );
	}
	$linkc->close();
}

if($dato->accion == 'D'){
	$linkc=ConectarseCert();
	$SQL = "SELECT * FROM tipoaceros Where nAcero = '$dato->nAcero'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$Estado = 'off';
	    $actSQL="UPDATE tipoaceros SET ";
	    $actSQL.="Estado            	= '".$Estado. 				"' ";
	    $actSQL.="WHERE nAcero 			= '".$dato->nAcero. 		"'";
	    $bdAct=$linkc->query($actSQL);
	}
	$linkc->close();
}
if($dato->accion == 'H'){
	$linkc=ConectarseCert();
	$SQL = "SELECT * FROM tipoaceros Where nAcero = '$dato->nAcero'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$Estado = 'on';
	    $actSQL="UPDATE tipoaceros SET ";
	    $actSQL.="Estado            	= '".$Estado. 				"' ";
	    $actSQL.="WHERE nAcero  		= '".$dato->nAcero. 		"'";
	    $bdAct=$linkc->query($actSQL);
	}
	$linkc->close();
}
if($dato->accion == 'E'){
	$linkc=ConectarseCert();
	$SQL = "SELECT * FROM certificado Where CodCertificado = '$dato->CodCertificado'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$bdAct=$linkc->query("Delete From certificado Where CodCertificado = '$dato->CodCertificado'");	
	}
	$linkc->close();
}


?>