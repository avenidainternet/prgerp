<?php
// =========================================================================
// 1. CONFIGURACIÓN Y SEGURIDAD
// =========================================================================

// Conexión segura
$link = Conectarse();
if (!$link) {
    die("Error de conexión.");
}

// Sanitización de entrada
$pAgno = isset($pAgno) ? (int)$pAgno : (int)date('Y');

// Asegurar que exista ultUF (Valor de la UF), si viene de un include externo
$valorUF = isset($ultUF) ? $ultUF : 0; 

$mesesNombres = [
    1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr', 5 => 'May', 6 => 'Jun',
    7 => 'Jul', 8 => 'Ago', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'
];

// Perfiles permitidos para el reporte (Ingenieros/Admins)
$perfilesPermitidos = [1, '01', '02'];

// =========================================================================
// 2. OBTENCIÓN DE DATOS (MODELO OPTIMIZADO)
// =========================================================================

// 2.1 Obtener Usuarios (Ingenieros)
$usuarios = [];
$sqlUsr = "SELECT usr, nPerfil FROM Usuarios";
$bdUsr = $link->query($sqlUsr);

while ($row = $bdUsr->fetch_assoc()) {
    // Verificación flexible de tipos (int vs string)
    if (in_array($row['nPerfil'], $perfilesPermitidos) || in_array((int)$row['nPerfil'], $perfilesPermitidos)) {
        $usuarios[] = $row['usr'];
    }
}

// 2.2 Obtener Productividad (Cotizaciones) - UNA SOLA CONSULTA
// Agrupamos por usuario y mes directamente en SQL
$dataProductividad = [];
$sqlProd = "SELECT usrResponzable, MONTH(fechaTermino) as mes, SUM(NetoUF) as totalNeto 
            FROM Cotizaciones 
            WHERE YEAR(fechaTermino) = $pAgno 
              AND RAM > 0 
              AND Estado = 'T'
            GROUP BY usrResponzable, MONTH(fechaTermino)";

$bdProd = $link->query($sqlProd);
while ($row = $bdProd->fetch_assoc()) {
    $u = $row['usrResponzable'];
    $m = (int)$row['mes'];
    
    if (!isset($dataProductividad[$u])) $dataProductividad[$u] = [];
    $dataProductividad[$u][$m] = (float)$row['totalNeto'];
}

// 2.3 Obtener Horas (RelojControl) - UNA SOLA CONSULTA (Opcional, estructura base)
// Nota: La lógica de sumar horas 'HH:MM:SS' es compleja en SQL directo sin funciones extra,
// aquí solo contamos registros o preparamos la estructura para optimización futura.
// Por ahora mantuve la lógica visual limpia, ya que en tu original estaba comentado el cálculo.

$link->close();

// =========================================================================
// 3. PROCESAMIENTO (CONTROLADOR)
// =========================================================================

$tablaReporte = [];
$totalesMensuales = array_fill(1, 12, 0); // Inicializa array del 1 al 12 con 0
$granTotalAnual = 0;

foreach ($usuarios as $usr) {
    $filaData = [];
    $totalUsuario = 0;

    for ($i = 1; $i <= 12; $i++) {
        $valorCalculado = 0;
        
        // Verificamos si existe dato en la matriz precargada
        if (isset($dataProductividad[$usr][$i])) {
            $netoUF = $dataProductividad[$usr][$i];
            
            // Lógica de Negocio Original: (UF_Actual * TotalNeto) / 1.000.000
            if ($valorUF > 0) {
                $valorCalculado = ($valorUF * $netoUF) / 1000000;
            }
        }

        $filaData[$i] = $valorCalculado;

        // Acumuladores
        $totalUsuario += $valorCalculado;
        $totalesMensuales[$i] += $valorCalculado;
    }
    $granTotalAnual += $totalUsuario;

    // Solo agregamos al reporte si el usuario tiene actividad o queremos verlos a todos
    $tablaReporte[] = [
        'usuario' => $usr,
        'meses'   => $filaData,
        'total'   => $totalUsuario
    ];
}

?>

<h3 class="bg-light text-dark p-2 border-bottom">
    <i class="fas fa-industry"></i> Tabla Indicador Productividad <?php echo $pAgno; ?>
</h3>

<div class="table-responsive">
    <table class="table table-hover table-bordered table-sm">
        <thead class="thead-light">
            <tr>
                <th style="width: 15%; vertical-align: middle;">Ingeniero</th>
                <?php for($i=1; $i<=12; $i++): ?>
                    <th class="text-center" style="font-size: 0.9em;">
                        <?php echo $mesesNombres[$i] . '.'; ?>
                    </th>
                <?php endfor; ?>
                <th class="text-center bg-secondary text-white" style="vertical-align: middle;">Tot.</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tablaReporte as $fila): ?>
                <tr>
                    <td style="padding-left:10px; font-weight: 500;">
                        <?php echo $fila['usuario']; ?>
                    </td>
                    
                    <?php for ($i=1; $i<=12; $i++): ?>
                        <td class="text-center">
                            <?php 
                            if ($fila['meses'][$i] > 0) {
                                echo number_format($fila['meses'][$i], 2, ',', '.');
                            } else {
                                echo '<span class="text-muted text-black-50">-</span>';
                            }
                            ?>
                        </td>
                    <?php endfor; ?>

                    <td class="text-center font-weight-bold bg-light">
                        <?php echo ($fila['total'] > 0) ? number_format($fila['total'], 2, ',', '.') : ''; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot class="thead-light">
            <tr class="font-weight-bold border-top-2">
                <th style="padding-left:10px;">TOTAL PRODUCTIVIDAD</th>
                <?php for ($i=1; $i<=12; $i++): ?>
                    <th class="text-center">
                        <?php 
                        if ($totalesMensuales[$i] > 0) {
                            echo number_format($totalesMensuales[$i], 2, ',', '.'); 
                        }
                        ?>
                    </th>
                <?php endfor; ?>
                <th class="text-center bg-secondary text-white">
                    <?php echo number_format($granTotalAnual, 2, ',', '.'); ?>
                </th>
            </tr>
        </tfoot>
    </table>
</div>