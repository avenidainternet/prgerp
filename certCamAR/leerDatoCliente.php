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
	$SQL = "SELECT * FROM clientes Where RutCli = '$dato->RutCli'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$Hes = 'off';
		if($rs['Hes']){
			$Hes = $rs['Hes'];
		}

		$res.= '{"RutCli":"'.				$rs["RutCli"].			'",';
		$res.= '"Cliente":"'. 				$rs["Cliente"]. 		'",';
		$res.= '"Direccion":"'. 			$rs["Direccion"]. 		'",';
		$res.= '"Telefono":"'. 				$rs["Telefono"]. 		'",';
		$res.= '"Celular":"'. 				$rs["Celular"]. 		'",';
		$res.= '"Email":"'. 				$rs["Email"]. 			'",';
		$res.= '"Contacto":"'. 				$rs["Contacto"]. 		'",';
		$res.= '"nCertificados":"'. 		$rs["nCertificados"]. 	'",';
		$res.= '"Estado":"'. 				$rs["Estado"]. 			'",';
		$res.= '"Sitio":"'. 				$rs["Sitio"]. 			'",';
		$res.= '"Hes":"'. 					$Hes. 					'"}';
	}
	$linkc->close();
	echo $res;	
}
if($dato->accion == 'G'){
	$Estado = 'on';
	$linkc=ConectarseCert();
	$SQL = "SELECT * FROM clientes Where RutCli = '$dato->RutCli'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
	    $actSQL="UPDATE clientes SET ";
	    $actSQL.="Cliente               = '".$dato->Cliente.                "', ";
	    $actSQL.="Direccion        		= '".$dato->Direccion.         		"', ";
	    $actSQL.="Contacto              = '".$dato->Contacto.               "', ";
	    $actSQL.="Telefono        		= '".$dato->Telefono.         		"', ";
	    $actSQL.="Celular               = '".$dato->Celular.                "', ";
	    $actSQL.="Email               	= '".$dato->Email.                	"', ";
	    $actSQL.="Sitio            		= '".$Sitio.             			"', ";
	    $actSQL.="Estado            	= '".$Estado.             			"' ";
	    $actSQL.="WHERE RutCli      	= '".$dato->RutCli. "'";
	    $bdAct=$linkc->query($actSQL);
	}else{
     	$linkc->query("insert into clientes (
                                           	RutCli 				,
                                            Cliente 			,
                                            Direccion 			,
                                            Contacto 			,
                                            Telefono 			,
                                            Celular 			,
                                            Email 				,
                                            Sitio				,
                                            Estado
                                        ) 
                                 values (	
                                            '$dato->RutCli' 	,
                                            '$dato->Cliente' 	,
                                            '$dato->Direccion' 	,
                                            '$dato->Contacto' 	,
                                            '$dato->Telefono' 	,
                                            '$dato->Celular' 	,
                                            '$dato->Email' 		,
                                            '$Sitio'			,
                                            '$Estado'		
                                        )"
                        );
	}
	$linkc->close();

}
if($dato->accion == 'D'){
	$linkc=ConectarseCert();
	$SQL = "SELECT * FROM clientes Where RutCli = '$dato->RutCli'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$Estado = 'off';
	    $actSQL="UPDATE clientes SET ";
	    $actSQL.="Estado            	= '".$Estado. 		"' ";
	    $actSQL.="WHERE RutCli      	= '".$dato->RutCli. "'";
	    $bdAct=$linkc->query($actSQL);
	}
	$linkc->close();
}
if($dato->accion == 'H'){
	$linkc=ConectarseCert();
	$SQL = "SELECT * FROM clientes Where RutCli = '$dato->RutCli'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$Estado = 'on';
	    $actSQL="UPDATE clientes SET ";
	    $actSQL.="Estado            	= '".$Estado. 		"' ";
	    $actSQL.="WHERE RutCli      	= '".$dato->RutCli. "'";
	    $bdAct=$linkc->query($actSQL);
	}
	$linkc->close();
}
if($dato->accion == 'E'){
	$linkc=ConectarseCert(); 
	$SQL = "SELECT * FROM clientes Where RutCli = '$dato->RutCli'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		// $bdAct=$linkc->query("Delete From clientes Where RutCli = '$dato->RutCli'");	
	}
	$linkc->close();
}
?>