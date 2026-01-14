<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include_once("conexionli.php");
$agnoAct = date('Y');
$mesAct = date('m');
$rCot	= 0;

$outp = "";

$link=Conectarse();


	/* Cerrar CAM con 60 Días y sin RAM*/

	$fechaHoy = date('Y-m-d');
	$fecha60dias 	= strtotime ( '-60 day' , strtotime ( $fechaHoy ) );
	$fecha60dias	= date ( 'Y-m-d' , $fecha60dias );
	$Estado 		= 'C';

	//echo $fechaHoy.' '.$fecha60dias;
	$actSQL="Update cotizaciones Set ";
	$actSQL.="fechaCierre	='".$fechaHoy.	"',";
	$actSQL.="Estado		='".$Estado.	"'";
	$actSQL.="Where Estado 	= 'E' and RAM = 0 and fechaCotizacion <= '".$fecha60dias."' and BrutoUF < 40";
	$bdCot=$link->query($actSQL);

	/* Fin Verificar CAM con 90 Días */



$SQLi = "SELECT * FROM tablaindicadores Where mesInd = '$mesAct' and agnoInd = '$agnoAct'"; 
$bdi=$link->query($SQLi);
if($rsi=mysqli_fetch_array($bdi)){
   	$rCot =	$rsi["rCot"];
}


$SQL = "Select * From cotizaciones Where usrCotizador = '".$dato->usr."' and fechaInicio = '0000-00-00' and Estado = 'E' or Estado = '' Order By tpEnsayo Desc, Estado Desc";
//$SQL = "Select * From cotizaciones Where usrCotizador = 'RPM' and fechaInicio = '0000-00-00' and Estado = 'E' or Estado = '' Order By tpEnsayo Desc, Estado Desc";


$bd=$link->query($SQL);
while($rs = mysqli_fetch_array($bd)){
	$Cliente = '';
	$Clasificacion = 0;
	$SQLc = "SELECT * FROM clientes where RutCli = '".$rs['RutCli']."'";
	$bdc=$link->query($SQLc);
	if($rsc = mysqli_fetch_array($bdc)){
		$Cliente = trim($rsc['Cliente']);
		$nFactPend 		= $rsc['nFactPend'];
		$Clasificacion 	= $rsc['Clasificacion'];

		$fechaxVencer 	= strtotime ( '+'.$rs['Validez'].' day' , strtotime ( $rs['fechaCotizacion'] ) );
		$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
	
		$fd = explode('-', $fechaxVencer);
		//echo $fd[2].'/'.$fd[1];

		$dh	= $rs['Validez'] - 1; 
		//Cuenta Dias Habiles
		$dd	= 0;
		for($i=1; $i<=$dh; $i++){
			$ft	= strtotime ( '+'.$i.' day' , strtotime ( $rs['fechaCotizacion'] ) );
			$ft	= date ( 'Y-m-d' , $ft );
			$dia_semana = date("w",strtotime($ft));
			if($dia_semana == 0 or $dia_semana == 6){
				$dh++;
				$dd++;
			}
		}
		$fe = explode('-', $ft);
		$fechaTermino = $ft;
											
		$fechaHoy = date('Y-m-d');
		$start_ts 	= strtotime($fechaHoy); 
		$end_ts 	= strtotime($fechaxVencer); 
											
		$nDias = $end_ts - $start_ts;
		$nDias = round($nDias / 86400);

		$Contactar = 'No';
		$proxRecordatorio = $rs["proxRecordatorio"];
		if($rs["proxRecordatorio"] > 0 and $rs["proxRecordatorio"] <= $fechaHoy){
			$Contactar = 'Si';
		}

		$sDeuda = 0;
		$fechaHoy = date('Y-m-d');
		$fecha90dias 	= strtotime ( '-90 day' , strtotime ( $fechaHoy ) );
		$fecha90dias	= date ( 'Y-m-d' , $fecha90dias );
		$bdDe=$link->query("SELECT * FROM solfactura Where RutCli = '".$rsc['RutCli']."' and fechaPago = '0000-00-00'");
		while($rowDe=mysqli_fetch_array($bdDe)){
			if($rowDe['fechaFactura'] > '0000-00-00'){
				if($rowDe['fechaFactura'] < $fecha90dias){
					$sDeuda += $rowDe['Bruto'];
				}
			}
		}

		$colorCam = 'Blanco';
		if($rs['Estado']==' '){
			$colorCam = 'Blanco';
		}
		if($rs['Estado']=='E'){ // Enviada
			$colorCam = 'Amarilla';
			$tDias = 3;
			if($nDias <= $tDias){ // En Proceso
				$colorCam = 'Rojo';
			}
			if($rs['proxRecordatorio'] <= $fechaHoy){ // En Proceso
				$colorCam = 'Rojo';
			}
		}
		if($rs['fechaAceptacion'] != '0000-00-00'){ // Aceptada
			$colorCam = 'Verde';
		}
		if($rs['RAM'] > 0){ // Aceptada
			$colorCam = 'Verde';
		}
		if($rs['Estado']=='C'){
			$colorCam = 'Azul';
		}

		if($rs['Estado']==''){
			$colorCam = 'Blanco';
		}

		if ($outp != "") {$outp .= ",";}
		$outp .= '{"CAM":"'  . 				$rs["CAM"]. 				'",';
		$outp .= '"RAM":"'. 				$rs["RAM"]. 				'",';
		$outp .= '"tpEnsayo":"'. 			$rs["tpEnsayo"]. 			'",';
		$outp .= '"OFE":"'. 				$rs["OFE"]. 				'",';
		$outp .= '"Rev":"'. 				$rs["Rev"]. 				'",';
		$outp .= '"Estado":"'. 				$rs["Estado"]. 				'",';
		$outp .= '"enviadoCorreo":"'. 		$rs["enviadoCorreo"]. 		'",';
		$outp .= '"correoAutomatico":"'. 	$rs["correoAutomatico"]. 	'",';
		$outp .= '"fechaEnvio":"'. 			$rs["fechaEnvio"]. 			'",';
		$outp .= '"Validez":"'. 			$rs["Validez"]. 			'",';
		$outp .= '"usrPega":"'. 			$rs["usrPega"]. 			'",';
		$outp .= '"fechaxVencer":"'. 		$fechaxVencer. 				'",';
		$outp .= '"fechaTermino":"'. 		$fechaTermino. 				'",';
		$outp .= '"Contactar":"'. 			$Contactar. 				'",';
		$outp .= '"nFactPend":"'. 			$nFactPend. 				'",';
		$outp .= '"proxRecordatorio":"'. 	$rs["proxRecordatorio"]. 	'",';
		$outp .= '"nDias":"'. 				$nDias. 					'",';
		$outp .= '"usrCotizador":"'. 		$rs["usrCotizador"]. 		'",';
		$outp .= '"dHabiles":"'. 			$rs["dHabiles"]. 			'",';
		$outp .= '"fechaEstimadaTermino":"'.$rs["fechaEstimadaTermino"].'",';
		$outp .= '"fechaCotizacion":"'. 	$rs["fechaCotizacion"]. 	'",';
		$outp .= '"fechaAceptacion":"'. 	$rs["fechaAceptacion"]. 	'",';
		$outp .= '"correoAutomatico":"'. 	$rs["correoAutomatico"]. 	'",';
		$outp .= '"RutCli":"'. 				$rs["RutCli"]. 				'",';
		$outp .= '"Moneda":"'. 				$rs["Moneda"]. 				'",';
		$outp .= '"pDescuento":"'. 			$rs["pDescuento"]. 			'",';
		$outp .= '"Bruto":"'. 				$rs["Bruto"]. 				'",';
		$outp .= '"BrutoUF":"'. 			$rs["BrutoUF"]. 			'",';
		$outp .= '"Fan":"'. 				$rs["Fan"]. 				'",';
		$outp .= '"fecha60dias":"'. 		$fecha60dias. 				'",';
		$outp .= '"rCot":"'. 				$rCot. 						'",';
		$outp .= '"colorCam":"'. 			$colorCam. 					'",';
		$outp .= '"sDeuda":"'. 				$sDeuda. 					'",';
		$outp .= '"Clasificacion":"'. 		$Clasificacion. 			'",';
	    $outp .= '"Cliente":"'. 			trim($Cliente). 			'"}';
	}
}
$outp ='{"records":['.$outp.']}';
$link->close();
echo ($outp);
?>