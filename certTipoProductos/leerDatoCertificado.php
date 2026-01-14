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
	$SQL = "SELECT * FROM tipoproductos Where nProducto = '$dato->nProducto'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$res.= '{"nProducto":"'.			$rs["nProducto"].				'",';
		$res.= '"Producto":' 				.json_encode($rs["Producto"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
		$res.= '"Estado":"'. 				$rs["Estado"]. 					'"}';
	}else{
		$SQL = "SELECT * FROM tipoproductos Order By nProducto Desc";
		$bd=$linkc->query($SQL);
		if($rs = mysqli_fetch_array($bd)){
			$nProducto = $rs["nProducto"] + 1;
			$Producto  = 'Producto nuevo...';
			$Estado = 'on';
			$res.= '{"nProducto":"'.			$nProducto.				'",';
			$res.= '"Producto":"'. 				$Producto. 				'",';
			$res.= '"Estado":"'. 				$Estado.				'"}';
		}	
	}
	$linkc->close();
	echo $res;	
}


if($dato->accion == 'G'){
	$Estado = 'on';
	$linkc=ConectarseCert();
	$SQL = "SELECT * FROM tipoproductos Where nProducto = '$dato->nProducto'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){

	    $actSQL="UPDATE tipoproductos SET ";
	    $actSQL.="nProducto             = '".$dato->nProducto.              "', ";
	    $actSQL.="Producto        		= '".$dato->Producto.         		"' ";
	    $actSQL.="WHERE nProducto 		= '".$dato->nProducto. 				"'";
	    $bdAct=$linkc->query($actSQL);
	}else{
     	$linkc->query("insert into tipoproductos (
												nProducto				,
												Producto				,
	                                            Estado 						
                                        ) 
                                 values (	
	                                            '$dato->nProducto' 		,
	                                            '$dato->Producto' 			,
	                                            '$Estado' 					
                                        )"
                        );
	}
	$linkc->close();
}

if($dato->accion == 'D'){
	$linkc=ConectarseCert();
	$SQL = "SELECT * FROM tipoproductos Where nProducto = '$dato->nProducto'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$Estado = 'off';
	    $actSQL="UPDATE tipoproductos SET ";
	    $actSQL.="Estado            	= '".$Estado. 				"' ";
	    $actSQL.="WHERE nProducto 		= '".$dato->nProducto. 		"'";
	    $bdAct=$linkc->query($actSQL);
	}
	$linkc->close();
}
if($dato->accion == 'H'){
	$linkc=ConectarseCert();
	$SQL = "SELECT * FROM tipoproductos Where nProducto = '$dato->nProducto'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$Estado = 'on';
	    $actSQL="UPDATE tipoproductos SET ";
	    $actSQL.="Estado            	= '".$Estado. 				"' ";
	    $actSQL.="WHERE nProducto  		= '".$dato->nProducto. 		"'";
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