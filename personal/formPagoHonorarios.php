<?php
include('../conexionli.php');
require('../fpdf/fpdf.php');
/* Variables */
    $Proyecto   = '';
    $Run        = '';
    $nBoleta    = '';
    $Periodo    = '';

	if(isset($_GET['Run']))     { $Run      = $_GET['Run'];     }
	if(isset($_GET['nBoleta'])) { $nBoleta  = $_GET['nBoleta']; }
	if(isset($_GET['Periodo'])) { $Periodo  = $_GET['Periodo']; }
	$Mes = array(
					1 => 'Enero', 
					2 => 'Febrero',
					3 => 'Marzo',
					4 => 'Abril',
					5 => 'Mayo',
					6 => 'Junio',
					7 => 'Julio',
					8 => 'Agosto',
					9 => 'Septiembre',
					10 => 'Octubre',
					11 => 'Noviembre',
					12 => 'Diciembre'
				);

	$pdf=new FPDF('P','mm','Legal');

/********************** Imprime Solicitudes     *****************************/

	$link=Conectarse();
	$bd=$link->query("SELECT * FROM honorarios Where Run = '$Run' and nBoleta = '$nBoleta'");
	if ($rs=mysqli_fetch_array($bd)){
		$Proyecto = $rs['IdProyecto'];
	}
	$bdDep=$link->query("SELECT * FROM Departamentos");
	if ($rowDep=mysqli_fetch_array($bdDep)){
		$NomDirector = $rowDep['NomDirector'];
	}
	$bd=$link->query("SELECT * FROM Proyectos Where IdProyecto = '".$Proyecto."'");
	if ($row=mysqli_fetch_array($bd)){
		$NomProyecto 		= $row['Proyecto'];
		$JefeProyecto 		= $row['JefeProyecto'];
		$Rut_JefeProyecto 	= $row['Rut_JefeProyecto'];
		$firmaJefe 			= $row['firmaJefe'];
	}
	$link->close();

	$pdf->AddPage();
    $pdf->Image('../logossdt/formulariosolicitudes2022.png',10,10);
    $ln = 35;

    $pdf->SetFillColor(234, 80, 55);
	// $pdf->SetDrawColor(234, 80, 55);
	$pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('Arial','B',12);
    $pdf->SetXY(10,$ln);
	$pdf->Cell(180,10,utf8_decode('FORMULARIO DE SOLICITUD DE PAGO DE HONORARIOS'),1,0,'C', true);
	$pdf->SetTextColor(0, 0, 0);

	$pdf->Ln(13);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(70,5,'FECHA DE EMISIÓN DEL FORMULARIO:',0,0);
	//$pdf->Cell(2,5,':',0,0);
	$pdf->Cell(110,5,date('d').'/'.date('m').'/'.date('Y'),0,0);

	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(70,10,'COMPLETE LOS SIGUIENTES CAMPOS:',0,0);
	$pdf->SetFont('Arial','',7);

	$pdf->Ln(10);
	$pdf->Cell(70,10,'NOMBRE DEL PROYECTO:',0,0);
	$pdf->Cell(110,10,$NomProyecto,1,0);
	$pdf->Ln(12);
	$pdf->Cell(70,10,utf8_decode('CÓDIGO DEL PROYECTO:'),0,0);
	$pdf->Cell(110,10,$Proyecto,1,0);

	$pdf->SetFont('Arial','B',7);
	$pdf->Ln(10);
	$pdf->Cell(196,10,'DETALLE DE HONORARIOS',0,0,'C');

	$pdf->SetFont('Arial','',7);

    $pdf->SetFillColor(238, 238, 238);
    $ln = $pdf->GetY()+12;
    $pdf->SetXY(10,$ln);
    $pdf->MultiCell(55,15,'NOMBRE', 1, "C", true);
    $pdf->SetXY(65,$ln);
    $pdf->MultiCell(20,15,utf8_decode('RUT'), 1, "C", true);
    $pdf->SetXY(85,$ln);
    $pdf->MultiCell(25,5,utf8_decode('FUNCIÓN ACADÉMICA (INDICAR SI/NO)'), 1, "C", true);
    $pdf->SetXY(110,$ln);
    $pdf->MultiCell(50,15,utf8_decode('N° BOLETA'), 1, "C", true);
    $pdf->SetXY(160,$ln);
    $pdf->MultiCell(30,15,'MONTO', 1, "C", true);
	$pdf->SetFillColor(234, 80, 55);

	$sTotal = 0;
		
	$link=Conectarse();
	$bdH=$link->query("SELECT * FROM Honorarios WHERE IdProyecto = '".$Proyecto."' && PeriodoPago = '".$Periodo."' && Run = '".$Run."' && nBoleta = '".$nBoleta."'");
	if ($rowH=mysqli_fetch_array($bdH)){
		$Run	 		= $rowH['Run'];
		$nBoleta 		= $rowH['nBoleta'];
		$Descripcion 	= $rowH['Descripcion'];
		$PerIniServ 	= $rowH['PerIniServ'];
		$PerTerServ 	= $rowH['PerTerServ'];
		$Total 			= $rowH['Total'];
		$sTotal			+= $Total;

		$bdP=$link->query("SELECT * FROM PersonalHonorarios WHERE Run = '".$Run."'");
		if ($rowP=mysqli_fetch_array($bdP)){
			$Nombre 		= $rowP['Nombres'].' '.$rowP['Paterno'].' '.$rowP['Materno'];
			$Email 			= $rowP['Email'];
			$Banco 			= $rowP['Banco'];
			$nCuenta 		= $rowP['nCuenta'];
			$ServicioIntExt	= $rowP['ServicioIntExt'];
		}

		$bdSup=$link->query("SELECT * FROM supervisor");
		if ($rowSup=mysqli_fetch_array($bdSup)){
			$rutSuper 		= $rowSup['rutSuper'];
			$nombreSuper 	= $rowSup['nombreSuper'];
			$cargoSuper 	= $rowSup['cargoSuper'];
			$firmaSuper 	= $rowSup['firmaSuper'];
		}
		
		$pdf->SetFont('Arial','',6);
		$pdf->Cell(55,5, utf8_decode($Nombre),1,0);
		$pdf->Cell(20,5,$Run,1,0,'C');
		$pdf->Cell(25,5,'NO',1,0,'C');
		$pdf->Cell(50,5,$nBoleta,1,0,'C');
		// $pdf->Cell(40,5,$Email,1,0);
		// $pdf->Cell(22,5,$Banco,1,0);
		// $pdf->Cell(20,5,$nCuenta,1,0,'C');
		$pdf->Cell(30,5,'$ '.number_format($Total, 0, ',', '.'),1,0,'R');

	}
	
	$pdf->Ln(5);
	$pdf->Cell(55,5,'',0,0);
	$pdf->Cell(20,5,'',0,0);
	$pdf->Cell(25,5,'',0,0);
	$pdf->Cell(50,5,'TOTAL',0,0,'R');
	$pdf->Cell(30,5,'$ '.number_format($sTotal, 0, ',', '.'),1,0,'R');


    $pdf->SetFillColor(238, 238, 238);
    $ln = $pdf->GetY()+12;
    $pdf->SetXY(10,$ln);
    $pdf->SetFont('Arial','B',7);
    $pdf->MultiCell(180,5,'DATOS BANCARIOS DEL PRESTADOR', 1, "L", true);
	$pdf->SetFont('Arial','',7);

    $ln = $pdf->GetY();
    $pdf->SetXY(10,$ln);
	$pdf->Cell(70,5, utf8_decode('NÚMERO DE CUENTA'),1,0);
	$pdf->Cell(110,5,$nCuenta,1,0);

	$pdf->Ln(5);
	$pdf->Cell(70,5,utf8_decode('ENTIDAD BANCARIA'),1,0);
	$pdf->Cell(110,5,$Banco,1,0);

	$pdf->Ln(5);
	$pdf->Cell(70,5,utf8_decode('CORREO ELECTRÓNICO'),1,0);
	$pdf->Cell(110,5,$Email,1,0);

    $link->close();

	$pdf->SetFillColor(234, 80, 55);




	$ln = $pdf->GetY()+10;
	$pdf->SetXY(10,$ln);
	$pdf->SetFont('Arial','',10);
	$LinTxt  = "NOTA: INDICAR SI EL PRESTADOR NO CUENTA CON BOLETA ELECTRÓNICA DE HONORARIOS, Y LOS MOTIVOS PERTINENTES.-";
	$pdf->MultiCell(185,5,utf8_decode($LinTxt),0,'J');

	//$firmaJefe = 'aaa.png';
	$pdf->Image('../ft/'.$firmaJefe,30,260,40,40);
	$pdf->Image('../ft/'.$firmaSuper,130,260,40,40);
	//$pdf->Image('../ft/TimbreDirector.png',120,280,20,20);

	$pdf->SetXY(10,290);

	/*
	if($Rut_JefeProyecto != '11845057-4'){
		$pdf->Cell(40,5,'pp',0,0,"C");
	}
	*/

	$pdf->SetFont('Arial','B',10);
	// Line(Col, FilaDesde, ColHasta, FilaHasta) 
	$pdf->Line(20, 300, 90, 300);
	$pdf->SetXY(20,300);
	//Cell(LargoMarco ,AltoMarco, Txt, VerMarco, ,Centro)
	$pdf->Cell(70,5, utf8_decode($JefeProyecto),0,0,"C");
	$pdf->SetXY(20,305);
	$pdf->Cell(70,5,"Jefe de Proyecto",0,0,"C");

	$pdf->Line(120, 300, 190, 300);
	$pdf->SetXY(120,300);
	$pdf->Cell(70,5, utf8_decode($nombreSuper),0,0,"C");
	$pdf->SetXY(120,305);
	$pdf->Cell(70,5,$cargoSuper,0,0,"C");

	/********************** Fin Imprime Solicitudes *****************************/

	/********************** 	Imprime Prestadores *****************************/

	$link=Conectarse();
	$bdDep=$link->query("SELECT * FROM Departamentos");
	if ($rowDep=mysqli_fetch_array($bdDep)){
		$NomDirector 			= $rowDep['NomDirector'];
		$SubDirectorProyectos 	= $rowDep['SubDirectorProyectos'];
	}
	$bd=$link->query("SELECT * FROM Proyectos Where IdProyecto = '".$Proyecto."'");
	if ($row=mysqli_fetch_array($bd)){
		$NomProyecto 		= $row['Proyecto'];
		$JefeProyecto 		= $row['JefeProyecto'];
		$Rut_JefeProyecto 	= $row['Rut_JefeProyecto'];
	}
	$link->close();

	$sTotal 		= 0;
	$RunControl 	= "";
	$ImprimeLinea 	= "No";
	$nBoletas		= 0;
	$tTotal			= 0;
	$tRetencion		= 0;
	$tLiquido		= 0;
	$nDoc			= 0;
    $nInforme       = 0;
	
	$nDoc++;
	$link=Conectarse();
	// $bdH=$link->query("SELECT * FROM Honorarios WHERE Run = '".$Run."' && nBoleta = '".$nBoleta."' && IdProyecto = '".$Proyecto."'");
	$bdH=$link->query("SELECT * FROM Honorarios WHERE Run = '".$Run."' && nBoleta = '".$nBoleta."'");
	if ($rowH=mysqli_fetch_array($bdH)){
		$Total 			= $rowH['Total'];
		$sTotal			+= $Total;
		$tTotal			+= $rowH['Total'];
		$tRetencion		+= $rowH['Retencion'];
		$tLiquido		+= $rowH['Liquido'];
        $nInforme = $rowH['nInforme']; 
	}
	$link->close();
	
    if($nInforme == 0){
        $link=Conectarse();
        $sql = "SELECT * FROM Formularios Where Formulario = 'F5'";  
        $result = $link->query($sql);
        $nInf = mysqli_num_rows($result); // obtenemos el n�mero de filas
        $nInf = $nInf +1;
        $link->close();

        $nDoc = 0;
        $link=Conectarse();
            $nDoc++;
            $actSQL="UPDATE Honorarios SET ";
            $actSQL.="FechaPago		='".date('Y-m-d')."',";
            $actSQL.="Estado		='P',";
            $actSQL.="nInforme		='".$nInf."'";
            $actSQL.="WHERE Run		='".$Run."' && nBoleta = '".$nBoleta."'";
            $bdH=$link->query($actSQL);
    
        $link->close();
        $f 			= "F5";
        $fecha 		= date('Y-m-d');
        
        $fd 	= explode('-', date('Y-m-d'));
        $Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
        
        $Concepto 	= 'Solicitud de Pagos de Honorarios '.$Fecha;
    
        $link=Conectarse();
       
        $link->query("insert into Formularios (	nInforme,
                                                Formulario,
                                                nDocumentos,
                                                Fecha,
                                                Concepto,
                                                IdProyecto,
                                                Total,
                                                Retencion,
                                                Liquido) 
                                values 		 (	'$nInf',
                                                '$f',
                                                '$nDoc',
                                                '$fecha',
                                                '$Concepto',
                                                '$Proyecto',
                                                '$tTotal',
                                                '$tRetencion',
                                                '$tLiquido'
                                                )");
    
    
        $link->close();
    }


// Pie

$pdf->SetFillColor(234, 80, 55);
// $pdf->SetDrawColor(234, 80, 55);
$pdf->SetTextColor(255, 255, 255);

$fila = 310;
$pdf->SetXY(10,$fila);
$pdf->SetDrawColor(234, 80, 55);
$pdf->MultiCell(185,25,'',1,'L', true);

$fila += 2;
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(240,240,240);
$pdf->SetXY(120,$fila);
$pdf->Cell(70,5,"Alameda Libertador",0,0,"L");

$pdf->SetFont('Arial','',8);
$pdf->SetXY(162,$fila);
$pdf->Cell(70,5, utf8_decode("Trece Oriente Nº2211"),0,0,"L");

$fila += 5;
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(240,240,240);
$pdf->SetXY(120,$fila);
$pdf->Cell(70,5, utf8_decode("Bernardo O'higgins 1611"),0,0,"L");

$pdf->SetXY(162,$fila);
$pdf->Cell(70,5, utf8_decode("Piso 1, Iquique"),0,0,"L");

$fila += 5;
$pdf->SetTextColor(240,240,240);
$pdf->SetXY(120,$fila);
$pdf->Cell(70,5, utf8_decode("Santiago"),0,0,"L");

$pdf->SetXY(162,$fila);
$pdf->Cell(70,5, utf8_decode("+57 22 488 84(85)"),0,0,"L");

$fila += 5;
$pdf->SetTextColor(240,240,240);
$pdf->SetXY(120,$fila);
$pdf->Cell(70,5, utf8_decode("+562 2718 1400"),0,0,"L");

$pdf->SetXY(162,$fila);
$pdf->Cell(70,5, utf8_decode("+569 4409 2070"),0,0,"L");

$pdf->SetDrawColor(255, 255, 255);
$pdf->Line(160, 312, 160, 333);
$pdf->SetTextColor(0, 0, 0);


	$agnoActual = date('Y');
	$vDir = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/HONORARIOS/';;


	$NombreFormulario = "Formulario-".$Run."-".$nBoleta.".pdf";

	$pdf->Output($NombreFormulario,'D'); //Para Descarga
	$pdf->Output($vDir.$NombreFormulario,'F'); //Para Descarga

?>
