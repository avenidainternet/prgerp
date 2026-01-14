<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));
	
$Sitio = '';
if(isset($dato->Sitio)){ $Sitio = $dato->Sitio; } 

include("../conexioncert.php"); 
include("../conexionli.php"); 

$res = '';
if($dato->accion == 'leerNormas'){
	$link=ConectarseCert();
	$outp = "";
	$SQL = "SELECT * FROM normas Where Estado = 'on'";
	$bd=$link->query($SQL);
	while($rs=mysqli_fetch_array($bd)){
		
		$SQLn = "SELECT * FROM normarefcert Where CodCertificado = '$dato->CodCertificado' and nNorma = '".$rs['nNorma']."'";
		$bdn=$link->query($SQLn);
		if($rsn=mysqli_fetch_array($bdn)){

		}else{
			
			if ($outp != "") {$outp .= ",";}
			$outp .= '{"nNorma":"'  		        . $rs["nNorma"] 		. '",';
			$outp .= '"Norma":' 			    	.json_encode($rs["Norma"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
			$outp .= '"Estado":"'	                . $rs["Estado"]      	. '"}';
		}

	}
	$outp ='{"records":['.$outp.']}';
	$link->close();
	/*
	$json_string = $outp;
	$file = 'info.json';
	file_put_contents($file, $json_string); 
	*/
	echo($outp);
}

if($dato->accion == 'leerObservacionesAsignadas'){
	$link=ConectarseCert();
	$outp = "";
	$SQL = "SELECT * FROM observacionescertificados Where Estado = 'on'";
	$bd=$link->query($SQL);
	while($rs=mysqli_fetch_array($bd)){
		
		$SQLn = "SELECT * FROM observaciones Where CodCertificado = '$dato->CodCertificado' and nObservacion = '".$rs['nObservacion']."'";
		$bdn=$link->query($SQLn);
		if($rsn=mysqli_fetch_array($bdn)){
			if ($outp != "") {$outp .= ",";}
			$outp .= '{"nObservacion":"'  		        . $rs["nObservacion"] 		. '",';
			$outp .= '"Observacion":' 			    	.json_encode($rs["Observacion"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
			$outp .= '"Estado":"'	                	. $rs["Estado"]      	. '"}';
		}else{
		}

	}
	$outp ='{"records":['.$outp.']}';
	$link->close();
	/*
	$json_string = $outp;
	$file = 'info.json';
	file_put_contents($file, $json_string);
	*/
	echo($outp);
}

if($dato->accion == 'leerTodasObservaciones'){
	$link=ConectarseCert();
	$outp = "";
	$SQL = "SELECT * FROM observacionescertificados";
	$bd=$link->query($SQL);
	while($rs=mysqli_fetch_array($bd)){
		
			if ($outp != "") {$outp .= ",";}
			$outp .= '{"nObservacion":"'  		        . $rs["nObservacion"] 		. '",';
			$outp .= '"Observacion":' 			    	.json_encode($rs["Observacion"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
			$outp .= '"Estado":"'	                	. $rs["Estado"]      		. '"}';

	}
	$outp ='{"records":['.$outp.']}';
	$link->close();
	/*
	$json_string = $outp;
	$file = 'info.json';
	file_put_contents($file, $json_string);
	*/
	echo($outp);
}


if($dato->accion == 'habilitaObservaciones'){
	$link=ConectarseCert();
	$Estado = 'on';
	$SQL = "SELECT * FROM observacionescertificados Where nObservacion = '$dato->nObservacion'";
	$bd=$link->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
	    $actSQL="UPDATE observacionescertificados SET ";
	    $actSQL.="Estado        		= '".$Estado.         	"' ";
	    $actSQL.="WHERE nObservacion 	= '$dato->nObservacion'";
	    $bdAct=$link->query($actSQL);
	}
	$link->close();
}

if($dato->accion == 'deshabilitaObservaciones'){
	$link=ConectarseCert();
	$Estado = 'off';
	$SQL = "SELECT * FROM observacionescertificados Where nObservacion = '$dato->nObservacion'";
	$bd=$link->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
	    $actSQL="UPDATE observacionescertificados SET ";
	    $actSQL.="Estado        		= '".$Estado.         	"' ";
	    $actSQL.="WHERE nObservacion 	= '$dato->nObservacion'";
	    $bdAct=$link->query($actSQL);
	}
	$link->close();
}

if($dato->accion == 'actualizaObservaciones'){
	$link=ConectarseCert();
	$SQL = "SELECT * FROM observacionescertificados Where nObservacion = '$dato->nObservacion'";
	$bd=$link->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
	    $actSQL="UPDATE observacionescertificados SET ";
	    $actSQL.="Observacion        	= '".$dato->Observacion.         	"' ";
	    $actSQL.="WHERE nObservacion 	= '$dato->nObservacion'";
	    $bdAct=$link->query($actSQL);
	}else{
		$Estado = 'on';
		$link->query("insert into observacionescertificados (
			nObservacion				,
			Observacion					,
			Estado
			) 
		values (	
			'$dato->nObservacion' 		,
			'$dato->Observacion'		,
			'$Estado'
			)"
		);
	
	}
	$link->close();
}


if($dato->accion == 'leerObservaciones'){
	$link=ConectarseCert();
	$outp = "";
	$SQL = "SELECT * FROM observacionescertificados Where Estado = 'on'";
	$bd=$link->query($SQL);
	while($rs=mysqli_fetch_array($bd)){
		
		$SQLn = "SELECT * FROM observaciones Where CodCertificado = '$dato->CodCertificado' and nObservacion = '".$rs['nObservacion']."'";
		$bdn=$link->query($SQLn);
		if($rsn=mysqli_fetch_array($bdn)){
		}else{
			if ($outp != "") {$outp .= ",";}
			$outp .= '{"nObservacion":"'  		        . $rs["nObservacion"] 		. '",';
			$outp .= '"Observacion":' 			    	.json_encode($rs["Observacion"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
			$outp .= '"Estado":"'	                	. $rs["Estado"]      	. '"}';
		}

	}
	$outp ='{"records":['.$outp.']}';
	$link->close();
	/*
	$json_string = $outp;
	$file = 'info.json';
	file_put_contents($file, $json_string);
	*/
	echo($outp);
}

if($dato->accion == 'leerNormasAc'){
	$link=ConectarseCert();
	$outp = "";
	$SQL = "SELECT * FROM normas Where Estado = 'on'";
	$bd=$link->query($SQL);
	while($rs=mysqli_fetch_array($bd)){
		
		$SQLn = "SELECT * FROM normaacre Where CodCertificado = '$dato->CodCertificado' and nNorma = '".$rs['nNorma']."'";
		$bdn=$link->query($SQLn);
		if($rsn=mysqli_fetch_array($bdn)){

		}else{
			
			if ($outp != "") {$outp .= ",";}
			$outp .= '{"nNorma":"'  		        . $rs["nNorma"] 		. '",';
			$outp .= '"Norma":' 			    	.json_encode($rs["Norma"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
			$outp .= '"Estado":"'	                . $rs["Estado"]      	. '"}';
		}

	}
	$outp ='{"records":['.$outp.']}';
	$link->close();
	/*
	$json_string = $outp;
	$file = 'info.json';
	file_put_contents($file, $json_string);
	*/
	echo($outp);
}


if($dato->accion == 'leerNormasRefAsignadas'){
	$link=ConectarseCert();
	$outp = "";
	$SQL = "SELECT * FROM normas Where Estado = 'on'";
	$bd=$link->query($SQL);
	while($rs=mysqli_fetch_array($bd)){
		
		$SQLn = "SELECT * FROM normarefcert Where CodCertificado = '$dato->CodCertificado' and nNorma = '".$rs['nNorma']."'";
		$bdn=$link->query($SQLn);
		if($rsn=mysqli_fetch_array($bdn)){
			if ($outp != "") {$outp .= ",";}
			$outp .= '{"nNorma":"'  		        . $rs["nNorma"] 		. '",';
			$outp .= '"Norma":' 			    	.json_encode($rs["Norma"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
			$outp .= '"Estado":"'	                . $rs["Estado"]      	. '"}';
		}

	}
	$outp ='{"records":['.$outp.']}';
	$link->close();
	/*
	$json_string = $outp;
	$file = 'info.json';
	file_put_contents($file, $json_string);
	*/
	echo($outp);
}

if($dato->accion == 'leerNormasAceptacionRechazo'){
	$link=ConectarseCert();
	$outp = "";
	$SQL = "SELECT * FROM normas Where Estado = 'on'";
	$bd=$link->query($SQL);
	while($rs=mysqli_fetch_array($bd)){
		
		$SQLn = "SELECT * FROM normaacre Where CodCertificado = '$dato->CodCertificado' and nNorma = '".$rs['nNorma']."'";
		$bdn=$link->query($SQLn);
		if($rsn=mysqli_fetch_array($bdn)){
			if ($outp != "") {$outp .= ",";}
			$outp .= '{"nNorma":"'  		        . $rs["nNorma"] 		. '",';
			$outp .= '"Norma":' 			    	.json_encode($rs["Norma"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
			$outp .= '"Estado":"'	                . $rs["Estado"]      	. '"}';
		}

	}
	$outp ='{"records":['.$outp.']}';
	$link->close();
	/*
	$json_string = $outp;
	$file = 'info.json';
	file_put_contents($file, $json_string);
	*/
	echo($outp);
}

if($dato->accion == 'grabarPdf'){
	$linkc=ConectarseCert(); 
	$SQL = "SELECT * FROM certificado Where CodCertificado = '$dato->CodCertificado'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
	    $actSQL="UPDATE certificado SET ";
	    $actSQL.="pdf        			= '".$dato->pdf.         	"' ";
	    $actSQL.="WHERE CodCertificado 	= '$dato->CodCertificado'";
	    $bdAct=$linkc->query($actSQL);
	}
	$linkc->close();

}

if($dato->accion == 'guardarProducto'){
	$linkc=ConectarseCert(); 
	$SQL = "SELECT * FROM certificado Where CodCertificado = '$dato->CodCertificado'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$SQLtp = "SELECT * FROM tipoproductos Where nProducto = '".$dato->nProducto."'";
		$bdtp=$linkc->query($SQLtp);
		if($rstp = mysqli_fetch_array($bdtp)){

		}

		$idCertificado = 'Certificado OCP SIMET USACH '.$dato->CodCertificado.' '.$rstp["Producto"].' Plancha '.$rs["Dimension"].' Colada '.$rs["Lote"];

	    $actSQL="UPDATE certificado SET ";
	    $actSQL.="idCertificado        	= '".$idCertificado.         	"', ";
	    $actSQL.="nProducto        		= '".$dato->nProducto.         	"' ";
	    $actSQL.="WHERE CodCertificado 	= '$dato->CodCertificado'";
	    $bdAct=$linkc->query($actSQL);
	}
	$linkc->close();

	$res.= '{"idCertificado":"'		.	$idCertificado.				'"}';
	echo $res;	


}

if($dato->accion == 'guardarAcero'){
	$linkc=ConectarseCert(); 
	$SQL = "SELECT * FROM certificado Where CodCertificado = '$dato->CodCertificado'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
	    $actSQL="UPDATE certificado SET ";
	    $actSQL.="nAcero        		= '".$dato->nAcero.         	"' ";
	    $actSQL.="WHERE CodCertificado 	= '$dato->CodCertificado'";
	    $bdAct=$linkc->query($actSQL);
	}
	$linkc->close();

}

if($dato->accion == 'guardarDimension'){
	$linkc=ConectarseCert(); 
	$SQL = "SELECT * FROM certificado Where CodCertificado = '$dato->CodCertificado'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$SQLtp = "SELECT * FROM tipoproductos Where nProducto = '".$rs['nProducto']."'";
		$bdtp=$linkc->query($SQLtp);
		if($rstp = mysqli_fetch_array($bdtp)){
		}

		$Dimension = '';
		if($dato->Dimension){ 
			$idCertificado = 'Certificado OCP SIMET USACH '.$dato->CodCertificado.' '.$rstp["Producto"].' Plancha '.$dato->Dimension.' Colada '.$rs['Lote'];
		}else{
			$idCertificado = 'Certificado OCP SIMET USACH '.$dato->CodCertificado.' '.$rstp["Producto"].' Plancha '.' Colada '.$rs['Lote'];
		}

	    $actSQL="UPDATE certificado SET ";
	    $actSQL.="idCertificado        	= '".$idCertificado.         	"', ";
	    $actSQL.="Dimension        		= '".$dato->Dimension.         	"' ";
	    $actSQL.="WHERE CodCertificado 	= '$dato->CodCertificado'";
	    $bdAct=$linkc->query($actSQL);
	}
	$linkc->close();

	$res.= '{"idCertificado":"'		.	$idCertificado.				'"}';
	echo $res;	

}

if($dato->accion == 'guardaContacto'){
	$fd = explode('-', $dato->CodCertificado);
	$codAr = $fd[1];
	$linkc=ConectarseCert(); 
	$SQL = "SELECT * FROM ar Where codAr = '$codAr'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
	    $actSQL="UPDATE ar SET ";
	    $actSQL.="Contacto        		= '".$dato->Contacto.         	"' ";
	    $actSQL.="WHERE codAr 			= '$codAr'";
	    $bdAct=$linkc->query($actSQL);
	}
	$linkc->close();

}

if($dato->accion == 'guardarPeso'){
	$linkc=ConectarseCert(); 
	$SQL = "SELECT * FROM certificado Where CodCertificado = '$dato->CodCertificado'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
	    $actSQL="UPDATE certificado SET ";
	    $actSQL.="Peso        			= '".$dato->Peso.         	"' ";
	    $actSQL.="WHERE CodCertificado 	= '$dato->CodCertificado'";
	    $bdAct=$linkc->query($actSQL);
	}
	$linkc->close();

}

if($dato->accion == 'buscarCodObservacion'){
	$linkc=ConectarseCert(); 
	$SQL = "SELECT * FROM observacionescertificados Order By nObservacion Desc";
	$bd=$linkc->query($SQL);
	if($rs=mysqli_fetch_array($bd)){
		$nObservacion = $rs['nObservacion'] + 1;
		$res.= '{"nObservacion":"'		.	$nObservacion.				'",';
		$res.= '"Observacion":"'		. 	$rs["Observacion"]. 		'"}';
	}
	$linkc->close();
	echo $res;	

}

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
			$res.= '{"CodigoVerificacion":"'.	$rs["CodigoVerificacion"].				'",';
			$res.= '"tipoMuestra":"'. 			$rs["tipoMuestra"]. 					'",';
			$res.= '"fechaTerminoTaller":"'. 	$rsm["fechaTerminoTaller"]. 			'",';
			$res.= '"idMuestra":"'. 			$idMuestra. 							'",';
			$res.= '"imgQR":"'. 				$rs["imgQR"]. 							'"}';
		}
	}
	$link->close();	
	echo $res;	

	$json_string = $res;
	$file = 'aminformes.json';
	file_put_contents($file, $json_string);

}  

if($dato->accion == 'L'){   
	$linkc=ConectarseCert(); 
	$SQL = "SELECT * FROM certificado Where CodCertificado = '$dato->CodCertificado'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$fd = explode('-', $dato->CodCertificado);
		$codAr = $fd[1];

		$SQLcl = "SELECT * FROM clientes Where RutCli = '".$rs['RutCli']."'";
		$bdcl=$linkc->query($SQLcl);
		if($rscl = mysqli_fetch_array($bdcl)){

		}
		$SQLtp = "SELECT * FROM tipoproductos Where nProducto = '".$rs["nProducto"]."'";
		$bdtp=$linkc->query($SQLtp);
		if($rstp = mysqli_fetch_array($bdtp)){

		}
		$SQLar = "SELECT * FROM ar Where codAr = '".$codAr."'";
		$bdar=$linkc->query($SQLar);
		if($rsar = mysqli_fetch_array($bdar)){

		}
		$CodigoVerificacion = $rs["CodigoVerificacion"];
		if($rs["CodigoVerificacion"] == ''){
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
		$fechaCertificado = date('Y-m-d');
		if($rs['fechaCertificado'] == '0000-00-00'){
		    $actSQL="UPDATE certificado SET ";
	    	$actSQL.="fechaCertificado    	= '".$fechaCertificado.         	"' ";
	    	$actSQL.="WHERE CodCertificado 	= '$dato->CodCertificado'";
	    	$bdAct=$linkc->query($actSQL);
		}

		$idCertificado = 'Certificado OCP SIMET USACH '.$dato->CodCertificado.' '.$rstp["Producto"].' Plancha '.$rs["Dimension"].' Colada '.$rs["Lote"];

		$actSQL="UPDATE certificado SET ";
	    $actSQL.="idCertificado        	= '".$idCertificado.         	"' ";
	    $actSQL.="WHERE CodCertificado 	= '$dato->CodCertificado'";
	    $bdAct=$linkc->query($actSQL);

		
		$res.= '{"RutCli":"'.					$rs["RutCli"].					'",';
		$res.= '"Contacto":"'. 					$rsar["Contacto"]. 				'",';
		$res.= '"Cliente":"'. 					$rscl["Cliente"]. 				'",';
		$res.= '"Direccion":"'. 				$rscl["Direccion"]. 			'",';
		$res.= '"fechaCertificado":"'. 			$rs["fechaCertificado"]. 		'",';
		$res.= '"fechaUpLoad":"'. 				$rs["fechaUpLoad"]. 			'",';
		$res.= '"Lote":"'. 						$rs["Lote"]. 					'",';
		$res.= '"CodCertificado":"'. 			$rs["CodCertificado"]. 			'",';
		//$res.= '"idCertificado":"'. 			$rs["idCertificado"]. 			'",';
		$res.= '"idCertificado":"'. 			$idCertificado. 				'",';
		
		$res.= '"RAMAR":"'. 					$rsar["RAMAR"]. 					'",';
		$res.= '"nProducto":"'. 				$rs["nProducto"]. 				'",';
		$res.= '"nAcero":"'. 					$rs["nAcero"]. 					'",';
		$res.= '"Dimension":"'. 				$rs["Dimension"]. 				'",';
		$res.= '"Peso":"'. 						$rs["Peso"]. 					'",';
		$res.= '"CodInforme":"'. 				$rs["CodInforme"]. 				'",';
		$res.= '"CodigoVerificacion":"'. 		$CodigoVerificacion. 			'",';
		$res.= '"resultadoCertificacion":"'. 	$rs["resultadoCertificacion"]. 	'",';
		$res.= '"pdf":"'. 						$rs["pdf"]. 					'",';
		$res.= '"Estado":"'. 					$rs["Estado"]. 					'"}';


	    $actSQL="UPDATE certificado SET ";
	    $actSQL.="CodigoVerificacion    = '".$CodigoVerificacion.         	"' ";
	    $actSQL.="WHERE CodCertificado 	= '$dato->CodCertificado'";
	    $bdAct=$linkc->query($actSQL);

	}
	$linkc->close();
	echo $res;	
}


if($dato->accion == 'quitarObservaciones'){
	$linkc=ConectarseCert();
	$bdAct=$linkc->query("Delete From observaciones Where CodCertificado = '$dato->CodCertificado' and nObservacion = '$dato->nObservacion'");	
	$linkc->close();

}

if($dato->accion == 'quitarNormaRef'){
	$linkc=ConectarseCert();
	$bdAct=$linkc->query("Delete From normarefcert Where CodCertificado = '$dato->CodCertificado' and nNorma = '$dato->nNorma'");	
	$linkc->close();

}

if($dato->accion == 'quitarNormaAcRe'){
	$linkc=ConectarseCert();
	$bdAct=$linkc->query("Delete From normaacre Where CodCertificado = '$dato->CodCertificado' and nNorma = '$dato->nNorma'");	
	$linkc->close();

}

if($dato->accion == 'asignarLote'){
	$linkc=ConectarseCert();
	$SQL = "SELECT * FROM certificado Where CodCertificado = '$dato->CodCertificado'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$SQLtp = "SELECT * FROM tipoproductos Where nProducto = '".$rs['nProducto']."'";
		$bdtp=$linkc->query($SQLtp);
		if($rstp = mysqli_fetch_array($bdtp)){
		}

		$Lote = '';
		if($dato->Lote){ 
			$idCertificado = 'Certificado OCP SIMET USACH '.$dato->CodCertificado.' '.$rstp["Producto"].' Plancha '.$rs["Dimension"].' Colada '.$dato->Lote;
		}else{
			$idCertificado = 'Certificado OCP SIMET USACH '.$dato->CodCertificado.' '.$rstp["Producto"].' Plancha '.$rs["Dimension"].' Colada';
		}


	    $actSQL="UPDATE certificado SET ";
	    $actSQL.="idCertificado        	= '".$idCertificado.    "', ";
	    $actSQL.="Lote        			= '".$dato->Lote.         	"' ";
	    $actSQL.="WHERE CodCertificado 	= '$dato->CodCertificado'";
	    $bdAct=$linkc->query($actSQL);
	}
	$linkc->close();

	$res.= '{"idCertificado":"'		.	$idCertificado.				'"}';

	echo $res;	

}

if($dato->accion == 'gardarFechaEmision'){
	$linkc=ConectarseCert();
	$SQL = "SELECT * FROM certificado Where CodCertificado = '$dato->CodCertificado'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
	    $actSQL="UPDATE certificado SET ";
	    $actSQL.="fechaCertificado			= '".$dato->fechaCertificado.         	"' ";
	    $actSQL.="WHERE CodCertificado 		= '$dato->CodCertificado'";
	    $bdAct=$linkc->query($actSQL);
	}
	$linkc->close();
}
if($dato->accion == 'cambiarResultado'){
	$linkc=ConectarseCert();
	$SQL = "SELECT * FROM certificado Where CodCertificado = '$dato->CodCertificado'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
	    $actSQL="UPDATE certificado SET ";
	    $actSQL.="resultadoCertificacion	= '".$dato->resultadoCertificacion.         	"' ";
	    $actSQL.="WHERE CodCertificado 		= '$dato->CodCertificado'";
	    $bdAct=$linkc->query($actSQL);
	}
	$linkc->close();
}

if($dato->accion == 'asignarObservaciones'){
	$linkc=ConectarseCert();
	$SQL = "SELECT * FROM observaciones Where CodCertificado = '$dato->CodCertificado' and nObservacion = '$dato->nObservacion'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){

	}else{
		$linkc->query("insert into observaciones (
				CodCertificado				,
				nObservacion
				) 
			values (	
				'$dato->CodCertificado' 	,
				'$dato->nObservacion'
				)"
			);

	}
	$linkc->close();
}

if($dato->accion == 'asignarNormaRef'){
	$linkc=ConectarseCert();
	$SQL = "SELECT * FROM normarefcert Where CodCertificado = '$dato->CodCertificado' and nNorma = '$dato->nNorma'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){

	}else{
		$linkc->query("insert into normarefcert (
				CodCertificado				,
				nNorma
				) 
			values (	
				'$dato->CodCertificado' 	,
				'$dato->nNorma'
				)"
			);

	}
	$linkc->close();
}

if($dato->accion == 'asignarNormaAc'){
	$linkc=ConectarseCert();
	$SQL = "SELECT * FROM normaacre Where CodCertificado = '$dato->CodCertificado' and nNorma = '$dato->nNorma'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){

	}else{
		$linkc->query("insert into normaacre (
				CodCertificado				,
				nNorma
				) 
			values (	
				'$dato->CodCertificado' 	,
				'$dato->nNorma'
				)"
			);

	}
	$linkc->close();
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