<?php
/**
    Envío de múltiples archivos y datos
    a PHP desde AngularJS usando FormData y $http
 
    @author parzibyte
    parzibyte.me/blog
*/
 
// Los archivos en $_FILES y lo demás en $_POST
$CodCertificado = $_POST["CodCertificado"];
 
// Aquí podemos hacer lo que sea con $nombre
$Fichero = ''; 
foreach ($_FILES as $archivo) {
    move_uploaded_file($archivo["tmp_name"], '../certificados/'.$archivo["name"]);
    $Fichero = $archivo["name"];
    //move_uploaded_file($archivo["tmp_name"], 'upload/'.$nNoticia.'.jpg');
}
 
# La respuesta que recibe $http.post en el then de la promesa
echo $Fichero;
?>
