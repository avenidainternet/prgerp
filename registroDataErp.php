<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include_once("conexionli.php");

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

if($dato->accion == 'volverTrabajosSinInformes'){
    $nOC            = '';
    $HES            = '';
    $informeUP      = '';
    $fechaInformeUP = '';

    $link=Conectarse();
	$SQL = "Select * From cotizaciones Where CAM = '$dato->CAM' and RAM = '$dato->RAM' and Fan = '$dato->Fan'";
    $bd=$link->query($SQL);
    if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE cotizaciones SET ";
        $actSQL.="nOC		        = '".$nOC.	            "',";
        $actSQL.="HES		        = '".$HES.	            "',";
        $actSQL.="informeUP		    = '".$informeUP.	    "',";
        $actSQL.="fechaInformeUP    = '".$fechaInformeUP.	"'";
        $actSQL.="Where CAM = '$dato->CAM' and RAM = '$dato->RAM' and Fan = '$dato->Fan'";
        $bdfRAM=$link->query($actSQL);
    }
    $link->close();
}
if($dato->accion == 'grabarAmRosado'){
    $link=Conectarse();
	$SQL = "Select * From cotizaciones Where CAM = '$dato->CAM' and RAM = '$dato->RAM' and Fan = '$dato->Fan'";
    $bd=$link->query($SQL);
    if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE cotizaciones SET ";
        $actSQL.="nOC		    = '".$dato->nOC.	"',";
        $actSQL.="HES		    = '".$dato->HES.	"'";
        $actSQL.="Where CAM = '$dato->CAM' and RAM = '$dato->RAM' and Fan = '$dato->Fan'";
        $bdfRAM=$link->query($actSQL);
    }
    $link->close();
}



?>