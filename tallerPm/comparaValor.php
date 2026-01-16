<?php


function compararValores($valorDefecto, $valor) {
    // Extraer el valor numérico de $valorDefecto (quitar el '<' y convertir coma a punto)
    $valorDefectoLimpio = ltrim($valorDefecto, '<');
    $valorDefectoNumerico = (float) str_replace(',', '.', $valorDefectoLimpio);
    
    // Calcular cantidad de decimales en $valorDefecto
    $partes = explode(',', $valorDefectoLimpio);
    if (count($partes) == 1) {
        $partes = explode('.', $valorDefectoLimpio);
    }
    $decimales = isset($partes[1]) ? strlen($partes[1]) : 0;
    
    // Convertir $valor a número (cambiar coma a punto si es necesario)
    $valorNumerico = (float) str_replace(',', '.', $valor);
    
    // Si el valor es menor que el valor por defecto, devolver el valor por defecto
    if ($valorNumerico < $valorDefectoNumerico) {
        return $valorDefecto;
    }
    
    // Si no, aproximar (redondear) el valor a la misma cantidad de decimales y devolverlo
    $valorAproximado = round($valorNumerico, $decimales);
    
    // Formatear con la misma notación (coma o punto) que tenía el valor original
    if (strpos($valor, ',') !== false) {
        return number_format($valorAproximado, $decimales, ',', '');
    } else {
        return number_format($valorAproximado, $decimales, '.', '');
    }
}

// Ejemplos de uso:
$valorDefecto = '<0,001';
$valor = '0,007';

$resultado = compararValores($valorDefecto, $valor);
echo "Valor por defecto: $valorDefecto <br>";
echo "Valor a comparar: $valor <br>";
echo "Resultado: $resultado <br> <br>";

echo "\n--- Más ejemplos ---<br>";

// Ejemplo donde el valor es mayor
$valor2 = '0,05632';
$resultado2 = compararValores($valorDefecto, $valor2);
echo "Valor por defecto: $valorDefecto <br>";
echo "Valor a comparar: $valor2 <br>";
echo "Resultado: $resultado2 (aproximado a 2 decimales) <br><br>";

// Ejemplo con punto decimal
$valor3 = '0.003789';
$resultado3 = compararValores($valorDefecto, $valor3);
echo "\nValor por defecto: $valorDefecto <br>";
echo "Valor a comparar: $valor3 <br>";
echo "Resultado: $resultado3 <br> <br>";

// Ejemplo con más decimales
$valor4 = '0,123456';
$resultado4 = compararValores($valorDefecto, $valor4);
echo "\nValor por defecto: $valorDefecto <br>";
echo "Valor a comparar: $valor4 <br>";
echo "Resultado: $resultado4 (aproximado a 2 decimales) <br> <br>";

// Ejemplo que muestra la diferencia entre aproximar vs truncar
$valor5 = '0,05999';
$resultado5 = compararValores($valorDefecto, $valor5);
echo "\nValor por defecto: $valorDefecto <br>";
echo "Valor a comparar: $valor5 <br>";
echo "Resultado: $resultado5 (0,05999 aproximado a 2 decimales = 0,06) <br>";

?>