<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
date_default_timezone_set("America/Santiago");

$dato = json_decode(file_get_contents("php://input")); 

include("../conexionli.php"); 


if($dato->accion == "dataTraccionesTablaTr100"){
    $Otam = $dato->Otam;
    $res = '';
    $Prueba = 'Prueba';
    require_once '../PHPExcel/Classes/PHPExcel.php';

    $archivo = 'resultadoTr/'.$Otam.'/Traccion.xlsx';
    $archivo = "resultadoTr/19678-01-T01/Traccion.xlsx";

    if(file_exists($archivo)){
        $inputFileType = PHPExcel_IOFactory::identify($archivo);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($archivo);
        $sheet = $objPHPExcel->getSheet(0); 
        $highestRow = $sheet->getHighestRow(); 
        $highestColumn = $sheet->getHighestColumn();

        // $Prueba = $sheet->getCell("N".8)->getValue();
        $aTit[] = $sheet->getCell("N".$row)->getValue();
        // $Prueba = $sheet->getCell("N".$row)->getValue();

        $Prueba = 'Entra aqui...';
        $res.= '{"idItem":"'.			    $Otam.				            '",';
        $res.= '"Prueba":"'.			    $Prueba.		            '"}';

    }
    echo $res;	

}

if($dato->accion == "dataTraccionesTabla"){

    $Otam = $dato->Otam;
    
    $fp = fopen('resultadoTr/'.$Otam."/Resultados.htm", "r");
    $i          = 0;
    $probeta    = 'Re';
    $Operador   = '';
    $j          = 0;
    $inicia     = 'No';
    $Campo      = '';

    $Zporciento = 0;
    $rAre       = 0;
    $Di         = 0;
    $Df         = 0;
    $Espesor    = 0;
    $Ancho      = 0;
    $UTS        = 0;
    $tFlu       = 0;
    $cMax       = 0;
    $tpMuestra  = 'Re';
    
    while(!feof($fp)) {
        $linea = utf8_encode(fgets($fp)); 
        $ln = trim(strip_tags($linea));
        if(substr_count($ln,'OTAM') > 0 ){
            $j = 0;
            $inicia = 'Si';
        }
          
        if($ln != ''){
            $i++;
            //echo $i.' => '.$ln.'<br>';
            
            if($i >= 6 and $i <= 19){
                if($i == 7){
                    $Otam = $ln;
                }
                if($i == 9){
                    //$Operador = $ln;
                }
                if($i == 11){
                    $Humedad = $ln;
                }
                if($i == 13){
                    $Temperatura = $ln;
                }
                if($i == 17){
                    //echo 'Temperatura : '.$Temperatura.'<br>';
                    if(substr_count($ln,'Plana') > 0 ){
                        $tpMuestra = 'Pl';
                    }
                    if(substr_count($ln,'Redonda') > 0 ){
                        $tpMuestra = 'Re';
                    }
                    if(substr_count($ln,'Cilindrica') > 0 ){
                        $tpMuestra = 'Re';
                    }
    
                }
                if($i == 19){
                     $fechaRegistro = $ln;
                     $fd = explode('/', $fechaRegistro); // dd-mm-aaaa 07-03-2023

                     //MM/dd/AAAA
                     //0   1  2
                     $fechaRegistro = $fd[2].'-'.$fd[0].'-'.$fd[1];
                }
            }

            
            if($i >= 21){
                //echo $i.' => '.$ln.'<br>';
    
                if($tpMuestra == 'Pl'){
                    if($i == 22){
                        $Espesor = $ln;
                    }
                    if($i == 24){
                        $Ancho = $ln;
                    }
                    if($i == 26){
                        $aIni = $ln;
                    }
                    if($i == 28){
                        $Modulo = $ln;
                    }
                    if($i == 30){
                        $cFlu = $ln;
                    }
                    if($i == 32){
                        $cMax = $ln;
                        $UTS = $ln;
                    }
                    if($i == 34){
                        $tFlu = $ln;
                    }
                    if($i == 36){
                        $tMax = $ln;
                    }
                    if($i == 38){
                        $aSob = $ln;
                    }
                    if($i == 40){
                        $Li = $ln;
                    }
                    if($i == 42){
                        $Lf = $ln;
                    }
        
                }
                
                if($tpMuestra == 'Re'){
                    $Espesor    = 0;
                    $Ancho      = 0;
                
                    if($i == 22){
                        $Di = $ln;
                    }
                    if($i == 24){
                        $aIni = $ln;
                    }
                    if($i == 26){
                        $Modulo = $ln;
                    }
                    if($i == 28){
                        $cFlu = $ln;
                    }
                    if($i == 30){
                        $UTS = $ln;
                        $cMax = $ln;
                        $UTS = $ln;

                    }
                    if($i == 32){
                        $tFlu = $ln;
                    }
                    if($i == 34){
                        $tMax = $ln;
                    }
                    if($i == 36){
                        $aSob = $ln;
                    }
                    if($i == 38){
                        $rAre = $ln;
                    }
                    if($i == 40){
                        $Li = $ln;
                    }
                    if($i == 42){
                        $Lf = $ln;
                    }
                    if($i == 44){
                        $Df = $ln;
                    }
        
                }
                
            }
            
    
        }
        
    }


    fclose($fp);
 
    $g 	= 9.80665; 
    $pi = 3.1416;
    
    if($tpMuestra == 'Pl'){
        $aIni 	= $Espesor * $Ancho;
        $aIni 	= number_format($aIni, 2, '.', ',');
        
        if($Espesor > 0 and $Ancho > 0 and $tFlu > 0){
            $cFlu	= (($tFlu * $Espesor * $Ancho) / $g);
            $cFlu 	= number_format($cFlu, 0, ',', '.');
        }

        if($Espesor > 0 and $Ancho > 0 and $cMax > 0){
            $tMax	= (($cMax / ($Espesor * $Ancho)) * $g);
            $tMax 	= number_format($tMax, 0, ',', '.');
        }

        if($Lf > 0 and $Li > 0 ){
            $aSob	= ((($Lf - $Li) / $Li) * 100);
            $aSob 	= number_format($aSob, 2, ',', '.');
            $Aporciento = (($Lf - $Li) / $Li) * 100;
        }
    }


    if($tpMuestra == 'Re'){
        $Espesor    = 0;
        $Ancho      = 0;

        if($Di > 0){
            $aIni 	= (pow($Di, 2) / 4) * $pi;
            $aIni 	= number_format($aIni, 2, '.', ',');
        }

        if($Di > 0 and $tFlu > 0){
            $cFlu	= ($tFlu * ((pow($Di, 2) / 4) * $pi)) / $g;
            $cFlu 	= number_format($cFlu, 0, ',', '.');
        }

        if($Di > 0){
            $tMax	= ((4 * intval($cMax)) / (pow($Di, 2) * $pi)) * $g ;
            $tMax 	= number_format($tMax, 0, ',', '.');
        }						
        if($Li > 0){
            $aSob	= ((($Lf - $Li) / $Li) * 100);
            $aSob 	= number_format($aSob, 0, ',', '.');
            $Aporciento = (($Lf - $Li) / $Li) * 100;
        }						
        if($Di > 0){
            $rAre	= (((pow($Di, 2) - pow($Df, 2)) / pow($Di, 2)) * 100);
            $rAre 	= number_format($rAre, 2, '.', ',');

            $aInicial 	= (pow($Di, 2) / 4) * $pi;
            $aInicial 	= number_format($aInicial, 2, '.', ',');
            $aFinal 	= (pow($Df, 2) / 4) * $pi;
            $aFinal 	= number_format($aFinal, 2, '.', ',');
            $Zporciento = ((intval($aInicial) - intval($aFinal)) / intval($aInicial)) * 100;
            $Zporciento	= number_format($Zporciento, 2, '.', ',');
            //echo $aInicial.' '.$aFinal.' '.round(($aInicial - $aFinal),2).' '.$Zporciento;
        }

    }
    if($cMax > 0 and $aIni > 0){
        $UTS = ($cMax * $g);
        $UTS = $UTS / floatval($aIni);
    }

    $res = '';
    $link=Conectarse();
    $SQL = "SELECT * FROM regtraccion Where idItem = '$dato->Otam'";
    $bd=$link->query($SQL);
    if($rs = mysqli_fetch_array($bd)){
        
        $actSQL="UPDATE regtraccion SET ";
        $actSQL.="Zporciento	    = '".$Zporciento.       "',";
        $actSQL.="Di	            = '".$Di.               "',";
        $actSQL.="Df	            = '".$Df.               "',";
        $actSQL.="UTS               = '".$UTS.              "',";
        $actSQL.="rAre              = '".$rAre.             "',";
        $actSQL.="Humedad		    = '".$Humedad.	        "',";
        $actSQL.="Temperatura		= '".$Temperatura.	    "',";
        $actSQL.="fechaRegistro		= '".$fechaRegistro.	"',";
        $actSQL.="Espesor			= '".$Espesor.	        "',";
        $actSQL.="Ancho			    = '".$Ancho.	        "',";
        $actSQL.="aIni			    = '".$aIni.	            "',";
        $actSQL.="cFlu	            = '".$cFlu.	            "',";
        $actSQL.="cMax	            = '".$cMax.	            "',";
        $actSQL.="tMax	            = '".$tMax.	            "',";
        $actSQL.="tFlu	            = '".$tFlu.	            "',";
        $actSQL.="aSob	            = '".$aSob.	            "',";
        //$actSQL.="Aporciento	            = '".$aSob.	            "',";
        $actSQL.="Li	            = '".$Li.	            "',";
        $actSQL.="Lf	            = '".$Lf.	            "'";
        $actSQL.="WHERE idItem	    = '$dato->Otam'";
        $bdCot=$link->query($actSQL);
        
        $actSQL="UPDATE Otams SET ";
        $actSQL.="tecRes	        = '".$Operador.	            "'";
        $actSQL.="WHERE Otam	    = '$dato->Otam'";
        $bdCot=$link->query($actSQL);
        
        $res.= '{"idItem":"'.			    $Otam.				            '",';
        $res.= '"Temperatura":"'.	        $rs['Temperatura']. 		    '",';
        $res.= '"Humedad":"'.	            $rs['Humedad']. 				'",';
        $res.= '"tpMuestra":"'.	            $rs['tpMuestra']. 		        '",';
        $res.= '"Espesor":"'.	            $rs['Espesor']. 	            '",';
        $res.= '"Ancho":"'.	                $rs['Ancho']. 	                '",';
        $res.= '"aIni":"'.	                $rs['aIni']. 	                '",';
        
        $res.= '"cFlu":"'.	                $rs['cFlu']. 	                '",';
        $res.= '"cMax":"'.	                $rs['cMax']. 	                '",';
        $res.= '"tMax":"'.	                $rs['tMax']. 	                '",';
        $res.= '"tFlu":"'.	                $rs['tFlu']. 	                '",';
        $res.= '"aSob":"'.	                $rs['aSob']. 	                '",';
        $res.= '"Li":"'.	                $rs['Li']. 	                    '",';
        $res.= '"Lf":"'.	                $rs['Lf']. 	                    '",';
        $res.= '"Di":"'.	                $rs['Di']. 	                    '",';
        $res.= '"Df":"'.	                $rs['Df']. 	                    '",';
        $res.= '"fechaRegistro":"'.			$fechaRegistro.		            '"}';

        
    }
    $link->close();
    echo $res;	



}

if($dato->accion == "guardarDureza"){

    $link=Conectarse(); 
    $sql = "SELECT * FROM regdoblado Where idItem = '$dato->idItem' and nIndenta = '$dato->nIndenta'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE regdoblado SET ";
        $actSQL.="Dureza		    ='".$dato->Dureza.	    "'";
        $actSQL.="WHERE idItem	    = '$dato->idItem' and nIndenta = '$dato->nIndenta'";
        $bdCot=$link->query($actSQL);
    }
    $link->close();
    
}

if($dato->accion == "LecturaDurezasPerfiles"){
    $res = '';
    $link=Conectarse();
    $SQL = "SELECT * FROM regdoblado Where idItem = '$dato->idItem' Order By nIndenta Desc";
    $bd=$link->query($SQL);
    if($rs = mysqli_fetch_array($bd)){
        $res.= '{"CodInforme":"'.			$rs['CodInforme'].					'",';
        $res.= '"tpMuestra":"'.	            $rs["tpMuestra"]. 				    '",';
        $res.= '"nIndenta":"'.	            $rs["nIndenta"]. 				    '",';
        $res.= '"Distancia":"'.	            $rs["Distancia"]. 				    '",';
        $res.= '"Dureza":"'.	            $rs["Dureza"]. 	                    '",';
        $res.= '"fechaRegistro":"'.			$rs['fechaRegistro'].		         '"}';
    }
    $link->close();
    echo $res;	
}

if($dato->accion == "mostrarTracciones"){
    $outp = "";
    $link=Conectarse();
    $SQL = "SELECT * FROM regtraccion Where idItem like '%$dato->RAM%' and fechaRegistro = '0000-00-00' Order By idItem Asc";
    $bd=$link->query($SQL);
    while($rs = mysqli_fetch_array($bd)){
        $dataItem = '';
        $fd = explode('-', $rs['idItem']);
        $dataidItem = $fd[0].'-'.$fd[1];
        $equipo = '';
        $SQLtab = "SELECT * FROM amtabensayos Where idItem = '".$dataidItem."' and idEnsayo = 'Tr'";
        $equipo = $SQLtab;
        $bdtab=$link->query($SQLtab);
        if($rstab = mysqli_fetch_array($bdtab)){
            $equipo = $rstab["equipo"];
            // $equipo = $dataidItem;
        }

        if ($outp != "") {$outp .= ",";}
        $outp.= '{"idItem":"'.	    $rs["idItem"].	        '",';
        $outp.= '"equipo":"'.	    $equipo.	            '",';
        $outp.= '"tpMuestra":"'. 	$rs["tpMuestra"]. 	    '"}';
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);    
}

if($dato->accion == "dataTraccionesEnsayar"){
    $Tr100  = 'off';
    $Tr30   = 'off';
    $Tr5    = 'off';

    $outp = "";
    $link=Conectarse();
    $SQL = "SELECT * FROM cotizaciones Where Estado = 'P' and RAM > 0 Order By RAM Asc";
    $bd=$link->query($SQL);
    while($rs = mysqli_fetch_array($bd)){
        $cEnsayos   = 0;
        $cEnsayosP  = 0;
        $RAM        = 0;
        $tpMuestra  = '';
        $equipo     = 'Tr';
        $SQLot = "SELECT * FROM otams Where RAM = '".$rs['RAM']."' and idEnsayo = 'Tr'";
        $bdot=$link->query($SQLot);
        while($rsot = mysqli_fetch_array($bdot)){  
            $cEnsayos++;
            $SQLt = "SELECT * FROM regtraccion Where idItem = '".$rsot['Otam']."'";
            $bdt=$link->query($SQLt);
            if($rst = mysqli_fetch_array($bdt)){
                if($rst['fechaRegistro'] == '0000-00-00'){
                    $cEnsayosP++;
                }
            }
            // $SQLtr = "SELECT * FROM amtabensayos Where idItem = '".$rsot['idItem']."' and idEnsayo = 'Tr'";
            // $bdtr=$link->query($SQLtr);
            // if($rstr = mysqli_fetch_array($bdtr)){
            // //     $equipo = $rstr['equipo'];
            //     if($rstr['equipo'] == 'Tr-100'){
            //         $Tr100 = 'on';
            //     }
            // }
            // $equipo = '';
            $tpMuestra = $rsot["tpMuestra"];
        }
        if($cEnsayosP > 0){
            if ($outp != "") {$outp .= ",";}
            $outp.= '{"cEnsayos":"'.	$cEnsayos.	        '",';
            $outp.= '"cEnsayosP":"'.	$cEnsayosP.	        '",';
            $outp.= '"tpMuestra":"'.	$tpMuestra.	        '",';
            $outp.= '"Otam":"'.	        $rsot['Otam'].	    '",';
            // $outp.= '"Tr100":"'.	    $Tr100.	            '",';
            $outp.= '"RAM":"'. 	        $rs["RAM"]. 	    '"}';
        }
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);    
}



if($dato->accion == "Ultima"){
    $res = '';
    $link=Conectarse();
    $SQL = "SELECT * FROM actividades Order By idActividad Desc";
    $bd=$link->query($SQL);
    if($rs = mysqli_fetch_array($bd)){
        $idActividad = $rs['idActividad'] + 1;
        $res.= '{"idActividad":"'.			$idActividad.					'"}';
    }
    $link->close();
    echo $res;	
}
if($dato->accion == "Borrar"){
    $link=Conectarse();
    $bdEnc=$link->query("Delete From actividades Where idActividad = '$dato->idActividad'");
    $link->close();
}


?>