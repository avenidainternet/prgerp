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
$archivo = "ListaPersonal.xlsx";
$archivo = "resultadosQu/prueba.xlsx";
$inputFileType = PHPExcel_IOFactory::identify($archivo);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($archivo);
$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 
$highestColumn = $sheet->getHighestColumn();?>

<table class="table table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>RAM</th>
          <th>Fecha</th>
          <th>Programa</th>
          <th>Tipo</th>
          <th>C</th>
          <th>Si</th>
          <th>Mn</th>
          <th>P</th>
          <th>S</th>
          <th>Cr</th>
          <th>Ni</th>
          <th>Mo</th>
          <th>Al</th>
          <th>Cu</th>
          <th>Co</th>
          <th>Ti</th>
          <th>Nb</th>
          <th>V</th>
          <th>W</th>
          <th>B</th>
        </tr>
      </thead>
      <tbody>


      <?php
      $num=0;
      for ($row = 2; $row <= $highestRow; $row++){ 
            if($sheet->getCell("D".$row)->getValue() == 'Average' and $sheet->getCell("C".$row)->getValue() != 'Fe-01-M' and $sheet->getCell("A".$row)->getValue() != '' and $sheet->getCell("C".$row)->getValue() != 'Al-01-M' and $sheet->getCell("C".$row)->getValue() != 'Cu-01-M'	){
              $num++;
              $fr = explode('-',$sheet->getCell("A".$row)->getValue());
              $Otam = $fr[0];
              if($fr[1]){
                $Otam .= '-'.$fr[1];
              }
              if(sizeof($fr) == 3){
                $Otam .= '-'.$fr[2];
              }
              ?>
              <tr>
                <th scope='row'><?php echo $num.' '.$Otam;?></th>
                <td><?php echo $sheet->getCell("A".$row)->getValue();?></td>
                <td><?php echo $sheet->getCell("B".$row)->getValue();?></td>
                <td><?php echo $sheet->getCell("C".$row)->getValue();?></td>
                <td><?php echo $sheet->getCell("D".$row)->getValue();?></td>
                <td><?php echo $sheet->getCell("E".$row)->getValue();?></td>
                <td><?php echo $sheet->getCell("F".$row)->getValue();?></td>
                <td><?php echo $sheet->getCell("G".$row)->getValue();?></td>
                <td><?php echo $sheet->getCell("H".$row)->getValue();?></td>
                <td><?php echo $sheet->getCell("I".$row)->getValue();?></td>
                <td><?php echo $sheet->getCell("J".$row)->getValue();?></td>
                <td><?php echo $sheet->getCell("K".$row)->getValue();?></td>
                <td><?php echo $sheet->getCell("L".$row)->getValue();?></td>
                <td><?php echo $sheet->getCell("M".$row)->getValue();?></td>
                <td><?php echo $sheet->getCell("N".$row)->getValue();?></td>
                <td><?php echo $sheet->getCell("O".$row)->getValue();?></td>
                <td><?php echo $sheet->getCell("P".$row)->getValue();?></td>
                <td><?php echo $sheet->getCell("Q".$row)->getValue();?></td>
                <td><?php echo $sheet->getCell("R".$row)->getValue();?></td>
                <td><?php echo $sheet->getCell("S".$row)->getValue();?></td>
                <td><?php echo $sheet->getCell("T".$row)->getValue();?></td>
              </tr>
              <?php
            }

      }
      ?>
          </tbody>
    </table>
  </div>	
 </div>	
</div>
</body>
</html>
