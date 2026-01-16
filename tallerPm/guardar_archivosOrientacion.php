<?php
/**
    Envío de múltiples archivos y datos
    a PHP desde AngularJS usando FormData y $http
 
    @author parzibyte
    parzibyte.me/blog
*/
include_once("../conexionli.php");
 
// Los archivos en $_FILES y lo demás en $_POST
$RAM         = $_GET["RAM"];
date_default_timezone_set("America/Santiago");

$agnoActual = date('Y'); 
$vDir = 'resultadosQu'; 
if(!file_exists($vDir)){
    mkdir($vDir);
}

$tmpOtam = $vDir.'/'.$RAM.'/';
if(!file_exists($tmpOtam)){
    mkdir($tmpOtam);
}
foreach ($_FILES as $archivo) {
    $info = new SplFileInfo($archivo["name"]);
    //$nombre_fichero = $archivo["tmp_name"];
    // $nombre_fichero = $Otam.'.'.$info->getExtension();  
    $nombre_fichero = $archivo["name"];  

    $agnoActual = date('Y'); 
    $vDir = 'Y://AAA/LE/LABORATORIO/'.$agnoActual.'/'.$RAM;
    if(!file_exists($vDir)){
        mkdir($vDir);
    }
    $vDir = 'Y://AAA/LE/LABORATORIO/'.$agnoActual.'/'.$RAM.'/Qu';
    if(!file_exists($vDir)){
        mkdir($vDir);
    }
    
    move_uploaded_file($archivo["tmp_name"], $vDir.'/'.$nombre_fichero);


    $link=Conectarse();
    $Seleccionado = 'off';
    //$SQL = "Select * From tablaorientacion Where idItem like '%$RAM%' and Seleccionado = 'on'"; 
	//$bd = $link->query($SQL);
	//while($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE tablaorientacion SET ";
        $actSQL.="pdfOrientacion	= '".$nombre_fichero.	"',";
        $actSQL.="Seleccionado	    = '".$Seleccionado.	    "'";
        $actSQL.="Where idItem 	like '%$RAM%'";
        // $actSQL.="Where idItem 	like '%$RAM%' and Seleccionado = 'on'";
        $bdfRAM=$link->query($actSQL);

    //}
    $link->close();



	//copy('tmp/'.$nombre_fichero, $vDir.'/'.$nombre_fichero);
	//unlink($nombre_fichero);

}


# La respuesta que recibe $http.post en el then de la promesa
?>
