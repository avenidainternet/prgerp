<?php
// 1. CONFIGURACIÓN Y VARIABLES INICIALES
if (!isset($pAgno)) $pAgno = date('Y');
if (!isset($Mes)) {
    $Mes = [1=>'Enero', 2=>'Febrero', 3=>'Marzo', 4=>'Abril', 5=>'Mayo', 6=>'Junio', 
            7=>'Julio', 8=>'Agosto', 9=>'Septiembre', 10=>'Octubre', 11=>'Noviembre', 12=>'Diciembre'];
}

$link = Conectarse();

// -------------------------------------------------------------------------
// PASO 2: OBTENER DATOS (OPTIMIZACIÓN SQL)
// -------------------------------------------------------------------------

// 2.1 Obtener TODAS las cuentas de Otams de una sola vez
// Agrupamos por Ensayo, Tipo de Muestra y Mes.
// Esto reemplaza las miles de consultas dentro de los bucles.
$stats = [];
$sqlStats = "SELECT idEnsayo, tpMuestra, MONTH(fechaCreaRegistro) as mes, COUNT(*) as cantidad 
             FROM Otams 
             WHERE YEAR(fechaCreaRegistro) = '$pAgno' 
             GROUP BY idEnsayo, tpMuestra, mes";

$bdStats = $link->query($sqlStats);
while ($row = mysqli_fetch_array($bdStats)) {
    $e = $row['idEnsayo'];
    $m = $row['tpMuestra'];
    $mes = $row['mes'];
    
    // Guardamos en una estructura tridimensional: [Ensayo][Muestra][Mes]
    if (!isset($stats[$e])) $stats[$e] = [];
    if (!isset($stats[$e][$m])) $stats[$e][$m] = [];
    
    $stats[$e][$m][$mes] = $row['cantidad'];
}

// Función auxiliar para recuperar el conteo desde la memoria (sin ir a la BD)
function obtenerConteo($stats, $idEnsayo, $tpMuestra, $mes, $esCasoEspecialTr) {
    $total = 0;
    
    if (isset($stats[$idEnsayo])) {
        if ($esCasoEspecialTr) {
            // Si es 'Tr', buscamos la coincidencia exacta de tpMuestra
            if (isset($stats[$idEnsayo][$tpMuestra][$mes])) {
                $total = $stats[$idEnsayo][$tpMuestra][$mes];
            }
        } else {
            // Si NO es 'Tr', el código original sumaba TODO lo que tuviera ese idEnsayo,
            // sin importar el tpMuestra. Sumamos todas las sub-claves.
            foreach ($stats[$idEnsayo] as $mues => $mesesData) {
                if (isset($mesesData[$mes])) {
                    $total += $mesesData[$mes];
                }
            }
        }
    }
    return $total;
}

// 2.2 Obtener Definiciones de Ensayos y Muestras
$ensayos = [];
$bdEn = $link->query("SELECT * FROM amEnsayos ORDER BY nEns");
while ($row = mysqli_fetch_array($bdEn)) {
    $ensayos[] = $row;
}

// Pre-cargar tipos de muestras para 'Tr' para evitar queries en el bucle
$muestrasTr = [];
$bdMu = $link->query("SELECT * FROM amTpsMuestras WHERE idEnsayo = 'Tr'");
while ($row = mysqli_fetch_array($bdMu)) {
    $muestrasTr[] = $row;
}

$link->close();

// Totales de columnas (Meses)
$totalesColumnas = array_fill(1, 12, 0);
$granTotalAnual = 0;
?>

<h3 class="bg-light text-dark">Tabla Indicador Ensayos <?php echo $pAgno; ?></h3>
<table class="table table-hover table-bordered table-sm">
	<thead class="thead-light">
        <tr>
            <th style="padding-left:10px;" width="20%">Ensayos</th>
            <?php for($i=1; $i<=12; $i++) echo '<th class="text-center">'.substr($Mes[$i],0,3).'.'.'</th>'; ?>
            <th class="text-center">Tot.</th>
        </tr>
	</thead>
	<tbody>
    <?php foreach ($ensayos as $rowEn): ?>
        
        <?php 
        // LÓGICA: Si es 'Tr', iteramos sobre sus muestras. Si no, mostramos solo una fila.
        $filasAImprimir = [];
        
        if ($rowEn['idEnsayo'] == 'Tr') {
            foreach ($muestrasTr as $mu) {
                $filasAImprimir[] = [
                    'titulo' => $rowEn['Ensayo'] . ' ' . $mu['Muestra'],
                    'tpMuestra' => $mu['tpMuestra'], // Necesario para filtrar
                    'esTr' => true
                ];
            }
        } else {
            $filasAImprimir[] = [
                'titulo' => $rowEn['Ensayo'],
                'tpMuestra' => null, // No aplica filtro específico
                'esTr' => false
            ];
        }
        ?>

        <?php foreach ($filasAImprimir as $fila): ?>
            <tr style="background-color:#fff;">
                <td style="padding-left:10px;">
                    <?php echo $fila['titulo']; ?>
                </td>
                
                <?php 
                $totalFila = 0;
                // Bucle de Meses
                for ($i=1; $i<=12; $i++) {
                    // Aquí ocurre la "magia": consultamos el array $stats en vez de la BD
                    $cantidad = obtenerConteo($stats, $rowEn['idEnsayo'], $fila['tpMuestra'], $i, $fila['esTr']);
                    
                    // Acumular totales
                    if ($cantidad > 0) {
                        $totalFila += $cantidad;
                        $totalesColumnas[$i] += $cantidad;
                        $granTotalAnual += $cantidad;
                    }
                    
                    echo '<td class="text-center">';
                    echo ($cantidad > 0) ? $cantidad : '';
                    echo '</td>';
                }
                ?>
                
                <td class="text-center font-weight-bold">
                    <?php echo ($totalFila > 0) ? $totalFila : ''; ?>
                </td>
            </tr>
        <?php endforeach; ?>

    <?php endforeach; ?>
	</tbody>
    
    <tfoot class="thead-light">
        <tr class="font-weight-bold">
            <th style="padding-left:10px;">Tot. Ensayos Mes</th>
            <?php 
                for ($i=1; $i<=12; $i++) {
                    echo '<th class="text-center">';
                    echo ($totalesColumnas[$i] > 0) ? $totalesColumnas[$i] : '';
                    echo '</th>';
                }
            ?>
            <th class="text-center"><?php echo $granTotalAnual; ?></th>
        </tr>
	</tfoot>
</table>