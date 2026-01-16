<?php
	require_once('../../fpdf/fpdf.php');
	include_once("../../conexionli.php");
	header('Content-Type: text/html; charset=utf-8');

	if(isset($_GET['RAM'])) 	{ $RAM 		= $_GET['RAM'];		} 
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
	$RutCli = '';
	$CAM 	= '';
	
	$link=Conectarse();
	$bdRAM=$link->query("SELECT * FROM formRAM WHERE RAM = '".$RAM."'");
	if($rowRAM=mysqli_fetch_array($bdRAM)){
		if($rowRAM['CAM'] > 0){
			$CAM = $rowRAM['CAM'];
		}
		$pdf=new FPDF('P','mm','Letter');

		// Encabezado 
		$pdf->AddPage();
		$pdf->SetXY(10,5);
		$pdf->Image('../../imagenes/logonewsimet.jpg',10,5,43,16);

		$pdf->SetFont('Arial','B',18);
		$r = $RAM;

		//$rRam = $r - (intval($r / 1000)*1000);
		$rRam = intval((($r / 10) - intval($r / 10)) * 10);

		if($rRam > 4) { $rRam = $rRam - 5; }
		
		$cR = 0; $cG = 0; $cB = 0;
		
		/* Negro */
		if($rRam == 0){ $cR = 0; $cG = 0; $cB = 0; }
		
		/* Azul */
		if($rRam == 1){ $cR = 0; $cG = 102; $cB = 204; }
		
		/* Verde */
		if($rRam == 2){ $cR = 0; $cG = 204; $cB = 102; }
		
		/* Cafe */
		if($rRam == 3){ $cR = 153; $cG = 76; $cB = 0; }
		
		/* Rojo */
		if($rRam == 4){ $cR = 255; $cG = 0; $cB = 0; }
		
		$pdf->SetTextColor($cR, $cG, $cB);
		//$pdf->SetTextColor(0,102,204);
		$pdf->SetXY(80,12);
		$pdf->Cell(30,5,'RAM '.$RAM,0,0,'C');
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('Arial','',10);

		$pdf->SetXY(50,17);
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(10,5,'',0,0);

		$pdf->SetXY(10,17);
		$pdf->Image('../../gastos/logos/logousach.png',195,5,15,23);

		$pdf->SetDrawColor(0, 0, 0);
		$pdf->Image('../../imagenes/logonewsimet.jpg',185,245,20,8);
		
		$pdf->SetXY(197,30);
		$pdf->Cell(30,4,$CAM,0,0,'L');

		$pdf->SetDrawColor(200, 200, 200);
		$pdf->Line(190, 30, 190, 270);
		$pdf->SetDrawColor(0, 0, 0);
		// Fin Encabezado
		$nContacto = 0;
		//$bdCAM=$link->query("SELECT * FROM Cotizaciones WHERE CAM = '".$CAM."' and RAM = '".$RAM."'");
		$bdCAM=$link->query("SELECT * FROM Cotizaciones WHERE RAM = '".$RAM."'");
		if($rowCAM=mysqli_fetch_array($bdCAM)){
			$RutCli 		= $rowCAM['RutCli'];
			$Atencion 		= $rowCAM['Atencion'];
			$nContacto 		= $rowCAM['nContacto'];
			$RutCli			= $rowCAM['RutCli'];
			$usrResponsable	= $rowCAM['usrResponzable'];
			if($Atencion > 0 and $nContacto == 0){
				$nContacto = $rowCAM['Atencion'];
			}
		}
		
		$ln = 25;
		$bdCli=$link->query("SELECT * FROM Clientes WHERE RutCli = '".$RutCli."'");
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
			$fd = explode('-', $rowRAM['fechaInicio']); 
			$pdf->SetXY(164,$ln);
			$pdf->Cell(15,4,$fd[2].'/'.$fd[1].'/'.$fd[0],0,0,'L');

			// Line(Col, FilaDesde, ColHasta, FilaHasta) 
			$pdf->Line(10, 30, 184, 30);

			$ln += 8;

			$bdCon=$link->query("SELECT * FROM contactosCli WHERE RutCli = '".$RutCli."' and nContacto = '".$nContacto."'");
			if($rowCon=mysqli_fetch_array($bdCon)){

				$pdf->SetFont('Arial','',10);
				$pdf->SetXY(10,$ln);
				$pdf->Cell(30,4, utf8_decode('ATENCIÓN') ,0,0,'L');

				$pdf->SetFont('Arial','B',10);
				$pdf->SetXY(30,$ln);
				$pdf->Cell(144,4,utf8_decode($rowCon['Contacto']),0,0,'L');

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
				$pdf->Cell(30,4, utf8_decode('DIRECCIÓN:') ,0,0,'L');

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
		$pdf->MultiCell(174,8,utf8_decode($lnTxt),0,'L');

		$lnTxt  = "En este formulario se deben adjuntar registros pertinentes a la administración, ";
		$lnTxt .= "tal como: órdenes de compra, guías de despacho, etc.";
		
		$pdf->SetFont('Arial','',14);
		$pdf->SetXY(10,120);
		$pdf->MultiCell(174,8,utf8_decode($lnTxt),0,'L');
		
		$pdf->SetFont('Arial','B',12);
		$pdf->SetXY(10,220);
		$pdf->Cell(30,4,utf8_decode('Recepción:') ,0,0,'L');

		$pdf->SetXY(100,220);
		$pdf->Cell(30,4,'Responsable:',0,0,'L');

		$pdf->SetXY(10,225);
		$pdf->Cell(15,10,utf8_decode(substr($rowRAM['ingResponsable'],0,1)),1,0,'C');
		$pdf->Cell(15,10,utf8_decode(substr($rowRAM['ingResponsable'],1,1)),1,0,'C');
		$pdf->Cell(15,10,utf8_decode(substr($rowRAM['ingResponsable'],2,1)),1,0,'C');

		$pdf->SetXY(100,225);
		$pdf->Cell(15,10,utf8_decode(substr($rowRAM['cooResponsable'],0,1)),1,0,'C');
		$pdf->Cell(15,10,utf8_decode(substr($rowRAM['cooResponsable'],1,1)),1,0,'C');
		$pdf->Cell(15,10,utf8_decode(substr($rowRAM['cooResponsable'],2,1)),1,0,'C');

		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(150,245);
		$pdf->Cell(15,10,'Reg 2401-V.05',0,0,'R');

		// Encabezado 
		$pdf->AddPage();
		$pdf->SetXY(10,5);
		$pdf->Image('../../imagenes/logonewsimet.jpg',10,5,43,16);

		$pdf->SetFont('Arial','B',18);
		$pdf->SetXY(80,12);
		$pdf->SetTextColor($cR, $cG, $cB);
		$pdf->Cell(30,5,'RAM '.$RAM,0,0,'C');
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('Arial','',10);

		$pdf->SetXY(50,17);
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(10,5,'',0,0);

		$pdf->SetXY(10,17);
		$pdf->Image('../../gastos/logos/logousach.png',195,5,15,23);

		$pdf->SetDrawColor(0, 0, 0);
		$pdf->Image('../../imagenes/logonewsimet.jpg',185,245,20,8);
		
		$pdf->SetXY(197,30);
		$pdf->Cell(30,4,$CAM,0,0,'L');

		$pdf->SetDrawColor(200, 200, 200);
		$pdf->Line(190, 30, 190, 270);
		$pdf->SetDrawColor(0, 0, 0);
		// Fin Encabezado
	
		$ln = 25;
		$bdCli=$link->query("SELECT * FROM Clientes WHERE RutCli = '".$RutCli."'");
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
			$fd = explode('-', $rowRAM['fechaInicio']); 
			$pdf->SetXY(164,$ln);
			$pdf->Cell(15,4,$fd[2].'/'.$fd[1].'/'.$fd[0],0,0,'L');

			// Line(Col, FilaDesde, ColHasta, FilaHasta) 
			$pdf->Line(10, 30, 184, 30);

			$ln += 8;
			$bdCAM=$link->query("SELECT * FROM Cotizaciones WHERE CAM = '".$CAM."' and RAM = '".$RAM."'");
			if($rowCAM=mysqli_fetch_array($bdCAM)){
				$RutCli 		= $rowCAM['RutCli'];
				$Atencion 		= $rowCAM['Atencion'];
				$RutCli			= $rowCAM['RutCli'];
				$usrResponsable	= $rowCAM['usrResponzable'];
			}

			$bdCon=$link->query("SELECT * FROM contactosCli WHERE RutCli = '".$RutCli."' and Contacto = '".$Atencion."'");
			if($rowCon=mysqli_fetch_array($bdCon)){

				$pdf->SetFont('Arial','',10);
				$pdf->SetXY(10,$ln);
				$pdf->Cell(30,4,'ATENCIÓN',0,0,'L');

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
				$pdf->Cell(30,4,'DIRECCIÓN:',0,0,'L');

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

		if($rowRAM['nSolTaller']>0){
			$pdf->SetXY(57,$ln);
			$pdf->Cell(10,10,"X",0,0,'C');
		}

		$lnTxt = "no ";

		$pdf->SetXY(68,$ln);
		$pdf->Cell(10,8,$lnTxt,0,0,'L');

		$pdf->SetXY(77,$ln);
		$pdf->MultiCell(10,10,"",1,'L');

		if($rowRAM['nSolTaller']==0){
			$pdf->SetXY(77,$ln);
			$pdf->Cell(10,10,"X",0,0,'C');
		}

		$lnTxt = "N° Solicitud Servicio Taller ";

		$pdf->SetXY(90,$ln);
		$pdf->Cell(40,8,utf8_decode($lnTxt),0,0,'L');

		$pdf->SetXY(146,$ln);
		$pdf->MultiCell(39,10,"",1,'L');

		if($rowRAM['nSolTaller']>0){
			$pdf->SetXY(146,$ln);
			$pdf->Cell(39,10,$rowRAM['nSolTaller'],0,0,'C');
		}
		
		$ln += 15;

		$lnTxt = "Observaciones: ";

		$pdf->SetXY(10,$ln);
		$pdf->Cell(174,8,$lnTxt,0,0,'L');

		$pdf->SetFont('Arial','',10);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(175,70,"",1,'L');

		$ln = $ln + 7;
		$pdf->SetXY(15,$ln);
		$pdf->MultiCell(175,5,utf8_decode($rowRAM['Obs']),0,'L');

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

		$nOtam = 0;
		$SQL = "SELECT * FROM amMuestras Where idItem Like '%".$RAM."%' Order By idItem";
		$bdMu=$link->query($SQL);
		if($rowMu=mysqli_fetch_array($bdMu)){
			do{
				$sqlOtam = "SELECT * FROM OTAMs Where idItem = '".$rowMu['idItem']."' Order By idItem, Otam";
				$bdOT=$link->query($sqlOtam);
				if($rowOT=mysqli_fetch_array($bdOT)){
					$sqlOtam = "SELECT * FROM OTAMs Where idItem = '".$rowMu['idItem']."' Order By idItem, Otam";
					$bdOT=$link->query($sqlOtam);
					while($rowOT=mysqli_fetch_array($bdOT)){
							$nOtam++;
							if($nOtam <= 5){
								$ln += 10;
								
								$pdf->SetTextColor($cR, $cG, $cB);
								$pdf->SetXY(10,$ln);
								$pdf->MultiCell(20,10,$rowMu['idItem'],1,'C');
							
								$pdf->SetXY(30,$ln);
								$pdf->SetFont('Arial','B',8);
								$pdf->MultiCell(114,10,"",1,'L');
	
								$pdf->SetXY(30,$ln);
								$pdf->MultiCell(114,4,utf8_decode($rowMu['idMuestra']),0,'L');
								$pdf->SetFont('Arial','B',10);
							
								$pdf->SetXY(144,$ln);
								$pdf->MultiCell(41,10,$rowOT['Otam'],1,'C');
								$pdf->SetTextColor(0,0,0);
							}
					} // Imprimir Muestra sin OTAM
				}else{

							$nOtam++;
							if($nOtam <= 5){
								$ln += 10;
								
								$pdf->SetTextColor($cR, $cG, $cB);
								$pdf->SetXY(10,$ln);
								$pdf->MultiCell(20,10,$rowMu['idItem'],1,'C');
							
								$pdf->SetXY(30,$ln);
								$pdf->SetFont('Arial','B',8);
								$pdf->MultiCell(114,10,"",1,'L');
	
								$pdf->SetXY(30,$ln);
								$pdf->MultiCell(114,4,utf8_decode($rowMu['idMuestra']),0,'L');
								$pdf->SetFont('Arial','B',10);
							
								$pdf->SetXY(144,$ln);
								$pdf->MultiCell(41,10,$rowOT['Otam'],1,'C');
								$pdf->SetTextColor(0,0,0);
							}


				}
			}while($rowMu=mysqli_fetch_array($bdMu));
		}

		$pdf->SetFont('Arial','B',12);
		$pdf->SetXY(10,220);
		$pdf->Cell(30,4,utf8_decode('Recepción:'),0,0,'L');

		$pdf->SetXY(100,220);
		$pdf->Cell(30,4,'Responsable:',0,0,'L');

		$pdf->SetXY(10,225);
		$pdf->Cell(15,10,utf8_decode(substr($rowRAM['ingResponsable'],0,1)),1,0,'C');
		$pdf->Cell(15,10,utf8_decode(substr($rowRAM['ingResponsable'],1,1)),1,0,'C');
		$pdf->Cell(15,10,utf8_decode(substr($rowRAM['ingResponsable'],2,1)),1,0,'C');

		$pdf->SetXY(100,225);
		$pdf->Cell(15,10,utf8_decode(substr($rowRAM['cooResponsable'],0,1)),1,0,'C');
		$pdf->Cell(15,10,utf8_decode(substr($rowRAM['cooResponsable'],1,1)),1,0,'C');
		$pdf->Cell(15,10,utf8_decode(substr($rowRAM['cooResponsable'],2,1)),1,0,'C');

			// Siguientes Registros de OTAMs

		$sqlOtams	= "SELECT * FROM OTAMs Where RAM = '".$RAM."'";  // sentencia sql
		$result 	= $link->query($sqlOtams);
		$tOtams 	= mysqli_num_rows($result); // obtenemos el número de Otams
		
		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(150,245);
		$pdf->Cell(15,10,'Reg 2401-V.05',0,0,'R');


		
		if($tOtams > 5){
			// Encabezado 
			$pdf->AddPage();
			$pdf->SetXY(10,5);
			$pdf->Image('../../imagenes/logonewsimet.jpg',10,5,43,16);
	
			$pdf->SetFont('Arial','B',18);
			$pdf->SetXY(80,12);
			$pdf->SetTextColor($cR, $cG, $cB);
			$pdf->Cell(30,5,'RAM '.$RAM,0,0,'C');
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFont('Arial','',10);
	
			$pdf->SetXY(50,17);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(10,5,'',0,0);
	
			$pdf->SetXY(10,17);
			$pdf->Image('../../gastos/logos/logousach.png',195,5,15,23);
	
			$pdf->SetDrawColor(0, 0, 0);
			$pdf->Image('../../imagenes/logonewsimet.jpg',185,245,20,8);
			
			$pdf->SetXY(197,30);
			$pdf->Cell(30,4,$CAM,0,0,'L');
	
			$pdf->SetDrawColor(200, 200, 200);
			$pdf->Line(190, 30, 190, 270);
			$pdf->SetDrawColor(0, 0, 0);
			// Fin Encabezado
	
			$ln = 25;
	
			$lnTxt = "ID SIMET";
	
			$pdf->SetFont('Arial','B',10);
			$pdf->SetXY(10,$ln);
			$pdf->Cell(20,7,$lnTxt,0,0,'C');
	
			$pdf->SetXY(10,$ln);
			$pdf->MultiCell(20,8,"",1,'L');
	
			$lnTxt = "Identificación del cliente";
			$pdf->SetXY(30,$ln);
			$pdf->Cell(114,7,utf8_decode($lnTxt),0,0,'C');
			$pdf->SetXY(30,$ln);
			$pdf->MultiCell(114,8,"",1,'L');
	
			$lnTxt = "OTAM";
			$pdf->SetXY(144,$ln);
			$pdf->Cell(41,7,$lnTxt,0,0,'C');
			$pdf->SetXY(144,$ln);
			$pdf->MultiCell(41,8,"",1,'L');

			$pdf->SetFont('Arial','',9);
			$pdf->SetXY(155,247);
			$pdf->Cell(15,10,'Reg 240201-V.04',0,0,'R');
	
			$nOtam = 0;
			$nPp  = 0;
			
			$SQL = "SELECT * FROM amMuestras Where idItem Like '%".$RAM."%' Order By idItem";
			$bdMu=$link->query($SQL);
			if($rowMu=mysqli_fetch_array($bdMu)){
				do{
					$sqlOtam = "SELECT * FROM OTAMs Where idItem = '".$rowMu['idItem']."'";
					$bdOT=$link->query($sqlOtam);
					if($rowOT=mysqli_fetch_array($bdOT)){
						$sqlOtam = "SELECT * FROM OTAMs Where idItem = '".$rowMu['idItem']."' Order By idItem, Otam";
						$bdOT=$link->query($sqlOtam);
						if($rowOT=mysqli_fetch_array($bdOT)){
							do{
								$nOtam++;
								if($nOtam > 5){
									$nPp++;
									if($nPp > 27){
										$nPp = 1;
										// Encabezado 
										$pdf->AddPage();
										$pdf->SetXY(10,5);
										$pdf->Image('../../imagenes/logonewsimet.jpg',10,5,43,16);
								
										$pdf->SetFont('Arial','B',18);
										$pdf->SetXY(80,12);
										$pdf->SetTextColor($cR, $cG, $cB);
										$pdf->Cell(30,5,'RAM '.$RAM,0,0,'C');
										$pdf->SetTextColor(0,0,0);
										$pdf->SetFont('Arial','',10);
								
										$pdf->SetXY(50,17);
										$pdf->SetFont('Arial','B',8);
										$pdf->Cell(10,5,'',0,0);
								
										$pdf->SetXY(10,17);
										$pdf->Image('../../gastos/logos/logousach.png',195,5,15,23);
								
										$pdf->SetDrawColor(0, 0, 0);
										$pdf->Image('../../imagenes/logonewsimet.jpg',185,245,20,8);
										
										$pdf->SetXY(197,30);
										$pdf->Cell(30,4,$CAM,0,0,'L');
								
										$pdf->SetDrawColor(200, 200, 200);
										$pdf->Line(190, 30, 190, 270);
										$pdf->SetDrawColor(0, 0, 0);
										// Fin Encabezado
								
										$ln = 24;
								
										$lnTxt = "ID SIMET";
								
										$pdf->SetFont('Arial','B',10);
										$pdf->SetXY(10,$ln);
										$pdf->Cell(20,7,$lnTxt,0,0,'C');
								
										$pdf->SetXY(10,$ln);
										$pdf->MultiCell(20,8,"",1,'L');
								
										$lnTxt = "Identificación del cliente";
										$pdf->SetXY(30,$ln);
										$pdf->Cell(114,7,utf8_decode($lnTxt),0,0,'C');
										$pdf->SetXY(30,$ln);
										$pdf->MultiCell(114,8,"",1,'L');
								
										$lnTxt = "OTAM";
										$pdf->SetXY(144,$ln);
										$pdf->Cell(41,7,$lnTxt,0,0,'C');
										$pdf->SetXY(144,$ln);
										$pdf->MultiCell(41,8,"",1,'L');
										
										$pdf->SetFont('Arial','',9);
										$pdf->SetXY(150,247);
										$pdf->Cell(15,10,'Reg 240201-V.04',0,0,'R');
										
									}
									$ln += 8;
										
									$pdf->SetTextColor($cR, $cG, $cB);
									$pdf->SetXY(10,$ln);
									$pdf->MultiCell(20,8,$rowMu['idItem'],1,'C');
								
									$pdf->SetXY(30,$ln);
									$pdf->SetFont('Arial','B',7);
									$pdf->MultiCell(114,8,"",1,'L');

									$pdf->SetXY(30,$ln);
									$pdf->SetFont('Arial','B',8);
									$pdf->MultiCell(114,4,utf8_decode($rowMu['idMuestra']),0,'L');
							
									$pdf->SetFont('Arial','B',10);
									$pdf->SetXY(144,$ln);
									$pdf->MultiCell(41,8,$rowOT['Otam'],1,'C');
									$pdf->SetTextColor(0,0,0);
								}
							}while($rowOT=mysqli_fetch_array($bdOT));
						}
					}else{

								$nOtam++;
								if($nOtam > 5){
									$nPp++;
									if($nPp > 27){
										$nPp = 1;
										// Encabezado 
										$pdf->AddPage();
										$pdf->SetXY(10,5);
										$pdf->Image('../../imagenes/logonewsimet.jpg',10,5,43,16);
								
										$pdf->SetFont('Arial','B',18);
										$pdf->SetXY(80,12);
										$pdf->SetTextColor($cR, $cG, $cB);
										$pdf->Cell(30,5,'RAM '.$RAM,0,0,'C');
										$pdf->SetTextColor(0,0,0);
										$pdf->SetFont('Arial','',10);
								
										$pdf->SetXY(50,17);
										$pdf->SetFont('Arial','B',8);
										$pdf->Cell(10,5,'',0,0);
								
										$pdf->SetXY(10,17);
										$pdf->Image('../../gastos/logos/logousach.png',195,5,15,23);
								
										$pdf->SetDrawColor(0, 0, 0);
										$pdf->Image('../../imagenes/logonewsimet.jpg',185,245,20,8);
										
										$pdf->SetXY(197,30);
										$pdf->Cell(30,4,$CAM,0,0,'L');
								
										$pdf->SetDrawColor(200, 200, 200);
										$pdf->Line(190, 30, 190, 270);
										$pdf->SetDrawColor(0, 0, 0);
										// Fin Encabezado
								
										$ln = 24;
								
										$lnTxt = "ID SIMET";
								
										$pdf->SetFont('Arial','B',10);
										$pdf->SetXY(10,$ln);
										$pdf->Cell(20,7,$lnTxt,0,0,'C');
								
										$pdf->SetXY(10,$ln);
										$pdf->MultiCell(20,8,"",1,'L');
								
										$lnTxt = "Identificación del cliente";
										$pdf->SetXY(30,$ln);
										$pdf->Cell(114,7,utf8_decode($lnTxt),0,0,'C');
										$pdf->SetXY(30,$ln);
										$pdf->MultiCell(114,8,"",1,'L');
								
										$lnTxt = "OTAM";
										$pdf->SetXY(144,$ln);
										$pdf->Cell(41,7,$lnTxt,0,0,'C');
										$pdf->SetXY(144,$ln);
										$pdf->MultiCell(41,8,"",1,'L');
										
										$pdf->SetFont('Arial','',9);
										$pdf->SetXY(150,247);
										$pdf->Cell(15,10,'Reg 240201-V.04',0,0,'R');
										
									}
									$ln += 8;
										
									$pdf->SetTextColor($cR, $cG, $cB);
									$pdf->SetXY(10,$ln);
									$pdf->MultiCell(20,8,$rowMu['idItem'],1,'C');

									$pdf->SetXY(30,$ln);
									$pdf->SetFont('Arial','B',7);
									$pdf->MultiCell(114,8,"",1,'L');

									$pdf->SetXY(30,$ln);
									$pdf->SetFont('Arial','B',5);
									$pdf->MultiCell(114,4,utf8_decode($rowMu['idMuestra']),0,'L');
							
									$pdf->SetFont('Arial','B',10);
									$pdf->SetXY(144,$ln);
									$pdf->MultiCell(41,8,'',1,'C');
									$pdf->SetTextColor(0,0,0);
								}


					
					}
				}while($rowMu=mysqli_fetch_array($bdMu));
			}
			for($i=$nPp+1;  $i<=27; $i++){
				$ln += 8;
								
				$pdf->SetXY(10,$ln);
				$pdf->MultiCell(20,8,'',1,'C');
						
				$pdf->SetXY(30,$ln);
				$pdf->MultiCell(114,8,"",1,'L');
						
				$pdf->SetXY(144,$ln);
				$pdf->MultiCell(41,8,"",1,'C');
			}
	
			// Pie
/*
			$pdf->SetFont('Arial','',9);
			$pdf->SetXY(150,247);
			$pdf->Cell(15,10,'Reg 2401-Rev.04',0,0,'R');
*/			
			// Fin Pie
		}
		
		// Imprimir Solicitud Servicio a Taller SST
		if($rowRAM['nSolTaller']>0){
			// Encabezado 
			$pdf->AddPage();
			$pdf->SetXY(10,5);
			$pdf->Image('../../imagenes/logonewsimet.jpg',10,5,43,16);
	
			$pdf->SetFont('Arial','B',18);
			$pdf->SetTextColor($cR, $cG, $cB);
			$pdf->SetXY(90,12);
			$pdf->Cell(40,5, utf8_decode('Solicitud servicio a taller N° ') .$rowRAM['nSolTaller'],0,0,'C');
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFont('Arial','',10);
	
			$pdf->SetXY(50,17);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(10,5,'',0,0);
	
			$pdf->SetXY(10,17);
			$pdf->Image('../../gastos/logos/logousach.png',195,5,15,23);
	
			$pdf->SetDrawColor(0, 0, 0);
			$pdf->Image('../../imagenes/logonewsimet.jpg',185,245,20,8);
			
			$pdf->SetXY(197,30);
			$pdf->Cell(30,4,$CAM,0,0,'L');
	
			$pdf->SetDrawColor(200, 200, 200);
			$pdf->Line(190, 30, 190, 270);
			$pdf->SetDrawColor(0, 0, 0);
			// Fin Encabezado
	
			$ln = 25;
			$pdf->SetFont('Arial','B',12);
			$pdf->SetXY(10,$ln);
			$pdf->Cell(10,7,'RAM:',0,0,'L');
			$pdf->SetFont('Arial','B',12);
			$pdf->SetTextColor($cR, $cG, $cB);
			$pdf->SetXY(25,$ln);
			$pdf->Cell(144,7,$RAM,0,0,'L');
			$pdf->SetTextColor(0,0,0);

			$pdf->SetFont('Arial','B',12);
			$pdf->SetXY(140,$ln);
			$pdf->Cell(10,7,'FECHA:',0,0,'L');
			$pdf->SetFont('Arial','B',12);
			$fd = explode('-', $rowRAM['fechaInicio']); 
			$pdf->SetXY(160,$ln);
			$pdf->Cell(15,7,$fd[2].'/'.$fd[1].'/'.$fd[0],0,0,'L');
			$ln += 7;
			$pdf->Line(10, $ln, 184, $ln);

			$ln += 3;
			$pdf->SetFont('Arial','B',12);
			$pdf->SetXY(10,$ln);
			$pdf->Cell(17,7,'Solicitado por:',0,0,'L');
			$sqlUs = "SELECT * FROM Usuarios Where usr = '".$rowRAM['cooResponsable']."'";
			$bdUs=$link->query($sqlUs);
			if($rowUs=mysqli_fetch_array($bdUs)){
				$pdf->SetFont('Arial','B',12);
				$pdf->SetXY(40,$ln);
				$pdf->Cell(144,7,utf8_decode($rowUs['usuario']),0,0,'L');
			}
			$ln += 7;
			$pdf->Line(10, $ln, 184, $ln);

			$nOtam 	  = 0;
			$ultItem  = '';
			$nPagServ = 1;
			$ctlLin   = 0;
			
			
			if($rowRAM['Taller'] == 'on'){
				$SQL = "SELECT * FROM OTAMs Where RAM = '".$RAM."' Order By idItem";
			}else{
				$SQL = "SELECT * FROM OTAMs Where RAM = '".$RAM."' and rTaller = 'on' Order By idItem";
			}
			$SQL = "SELECT * FROM amMuestras Where idItem Like '%".$RAM."%' and Taller = 'on' Order By idItem";
			$bdMu=$link->query($SQL);
			if($rowMu=mysqli_fetch_array($bdMu)){
				do{
					$nOtam++;
					if($nOtam > 4 and $nPagServ == 1){
						$nPagServ++;
						// Imprimir Pie de Otam
						$ln += 1;
						$ctlLin = 0;
						$pdf->SetFont('Arial','B',12);
						$pdf->SetXY(10,$ln);
						$pdf->Cell(17,7,'Observaciones:',0,0,'L');
						$ln += 15;
						$pdf->Line(10, $ln, 184, $ln);
			
						$ln += 1;
						$pdf->SetFont('Arial','B',12);
						$pdf->SetXY(10,$ln);
						$pdf->Cell(100,7,'Fecha de entrega de muestra preparada',0,0,'L');
						$pdf->SetXY(92,$ln);
						$pdf->Cell(10,7,':        /    /',0,0,'L');
						$ln += 7;
						$pdf->Line(10, $ln, 184, $ln);
			
						$ln += 1;
						$pdf->SetFont('Arial','B',12);
						$pdf->SetXY(10,$ln);
						$pdf->Cell(100,7,utf8_decode('Nombre del técnico responsable'),0,0,'L');
						$pdf->SetXY(92,$ln);
						$pdf->Cell(10,7,':',0,0,'L');
						$ln += 7;
						$pdf->Line(10, $ln, 184, $ln);
			
						$ln += 1;
						$pdf->SetFont('Arial','B',12);
						$pdf->SetXY(10,$ln);
						$pdf->Cell(100,7,'Persona que recibe el trabajo',0,0,'L');
						$pdf->SetXY(92,$ln);
						$pdf->Cell(10,7,':',0,0,'L');
						$ln += 7;
						$pdf->Line(10, $ln, 184, $ln);
						
						// Encabezado 
						$pdf->AddPage();
						$pdf->SetXY(10,5);
						$pdf->Image('../../imagenes/logonewsimet.jpg',10,5,43,16);
				
						$pdf->SetFont('Arial','B',18);
						$pdf->SetXY(90,12);
						$pdf->SetTextColor($cR, $cG, $cB);
						$pdf->Cell(40,5,utf8_decode('Solicitud servicio a taller N°').$rowRAM['nSolTaller'],0,0,'C');
						$pdf->SetTextColor(0,0,0);
						$pdf->SetFont('Arial','',10);
				
						$pdf->SetXY(50,17);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(10,5,'',0,0);
				
						$pdf->SetXY(10,17);
						$pdf->Image('../../gastos/logos/logousach.png',195,5,15,23);
				
						$pdf->SetDrawColor(0, 0, 0);
						$pdf->Image('../../imagenes/logonewsimet.jpg',185,245,20,8);
						
						$pdf->SetXY(197,30);
						$pdf->Cell(30,4,$CAM,0,0,'L');
				
						$pdf->SetDrawColor(200, 200, 200);
						$pdf->Line(190, 30, 190, 270);
						$pdf->SetDrawColor(0, 0, 0);
						// Fin Encabezado
	
						$ln = 25;
						
					}

					if($nPagServ > 1){
						// Imprimir Pie de Otam
						if($ctlLin == 5){
							$nPagServ++;
							$ctlLin = 0;
							// Encabezado 
							$pdf->AddPage();
							$pdf->SetXY(10,5);
							$pdf->Image('../../imagenes/logonewsimet.jpg',10,5,43,16);
					
							$pdf->SetFont('Arial','B',18);
							$pdf->SetXY(90,12);
							$pdf->SetTextColor($cR, $cG, $cB);
							$pdf->Cell(40,5, utf8_decode('Solicitud servicio a taller N° ') .$rowRAM['nSolTaller'],0,0,'C');
							$pdf->SetTextColor(0,0,0);
							$pdf->SetFont('Arial','',10);
					
							$pdf->SetXY(50,17);
							$pdf->SetFont('Arial','B',8);
							$pdf->Cell(10,5,'',0,0);
					
							$pdf->SetXY(10,17);
							$pdf->Image('../../gastos/logos/logousach.png',195,5,15,23);
					
							$pdf->SetDrawColor(0, 0, 0);
							$pdf->Image('../../imagenes/logonewsimet.jpg',185,245,20,8);
							
							$pdf->SetXY(197,30);
							$pdf->Cell(30,4,$CAM,0,0,'L');
					
							$pdf->SetDrawColor(200, 200, 200);
							$pdf->Line(190, 30, 190, 270);
							$pdf->SetDrawColor(0, 0, 0);
							// Fin Encabezado
		
							$ln = 25;
						}
					}
					
					if($rowMu['idItem'] != $ultItem){
						$ctlLin++;
						$ultItem = $rowMu['idItem'];
						$ln += 3;
						$pdf->SetFont('Arial','B',12);
						$pdf->SetXY(10,$ln);
						$pdf->Cell(17,7,'Muestras '.$nOtam.':',0,0,'L');
						$pdf->SetFont('Arial','B',12);
						$pdf->SetXY(40,$ln);
						$pdf->SetTextColor($cR, $cG, $cB);
						$pdf->Cell(144,7,$rowMu['idItem'],0,0,'L');
						$pdf->SetTextColor(0,0,0);
						$ln += 7;
						$pdf->Line(10, $ln, 184, $ln);
		
						$ln += 1;
						$pdf->SetFont('Arial','B',12);
						$pdf->SetXY(10,$ln);
						$pdf->Cell(17,7,'Objetivo:',0,0,'L');
						$pdf->SetFont('Arial','B',12);

						$ln += 5;
						$pdf->SetXY(10,$ln);
						$pdf->SetFont('Arial','',8);
						$pdf->MultiCell(180,5,utf8_decode($rowMu['Objetivo']),0,'L');

						$ln += 24;
						$pdf->Line(10, $ln, 184, $ln);
					}else{
						$nOtam--;
					}
				}while($rowMu=mysqli_fetch_array($bdMu));
			}
			if($nOtam <= 4){
				for($i=$nOtam+1;  $i<=4; $i++){
					$ln += 3;
					$pdf->SetFont('Arial','B',12);
					$pdf->SetXY(10,$ln);
					$pdf->Cell(17,7,'Muestra '.$i.':',0,0,'L');
					$pdf->SetFont('Arial','B',12);
					$pdf->SetXY(40,$ln);
					$pdf->Cell(144,7,"",0,0,'L');
					$ln += 7;
					$pdf->Line(10, $ln, 184, $ln);

					$ln += 1;
					$pdf->SetFont('Arial','B',12);
					$pdf->SetXY(10,$ln);
					$pdf->Cell(17,7,'Objetivo:',0,0,'L');
					$pdf->SetFont('Arial','B',12);


					$ln += 5;
					$pdf->SetXY(10,$ln);
					$pdf->SetFont('Arial','',12);
					//$pdf->MultiCell(180,5,utf8_decode($rowMu['Objetivo']),0,'L');

					$ln += 24;
					$pdf->Line(10, $ln, 184, $ln);

				}
				$ln += 1;
				$pdf->SetFont('Arial','B',12);
				$pdf->SetXY(10,$ln);
				$pdf->Cell(17,7,'Observaciones:',0,0,'L');
				$ln += 15;
				$pdf->Line(10, $ln, 184, $ln);
	
				$ln += 1;
				$pdf->SetFont('Arial','B',12);
				$pdf->SetXY(10,$ln);
				$pdf->Cell(100,7,'Fecha de entrega de muestra preparada',0,0,'L');
				$pdf->SetXY(92,$ln);
				$pdf->Cell(10,7,':        /    /',0,0,'L');
				$ln += 7;
				$pdf->Line(10, $ln, 184, $ln);
	
				$ln += 1;
				$pdf->SetFont('Arial','B',12);
				$pdf->SetXY(10,$ln);
				$pdf->Cell(100,7,utf8_decode('Nombre del técnico responsable'),0,0,'L');
				$pdf->SetXY(92,$ln);
				$pdf->Cell(10,7,':',0,0,'L');
				$ln += 7;
				$pdf->Line(10, $ln, 184, $ln);
	
				$ln += 1;
				$pdf->SetFont('Arial','B',12);
				$pdf->SetXY(10,$ln);
				$pdf->Cell(100,7,'Persona que recibe el trabajo',0,0,'L');
				$pdf->SetXY(92,$ln);
				$pdf->Cell(10,7,':',0,0,'L');
				$ln += 7;
				$pdf->Line(10, $ln, 184, $ln);
			}
			if($ctlLin < 5 and $nPagServ > 1){
				for($i=$ctlLin+1;  $i<=5; $i++){
					$nOtam++;
					$ln += 3;
					$pdf->SetFont('Arial','B',12);
					$pdf->SetXY(10,$ln);
					$pdf->Cell(17,7,'Muestra '.$nOtam.':',0,0,'L');
					$pdf->SetFont('Arial','B',12);
					$pdf->SetXY(40,$ln);
					$pdf->Cell(144,7,"",0,0,'L');
					$ln += 7;
					$pdf->Line(10, $ln, 184, $ln);

					$ln += 1;
					$pdf->SetFont('Arial','B',12);
					$pdf->SetXY(10,$ln);
					$pdf->Cell(17,7,'Objetivo:',0,0,'L');
					$pdf->SetFont('Arial','B',12);

					$ln += 5;
					$pdf->SetXY(10,$ln);
					$pdf->SetFont('Arial','',8);
					if(!empty($rowMu['Objetivo'])){
						$pdf->MultiCell(180,5,utf8_decode($rowMu['Objetivo']),0,'L');
					}
					$ln += 24;
					$pdf->Line(10, $ln, 184, $ln);

				}
			}
			
			
			// Pie
			$pdf->SetFont('Arial','',9);
			$pdf->SetXY(150,245);
			$pdf->Cell(15,10,'Reg 2402-V.03',0,0,'R');
			// Fin Pie
		
		}
		//Fin Solicitud Servicio de Taller


		// Imprimir Solicitud Servicio a Taller SST
		if($rowRAM['nSolTaller']>0){
			// Encabezado 
			$pdf->AddPage();
			$pdf->SetXY(10,5);
			$pdf->Image('../../imagenes/logonewsimet.jpg',10,5,43,16);
	
			$pdf->SetFont('Arial','B',18);
			$pdf->SetTextColor($cR, $cG, $cB);
			$pdf->SetXY(90,12);
			$pdf->Cell(40,5,utf8_decode('Solicitud servicio a taller N°').$rowRAM['nSolTaller'],0,0,'C');
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFont('Arial','',10);
	
			$pdf->SetXY(50,17);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(10,5,'',0,0);
	
			$pdf->SetXY(10,17);
			$pdf->Image('../../gastos/logos/logousach.png',195,5,15,23);
	
			$pdf->SetDrawColor(0, 0, 0);
			$pdf->Image('../../imagenes/logonewsimet.jpg',185,245,20,8);
			
			$pdf->SetXY(197,30);
			$pdf->Cell(30,4,$CAM,0,0,'L');
	
			$pdf->SetDrawColor(200, 200, 200);
			$pdf->Line(190, 30, 190, 270);
			$pdf->SetDrawColor(0, 0, 0);
			// Fin Encabezado
	
			$ln = 25;
			$pdf->SetFont('Arial','B',12);
			$pdf->SetXY(10,$ln);
			$pdf->Cell(10,7,'RAM:',0,0,'L');
			$pdf->SetFont('Arial','B',12);
			$pdf->SetTextColor($cR, $cG, $cB);
			$pdf->SetXY(25,$ln);
			$pdf->Cell(144,7,$RAM,0,0,'L');
			$pdf->SetTextColor(0,0,0);

			$pdf->SetFont('Arial','B',12);
			$pdf->SetXY(140,$ln);
			$pdf->Cell(10,7,'FECHA:',0,0,'L');
			$pdf->SetFont('Arial','B',12);
			$fd = explode('-', $rowRAM['fechaInicio']); 
			$pdf->SetXY(160,$ln);
			$pdf->Cell(15,7,$fd[2].'/'.$fd[1].'/'.$fd[0],0,0,'L');
			$ln += 7;
			$pdf->Line(10, $ln, 184, $ln);

			$ln += 3;
			$pdf->SetFont('Arial','B',12);
			$pdf->SetXY(10,$ln);
			$pdf->Cell(17,7,'Solicitado por:',0,0,'L');
			$sqlUs = "SELECT * FROM Usuarios Where usr = '".$rowRAM['cooResponsable']."'";
			$bdUs=$link->query($sqlUs);
			if($rowUs=mysqli_fetch_array($bdUs)){
				$pdf->SetFont('Arial','B',12);
				$pdf->SetXY(40,$ln);
				$pdf->Cell(144,7,utf8_decode($rowUs['usuario']),0,0,'L');
			}
			$ln += 7;
			$pdf->Line(10, $ln, 184, $ln);

			$nOtam 	  = 0;
			$ultItem  = '';
			$nPagServ = 1;
			$ctlLin   = 0;
			if($rowRAM['Taller'] == 'on'){
				$SQL = "SELECT * FROM OTAMs Where RAM = '".$RAM."' Order By idItem";
			}else{
				$SQL = "SELECT * FROM OTAMs Where RAM = '".$RAM."' and rTaller = 'on' Order By idItem";
			}
			$SQL = "SELECT * FROM amMuestras Where idItem Like '%".$RAM."%' and Taller = 'on' Order By idItem";
			$bdMu=$link->query($SQL);
			if($rowMu=mysqli_fetch_array($bdMu)){
				do{
					$nOtam++;
					if($nOtam > 4 and $nPagServ == 1){
						$nPagServ++;
						// Imprimir Pie de Otam
						$ln += 1;
						$ctlLin = 0;
						$pdf->SetFont('Arial','B',12);
						$pdf->SetXY(10,$ln);
						$pdf->Cell(17,7,'Observaciones:',0,0,'L');
						$ln += 15;
						$pdf->Line(10, $ln, 184, $ln);
			
						$ln += 1;
						$pdf->SetFont('Arial','B',12);
						$pdf->SetXY(10,$ln);
						$pdf->Cell(100,7,'Fecha de entrega de muestra preparada',0,0,'L');
						$pdf->SetXY(92,$ln);
						$pdf->Cell(10,7,':        /    /',0,0,'L');
						$ln += 7;
						$pdf->Line(10, $ln, 184, $ln);
			
						$ln += 1;
						$pdf->SetFont('Arial','B',12);
						$pdf->SetXY(10,$ln);
						$pdf->Cell(100,7,utf8_decode('Nombre del técnico responsable'),0,0,'L');
						$pdf->SetXY(92,$ln);
						$pdf->Cell(10,7,':',0,0,'L');
						$ln += 7;
						$pdf->Line(10, $ln, 184, $ln);
			
						$ln += 1;
						$pdf->SetFont('Arial','B',12);
						$pdf->SetXY(10,$ln);
						$pdf->Cell(100,7,'Persona que recibe el trabajo',0,0,'L');
						$pdf->SetXY(92,$ln);
						$pdf->Cell(10,7,':',0,0,'L');
						$ln += 7;
						$pdf->Line(10, $ln, 184, $ln);
						
						// Encabezado 
						$pdf->AddPage();
						$pdf->SetXY(10,5);
						$pdf->Image('../../imagenes/logonewsimet.jpg',10,5,43,16);
				
						$pdf->SetFont('Arial','B',18);
						$pdf->SetXY(90,12);
						$pdf->SetTextColor($cR, $cG, $cB);
						$pdf->Cell(40,5,utf8_decode('Solicitud servicio a taller N°').$rowRAM['nSolTaller'],0,0,'C');
						$pdf->SetTextColor(0,0,0);
						$pdf->SetFont('Arial','',10);
				
						$pdf->SetXY(50,17);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(10,5,'',0,0);
				
						$pdf->SetXY(10,17);
						$pdf->Image('../../gastos/logos/logousach.png',195,5,15,23);
				
						$pdf->SetDrawColor(0, 0, 0);
						$pdf->Image('../../imagenes/logonewsimet.jpg',185,245,20,8);
						
						$pdf->SetXY(197,30);
						$pdf->Cell(30,4,$CAM,0,0,'L');
				
						$pdf->SetDrawColor(200, 200, 200);
						$pdf->Line(190, 30, 190, 270);
						$pdf->SetDrawColor(0, 0, 0);
						// Fin Encabezado
	
						$ln = 25;
						
					}

					if($nPagServ > 1){
						// Imprimir Pie de Otam
						if($ctlLin == 5){
							$nPagServ++;
							$ctlLin = 0;
							// Encabezado 
							$pdf->AddPage();
							$pdf->SetXY(10,5);
							$pdf->Image('../../imagenes/logonewsimet.jpg',10,5,43,16);
					
							$pdf->SetFont('Arial','B',18);
							$pdf->SetXY(90,12);
							$pdf->SetTextColor($cR, $cG, $cB);
							$pdf->Cell(40,5,utf8_decode('Solicitud servicio a taller N°').$rowRAM['nSolTaller'],0,0,'C');
							$pdf->SetTextColor(0,0,0);
							$pdf->SetFont('Arial','',10);
					
							$pdf->SetXY(50,17);
							$pdf->SetFont('Arial','B',8);
							$pdf->Cell(10,5,'',0,0);
					
							$pdf->SetXY(10,17);
							$pdf->Image('../../gastos/logos/logousach.png',195,5,15,23);
					
							$pdf->SetDrawColor(0, 0, 0);
							$pdf->Image('../../imagenes/logonewsimet.jpg',185,245,20,8);
							
							$pdf->SetXY(197,30);
							$pdf->Cell(30,4,$CAM,0,0,'L');
					
							$pdf->SetDrawColor(200, 200, 200);
							$pdf->Line(190, 30, 190, 270);
							$pdf->SetDrawColor(0, 0, 0);
							// Fin Encabezado
		
							$ln = 25;
						}
					}
					
					if($rowMu['idItem'] != $ultItem){
						$ctlLin++;
						$ultItem = $rowMu['idItem'];
						$ln += 3;
						$pdf->SetFont('Arial','B',12);
						$pdf->SetXY(10,$ln);
						$pdf->Cell(17,7,'Muestra '.$nOtam.':',0,0,'L');
						$pdf->SetFont('Arial','B',12);
						$pdf->SetXY(40,$ln);
						$pdf->SetTextColor($cR, $cG, $cB);
						$pdf->Cell(144,7,$rowMu['idItem'],0,0,'L');
						$pdf->SetTextColor(0,0,0);
						$ln += 7;
						$pdf->Line(10, $ln, 184, $ln);
		
						$ln += 1;
						$pdf->SetFont('Arial','B',12);
						$pdf->SetXY(10,$ln);
						$pdf->Cell(17,7,'Objetivo:',0,0,'L');
						$pdf->SetFont('Arial','B',12);

						$ln += 5;
						$pdf->SetXY(10,$ln);
						$pdf->SetFont('Arial','',8);
						$pdf->MultiCell(180,5,utf8_decode($rowMu['Objetivo']),0,'L');

						$ln += 24;
						$pdf->Line(10, $ln, 184, $ln);
					}else{
						$nOtam--;
					}
				}while($rowMu=mysqli_fetch_array($bdMu));
			}
			if($nOtam <= 4){
				for($i=$nOtam+1;  $i<=4; $i++){
					$ln += 3;
					$pdf->SetFont('Arial','B',12);
					$pdf->SetXY(10,$ln);
					$pdf->Cell(17,7,'Muestra '.$i.':',0,0,'L');
					$pdf->SetFont('Arial','B',12);
					$pdf->SetXY(40,$ln);
					$pdf->Cell(144,7,"",0,0,'L');
					$ln += 7;
					$pdf->Line(10, $ln, 184, $ln);

					$ln += 1;
					$pdf->SetFont('Arial','B',12);
					$pdf->SetXY(10,$ln);
					$pdf->Cell(17,7,'Objetivo:',0,0,'L');
					$pdf->SetFont('Arial','B',12);

					$ln += 5;
					$pdf->SetXY(10,$ln);
					$pdf->SetFont('Arial','',12);
					//$pdf->MultiCell(180,5,$rowMu['Objetivo'],0,'L');

					$ln += 24;
					$pdf->Line(10, $ln, 184, $ln);

				}
				$ln += 1;
				$pdf->SetFont('Arial','B',12);
				$pdf->SetXY(10,$ln);
				$pdf->Cell(17,7,'Observaciones:',0,0,'L');
				$ln += 15;
				$pdf->Line(10, $ln, 184, $ln);
	
				$ln += 1;
				$pdf->SetFont('Arial','B',12);
				$pdf->SetXY(10,$ln);
				$pdf->Cell(100,7,'Fecha de entrega de muestra preparada',0,0,'L');
				$pdf->SetXY(92,$ln);
				$pdf->Cell(10,7,':        /    /',0,0,'L');
				$ln += 7;
				$pdf->Line(10, $ln, 184, $ln);
	
				$ln += 1;
				$pdf->SetFont('Arial','B',12);
				$pdf->SetXY(10,$ln);
				$pdf->Cell(100,7,utf8_decode('Nombre del técnico responsable'),0,0,'L');
				$pdf->SetXY(92,$ln);
				$pdf->Cell(10,7,':',0,0,'L');
				$ln += 7;
				$pdf->Line(10, $ln, 184, $ln);
	
				$ln += 1;
				$pdf->SetFont('Arial','B',12);
				$pdf->SetXY(10,$ln);
				$pdf->Cell(100,7,'Persona que recibe el trabajo',0,0,'L');
				$pdf->SetXY(92,$ln);
				$pdf->Cell(10,7,':',0,0,'L');
				$ln += 7;
				$pdf->Line(10, $ln, 184, $ln);
			}
			if($ctlLin < 5 and $nPagServ > 1){
				for($i=$ctlLin+1;  $i<=5; $i++){
					$nOtam++;
					$ln += 3;
					$pdf->SetFont('Arial','B',12);
					$pdf->SetXY(10,$ln);
					$pdf->Cell(17,7,'Muestra '.$nOtam.':',0,0,'L');
					$pdf->SetFont('Arial','B',12);
					$pdf->SetXY(40,$ln);
					$pdf->Cell(144,7,"",0,0,'L');
					$ln += 7;
					$pdf->Line(10, $ln, 184, $ln);

					$ln += 1;
					$pdf->SetFont('Arial','B',12);
					$pdf->SetXY(10,$ln);
					$pdf->Cell(17,7,'Objetivo:',0,0,'L');
					$pdf->SetFont('Arial','B',12);
//					$pdf->SetXY(40,$ln);
//					$pdf->Cell(144,7,$rowMu[idItem],0,0,'L');
					$ln += 30;
					$pdf->Line(10, $ln, 184, $ln);

				}
			}
			
			
			// Pie
			$pdf->SetFont('Arial','',9);
			$pdf->SetXY(150,245);
			$pdf->Cell(15,10,'Reg 2402-V.03',0,0,'R');
			// Fin Pie
		
		}
		//Fin Solicitud Servicio de Taller Copia


		
		//Imprimir Otam Tracción
		$nPag = 0;
		$nTra = 5;

		/* +++ */
		$SQLMm = "SELECT * FROM amMuestras Where idItem Like '%".$RAM."%' and conEnsayo != 'off' Order By idItem";
		$bdMm=$link->query($SQLMm);
		if($rowMm=mysqli_fetch_array($bdMm)){
			do{

				$Otam = $RAM;
				$SQL = "SELECT * FROM OTAMs Where RAM = '".$RAM."' and Otam Like '%".$Otam."%' and idItem = '".$rowMm['idItem']."' and idEnsayo = 'Tr' Order By idItem";
				$bdMu=$link->query($SQL);
				if($rowMu=mysqli_fetch_array($bdMu)){
					do{
						if($nTra >= 5){
							$nPag++;
							$nTra = 0;
							// Encabezado 
							$pdf->AddPage();
							$pdf->SetXY(10,5);
							$pdf->Image('../../imagenes/logonewsimet.jpg',10,5,43,16);
								
							$pdf->SetFont('Arial','B',18);
							$pdf->SetXY(90,12);
							$pdf->SetTextColor($cR, $cG, $cB);
							$pdf->Cell(40,5,'OTAM-'.$RAM.'-T',0,0,'C');
							$pdf->SetTextColor(0,0,0);
							$pdf->SetFont('Arial','',10);
								
							$pdf->SetXY(50,17);
							$pdf->SetFont('Arial','B',8);
							$pdf->Cell(10,5,'',0,0);
								
							$pdf->SetXY(10,17);
							$pdf->Image('../../gastos/logos/logousach.png',195,5,15,23);
								
							$pdf->SetDrawColor(0, 0, 0);
							$pdf->Image('../../imagenes/logonewsimet.jpg',185,245,20,8);
										
							$pdf->SetXY(197,30);
							$pdf->Cell(30,4,$CAM,0,0,'L');
								
							$pdf->SetDrawColor(200, 200, 200);
							$pdf->Line(190, 30, 190, 270);
							$pdf->SetDrawColor(0, 0, 0);
							// Fin Encabezado
		
							$ln = 5;
							
							// Pie
							$pdf->SetFont('Arial','B',10);
							$pdf->SetXY(10,220);
							$pdf->Cell(30,4,utf8_decode('Técnico responsable'),0,0,'L');
					
							$pdf->SetXY(100,220);
							$pdf->Cell(30,4,'Solicitante',0,0,'L');
					
							$pdf->SetXY(10,225);
							$pdf->Cell(15,10,"",1,0,'C');
							$pdf->Cell(15,10,"",1,0,'C');
							$pdf->Cell(15,10,"",1,0,'C');
					
							$pdf->SetXY(100,225);
							$pdf->Cell(15,10,utf8_decode(substr($rowRAM['cooResponsable'],0,1)),1,0,'C');
							$pdf->Cell(15,10,utf8_decode(substr($rowRAM['cooResponsable'],1,1)),1,0,'C');
							$pdf->Cell(15,10,utf8_decode(substr($rowRAM['cooResponsable'],2,1)),1,0,'C');
		
							$pdf->SetFont('Arial','',9);
							$pdf->SetXY(150,245);
							$pdf->Cell(15,10,'Reg 240201-V.04',0,0,'R');
							// Fin Pie
						}
						
						if($nPag >= 1) { $ln += 18; }
						$nTra++;
							
						$lnTxt = "IDENTIFICACIÓN ";
						$pdf->SetFont('Arial','B',11);
						$pdf->SetXY(10,$ln); 
						$pdf->Cell(50,5,utf8_decode($lnTxt),0,0,'C');
						$pdf->SetXY(10,$ln);
						$pdf->MultiCell(50,5,"",1,'L');
					
						$lnTxt = "DIMENSIONES";
						$pdf->SetXY(60,$ln);
						$pdf->Cell(50,5,$lnTxt,0,0,'C');
						$pdf->SetXY(60,$ln);
						$pdf->MultiCell(50,5,"",1,'L');
		
						$lnTxt = "RESULTADOS";
						$pdf->SetXY(110,$ln);
						$pdf->Cell(75,5,$lnTxt,0,0,'C');
						$pdf->SetXY(110,$ln);
						$pdf->MultiCell(75,5,"",1,'L');
							
						$ln += 5;
						$lnTxt = $rowMu['Otam'];
						$pdf->SetXY(10,$ln);
						$pdf->SetTextColor($cR, $cG, $cB);
						$pdf->MultiCell(50,5,$lnTxt,1,'C');
						$pdf->SetTextColor(0,0,0);
		
						$pdf->SetFont('Arial','',8);;
						$lnTxt = 'Diámetro(mm)';
						$pdf->SetXY(60,$ln);
						$pdf->MultiCell(25,5,utf8_decode($lnTxt),1,'L');
						$lnTxt = '';
						$pdf->SetXY(85,$ln);
						$pdf->MultiCell(25,5,$lnTxt,1,'L');
	
						$pdf->SetFont('Arial','',6,9);;
						$lnTxt = 'Fluencia(MPa)';
						$pdf->SetXY(110,$ln);
						$pdf->MultiCell(18,5,$lnTxt,1,'L');
						$lnTxt = '';
						$pdf->SetXY(110,$ln);
						$pdf->MultiCell(18,5,$lnTxt,1,'L');
		
						$pdf->SetFont('Arial','',8);
						$lnTxt = '';
						$pdf->SetXY(128,$ln);
						$pdf->MultiCell(19,5,$lnTxt,1,'L');
		
						$lnTxt = 'Z(%)';
						$pdf->SetXY(147,$ln);
						$pdf->MultiCell(15,5,$lnTxt,1,'L');
						$lnTxt = '';
						$pdf->SetXY(147,$ln);
						$pdf->MultiCell(15,5,$lnTxt,1,'L');
							
						$lnTxt = '';
						$pdf->SetXY(162,$ln);
						$pdf->MultiCell(23,5,$lnTxt,1,'L');
		
						$ln += 5;
						$pdf->SetFont('Arial','B',11);
						$lnTxt = 'FECHA';
						$pdf->SetXY(10,$ln);
						$pdf->MultiCell(50,5,$lnTxt,1,'C');
						$pdf->SetFont('Arial','',8);;;;;;;;
							
						$lnTxt = 'Espesor(mm)';
						$pdf->SetXY(60,$ln);
						$pdf->MultiCell(25,5,$lnTxt,1,'L');
						$lnTxt = '';
						$pdf->SetXY(85,$ln);
						$pdf->MultiCell(25,5,$lnTxt,1,'L');
		
						$lnTxt = 'UTS(MPa)';
						$pdf->SetXY(110,$ln);
						$pdf->MultiCell(18,5,$lnTxt,1,'L');
						$lnTxt = '';
						$pdf->SetXY(110,$ln);
						$pdf->MultiCell(18,5,$lnTxt,1,'L');
		
						$lnTxt = '';
						$pdf->SetXY(128,$ln);
						$pdf->MultiCell(19,5,$lnTxt,1,'L');
		
						$pdf->SetFont('Arial','',7);;
						$lnTxt = 'Temp.(°C)';
						$pdf->SetXY(147,$ln);
						$pdf->MultiCell(15,5, utf8_decode($lnTxt),1,'L');
						$lnTxt = '';
						$pdf->SetXY(147,$ln);
						$pdf->MultiCell(15,5, utf8_decode($lnTxt),1,'L');
							
						$pdf->SetFont('Arial','',8);
						$lnTxt = '';
						$pdf->SetXY(162,$ln);
						$pdf->MultiCell(23,5,$lnTxt,1,'L');
		
						$ln += 5;
						$lnTxt = '';
						$pdf->SetXY(10,$ln);
						$pdf->MultiCell(50,5,$lnTxt,1,'C');
		
						$lnTxt = 'Ancho(mm)';
						$pdf->SetXY(60,$ln);
						$pdf->MultiCell(25,5,$lnTxt,1,'L');
						$lnTxt = '';
						$pdf->SetXY(85,$ln);
						$pdf->MultiCell(25,5,$lnTxt,1,'L');
		
						$lnTxt = 'A(%)';
						$pdf->SetXY(110,$ln);
						$pdf->MultiCell(18,5,$lnTxt,1,'L');
						$lnTxt = '';
						$pdf->SetXY(110,$ln);
						$pdf->MultiCell(18,5,$lnTxt,1,'L');
		
						$lnTxt = '';
						$pdf->SetXY(128,$ln);
						$pdf->MultiCell(19,5,$lnTxt,1,'L');
		
						$lnTxt = 'Hum.(%)';
						$pdf->SetXY(147,$ln);
						$pdf->MultiCell(15,5,$lnTxt,1,'L');
						$lnTxt = '';
						$pdf->SetXY(147,$ln);
						$pdf->MultiCell(15,5,$lnTxt,1,'L');
						
						$lnTxt = '';
						$pdf->SetXY(162,$ln);
						$pdf->MultiCell(23,5,$lnTxt,1,'L');
	
						$ln += 5;
						$lnTxt = 'OBSERVACIONES';
						$pdf->SetXY(10,$ln);
						$pdf->Cell(10,5,$lnTxt,0,0,'L');
						$pdf->SetXY(10,$ln);
						$pdf->MultiCell(175,13,"",1,'C');
						
					}while($rowMu=mysqli_fetch_array($bdMu));

				}
			}while($rowMm=mysqli_fetch_array($bdMm));


					for($i=$nTra+1;  $i<=5; $i++){
							$ln += 18;
							$lnTxt = "IDENTIFICACIÓN ";
							$pdf->SetFont('Arial','B',11);
							$pdf->SetXY(10,$ln); 
							$pdf->Cell(50,5,utf8_decode($lnTxt),0,0,'C');
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(50,5,"",1,'L');
					
							$lnTxt = "DIMENSIONES";
							$pdf->SetXY(60,$ln);
							$pdf->Cell(50,5,$lnTxt,0,0,'C');
							$pdf->SetXY(60,$ln);
							$pdf->MultiCell(50,5,"",1,'L');
		
							$lnTxt = "RESULTADOS";
							$pdf->SetXY(110,$ln);
							$pdf->Cell(75,5,$lnTxt,0,0,'C');
							$pdf->SetXY(110,$ln);
							$pdf->MultiCell(75,5,"",1,'L');
							
							$ln += 5;
							$lnTxt = '__-T-__';
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(50,5,$lnTxt,1,'C');
		
							$pdf->SetFont('Arial','',8);
							$lnTxt = 'Diámetro(mm)';
							$pdf->SetXY(60,$ln);
							$pdf->MultiCell(25,5,utf8_decode($lnTxt),1,'L');
							$lnTxt = '';
							$pdf->SetXY(85,$ln);
							$pdf->MultiCell(25,5,$lnTxt,1,'L');
		
							$pdf->SetFont('Arial','',6,9);;
							$lnTxt = 'Fluencia(MPa)';
							$pdf->SetXY(110,$ln);
							$pdf->MultiCell(18,5,$lnTxt,1,'L');
							$lnTxt = '';
							$pdf->SetXY(110,$ln);
							$pdf->MultiCell(18,5,$lnTxt,1,'L');
							$pdf->SetFont('Arial','',8);

							$lnTxt = '';
							$pdf->SetXY(128,$ln);
							$pdf->MultiCell(19,5,$lnTxt,1,'L');
		
							$lnTxt = 'Z(%)';
							$pdf->SetXY(147,$ln);
							$pdf->MultiCell(15,5,$lnTxt,1,'L');
							$lnTxt = '';
							$pdf->SetXY(147,$ln);
							$pdf->MultiCell(15,5,$lnTxt,1,'L');
							
							$lnTxt = '';
							$pdf->SetXY(162,$ln);
							$pdf->MultiCell(23,5,$lnTxt,1,'L');
							
							$ln += 5;
							$lnTxt = '';
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(50,5,$lnTxt,1,'C');
		
							$lnTxt = 'Espesor(mm)';
							$pdf->SetXY(60,$ln);
							$pdf->MultiCell(25,5,$lnTxt,1,'L');
							$lnTxt = '';
							$pdf->SetXY(85,$ln);
							$pdf->MultiCell(25,5,$lnTxt,1,'L');
		
							$lnTxt = 'UTS(MPa)';
							$pdf->SetXY(110,$ln);
							$pdf->MultiCell(18,5,$lnTxt,1,'L');
							$lnTxt = '';
							$pdf->SetXY(110,$ln);
							$pdf->MultiCell(18,5,$lnTxt,1,'L');
		
							$lnTxt = '';
							$pdf->SetXY(128,$ln);
							$pdf->MultiCell(19,5,$lnTxt,1,'L');
		
							$pdf->SetFont('Arial','',7);;
							$lnTxt = 'Temp.(°C)';
							$pdf->SetXY(147,$ln);
							$pdf->MultiCell(15,5, utf8_decode($lnTxt),1,'L');
							$lnTxt = '';
							$pdf->SetXY(147,$ln);
							$pdf->MultiCell(15,5, utf8_decode($lnTxt),1,'L');
							
							$pdf->SetFont('Arial','',8);
							$lnTxt = '';
							$pdf->SetXY(162,$ln);
							$pdf->MultiCell(23,5,$lnTxt,1,'L');
		
							$ln += 5;
							$lnTxt = '';
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(50,5,$lnTxt,1,'C');
		
							$lnTxt = 'Ancho(mm)';
							$pdf->SetXY(60,$ln);
							$pdf->MultiCell(25,5,$lnTxt,1,'L');
							$lnTxt = '';
							$pdf->SetXY(85,$ln);
							$pdf->MultiCell(25,5,$lnTxt,1,'L');
		
							$lnTxt = 'A(%)';
							$pdf->SetXY(110,$ln);
							$pdf->MultiCell(18,5,$lnTxt,1,'L');
							$lnTxt = '';
							$pdf->SetXY(110,$ln);
							$pdf->MultiCell(18,5,$lnTxt,1,'L');
		
							$lnTxt = '';
							$pdf->SetXY(128,$ln);
							$pdf->MultiCell(19,5,$lnTxt,1,'L');
		
							$lnTxt = 'Hum.(%)';
							$pdf->SetXY(147,$ln);
							$pdf->MultiCell(15,5,$lnTxt,1,'L');
							$lnTxt = '';
							$pdf->SetXY(147,$ln);
							$pdf->MultiCell(15,5,$lnTxt,1,'L');
							
							$lnTxt = '';
							$pdf->SetXY(162,$ln);
							$pdf->MultiCell(23,5,$lnTxt,1,'L');
		
							$ln += 5;
							$lnTxt = 'OBSERVACIONES';
							$pdf->SetXY(10,$ln);
							$pdf->Cell(10,5,$lnTxt,0,0,'L');
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(175,13,"",1,'C');
					}
		}
		
		//Fin Imprimir Otam Tracción

		//Imprimir Otam Dureza
				$nPag = 0;
				$nDur = 5;

		/* ++++ */
		$SQLMm = "SELECT * FROM amMuestras Where idItem Like '%".$RAM."%' and conEnsayo != 'off' Order By idItem";
		$bdMm=$link->query($SQLMm);
		if($rowMm=mysqli_fetch_array($bdMm)){
			do{

				$Sw	  = false;
				$Otam = $RAM;
				$SQL = "SELECT * FROM OTAMs Where RAM = '".$RAM."' and idEnsayo = 'Du' and idItem = '".$rowMm['idItem']."' Order By idItem";
				$bdMu=$link->query($SQL);
				if($rowMu=mysqli_fetch_array($bdMu)){
					do{
						if($nDur == 5){
							$nPag++;
							$nDur = 0;
							$Sw   = true;
							
							// Encabezado 
							$pdf->AddPage();
							$pdf->SetXY(10,5);
							$pdf->Image('../../imagenes/logonewsimet.jpg',10,5,43,16);
								
							$pdf->SetFont('Arial','B',18);
							$pdf->SetXY(90,12);
							$pdf->SetTextColor($cR, $cG, $cB);
							$pdf->Cell(40,5,'OTAM-'.$RAM.'-D',0,0,'C');
							$pdf->SetTextColor(0,0,0);
							$pdf->SetFont('Arial','',10);
								
							$pdf->SetXY(50,17);
							$pdf->SetFont('Arial','B',8);
							$pdf->Cell(10,5,'',0,0);
								
							$pdf->SetXY(10,17);
							$pdf->Image('../../gastos/logos/logousach.png',195,5,15,23);
								
							$pdf->SetDrawColor(0, 0, 0);
							$pdf->Image('../../imagenes/logonewsimet.jpg',185,245,20,8);
										
							$pdf->SetXY(197,30);
							$pdf->Cell(30,4,$CAM,0,0,'L');
								
							$pdf->SetDrawColor(200, 200, 200);
							$pdf->Line(190, 30, 190, 270);
							$pdf->SetDrawColor(0, 0, 0);
							// Fin Encabezado
		
							$ln = 5;
							
							// Pie

							
							$pdf->SetFont('Arial','B',10);
							$pdf->SetXY(10,220);
							$pdf->Cell(30,4, utf8_decode('Técnico responsable') ,0,0,'L');
					
							$pdf->SetXY(100,220);
							$pdf->Cell(30,4,'Solicitante',0,0,'L');
					
							$pdf->SetXY(10,225);
							$pdf->Cell(15,10,"",1,0,'C');
							$pdf->Cell(15,10,"",1,0,'C');
							$pdf->Cell(15,10,"",1,0,'C');
					
							$pdf->SetXY(100,225);
							$pdf->Cell(15,10,utf8_decode(substr($rowRAM['cooResponsable'],0,1)),1,0,'C');
							$pdf->Cell(15,10,utf8_decode(substr($rowRAM['cooResponsable'],1,1)),1,0,'C');
							$pdf->Cell(15,10,utf8_encode(substr($rowRAM['cooResponsable'],2,1)),1,0,'C');
							

							$pdf->SetFont('Arial','',9);
							$pdf->SetXY(150,245);
							$pdf->Cell(15,10,'Reg 240302-V.05',0,0,'R');
							// Fin Pie
						}
							if($nPag >= 1) { $ln += 18; }
							$nDur++;
							
							if($Sw == true) {
								$pdf->SetFont('Arial','B',11);
								$pdf->SetXY(10,$ln);
								$pdf->Cell(30,4,utf8_decode('N° de Probetas:'),0,0,'L');
								$ln += 5;
								$Sw = false;
							}
							
							$lnTxt = "ID";
							$pdf->SetFont('Arial','B',11);
							$pdf->SetXY(10,$ln); 
							$pdf->Cell(25,5,$lnTxt,0,0,'C');
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(25,5,"",1,'L');
		
							$pdf->SetXY(35,$ln);
							$pdf->SetTextColor($cR, $cG, $cB);
							$pdf->MultiCell(30,5,$rowMu['Otam'],1,'C');
							$pdf->SetTextColor(0,0,0);
		
							$pdf->SetXY(65,$ln);
							$pdf->MultiCell(50,5,"RESULTADOS",1,'C');
		
							$pdf->SetXY(115,$ln);
							$pdf->MultiCell(70,5,"DIAGRAMA DE PIEZA",1,'C');
		
							$ln += 5;
							$pdf->SetFont('Arial','',11);
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(25,5,"FECHA",1,'C');
							$pdf->SetXY(35,$ln);
							$pdf->MultiCell(30,5,"",1,'C');
		
							$pdf->SetXY(65,$ln);
							$pdf->MultiCell(10,5,"A",1,'C');
							$pdf->SetXY(75,$ln);
							$pdf->MultiCell(15,5,"",1,'C');
							$pdf->SetXY(90,$ln);
							$pdf->MultiCell(10,5,"D",1,'C');
							$pdf->SetXY(100,$ln);
							$pdf->MultiCell(15,5,"",1,'C');
		
							$pdf->SetXY(115,$ln);
							$pdf->MultiCell(70,25,"",1,'C');
		
							$ln += 5;
							$pdf->SetFont('Arial','',11);
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(25,5, utf8_decode("T(°C)"),1,'C');
							$pdf->SetXY(35,$ln);
							$pdf->MultiCell(30,5,"",1,'C');
		
							$pdf->SetXY(65,$ln);
							$pdf->MultiCell(10,5,"B",1,'C');
							$pdf->SetXY(75,$ln);
							$pdf->MultiCell(15,5,"",1,'C');
							$pdf->SetXY(90,$ln);
							$pdf->MultiCell(10,5,"E",1,'C');
							$pdf->SetXY(100,$ln);
							$pdf->MultiCell(15,5,"",1,'C');
		
							$ln += 5;
							$pdf->SetFont('Arial','',11);
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(25,5,"H(%)",1,'C');
							$pdf->SetXY(35,$ln);
							$pdf->MultiCell(30,5,"",1,'C');
		
							$pdf->SetXY(65,$ln);
							$pdf->MultiCell(10,5,"C",1,'C');
							$pdf->SetXY(75,$ln);
							$pdf->MultiCell(15,5,"",1,'C');
							$pdf->SetXY(90,$ln);
							$pdf->MultiCell(10,5,"F",1,'C');
							$pdf->SetXY(100,$ln);
							$pdf->MultiCell(15,5,"",1,'C');
		
							$ln += 5;
							$lnTxt = 'ESCALA DE MEDICIÓN';
							$pdf->SetXY(10,$ln);
							$pdf->Cell(105,5, utf8_decode($lnTxt),1,0,'C');
							$ln += 5;
							$pdf->SetXY(10,$ln);
							$pdf->Cell(10,5,"HRC",1,0,'C');
							$pdf->Cell(5,5,"",1,0,'C');
							$pdf->Cell(10,5,"HRB",1,0,'C');
							$pdf->Cell(5,5,"",1,0,'C');
							$pdf->Cell(10,5,"HRW",1,0,'C');
							$pdf->Cell(20,5,"__/____",1,0,'C');
							$pdf->Cell(15,5,"OTRA",1,0,'C');
							$pdf->Cell(30,5,"",1,0,'C');
					}while($rowMu=mysqli_fetch_array($bdMu));
				}

			}while($rowMm=mysqli_fetch_array($bdMm));
					for($i=$nDur+1;  $i<=4; $i++){
		
							$ln += 18;
							$lnTxt = "ID";
							$pdf->SetFont('Arial','B',11);
							$pdf->SetXY(10,$ln); 
							$pdf->Cell(25,5,$lnTxt,0,0,'C');
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(25,5,"",1,'L');
		
							$pdf->SetXY(35,$ln);
							$pdf->MultiCell(30,5,"____-D__",1,'C');
		
							$pdf->SetXY(65,$ln);
							$pdf->MultiCell(50,5,"RESULTADOS",1,'C');
		
							$pdf->SetXY(115,$ln);
							$pdf->MultiCell(70,5,"DIAGRAMA DE PIEZA",1,'C');
		
							$ln += 5;
							$pdf->SetFont('Arial','',11);
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(25,5,"FECHA",1,'C');
							$pdf->SetXY(35,$ln);
							$pdf->MultiCell(30,5,"",1,'C');
		
							$pdf->SetXY(65,$ln);
							$pdf->MultiCell(10,5,"A",1,'C');
							$pdf->SetXY(75,$ln);
							$pdf->MultiCell(15,5,"",1,'C');
							$pdf->SetXY(90,$ln);
							$pdf->MultiCell(10,5,"D",1,'C');
							$pdf->SetXY(100,$ln);
							$pdf->MultiCell(15,5,"",1,'C');
		
							$pdf->SetXY(115,$ln);
							$pdf->MultiCell(70,25,"",1,'C');
		
							$ln += 5;
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(25,5,utf8_decode("T(°C)"),1,'C');
							$pdf->SetXY(35,$ln);
							$pdf->MultiCell(30,5,"",1,'C');
		
							$pdf->SetXY(65,$ln);
							$pdf->MultiCell(10,5,"B",1,'C');
							$pdf->SetXY(75,$ln);
							$pdf->MultiCell(15,5,"",1,'C');
							$pdf->SetXY(90,$ln);
							$pdf->MultiCell(10,5,"E",1,'C');
							$pdf->SetXY(100,$ln);
							$pdf->MultiCell(15,5,"",1,'C');
		
							$ln += 5;
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(25,5,"H(%)",1,'C');
							$pdf->SetXY(35,$ln);
							$pdf->MultiCell(30,5,"",1,'C');
		
							$pdf->SetXY(65,$ln);
							$pdf->MultiCell(10,5,"C",1,'C');
							$pdf->SetXY(75,$ln);
							$pdf->MultiCell(15,5,"",1,'C');
							$pdf->SetXY(90,$ln);
							$pdf->MultiCell(10,5,"F",1,'C');
							$pdf->SetXY(100,$ln);
							$pdf->MultiCell(15,5,"",1,'C');
		
							$ln += 5;
							$lnTxt = 'ESCALA DE MEDICIÓN';
							$pdf->SetXY(10,$ln);
							$pdf->Cell(105,5, utf8_decode($lnTxt),1,0,'C');
							$ln += 5;
							$pdf->SetXY(10,$ln);
							$pdf->Cell(10,5,"HRC",1,0,'C');
							$pdf->Cell(5,5,"",1,0,'C');
							$pdf->Cell(10,5,"HRB",1,0,'C');
							$pdf->Cell(5,5,"",1,0,'C');
							$pdf->Cell(10,5,"HRW",1,0,'C');
							$pdf->Cell(20,5,"__/____",1,0,'C');
							$pdf->Cell(15,5,"OTRA",1,0,'C');
							$pdf->Cell(30,5,"",1,0,'C');
					}
		}
		
		//Fin Imprimir Otam Dureza


		//Imprimir Otam Químico
		/* ++++ */

		$nPag = 0;
		$nQui = 5;
		$SQLMm = "SELECT * FROM amMuestras Where idItem Like '%".$RAM."%' and conEnsayo != 'off' Order By idItem";
		$bdMm=$link->query($SQLMm);
		if($rowMm=mysqli_fetch_array($bdMm)){
			do{

				$Sw	  = false;
				
				$Otam = $RAM;
				$SQL = "SELECT * FROM OTAMs Where RAM = '".$RAM."' and Otam Like '%".$Otam."%' and idItem = '".$rowMm['idItem']."'  and idEnsayo = 'Qu' Order By idItem";
				$bdMu=$link->query($SQL);
				if($rowMu=mysqli_fetch_array($bdMu)){
					do{
						if($nQui >= 5){
							$nPag++;
							$nQui = 0;
							$Sw   = true;
							// Encabezado 
							$pdf->AddPage();
							$pdf->SetXY(10,5);
							$pdf->Image('../../imagenes/logonewsimet.jpg',10,5,43,16);
								
							$pdf->SetFont('Arial','B',18);
							$pdf->SetXY(90,12);
							$pdf->SetTextColor($cR, $cG, $cB);
							$pdf->Cell(40,5,'OTAM-'.$RAM.'-Q',0,0,'C');
							$pdf->SetTextColor(0,0,0);
							$pdf->SetFont('Arial','',10);
								
							$pdf->SetXY(50,17);
							$pdf->SetFont('Arial','B',8);
							$pdf->Cell(10,5,'',0,0);
								
							$pdf->SetXY(10,17);
							$pdf->Image('../../gastos/logos/logousach.png',195,5,15,23);
								
							$pdf->SetDrawColor(0, 0, 0);
							$pdf->Image('../../imagenes/logonewsimet.jpg',185,245,20,8);
										
							$pdf->SetXY(197,30);
							$pdf->Cell(30,4,$CAM,0,0,'L');
								
							$pdf->SetDrawColor(200, 200, 200);
							$pdf->Line(190, 30, 190, 270);
							$pdf->SetDrawColor(0, 0, 0);
							// Fin Encabezado
		
							$ln = 5;
							
							// Pie
							$pdf->SetFont('Arial','B',10);
							$pdf->SetXY(10,220);
							$pdf->Cell(30,4,utf8_decode('Técnico responsable'),0,0,'L');
					
							$pdf->SetXY(100,220);
							$pdf->Cell(30,4,'Solicitante',0,0,'L');
					
							$pdf->SetXY(10,225);
							$pdf->Cell(15,10,"",1,0,'C');
							$pdf->Cell(15,10,"",1,0,'C');
							$pdf->Cell(15,10,"",1,0,'C');
					
							$pdf->SetXY(100,225);
							$pdf->Cell(15,10,utf8_decode(substr($rowRAM['cooResponsable'],0,1)),1,0,'C');
							$pdf->Cell(15,10,utf8_decode(substr($rowRAM['cooResponsable'],1,1)),1,0,'C');
							$pdf->Cell(15,10,utf8_decode(substr($rowRAM['cooResponsable'],2,1)),1,0,'C');
		
							$pdf->SetFont('Arial','',9);
							$pdf->SetXY(150,245);
							$pdf->Cell(15,10,'Reg 240205-V.0',0,0,'R');
							// Fin Pie
						}
							if($nPag >= 1) { $ln += 18; }
							$nQui++;
							$pdf->SetFont('Arial','B',11);
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(50,5,utf8_decode("IDENTIFICACIÓN"),1,'C');
							$pdf->SetXY(60,$ln);
							$pdf->MultiCell(50,5,utf8_decode("ALEACIÓN BASE"),1,'C');
							$pdf->SetXY(110,$ln);
							$pdf->MultiCell(75,5,"OBSERVACIONES",1,'C');
		
							$ln += 5;
							$pdf->SetXY(10,$ln);
							$pdf->SetTextColor($cR, $cG, $cB);
							$pdf->MultiCell(50,5,$rowMu['Otam'],1,'C');
							$pdf->SetTextColor(0,0,0);
							$pdf->SetFont('Arial','',11);
							$pdf->SetXY(60,$ln);
							$pdf->MultiCell(50,10,'',1,'C');
							$pdf->SetXY(110,$ln);
							$pdf->MultiCell(75,15,'',1,'C');
		
							$ln += 5;
							$pdf->SetFont('Arial','',11);
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(50,5,'FECHA',1,'L');
		
							$ln += 5;
							$pdf->SetFont('Arial','B',10);
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(50,5,'TEMPERATURA',1,'C');
							$pdf->SetXY(60,$ln);
							$pdf->MultiCell(50,5,'',1,'C');
							$pdf->SetXY(110,$ln);
							$pdf->MultiCell(30,5,'HUMEDAD',1,'L');
							$pdf->SetXY(140,$ln);
							$pdf->MultiCell(45,5,'',1,'C');
							
							$ln += 5;
							$lnTxt = 'OBSERVACIONES';
							$pdf->SetXY(10,$ln);
							$pdf->Cell(25,5,$lnTxt,0,0,'L');
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(175,14,"",1,'C');
					}while($rowMu=mysqli_fetch_array($bdMu));
				}

			}while($rowMm=mysqli_fetch_array($bdMm));
					for($i=$nQui+1;  $i<=5; $i++){
		
							$ln += 18;
							$pdf->SetFont('Arial','B',11);
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(50,5,utf8_decode("IDENTIFICACIÓN"),1,'C');
							$pdf->SetXY(60,$ln);
							$pdf->MultiCell(50,5,utf8_decode("ALEACIÓN BASE"),1,'C');
							$pdf->SetXY(110,$ln);
							$pdf->MultiCell(75,5,"OBSERVACIONES",1,'C');
		
							$ln += 5;
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(50,5,'__-Q-__',1,'C');
							$pdf->SetFont('Arial','',11);
							$pdf->SetXY(60,$ln);
							$pdf->MultiCell(50,10,'',1,'C');
							$pdf->SetXY(110,$ln);
							$pdf->MultiCell(75,15,'',1,'C');
		
							$ln += 5;
							$pdf->SetFont('Arial','',11);
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(50,5,'FECHA',1,'L');
		
							$ln += 5;
							$pdf->SetFont('Arial','B',10);
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(50,5,'TEMPERATURA',1,'C');
							$pdf->SetXY(60,$ln);
							$pdf->MultiCell(50,5,'',1,'C');
							$pdf->SetXY(110,$ln);
							$pdf->MultiCell(30,5,'HUMEDAD',1,'L');
							$pdf->SetXY(140,$ln);
							$pdf->MultiCell(45,5,'',1,'C');
							
							$ln += 5;
							$lnTxt = 'OBSERVACIONES';
							$pdf->SetXY(10,$ln);
							$pdf->Cell(25,5,$lnTxt,0,0,'L');
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(175,14,"",1,'C');
					}
		}
		
		//Fin Imprimir Otam Químico
		$nPag = 0;
		$nCha = 6;
		
		//Imprimir Otam Charpy
		/* ++++ */
		$par = 0;
		$pieCharpy = false;
		$SQLMm = "SELECT * FROM amMuestras Where idItem Like '%".$RAM."%' and conEnsayo != 'off' Order By idItem";
		$bdMm=$link->query($SQLMm);
		while($rowMm=mysqli_fetch_array($bdMm)){
			$Sw	  = false;
			$pieCharpy = false;
			$Otam = $RAM;
			$SQL = "SELECT * FROM OTAMs Where RAM = '".$RAM."' and Otam Like '%".$Otam."%' and idItem = '".$rowMm['idItem']."' and idEnsayo = 'Ch' Order By idItem";
			$bdMu=$link->query($SQL);
			while($rowMu=mysqli_fetch_array($bdMu)){
				$Ind = $rowMu['Ind'];
				$LetraCha = 'A';
				$pieCharpy = true;
					for($i=1;  $i<=$Ind; $i++){
							if($nCha > 5){
								$par = 0;
								$nPag++;
								if($nPag > 1){
									$ln += 10;
									$pdf->SetFont('Arial','B',10);
									$pdf->SetXY(10,$ln);
									$pdf->SetFillColor(218, 214, 214);
									$pdf->Cell(30,15,utf8_decode('Observaciones'),1,0,'C', true);
									$pdf->SetFont('Arial','',8);;;;;
									$pdf->Cell(210,15,'',1,0,'C', true);
						
									$ln += 15;
									$pdf->SetXY(37,$ln);
									$pdf->SetFillColor(0, 0, 0);
									$pdf->MultiCell(215,5,utf8_decode('NOTA:  Ponga un Ticket si la muestra a ensayar cumple con el requerimiento, en caso que no ponga una cruz (X) e informe inmediatamente al Jefe de Laboratorio, o en su defecto al Gerente Técnico'),0,'L', false);
								}

								$nCha = 0;
								$Sw   = true;
								// Encabezado 
								$pdf->AddPage('L');
								$pdf->SetXY(10,5);
								$pdf->Image('../../imagenes/logonewsimet.jpg',10,5,43,16);
									
								$pdf->SetFont('Arial','B',18);
								$pdf->SetXY(90,12);
								$pdf->SetTextColor($cR, $cG, $cB);
								$pdf->Cell(40,5,'OTAM-'.$RAM.'-Ch',0,0,'C');
								$pdf->SetTextColor(0,0,0);
								$pdf->SetFont('Arial','',10);
									
								$pdf->SetXY(50,17);
								$pdf->SetFont('Arial','B',8);
								$pdf->Cell(10,5,'',0,0);
									
								$pdf->SetXY(10,17);
								$pdf->Image('../../gastos/logos/logousach.png',260,5,15,23);
									
								$pdf->SetDrawColor(0, 0, 0);
								$pdf->Image('../../imagenes/logonewsimet.jpg',250,180,20,8);
											
								$pdf->SetXY(263,30);
								$pdf->Cell(30,4,$CAM,0,0,'L');
									
								$pdf->SetDrawColor(200, 200, 200);
								$pdf->Line(255, 30, 255, 205);
								$pdf->SetDrawColor(0, 0, 0);
								// Fin Encabezado
								
								$ln = 23;
								$pdf->SetFont('Arial','B',14);
								$pdf->SetXY(10,$ln);
								$pdf->SetFillColor(5, 156, 193);
								$pdf->MultiCell(240,7,utf8_decode("Resumen de resultados"),1,'C', true);
								$pdf->SetFillColor(0, 0, 0);
				
								$ln += 7;
								$pdf->SetFont('Arial','',12);
								$pdf->SetXY(10,$ln);
								$pdf->MultiCell(80,7,utf8_decode("Registre Temperatura ambiental (ºC)"),1,'C');
								$pdf->SetXY(90,$ln);
								$pdf->MultiCell(80,7,utf8_decode("Registre humedad ambiental (%)"),1,'C');
								$pdf->SetXY(170,$ln);
								$pdf->MultiCell(80,7,utf8_decode("Fecha de ensayo"),1,'C');
								$ln += 7;
								$pdf->SetFont('Arial','',12);
								$pdf->SetXY(10,$ln);
								$pdf->MultiCell(80,7,'',1,'C');
								$pdf->SetXY(90,$ln);
								$pdf->MultiCell(80,7,'',1,'C');
								$pdf->SetXY(170,$ln);
								$pdf->MultiCell(80,7,'',1,'C');
								$ln += 7;
								$pdf->SetFont('Arial','',12);
								$pdf->SetXY(10,$ln);
								$pdf->MultiCell(80,7,utf8_decode('Temperatura de ensayo (ºC)'),1,'C');
								$pdf->SetXY(90,$ln);
								$pdf->MultiCell(160,7,utf8_decode($rowMu['Tem']),1,'L');
								$ln += 7;
								$pdf->SetFont('Arial','B',10);
								$pdf->SetXY(10,$ln);
								$pdf->SetFillColor(218, 214, 214);
								$pdf->Cell(30,25,utf8_decode('Identificación'),1,0,'C', true);
								$pdf->SetFont('Arial','',8);;;;;
								$pdf->Cell(21,25,'',1,0,'C', true);
								$pdf->Cell(21,25,'',1,0,'C', true);
								$pdf->Cell(21,25,'',1,0,'C', true);
								$pdf->Cell(21,25,'',1,0,'C', true);
								$pdf->Cell(21,25,'',1,0,'C', true);
								$pdf->Cell(21,25,'',1,0,'C', true);
								$pdf->Cell(21,25,'',1,0,'C', true);
								$pdf->Cell(21,25,'',1,0,'C', true);
								$pdf->Cell(21,25,'',1,0,'C', true);
								$pdf->Cell(21,25,'',1,0,'C', true);
								$pdf->SetFillColor(0, 0, 0);

								$pdf->Cell(210,2,utf8_decode(''),0,0,'C');

								$ln+=2;
								$pdf->SetXY(40,$ln);
								$pdf->Cell(21,5,utf8_decode('Costado de'),0,0,'C');
								$pdf->Cell(21,5,utf8_decode('Caras del'),0,0,'C');
								$pdf->Cell(21,5,utf8_decode(''),0,0,'C');
								$pdf->Cell(21,5,utf8_decode(''),0,0,'C');
								$pdf->Cell(21,5,utf8_decode(''),0,0,'C');
								$pdf->Cell(21,5,utf8_decode('La'),0,0,'C');
								$pdf->Cell(21,5,utf8_decode('El radio de'),0,0,'C');
								$pdf->Cell(21,5,utf8_decode(''),0,0,'C');
								$pdf->Cell(21,5,utf8_decode(''),0,0,'C');
								$pdf->Cell(21,5,utf8_decode(''),0,0,'C');

								$ln+=5;
								$pdf->SetXY(40,$ln);
								$pdf->Cell(21,5,utf8_decode('la probeta'),0,0,'C');
								$pdf->Cell(21,5,utf8_decode('entalle'),0,0,'C');
								$pdf->Cell(21,5,utf8_decode('La probeta'),0,0,'C');
								$pdf->Cell(21,5,utf8_decode('El centro del'),0,0,'C');
								$pdf->Cell(21,5,utf8_decode('El ángulo del'),0,0,'C');
								$pdf->Cell(21,5,utf8_decode('profundidad'),0,0,'C');
								$pdf->Cell(21,5,utf8_decode('curvatura es'),0,0,'C');
								$pdf->Cell(21,5,utf8_decode('Registre'),0,0,'C');
								$pdf->Cell(21,5,utf8_decode('Registre alto'),0,0,'C');
								$pdf->Cell(21,5,utf8_decode('Energía'),0,0,'C');

								$ln+=5;
								$pdf->SetXY(40,$ln);
								$pdf->Cell(21,5,utf8_decode('¿Es menor a'),0,0,'C');
								$pdf->Cell(21,5,utf8_decode('¿Es menor a'),0,0,'C');
								$pdf->Cell(21,5,utf8_decode('mide 55'),0,0,'C');
								$pdf->Cell(21,5,utf8_decode('entalle está a'),0,0,'C');
								$pdf->Cell(21,5,utf8_decode('entalle de es'),0,0,'C');
								$pdf->Cell(21,5,utf8_decode('del entalle de'),0,0,'C');
								$pdf->Cell(21,5,utf8_decode('de 0,25 mm'),0,0,'C');
								$pdf->Cell(21,5,utf8_decode('ancho (mm)'),0,0,'C');
								$pdf->Cell(21,5,utf8_decode('(mm)'),0,0,'C');
								$pdf->Cell(21,5,utf8_decode('Absorbida'),0,0,'C');

								$ln+=5;
								$pdf->SetXY(40,$ln);
								$pdf->Cell(21,5,utf8_decode('4 Ra?'),0,0,'C');
								$pdf->Cell(21,5,utf8_decode('2 Ra?'),0,0,'C');
								$pdf->Cell(21,5,utf8_decode('+0/ -2,5 mm'),0,0,'C');
								$pdf->Cell(21,5,utf8_decode('27 +/- 1 mm'),0,0,'C');
								$pdf->Cell(21,5,utf8_decode('45º +/- 1º'),0,0,'C');
								$pdf->Cell(21,5,utf8_decode('es 2 mm'),0,0,'C');
								$pdf->Cell(21,5,utf8_decode('+/- 0.025 mm'),0,0,'C');
								$pdf->Cell(21,5,utf8_decode(''),0,0,'C');
								$pdf->Cell(21,5,utf8_decode(''),0,0,'C');
								$pdf->Cell(21,5,utf8_decode('(J)'),0,0,'C');

								// Pie
								$pdf->SetFont('Arial','B',10);
								$pdf->SetXY(10,170);
								$pdf->Cell(30,4,utf8_decode('Técnico responsable'),0,0,'L');
						
								$pdf->SetXY(210,170);
								$pdf->Cell(30,4,'Solicitante',0,0,'L');
						
								$pdf->SetXY(10,175);
								$pdf->Cell(15,10,"",1,0,'C');
								$pdf->Cell(15,10,"",1,0,'C');
								$pdf->Cell(15,10,"",1,0,'C');
						
								$pdf->SetXY(200,175);
								$pdf->Cell(15,10,utf8_decode(substr($rowRAM['cooResponsable'],0,1)),1,0,'C');
								$pdf->Cell(15,10,utf8_decode(substr($rowRAM['cooResponsable'],1,1)),1,0,'C');
								$pdf->Cell(15,10,utf8_decode(substr($rowRAM['cooResponsable'],2,1)),1,0,'C');
			
								$pdf->SetFont('Arial','',9);
								$pdf->SetXY(230,185);
								$pdf->Cell(15,10,'Reg 240203 V.3',0,0,'R');
								// Fin Pie
							}
							//if($nPag >= 1) { $ln += 18; }
							$par++;
							$nCha++;

							$alto = 10;
							$ln += $alto;
							
							$pdf->SetFont('Arial','B',10);
							if($par == 1){ $ln = $ln -2; }
							
							$pdf->SetXY(10,$ln);
							$estadoSw = false;
							if($par/2 == intval($par/2)){
								$estadoSw = true;
							}
						
							$pdf->SetFillColor(218, 214, 214);
							$pdf->SetFont('Arial','',8);;;;;

							$pdf->Cell(30,$alto,$rowMu['Otam'].' '.$LetraCha,1,0,'C', $estadoSw);
							$pdf->Cell(21,$alto,'',1,0,'C', $estadoSw);
							$pdf->Cell(21,$alto,'',1,0,'C', $estadoSw);
							$pdf->Cell(21,$alto,'',1,0,'C', $estadoSw);
							$pdf->Cell(21,$alto,'',1,0,'C', $estadoSw);
							$pdf->Cell(21,$alto,'',1,0,'C', $estadoSw);
							$pdf->Cell(21,$alto,'',1,0,'C', $estadoSw);
							$pdf->Cell(21,$alto,'',1,0,'C', $estadoSw);
							$pdf->Cell(21,$alto,'',1,0,'C', $estadoSw);
							$pdf->Cell(21,$alto,'',1,0,'C', $estadoSw);
							$pdf->Cell(21,$alto,'',1,0,'C', $estadoSw);
							$pdf->SetFillColor(0, 0, 0);



							$LetraCha++;
					}
				}
			}
			if($pieCharpy == true){
				$ln += 10;
				$pdf->SetFont('Arial','B',10);
				$pdf->SetXY(10,$ln);
				$pdf->SetFillColor(218, 214, 214);
				$pdf->Cell(30,15,utf8_decode('Observaciones'),1,0,'C', true);
				$pdf->SetFont('Arial','',8);;;;;
				$pdf->Cell(210,15,'',1,0,'C', true);
				$ln += 15;
				$pdf->SetXY(37,$ln);
				$pdf->SetFillColor(0, 0, 0);
				$pdf->MultiCell(215,5,utf8_decode('NOTA:  Ponga un Ticket si la muestra a ensayar cumple con el requerimiento, en caso que no ponga una cruz (X) e informe inmediatamente al Jefe de Laboratorio, o en su defecto al Gerente Técnico'),0,'L', false);
			}
		//Fin Imprimir Otam Charpy




		//Imprimir Otam Doblado
		$nPag = 0;
		$nTra = 5;

		/* +++ */
		$SQLMm = "SELECT * FROM amMuestras Where idItem Like '%".$RAM."%' and conEnsayo != 'off' Order By idItem";
		$bdMm=$link->query($SQLMm);
		if($rowMm=mysqli_fetch_array($bdMm)){
			do{

				$Otam = $RAM;
				$SQL = "SELECT * FROM OTAMs Where RAM = '".$RAM."' and Otam Like '%".$Otam."%' and idItem = '".$rowMm['idItem']."' and idEnsayo = 'Do' Order By idItem";
				$bdMu=$link->query($SQL);
				if($rowMu=mysqli_fetch_array($bdMu)){
					do{
						if($nTra >= 5){
							$nPag++;
							$nTra = 0;
							// Encabezado 
							$pdf->AddPage();
							$pdf->SetXY(10,5);
							$pdf->Image('../../imagenes/logonewsimet.jpg',10,5,43,16);
								
							$pdf->SetFont('Arial','B',18);
							$pdf->SetXY(90,12);
							$pdf->SetTextColor($cR, $cG, $cB);
							$pdf->Cell(40,5,'OTAM-'.$RAM.'-Do',0,0,'C');
							$pdf->SetTextColor(0,0,0);
							$pdf->SetFont('Arial','',10);
								
							$pdf->SetXY(50,17);
							$pdf->SetFont('Arial','B',8);
							$pdf->Cell(10,5,'',0,0);
								
							$pdf->SetXY(10,17);
							$pdf->Image('../../gastos/logos/logousach.png',195,5,15,23);
								
							$pdf->SetDrawColor(0, 0, 0);
							$pdf->Image('../../imagenes/logonewsimet.jpg',185,245,20,8);
										
							$pdf->SetXY(197,30);
							$pdf->Cell(30,4,$CAM,0,0,'L');
								
							$pdf->SetDrawColor(200, 200, 200);
							$pdf->Line(190, 30, 190, 270);
							$pdf->SetDrawColor(0, 0, 0);
							// Fin Encabezado
		
							$ln = 5;
							
							// Pie
							$pdf->SetFont('Arial','B',10);
							$pdf->SetXY(10,220);
							$pdf->Cell(30,4,utf8_decode('Técnico responsable'),0,0,'L');
					
							$pdf->SetXY(100,220);
							$pdf->Cell(30,4,'Solicitante',0,0,'L');
					
							$pdf->SetXY(10,225);
							$pdf->Cell(15,10,"",1,0,'C');
							$pdf->Cell(15,10,"",1,0,'C');
							$pdf->Cell(15,10,"",1,0,'C');
					
							$pdf->SetXY(100,225);
							$pdf->Cell(15,10,utf8_decode(substr($rowRAM['cooResponsable'],0,1)),1,0,'C');
							$pdf->Cell(15,10,utf8_decode(substr($rowRAM['cooResponsable'],1,1)),1,0,'C');
							$pdf->Cell(15,10,utf8_decode(substr($rowRAM['cooResponsable'],2,1)),1,0,'C');
		
							$pdf->SetFont('Arial','',9);
							$pdf->SetXY(150,245);
							$pdf->Cell(15,10,'Reg 240204 V.0',0,0,'R');
							// Fin Pie
						}
						
						if($nPag >= 1) { $ln += 18; }
						$nTra++;
							
						$lnTxt = "IDENTIFICACIÓN ";
						$pdf->SetFont('Arial','B',11);
						$pdf->SetXY(10,$ln); 
						$pdf->Cell(35,5,utf8_decode($lnTxt),0,0,'C');
						$pdf->SetXY(10,$ln);
						$pdf->MultiCell(35,5,"",1,'L');
					
						$lnTxt = "RESUMEN RESULTADOS";
						$pdf->SetXY(45,$ln);
						$pdf->Cell(140,5,$lnTxt,0,0,'C');
						$pdf->SetXY(45,$ln);
						$pdf->MultiCell(140,5,"",1,'L');
							
						$ln += 5;
						$lnTxt = $rowMu['Otam'];
						$pdf->SetXY(10,$ln);
						$pdf->SetTextColor($cR, $cG, $cB);
						$pdf->MultiCell(35,10,$lnTxt,1,'C');
						$pdf->SetTextColor(0,0,0);
		
						$pdf->SetFont('Arial','',10);
						$lnTxt = 'Separación entre apoyos (mm)';
						$pdf->SetXY(45,$ln);
						$pdf->MultiCell(29,5,utf8_decode($lnTxt),1,'C');

						$lnTxt = 'Diámetro Apoyos (mm)';
						$pdf->SetXY(74,$ln);
						$pdf->MultiCell(25,5,utf8_decode($lnTxt),1,'C');
	
						$lnTxt = 'Diámetro Punzón (mm)';
						$pdf->SetXY(99,$ln);
						$pdf->MultiCell(29,5,utf8_decode($lnTxt),1,'C');

						$lnTxt = 'Angulo Alcanzado (º)';
						$pdf->SetXY(128,$ln);
						$pdf->MultiCell(29,5,utf8_decode($lnTxt),1,'C');
		
						$lnTxt = 'Dimensión Fisuras (mm)';
						$pdf->SetXY(157,$ln);
						$pdf->MultiCell(28,5,utf8_decode($lnTxt),1,'C');

		
						$ln += 10;
						$pdf->SetFont('Arial','B',11);
						$lnTxt = 'FECHA';
						$pdf->SetXY(10,$ln);
						$pdf->MultiCell(35,5,$lnTxt,1,'C');
						$pdf->SetFont('Arial','',11);
							
						$lnTxt = '';
						$pdf->SetXY(45,$ln);
						$pdf->MultiCell(29,5,$lnTxt,1,'C');

						$lnTxt = '';
						$pdf->SetXY(74,$ln);
						$pdf->MultiCell(25,5,$lnTxt,1,'L');
		
						$lnTxt = '';
						$pdf->SetXY(99,$ln);
						$pdf->MultiCell(29,5,$lnTxt,1,'L');
		
						$lnTxt = '';
						$pdf->SetXY(128,$ln);
						$pdf->MultiCell(29,5,$lnTxt,1,'L');

						$lnTxt = '';
						$pdf->SetXY(157,$ln);
						$pdf->MultiCell(28,5,$lnTxt,1,'L');
							
		
						$ln += 5;
						$lnTxt = '';
						$pdf->SetXY(10,$ln);
						$pdf->MultiCell(35,5,$lnTxt,1,'C');
		
						$pdf->SetFont('Arial','B',9);
						$lnTxt = 'TEMPERATURA';
						$pdf->SetXY(45,$ln);
						$pdf->MultiCell(29,5,$lnTxt,1,'L');

						$lnTxt = '';
						$pdf->SetXY(74,$ln);
						$pdf->MultiCell(54,5,$lnTxt,1,'L');
		
						$lnTxt = 'HUMEDAD';
						$pdf->SetXY(128,$ln);
						$pdf->MultiCell(29,5,$lnTxt,1,'L');

						$lnTxt = '';
						$pdf->SetXY(157,$ln);
						$pdf->MultiCell(28,5,$lnTxt,1,'L');
	
	
						$ln += 5;
						$lnTxt = 'OBSERVACIONES';
						$pdf->SetXY(10,$ln);
						$pdf->Cell(10,5,$lnTxt,0,0,'L');
						$pdf->SetXY(10,$ln);
						$pdf->MultiCell(175,13,"",1,'C');
						
					}while($rowMu=mysqli_fetch_array($bdMu));

				}
			}while($rowMm=mysqli_fetch_array($bdMm));


			for($i=$nTra+1;  $i<=4; $i++){
						$ln += 18;
						$lnTxt = "IDENTIFICACIÓN ";
						$pdf->SetFont('Arial','B',11);
						$pdf->SetXY(10,$ln); 
						$pdf->Cell(35,5,utf8_decode($lnTxt),0,0,'C');
						$pdf->SetXY(10,$ln);
						$pdf->MultiCell(35,5,"",1,'L');
					
						$lnTxt = "RESUMEN RESULTADOS";
						$pdf->SetXY(45,$ln);
						$pdf->Cell(140,5,$lnTxt,0,0,'C');
						$pdf->SetXY(45,$ln);
						$pdf->MultiCell(140,5,"",1,'L');
							
						$ln += 5;
						//$lnTxt = $rowMu['Otam'];
						$pdf->SetXY(10,$ln);
						$pdf->SetTextColor($cR, $cG, $cB);
						$pdf->MultiCell(35,10,$lnTxt,1,'C');
						$pdf->SetTextColor(0,0,0);
		
						$pdf->SetFont('Arial','',10);
						$lnTxt = 'Separación entre apoyos (mm)';
						$pdf->SetXY(45,$ln);
						$pdf->MultiCell(29,5,utf8_decode($lnTxt),1,'C');

						$lnTxt = 'Diámetro Apoyos (mm)';
						$pdf->SetXY(74,$ln);
						$pdf->MultiCell(25,5,utf8_decode($lnTxt),1,'C');
	
						$lnTxt = 'Diámetro Punzón (mm)';
						$pdf->SetXY(99,$ln);
						$pdf->MultiCell(29,5,utf8_decode($lnTxt),1,'C');

						$lnTxt = 'Angulo Alcanzado (º)';
						$pdf->SetXY(128,$ln);
						$pdf->MultiCell(29,5,utf8_decode($lnTxt),1,'C');
		
						$lnTxt = 'Dimensión Fisuras (mm)';
						$pdf->SetXY(157,$ln);
						$pdf->MultiCell(28,5,utf8_decode($lnTxt),1,'C');

		
						$ln += 10;
						$pdf->SetFont('Arial','B',11);
						$lnTxt = 'FECHA';
						$pdf->SetXY(10,$ln);
						$pdf->MultiCell(35,5,$lnTxt,1,'C');
						$pdf->SetFont('Arial','',11);
							
						$lnTxt = '';
						$pdf->SetXY(45,$ln);
						$pdf->MultiCell(29,5,$lnTxt,1,'C');

						$lnTxt = '';
						$pdf->SetXY(74,$ln);
						$pdf->MultiCell(25,5,$lnTxt,1,'L');
		
						$lnTxt = '';
						$pdf->SetXY(99,$ln);
						$pdf->MultiCell(29,5,$lnTxt,1,'L');
		
						$lnTxt = '';
						$pdf->SetXY(128,$ln);
						$pdf->MultiCell(29,5,$lnTxt,1,'L');

						$lnTxt = '';
						$pdf->SetXY(157,$ln);
						$pdf->MultiCell(28,5,$lnTxt,1,'L');
							
		
						$ln += 5;
						$lnTxt = '';
						$pdf->SetXY(10,$ln);
						$pdf->MultiCell(35,5,$lnTxt,1,'C');
		
						$pdf->SetFont('Arial','B',9);
						$lnTxt = 'TEMPERATURA';
						$pdf->SetXY(45,$ln);
						$pdf->MultiCell(29,5,$lnTxt,1,'L');

						$lnTxt = '';
						$pdf->SetXY(74,$ln);
						$pdf->MultiCell(54,5,$lnTxt,1,'L');
		
						$lnTxt = 'HUMEDAD';
						$pdf->SetXY(128,$ln);
						$pdf->MultiCell(29,5,$lnTxt,1,'L');

						$lnTxt = '';
						$pdf->SetXY(157,$ln);
						$pdf->MultiCell(28,5,$lnTxt,1,'L');
	
	
						$ln += 5;
						$lnTxt = 'OBSERVACIONES';
						$pdf->SetXY(10,$ln);
						$pdf->Cell(10,5,$lnTxt,0,0,'L');
						$pdf->SetXY(10,$ln);
						$pdf->MultiCell(175,13,"",1,'C');
			}
		}
		
		//Fin Imprimir Otam Doblado


		
		//Imprimir Otam Metalografía
		$nPag = 0;
		$nTra = 5;

		$SQLMm = "SELECT * FROM amMuestras Where idItem Like '%".$RAM."%' and conEnsayo != 'off' Order By idItem";
		$bdMm=$link->query($SQLMm);
		if($rowMm=mysqli_fetch_array($bdMm)){
			$Otam = $RAM;
			$SQL = "SELECT * FROM OTAMs Where RAM = '".$RAM."' and Otam Like '%".$Otam."%' and idItem = '".$rowMm['idItem']."' and idEnsayo = 'M' Order By idItem";
			$bdMu=$link->query($SQL);
			while($rowMu=mysqli_fetch_array($bdMu)){
				$nPag = 0;
				$nTra = 5;
		
				if($nTra >= 5){
						$nPag++;
						$nTra = 0;
						$pdf->AddPage();
						$pdf->SetXY(10,5);
						$pdf->Image('../../imagenes/logonewsimet.jpg',10,5,43,16);
						$pdf->SetFont('Arial','B',18);
						$pdf->SetXY(90,12);
						$pdf->SetTextColor($cR, $cG, $cB);
						$pdf->Cell(40,5,'OTAM-'.$RAM.'-M',0,0,'C');
						$pdf->SetTextColor(0,0,0);
						$pdf->SetFont('Arial','',10);
						$pdf->SetXY(50,17);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(10,5,'',0,0);
						$pdf->SetXY(10,17);
						$pdf->Image('../../gastos/logos/logousach.png',195,5,15,23);
						$pdf->SetDrawColor(0, 0, 0);
						$pdf->Image('../../imagenes/logonewsimet.jpg',185,245,20,8);
						$pdf->SetXY(197,30);
						$pdf->Cell(30,4,$CAM,0,0,'L');
						$pdf->SetDrawColor(200, 200, 200);
						$pdf->Line(190, 30, 190, 270);
						$pdf->SetDrawColor(0, 0, 0);
						// Fin Encabezado
						$ln = 5;
						// Pie
						$pdf->SetFont('Arial','B',10);
						$pdf->SetXY(10,220);
						$pdf->Cell(30,4,'',0,0,'L');
						$pdf->SetXY(100,220);
						$pdf->Cell(30,4,utf8_decode('Responsable'),0,0,'L');
						$pdf->SetXY(10,225);
						//$pdf->Cell(15,10,"G",1,0,'C');
						//$pdf->Cell(15,10,"R",1,0,'C');
						//$pdf->Cell(15,10,"C",1,0,'C');
						$pdf->SetXY(100,225);
						$pdf->Cell(15,10,"",1,0,'C');
						$pdf->Cell(15,10,"",1,0,'C');
						$pdf->Cell(15,10,"",1,0,'C');
						//$pdf->Cell(15,10,'G',1,0,'C');
						//$pdf->Cell(15,10,'R',1,0,'C');
						//$pdf->Cell(15,10,'C',1,0,'C');
						//$pdf->SetFont('Arial','',9);
						$pdf->SetXY(150,245);
						//$pdf->Cell(15,10,'Reg 240204 V.0',0,0,'R');
						$pdf->Cell(15,10,'',0,0,'R');
						// Fin Pie
				}
						
				if($nPag >= 1) { $ln += 18; }
					$nTra++;
							

					$lnTxt = "   En el siguiente cuadro debe ser dibujado un esquema de la muestra. Adicionalmente, será necesario que";
					$lnTxt .= "se indiquen con números los sectores analizados. Las fotos deben ser guardadas en JPG y con el número";
					$lnTxt .= "correspondiente al sector estudiado.";
					$pdf->SetFont('Arial','',11);
					$pdf->SetXY(10,$ln); 
					$pdf->MultiCell(180,5,utf8_decode($lnTxt),0,'J');

					$ln += 18;
					$pdf->SetXY(10,$ln); 
					$pdf->MultiCell(175,80,'',1,'J');

					$ln += 85;
					$lnTxt = "Las siguientes tablas deben ser completadas con una X";
					$pdf->SetFont('Arial','B',11);
					$pdf->SetXY(10,$ln); 
					$pdf->Cell(175,5,utf8_decode($lnTxt),0,0,'C');

					$ln += 10;
					$lnTxt = "Imagen";
					$pdf->SetFont('Arial','B',11);
					$pdf->SetXY(10,$ln); 
					$pdf->Cell(175,5,utf8_decode($lnTxt),1,0,'C');

					$ln += 5;
					$lnTxt = "Nº";
					$pdf->SetXY(10,$ln);
					$pdf->Cell(10,10, utf8_decode($lnTxt),1,0,'C');
					$lnTxt = "Aumento";
					$pdf->Cell(100,5, utf8_decode($lnTxt),1,0,'C');
					$lnTxt = "Observaciones";
					$pdf->Cell(65,10, utf8_decode($lnTxt),1,0,'C');
							
					$ln += 5;
					$lnTxt = '50'; // $rowMu['Otam'];
					$pdf->SetXY(20,$ln);
					$pdf->Cell(20,5,$lnTxt,1,0,'C');
					$lnTxt = '100';
					$pdf->Cell(20,5,$lnTxt,1,0,'C');
					$lnTxt = '200';
					$pdf->Cell(20,5,$lnTxt,1,0,'C');
					$lnTxt = '500';
					$pdf->Cell(20,5,$lnTxt,1,0,'C');
					$lnTxt = '1000';
					$pdf->Cell(20,5,$lnTxt,1,0,'C');

					for($i=1; $i<=10; $i++){
						$ln += 5;
						$lnTxt = $i; // $rowMu['Otam'];
						$pdf->SetXY(10,$ln);
						$pdf->Cell(10,5,$lnTxt,1,0,'C');
	
						$lnTxt = ''; // $rowMu['Otam'];
						$pdf->SetXY(20,$ln);
						$pdf->Cell(20,5,$lnTxt,1,0,'C');
						$pdf->Cell(20,5,$lnTxt,1,0,'C');
						$pdf->Cell(20,5,$lnTxt,1,0,'C');
						$pdf->Cell(20,5,$lnTxt,1,0,'C');
						$pdf->Cell(20,5,$lnTxt,1,0,'C');
						$pdf->Cell(65,5,$lnTxt,1,0,'C');
						//$pdf->SetTextColor(0,0,0);
					}
		
						
				}

		}
		
		//Fin Imprimir Otam Metalografía


		

	}

	$agnoActual = date('Y'); 

	$link=Conectarse();
	$vDirEnsayos = 'Y://AAA/LE/LABORATORIO/'.$agnoActual.'/'.$RAM; 
	if(!file_exists($vDirEnsayos)){
		mkdir($vDirEnsayos);
	}	

	$sqlOtam = "SELECT * FROM otams Where idItem like '%$RAM%' Order By idEnsayo";
	$bdOT=$link->query($sqlOtam);
	while($rowOT=mysqli_fetch_array($bdOT)){
		$vDirEnsayos = 'Y://AAA/LE/LABORATORIO/'.$agnoActual.'/'.$RAM.'/'.$rowOT['idEnsayo']; 
		if(!file_exists($vDirEnsayos)){
			mkdir($vDirEnsayos);
		}	
	}
	$link->close(); 

	// $vDirEnsayos = 'Y://AAA/Archivador-'.$agnoActual.'/Laboratorio/Archivador-AM/'.$RAM; 
	$vDirEnsayos = 'Y://AAA/LE/LABORATORIO/'.$agnoActual.'/'.$RAM.'/'; 
	if(!file_exists($vDirEnsayos)){
		mkdir($vDirEnsayos);
	}	

	//$pdf->Output('F3B-00001.pdf','I'); //Para Descarga
	$NombreFormulario = "RAM-".$RAM.".pdf";
	$NombreOtam = "RAM-".$RAM.".pdf";
	$pdf->Output($NombreFormulario,'D'); //Para Descarga
	$pdf->Output($vDirEnsayos.$NombreOtam,'F'); //Para Descarga
	// copy($NombreOtam, $vDirEnsayos.'/'.$NombreOtam);
	unlink($NombreOtam);

	// header("Location: iRAMAR.php");
?>

