<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("conexionli.php");
$agnoAct = date('Y');
$mesAct = date('m');
$outp = "";

$link=Conectarse();

//$SQL = "Select * From cotizaciones Where Estado = 'T' and RAM > 0 and informeUP != 'on' and Archivo != 'on' and nSolicitud = 0";
$SQL = "Select * From cotizaciones Where Estado = 'T' and RAM > 0 and Archivo != 'on' Order By Facturacion, Archivo, informeUP, fechaTermino Desc";
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

		if($rowCli['nFactPend'] > 0){
			$nFactPend 		= $rowCli['nFactPend'];
		}
	}

	$sDeuda = 0;
	$cFact	= 0;
	$fechaHoy = date('Y-m-d');
	$fecha90dias 	= strtotime ( '-90 day' , strtotime ( $fechaHoy ) );
	$fecha90dias	= date ( 'Y-m-d' , $fecha90dias );
	$bdDe=$link->query("SELECT * FROM solfactura Where RutCli = '".$rs['RutCli']."' and fechaPago = '0000-00-00'");
	while($rowDe=mysqli_fetch_array($bdDe)){
		if($rowDe['fechaFactura'] > '0000-00-00'){
			if($rowDe['fechaFactura'] < $fecha90dias){
				$sDeuda += $rowDe['Bruto'];
				$cFact++;
			}
		}
	}
	
	$nFactura = 0;
	$bdDe=$link->query("SELECT * FROM solfactura Where nSolicitud = '".$rs['nSolicitud']."'");
	if($rowDe=mysqli_fetch_array($bdDe)){
		$nFactura = $rowDe['nFactura'];
	}
	
	$CodInforme = 'AM-'.$rs['RAM'];
	$fechaUp 	= '0000-00-00';
	$bdInf=$link->query("SELECT * FROM informes Where CodInforme Like '%".$CodInforme."%' and RutCli = '".$rs['RutCli']."'");
	if($rowInf=mysqli_fetch_array($bdInf)){
		if($rowInf['informePDF']){
			$fechaUp = $rowInf['fechaUp'];
		}
	}
	$infoNumero 	= 0;
	$infoSubidos 	= 0;
	$color 			= 'blanco';
	$ordenCompra	= 'No';
	$bdInf=$link->query("SELECT * FROM Informes Where CodInforme Like '%".$CodInforme."%'");
	while($rowInf=mysqli_fetch_array($bdInf)){
		$infoNumero++;
		if($rowInf['informePDF']){
			$infoSubidos++;
		}
	}
	if($infoNumero == 0 ){ $color = 'blanca'; }
	if($rs["nOC"]){ $ordenCompra = 'Si'; }
        if($infoSubidos == 0 || $infoSubidos < $infoNumero){
        	$color = 'blanco';
        }
		
        //if($rs["informeUP"] == 'on' && $rs['nSolicitud'] == 0 && $nFactura == 0 && $HES == 'on' && $rs["HES"] == ''){
        if($rs["informeUP"] == 'on' && $rs['nSolicitud'] == 0 && $nFactura == 0 && $HES == 'on' && $rs["HES"] == ''){
        	$color = 'rosado';
        }
        if($rs["informeUP"] == 'on' && $rs['nSolicitud'] == 0 && $nFactura == 0){
        	if($HES == 'on' && $rs["HES"] == ''){
        		
        	}else{
        		$color = 'amarillo';
        	}
        }
        if($rs['nSolicitud'] > 0 && $nFactura == 0){
        	$color = 'verde';
        }
        if($rs['nSolicitud'] > 0 && $nFactura > 0){
        	$color = 'azul';
        }
        

		if ($outp != "") {$outp .= ",";}
		$outp .= '{"CAM":"'  . 				$rs["CAM"]. 				'",';
		$outp .= '"RAM":"'. 				$rs["RAM"]. 				'",';
		$outp .= '"Rev":"'. 				$rs["Rev"]. 				'",';
		$outp .= '"Cta":"'. 				$rs["Cta"]. 				'",';
		//$outp .= '"CodInforme":"'. 			$CodInforme. 				'",';
		$outp .= '"ordenCompra":"'. 		$ordenCompra. 				'",';
		$outp .= '"Fan":"'. 				$rs["Fan"]. 				'",';
		$outp .= '"oMail":"'. 				$rs["oMail"]. 				'",';
		$outp .= '"nOC":"'. 				$rs["nOC"]. 				'",';
		$outp .= '"usrResponzable":"'. 		$rs["usrResponzable"]. 		'",';
		$outp .= '"BrutoUF":"'. 			$rs["BrutoUF"]. 			'",';
		$outp .= '"fechaTermino":"'. 		$rs["fechaTermino"]. 		'",';
		$outp .= '"Facturacion":"'. 		$rs["Facturacion"]. 		'",';
		$outp .= '"fechaFacturacion":"'. 	$rs["fechaFacturacion"]. 	'",';
		$outp .= '"nSolicitud":"'. 			$rs['nSolicitud']. 			'",';
		$outp .= '"Estado":"'. 				$rs["Estado"]. 				'",';
		$outp .= '"informeUP":"'. 			$rs["informeUP"]. 			'",';
		$outp .= '"fechaInformeUP":"'. 		$rs["fechaInformeUP"]. 		'",';
		$outp .= '"Archivo":"'. 			$rs["Archivo"]. 			'",';
		$outp .= '"fechaArchivo":"'. 		$rs["fechaArchivo"]. 		'",';
		$outp .= '"nFactura":"'. 			$nFactura. 					'",';
		$outp .= '"nFactPend":"'. 			$nFactPend. 				'",';
		$outp .= '"Clasificacion":"'. 		$Clasificacion. 			'",';
		$outp .= '"HES":"'. 				$HES. 						'",';
		$outp .= '"HEScot":"'. 				$rs["HES"]. 				'",';
		$outp .= '"sDeuda":"'. 				$sDeuda. 					'",';
		$outp .= '"cFact":"'. 				$cFact. 					'",';
		$outp .= '"CodInforme":"'. 			$CodInforme. 				'",';
		$outp .= '"color":"'. 				$color. 					'",';
		$outp .= '"infoNumero":"'. 			$infoNumero. 				'",';
		$outp .= '"infoSubidos":"'. 		$infoSubidos. 				'",';
		$outp .= '"fechaUp":"'. 			$fechaUp. 					'",';
		$outp .= '"Cliente":"'. 			trim($Cliente). 			'",';
	    $outp .= '"RutCli":"'. 				$rs["RutCli"]. 				'"}';
}
$outp ='{"records":['.$outp.']}';
$link->close();
echo ($outp);
?>