<?php
// Incluye la función de conexión a la base de datos
// Se utiliza 'conexion.php' para la conexión MySQLi
require 'conexionli.php';

$link = null;
$cotizaciones = [];
$error = null;

try {
    // 1. Establecer la conexión a la base de datos
    $link = Conectarse();

    // 2. Consulta principal: Obtener todas las cotizaciones que cumplen con los filtros.
    // El resultado de esta consulta (RAM) se usará para buscar los ensayos.
    $sql_cotizaciones = "
        SELECT 
            c.RutCli,
            c.fechaCotizacion,
            c.fechaTermino,
            c.CAM, 
            c.RAM, 
            c.Observacion
        FROM cotizaciones c
        WHERE c.RutCli = '96849300-0'
        AND c.Estado = 'T'
        AND c.fechaTermino >= '2020-01-01'
        ORDER BY c.fechaTermino desc
    ";

    $resultado_cotizaciones = $link->query($sql_cotizaciones);

    if (!$resultado_cotizaciones) {
        throw new Exception("Error en la consulta de cotizaciones: " . $link->error);
    }

    // 3. Procesar cada cotización para encontrar sus ensayos asociados en la tabla 'otams'
    while ($cotizacion = $resultado_cotizaciones->fetch_assoc()) {
        $ram = $cotizacion['RAM']; // Obtiene el ID de la cotización (RAM)
        
        // Consulta secundaria: Buscar todos los ensayos (registros en 'otams') que
        // correspondan al RAM de la cotización actual.
        $sql_ensayos = "
            SELECT 
                idEnsayo, 
                fechaEnsayo,
                idItem
            FROM otams 
            WHERE RAM = $ram
        ";
        
        $resultado_ensayos = $link->query($sql_ensayos);
        $ensayos = [];

        if (!$resultado_ensayos) {
            // Manejo de error si la subconsulta falla
            $ensayos[] = ['idEnsayo' => 'ERROR', 'fechaEnsayo' => 'Error al cargar ensayos', 'idItem' => ''];
        } else {
            // Almacena los detalles de cada ensayo encontrado
            while ($ensayo = $resultado_ensayos->fetch_assoc()) {
                $ensayos[] = [
                    'idEnsayo' => $ensayo['idEnsayo'],
                    'fechaEnsayo' => $ensayo['fechaEnsayo'],
                    'tpMuestra' => $ensayo['idItem'] // Mapeamos idItem a tpMuestra
                ];
            }
        }
        
        // Agrega la lista de ensayos como un subconjunto de la cotización
        $cotizacion['ensayos'] = $ensayos;
        $cotizaciones[] = $cotizacion;
    }

} catch (Exception $e) {
    $error = $e->getMessage();
} finally {
    // 4. Cerrar la conexión
    if ($link && $link->ping()) {
        $link->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Cotizaciones PHP/HTML</title>
    <!-- Carga de Tailwind CSS para estilos -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Estilos personalizados para la tabla y la aplicación */
        .app-container {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }
        .header {
            border-bottom: 4px solid #10b981; /* Emerald 500 */
        }
        .ensayo-tag {
            display: inline-block;
            margin: 3px 2px;
            padding: 4px 8px;
            border-radius: 9999px;
            background-color: #e0f2f1;
            color: #042f2e;
            font-size: 0.75rem;
            font-weight: 600;
            border: 1px solid #99f6e4;
        }
        .table-cell-small {
            white-space: nowrap;
            font-size: 0.8rem;
        }
        .table-cell-ensayo {
            max-width: 350px;
            overflow-x: auto; 
        }
    </style>
</head>
<body class="bg-gray-50 app-container">

    <div class="container mx-auto p-4 md:p-8">
        <header class="header bg-white p-6 mb-8 rounded-xl shadow-xl">
            <h1 class="text-3xl font-extrabold text-gray-800">Listado de Cotizaciones y Ensayos (PHP Puro)</h1>
            <p class="text-gray-600 mt-2 text-lg">
                Filtro aplicado: <code class="bg-indigo-100 p-1 rounded font-mono text-indigo-800">RutCli='96849300-0'</code>, <code class="bg-indigo-100 p-1 rounded font-mono text-indigo-800">Estado='T'</code>, <code class="bg-indigo-100 p-1 rounded font-mono text-indigo-800">Fecha Termino >= 2020</code>.
            </p>
        </header>

        <?php if ($error): // Muestra el error si existe ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-xl shadow-lg mb-8" role="alert">
                <p class="font-bold">¡Error de la Base de Datos!</p>
                <p><?php echo htmlspecialchars($error); ?></p>
            </div>
        <?php else: // Si no hay error, muestra la tabla ?>
            
            <!-- Tabla de Resultados -->
            <div class="bg-white rounded-xl shadow-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider table-cell-small">Rut Cli</th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider table-cell-small">Fec. Cotiz.</th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider table-cell-small">Fec. Térm.</th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider table-cell-small">CAM</th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider table-cell-small">RAM</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Observación</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Ensayos (ID / Muestra)</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if (count($cotizaciones) === 0): ?>
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500 italic">No se encontraron cotizaciones con los filtros aplicados.</td>
                            </tr>
                        <?php endif; ?>
                        
                        <?php foreach ($cotizaciones as $coti): ?>
                            <tr class="hover:bg-green-50 transition duration-150">
                                <!-- Datos de Cotizaciones -->
                                <td class="px-3 py-4 table-cell-small text-gray-600"><?php echo htmlspecialchars($coti['RutCli']); ?></td>
                                <td class="px-3 py-4 table-cell-small text-gray-500"><?php echo date('d/m/Y', strtotime($coti['fechaCotizacion'])); ?></td>
                                <td class="px-3 py-4 table-cell-small text-gray-500"><?php echo date('d/m/Y', strtotime($coti['fechaTermino'])); ?></td>
                                <td class="px-3 py-4 table-cell-small font-semibold text-blue-600"><?php echo htmlspecialchars($coti['CAM']); ?></td>
                                <td class="px-3 py-4 table-cell-small font-bold text-indigo-700"><?php echo htmlspecialchars($coti['RAM']); ?></td>
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-700 max-w-xs"><?php echo htmlspecialchars($coti['Observacion']); ?></td>
                                
                                <!-- Datos de Ensayos (otams) -->
                                <td class="px-6 py-4 text-sm text-gray-700 table-cell-ensayo">
                                    <?php
                                    	$link=Conectarse();
                                        $bd=$link->query("SELECT * FROM otams Where RAM = '".$coti['RAM']."'");
                                        while($rs=mysqli_fetch_array($bd)){
                                            echo $rs['idEnsayo'];
                                            if($rs['tpMuestra']){
                                                echo ' / '. $rs['tpMuestra'];
                                            }
                                            echo '<br>';
                                        }
                                    
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- Total de registros -->
            <div class="mt-4 text-sm text-gray-600 font-semibold p-4 bg-white rounded-xl shadow">
                Total de cotizaciones encontradas: <span class="text-indigo-600"><?php echo count($cotizaciones); ?></span>
            </div>
        <?php endif; ?>

    </div>

</body>
</html>