<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php"); 

if($dato->accion == 'leerData'){
    $outp = '';
    $link=Conectarse();
    $bd=$link->query("SELECT * FROM aminformes Where CodInforme = '$dato->CodInforme'");
    if($rs=mysqli_fetch_array($bd)){
        if ($outp != "") {$outp .= ",";}
        $outp .= '{"CodInforme":"'  		. $rs["CodInforme"] 		. '",'; 
        $outp .= '"RutCli":"'  		        . $rs["RutCli"] 	        . '",';
        $outp .= '"ingResponsable":"'  		. $rs["ingResponsable"] 	. '",';
        $outp .= '"cooResponsable":"'  		. $rs["cooResponsable"] 	. '",';
        $outp .= '"CodigoVerificacion":"' 	. $rs["CodigoVerificacion"] . '",';
        $outp .= '"imgQR":"' 				. $rs["imgQR"] 				. '",'; 
        $outp .= '"imgMuestra":"' 			. $rs["imgMuestra"] 		. '",'; 
        $outp .= '"fechaRecepcion":"' 		. $rs["fechaRecepcion"] 	. '",'; 
        $outp .= '"fechaInforme":"' 		. $rs["fechaInforme"] 	    . '",'; 
        $outp .= '"nMuestras":"' 		    . $rs["nMuestras"] 	        . '",'; 
        $outp .= '"tpEnsayo":"' 		    . $rs["tpEnsayo"] 	        . '",'; 
        $outp .= '"amEnsayo":"' 		    . $rs["amEnsayo"] 	        . '",'; 
        $outp .= '"Titulo":"' 		        . $rs["Titulo"] 	        . '",'; 
        $outp .= '"palsClaves":"' 		    . $rs["palsClaves"] 	    . '",'; 
        $outp .= '"Objetivos":"' 		    . $rs["Objetivos"] 	        . '",'; 
        $outp .= '"Metodologia":"' 		    . $rs["Metodologia"] 	    . '",'; 
        $outp .= '"Comentarios":"' 		    . $rs["Comentarios"] 	    . '",'; 
        $outp .= '"Resumen":"' 		        . $rs["Resumen"] 	        . '",'; 
        $outp .= '"Antecedentes":"' 		. $rs["Antecedentes"] 	    . '",'; 
        $outp .= '"tipoMuestra":"'	    	. $rs["tipoMuestra"]  		. '"}';
    }
    $link->close();
    $outp ='{"records":['.$outp.']}';


}
if($dato->accion == 'porahoranada'){
    $outp = '';
    $link=Conectarse();
    //$bdInf=$link->query("SELECT * FROM amInformes Where CodInforme = '$dato->CodInforme'");
    $bd=$link->query("SELECT * FROM amInformes Where CodInforme = '$dato->CodInforme'");
    if($rs=mysqli_fetch_array($bd)){
        $Cliente        = '';
        $CLIENTE        = '';
        $Direccion      = '';
        $Contacto       = '';
        $Email          = '';
        $nContacto      = 0;
        $CAM            = 0;
        $RAM            = 0;
        $Rev            = 0;
    
        $fd = explode('-', $rs['CodInforme']);
        $RAM = $fd[1];
    
        $bdCAM = $link->query("SELECT * FROM cotizaciones Where RAM = '".$RAM."'");
        if($rowCAM=mysqli_fetch_array($bdCAM)){
            $nContacto  = $rowCAM['nContacto'];
            $CAM        = $rowCAM['CAM'];
            $RAM        = $rowCAM['RAM'];
            $Rev        = $rowCAM['Rev'];
        }
    
        $bdCli = $link->query("SELECT * FROM Clientes Where RutCli = '".$rs['RutCli']."'");
        if($rowCli=mysqli_fetch_array($bdCli)){
            $Cliente 	= $rowCli['Cliente'];
            $CLIENTE 	= $rowCli['Cliente'];
            $Direccion 	= $rowCli['Direccion'];
        }	
    
        $bdCon = $link->query("SELECT * FROM contactoscli Where RutCli = '".$rs['RutCli']."' and nContacto = '".$nContacto."'");
        if($rowCon=mysqli_fetch_array($bdCon)){
            $Contacto 	= $rowCon['Contacto'];
            $Email 		= $rowCon['Email'];
        }	
    
          if ($outp != "") {$outp .= ",";}
          $outp .= '{"CodInforme":"'  		. $rs["CodInforme"] 		. '",'; 
          $outp .= '"RutCli":"'  		        . $rs["RutCli"] 	        . '",';
          $outp .= '"CAM":"'  		        . $CAM 	                    . '",';
          $outp .= '"RAM":"'  		        . $RAM 	                    . '",';
          $outp .= '"Rev":"'  		        . $Rev 	                    . '",';
          $outp .= '"Cliente":"'  		    . $Cliente 	                . '",';
          $outp .= '"CLIENTE":"'  		    . $CLIENTE 	                . '",';
          $outp .= '"Direccion":"'  		    . $Direccion 	            . '",';
          $outp .= '"Contacto":"'  		    . $Contacto 	            . '",';
          $outp .= '"nContacto":"'  		    . $nContacto 	            . '",';
          $outp .= '"Email":"'  		        . $Email 	                . '",';
          $outp .= '"ingResponsable":"'  		. $rs["ingResponsable"] 	. '",';
          $outp .= '"cooResponsable":"'  		. $rs["cooResponsable"] 	. '",';
          $outp .= '"CodigoVerificacion":"' 	. $rs["CodigoVerificacion"] . '",';
          $outp .= '"imgQR":"' 				. $rs["imgQR"] 				. '",'; 
          $outp .= '"imgMuestra":"' 			. $rs["imgMuestra"] 		. '",'; 
          $outp .= '"fechaRecepcion":"' 		. $rs["fechaRecepcion"] 	. '",'; 
          $outp .= '"fechaInforme":"' 		. $rs["fechaInforme"] 	    . '",'; 
          $outp .= '"nMuestras":"' 		    . $rs["nMuestras"] 	        . '",'; 
          $outp .= '"tpEnsayo":"' 		    . $rs["tpEnsayo"] 	        . '",'; 
          $outp .= '"amEnsayo":"' 		    . $rs["amEnsayo"] 	        . '",'; 
          $outp .= '"Titulo":"' 		        . $rs["Titulo"] 	        . '",'; 
          $outp .= '"palsClaves":"' 		    . $rs["palsClaves"] 	    . '",'; 
          $outp .= '"Objetivos":"' 		    . $rs["Objetivos"] 	        . '",'; 
          $outp .= '"Metodologia":"' 		    . $rs["Metodologia"] 	    . '",'; 
          $outp .= '"Comentarios":"' 		    . $rs["Comentarios"] 	    . '",'; 
          $outp .= '"Resumen":"' 		        . $rs["Resumen"] 	        . '",'; 
          $outp .= '"Antecedentes":"' 		. $rs["Antecedentes"] 	    . '",'; 
          $outp .= '"tipoMuestra":"'	    	. $rs["tipoMuestra"]  		. '"}';
    }
    //$outp ='{"records":['.$outp.']}';
    
    $json_string = $outp;
    $file = 'json/'.$dato->CodInforme.'.json';
    file_put_contents($file, $json_string);
    
    $outp = '';
    $bdm=$link->query("SELECT * FROM amMuestras Where CodInforme = '$dato->CodInforme' Order By idItem");
    while($rsm=mysqli_fetch_array($bdm)){
            
            if ($outp != "") {$outp .= ",";}
            $outp .= '{"CodInforme":"'  		. $dato->CodInforme 		. '",'; 
            $outp .= '"idMuestra":"'  		    . $rsm["idMuestra"] 	    . '",';
            $outp .= '"idItem":"'	    	    . $rsm["idItem"]  		    . '"}';
      
    }
    $outp ='['.$outp.']';
    $json_string = $outp;
    $file = 'json/'.$RAM.'-amMuestras.json';
    file_put_contents($file, $json_string);
    
    $outp = '';
    $bdte=$link->query("SELECT * FROM amTabEnsayos Where CodInforme = '$dato->CodInforme'");
    while($rste=mysqli_fetch_array($bdte)){
            
            if ($outp != "") {$outp .= ",";}
            $outp .= '{"CodInforme":"'  		. $dato->CodInforme 		. '",'; 
            $outp .= '"idEnsayo":"'  		    . $rste["idEnsayo"] 	    . '",';
            $outp .= '"Ref":"'	    	        . $rste["Ref"]  		    . '"}';
      
    }
    $outp ='['.$outp.']';
    $json_string = $outp;
    $file = 'json/'.$RAM.'-amTabEnsayos.json';
    file_put_contents($file, $json_string);
    
    $outp = '';
    $bdot=$link->query("SELECT * FROM Otams Where CodInforme = '$dato->CodInforme'");
    while($rsot=mysqli_fetch_array($bdot)){
            
            if ($outp != "") {$outp .= ",";}
            $outp .= '{"CodInforme":"'  		. $dato->CodInforme 		    . '",'; 
            $outp .= '"CAM":"'  		        . $rsot["CAM"] 	                . '",';
            $outp .= '"RAM":"'  		        . $rsot["RAM"] 	                . '",';
            $outp .= '"idItem":"'  		        . $rsot["idItem"] 	            . '",';
            $outp .= '"Otam":"'  		        . $rsot["Otam"] 	            . '",';
            $outp .= '"ObsOtam":"'  		    . $rsot["ObsOtam"] 	            . '",';
            $outp .= '"rTaller":"'  		    . $rsot["rTaller"] 	            . '",';
            $outp .= '"idEnsayo":"'  		    . $rsot["idEnsayo"] 	        . '",';
            $outp .= '"tpMuestra":"'  		    . $rsot["tpMuestra"] 	        . '",';
            $outp .= '"Ind":"'  		        . $rsot["Ind"] 	                . '",';
            $outp .= '"Tem":"'  		        . $rsot["Tem"] 	                . '",';
            $outp .= '"Hum":"'  		        . $rsot["Hum"] 	                . '",';
            $outp .= '"TemEnsayo":"'  		    . $rsot["TemEnsayo"] 	        . '",';
            $outp .= '"Archivada":"'  		    . $rsot["Archivada"] 	        . '",';
            $outp .= '"fechaArchivo":"'  		. $rsot["fechaArchivo"] 	    . '",';
            $outp .= '"fechaCreaRegistro":"'  	. $rsot["fechaCreaRegistro"] 	. '",';
            $outp .= '"Estado":"'  	            . $rsot["Estado"] 	            . '",';
            $outp .= '"tpMedicion":"'  	        . $rsot["tpMedicion"] 	        . '",';
            $outp .= '"distanciaMax":"'  	    . $rsot["distanciaMax"] 	    . '",';
            $outp .= '"separacion":"'	    	. $rsot["separacion"]  		    . '"}';
      
    }
    $outp ='['.$outp.']';
    $json_string = $outp;
    $file = 'json/'.$RAM.'-Otams.json';
    file_put_contents($file, $json_string);
    
    $outp = '';
    $tQu = 'No';
    $bdq=$link->query("SELECT * FROM regQuimico Where CodInforme = '$dato->CodInforme'");
    while($rsq=mysqli_fetch_array($bdq)){
            $tQu = 'Si';
            if ($outp != "") {$outp .= ",";}
            $outp .= '{"CodInforme":"'  		. $dato->CodInforme 		. '",'; 
            $outp .= '"idItem":"'  		        . $rsq["idItem"] 	        . '",';
            $outp .= '"tpMuestra":"'  		    . $rsq["tpMuestra"] 	    . '",';
            $outp .= '"cC":"'  		            . $rsq["cC"] 	            . '",';
            $outp .= '"cSi":"'  		        . $rsq["cSi"] 	            . '",';
            $outp .= '"cMn":"'  		        . $rsq["cMn"] 	            . '",';
            $outp .= '"cP":"'  		            . $rsq["cP"] 	            . '",';
            $outp .= '"cS":"'  		            . $rsq["cS"] 	            . '",';
            $outp .= '"cCr":"'  		        . $rsq["cCr"] 	            . '",';
            $outp .= '"cNi":"'  		        . $rsq["cNi"] 	            . '",';
            $outp .= '"cMo":"'  		        . $rsq["cMo"] 	            . '",';
            $outp .= '"cAl":"'  		        . $rsq["cAl"] 	            . '",';
            $outp .= '"cCu":"'  		        . $rsq["cCu"] 	            . '",';
            $outp .= '"cCo":"'  		        . $rsq["cCo"] 	            . '",';
            $outp .= '"cTi":"'  		        . $rsq["cTi"] 	            . '",';
            $outp .= '"cNb":"'  		        . $rsq["cNb"] 	            . '",';
            $outp .= '"cNb":"'  		        . $rsq["cNb"] 	            . '",';
            $outp .= '"cV":"'  		            . $rsq["cV"] 	            . '",';
            $outp .= '"cW":"'  		            . $rsq["cW"] 	            . '",';
            $outp .= '"cPb":"'  		        . $rsq["cPb"] 	            . '",';
            $outp .= '"cB":"'  		            . $rsq["cB"] 	            . '",';
            $outp .= '"cSb":"'  		        . $rsq["cSb"] 	            . '",';
            $outp .= '"cSn":"'  		        . $rsq["cSn"] 	            . '",';
            $outp .= '"cZn":"'  		        . $rsq["cZn"] 	            . '",';
            $outp .= '"cAs":"'  		        . $rsq["cAs"] 	            . '",';
            $outp .= '"cBi":"'  		        . $rsq["cBi"] 	            . '",';
            $outp .= '"cTa":"'  		        . $rsq["cTa"] 	            . '",';
            $outp .= '"cCa":"'  		        . $rsq["cCa"] 	            . '",';
            $outp .= '"cCe":"'  		        . $rsq["cCe"] 	            . '",';
            $outp .= '"cZr":"'  		        . $rsq["cZr"] 	            . '",';
            $outp .= '"cLa":"'  		        . $rsq["cLa"] 	            . '",';
            $outp .= '"cSe":"'  		        . $rsq["cSe"] 	            . '",';
            $outp .= '"cN":"'  		            . $rsq["cN"] 	            . '",';
            $outp .= '"cFe":"'  		        . $rsq["cFe"] 	            . '",';
            $outp .= '"cMg":"'  		        . $rsq["cMg"] 	            . '",';
            $outp .= '"cTe":"'  		        . $rsq["cTe"] 	            . '",';
            $outp .= '"cCd":"'  		        . $rsq["cCd"] 	            . '",';
            $outp .= '"cAg":"'  		        . $rsq["cAg"] 	            . '",';
            $outp .= '"cAu":"'  		        . $rsq["cAu"] 	            . '",';
            $outp .= '"cAi":"'  		        . $rsq["cAi"] 	            . '",';
            $outp .= '"Temperatura":"'  		. $rsq["Temperatura"] 	    . '",';
            $outp .= '"Humedad":"'  		    . $rsq["Humedad"] 	        . '",';
            $outp .= '"Observacion":"'  		. $rsq["Observacion"] 	    . '",';
            $outp .= '"fechaRegistro":"'  		. $rsq["fechaRegistro"] 	. '",';
            $outp .= '"Precaucion":"'	    	. $rsq["Precaucion"]  		. '"}';
      
    }
    if($tQu == 'Si'){
        $outp ='['.$outp.']';
        $json_string = $outp;
        $file = 'json/'.$RAM.'-regQuimico.json';
        file_put_contents($file, $json_string);
    }
    
    $outp = '';
    $tTr = 'No';
    $bdtt=$link->query("SELECT * FROM regtraccion Where CodInforme = '$dato->CodInforme'");
    while($rstt=mysqli_fetch_array($bdtt)){
            $tTr = 'Si';
            if ($outp != "") {$outp .= ",";}
            $outp .= '{"CodInforme":"'  		. $dato->CodInforme 		        . '",'; 
            $outp .= '"idItem":"'  		        . $rstt["idItem"] 	                . '",';
            $outp .= '"tpMuestra":"'  		    . $rstt["tpMuestra"] 	            . '",';
            $outp .= '"aIni":"'  		        . $rstt["aIni"] 	                . '",';
            $outp .= '"cFlu":"'  		        . $rstt["cFlu"] 	                . '",';
            $outp .= '"cMax":"'  		        . $rstt["cMax"] 	                . '",';
            $outp .= '"tFlu":"'  		        . $rstt["tFlu"] 	                . '",';
            $outp .= '"tMax":"'  		        . $rstt["tMax"] 	                . '",';
            $outp .= '"aSob":"'  		        . $rstt["aSob"] 	                . '",';
            $outp .= '"rAre":"'  		        . $rstt["rAre"] 	                . '",';
            $outp .= '"Espesor":"'  		    . $rstt["Espesor"] 	                . '",';
            $outp .= '"Ancho":"'  		        . $rstt["Ancho"] 	                . '",';
            $outp .= '"Li":"'  		            . $rstt["Li"] 	                    . '",';
            $outp .= '"Lf":"'  		            . $rstt["Lf"] 	                    . '",';
            $outp .= '"Di":"'  		            . $rstt["Di"] 	                    . '",';
            $outp .= '"Df":"'  		            . $rstt["Df"] 	                    . '",';
            $outp .= '"Temperatura":"'  		. $rstt["Temperatura"] 	            . '",';
            $outp .= '"Humedad":"'  		    . $rstt["Humedad"] 	                . '",';
            $outp .= '"UTS":"'  		        . $rstt["UTS"] 	                    . '",';
            $outp .= '"Aporciento":"'  		    . $rstt["Aporciento"] 	            . '",';
            $outp .= '"Zporciento":"'  		    . $rstt["Zporciento"] 	            . '",';
            $outp .= '"Observacion":"'  		. $rstt["Observacion"] 	            . '",';
            $outp .= '"vbIngeniero":"'  		. $rstt["vbIngeniero"] 	            . '",';
            $outp .= '"fechaRegistro":"'	    . $rstt["fechaRegistro"]  		    . '"}';
      
    }
    if($tTr == 'Si'){
        $outp ='['.$outp.']';
        $json_string = $outp;
        $file = 'json/'.$RAM.'-regTraccion.json';
        file_put_contents($file, $json_string);
    }
    
    $outp = '';
    $tCh = 'No';
    $bdCh=$link->query("SELECT * FROM regCharpy Where CodInforme = '$dato->CodInforme'");
    while($rsCh=mysqli_fetch_array($bdCh)){
            $tCh = 'Si';
            if ($outp != "") {$outp .= ",";}
            $outp .= '{"CodInforme":"'  		. $dato->CodInforme 		        . '",'; 
            $outp .= '"idItem":"'  		        . $rsCh["idItem"] 	                . '",';
            $outp .= '"tpMuestra":"'  		    . $rsCh["tpMuestra"] 	            . '",';
            $outp .= '"Tem":"'  		        . $rsCh["Tem"] 	                    . '",';
            $outp .= '"Ancho":"'  		        . $rsCh["Ancho"] 	                . '",';
            $outp .= '"Alto":"'  		        . $rsCh["Alto"] 	                . '",';
            $outp .= '"resEquipo":"'  		    . $rsCh["resEquipo"] 	            . '",';
            $outp .= '"nImpacto":"'  		    . $rsCh["nImpacto"] 	            . '",';
            $outp .= '"vImpacto":"'  		    . $rsCh["vImpacto"] 	            . '",';
            $outp .= '"mm":"'  		            . $rsCh["mm"] 	                    . '",';
            $outp .= '"Entalle":"'  		    . $rsCh["Entalle"] 	                . '",';
            $outp .= '"fechaRegistro":"'  		. $rsCh["fechaRegistro"] 	        . '",';
            $outp .= '"CosProbMen4Ra":"'  		. $rsCh["CosProbMen4Ra"] 	        . '",';
            $outp .= '"CarEntMen2Ra":"'  		. $rsCh["CarEntMen2Ra"] 	        . '",';
            $outp .= '"Prob55":"'  		        . $rsCh["Prob55"] 	                . '",';
            $outp .= '"CentEnt27":"'  		    . $rsCh["CentEnt27"] 	            . '",';
            $outp .= '"AngEnt45":"'  		    . $rsCh["AngEnt45"] 	            . '",';
            $outp .= '"ProfEnt2mm":"'  		    . $rsCh["ProfEnt2mm"] 	            . '",';
            $outp .= '"RadCorv025":"'  		    . $rsCh["RadCorv025"] 	            . '",';
            $outp .= '"eAbs":"'	                . $rsCh["eAbs"]  		            . '"}';
      
    }
    if($tCh == 'Si'){
        $outp ='['.$outp.']';
        $json_string = $outp;
        $file = 'json/'.$RAM.'-regCharpy.json';
        file_put_contents($file, $json_string);
    }
    
    $outp = '';
    $tDu = 'No';
    $bdDu=$link->query("SELECT * FROM regdoblado Where CodInforme = '$dato->CodInforme'");
    while($rsDu=mysqli_fetch_array($bdDu)){
            $tDu = 'Si';
            if ($outp != "") {$outp .= ",";}
            $outp .= '{"CodInforme":"'  		. $dato->CodInforme 		        . '",'; 
            $outp .= '"idItem":"'  		        . $rsDu["idItem"] 	                . '",';
            $outp .= '"tpMuestra":"'  		    . $rsDu["tpMuestra"] 	            . '",';
            $outp .= '"nIndenta":"'  		    . $rsDu["nIndenta"] 	            . '",';
            $outp .= '"vIndenta":"'  		    . $rsDu["vIndenta"] 	            . '",';
            $outp .= '"Temperatura":"'  		. $rsDu["Temperatura"] 	            . '",';
            $outp .= '"Humedad":"'  		    . $rsDu["Humedad"] 	                . '",';
            $outp .= '"fechaRegistro":"'	    . $rsDu["fechaRegistro"]  		    . '"}';
      
    }
    if($tDu == 'Si'){
        $outp ='['.$outp.']';
        $json_string = $outp;
        $file = 'json/'.$RAM.'-regDoblado.json';
        file_put_contents($file, $json_string);
    }
    
    $outp = '';
    $tDo = 'No';
    $bdDo=$link->query("SELECT * FROM regdobladosreal Where CodInforme = '$dato->CodInforme'");
    while($rsDo=mysqli_fetch_array($bdDo)){
            $tDo = 'Si';
            if ($outp != "") {$outp .= ",";}
            $outp .= '{"CodInforme":"'  		. $dato->CodInforme 		        . '",'; 
            $outp .= '"idItem":"'  		        . $rsDo["idItem"] 	                . '",';
            $outp .= '"tpMuestra":"'  		    . $rsDo["tpMuestra"] 	            . '",';
            $outp .= '"Tipo":"'  		        . $rsDo["Tipo"] 	                . '",';
            $outp .= '"Observaciones":"'  		. $rsDo["Observaciones"] 	        . '",';
            $outp .= '"Condicion":"'  		    . $rsDo["Condicion"] 	            . '",';
            $outp .= '"fechaRegistro":"'	    . $rsDo["fechaRegistro"]  		    . '"}';
      
    }
    if($tDo == 'Si'){
        $outp ='['.$outp.']';
        $json_string = $outp;
        $file = 'json/'.$RAM.'-regDobladosReal.json';
        file_put_contents($file, $json_string);
    }
    
    
    $link->close();
    
    /*	
                        $host="ftp.simet.cl";
                        $login="simet";
                        $password="Alf.86382165";
                        $ftp=ftp_connect($host) or die ("no puedo conectar");
                        ftp_login($ftp,$login,$password) or die ("Conexión rechazada");
    
                        ftp_chdir($ftp,"/public_html/certificados/certificados");
    
                        if (ftp_put($ftp,$dato->pdf,"../certificados/".$dato->pdf,FTP_BINARY)){
                        }else{
                            echo "Error al subir el archivo<br>"; 
                        }
    
                        if (ftp_put($ftp,$file,"../certificados/".$file,FTP_BINARY)){
                        }else{
                            echo "Error al subir el archivo<br>"; 
                        }
                        ftp_quit($ftp);
    */
    
     //header("Location: http://servidordata/erperp/generarinformes2/exportarInformeWordAnalisis.php?CodInforme=$dato->CodInforme&accion=Imprime&version=Old");					
}



?>