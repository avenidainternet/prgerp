<?php
/**
    Envío de múltiples archivos y datos
    a PHP desde AngularJS usando FormData y $http
 
    @author parzibyte
    parzibyte.me/blog
*/
 
// Los archivos en $_FILES y lo demás en $_POST
$Otam       = $_GET["Otam"];
//$formdata = $dato->formdata;
 
foreach ($_FILES as $archivo) {
    $fd = explode('-',$Otam);
    $RAM = $fd[0];
    $info = new SplFileInfo($archivo["name"]);
    
    $nombre_fichero = $Otam.'.'.$info->getExtension(); 

    $agnoActual = date('Y'); 
	$vDir = 'Y://AAA/Archivador-'.$agnoActual.'/Laboratorio/Archivador-AM/'.$RAM.'/Tr';  
	if(!file_exists($vDir)){
		mkdir($vDir);
	}
    
    $tmp = "tmp";
	if(!file_exists($tmp)){
		mkdir($tmp);
	}

    move_uploaded_file($archivo["tmp_name"], 'tmp/'.$nombre_fichero);
	copy('tmp/'.$nombre_fichero, $vDir.'/'.$nombre_fichero);
	//unlink($nombre_fichero);

}
 
# La respuesta que recibe $http.post en el then de la promesa
?>
