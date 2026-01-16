<?php
	require_once('../../fpdf/fpdf.php');
	include_once("../../conexionli.php");

	if(isset($_GET['RAM'])) 	{ $RAM 		= $_GET['RAM']; 	}
	if(isset($_GET['CAM'])) 	{ $CAM 		= $_GET['CAM'];		}
	if(isset($_GET['accion'])) 	{ $accion 	= $_GET['accion'];	}
		
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
	$bdRAM=$link->query("SELECT * FROM registroMuestras WHERE RAM = '".$RAM."'");
	if($rowRAM=mysqli_fetch_array($bdRAM)){
		if($rowRAM['CAM'] > 0){
			$CAM = $rowRAM['CAM'];
		}
		$pdf=new FPDF('P','mm','Letter');

		// Encabezado 
		$pdf->AddPage();
		$pdf->SetXY(10,5);
		$pdf->Image('../../imagenes/logoSimetCam.png',10,5,43,16);

		$pdf->SetFont('Arial','B',18);
		$pdf->SetXY(80,12);
		$pdf->Cell(30,5,'RAM '.$RAM,0,0,'C');
		$pdf->SetFont('Arial','',10);

		$pdf->SetXY(50,17);
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(10,5,'Acreditado NCh-ISO 17.025.',0,0);

		$pdf->SetXY(10,17);
		$pdf->Image('../../gastos/logos/logousach.png',195,5,15,23);

		$pdf->SetDrawColor(0, 0, 0);
		$pdf->Image('../../imagenes/logoSimetCam.png',185,245,20,8);
		
		$pdf->SetXY(197,30);
		$pdf->Cell(30,4,$CAM,0,0,'L');

		$pdf->SetDrawColor(200, 200, 200);
		$pdf->Line(190, 30, 190, 270);
		$pdf->SetDrawColor(0, 0, 0);
		// Fin Encabezado
		
		$ln = 25;
		$bdCli=$link->query("SELECT * FROM Clientes WHERE RutCli = '".$rowRAM['RutCli']."'");
		if($rowCli=mysqli_fetch_array($bdCli)){
			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(10,$ln);
			$pdf->Cell(30,4,'EMPRESA:',0,0,'L');

			$pdf->SetFont('Arial','B',10);
			$pdf->SetXY(30,$ln);
			$pdf->Cell(144,4,utf8_decode($rowCli['Cliente']),0,0,'L');

			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(150,$ln);
			$pdf->Cell(10,4,'FECHA:',0,0,'L');
			
			$pdf->SetFont('Arial','B',10);
			$fd = explode('-', $rowRAM['fechaRegistro']); 
			$pdf->SetXY(164,$ln);
			$pdf->Cell(15,4,$fd[2].'/'.$fd[1].'/'.$fd[0],0,0,'L');

			// Line(Col, FilaDesde, ColHasta, FilaHasta) 
			$pdf->Line(10, 30, 184, 30);

			$ln += 8;
			$bdCAM=$link->query("SELECT * FROM Cotizaciones WHERE CAM = '".$CAM."'");
			if($rowCAM=mysqli_fetch_array($bdCAM)){
				$Atencion 		= $rowCAM['Atencion'];
				$RutCli			= $rowCAM['RutCli'];
				$usrResponsable	= $rowCAM['usrResponzable'];
			}

			$bdCon=$link->query("SELECT * FROM contactosCli WHERE RutCli = '".$RutCli."' and Contacto = '".$Atencion."'");
			if($rowCon=mysqli_fetch_array($bdCon)){

				$pdf->SetFont('Arial','',10);
				$pdf->SetXY(10,$ln);
				$pdf->Cell(30,4, utf8_decode('ATENCIÓN'),0,0,'L');

				$pdf->SetFont('Arial','B',10);
				$pdf->SetXY(30,$ln);
				$pdf->Cell(144,4,utf8_decode($Atencion),0,0,'L');

				$ln += 5;
				$pdf->SetFont('Arial','',10);
				$pdf->Line(10, $ln, 184, $ln);

				$ln += 3;
				$pdf->SetFont('Arial','',10);
				$pdf->SetXY(10,$ln);
				$pdf->Cell(30,4,'FONO:',0,0,'L');
	
				$pdf->SetFont('Arial','B',10);
				$pdf->SetXY(30,$ln);
				$pdf->Cell(144,4,$rowCon['Telefono'],0,0,'L');

				$pdf->SetFont('Arial','',10);
				$pdf->SetXY(120,$ln);
				$pdf->Cell(10,4,'EMAIL:',0,0,'L');
	
				$pdf->SetFont('Arial','B',10);
				$pdf->SetXY(134,$ln);
				$pdf->Cell(50,4,$rowCon['Email'],0,0,'L');
				
				$ln += 5;
				$pdf->SetFont('Arial','',10);
				$pdf->Line(10, $ln, 184, $ln);

				$ln += 3;
				$pdf->SetFont('Arial','',10);
				$pdf->SetXY(10,$ln);
				$pdf->Cell(30,4,utf8_decode('DIRECCIÓN:'),0,0,'L');

				$pdf->SetFont('Arial','B',10);
				$pdf->SetXY(35,$ln);
				$pdf->Cell(144,4,utf8_decode($rowCli['Direccion']),0,0,'L');

				$ln += 5;
				$pdf->SetFont('Arial','',10);
				$pdf->Line(10, $ln, 184, $ln);
			}
		}
		$ln += 5;

		$pdf->SetFont('Arial','',10);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(175,150,"",1,'L');
		
		$lnTxt = "No se debe retirar este documento si es que no se adjunta la Cotización y/o la aprobación del cliente.";

		$pdf->SetFont('Arial','B',16);
		$pdf->SetXY(10,100);
		$pdf->MultiCell(174,8, utf8_decode($lnTxt),0,'L');

		$lnTxt  = "En este formulario se deben adjuntar registros pertinentes a la administración, ";
		$lnTxt .= "tal como: órdenes de compra, guías de despacho, etc.";
		
		$pdf->SetFont('Arial','',14);
		$pdf->SetXY(10,120);
		$pdf->MultiCell(174,8,utf8_decode($lnTxt),0,'L');
		
		$pdf->SetFont('Arial','B',12);
		$pdf->SetXY(10,220);
		$pdf->Cell(30,4,utf8_decode('Recepción:'),0,0,'L');

		$pdf->SetXY(100,220);
		$pdf->Cell(30,4,'Responsable:',0,0,'L');

		$pdf->SetXY(10,225);
		$pdf->Cell(15,10,substr($rowRAM['usrRecepcion'],0,1),1,0,'C');
		$pdf->Cell(15,10,substr($rowRAM['usrRecepcion'],1,1),1,0,'C');
		$pdf->Cell(15,10,substr($rowRAM['usrRecepcion'],2,1),1,0,'C');

		$pdf->SetXY(100,225);
		$pdf->Cell(15,10,substr($usrResponsable,0,1),1,0,'C');
		$pdf->Cell(15,10,substr($usrResponsable,1,1),1,0,'C');
		$pdf->Cell(15,10,substr($usrResponsable,2,1),1,0,'C');

		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(150,245);
		$pdf->Cell(15,10,'Reg 2401-Rev.04',0,0,'R');

		// Encabezado 
		$pdf->AddPage();
		$pdf->SetXY(10,5);
		$pdf->Image('../../imagenes/logoSimetCam.png',10,5,43,16);

		$pdf->SetFont('Arial','B',18);
		$pdf->SetXY(80,12);
		$pdf->Cell(30,5,'RAM '.$RAM,0,0,'C');
		$pdf->SetFont('Arial','',10);

		$pdf->SetXY(50,17);
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(10,5,'Acreditado NCh-ISO 17.025.',0,0);

		$pdf->SetXY(10,17);
		$pdf->Image('../../gastos/logos/logousach.png',195,5,15,23);

		$pdf->SetDrawColor(0, 0, 0);
		$pdf->Image('../../imagenes/logoSimetCam.png',185,245,20,8);
		
		$pdf->SetXY(197,30);
		$pdf->Cell(30,4,$CAM,0,0,'L');

		$pdf->SetDrawColor(200, 200, 200);
		$pdf->Line(190, 30, 190, 270);
		$pdf->SetDrawColor(0, 0, 0);
		// Fin Encabezado
	
		$ln = 25;
		$bdCli=$link->query("SELECT * FROM Clientes WHERE RutCli = '".$rowRAM['RutCli']."'");
		if($rowCli=mysqli_fetch_array($bdCli)){
			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(10,$ln);
			$pdf->Cell(30,4,'EMPRESA:',0,0,'L');

			$pdf->SetFont('Arial','B',10);
			$pdf->SetXY(30,$ln);
			$pdf->Cell(144,4,utf8_decode($rowCli['Cliente']),0,0,'L');

			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(150,$ln);
			$pdf->Cell(10,4,'FECHA:',0,0,'L');
			
			$pdf->SetFont('Arial','B',10);
			$fd = explode('-', $rowRAM['fechaRegistro']); 
			$pdf->SetXY(164,$ln);
			$pdf->Cell(15,4,$fd[2].'/'.$fd[1].'/'.$fd[0],0,0,'L');

			// Line(Col, FilaDesde, ColHasta, FilaHasta) 
			$pdf->Line(10, 30, 184, 30);

			$ln += 8;
			$bdCAM=$link->query("SELECT * FROM Cotizaciones WHERE CAM = '".$CAM."'");
			if($rowCAM=mysqli_fetch_array($bdCAM)){
				$Atencion 		= $rowCAM['Atencion'];
				$RutCli			= $rowCAM['RutCli'];
				$usrResponsable	= $rowCAM['usrResponzable'];
			}

			$bdCon=$link->query("SELECT * FROM contactosCli WHERE RutCli = '".$RutCli."' and Contacto = '".$Atencion."'");
			if($rowCon=mysqli_fetch_array($bdCon)){

				$pdf->SetFont('Arial','',10);
				$pdf->SetXY(10,$ln);
				$pdf->Cell(30,4,utf8_decode('ATENCIÓN'),0,0,'L');

				$pdf->SetFont('Arial','B',10);
				$pdf->SetXY(30,$ln);
				$pdf->Cell(144,4,utf8_decode($Atencion),0,0,'L');

				$ln += 5;
				$pdf->SetFont('Arial','',10);
				$pdf->Line(10, $ln, 184, $ln);

				$ln += 3;
				$pdf->SetFont('Arial','',10);
				$pdf->SetXY(10,$ln);
				$pdf->Cell(30,4,'FONO:',0,0,'L');
	
				$pdf->SetFont('Arial','B',10);
				$pdf->SetXY(30,$ln);
				$pdf->Cell(144,4,$rowCon['Telefono'],0,0,'L');

				$pdf->SetFont('Arial','',10);
				$pdf->SetXY(120,$ln);
				$pdf->Cell(10,4,'EMAIL:',0,0,'L');
	
				$pdf->SetFont('Arial','B',10);
				$pdf->SetXY(134,$ln);
				$pdf->Cell(50,4,$rowCon['Email'],0,0,'L');
				
				$ln += 5;
				$pdf->SetFont('Arial','',10);
				$pdf->Line(10, $ln, 184, $ln);

				$ln += 3;
				$pdf->SetFont('Arial','',10);
				$pdf->SetXY(10,$ln);
				$pdf->Cell(30,4,utf8_decode('DIRECCIÓN:'),0,0,'L');

				$pdf->SetFont('Arial','B',10);
				$pdf->SetXY(35,$ln);
				$pdf->Cell(144,4,utf8_decode($rowCli['Direccion']),0,0,'L');

				$ln += 5;
				$pdf->SetFont('Arial','',10);
				$pdf->Line(10, $ln, 184, $ln);
			}
		}
		$ln += 5;

		$lnTxt = "Necesita S. a taller: ";

		$pdf->SetFont('Arial','B',12);
		$pdf->SetXY(10,$ln);
		$pdf->Cell(30,8,$lnTxt,0,0,'L');

		$lnTxt = "si ";

		$pdf->SetXY(50,$ln);
		$pdf->Cell(10,8,$lnTxt,0,0,'L');

		$pdf->SetXY(57,$ln);
		$pdf->MultiCell(10,10,"",1,'L');

		$lnTxt = "no ";

		$pdf->SetXY(68,$ln);
		$pdf->Cell(10,8,$lnTxt,0,0,'L');

		$pdf->SetXY(77,$ln);
		$pdf->MultiCell(10,10,"",1,'L');

		$lnTxt = "Nº Solicitud Servicio Taller ";

		$pdf->SetXY(90,$ln);
		$pdf->Cell(40,8,utf8_decode($lnTxt),0,0,'L');

		$pdf->SetXY(146,$ln);
		$pdf->MultiCell(39,10,"",1,'L');
		
		$ln += 15;

		$lnTxt = "Observaciones: ";

		$pdf->SetXY(10,$ln);
		$pdf->Cell(174,8,$lnTxt,0,0,'L');

		$pdf->SetFont('Arial','',10);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(175,70,"",1,'L');

		$ln = 147;

		$lnTxt = "ID SIMET";

		$pdf->SetFont('Arial','B',10);
		$pdf->SetXY(10,$ln);
		$pdf->Cell(20,8,$lnTxt,0,0,'C');

		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(20,10,"",1,'L');

		$lnTxt = "Identificación del cliente";
		$pdf->SetXY(30,$ln);
		$pdf->Cell(114,8,utf8_decode($lnTxt),0,0,'C');
		$pdf->SetXY(30,$ln);
		$pdf->MultiCell(114,10,"",1,'L');

		$lnTxt = "OTAM";
		$pdf->SetXY(144,$ln);
		$pdf->Cell(41,8,$lnTxt,0,0,'C');
		$pdf->SetXY(144,$ln);
		$pdf->MultiCell(41,10,"",1,'L');

		for($i=1; $i<6; $i++){
			$ln += 10;
			
			$pdf->SetXY(10,$ln);
			$pdf->MultiCell(20,10,"",1,'L');
	
			$pdf->SetXY(30,$ln);
			$pdf->MultiCell(114,10,"",1,'L');
	
			$pdf->SetXY(144,$ln);
			$pdf->MultiCell(41,10,"",1,'L');
		}

		$pdf->SetFont('Arial','B',12);
		$pdf->SetXY(10,220);
		$pdf->Cell(30,4,utf8_decode('Recepción:'),0,0,'L');

		$pdf->SetXY(100,220);
		$pdf->Cell(30,4,'Responsable:',0,0,'L');

		$pdf->SetXY(10,225);
		$pdf->Cell(15,10,substr($rowRAM['usrRecepcion'],0,1),1,0,'C');
		$pdf->Cell(15,10,substr($rowRAM['usrRecepcion'],1,1),1,0,'C');
		$pdf->Cell(15,10,substr($rowRAM['usrRecepcion'],2,1),1,0,'C');

		$pdf->SetXY(100,225);
		$pdf->Cell(15,10,substr($usrResponsable,0,1),1,0,'C');
		$pdf->Cell(15,10,substr($usrResponsable,1,1),1,0,'C');
		$pdf->Cell(15,10,substr($usrResponsable,2,1),1,0,'C');

		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(150,245);
		$pdf->Cell(15,10,'Reg 2401-Rev.04',0,0,'R');
		
	}
	
$link->close();
/*
	if($accion == 'Reimprime'){
	}else{
		$Estado 		= 'E';
		$enviadoCorreo 	= 'on';
		$actSQL="UPDATE Cotizaciones SET ";
		$actSQL.="Estado			='".$Estado.			"',";
		$actSQL.="enviadoCorreo		='".$enviadoCorreo.		"',";
		$actSQL.="proxRecordatorio	='".$proxRecordatorio.	"',";
		$actSQL.="fechaEnvio		='".$fechaHoy.			"'";
		$actSQL.="WHERE CAM			= '".$CAM."'and Rev = '".$Rev."' and Cta = '".$Cta."'";
		$bdCot=$link->query($actSQL);
		mysql_close($link);
	}
*/	
	//$pdf->Output('F3B-00001.pdf','I'); //Para Descarga
	$NombreFormulario = "RAM-".$RAM.".pdf";
	$pdf->Output($NombreFormulario,'D'); //Para Descarga
	//$pdf->Output('F3B-00001.pdf','F');

?>
