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
	$ln = 70;

	$entra = 'No';
	$SQL = "SELECT * FROM Cotizaciones Where RutCli = '".$RutCli."' and nContacto = '".$nContacto."' and Estado = 'P' Order By Facturacion, Archivo, informeUp, fechaTermino Desc";
	if ($nContacto == 'All'){
		$SQL = "SELECT * FROM Cotizaciones Where RutCli = '".$RutCli."' and Estado = 'P' Order By Facturacion, Archivo, informeUp, fechaTermino Desc";
	}
	$bd=$link->query($SQL);
	if ($row=mysqli_fetch_array($bd)){
		$entra = 'Si';
	}

	if($entra == 'Si'){
		// En Proceso
		$ln += 8;
		$pdf->SetXY(10,$ln);
		$pdf->SetFont('Arial','B',12);
		$pdf->MultiCell(185,5,'TRABAJOS EN PROCESO',0,'C');
		
		$ln += 8;
		$pdf->SetFont('Arial','B',7);
		$pdf->SetXY(10,$ln);
		$pdf->Cell(15,5,utf8_decode('Cotización'),1,0,'C');
		$pdf->Cell(15,5,'Cod.Interno',1,0,'C');
		$pdf->Cell(20,5,'Solicitud',1,0,'C');
		$pdf->Cell(50,5,utf8_decode('Atención'),1,0,'C');
		$pdf->Cell(40,5,'Cant. Informe(S)',1,0,'C');
		$pdf->Cell(20,5,'Fecha UP',1,0,'C');
		$pdf->Cell(25,5,'Costo',1,0,'C');

		$montoTotal = 0;
		$SQL = "SELECT * FROM Cotizaciones Where RutCli = '".$RutCli."' and nContacto = '".$nContacto."' and Estado = 'P' Order By Facturacion, Archivo, informeUp, fechaTermino Desc";
		if ($nContacto == 'All'){
			$SQL = "SELECT * FROM Cotizaciones Where RutCli = '".$RutCli."' and Estado = 'P' Order By Facturacion, Archivo, informeUp, fechaTermino Desc";
		}
		$bd=$link->query($SQL);
		while ($row=mysqli_fetch_array($bd)){
			if($pdf->GetY() >= 225){
				$pdf->AddPage();
				$ln = 15;
			}
			$ln += 5;
			$pdf->SetXY(10,$ln);
			$pdf->Cell(15,5,$row['CAM'],1,0,'C');
			$pdf->Cell(15,5,$row['RAM'],1,0,'C');
			$fd = explode('-',$row['fechaCotizacion']);
			$pdf->Cell(20,5,$fd[2].'-'.$fd[1].'-'.$fd[0],1,0,'C');

			$Atencion = '';
			$SQLa = "SELECT * FROM contactosCli Where RutCli = '".$RutCli."' and nContacto = '".$row['nContacto']."'";
			$bda=$link->query($SQLa);
			if ($rowa=mysqli_fetch_array($bda)){
				$Atencion = $rowa['Contacto'];
			}
			$pdf->SetFont('Arial','',5);
			$pdf->Cell(50,5,strtoupper(utf8_decode($Atencion)),1,0,'C');
			$pdf->SetFont('Arial','',7);

			$informes 	= '';
			$cInformes 	= 0;
			$SQLi = "SELECT * FROM informes Where CodInforme Like '%".$row['RAM']."%'";
			$bdi=$link->query($SQLi);
			while ($rowi=mysqli_fetch_array($bdi)){
				$cInformes++;
				if($informes == ''){
					$informes = $rowi['informePDF'];
				}else{
					$informes .= ', '.$rowi['informePDF'];
				}
			}
			$pdf->Cell(40,5,$cInformes,1,0,'C');
			$fd = explode('-',$row['fechaInformeUP']);
			$pdf->Cell(20,5,' ',1,0,'C');
			if($row['Bruto']){
				$pdf->Cell(25,5,'$ '.number_format($row['Bruto'],0,',','.'),1,0,'C');
				$montoTotal += $row['Bruto'];
			}else{
				$pdf->Cell(25,5,'$ '.number_format($row['BrutoUF'],2,',','.').' UF',1,0,'C');
			}

		}
		// En Proceso
	}else{
		// En Proceso
		$ln += 8;
		$pdf->SetXY(10,$ln);
		$pdf->SetFont('Arial','B',12);
		$pdf->MultiCell(185,5,'NO HAY TRABAJOS EN PROCESO PARA ESTE CLIENTE',0,'C');
	}
	
	$link->close();


	//$pdf->Output('F3B-00001.pdf','I'); //Para Descarga
	$NombreFormulario = "estadoCuenta-".$RutCli.".pdf";
	$pdf->Output($NombreFormulario,'D'); //Para Descarga
	//$pdf->Output('F3B-00001.pdf','F');

?>
