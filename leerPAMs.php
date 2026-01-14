<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("conexionli.php");
include_once("inc/funciones.php");
$agnoAct = date('Y');
$mesAct = date('m');
$rCot	= 0;

$outp = "";

$link=Conectarse();

$SQLi = "SELECT * FROM tablaindicadores Where mesInd = '$mesAct' and agnoInd = '$agnoAct'"; 
$bdi=$link->query($SQLi);
if($rsi=mysqli_fetch_array($bdi)){ 
   	$rCot =	$rsi["rCot"];
}
$SQL = "Select * From cotizaciones Where Estado = 'P' Order By RAM Asc";
$bd=$link->query($SQL);
while($rs = mysqli_fetch_array($bd)){
	$Cliente = '';
	$SQLc = "SELECT * FROM clientes where RutCli = '".$rs['RutCli']."'";
	$bdc=$link->query($SQLc);
	if($rsc = mysqli_fetch_array($bdc)){
		$Cliente = trim($rsc['Cliente']);
		$nFactPend = $rsc['nFactPend'];
		$Clasificacion = $rsc['nFactPend'];

		list($ftermino, $dhf, $dha, $dsemana) = fnDiasHabiles($rs['fechaInicio'],$rs['dHabiles'],$rs['horaPAM']);

		$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
		$fechaHoy = date('Y-m-d');
		$dsemana = date("w",strtotime($ftermino));
		$diaTermino = $dSem[$dsemana];
		$fechaTermino = $ftermino;
											
		$ft = $rs['fechaInicio'];
		$dh	= $rs['dHabiles']-1;
		$dd	= 0;
		for($i=1; $i<=$dh; $i++){
			$ft	= strtotime ( '+'.$i.' day' , strtotime ( $rs['fechaInicio'] ) );
			$ft	= date ( 'Y-m-d' , $ft );
			$dia_semana = date("w",strtotime($ft));
			if($dia_semana == 0 or $dia_semana == 6){
				$dh++;
				$dd++;
			}
		}
						
		$fechaHoy = date('Y-m-d');
		$start_ts 	= strtotime($fechaHoy); 
		$end_ts 	= strtotime($ft); 
										
		$tDias = 1;
		$nDias = $end_ts - $start_ts;

		$nDias = round($nDias / 86400)+1;
		if($ft < $fechaHoy){
			$nDias = $nDias - $dd;
		}

		if ($outp != "") {$outp .= ",";}
		$outp .= '{"CAM":"'  . 				$rs["CAM"]. 				'",';
		$outp .= '"RAM":"'. 				$rs["RAM"]. 				'",';
	    $outp.= '"Descripcion":' 			.json_encode($rs["Descripcion"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
		$outp .= '"tpEnsayo":"'. 			$rs["tpEnsayo"]. 			'",';
		$outp .= '"OFE":"'. 				$rs["OFE"]. 				'",';
		$outp .= '"Rev":"'. 				$rs["Rev"]. 				'",';
		$outp .= '"Estado":"'. 				$rs["Estado"]. 				'",';
		$outp .= '"enviadoCorreo":"'. 		$rs["enviadoCorreo"]. 		'",';
		$outp .= '"fechaInicio":"'. 		$rs["fechaInicio"]. 		'",';
		$outp .= '"fechaEnvio":"'. 			$rs["fechaEnvio"]. 			'",';
		$outp .= '"Validez":"'. 			$rs["Validez"]. 			'",';
		$outp .= '"usrPega":"'. 			$rs["usrPega"]. 			'",';
		$outp .= '"fechaTermino":"'. 		$fechaTermino. 				'",';
		$outp .= '"nFactPend":"'. 			$nFactPend. 				'",';
		$outp .= '"proxRecordatorio":"'. 	$rs["proxRecordatorio"]. 	'",';
		$outp .= '"Clasificacion":"'. 		$Clasificacion. 			'",';
		$outp .= '"nDias":"'. 				$nDias. 					'",';
		$outp .= '"diaTermino":"'. 			$diaTermino. 				'",';
		$outp .= '"dhf":"'. 				$dhf. 						'",';
		$outp .= '"dha":"'. 				$dha. 						'",';
		$outp .= '"usrCotizador":"'. 		$rs["usrCotizador"]. 		'",';
		$outp .= '"usrResponzable":"'. 		$rs["usrResponzable"]. 		'",';
		$outp .= '"dHabiles":"'. 			$rs["dHabiles"]. 			'",';
		$outp .= '"fechaEstimadaTermino":"'.$rs["fechaEstimadaTermino"].'",';
		$outp .= '"fechaCotizacion":"'. 	$rs["fechaCotizacion"]. 	'",';
		$outp .= '"correoAutomatico":"'. 	$rs["correoAutomatico"]. 	'",';
		$outp .= '"RutCli":"'. 				$rs["RutCli"]. 				'",';
		$outp .= '"Moneda":"'. 				$rs["Moneda"]. 				'",';
		$outp .= '"pDescuento":"'. 			$rs["pDescuento"]. 			'",';
		$outp .= '"Bruto":"'. 				$rs["Bruto"]. 				'",';
		$outp .= '"BrutoUF":"'. 			$rs["BrutoUF"]. 			'",';
		$outp .= '"Fan":"'. 				$rs["Fan"]. 				'",';
		$outp .= '"rCot":"'. 				$rCot. 						'",';
	    $outp .= '"Cliente":"'. 			trim($Cliente). 			'"}';
	}
}
$outp ='{"records":['.$outp.']}';
$link->close();
echo ($outp);
?>