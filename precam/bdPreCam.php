<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));
date_default_timezone_set('America/Santiago');

include("../conexionli.php"); 
$fechaHoy = date('Y-m-d'); 
$bColor = 'Normal';

if($dato->accion == 'leerUsuarios'){
    $link=Conectarse();
    $outp = "";
	$SQL = "Select * From usuarios where (nPerfil = 1 or nPerfil = '02') and status != 'off' Order By usuario";
    $bd=$link->query($SQL);
    while($rs = mysqli_fetch_array($bd)){
		if ($outp != "") {$outp .= ",";}
		$outp .= '{"usr":"'  . 		$rs["usr"]. 				    '",';
		$outp .= '"nPerfil":"'. 	$rs["nPerfil"]. 				'",';
		$outp.= '"usuario":'.       json_encode($rs["usuario"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
	    $outp .= '"email":"'. 		$rs["email"]. 			'"}';
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);


    $json_string = $outp;
    $file = 'usuarios.json';
    file_put_contents($file, $json_string);
        
}


if($dato->accion == 'cerrarPreCAM'){
    $link=Conectarse();
    $SQL = "SELECT * FROM precam where idPreCAM = '$dato->idPreCAM'"; 
    $bd=$link->query($SQL);
    if($rs=mysqli_fetch_array($bd)){
        $Estado = 'off';
        $actSQL="UPDATE precam SET ";
        $actSQL.="Estado			='".$Estado.                "'";
        $actSQL.="WHERE idPreCAM	='".$dato->idPreCAM."'";
        $bdCot=$link->query($actSQL);
    }
    $link->close();
}

if($dato->accion == 'guardarDatos'){
    $link=Conectarse();
    $SQL = "SELECT * FROM precam where idPreCAM = '$dato->idPreCAM'"; 
    $bd=$link->query($SQL);
    if($rs=mysqli_fetch_array($bd)){
        $Estado = 'on';
        $actSQL="UPDATE precam SET ";
        $actSQL.="Correo			='".$dato->Correo.		    "',";
        $actSQL.="fechaPreCAM		='".$dato->fechaPreCAM.	    "',";
        $actSQL.="idCliente		    ='".$dato->idCliente.	    "',";
        $actSQL.="fechaSeg			='".$dato->fechaSeg.		"',";
        $actSQL.="usrResponsable	='".$dato->usrResponsable.  "',";
        $actSQL.="Tipo	            ='".$dato->Tipo.            "',";
        $actSQL.="Estado			='".$Estado.                "'";
        $actSQL.="WHERE idPreCAM	='".$dato->idPreCAM."'";
        $bdCot=$link->query($actSQL);
    }else{
        $Estado	= 'on';
        $link->query("insert into precam(	
                                        idPreCAM            ,
                                        fechaPreCAM         ,
                                        fechaSeg            ,
                                        Tipo                ,
                                        idCliente         ,
                                        Correo              ,
                                        usrResponsable      ,
                                        Estado
                                        ) 
                                values 	(	
                                        '$dato->idPreCAM'       ,
                                        '$dato->fechaPreCAM'    ,
                                        '$dato->fechaSeg'       ,
                                        '$dato->Tipo'           ,
                                        '$dato->idCliente'    ,
                                        '$dato->Correo'         ,
                                        '$dato->usrResponsable' ,
                                        '$Estado'
                )");
    }
    $link->close();
}

if($dato->accion == 'leerDatos'){
    $link=Conectarse();
    $res = "";
    $SQL = "SELECT * FROM precam where idPreCAM = '$dato->idPreCAM'"; 
    $bd=$link->query($SQL);
    while($rs=mysqli_fetch_array($bd)){ 
        
        $res .= '{"idPreCAM":"'  		. $rs["idPreCAM"] 		        . '",'; 
        $res .= '"idCliente":"'  	    . $rs["idCliente"] 		        . '",';
        $res .= '"Correo":' 		    . json_encode($rs["Correo"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
        $res .= '"fechaPreCAM":"'       . $rs["fechaPreCAM"] 		    . '",';
        $res .= '"Tipo":"'              . $rs["Tipo"] 		            . '",';
        $res .= '"fechaSeg":"'          . $rs["fechaSeg"] 		        . '",';
        $res .= '"usrResponsable":"'	. $rs["usrResponsable"]         . '"}';
    }
    $link->close();
    echo $res;	
}
?>