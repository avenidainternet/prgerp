<?php
require_once '../PHPExcel/Classes/PHPExcel.php';

// Configuración inicial
$archivo = "resultadosQu/prueba.xlsx";
$inputFileType = PHPExcel_IOFactory::identify($archivo);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($archivo);
$sheet = $objPHPExcel->getSheet(0);

$highestRow = $sheet->getHighestRow();
$highestColumn = $sheet->getHighestColumn();

// Columnas a procesar
$cl = 'A-B-C-D-E-F-G-H-I-J-K-L-M-N-O-P-Q-R-S-T-U-V-W-X-Y-Z-AA-AB-AC-AD-AE-AF-AG-AH-AI-AJ-AK-AL-AM-AN';
$fd = explode('-', $cl);

// Variables de control
$idItem = '';
$RAM    = '';
$inicioData = 0;
$finData = 0;
$procesamientoActivo = false;

// Buscar la estructura del archivo
for ($row = 1; $row <= $highestRow; $row++) {
    $valorA = $sheet->getCell('A' . $row)->getValue();
    $valorF = $sheet->getCell('F' . $row)->getValue();
    // echo 'Fila -> '.$row.'<br>';
    // Verificar si encontramos 'Sample Result Name' en columna A
    if ($valorA == 'Sample Result Name') {
        // La siguiente fila debe contener el $idItem
        if ($row + 1 <= $highestRow) {
            $idItem = $sheet->getCell('A' . ($row + 1))->getValue();
            $RAM = substr($idItem, 0, 5);
            // Verificar si la columna F tiene 'Fe-01+N'
            $metodoF = $sheet->getCell('F' . ($row + 1))->getValue();
            if ($metodoF == 'Fe-01+N') {
                echo "Encontrado ensayo Fe-01+N con ID: $idItem<br>";
                $procesamientoActivo = true;
                $inicioData = $row; // Comenzar desde 'Sample Result Name'
                
                // Buscar la fila que contiene 'Rep' para determinar el final
                for ($searchRow = $row + 1; $searchRow <= $highestRow; $searchRow++) {
                    $valorRep = $sheet->getCell('A' . $searchRow)->getValue();
                    if ($valorRep == 'Rep') {
                        $finData = $searchRow;
                        break;
                    }
                }
                
                if ($finData > 0) {
                    echo "Rango de datos encontrado: Fila $inicioData a Fila $finData<br>";
                    
                    // Crear el nuevo archivo Excel
                    crearArchivoExcel($sheet, $inicioData, $finData, $fd, $idItem, $RAM);
                    // break; // Salir del bucle principal
                }
            }
        }
    }
}

if (!$procesamientoActivo) {
    echo "No se encontró ningún ensayo con método 'Fe-01+N' o estructura válida.";
}

/**
 * Función para crear el archivo Excel
 */
function crearArchivoExcel($sheet, $inicioData, $finData, $columnas, $idItem, $RAM) {
    try {
        // Crear nuevo objeto PHPExcel
        $nuevoExcel = new PHPExcel();
        $nuevaHoja = $nuevoExcel->getActiveSheet();
        
        // Copiar datos desde la columna A hasta AN
        $filaDestino = 1;
        
        for ($fila = $inicioData; $fila <= $finData; $fila++) {
            $colDestino = 0;
            
            foreach ($columnas as $columna) {
                $valor = $sheet->getCell($columna . $fila)->getValue();
                $nuevaHoja->setCellValueByColumnAndRow($colDestino, $filaDestino, $valor);
                $colDestino++;
            }
            $filaDestino++;
        }
        
        // Configurar headers para descarga
        $nombreArchivo = "Orientacion" . $RAM . ".xls";
        $rutaCompleta = "Y://AAA/LE/LABORATORIO/2025/$RAM/Qu/" . $nombreArchivo;
        
        // Verificar si la carpeta existe, si no, crearla
        $directorio = "Y://AAA/LE/LABORATORIO/2025/$RAM/Qu";
        if (!file_exists($directorio)) {
            mkdir($directorio, 0777, true);
            echo "Directorio creado: $directorio<br>";
        }
        
        // Crear writer y guardar archivo
        $objWriter = PHPExcel_IOFactory::createWriter($nuevoExcel, 'Excel5');
        
        // Guardar en la carpeta especificada
        $objWriter->save($rutaCompleta);
        echo "Archivo guardado exitosamente en: $rutaCompleta<br>";
        
        // También enviar al navegador para descarga (opcional)
        // header("Content-Type: application/vnd.ms-excel");
        // header("Expires: 0");
        // header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        // header("Content-Disposition: attachment;filename=$nombreArchivo");
        
        // Crear un nuevo writer para la descarga
        // $downloadWriter = PHPExcel_IOFactory::createWriter($nuevoExcel, 'Excel5');
        // $downloadWriter->save('php://output');
        
        // Limpiar memoria
        // $nuevoExcel->disconnectWorksheets();
        // unset($nuevoExcel);
        
    } catch (Exception $e) {
        echo "Error al crear el archivo Excel: " . $e->getMessage() . "<br>";
    }
}

/**
 * Función auxiliar para debug - mostrar contenido de una fila
 */
function mostrarFilaDebug($sheet, $fila, $columnas) {
    echo "Fila $fila: ";
    foreach ($columnas as $col) {
        $valor = $sheet->getCell($col . $fila)->getValue();
        echo "$col:$valor | ";
    }
    echo "<br>";
}

// Función para logging (opcional)
function logProceso($mensaje) {
    $logFile = "Y://AAA/LE/LABORATORIO/2025/20467/Qu/proceso_log.txt";
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$timestamp] $mensaje\n", FILE_APPEND | LOCK_EX);
}

echo "<br>Proceso completado.";
?>