<?php
    require_once '../PHPExcel/Classes/PHPExcel.php';
    $fechaHoy = date('Y-m-d');    

    $archivo = 'tmp/Espectrometro-'.$fechaHoy.'.xlsx';
    if(file_exists($archivo)){
        $inputFileType = PHPExcel_IOFactory::identify($archivo);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($archivo);
        $sheet = $objPHPExcel->getSheet(0); 
        $highestRow = $sheet->getHighestRow(); 
        $highestColumn = $sheet->getHighestColumn();
        $columnas   = 'B-C-D-E-F-G-H-I-J-K-L-M-N-O-P-Q-R-S-T-U-V-W-X-Y-Z-AA-AB-AC-AD-AE-AF-AG-AH-AI-AJ-AK-AL-AM-AN';
        $fd = explode('-',$columnas);
        $row = 5;
        $elemento = $sheet->getCell("B".$row)->getValue();
        $col = 0;
        for($i=1; $i<=sizeof($fd); $i++){
            $col++;
            if($sheet->getCell($fd[$i-1].$row)->getValue() == ''){
                break;
            }
            echo $sheet->getCell($fd[$i-1].$row)->getValue().'-';
        }


    }
?>