<?php
/**
    Envío de múltiples archivos y datos
    a PHP desde AngularJS usando FormData y $http
 
    @author parzibyte
    parzibyte.me/blog
*/
 
// Los archivos en $_FILES y lo demás en $_POST
$Otam       = $_GET["Otam"];
date_default_timezone_set("America/Santiago");

$agnoActual = date('Y'); 
$vDir = 'resultadoTr'; 
if(!file_exists($vDir)){
    mkdir($vDir);
}

$fd = explode('-', $Otam);
$RAM = $fd[0];

$vDirAAA = "Y://AAA/LE/LABORATORIO/".$agnoActual."/".$RAM."/Tr/".$Otam; 
if(!file_exists($vDirAAA)){
    mkdir($vDirAAA);
}

$tmpOtam = $vDir.'/'.$Otam.'/'; 
if(!file_exists($tmpOtam)){
    mkdir($tmpOtam);
}

$tmpOtamAAA = $vDirAAA.'/';
if(!file_exists($tmpOtamAAA)){
    mkdir($tmpOtamAAA);
}

foreach ($_FILES as $archivo) {
    $info = new SplFileInfo($archivo["name"]);
    // $nombre_fichero = $archivo["tmp_name"];
    $nombre_fichero = 'Traccion.'.$info->getExtension();  
    // $nombre_fichero = '$archivo["name"]';  

    //$vDir = 'Y://AAA/LE/LABORATORIO/';

    move_uploaded_file($archivo["tmp_name"], $tmpOtam.$nombre_fichero);
	copy($tmpOtam.$nombre_fichero, $tmpOtamAAA.$nombre_fichero);
	//unlink($nombre_fichero);

}


# La respuesta que recibe $http.post en el then de la promesa
?>
