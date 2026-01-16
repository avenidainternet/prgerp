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

		
		// Imprimir Solicitud Servicio a Taller SST
		if($rowRAM['nSolTaller']>0){
			// Encabezado 
			$pdf->AddPage();
			$pdf->SetXY(10,5);
			$pdf->Image('../../imagenes/logoSimetCam.png',10,5,43,16);
	
			$pdf->SetFont('Arial','B',18);
			$pdf->SetXY(90,12);
			$pdf->Cell(40,5,'Solicitud servicio a taller N° '.$rowRAM['nSolTaller'],0,0,'C');
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFont('Arial','',10);
	
			$pdf->SetXY(50,17);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(10,5,'',0,0);
	
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
			while($rowMu=mysqli_fetch_array($bdMu)){
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
						$pdf->Cell(100,7,utf8_decode('Nombre del tÃ©cnico responsable'),0,0,'L');
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
						$pdf->Cell(40,5,utf8_decode('Solicitud servicio a taller NÂ°').$rowRAM['nSolTaller'],0,0,'C');
						$pdf->SetTextColor(0,0,0);
						$pdf->SetFont('Arial','',10);
				
						$pdf->SetXY(50,17);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(10,5,'',0,0);
				
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
							$pdf->Cell(40,5,'Solicitud servicio a taller N° '.$rowRAM['nSolTaller'],0,0,'C');
							$pdf->SetTextColor(0,0,0);
							$pdf->SetFont('Arial','',10);
					
							$pdf->SetXY(50,17);
							$pdf->SetFont('Arial','B',8);
							$pdf->Cell(10,5,'',0,0);
					
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
						$pdf->SetFont('Arial','',12);
						$pdf->MultiCell(180,7,utf8_decode($rowMu['Objetivo']),0,'L');

						$ln += 24;
						$pdf->Line(10, $ln, 184, $ln);
					}else{
						$nOtam--;
					}
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
					$pdf->MultiCell(180,7,utf8_decode($rowMu['Objetivo']),0,'L');

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
				$pdf->Cell(100,7,utf8_decode('Nombre del tÃ©cnico responsable'),0,0,'L');
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
					$pdf->SetFont('Arial','',12);
					$pdf->MultiCell(180,7,utf8_decode($rowMu['Objetivo']),0,'L');

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

	}
	
	//$pdf->Output('F3B-00001.pdf','I'); //Para Descarga
	$NombreFormulario = "RAM-".$RAM.".pdf";
	$pdf->Output($NombreFormulario,'D'); //Para Descarga
	//$pdf->Output('F3B-00001.pdf','F');

?>
