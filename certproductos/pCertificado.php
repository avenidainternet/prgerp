<?php
//define('FPDF_FONTPATH','/home/www/font');
require_once("../fpdf182/fpdf.php");
//require_once("../fpdi/src/autoload.php");
//use \setasign\Fpdi\Fpdi;

include("../conexioncert.php"); 
include("../conexionli.php"); 

if(isset($_GET['CodCertificado'])) 	{ $CodCertificado 	= $_GET['CodCertificado']; 	};
$fechaHoy 	= date('Y-m-d');
$fd         = explode('-', $fechaHoy);
$fechaHoy   = $fd[2].'-'.$fd['1'].'-'.$fd[0];

$_SESSION['CodCertificado']	= $CodCertificado;

$linkc=ConectarseCert();
$link=Conectarse();
$bd = $linkc->query("SELECT * FROM certificado Where CodCertificado = '".$CodCertificado."'");
if($rs=mysqli_fetch_array($bd)){
    $bdcl = $linkc->query("SELECT * FROM clientes Where RutCli = '".$rs['RutCli']."'");
    if($rscl=mysqli_fetch_array($bdcl)){
        $_SESSION['Cliente']	= $rscl['Cliente'];
    }
}
$linkc->close();
$link->close();

class PDF extends FPDF
{
        // Cabecera de página
        function Header()
        {
        // Logo
        $Cliente = '';
            
        $this->SetFont('Arial','',9);
        //$this->Cell(60);
        $this->SetXY(50, 5);
        $this->Cell(100,5,'CERTIFICADO DE CONFORMIDAD',0,0,'C');    
        $this->SetXY(50, 10);
        $this->Cell(100,5,$_SESSION['CodCertificado'],0,0,'C');    
        $this->SetXY(50, 15);
        $this->Cell(100,5,$_SESSION['Cliente'],0,0,'C');    
        $this->Image('../imagenes/logocert.png',10,02,50);
        $this->Line(65,1,65,20);
        $this->Line(145,1,145,20);
        $this->Image('../imagenes/inncert.png',150,02,50);
        $this->Image('../imagenes/lineaheadcert.png',5,25,200);
        $this->Image('../imagenes/cintaceleste.png',0,47,220,250); 
        $this->SetFont('Arial','',15);
        $this->Ln(10);
    }

    // Pie de página
    function Footer()
    {
        $this->SetTextColor(200, 200, 200);
        $this->SetFont('Arial','',9);
        $this->Image('../imagenes/cintacolores.png',165,282,40,3);
        $this->SetXY(173, -10);
        $this->Cell(0,4,utf8_decode('Reg. 101501 v.4'),0,0);

    }
}

$pdf = new PDF();

//$pdf=new Fpdi('P','mm','Legal');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);



$linkc=ConectarseCert();
$link=Conectarse();
$bd = $linkc->query("SELECT * FROM certificado Where CodCertificado = '".$CodCertificado."'");
if($rs=mysqli_fetch_array($bd)){
    $bdcl = $linkc->query("SELECT * FROM clientes Where RutCli = '".$rs['RutCli']."'");
    if($rscl=mysqli_fetch_array($bdcl)){
        $Cliente = $rscl['Cliente'];
        $bdpr = $linkc->query("SELECT * FROM tipoproductos Where nProducto = '".$rs['nProducto']."'");
        if($rspr=mysqli_fetch_array($bdpr)){

        }
        $bdac = $linkc->query("SELECT * FROM tipoaceros Where nAcero = '".$rs['nAcero']."'");
        if($rsac=mysqli_fetch_array($bdac)){

        }
        $bdi = $link->query("SELECT * FROM aminformes Where CodInforme = '".$rs['CodInforme']."'");
        if($rsi=mysqli_fetch_array($bdi)){

        }
        $bdmm = $link->query("SELECT * FROM ammuestras Where CodInforme = '".$rs['CodInforme']."'");
        if($rsmm=mysqli_fetch_array($bdmm)){

        }

        $pdf->SetFont('Arial','B',18);
        $y = $pdf->GetY();
        $pdf->SetXY(5, $y);
        $pdf->Cell(200,10,utf8_decode('CERTIFICADO DE CONFORMIDAD: '),0,1,'C');
        $y = $pdf->GetY();
        $pdf->SetXY(5, $y);
        $pdf->Cell(200,10,utf8_decode('AR-ID CERTIFICADO ').$CodCertificado,0,1,'C');

        $pdf->SetFont('Arial','',9);
        $y = $pdf->GetY();
        $pdf->SetXY(5, $y);

        $pdf->SetDrawColor(191, 181, 174); // Color Naranjo claro Linea
        $pdf->SetFillColor(251, 228, 213); // Color Naranjo claro Fondo
        $pdf->Line(5,$y,205,$y);
        $pdf->Cell(200,7,utf8_decode('Identificación del cliente'),0,1,'C', true);
        $y = $pdf->GetY();
        $pdf->SetXY(5, $y);
        $pdf->Line(5,$y,205,$y);
        $pdf->SetFillColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);

        $pdf->SetFont('Arial','B',8);
        $y = $pdf->GetY();
        $pdf->SetXY(5, $y);
        $pdf->Cell(200,7,utf8_decode('Organismo de certificación'),0,1,'L');




    }

}
$linkc->close();
$link->close();


function bClientes(){

    $link=Conectarse();
    $bd = $linkc->query("SELECT * FROM certificado Where CodCertificado = '".$CodCertificado."'");
    if($rs=mysqli_fetch_array($bd)){
        $bdcl = $linkc->query("SELECT * FROM clientes Where RutCli = '".$rs['RutCli']."'");
        if($rscl=mysqli_fetch_array($bdcl)){
            $Cliente = $rscl['Cliente'];
        }
    }
    $link->close();
    $linkc->close();
    return $Cliente;
}

$pdf->Output();
$pdf->Output('Certificados/'.$CodCertificado.'.pdf','F'); //Para Descarga
$pdf->Output('Certificados/'.$CodCertificado.'.pdf','D'); //Para Descarga

?>