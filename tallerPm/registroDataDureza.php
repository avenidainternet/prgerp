<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include_once("../conexionli.php");


if($dato->accion == 'editarCarga'){
    $link=Conectarse();
    $res = '';
	$SQL = "Select * From tablacargadureza Where diametroBola = '$dato->diametroBola'"; 
    $bd=$link->query($SQL);
    if($rs = mysqli_fetch_array($bd)){
        $res.= '{"diametroBola":"'.			$rs["diametroBola"].			'",';
        $res.= '"c3000":"'.			        $rs["c3000"].				    '",';
        $res.= '"c1500":"'.			        $rs["c1500"].				    '",';
        $res.= '"c1000":"'.			        $rs["c1000"].				    '",';
        $res.= '"c500":"'.			        $rs["c500"].				    '",';
        $res.= '"c250":"'.			        $rs["c250"].				    '",';
        $res.= '"c125":"'.			        $rs["c125"].				    '",';
        $res.= '"c100":"'. 				    $rs["c100"]. 				    '"}';
    
    }
    $link->close();
    echo $res;
}

if($dato->accion == 'LeerOtams'){ 
    $link=Conectarse();
    $res = '';
	$SQL = "Select * From otams Where Otam = '$dato->Otam'"; 
	// $SQL = "Select * From otams Where Otam = '15761-02-D02'";
    $bd=$link->query($SQL);
    if($rs = mysqli_fetch_array($bd)){
        $Muestra    = 'Muestra';
        $tipoEnsayo = '';
        $factorY    = 0.000;
        $constanteY = 0.000;

        $SQLm = "SELECT * FROM amtpsmuestras Where idEnsayo = '".$rs['idEnsayo']."' and tpMuestra = '".$rs['tpMuestra']."'";
        $bdm=$link->query($SQLm);
        if($rsm=mysqli_fetch_array($bdm)){
            $Muestra    = $rsm['Muestra'];
            $tipoEnsayo = $rsm['tipoEnsayo'];
            $factorY    = $rsm['factorY'];
            $constanteY = $rsm['constanteY'];
        }
        $fechaRegistro = date('Y-m-d');
        $SQLd = "Select * From regdoblado Where idItem = '$dato->Otam'";
        $bdd=$link->query($SQLd);
        if($rsd = mysqli_fetch_array($bdd)){
            $fechaRegistro = $rsd['fechaRegistro'];
        }

        $Geometria = '';
        $SQLg = "Select * From geometria Where nGeometria = '".$rs['Geometria']."'";
        $bdg=$link->query($SQLg);
        if($rsg = mysqli_fetch_array($bdg)){
            $Geometria = $rsg['Geometria'];
        }
    
        $res.= '{"CodInforme":"'.			$rs["CodInforme"].				'",';
		$res.= '"RAM":"'.			        $rs["RAM"].				        '",';
		$res.= '"CAM":"'.			        $rs["CAM"].				        '",';
		$res.= '"tpMuestra":"'.			    $rs["tpMuestra"].		        '",';
		$res.= '"tpMedicion":"'.			$rs["tpMedicion"].		        '",';
		$res.= '"tpEnsayoDureza":"'.	    $rs["tpEnsayoDureza"].		    '",';
		$res.= '"Geometria":"'.	            $Geometria.		                '",';
		$res.= '"cargaDureza":"'.	        $rs["cargaDureza"].		        '",';
		$res.= '"distanciaInicial":"'.	    $rs["distanciaInicial"].		'",';
		$res.= '"distanciaEntreInd":"'.	    $rs["distanciaEntreInd"].		'",';
		$res.= '"distanciaMax":"'.	        $rs["distanciaMax"].		    '",';
		$res.= '"separacion":"'.	        $rs["separacion"].		        '",';
		$res.= '"Estado":"'.			    $rs["Estado"].		            '",';
		$res.= '"Tem":"'.			        $rs["Tem"].		                '",';
		$res.= '"Hum":"'.			        $rs["Hum"].		                '",';
		$res.= '"tecRes":"'.			    $rs["tecRes"].		            '",';
		$res.= '"Muestra":"'.			    $Muestra.		                '",';
		$res.= '"fechaRegistro":"'.			$fechaRegistro.		            '",';
		$res.= '"factorY":"'.			    $factorY.		                '",';
		$res.= '"constanteY":"'.			$constanteY.		            '",';
		$res.= '"tipoEnsayo":"'.			$tipoEnsayo.		            '",';
        $res.= '"Ind":"'. 				    $rs["Ind"]. 				    '"}';
    }
    $link->close();
    echo $res;	

}

if($dato->accion == 'LeerTiposDurezas'){
    $link=Conectarse();
    $outp = "";
	$SQL = "Select * From amtpsmuestras Where idEnsayo = '$dato->idEnsayo'";
    $bd=$link->query($SQL);
    while($rs = mysqli_fetch_array($bd)){
		if ($outp != "") {$outp .= ",";}
		$outp .= '{"idEnsayo":"'  . 		$rs["idEnsayo"]. 			'",';
		$outp .= '"tpMuestra":"'. 			$rs["tpMuestra"]. 		    '",';
		$outp .= '"Muestra":"'. 			$rs["Muestra"]. 			'",';
	    $outp .= '"tipoEnsayo":"'. 			$rs["tipoEnsayo"]. 			'"}';
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);
}

if($dato->accion == 'leerEscala'){
    $link=Conectarse();
    $outp = "";
	$SQL = "Select * From durezaescala Order By nEscala";
    $bd=$link->query($SQL);
    while($rs = mysqli_fetch_array($bd)){
		if ($outp != "") {$outp .= ",";}
		$outp .= '{"nEscala":"'  . 		    $rs["nEscala"]. 		'",';
	    $outp .= '"Escala":"'. 			    $rs["Escala"]. 			'"}';
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);
}

if($dato->accion == 'leerGeometria'){
    $link=Conectarse();
    $outp = "";
	$SQL = "Select * From geometria Order By nGeometria";
    $bd=$link->query($SQL);
    while($rs = mysqli_fetch_array($bd)){
		if ($outp != "") {$outp .= ",";}
		$outp .= '{"nGeometria":"'  . 		$rs["nGeometria"]. 		'",';
	    $outp .= '"Geometria":"'. 			$rs["Geometria"]. 	    '"}';
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);
}

if($dato->accion == 'leerCargas'){
    $link=Conectarse();
    $outp = "";
	$SQL = "Select * From tablacargadureza";
    $bd=$link->query($SQL);
    while($rs = mysqli_fetch_array($bd)){
		if ($outp != "") {$outp .= ",";}
		$outp .= '{"diametroBola":"'  . 	$rs["diametroBola"]. 		'",';
		$outp .= '"c3000":"'. 			    $rs["c3000"]. 				'",';
		$outp .= '"c1500":"'. 			    $rs["c1500"]. 			    '",';
		$outp .= '"c1000":"'. 			    $rs["c1000"]. 			    '",';
		$outp .= '"c500":"'. 			    $rs["c500"]. 			    '",';
		$outp .= '"c250":"'. 	            $rs["c250"]. 		        '",';
		$outp .= '"c125":"'. 	            $rs["c125"]. 		        '",';
	    $outp .= '"c100":"'. 			    $rs["c100"]. 			    '"}';
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);
}

if($dato->accion == 'LeerDureza'){
    $link=Conectarse();
    $outp = "";
	$SQL = "Select * From regdoblado Where idItem = '$dato->Otam' Order By nIndenta";
    $bd=$link->query($SQL);
    while($rs = mysqli_fetch_array($bd)){
		if ($outp != "") {$outp .= ",";}
		$outp .= '{"CodInforme":"'  . 		$rs["CodInforme"]. 			'",';
		$outp .= '"idItem":"'. 			    $rs["idItem"]. 				'",';
		$outp .= '"nIndenta":"'. 			$rs["nIndenta"]. 			'",';
		$outp .= '"tpMuestra":"'. 			$rs["tpMuestra"]. 			'",';
		$outp .= '"vIndenta":"'. 			$rs["vIndenta"]. 			'",';
		$outp .= '"Distancia":"'. 			$rs["Distancia"]. 			'",';
		$outp .= '"diametroHuella":"'. 		$rs["diametroHuella"]. 		'",';
		// $outp.= '"Muestra":' 	            .json_encode($rs["Muestra"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
		$outp .= '"Temperatura":"'. 	    $rs["Temperatura"]. 		'",';
	    $outp .= '"Humedad":"'. 			$rs["Humedad"]. 			'"}';
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);
}

if($dato->accion == 'guardarDistanciaEntreInd'){
    $link=Conectarse();
    $Estado = 'R';
    $actSQL="UPDATE otams SET ";
    $actSQL.="Estado                = '".$Estado.	                        "',";
    $actSQL.="distanciaEntreInd     = '".$dato->distanciaEntreInd.	        "'";
    $actSQL.="Where Otam 	        = '$dato->Otam'";
    $bdOt=$link->query($actSQL);


    $bd=$link->query("SELECT * FROM otams Where Otam = '$dato->Otam'");
    if($rs=mysqli_fetch_array($bd)){
        $Ind = $rs['Ind'];

        $Distancia = $rs['distanciaInicial'];
        if($rs['distanciaInicial'] == 0){
            $Distancia = $dato->distanciaEntreInd;
        }

        $actSQL="UPDATE regdoblado SET ";
        $actSQL.="Distancia     = '".$Distancia.	         "'";
        $actSQL.="Where idItem 	= '$dato->Otam' and nIndenta = '1'";
        $bdOt=$link->query($actSQL);

        if($rs['distanciaInicial'] > 0){
            $Distancia = 0;
        }

        for($i=2; $i<=$Ind; $i++){
            $Distancia += $rs['distanciaEntreInd'];
            $actSQL="UPDATE regdoblado SET ";
            $actSQL.="Distancia     = '".$Distancia.	         "'";
            $actSQL.="Where idItem 	= '$dato->Otam' and nIndenta = '$i'";
            $bdOt=$link->query($actSQL);
        }
    }

    $link->close();

}

if($dato->accion == 'guardarDistanciaInicial'){
    $link=Conectarse();
    $Estado = 'R';
    $actSQL="UPDATE otams SET ";
    $actSQL.="Estado                = '".$Estado.	                        "',";
    $actSQL.="distanciaInicial      = '".$dato->distanciaInicial.	        "'";
    $actSQL.="Where Otam 	        = '$dato->Otam'";
    $bdOt=$link->query($actSQL);

    $bd=$link->query("SELECT * FROM otams Where Otam = '$dato->Otam'");
    if($rs=mysqli_fetch_array($bd)){
        $Distancia = $rs['distanciaInicial'];
        if($dato->distanciaInicial == 0){
            $Distancia = $rs['distanciaEntreInd'];
        }
        $distanciaEntreInd = $rs['distanciaEntreInd'];
        $Ind = $rs['Ind'];
        $actSQL="UPDATE regdoblado SET ";
        $actSQL.="Distancia     = '".$Distancia.	         "'";
        $actSQL.="Where idItem 	= '$dato->Otam' and nIndenta = '1'";
        $bdOt=$link->query($actSQL);
        if($dato->distanciaInicial > 0){
            $Distancia = 0;
        }
       
        for($i=2; $i<=$Ind; $i++){
            $Distancia += $rs['distanciaEntreInd'];
            $actSQL="UPDATE regdoblado SET ";
            $actSQL.="Distancia     = '".$Distancia.	         "'";
            $actSQL.="Where idItem 	= '$dato->Otam' and nIndenta = '$i'";
            $bdOt=$link->query($actSQL);
        }

    }

    $link->close();

}


if($dato->accion == 'guardarTecRes'){
    $link=Conectarse();

    $actSQL="UPDATE otams SET ";
    $actSQL.="tecRes            = '".$dato->tecRes.	         "'";
    $actSQL.="Where Otam 	    = '$dato->Otam'";
    $bdOt=$link->query($actSQL);

    $link->close();

}


if($dato->accion == 'grabarTipoMuestra'){
    $link=Conectarse();

    $actSQL="UPDATE otams SET ";
    $actSQL.="tpMuestra    ='".$dato->tpMuestra.	         "'";
    $actSQL.="Where Otam 	= '$dato->Otam'";
    $bdOt=$link->query($actSQL);

    $link->close();

}

if($dato->accion == 'guardarGeometria'){
    $link=Conectarse();
    $bd=$link->query("SELECT * FROM geometria Where Geometria = '$dato->Geometria'");
    if($rs=mysqli_fetch_array($bd)){
        $nGeometria = $rs['nGeometria'];
        $actSQL="UPDATE otams SET ";
        $actSQL.="Geometria     ='".$nGeometria.	         "'";
        $actSQL.="Where Otam 	= '$dato->Otam'";
        $bdOt=$link->query($actSQL);
    }


    $link->close();
}

if($dato->accion == 'grabarTipo'){
    $link=Conectarse();

    $actSQL="UPDATE otams SET ";
    $actSQL.="tpMedicion    ='".$dato->tpMedicion.	         "'";
    $actSQL.="Where Otam 	= '$dato->Otam'";
    $bdOt=$link->query($actSQL);

    $link->close();
}

if($dato->accion == 'guardarCargaDureza'){
    $link=Conectarse();

    $actSQL="UPDATE otams SET ";
    $actSQL.="cargaDureza   ='".$dato->cargaDureza.	"'";
    $actSQL.="Where Otam 	= '$dato->Otam'";
    $bdOt=$link->query($actSQL);


    $bd=$link->query("SELECT * FROM regdoblado Where idItem = '$dato->Otam'");
    while($rs=mysqli_fetch_array($bd)){
        $nIndenta = $rs['nIndenta'];
        $bdcd=$link->query("SELECT * FROM tablacargadureza Where diametroBola = '".$rs['diametroHuella']."'");
        if($rscd=mysqli_fetch_array($bdcd)){

            if($dato->cargaDureza == 100){
                $actSQL="UPDATE regdoblado SET ";
                $actSQL.="vIndenta          ='".$rscd['c100']             ."'";
                $actSQL.="WHERE idItem 	    = '$dato->Otam' and nIndenta = '$nIndenta'";
                $bdDu=$link->query($actSQL);            
            }
            if($dato->cargaDureza == 125){
                $actSQL="UPDATE regdoblado SET ";
                $actSQL.="vIndenta          ='".$rscd['c125']             ."'";
                $actSQL.="WHERE idItem 	    = '$dato->Otam' and nIndenta = '$nIndenta'";
                $bdDu=$link->query($actSQL);            
            }
            if($dato->cargaDureza == 250){
                $actSQL="UPDATE regdoblado SET ";
                $actSQL.="vIndenta          ='".$rscd['c250']             ."'";
                $actSQL.="WHERE idItem 	    = '$dato->Otam' and nIndenta = '$nIndenta'";
                $bdDu=$link->query($actSQL);            
            }
            if($dato->cargaDureza == 500){
                $actSQL="UPDATE regdoblado SET ";
                $actSQL.="vIndenta          ='".$rscd['c500']             ."'";
                $actSQL.="WHERE idItem 	    = '$dato->Otam' and nIndenta = '$nIndenta'";
                $bdDu=$link->query($actSQL);            
            }
            if($dato->cargaDureza == 1000){
                $actSQL="UPDATE regdoblado SET ";
                $actSQL.="vIndenta          ='".$rscd['c1000']             ."'";
                $actSQL.="WHERE idItem 	    = '$dato->Otam' and nIndenta = '$nIndenta'";
                $bdDu=$link->query($actSQL);            
            }
            if($dato->cargaDureza == 1500){
                $actSQL="UPDATE regdoblado SET ";
                $actSQL.="vIndenta          ='".$rscd['c1500']             ."'";
                $actSQL.="WHERE idItem 	    = '$dato->Otam' and nIndenta = '$nIndenta'";
                $bdDu=$link->query($actSQL);            
            }
            if($dato->cargaDureza == 3000){
                $actSQL="UPDATE regdoblado SET ";
                $actSQL.="vIndenta          ='".$rscd['c3000']             ."'";
                $actSQL.="WHERE idItem 	    = '$dato->Otam' and nIndenta = '$nIndenta'";
                $bdDu=$link->query($actSQL);            
            }


        }

    }



    $link->close();
}

if($dato->accion == 'gardarRegDurezaDatosFijos'){
    $link=Conectarse();

    $actSQL="UPDATE regdoblado SET ";
    $actSQL.="fechaRegistro ='".$dato->fechaRegistro.	"',";
    $actSQL.="Temperatura   ='".$dato->Temperatura.	    "',";
    $actSQL.="Humedad       ='".$dato->Humedad.	        "'";
    $actSQL.="WHERE idItem 	= '$dato->idItem'";
    $bdDu=$link->query($actSQL);

    $actSQL="UPDATE otams SET ";
    $actSQL.="Tem           ='".$dato->Temperatura.	    "',";
    $actSQL.="Hum           ='".$dato->Humedad.	         "'";
    $actSQL.="Where Otam 	= '$dato->idItem'";
    $bdOt=$link->query($actSQL);

    $link->close();
}

if($dato->accion == 'guardarCarga'){
    $link=Conectarse();
    $bd=$link->query("SELECT * FROM tablacargadureza Where diametroBola = '$dato->diametroBola'");
    if($rs=mysqli_fetch_array($bd)){
        $actSQL= "UPDATE tablacargadureza SET ";
        $actSQL.= "diametroBola      ='".$dato->diametroBola.    "',";
        $actSQL.= "c3000             ='".$dato->c3000.           "',";
        $actSQL.= "c1500             ='".$dato->c1500.           "',";
        $actSQL.= "c1000             ='".$dato->c1000.           "',";
        $actSQL.= "c500              ='".$dato->c500.            "',";
        $actSQL.= "c250              ='".$dato->c250.            "',";
        $actSQL.= "c125              ='".$dato->c125.            "',";
        $actSQL.= "c100              ='".$dato->c100.            "'";
        $actSQL.= "Where diametroBola 	    = '$dato->diametroBola'";
        $bdDu=$link->query($actSQL);
    }else{
        $link->query("insert into tablacargadureza(
                                            diametroBola,
                                            c3000,
                                            c1500,
                                            c1000,
                                            c500,
                                            c250,
                                            c125,
                                            c100
                            ) values (	
                                            '$dato->diametroBola',
                                            '$dato->c3000',
                                            '$dato->c1500',
                                            '$dato->c1000',
                                            '$dato->c500',
                                            '$dato->c250',
                                            '$dato->c125',
                                            '$dato->c100'
        )");

    }
    $link->close();
}

if($dato->accion == 'calculoHuella'){
    $vIndenta = 0;
    $link=Conectarse();

    $bd=$link->query("SELECT * FROM tablacargadureza Where diametroBola = '$dato->diametroHuella'");
    if($rs=mysqli_fetch_array($bd)){
        $bdot=$link->query("SELECT * FROM otams Where Otam = '$dato->idItem'");
        if($rsot=mysqli_fetch_array($bdot)){
            if($rsot['cargaDureza'] == 100){
                $vIndenta =  $rs['c100'];
                $actSQL="UPDATE regdoblado SET ";
                $actSQL.="diametroHuella    ='".$dato->diametroHuella   ."',";
                $actSQL.="vIndenta          ='".$rs['c100']             ."'";
                $actSQL.="WHERE idItem 	    = '$dato->idItem' and nIndenta = '$dato->nIndenta'";
                $bdDu=$link->query($actSQL);            
            }
            if($rsot['cargaDureza'] == 125){
                $vIndenta =  $rs['c125'];
                $actSQL="UPDATE regdoblado SET ";
                $actSQL.="diametroHuella    ='".$dato->diametroHuella   ."',";
                $actSQL.="vIndenta          ='".$rs['c125']             ."'";
                $actSQL.="WHERE idItem 	    = '$dato->idItem' and nIndenta = '$dato->nIndenta'";
                $bdDu=$link->query($actSQL);            
            }
            if($rsot['cargaDureza'] == 250){
                $vIndenta =  $rs['c250'];
                $actSQL="UPDATE regdoblado SET ";
                $actSQL.="diametroHuella    ='".$dato->diametroHuella   ."',";
                $actSQL.="vIndenta          ='".$rs['c250']             ."'";
                $actSQL.="WHERE idItem 	    = '$dato->idItem' and nIndenta = '$dato->nIndenta'";
                $bdDu=$link->query($actSQL);            
            }
            if($rsot['cargaDureza'] == 500){
                $vIndenta =  $rs['c500'];
                $actSQL="UPDATE regdoblado SET ";
                $actSQL.="diametroHuella    ='".$dato->diametroHuella   ."',";
                $actSQL.="vIndenta          ='".$rs['c500']             ."'";
                $actSQL.="WHERE idItem 	    = '$dato->idItem' and nIndenta = '$dato->nIndenta'";
                $bdDu=$link->query($actSQL);            
            }
            if($rsot['cargaDureza'] == 1000){
                $vIndenta =  $rs['c1000'];
                $actSQL="UPDATE regdoblado SET ";
                $actSQL.="diametroHuella    ='".$dato->diametroHuella   ."',";
                $actSQL.="vIndenta          ='".$rs['c1000']            ."'";
                $actSQL.="WHERE idItem 	    = '$dato->idItem' and nIndenta = '$dato->nIndenta'";
                $bdDu=$link->query($actSQL);            
            }
            if($rsot['cargaDureza'] == 1500){
                $vIndenta =  $rs['c1500'];
                $actSQL="UPDATE regdoblado SET ";
                $actSQL.="diametroHuella    ='".$dato->diametroHuella   ."',";
                $actSQL.="vIndenta          ='".$rs['c1500']            ."'";
                $actSQL.="WHERE idItem 	    = '$dato->idItem' and nIndenta = '$dato->nIndenta'";
                $bdDu=$link->query($actSQL);            
            }
            if($rsot['cargaDureza'] == 3000){
                $vIndenta =  $rs['c3000'];
                $actSQL="UPDATE regdoblado SET ";
                $actSQL.="diametroHuella    ='".$dato->diametroHuella   ."',";
                $actSQL.="vIndenta          ='".$rs['c3000']            ."'";
                $actSQL.="WHERE idItem 	    = '$dato->idItem' and nIndenta = '$dato->nIndenta'";
                $bdDu=$link->query($actSQL);            
            }
        }
    }

    $link->close();
}

if($dato->accion == 'actualizarIndentacion'){
    $link=Conectarse();
    $bd=$link->query("SELECT * FROM otams Where Otam = '$dato->Otam'");
    if($rs=mysqli_fetch_array($bd)){
        $tpMuestra  = $rs['tpMuestra'];
        $IndActual  = $rs['Ind'];

        $actSQL="UPDATE otams SET ";
        $actSQL.="Ind 		    ='".$dato->Ind.	    "'";
        $actSQL.="WHERE Otam 	= '$dato->Otam'";
        $bdDu=$link->query($actSQL);
    }

    for($i=1; $i <= $dato->Ind; $i++){
        $bd=$link->query("SELECT * FROM regdoblado Where idItem = '$dato->Otam' and nIndenta = '$i'");
        if($rs=mysqli_fetch_array($bd)){
        }else{
            $link->query("insert into regdoblado(
                                                    idItem,
                                                    tpMuestra,
                                                    nIndenta
                                                ) values (	
                                                    '$dato->Otam',
                                                    '$tpMuestra',
                                                    '$i'
            )");
        }
    }

    if($IndActual > $dato->Ind){
        for($i=$dato->Ind+1; $i<=$IndActual; $i++){
            $bd=$link->query("DELETE FROM regdoblado Where idItem = '$dato->Otam' and nIndenta = '$i'");
        }
    }
    $link->close();

}

if($dato->accion == 'gardarRegDureza'){
    $link=Conectarse();
    //$bd=$link->query("SELECT * FROM regdoblado Where idItem = '$dato->idItem' and nIndenta = '$dato->nIndenta'");

    $bd=$link->query("SELECT * FROM regdoblado Where idItem = '$dato->idItem' and nIndenta = '$dato->nIndenta'");
    if($rs=mysqli_fetch_array($bd)){
        $actSQL="UPDATE regdoblado SET ";
        $actSQL.="fechaRegistro ='".$dato->fechaRegistro.	"',";
        $actSQL.="Temperatura   ='".$dato->Temperatura.	    "',";
        $actSQL.="Humedad       ='".$dato->Humedad.	         "',";
        $actSQL.="vIndenta 		='".$dato->vIndenta.	    "'";
        $actSQL.="WHERE idItem 	= '$dato->idItem' and nIndenta = '$dato->nIndenta'";
        $bdDu=$link->query($actSQL);
    }

    $regIndentaciones       = 0;
    $cantidadIndentaciones  = 0;
    $bd=$link->query("SELECT * FROM regdoblado Where idItem = '$dato->idItem' Order By nIndenta Asc");
    while($rs=mysqli_fetch_array($bd)){
        $cantidadIndentaciones++;
        if($rs['vIndenta'] > 0){
            $regIndentaciones++;
        }
    }
    if($cantidadIndentaciones == $regIndentaciones){
        $Estado = 'R';
        $actSQL="UPDATE otams SET ";
        $actSQL.="Tem           ='".$dato->Temperatura.	    "',";
        $actSQL.="Hum           ='".$dato->Humedad.	         "',";
        $actSQL.="Estado        ='".$Estado.	            "'";
        $actSQL.="Where Otam 	= '$dato->idItem'";
        $bdOt=$link->query($actSQL);
    }
    $link->close();
}

?>