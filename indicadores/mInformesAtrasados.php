<?php
// Validamos variables externas
if (!isset($pAgno)) $pAgno = date('Y');
if (!isset($Mes)) {
    $Mes = [1=>'Enero', 2=>'Febrero', 3=>'Marzo', 4=>'Abril', 5=>'Mayo', 6=>'Junio', 
            7=>'Julio', 8=>'Agosto', 9=>'Septiembre', 10=>'Octubre', 11=>'Noviembre', 12=>'Diciembre'];
}

$link = Conectarse();

// -------------------------------------------------------------------------
// PASO 1: LÓGICA DE DATOS (Back-end)
// -------------------------------------------------------------------------

// 1.1 Obtener todos los feriados del año en un array simple
$feriados = [];
$sqlFeriados = "SELECT fecha FROM diasferiados WHERE YEAR(fecha) = '$pAgno'";
$bdF = $link->query($sqlFeriados);
while ($row = mysqli_fetch_array($bdF)) {
    $feriados[] = $row['fecha'];
}

// 1.2 Función optimizada para calcular fecha hábil (sin tocar la BD)
function calcularFechaEntrega($fechaInicio, $diasHabiles, $feriadosArray) {
    // La lógica original restaba 1 a dHabiles
    $objetivo = $diasHabiles - 1; 
    $ts = strtotime($fechaInicio);

    for ($i = 1; $i <= $objetivo; $i++) {
        $ts = strtotime('+1 day', $ts);
        $fechaStr = date('Y-m-d', $ts);
        $diaSemana = date('w', $ts); // 0=Dom, 6=Sab
        
        // Mientras sea fin de semana o feriado, avanzamos un día extra sin contar en $i
        while ($diaSemana == 0 || $diaSemana == 6 || in_array($fechaStr, $feriadosArray)) {
            $ts = strtotime('+1 day', $ts);
            $fechaStr = date('Y-m-d', $ts);
            $diaSemana = date('w', $ts);
        }
    }
    return date('Y-m-d', $ts);
}

// 1.3 Estructura de datos para Ensayos
$ensayosData = [];
// Obtenemos los nombres de los ensayos primero
$bdEnsayo = $link->query("SELECT tpEnsayo, Ensayo FROM amtpensayo ORDER BY tpEnsayo");
while ($row = mysqli_fetch_array($bdEnsayo)) {
    $ensayosData[$row['tpEnsayo']] = [
        'nombre' => $row['Ensayo'],
        'meses'  => array_fill(1, 12, ['total' => 0, 'atrasados' => 0]),
        'anual'  => ['total' => 0, 'atrasados' => 0]
    ];
}

// 1.4 Estructura para Totales Generales (Fila inferior)
$totalesMensuales = array_fill(1, 12, ['total' => 0, 'atrasados' => 0]);
$totalAnualGeneral = ['total' => 0, 'atrasados' => 0];

// 1.5 Consulta Principal (Traemos todo de una vez)
// Nota: Quitamos el filtro 'Fan' ya que no estaba en tu snippet original de este archivo,
// pero mantenemos el Estado='T'.
$sqlMain = "SELECT tpEnsayo, fechaInicio, dHabiles, nInforme, fechaTermino, MONTH(fechaInicio) as mes 
            FROM cotizaciones 
            WHERE Estado = 'T' AND YEAR(fechaInicio) = '$pAgno'";

$bdC = $link->query($sqlMain);

while ($row = mysqli_fetch_array($bdC)) {
    $tp = $row['tpEnsayo'];
    $mes = $row['mes'];

    // Si el ensayo no existe en la tabla amtpensayo (o fue borrado), saltamos
    if (!isset($ensayosData[$tp])) continue;

    // Calcular fecha límite real
    $fechaLimite = calcularFechaEntrega($row['fechaInicio'], $row['dHabiles'], $feriados);
    
    // Verificar atraso
    // Lógica original: if($rsc['fechaTermino'] > $fechaEntrega)
    $esAtrasado = ($row['fechaTermino'] > $fechaLimite);

    // -- Acumular datos por Ensayo --
    // Nota: El original usaba $cuentaInformes++ (contaba registros), no sumaba nInforme.
    // Si necesitas sumar nInforme, cambia 1 por $row['nInforme'].
    $incremento = 1; 

    $ensayosData[$tp]['meses'][$mes]['total'] += $incremento;
    $ensayosData[$tp]['anual']['total'] += $incremento;

    if ($esAtrasado) {
        $ensayosData[$tp]['meses'][$mes]['atrasados'] += $incremento;
        $ensayosData[$tp]['anual']['atrasados'] += $incremento;
    }

    // -- Acumular datos Generales --
    $totalesMensuales[$mes]['total'] += $incremento;
    $totalAnualGeneral['total'] += $incremento;
    
    if ($esAtrasado) {
        $totalesMensuales[$mes]['atrasados'] += $incremento;
        $totalAnualGeneral['atrasados'] += $incremento;
    }
}

$link->close();

// -------------------------------------------------------------------------
// PASO 2: RENDERIZADO (Vista HTML)
// -------------------------------------------------------------------------

// Helper para dibujar la celda repetitiva
function dibujarCelda($atrasados, $total) {
    if ($total > 0) {
        echo $atrasados . '/' . $total . '<br>';
        $promedio = ($atrasados > 0) ? ($atrasados / $total) : 0;
        if ($promedio > 0) {
            echo '<a href="#" class="btn btn-danger btn-sm"><b>' . number_format($promedio, 2) . '</b></a>';
        }
    } else {
        echo '';
    }
}
?>

<h3 class="bg-light text-dark">Tabla Indicador Informes Procesos</h3>
<table class="table table-hover table-bordered table-sm">
	<thead class="thead-light">
        <tr>
            <th style="padding-left:10px;" width="20%">Informes Procesos</th>
            <?php for($i=1; $i<=12; $i++) { echo '<th class="text-center">'.substr($Mes[$i],0,3).'.'.'</th>'; } ?>
            <th class="text-center">Tot.</th>
        </tr>
	</thead>
	<tbody>
        <?php foreach($ensayosData as $tp => $data): ?>
            <tr>
                <td><?php echo $data['nombre']; ?></td>
                <?php
                // Columnas de Meses
                for($i=1; $i<=12; $i++){
                    echo '<td class="text-center">';
                    dibujarCelda($data['meses'][$i]['atrasados'], $data['meses'][$i]['total']);
                    echo '</td>';
                }
                ?>
                <td class="text-center">
                    <?php dibujarCelda($data['anual']['atrasados'], $data['anual']['total']); ?>
                </td>
            </tr>
        <?php endforeach; ?>

        <tr class="table-info font-weight-bold">
            <td>Procesos Mensuales</td>
            <?php 
                for($i=1; $i<=12; $i++){
                    echo '<td class="text-center">';
                    dibujarCelda($totalesMensuales[$i]['atrasados'], $totalesMensuales[$i]['total']);
                    echo '</td>';
                }
            ?>
            <td class="text-center">
                <?php dibujarCelda($totalAnualGeneral['atrasados'], $totalAnualGeneral['total']); ?>
            </td>
        </tr>
	</tbody>
</table>