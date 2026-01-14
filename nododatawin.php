<?php
//  Dirección IP del equipo donde se creará la carpeta
$ip_remota = 'servidordata';
$test_connection = @fsockopen($ip_remota, 80, $errno, $errstr, 3);
if (is_resource($test_connection)) {
    echo 'ENTRA...<br>';
}else{
    echo 'No conecta...<br>';
}
$ip_address = "192.168.0.101";

// Nombre de la carpeta a crear
$folder_name = "FAOR";
// Ruta completa donde se creará la carpeta (ajustar según la configuración de red)
// file://192.168.0.101/Data/
$folder_path = "file://192.168.0.101/Data/" . $folder_name;
echo $folder_path.'<br>';
// Comando para crear la carpeta
mkdir($folder_path);

// Ejecutar el comando
// $output = shell_exec($command);

// Imprimir la salida del comando (opcional)
// echo "<pre>" . $output . "</pre>";

// Verificar si la carpeta se creó exitosamente
if (is_dir($folder_path)) {
    echo "La carpeta '$folder_name' se creó exitosamente en '$ip_address'.";
} else {
    echo "Hubo un error al crear la carpeta.";
}
?>