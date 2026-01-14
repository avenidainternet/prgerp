<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("conexionli.php"); 
$agnoAct = date('Y');
$mesAct = date('m');
$outp = "";

$link=Conectarse(); 
$sDeuda = 0;

$SQL = "Select * From cotizaciones Where tpEnsayo != 2 and  Estado = 'T' and RAM > 0 and Archivo != 'on' Order By Facturacion, Archivo, informeUP, fechaTermino Desc";
$bd=$link->query($SQL);
while($rs = mysqli_fetch_array($bd)){
        $nFactPend 		= 0;
        $Clasificacion 	= 0;
        $HES			= 'off';
        $Cliente 		= '';
        $bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$rs['RutCli']."'");
        if($rowCli=mysqli_fetch_array($bdCli)){
            $Clasificacion 	= $rowCli['Clasificacion'];
            $Cliente 		= $rowCli['Cliente'];
            $HES 			= $rowCli['HES'];
            $sDeuda         = $rowCli['sDeuda'];

            if($rowCli['nFactPend'] > 0){
                $nFactPend 		= $rowCli['nFactPend'];
            }
        }

        $infoSubidos 	= 0;
        $infoNumero     = 0;
        $color 			= '';
        $ordenCompra	= 'No';
        $CodInforme = 'AM-'.$rs['RAM'];

        if($rs["infoNumero"] == 0 ){ $color = 'blanca'; }
        if($rs["nOC"]){ $ordenCompra = 'Si'; }

        if($rs["infoSubidos"] == 0 || $rs["infoSubidos"] < $rs["infoNumero"]){
        	$color = 'blanco';
        }

        if($rs["informeUP"] == 'on' && $rs['nSolicitud'] == 0 && $rs['nFactura'] == 0){
			$color = 'amarillo';
       		if($HES == 'on'){
        		if($rs["HES"] == ''){
       				$color = 'rosado';
        		}else{
		       		if($rs["nOC"] == ''){
		       			$color = 'rosado';
		       		}else{
		       			$color = 'amarillo';
		       		}
        		}
       		}else{
	       		if($rs["nOC"] == ''){
	       			$color = 'rosado';
	       		}else{
	       			$color = 'amarillo'; 
	       		}
       		}
        }


		if ($outp != "") {$outp .= ",";}
		$outp .= '{"CAM":"'  . 				$rs["CAM"]. 				'",';
		$outp .= '"tpEnsayo":"'  . 			$rs["tpEnsayo"]. 			'",';
		$outp .= '"Cliente":"'. 			$Cliente. 				    '",';
		$outp .= '"Clasificacion":"'. 		$Clasificacion. 		    '",';
		$outp .= '"infoNumero":"'. 			$rs["infoNumero"]. 			'",';
		$outp .= '"infoSubidos":"'. 		$rs["infoSubidos"]. 		'",';
        $outp .= '"fechaUp":"'. 			$rs["fechaInformeUP"]. 		'",';
		$outp .= '"color":"'. 				$color. 					'",';
		$outp .= '"nFactPend":"'. 			$nFactPend. 				'",';
		$outp .= '"sDeuda":"'. 				$sDeuda. 				    '",';
		$outp .= '"RAM":"'. 				$rs["RAM"]. 				'",';
		$outp .= '"Rev":"'. 				$rs["Rev"]. 				'",';
		$outp .= '"Cta":"'. 				$rs["Cta"]. 				'",';
		$outp .= '"Fan":"'. 				$rs["Fan"]. 				'",';
		$outp .= '"oMail":"'. 				$rs["oMail"]. 				'",';
		$outp.= '"nOC":' 				.json_encode($rs["nOC"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
		$outp .= '"nFactura":"'. 			$rs["nFactura"]. 			'",';
		$outp .= '"usrResponzable":"'. 		$rs["usrResponzable"]. 		'",';
		$outp .= '"Moneda":"'. 				$rs["Moneda"]. 				'",';
		$outp .= '"BrutoUF":"'. 			$rs["BrutoUF"]. 			'",';
		$outp .= '"BrutoUS":"'. 			$rs["BrutoUS"]. 			'",';
		$outp .= '"Bruto":"'. 				$rs["Bruto"]. 				'",';
		$outp .= '"fechaTermino":"'. 		$rs["fechaTermino"]. 		'",';
		$outp .= '"Facturacion":"'. 		$rs["Facturacion"]. 		'",';
		$outp .= '"fechaFacturacion":"'. 	$rs["fechaFacturacion"]. 	'",';
		$outp .= '"nSolicitud":"'. 			$rs['nSolicitud']. 			'",';
		$outp .= '"Estado":"'. 				$rs["Estado"]. 				'",';
		$outp .= '"informeUP":"'. 			$rs["informeUP"]. 			'",';
		$outp .= '"fechaInformeUP":"'. 		$rs["fechaInformeUP"]. 		'",';
		$outp .= '"Archivo":"'. 			$rs["Archivo"]. 			'",';
		$outp .= '"fechaArchivo":"'. 		$rs["fechaArchivo"]. 		'",';
		$outp .= '"HEScot":"'. 				$rs["HES"]. 				'",';
		$outp .= '"HES":"'. 				$HES. 				        '",';
	    $outp .= '"RutCli":"'. 				$rs["RutCli"]. 				'"}'; 
}


$SQL = "Select * From cotizaciones Where tpEnsayo = 2 and  Estado = 'T' and RAM > 0 and Archivo != 'on' Order By Facturacion, Archivo, informeUP, fechaTermino Desc";
$bd=$link->query($SQL);
while($rs = mysqli_fetch_array($bd)){
        $nFactPend 		= 0;
        $Clasificacion 	= 0;
        $HES			= 'off';
        $Cliente 		= '';
        $bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$rs['RutCli']."'");
        if($rowCli=mysqli_fetch_array($bdCli)){
            $Clasificacion 	= $rowCli['Clasificacion'];
            $Cliente 		= $rowCli['Cliente'];
            $HES 			= $rowCli['HES'];
            $sDeuda         = $rowCli['sDeuda'];

            if($rowCli['nFactPend'] > 0){
                $nFactPend 		= $rowCli['nFactPend'];
            }
        }

        $infoSubidos 	= 0;
        $infoNumero     = 0;
        $color 			= '';
        $ordenCompra	= 'No';
        $CodInforme = 'AM-'.$rs['RAM'];

        if($rs["infoNumero"] == 0 ){ $color = 'blanca'; }
        if($rs["nOC"]){ $ordenCompra = 'Si'; }

        if($rs["infoSubidos"] == 0 || $rs["infoSubidos"] < $rs["infoNumero"]){
        	$color = 'blanco';
        }

        if($rs["informeUP"] == 'on' && $rs['nSolicitud'] == 0 && $rs['nFactura'] == 0){
			$color = 'amarillo';
       		if($HES == 'on'){
        		if($rs["HES"] == ''){
       				$color = 'rosado';
        		}else{
		       		if($rs["nOC"] == ''){
		       			$color = 'rosado';
		       		}else{
		       			$color = 'amarillo';
		       		}
        		}
       		}else{
	       		if($rs["nOC"] == ''){
	       			$color = 'rosado';
	       		}else{
	       			$color = 'amarillo'; 
	       		}
       		}
        }


		if ($outp != "") {$outp .= ",";}
		$outp .= '{"CAM":"'  . 				$rs["CAM"]. 				'",';
		$outp .= '"tpEnsayo":"'  . 			$rs["tpEnsayo"]. 			'",';
		$outp .= '"Cliente":"'. 			$Cliente. 				    '",';
		$outp .= '"Clasificacion":"'. 		$Clasificacion. 		    '",';
		$outp .= '"HES":"'. 		        $HES. 		                '",';
		$outp .= '"infoNumero":"'. 			$rs["infoNumero"]. 			'",';
		$outp .= '"infoSubidos":"'. 		$rs["infoSubidos"]. 		'",';
        $outp .= '"fechaUp":"'. 			$rs["fechaInformeUP"]. 		'",';
		$outp .= '"color":"'. 				$color. 					'",';
		$outp .= '"nFactPend":"'. 			$nFactPend. 				'",';
		$outp .= '"sDeuda":"'. 				$sDeuda. 				    '",';
		$outp .= '"RAM":"'. 				$rs["RAM"]. 				'",';
		$outp .= '"Rev":"'. 				$rs["Rev"]. 				'",';
		$outp .= '"Cta":"'. 				$rs["Cta"]. 				'",';
		$outp .= '"Fan":"'. 				$rs["Fan"]. 				'",';
		$outp .= '"oMail":"'. 				$rs["oMail"]. 				'",';
		$outp .= '"nOC":' 					.json_encode($rs["nOC"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
		$outp .= '"nFactura":"'. 			$rs["nFactura"]. 			'",';
		$outp .= '"usrResponzable":"'. 		$rs["usrResponzable"]. 		'",';
		$outp .= '"Moneda":"'. 				$rs["Moneda"]. 				'",';
		$outp .= '"BrutoUF":"'. 			$rs["BrutoUF"]. 			'",';
		$outp .= '"BrutoUS":"'. 			$rs["BrutoUS"]. 			'",';
		$outp .= '"Bruto":"'. 				$rs["Bruto"]. 				'",';
		$outp .= '"fechaTermino":"'. 		$rs["fechaTermino"]. 		'",';
		$outp .= '"Facturacion":"'. 		$rs["Facturacion"]. 		'",';
		$outp .= '"fechaFacturacion":"'. 	$rs["fechaFacturacion"]. 	'",';
		$outp .= '"nSolicitud":"'. 			$rs['nSolicitud']. 			'",';
		$outp .= '"Estado":"'. 				$rs["Estado"]. 				'",';
		$outp .= '"informeUP":"'. 			$rs["informeUP"]. 			'",';
		$outp .= '"fechaInformeUP":"'. 		$rs["fechaInformeUP"]. 		'",';
		$outp .= '"Archivo":"'. 			$rs["Archivo"]. 			'",';
		$outp .= '"fechaArchivo":"'. 		$rs["fechaArchivo"]. 		'",';
		$outp .= '"HEScot":"'. 				$rs["HES"]. 				'",';
		$outp .= '"HES":"'. 				$HES. 				        '",';
	    $outp .= '"RutCli":"'. 				$rs["RutCli"]. 				'"}';
}





$outp ='{"records":['.$outp.']}';
$link->close();
echo ($outp);
?>