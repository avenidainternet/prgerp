<?php
	require('../../fpdf/fpdf.php');
	include_once("../../conexionli.php");
	$ln = 100;
	$RutCli = $_GET['RutCli'];

	if(isset($_GET['Contacto'])) { 
		$Contacto = $_GET['Contacto']; 
	}

	$nContacto = 'All';
	$link=Conectarse();
	if($Contacto){
		$SQL = "SELECT * FROM contactoscli Where RutCli = '".$RutCli."' and Contacto like '%".$Contacto."%'";
		$bdc=$link->query($SQL);
		if ($rs=mysqli_fetch_array($bdc)){
			$nContacto = $rs['nContacto'];
		}
	}

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

	$pdf=new FPDF('P','mm','A4');
	$pdf->AddPage();
		

	$pdf->Image('../../imagenes/logonewsimet.jpg',10,10,50,20);
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

	$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$RutCli."'");
	if($rowCli=mysqli_fetch_array($bdCli)){
		$pdf->SetXY(10,45);
		$pdf->Cell(40,5,'EMPRESA: ',0,0);
		$pdf->Cell(115,5, utf8_decode(strtoupper($rowCli['Cliente'])),0,0);

		$pdf->SetXY(10,50);
		$pdf->Cell(40,5,'GIRO:',0,0);
		$pdf->Cell(115,5,utf8_decode($rowCli['Giro']),0,0);

		$pdf->SetXY(10,55);
		$pdf->Cell(40,5,'RUT:',0,0);
		$pdf->Cell(115,5,strtoupper($rowCli['RutCli']),0,0);

		$pdf->SetXY(10,60);
		$pdf->Cell(40,5, utf8_decode('DIRECCIÓN / COMUNA:'),0,0);
		$pdf->Cell(115,5, utf8_decode(strtoupper($rowCli['Direccion'])),0,0);

		$pdf->SetXY(10,65);
		$pdf->Cell(40,5,'FONO:',0,0);
		$pdf->Cell(115,5,$rowCli['Telefono'],0,0);

	}		

	$bdSol=$link->query("SELECT * FROM SolFactura WHERE RutCli = '".$RutCli."' and nFactura > 0 and pagoFactura != 'on' Order By fechaFactura");
	if($rowSol=mysqli_fetch_array($bdSol)){

		$pdf->SetFont('Arial','B',7);
		$pdf->SetXY(10,70);
		$pdf->Cell(15,5,'Factura',1,0,'C');
		$pdf->Cell(15,5,'Fecha',1,0,'C');
		$pdf->Cell(40,5,'Contacto',1,0,'C');
		$pdf->Cell(37,5, utf8_decode('Cotización'),1,0,'C');
		$pdf->Cell(38,5,'Informes',1,0,'C');
		$pdf->Cell(10,5,utf8_decode('Días'),1,0,'C');
		$pdf->Cell(16,5,'Estado',1,0,'C');
		$pdf->Cell(15,5,'Monto',1,0,'C');
		$ln = 70;
		$pdf->SetFont('Arial','',7);
		$tBruto 	= 0;
		$tCobranza 	= 0;
		$tVigente	= 0;
		$ln += 5;
		$bdSol=$link->query("SELECT * FROM SolFactura WHERE RutCli = '".$RutCli."' and nFactura > 0 and pagoFactura != 'on' Order By fechaFactura");
		while($rowSol=mysqli_fetch_array($bdSol)){
				$Contacto = '';
				$Departamento = '';
				$Correo = '';
				$Fono = '';
			
				$pdf->SetXY(10,$ln);
				$pdf->Cell(15,10,'',1,1,'C');
				$pdf->SetXY(10,$ln);
				$pdf->MultiCell(15,10,$rowSol['nFactura'],0,'C');
				$fd 	= explode('-', $rowSol['fechaFactura']);
				$pdf->SetXY(25,$ln);
				$pdf->Cell(15,10,'',1,1,'C');
				$pdf->SetXY(25,$ln);
				$pdf->MultiCell(15,10,$fd[2].'-'.$fd[1].'-'.$fd[0],0,'C');
				$Atencion = explode(',',$rowSol['Atencion']);

				$fdAtencion = $Atencion[0];
				if($Atencion[0] == 'pago'){
					$fdAtencion = $Atencion[1];
				}

				$pdf->SetXY(40,$ln);
				$pdf->Cell(40,10,'',1,1,'C');
				$pdf->SetXY(40,$ln);
				$pdf->SetFont('Arial','',5);
				$pdf->MultiCell(40,10, strtoupper(utf8_decode($fdAtencion)),0,'C');
				$pdf->SetFont('Arial','',7);

				$pdf->SetXY(80,$ln);
				$pdf->Cell(37,10,'',1,1,'C');
				$pdf->SetXY(80,$ln);
				$pdf->MultiCell(34,5,$rowSol['cotizacionesCAM'],0,'R');
				$pdf->SetXY(117,$ln);
				$pdf->Cell(38,10,'',1,1,'C');
				$pdf->SetXY(117,$ln);
				$pdf->MultiCell(34,5,$rowSol['informesAM'],0,'R');
				$fechaCobro = strtotime ( '+30 day' , strtotime ( $rowSol['fechaFactura'] ) );
				$fechaCobro = date ( 'Y-m-d' , $fechaCobro );

				$start_ts 	= strtotime($fechaHoy); 
				$end_ts 	= strtotime($fechaCobro); 
				$start_ts 	= strtotime($fechaCobro); 
				$end_ts 	= strtotime($fechaHoy); 
				$nDias = $end_ts - $start_ts;
				$nDias = round($nDias / 86400)+1;
				$pdf->SetXY(155,$ln);
				$pdf->Cell(10,10,'',1,1,'C');
				if($nDias > 0){
					$pdf->SetXY(155,$ln);
					$pdf->MultiCell(10,10,$nDias,1,'C');
				}else{
					$pdf->SetXY(155,$ln);
					$pdf->MultiCell(10,10,'',1,'C');
				}
				$Estado = '';
				if($fechaCobro <= $fechaHoy){
					$Estado = 'Vencido';
					$tCobranza += $rowSol['Bruto'];
				}else{
					$Estado = 'Vigente';
					$tVigente += $rowSol['Bruto'];
				}
				$pdf->SetXY(165,$ln);
				$pdf->Cell(16,10,'',1,1,'C');
				$pdf->SetXY(165,$ln);
				$pdf->MultiCell(16,10,$Estado,1,'C');
				$pdf->SetXY(181,$ln);
				$pdf->Cell(15,10,'',1,1,'C');
				$pdf->SetXY(181,$ln);
				$pdf->MultiCell(15,10,number_format($rowSol['Bruto'], 0, ',', '.'),0,'C');
				$tBruto += $rowSol['Bruto'];
				$ln += 10;
		}
			
		$pdf->SetXY(155,$ln);
		$pdf->MultiCell(26,5,'VENCIDO',1,'C');
		$pdf->SetXY(181,$ln);
		$pdf->Cell(15,5,number_format($tCobranza, 0, ',', '.'),1,'C');

		$ln += 5;
		$pdf->SetXY(155,$ln);
		$pdf->MultiCell(26,5,'VIGENTE',1,'C');
		$pdf->SetXY(181,$ln);
		$pdf->Cell(15,5,number_format($tVigente, 0, ',', '.'),1,'C');

		$ln += 5;
		$pdf->SetXY(155,$ln);
		$pdf->MultiCell(26,5,'TOTAL',1,'C');
		$pdf->SetXY(181,$ln);
		$pdf->Cell(15,5,number_format($tBruto, 0, ',', '.'),1,'C');

	}else{
		$ln += 8;
		$pdf->SetXY(10,$ln);
		$pdf->SetFont('Arial','B',12);
		$pdf->MultiCell(185,5,'NO EXISTEN FACTURACIONES PARA ESTE CLIENTE',0,'C');
	}
	
	$link->close();


	//$pdf->Output('F3B-00001.pdf','I'); //Para Descarga
	$NombreFormulario = "estadoCuenta-".$RutCli.".pdf";
	$pdf->Output($NombreFormulario,'D'); //Para Descarga
	//$pdf->Output('F3B-00001.pdf','F');

?>
