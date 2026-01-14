<?php
	require_once('../../fpdf/fpdf.php');
	include_once("../../conexion.php");

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

	$link=Conectarse();
	
	$pdf=new FPDF('P','mm','Letter');

	// Encabezado 
	$pdf->AddPage();
	$pdf->SetXY(10,5);
	$pdf->Image('../../imagenes/logoSimetCam.png',10,5,43,16);

	$pdf->SetXY(110,12);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(10,5,'FECHA:',0,0);
	
	$fechaHoy = date('Y-m-d');
	$fd 	= explode('-', $fechaHoy);
	$pdf->SetXY(130,12);
	$pdf->Cell(50,5,$fd[2].' de '.$Mes[$fd[1]-1].' de '.$fd[0],0,0);

	$pdf->SetXY(50,17);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(10,5,'Acreditado NCh-ISO 17.025.',0,0);

	// Line(Col, FilaDesde, ColHasta, FilaHasta) 
	$pdf->Line(10, 23, 184, 23);

	$pdf->SetXY(10,17);
	$pdf->Image('../../gastos/logos/logousach.png',195,5,15,23);

	$pdf->SetFont('Arial','I',14);
	$pdf->SetXY(10,25);
	$pdf->Cell(170,5,'COTIZACIONES PREMIUM',0,0,'C');
	$pdf->Line(10, 30, 184, 30);
	$pdf->Line(10, 30.7, 184, 30.7);
		
	$pdf->SetDrawColor(200, 200, 200);
	$pdf->Line(190, 30, 190, 270);
	$pdf->SetDrawColor(0, 0, 0);
	$pdf->Image('../../imagenes/logoSimetCam.png',185,245,20,8);

	$ln 	= 31;
	$lnTxt 	= '';
	
	$pdf->SetFont('Arial','',9);
	$pdf->SetXY(10,$ln);
	$pdf->MultiCell(175,4,$lnTxt,0,'J');

	$ln += 2;
	$pdf->SetFont('Arial','B',8);
			
	$pdf->SetXY(10,$ln);
	$pdf->MultiCell(20,8,'CAM',1,'C');
			
	$pdf->SetXY(30,$ln);
	$pdf->MultiCell(115,8,'CLIENTE',1,'C');

	$pdf->SetXY(145,$ln);
	$pdf->MultiCell(20,8,'',1,'C');
	
	$pdf->SetXY(145,$ln);
	$pdf->Cell(20,4,'Valor',0,0,'C');
	$pdf->SetXY(145,$ln+4);

	$pdf->Cell(20,4,'Bruto UF',0,0,'C');

	$pdf->SetXY(165,$ln);
	$pdf->MultiCell(20,8,'',1,'C');
	
	$pdf->SetXY(165,$ln);
	$pdf->Cell(20,8,'Seguimiento',0,0,'C');
	
	
	// Fin Encabezado
	
	/* Cuerpo */

	$bdTi=mysql_query("SELECT * FROM tablaIndicadores Where agnoInd = '".$fd[0]."' and mesInd = '".$fd[1]."'");
	if($rowTi=mysql_fetch_array($bdTi)){
		$rCot = $rowTi['rCot'];
	}

	$ln += 4;
	$bdCAM=mysql_query("SELECT * FROM Cotizaciones Where Estado = 'E' and BrutoUF >= $rCot Order By fechaCotizacion Desc");
	if($rowCAM=mysql_fetch_array($bdCAM)){
		do{
			$ln += 4;
			$pdf->SetFont('Arial','',8);
			$fd = explode('-',$rowCAM['fechaCotizacion']);
			$pdf->SetXY(10,$ln);
			$pdf->MultiCell(20,4,$rowCAM['CAM'].' / '.$fd[2].'-'.$fd[1],1,'C');

			$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowCAM['RutCli']."'");
			if($rowCli=mysql_fetch_array($bdCli)){
				$pdf->SetXY(30,$ln);
				$pdf->MultiCell(115,4,$rowCli['Cliente'],1,'L');
			}

			$pdf->SetXY(145,$ln);
			$pdf->MultiCell(20,4,number_format($rowCAM['BrutoUF'], 2, '.', ','),1,'R');

			$pdf->SetXY(165,$ln);
			$pdf->MultiCell(20,4,$rowCAM['usrCotizador'],1,'C');
			if($rowCAM['contactoRecordatorio']){
				$ln += 4;
				
				$pdf->SetFont('Arial','B',8);
				$cR = 255; $cG =   0; $cB =   0; // Rojo
				$pdf->SetTextColor($cR, $cG, $cB);
				$lnn = $ln;
				$nr	 = 0;
						$bdCs=mysql_query("SELECT * FROM CotizacionesSegimiento Where CAM = '".$rowCAM['CAM']."' Order By fechaContacto" );
						if($rowCs=mysql_fetch_array($bdCs)){
							do{
								$nr++;
								$fd = explode('-', $rowCs['fechaContacto']);
								$contactoRecordatorio = $fd[2].'/'.$fd[1].'/'.$fd[0].' - '.$rowCs['contactoRecordatorio'];
								$pdf->SetXY(10,$lnn);
								$pdf->MultiCell(175,4,$contactoRecordatorio,0,'L');
							}while ($rowCs=mysql_fetch_array($bdCs));
						}
				
				$pdf->SetXY(10,$ln);
				$pdf->MultiCell(175,12,'',1,'L');
				$ln += 8;
				$pdf->SetTextColor(0,0,0);
			}
			
		}while ($rowCAM=mysql_fetch_array($bdCAM));
	}

	/* Fin Cuerpo */

	//$pdf->Output('F3B-00001.pdf','I'); //Para Descarga
	$NombreFormulario = "CAMPremium.pdf";
	$pdf->Output($NombreFormulario,'D'); //Para Descarga
	//$pdf->Output('F3B-00001.pdf','F');

?>
