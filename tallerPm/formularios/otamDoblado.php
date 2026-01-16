<?php
	require_once('../../fpdf/fpdf.php');
	include_once("../../conexionli.php");
	header('Content-Type: text/html; charset=utf-8');

	if(isset($_GET['RAM'])) 		{ $RAM 			= $_GET['RAM'];			} 
	if(isset($_GET['CodInforme'])) 	{ $CodInforme 	= $_GET['CodInforme'];	}
	if(isset($_GET['Otam'])) 		{ $Otam 		= $_GET['Otam'];		}
		
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
	//	$pdf->AddPage();

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
		
		// Fin Encabezado
		$nContacto = 0;
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
		$ln += 5;

		// Encabezado 
		$bdCli=$link->query("SELECT * FROM Clientes WHERE RutCli = '".$RutCli."'");
		if($rowCli=mysqli_fetch_array($bdCli)){

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

			}
		}
		$ln += 5;

		$ln += 15;


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
							if($nOtam <= 5){
								$ln += 10;
								
							}
					} // Imprimir Muestra sin OTAM
				}else{

							$nOtam++;
							if($nOtam <= 5){
								$ln += 10;
								
							}


				}
		}

		// Siguientes Registros de OTAMs
	
		$sqlOtams	= "SELECT * FROM OTAMs Where RAM = '".$RAM."'";  // sentencia sql
		$result 	= $link->query($sqlOtams);
		$tOtams 	= mysqli_num_rows($result); // obtenemos el número de Otams

		//Imprimir Otam Doblado
		$nPag = 0;
		$nTra = 4;

		/* +++ */
		//$SQLMm = "SELECT * FROM amMuestras Where idItem Like '%".$RAM."%' and conEnsayo != 'off' Order By idItem";
		//$bdMm=$link->query($SQLMm);
		//while($rowMm=mysqli_fetch_array($bdMm)){
			//$Otam = $RAM;
			//$SQL = "SELECT * FROM OTAMs Where RAM = '".$RAM."' and Otam Like '%".$Otam."%' and idItem = '".$rowMm['idItem']."' and idEnsayo = 'Do' Order By idItem";
			$SQL = "SELECT * FROM OTAMs Where RAM = '".$RAM."' and idEnsayo = 'Do' Order By idItem";
			$bdMu=$link->query($SQL);
			while($rowMu=mysqli_fetch_array($bdMu)){
				//$SQLt = "SELECT * FROM regdobladosreal Where idItem = '".$rowMu['Otam']."'";
				$SQLt = "SELECT * FROM regdobladosreal Where idItem = '".$rowMu['Otam']."'";
				$bd=$link->query($SQLt);
				if($rs=mysqli_fetch_array($bd)){
					$tecRes = $rs['usrResponsable'];
				}

				if($nTra >= 4){
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
					$pdf->Cell(15,10,substr($tecRes,0,1),1,0,'C');
					$pdf->Cell(15,10,substr($tecRes,1,1),1,0,'C');
					$pdf->Cell(15,10,substr($tecRes,2,1),1,0,'C');
			
					$pdf->SetXY(100,225);
					$pdf->Cell(15,10,utf8_decode(substr($rowRAM['cooResponsable'],0,1)),1,0,'C');
					$pdf->Cell(15,10,utf8_decode(substr($rowRAM['cooResponsable'],1,1)),1,0,'C');
					$pdf->Cell(15,10,utf8_decode(substr($rowRAM['cooResponsable'],2,1)),1,0,'C');

					$pdf->SetFont('Arial','',9);
					$pdf->SetXY(150,245);
					$pdf->Cell(15,10,'Reg 240204-V.0',0,0,'R');
					// Fin Pie
				}
						
				if($nPag >= 1) { $ln += 18; }
				$nTra++;

				// Tabla Info 1
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
                
                // Tabla Info 2
				$ln += 5;
				$lnTxt = $rowMu['Otam'];
				$pdf->SetXY(10,$ln);
				$pdf->SetTextColor($cR, $cG, $cB);
				$pdf->Cell(35,10,$lnTxt,1,0,'C');
				
				$pdf->SetTextColor(0,0,0);
				$pdf->SetFont('Arial','',8);
				$lnTxt = 'Separación entre apoyos (mm)';
				$pdf->SetXY(45,$ln);
				$pdf->MultiCell(28,5,utf8_decode($lnTxt),1,'C');

				$pdf->SetFont('Arial','',8);
				$lnTxt = 'Diámetro Apoyos (mm)';
				$pdf->SetXY(73,$ln);
				$pdf->MultiCell(28,5,utf8_decode($lnTxt),1,'C');

				$lnTxt = 'Diámetro Punzón (mm)';
				$pdf->SetXY(101,$ln);
				$pdf->MultiCell(28,5,utf8_decode($lnTxt),1,'C');

				$lnTxt = 'Angulo Alcanzado (º)';
				$pdf->SetXY(129,$ln);
				$pdf->MultiCell(28,5,utf8_decode($lnTxt),1,'C');

				$lnTxt = 'Dimensión Fisuras (mm)';
				$pdf->SetXY(157,$ln);
				$pdf->MultiCell(28,5,utf8_decode($lnTxt),1,'C');
				// Fin 2

				// Tabla Datos 3
				$ln += 10;
				$lnTxt = 'FECHA';
				$pdf->SetXY(10,$ln);
				$pdf->SetTextColor($cR, $cG, $cB);
				$pdf->Cell(35,5,$lnTxt,1,0,'C');

				$pdf->SetTextColor(0,0,0);
				$pdf->SetFont('Arial','',8);
				$lnTxt = $rs['separacionApoyos']; // DATO
				$pdf->SetXY(45,$ln);
				$pdf->Cell(28,5,utf8_decode($lnTxt),1,0,'C');

				$pdf->SetFont('Arial','',8);
				$lnTxt = ''; // DATO
				$SQLd = "SELECT * FROM diametrosdoblados Where  nDiametroDoblado = '".$rs['nDiametroDoblado']."'";
				$bdd=$link->query($SQLd);
				if($rsd=mysqli_fetch_array($bdd)){
					$lnTxt = $rsd['diametroDoblado']; // DATO
				}
				$pdf->SetXY(73,$ln);
				$pdf->Cell(28,5,utf8_decode($lnTxt),1,0,'C');

				$pdf->SetFont('Arial','',8);
				$lnTxt = $rs['diametroPunzon']; // DATO
				$pdf->SetXY(101,$ln);
				$pdf->Cell(28,5,utf8_decode($lnTxt),1,0,'C');

				$pdf->SetFont('Arial','',8);
				$lnTxt = $rs['anguloAlcanzado']; // DATO
				$pdf->SetXY(129,$ln);
				$pdf->Cell(28,5,utf8_decode($lnTxt),1,0,'C');

				$pdf->SetFont('Arial','',8);
				$lnTxt = $rs['diametroFisuras']; // DATO
				$pdf->SetXY(157,$ln);
				$pdf->Cell(28,5,utf8_decode($lnTxt),1,0,'C');

				// Fin Fila 3
				// Fila 4
				$ln += 5;
				$lnTxt = '29-06-2023';
				$pdf->SetXY(10,$ln);
				$pdf->Cell(35,5,$lnTxt,1,0,'C');

				$pdf->SetFont('Arial','',8);
				$pdf->SetTextColor($cR, $cG, $cB);
				$lnTxt = 'TEMPERATURA (°C)';
				$pdf->SetXY(45,$ln);
				$pdf->Cell(28,5,utf8_decode($lnTxt),1,0,'C');
				$pdf->SetTextColor(0,0,0);

				$pdf->SetFont('Arial','',8);
				$lnTxt = $rs['Tem'];
				$pdf->SetXY(73,$ln);
				$pdf->Cell(56,5,utf8_decode($lnTxt),1,0,'C');
				$pdf->SetTextColor(0,0,0);

				$pdf->SetFont('Arial','',8);
				$pdf->SetTextColor($cR, $cG, $cB);
				$lnTxt = 'HUMEDAD (%)';
				$pdf->SetXY(129,$ln);
				$pdf->Cell(28,5,utf8_decode($lnTxt),1,0,'C');
				$pdf->SetTextColor(0,0,0);

				$pdf->SetFont('Arial','',8);
				$lnTxt = $rs['Hum'];
				$pdf->SetXY(157,$ln);
				$pdf->Cell(28,5,utf8_decode($lnTxt),1,0,'C');
				$pdf->SetTextColor(0,0,0);


	
				$ln += 5;
				
				$lnTxt = 'OBSERVACIONES';
				$pdf->SetXY(10,$ln);
				$pdf->Cell(10,5,$lnTxt,0,0,'L');
				$pdf->SetXY(10,$ln);
				$lnTxt = utf8_decode($rs['Observacion']);
				$pdf->SetFont('Arial','B',8);
				$pdf->MultiCell(175,13,$lnTxt,1,'L');
				$pdf->SetFont('Arial','B',11);

			}
		// } // Quitar amMuestras
		
		//Fin Imprimir Otam
	
	}

	$agnoActual = date('Y'); 
	$vDir = 'Y://AAA/LE/LABORATORIO/'.$agnoActual.'/'.$RAM.'/Do'; 
	if(!file_exists($vDir)){
		mkdir($vDir);
	}

	$NombreFormulario = "Otam-Doblado-".$RAM.".pdf";
	$pdf->Output($vDir.'/'.$NombreFormulario,'F'); //Guarda en un Fichero

?>
