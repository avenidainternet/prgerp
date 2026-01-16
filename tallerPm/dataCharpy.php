<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
date_default_timezone_set("America/Santiago");

$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php"); 

if($dato->accion == "guardarEquipo"){
    $link=Conectarse(); 
    $sql = "SELECT * FROM regcharpy Where idItem = '$dato->idItem'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE regcharpy SET ";
        $actSQL.="Equipo		    ='".$dato->Equipo.	    "'";
        $actSQL.="WHERE idItem	    = '$dato->idItem'";
        $bdCot=$link->query($actSQL);
    }
    $link->close();
}


if($dato->accion == "guardarAncho"){
    $anchoLimpio = str_replace(',', '.', $dato->Ancho);
    $link=Conectarse(); 
    $sql = "SELECT * FROM regcharpy Where idItem = '$dato->idItem' and nImpacto = '$dato->nImpacto'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE regcharpy SET ";
        $actSQL.="Ancho		        ='".$anchoLimpio.	    "'";
        $actSQL.="WHERE idItem	    = '$dato->idItem' and nImpacto = '$dato->nImpacto'";
        $bdCot=$link->query($actSQL);
    }



    $calA           = 0.9061;
    //$calB = 2.7885;
    $calB           = 0.7885;
    // $calC           = 0;
    // $calD           = 0;
    // $EquilibrioX    = 0;
    $bdCAL=$link->query("Select * From calibraciones Where idEnsayo = 'Ch' and Equipo = '$dato->Equipo'");
    if($rowCAL=mysqli_fetch_array($bdCAL)){
            $calA 			= $rowCAL['calA'];
            $calB 			= $rowCAL['calB'];
            $EquilibrioX 	= $rowCAL['EquilibrioX'];
            $calC 			= $rowCAL['calC'];
            $calD 			= $rowCAL['calD'];
    }

    $sql = "SELECT * FROM regcharpy Where idItem = '$dato->idItem' and nImpacto = '$dato->nImpacto'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){

        $criterio = 80;
        $Entalle = 'Sin';
        $y = 0;
        if($rs['mm'] == 10.0) { $criterio = 80;     }
        if($rs['mm'] == 7.5 ) { $criterio = 60;     }
        if($rs['mm'] == 6.7 ) { $criterio = 53.6;   }
        if($rs['mm'] == 5.0 ) { $criterio = 40;     }
        if($rs['mm'] == 3.3 ) { $criterio = 26.4;   }
        if($rs['mm'] == 2.5 ) { $criterio = 20;     } 

        if(($rs['Ancho'] * $rs['Alto']) > 0){ 
            if($rs['mm'] < 10 and $rs['Entalle'] == 'Con'){
                $r = ($rs['Ancho'] * ($rs['Alto'] - 2));
                if($r > 0){
                    $y = ($rs['resEquipo'] * $criterio) / ($rs['Ancho'] * ($rs['Alto'] - 2));
                }else{
                    $y = ($rs['resEquipo'] * $criterio);
                }
            }else{
                $criterio = 100;
                $y = ($rs['resEquipo'] * $criterio) / ($rs['Ancho'] * $rs['Alto']);
            }
        }

        if($rs['resEquipo'] <= $EquilibrioX){
            $vImpacto = ($calA * $y) + ($calB);
        }
        if($rs['resEquipo'] > $EquilibrioX){
            $vImpacto = ($calC * $y) + ($calD);
        }
        if($y == 0){
            $vImpacto = 0;
        }else{
            // vImpacto = 22.2

            $vImpactoDec = ($vImpacto - intval($vImpacto)) * 10;
            $vImpactoRes = intval($vImpacto) / 2 - intval(intval($vImpacto) / 2);
            
            if($vImpactoRes == 0){
                if(intval($vImpactoDec) == 1 or intval($vImpactoDec) == 2 or intval($vImpactoDec) == 3){
                    $vImpacto = intval($vImpacto);
                }
                if(intval($vImpactoDec) == 4 or intval($vImpactoDec) == 5 or intval($vImpactoDec) == 6 or intval($vImpactoDec) == 7){
                    $vImpacto = intval($vImpacto)+0.4;
                }
                if(intval($vImpactoDec) == 8 or intval($vImpactoDec) == 9){
                    $vImpacto = intval($vImpacto)+0.8;
                }
            }else{
                if(intval($vImpactoDec) == 0 or intval($vImpactoDec) == 1){
                    $vImpacto = (intval($vImpacto) - 1) + 0.8;
                    //$vImpacto = $vImpacto;
                }
                if(intval($vImpactoDec) == 2 or intval($vImpactoDec) == 3 or intval($vImpactoDec) == 4 or intval($vImpactoDec) == 5){
                    $vImpacto = intval($vImpacto)+0.2;
                }
                if(intval($vImpactoDec) == 6 or intval($vImpactoDec) == 7 or intval($vImpactoDec) == 8 or intval($vImpactoDec) == 9){
                    $vImpacto = intval($vImpacto)+0.6;
                }
            }
            //$vImpacto = $vImpactoRes;

        }


        $actSQL="UPDATE regcharpy SET ";
        $actSQL.="vImpacto		    ='".$vImpacto.	            "'";
        $actSQL.="WHERE idItem	    = '$dato->idItem' and nImpacto = '$dato->nImpacto'";
        $bdCot=$link->query($actSQL);

    }





    $link->close();

    $tmp = "tmp";
	if(!file_exists($tmp)){
		mkdir($tmp);
	}

    
}
if($dato->accion == "guardarAlto"){
    // $Alto = $dato->Alto;
    // $Alto = number_format($dato->Alto, 2, ',', '.');
    $altoLimpio = str_replace(',', '.', $dato->Alto);

    $link=Conectarse(); 
    $sql = "SELECT * FROM regcharpy Where idItem = '$dato->idItem' and nImpacto = '$dato->nImpacto'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE regcharpy SET ";
        $actSQL.="Alto		        ='".$altoLimpio.	    "'";
        $actSQL.="WHERE idItem	    = '$dato->idItem' and nImpacto = '$dato->nImpacto'";
        $bdCot=$link->query($actSQL);
    }


    $calA = 0.9061;
    //$calB = 2.7885;
    $calB = 0.7885;
    $bdCAL=$link->query("Select * From calibraciones Where idEnsayo = 'Ch' and Equipo = '$dato->Equipo'");
    if($rowCAL=mysqli_fetch_array($bdCAL)){
            $calA 			= $rowCAL['calA'];
            $calB 			= $rowCAL['calB'];
            $EquilibrioX 	= $rowCAL['EquilibrioX'];
            $calC 			= $rowCAL['calC'];
            $calD 			= $rowCAL['calD'];
    }

    $sql = "SELECT * FROM regcharpy Where idItem = '$dato->idItem' and nImpacto = '$dato->nImpacto'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){

        $criterio = 80;
        $Entalle = 'Sin';
        $y = 0;
        if($rs['mm'] == 10.0) { $criterio = 80;     }
        if($rs['mm'] == 7.5 ) { $criterio = 60;     }
        if($rs['mm'] == 6.7 ) { $criterio = 53.6;   }
        if($rs['mm'] == 5.0 ) { $criterio = 40;     }
        if($rs['mm'] == 3.3 ) { $criterio = 26.4;   }
        if($rs['mm'] == 2.5 ) { $criterio = 20;     } 

        if(($rs['Ancho'] * $rs['Alto']) > 0){ 
            if($rs['mm'] < 10 and $rs['Entalle'] == 'Con'){
                $r = ($rs['Ancho'] * ($rs['Alto'] - 2));
                if($r > 0){
                    $y = ($rs['resEquipo'] * $criterio) / ($rs['Ancho'] * ($rs['Alto'] - 2));
                }else{
                    $y = ($rs['resEquipo'] * $criterio);
                }
            }else{
                $criterio = 100;
                $y = ($rs['resEquipo'] * $criterio) / ($rs['Ancho'] * $rs['Alto']);
            }
        }

        if($rs['resEquipo'] <= $EquilibrioX){
            $vImpacto = round(($calA * $y) + ($calB),1);
        }
        if($rs['resEquipo'] > $EquilibrioX){
            $vImpacto = round(($calC * $y) + ($calD),1);
        }
        if($y == 0){
            $vImpacto = 0;
        }else{
            // vImpacto = 22.2

            $vImpactoDec = ($vImpacto - intval($vImpacto)) * 10;
            $vImpactoRes = intval($vImpacto) / 2 - intval(intval($vImpacto) / 2);
            
            if($vImpactoRes == 0){
                if(intval($vImpactoDec) == 1 or intval($vImpactoDec) == 2 or intval($vImpactoDec) == 3){
                    $vImpacto = intval($vImpacto);
                }
                if(intval($vImpactoDec) == 4 or intval($vImpactoDec) == 5 or intval($vImpactoDec) == 6 or intval($vImpactoDec) == 7){
                    $vImpacto = intval($vImpacto)+0.4;
                }
                if(intval($vImpactoDec) == 8 or intval($vImpactoDec) == 9){
                    $vImpacto = intval($vImpacto)+0.8;
                }
            }else{
                if(intval($vImpactoDec) == 0 or intval($vImpactoDec) == 1){
                    $vImpacto = (intval($vImpacto) - 1) + 0.8;
                    //$vImpacto = $vImpacto;
                }
                if(intval($vImpactoDec) == 2 or intval($vImpactoDec) == 3 or intval($vImpactoDec) == 4 or intval($vImpactoDec) == 5){
                    $vImpacto = intval($vImpacto)+0.2;
                }
                if(intval($vImpactoDec) == 6 or intval($vImpactoDec) == 7 or intval($vImpactoDec) == 8 or intval($vImpactoDec) == 9){
                    $vImpacto = intval($vImpacto)+0.6;
                }
            }
            //$vImpacto = $vImpactoRes;

        }


        $actSQL="UPDATE regcharpy SET ";
        $actSQL.="vImpacto		    ='".$vImpacto.	            "'";
        $actSQL.="WHERE idItem	    = '$dato->idItem' and nImpacto = '$dato->nImpacto'";
        $bdCot=$link->query($actSQL);

        $tmp = "tmp";
        if(!file_exists($tmp)){
            mkdir($tmp);
        }
    
    }




    $link->close();
    
}
if($dato->accion == "guardarresEquipo"){
    $link=Conectarse(); 

    $calA = 0.9061;
    //$calB = 2.7885;
    $calB = 0.7885;
    $bdCAL=$link->query("Select * From calibraciones Where idEnsayo = 'Ch' and Equipo = '$dato->Equipo'");
    if($rowCAL=mysqli_fetch_array($bdCAL)){
            $calA 			= $rowCAL['calA'];
            $calB 			= $rowCAL['calB'];
            $EquilibrioX 	= $rowCAL['EquilibrioX'];
            $calC 			= $rowCAL['calC'];
            $calD 			= $rowCAL['calD'];
    }

    $sql = "SELECT * FROM regcharpy Where idItem = '$dato->idItem' and nImpacto = '$dato->nImpacto'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){

        $criterio = 80;
        $Entalle = 'Sin';
        $y = 0;
        if($rs['mm'] == 10.0) { $criterio = 80;     }
        if($rs['mm'] == 7.5 ) { $criterio = 60;     }
        if($rs['mm'] == 6.7 ) { $criterio = 53.6;   }
        if($rs['mm'] == 5.0 ) { $criterio = 40;     }
        if($rs['mm'] == 3.3 ) { $criterio = 26.4;   }
        if($rs['mm'] == 2.5 ) { $criterio = 20;     } 

        if(($rs['Ancho'] * $rs['Alto']) > 0){ 
            if($rs['mm'] < 10 and $rs['Entalle'] == 'Con'){
                $y = ($dato->resEquipo * $criterio) / ($rs['Ancho'] * ($rs['Alto'] - 2));
            }else{
                $criterio = 100;
                $y = ($dato->resEquipo * $criterio) / ($rs['Ancho'] * $rs['Alto']);
            }
        }
        
        if($dato->resEquipo <= $EquilibrioX){
            $vImpacto = ($calA * $y) + ($calB);
        }
        if($dato->resEquipo > $EquilibrioX){
            $vImpacto = ($calC * $y) + ($calD);
        }
        if($y == 0){
            $vImpacto = 0;
        }else{
            // vImpacto = 22.2

            $vImpactoDec = ($vImpacto - intval($vImpacto)) * 10;
            $vImpactoRes = intval($vImpacto) / 2 - intval(intval($vImpacto) / 2);
            
            if($vImpactoRes == 0){
                if(intval($vImpactoDec) == 1 or intval($vImpactoDec) == 2 or intval($vImpactoDec) == 3){
                    $vImpacto = intval($vImpacto);
                }
                if(intval($vImpactoDec) == 4 or intval($vImpactoDec) == 5 or intval($vImpactoDec) == 6 or intval($vImpactoDec) == 7){
                    $vImpacto = intval($vImpacto)+0.4;
                }
                if(intval($vImpactoDec) == 8 or intval($vImpactoDec) == 9){
                    $vImpacto = intval($vImpacto)+0.8;
                }
            }else{
                if(intval($vImpactoDec) == 0 or intval($vImpactoDec) == 1){
                    $vImpacto = (intval($vImpacto) - 1) + 0.8;
                    //$vImpacto = $vImpacto;
                }
                if(intval($vImpactoDec) == 2 or intval($vImpactoDec) == 3 or intval($vImpactoDec) == 4 or intval($vImpactoDec) == 5){
                    $vImpacto = intval($vImpacto)+0.2;
                }
                if(intval($vImpactoDec) == 6 or intval($vImpactoDec) == 7 or intval($vImpactoDec) == 8 or intval($vImpactoDec) == 9){
                    $vImpacto = intval($vImpacto)+0.6;
                }
            }
            //$vImpacto = $vImpactoRes;

        }


        $actSQL="UPDATE regcharpy SET ";
        $actSQL.="resEquipo		    ='".$dato->resEquipo.	    "',";
        $actSQL.="vImpacto		    ='".$vImpacto.	            "'";
        $actSQL.="WHERE idItem	    = '$dato->idItem' and nImpacto = '$dato->nImpacto'";
        $bdCot=$link->query($actSQL);
    }
    $link->close();    

    $tmp = "tmp";
	if(!file_exists($tmp)){
		mkdir($tmp);
	}

}


if($dato->accion == "guardarCosProbMen4Ra"){
    $CosProbMen4Ra = 'off';
    if($dato->CosProbMen4Ra == 1){
        $CosProbMen4Ra = 'on';
    }
    $link=Conectarse(); 
    $sql = "SELECT * FROM regcharpy Where idItem = '$dato->idItem' and nImpacto = '$dato->nImpacto'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE regcharpy SET ";
        $actSQL.="CosProbMen4Ra		='".$CosProbMen4Ra.	    "'";
        $actSQL.="WHERE idItem	    = '$dato->idItem' and nImpacto = '$dato->nImpacto'";
        $bdCot=$link->query($actSQL);
    }
    $link->close();    
}

if($dato->accion == "guardarCarEntMen2Ra"){
    $CarEntMen2Ra = 'off';
    if($dato->CarEntMen2Ra == 1){
        $CarEntMen2Ra = 'on';
    }
    $link=Conectarse(); 
    $sql = "SELECT * FROM regcharpy Where idItem = '$dato->idItem' and nImpacto = '$dato->nImpacto'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE regcharpy SET ";
        $actSQL.="CarEntMen2Ra		='".$CarEntMen2Ra.	    "'";
        $actSQL.="WHERE idItem	    = '$dato->idItem' and nImpacto = '$dato->nImpacto'";
        $bdCot=$link->query($actSQL);
    }
    $link->close();    
}

if($dato->accion == "guardarProb55"){
    $Prob55 = 'off';
    if($dato->Prob55 == 1){
        $Prob55 = 'on';
    }
    $link=Conectarse(); 
    $sql = "SELECT * FROM regcharpy Where idItem = '$dato->idItem' and nImpacto = '$dato->nImpacto'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE regcharpy SET ";
        $actSQL.="Prob55		    ='".$Prob55.	    "'";
        $actSQL.="WHERE idItem	    = '$dato->idItem' and nImpacto = '$dato->nImpacto'";
        $bdCot=$link->query($actSQL);
    }
    $link->close();    

    $tmp = "tmp";
	if(!file_exists($tmp)){
		mkdir($tmp);
	}

}
if($dato->accion == "guardarCentEnt27"){
    $CentEnt27 = 'off';
    if($dato->CentEnt27 == 1){
        $CentEnt27 = 'on';
    }
    $link=Conectarse(); 
    $sql = "SELECT * FROM regcharpy Where idItem = '$dato->idItem' and nImpacto = '$dato->nImpacto'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE regcharpy SET ";
        $actSQL.="CentEnt27		    ='".$CentEnt27.	    "'";
        $actSQL.="WHERE idItem	    = '$dato->idItem' and nImpacto = '$dato->nImpacto'";
        $bdCot=$link->query($actSQL);
    }
    $link->close();    

    $tmp = "tmp";
	if(!file_exists($tmp)){
		mkdir($tmp);
	}

}
if($dato->accion == "guardarAngEnt45"){
    $AngEnt45 = 'off';
    if($dato->AngEnt45 == 1){
        $AngEnt45 = 'on';
    }
    $link=Conectarse(); 
    $sql = "SELECT * FROM regcharpy Where idItem = '$dato->idItem' and nImpacto = '$dato->nImpacto'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE regcharpy SET ";
        $actSQL.="AngEnt45		    ='".$AngEnt45.	    "'";
        $actSQL.="WHERE idItem	    = '$dato->idItem' and nImpacto = '$dato->nImpacto'";
        $bdCot=$link->query($actSQL);
    }
    $link->close();    
}
if($dato->accion == "guardarProfEnt2mm"){
    $ProfEnt2mm = 'off';
    if($dato->ProfEnt2mm == 1){
        $ProfEnt2mm = 'on';
    }
    $link=Conectarse(); 
    $sql = "SELECT * FROM regcharpy Where idItem = '$dato->idItem' and nImpacto = '$dato->nImpacto'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE regcharpy SET ";
        $actSQL.="ProfEnt2mm		='".$ProfEnt2mm.	    "'";
        $actSQL.="WHERE idItem	    = '$dato->idItem' and nImpacto = '$dato->nImpacto'";
        $bdCot=$link->query($actSQL);
    }
    $link->close();    
}
if($dato->accion == "guardarRadCorv025"){
    $RadCorv025 = 'off';
    if($dato->RadCorv025 == 1){
        $RadCorv025 = 'on';
    }
    $link=Conectarse(); 
    $sql = "SELECT * FROM regcharpy Where idItem = '$dato->idItem' and nImpacto = '$dato->nImpacto'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE regcharpy SET ";
        $actSQL.="RadCorv025		='".$RadCorv025.	    "'";
        $actSQL.="WHERE idItem	    = '$dato->idItem' and nImpacto = '$dato->nImpacto'";
        $bdCot=$link->query($actSQL);
    }
    $link->close();    
}

if($dato->accion == "actDes"){
    $activar = 'off';
    $actCheck = false;
    $link=Conectarse(); 
    $sql = "SELECT * FROM regcharpy Where idItem = '$dato->idItem' and nImpacto = '$dato->nImpacto'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){
        if($rs['actCheck']){
            $actCheck = false;
            $activar = 'off';
        }else{
            $actCheck = true;            
            $activar = 'on';
        }
        $actSQL="UPDATE regcharpy SET ";
        $actSQL.="actCheck		    ='".$actCheck.	    "',";
        $actSQL.="CosProbMen4Ra		='".$activar.	    "',";
        $actSQL.="CarEntMen2Ra		='".$activar.	    "',";
        $actSQL.="Prob55		    ='".$activar.	    "',";
        $actSQL.="CentEnt27		    ='".$activar.	    "',";
        $actSQL.="AngEnt45		    ='".$activar.	    "',";
        $actSQL.="ProfEnt2mm		='".$activar.	    "',";
        $actSQL.="RadCorv025		='".$activar.	    "'";
        $actSQL.="WHERE idItem	    = '$dato->idItem' and nImpacto = '$dato->nImpacto'";
        $bdCot=$link->query($actSQL);
    }
    $link->close();    
}
if($dato->accion == "guardarfechaRegistroEnsayo"){
    $link=Conectarse(); 
    $sql = "SELECT * FROM regcharpy Where idItem = '$dato->idItem'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE regcharpy SET ";
        $actSQL.="fechaRegistro		='".$dato->fechaRegistro.	    "'";
        $actSQL.="WHERE idItem	    = '$dato->idItem'";
        $bdCot=$link->query($actSQL);
    }
    $link->close();    
}
if($dato->accion == "cambiaObsOtam"){ 
    $link=Conectarse(); 
    $sql = "SELECT * FROM otams Where Otam = '$dato->Otam'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE otams SET ";
        $actSQL.="ObsOtam		='".$dato->ObsOtam.	    "'";
        $actSQL.="WHERE Otam	= '$dato->Otam'";
        $bdCot=$link->query($actSQL);
    }
    $link->close();    
}
if($dato->accion == "cerrarEnsayoCh"){
    $Estado = 'R';
    $link=Conectarse(); 
    $sql = "SELECT * FROM otams Where Otam = '$dato->Otam'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE otams SET ";
        $actSQL.="Estado		='".$Estado.	    "'";
        $actSQL.="WHERE Otam	= '$dato->Otam'";
        $bdCot=$link->query($actSQL);
    }
    $link->close();    
}
if($dato->accion == "cambiaTemAmbiente"){
    $link=Conectarse(); 
    $sql = "SELECT * FROM otams Where Otam = '$dato->Otam'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE otams SET ";
        $actSQL.="TemAmb		='".$dato->TemAmb.	    "'";
        $actSQL.="WHERE Otam	= '$dato->Otam'";
        $bdCot=$link->query($actSQL);
    }
    $link->close();    
}
if($dato->accion == "cambiaTemEnsayo"){
    $link=Conectarse(); 
    $sql = "SELECT * FROM otams Where Otam = '$dato->Otam'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE otams SET ";
        $actSQL.="Tem		    ='".$dato->Tem.	    "'";
        $actSQL.="WHERE Otam	= '$dato->Otam'";
        $bdCot=$link->query($actSQL);
    }
    $link->close();    
}
if($dato->accion == "cambiaHumEnsayo"){
    $link=Conectarse(); 
    $sql = "SELECT * FROM otams Where Otam = '$dato->Otam'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE otams SET ";
        $actSQL.="Hum		    ='".$dato->Hum.	    "'";
        $actSQL.="WHERE Otam	= '$dato->Otam'";
        $bdCot=$link->query($actSQL);
    }
    $link->close();    
}
if($dato->accion == "cambiarEstado"){
    $Estado = 'R';
    $link=Conectarse(); 
    $sql = "SELECT * FROM otams Where Otam = '$dato->Otam'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE otams SET ";
        $actSQL.="Estado		='".$Estado.	    "'";
        $actSQL.="WHERE Otam	= '$dato->Otam'";
        $bdCot=$link->query($actSQL);
    }
    $link->close();    
}
if($dato->accion == "cambiatecnico"){
    $Estado = 'R';
    $link=Conectarse(); 
    $sql = "SELECT * FROM otams Where Otam = '$dato->Otam'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE otams SET ";
        $actSQL.="Estado		='".$Estado.	    "',";
        $actSQL.="tecRes		='".$dato->tecRes.	    "'";
        $actSQL.="WHERE Otam	= '$dato->Otam'";
        $bdCot=$link->query($actSQL);
    }
    $link->close();    
}
if($dato->accion == "cambiaEntalle"){
    $link=Conectarse(); 
    $sql = "SELECT * FROM regcharpy Where idItem = '$dato->idItem'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE regcharpy SET ";
        $actSQL.="Entalle		='".$dato->Entalle.	    "'";
        $actSQL.="WHERE idItem	= '$dato->idItem'";
        $bdCot=$link->query($actSQL);
    }


    $calA = 0.9061;
    //$calB = 2.7885;
    $calB = 0.7885;
    $bdCAL=$link->query("Select * From calibraciones Where idEnsayo = 'Ch'");
    if($rowCAL=mysqli_fetch_array($bdCAL)){
            $calA 			= $rowCAL['calA'];
            $calB 			= $rowCAL['calB'];
            $EquilibrioX 	= $rowCAL['EquilibrioX'];
            $calC 			= $rowCAL['calC'];
            $calD 			= $rowCAL['calD'];
    }

    $sql = "SELECT * FROM regcharpy Where idItem = '$dato->idItem'";
    $bd=$link->query($sql);
    while($rs = mysqli_fetch_array($bd)){
        $nImpacto = $rs['nImpacto'];
        $criterio = 80;
        $Entalle = 'Sin';
        $y = 0;
        if($rs['mm'] == 10.0) { $criterio = 80;     }
        if($rs['mm'] == 7.5 ) { $criterio = 60;     }
        if($rs['mm'] == 6.7 ) { $criterio = 53.6;   }
        if($rs['mm'] == 5.0 ) { $criterio = 40;     }
        if($rs['mm'] == 3.3 ) { $criterio = 26.4;   }
        if($rs['mm'] == 2.5 ) { $criterio = 20;     } 

        if(($rs['Ancho'] * $rs['Alto']) > 0){ 
            if($rs['mm'] < 10 and $rs['Entalle'] == 'Con'){
                $y = ($rs['resEquipo'] * $criterio) / ($rs['Ancho'] * ($rs['Alto'] - 2));
            }else{
                $criterio = 100;
                $y = ($rs['resEquipo'] * $criterio) / ($rs['Ancho'] * $rs['Alto']);
            }
        }

        if($rs['resEquipo'] <= $EquilibrioX){
            $vImpacto = ($calA * $y) + ($calB);
        }
        if($rs['resEquipo'] > $EquilibrioX){
            $vImpacto = ($calC * $y) + ($calD);
        }
        if($y == 0){
            $vImpacto = 0;
        }else{
            // vImpacto = 22.2

            $vImpactoDec = ($vImpacto - intval($vImpacto)) * 10;
            $vImpactoRes = intval($vImpacto) / 2 - intval(intval($vImpacto) / 2);
            
            if($vImpactoRes == 0){
                if(intval($vImpactoDec) == 1 or intval($vImpactoDec) == 2 or intval($vImpactoDec) == 3){
                    $vImpacto = intval($vImpacto);
                }
                if(intval($vImpactoDec) == 4 or intval($vImpactoDec) == 5 or intval($vImpactoDec) == 6 or intval($vImpactoDec) == 7){
                    $vImpacto = intval($vImpacto)+0.4;
                }
                if(intval($vImpactoDec) == 8 or intval($vImpactoDec) == 9){
                    $vImpacto = intval($vImpacto)+0.8;
                }
            }else{
                if(intval($vImpactoDec) == 0 or intval($vImpactoDec) == 1){
                    $vImpacto = (intval($vImpacto) - 1) + 0.8;
                    //$vImpacto = $vImpacto;
                }
                if(intval($vImpactoDec) == 2 or intval($vImpactoDec) == 3 or intval($vImpactoDec) == 4 or intval($vImpactoDec) == 5){
                    $vImpacto = intval($vImpacto)+0.2;
                }
                if(intval($vImpactoDec) == 6 or intval($vImpactoDec) == 7 or intval($vImpactoDec) == 8 or intval($vImpactoDec) == 9){
                    $vImpacto = intval($vImpacto)+0.6;
                }
            }
            //$vImpacto = $vImpactoRes;

        }

        $actSQL="UPDATE regcharpy SET ";
        $actSQL.="vImpacto		    ='".$vImpacto.	            "'";
        $actSQL.="WHERE idItem	    = '$dato->idItem' and nImpacto = '$nImpacto'";
        $bdCot=$link->query($actSQL);

    }




    $link->close();    
}
if($dato->accion == "cambiaMilimetros"){
    $link=Conectarse(); 
    $sql = "SELECT * FROM regcharpy Where idItem = '$dato->idItem'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE regcharpy SET ";
        $actSQL.="mm		    ='".$dato->mm.	    "'";
        $actSQL.="WHERE idItem	= '$dato->idItem'";
        $bdCot=$link->query($actSQL);
    }


    $calA = 0.9061;
    //$calB = 2.7885;
    $calB = 0.7885;
    $bdCAL=$link->query("Select * From calibraciones Where idEnsayo = 'Ch'");
    if($rowCAL=mysqli_fetch_array($bdCAL)){
            $calA 			= $rowCAL['calA'];
            $calB 			= $rowCAL['calB'];
            $EquilibrioX 	= $rowCAL['EquilibrioX'];
            $calC 			= $rowCAL['calC'];
            $calD 			= $rowCAL['calD'];
    }

    $sql = "SELECT * FROM regcharpy Where idItem = '$dato->idItem'";
    $bd=$link->query($sql);
    while($rs = mysqli_fetch_array($bd)){
        $nImpacto = $rs['nImpacto'];
        $criterio = 80;
        $Entalle = 'Sin';
        $y = 0;
        if($rs['mm'] == 10.0) { $criterio = 80;     }
        if($rs['mm'] == 7.5 ) { $criterio = 60;     }
        if($rs['mm'] == 6.7 ) { $criterio = 53.6;   }
        if($rs['mm'] == 5.0 ) { $criterio = 40;     }
        if($rs['mm'] == 3.3 ) { $criterio = 26.4;   }
        if($rs['mm'] == 2.5 ) { $criterio = 20;     } 
        if(($rs['Ancho'] * $rs['Alto']) > 0){ 
            if($rs['mm'] < 10 and $rs['Entalle'] == 'Con'){
                $y = ($rs['resEquipo'] * $criterio) / ($rs['Ancho'] * ($rs['Alto'] - 2));
            }else{
                $criterio = 100;
                $y = ($rs['resEquipo'] * $criterio) / ($rs['Ancho'] * $rs['Alto']);
            }
        }
        
        if($rs['resEquipo'] <= $EquilibrioX){
            $vImpacto = ($calA * $y) + ($calB);
        }
        if($rs['resEquipo'] > $EquilibrioX){
            $vImpacto = ($calC * $y) + ($calD);
        }
        if($y == 0){
            $vImpacto = 0;
        }else{
            // vImpacto = 22.2

            $vImpactoDec = ($vImpacto - intval($vImpacto)) * 10;
            $vImpactoRes = intval($vImpacto) / 2 - intval(intval($vImpacto) / 2);
            
            if($vImpactoRes == 0){
                if(intval($vImpactoDec) == 1 or intval($vImpactoDec) == 2 or intval($vImpactoDec) == 3){
                    $vImpacto = intval($vImpacto);
                }
                if(intval($vImpactoDec) == 4 or intval($vImpactoDec) == 5 or intval($vImpactoDec) == 6 or intval($vImpactoDec) == 7){
                    $vImpacto = intval($vImpacto)+0.4;
                }
                if(intval($vImpactoDec) == 8 or intval($vImpactoDec) == 9){
                    $vImpacto = intval($vImpacto)+0.8;
                }
            }else{
                if(intval($vImpactoDec) == 0 or intval($vImpactoDec) == 1){
                    $vImpacto = (intval($vImpacto) - 1) + 0.8;
                    //$vImpacto = $vImpacto;
                }
                if(intval($vImpactoDec) == 2 or intval($vImpactoDec) == 3 or intval($vImpactoDec) == 4 or intval($vImpactoDec) == 5){
                    $vImpacto = intval($vImpacto)+0.2;
                }
                if(intval($vImpactoDec) == 6 or intval($vImpactoDec) == 7 or intval($vImpactoDec) == 8 or intval($vImpactoDec) == 9){
                    $vImpacto = intval($vImpacto)+0.6;
                }
            }
            //$vImpacto = $vImpactoRes;

        }


        $actSQL="UPDATE regcharpy SET ";
        $actSQL.="vImpacto		    ='".$vImpacto.	            "'";
        $actSQL.="WHERE idItem	    = '$dato->idItem' and nImpacto = '$nImpacto'";
        $bdCot=$link->query($actSQL);

    }




    $link->close();    
}


if($dato->accion == "LecturaImpactos"){
    $res = '';
    $link=Conectarse();
    $SQL = "SELECT * FROM regcharpy Where idItem = '$dato->idItem' Order By nImpacto Desc";
    $bd=$link->query($SQL);
    if($rs = mysqli_fetch_array($bd)){
        $fechaDB = trim($rs["fechaRegistro"]);
        if (empty($fechaDB) || $fechaDB == '0000-00-00' || $fechaDB == '0000-00-00 00:00:00') {
            // Usamos el formato DATE de MySQL (Y-m-d)
            $fechaRegistro = date("Y-m-d"); 
        } else {
            // Si tiene datos válidos, usamos el valor de la BD
            $fechaRegistro = $fechaDB;
        }

        $actSQL="UPDATE regcharpy SET ";
        $actSQL.="fechaRegistro		    ='".$fechaRegistro.	            "'";
        $actSQL.="WHERE idItem	    = '$dato->idItem'";
        $bdCot=$link->query($actSQL);

        $Tem    = '';
        $Hum    = '';
        $TemAmb = '';
        $tecRes = '';

        $Equipo = 'Imp-01';
        if($rs['Equipo'] == ''){
            $actSQL="UPDATE regcharpy SET ";
            $actSQL.="Equipo		    ='".$Equipo.	            "'";
            $actSQL.="WHERE idItem	    = '$dato->idItem'";
            $bdCot=$link->query($actSQL);
        }else{
            $Equipo = $rs['Equipo'];
        }
        $sqlOt  = "SELECT * FROM otams Where Otam = '$dato->idItem'";
        $bdOt=$link->query($sqlOt);
        if($rsOt = mysqli_fetch_array($bdOt)){
            $Tem     = $rsOt['Tem'];
            $Hum     = $rsOt['Hum'];
            $TemAmb  = $rsOt['TemAmb'];
            $ObsOtam = $rsOt['ObsOtam'];
            $tecRes  = $rsOt['tecRes'];
        }
            
        $res.= '{"CodInforme":"'.			$rs['CodInforme'].					'",';
        $res.= '"tpMuestra":"'.	            $rs["tpMuestra"]. 				    '",';
        $res.= '"mm":"'.	                $rs["mm"]. 	                        '",';
        $res.= '"nImpacto":"'.	            $rs["nImpacto"]. 				    '",';
        $res.= '"actCheck":"'.	            $rs["actCheck"]. 	                '",';
        $res.= '"Entalle":"'.	            $rs["Entalle"]. 	                '",';
        $res.= '"Equipo":"'.	            $Equipo. 				            '",';
        $res.= '"Hum":"'.	                $Hum. 	                            '",';
        $res.= '"Tem":"'.	                $Tem. 	                            '",';
        $res.= '"TemAmb":"'.	            $TemAmb. 	                        '",';
        $res .= '"ObsOtam":' 			    .json_encode($ObsOtam, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
        // $res.= '"ObsOtam":"'.	            $ObsOtam. 	                        '",';
        $res.= '"tecRes":"'.	            $tecRes. 	                        '",';
        
        $res.= '"fechaRegistro":"'.			$rs['fechaRegistro'].		        '"}';
    }
    $link->close();
    echo $res;	
}

if($dato->accion == "LecturaRegImpactos"){
    $outp = "";
    $sImpactos = 0;
    $Media = 0;
    $i = 0;
    $link=Conectarse();
    
    $SQL = "SELECT * FROM regcharpy Where idItem = '$dato->idItem' Order By nImpacto Asc";
    $bd=$link->query($SQL);
    while($rs = mysqli_fetch_array($bd)){   
        $i++;
        $sImpactos += $rs['vImpacto'];
        $Media = $sImpactos / $i;
        if ($outp != "") {$outp .= ",";}
        $outp.= '{"nImpacto":"'.				$rs["nImpacto"].					'",';
        $outp.= '"idItem":"'.				    $rs["idItem"]. 				        '",';
        $outp.= '"tpMuestra":"'.				$rs["tpMuestra"]. 				    '",';
        $outp.= '"actCheck":"'.				    $rs["actCheck"]. 				    '",';
        // $outp.= '"Tem":"'.				        $rs["Tem"]. 				        '",';
        $outp.= '"Ancho":"'.				    $rs["Ancho"]. 				        '",';
        $outp.= '"Alto":"'.				        $rs["Alto"]. 				        '",';
        $outp.= '"resEquipo":"'.				$rs["resEquipo"]. 				    '",';
        $outp.= '"mm":"'.				        $rs["mm"]. 				            '",';
        $outp.= '"Entalle":"'.				    $rs["Entalle"]. 				    '",';
        $outp.= '"CosProbMen4Ra":"'.	        trim($rs["CosProbMen4Ra"]). 	    '",';
        $outp.= '"CarEntMen2Ra":"'.	            trim($rs["CarEntMen2Ra"]). 	        '",';
        $outp.= '"Prob55":"'.	                trim($rs["Prob55"]). 	            '",';
        $outp.= '"CentEnt27":"'.	            trim($rs["CentEnt27"]). 	        '",';
        $outp.= '"AngEnt45":"'.	                trim($rs["AngEnt45"]). 	            '",';
        $outp.= '"ProfEnt2mm":"'.	            trim($rs["ProfEnt2mm"]). 	        '",';
        $outp.= '"RadCorv025":"'.	            trim($rs["RadCorv025"]). 	        '",';
        $outp.= '"eAbs":"'.	                    trim($rs["eAbs"]). 	                '",';
        $outp.= '"vImpacto":"'.	                $rs["vImpacto"]. 	                '",';
        $outp.= '"Media":"'.	                $Media. 	                        '",';
        $outp.= '"fechaRegistro":"'. 		    $rs["fechaRegistro"]. 				'"}';
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
if($dato->accion == "respaldaEnsayo"){
    header('Location: formularios/otamCharpy.php?accion=Imprimir&RAM='.$dato->RAM.'&Otam='.$dato->Otam.'&CodInforme='.$dato->CodInforme);
}


?>