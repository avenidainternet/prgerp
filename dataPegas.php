<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
date_default_timezone_set("America/Santiago");

$dato = json_decode(file_get_contents("php://input"));

include("conexionli.php"); 

if($dato->accion == "Seguimiento"){

    $link=Conectarse(); 

    $sql = "SELECT * FROM actividades Where idActividad = '$dato->idActividad'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){
        $fechaHoy = date('Y-m-d');
        $prgActividad = $fechaHoy;
        $tpoProx = $rs['tpoProx'];
        $fechaProxAct	= strtotime ( '+'.$tpoProx.' day' , strtotime ( $fechaHoy ) );
        $fechaProxAct	= date ( 'Y-m-d' , $fechaProxAct );

        //$fechaProxAct = date("d-m-Y",strtotime($fechaHoy."+ ". $tpoProx." days"));

        $actSQL="UPDATE Actividades SET ";
        $actSQL.="prgActividad		='".$prgActividad.	        "',";
        $actSQL.="Comentarios		='".$fechaProxAct.	        "',";
        $actSQL.="fechaProxAct		='".$fechaProxAct.	        "'";
        $actSQL.="WHERE idActividad	= '".$dato->idActividad.    "'";
        $bdCot=$link->query($actSQL);

    }
    $link->close();
    
}
if($dato->accion == "Grabar"){
    $Acreditado = 'off';
    $actRepetitiva = 'off';
    $fecha = $dato->aa.'/'.$dato->mm.'/'.$dato->dd;
    if($dato->Acreditado == 1){ $Acreditado = 'on'; }
    if($dato->actRepetitiva == 1){ $actRepetitiva = 'on'; }
    $link=Conectarse(); 
    $sql = "SELECT * FROM actividades Where idActividad = '$dato->idActividad'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE Actividades SET ";
        $actSQL.="Actividad			='".$dato->Actividad.		"',";
        $actSQL.="actRepetitiva		='".$actRepetitiva.	        "',";
        $actSQL.="Acreditado		='".$Acreditado.	        "',";
        $actSQL.="prgActividad		='".$dato->prgActividad.	"',";
        $actSQL.="tpoProx			='".$dato->tpoProx.		    "',";
        $actSQL.="tpoAvisoAct		='".$dato->tpoAvisoAct.	    "',";
        $actSQL.="fechaProxAct		='".$dato->fechaProxAct.	"',";
        $actSQL.="usrResponsable	='".$dato->usrResponsable.  "'";
        $actSQL.="WHERE idActividad	= '".$dato->idActividad.    "'";
        $bdCot=$link->query($actSQL);

    }else{
        $link->query("insert into Actividades(	
                                                idActividad,
                                                Actividad,
                                                actRepetitiva,
                                                Acreditado,
                                                prgActividad,
                                                tpoProx,
                                                tpoAvisoAct,
                                                fechaProxAct,
                                                usrResponsable
                                                ) 
                                    values 	(	
                                                '$dato->idActividad',
                                                '$dato->Actividad',
                                                '$actRepetitiva',
                                                '$Acreditado',
                                                '$dato->prgActividad',
                                                '$dato->tpoProx',
                                                '$dato->tpoAvisoAct',
                                                '$dato->fechaProxAct',
                                                '$dato->usrResponsable'
            )");

    }
    $link->close();
}
if($dato->accion == "Usuarios"){
    $outp = "";
    $link=Conectarse();
    
    $sql = "SELECT * FROM usuarios Where nPerfil = '1' and responsableInforme != 'off'";
    $bd=$link->query($sql);
    while($rs = mysqli_fetch_array($bd)){
        if ($outp != "") {$outp .= ",";}
        $outp.= '{"usr":"'.				$rs["usr"].					'"}';
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);    
  
}
if($dato->accion == "Pegas"){
    $outp = "";
    $link=Conectarse();
    
    $sql = "SELECT * FROM cotizaciones Where Estado = 'P' and usrResponzable != '' and RAM > 0 Order By usrResponzable";
    $bd=$link->query($sql);
    while($rs = mysqli_fetch_array($bd)){
        if ($outp != "") {$outp .= ",";}
        $outp.= '{"usrResponzable":"'.				$rs["usrResponzable"].					'",';
        $outp.= '"RAM":"'.				            $rs["RAM"].					            '"}';
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);    
  
}
if($dato->accion == "Editar"){
    $res = '';
    $link=Conectarse();
    $SQL = "SELECT * FROM actividades Where idActividad = '$dato->idActividad'";
    $bd=$link->query($SQL);
    if($rs = mysqli_fetch_array($bd)){
        $res.= '{"idActividad":"'.			$rs['idActividad'].					'",';
        $res.= '"tpoProx":"'.	            $rs["tpoProx"]. 				    '",';
        $res.= '"tpoAvisoAct":"'.	        $rs["tpoAvisoAct"]. 				'",';
        $res.= '"Acreditado":"'.	        $rs["Acreditado"]. 				    '",';
        $res.= '"Actividad":' 			    .json_encode($rs["Actividad"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
        $res.= '"prgActividad":"'.	        $rs["prgActividad"]. 	            '",';
        $res.= '"fechaProxAct":"'.	        $rs["fechaProxAct"]. 	            '",';
        $res.= '"usrResponsable":"'.	    $rs["usrResponsable"]. 	            '",';
        $res.= '"Estado":"'.			    $rs['Estado'].					    '"}';
    }
    $link->close();
    echo $res;	
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
if($dato->accion == "Lectura"){
    $outp = "";
    $link=Conectarse();
    
    $sql = "SELECT * FROM actividades Order By idActividad Desc, Estado, fechaAccionAct Desc";
    $bd=$link->query($sql);
    while($rs = mysqli_fetch_array($bd)){
        
        if ($outp != "") {$outp .= ",";}
        $outp.= '{"idActividad":"'.				$rs["idActividad"].					'",';
        $outp.= '"Acreditado":"'.				$rs["Acreditado"]. 				    '",';
        $outp.= '"Actividad":' 			        .json_encode($rs["Actividad"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
        $outp.= '"prgActividad":"'.	            $rs["prgActividad"]. 	            '",';
        $outp.= '"fechaProxAct":"'.	            $rs["fechaProxAct"]. 	            '",';
        $outp.= '"usrResponsable":"'.	        $rs["usrResponsable"]. 	            '",';
        $outp.= '"tpoAvisoAct":"'.	            $rs["tpoAvisoAct"]. 	            '",';
        $outp.= '"Estado":"'. 				    $rs["Estado"]. 				        '"}';
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);    
}


?>