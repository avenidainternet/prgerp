<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
date_default_timezone_set("America/Santiago");

$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php"); 


if($dato->accion == "bInforme"){
    $res = '';
    $link=Conectarse();
    $sql = "SELECT * FROM informes Where CodInforme = '$dato->CodInforme'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){
        $Cliente = '';
        $sqle = "SELECT * FROM clientes Where RutCli = '".$rs['RutCli']."'";
        $bde=$link->query($sqle);
        if($rse = mysqli_fetch_array($bde)){
            $Cliente = $rse['Cliente'];
        }
        $res.= '{"CodInforme":"'.			$rs['CodInforme'].					'",';
        $res.= '"CodigoVerificacion":"'.	$rs["CodigoVerificacion"]. 		    '",';
        $res.= '"IdProyecto":"'.	        $rs["IdProyecto"]. 				    '",';
        $res.= '"RutCli":"'.	            $rs["RutCli"]. 				        '",';
        $res.= '"informePDF":"'.	        $rs["informePDF"]. 				    '",';
        $res.= '"Detalle":' 			    .json_encode($rs["Detalle"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
        $res.= '"fechaUp":"'.	            $rs["fechaUp"]. 	                '",';
        $res.= '"DiaInforme":"'.	        $rs["DiaInforme"]. 	                '",';
        $res.= '"MesInforme":"'.	        $rs["MesInforme"]. 	                '",';
        $res.= '"AgnoInforme":"'.	        $rs["AgnoInforme"]. 	            '",';
        $res.= '"Cliente":"'.	            $Cliente. 	                        '",';
        $res.= '"estadoSituacion":"'.	    $rs['Estado'].					    '"}';
    }
    $link->close();
    echo $res;    
}

if($dato->accion == "generaCodigoVerificacion"){
    $res = '';
    $i=0; 
    $password=""; 
    $pw_largo = 12; 
    $desde_ascii = 50; // "2" 
    $hasta_ascii = 122; // "z" 
    $no_usar = array (58,59,60,61,62,63,64,73,79,91,92,93,94,95,96,108,111); 
    while ($i < $pw_largo) { 
        mt_srand ((double)microtime() * 1000000); 
        $numero_aleat = mt_rand ($desde_ascii, $hasta_ascii); 
        if (!in_array ($numero_aleat, $no_usar)) { 
            $password = $password . chr($numero_aleat); 
            $i++; 
        } 
    }
    $CodigoVerificacion = $password;
    $res.= '{"CodigoVerificacion":"'.	$CodigoVerificacion.	'"}';
    echo $res;
}

if($dato->accion == "ctrlRevisiones"){
    $link=Conectarse();
    if($dato->nMod == 8){
        $bdProv=$link->query("DELETE FROM regRevisiones WHERE CodInforme = '".$dato->CodInforme."'");
    }else{
        $bdProv=$link->query("DELETE FROM regRevisiones WHERE CodInforme = '".$dato->CodInforme."' and nMod = '8'");
    }
    $bd=$link->query("SELECT * FROM regrevisiones WHERE CodInforme = '".$dato->CodInforme."' and nMod = '".$dato->nMod."'");
    if($rs=mysqli_fetch_array($bd)){
        $bdProv=$link->query("DELETE FROM regRevisiones WHERE CodInforme = '".$dato->CodInforme."' && nMod = '".$dato->nMod."'");
    }else{
        $link->query("insert into regrevisiones(	CodInforme,
                                                    nMod,
                                                    fechaMod
                                                ) 
                                    values 		(	'$dato->CodInforme',
                                                    '$dato->nMod',
                                                    '$dato->fechaUp'
        )");
    }
    $link->close();
}
if($dato->accion == "guardarDatoInforme"){
    $link=Conectarse();
    $bdInf=$link->query("SELECT * FROM informes WHERE CodInforme = '".$dato->CodInforme."'");
    if($rowInf=mysqli_fetch_array($bdInf)){
        $actSQL="UPDATE informes SET ";
        $actSQL.="CodigoVerificacion	='".$dato->CodigoVerificacion.          "',";
        $actSQL.="fechaUp			    ='".$dato->fechaUp.		                "',";
        $actSQL.="Estado			    ='".$dato->estadoSituacion.		        "',";
        $actSQL.="Detalle				='".trim($dato->Detalle).		        "'";
        $actSQL.="Where CodInforme		= '".$dato->CodInforme."'";
        $bdInf=$link->query($actSQL);


        $bdRev=$link->query("SELECT * FROM regrevisiones WHERE CodInforme = '".$dato->CodInforme."'");
        if($rowRev=mysqli_fetch_array($bdRev)){
            $actSQL="UPDATE regRevisiones SET ";
            $actSQL.="fechaMod			='".$dato->fechaUp."' ";
            $actSQL.="WHERE CodInforme = '".$dato->CodInforme."'";
            $bdRev=$link->query($actSQL);
        }
        

    }else{
        $link->query("insert into informes(	CodInforme,
                                            RutCli,
                                            CodigoVerificacion,
                                            DiaInforme,
                                            MesInforme,
                                            AgnoInforme,
                                            IdProyecto,
                                            Estado,
                                            Detalle
                                        ) 
                            values 		(	'$CodInforme',
                                            '$RutCli',
                                            '$CodigoVerificacion',
                                            '$DiaInforme',
                                            '$MesInforme',
                                            '$AgnoInforme',
                                            '$IdProyecto',
                                            '$Estado',
                                            '$Detalle'
        )");
    }
    $link->close();
}

if($dato->accion == "leeRevisiones"){
    $outp = "";
    $link=Conectarse();
    
    $sql = "SELECT * FROM ItemsMod Order By nMod";
    $bd=$link->query($sql);
    while($rs = mysqli_fetch_array($bd)){  
             
        
        $Estado = 'off';
        $estModi = false;
        /*
        if($rs['nMod'] == 8 and $dato->Rev == 'No'){
            $Estado = 'on';
            $estModi = true;
        }
        */
        $sqlr = "SELECT * FROM regrevisiones Where CodInforme = '$dato->CodInforme' and nMod = '".$rs['nMod']."'";
        $bdr=$link->query($sqlr);
        if($rsr = mysqli_fetch_array($bdr)){
            $Estado = 'on';
        }

        if ($outp != "") {$outp .= ",";}
        $outp.= '{"nMod":"'.				    $rs["nMod"].					    '",';
        $outp.= '"Modificacion":' 			    .json_encode($rs["Modificacion"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
        $outp.= '"cMov":"'.	                    $rs["cMov"]. 	                    '",';
        $outp.= '"Estado":"'.	                $Estado. 	                        '",';
        $outp.= '"estModi":"'.	                $estModi. 	                        '",';
        $outp.= '"eCorreo":"'. 				    $rs["eCorreo"]. 				    '"}';
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);    
}

?>