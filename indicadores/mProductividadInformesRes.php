<?php
// =========================================================================
// 1. CONFIGURACIÓN Y PRE-CARGA DE DATOS
// =========================================================================

$pAgno = isset($pAgno) ? (int)$pAgno : (int)date('Y');
$link = Conectarse();

// 1.1 Obtener Valor UF Referencial Base
$valorUFBase = 0;
$bdTab = $link->query("SELECT valorUFRef FROM tablaRegForm LIMIT 1");
if ($rowTab = $bdTab->fetch_assoc()) {
    $valorUFBase = (float)$rowTab['valorUFRef'];
}

// 1.2 Obtener Mapa de UFs Mensuales (Optimización)
// En lugar de consultar dentro del bucle, obtenemos la mejor UF de cada mes de una vez
$ufsMensuales = array_fill(1, 12, $valorUFBase); // Por defecto usa la base
$sqlUF = "SELECT MONTH(fechaFactura) as mes, MAX(valorUF) as maxUF 
          FROM solfactura 
          WHERE YEAR(fechaFactura) = $pAgno AND valorUF > 0
          GROUP BY mes";
$bdUF = $link->query($sqlUF);
while ($row = $bdUF->fetch_assoc()) {
    $ufsMensuales[(int)$row['mes']] = (float)$row['maxUF'];
}

// 1.3 Obtener Usuarios (Responsables de Informe habilitados)
$usuarios = [];
$sqlUsr = "SELECT usr FROM Usuarios WHERE responsableInforme = 'on' ORDER BY usr";
$bdUsr = $link->query($sqlUsr);
while ($row = $bdUsr->fetch_assoc()) {
    $usuarios[] = $row['usr'];
}

// 1.4 Obtener Informes del Año (Filtrado Optimizado)
// Solo traemos informes donde el Ingeniero Responsable sea DISTINTO al Co-Responsable
$informesPorUsuarioMes = [];
$sqlInformes = "SELECT ingResponsable, MONTH(fechaInforme) as mes, CodInforme 
                FROM AmInformes 
                WHERE YEAR(fechaInforme) = $pAgno 
                  AND ingResponsable != cooResponsable 
                ORDER BY CodInforme";

$bdInf = $link->query($sqlInformes);

// Pre-procesar informes agrupándolos en memoria
while ($row = $bdInf->fetch_assoc()) {
    $u = $row['ingResponsable'];
    $m = (int)$row['mes'];
    $cod = $row['CodInforme'];
    
    // Extraer RAM (ej: AM-12345-X -> 12345)
    $parts = explode('-', $cod);
    if (isset($parts[1])) {
        $ram = $parts[1];
        $informesPorUsuarioMes[$u][$m][] = $ram;
    }
}

// Cache para Memoización (evita recalcular la misma RAM)
$cacheValoresRAM = []; 

// Función auxiliar para calcular valor de una RAM
function obtenerValorRAM2($ram, $link, $ufDelMes, &$cacheValoresRAM) {
    // Si ya calculamos esta RAM para este mes (o en general), devolver valor
    // Nota: Si la UF cambia drásticamente por mes, la caché debería considerar el mes. 
    // Para simplificar y optimizar, asumimos que el valor neto facturado es fijo, 
    // y solo la conversión UF depende del mes. Aquí cacheamos el resultado final.
    $cacheKey = $ram . '_' . $ufDelMes;
    if (isset($cacheValoresRAM[$cacheKey])) {
        return $cacheValoresRAM[$cacheKey];
    }

    $neto = 0;
    $facturado = false;

    // A. Verificar Facturación (solfactura)
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
                // Usamos la UF específica del mes (pre-cargada)
                $neto += ($rowCot['NetoUF'] * $ufDelMes);
            }
        }
    }

    $cacheValoresRAM[$cacheKey] = $neto;
    return $neto;
}

// =========================================================================
// 2. PROCESAMIENTO (CÁLCULOS)
// =========================================================================

$matrizReporte = [];
$totalesMensuales = array_fill(1, 12, 0);
$granTotalAnual = 0;

foreach ($usuarios as $usr) {
    $filaData = [];
    $totalUsuario = 0;

    for ($mes = 1; $mes <= 12; $mes++) {
        $sumaMes = 0;

        if (isset($informesPorUsuarioMes[$usr][$mes])) {
            // Eliminar RAMs duplicadas en el mismo mes para no sumar doble
            $ramsUnicas = array_unique($informesPorUsuarioMes[$usr][$mes]);
            
            // Usamos la UF correspondiente a este mes para los cálculos
            $ufActual = $ufsMensuales[$mes];

            foreach ($ramsUnicas as $ram) {
                $sumaMes += obtenerValorRAM2($ram, $link, $ufActual, $cacheValoresRAM);
            }
        }

        $filaData[$mes] = $sumaMes;
        $totalUsuario += $sumaMes;
        $totalesMensuales[$mes] += $sumaMes;
    }
    
    $granTotalAnual += $totalUsuario;

    // Agregamos usuario a la lista (incluso si no tiene datos, según lógica original)
    $matrizReporte[] = [
        'usuario' => $usr,
        'meses'   => $filaData,
        'total'   => $totalUsuario
    ];
}

$link->close();
?>

<h3 class="bg-light text-dark p-2 border-bottom">
    Tabla Indicador Productividad Informes RESPONSABLES <?php echo $pAgno; ?>
    <small class="text-muted" style="font-size: 0.6em;">(Valores en MM$)</small>
</h3>

<div class="table-responsive">
    <table class="table table-hover table-bordered table-sm text-nowrap">
        <thead class="thead-light">
            <tr>
                <th style="padding-left:10px; vertical-align: middle;" width="20%">Ingeniero</th>
                <?php 
                // Aseguramos que $Mes exista, sino usamos genérico
                if(!isset($Mes)) $Mes = [1=>'Ene', 2=>'Feb', 3=>'Mar', 4=>'Abr', 5=>'May', 6=>'Jun', 7=>'Jul', 8=>'Ago', 9=>'Sep', 10=>'Oct', 11=>'Nov', 12=>'Dic'];
                for($i=1; $i<=12; $i++): ?>
                    <th class="text-center" style="font-size: 0.9em;">
                        <?php echo substr($Mes[$i], 0, 3) . '.'; ?>
                    </th>
                <?php endfor; ?>
                <th class="text-center bg-secondary text-white" style="vertical-align: middle;">Tot.</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($matrizReporte as $datos): ?>
                <tr style="background-color: #fff;">
                    <td style="padding-left:10px; font-weight: 500;">
                        <?php echo $datos['usuario']; ?>
                    </td>
                    
                    <?php for ($i=1; $i<=12; $i++): ?>
                        <td class="text-center">
                            <?php 
                                $val = $datos['meses'][$i];
                                if ($val > 0) {
                                    // Formato MM$ (Dividido por 1 millón)
                                    echo number_format($val / 1000000, 2, ',', '.');
                                } else {
                                    echo '<span class="text-black-50" style="color: #ccc;">-</span>';
                                }
                            ?>
                        </td>
                    <?php endfor; ?>

                    <td class="text-center font-weight-bold bg-light">
                        <?php 
                        if ($datos['total'] > 0) {
                            echo number_format($datos['total'] / 1000000, 2, ',', '.');
                        }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot class="thead-light">
            <tr class="font-weight-bold border-top-2" style="background-color: #ccc;">
                <th style="padding-left:10px;">Tot. Productividad Mes</th>
                <?php for ($i=1; $i<=12; $i++): ?>
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