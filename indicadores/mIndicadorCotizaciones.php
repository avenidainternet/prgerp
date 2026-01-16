<?php
// =========================================================================
// 1. CONFIGURACIÓN Y CARGA DE DATOS (MODELO)
// =========================================================================

$pAgno = isset($pAgno) ? (int)$pAgno : (int)date('Y');
$link = Conectarse();

// 1.1 Cargar Feriados en Memoria (Optimización Crítica)
// Evita consultar la BD por cada día de cálculo
$feriados = [];
$bdFer = $link->query("SELECT fecha FROM diasferiados");
while ($r = $bdFer->fetch_assoc()) {
    $feriados[$r['fecha']] = true;
}

// 1.2 Cargar Clasificación de Clientes
$clientesClasificacion = [];
$bdCli = $link->query("SELECT RutCli, Clasificacion FROM Clientes");
while ($r = $bdCli->fetch_assoc()) {
    $clientesClasificacion[$r['RutCli']] = $r['Clasificacion']; // 1, 2, 3...
}

// 1.3 Función para calcular Fecha Término Estimada (Lógica PHP pura)
function calcularFechaTermino($fechaInicio, $diasHabiles, $feriados) {
    // Si dHabiles viene vacío o es 0, asumir al menos 1 día o devolver misma fecha
    if ($diasHabiles < 1) $diasHabiles = 1; 
    
    // Restamos 1 porque el primer día ya cuenta (según lógica original)
    $diasPorSumar = $diasHabiles - 1; 
    $fechaActual = strtotime($fechaInicio);
    
    while ($diasPorSumar > 0) {
        $fechaActual = strtotime('+1 day', $fechaActual);
        $fechaStr = date('Y-m-d', $fechaActual);
        $diaSemana = date('w', $fechaActual); // 0=Dom, 6=Sab
        
        // Si es fin de semana O feriado, no descontamos día (el bucle sigue)
        // Si es día hábil, descontamos 1
        if ($diaSemana != 0 && $diaSemana != 6 && !isset($feriados[$fechaStr])) {
            $diasPorSumar--;
        }
    }
    return date('Y-m-d', $fechaActual);
}

// 1.4 Inicializar Estructuras de Datos para los 12 meses
$stats = [
    'cotizaciones' => array_fill(1, 12, ['total' => 0, 'seg' => 0, 'eje' => 0]),
    'informes'     => array_fill(1, 12, ['total' => 0, 'conRev' => 0]),
    'atrasos'      => [
        'general' => array_fill(1, 12, ['total' => 0, 'atrasadas' => 0]),
        'c1'      => array_fill(1, 12, ['total' => 0, 'atrasadas' => 0]), // Estrellas 1
        'c2'      => array_fill(1, 12, ['total' => 0, 'atrasadas' => 0]), // Estrellas 2
        'c3'      => array_fill(1, 12, ['total' => 0, 'atrasadas' => 0]), // Estrellas 3
    ]
];

// 1.5 Procesar Cotizaciones (Premium, Seguimiento y Atrasos)
// Hacemos UNA sola consulta grande en lugar de miles pequeñas
$sqlCot = "SELECT * FROM Cotizaciones 
           WHERE YEAR(fechaCotizacion) = $pAgno 
              OR YEAR(fechaInicio) = $pAgno"; 
// Nota: Traemos por fechaCotizacion y fechaInicio para cubrir ambos reportes

$bdCot = $link->query($sqlCot);
while ($row = $bdCot->fetch_assoc()) {
    $mesCot = (int)date('m', strtotime($row['fechaCotizacion']));
    $agnoCot = (int)date('Y', strtotime($row['fechaCotizacion']));
    
    $mesIni = (int)date('m', strtotime($row['fechaInicio']));
    $agnoIni = (int)date('Y', strtotime($row['fechaInicio']));

    // --- A. Lógica "Premium / Seguimiento" (Basado en fechaCotizacion) ---
    if ($agnoCot == $pAgno && $row['BrutoUF'] >= 40) {
        $stats['cotizaciones'][$mesCot]['total']++;
        
        if ($row['proxRecordatorio'] > '0000-00-00') {
            $stats['cotizaciones'][$mesCot]['seg']++;
        }
        if ($row['Estado'] == 'T') {
            $stats['cotizaciones'][$mesCot]['eje']++;
        }
    }

    // --- B. Lógica "PAM Atrasadas" (Basado en fechaInicio) ---
    // Solo procesamos si es del año actual y está terminada ('T')
    if ($agnoIni == $pAgno && $row['Estado'] == 'T') {
        $rut = $row['RutCli'];
        $clasificacion = isset($clientesClasificacion[$rut]) ? $clientesClasificacion[$rut] : 0;
        
        // Determinar si está atrasada
        $esAtrasada = false;
        if ($row['fechaTermino'] > '0000-00-00' && $row['dHabiles'] > 0) {
            $fechaEstimada = calcularFechaTermino($row['fechaInicio'], $row['dHabiles'], $feriados);
            if ($row['fechaTermino'] > $fechaEstimada) {
                $esAtrasada = true;
            }
        }

        // Helper para sumar en la categoría correcta
        $sumarStats = function($tipo) use (&$stats, $mesIni, $esAtrasada) {
            $stats['atrasos'][$tipo][$mesIni]['total']++;
            if ($esAtrasada) {
                $stats['atrasos'][$tipo][$mesIni]['atrasadas']++;
            }
        };

        // 1. Sumar a General
        $sumarStats('general');
        
        // 2. Sumar a Clasificación Específica
        if ($clasificacion == '1') $sumarStats('c1');
        if ($clasificacion == '2') $sumarStats('c2');
        if ($clasificacion == '3') $sumarStats('c3');
    }
}

// 1.6 Procesar Informes y Revisiones
// Contar Informes
$sqlInf = "SELECT MONTH(fechaUp) as mes, COUNT(*) as c FROM Informes WHERE YEAR(fechaUp) = $pAgno GROUP BY mes";
$bdInf = $link->query($sqlInf);
while($r = $bdInf->fetch_assoc()) {
    $stats['informes'][(int)$r['mes']]['total'] = $r['c'];
}
// Contar Revisiones
$sqlRev = "SELECT MONTH(fechaMod) as mes, COUNT(*) as c FROM regRevisiones WHERE YEAR(fechaMod) = $pAgno GROUP BY mes";
$bdRev = $link->query($sqlRev);
while($r = $bdRev->fetch_assoc()) {
    $stats['informes'][(int)$r['mes']]['conRev'] = $r['c'];
}

$link->close();
?>

<h3 class="bg-light text-dark p-2 border-bottom">
    <i class="fas fa-file-invoice-dollar"></i> Indicador Cotizaciones <?php echo $pAgno; ?>
</h3>

<div class="table-responsive">
    <table class="table table-hover table-bordered table-sm text-nowrap">
        <thead class="thead-light">
            <tr>
                <th style="padding-left:10px; width: 20%;">Indicador</th>
                <?php 
                $nombresMes = [1=>'Ene', 2=>'Feb', 3=>'Mar', 4=>'Abr', 5=>'May', 6=>'Jun', 7=>'Jul', 8=>'Ago', 9=>'Sep', 10=>'Oct', 11=>'Nov', 12=>'Dic'];
                for($i=1; $i<=12; $i++): ?>
                    <th class="text-center"><?php echo $nombresMes[$i]; ?>.</th>
                <?php endfor; ?>
                <th class="text-center bg-secondary text-white">Total</th>
            </tr>
        </thead>
        <tbody>
            
            <tr>
                <td style="padding-left:10px; font-weight:500;">Premium c/Seguimiento</td>
                <?php 
                $tSeg = 0; $tTot = 0;
                for($i=1; $i<=12; $i++): 
                    $d = $stats['cotizaciones'][$i];
                    $tSeg += $d['seg']; 
                    $tTot += $d['total'];
                ?>
                    <td class="text-center">
                        <?php if($d['total'] > 0): ?>
                            <?php echo number_format($d['seg'] / $d['total'], 2, ',', '.'); ?>
                            <br><small class="text-muted"><?php echo $d['seg'].'/'.$d['total']; ?></small>
                        <?php else: echo '-'; endif; ?>
                    </td>
                <?php endfor; ?>
                <td class="text-center font-weight-bold bg-light">
                    <?php if($tTot > 0) echo number_format($tSeg/$tTot, 2, ',', '.'); ?>
                    <br><small><?php echo $tSeg.'/'.$tTot; ?></small>
                </td>
            </tr>

            <tr>
                <td style="padding-left:10px; font-weight:500;">Premium Ejecutadas</td>
                <?php 
                $tEje = 0; $tTot = 0;
                for($i=1; $i<=12; $i++): 
                    $d = $stats['cotizaciones'][$i];
                    $tEje += $d['eje']; 
                    $tTot += $d['total'];
                ?>
                    <td class="text-center">
                        <?php if($d['total'] > 0): ?>
                            <?php echo number_format($d['eje'] / $d['total'], 2, ',', '.'); ?>
                            <br><small class="text-muted"><?php echo $d['eje'].'/'.$d['total']; ?></small>
                        <?php else: echo '-'; endif; ?>
                    </td>
                <?php endfor; ?>
                <td class="text-center font-weight-bold bg-light">
                    <?php if($tTot > 0) echo number_format($tEje/$tTot, 2, ',', '.'); ?>
                    <br><small><?php echo $tEje.'/'.$tTot; ?></small>
                </td>
            </tr>

            <tr>
                <td style="padding-left:10px; font-weight:500;">Informes con Revisión</td>
                <?php 
                $tRev = 0; $tInf = 0;
                for($i=1; $i<=12; $i++): 
                    $d = $stats['informes'][$i];
                    $tRev += $d['conRev']; 
                    $tInf += $d['total'];
                    
                    // Cálculo inverso: 1 - (Rev/Inf) según original? 
                    // Original: echo number_format(1 - $rRev,2);
                    // Si rRev es (Revisiones / Informes), entonces 1 - eso es "% Sin Revisión" o "% Aprobado directo"
                    $ratio = ($d['total'] > 0) ? ($d['conRev'] / $d['total']) : 0;
                    $valMostrar = ($d['total'] > 0) ? (1 - $ratio) : 0;
                ?>
                    <td class="text-center">
                        <?php if($d['total'] > 0): ?>
                            <?php echo number_format($valMostrar, 2, ',', '.'); ?>
                            <br><small class="text-muted"><?php echo $d['conRev'].'/'.$d['total']; ?></small>
                        <?php else: echo '-'; endif; ?>
                    </td>
                <?php endfor; ?>
                <td class="text-center font-weight-bold bg-light">
                    <?php 
                        $ratioTot = ($tInf > 0) ? ($tRev / $tInf) : 0;
                        if($tInf > 0) echo number_format(1 - $ratioTot, 2, ',', '.');
                    ?>
                    <br><small><?php echo $tRev.'/'.$tInf; ?></small>
                </td>
            </tr>

            <?php 
            $filasAtrasos = [
                ['key' => 'general', 'titulo' => 'PAM Atrasadas', 'icono' => '', 'link' => 0],
                ['key' => 'c1',      'titulo' => 'PAM Atrasadas', 'icono' => str_repeat('<i class="fas fa-star text-warning"></i> ', 1), 'link' => 1],
                ['key' => 'c2',      'titulo' => 'PAM Atrasadas', 'icono' => str_repeat('<i class="fas fa-star text-warning"></i> ', 2), 'link' => 2],
                ['key' => 'c3',      'titulo' => 'PAM Atrasadas', 'icono' => str_repeat('<i class="fas fa-star text-warning"></i> ', 3), 'link' => 3],
            ];

            foreach($filasAtrasos as $fila):
                $key = $fila['key'];
                $datos = $stats['atrasos'][$key];
                $tAtr = 0; $tTot = 0;
            ?>
            <tr>
                <td style="padding-left:10px; font-weight:500;">
                    <?php echo $fila['titulo'] . ' ' . $fila['icono']; ?>
                </td>
                <?php for($i=1; $i<=12; $i++): 
                    $d = $datos[$i];
                    $tAtr += $d['atrasadas'];
                    $tTot += $d['total'];
                ?>
                    <td class="text-center">
                        <?php if($d['total'] > 0): ?>
                            <?php echo number_format($d['atrasadas'] / $d['total'], 2, ',', '.'); ?>
                            
                            <a href="PAMatrazadas.php?AgnoAtr=<?php echo $pAgno; ?>&MesAtr=<?php echo $i; ?>&Clasificacion=<?php echo $fila['link']; ?>" style="text-decoration: none;">
                                <br><span style="font-size:12px; font-weight: bold; color: #007bff;">
                                    <?php echo $d['atrasadas'].' / '.$d['total']; ?>
                                </span>
                            </a>
                        <?php else: echo '-'; endif; ?>
                    </td>
                <?php endfor; ?>
                <td class="text-center font-weight-bold bg-light">
                    <?php if($tTot > 0) echo number_format($tAtr/$tTot, 2, ',', '.'); ?>
                    <br><small><?php echo $tAtr.'/'.$tTot; ?></small>
                </td>
            </tr>
            <?php endforeach; ?>

        </tbody>
    </table>
</div>