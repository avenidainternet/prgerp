<!DOCTYPE html>
<html>
<head>
	<title>Leer Archivo Excel usando PHP</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container-fuid ml-2">
	<h2>Ejemplo: Leer Archivos Excel con PHP</h2>	
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Resultados de archivo de Excel.</h3>
      </div>
      <div class="panel-body">
        <div class="col-lg-12">
            
<?php
require_once '../PHPExcel/Classes/PHPExcel.php';

$archivo = "resultadosQu/prueba.xlsx";

$inputFileType = PHPExcel_IOFactory::identify($archivo);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($archivo);
$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 
$highestColumn = $sheet->getHighestColumn();

$cl   = 'B-C-D-E-F-G-H-I-J-K-L-M-N-O-P-Q-R-S-T-U-V-W-X-Y-Z-AA-AB-AC-AD-AE-AF-AG-AH-AI-AJ-AK-AL-AM-AN';
$fd = explode('-',$cl);

$num=0;
for ($row = 1; $row <= $highestRow; $row++){ 
  // Leer encabezado
  if($sheet->getCell("A".$row)->getValue() == 'Sample Result Name'){
    $i = $row + 1;
    $Programa = $sheet->getCell('F'.$i)->getValue();
    echo '<b> Programa : '.$Programa.'</b>';
  }
  if($sheet->getCell("A".$row)->getValue() == 'Sample Name'){
    $i = $row + 1;
    $idItem = $sheet->getCell('A'.$i)->getValue();
    echo '<b> Cód.Ensayo : '.$idItem.'</b><br><br>';
    $r = $row + 1;
    ?>
    <table class="table table-bordered">
      <thead>
        <tr>
    <?php
  
    for($j=1; $j<=sizeof($fd); $j++){
      $r = $row + 2;
      if($sheet->getCell($fd[$j-1].$r)->getValue() != ''){
        echo '<th>'.$sheet->getCell($fd[$j-1].$r)->getValue().'</th>';
      }
    }
    ?>
        </tr>
      </thead>
    <?php
  }
  if($sheet->getCell("A".$row)->getValue() == 'Rep'){
    ?>
      </tbody>
        </tr>
    <?php
    for($i=1; $i<=sizeof($fd); $i++){
      if($sheet->getCell($fd[$i-1].$r)->getValue() != ''){
        echo '<td>'.$sheet->getCell($fd[$i-1].$row)->getValue().'</td>';
      }
    }
    ?>
        </tr>
      </tbody>
    </table>
    <?php
  }
  // for ($col = 1; $col <= $highestColumn; $col++){ 
  // }
}
?>
