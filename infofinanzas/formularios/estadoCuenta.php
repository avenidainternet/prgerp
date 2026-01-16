<?php
	require('../../fpdf/fpdf.php');
	include_once("../conexion.php");
	$ln = 100;
	$RutCli = $_GET['RutCli'];

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
	$fechaHoy = date('Y-m-d');
	$link=Conectarse();

	$pdf=new FPDF('P','mm','A4');
	$pdf->AddPage();
		

	$pdf->Image('../../imagenes/simet.png',10,10,30,20);
	$pdf->Image('../../gastos/logos/logousach.png',170,10,15,23);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(40);

	$pdf->Cell(100,10,'UNIVERSIDAD DE SANTIAGO DE CHILE',0,2,'C');
	$pdf->Cell(100,1,'LABORATORIO SIMET-USACH',0,2,'C');

	$pdf->SetXY(10,30);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(200,5,'ESTADO DE CUENTA',0,0,'C');
	
	$fd 	= explode('-', $fechaHoy);
	$pdf->SetXY(10,40);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(70,5,'FECHA: Santiago, '.$fd[2].' de '.$Mes[$fd[1]-1].' de '.$fd[0],0,0);

	$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$RutCli."'");
	if($rowCli=mysql_fetch_array($bdCli)){
		$pdf->SetXY(10,45);
		$pdf->Cell(40,5,'EMPRESA: ',0,0);
		$pdf->Cell(115,5,strtoupper($rowCli['Cliente']),0,0);

		$pdf->SetXY(10,50);
		$pdf->Cell(40,5,'GIRO:',0,0);
		$pdf->Cell(115,5,$rowCli['Giro'],0,0);

		$pdf->SetXY(10,55);
		$pdf->Cell(40,5,'RUT:',0,0);
		$pdf->Cell(115,5,strtoupper($rowCli['RutCli']),0,0);

		$pdf->SetXY(10,60);
		$pdf->Cell(40,5,'DIRECCIÓN / COMUNA:',0,0);
		$pdf->Cell(115,5,strtoupper($rowCli['Direccion']),0,0);

		$pdf->SetXY(10,65);
		$pdf->Cell(40,5,'FONO:',0,0);
		$pdf->Cell(115,5,$rowCli['Telefono'],0,0);

	}		

	$pdf->SetFont('Arial','B',7);
	$pdf->SetXY(10,70);
	$pdf->Cell(15,5,'Factura',1,0,'C');
	$pdf->Cell(14,5,'Fecha',1,0,'C');
	$pdf->Cell(40,5,'Contacto',1,0,'C');
	$pdf->Cell(37,5,'Cotización',1,0,'C');
	$pdf->Cell(38,5,'Informes',1,0,'C');
	$pdf->Cell(10,5,'Días',1,0,'C');
	$pdf->Cell(16,5,'Estado',1,0,'C');
	$pdf->Cell(15,5,'Monto',1,0,'C');
	$ln = 70;
	$pdf->SetFont('Arial','',7);
	$tBruto 	= 0;
	$tCobranza 	= 0;
	$tVigente	= 0;
	$bdSol=mysql_query("SELECT * FROM SolFactura WHERE RutCli = '".$RutCli."' and nFactura > 0 and pagoFactura != 'on' Order By fechaFactura");
	if($rowSol=mysql_fetch_array($bdSol)){
		do{
			$ln += 5;
			$pdf->SetXY(10,$ln);
			$pdf->Cell(15,5,$rowSol['nFactura'],1,0,'C');
			$fd 	= explode('-', $rowSol['fechaFactura']);
			$pdf->Cell(14,5,$fd[2].'-'.$fd[1].'-'.$fd[0],1,0,'C');
			$bdCon=mysql_query("SELECT * FROM contactosCli Where RutCli = '".$rowSol['RutCli']."' and Contacto Like '%".$rowSol['Contacto']."%'");
			if($rowCon=mysql_fetch_array($bdCon)){
				$Contacto 		= $rowCon['Contacto'];
				$Departamento 	= $rowCon['Depto'];
				$Correo 		= $rowCon['Email'];
				$Fono 			= $rowCon['Telefono'];
			}
			$pdf->Cell(40,5,utf8_decode($Contacto),1,0,'C');
			$pdf->Cell(37,5,$rowSol['cotizacionesCAM'],1,0,'R');
			$pdf->Cell(38,5,$rowSol['informesAM'],1,0,'R');
			$fechaCobro = strtotime ( '+30 day' , strtotime ( $rowSol['fechaFactura'] ) );
			$fechaCobro = date ( 'Y-m-d' , $fechaCobro );

			$start_ts 	= strtotime($fechaHoy); 
			$end_ts 	= strtotime($fechaCobro); 
			$start_ts 	= strtotime($fechaCobro); 
			$end_ts 	= strtotime($fechaHoy); 
			$nDias = $end_ts - $start_ts;
			$nDias = round($nDias / 86400)+1;
			if($nDias > 0){
				$pdf->Cell(10,5,$nDias,1,0,'C');
			}else{
				$pdf->Cell(10,5,'',1,0,'C');
			}
			$Estado = '';
			if($fechaCobro <= $fechaHoy){
				$Estado = 'Vencido';
				$tCobranza += $rowSol['Bruto'];
			}else{
				$Estado = 'Vigente';
				$tVigente += $rowSol['Bruto'];
			}
			$pdf->Cell(16,5,$Estado,1,0,'C');
			$pdf->Cell(15,5,number_format($rowSol['Bruto'], 0, ',', '.'),1,0,'C');
			$tBruto += $rowSol['Bruto'];
		}while ($rowSol=mysql_fetch_array($bdSol));
	}
		
		$ln += 5;
		$pdf->SetXY(154,$ln);
		$pdf->MultiCell(26,5,'VENCIDO',1,'C');
		$pdf->SetXY(180,$ln);
		$pdf->Cell(15,5,'$ '.number_format($tCobranza, 0, ',', '.'),1,'C');

		$ln += 5;
		$pdf->SetXY(154,$ln);
		$pdf->MultiCell(26,5,'VIGENTE',1,'C');
		$pdf->SetXY(180,$ln);
		$pdf->Cell(15,5,'$ '.number_format($tVigente, 0, ',', '.'),1,'C');

		$ln += 5;
		$pdf->SetXY(154,$ln);
		$pdf->MultiCell(26,5,'TOTAL',1,'C');
		$pdf->SetXY(180,$ln);
		$pdf->Cell(15,5,'$ '.number_format($tBruto, 0, ',', '.'),1,'C');


//		$txt  = "Nota: La dirección de SDT USACH es Av. Libertador Bernado O'Higgins N° 1611, sin embargo, para dar inicio a la tramitación de este ";
//		$txt .= "Formulario, lo debe entregar en la dirección Av. Bernardo O'Higgins N° 2229, Oficina de Ingreso de Requerimientos.";
//		$ln = $pdf->GetY() + 5;
//		$pdf->SetFont('Arial','',6);
//		$pdf->SetXY(10,$ln);
//		$pdf->MultiCell(185,5,$txt,0,'L');
		

	mysql_close($link);


	//$pdf->Output('F3B-00001.pdf','I'); //Para Descarga
	$NombreFormulario = "estadoCuenta-".$RutCli.".pdf";
	$pdf->Output($NombreFormulario,'D'); //Para Descarga
	//$pdf->Output('F3B-00001.pdf','F');

?>
