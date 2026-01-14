<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));
	
$Sitio = '';
if(isset($dato->Sitio)){ $Sitio = $dato->Sitio; } 

include("../conexioncert.php"); 
$res = '';
if($dato->accion == 'L'){   
	$linkc=ConectarseCert();
	$SQL = "SELECT * FROM certificado Where CodCertificado = '$dato->CodCertificado'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$SQLcl = "SELECT * FROM clientes Where RutCli = '".$rs['RutCli']."'";
		$bdcl=$linkc->query($SQLcl);
		if($rscl = mysqli_fetch_array($bdcl)){

		}
		

		$res.= '{"RutCli":"'.				$rs["RutCli"].				'",';
		$res.= '"Contacto":"'. 				$rscl["Contacto"]. 			'",';
		$res.= '"fechaUpLoad":"'. 			$rs["fechaUpLoad"]. 		'",';
		$res.= '"Lote":"'. 					$rs["Lote"]. 				'",';
		$res.= '"CodCertificado":"'. 		$rs["CodCertificado"]. 		'",';
		$res.= '"CodigoVerificacion":"'. 	$rs["CodigoVerificacion"]. 	'",';
		$res.= '"pdf":"'. 					$rs["pdf"]. 				'",';
		$res.= '"Estado":"'. 				$rs["Estado"]. 				'"}';
	}
	$linkc->close();
	echo $res;	
}


if($dato->accion == 'G'){
	$Estado = 'on';
	$upLoad = 'off';
	$pdf	= '';
	if(isset($dato->pdf)){
		$pdf = $dato->pdf;
	}
	$linkc=ConectarseCert();
	$SQL = "SELECT * FROM certificado Where CodCertificado = '$dato->CodCertificado'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){

		$CodigoVerificacion = '';
		if($rs['CodigoVerificacion']){
			$CodigoVerificacion = $rs['CodigoVerificacion'];
		}else{
			$i=0; 
			$password=""; 
			$pw_largo = 12; 
			$desde_ascii = 50; // "2" 
			$hasta_ascii = 122; // "z" 
			$no_usar = array (58,59,60,61,62,63,64,73,79,91,92,93,94,95,96,108,111); 
			while ($i < $pw_largo) { 
				mt_srand ((double)microtime() * 1000000); 
				$numero_aleat = mt_rand ($desde_ascii, $hasta_ascii); 
				if (!in_array ($numero_aleat, $no_usar)) { 
					$password = $password . chr($numero_aleat); 
					$i++; 
				} 
			}
			$CodigoVerificacion = $password;
		}
	    $actSQL="UPDATE certificado SET ";
	    $actSQL.="RutCli               	= '".$dato->RutCli.                	"', ";
	    $actSQL.="CodigoVerificacion    = '".$CodigoVerificacion.     		"', ";
	    $actSQL.="pdf               	= '".$pdf.                			"', ";
	    $actSQL.="Lote        			= '".$dato->Lote.         			"' ";
	    $actSQL.="WHERE CodCertificado 	= '".$dato->CodCertificado. 		"'";
	    $bdAct=$linkc->query($actSQL);
	}else{
		$i=0; 
		$password=""; 
		$pw_largo = 12; 
		$desde_ascii = 50; // "2" 
		$hasta_ascii = 122; // "z" 
		$no_usar = array (58,59,60,61,62,63,64,73,79,91,92,93,94,95,96,108,111); 
		while ($i < $pw_largo) { 
			mt_srand ((double)microtime() * 1000000); 
			$numero_aleat = mt_rand ($desde_ascii, $hasta_ascii); 
			if (!in_array ($numero_aleat, $no_usar)) { 
				$password = $password . chr($numero_aleat); 
				$i++; 
			} 
		}
		$CodigoVerificacion = $password;

     	$linkc->query("insert into certificado (
												CodCertificado				,
												CodigoVerificacion			,
	                                            Lote 						,
	                                           	RutCli 						,
	                                           	Estado						,
	                                           	pdf							,
	                                           	upLoad
                                        ) 
                                 values (	
	                                            '$dato->CodCertificado' 	,
	                                            '$CodigoVerificacion' 		,
	                                            '$dato->Lote' 				,
	                                            '$dato->RutCli' 			,
	                                            '$Estado' 					,
	                                            '$pdf' 						,
	                                            '$upLoad'
                                        )"
                        );
	}
	$linkc->close();
}

if($dato->accion == 'D'){
	$linkc=ConectarseCert();
	$SQL = "SELECT * FROM certificado Where CodCertificado = '$dato->CodCertificado'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$Estado = 'off';
	    $actSQL="UPDATE certificado SET ";
	    $actSQL.="Estado            	= '".$Estado. 				"' ";
	    $actSQL.="WHERE CodCertificado 	= '".$dato->CodCertificado. "'";
	    $bdAct=$linkc->query($actSQL);
	}
	$linkc->close();
}
if($dato->accion == 'H'){
	$linkc=ConectarseCert();
	$SQL = "SELECT * FROM certificado Where CodCertificado = '$dato->CodCertificado'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$Estado = 'on';
	    $actSQL="UPDATE clientes SET ";
	    $actSQL.="Estado            	= '".$Estado. 		"' ";
	    $actSQL.="WHERE CodCertificado  = '".$dato->CodCertificado. "'";
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