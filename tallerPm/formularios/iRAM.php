<?php
	require_once('../../fpdf/fpdf.php');
	include_once("../../conexionli.php");
	//header('Content-Type: text/html; charset=iso-8859-1');
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

	$link=Conectarse();
	$bdRAM=$link->query("SELECT * FROM formram WHERE RAM = '".$RAM."'");
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
		$nContacto = 0;
		$bdCAM=$link->query("SELECT * FROM Cotizaciones WHERE CAM = '".$CAM."' and RAM = '".$RAM."'");
		if($rowCAM=mysqli_fetch_array($bdCAM)){
			$RutCli 		= $rowCAM['RutCli'];
			$Atencion 		= $rowCAM['Atencion'];
			$nContacto 		= $rowCAM['nContacto'];
			$RutCli			= $rowCAM['RutCli'];
			$usrResponsable	= $rowCAM['usrResponzable'];
		}
		
		$ln = 25;
		$bdCli=$link->query("SELECT * FROM Clientes WHERE RutCli = '".$RutCli."'");
		if($rowCli=mysqli_fetch_array($bdCli)){
			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(10,$ln);
			$pdf->Cell(30,4,'EMPRESA:',0,0,'L');

			$pdf->SetFont('Arial','B',10);
			$pdf->SetXY(30,$ln);
			$pdf->Cell(144,4,$rowCli['Cliente'],0,0,'L');

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
				$pdf->Cell(30,4,utf8_decode('ATENCIÓN'),0,0,'L');

				$pdf->SetFont('Arial','B',10);
				$pdf->SetXY(30,$ln);
				//$pdf->Cell(144,4,utf8_decode($Atencion),0,0,'L');
				$pdf->Cell(144,4,$Atencion,0,0,'L');

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
				$pdf->Cell(144,4,$rowCli['Direccion'],0,0,'L');

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
		$pdf->MultiCell(174,8,$lnTxt,0,'L');

		$lnTxt  = "En este formulario se deben adjuntar registros pertinentes a la administración, ";
		$lnTxt .= "tal como: órdenes de compra, guías de despacho, etc.";
		
		$pdf->SetFont('Arial','',14);
		$pdf->SetXY(10,120);
		$pdf->MultiCell(174,8,$lnTxt,0,'L');
		
		$pdf->SetFont('Arial','B',12);
		$pdf->SetXY(10,220);
		$pdf->Cell(30,4,'Recepción:',0,0,'L');

		$pdf->SetXY(100,220);
		$pdf->Cell(30,4,'Responsable:',0,0,'L');

		$pdf->SetXY(10,225);
		$pdf->Cell(15,10,substr($rowRAM['ingResponsable'],0,1),1,0,'C');
		$pdf->Cell(15,10,substr($rowRAM['ingResponsable'],1,1),1,0,'C');
		$pdf->Cell(15,10,substr($rowRAM['ingResponsable'],2,1),1,0,'C');

		$pdf->SetXY(100,225);
		$pdf->Cell(15,10,substr($rowRAM['cooResponsable'],0,1),1,0,'C');
		$pdf->Cell(15,10,substr($rowRAM['cooResponsable'],1,1),1,0,'C');
		$pdf->Cell(15,10,substr($rowRAM['cooResponsable'],2,1),1,0,'C');

		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(150,245);
		$pdf->Cell(15,10,'Reg 2401-V.05',0,0,'R');

		// Encabezado 
		$pdf->AddPage();
		$pdf->SetXY(10,5);
		$pdf->Image('../../imagenes/logoSimetCam.png',10,5,43,16);

		$pdf->SetFont('Arial','B',18);
		$pdf->SetXY(80,12);
		$pdf->SetTextColor($cR, $cG, $cB);
		$pdf->Cell(30,5,'RAM '.$RAM,0,0,'C');
		$pdf->SetTextColor(0,0,0);
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
		$bdCli=$link->query("SELECT * FROM Clientes WHERE RutCli = '".$RutCli."'");
		if($rowCli=mysqli_fetch_array($bdCli)){
			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(10,$ln);
			$pdf->Cell(30,4,'EMPRESA:',0,0,'L');

			$pdf->SetFont('Arial','B',10);
			$pdf->SetXY(30,$ln);
			$pdf->Cell(144,4,$rowCli['Cliente'],0,0,'L');

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
				$pdf->Cell(144,4,$Atencion,0,0,'L');

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
				$pdf->Cell(144,4,$rowCli['Direccion'],0,0,'L');

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
		$pdf->Cell(40,8,$lnTxt,0,0,'L');

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
		$pdf->MultiCell(175,5,$rowRAM['Obs'],0,'L');

		$ln = 147;

		$lnTxt = "ID SIMET";

		$pdf->SetFont('Arial','B',10);
		$pdf->SetXY(10,$ln);
		$pdf->Cell(20,8,$lnTxt,0,0,'C');

		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(20,10,"",1,'L');

		$lnTxt = "Identificación del cliente";
		$pdf->SetXY(30,$ln);
		$pdf->Cell(114,8,$lnTxt,0,0,'C');
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
					if($rowOT=mysqli_fetch_array($bdOT)){
						do{
							$nOtam++;
							if($nOtam <= 5){
								$ln += 10;
								
								$pdf->SetTextColor($cR, $cG, $cB);
								$pdf->SetXY(10,$ln);
								$pdf->MultiCell(20,10,$rowMu['idItem'],1,'C');
							
								$pdf->SetXY(30,$ln);
								$pdf->SetFont('Arial','B',7);
								$pdf->MultiCell(114,10,"",1,'L');
	
								$pdf->SetXY(30,$ln);
								$pdf->MultiCell(114,4,$rowMu['idMuestra'],0,'L');
								$pdf->SetFont('Arial','B',10);
							
								$pdf->SetXY(144,$ln);
								$pdf->MultiCell(41,10,$rowOT['Otam'],1,'C');
								$pdf->SetTextColor(0,0,0);
							}
						}while($rowOT=mysqli_fetch_array($bdOT));
					} // Imprimir Muestra sin OTAM
				}else{

							$nOtam++;
							if($nOtam <= 5){
								$ln += 10;
								
								$pdf->SetTextColor($cR, $cG, $cB);
								$pdf->SetXY(10,$ln);
								$pdf->MultiCell(20,10,$rowMu['idItem'],1,'C');
							
								$pdf->SetXY(30,$ln);
								$pdf->SetFont('Arial','B',7);
								$pdf->MultiCell(114,10,"",1,'L');
	
								$pdf->SetXY(30,$ln);
								$pdf->MultiCell(114,4,$rowMu['idMuestra'],0,'L');
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
		$pdf->Cell(30,4,'Recepción:',0,0,'L');

		$pdf->SetXY(100,220);
		$pdf->Cell(30,4,'Responsable:',0,0,'L');

		$pdf->SetXY(10,225);
		$pdf->Cell(15,10,substr($rowRAM['ingResponsable'],0,1),1,0,'C');
		$pdf->Cell(15,10,substr($rowRAM['ingResponsable'],1,1),1,0,'C');
		$pdf->Cell(15,10,substr($rowRAM['ingResponsable'],2,1),1,0,'C');

		$pdf->SetXY(100,225);
		$pdf->Cell(15,10,substr($rowRAM['cooResponsable'],0,1),1,0,'C');
		$pdf->Cell(15,10,substr($rowRAM['cooResponsable'],1,1),1,0,'C');
		$pdf->Cell(15,10,substr($rowRAM['cooResponsable'],2,1),1,0,'C');

		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(150,245);
		$pdf->Cell(15,10,'Reg 2401-V.05',0,0,'R');


		// Siguientes Registros de OTAMs
	
		$sqlOtams	= "SELECT * FROM OTAMs Where RAM = '".$RAM."'";  // sentencia sql
		$result 	= $link->query($sqlOtams);
		$tOtams 	= mysql_num_rows($result); // obtenemos el n�mero de Otams
		
		if($tOtams > 5){
			// Encabezado 
			$pdf->AddPage();
			$pdf->SetXY(10,5);
			$pdf->Image('../../imagenes/logoSimetCam.png',10,5,43,16);
	
			$pdf->SetFont('Arial','B',18);
			$pdf->SetXY(80,12);
			$pdf->SetTextColor($cR, $cG, $cB);
			$pdf->Cell(30,5,'RAM '.$RAM,0,0,'C');
			$pdf->SetTextColor(0,0,0);
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
	
			$lnTxt = "ID SIMET";
	
			$pdf->SetFont('Arial','B',10);
			$pdf->SetXY(10,$ln);
			$pdf->Cell(20,7,$lnTxt,0,0,'C');
	
			$pdf->SetXY(10,$ln);
			$pdf->MultiCell(20,8,"",1,'L');
	
			$lnTxt = "Identificación del cliente";
			$pdf->SetXY(30,$ln);
			$pdf->Cell(114,7,$lnTxt,0,0,'C');
			$pdf->SetXY(30,$ln);
			$pdf->MultiCell(114,8,"",1,'L');
	
			$lnTxt = "OTAM";
			$pdf->SetXY(144,$ln);
			$pdf->Cell(41,7,$lnTxt,0,0,'C');
			$pdf->SetXY(144,$ln);
			$pdf->MultiCell(41,8,"",1,'L');

			$pdf->SetFont('Arial','',9);
			$pdf->SetXY(155,247);
			$pdf->Cell(15,10,'Reg 2401-V.05',0,0,'R');
	
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
										$pdf->Image('../../imagenes/logoSimetCam.png',10,5,43,16);
								
										$pdf->SetFont('Arial','B',18);
										$pdf->SetXY(80,12);
										$pdf->SetTextColor($cR, $cG, $cB);
										$pdf->Cell(30,5,'RAM '.$RAM,0,0,'C');
										$pdf->SetTextColor(0,0,0);
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
								
										$ln = 24;
								
										$lnTxt = "ID SIMET";
								
										$pdf->SetFont('Arial','B',10);
										$pdf->SetXY(10,$ln);
										$pdf->Cell(20,7,$lnTxt,0,0,'C');
								
										$pdf->SetXY(10,$ln);
										$pdf->MultiCell(20,8,"",1,'L');
								
										$lnTxt = "Identificación del cliente";
										$pdf->SetXY(30,$ln);
										$pdf->Cell(114,7,$lnTxt,0,0,'C');
										$pdf->SetXY(30,$ln);
										$pdf->MultiCell(114,8,"",1,'L');
								
										$lnTxt = "OTAM";
										$pdf->SetXY(144,$ln);
										$pdf->Cell(41,7,$lnTxt,0,0,'C');
										$pdf->SetXY(144,$ln);
										$pdf->MultiCell(41,8,"",1,'L');
										
										$pdf->SetFont('Arial','',9);
										$pdf->SetXY(150,247);
										$pdf->Cell(15,10,'Reg 2401-V.05',0,0,'R');
										
									}
									$ln += 8;
										
									$pdf->SetTextColor($cR, $cG, $cB);
									$pdf->SetXY(10,$ln);
									$pdf->MultiCell(20,8,$rowMu['idItem'],1,'C');
								
									$pdf->SetXY(30,$ln);
									$pdf->MultiCell(114,8,$rowMu['idMuestra'],1,'L');
							
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
										$pdf->Image('../../imagenes/logoSimetCam.png',10,5,43,16);
								
										$pdf->SetFont('Arial','B',18);
										$pdf->SetXY(80,12);
										$pdf->SetTextColor($cR, $cG, $cB);
										$pdf->Cell(30,5,'RAM '.$RAM,0,0,'C');
										$pdf->SetTextColor(0,0,0);
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
								
										$ln = 24;
								
										$lnTxt = "ID SIMET";
								
										$pdf->SetFont('Arial','B',10);
										$pdf->SetXY(10,$ln);
										$pdf->Cell(20,7,$lnTxt,0,0,'C');
								
										$pdf->SetXY(10,$ln);
										$pdf->MultiCell(20,8,"",1,'L');
								
										$lnTxt = "Identificación del cliente";
										$pdf->SetXY(30,$ln);
										$pdf->Cell(114,7,$lnTxt,0,0,'C');
										$pdf->SetXY(30,$ln);
										$pdf->MultiCell(114,8,"",1,'L');
								
										$lnTxt = "OTAM";
										$pdf->SetXY(144,$ln);
										$pdf->Cell(41,7,$lnTxt,0,0,'C');
										$pdf->SetXY(144,$ln);
										$pdf->MultiCell(41,8,"",1,'L');
										
										$pdf->SetFont('Arial','',9);
										$pdf->SetXY(150,247);
										$pdf->Cell(15,10,'Reg 2401-V.05',0,0,'R');
										
									}
									$ln += 8;
										
									$pdf->SetTextColor($cR, $cG, $cB);
									$pdf->SetXY(10,$ln);
									$pdf->MultiCell(20,8,$rowMu['idItem'],1,'C');
								
									$pdf->SetXY(30,$ln);
									$pdf->MultiCell(114,8,$rowMu['idMuestra'],1,'L');
							
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
			$pdf->Image('../../imagenes/logoSimetCam.png',10,5,43,16);
	
			$pdf->SetFont('Arial','B',18);
			$pdf->SetTextColor($cR, $cG, $cB);
			$pdf->SetXY(90,12);
			$pdf->Cell(40,5,'Solicitud servicio a taller N°'.$rowRAM['nSolTaller'],0,0,'C');
			$pdf->SetTextColor(0,0,0);
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
				$pdf->Cell(144,7,$rowUs['usuario'],0,0,'L');
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
						$pdf->Cell(100,7,'Nombre del técnico responsable',0,0,'L');
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
						$pdf->Image('../../imagenes/logoSimetCam.png',10,5,43,16);
				
						$pdf->SetFont('Arial','B',18);
						$pdf->SetXY(90,12);
						$pdf->SetTextColor($cR, $cG, $cB);
						$pdf->Cell(40,5,'Solicitud servicio a taller N°'.$rowRAM['nSolTaller'],0,0,'C');
						$pdf->SetTextColor(0,0,0);
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
						
					}

					if($nPagServ > 1){
						// Imprimir Pie de Otam
						if($ctlLin == 5){
							$nPagServ++;
							$ctlLin = 0;
							// Encabezado 
							$pdf->AddPage();
							$pdf->SetXY(10,5);
							$pdf->Image('../../imagenes/logoSimetCam.png',10,5,43,16);
					
							$pdf->SetFont('Arial','B',18);
							$pdf->SetXY(90,12);
							$pdf->SetTextColor($cR, $cG, $cB);
							$pdf->Cell(40,5,'Solicitud servicio a taller N°'.$rowRAM['nSolTaller'],0,0,'C');
							$pdf->SetTextColor(0,0,0);
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
		//				$pdf->SetXY(40,$ln);
		//				$pdf->Cell(144,7,$rowMu[idItem],0,0,'L');
						$ln += 30;
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
//					$pdf->SetXY(40,$ln);
//					$pdf->Cell(144,7,$rowMu[idItem],0,0,'L');
					$ln += 30;
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
				$pdf->Cell(100,7,'Nombre del técnico responsable',0,0,'L');
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
		//Fin Solicitud Servicio de Taller


		// Imprimir Solicitud Servicio a Taller SST
		if($rowRAM['nSolTaller']>0){
			// Encabezado 
			$pdf->AddPage();
			$pdf->SetXY(10,5);
			$pdf->Image('../../imagenes/logoSimetCam.png',10,5,43,16);
	
			$pdf->SetFont('Arial','B',18);
			$pdf->SetTextColor($cR, $cG, $cB);
			$pdf->SetXY(90,12);
			$pdf->Cell(40,5,'Solicitud servicio a taller N°'.$rowRAM['nSolTaller'],0,0,'C');
			$pdf->SetTextColor(0,0,0);
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
				$pdf->Cell(144,7,$rowUs['usuario'],0,0,'L');
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
						$pdf->Cell(100,7,'Nombre del técnico responsable',0,0,'L');
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
						$pdf->Image('../../imagenes/logoSimetCam.png',10,5,43,16);
				
						$pdf->SetFont('Arial','B',18);
						$pdf->SetXY(90,12);
						$pdf->SetTextColor($cR, $cG, $cB);
						$pdf->Cell(40,5,'Solicitud servicio a taller N°'.$rowRAM['nSolTaller'],0,0,'C');
						$pdf->SetTextColor(0,0,0);
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
						
					}

					if($nPagServ > 1){
						// Imprimir Pie de Otam
						if($ctlLin == 5){
							$nPagServ++;
							$ctlLin = 0;
							// Encabezado 
							$pdf->AddPage();
							$pdf->SetXY(10,5);
							$pdf->Image('../../imagenes/logoSimetCam.png',10,5,43,16);
					
							$pdf->SetFont('Arial','B',18);
							$pdf->SetXY(90,12);
							$pdf->SetTextColor($cR, $cG, $cB);
							$pdf->Cell(40,5,'Solicitud servicio a taller N°'.$rowRAM['nSolTaller'],0,0,'C');
							$pdf->SetTextColor(0,0,0);
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
		//				$pdf->SetXY(40,$ln);
		//				$pdf->Cell(144,7,$rowMu[idItem],0,0,'L');
						$ln += 30;
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
//					$pdf->SetXY(40,$ln);
//					$pdf->Cell(144,7,$rowMu[idItem],0,0,'L');
					$ln += 30;
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
				$pdf->Cell(100,7,'Nombre del técnico responsable',0,0,'L');
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


		
		//Imprimir Otam Tracci�n
		$nPag = 0;
		$nTra = 5;

		/* +++ */
		$SQLMm = "SELECT * FROM amMuestras Where idItem Like '%".$RAM."%' and conEnsayo != 'off' Order By idItem";
		$bdMm=$link->query($SQLMm);
		if($rowMm=mysqli_fetch_array($bdMm)){
			do{

				$Otam = $RAM.'-T';
				$SQL = "SELECT * FROM OTAMs Where RAM = '".$RAM."' and Otam Like '%".$Otam."%' and idItem = '".$rowMm['idItem']."' Order By idItem";
				$bdMu=$link->query($SQL);
				if($rowMu=mysqli_fetch_array($bdMu)){
					do{
						if($nTra >= 5){
							$nPag++;
							$nTra = 0;
							// Encabezado 
							$pdf->AddPage();
							$pdf->SetXY(10,5);
							$pdf->Image('../../imagenes/logoSimetCam.png',10,5,43,16);
								
							$pdf->SetFont('Arial','B',18);
							$pdf->SetXY(90,12);
							$pdf->SetTextColor($cR, $cG, $cB);
							$pdf->Cell(40,5,'OTAM-'.$RAM.'-T',0,0,'C');
							$pdf->SetTextColor(0,0,0);
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
		
							$ln = 5;
							
							// Pie
							$pdf->SetFont('Arial','B',10);
							$pdf->SetXY(10,220);
							$pdf->Cell(30,4,'Técnico responsable',0,0,'L');
					
							$pdf->SetXY(100,220);
							$pdf->Cell(30,4,'Solicitante',0,0,'L');
					
							$pdf->SetXY(10,225);
							$pdf->Cell(15,10,"",1,0,'C');
							$pdf->Cell(15,10,"",1,0,'C');
							$pdf->Cell(15,10,"",1,0,'C');
					
							$pdf->SetXY(100,225);
							$pdf->Cell(15,10,substr($rowRAM['cooResponsable'],0,1),1,0,'C');
							$pdf->Cell(15,10,substr($rowRAM['cooResponsable'],1,1),1,0,'C');
							$pdf->Cell(15,10,substr($rowRAM['cooResponsable'],2,1),1,0,'C');
		
							$pdf->SetFont('Arial','',9);
							$pdf->SetXY(150,245);
							$pdf->Cell(15,10,'Reg 240012-V.02',0,0,'R');
							// Fin Pie
						}
						
						if($nPag >= 1) { $ln += 18; }
						$nTra++;
							
						$lnTxt = "IDENTIFICACIÓN ";
						$pdf->SetFont('Arial','B',11);
						$pdf->SetXY(10,$ln); 
						$pdf->Cell(50,5,$lnTxt,0,0,'C');
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
		
						$pdf->SetFont('Arial','',11);
						$lnTxt = 'Diámetro';
						$pdf->SetXY(60,$ln);
						$pdf->MultiCell(25,5,$lnTxt,1,'L');
						$lnTxt = '';
						$pdf->SetXY(85,$ln);
						$pdf->MultiCell(25,5,$lnTxt,1,'L');
	
						$lnTxt = 'Fluencia';
						$pdf->SetXY(110,$ln);
						$pdf->MultiCell(18,5,$lnTxt,1,'L');
						$lnTxt = '';
						$pdf->SetXY(110,$ln);
						$pdf->MultiCell(18,5,$lnTxt,1,'L');
		
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
						$pdf->SetFont('Arial','',11);
							
						$lnTxt = 'Espesor';
						$pdf->SetXY(60,$ln);
						$pdf->MultiCell(25,5,$lnTxt,1,'L');
						$lnTxt = '';
						$pdf->SetXY(85,$ln);
						$pdf->MultiCell(25,5,$lnTxt,1,'L');
		
						$lnTxt = 'UTS';
						$pdf->SetXY(110,$ln);
						$pdf->MultiCell(18,5,$lnTxt,1,'L');
						$lnTxt = '';
						$pdf->SetXY(110,$ln);
						$pdf->MultiCell(18,5,$lnTxt,1,'L');
		
						$lnTxt = '';
						$pdf->SetXY(128,$ln);
						$pdf->MultiCell(19,5,$lnTxt,1,'L');
		
						$lnTxt = 'Temp.';
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
		
						$lnTxt = 'Ancho';
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
		
						$lnTxt = 'Hum.';
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
							$pdf->Cell(50,5,$lnTxt,0,0,'C');
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
		
							$pdf->SetFont('Arial','',11);
							$lnTxt = 'Diámetro';
							$pdf->SetXY(60,$ln);
							$pdf->MultiCell(25,5,$lnTxt,1,'L');
							$lnTxt = '';
							$pdf->SetXY(85,$ln);
							$pdf->MultiCell(25,5,$lnTxt,1,'L');
		
							$lnTxt = 'Fluencia';
							$pdf->SetXY(110,$ln);
							$pdf->MultiCell(18,5,$lnTxt,1,'L');
							$lnTxt = '';
							$pdf->SetXY(110,$ln);
							$pdf->MultiCell(18,5,$lnTxt,1,'L');
		
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
		
							$lnTxt = 'Espesor';
							$pdf->SetXY(60,$ln);
							$pdf->MultiCell(25,5,$lnTxt,1,'L');
							$lnTxt = '';
							$pdf->SetXY(85,$ln);
							$pdf->MultiCell(25,5,$lnTxt,1,'L');
		
							$lnTxt = 'UTS';
							$pdf->SetXY(110,$ln);
							$pdf->MultiCell(18,5,$lnTxt,1,'L');
							$lnTxt = '';
							$pdf->SetXY(110,$ln);
							$pdf->MultiCell(18,5,$lnTxt,1,'L');
		
							$lnTxt = '';
							$pdf->SetXY(128,$ln);
							$pdf->MultiCell(19,5,$lnTxt,1,'L');
		
							$lnTxt = 'Temp.';
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
		
							$lnTxt = 'Ancho';
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
		
							$lnTxt = 'Hum.';
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
		
		//Fin Imprimir Otam Tracci�n

		//Imprimir Otam Dureza
				$nPag = 0;
				$nDur = 5;

		/* ++++ */
		$SQLMm = "SELECT * FROM amMuestras Where idItem Like '%".$RAM."%' and conEnsayo != 'off' Order By idItem";
		$bdMm=$link->query($SQLMm);
		if($rowMm=mysqli_fetch_array($bdMm)){
			do{

				$Sw	  = false;
				$Otam = $RAM.'-D';
				//$SQL = "SELECT * FROM OTAMs Where RAM = '".$RAM."' and Otam Like '%".$Otam."%' and idItem = '".$rowMm['idItem']."' Order By idItem";
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
							$pdf->Image('../../imagenes/logoSimetCam.png',10,5,43,16);
								
							$pdf->SetFont('Arial','B',18);
							$pdf->SetXY(90,12);
							$pdf->SetTextColor($cR, $cG, $cB);
							$pdf->Cell(40,5,'OTAM-'.$RAM.'-D',0,0,'C');
							$pdf->SetTextColor(0,0,0);
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
		
							$ln = 5;
							
							// Pie
							$pdf->SetFont('Arial','B',10);
							$pdf->SetXY(10,220);
							$pdf->Cell(30,4,'Técnico responsable',0,0,'L');
					
							$pdf->SetXY(100,220);
							$pdf->Cell(30,4,'Solicitante',0,0,'L');
					
							$pdf->SetXY(10,225);
							$pdf->Cell(15,10,"",1,0,'C');
							$pdf->Cell(15,10,"",1,0,'C');
							$pdf->Cell(15,10,"",1,0,'C');
					
							$pdf->SetXY(100,225);
							$pdf->Cell(15,10,substr($rowRAM['cooResponsable'],0,1),1,0,'C');
							$pdf->Cell(15,10,substr($rowRAM['cooResponsable'],1,1),1,0,'C');
							$pdf->Cell(15,10,substr($rowRAM['cooResponsable'],2,1),1,0,'C');
		
							$pdf->SetFont('Arial','',9);
							$pdf->SetXY(150,245);
							$pdf->Cell(15,10,'Reg 240202-V.03',0,0,'R');
							// Fin Pie
						}
							if($nPag >= 1) { $ln += 18; }
							$nDur++;
							
							if($Sw == true) {
								$pdf->SetFont('Arial','B',11);
								$pdf->SetXY(10,$ln);
								$pdf->Cell(30,4,'N° de Probetas:',0,0,'L');
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
							$pdf->MultiCell(70,30,"",1,'C');
		
							$ln += 5;
							$pdf->SetFont('Arial','',11);
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(25,5,"T",1,'C');
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
							$pdf->MultiCell(25,5,"H",1,'C');
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
							$lnTxt = 'OBSERVACIONES';
							$pdf->SetXY(10,$ln);
							$pdf->Cell(25,5,$lnTxt,0,0,'L');
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(105,15,"",1,'C');
					}while($rowMu=mysqli_fetch_array($bdMu));
				}

			}while($rowMm=mysqli_fetch_array($bdMm));
					for($i=$nDur+1;  $i<=5; $i++){
		
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
							$pdf->MultiCell(70,30,"",1,'C');
		
							$ln += 5;
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(25,5,"T",1,'C');
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
							$pdf->MultiCell(25,5,"H",1,'C');
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
							$lnTxt = 'OBSERVACIONES';
							$pdf->SetXY(10,$ln);
							$pdf->Cell(25,5,$lnTxt,0,0,'L');
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(105,15,"",1,'C');
					}
		}
		
		//Fin Imprimir Otam Dureza


		//Imprimir Otam Qu�mico
		/* ++++ */
		$nPag = 0;
		$nQui = 5;
		$SQLMm = "SELECT * FROM amMuestras Where idItem Like '%".$RAM."%' and conEnsayo != 'off' Order By idItem";
		$bdMm=$link->query($SQLMm);
		if($rowMm=mysqli_fetch_array($bdMm)){
			do{

				$Sw	  = false;
				
				$Otam = $RAM.'-Q';
				$SQL = "SELECT * FROM OTAMs Where RAM = '".$RAM."' and Otam Like '%".$Otam."%' and idItem = '".$rowMm['idItem']."' Order By idItem";
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
							$pdf->Image('../../imagenes/logoSimetCam.png',10,5,43,16);
								
							$pdf->SetFont('Arial','B',18);
							$pdf->SetXY(90,12);
							$pdf->SetTextColor($cR, $cG, $cB);
							$pdf->Cell(40,5,'OTAM-'.$RAM.'-Q',0,0,'C');
							$pdf->SetTextColor(0,0,0);
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
		
							$ln = 5;
							
							// Pie
							$pdf->SetFont('Arial','B',10);
							$pdf->SetXY(10,220);
							$pdf->Cell(30,4,'Técnico responsable',0,0,'L');
					
							$pdf->SetXY(100,220);
							$pdf->Cell(30,4,'Solicitante',0,0,'L');
					
							$pdf->SetXY(10,225);
							$pdf->Cell(15,10,"",1,0,'C');
							$pdf->Cell(15,10,"",1,0,'C');
							$pdf->Cell(15,10,"",1,0,'C');
					
							$pdf->SetXY(100,225);
							$pdf->Cell(15,10,substr($rowRAM['cooResponsable'],0,1),1,0,'C');
							$pdf->Cell(15,10,substr($rowRAM['cooResponsable'],1,1),1,0,'C');
							$pdf->Cell(15,10,substr($rowRAM['cooResponsable'],2,1),1,0,'C');
		
							$pdf->SetFont('Arial','',9);
							$pdf->SetXY(150,245);
							$pdf->Cell(15,10,'Reg 240203-V.01',0,0,'R');
							// Fin Pie
						}
							if($nPag >= 1) { $ln += 18; }
							$nQui++;
/*							
							if($Sw == false) {
								$pdf->SetFont('Arial','B',11);
								$pdf->SetXY(10,$ln);
								$pdf->Cell(30,4,'EMPRESA :'.$rowCli['Cliente'],0,0,'L');
								$ln += 5;
								$pdf->Line(10, $ln, 184, $ln);
								$ln += 5;
								$Sw = false;
							}
*/		
							$pdf->SetFont('Arial','B',11);
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(50,5,"IDENTIFICACION",1,'C');
							$pdf->SetXY(60,$ln);
							$pdf->MultiCell(50,5,"ALEACIÓN BASE",1,'C');
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
							$pdf->MultiCell(50,5,"IDENTIFICACION",1,'C');
							$pdf->SetXY(60,$ln);
							$pdf->MultiCell(50,5,"ALEACIÓN BASE",1,'C');
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
		
		//Fin Imprimir Otam Qu�mico
				$nPag = 0;
				$nCha = 5;
		
		//Imprimir Otam Charpy
		/* ++++ */
		$SQLMm = "SELECT * FROM amMuestras Where idItem Like '%".$RAM."%' and conEnsayo != 'off' Order By idItem";
		$bdMm=$link->query($SQLMm);
		if($rowMm=mysqli_fetch_array($bdMm)){
			do{
				$Sw	  = false;
				
				$Otam = $RAM.'-Ch';
				$SQL = "SELECT * FROM OTAMs Where RAM = '".$RAM."' and Otam Like '%".$Otam."%' and idItem = '".$rowMm['idItem']."' Order By idItem";
				$bdMu=$link->query($SQL);
				if($rowMu=mysqli_fetch_array($bdMu)){
					do{
						$Ind = $rowMu['Ind'];
						$LetraCha = 'A';
						
						for($i=1;  $i<=$Ind; $i++){
							if($nCha > 4){
								$nPag++;
								$nCha = 0;
								$Sw   = true;
								// Encabezado 
								$pdf->AddPage();
								$pdf->SetXY(10,5);
								$pdf->Image('../../imagenes/logoSimetCam.png',10,5,43,16);
									
								$pdf->SetFont('Arial','B',18);
								$pdf->SetXY(90,12);
								$pdf->SetTextColor($cR, $cG, $cB);
								$pdf->Cell(40,5,'OTAM-'.$RAM.'-Ch',0,0,'C');
								$pdf->SetTextColor(0,0,0);
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
			
								$ln = 5;
								
								// Pie
								$pdf->SetFont('Arial','B',10);
								$pdf->SetXY(10,220);
								$pdf->Cell(30,4,'Técnico responsable',0,0,'L');
						
								$pdf->SetXY(100,220);
								$pdf->Cell(30,4,'Solicitante',0,0,'L');
						
								$pdf->SetXY(10,225);
								$pdf->Cell(15,10,"",1,0,'C');
								$pdf->Cell(15,10,"",1,0,'C');
								$pdf->Cell(15,10,"",1,0,'C');
						
								$pdf->SetXY(100,225);
								$pdf->Cell(15,10,substr($rowRAM['cooResponsable'],0,1),1,0,'C');
								$pdf->Cell(15,10,substr($rowRAM['cooResponsable'],1,1),1,0,'C');
								$pdf->Cell(15,10,substr($rowRAM['cooResponsable'],2,1),1,0,'C');
			
								$pdf->SetFont('Arial','',9);
								$pdf->SetXY(150,245);
								$pdf->Cell(15,10,'Reg 240205-V0 V.02',0,0,'R');
								// Fin Pie
							}
							if($nPag >= 1) { $ln += 18; }
							$nCha++;

/*							
							if($Sw == true) {
								$pdf->SetFont('Arial','B',11);
								$pdf->SetXY(10,$ln);
								$pdf->Cell(30,4,$rowCli['Cliente'],0,0,'L');
								$ln += 5;
								$pdf->Line(10, $ln, 184, $ln);
								$ln += 5;
								$Sw = false;
							}
*/		
							$pdf->SetFont('Arial','B',11);
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(50,5,"IDENTIFICACIÓN",1,'C');
							$pdf->SetXY(60,$ln);
							$pdf->MultiCell(125,5,"RESUMEN RESULTADOS",1,'C');
		
							$ln += 5;
							$pdf->SetXY(10,$ln);
							$pdf->SetTextColor($cR, $cG, $cB);
							$pdf->MultiCell(50,5,$rowMu['Otam'].' '.$LetraCha,1,'C');
							$pdf->SetTextColor(0,0,0);
							$pdf->SetFont('Arial','',11);
							$pdf->SetXY(60,$ln);
							$pdf->MultiCell(31,5,'Ancho (mm)',1,'C');
							$pdf->SetXY(91,$ln);
							$pdf->MultiCell(31,5,'Alto (mm)',1,'C');
							$pdf->SetXY(122,$ln);
							$pdf->MultiCell(31,5,'E. absorbida (J)',1,'C');
							$pdf->SetXY(153,$ln);
							$pdf->MultiCell(32,5,'E. corregida (J)',1,'C');
		
							$ln += 5;
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(50,5,'FECHA',1,'C');
							$pdf->SetFont('Arial','',11);
							$pdf->SetXY(60,$ln);
							$pdf->MultiCell(31,5,'',1,'C');
							$pdf->SetXY(91,$ln);
							$pdf->MultiCell(31,5,'',1,'C');
							$pdf->SetXY(122,$ln);
							$pdf->MultiCell(31,5,'',1,'C');
							$pdf->SetXY(153,$ln);
							$pdf->MultiCell(32,5,'',1,'C');
		
							$ln += 5;
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(50,5,'',1,'C');
							$pdf->SetFont('Arial','',10);
							$pdf->SetXY(60,$ln);
							$pdf->MultiCell(31,5,'TEMPERATURA',1,'C');
							$pdf->SetXY(91,$ln);
							$pdf->MultiCell(31,5,'',1,'C');
							$pdf->SetXY(122,$ln);
							$pdf->MultiCell(31,5,'HUMEDAD',1,'C');
							$pdf->SetXY(153,$ln);
							$pdf->MultiCell(32,5,'',1,'C');
		
							$ln += 5;
							$lnTxt = 'OBSERVACIONES';
							$pdf->SetXY(10,$ln);
							$pdf->Cell(25,5,$lnTxt,0,0,'L');
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(175,14,"",1,'C');
		
							$LetraCha++;
						}
					}while($rowMu=mysqli_fetch_array($bdMu));
				}
		
			}while($rowMm=mysqli_fetch_array($bdMm));
					for($i=$nCha+1;  $i<=5; $i++){
		
							$ln += 18;
							$pdf->SetFont('Arial','B',11);
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(50,5,"IDENTIFICACIÓN",1,'C');
							$pdf->SetXY(60,$ln);
							$pdf->MultiCell(125,5,"RESUMEN RESULTADOS",1,'C');
		
							$ln += 5;
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(50,5,'__-Ch-__',1,'C');
							$pdf->SetFont('Arial','',11);
							$pdf->SetXY(60,$ln);
							$pdf->MultiCell(31,5,'Ancho (mm)',1,'C');
							$pdf->SetXY(91,$ln);
							$pdf->MultiCell(31,5,'Alto (mm)',1,'C');
							$pdf->SetXY(122,$ln);
							$pdf->MultiCell(31,5,'E. absorbida (J)',1,'C');
							$pdf->SetXY(153,$ln);
							$pdf->MultiCell(32,5,'E. corregida (J)',1,'C');
		
							$ln += 5;
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(50,5,'FECHA',1,'C');
							$pdf->SetFont('Arial','',11);
							$pdf->SetXY(60,$ln);
							$pdf->MultiCell(31,5,'',1,'C');
							$pdf->SetXY(91,$ln);
							$pdf->MultiCell(31,5,'',1,'C');
							$pdf->SetXY(122,$ln);
							$pdf->MultiCell(31,5,'',1,'C');
							$pdf->SetXY(153,$ln);
							$pdf->MultiCell(32,5,'',1,'C');
		
							$ln += 5;
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(50,5,'',1,'C');
							$pdf->SetFont('Arial','',10);
							$pdf->SetXY(60,$ln);
							$pdf->MultiCell(31,5,'TEMPERATURA',1,'C');
							$pdf->SetXY(91,$ln);
							$pdf->MultiCell(31,5,'',1,'C');
							$pdf->SetXY(122,$ln);
							$pdf->MultiCell(31,5,'HUMEDAD',1,'C');
							$pdf->SetXY(153,$ln);
							$pdf->MultiCell(32,5,'',1,'C');
		
							$ln += 5;
							$lnTxt = 'OBSERVACIONES';
							$pdf->SetXY(10,$ln);
							$pdf->Cell(25,5,$lnTxt,0,0,'L');
							$pdf->SetXY(10,$ln);
							$pdf->MultiCell(175,14,"",1,'C');
					}
		}
		//Fin Imprimir Otam Charpy
		

	}
	$link->close();
	//$pdf->Output('F3B-00001.pdf','I'); //Para Descarga
	$NombreFormulario = "RAM-".$RAM.".pdf";
	$pdf->Output($NombreFormulario,'D'); //Para Descarga
	//$pdf->Output('F3B-00001.pdf','F');

?>
