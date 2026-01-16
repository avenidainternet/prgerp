<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
date_default_timezone_set("America/Santiago");

$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php"); 

if($dato->accion == "guardarDistancia"){

    $link=Conectarse(); 
    $sql = "SELECT * FROM regdoblado Where idItem = '$dato->idItem' and nIndenta = '$dato->nIndenta'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE regdoblado SET ";
        $actSQL.="Distancia		    ='".$dato->Distancia.	    "'";
        $actSQL.="WHERE idItem	    = '$dato->idItem' and nIndenta = '$dato->nIndenta'";
        $bdCot=$link->query($actSQL);
    }
    $link->close();
    
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
if($dato->accion == "LecturaRegDurezasPerfiles"){
    $outp = "";
    $link=Conectarse();
    
    $SQL = "SELECT * FROM regdoblado Where idItem = '$dato->idItem' Order By nIndenta Asc";
    $bd=$link->query($SQL);
    while($rs = mysqli_fetch_array($bd)){   
        if ($outp != "") {$outp .= ",";}
        $outp.= '{"nIndenta":"'.				$rs["nIndenta"].					'",';
        $outp.= '"Distancia":"'.				$rs["Distancia"]. 				    '",';
        $outp.= '"Dureza":"'. 				    $rs["Dureza"]. 				        '"}';
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