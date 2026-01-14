<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include_once("conexionli.php");



if($dato->accion == 'calcularGrabar'){
    $link=Conectarse();

    $g 	= 9.80665;
    $pi = 3.1416;
    
    $aIni           = 0;
    $cFlu           = 0;
    $tMax           = 0;
    $aSob           = 0;
    $Aporciento     = 0;

    $rAre           = 0;
    $aInicial       = 0;
    $aFinal         = 0;
    $Zporciento     = 0;
    $UTS            = 0;


    if($dato->tpMuestra == 'Pl'){
        $aIni 	= $dato->Espesor * $dato->Ancho;
        $aIni 	= number_format($aIni, 2, ',', '.');
        
        if($dato->Espesor > 0 and $dato->Ancho > 0 and $dato->tFlu > 0){
            $cFlu	= (($dato->tFlu * $dato->Espesor * $dato->Ancho) / $g);
            $cFlu 	= number_format($cFlu, 0, ',', '.');
        }

        if($dato->Espesor > 0 and $dato->Ancho > 0 and $dato->cMax > 0){
            $tMax	= (($dato->cMax / ($dato->Espesor * $dato->Ancho)) * $g);
            $tMax 	= number_format($tMax, 0, ',', '.');
        }

        if($dato->Lf > 0 and $dato->Li > 0 ){
            $aSob	= ((($dato->Lf - $dato->Li) / $dato->Li) * 100);
            $aSob 	= number_format($aSob, 0, ',', '.');
            $Aporciento = (($dato->Lf - $dato->Li) / $dato->Li) * 100;
        }
    }

    if($dato->tpMuestra == 'Re'){
        
        if($dato->Di > 0){
            $aIni 	= (pow($dato->Di, 2) / 4) * $pi;
            $aIni 	= number_format($aIni, 2, ',', '.');
        }

        if($dato->Di > 0 and $dato->tFlu > 0){
            $cFlu	= ($dato->tFlu * ((pow($dato->Di, 2) / 4) * $pi)) / $g;
            $cFlu 	= number_format($cFlu, 0, ',', '.');
        }

        if($dato->Di > 0){
            $tMax	= ((4 * intval($dato->cMax)) / (pow($dato->Di, 2) * $pi)) * $g ;
            $tMax 	= number_format($tMax, 0, ',', '.');
        }						

        if($dato->Li > 0){
            $aSob	= ((($dato->Lf - $dato->Li) / $dato->Li) * 100);
            $aSob 	= number_format($aSob, 0, ',', '.');
            $Aporciento = (($dato->Lf - $dato->Li) / $dato->Li) * 100;
        }						

        if($dato->Di > 0){

            $rAre	= (((pow($dato->Di, 2) - pow($dato->Df, 2)) / pow($dato->Di, 2)) * 100);
            $rAre 	= number_format($rAre, 2, ',', '.');

            $aInicial 	= (pow($dato->Di, 2) / 4) * $pi;
            $aInicial 	= number_format($aInicial, 2, '.', ',');
            $aFinal 	= (pow($dato->Df, 2) / 4) * $pi;
            $aFinal 	= number_format($aFinal, 2, '.', ',');
            $Zporciento = ((intval($aInicial) - intval($aFinal)) / intval($aInicial)) * 100;
            $Zporciento	= number_format($Zporciento, 2, '.', ',');
            //echo $aInicial.' '.$aFinal.' '.round(($aInicial - $aFinal),2).' '.$Zporciento;
        
        } 
    }

    if($dato->cMax > 0 and $aIni > 0){
        $UTS = ($dato->cMax * $g);
        $UTS = $UTS / floatval($aIni);
    }


	$SQL = "Select * From regtraccion Where idItem = '$dato->Otam'";
    $bd=$link->query($SQL);
    if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE regtraccion SET ";
        $actSQL.="tpMuestra		= '".$dato->tpMuestra.	    "',";
        $actSQL.="Espesor		= '".$dato->Espesor.	    "',";
        $actSQL.="Ancho		    = '".$dato->Ancho.	        "',";
        $actSQL.="Observacion   = '".$dato->Observacion.	"',";
        $actSQL.="Li		    = '".$dato->Li.	            "',";
        $actSQL.="Lf		    = '".$dato->Lf.	            "',";
        $actSQL.="Di		    = '".$dato->Di.	            "',";
        $actSQL.="Df		    = '".$dato->Df.	            "',";
        $actSQL.="cMax		    = '".$dato->cMax.	        "',";
        $actSQL.="tFlu		    = '".$dato->tFlu.	        "',";
        $actSQL.="Temperatura   = '".$dato->Temperatura.	"',";
        $actSQL.="Humedad       = '".$dato->Humedad.	    "',";
        $actSQL.="fechaRegistro = '".$dato->fechaRegistro.	"',";
        $actSQL.="aIni		    = '".$aIni.	                "',";
        $actSQL.="cFlu		    = '".$cFlu.	                "',";
        $actSQL.="tMax		    = '".$tMax.	                "',";
        $actSQL.="aSob		    = '".$aSob.	                "',";
        $actSQL.="rAre		    = '".$rAre.	                "',";
        $actSQL.="Zporciento    = '".$Zporciento.	        "',";
        $actSQL.="UTS           = '".$UTS.	                "'";
        $actSQL.="Where idItem 	= '".$dato->Otam."'";
        $bdfRAM=$link->query($actSQL);
    }

    if($dato->Estado == 'R'){
        $actSQL="UPDATE otams SET ";
        $actSQL.="Estado		='".$dato->Estado.	"'";
        $actSQL.="WHERE Otam 	= '".$dato->Otam.   "'";
        $bdfRAM=$link->query($actSQL);
    }
   
    $link->close();
    
    $tmp = "tmp";
	if(!file_exists($tmp)){
		mkdir($tmp);
	}

}

if($dato->accion == 'LeerTraccion'){
    $link=Conectarse();
    $res = '';
	$SQL = "Select * From regtraccion Where idItem = '$dato->Otam'";
    $bd=$link->query($SQL);
    if($rs = mysqli_fetch_array($bd)){
        $SQLo = "Select * From otams Where Otam = '$dato->Otam'";
        $bdo=$link->query($SQL);
        if($rso = mysqli_fetch_array($bdo)){

        }
		$res.= '{"CodInforme":"'.			$rs["CodInforme"].				'",';
		$res.= '"Di":"'.			        $rs["Di"].				        '",';
		$res.= '"Df":"'.			        $rs["Df"].				        '",';
		$res.= '"aIni":"'.			        $rs["aIni"].				    '",';
		$res.= '"cFlu":"'.			        $rs["cFlu"].		            '",';
		$res.= '"tFlu":"'.			        $rs["tFlu"].		            '",';
		$res.= '"rAre":"'.			        $rs["rAre"].		            '",';
		$res.= '"Zporciento":"'.			$rs["Zporciento"].		        '",';
		$res.= '"Espesor":"'.			    $rs["Espesor"].		            '",';
		$res.= '"tMax":"'.			        $rs["tMax"].		            '",';
		$res.= '"Temperatura":"'.			$rs["Temperatura"].		        '",';
		$res.= '"Ancho":"'.			        $rs["Ancho"].		            '",';
		$res.= '"aSob":"'.			        $rs["aSob"].		            '",';
		$res.= '"Humedad":"'.			    $rs["Humedad"].		            '",';
		$res.= '"cMax":"'.			        $rs["cMax"].		            '",';
		$res.= '"Li":"'.			        $rs["Li"].		                '",';
		$res.= '"Lf":"'.			        $rs["Lf"].		                '",';
        $res.= '"Observacion":' 	        .json_encode($rs["Observacion"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
		$res.= '"aSob":"'.			        $rso["aSob"].		             '",';
        $res.= '"fechaRegistro":"'. 	    $rs["fechaRegistro"]. 		    '"}';
    }
    $link->close();
    echo $res;	
}

if($dato->accion == 'LeerArchivos'){
    $fd = explode('-',$dato->Otam);
    $RAM = $fd[0];
    $res = '';
    $agnoActual = date('Y'); 
    $ruta = 'Y://AAA/Archivador-AM/'.$agnoActual.'/'.$RAM; 

    $gestorDir = opendir($ruta);
    while(false !== ($nombreDir = readdir($gestorDir))){
        $dirActual = explode('-', $nombreDir);
        if($nombreDir != '.' and $nombreDir != '..'){
            $res.= '{"Otam":"'.			$dato->Otam.				'",';
            $res.= '"ficheros":' 	    .json_encode($nombreDir, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
            $res.= '"idItem":"'. 	    $dato->Otam. 		    '"}';
        }
    }
    echo $res;	

}
if($dato->accion == 'LeerCAM'){
    $link=Conectarse();
    $res = '';
	$SQL = "Select * From cotizaciones Where CAM = '$dato->CAM'";
    $bd=$link->query($SQL);
    if($rs = mysqli_fetch_array($bd)){
        $Cliente = '';
        $HEScli  = '';
        $SQLc = "SELECT * FROM clientes Where RutCli = '".$rs['RutCli']."'";
        $bdc=$link->query($SQLc);
        if($rsc=mysqli_fetch_array($bdc)){
            $Cliente    = $rsc['Cliente'];
            $HEScli     = $rsc['HES'];
        }
        $Contacto = '';
        $SQLcc = "SELECT * FROM contactoscli Where RutCli = '".$rs['RutCli']."' and nContacto = '".$rs['nContacto']."'";
        $bdcc=$link->query($SQLcc);
        if($rscc=mysqli_fetch_array($bdcc)){
            $Contacto = $rscc['Contacto'];
        }
		$res.= '{"CAM":"'.			    $rs["CAM"].				        '",';
		$res.= '"RAM":"'.			    $rs["RAM"].				        '",';
        $res.= '"obsServicios":' 	    .json_encode($rs['obsServicios'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
		$res.= '"informeUP":"'.	        $rs["informeUP"].		        '",';
		$res.= '"fechaInformeUP":"'.    $rs["fechaInformeUP"].		    '",';
		$res.= '"nContacto":"'.         $rs["nContacto"].		        '",';
		$res.= '"usrCotizador":"'.      $rs["usrCotizador"].		    '",';
		$res.= '"usrResponzable":"'.    $rs["usrResponzable"].		    '",';
		$res.= '"nOC":"'.               $rs["nOC"].		                '",';
		$res.= '"HES":"'.               $rs["HES"].		                '",';
		$res.= '"Cliente":"'.	        $Cliente.		                '",';
		$res.= '"HEScli":"'.	        $HEScli.		                '",';
		$res.= '"Contacto":"'.	        $Contacto.		                '",';
        $res.= '"Fan":"'. 		        $rs["Fan"]. 				    '"}';
    }
    $link->close();
    echo $res;	

}

if($dato->accion == 'cambiarMuestra'){
    $link=Conectarse();
	$SQL = "Select * From otams Where Otam = '$dato->Otam'";
    $bd=$link->query($SQL);
    if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE otams SET ";
        $actSQL.="tpMuestra		= '".$dato->tpMuestra.	"'";
        $actSQL.="Where Otam 	= '".$dato->Otam."'";
        $bdfRAM=$link->query($actSQL);
        $actSQL="UPDATE regtraccion SET ";
        $actSQL.="tpMuestra		= '".$dato->tpMuestra.	"'";
        $actSQL.="Where idItem 	= '".$dato->Otam."'";
        $bdfRAM=$link->query($actSQL);
    }
    $link->close();
}

if($dato->accion == 'Muestras'){
    $link=Conectarse();
    $outp = "";
	$SQL = "Select * From amtpsmuestras Where idEnsayo = '$dato->idEnsayo'";
    $bd=$link->query($SQL);
    while($rs = mysqli_fetch_array($bd)){
		if ($outp != "") {$outp .= ",";}
		$outp .= '{"idEnsayo":"'  . 		$rs["idEnsayo"]. 				'",';
		$outp .= '"tpMuestra":"'. 			$rs["tpMuestra"]. 				'",';
		$outp.= '"Muestra":' 	            .json_encode($rs["Muestra"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
		$outp.= '"tipoEnsayo":' 			.json_encode($rs["tipoEnsayo"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
		$outp .= '"factorY":"'. 		    $rs["factorY"]. 			'",';
	    $outp .= '"constanteY":"'. 			$rs["constanteY"]. 			'"}';
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);
}


?>