<?php
	require_once('../../fpdf/fpdf.php');
	include_once("../../conexionli.php");
	header('Content-Type: text/html; charset=utf-8');

	if(isset($_GET['RAM'])) 		{ $RAM 			= $_GET['RAM'];			} 
	if(isset($_GET['CAM'])) 		{ $CAM 			= $_GET['CAM'];			}
	if(isset($_GET['CodInforme'])) 	{ $CodInforme 	= $_GET['CodInforme'];	}
	if(isset($_GET['Otam'])) 		{ $Otam 		= $_GET['Otam'];		}
	if(isset($_GET['accion'])) 		{ $accion 		= $_GET['accion'];		}
		
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
	$Equipo = '';
	
	$link=Conectarse();
	$bdRAM=$link->query("SELECT * FROM formram WHERE RAM = '".$RAM."'");
	if($rowRAM=mysqli_fetch_array($bdRAM)){
		if($rowRAM['CAM'] > 0){
			$CAM = $rowRAM['CAM'];
		}
		$pdf=new FPDF('P','mm','Letter');

		// Encabezado 
		//$pdf->AddPage();
		$pdf->SetXY(10,5);

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
		$pdf->SetFillColor(220,220,220);

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
			$bdCon=$link->query("SELECT * FROM contactoscli WHERE RutCli = '".$RutCli."' and nContacto = '".$nContacto."'");
			if($rowCon=mysqli_fetch_array($bdCon)){


			}
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
		$sqlCh = "SELECT * FROM regcharpy Where idItem Like '%".$Otam."%'";
		$bd=$link->query($sqlCh);
		if($rs=mysqli_fetch_array($bd)){
			$Equipo = $rs['Equipo'];
		}

		$nPag = 0;
		$nCha = 6;
		$alto = 10;

		//Imprimir Otam Charpy
		$par = 0;
		$pieCharpy = false;
		$SQLMm = "SELECT * FROM ammuestras Where idItem Like '%".$RAM."%' and conEnsayo != 'off' Order By idItem";
		$SQLMm = "SELECT * FROM ammuestras Where idItem Like '%".$RAM."%' Order By idItem";
		$bdMm=$link->query($SQLMm);
		while($rowMm=mysqli_fetch_array($bdMm)){
				$Sw	  = false;

				$pieCharpy = false;
				$tecRes = '';
				//$Otam = $RAM; +++
				$SQL = "SELECT * FROM otams Where RAM = '".$RAM."' and Otam Like '%".$Otam."%' and idItem = '".$rowMm['idItem']."' and idEnsayo = 'Ch' Order By idItem";
				$bdMu=$link->query($SQL);
				while($rowMu=mysqli_fetch_array($bdMu)){
						$Ind = $rowMu['Ind'];
						$LetraCha = 'A';
						$pieCharpy = true;
						$ObsOtam = $rowMu['ObsOtam'];
						$tecRes = $rowMu['tecRes'];
						
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
									$pdf->SetFont('Arial','',8);
									$pdf->Cell(210,15,'Equipo '.$Equipo,1,0,'C', true);
						
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
								$pdf->MultiCell(80,7, utf8_decode($rowMu['TemAmb'].'ºC'),1,'C');
								$pdf->SetXY(90,$ln);
								$pdf->MultiCell(80,7,$rowMu['Hum'],1,'C');
								$pdf->SetXY(170,$ln);
								$sqlCh = "SELECT * FROM regcharpy Where idItem Like '%".$Otam."%'";
								$bd=$link->query($sqlCh);
								if($rs=mysqli_fetch_array($bd)){
									$fd = explode('-', $rs['fechaRegistro']); 
									$pdf->MultiCell(80,7,$fd[2].'/'.$fd[1].'/'.$fd[0],1,'C'); //
								}else{
									$pdf->MultiCell(80,7,'',1,'C'); //
								}
								$ln += 7;
								$pdf->SetFont('Arial','',12);
								$pdf->SetXY(10,$ln);
								$pdf->MultiCell(80,7,utf8_decode('Temperatura de ensayo (ºC)'),1,'C');
								$pdf->SetXY(90,$ln);
								$pdf->MultiCell(160,7,utf8_decode($rowMu['Tem'].'ºC'),1,'L');
								$ln += 7;
								$pdf->SetFont('Arial','B',10);
								$pdf->SetXY(10,$ln);
								$pdf->SetFillColor(218, 214, 214);
								$pdf->Cell(30,25,utf8_decode('Identificación'),1,0,'C', true);
								$pdf->SetFont('Arial','',8);
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
								$pdf->Cell(15,10,substr($tecRes,0,1),1,0,'C');
								$pdf->Cell(15,10,substr($tecRes,1,1),1,0,'C');
								$pdf->Cell(15,10,substr($tecRes,2,1),1,0,'C');
						
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
							$pdf->SetFont('Arial','',8);
							
							$pdf->Cell(30,$alto,$rowMu['Otam'].' '.$LetraCha,1,0,'C', $estadoSw);

							$sqlCh = "SELECT * FROM regcharpy Where idItem Like '%".$Otam."%' and nImpacto = '$i'";
							$bd=$link->query($sqlCh);
							if($rs=mysqli_fetch_array($bd)){
								//if(rs['CosProbMen4Ra'] == 'on'){'Si'}else{'No'}
								//$v1 = ;
								$pdf->SetFont('Symbol','',14);
								$pdf->Cell(21,$alto,($rs['CosProbMen4Ra'] == 'on' ? chr(214):chr(67)),1,0,'C', $estadoSw);
								$pdf->Cell(21,$alto,($rs['CarEntMen2Ra'] == 'on' ? chr(214):chr(67)),1,0,'C', $estadoSw);
								$pdf->Cell(21,$alto,($rs['Prob55'] == 'on' ? chr(214):chr(67)),1,0,'C', $estadoSw);
								$pdf->Cell(21,$alto,($rs['CentEnt27'] == 'on' ? chr(214):chr(67)),1,0,'C', $estadoSw);
								$pdf->Cell(21,$alto,($rs['AngEnt45'] == 'on' ? chr(214):chr(67)),1,0,'C', $estadoSw);
								$pdf->Cell(21,$alto,($rs['ProfEnt2mm'] == 'on' ? chr(214):chr(67)),1,0,'C', $estadoSw);
								$pdf->Cell(21,$alto,($rs['RadCorv025'] == 'on' ? chr(214):chr(67)),1,0,'C', $estadoSw);
								$pdf->SetFont('Arial','',8);

								$pdf->Cell(21,$alto,$rs['Ancho'],1,0,'C', $estadoSw);
								$pdf->Cell(21,$alto,$rs['Alto'],1,0,'C', $estadoSw);
								$pdf->Cell(21,$alto,$rs['vImpacto'],1,0,'C', $estadoSw);
							}else{
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
							}




							$pdf->SetFillColor(0, 0, 0);

							$LetraCha++;
						}
				}

			}
			$ln += 10; 
			$pdf->SetXY(10,$ln);
			$pdf->SetFillColor(218, 214, 214);

			$pdf->Cell(30,$alto,'Observaciones',1,0,'C', true);
			$pdf->Cell(210,$alto, 'Equipo '.$Equipo.' '.utf8_decode($ObsOtam),1,0,'L', true);
			$pdf->SetFillColor(0, 0, 0);

			if($pieCharpy == true){
				$ln += 10;
				$pdf->SetFont('Arial','B',10);
				$pdf->SetXY(10,$ln);
				$pdf->SetFillColor(218, 214, 214);
				$pdf->Cell(30,15,utf8_decode('Observaciones'),1,0,'C', true);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(210,15,'Equipo '.$Equipo,1,0,'C', true);
	
				$ln += 15;
				$pdf->SetXY(37,$ln);
				$pdf->SetFillColor(0, 0, 0);
				$pdf->MultiCell(215,5,utf8_decode('NOTA:  Ponga un Ticket si la muestra a ensayar cumple con el requerimiento, en caso que no ponga una cruz (X) e informe inmediatamente al Jefe de Laboratorio, o en su defecto al Gerente Técnico'),0,'L', false);
			}
		//Fin Imprimir Otam Charpy















		

	}

	$tmp = "tmp";
	if(!file_exists($tmp)){
		mkdir($tmp);
	}

	$agnoActual = date('Y'); 
	$vDir = 'Y://AAA/LE/LABORATORIO/'.$agnoActual.'/'.$RAM.'/Ch';
	if(!file_exists($vDir)){
		mkdir($vDir);
	}

	
	//$pdf->Output('F3B-00001.pdf','I'); //Para Descarga
	$NombreFormulario = 'Otam-Ch'.$Otam.".pdf";
	$pdf->Output($vDir.'/'.$NombreFormulario,'F'); //Guarda en un Fichero
	$pdf->Output($NombreFormulario,'D'); //Para Descarga

	// copy('../tmp/'.$NombreFormulario, $vDir.'/'.$NombreFormulario);
	//unlink($NombreFormulario);
	// header('Location: ../iCharpy.php?Otam='.$Otam.'&CodInforme='.$CodInforme);


?>
