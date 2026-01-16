<?php
    $data = file_get_contents("resultadosQu/vEspectrometro.json"); 
    $products = json_decode($data, true);
    

    $records = $products['records'];
    echo "Total de registros: " . count($records) . "\n\n";
    foreach ($records as $index => $record) {
        echo "Registro " . ($index + 1) . "<br>";
        echo "  RAM: " . $record['RAM'] . "<br>";
        echo "  Programa: " . $record['Programa'] . "<br>";
        echo "  Tipo Muestra: " . $record['tpMuestra'] . "<br>";
        echo "  ID Item: " . $record['idItem'] . "<br>";
        echo "  <br>";
    }
?>