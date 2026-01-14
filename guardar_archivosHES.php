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
 
foreach ($_FILES as $archivo) {
    $info = new SplFileInfo($archivo["name"]);
    $fechaHoy = date('Y-m-d');
    
    // $nombre_fichero = 'Espectrometro-'.$fechaHoy.'.'.$info->getExtension();
    $nombre_fichero = 'HES-'.$_GET['CAM'].'.'.$info->getExtension();

    $agnoActual = date('Y'); 
    // BORRAR DESPUES
    /*
	$vDir = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion/octmp'; 
	if(!file_exists($vDir)){
		mkdir($vDir);
	}
    */
    // FIN BORRAR DESPUES

    $vDir = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/SOLICITUD-FACTURA/octmp';
	if(!file_exists($vDir)){
		mkdir($vDir);
	}
	//$vDir = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion/octmp'; // BORRAR DESPUES

    $agnoActual = date('Y'); 
	$vDirTmp = 'tmp'; 
	if(!file_exists($vDirTmp)){
		mkdir($vDirTmp);
	}
    

    move_uploaded_file($archivo["tmp_name"], 'tmp/'.$nombre_fichero);
	copy('tmp/'.$nombre_fichero, $vDir.'/'.$nombre_fichero);
	//unlink($nombre_fichero);

}
 
# La respuesta que recibe $http.post en el then de la promesa
?>
