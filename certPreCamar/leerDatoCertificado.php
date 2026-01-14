<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));
	
$Sitio = '';
if(isset($dato->Sitio)){ $Sitio = $dato->Sitio; }  

include("../conexioncert.php"); 
include("../conexionli.php"); 

$res = '';


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


if($dato->accion == 'guardarProducto'){
	$linkc=ConectarseCert(); 
	$SQL = "SELECT * FROM dcamar Where CAMAR = '$dato->CAMAR' and Colada = '$dato->Colada'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$SQLtp = "SELECT * FROM tipoproductos Where nProducto = '".$dato->nProducto."'";
		$bdtp=$linkc->query($SQLtp);
		if($rstp = mysqli_fetch_array($bdtp)){

		}

		$idCertificado = 'Certificado OCP SIMET USACH '.$dato->CAMAR.' '.$rstp["Producto"].' Plancha '.$rs["Dimension"].' Colada '.$rs["Lote"];

	    $actSQL="UPDATE dcamar SET ";
	    $actSQL.="idCertificado        	= '".$idCertificado.         	"', ";
	    $actSQL.="nProducto        		= '".$dato->nProducto.         	"' ";
	    $actSQL.="WHERE CAMAR 			= '$dato->CAMAR' and Colada = '$dato->Colada'";
	    $bdAct=$linkc->query($actSQL);
	}
	$linkc->close();

	$res.= '{"idCertificado":"'		.	$idCertificado.				'"}';
	echo $res;	


}

if($dato->accion == 'guardarAcero'){
	$linkc=ConectarseCert(); 
	$SQL = "SELECT * FROM dcamar Where CAMAR = '$dato->CAMAR' and Colada = '$dato->Colada'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
	    $actSQL="UPDATE dcamar SET ";
	    $actSQL.="nAcero        		= '".$dato->nAcero.         	"' ";
	    $actSQL.="WHERE CAMAR 			= '$dato->CAMAR' and Colada = '$dato->Colada'";
	    $bdAct=$linkc->query($actSQL);
	}
	$linkc->close();

}

if($dato->accion == 'guardarDimension'){
	$linkc=ConectarseCert(); 
	$SQL = "SELECT * FROM dcamar Where CAMAR = '$dato->CAMAR' and Colada = '$dato->Colada'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$SQLtp = "SELECT * FROM tipoproductos Where nProducto = '".$rs['nProducto']."'";
		$bdtp=$linkc->query($SQLtp);
		if($rstp = mysqli_fetch_array($bdtp)){
		}

		$Dimension = '';
		if($dato->Dimension){ 
			$idCertificado = 'Certificado OCP SIMET USACH '.$dato->CAMAR.' '.$rstp["Producto"].' Plancha '.$dato->Dimension.' Colada '.$rs['Lote'];
		}else{
			$idCertificado = 'Certificado OCP SIMET USACH '.$dato->CAMAR.' '.$rstp["Producto"].' Plancha '.' Colada '.$rs['Lote'];
		}

	    $actSQL="UPDATE dcamar SET ";
	    $actSQL.="idCertificado        	= '".$idCertificado.         	"', ";
	    $actSQL.="Dimension        		= '".$dato->Dimension.         	"' ";
	    $actSQL.="WHERE CAMAR 	= '$dato->CAMAR' and Colada = '$dato->Colada'";
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

if($dato->accion == 'gardarCambiosPreCam'){
	$linkc=ConectarseCert(); 
	
	$nColadas = 0;
	$SQLar = "SELECT * FROM camar Where CAMAR = '$dato->CAMAR'";
	$bdar=$linkc->query($SQLar);
	if($rsar = mysqli_fetch_array($bdar)){
		$nColadas = $rsar['nColadas'];
	}

	$nColadas40 	= 0;
	$nColadas80 	= 0;
	$nColadas120 	= 0; 
	$SQL = "SELECT * FROM dcamar Where CAMAR = '$dato->CAMAR'";
	$bd=$linkc->query($SQL);
	while($rs = mysqli_fetch_array($bd)){
		if($rs['Peso'] <= 40000){
			$nColadas40++;
		}
		if($rs['Peso'] > 40000 and $rs['Peso'] <= 80000){
			$nColadas80++;
		}
		if($rs['Peso'] > 80000){
			$nColadas120++;
		}
	}
	
	$linkc->Close();

	$link=Conectarse();
	$bdCot = $link->query("Delete From dcotizacion Where CAM = '$dato->CAMAR'");
	
	
	$NetoUFTot 	= 0;
	$IvaUFTot 	= 0;
	$BrutoUFTot = 0;
	$i 			= 0;
	if($nColadas40 >0){
			$nServicio 		= 1201;
			$i++;
			$SQLser = "SELECT * FROM servicios where nServicio = '$nServicio'"; 
			$bdser=$link->query($SQLser);
			if($rsser = mysqli_fetch_array($bdser)){
				$ValorUF = $rsser['ValorUF'];
			}
			$NetoUF 		= $ValorUF * $nColadas40;
			$IvaUF			= $NetoUF * 1.19;
			$TotalUF		= $NetoUF + $IvaUF;
			
			$NetoUFTot 		= $NetoUFTot + $NetoUF;
			$IvaUFTot 		= $IvaUFTot + $IvaUF;
			$BrutoUFTot 	= $BrutoUFTot + $TotalUF;

			$link->query("insert into dcotizacion(		CAM					,
														nLin				,
														Cantidad			,
														nServicio			,
														unitarioUF			,
														NetoUF				,
														IvaUF				,
														TotalUF
													) 
											values 	(	'$dato->CAMAR'				,
														'$i'						,
														'$nColadas40'				,
														'$nServicio'				,
														'$ValorUF'					,
														'$NetoUF'					,
														'$IvaUF'					,
														'$TotalUF'
			)");
	}
	if($nColadas80 >0){
			$nServicio 		= 1203;
			$i++;
			$SQLser = "SELECT * FROM servicios where nServicio = '$nServicio'"; 
			$bdser=$link->query($SQLser);
			if($rsser = mysqli_fetch_array($bdser)){
				$ValorUF = $rsser['ValorUF'];
			}
			$NetoUF 		= $ValorUF * $nColadas80;
			$IvaUF			= $NetoUF * 1.19;
			$TotalUF		= $NetoUF + $IvaUF;

			$NetoUFTot 		= $NetoUFTot + $NetoUF;
			$IvaUFTot 		= $IvaUFTot + $IvaUF;
			$BrutoUFTot 	= $BrutoUFTot + $TotalUF;

			$link->query("insert into dcotizacion(		CAM					,
														nLin				,
														Cantidad			,
														nServicio			,
														unitarioUF			,
														NetoUF				,
														IvaUF				,
														TotalUF
													) 
											values 	(	'$dato->CAMAR'				,
														'$i'						,
														'$nColadas80'				,
														'$nServicio'				,
														'$ValorUF'					,
														'$NetoUF'					,
														'$IvaUF'					,
														'$TotalUF'
			)");
	}
	if($nColadas120 >0){
			$nServicio 		= 1202;
			$i++;
			$SQLser = "SELECT * FROM servicios where nServicio = '$nServicio'"; 
			$bdser=$link->query($SQLser);
			if($rsser = mysqli_fetch_array($bdser)){
				$ValorUF = $rsser['ValorUF'];
			}
			$NetoUF 		= $ValorUF * $nColadas120;
			$IvaUF			= $NetoUF * 1.19;
			$TotalUF		= $NetoUF + $IvaUF;

			$NetoUFTot 		= $NetoUFTot + $NetoUF;
			$IvaUFTot 		= $IvaUFTot + $IvaUF;
			$BrutoUFTot 	= $BrutoUFTot + $TotalUF;

			$link->query("insert into dcotizacion(		CAM					,
														nLin				,
														Cantidad			,
														nServicio			,
														unitarioUF			,
														NetoUF				,
														IvaUF				,
														TotalUF
													) 
											values 	(	'$dato->CAMAR'				,
														'$i'						,
														'$nColadas120'				,
														'$nServicio'				,
														'$ValorUF'					,
														'$NetoUF'					,
														'$IvaUF'					,
														'$TotalUF'
			)");
	}

	$Observacion 		= 'Certificación '.$nColadas.' Coladas ';
	$obsServicios 		= 'Certificación '.$nColadas.' Coladas ';
	$Descripcion 		= 'Certificación '.$nColadas.' Coladas ';

	$actSQL="UPDATE cotizaciones SET ";
	$actSQL.="Observacion   		= '".$Observacion. 				"', ";
	$actSQL.="obsServicios   		= '".$obsServicios. 			"', ";
	$actSQL.="Descripcion   		= '".$Descripcion. 				"', ";
	$actSQL.="NetoUF   				= '".$NetoUFTot. 				"', ";
	$actSQL.="IvaUF   				= '".$IvaUFTot. 				"', ";
	$actSQL.="BrutoUF   			= '".$BrutoUFTot. 				"' ";
	$actSQL.="WHERE CAM = '$dato->CAMAR'";
	$bdAct = $link->query($actSQL);

	
	$link->Close();
}

if($dato->accion == 'guardarPeso'){
	$linkc=ConectarseCert(); 
	$SQL = "SELECT * FROM dcamar Where CAMAR = '$dato->CAMAR' and Colada = '$dato->Colada'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
	    $actSQL="UPDATE dcamar SET ";
	    $actSQL.="Peso        	= '".$dato->Peso.         	"' ";
	    $actSQL.="WHERE CAMAR 	= '$dato->CAMAR' and Colada = '$dato->Colada'";
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


if($dato->accion == 'L'){ 
	
	$res = '';  
	$linkc=ConectarseCert(); 
	$SQL = "SELECT * FROM dcamar Where CAMAR = '$dato->CAMAR' and Colada = '$dato->Colada'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$SQLcl = "SELECT * FROM clientes Where RutCli = '".$rs['RutCli']."'";
		$bdcl=$linkc->query($SQLcl);
		if($rscl = mysqli_fetch_array($bdcl)){

		}
		
		$res.= '{"RutCli":"'.					$rs["RutCli"].					'",';
		$res.= '"CAMAR":"'. 					$rs["CAMAR"]. 					'",';
		$res.= '"Colada":"'. 					$rs["Colada"]. 					'",';
		$res.= '"Lote":"'. 						$rs["Lote"]. 					'",';
		$res.= '"Peso":"'. 						$rs["Peso"]. 					'",';
		$res.= '"Dimension":"'. 				$rs["Dimension"]. 				'",';
		$res.= '"nProducto":"'. 				$rs["nProducto"]. 				'",';
		$res.= '"nAcero":"'. 					$rs["nAcero"]. 					'",';
		$res.= '"idCertificado":"'. 			$rs["idCertificado"]. 			'",';
		$res.= '"RAMAR":"'. 					$rs["RAMAR"]. 					'"}';


	}
	$linkc->Close();
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
	$SQL = "SELECT * FROM dcamar Where CAMAR = '$dato->CAMAR' and Colada = '$dato->Colada'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$SQLtp = "SELECT * FROM tipoproductos Where nProducto = '".$rs['nProducto']."'";
		$bdtp=$linkc->query($SQLtp);
		if($rstp = mysqli_fetch_array($bdtp)){
		}

		$Lote = '';
		if($dato->Lote){ 
			$idCertificado = 'Certificado OCP SIMET USACH '.$dato->CAMAR.' '.$rstp["Producto"].' Plancha '.$rs["Dimension"].' Colada '.$dato->Lote;
		}else{
			$idCertificado = 'Certificado OCP SIMET USACH '.$dato->CAMAR.' '.$rstp["Producto"].' Plancha '.$rs["Dimension"].' Colada';
		}


	    $actSQL="UPDATE dcamar SET ";
	    $actSQL.="idCertificado        	= '".$idCertificado.    "', ";
	    $actSQL.="Lote        			= '".$dato->Lote.         	"' ";
	    $actSQL.="WHERE CAMAR 			= '$dato->CAMAR' and Colada = '$dato->Colada'";
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