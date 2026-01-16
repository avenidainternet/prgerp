<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include_once("../conexionli.php");



if($dato->accion == 'leerEspectometroPHP'){
    $data = file_get_contents("resultadosQu/vEspectrometro.json"); 
    $products = json_decode($data, true);
     
    foreach ($products as $product) {
        echo '<pre>';
        print_r($product);
        echo '</pre>';
    }
}

if($dato->accion == 'grabarDatosQu'){ 
    $link=Conectarse();
    $data = file_get_contents("resultadosQu/vEspectrometro.json"); 
    $products = json_decode($data, true);
    $records = $products['records'];

    foreach ($records as $index => $record) {

        $idItem     = $record['idItem'];
        $tpMuestra  = $record['tpMuestra'];

        $Estado     = 'R';
        $SQLot = "Select * From otams Where Otam = '$idItem' and tpMuestra = '$tpMuestra' and idEnsayo = 'Qu'";
        $bdot=$link->query($SQLot);
        if($rsot = mysqli_fetch_array($bdot)){
            $tpMuestra = $rsot['tpMuestra'];
            if($rsot['CodInforme']){
                $CodInforme = $rsot['CodInforme']; 
                $Estado = 'R';
            }
        }

        $actSQL="UPDATE otams SET ";
        $actSQL.="tecRes		    = '".$dato->tecRes.	            "',";
        $actSQL.="Estado		    = '".$Estado.	                 "'";
        $actSQL.="Where Otam 	    = '$idItem' and tpMuestra = '$tpMuestra' and idEnsayo = 'Qu'";
        $bdfRAM=$link->query($actSQL);
    
        $actSQL="UPDATE regquimico SET ";
        $actSQL.="fechaRegistro		= '".$dato->fechaRegistro.	    "',";
        $actSQL.="Temperatura		= '".$dato->Temperatura.	    "',";
        $actSQL.="Humedad		    = '".$dato->Humedad.	        "'";
        $actSQL.="Where idItem 	    = '$idItem'";
        $bdfRAM=$link->query($actSQL);

        // $fd = explode('-', $idItem);
        // $RAM = $fd[0];
        // header("Location: formularios/otamQuimicoEsprometro.php?accion=Imprimir&RAM=" . $RAM . "&Otam=" . $idItem . ");
    }
    $link->close();
}
if($dato->accion == 'grabarDatosQuOLD'){ 
    if($dato->Programa){
        $fp = explode('-',$dato->Programa); 
        if($fp[0] == 'Cu'){
            $tpMuestra = 'Co';
        }
        if($fp[0] == 'Al'){
            $tpMuestra = 'Al';
        }
        if($fp[0] == 'P1'){
            $tpMuestra = 'Ac';
        }
    }

    $CodInformeB = '';
    $SQL = "Select * From regquimico Where idItem = '$idItem' and CodInforme = '$CodInforme'";
    $bd=$link->query($SQL);
    if($rs = mysqli_fetch_array($bd)){
        // $bdEnc=$link->query("Delete From regquimico idItem = '$idItem'");

        $CodInforme = $rs['CodInforme'];
        $actSQL="UPDATE regquimico SET ";
        $actSQL.="CodInforme = '".$CodInformeB.	    "'";
        $actSQL.="Where idItem 	    = '$idItem'";
        $bdfRAM=$link->query($actSQL);
    }
    // $SQL = "Select * From regquimico Where idItem = '$idItem' and Programa = '$dato->Programa' and Rep = '$Rep'";
    $SQL = "Select * From regquimico Where idItem = '$idItem' and Programa = '$dato->Programa'";
    $bd=$link->query($SQL);
    if($rs = mysqli_fetch_array($bd)){
        $cC      = 0;
        $cSi     = 0;
        $cMn     = 0; 
        $cP      = 0;            
        $cS      = 0;            
        $cCr     = 0;
        $cMo     = 0;
        $cNi     = 0;
        $cAl     = 0;
        $cCo     = 0;
        $cCu     = 0;
        $cNb     = 0;
        $cTi     = 0;
        $cV      = 0;            
        $cW      = 0;            
        $cPb     = 0;
        $cSn     = 0;
        $cAs     = 0;
        $cZr     = 0;
        $cB      = 0;            
        $cZn     = 0;
        $cAg     = 0;

        $cBi     = 0;
        $cCa     = 0;
        $cCe     = 0;
        $cSb     = 0;
        $cSe     = 0;
        $cTe     = 0;
        $cTa     = 0;
        $cB      = 0;
        $cZn     = 0;
        $cAg     = 0;
        $cMg     = 0;
        $cBa     = 0;
        $cCd     = 0;
        $cGa     = 0;
        $cHg     = 0;
        $cIn     = 0;
        $cLa     = 0;
        $cNa     = 0;
        $cSr     = 0;
        $cTl     = 0;
        $cHf     = 0;
        $cSc     = 0;
        $cY      = 0;
        $cBg     = 0;
        $cN     = 0;

        $cFe     = 0;
        $cAu     = 0;

        // if(substr($dato->Programa,0,2) == 'Fe'){ 
        if($tpMuestra == 'Ac'){ 
            
            $tpMuestra  = 'Ac';
            $cFe        = 'Resto';
            $actSQL="UPDATE regquimico SET ";
            $actSQL.="CodInforme		= '".$CodInforme.	            "',";
            $actSQL.="fechaRegistro		= '".$dato->fechaRegistro.	    "',";
            $actSQL.="Rep		        = '".$Rep.	                    "',";
            $actSQL.="tpMuestra		    = '".$tpMuestra.	            "',";
            $actSQL.="Programa		    = '".$dato->Programa.	        "',";
            $actSQL.="Temperatura		= '".$dato->Temperatura.	    "',";
            $actSQL.="Humedad		    = '".$dato->Humedad.	        "',";
                       
            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'C'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cC = comparaValor($dato->cC, $rsd['valorDefecto']);
            }
            $actSQL.="cC		        = '".$cC.	                    "',";
            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Si'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cSi = comparaValor($dato->cSi, $rsd['valorDefecto']);
            }
            $actSQL.="cSi		        = '".$cSi.	                     "',";
            
            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Mn'");
            if($rsd=mysqli_fetch_array($bdd)){
                // $cMn		        = str_replace('.',',',decimales($dato->cMn));
                $cMn = comparaValor($dato->cMn, $rsd['valorDefecto']);
                // $cMn = $dato->cMn;

            }
            $actSQL.="cMn               = '".$cMn.	            "',";
            
            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'P'");
            if($rsd=mysqli_fetch_array($bdd)){
                // $cP		        = str_replace('.',',',decimales($dato->cP));
                $cP = comparaValor($dato->cP, $rsd['valorDefecto']);
                // $cP = $dato->cP;
            }
            $actSQL.="cP                = '".$cP.	            "',";
            
            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'S'");
            if($rsd=mysqli_fetch_array($bdd)){
                // $cS		        = str_replace('.',',',decimales($dato->cS));
                $cS = comparaValor($dato->cS, $rsd['valorDefecto']);
                // $cS = $dato->cS;
            }
            $actSQL.="cS                = '".$cS.	            "',";
            
            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Cr'");
            if($rsd=mysqli_fetch_array($bdd)){
                // $cCr		        = str_replace('.',',',decimales($dato->cCr));
                $cCr = comparaValor($dato->cCr, $rsd['valorDefecto']);
                // $cCr = $dato->cCr;
            }
            $actSQL.="cCr               = '".$cCr.	            "',";
                        
            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Mo'");
            if($rsd=mysqli_fetch_array($bdd)){
                // $cMo		        = str_replace('.',',',decimales($dato->cMo));
                $cMo = comparaValor($dato->cMo, $rsd['valorDefecto']);
                // $cMo = $dato->cMo;
            }
            $actSQL.="cMo               = '".$cMo.	            "',";
                        
            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Ni'");
            if($rsd=mysqli_fetch_array($bdd)){
                // $cNi		        = str_replace('.',',',decimales($dato->cNi));
                $cNi = comparaValor($dato->cNi, $rsd['valorDefecto']);
                // $cNi = $dato->cNi;
            }
            $actSQL.="cNi               = '".$cNi.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Al'");
            if($rsd=mysqli_fetch_array($bdd)){
                // $cAl		        = str_replace('.',',',decimales($dato->cAl));
                $cAl = comparaValor($dato->cAl, $rsd['valorDefecto']);
                // $cAl = $dato->cAl;

            }
            $actSQL.="cAl               = '".$cAl.	            "',";
            
            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Co'");
            if($rsd=mysqli_fetch_array($bdd)){
                // $cCo		        = str_replace('.',',',decimales($dato->cCo));
                $cCo = comparaValor($dato->cCo, $rsd['valorDefecto']);
                // $cCo = $dato->cCo;
            }
            $actSQL.="cCo               = '".$cCo.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Cu'");
            if($rsd=mysqli_fetch_array($bdd)){
                // $cCu		        = str_replace('.',',',decimales($dato->cCu));
                $cCu = comparaValor($dato->cCu, $rsd['valorDefecto']);
                // $cCu = $dato->cCu;
            }
            $actSQL.="cCu               = '".$cCu.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Nb'");
            if($rsd=mysqli_fetch_array($bdd)){
                // Cambio $cNb		        = str_replace('.',',',decimales($dato->cNb));
                $cNb = comparaValor($dato->cNb, $rsd['valorDefecto']);
                // $cNb = $dato->cNb;

            }
            $actSQL.="cNb               = '".$cNb.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Ti'");
            if($rsd=mysqli_fetch_array($bdd)){
                // $cTi		        = str_replace('.',',',decimales($dato->cTi));
                $cTi = comparaValor($dato->cTi, $rsd['valorDefecto']);
                // $cTi = $dato->cTi;
            }
            $actSQL.="cTi               = '".$cTi.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'V'");
            if($rsd=mysqli_fetch_array($bdd)){
                // $cV		        = str_replace('.',',',decimales($dato->cV));
                $cV = comparaValor($dato->cV, $rsd['valorDefecto']);
                // $cV = $dato->cV;
            }
            $actSQL.="cV                = '".$cV.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'W'");
            if($rsd=mysqli_fetch_array($bdd)){
                // $cW		        = str_replace('.',',',decimales($dato->cW));
                $cW = comparaValor($dato->cW, $rsd['valorDefecto']); 
                // $cW = $dato->cW; 
            }
            $actSQL.="cW                = '".$cW.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Pb'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cPb = comparaValor($dato->cPb, $rsd['valorDefecto']);
            }
            $actSQL.="cPb               = '".$cPb.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Sn'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cSn = comparaValor($dato->cSn, $rsd['valorDefecto']);
            }
            $actSQL.="cSn               = '".$cSn.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'As'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cAs = comparaValor($dato->cAs, $rsd['valorDefecto']);
            }
            $actSQL.="cAs               = '".$cAs.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Zr'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cZr = comparaValor($dato->cZr, $rsd['valorDefecto']);
            }
            $actSQL.="cZr               = '".$cZr.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Bi'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cBi = comparaValor($dato->cBi, $rsd['valorDefecto']);
            }
            $actSQL.="cBi               = '".$cBi.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Ca'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cCa = comparaValor($dato->cCa, $rsd['valorDefecto']);
            }
            $actSQL.="cCa               = '".$cCa.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Ce'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cCe = comparaValor($dato->cCe, $rsd['valorDefecto']);
            }
            $actSQL.="cCe               = '".$cCe.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Sb'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cSb = comparaValor($dato->cSb, $rsd['valorDefecto']);
            }
            $actSQL.="cSb               = '".$cSb.	            "',";
          
            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Se'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cSe = comparaValor($dato->cSe, $rsd['valorDefecto']);
            }
            $actSQL.="cSe               = '".$cSe.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Te'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cTe = comparaValor($dato->cTe, $rsd['valorDefecto']);
            }
            $actSQL.="cTe               = '".$cTe.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Ta'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cTa = comparaValor($dato->cTa, $rsd['valorDefecto']);
            }
            $actSQL.="cTa               = '".$cTa.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'B'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cB = comparaValor($dato->cB, $rsd['valorDefecto']);
            }            
            $actSQL.="cB                = '".$cB.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Zn'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cZn = comparaValor($dato->cZn, $rsd['valorDefecto']);
            }
            $actSQL.="cZn               = '".$cZn.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Ag'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cAg = comparaValor($dato->cAg, $rsd['valorDefecto']);
            }
            $actSQL.="cAg               = '".$cAg.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Mg'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cMg = comparaValor($dato->cMg, $rsd['valorDefecto']);
            }
            $actSQL.="cMg               = '".$cMg.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Ba'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cBa = comparaValor($dato->cBa, $rsd['valorDefecto']);
            }
            $actSQL.="cBa               = '".$cBa.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Cd'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cCd = comparaValor($dato->cCd, $rsd['valorDefecto']);
            }
            $actSQL.="cCd               = '".$cCd.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Ga'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cGa = comparaValor($dato->cGa, $rsd['valorDefecto']);
            }
            $actSQL.="cGa               = '".$cGa.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Hg'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cHg = comparaValor($dato->cHg, $rsd['valorDefecto']);
            }
            $actSQL.="cHg               = '".$cHg.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'In'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cIn = comparaValor($dato->cIn, $rsd['valorDefecto']);
            }
            $actSQL.="cIn               = '".$cIn.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'La'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cLa = comparaValor($dato->cLa, $rsd['valorDefecto']);
            }
            $actSQL.="cLa               = '".$cLa.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Na'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cNa = comparaValor($dato->cNa, $rsd['valorDefecto']);
            }
            $actSQL.="cNa               = '".$cNa.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Sn'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cSr = comparaValor($dato->cSr, $rsd['valorDefecto']);
            }
            $actSQL.="cSr               = '".$cSr.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Tl'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cTl = comparaValor($dato->cTl, $rsd['valorDefecto']);
            }
            $actSQL.="cTl               = '".$cTl.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Hf'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cHf = comparaValor($dato->cHf, $rsd['valorDefecto']);
            }
            $actSQL.="cHf               = '".$cHf.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Sc'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cSc = comparaValor($dato->cSc, $rsd['valorDefecto']);
            }
            $actSQL.="cSc               = '".$cSc.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Y'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cY = comparaValor($dato->cY, $rsd['valorDefecto']);
            }
            $actSQL.="cY               = '".$cY.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Bg'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cBg = comparaValor($dato->cBg, $rsd['valorDefecto']);
            }
            $actSQL.="cBg               = '".$cBg.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'N'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cN = comparaValor($dato->cN, $rsd['valorDefecto']);
            }
            $actSQL.="cN               = '".$cN.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Au' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cAu = comparaValor($dato->cAu, $rsd['valorDefecto']);
            }
            $actSQL.="cAu		        = '".$cAu.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Fe'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cFe = comparaValor($dato->cFe, $rsd['valorDefecto']);
            }
            $actSQL.="cFe               = '".$cFe.	            "'";

            $actSQL.="Where idItem 	    = '$idItem' and Programa = '$dato->Programa' and Rep = '$Rep'";
            $bdfRAM=$link->query($actSQL);
           
        }

        if(substr($dato->Programa,0,2) == 'Al'){ 
            $actSQL="UPDATE regquimico SET ";
            $actSQL.="CodInforme		= '".$CodInforme.	                                "',";
            $actSQL.="fechaRegistro		= '".$dato->fechaRegistro.	                        "',";
            $actSQL.="Rep		        = '".$Rep.	                                        "',";
            $actSQL.="Programa		    = '".$dato->Programa.	                            "',";
            $actSQL.="tpMuestra		    = '".$tpMuestra.	                                "',";        
            $actSQL.="Temperatura		= '".$dato->Temperatura.	                        "',";
            $actSQL.="Humedad		    = '".$dato->Humedad.	                            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'C' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cC = comparaValor($dato->cC, $rsd['valorDefecto']);
            }
            $actSQL.="cC		        = '".$cC.	                    "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Si' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cSi = comparaValor($dato->cSi, $rsd['valorDefecto']);
            }
            $actSQL.="cSi		        = '".$cSi.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Mn' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cMn = comparaValor($dato->cMn, $rsd['valorDefecto']);
            }
            $actSQL.="cMn		        = '".$cMn.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'P' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cP = comparaValor($dato->cP, $rsd['valorDefecto']);
            }
            $actSQL.="cP		        = '".$cP.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'S' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cS = comparaValor($dato->cS, $rsd['valorDefecto']);
            }
            $actSQL.="cS		        = '".$cS.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Cr' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cCr = comparaValor($dato->cCr, $rsd['valorDefecto']);
            }
            $actSQL.="cCr		        = '".$cCr.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Mo' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cMo = comparaValor($dato->cMo, $rsd['valorDefecto']);
            }
            $actSQL.="cMo		        = '".$cMo.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Ni' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cNi = comparaValor($dato->cNi, $rsd['valorDefecto']);
            }
            $actSQL.="cNi		        = '".$cNi.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Mo' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cMo = comparaValor($dato->cMo, $rsd['valorDefecto']);
            }
            $actSQL.="cMo		        = '".$cMo.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Al' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cAl = comparaValor($dato->cAl, $rsd['valorDefecto']);
            }
            $actSQL.="cAl		        = '".$cAl.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Co' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cCo = comparaValor($dato->cCo, $rsd['valorDefecto']);
            }
            $actSQL.="cCo		        = '".$cCo.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Cu' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cCu = comparaValor($dato->cCu, $rsd['valorDefecto']);
            }
            $actSQL.="cCu		        = '".$cCu.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Nb' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cNb = comparaValor($dato->cNb, $rsd['valorDefecto']);
            }
            $actSQL.="cNb		        = '".$cNb.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Ti' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cTi = comparaValor($dato->cTi, $rsd['valorDefecto']);
            }
            $actSQL.="cTi		        = '".$cTi.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'V' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cV = comparaValor($dato->cV, $rsd['valorDefecto']);
            }
            $actSQL.="cV		        = '".$cV.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'W' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cW = comparaValor($dato->cW, $rsd['valorDefecto']);
            }
            $actSQL.="cW		        = '".$cW.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Pb' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cPb = comparaValor($dato->cPb, $rsd['valorDefecto']);
            }
            $actSQL.="cPb		        = '".$cPb.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Sn' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cSn = comparaValor($dato->cSn, $rsd['valorDefecto']);
            }
            $actSQL.="cSn		        = '".$cSn.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'As' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cAs = comparaValor($dato->cAs, $rsd['valorDefecto']);
            }
            $actSQL.="cAs		        = '".$cAs.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Zr' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cZr = comparaValor($dato->cZr, $rsd['valorDefecto']);
            }
            $actSQL.="cZr		        = '".$cZr.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Bi' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cBi = comparaValor($dato->cBi, $rsd['valorDefecto']);
            }
            $actSQL.="cBi		        = '".$cBi.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Ca' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cCa = comparaValor($dato->cCa, $rsd['valorDefecto']);
            }
            $actSQL.="cCa		        = '".$cCa.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Ce' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cCe = comparaValor($dato->cCe, $rsd['valorDefecto']);
            }
            $actSQL.="cCe		        = '".$cCe.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Sb' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cSb = comparaValor($dato->cSb, $rsd['valorDefecto']);
            }
            $actSQL.="cSb		        = '".$cSb.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Se' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cSe = comparaValor($dato->cSe, $rsd['valorDefecto']);
            }
            $actSQL.="cSe		        = '".$cSe.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Te' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cTe = comparaValor($dato->cTe, $rsd['valorDefecto']);
            }
            $actSQL.="cTe		        = '".$cTe.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Ta' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cTa = comparaValor($dato->cTa, $rsd['valorDefecto']);
            }
            $actSQL.="cTa		        = '".$cTa.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'B' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cB = comparaValor($dato->cB, $rsd['valorDefecto']);
            }
            $actSQL.="cB		        = '".$cB.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Zn' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cZn = comparaValor($dato->cZn, $rsd['valorDefecto']);
            }
            $actSQL.="cZn		        = '".$cZn.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Ag' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cAg = comparaValor($dato->cAg, $rsd['valorDefecto']);
            }
            $actSQL.="cAg		        = '".$cAg.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Mg' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cMg = comparaValor($dato->cMg, $rsd['valorDefecto']);
            }
            $actSQL.="cMg		        = '".$cMg.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Ba' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cBa = comparaValor($dato->cBa, $rsd['valorDefecto']);
            }
            $actSQL.="cBa		        = '".$cBa.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Cd' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cCd = comparaValor($dato->cCd, $rsd['valorDefecto']);
            }
            $actSQL.="cCd		        = '".$cCd.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Ga' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cGa = comparaValor($dato->cGa, $rsd['valorDefecto']);
            }
            $actSQL.="cGa		        = '".$cGa.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Hg' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cHg = comparaValor($dato->cHg, $rsd['valorDefecto']);
            }
            $actSQL.="cHg		        = '".$cHg.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'In' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cIn = comparaValor($dato->cIn, $rsd['valorDefecto']);
            }
            $actSQL.="cIn		        = '".$cIn.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'La' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cLa = comparaValor($dato->cLa, $rsd['valorDefecto']);
            }
            $actSQL.="cLa		        = '".$cLa.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Na' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cNa = comparaValor($dato->cNa, $rsd['valorDefecto']);
            }
            $actSQL.="cNa		        = '".$cNa.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Sr' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cSr = comparaValor($dato->cSr, $rsd['valorDefecto']);
            }
            $actSQL.="cSr		        = '".$cSr.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Tl' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cTl = comparaValor($dato->cTl, $rsd['valorDefecto']);
            }
            $actSQL.="cTl		        = '".$cTl.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Hf' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cHf = comparaValor($dato->cHf, $rsd['valorDefecto']);
            }
            $actSQL.="cHf		        = '".$cHf.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Sc' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cSc = comparaValor($dato->cSc, $rsd['valorDefecto']);
            }
            $actSQL.="cSc		        = '".$cSc.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Y' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cY = comparaValor($dato->cY, $rsd['valorDefecto']);
            }
            $actSQL.="cY		        = '".$cY.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Bg' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cBg = comparaValor($dato->cBg, $rsd['valorDefecto']);
            }
            $actSQL.="cBg		        = '".$cBg.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'N' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cN = comparaValor($dato->cN, $rsd['valorDefecto']);
            }
            $actSQL.="cN		        = '".$cN.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Au' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cAu = comparaValor($dato->cAu, $rsd['valorDefecto']);
            }
            $actSQL.="cAu		        = '".$cAu.	            "',";

            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Fe' and imprimible = 'on'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cFe = comparaValor($dato->cFe, $rsd['valorDefecto']);
            }
            $actSQL.="cFe		        = '".$cFe.	            "'";
                       
            $actSQL.="Where idItem 	    = '$idItem' and Programa = '$dato->Programa' and Rep = '$Rep'";
            $bdfRAM=$link->query($actSQL);
        }
        if(substr($dato->Programa,0,2) == 'Co'){ 
            $actSQL="UPDATE regquimico SET ";
            $actSQL.="CodInforme		= '".$CodInforme.	                                "',";
            $actSQL.="fechaRegistro		= '".$dato->fechaRegistro.	                        "',";
            $actSQL.="Rep		        = '".$Rep.	                                        "',";
            $actSQL.="Programa		    = '".$dato->Programa.	                            "',";
            $actSQL.="tpMuestra		    = '".$tpMuestra.	                                "',";        
            $actSQL.="Temperatura		= '".$dato->Temperatura.	                        "',";
            $actSQL.="Humedad		    = '".$dato->Humedad.	                            "',";

            $actSQL.="cC		        = '".str_replace('.',',',$dato->cC).	            "',";
            $actSQL.="cSi		        = '".str_replace('.',',',$dato->cSi).	            "',";
            $actSQL.="cMn               = '".str_replace('.',',',$dato->cMn).	            "',";
            $actSQL.="cP                = '".str_replace('.',',',$dato->cP).	            "',";
            $actSQL.="cS                = '".str_replace('.',',',$dato->cS).	            "',";
            $actSQL.="cCr               = '".str_replace('.',',',$dato->cCr).	            "',";
            $actSQL.="cMo               = '".str_replace('.',',',$dato->cMo).	            "',";
            $actSQL.="cNi               = '".str_replace('.',',',$dato->cNi).	            "',";
            $actSQL.="cAl               = '".str_replace('.',',',$dato->cAl).	            "',";
            $actSQL.="cCo               = '".str_replace('.',',',$dato->cCo).	            "',";
            $actSQL.="cCu               = '".str_replace('.',',',$dato->cCu).	            "',";
            $actSQL.="cNb               = '".str_replace('.',',',$dato->cNb).	            "',";
            $actSQL.="cTi               = '".str_replace('.',',',$dato->cTi).	            "',";
            $actSQL.="cV                = '".str_replace('.',',',$dato->cV).	            "',";
            $actSQL.="cW                = '".str_replace('.',',',$dato->cW).	            "',";
            $actSQL.="cPb               = '".str_replace('.',',',$dato->cPb).	            "',";
            $actSQL.="cSn               = '".str_replace('.',',',$dato->cSn).	            "',";
            $actSQL.="cAs               = '".str_replace('.',',',$dato->cAs).	            "',";
            $actSQL.="cZr               = '".str_replace('.',',',$dato->cZr).	            "',";
            $actSQL.="cBi               = '".str_replace('.',',',$dato->cBi).	            "',";
            $actSQL.="cCa               = '".str_replace('.',',',$dato->cCa).	            "',";
            $actSQL.="cCe               = '".str_replace('.',',',$dato->cCe).	            "',";
            $actSQL.="cSb               = '".str_replace('.',',',$dato->cSb).	            "',"; 
            $actSQL.="cSe               = '".str_replace('.',',',$dato->cSe).	            "',";
            $actSQL.="cTe               = '".str_replace('.',',',$dato->cTe).	            "',";
            $actSQL.="cTa               = '".str_replace('.',',',$dato->cTa).	            "',";
            $actSQL.="cB                = '".str_replace('.',',',$dato->cB).	            "',";
            $actSQL.="cZn               = '".str_replace('.',',',$dato->cZn).	            "',";
            $actSQL.="cAg               = '".str_replace('.',',',$dato->cAg).	            "',";
            $actSQL.="cMg               = '".str_replace('.',',',$dato->cMg).	            "',";
            $actSQL.="cBa               = '".str_replace('.',',',$dato->cBa).	            "',";
            $actSQL.="cCd               = '".str_replace('.',',',$dato->cCd).	            "',";
            $actSQL.="cGa               = '".str_replace('.',',',$dato->cGa).	            "',";
            $actSQL.="cHg               = '".str_replace('.',',',$dato->cHg).	            "',";
            $actSQL.="cIn               = '".str_replace('.',',',$dato->cIn).	            "',";
            $actSQL.="cLa               = '".str_replace('.',',',$dato->cLa).	            "',";
            $actSQL.="cNa               = '".str_replace('.',',',$dato->cNa).	            "',";
            $actSQL.="cSr               = '".str_replace('.',',',$dato->cSr).	            "',";
            $actSQL.="cTl               = '".str_replace('.',',',$dato->cTl).	            "',";
            $actSQL.="cHf               = '".str_replace('.',',',$dato->cHf).	            "',";
            $actSQL.="cSc               = '".str_replace('.',',',$dato->cSc).	            "',";
            $actSQL.="cBi               = '".str_replace('.',',',$dato->cBi).	            "',";
            $actSQL.="cY                = '".str_replace('.',',',$dato->cY).	            "',";
            $actSQL.="cBg               = '".str_replace('.',',',$dato->cBg).	            "',";
            $actSQL.="cN                = '".str_replace('.',',',$dato->cN).	            "',";
            $actSQL.="cAu               = '".str_replace('.',',',$dato->cAu).	            "',";
            $actSQL.="cFe               = '".str_replace('.',',',$dato->cFe).	            "'";
                        
            $actSQL.="Where idItem 	    = '$idItem' and Programa = '$dato->Programa' and Rep = '$Rep'";
            $bdfRAM=$link->query($actSQL);
        }
    }else{     
        $cC      = 0;
        $cSi     = 0;
        $cMn     = 0; 
        $cP      = 0;            
        $cS      = 0;            
        $cCr     = 0;
        $cNi     = 0;
        $cMo     = 0;
        $cAl     = 0;
        $cCu     = 0;
        $cCo     = 0;
        $cTi     = 0;
        $cNb     = 0;
        $cV      = 0;            
        $cW      = 0;            
        $cB      = 0;            
        $cZn     = 0;
        $cPb     = 0;
        $cSn     = 0;
        $cFe     = 'Resto';
        $cTe     = 0;
        $cAs     = 0;
        $cSb     = 0;
        $cCd     = 0;
        $cBi     = 0;
        $cAg     = 0;
        $cZr     = 0;
        $cAu     = 0;
        $cSe     = 0;
        $cMg     = 0;
        if(substr($dato->Programa,0,2) == 'Fe'){ 
            $tpMuestra = 'Ac';


            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'C'");
            if($rsd=mysqli_fetch_array($bdd)){
                $cC		        = str_replace('.',',',decimales($dato->cC));
                // $cC = comparaValor($dato->cC, $rsd['valorDefecto']);

            }
            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Si'");
            if($rsd=mysqli_fetch_array($bdd)){
                //$cSi = comparaValor($dato->cSi, $rsd['valorDefecto']);
                $cSi		        = str_replace('.',',',decimales($dato->cSi));

            }
            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Mn'");
            if($rsd=mysqli_fetch_array($bdd)){
                //$cMn = comparaValor($dato->cMn, $rsd['valorDefecto']);
                $cMn		        = str_replace('.',',',decimales($dato->cMn));

            }
            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'P'");
            if($rsd=mysqli_fetch_array($bdd)){
                //$cP = comparaValor($dato->cP, $rsd['valorDefecto']);
                $cP		        = str_replace('.',',',decimales($dato->cP));

            }
            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'S'");
            if($rsd=mysqli_fetch_array($bdd)){
                //$cS = comparaValor($dato->cS, $rsd['valorDefecto']);
                $cS		        = str_replace('.',',',decimales($dato->cS));

            }
            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Cr'");
            if($rsd=mysqli_fetch_array($bdd)){
                //$cCr = comparaValor($dato->cCr, $rsd['valorDefecto']);
                $cCr		        = str_replace('.',',',decimales($dato->cCr));

            }
            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Ni'");
            if($rsd=mysqli_fetch_array($bdd)){
                //$cNi = comparaValor($dato->cNi, $rsd['valorDefecto']);
                $cNi		        = str_replace('.',',',decimales($dato->cNi));

            }
            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Mo'");
            if($rsd=mysqli_fetch_array($bdd)){
                //$cMo = comparaValor($dato->cMo, $rsd['valorDefecto']);
                $cMo		        = str_replace('.',',',decimales($dato->cMo));

            }
            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Al'");
            if($rsd=mysqli_fetch_array($bdd)){
                //$cAl = comparaValor($dato->cAl, $rsd['valorDefecto']);
                $cAl		        = str_replace('.',',',decimales($dato->cAl));

            }
            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Cu'");
            if($rsd=mysqli_fetch_array($bdd)){
                //$cCu = comparaValor($dato->cCu, $rsd['valorDefecto']);
                $cCu		        = str_replace('.',',',decimales($dato->cCu));

            }
            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Co'");
            if($rsd=mysqli_fetch_array($bdd)){
                //$cCo = comparaValor($dato->cCo, $rsd['valorDefecto']);
                $cCo		        = str_replace('.',',',decimales($dato->cCo));

            }
            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Ti'");
            if($rsd=mysqli_fetch_array($bdd)){
                //$cTi = comparaValor($dato->cTi, $rsd['valorDefecto']);
                $cTi		        = str_replace('.',',',decimales($dato->cTi));

            }
            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Nb'");
            if($rsd=mysqli_fetch_array($bdd)){
                //$cNb = comparaValor($dato->cNb, $rsd['valorDefecto']);
                $cNb		        = str_replace('.',',',decimales($dato->cNb));

            }
            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'V'");
            if($rsd=mysqli_fetch_array($bdd)){
                //$cV = comparaValor($dato->cV, $rsd['valorDefecto']);
                $cV		        = str_replace('.',',',decimales($dato->cV));

            }
            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'W'");
            if($rsd=mysqli_fetch_array($bdd)){
                //$cW = comparaValor($dato->cW, $rsd['valorDefecto']);
                $cW		        = str_replace('.',',',decimales($dato->cW));

            }
            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'B'");
            if($rsd=mysqli_fetch_array($bdd)){
                //$cB = comparaValor($dato->cB, $rsd['valorDefecto']);
                $cB		        = str_replace('.',',',decimales($dato->cB));

            }

            $link->query("insert into regquimico(
                CodInforme              ,
                idItem                  ,
                Rep                     ,
                Programa                ,
                fechaRegistro           ,
                tpMuestra               ,
                Temperatura             ,
                Humedad                 ,
                cC                      ,
                cSi                     ,
                cMn                     ,
                cP                      ,
                cS                      ,
                cCr                     ,
                cNi                     ,
                cMo                     ,
                cAl                     ,
                cCu                     ,
                cCo                     ,
                cTi                     ,
                cNb                     ,
                cV                      ,
                cW                      ,
                cB                      ,
                cZn                     ,
                cPb                     ,
                cSn                     ,
                cFe                     ,
                cTe                     ,
                cAs                     ,
                cSb                     ,
                cCd                     ,
                cBi                     ,
                cAg                     ,
                cZr                     ,
                cAu                     ,
                cSe                     ,
                cMg
                ) 
            values 	(	
                '$CodInforme'           ,
                '$idItem'               ,
                '$Rep'                  ,
                '$dato->Programa'       ,
                '$dato->fechaRegistro'  ,
                '$tpMuestra'            ,
                '$dato->Temperatura'    ,
                '$dato->Humedad'        ,
                '$cC'                   ,
                '$cSi'                  ,
                '$cMn'                  ,
                '$cP'                   ,
                '$cS'                   ,
                '$cCr'                  ,
                '$cNi'                  ,
                '$cMo'                  ,
                '$cAl'                  ,
                '$cCu'                  ,
                '$cCo'                  ,
                '$cTi'                  ,
                '$cNb'                  ,
                '$cV'                   ,
                '$cW'                   ,
                '$cB'                   ,
                '$cZn'                  ,
                '$cPb'                  ,
                '$cSn'                  ,
                '$cFe'                  ,
                '$cTe'                  ,
                '$cAs'                  ,
                '$cSb'                  ,
                '$cCd'                  ,
                '$cBi'                  ,
                '$cAg'                  ,
                '$cZr'                  ,
                '$cAu'                  ,
                '$cSe'                  ,
                '$cMg'
            )");
            

        }else{
            
            $cC      = str_replace('.',',',$dato->cC);
            $cSi     = str_replace('.',',',$dato->cSi);
            //$cSi     = str_replace('.',',','0.51');
            $cMn     = str_replace('.',',',$dato->cMn);
            $cP      = str_replace('.',',',$dato->cP);
            $cS      = str_replace('.',',',$dato->cS);
            $cCr     = str_replace('.',',',$dato->cCr);
            $cNi     = str_replace('.',',',$dato->cNi);
            $cMo     = str_replace('.',',',$dato->cMo);
            $cAl     = str_replace('.',',',$dato->cAl);
            $cCu     = str_replace('.',',',$dato->cCu);
            $cCo     = str_replace('.',',',$dato->cCo);
            $cTi     = str_replace('.',',',$dato->cTi);
            $cNb     = str_replace('.',',',$dato->cNb);
            $cV      = str_replace('.',',',$dato->cV);
            $cW      = str_replace('.',',',$dato->cW);
            $cB      = str_replace('.',',',$dato->cB);
            $cZn     = str_replace('.',',',$dato->cZn);
            $cPb     = str_replace('.',',',$dato->cPb);
            $cSn     = str_replace('.',',',$dato->cSn);
            $cFe     = str_replace('.',',',$dato->cFe);
            $cAs     = str_replace('.',',',$dato->cAs);
            $cSb     = str_replace('.',',',$dato->cSb);
            $cCd     = str_replace('.',',',$dato->cCb);
            $cBi     = str_replace('.',',',$dato->cBi);
            $cAg     = str_replace('.',',',$dato->cAg);
            $cZr     = str_replace('.',',',$dato->cZr);
            $cAu     = str_replace('.',',',$dato->cAu);
            $cSe     = str_replace('.',',',$dato->cSe);
            $cMg     = str_replace('.',',',$dato->cMg);

            $link->query("insert into regquimico(
                                                    CodInforme              ,
                                                    idItem                  ,
                                                    Rep                     ,
                                                    Programa                ,
                                                    fechaRegistro           ,
                                                    tpMuestra               ,
                                                    Temperatura             ,
                                                    Humedad                 ,
                                                    cC                      ,
                                                    cSi                     ,
                                                    cMn                     ,
                                                    cP                      ,
                                                    cS                      ,
                                                    cCr                     ,
                                                    cNi                     ,
                                                    cMo                     ,
                                                    cAl                     ,
                                                    cCu                     ,
                                                    cCo                     ,
                                                    cTi                     ,
                                                    cNb                     ,
                                                    cV                      ,
                                                    cW                      ,
                                                    cB                      ,
                                                    cZn                     ,
                                                    cPb                     ,
                                                    cSn                     ,
                                                    cFe                     ,
                                                    cTe                     ,
                                                    cAs                     ,
                                                    cSb                     ,
                                                    cCd                     ,
                                                    cBi                     ,
                                                    cAg                     ,
                                                    cZr                     ,
                                                    cAu                     ,
                                                    cSe                     ,
                                                    cMg
                                                ) 
                                        values 	(	
                                                    '$CodInforme'           ,
                                                    '$idItem'               ,
                                                    '$Rep'                  ,
                                                    '$dato->Programa'       ,
                                                    '$dato->fechaRegistro'  ,
                                                    '$tpMuestra'            ,
                                                    '$dato->Temperatura'    ,
                                                    '$dato->Humedad'        ,
                                                    '$cC'                   ,
                                                    '$cSi'                  ,
                                                    '$cMn'                  ,
                                                    '$cP'                   ,
                                                    '$cS'                   ,
                                                    '$cCr'                  ,
                                                    '$cNi'                  ,
                                                    '$cMo'                  ,
                                                    '$cAl'                  ,
                                                    '$cCu'                  ,
                                                    '$cCo'                  ,
                                                    '$cTi'                  ,
                                                    '$cNb'                  ,
                                                    '$cV'                   ,
                                                    '$cW'                   ,
                                                    '$cB'                   ,
                                                    '$cZn'                  ,
                                                    '$cPb'                  ,
                                                    '$cSn'                  ,
                                                    '$cFe'                  ,
                                                    '$cTe'                  ,
                                                    '$cAs'                  ,
                                                    '$cSb'                  ,
                                                    '$cCd'                  ,
                                                    '$cBi'                  ,
                                                    '$cAg'                  ,
                                                    '$cZr'                  ,
                                                    '$cAu'                  ,
                                                    '$cSe'                  ,
                                                    '$cMg'
            )");
            
        }    
    }

    $actSQL="UPDATE otams SET ";
    $actSQL.="tecRes		= '".$dato->tecRes.	    "',";
    $actSQL.="tpMuestra		= '".$tpMuestra.	    "'";
    $actSQL.="Where Otam 	    = '$idItem'";
    $bdfRAM=$link->query($actSQL);

    $link->close();
} 

if($dato->accion == 'actualizarTablaEnsayos'){
    $link=Conectarse();
    $outp   = '';
    $SQL = "Select * From tablaorientacion Where idItem like '%$dato->RAM%' and Seleccionado = '' Order By idItem Asc";
    $bd=$link->query($SQL);
    while($rs = mysqli_fetch_array($bd)){     
        if ($outp != "") {$outp .= ",";}
        $outp .= '{"idItem":"'          . $rs['idItem']. 		            '",';
        $outp .= '"pdfOrientacion":"'   . $rs['pdfOrientacion']. 	        '"}';
    }
    $outp ='{"records":['.$outp.']}';
    echo ($outp);
    $link->close();

}

if($dato->accion == 'mostrarEnsayosSeleccionados'){
    $link=Conectarse();
    $outp   = '';
    $SQL = "Select * From tablaorientacion Where idItem like '%$dato->RAM%' and Seleccionado = 'on' Order By idItem Asc";
    $bd=$link->query($SQL);
    while($rs = mysqli_fetch_array($bd)){     
        if ($outp != "") {$outp .= ",";}
        $outp .= '{"idItem":"'          . $rs['idItem']. 		            '",';
        $outp .= '"pdfOrientacion":"'   . $rs['pdfOrientacion']. 	        '"}';
    }
    $outp ='{"records":['.$outp.']}';
    echo ($outp);
    $link->close();

}

if($dato->accion == 'mostrarEnsayos'){
    $link=Conectarse();
    $outp   = '';
    $SQL = "Select * From tablaorientacion Where idItem like '%$dato->RAM%' Order By idItem Asc";
    $bd=$link->query($SQL);
    while($rs = mysqli_fetch_array($bd)){     
        if ($outp != "") {$outp .= ",";}
        $outp .= '{"idItem":"'          . $rs['idItem']. 		            '",';
        $outp .= '"pdfOrientacion":"'   . $rs['pdfOrientacion']. 	        '"}';
    }
    $outp ='{"records":['.$outp.']}';
    echo ($outp);
    $link->close();

}

if($dato->accion == 'cargarRamsEspectometro'){

    $link=Conectarse();
    $RAMold     = '';
    $outp       = '';
    $cEnsayos   = 0;
    $cEnsayosP  = 0;
    $SQL = "Select * From tablaorientacion Where pdfOrientacion = '' Order By idItem Asc";
    $bd=$link->query($SQL);
    while($rs = mysqli_fetch_array($bd)){
             
        $id = explode('-', $rs['idItem']);
        $RAM = $id[0];
        $cEnsayos++;
        if($rs['pdfOrientacion'] == ''){
            $cEnsayosP++;
        }
        if($RAMold != $RAM){
            if ($outp != "") {$outp .= ",";}
            $outp .= '{"RAM":"'             . $RAM. 		            '",';
            //$outp .= '"cEnsayos":"'         . $cEnsayos. 		        '",';
            //$outp .= '"cEnsayosP":"'        . $cEnsayosP. 		        '",';
            $outp .= '"pdfOrientacion":"'   . $rs['pdfOrientacion']. 	'"}';
            $RAMold = $RAM;
            $cEnsayos = 0;
            $cEnsayosP = 0;
        }
    
    }
    
    $outp ='{"records":['.$outp.']}';
    echo ($outp);
    $link->close();
}


// Aqui esta el Problema REVISAR
if($dato->accion == 'cargarTablaOrientacionnnnn'){
    $idItem     = $dato->idItem;
    $fd         = explode('-', $idItem);
    
    if(sizeof($fd) > 3){
        $idItem = $fi[0].'-'.$fi[1].'-'.$fi[2];
    }

    $link=Conectarse();
    $pdfOrientacion = '';
    $SQL = "Select * From tablaorientacion Where idItem = '$idItem'";
    $bd=$link->query($SQL);
    if($rs = mysqli_fetch_array($bd)){
    }else{
        $link->query("insert tablaorientacion (
            idItem                  ,
            pdfOrientacion
            ) 
        values 	(	
            '$idItem'         ,
            '$pdfOrientacion'
        )");

    }
    $link->close();

}

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
        $aIni 	= number_format($aIni, 2, '.', ',');
        
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
            $aIni 	= number_format($aIni, 2, '.', ',');
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
            $rAre 	= number_format($rAre, 2, '.', ',');

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

    $actSQL="UPDATE otams SET ";
    $actSQL.="tecRes		='".$dato->tecRes.	"'";
    $actSQL.="WHERE Otam 	= '".$dato->Otam.   "'";
    $bdfRAM=$link->query($actSQL);

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

if($dato->accion == 'quitarEnsayo'){
    $Seleccionado = '';
    $link=Conectarse();
    $actSQL="UPDATE tablaorientacion SET ";
    $actSQL.="Seleccionado	= '".$Seleccionado.	"'";
    $actSQL.="WHERE idItem 	= '".$dato->idItem.   "'";
    $bdfRAM=$link->query($actSQL);
    $link->close();
}

if($dato->accion == 'SelecionarEnsayo'){
    $Seleccionado = 'on';
    $link=Conectarse();
    $actSQL="UPDATE tablaorientacion SET ";
    $actSQL.="Seleccionado	= '".$Seleccionado.	"'";
    $actSQL.="WHERE idItem 	= '".$dato->idItem.   "'";
    $bdfRAM=$link->query($actSQL);
    $link->close();
}

if($dato->accion == 'LeerTraccion'){
    $link=Conectarse();
    $res = '';
	$SQL = "Select * From regtraccion Where idItem = '$dato->Otam'";
    $bd=$link->query($SQL);
    if($rs = mysqli_fetch_array($bd)){
        $tecRes = '';
        $SQLo = "Select * From otams Where Otam = '$dato->Otam'"; 
        $bdo=$link->query($SQLo);
        if($rso = mysqli_fetch_array($bdo)){
            $tecRes =  $rso["tecRes"];
        }
		$res.= '{"CodInforme":"'.			$rs["CodInforme"].				'",';
		$res.= '"tecRes":"'.			    $tecRes.				        '",';
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
		$res.= '"aSob":"'.			        $rs["aSob"].		             '",';
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
if($dato->accion == 'LeerOtams'){
    $link=Conectarse();
    $res = '';
	$SQL = "Select * From otams Where Otam = '$dato->Otam'";
    $bd=$link->query($SQL);
    if($rs = mysqli_fetch_array($bd)){
        $Muestra = 'Muestra';
        $SQLm = "SELECT * FROM amtpsmuestras Where idEnsayo = '".$rs['idEnsayo']."' and tpMuestra = '".$rs['tpMuestra']."'";
        $bdm=$link->query($SQLm);
        if($rsm=mysqli_fetch_array($bdm)){
            $Muestra = $rsm['Muestra'];
        }
        if($rs['idEnsayo'] == 'Do'){
            $CodInforme = $rs['CodInforme'];
            $Otam       = $rs['Otam'];
            $tpMuestra  = $rs['tpMuestra'];
            $SQLr = "SELECT * FROM regdobladosreal Where idItem = '".$rs['Otam']."'";
            $bdr=$link->query($SQLr);
            if($rsr=mysqli_fetch_array($bdr)){
            }else{
                $link->query("insert into regdobladosreal (
                    CodInforme,
                    idItem,
                    tpMuestra
                    ) 
            values 	(	
                    '$CodInforme',
                    '$Otam',
                    '$tpMuestra'
                    )");

            }
        }
        if($rs['idEnsayo'] == 'Tr'){
            $CodInforme = $rs['CodInforme'];
            $Otam       = $rs['Otam'];
            $tpMuestra  = $rs['tpMuestra'];
            $SQLr = "SELECT * FROM regtraccion Where idItem = '".$rs['Otam']."'";
            $bdr=$link->query($SQLr);
            if($rsr=mysqli_fetch_array($bdr)){
            }else{
                $link->query("insert into regtraccion (
                    CodInforme,
                    idItem,
                    tpMuestra
                    ) 
            values 	(	
                    '$CodInforme',
                    '$Otam',
                    '$tpMuestra'
                    )");

            }
        }

        /*
        $aIni = 100;
        $SQLt = "Select * From regtraccion Where idItem = '$dato->Otam'";
        $bdt=$link->query($SQLt);
        if($rst = mysqli_fetch_array($bdt)){
            $aIni= $rst['aIni'];
        }
    */
		$res.= '{"CodInforme":"'.			$rs["CodInforme"].				'",';
		$res.= '"CAM":"'.			        $rs["CAM"].				        '",';
		$res.= '"tpMuestra":"'.			    $rs["tpMuestra"].		        '",';
		$res.= '"tecRes":"'.			    $rs["tecRes"].		            '",';
		//$res.= '"aIni":"'.			        $aIni.		            '",';
		$res.= '"Muestra":"'.			    $Muestra.		                '",';
        $res.= '"RAM":"'. 				    $rs["RAM"]. 				    '"}';
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

if($dato->accion == 'Operadores'){
    $link=Conectarse();
    $outp = "";
	$SQL = "Select * From Operadores Order By nOperador";
    $bd=$link->query($SQL);
    while($rs = mysqli_fetch_array($bd)){
		if ($outp != "") {$outp .= ",";}
		$outp .= '{"nOperador":"'  . 		$rs["nOperador"]. 		'",';
	    $outp .= '"tecRes":"'. 			    $rs["tecRes"]. 			'"}';
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);
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




function decimales($v){
    $valor = $v;

    if(substr($v,0,1) == '<'){
        $valor = substr($v,1);
    }
    
    $decimales = $valor;
    if($valor > 0){
        $decimales = $valor - intval($valor);
    }
    if(strlen(strval($decimales)) == 3){
        $valor = number_format($valor, 2, ',', '.');
    }
    if(substr($v,0,1) == '<'){
        $valor = '<'.$valor;
    }
    return $valor;
}

function comparaValor($vExcel, $vDefecto){
    $resultado      = '';
    $vDefectoBd     = $vDefecto;
    $vExcelOrigen   = $vExcel;

    $vDec       = 0;
    $vDef       = '';
    $iConteo    = 'No';

    for($i = 0; $i < strlen($vDefecto); $i++){
        if(substr($vDefecto, $i, 1) != '<'){
            if(substr($vDefecto, $i, 1) == ',' or substr($vDefecto, $i, 1) == '.'){
                $vDef .= '.';
                $vDec = 0;
            }else{
                $vDef .= substr($vDefecto, $i, 1);
                if(intval(substr($vDefecto, $i, 1)) >= 0){
                    $vDec++;
                }
            }
        }
    }

    $vExe = '';
    for($i = 0; $i < strlen($vExcel); $i++){
        if(substr($vExcel, $i, 1) != '<'){
            if(substr($vExcel, $i, 1) == ',' or substr($vExcel, $i, 1) == '.'){
                $vExe .= '.';
            }else{
                $vExe .= substr($vExcel, $i, 1);
            }
        }
    }

    if($vExe > $vDef){
        $vExe = number_format($vExe, $vDec, '.', ',');
        if(substr($vExcel, 0, 1) == '<'){
            $vExe = '<'.number_format($vExe, $vDec, '.', ',');
        }
        // $fd = explode('.', $vExe);
        // if(strval($fd[1]) < $vDec){
        //     $vExe .= '0';
        // }
        $resultado = $vExe;

    }else{
        if($vExe == $vDef){
            $vDef = number_format($vExe, $vDec, '.', ',');
        }else{
            $vDef = number_format($vDef, $vDec, '.', ',');
            if(substr($vDefecto, 0, 1) == '<'){
                $vDef = '<'.number_format($vDef, $vDec, '.', ',');
            }
        }

        $resultado = $vDef;

    }


    /*
    if(substr($vExcel,0,1) == '<'){
        $vExcel = substr($vExcel,1);
        if($vExcel > 0){ 
            $vExcel = number_format($vExcel, 2, ',', '.');
        }
    }else{
        //$vExcel = number_format($vExcel, 2, ',', '.');
        $vExcel = str_replace('.',',',$vExcel);
    }
    $vDefecto = substr($vDefecto,1);
    if($vExcel == $vDefecto){
         $resultado = $vExcelOrigen;
     }
     if($vExcel < $vDefecto){
         $resultado = $vDefectoBd;
     }
     if($vExcel > $vDefecto){
         $resultado = $vExcelOrigen;
     }
     $resultado     = str_replace('.',',',$resultado);
    */
     //$resultado = $vExe;
     return $resultado;
 }
 

?>