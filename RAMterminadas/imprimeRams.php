<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
if(isset($_GET['fd'])){ $fd = $_GET['fd']; }
if(isset($_GET['fh'])){ $fh = $_GET['fh']; }

require_once('../fpdf/fpdf.php');
include("../conexionli.php");

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    $this->Image('../imagenes/logonewsimet.jpg',10,02,50);
    $this->Image('../imagenes/cintaceleste.png',0,47,220,250);
    $this->SetFont('Arial','',15);
    $this->Ln(10);
}

// Pie de página
function Footer()
{
    $this->SetTextColor(200, 200, 200);
    $this->SetFont('Arial','',12);
    $this->Image('../gastos/logos/logousach.png',195,250,15,23);

    $this->SetXY(112, -27);
    $this->Cell(0,4,'UNIVERSIDAD DE SANTIAGO DE CHILE',0,0);
    $this->SetFont('Arial','',10);
    $this->SetXY(130, -23);
    $this->Cell(0,4, utf8_decode('Departamento de Ingeniería Metalúrgia'),0,0);
    $this->SetXY(108, -19);
    $this->Cell(0,4,utf8_decode('Laboratorio de Ensayos e Investigación de Materiales'),0,0);
    $this->SetXY(108, -14);
    $this->Cell(0,4,utf8_decode('Av. Ecuador 3769, Estación Central - Santiago - Chile'),0,0);
    $this->SetXY(95, -10);
    $this->Cell(0,4,utf8_decode('Fono:(+569)23234780, Email: simet@usach.cl / www.simet.cl'),0,0);

}
}

$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddPage();

$ln = 10;
$pdf->SetXY(10,$ln);
$pdf->Cell(190,4, utf8_decode('RAM TERMINADAS'),0,0,'C');

$ln += 5;
$pdf->SetFont('Arial','',10);
$pdf->SetXY(10,$ln);
$fdi = explode('-', $fd);
$fdh = explode('-', $fd);
$pdf->Cell(190,4, 'Desde '.$fdi[2].'/'.$fdi[1].'/'.$fdi[0].' - Hasta '.$fdh[2].'/'.$fdh[1].'/'.$fdh[0],0,0,'C');

$ln += 5;
$cl = 0;
$nCol = 1;
$Hay = 'No';

$link=Conectarse();
$SQL = "SELECT * FROM cotizaciones Where Estado = 'T' and RAM > 0 and RAMarchivada != 'on' and fechaTermino >= '$fd' and fechaTermino <= '$fh' Order By fechaTermino Asc";
$bd=$link->query($SQL);
while($rs = mysqli_fetch_array($bd)){
    $Hay = 'Si';
    
    $tEnsayos = array(  
                        'Fr'    => 0, 
                        'Mg'    => 0,
                        'S'     => 0,
                        'Qu'    => 0,
                        'Tr'    => 0,
                        'Do'    => 0,
                        'Du'    => 0,
                        'Md'    => 0,
                        'Ch'    => 0,
                        'M'     => 0,
                        'El'    => 0,
                        'Pl'    => 0,
                        'Qv'    => 0,
                        'DFX'   => 0,
                        'Ot'    => 0
                    );
    $sqle = "SELECT * FROM amtabensayos Where idItem like '%".$rs['RAM']."%'";
    $bde=$link->query($sqle);
    while($rse = mysqli_fetch_array($bde)){
        $tEnsayos[$rse['idEnsayo']] += $rse['cEnsayos'];
    }
    if($nCol == 1){
        $ln += 16;
        $cl += 12;
    }
    if($nCol == 2){
        $cl += 60;
    }
    if($nCol == 3){
        $cl += 60;
    }
    $pdf->SetFont('Arial','',12);
    $pdf->SetXY($cl,$ln);
    $pdf->Cell(50,14, $rs['RAM'],1,0,'C');
    $ensayos = '';
    foreach ($tEnsayos as $key => $valor) {
        if($valor > 0){
            if($ensayos){
                $ensayos .= ' '.$key .' = '. $key=($valor);
            }else{
                $ensayos .= $key .' = '. $key=($valor);
            }
        }
    }
    $pdf->SetFont('Arial','B',8);
    $ln += 7;
    $pdf->SetXY($cl,$ln);
    $pdf->Cell(50,7, $ensayos,0,0,'C');
    $ln -= 7;

    if($nCol == 3){ $nCol = 0; $cl = 0;}
    $nCol++;
}

$link->close();
if($Hay == 'No'){
    $ln = 50;
    $cl = 12;
    $pdf->SetFont('Arial','',12);
    $pdf->SetXY($cl,$ln);
    $pdf->Cell(150,14, 'NO EXISTEN RAM QUE GUARDAR',0,0,'C');

}
$NombreFormulario = "Ram.pdf";
$pdf->Output($NombreFormulario,'D'); //Para Descarga

?>