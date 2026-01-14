<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include_once("../conexionli.php");


if($dato->accion == 'loadData'){
    $link=Conectarse();
    $res = "";
    $SQL = "SELECT * FROM accionescorrectivas where nInformeCorrectiva = '$dato->nInformeCorrectiva'"; 
    $bd=$link->query($SQL);
    while($rs=mysqli_fetch_array($bd)){ 
        $res .= '{"fechaApertura":"'  	. $rs["fechaApertura"] 		        . '",'; 
        $res .= '"usrApertura":"'  	    . $rs["usrApertura"] 		        . '",';
        $res .= '"desIdentificacion":'  . json_encode($rs["desIdentificacion"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
        $res .= '"desHallazgo":'        . json_encode($rs["desHallazgo"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
        $res .= '"usrCalidad":"'        . $rs["usrCalidad"] 		        . '",';
        $res .= '"hallazgo":"'          . $rs["hallazgo"] 		            . '",';
        $res .= '"usrResponsable":"'	. $rs["usrResponsable"]             . '"}';
    }
    $link->close();
    echo $res;	

}

if($dato->accion == 'usrResponsables'){
    $outp = "";
    $link=Conectarse();
    $fechaHoy = date('Y-m-d');
    $fd = explode('-', $fechaHoy);
    $SQL = "SELECT * FROM usuarios where nPerfil = '1' or nPerfil = '3' Order By usuario";
    // echo $SQL;
    $bd=$link->query($SQL);
    while($rs=mysqli_fetch_array($bd)){
        if ($outp != "") {$outp .= ",";}
		$outp .= '{"usrResponsable":"'      . $rs["usr"]. 			'",';
        $outp .= '"usuario":"'              . $rs["usuario"]. 		'",';
        $outp.= '"email":' 			        . json_encode($rs["email"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
	    $outp .= '"responsableInforme":"'   . $rs["responsableInforme"]. 			'"}';    
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);

}

if($dato->accion == 'borrarDoc'){
    $ruta = 'Y://AAA/LE/CALIDAD/AC/AC-'.$dato->nInformeCorrectiva.'/Anexos/'; 
    unlink($ruta.$dato->archivo);
}

if($dato->accion == 'lecturaSolicitudes'){
    $outp = "";
    $link=Conectarse();
    $fechaHoy = date('Y-m-d');
    $fd = explode('-', $fechaHoy);
    $SQL = "SELECT * FROM formularios where Modulo = 'G' and year(Fecha) = '".$fd[0]."' and month(Fecha) = '".$fd[1]."' Order By nInforme Desc";
    // echo $SQL;
    $bd=$link->query($SQL);
    while($rs=mysqli_fetch_array($bd)){
        $ff = explode('(', $rs["Formulario"]);
        $tpForm = $ff[0];
        if ($outp != "") {$outp .= ",";}
		$outp .= '{"nInforme":"'  . 		$rs["nInforme"]. 			'",';
        $outp .= '"Formulario":"'. 			$rs["Formulario"]. 			'",';
        $outp .= '"tpForm":"'. 			    $tpForm. 			        '",';
        $outp .= '"Impuesto":"'. 			$rs["Impuesto"]. 	        '",';
        $outp .= '"Fecha":"'. 			    $rs["Fecha"]. 			    '",';
        $outp .= '"Neto":"'. 			    $rs["Neto"]. 			    '",';
        $outp .= '"Iva":"'. 			    $rs["Iva"]. 			    '",';
        $outp .= '"Bruto":"'. 			    $rs["Bruto"]. 			    '",';
        $outp.= '"Concepto":' 			    .json_encode($rs["Concepto"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
	    $outp .= '"IdProyecto":"'. 			$rs["IdProyecto"]. 			'"}';    
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);
}



?>