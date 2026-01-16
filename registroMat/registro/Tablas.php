<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include_once("../../conexionli.php"); 

if($dato->accion=='L'){ 
    $outp = "";
    $link=Conectarse();
    $Copias = 0;

        $SQL = "Select * From registromuestras Where RAM = '$dato->RAM' and Fan = '0'";
        $bd=$link->query($SQL);
        if($rs = mysqli_fetch_array($bd)){
            $Copias = $rs['Copias'];
        }

    $SQL = "Select * From registromuestras Where RAM = '$dato->RAM' and Fan = '$dato->Fan'";
    $bd=$link->query($SQL);
    while($rs = mysqli_fetch_array($bd)){

        $Cliente = '';
      
        $SQLcl = "Select * From clientes Where RutCli = '".$rs['RutCli']."'";
        $bdcl=$link->query($SQLcl);
        if($rscl = mysqli_fetch_array($bdcl)){
            $Cliente = $rscl['Cliente'];
        }
  
        $outp .= '{"CAM":"'  . 				$rs["CAM"]. 				'",';
        $outp .= '"RAM":"'. 				$rs["RAM"]. 				'",';
        $outp .= '"Fan":"'. 				$rs["Fan"]. 				'",';
        $outp .= '"fechaRegistro":"'. 		$rs["fechaRegistro"]. 		'",';
	    $outp .= '"Descripcion":' 			.json_encode($rs["Descripcion"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
        $outp .= '"Cliente":"'. 		    $Cliente. 		            '",';
        $outp .= '"Copias":"'. 		        $Copias. 		            '",';
        $outp .= '"RutCli":"'. 			    $rs["RutCli"]. 			    '"}';
    }
    //$outp ='{"records":['.$outp.']}';
    $link->close();
    echo $outp;
}
if($dato->accion=='LCli'){
    $outp = "";
    $link=Conectarse();
    $SQL = "Select * From clientes where Estado = 'on' Order By Cliente";
    $bd=$link->query($SQL);
    while($rs = mysqli_fetch_array($bd)){
        if ($outp != "") {$outp .= ",";}
        $outp .= '{"RutCli":"'  . 			$rs["RutCli"]. 				'",'; 
        $outp .= '"Cliente":' 				.json_encode($rs["Cliente"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
        $outp .= '"Direccion":' 			.json_encode($rs["Direccion"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
        $outp .= '"cFree":"'. 				$rs["cFree"]. 				'",';
        $outp .= '"Docencia":"'. 			$rs["Docencia"]. 			'",';
        $outp .= '"Clasificacion":"'. 		$rs["Clasificacion"]. 		'"}';
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);
}

if($dato->accion=='LCon'){
    $outp = "";
    $link=Conectarse();
    $SQL = "Select * From contactoscli where RutCli = '$dato->RutCli' Order By Contacto";
    $bd=$link->query($SQL);
    while($rs = mysqli_fetch_array($bd)){
        if ($outp != "") {$outp .= ",";}
        $outp .= '{"RutCli":"'  . 			$rs["RutCli"]. 				'",';
        $outp .= '"nContacto":"'. 			$rs["nContacto"]. 			'",';
        $outp .= '"Contacto":"'. 			trim($rs["Contacto"]). 		'",';
        $outp .= '"Email":"'. 				trim($rs["Email"]). 		'",';
        $outp .= '"Telefono":"'. 			trim($rs["Telefono"]). 		'"}';

    }
    $outp ='{"records":['.$outp.']}';

    $link->close();
    echo ($outp);
}

if($dato->accion=='LUsr'){
    $outp = "";
    $link=Conectarse();
    $SQL = "Select * From usuarios Where nPerfil = 1 and usr != 'Alfredo.Artigas'";
    $bd=$link->query($SQL);
    while($rs = mysqli_fetch_array($bd)){
        if ($outp != "") {$outp .= ",";}
        $outp .= '{"usr":"'  . 				$rs["usr"]. 				'",';
        $outp .= '"usuario":"'. 			$rs["usuario"]. 			'",';
        $outp .= '"nPerfil":"'. 			$rs["nPerfil"]. 			'",';
        $outp .= '"email":"'. 				$rs["email"]. 				'",';
        $outp .= '"cargoUsr":"'. 			$rs["cargoUsr"]. 			'",';
        $outp .= '"responsableInforme":"'. 	$rs["responsableInforme"]. 	'",';
        $outp .= '"apruebaOfertas":"'. 		$rs["apruebaOfertas"]. 		'"}';
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);
}
if($dato->accion=='DarDeBajaRAM'){
    $link=Conectarse();

    $situacionMuestra = 'B';
    $CAM = 0;
    $actSQL="UPDATE registromuestras SET ";
    $actSQL.="situacionMuestra	='".$situacionMuestra.				"'";
    $actSQL.="WHERE RAM			= '$dato->RAM' and CAM = '$dato->CAM' and Fan = '$dato->Fan'";
    $bdRam=$link->query($actSQL);

    $RAM = 0;
    $Fan = 0;
    $actSQL="UPDATE cotizaciones SET ";
    $actSQL.="RAM	 			='".$RAM.				"',";
    $actSQL.="Fan	 			='".$Fan.				"'";
    $actSQL.="WHERE RAM			= '$dato->RAM' and CAM = '$dato->CAM' and Fan = '$dato->Fan'";
    $bdRam=$link->query($actSQL);

    $link->close();
}
if($dato->accion=='DCR'){
    $link=Conectarse();

    $situacionMuestra = 'B';
    $CAM = 0;
    $actSQL="UPDATE registromuestras SET ";
    $actSQL.="CAM	 			='".$CAM.				"'";
    $actSQL.="WHERE RAM			= '$dato->RAM' and Fan = '$dato->Fan'";
    $bdRam=$link->query($actSQL);

    $actSQL="UPDATE cotizaciones SET ";
    $RAM = 0;
    $Fan = 0;
    $actSQL.="RAM	 			='".$RAM.				"',";
    $actSQL.="Fan	 			='".$Fan.				"'";
    $actSQL.="WHERE CAM			= '$dato->CAM'";
    $bdRam=$link->query($actSQL);

    $link->close();
}
if($dato->accion=='ACR'){
    $link=Conectarse();

    $situacionMuestra = 'B';
    $bd=$link->query("Select * From registromuestras Where RAM = '$dato->RAM' and Fan = '$dato->Fan'");
    if($rs=mysqli_fetch_array($bd)){
        if($rs['CAM'] > 0){
            if($rs['CAM'] != $dato->CAM){
                $RAM = 0;
                $Fan = 0;
                $actSQL="UPDATE cotizaciones SET ";
                $actSQL.="RAM	 			='".$RAM.				"',";
                $actSQL.="Fan	 			='".$Fan.				"'";
                $actSQL.="WHERE CAM			= '".$rs['CAM']."'";
                $bdRam=$link->query($actSQL);
            }
        }
    }

    $actSQL="UPDATE registromuestras SET ";
    $actSQL.="CAM	 			='".$dato->CAM.				"'";
    $actSQL.="WHERE RAM			= '$dato->RAM' and Fan = '$dato->Fan'";
    $bdRam=$link->query($actSQL);

    $actSQL="UPDATE cotizaciones SET ";
    $actSQL.="Fan	 			='".$dato->Fan.				"',";
    $actSQL.="RAM	 			='".$dato->RAM.				"'";
    $actSQL.="WHERE CAM			= '$dato->CAM'";
    $bdRam=$link->query($actSQL);

    $link->close();
}
if($dato->accion=='AM'){
    $outp = "";
    $link=Conectarse();
    $bd=$link->query("Select * From registromuestras Order By RAM Desc");
    if($rs=mysqli_fetch_array($bd)){
        $RAM = $rs["RAM"] + 1;
        $outp .= '{"RAM":"'  . 				$RAM. 				'"}';
    }
    $situacionMuestra = 'R';
    $CAM = 0;

    if($RAM){
		// **************************************************************************
		// Crea carpetas tanto en AAA como en el Local si no existiesen
		// **************************************************************************
		//$am = explode('-',$CodInforme);
		//$ramAm = $am[1];
        $ramAm = $RAM;
        /*
		$directorioAM = 'Y://AAA/LE/LABORATORIO/MUESTRAS-'.$ramAm;
		if(!file_exists($directorioAM)){
			mkdir($directorioAM);
		}
        */
		$directorioImpactosLocal = '../../Archivador-AM';
		if(!file_exists($directorioImpactosLocal)){
			mkdir($directorioImpactosLocal);
			$directorioImpactosLocalRam = $directorioImpactosLocal.'/'.$ramAm;
			if(!file_exists($directorioImpactosLocalRam)){
				mkdir($directorioImpactosLocalRam);
			}
		}else{
			$directorioImpactosLocalRam = $directorioImpactosLocal.'/'.$ramAm;
			if(!file_exists($directorioImpactosLocalRam)){
				mkdir($directorioImpactosLocalRam);
			}
		}
	}


    $link->query("insert into registromuestras(	RAM,
                                                CAM,
                                                fechaRegistro,
                                                RutCli,
                                                Descripcion,
                                                situacionMuestra
                                                ) 
                                    values 	(	'$RAM',
                                                '$CAM',
                                                '$dato->fechaRegistro', 
                                                '$dato->RutCli',
                                                '$dato->Descripcion',
                                                '$situacionMuestra'
    )");

    $link->close();
    echo $outp;
}
if($dato->accion=='G'){
    $link=Conectarse();
    //$bdRam=mysql_query("Select * From registroMuestras Where RAM = '$dato->RAM' and Fan = '$dato->Fan'");
    $bd=$link->query("Select * From registromuestras Where RAM = '$dato->RAM' and Fan = '$dato->Fan'");
    if($rs=mysqli_fetch_array($bd)){
        $situacionMuestra = 'R';
        if($dato->CAM > 0){
            $situacionMuestra = 'P';
        }
        $Copias = $rs['Copias'];
        if($dato->Copias == 0){
            if($Copias > 0 ){
                $bd=$link->query("Delete From registromuestras Where RAM = '$dato->RAM' and Fan > '0'");
                $Copias = 0;
            }
        }else{
            if($dato->Copias != $Copias){
                $bd=$link->query("Delete From registromuestras Where RAM = '$dato->RAM' and Fan > '0'");
                $Copias = $dato->Copias;
                for($i=1; $i<=$Copias; $i++){
                    $situacionMuestra = 'R';
                    $link->query("insert into registromuestras(	RAM,
                                                                Fan,
                                                                fechaRegistro,
                                                                RutCli,
                                                                Descripcion,
                                                                situacionMuestra
                                                            ) 
                                                    values 	(	'$dato->RAM',
                                                                '$i',
                                                                '$dato->fechaRegistro',
                                                                '$dato->RutCli',
                                                                '$dato->Descripcion',
                                                                '$situacionMuestra'
                                                            )");
                }
            }
        }

        if($dato->Fan > 0){ $Copias = 0; }
        $actSQL="UPDATE registromuestras SET ";
        $actSQL.="CAM	 			='".$dato->CAM.				"',";
        $actSQL.="Fan	 			='".$dato->Fan.				"',";
        $actSQL.="Copias	 		='".$Copias.			    "',";
        $actSQL.="fechaRegistro	 	='".$dato->fechaRegistro.	"',";
        //$actSQL.="usrRecepcion 	 	='".$dato->usrRecepcion.	"',";
        $actSQL.="RutCli 			='".$dato->RutCli.			"',";
        //$actSQL.="nContacto			='".$dato->nContacto.		"',";
        $actSQL.="Descripcion		='".$dato->Descripcion.		"',";
        $actSQL.="situacionMuestra	='".$situacionMuestra.	    "'";
        $actSQL.="WHERE RAM			= '$dato->RAM' and Fan = '$dato->Fan'";
        $bdRam=$link->query($actSQL);
    }else{
        $situacionMuestra = 'R';
        $link->query("insert into registromuestras(	RAM,
                                                    CAM,
                                                    fechaRegistro,
                                                    usrRecepcion,
                                                    RutCli,
                                                    nContacto,
                                                    Descripcion,
                                                    situacionMuestra
                                                    ) 
                                        values 	(	'$RAM',
                                                    '$dato->CAM',
                                                    '$dato->fechaRegistro',
                                                    '$dato->usrRecepcion',
                                                    '$dato->RutCli',
                                                    '$dato->nContacto',
                                                    '$dato->Descripcion',
                                                    '$situacionMuestra'
        )");
    }

}

?>