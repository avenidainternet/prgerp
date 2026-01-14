<?php
	// Crear Carpetas
    $ip_remota = "192.168.0.101"; // Reemplaza con la IP real
    $ruta_carpeta = "/User/servidordata/Desktop/Data"; // Reemplaza con la ruta real
    $nombre_carpeta = "FAOR"; // Nombre de la carpeta a crear
    
    //  Verificar si se puede acceder a la IP remota (opcional, pero recomendado)
    $test_connection = @fsockopen($ip_remota, 80, $errno, $errstr, 3);
    if (is_resource($test_connection)) {
        echo 'ENTRA...';
        fclose($test_connection);
    
        // Crear la ruta completa de la carpeta
        $ruta_completa = $ruta_carpeta . "/" . $nombre_carpeta;
    
        // Construir el comando para crear la carpeta en el equipo remoto
        // Se asume que el usuario con el que se ejecuta PHP tiene permisos
        // para crear carpetas en esa ruta.  Si no, necesitas un usuario
        // con permisos apropiados o configurar acceso vía SSH.
        $comando_crear_carpeta = "ssh usuario@{$ip_remota} mkdir -p {$ruta_completa}";
    
        // Ejecutar el comando y capturar la salida
        $salida = shell_exec($comando_crear_carpeta);
    
        // Verificar si la carpeta se creó exitosamente
        if (strpos($salida, "mkdir") === false) {
            echo "Carpeta creada exitosamente en {$ip_remota}.\n";
        } else {
            echo "Error al crear la carpeta en {$ip_remota}: " . $salida . "\n";
        }
    } else {
            echo "No se pudo acceder al equipo con IP {$ip_remota}.\n";
    }
    ?>

