<?php
// Establece el encabezado para que el navegador sepa que se envía JSON
header('Content-Type: application/json');
// Permite que cualquier dominio (el frontend Angular) acceda a este script
header('Access-Control-Allow-Origin: *'); 

// Incluye la función de conexión a la base de datos (se espera que 'conexion.php' contenga la función Conectarse())
require 'conexionli.php';

$link = null;

try {
    // 1. Establecer la conexión usando la función proporcionada
    $link = Conectarse();

    // 2. Consulta principal: cotizaciones filtradas y ordenadas
    // Criterios: RutCli = '96849300-0', Estado = 'T', fechaTermino >= 2020, ORDENADO por RAM ASC
    $sql_cotizaciones = "
        SELECT 
            c.RAM, 
            c.Observacion, 
            c.fechaTermino
        FROM cotizaciones c
        WHERE c.RutCli = '96849300-0'
        AND c.Estado = 'T'
        AND c.fechaTermino >= '2020-01-01' -- Filtrar por fecha de término >= 2020
        ORDER BY c.RAM ASC
    ";

    $resultado_cotizaciones = $link->query($sql_cotizaciones);

    if (!$resultado_cotizaciones) {
        // Lanza una excepción si la consulta falla
        throw new Exception("Error en la consulta de cotizaciones: " . $link->error);
    }

    $datos_finales = [];
    // 3. Procesar cada cotización para encontrar sus ensayos
    while ($cotizacion = $resultado_cotizaciones->fetch_assoc()) {
        $ram = $cotizacion['RAM'];

        // Consulta secundaria: obtener los ensayos (otams) relacionados por RAM
        // Se relaciona por el campo RAM
        $sql_ensayos = "
            SELECT 
                idEnsayo, 
                fechaEnsayo 
            FROM otams 
            WHERE RAM = $ram
            ORDER BY fechaEnsayo ASC
        ";

        $resultado_ensayos = $link->query($sql_ensayos);

        if (!$resultado_ensayos) {
            // Si la subconsulta falla, se añade un error en lugar de detener todo
            $cotizacion['ensayos'] = [
                ['idEnsayo' => 'ERROR', 'fechaEnsayo' => 'Error al cargar ensayos']
            ];
        } else {
            $ensayos = [];
            while ($ensayo = $resultado_ensayos->fetch_assoc()) {
                $ensayos[] = [
                    'idEnsayo' => $ensayo['idEnsayo'],
                    'fechaEnsayo' => $ensayo['fechaEnsayo']
                ];
            }
            // Asigna la lista de ensayos a la cotización actual
            $cotizacion['ensayos'] = $ensayos;
        }

        // Agrega la cotización (con sus ensayos) a la lista final
        $datos_finales[] = $cotizacion;
    }

    // 4. Devolver los resultados exitosos en formato JSON
    echo json_encode(['success' => true, 'data' => $datos_finales]);

} catch (Exception $e) {
    // Manejo de errores de conexión o consulta principal
    http_response_code(500); // Código de error del servidor
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    // 5. Cerrar la conexión si está abierta y activa
    if ($link && $link->ping()) {
        $link->close();
    }
}
?>