<?php
// 1. Incluir tu archivo de conexión y llamar a la función
include("conexionli.php");
$link = Conectarse(); // $link ahora contiene tu objeto de conexión mysqli

// Verificar que la conexión se haya establecido correctamente
if (!$link || $link->connect_error) {
    die("Error de conexión: " . ($link ? $link->connect_error : "No se pudo establecer la conexión."));
}

// 2. Definir la consulta SQL con el alias para idCotizacion
//    Seleccionamos 'idCotizacion AS CAM' para que la columna se llame CAM en el resultado.
$sql = "SELECT * 
        FROM `cotizaciones` 
        WHERE `tpEnsayo` = ? 
        AND `fechaCotizacion` >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH) AND `RAM` > 0
        ORDER BY `fechaCotizacion` DESC";

// 3. Preparar la consulta
$stmt = $link->prepare($sql);

if ($stmt === false) {
    die("Error al preparar la consulta: " . $link->error);
}

// 4. Vincular el parámetro y ejecutar
$tpEnsayoValor = 3;
$stmt->bind_param("i", $tpEnsayoValor);

$stmt->execute();

// 5. Obtener el conjunto de resultados
$resultado = $stmt->get_result();

// 6. Procesar y mostrar los resultados
if ($resultado->num_rows > 0) {
    echo "<h2>Cotizaciones encontradas:</h2>";
    echo "<table border='1' style='width:100%; border-collapse: collapse;'>";
    echo "<tr style='background-color:#f2f2f2;'>
            <th style='padding: 8px;'>CAM</th>
            <th style='padding: 8px;'>Fecha Cotización</th>
            <th style='padding: 8px;'>Ensayos</th>
          </tr>";

    // Recorrer cada fila del resultado
    while ($fila = $resultado->fetch_assoc()) {
        $RAM = $fila['RAM'];

        echo "<tr>";
        // Ahora usamos 'CAM' para acceder al valor, porque ese es el alias que definimos
        echo "<td style='padding: 8px;'>" . htmlspecialchars($fila['CAM']) . ' - ' . htmlspecialchars($fila['RAM']) . "</td>";
        echo "<td style='padding: 8px;'>" . htmlspecialchars($fila['fechaCotizacion']) . "</td>";
        echo "<td style='padding: 8px;'>";
            $sql = "SELECT * FROM regquimico Where idItem like '%$RAM%'";
            $bd=$link->query($sql);
            while($rs = mysqli_fetch_array($bd)){
                echo $rs['idItem'].'<br>';
            }
            echo '<br';
            $sql = "SELECT * FROM regtraccion Where idItem like '%$RAM%'";
            $bd=$link->query($sql);
            while($rs = mysqli_fetch_array($bd)){
                echo $rs['idItem'].'<br>';
            }
            echo '<br';
            $sql = "SELECT * FROM regcharpy Where idItem like '%$RAM%'";
            $bd=$link->query($sql);
            while($rs = mysqli_fetch_array($bd)){
                echo $rs['idItem'].'<br>';
            }
        echo "</td>";
        echo "</tr>";
    
    }

    echo "</table>";
} else {
    echo "<h3>No se encontraron cotizaciones con TpEnsayo = 3 en los últimos 5 meses.</h3>";
}

// 7. Liberar recursos
$stmt->close();
$link->close();
?>