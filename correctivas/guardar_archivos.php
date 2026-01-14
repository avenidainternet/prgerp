<?php
/**
    Envío de múltiples archivos y datos
    a PHP desde AngularJS usando FormData y $http
 
    @author parzibyte
    parzibyte.me/blog
*/
 
// Los archivos en $_FILES y lo demás en $_POST
// $Otam       = $_GET["Otam"];
//$formdata = $dato->formdata;
date_default_timezone_set("America/Santiago");
 
foreach ($_FILES as $archivo) {
    $info = new SplFileInfo($archivo["name"]);
    $fechaHoy = date('Y-m-d');
    
    // $nombre_fichero = 'Espectrometro-'.$fechaHoy.'.'.$info->getExtension();
    $nombre_fichero = $info;

    $agnoActual = date('Y'); 
	//$vDir = 'Y://AAA/LE/CALIDAD/AC/AC-196/Anexos'; 
	$vDir = 'Y://AAA/LE/CALIDAD/AC/AC-'.$_GET['id']; 
	if(!file_exists($vDir)){
		mkdir($vDir);
	}
	$vDir = 'Y://AAA/LE/CALIDAD/AC/AC-'.$_GET['id'].'/Anexos'; 
	if(!file_exists($vDir)){
		mkdir($vDir);
	}
    
    $tmp = "tmp";
	if(!file_exists($tmp)){
		mkdir($tmp);
	}

    // $nombre_fichero = utf8_decode($nombre_fichero);

    // $vowels = array("á", "é", "í", "ó", "ú", "?");
    $nombreNew = str_replace('?', "o", $nombre_fichero);
    
    
    move_uploaded_file($archivo["tmp_name"], 'tmp/'. utf8_decode($nombreNew));
	copy('tmp/'.utf8_decode($nombreNew), $vDir.'/'.utf8_decode($nombreNew));
	//unlink($nombre_fichero);

}
 
# La respuesta que recibe $http.post en el then de la promesa
?>
