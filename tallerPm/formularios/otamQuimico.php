<?php
	require_once('../../fpdf/fpdf.php');
	include_once("../../conexionli.php");
	header('Content-Type: text/html; charset=utf-8');
	$OtamActual = '';
	if(isset($_GET['RAM'])) 		{ $RAM 			= $_GET['RAM'];			} 
	if(isset($_GET['CodInforme'])) 	{ $CodInforme 	= $_GET['CodInforme'];	} 
	if(isset($_GET['Otam'])) 		{ $Otam 		= $_GET['Otam'];		}
	if(isset($_GET['Otam'])) 		{ $OtamActual 	= $_GET['Otam'];		}
	if(isset($_GET['accion'])) 		{ $accion 		= $_GET['accion'];		}
	$OtamQu = $Otam;
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
	$bdRAM=$link->query("SELECT * FROM formram WHERE RAM = '".$RAM."'");
	if($rowRAM=mysqli_fetch_array($bdRAM)){
		if($rowRAM['CAM'] > 0){
			$CAM = $rowRAM['CAM'];
		}
		$pdf=new FPDF('P','mm','Letter');

		// Encabezado 
		//$pdf->AddPage();

		$pdf->SetFont('Arial','B',18);
		$r = $RAM;

		//$rRam = intval((($r / 10) - intval($r / 10)) * 10);

		//if($rRam > 4) { $rRam = $rRam - 5; }
		
		$cR = 0; $cG = 0; $cB = 0;
		
		/* Negro */
		//if($rRam == 0){ $cR = 0; $cG = 0; $cB = 0; }
		
		/* Azul */
		//if($rRam == 1){ $cR = 0; $cG = 102; $cB = 204; }
		
		/* Verde */
		//if($rRam == 2){ $cR = 0; $cG = 204; $cB = 102; }
		
		/* Cafe */
		//if($rRam == 3){ $cR = 153; $cG = 76; $cB = 0; }
		
		/* Rojo */
		//if($rRam == 4){ $cR = 255; $cG = 0; $cB = 0; }
		
		$pdf->SetTextColor($cR, $cG, $cB);
		$nContacto = 0;
		$bdCAM=$link->query("SELECT * FROM cotizaciones WHERE RAM = '".$RAM."'");
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
		$bdCli=$link->query("SELECT * FROM clientes WHERE RutCli = '".$RutCli."'");
		if($rowCli=mysqli_fetch_array($bdCli)){
		}
		$ln += 5;
		$ln = 25;
		$bdCli=$link->query("SELECT * FROM clientes WHERE RutCli = '".$RutCli."'");
		if($rowCli=mysqli_fetch_array($bdCli)){

			$ln += 8;
			$bdCAM=$link->query("SELECT * FROM cotizaciones WHERE CAM = '".$CAM."' and RAM = '".$RAM."'");
			if($rowCAM=mysqli_fetch_array($bdCAM)){
				$RutCli 		= $rowCAM['RutCli'];
				$Atencion 		= $rowCAM['Atencion'];
				$RutCli			= $rowCAM['RutCli'];
				$usrResponsable	= $rowCAM['usrResponzable'];
			}

			$bdCon=$link->query("SELECT * FROM contactoscli WHERE RutCli = '".$RutCli."' and Contacto = '".$Atencion."'");
			if($rowCon=mysqli_fetch_array($bdCon)){

			}
		}
		$ln += 5;


		$nOtam = 0;
		$fo = explode('-',$Otam);
		$idItem = $fo[0].'-'.$fo[1];


		// Siguientes Registros de OTAMs
	
		$sqlOtams	= "SELECT * FROM otams Where RAM = '".$RAM."' and idEnsayo = 'Qu'";  // sentencia sql
		$result 	= $link->query($sqlOtams);
		$tOtams 	= mysqli_num_rows($result); // obtenemos el número de Otams
/*		
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
										$pdf->Cell(15,10,'Reg 2401-V.05',0,0,'R');
										
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
										$pdf->Cell(15,10,'Reg 2401-V.05',0,0,'R');
										
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
	
		}
*/		
		// Imprimir Solicitud Servicio a Taller SST
/*		
		if($rowRAM['nSolTaller']>0){
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
						$pdf->SetFont('Arial','',12);
						$pdf->MultiCell(180,7,utf8_decode($rowMu['Objetivo']),0,'L');

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
					//$pdf->MultiCell(180,7,utf8_decode($rowMu['Objetivo']),0,'L');

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
					$pdf->SetFont('Arial','',12);
					if(!empty($rowMu['Objetivo'])){
						$pdf->MultiCell(180,7,utf8_decode($rowMu['Objetivo']),0,'L');
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
*/		
		//Fin Solicitud Servicio de Taller


		// Imprimir Solicitud Servicio a Taller SST
		/*
		if($rowRAM['nSolTaller']>0){
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
						$pdf->SetFont('Arial','',12);
						$pdf->MultiCell(180,7,utf8_decode($rowMu['Objetivo']),0,'L');

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
					//$pdf->MultiCell(180,7,$rowMu['Objetivo'],0,'L');

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
		*/
		//Fin Solicitud Servicio de Taller Copia


		
		$nPag = 0;
		$nDur = 5;

		//Imprimir Otam Químico
		/* ++++ */
		$nPag = 0;
		$nQui = 5;
		$SQLMm = "SELECT * FROM ammuestras Where idItem = '".$idItem."' and conEnsayo != 'off' Order By idItem";
		$bdMm=$link->query($SQLMm);
		while($rowMm=mysqli_fetch_array($bdMm)){

				$Sw	  = false;
				
				$Otam = $RAM;
				$SQL = "SELECT * FROM otams Where RAM = '".$RAM."' and Otam = '".$OtamQu."' and idItem = '".$rowMm['idItem']."'  and idEnsayo = 'Qu' Order By idItem";
				$bdMu=$link->query($SQL);
				while($rowMu=mysqli_fetch_array($bdMu)){
					$Aleacion = '';
					$sqlQu = "SELECT * FROM regquimico Where idItem = '".$OtamQu."' and CodInforme = '$CodInforme' and Programa != ''";
					$bd=$link->query($sqlQu);
					if($rs=mysqli_fetch_array($bd)){
						if($rs['tpMuestra'] == 'Ac'){ $Aleacion = 'Acero'; }
						if($rs['tpMuestra'] == 'Al'){ $Aleacion = 'Aluminio'; }
						if($rs['tpMuestra'] == 'Co'){ $Aleacion = 'Cobre'; }
					}
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
							$pdf->Cell(15,10,utf8_decode(substr($rowMu['tecRes'],0,1)),1,0,'C');
							$pdf->Cell(15,10,utf8_decode(substr($rowMu['tecRes'],1,1)),1,0,'C');
							$pdf->Cell(15,10,utf8_decode(substr($rowMu['tecRes'],2,1)),1,0,'C');
					
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
					$pdf->MultiCell(50,10,$Aleacion,1,'C');
					$pdf->SetXY(110,$ln);
					$pdf->MultiCell(75,15,$rs['Observacion'],1,'C');
					
					$ln += 5;
					$pdf->SetFont('Arial','',11);
					$pdf->SetXY(10,$ln);
					$fd = explode('-', $rs['fechaRegistro']); 
					
					$pdf->MultiCell(50,5,'FECHA: '.$fd[2].'/'.$fd[1].'/'.$fd[0],1,'L');
					
					$ln += 5;
					$pdf->SetFont('Arial','B',10);
					$pdf->SetXY(10,$ln);
					$pdf->MultiCell(50,5,'TEMPERATURA',1,'C');
					$pdf->SetXY(60,$ln);
					$pdf->MultiCell(50,5,utf8_decode($rs['Temperatura'].'ºC'),1,'C');
					$pdf->SetXY(110,$ln);
					$pdf->MultiCell(30,5,'HUMEDAD',1,'L');
					$pdf->SetXY(140,$ln);
					$pdf->MultiCell(45,5, utf8_decode($rs['Humedad'].'%'),1,'C');
					
					$ln += 5;
					$lnTxt = 'OBSERVACIONES';
					$pdf->SetXY(10,$ln);
					$pdf->Cell(25,5,$lnTxt,0,0,'L');
					$pdf->SetXY(10,$ln);
					$pdf->MultiCell(175,14,"",1,'C');
				}
				if($rs['tpMuestra'] == 'Co'){
					$ln += 18;
					$nEspacios = 18;
					$nCol = 10;
					$pdf->SetFont('Arial','',8);
					$pdf->SetFillColor(220,220,220);

					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%Zn',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%Pb',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%Sn',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%P',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%Mn',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%Fe',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%Ni',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%Si',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%Mg',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios -5,5,'%As',1,'C',true);
					//$pdf->SetFillColor(0,0,0);

					$ln += 5;
					$nEspacios = 18;
					$nCol = 10;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cZn'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cPb'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cSn'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cP'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cMn'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cFe'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cNi'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cSi'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5, $rs['cMg'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios -5,5,$rs['cAs'],1,'C');

					// Segunda Linea
					$ln += 5;
					$nEspacios = 18;
					$nCol = 10;
					$pdf->SetFont('Arial','',8);
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%Sb',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%Bi',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%Ag',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%Co',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%Al',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%S',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%Cu',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'-',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'-',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios -5,5,'-',1,'C',true);
					
					$ln += 5;
					$nEspacios = 18;
					$nCol = 10;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cSb'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cBi'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cAg'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cCo'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cAl'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cS'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cCu'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'-',1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'-',1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios -5,5,'-',1,'C');

				}
				if($rs['tpMuestra'] == 'Al'){
					$ln += 18;
					$nEspacios = 18;
					$nCol = 10;
					$pdf->SetFont('Arial','',8);
					$pdf->SetFillColor(220,220,220);

					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%Si',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%Fe',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%Cu',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%Mn',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%Mg',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%Cr',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%Al',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%B',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%Ga',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios -5,5,'%V',1,'C',true);
					//$pdf->SetFillColor(0,0,0);

					$ln += 5;
					$nEspacios = 18;
					$nCol = 10;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cSi'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cFe'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cCu'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cMn'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cMg'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cCr'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cAl'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cB'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5, $rs['cGa'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios -5,5,$rs['cV'],1,'C');


				}
				if($rs['tpMuestra'] == 'Ac'){
					$ln += 18;
					$nEspacios = 18;
					$nCol = 10;
					$pdf->SetFont('Arial','',8);
					$pdf->SetFillColor(220,220,220);

					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%C',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%Si',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%Mn',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%P',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%S',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%Cr',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%Ni',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%Mo',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%Al',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios -5,5,'%Cu',1,'C',true);
					//$pdf->SetFillColor(0,0,0);

					$ln += 5;
					$nEspacios = 18;
					$nCol = 10;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cC'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cSi'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cMn'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cP'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cS'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cCr'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cNi'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cMo'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5, $rs['cAl'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios -5,5,$rs['cCu'],1,'C');


					// Segunda Linea
					$ln += 5;
					$nEspacios = 18;
					$nCol = 10;
					$pdf->SetFont('Arial','',8);
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%Co',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%Ti',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%Nb',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%V',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'%B',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'-',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'-',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'-',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'-',1,'C',true);
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios -5,5,'%Fe',1,'C',true);
					
					$ln += 5;
					$nEspacios = 18;
					$nCol = 10;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cCo'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cTi'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cNb'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cV'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,$rs['cB'],1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'-',1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'-',1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'-',1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios,5,'-',1,'C');
					$nCol += $nEspacios;
					$pdf->SetXY($nCol,$ln);
					$pdf->MultiCell($nEspacios -5,5,'RESTO',1,'C');
				}

		}
		
		//Fin Imprimir Otam Químico



		

	}

	$agnoActual = date('Y');
	// $vDir = 'Y://AAA/Archivador-'.$agnoActual.'/Laboratorio/Archivador-AM/'.$RAM.'/Qu';
	$vDir = 'Y://AAA/LE/LABORATORIO/'.$agnoActual.'/'.$RAM.'/Qu';
	if(!file_exists($vDir)){
		mkdir($vDir);
	}


	$NombreFormulario = "Otam-Quimico-".$OtamQu.".pdf";
	$pdf->Output($NombreFormulario,'F'); //Guarda en un Fichero
	//$pdf->Output($NombreFormulario,'D'); //Para Descarga
	//$pdf->Output('F3B-00001.pdf','F');
	copy($NombreFormulario, $vDir.'/'.$NombreFormulario);
	unlink($NombreFormulario);
	header('Location: ../iQuimico.php?Otam='.$OtamActual.'&CodInforme='.$CodInforme);


?>
