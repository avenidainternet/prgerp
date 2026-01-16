<?php
// Aseguramos que las variables globales existan (asumiendo que vienen de un include previo)
// Si $Mes o $pAgno no están definidos, los definimos por defecto para evitar errores.
if (!isset($pAgno)) $pAgno = date('Y');
if (!isset($Mes)) {
    $Mes = [1=>'Enero', 2=>'Febrero', 3=>'Marzo', 4=>'Abril', 5=>'Mayo', 6=>'Junio', 
            7=>'Julio', 8=>'Agosto', 9=>'Septiembre', 10=>'Octubre', 11=>'Noviembre', 12=>'Diciembre'];
}

$link = Conectarse();
$linkCert = ConectarseCert(); // Asumo que esta función existe según tu código original

// -------------------------------------------------------------------------
// PASO 1: PRE-CARGA DE DATOS (Optimización de Base de Datos)
// -------------------------------------------------------------------------

// 1.1 Obtener todos los feriados del año una sola vez
$feriados = [];
$sqlFeriados = "SELECT fecha FROM diasferiados WHERE YEAR(fecha) = '$pAgno'"; // Usar Prepared Statements es mejor, pero mantenemos simple por compatibilidad
$bdF = $link->query($sqlFeriados);
while ($row = mysqli_fetch_array($bdF)) {
    $feriados[] = $row['fecha'];
}

// 1.2 Función para calcular fecha hábil (Sin tocar la BD)
function calcularFechaEntrega2($fechaInicio, $diasHabiles, $feriadosArray) {
    $fechaActual = $fechaInicio;
    $diasContados = 0;
    
    // El código original restaba 1 a dHabiles, mantenemos esa lógica
    $objetivo = $diasHabiles - 1; 

    // Convertir fecha a timestamp para iterar
    $ts = strtotime($fechaInicio);

    for ($i = 1; $i <= $objetivo; $i++) {
        // Sumar 1 día
        $ts = strtotime('+1 day', $ts);
        $fechaStr = date('Y-m-d', $ts);
        $diaSemana = date('w', $ts); // 0=Dom, 6=Sab

        // Si es fin de semana o feriado, aumentamos el objetivo (el bucle sigue)
        // Nota: El código original hacía $dh++ (extendía el bucle). 
        // Aquí lo hacemos con un while interno para encontrar el siguiente día hábil válido.
        
        while ($diaSemana == 0 || $diaSemana == 6 || in_array($fechaStr, $feriadosArray)) {
            $ts = strtotime('+1 day', $ts);
            $fechaStr = date('Y-m-d', $ts);
            $diaSemana = date('w', $ts);
        }
    }
    return date('Y-m-d', $ts);
}

// 1.3 Obtener Tipos de Ensayo
$ensayos = [];
$bdEnsayo = $link->query("SELECT * FROM amtpensayo ORDER BY tpEnsayo");
while ($row = mysqli_fetch_array($bdEnsayo)) {
    $ensayos[$row['tpEnsayo']] = [
        'nombre' => $row['Ensayo'],
        'data' => array_fill(1, 12, ['total' => 0, 'atrasados' => 0]),
        'anual' => ['total' => 0, 'atrasados' => 0]
    ];
}

// 1.4 Obtener Cotizaciones/Informes (Consulta Principal)
$dataMensualGeneral = array_fill(1, 12, ['total' => 0, 'atrasados' => 0]);
$sqlCotizaciones = "SELECT tpEnsayo, fechaInicio, dHabiles, nInforme, fechaInformeUP, fechaTermino, MONTH(fechaInicio) as mes 
                    FROM cotizaciones 
                    WHERE Estado = 'T' AND (Fan = 1 OR Fan = 0) AND YEAR(fechaInicio) = '$pAgno'";
$bdC = $link->query($sqlCotizaciones);

while ($row = mysqli_fetch_array($bdC)) {
    $tpEnsayo = $row['tpEnsayo'];
    $mes = $row['mes'];
    
    // Si el tipo de ensayo no está en nuestra lista (borrado o nuevo), lo ignoramos o creamos
    if (!isset($ensayos[$tpEnsayo])) continue;

    // Calcular Fecha Entrega Esperada
    $fechaEntrega = calcularFechaEntrega($row['fechaInicio'], $row['dHabiles'], $feriados);

    // Determinar si está atrasado
    // Lógica original: if($rsc['fechaTermino'] > $fechaEntrega)
    $esAtrasado = ($row['fechaTermino'] > $fechaEntrega);

    // Acumular contadores por Tipo de Ensayo
    $ensayos[$tpEnsayo]['data'][$mes]['total'] += $row['nInforme'];
    $ensayos[$tpEnsayo]['anual']['total'] += $row['nInforme'];

    if ($esAtrasado) {
        $ensayos[$tpEnsayo]['data'][$mes]['atrasados'] += $row['nInforme'];
        $ensayos[$tpEnsayo]['anual']['atrasados'] += $row['nInforme'];
    }

    // Acumular contadores Generales (Fila "Atrasos Mensuales")
    $dataMensualGeneral[$mes]['total'] += $row['nInforme'];
    if ($esAtrasado) {
        $dataMensualGeneral[$mes]['atrasados'] += $row['nInforme'];
    }
}

// -------------------------------------------------------------------------
// PASO 2: LÓGICA CERTIFICACIONES
// -------------------------------------------------------------------------
$certData = array_fill(1, 12, ['total' => 0, 'atrasados' => 0]);
$certAnual = ['total' => 0, 'atrasados' => 0];

// Obtenemos cotizaciones de tipo 5 para el año
$sqlCertCot = "SELECT Observacion, fechaInformeUP, MONTH(fechaInicio) as mes 
               FROM cotizaciones 
               WHERE Estado = 'T' AND tpEnsayo = '5' AND YEAR(fechaInicio) = '$pAgno'";
$bdCC = $link->query($sqlCertCot);

while ($cotRow = mysqli_fetch_array($bdCC)) {
    $ar = substr($cotRow['Observacion'], 0, 7); // Clave para buscar
    $mes = $cotRow['mes'];
    $fechaLimite = $cotRow['fechaInformeUP'];

    // Buscar certificados coincidentes. 
    // NOTA: Esto sigue siendo una consulta dentro de un bucle porque la lógica de enlace (LIKE) es compleja para un JOIN simple.
    // Sin embargo, es menos pesado que la lógica anterior.
    $sqlCert = "SELECT fechaUpLoad FROM certificado WHERE Codcertificado LIKE '%$ar%'"; 
    $bdCert = $linkCert->query($sqlCert);
    
    while ($certRow = mysqli_fetch_array($bdCert)) {
        $certData[$mes]['total']++;
        $certAnual['total']++;
        
        if ($certRow['fechaUpLoad'] > $fechaLimite) {
            $certData[$mes]['atrasados']++;
            $certAnual['atrasados']++;
        }
    }
}

$link->close();
$linkCert->close();

// -------------------------------------------------------------------------
// PASO 3: RENDERIZADO HTML (Vista)
// -------------------------------------------------------------------------
function renderCelda($atrasados, $total) {
    if ($total > 0) {
        $promedio = ($atrasados > 0) ? ($atrasados / $total) : 0;
        echo $atrasados . '/' . $total . '<br>';
        if ($promedio > 0) {
            echo '<a href="#" class="btn btn-danger btn-sm"><b>' . number_format($promedio, 2) . '</b></a>';
        }
    } else {
        echo ''; // Celda vacía si no hay datos
    }
}
?>

<h3 class="bg-light text-dark">Tabla Indicador Informes Atrasados</h3>
<table class="table table-hover table-bordered table-sm"> <thead class="thead-light">
        <tr>
            <th style="padding-left:10px;" width="20%">Informes Atrasados</th>
            <?php for($i=1; $i<=12; $i++) echo '<th class="text-center">'.substr($Mes[$i],0,3).'.'.'</th>'; ?>
            <th class="text-center">Tot.</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($ensayos as $ensayo): ?>
            <tr>
                <td><?php echo $ensayo['nombre']; ?></td>
                <?php 
                // Meses 1-12
                for ($i=1; $i<=12; $i++) {
                    echo '<td class="text-center">';
                    renderCelda($ensayo['data'][$i]['atrasados'], $ensayo['data'][$i]['total']);
                    echo '</td>';
                }
                // Total Anual
                echo '<td class="text-center">';
                renderCelda($ensayo['anual']['atrasados'], $ensayo['anual']['total']);
                echo '</td>';
                ?>
            </tr>
        <?php endforeach; ?>

        <tr class="table-info font-weight-bold">
            <td>Atrasos Mensuales</td>
            <?php 
            $granTotalAtrasados = 0;
            $granTotalInformes = 0;
            for ($i=1; $i<=12; $i++) {
                echo '<td class="text-center">';
                renderCelda($dataMensualGeneral[$i]['atrasados'], $dataMensualGeneral[$i]['total']);
                echo '</td>';
                
                $granTotalAtrasados += $dataMensualGeneral[$i]['atrasados'];
                $granTotalInformes += $dataMensualGeneral[$i]['total'];
            }
            ?>
            <td class="text-center">
                <?php renderCelda($granTotalAtrasados, $granTotalInformes); ?>
            </td>
        </tr>
    </tbody>
</table>

<table class="table table-hover table-bordered table-sm mt-4">
    <thead class="thead-light">
        <tr>
            <th style="padding-left:10px;" width="20%">Certificaciones</th>
            <?php for($i=1; $i<=12; $i++) echo '<th class="text-center">'.substr($Mes[$i],0,3).'.'.'</th>'; ?>
            <th class="text-center">Tot.</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Certificaciones</td>
            <?php 
            for ($i=1; $i<=12; $i++) {
                echo '<td class="text-center">';
                renderCelda($certData[$i]['atrasados'], $certData[$i]['total']);
                echo '</td>';
            }
            ?>
            <td class="text-center">
                <?php renderCelda($certAnual['atrasados'], $certAnual['total']); ?>
            </td>
        </tr>
    </tbody>
</table>