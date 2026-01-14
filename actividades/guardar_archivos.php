<?php
/**
    Envío de múltiples archivos y datos
    a PHP desde AngularJS usando FormData y $http
 
    @author parzibyte
    parzibyte.me/blog
*/
 
// Los archivos en $_FILES y lo demás en $_POST
$id         = $_GET["id"];
$evento     = $_GET["evento"];
$Actividad  = $_GET["Actividad"];
//$formdata = $dato->formdata;
 
// Aquí podemos hacer lo que sea con $nombre 
$Fichero = ''; 
$fechaHoy = date('Y-m-d');
foreach ($_FILES as $archivo) {
    if($evento == 'Nueva'){
        if(!mkdir('Actividades/'.$id."-".$Actividad)){ 
        }  
        if(!mkdir('Y://AAA/Actividades/'.$id."-".$Actividad)){ 
        }  
        $fichero = "Plantilla-".$id.".pdf";   
    }
    if($evento == 'Guardar'){
        $fichero = "Plantilla-$id.pdf"; 
    }
    if($evento == 'Seguimiento'){
        $fichero = "Actividad-$id-$fechaHoy.pdf"; 
    }
    $nombre_fichero = 'Actividades/'.$id."-".$Actividad.'/'.$fichero;
    if(file_exists($nombre_fichero)){
        unlink($nombre_fichero);
    }
    move_uploaded_file($archivo["tmp_name"], 'Actividades/'.$id."-".$Actividad.'/'.$fichero);

    copy('Actividades/'.$id."-".$Actividad.'/'.$fichero, 'Y://AAA/Actividades/'.$id."-".$Actividad.'/'.$fichero);

    $Fichero = $archivo["name"];
    //move_uploaded_file($archivo["tmp_name"], 'upload/'.$nNoticia.'.jpg');
}
 
# La respuesta que recibe $http.post en el then de la promesa
echo $Fichero;
?>
