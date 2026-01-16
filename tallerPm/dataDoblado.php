<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
date_default_timezone_set("America/Santiago");

$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php"); 

if($dato->accion == "guardarAncho"){

    $link=Conectarse(); 
    $sql = "SELECT * FROM regcharpy Where idItem = '$dato->idItem' and nImpacto = '$dato->nImpacto'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE regcharpy SET ";
        $actSQL.="Ancho		        ='".$dato->Ancho.	    "'";
        $actSQL.="WHERE idItem	    = '$dato->idItem' and nImpacto = '$dato->nImpacto'";
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

    $sql = "SELECT * FROM regcharpy Where idItem = '$dato->idItem' and nImpacto = '$dato->nImpacto'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){

        $criterio = 80;
        $Entalle = 'Sin';
        $y = 0;
        if($rs['mm'] == 10  ) { $criterio = 80;     }
        if($rs['mm'] == 7.5 ) { $criterio = 60;     }
        if($rs['mm'] == 6.7 ) { $criterio = 53.6;   }
        if($rs['mm'] == 5   ) { $criterio = 40;     }
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

    $link=Conectarse(); 
    $sql = "SELECT * FROM regcharpy Where idItem = '$dato->idItem' and nImpacto = '$dato->nImpacto'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE regcharpy SET ";
        $actSQL.="Alto		        ='".$dato->Alto.	    "'";
        $actSQL.="WHERE idItem	    = '$dato->idItem' and nImpacto = '$dato->nImpacto'";
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

    $sql = "SELECT * FROM regcharpy Where idItem = '$dato->idItem' and nImpacto = '$dato->nImpacto'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){

        $criterio = 80;
        $Entalle = 'Sin';
        $y = 0;
        if($rs['mm'] == 10  ) { $criterio = 80;     }
        if($rs['mm'] == 7.5 ) { $criterio = 60;     }
        if($rs['mm'] == 6.7 ) { $criterio = 53.6;   }
        if($rs['mm'] == 5   ) { $criterio = 40;     }
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
    $bdCAL=$link->query("Select * From calibraciones Where idEnsayo = 'Ch'");
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
        if($rs['mm'] == 10  ) { $criterio = 80;     }
        if($rs['mm'] == 7.5 ) { $criterio = 60;     }
        if($rs['mm'] == 6.7 ) { $criterio = 53.6;   }
        if($rs['mm'] == 5   ) { $criterio = 40;     }
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
        if($rs['mm'] == 10  ) { $criterio = 80;     }
        if($rs['mm'] == 7.5 ) { $criterio = 60;     }
        if($rs['mm'] == 6.7 ) { $criterio = 53.6;   }
        if($rs['mm'] == 5   ) { $criterio = 40;     }
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
        if($rs['mm'] == 10  ) { $criterio = 80;     }
        if($rs['mm'] == 7.5 ) { $criterio = 60;     }
        if($rs['mm'] == 6.7 ) { $criterio = 53.6;   }
        if($rs['mm'] == 5   ) { $criterio = 40;     }
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


if($dato->accion == "loadDoblado"){
    $res = '';
    $link=Conectarse();
    
    $SQL = "SELECT * FROM otams Where Otam = '$dato->Otam'";
    $bd=$link->query($SQL);
    if($rs = mysqli_fetch_array($bd)){
        $SQLd = "SELECT * FROM regdobladosreal Where idItem = '$dato->Otam'";
        $bdd=$link->query($SQLd);
        if($rsd = mysqli_fetch_array($bdd)){ 

        }
                
        $res.= '{"CodInforme":"'.			$rs['CodInforme'].					    '",';
        $res.= '"CAM":"'.	                $rs["CAM"]. 				            '",';
        $res.= '"RAM":"'.	                $rs["RAM"]. 	                        '",';
        $res.= '"idEnsayo":"'.	            $rs["idEnsayo"]. 	                    '",';
        $res.= '"tecRes":"'.	            $rs["tecRes"]. 	                        '",';
        $res.= '"Otam":"'.	                $rs["Otam"]. 	                        '",';
        $res.= '"idItem":"'.	            $rsd["idItem"]. 	                    '",';
        $res.= '"tpMuestra":"'.	            $rsd["tpMuestra"]. 	                    '",';
        $res.= '"fechaRegistro":"'.	        $rsd["fechaRegistro"]. 	                '",';
        $res.= '"Tem":"'.	                $rsd["Tem"]. 	                        '",';
        $res.= '"Hum":"'.	                $rsd["Hum"]. 	                        '",';
        $res.= '"normaRefDoblado":"'.	    $rsd["normaRefDoblado"]. 	            '",';
        $res.= '"nDiametroDoblado":"'.	    $rsd["nDiametroDoblado"]. 	            '",';
        $res.= '"Tipo":"'.	                $rsd["Tipo"]. 	                        '",';
        $res.= '"Observaciones":"'.	        $rsd["Observaciones"]. 	                '",';
        $res.= '"separacionApoyos":"'.	    $rsd["separacionApoyos"]. 	            '",';
        $res.= '"diametroPunzon":"'.	    $rsd["diametroPunzon"]. 	            '",';
        $res.= '"anguloAlcanzado":"'.	    $rsd["anguloAlcanzado"]. 	            '",';
        $res.= '"diametroFisuras":"'.	    $rsd["diametroFisuras"]. 	            '",';
        $res.= '"Condicion":"'.	            $rsd["Condicion"]. 	                    '",';
        $res.= '"usrResponsable":"'.	    $rsd["usrResponsable"]. 	            '",';
        $res.= '"Estado":"'.			    $rs['Estado'].		                    '"}';
    }
    
    $link->close();
    echo $res;	
}

if($dato->accion == "loadDiametros"){
    $outp = "";
    $link=Conectarse();
    $SQL = "SELECT * FROM diametrosdoblados Order By nDiametroDoblado Asc";
    $bd=$link->query($SQL);
    while($rs = mysqli_fetch_array($bd)){   
        if ($outp != "") {$outp .= ",";}
        $outp.= '{"nDiametroDoblado":"'.		$rs["nDiametroDoblado"].				'",';
        $outp.= '"diametroDoblado":"'. 		    $rs["diametroDoblado"]. 				'"}';
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);    
}

if($dato->accion == "loadNormaRef"){
    $outp = "";
    $link=Conectarse();
    $SQL = "SELECT * FROM normarefdoblado Order By normaRefDoblado Asc";
    $bd=$link->query($SQL);
    while($rs = mysqli_fetch_array($bd)){   
        if ($outp != "") {$outp .= ",";}
        $outp.= '{"normaRefDoblado":"'.		    $rs["normaRefDoblado"].				'",';
        $outp.= '"normaRef":"'. 		        $rs["normaRef"]. 		            '"}';
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);    
}

if($dato->accion == "loadTipo"){
    $outp = "";
    $link=Conectarse();
    $SQL = "SELECT * FROM tipodoblado Order By tipoDoblado Asc";
    $bd=$link->query($SQL);
    while($rs = mysqli_fetch_array($bd)){   
        if ($outp != "") {$outp .= ",";}
        $outp.= '{"tipoDoblado":"'.		        $rs["tipoDoblado"].				'",';
        $outp.= '"Tipo":"'. 		            $rs["Tipo"]. 		            '"}';
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);    
}

if($dato->accion == "loadObservaciones"){
    $outp = "";
    $link=Conectarse();
    $SQL = "SELECT * FROM obsDoblado Order By nObsDoblado Asc";
    $bd=$link->query($SQL);
    while($rs = mysqli_fetch_array($bd)){   
        if ($outp != "") {$outp .= ",";}
        $outp.= '{"nObsDoblado":"'.		        $rs["nObsDoblado"].				'",';
        $outp.= '"obsDoblado":"'. 		        $rs["obsDoblado"]. 		        '"}';
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);    
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
        $outp.= '"Tem":"'.				        $rs["Tem"]. 				        '",';
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


if($dato->accion == "grabarDoblado"){
    
    $link=Conectarse();
    $SQL = "SELECT * FROM regdobladosreal Where idItem = '$dato->Otam'";
    $bd=$link->query($SQL);
    if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE regdobladosreal SET ";
        $actSQL.="CodInforme	        ='".$dato->CodInforme.	        "',";
        $actSQL.="fechaRegistro         ='".$dato->fechaRegistro.	    "',";   
        $actSQL.="Tem                   ='".$dato->Tem.	                "',";
        $actSQL.="Hum                   ='".$dato->Hum.	                "',";
        $actSQL.="usrResponsable        ='".$dato->usrResponsable.	    "',";
        $actSQL.="separacionApoyos      ='".$dato->separacionApoyos.	"',";
        $actSQL.="nDiametroDoblado      ='".$dato->nDiametroDoblado.	"',";
        $actSQL.="diametroPunzon        ='".$dato->diametroPunzon.	    "',";
        $actSQL.="anguloAlcanzado       ='".$dato->anguloAlcanzado.	    "',";
        $actSQL.="diametroFisuras       ='".$dato->diametroFisuras.	    "',";
        $actSQL.="normaRefDoblado       ='".$dato->normaRefDoblado.	    "',";
        $actSQL.="Tipo                  ='".$dato->Tipo.	            "',";
        $actSQL.="Observaciones         ='".$dato->Observaciones.	    "',";
        $actSQL.="Condicion	            ='".$dato->Condicion.	        "'";
        $actSQL.="WHERE idItem	        = '$dato->Otam'";
        $bdCot=$link->query($actSQL);
    }
    $link->close();
}

/*
    }else{
        
        $link->query("insert into regdobladoread(	Otam,
                                                    CodInforme,
                                                    fechaRegistro,
                                                    Tem,
                                                    Hum,
                                                    usrResponsable,
                                                    separacionApoyos,
                                                    nDiametroDoblado,
                                                    diametroPunzon,
                                                    anguloAlcanzado,
                                                    diametroFisuras,
                                                    normaRefDoblado,
                                                    Tipo,
                                                    Observaciones,
                                                    Condicion
                                            ) 
                                    values 	(	    '$dato->Otam',
                                                    '$dato->CodInforme',
                                                    '$dato->fechaRegistro',
                                                    '$dato->Tem',
                                                    '$dato->Hum',
                                                    '$dato->usrResponsable',
                                                    '$dato->separacionApoyos',
                                                    '$dato->nDiametroDoblado',
                                                    '$dato->diametroPunzon',
                                                    '$dato->anguloAlcanzado',
                                                    '$dato->diametroFisuras',
                                                    '$dato->normaRefDoblado',
                                                    '$dato->Tipo',
                                                    '$dato->Observaciones',
                                                    '$dato->Condicion'
        )");
*/




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