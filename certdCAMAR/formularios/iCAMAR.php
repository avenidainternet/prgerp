<?php
	header ('Content-type: text/html; charset=utf-8'); 
	require_once('../../fpdf/fpdf.php');
    include_once("../../conexionli.php");

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    $this->Image('../../imagenes/logocert.PNG',10,02,50);
    $this->Image('../../imagenes/cintaceleste.png',0,47,220,250); 
    $this->SetFont('Arial','',15);
    $this->Ln(10);
}

// Pie de página
function Footer()
{
	$this->SetTextColor(200, 200, 200);
    $this->SetFont('Arial','',12);
    $this->Image('../../gastos/logos/logousach.png',195,250,15,23);

    $this->SetXY(112, -27);
    $this->Cell(0,4,'UNIVERSIDAD DE SANTIAGO DE CHILE',0,0);
    $this->SetFont('Arial','',10);
    $this->SetXY(130, -23);
    $this->Cell(0,4, utf8_decode('Departamento de Ingeniería Metalúrgia'),0,0);
    $this->SetXY(108, -19);
    $this->Cell(0,4,utf8_decode('Laboratorio de Ensayos e Investigación de Materiales'),0,0);
    $this->SetXY(108, -14);
    $this->Cell(0,4,utf8_decode('Av. Ecuador 3769, Estación Central - Santiago - Chile'),0,0);
    $this->SetXY(10, -10);
    $this->Cell(0,4,utf8_decode('Reg. 0201 V.07'),0,0);
    $this->SetXY(95, -10);
    $this->Cell(0,4,utf8_decode('Fono:(+562)23234780, Email: simet@usach.cl / www.simet.cl'),0,0);

}
}




$accion = '';
if(isset($_GET['CAM'])) 	{ $CAM 	= $_GET['CAM']; 	}
if(isset($_GET['Rev'])) 	{ $Rev 	= $_GET['Rev'];		}
if(isset($_GET['Cta'])) 	{ $Cta 	= $_GET['Cta'];		}
if(isset($_GET['accion'])) 	{ $accion = $_GET['accion'];}



$Mes = array(
    'Enero', 
    'Febrero',
    'Marzo',
    'Abril',
    'Mayo',
    'Junio',
    'Julio',
    'Agosto',
    'Septiembre',
    'Octubre',
    'Noviembre',
    'Diciembre'
);
$Estado = 'E';
$Rev = '0';
$link=Conectarse();
$bdCAM=$link->query("SELECT * FROM cotizaciones WHERE CAM = '$CAM'");
if($rowCAM=mysqli_fetch_array($bdCAM)){
    if($rowCAM['Estado']){
        $Estado = $rowCAM['Estado'];
    }
    $Rev = $rowCAM['Rev'];
    /* Encabezado Cotización */
    
    //$pdf = new PDF();
    $pdf=new PDF('P','mm','Letter');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial','',12);

    $fd = explode('-', $rowCAM['fechaCotizacion']);
    $ln = 20;
    $pdf->SetXY(140,$ln);
    $pdf->Cell(30,4,'Fecha: '.$fd[2].'/'.$fd[1].'/'.$fd[0] ,0,0,'L');
    $ln += 4;
    $pdf->SetXY(85,$ln);
    $pdf->Cell(30,4, utf8_decode('PRE COTIZACIÓN'),0,0,'L');
    $pdf->SetXY(140,$ln);
    $pdf->Cell(30,4, utf8_decode('CAM '.$CAM),0,0,'L');
    $ln += 4;
    $pdf->SetXY(140,$ln);
    $Rev = $rowCAM['Rev'];
    if($Rev < 10){ $Rev = '0'.$Rev.'.'; }
    $pdf->Cell(30,4, utf8_decode('Rev. '.$Rev),0,0,'L');

    /* CUADRO ID CLIENTE */
    $ln += 7;
    $pdf->SetXY(10,$ln);
    $pdf->SetDrawColor(200, 200, 200);
    $pdf->SetLineWidth(0.8);
    $pdf->MultiCell(190,24, '',1,0,'',false);
    $pdf->SetDrawColor(0, 0, 0);

    $bdCli=$link->query("SELECT * FROM clientes WHERE RutCli = '".$rowCAM['RutCli']."'");
    if($rowCli=mysqli_fetch_array($bdCli)){

        $ln += 2;
        $pdf->SetFont('Arial','',10);
        $pdf->SetXY(12,$ln);
        $pdf->Cell(30,4, utf8_decode('Empresa / Cliente'),0,0,'L');
        $pdf->SetXY(45,$ln);
        $pdf->Cell(2,4, utf8_decode(':'),0,0,'L');
        $pdf->SetXY(47,$ln);
        $pdf->Cell(2,4, utf8_decode(strtoupper($rowCli['Cliente'])),0,0,'L');
    
        $ln += 5;
        $pdf->SetXY(12,$ln);
        $pdf->Cell(30,4, utf8_decode('Teléfono'),0,0,'L');
        $pdf->SetXY(45,$ln);
        $pdf->Cell(2,4, utf8_decode(':'),0,0,'L');

        $bdCon=$link->query("SELECT * FROM contactoscli WHERE RutCli = '".$rowCAM['RutCli']."' and nContacto = '".$rowCAM['nContacto']."'");
        if($rowCon=mysqli_fetch_array($bdCon)){

            $pdf->SetXY(47,$ln);
            $pdf->Cell(2,4, utf8_decode(strtoupper($rowCon['Telefono'])),0,0,'L');
            
            $ln += 5;
            $pdf->SetXY(12,$ln);
            $pdf->Cell(30,4, utf8_decode('Contacto'),0,0,'L');
            $pdf->SetXY(45,$ln);
            $pdf->Cell(2,4, utf8_decode(':'),0,0,'L');
            $pdf->SetXY(47,$ln);
            $pdf->Cell(2,4, utf8_decode(strtoupper($rowCon['Contacto'])).', '.($rowCon['Email']),0,0,'L');

        }
    }
    $ln += 5;
    $pdf->SetXY(12,$ln);
    $pdf->Cell(30,4, utf8_decode('Servicio'),0,0,'L');
    $pdf->SetXY(45,$ln);
    $pdf->Cell(2,4, utf8_decode(':'),0,0,'L');
    $pdf->SetXY(47,$ln);
    $pdf->Cell(2,4, utf8_decode($rowCAM['Descripcion']),0,0,'L');

    /* Fín Encabezado Cotización */

    $pdf->SetDrawColor(255, 255, 255);
//    $pdf->SetLineWidth(0.8);

    $ln += 14;
    $pdf->SetFont('Arial','',10);
    
    $pdf->SetXY(10,$ln);
    $pdf->MultiCell(20,8,'Cantidad',1,'C');
    
    $pdf->SetXY(40,$ln);
    $pdf->MultiCell(115,8,'ITEM',1,'C');

    $pdf->SetXY(155,$ln);
    $pdf->MultiCell(22,8,'',1,'C');
    $pdf->SetXY(155,$ln);
    $pdf->Cell(22,4,'Valor',0,0,'C');
    $pdf->SetXY(155,$ln+4);
    if($rowCAM['Moneda']=='U'){
        $pdf->Cell(22,4,'Unitario UF',0,0,'C');
    }else{
        $pdf->Cell(22,4,'Unitario $',0,0,'C');
    }
    $totalNeto      = 0;
    $totalIva       = 0;
    $totalBruto     = 0;
    $tNet           = 0;
    $tIva           = 0;
    $tBru           = 0;

    $Moneda = 'UF';
    $pdf->SetXY(177,$ln);
    $pdf->MultiCell(23,8,'',1,'C');
    $pdf->SetXY(177,$ln);
    $pdf->Cell(23,4,'Valor',0,0,'C');
    $pdf->SetXY(177,$ln+4);
    if($rowCAM['Moneda']=='U'){
        $pdf->Cell(23,4,'Total UF',0,0,'C');
        $tNet = $rowCAM['NetoUF'];
        $tIva = $rowCAM['IvaUF'];
        $tBru = $rowCAM['BrutoUF'];
    }
    if($rowCAM['Moneda']=='P'){
        $pdf->Cell(23,4,'Total $',0,0,'C');
        $Moneda = '$';
        $tNet = $rowCAM['Neto'];
        $tIva = $rowCAM['Iva'];
        $tBru = $rowCAM['Bruto'];
    }			
    if($rowCAM['Moneda']=='D'){
        $pdf->Cell(23,4,'Total $US',0,0,'C');
        $Moneda = 'US$';
        $tNet = $rowCAM['NetoUS'];
        $tIva = $rowCAM['IvaUS'];
        $tBru = $rowCAM['BrutoUS'];
    }			
    $totalCot 	= 0;
    $nlineas  	= 0;
    $totalPesos	= 0;
    $totalDolar = 0;

    $pdf->SetDrawColor(200, 200, 200);

    $bdIns=$link->query("SELECT * FROM Empresa");
    if($rowIns=mysqli_fetch_array($bdIns)){
        $nombreFantasia     = $rowIns['nombreFantasia'];
    }

    $ln += 2;
    $nLineas = 0;
    $bddCAM=$link->query("SELECT * FROM dcotizacion WHERE CAM = '$CAM' Order By nLin Asc");
    while($rowdCAM=mysqli_fetch_array($bddCAM)){
        $pdf->SetFont('Arial','',8);
        $nLineas++;
        if($rowCAM['Moneda']=='U'){
            $totalNeto 	+= $rowdCAM['NetoUF'];
        }
        if($rowCAM['Moneda']=='P'){
            $totalNeto += $rowdCAM['Neto'];
        }
        if($rowCAM['Moneda']=='D'){
            $totalNeto += $rowdCAM['NetoUS'];
        }
        $ln += 6;
        $pdf->SetXY(10,$ln);
        $pdf->Cell(20,6,'',1,0,'C');
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(20,6,$rowdCAM['Cantidad'],0,'C');

        $pdf->SetXY(30,$ln);
        $pdf->Cell(125,6,'',1,0,'C');
        $bdSer=$link->query("SELECT * FROM servicios WHERE nServicio = '".$rowdCAM['nServicio']."'");
        if($rowSer=mysqli_fetch_array($bdSer)){
            $Servicio 	= utf8_decode($rowSer['Servicio']);
            $ValorUF 	= $rowSer['ValorUF'];
        }
        $pdf->SetXY(30,$ln);
        $pdf->MultiCell(125,6,$Servicio,0,'L');

        $pdf->SetXY(155,$ln);
        $pdf->Cell(22,6,'',1,0,'C');
        $pdf->SetXY(155,$ln);
        if($rowCAM['Moneda']=='U'){
            $pdf->MultiCell(22,6,number_format($rowdCAM['unitarioUF'], 2, '.', ','),0,'R');
        }
        if($rowCAM['Moneda']=='D'){
            $pdf->MultiCell(22,6,number_format($rowdCAM['unitarioUS'], 0, '.', ','),0,'R');
        }
        if($rowCAM['Moneda']=='P'){
            $pdf->MultiCell(22,6,number_format($rowdCAM['unitarioP'], 0, '.', ','),0,'R');
        }

        $pdf->SetXY(177,$ln);
        $pdf->Cell(23,6,'',1,0,'C');
        $pdf->SetXY(177,$ln);
        if($rowCAM['Moneda']=='U'){
            $pdf->MultiCell(23,6,number_format($rowdCAM['NetoUF'], 2, '.', ','),0,'R');
        }
        if($rowCAM['Moneda']=='P'){
            $pdf->MultiCell(23,6,number_format($rowdCAM['Neto'], 0, '.', ','),0,'R');
        }
        if($rowCAM['Moneda']=='D'){
            $pdf->MultiCell(23,6,number_format($rowdCAM['NetoUS'], 0, '.', ','),0,'R');
        }

    }
    if($nLineas<11){
        for($i=$nLineas; $i<11; $i++){
            $ln += 6;
            $pdf->SetXY(10,$ln);
            $pdf->Cell(20,6,'',1,0,'C');
            $pdf->SetXY(30,$ln);
            $pdf->Cell(125,6,'',1,0,'C');
            $pdf->SetXY(155,$ln);
            $pdf->Cell(22,6,'',1,0,'C');
            $pdf->SetXY(177,$ln);
            $pdf->Cell(23,6,'',1,0,'C');
        }
    }
    $ln += 6;
    $pdf->SetXY(155,$ln);
    $pdf->Cell(22,6,'Neto '.$Moneda,1,0,'C');
    $pdf->SetXY(177,$ln);
    if($Moneda == 'UF'){
        $pdf->Cell(23,6,number_format($totalNeto, 2, '.', ','),1,0,'R');
    }else{
        $pdf->Cell(23,6,number_format($totalNeto, 0, '.', ','),1,0,'R');
    }
    $Desc = 0;
    if($rowCAM['pDescuento']>0){
        $ln += 6;
        $Desc = $totalNeto * ($rowCAM['pDescuento']/100);
        $pdf->SetXY(155,$ln);
        $pdf->Cell(22,6,number_format($rowCAM['pDescuento'],0,'.',',').'% Desc.',1,0,'C');
        $pdf->SetXY(177,$ln);
        if($Moneda == 'UF'){
            $pdf->Cell(23,6,number_format($Desc, 2, '.', ','),1,0,'R');
        }else{
            $pdf->Cell(23,6,number_format($Desc, 0, '.', ','),1,0,'R');
        }
        $ln += 6;
        $pdf->SetXY(155,$ln);
        $pdf->Cell(22,6,'Sub Total '.$Moneda,1,0,'C');
        $pdf->SetXY(177,$ln);
        if($Moneda == 'UF'){
            $tNet = $totalNeto - $Desc;
            $pdf->Cell(23,6,number_format($tNet, 2, '.', ','),1,0,'R');
        }ELSE{
            $pdf->Cell(23,6,number_format($tNet, 0, '.', ','),1,0,'R');
        }
    }
    $tIva = $tNet * 0.19;
    $tBru = $tNet + $tIva;
    if($rowCAM['exentoIva'] == 'on'){
        $tIva = 0;
        $tBru = $tNet;
    }

    $ln += 6;
    $pdf->SetXY(155,$ln);
    $pdf->Cell(22,6,'IVA '.$Moneda,1,0,'C');
    $pdf->SetXY(177,$ln);
    if($Moneda == 'UF'){
        $pdf->Cell(23,6,number_format($tIva, 2, '.', ','),1,0,'R');
    }else{
        $pdf->Cell(23,6,number_format($tIva, 0, '.', ','),1,0,'R');
    }

    $ln += 6;
    $pdf->SetXY(155,$ln);
    $pdf->Cell(22,6,'TOTAL '.$Moneda,1,0,'C');
    $pdf->SetXY(177,$ln);
    if($Moneda == 'UF'){
        $pdf->Cell(23,6,number_format($tBru, 2, '.', ','),1,0,'R');
    }else{
        $pdf->Cell(23,6,number_format($tBru, 0, '.', ','),1,0,'R');
    }
    $pdf->SetFont('Arial','',10);

    $ln = $pdf->GetY();
    $Observacion = utf8_decode($rowCAM['Observacion']);
    if($Observacion){
        $lnTxt = 'Observaciónes Generales: ';
                
        $pdf->SetFont('Arial','BU',8);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(190,4,utf8_decode($lnTxt),0,'L');
    
        $ln = $pdf->GetY() + 2;
        $lnTxt = '* '.utf8_decode($rowCAM['Observacion']);
        $pdf->SetFont('Arial','',8);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(190,4,$lnTxt,0,'J');
    }

    $ultPos = $pdf->GetY();
    $iNota = 0;
    $bdNotas=$link->query("SELECT * FROM cotizaNotas Order By nNota");
    while($rowNotas=mysqli_fetch_array($bdNotas)){
        if($rowNotas['Nota']){
            $iNota++;
            $ultPos = $pdf->GetY();
            $ln = $ultPos + 4;

            if($iNota == 1){
                $lnTxt = 'NOTA: ';
                            
                $pdf->SetFont('Arial','BU',8);
                $pdf->SetXY(10,$ln);
                $pdf->MultiCell(190,4,$lnTxt,0,'L');
                $ln += 4;
    
            }
                    
            $lnTxt = '* '.utf8_decode($rowNotas['Nota']);
            $pdf->SetFont('Arial','',8);
            $pdf->SetXY(10,$ln);
            $pdf->MultiCell(190,2.5,$lnTxt,0,'J');
        }
    }

    $ln = $pdf->GetY() + 2;
    //$ln = 193;
    $lnTxt = 'Tiempo Estimado: ';
            
    $pdf->SetFont('Arial','BU',8);
    $pdf->SetXY(10,$ln);
    $pdf->MultiCell(190,4,$lnTxt,0,'L');
        
    $ln = $pdf->GetY() + 2;
    $lnTxt = '* '.$rowCAM['dHabiles'].' días hábiles una vez recibida las muestras y la orden de compra, sujeto a confirmación ';
    $lnTxt .= 'por carga de trabajo.';
    $pdf->SetFont('Arial','',8);
    $pdf->SetXY(10,$ln);
    $pdf->MultiCell(190,4,utf8_decode($lnTxt),0,'L');

    $ln = $pdf->GetY() + 2;
    $lnTxt = '* La entrega de resultados y/o informes queda sujeta a regularización de pago.';
    $pdf->SetFont('Arial','',8);
    $pdf->SetXY(10,$ln);
    $pdf->MultiCell(190,4,utf8_decode($lnTxt),0,'L');

    $bdLab=$link->query("SELECT * FROM Laboratorio");
    if($rowLab=mysqli_fetch_array($bdLab)){
        $entregaMuestras    = $rowLab['entregaMuestras'];
        $nombreLaboratorio  = $rowLab['nombreLaboratorio'];
    }

    $bdDep=$link->query("SELECT * FROM Departamentos");
    if($rowDep=mysqli_fetch_array($bdDep)){
        $nombreDepto    = utf8_decode($rowDep['nombreDepto']);
    }
        $pdf->AddPage();
        $ln = 30;

        $lnTxt = 'Envío de muestras y horario:';
        $pdf->SetFont('Arial','BU',8);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(190,4,utf8_decode($lnTxt),0,'L');

        $bdLab=$link->query("SELECT * FROM Laboratorio");
        if($rowLab=mysqli_fetch_array($bdLab)){
            $entregaMuestras    = $rowLab['entregaMuestras'];
            $nombreLaboratorio  = $rowLab['nombreLaboratorio'];
        }

        $bdDep=$link->query("SELECT * FROM Departamentos");
        if($rowDep=mysqli_fetch_array($bdDep)){
            $nombreDepto    = utf8_decode($rowDep['nombreDepto']);
        }

        $ln = $pdf->GetY() + 2;
        $lnTxt = '* '.utf8_decode($entregaMuestras).' '.utf8_decode($rowDep['nombreDepto']).', '. utf8_decode($rowDep['nomSector']).', '. utf8_decode($nombreLaboratorio).'.';
        $pdf->SetFont('Arial','',8);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(190,4,$lnTxt,0,'L');

        $ln = $pdf->GetY() + 2;
        $lnTxt = '* Horario de recepción:';
        $pdf->SetFont('Arial','',8);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(190,4,utf8_decode($lnTxt),0,'L');

        $ln = $pdf->GetY() + 2;
        $lnTxt = '                        Lunes a Jueves 9:00 a 17:00 hrs';
        $pdf->SetFont('Arial','',8);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(175,4,$lnTxt,0,'L');

        $ln = $pdf->GetY() + 2;
        $lnTxt = '                        Viernes        9:00 a 13:00 hrs';
        $pdf->SetFont('Arial','',8);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(175,4,$lnTxt,0,'L');

        $ln = $pdf->GetY() + 2;
        $lnTxt = 'Tiempo de validez: ';
        $pdf->SetFont('Arial','BU',9);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(190,4,utf8_decode($lnTxt),0,'L');
        
        $ln += 5;
        $lnTxt = '* La oferta económica tiene un tiempo de validez de '.$rowCAM['Validez'].' días.';
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(190,4,utf8_decode($lnTxt),0,'J');

        $ln += 5;
        $lnTxt = 'Forma de Pago: ';
        $pdf->SetFont('Arial','BU',9);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(155,4,$lnTxt,0,'L');
        
        $ln += 5;
        $lnTxt = '* Tipo de moneda, en pesos, según valor de la UF correspondiente al día de emisión de la Orden de Compra o Factura';
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(190,4,utf8_decode($lnTxt),0,'J');

        $ln += 8;
        $lnTxt = '* La forma de pago será ';
        $lnTxt .= 'contra factura:';
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(190,4,utf8_decode($lnTxt),0,'J');

        $ln += 5;
        $lnTxt = '* Pago en efectivo o cheque en '.utf8_decode($rowIns['Direccion']).', '.utf8_decode($rowIns['Comuna']).'.';
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(18,$ln);
        $pdf->MultiCell(190,4,$lnTxt,0,'J');

        $ln += 5;
        $lnTxt  = '* Pago mediante depósito o transferencia a nombre de '.$rowIns['razonSocial'].', '.$rowIns['Banco'].' cuenta corriente '.$rowIns['CtaCte'].' Rut: '.$rowIns['RutEmp'];
        $lnTxt .= '. Enviar confirmación a '.$rowDep['EmailDepto'].'.';
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(18,$ln);
        $pdf->MultiCell(185,5,utf8_decode($lnTxt),0,'J');

        $ln += 11;
        $lnTxt = '* Clientes nuevos, sólo pago anticipado.';
        $pdf->SetFont('Arial','B',9);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(185,4,utf8_decode($lnTxt),0,'J');

        $ln += 7;
        $lnTxt = 'Observaciones: ';
        $pdf->SetFont('Arial','BU',9);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(185,4,$lnTxt,0,'L');
        
        
        $ln += 5;
        $lnTxt = '* Después de 10 días de corridos de la emisión de este informe se entenderá como ';
        $lnTxt .= 'aceptado en su versión final, cualquier modificación posterior tendrá un recargo ';
        $lnTxt .= 'adicional de 1 UF + IVA.';
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(185,4,utf8_decode($lnTxt),0,'J');
        
        $ln += 8;
        $lnTxt = '* Se solicita indicar claramente la identificación de la muestra al momento de la recepción, para no rehacer informes. ';
        $lnTxt .= 'Cada informe rehecho por razones ajenas a SIMET-USACH tiene un costo de 1,00 UF + IVA.';
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(185,4,utf8_decode($lnTxt),0,'J');

        $ln += 8;
        $lnTxt = '* Visitas a terreno en Santiago, explicativas de informes de análisis de falla o de retiro de muestras en terreno';
        $lnTxt .= ', tienen un costo adicional de 6,0 UF + IVA, visitas fuera de la región metropolitana consultar.';
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(185,4,utf8_decode($lnTxt),0,'J');

        $ln += 8;
        $lnTxt = '* Al aceptar el servicio, el laboratorio SIMET-USACH mantendrá toda la información generada durante el servicio de manera confidencial, a menos que sea requerida por alguna autoridad legal o reglamentaria.';
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(185,4,utf8_decode($lnTxt),0,'J');

        $ln += 9;
        $lnTxt = '* En caso de realizar análisis de falla, el laboratorio se reserva el derecho de modificar el tipo y/o cantidad de ensayos.';
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(185,4,utf8_decode($lnTxt),0,'J');

        $ln += 9;
        $lnTxt = 'FAVOR EMITIR ORDEN DE COMPRA A NOMBRE DE:';
        $pdf->SetFont('Arial','B',9);
        $pdf->SetFillColor(197,190,151);
        $pdf->SetXY(10,$ln);
        $pdf->Cell(190,41,'',1,0,'L');
        $ln += 1;
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(185,4,$lnTxt,0,'J');
        $pdf->SetFillColor(0,0,0);

        $ln += 5;
        $lnTxt = strtoupper($rowIns['NombreEmp']);
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(185,4,utf8_decode($lnTxt),0,'J');

        $ln += 5;
        $lnTxt = 'GIRO: - Ventas al por menor de libros en comercio especializado.';
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(185,4,utf8_decode($lnTxt),0,'J');

        $ln += 5;
        $lnTxt = '- Servicio de publicidad prestados por empresa';
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(20,$ln);
        $pdf->MultiCell(185,4,utf8_decode($lnTxt),0,'J');

        $ln += 5;
        $lnTxt = 'RUT: '.$rowIns['RutEmp'];
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(185,4,$lnTxt,0,'J');

        $ln += 5;
        $lnTxt = 'DIRECCIÓN: '.($rowIns['Direccion'].', '.$rowIns['Comuna']);
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(185,4,utf8_decode($lnTxt),0,'J');

        $ln += 5;
        $lnTxt = 'NOMBRE: '.$rowLab['contactoLaboratorio'];
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(185,4,utf8_decode($lnTxt),0,'J');

        $ln += 5;
        $lnTxt = 'FONO: '.$rowIns['Fax'].' // Mail: '.$rowDep['EmailDepto'];
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(155,4,$lnTxt,0,'J');

        $ln += 7;
        $lnTxt = 'En caso de dudas favor comunicarse con: ';
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(155,4,$lnTxt,0,'J');



        $bdUsr=$link->query("SELECT * FROM Usuarios Where usr Like '%".$rowCAM['usrCotizador']."%'");
        if($rowUsr=mysqli_fetch_array($bdUsr)){
            $nomCotizador   = $rowUsr['usuario'];
        }

        $ln += 5;
        $lnTxt = '* Ingeniero '.utf8_decode($rowUsr['usuario']).'; mail: '.$rowUsr['email'].';';
        $pdf->SetFont('Arial','B',9);
        $pdf->SetXY(20,$ln);
        $pdf->MultiCell(145,4,$lnTxt,0,'J');

        if('simet.avr@usach.cl' != $rowUsr['email']){
            $ln += 5;
            $lnTxt = '* Ingeniero Alejandro Valdes R.; mail: simet.avr@usach.cl;';
            $pdf->SetFont('Arial','B',9);
            $pdf->SetXY(20,$ln);
            $pdf->MultiCell(145,4,utf8_decode($lnTxt),0,'J');
        }

        if('simet.aca@usach.cl' != $rowUsr['email']){
            $ln += 5;
            $lnTxt = '* Ingeniero Alejandro Castillo A.; mail: simet.aca@usach.cl;';
            $pdf->SetFont('Arial','B',9);
            $pdf->SetXY(20,$ln);
            $pdf->MultiCell(145,4,utf8_decode($lnTxt),0,'J');
        }

        $ln += 5;
        $lnTxt = '* Teléfonos +56 2 2323 47 80 o +56 2 2718 32 21.';
        $pdf->SetFont('Arial','B',9);
        $pdf->SetXY(20,$ln);
        $pdf->MultiCell(145,4,utf8_decode($lnTxt),0,'J');

        $ln += 7;
        $lnTxt = 'Quedamos a la espera de su confirmación, saluda cordialmente.';
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(20,$ln);
        $pdf->MultiCell(145,4,utf8_decode($lnTxt),0,'J');

        if($rowUsr['firmaUsr']){
            if (file_exists($rowUsr['firmaUsr'])) {
                $pdf->Image('../../ft/'.$rowUsr['firmaUsr'],130,205);
            }
        }
        
        $ln = 228;
        $lnTxt = $nomCotizador;
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(130,$ln);
        $pdf->MultiCell(50,4,utf8_decode($lnTxt),0,'C');

        $ln += 4;
        $lnTxt = 'Laboratorio '.$rowLab['idLaboratorio'];
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(130,$ln);
        $pdf->MultiCell(50,4,utf8_decode($lnTxt),0,'C');


        // Pie de Pagina
        $bdIns=$link->query("SELECT * FROM Empresa");
        if($rowIns=mysqli_fetch_array($bdIns)){
            $nombreFantasia     = $rowIns['nombreFantasia'];
        }
        $pdf->SetTextColor(128, 128, 128);



}
/* CUADRO ID CLIENTE - FIN */
    $fechaHoy           = date('Y-m-d');
    $proxRecordatorio   = strtotime ( '+10 day' , strtotime ( $rowCAM['fechaCotizacion'] ) );
    //$proxRecordatorio     = strtotime ( '+10 day' , strtotime ( $fechaHoy ) );
    $proxRecordatorio   = date ( 'Y-m-d' , $proxRecordatorio );


    if($accion == 'Reimprime'){
    }else{
        $enviadoCorreo  = 'on';
        $actSQL="UPDATE Cotizaciones SET ";
        $actSQL.="Estado            ='".$Estado.            "',";
        $actSQL.="enviadoCorreo     ='".$enviadoCorreo.     "',";
        $actSQL.="proxRecordatorio  ='".$proxRecordatorio.  "',";
        $actSQL.="fechaEnvio        ='".$fechaHoy.          "'";
        //$actSQL.="WHERE CAM         = '".$CAM."'and Rev = '".$Rev."' and Cta = '".$Cta."'";
        $actSQL.="WHERE CAM         = '".$CAM."'";
        $bdCot=$link->query($actSQL);
    }


    $Rev = $rowCAM['Rev'];

$link->close();

$NombreFormulario = "CAM-".$CAM." Rev-0".$Rev.".pdf";
//$pdf->Output($NombreFormulario,'D'); //Para Descarga
//$pdf->Output($NombreFormulario,'I'); //Muestra en el Navegador
//$pdf->Output($NombreFormulario,'F'); //Guarda en un Fichero
$pdf->Output($NombreFormulario,'D'); //Para Descarga
//copy($NombreFormulario, 'Y://AAA/Archivador-2020/CAMs/'.$NombreFormulario);
//unlink($NombreFormulario);
//$pdf->Output();
?>
