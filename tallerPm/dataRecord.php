<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
date_default_timezone_set("America/Santiago");

$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php"); 

if($dato->accion == "calcularCarbonoEquivalente"){
    $res = '';
    $link=Conectarse();
    if($dato->CodInforme){
        $SQL = "SELECT * FROM regquimico Where idItem = '$dato->idItem' and CodInforme = '$dato->CodInforme'";
    }else{
        $SQL = "SELECT * FROM regquimico Where idItem = '$dato->idItem' Order By fechaRegistro Desc";
    }
    $bd=$link->query($SQL);
    if($rs = mysqli_fetch_array($bd)){
        
        $vCarbono = '';
        $cC  = 0;

        $cC = $rs['cC'];
        if(substr($rs['cC'],0,1) == '<'){
            $cC = substr($rs['cC'],1);
        }
        $cC = floatval(str_replace(',','.',$cC));

        $cMn = $rs['cMn'];
        if(substr($rs['cMn'],0,1) == '<'){
            $cMn = substr($rs['cMn'],1);
        }
        $cMn = floatval(str_replace(',','.',$cMn));

        $cCr = $rs['cCr'];
        if(substr($rs['cCr'],0,1) == '<'){
            $cCr = substr($rs['cCr'],1);
        }
        $cCr = floatval(str_replace(',','.',$cCr));

        $cMo = $rs['cMo'];
        if(substr($rs['cMo'],0,1) == '<'){
            $cMo = substr($rs['cMo'],1);
        }
        $cMo = floatval(str_replace(',','.',$cMo));

        $cV = $rs['cV'];
        if(substr($rs['cV'],0,1) == '<'){
            $cV = substr($rs['cV'],1);
        }
        $cV = floatval(str_replace(',','.',$cV));

        $cV = $rs['cV'];
        if(substr($rs['cV'],0,1) == '<'){
            $cV = substr($rs['cV'],1);
        }
        $cV = floatval(str_replace(',','.',$cV));

        $cNi = $rs['cNi'];
        if(substr($rs['cNi'],0,1) == '<'){
            $cNi = substr($rs['cNi'],1);
        }
        $cNi = floatval(str_replace(',','.',$cNi));

        $cCu = $rs['cCu'];
        if(substr($rs['cCu'],0,1) == '<'){
            $cCu = substr($rs['cCu'],1);
        }
        $cCu = floatval(str_replace(',','.',$cCu));



        $vCarbono = $cC + ($cMn/6) + (($cCr + $cMo + $cV) / 5) + (($cNi + $cCu) / 15);
        $vCarbono = number_format($vCarbono, 2, '.', ',');

        
        $res.= '{"CodInforme":"'.			$rs['CodInforme'].					'",';
        $res.= '"idItem":"'.	            $rs["idItem"]. 				        '",';
        $res.= '"vCarbono":"'.			    $vCarbono.		                    '"}';
        
    }
    $link->close();
    echo $res;	 

}

if($dato->accion == "lecturaEnsayos"){
    $outp = "";
    $link=Conectarse();
    
    $SQL = "SELECT * FROM regquimico Where idItem = '$dato->idItem' Order By fechaRegistro Desc";
    //$SQL = "SELECT * FROM regquimico Where idItem = '15658-01-Q01' Order By fechaRegistro Desc";
    $bd=$link->query($SQL);
    while($rs = mysqli_fetch_array($bd)){   
        if ($outp != "") {$outp .= ",";}
        $outp.= '{"idItem":"'.				    $rs["idItem"].					'",';
        $outp.= '"Rep":"'.				        $rs["Rep"]. 				    '",';
        $outp.= '"Programa":"'.			        $rs["Programa"]. 			    '",';
        $outp.= '"Temperatura":"'.			    $rs["Temperatura"]. 			'",';
        $outp.= '"Humedad":"'.			        $rs["Humedad"]. 			    '",';
        $outp.= '"fechaRegistro":"'. 		    $rs["fechaRegistro"]. 	        '"}';
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);    
}

if($dato->accion == "leerEnsayoAsignado"){ 
    $res = '';
    $zero = 0;
    $CodInforme = $dato->CodInforme;

    $link=Conectarse();
    $SQL = "SELECT * FROM otams Where Otam = '$dato->idItem'";
    $bd=$link->query($SQL);
    if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE regquimico SET ";
        $actSQL.="CodInforme		='".$rs['CodInforme'].	    "'";
        $actSQL.="WHERE idItem	    = '$dato->idItem'";
        $bdCot=$link->query($actSQL);
    }
    $link->close();

    $link=Conectarse();
    if($dato->CodInforme){
        $SQL = "SELECT * FROM regquimico Where idItem = '$dato->idItem' and CodInforme = '$dato->CodInforme'";
    }else{
        $SQL = "SELECT * FROM regquimico Where idItem = '$dato->idItem' Order By fechaRegistro Desc";
    }
    $bd=$link->query($SQL);
    if($rs = mysqli_fetch_array($bd)){
        $SQLot = "SELECT * FROM otams Where Otam = '$dato->idItem'";
        $bdot=$link->query($SQLot);
        if($rsot = mysqli_fetch_array($bdot)){

        } 
        // $CodInforme = $rs['CodInforme'];
        // if($CodInforme === ''){ $CodInforme = $dato->CodInforme; }
        // $res.= '{"CodInforme":"'.			$CodInforme.					    '",';
        $res.= '{"idItem":"'.			    $rs["idItem"].					    '",';
        $res.= '"CodInforme":"'.	        $dato->CodInforme. 				        '",';
        $res.= '"Rep":"'.	                $rs["Rep"]. 				        '",';
        $res.= '"tecRes":"'.	            $rsot["tecRes"]. 				    '",';
        $res.= '"Programa":"'.	            $rs["Programa"]. 	                '",';
        $res.= '"Temperatura":"'.			$rs["Temperatura"]. 			    '",';
        $res.= '"Humedad":"'.			    $rs["Humedad"]. 			        '",';
        $res.= '"Observacion":"'.			$rs["Observacion"]. 			    '",';
        $res.= '"cZn":"'.	                $rs["cZn"]. 	                    '",';
        $res.= '"cMg":"'.	                $rs["cMg"]. 	                    '",';
        $res.= '"cPb":"'.                   $rs["cPb"].                         '",';
        $res.= '"cTe":"'.                   $rs["cTe"].                         '",';
        $res.= '"cAs":"'.                   $rs["cAs"].                         '",';
        $res.= '"cSb":"'.                   $rs["cSb"].                         '",';
        $res.= '"cCd":"'.                   $rs["cCd"].                         '",';
        $res.= '"cBi":"'.                   $rs["cBi"].                         '",';
        $res.= '"cAg":"'.                   $rs["cAg"].                         '",';
        $res.= '"cAi":"'.                   $rs["cAi"].                         '",';
        $res.= '"cZr":"'.                   $rs["cZr"].                         '",';
        $res.= '"cAu":"'.                   $rs["cAu"].                         '",';
        $res.= '"cSe":"'.                   $rs["cSe"].                         '",';


        $res.= '"cC":"'.	                $zero. 	                            '",';
        if($rs["cC"]){ 
            $res.= '"cC":"'.	            $rs["cC"]. 	                        '",';
        }else{
            $bdQ=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'C' and imprimible = 'on'");
            if($rq = mysqli_fetch_array($bdQ)){
                $res.= '"cC":"'.	        $rq['valorDefecto']. 	        '",';
            }
        }
        $res.= '"cSi":"'.	                $zero. 	                            '",';
        if($rs["cSi"]){ 
            $res.= '"cSi":"'.	            $rs["cSi"]. 	                 '",';
        }else{
            $bdQ=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Si' and imprimible = 'on'");
            if($rq = mysqli_fetch_array($bdQ)){
                $res.= '"cSi":"'.	        $rq['valorDefecto']. 	        '",';
            }
        }
        $res.= '"cMn":"'.	                $zero. 	                            '",';
        if($rs["cMn"]){ 
            $res.= '"cMn":"'.	            $rs["cMn"]. 	                 '",';
        }else{
            $bdQ=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Mn' and imprimible = 'on'");
            if($rq = mysqli_fetch_array($bdQ)){
                $res.= '"cMn":"'.	        $rq['valorDefecto']. 	        '",';
            }
        }
        $res.= '"cP":"'.	                $zero. 	                            '",';
        if($rs["cP"]){ 
            $res.= '"cP":"'.	            $rs["cP"]. 	                 '",';
        }else{
            $bdQ=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'P' and imprimible = 'on'");
            if($rq = mysqli_fetch_array($bdQ)){
                $res.= '"cP":"'.	        $rq['valorDefecto']. 	        '",';
            }
        }
        $res.= '"cS":"'.	                $zero. 	                            '",';
        if($rs["cS"]){ 
            $res.= '"cS":"'.	            $rs["cS"]. 	                 '",';
        }else{
            $bdQ=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'S' and imprimible = 'on'");
            if($rq = mysqli_fetch_array($bdQ)){
                $res.= '"cS":"'.	        $rq['valorDefecto']. 	        '",';
            }
        }
        $res.= '"cCr":"'.	                $zero. 	                            '",';
        if($rs["cCr"]){ 
            $res.= '"cCr":"'.	            $rs["cCr"]. 	                 '",';
        }else{
            $bdQ=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Cr' and imprimible = 'on'");
            if($rq = mysqli_fetch_array($bdQ)){
                $res.= '"cCr":"'.	        $rq['valorDefecto']. 	        '",';
            }
        }
        $res.= '"cNi":"'.	                $zero. 	                            '",';
        if($rs["cNi"]){ 
            $res.= '"cNi":"'.	            $rs["cNi"]. 	                 '",';
        }else{
            $bdQ=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Ni' and imprimible = 'on'");
            if($rq = mysqli_fetch_array($bdQ)){
                $res.= '"cNi":"'.	        $rq['valorDefecto']. 	        '",';
            }
        }
        $res.= '"cMo":"'.	                $zero. 	                            '",';

        if($rs["cMo"]){ 
            $res.= '"cMo":"'.	            $rs["cMo"]. 	                 '",';
        }else{
            $bdQ=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Mo' and imprimible = 'on'");
            if($rq = mysqli_fetch_array($bdQ)){
                $res.= '"cMo":"'.	        $rq['valorDefecto']. 	        '",';
            }
        }


        
        $res.= '"cAl":"'.	                $zero. 	                            '",';
        if($rs["cAl"]){ 
            $res.= '"cAl":"'.	            $rs["cAl"]. 	                 '",';
        }else{
            $bdQ=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Al' and imprimible = 'on'");
            if($rq = mysqli_fetch_array($bdQ)){
                $res.= '"cAl":"'.	        $rq['valorDefecto']. 	        '",';
            }
        }
        $res.= '"cCu":"'.	                $zero. 	                            '",';
        if($rs["cCu"]){ 
            $res.= '"cCu":"'.	            $rs["cCu"]. 	                 '",';
        }else{
            $bdQ=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Cu' and imprimible = 'on'");
            if($rq = mysqli_fetch_array($bdQ)){
                $res.= '"cCu":"'.	        $rq['valorDefecto']. 	        '",';
            }
        }
        $res.= '"cCo":"'.	                $zero. 	                            '",';
        if($rs["cCo"]){ 
            $res.= '"cCo":"'.	            $rs["cCo"]. 	                 '",';
        }else{
            $bdQ=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Co' and imprimible = 'on'");
            if($rq = mysqli_fetch_array($bdQ)){
                $res.= '"cCo":"'.	        $rq['valorDefecto']. 	        '",';
            }
        }
        $res.= '"cTi":"'.	                $zero. 	                            '",';
        if($rs["cTi"]){ 
            $res.= '"cTi":"'.	            $rs["cTi"]. 	                 '",';
        }else{
            $bdQ=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Ti' and imprimible = 'on'");
            if($rq = mysqli_fetch_array($bdQ)){
                $res.= '"cTi":"'.	        $rq['valorDefecto']. 	        '",';
            }
        }
        $res.= '"cNb":"'.	                $zero. 	                            '",';
        if($rs["cNb"]){ 
            $res.= '"cNb":"'.	            $rs["cNb"]. 	                 '",';
        }else{
            $bdQ=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Nb' and imprimible = 'on'");
            if($rq = mysqli_fetch_array($bdQ)){
                $res.= '"cNb":"'.	        $rq['valorDefecto']. 	        '",';
            }
        }
        $res.= '"cV":"'.	                $zero. 	                            '",';
        if($rs["cV"]){ 
            $res.= '"cV":"'.	            $rs["cV"]. 	                 '",';
        }else{
            $bdQ=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'V' and imprimible = 'on'");
            if($rq = mysqli_fetch_array($bdQ)){
                $res.= '"cV":"'.	        $rq['valorDefecto']. 	        '",';
            }
        }
        $res.= '"cB":"'.	                $zero. 	                            '",';
        if($rs["cB"]){ 
            $res.= '"cB":"'.	            $rs["cB"]. 	                 '",';
        }else{
            $bdQ=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'B' and imprimible = 'on'");
            if($rq = mysqli_fetch_array($bdQ)){
                $res.= '"cB":"'.	        $rq['valorDefecto']. 	        '",';
            }
        }
        $res.= '"cW":"'.	                $zero. 	                            '",';
        if($rs["cW"]){ 
            $res.= '"cW":"'.	            $rs["cW"]. 	                 '",';
        }else{
            $bdQ=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'W' and imprimible = 'on'");
            if($rq = mysqli_fetch_array($bdQ)){
                $res.= '"cW":"'.	        $rq['valorDefecto']. 	        '",';
            }
        }
        $res.= '"cSn":"'.	                $zero. 	                            '",';
        if($rs["cSn"]){ 
            $res.= '"cSn":"'.	            $rs["cSn"]. 	                 '",';
        }else{
            $bdQ=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Sn' and imprimible = 'on'");
            if($rq = mysqli_fetch_array($bdQ)){
                $res.= '"cSn":"'.	        $rq['valorDefecto']. 	        '",';
            }
        }
        $res.= '"cFe":"'.	                $zero. 	                            '",';
        if($rs["cFe"]){ 
            $res.= '"cFe":"'.	            $rs["cFe"]. 	                 '",';
        }else{
            $bdQ=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Fe' and imprimible = 'on'");
            if($rq = mysqli_fetch_array($bdQ)){
                $res.= '"cFe":"'.	        $rq['valorDefecto']. 	        '",';
            }
        }

        $res.= '"fechaRegistro":"'.			$rs['fechaRegistro'].		         '"}';
    }
    $link->close();
    echo $res;	
}

if($dato->accion == "grabarQuimico"){ 
    $link=Conectarse(); 

    $sql = "SELECT * FROM regquimico Where idItem = '$dato->idItem' and Programa = '$dato->Programa' and Rep = '$dato->Rep'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){ 

        $cMo = '0,002';


        $cC  = $dato->cC;
        $cSi = $dato->cSi;
        $cMn = $dato->cMn;
        $cP  = $dato->cP;
        $cS  = $dato->cS;
        $cCr = $dato->cCr;
        $cNi = $dato->cNi;
        $cMo = $dato->cMo;
        $cAl = $dato->cAl;
        $cCu = $dato->cCu;
        $cCo = $dato->cCo;
        $cTi = $dato->cTi;
        $cNb = $dato->cNb;
        $cV  = $dato->cV;
        $cB  = $dato->cB;
        $cSn = $dato->cSn;

        $cW  = $dato->cW;


        $cFe = $dato->cFe;
        $cZn = $dato->cZn;
        $cMg = $dato->cMg;
        $cPb = $dato->cPb;
        $cTe = $dato->cTe;
        $cAs = $dato->cAs;
        $cSb = $dato->cSb;
        $cCd = $dato->cCd;
        $cBi = $dato->cBi;
        $cAg = $dato->cAg;
        $cAi = $dato->cAi;
        $cZr = $dato->cZr;
        $cAu = $dato->cAu;
        $cSe = $dato->cSe; 

        if($rs['tpMuestra'] == 'Ac'){
            
            $bdQ=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Si' and imprimible = 'on'");
            if($rq = mysqli_fetch_array($bdQ)){
                $cC = validaValor($rq['valorDefecto'], $cC);
            }
            
            $bdQ=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Si' and imprimible = 'on'");
            if($rq = mysqli_fetch_array($bdQ)){
                $cSi = validaValor($rq['valorDefecto'], $cSi);
            }
            
            $bdQ=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Mn' and imprimible = 'on'");
            if($rq = mysqli_fetch_array($bdQ)){
                $cMn = validaValor($rq['valorDefecto'], $cMn);
            }
            $bdQ=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'P' and imprimible = 'on'");
            if($rq = mysqli_fetch_array($bdQ)){
                $cP = validaValor($rq['valorDefecto'], $cP);
            }
            $bdQ=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'S' and imprimible = 'on'");
            if($rq = mysqli_fetch_array($bdQ)){
                $cS = validaValor($rq['valorDefecto'], $cS);
            }
            $bdQ=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Cr' and imprimible = 'on'");
            if($rq = mysqli_fetch_array($bdQ)){
                $cCr = validaValor($rq['valorDefecto'], $cCr);
            }
            $bdQ=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Ni' and imprimible = 'on'");
            if($rq = mysqli_fetch_array($bdQ)){
                $cNi = validaValor($rq['valorDefecto'], $cNi);
            }
             
            $bdQ=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Mo' and imprimible = 'on'");
            if($rq = mysqli_fetch_array($bdQ)){
                $cMo = validaValor($rq['valorDefecto'], $cMo);
            }
            
            $bdQ=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Al' and imprimible = 'on'");
            if($rq = mysqli_fetch_array($bdQ)){
                $cAl = validaValor($rq['valorDefecto'], $cAl);
            }
            $bdQ=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Cu' and imprimible = 'on'");
            if($rq = mysqli_fetch_array($bdQ)){
                $cCu = validaValor($rq['valorDefecto'], $cCu);
            }
            $bdQ=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Co' and imprimible = 'on'");
            if($rq = mysqli_fetch_array($bdQ)){
                $cCo = validaValor($rq['valorDefecto'], $cCo);
            }
            $bdQ=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Ti' and imprimible = 'on'");
            if($rq = mysqli_fetch_array($bdQ)){
                $cTi = validaValor($rq['valorDefecto'], $cTi);
            }
            $bdQ=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Nb' and imprimible = 'on'");
            if($rq = mysqli_fetch_array($bdQ)){
                $cNb = validaValor($rq['valorDefecto'], $cNb);
            }
            $bdQ=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'V' and imprimible = 'on'");
            if($rq = mysqli_fetch_array($bdQ)){
                $cV = validaValor($rq['valorDefecto'], $cV);
            }
            $bdQ=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'B' and imprimible = 'on'");
            if($rq = mysqli_fetch_array($bdQ)){
                $cB = validaValor($rq['valorDefecto'], $cB);
            }
            $bdQ=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Sn' and imprimible = 'on'");
            if($rq = mysqli_fetch_array($bdQ)){
                $cSn = validaValor($rq['valorDefecto'], $cSn);
            }

            




        }

        $actSQL="UPDATE regquimico SET ";
        $actSQL.="Temperatura		='".$dato->Temperatura.	"',";
        $actSQL.="Humedad		    ='".$dato->Humedad.	    "',";
        $actSQL.="fechaRegistro		='".$dato->fechaRegistro."',";
        
        // $actSQL.="cC		        ='".$cC.	        "',";
        // $actSQL.="cSi		        ='".$cSi.	        "',";
        // $actSQL.="cMn		        ='".$cMn.	        "',";
        // $actSQL.="cP		        ='".$cP.	        "',";
        // $actSQL.="cS		        ='".$cS.	        "',";
        // $actSQL.="cCr		        ='".$cCr.	        "',";
        // $actSQL.="cNi		        ='".$cNi.	        "',";
        //$actSQL.="cMo		        ='".$dato->cMo.	        "',";

        // $actSQL.="cMo		        ='".$cMo.	            "',";
        // $actSQL.="cAl		        ='".$cAl.	        "',";
        // $actSQL.="cCu		        ='".$cCu.	        "',";
        // $actSQL.="cCo		        ='".$cCo.	        "',";
        // $actSQL.="cTi		        ='".$cTi.	        "',";
        // $actSQL.="cNb		        ='".$cNb.	        "',";
        // $actSQL.="cV		        ='".$cV.	        "',";
        // $actSQL.="cB		        ='".$cB.	        "',";
        // $actSQL.="cW		        ='".$dato->cW.	        "',";
        // $actSQL.="cSn		        ='".$cSn.	        "',";
        // $actSQL.="cFe		        ='".$dato->cFe.	        "',";
        // $actSQL.="cZn               ='".$dato->cZn.         "',";
        // $actSQL.="cMg               ='".$dato->cMg.         "',";
        // $actSQL.="cPb               ='".$dato->cPb.         "',";
        // $actSQL.="cTe               ='".$dato->cTe.         "',";
        // $actSQL.="cAs               ='".$dato->cAs.         "',";
        // $actSQL.="cSb               ='".$dato->cSb.         "',"; 
        // $actSQL.="cCd               ='".$dato->cCd.         "',";
        // $actSQL.="cBi               ='".$dato->cBi.         "',";
        // $actSQL.="cAg               ='".$dato->cAg.         "',";
        // $actSQL.="cAi               ='".$dato->cAi.         "',";
        // $actSQL.="cZr               ='".$dato->cZr.         "',";
        // $actSQL.="cAu               ='".$dato->cAu.         "',";
        // $actSQL.="cSe               ='".$dato->cSe.         "'"; 

        $actSQL.="WHERE idItem	    = '$dato->idItem' and Programa = '$dato->Programa' and Rep = '$dato->Rep'";
        $bdCot=$link->query($actSQL);

        if($dato->tecRes != ''){
            $actSQL="UPDATE OTAMs SET ";
            $actSQL.="tecRes		='".$dato->tecRes.	"'";
            $actSQL.="WHERE Otam 	= '$dato->idItem'";
            $bdfRAM=$link->query($actSQL);
        }
        if($dato->Estado == 'R'){
            $actSQL="UPDATE OTAMs SET ";
            $actSQL.="Estado		='".$dato->Estado.	"'";
            $actSQL.="WHERE Otam 	= '$dato->idItem'";
            $bdfRAM=$link->query($actSQL);
        }

        
    }
    $link->close();

}


function validaValor($vDef, $vEle){
    if(substr($vDef,0,1) == '<'){
        $vDefp = substr($vDef,1);
        $vDefp = floatval(str_replace(',','.',$vDefp));
    }
    if(substr($vEle,0,1) == '<'){
        $vEle = substr($vEle,1);
        $vEle = floatval(str_replace(',','.',$vEle));
    }else{
        $vEle = floatval(str_replace(',','.',$vEle));
    }
    if($vEle < $vDefp){
        $vEle = $vDef;
    }
    return $vEle;
}


if($dato->accion == "cambiarEnsayoGraba"){
    $CodInforme = '';
    $link=Conectarse(); 

    $sql = "SELECT * FROM regquimico Where idItem = '$dato->idItem' and CodInforme = '$dato->CodInforme'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE regquimico SET ";
        $actSQL.="CodInforme		='".$CodInforme.	    "'";
        $actSQL.="WHERE idItem	    = '$dato->idItem' and CodInforme = '$dato->CodInforme'";
        $bdCot=$link->query($actSQL);
    }

    $sql = "SELECT * FROM regquimico Where idItem = '$dato->idItem' and Rep = '$dato->Rep' and Programa = '$dato->Programa'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE regquimico SET ";
        $actSQL.="CodInforme		='".$dato->CodInforme.	    "'";
        $actSQL.="WHERE idItem	    = '$dato->idItem' and Rep = '$dato->Rep' and Programa = '$dato->Programa'";
        $bdCot=$link->query($actSQL);
    }


    $link->close();
}

?>