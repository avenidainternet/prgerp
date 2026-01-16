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

/*
		if($rowRAM['nSolTaller']>0){
		}


		if($rowRAM['nSolTaller']==0){
		}

		if($rowRAM['nSolTaller']>0){
		}
*/		
		$ln += 15;


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
								
							}
					} // Imprimir Muestra sin OTAM
				}else{

							$nOtam++;
							if($nOtam <= 5){
								$ln += 10;
								
							}


				}
			}while($rowMu=mysqli_fetch_array($bdMu));
		}

		// Siguientes Registros de OTAMs
	
		$sqlOtams	= "SELECT * FROM OTAMs Where RAM = '".$RAM."'";  // sentencia sql
		$result 	= $link->query($sqlOtams);
		$tOtams 	= mysqli_num_rows($result); // obtenemos el número de Otams
		// Imprimir Solicitud Servicio a Taller SST
		/*
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
			}

			
			// Pie
			$pdf->SetFont('Arial','',9);
			$pdf->SetXY(150,245);
			$pdf->Cell(15,10,'Reg 2402-V.03',0,0,'R');
			// Fin Pie
		
		}
		*/
		//Fin Solicitud Servicio de Taller



		
		//Imprimir Otam Tracción
		$nPag = 0;
		$nTra = 5;

		/* +++ */
		$SQLMm = "SELECT * FROM amMuestras Where idItem Like '%".$RAM."%' and conEnsayo != 'off' Order By idItem";
		$bdMm=$link->query($SQLMm);
		while($rowMm=mysqli_fetch_array($bdMm)){
			$Otam = $RAM;
			$SQL = "SELECT * FROM OTAMs Where RAM = '".$RAM."' and Otam Like '%".$Otam."%' and idItem = '".$rowMm['idItem']."' and idEnsayo = 'Tr' Order By idItem";
			$bdMu=$link->query($SQL);
			while($rowMu=mysqli_fetch_array($bdMu)){
				$SQLt = "SELECT * FROM regtraccion Where idItem = '".$rowMu['Otam']."'";
				$bd=$link->query($SQLt);
				if($rs=mysqli_fetch_array($bd)){

				}
				$tecRes = $rowMu['tecRes'];

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
					$pdf->Cell(15,10,substr($tecRes,0,1),1,0,'C');
					$pdf->Cell(15,10,substr($tecRes,1,1),1,0,'C');
					$pdf->Cell(15,10,substr($tecRes,2,1),1,0,'C');
			
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

				$pdf->SetFont('Arial','',8);
				$lnTxt = 'Diámetro(mm)';
				$pdf->SetXY(60,$ln);
				$pdf->MultiCell(25,5,utf8_decode($lnTxt),1,'L');
				$lnTxt = $rs['Di'];
				$lnTxt = ($rs['Di'] > 0) ? $rs['Di'] : '';
				$pdf->SetXY(85,$ln);
				$pdf->MultiCell(25,5,$lnTxt,1,'L');
	
				$pdf->SetFont('Arial','',6,9);
				$lnTxt = 'Fluencia(MPa)';
				$pdf->SetXY(110,$ln);
				$pdf->MultiCell(18,5,$lnTxt,1,'L');
				$lnTxt = '';
				$pdf->SetFont('Arial','',8);
				$pdf->SetXY(110,$ln);
				$pdf->MultiCell(18,5,$lnTxt,1,'L');
		
				$lnTxt = '';
				$lnTxt = ($rs['tFlu'] > 0) ? $rs['tFlu'] : '';
				$pdf->SetXY(128,$ln);
				$pdf->MultiCell(19,5,$lnTxt,1,'L');
		
				$pdf->SetFont('Arial','',8);
				$lnTxt = 'Z(%)';
				$pdf->SetXY(147,$ln);
				$pdf->MultiCell(15,5,$lnTxt,1,'L');
				$lnTxt = '';
				$pdf->SetXY(147,$ln);
				$pdf->MultiCell(15,5,$lnTxt,1,'L');
							
				$lnTxt = '';
				$lnTxt = ($rs['rAre'] > 0) ? $rs['rAre'] : '';
				$pdf->SetXY(162,$ln);
				$pdf->MultiCell(23,5,intval($lnTxt),1,'L');
		
				$ln += 5;
				$pdf->SetFont('Arial','B',11);
				$lnTxt = 'FECHA';
				$pdf->SetXY(10,$ln);
				$pdf->MultiCell(50,5,$lnTxt,1,'C');
				$pdf->SetFont('Arial','',11);
							
				$pdf->SetFont('Arial','',8);
				$lnTxt = 'Espesor(mm)';
				$pdf->SetXY(60,$ln);
				$pdf->MultiCell(25,5,$lnTxt,1,'L');
				$lnTxt = '';
				$lnTxt = ($rs['Espesor'] > 0) ? $rs['Espesor'] : '';
				$pdf->SetXY(85,$ln);
				$pdf->MultiCell(25,5,$lnTxt,1,'L');
		
				$pdf->SetFont('Arial','',8);
				$lnTxt = 'UTS(MPa)';
				$pdf->SetXY(110,$ln);
				$pdf->MultiCell(18,5,$lnTxt,1,'L');
				$lnTxt = '';
				$pdf->SetXY(110,$ln);
				$pdf->MultiCell(18,5,$lnTxt,1,'L');
		
				$lnTxt = '';
				$lnTxt = ($rs['tMax'] > 0) ? $rs['tMax'] : '';
				$pdf->SetXY(128,$ln);
				$pdf->MultiCell(19,5,$lnTxt,1,'L');
		
				$pdf->SetFont('Arial','',7);
				$lnTxt = 'Temp.(°C)';
				$pdf->SetXY(147,$ln);
				$pdf->MultiCell(15,5, utf8_decode($lnTxt),1,'L');
				$lnTxt = '';
				$pdf->SetFont('Arial','',8);
				$pdf->SetXY(147,$ln);
				$pdf->MultiCell(15,5,$lnTxt,1,'L');
							
				$lnTxt = '';
				$lnTxt = ($rs['Temperatura'] > 0) ? $rs['Temperatura'].'' : '';
				$pdf->SetXY(162,$ln);
				$pdf->MultiCell(23,5,$lnTxt,1,'L');
		
				$ln += 5;
				$lnTxt = '';
				if($rs['fechaRegistro'] != '0000-00-00'){
					$fd = explode('-', $rs['fechaRegistro']); 
					$lnTxt = $fd[2].'/'.$fd[1].'/'.$fd[0];
				}
				$pdf->SetXY(10,$ln);
				$pdf->MultiCell(50,5,$lnTxt,1,'C');
		
				$pdf->SetFont('Arial','',8);
				$lnTxt = 'Ancho(mm)';
				$pdf->SetXY(60,$ln);
				$pdf->MultiCell(25,5,$lnTxt,1,'L');
				$lnTxt = '';
				$lnTxt = ($rs['Ancho'] > 0) ? $rs['Ancho'].'' : '';
				$pdf->SetXY(85,$ln);
				$pdf->MultiCell(25,5,$lnTxt,1,'L');
		
				$pdf->SetFont('Arial','',8);
				$lnTxt = 'A(%)';
				$pdf->SetXY(110,$ln);
				$pdf->MultiCell(18,5,$lnTxt,1,'L');
				$lnTxt = '';
				$pdf->SetXY(110,$ln);
				$pdf->MultiCell(18,5,$lnTxt,1,'L');
		
				$lnTxt = '';
				$lnTxt = ($rs['aSob'] > 0) ? $rs['aSob'].'%' : '';
				$pdf->SetXY(128,$ln);
				$pdf->MultiCell(19,5,$lnTxt,1,'L');
		
				$pdf->SetFont('Arial','',8);
				$lnTxt = 'Hum.(%)';
				$pdf->SetXY(147,$ln);
				$pdf->MultiCell(15,5,$lnTxt,1,'L');
				$lnTxt = '';
				$pdf->SetXY(147,$ln);
				$pdf->MultiCell(15,5,$lnTxt,1,'L');
						
				$lnTxt = '';
				$lnTxt = ($rs['Humedad'] > 0) ? $rs['Humedad'].'' : '';
				$pdf->SetXY(162,$ln);
				$pdf->MultiCell(23,5,$lnTxt,1,'L');
	
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
		}
		
		//Fin Imprimir Otam Tracción
	
	}

	$agnoActual = date('Y'); 
	$vDir = 'Y://AAA/LE/LABORATORIO/'.$agnoActual.'/'.$RAM.'/Tr'; 
	if(!file_exists($vDir)){
		mkdir($vDir);
	}

	$NombreFormulario = "Otam-Traccion-".$Otam.".pdf";
	//unlink($vDir.'/'.$NombreFormulario);
	//unlink('../tmp/'.$NombreFormulario);

	// $pdf->Output('../tmp/'.$NombreFormulario,'F'); //Guarda en un Fichero
	$pdf->Output($vDir.'/'.$NombreFormulario,'F'); //Guarda en un Fichero

	//copy('../tmp/'.$NombreFormulario, $vDir.'/'.$NombreFormulario);
	// unlink($NombreFormulario);

	//header("Location: http://servidorerp/erp/generarinformes2/edicionInformes.php?accion=Editar&CodInforme=".$CodInforme."&RAM=".$CodInforme);

?>
