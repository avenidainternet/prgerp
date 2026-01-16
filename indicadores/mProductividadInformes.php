<?php
// =========================================================================
// 1. CONFIGURACIÓN Y PREPARACIÓN DE DATOS
// =========================================================================

$pAgno = isset($pAgno) ? (int)$pAgno : (int)date('Y');
$link = Conectarse();

// 1.1 Obtener Valor UF Referencial
$valorUFRef = 0;
$bdTab = $link->query("SELECT valorUFRef FROM tablaRegForm LIMIT 1");
if ($rowTab = $bdTab->fetch_assoc()) {
    $valorUFRef = $rowTab['valorUFRef'];
}

// 1.2 Obtener Usuarios Co-Responsables
$usuarios = [];
$sqlUsr = "SELECT usr FROM Usuarios WHERE responsableInforme = 'on' ORDER BY usr";
$bdUsr = $link->query($sqlUsr);
while ($row = $bdUsr->fetch_assoc()) {
    $usuarios[] = $row['usr'];
}

// 1.3 Obtener Todos los Informes del Año (Una sola consulta grande)
// Guardamos la estructura: $informes[usuario][mes] = [lista de RAMs]
$dataInformes = [];
$sqlInformes = "SELECT cooResponsable, MONTH(fechaInforme) as mes, CodInforme 
                FROM AmInformes 
                WHERE YEAR(fechaInforme) = $pAgno 
                ORDER BY CodInforme";

$bdInf = $link->query($sqlInformes);

// Cache para no consultar la misma RAM dos veces (Memoización)
$cacheValoresRAM = []; 

// Función auxiliar para calcular valor de una RAM (Lógica de negocio original)
function obtenerValorRAM($ram, $link, $valorUFRef, &$cacheValoresRAM) {
    if (isset($cacheValoresRAM[$ram])) {
        return $cacheValoresRAM[$ram];
    }

    $neto = 0;
    $facturado = false;

    // A. Buscar en Solicitudes de Factura (Nota: LIKE es lento, pero necesario por la estructura original)
    // Se intenta limitar el impacto buscando solo si la RAM tiene formato válido
    if (!empty($ram)) {
        $sqlSol = "SELECT Neto FROM solfactura WHERE informesAM LIKE '%$ram%'";
        $bdSol = $link->query($sqlSol);
        
        while ($rowSol = $bdSol->fetch_assoc()) {
            $facturado = true;
            $neto += $rowSol['Neto'];
        }
    }

    // B. Si no está facturado, buscar en Cotizaciones
    if (!$facturado && !empty($ram)) {
        $sqlCot = "SELECT Neto, NetoUF FROM Cotizaciones WHERE RAM = '$ram'";
        $bdCot = $link->query($sqlCot);
        if ($rowCot = $bdCot->fetch_assoc()) {
            if ($rowCot['Neto'] > 0) {
                $neto += $rowCot['Neto'];
            } else {
                $neto += ($rowCot['NetoUF'] * $valorUFRef);
            }
        }
    }

    $cacheValoresRAM[$ram] = $neto; // Guardar en caché
    return $neto;
}

// =========================================================================
// 2. PROCESAMIENTO
// =========================================================================

$matrizResultados = [];
$totalesMensuales = array_fill(1, 12, 0);
$granTotalAnual = 0;

// Procesamos primero la data bruta de informes para agruparla en PHP
$informesPorUsuarioMes = [];
while ($row = $bdInf->fetch_assoc()) {
    $u = $row['cooResponsable'];
    $m = (int)$row['mes'];
    $cod = $row['CodInforme'];
    
    // Extraer RAM (Lógica: 'AM-12345-X' -> '12345')
    $parts = explode('-', $cod);
    $ram = isset($parts[1]) ? $parts[1] : '';

    if ($ram) {
        $informesPorUsuarioMes[$u][$m][] = $ram; // Guardamos RAM para procesar
    }
}

// Ahora calculamos los montos iterando sobre nuestra estructura limpia
foreach ($usuarios as $usr) {
    $fila = [];
    $totalFila = 0;

    for ($i = 1; $i <= 12; $i++) {
        $sumaMes = 0;
        
        // Si el usuario tiene informes este mes
        if (isset($informesPorUsuarioMes[$usr][$i])) {
            // Eliminar duplicados de RAM en el mismo mes/usuario si aplica
            $ramsUnicas = array_unique($informesPorUsuarioMes[$usr][$i]);
            
            foreach ($ramsUnicas as $ram) {
                $sumaMes += obtenerValorRAM($ram, $link, $valorUFRef, $cacheValoresRAM);
            }
        }

        $fila[$i] = $sumaMes;
        $totalFila += $sumaMes;
        $totalesMensuales[$i] += $sumaMes;
    }
    
    $granTotalAnual += $totalFila;
    
    $matrizResultados[] = [
        'usuario' => $usr,
        'meses'   => $fila,
        'total'   => $totalFila
    ];
}

$link->close();
?>

<h3 class="bg-light text-dark p-2 border-bottom">
    Tabla Indicador Productividad Informes CO-RESPONSABLES <?php echo $pAgno; ?>
    <small class="text-muted" style="font-size: 0.6em;">(Valores en MM$)</small>
</h3>

<div class="table-responsive">
    <table class="table table-hover table-bordered table-sm text-nowrap">
        <thead class="thead-light">
            <tr>
                <th style="padding-left:10px; vertical-align: middle;" width="20%">Ingeniero</th>
                <?php foreach($Mes as $k => $nombreMes): if($k > 12) break; // Seguridad si el array Mes es raro ?>
                    <th class="text-center" style="font-size: 0.9em;">
                        <?php echo substr($nombreMes, 0, 3) . '.'; ?>
                    </th>
                <?php endforeach; ?>
                <th class="text-center bg-secondary text-white" style="vertical-align: middle;">Tot.</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($matrizResultados as $datos): ?>
                <tr>
                    <td style="padding-left:10px; font-weight: 500;">
                        <?php echo $datos['usuario']; ?>
                    </td>
                    
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <td class="text-center">
                            <?php 
                                $val = $datos['meses'][$i];
                                if ($val > 0) {
                                    // Dividir por 1.000.000 para formato MM$
                                    echo number_format($val / 1000000, 2, ',', '.');
                                } else {
                                    echo '<span class="text-black-50">-</span>';
                                }
                            ?>
                        </td>
                    <?php endfor; ?>

                    <td class="text-center font-weight-bold bg-light">
                        <?php echo ($datos['total'] > 0) ? number_format($datos['total'] / 1000000, 2, ',', '.') : ''; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot class="thead-light">
            <tr class="font-weight-bold border-top-2">
                <th style="padding-left:10px;">TOTAL MENSUAL</th>
                <?php for ($i = 1; $i <= 12; $i++): ?>
                    <th class="text-center">
                        <?php 
                        if ($totalesMensuales[$i] > 0) {
                            echo number_format($totalesMensuales[$i] / 1000000, 2, ',', '.'); 
                        }
                        ?>
                    </th>
                <?php endfor; ?>
                <th class="text-center bg-secondary text-white">
                    <?php echo number_format($granTotalAnual / 1000000, 2, ',', '.'); ?>
                </th>
            </tr>
        </tfoot>
    </table>
</div>