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
		$pdf->Image('../../imagenes/logocert.png',10,5,43,16);

		$pdf->SetFont('Arial','B',18);
		$r = $RAM;

		//$rRam = $r - (intval($r / 1000)*1000);
		$rRam = intval((($r / 10) - intval($r / 10)) * 10);

		if($rRam > 4) { $rRam = $rRam - 5; }
		
		$cR = 0; $cG = 0; $cB = 0;
		
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
		$pdf->Image('../../imagenes/logocert.png',185,245,20,8);
		
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
		$pdf->SetXY(10,5);
		$pdf->Image('../../imagenes/logocert.png',10,5,43,16);

		$pdf->SetFont('Arial','B',18);
		$pdf->SetXY(80,12);
		$pdf->SetTextColor($cR, $cG, $cB);
		$pdf->Cell(30,5,'RAM '.$RAM,0,0,'C');
		$pdf->SetTextColor(0,0,0);

		$pdf->SetFont('Arial','B',14);
		$pdf->SetXY(80,20);
		$pdf->SetTextColor($cR, $cG, $cB);
		$pdf->Cell(30,5,'Solicitud de Ensayos bajo NCh203',0,0,'C');
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('Arial','',10);

		$pdf->SetXY(50,17);
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(10,5,'',0,0);

		$pdf->SetXY(10,17);
		$pdf->Image('../../gastos/logos/logousach.png',195,5,15,23);

		$pdf->SetDrawColor(0, 0, 0);
		$pdf->Image('../../imagenes/logocert.png',185,245,20,8);
		
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
		while($rowMu=mysqli_fetch_array($bdMu)){
				$sqlOtam = "SELECT * FROM OTAMs Where idItem = '".$rowMu['idItem']."' Order By idItem, Otam";
				$bdOT=$link->query($sqlOtam);
				if($rowOT=mysqli_fetch_array($bdOT)){
					$sqlOtam = "SELECT * FROM OTAMs Where idItem = '".$rowMu['idItem']."' Order By idItem, Otam";
					$bdOT=$link->query($sqlOtam);
					while($rowOT=mysqli_fetch_array($bdOT)){
							$nOtam++;
							if($nOtam <= 20){
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
							}else{
								$nOtam = 0;
								$pdf->SetFont('Arial','',9);
								$pdf->SetXY(150,245);
								$pdf->Cell(15,10,'Reg 100403-V.0',0,0,'R');
						
								$pdf->AddPage();

								$pdf->SetXY(10,5);
								$pdf->Image('../../imagenes/logocert.png',10,5,43,16);
						
								$pdf->SetFont('Arial','B',18);
								$pdf->SetXY(80,12);
								$pdf->SetTextColor($cR, $cG, $cB);
								$pdf->Cell(30,5,'RAM '.$RAM,0,0,'C');
								$pdf->SetTextColor(0,0,0);
						
								$pdf->SetFont('Arial','B',14);
								$pdf->SetXY(80,20);
								$pdf->SetTextColor($cR, $cG, $cB);
								$pdf->Cell(30,5,'Solicitud de Ensayos bajo NCh203',0,0,'C');
								$pdf->SetTextColor(0,0,0);
								$pdf->SetFont('Arial','',10);
												
								$pdf->SetXY(50,17);
								$pdf->SetFont('Arial','B',8);
								$pdf->Cell(10,5,'',0,0);
						
								$pdf->SetXY(10,17);
								$pdf->Image('../../gastos/logos/logousach.png',195,5,15,23);
						
								$pdf->SetDrawColor(0, 0, 0);
								$pdf->Image('../../imagenes/logocert.png',185,245,20,8);
								
								$pdf->SetXY(197,30);
								$pdf->Cell(30,4,$CAM,0,0,'L');
						
								$pdf->SetDrawColor(200, 200, 200);
								$pdf->Line(190, 30, 190, 270);
								$pdf->SetDrawColor(0, 0, 0);

								$ln = 25;


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
						

							}
					} 
				}
		}


		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(150,245);
		$pdf->Cell(15,10,'Reg 100403-V.0',0,0,'R');




	}





	$agnoActual = date('Y');
	$vDirEnsayos = 'Y://AAA/OCP/AR/'.$agnoActual.'/'; 
	if(!file_exists($vDirEnsayos)){
		mkdir($vDirEnsayos);
	}	
	$vDirEnsayos = 'Y://AAA/OCP/AR/'.$agnoActual.'/AR-'.$RAM.'/'; 
	if(!file_exists($vDirEnsayos)){
		mkdir($vDirEnsayos);
	}	

	//$pdf->Output('F3B-00001.pdf','I'); //Para Descarga
	$NombreFormulario = "RAMAR-".$RAM.".pdf";
	$NombreOtam = "RAMAR-".$RAM.".pdf";
	$pdf->Output($NombreFormulario,'D'); //Para Descarga 
	$pdf->Output($vDirEnsayos.$NombreOtam,'F'); //Para Descarga
	// copy($NombreOtam, $vDirEnsayos.'/'.$NombreOtam);
	unlink($NombreOtam);
?>

