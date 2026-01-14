<?php
	require_once('../../fpdf/fpdf.php');
	include_once("../../conexion.php");

	$nSerie = $_GET['nSerie'];
	$accion = $_GET['accion'];
		
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
	$bdEq=mysql_query("SELECT * FROM equipos WHERE nSerie = '".$nSerie."'");
	if($rowEq=mysql_fetch_array($bdEq)){
		
		$pdf=new FPDF('L','mm','Letter');

		// Encabezado 
		$pdf->AddPage();
		$pdf->SetXY(10,5);
		$pdf->Image('../../imagenes/logoSimetCam.png',10,5,43,16);

		$pdf->SetFont('Arial','B',10);
		$pdf->SetTextColor(192, 192, 192);
		$pdf->SetXY(50,12);
		$pdf->Cell(120,5,'PROGRAMA DE MANTENCIÓN Y CALIBRACIÓN  '.$rowEq[nomEquipo],0,0,'C');

		$pdf->SetXY(170,12);
		$pdf->Cell(20,5,'HOJA N°: 001',0,0,'L');
		$pdf->SetFont('Arial','',10);
		$pdf->SetTextColor(0, 0, 0);

		$pdf->SetXY(50,17);
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(10,5,'Acreditado NCh-ISO 17.025.',0,0);

		$pdf->SetXY(10,17);
		$pdf->Image('../../gastos/logos/logousach.png',250,5,15,23);

		$pdf->SetDrawColor(200, 200, 200);
		$pdf->Line(245, 30, 245, 200);

		$pdf->SetDrawColor(0, 0, 0);
		$pdf->Image('../../imagenes/logoSimetCam.png',240,190,20,8);
		
		$pdf->SetDrawColor(0, 0, 0);
		// Fin Encabezado
		
		$ln = 25;

		// Primera Columna
		$pdf->SetFillColor(220, 220, 220);
		$pdf->SetFont('Arial','B',9);
		$pdf->SetXY(10,$ln);
		$pdf->Cell(50,8,' ', 1, 1, 'J', true);

		$pdf->SetXY(10,$ln);
		$lnTxt = 'Actividad';
		$pdf->MultiCell(50,4,$lnTxt,0,'C');
		
		$pdf->SetXY(10,$ln+4);
		$lnTxt = '(marque con una x)';
		$pdf->MultiCell(50,4,$lnTxt,0,'C');

		$pdf->SetXY(10,$ln+8);
		$pdf->Cell(25,6,' ', 1, 1, 'J', true);
		$pdf->SetXY(35,$ln+8);
		$pdf->Cell(25,6,' ', 1, 1, 'J', true);

		$pdf->SetXY(10,$ln+8);
		$lnTxt = 'Mantención';
		$pdf->MultiCell(25,6,$lnTxt,0,'C');

		$pdf->SetXY(35,$ln+8);
		$lnTxt = 'Calibración';
		$pdf->MultiCell(25,6,$lnTxt,0,'C');

		// Segunda Columna
		$pdf->SetXY(60,$ln);
		$pdf->Cell(25,14,' ', 1, 1, 'J', true);

		$pdf->SetXY(60,$ln);
		$lnTxt = 'Fecha tentativa de realización';
		$pdf->MultiCell(25,4.5,$lnTxt,0,'C');

		// Tercera Columna
		$pdf->SetXY(85,$ln);
		$pdf->Cell(35,14,' ', 1, 1, 'J', true);

		$pdf->SetXY(85,$ln);
		$lnTxt = 'Responsable';
		$pdf->MultiCell(35,6,$lnTxt,0,'C');

		// Cuarta Columna
		$pdf->SetXY(120,$ln);
		$pdf->Cell(20,14,' ', 1, 1, 'J', true);

		$pdf->SetXY(120,$ln);
		$lnTxt = 'Código Equipo';
		$pdf->MultiCell(20,6,$lnTxt,0,'C');

		// Quinta Columna
		$pdf->SetXY(140,$ln);
		$pdf->Cell(40,8,' ', 1, 1, 'J', true);

		$pdf->SetXY(140,$ln);
		$lnTxt = 'Tipo de Actividad';
		$pdf->MultiCell(40,4,$lnTxt,0,'C');

		$pdf->SetXY(140,$ln+4);
		$lnTxt = '(marque con una x)';
		$pdf->MultiCell(40,4,$lnTxt,0,'C');

		$pdf->SetXY(140,$ln+8);
		$pdf->Cell(20,6,' ', 1, 1, 'J', true);
		$lnTxt = 'Interna';
		$pdf->SetXY(140,$ln+8);
		$pdf->MultiCell(20,6,$lnTxt,0,'C');
		
		$pdf->SetXY(160,$ln+8);
		$pdf->Cell(20,6,' ', 1, 1, 'J', true);
		$lnTxt = 'Exerna';
		$pdf->SetXY(160,$ln+8);
		$pdf->MultiCell(20,6,$lnTxt,0,'C');

		// Sexta Columna
		$pdf->SetXY(180,$ln);
		$pdf->Cell(30,8,' ', 1, 1, 'J', true);

		$pdf->SetXY(180,$ln);
		$lnTxt = 'Se Realiza';
		$pdf->MultiCell(30,4,$lnTxt,0,'C');

		$pdf->SetXY(180,$ln+4);
		$lnTxt = 'Mantención';
		$pdf->MultiCell(30,4,$lnTxt,0,'C');

		$pdf->SetXY(180,$ln+8);
		$pdf->Cell(15,6,' ', 1, 1, 'J', true);
		$lnTxt = 'Si';
		$pdf->SetXY(180,$ln+8);
		$pdf->MultiCell(15,6,$lnTxt,0,'C');
		
		$pdf->SetXY(195,$ln+8);
		$pdf->Cell(15,6,' ', 1, 1, 'J', true);
		$lnTxt = 'No';
		$pdf->SetXY(195,$ln+8);
		$pdf->MultiCell(15,6,$lnTxt,0,'C');

		// Septima Columna
		$pdf->SetXY(210,$ln);
		$pdf->Cell(30,14,' ', 1, 1, 'J', true);

		$pdf->SetXY(210,$ln);
		$lnTxt = 'Fecha de Mantención';
		$pdf->MultiCell(30,6,$lnTxt,0,'C');
		
		$pdf->SetFillColor(0, 0, 0);
		
		/* Fin Encabezado Columna */

		/* Cuerpo Informe */
		// Calibración Programada
		if($rowEq[fechaProxCal] > '0000-00-00'){
			$ln += 14;

			$td = 'bola_verde.png';
			$fechaHoy = date('Y-m-d');
			$fechaxVencer 	= strtotime ( '-'.$rowEq[tpoAvisoCal].' day' , strtotime ( $rowEq[fechaProxCal] ) );
			$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
			if($rowEq[fechaProxCal] != '0000-00-00' and $fechaHoy >= $fechaxVencer){ 
				$td = 'bola_amarilla.png';
			}
			if($rowEq[fechaProxCal] != '0000-00-00' and $fechaHoy > $rowEq[fechaProxCal]){ 
				$td = 'bola_roja.png';
			}
			$pdf->Image('../../imagenes/'.$td,5,$ln,3,3);

			$pdf->SetXY(10,$ln);
			$pdf->Cell(25,6,' ', 1, 1, 'C');
	
			$pdf->SetXY(35,$ln);
			$pdf->Cell(25,6,' ', 1, 1, 'C');
			$pdf->SetXY(35,$ln);
			$pdf->Cell(25,6,'X', 0, 1, 'C');
	
			$pdf->SetXY(60,$ln);
			$pdf->Cell(25,6,' ', 1, 1, 'C');
			$fd = explode('-', $rowEq[fechaProxCal]);
			$pdf->SetXY(60,$ln);
			$pdf->Cell(25,6,$fd[2].'/'.$fd[1].'/'.$fd[0], 1, 1, 'C');
	
			$pdf->SetXY(85,$ln);
			$pdf->Cell(35,6,' ', 1, 1, 'C');
			$pdf->SetXY(85,$ln);
			$pdf->Cell(35,6,$rowEq[usrResponsable], 1, 1, 'C');
			
			$pdf->SetXY(120,$ln);
			$pdf->Cell(20,6,' ', 1, 1, 'C');
			$pdf->SetXY(120,$ln);
			$pdf->Cell(20,6,$rowEq[nSerie], 1, 1, 'C');
	
			$pdf->SetXY(140,$ln);
			$pdf->Cell(20,6,' ', 1, 1, 'C');
			$pdf->SetXY(140,$ln);
			$pdf->Cell(20,6,'X', 1, 1, 'C');
	
			$pdf->SetXY(160,$ln);
			$pdf->Cell(20,6,' ', 1, 1, 'C');
	
			$pdf->SetXY(180,$ln);
			$pdf->Cell(15,6,' ', 1, 1, 'C');
	
			$pdf->SetXY(195,$ln);
			$pdf->Cell(15,6,' ', 1, 1, 'C');
	
			$pdf->SetXY(210,$ln);
			$pdf->Cell(30,6,' ', 1, 1, 'C');
		}

		// Mantención Programada
		if($rowEq[fechaProxMan] > '0000-00-00'){
			if($rowEq[fechaProxCal] > '0000-00-00'){
				$ln += 6;
			}else{
				$ln += 14;
			}

			$td = 'bola_verde.png';
			$fechaHoy = date('Y-m-d');
			$fechaxVencer 	= strtotime ( '-'.$rowEq[tpoAvisoMan].' day' , strtotime ( $rowEq[fechaProxMan] ) );
			$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
			if($fechaHoy >= $fechaxVencer){ 
				$td = 'bola_amarilla.png';
			}
			if($fechaHoy > $rowEq[fechaProxMan]){ 
				$td = 'bola_roja.png';
			}
			$pdf->Image('../../imagenes/'.$td,5,$ln,3,3);

			$pdf->SetXY(10,$ln);
			$pdf->Cell(25,6,' ', 1, 1, 'C');
			$pdf->SetXY(10,$ln);
			$pdf->Cell(25,6,'X', 1, 1, 'C');
	
			$pdf->SetXY(35,$ln);
			$pdf->Cell(25,6,' ', 1, 1, 'C');
	
			$pdf->SetXY(60,$ln);
			$pdf->Cell(25,6,' ', 1, 1, 'C');
			$fd = explode('-', $rowEq[fechaProxMan]);
			$pdf->SetXY(60,$ln);
			$pdf->Cell(25,6,$fd[2].'/'.$fd[1].'/'.$fd[0], 1, 1, 'C');
	
			$pdf->SetXY(85,$ln);
			$pdf->Cell(35,6,' ', 1, 1, 'C');
			$pdf->SetXY(85,$ln);
			$pdf->Cell(35,6,$rowEq[usrResponsable], 1, 1, 'C');
			
			$pdf->SetXY(120,$ln);
			$pdf->Cell(20,6,' ', 1, 1, 'C');
			$pdf->SetXY(120,$ln);
			$pdf->Cell(20,6,$rowEq[nSerie], 1, 1, 'C');
	
			$pdf->SetXY(140,$ln);
			$pdf->Cell(20,6,' ', 1, 1, 'C');
			$pdf->SetXY(140,$ln);
			$pdf->Cell(20,6,'X', 1, 1, 'C');
	
			$pdf->SetXY(160,$ln);
			$pdf->Cell(20,6,' ', 1, 1, 'C');
	
			$pdf->SetXY(180,$ln);
			$pdf->Cell(15,6,' ', 1, 1, 'C');
	
			$pdf->SetXY(195,$ln);
			$pdf->Cell(15,6,' ', 1, 1, 'C');
	
			$pdf->SetXY(210,$ln);
			$pdf->Cell(30,6,' ', 1, 1, 'C');
		}

		$bdHis=mysql_query("SELECT * FROM equiposHistorial WHERE nSerie = '".$nSerie."'");
		if($rowHis=mysql_fetch_array($bdHis)){
			do{
				$ln += 6;

				$td = 'bola_azul.png';
				$pdf->Image('../../imagenes/'.$td,5,$ln,3,3);
	
				$pdf->SetXY(10,$ln);
				$pdf->Cell(25,6,' ', 1, 1, 'C');
				$pdf->SetXY(10,$ln);
				if($rowHis[Accion]=='Man'){
					$pdf->Cell(25,6,'X', 1, 1, 'C');
				}else{
					$pdf->Cell(25,6,' ', 1, 1, 'C');
				}
		
				$pdf->SetXY(35,$ln);
				$pdf->Cell(25,6,' ', 1, 1, 'C');
				$pdf->SetXY(35,$ln);
				if($rowHis[Accion]=='Ver'){
					$pdf->Cell(25,6,'Verificación', 1, 1, 'C');
				}else{
					if($rowHis[Accion]=='Cal'){
						$pdf->Cell(25,6,'X', 1, 1, 'C');
					}else{
						$pdf->Cell(25,6,' ', 1, 1, 'C');
					}
				}
		
				$pdf->SetXY(60,$ln);
				$pdf->Cell(25,6,' ', 1, 1, 'C');
				$fd = explode('-', $rowHis[fechaTentativa]);
				$pdf->SetXY(60,$ln);
				$pdf->Cell(25,6,$fd[2].'/'.$fd[1].'/'.$fd[0], 1, 1, 'C');
		
				$pdf->SetXY(85,$ln);
				$pdf->Cell(35,6,' ', 1, 1, 'C');
				$pdf->SetXY(85,$ln);
				$pdf->Cell(35,6,$rowEq[usrResponsable], 1, 1, 'C');
				
				$pdf->SetXY(120,$ln);
				$pdf->Cell(20,6,' ', 1, 1, 'C');
				$pdf->SetXY(120,$ln);
				$pdf->Cell(20,6,$rowEq[nSerie], 1, 1, 'C');
		
				$pdf->SetXY(140,$ln);
				$pdf->Cell(20,6,' ', 1, 1, 'C');
				$pdf->SetXY(140,$ln);
				$pdf->Cell(20,6,'X', 1, 1, 'C');
		
				$pdf->SetXY(160,$ln);
				$pdf->Cell(20,6,' ', 1, 1, 'C');
		
				$pdf->SetXY(180,$ln);
				$pdf->Cell(15,6,' ', 1, 1, 'C');
				$pdf->SetXY(180,$ln);
				$pdf->Cell(15,6,'X', 1, 1, 'C');
		
				$pdf->SetXY(195,$ln);
				$pdf->Cell(15,6,' ', 1, 1, 'C');
		
				$pdf->SetXY(210,$ln);
				$pdf->Cell(30,6,' ', 1, 1, 'C');
				$fd = explode('-', $rowHis[fechaAccion]);
				$pdf->SetXY(210,$ln);
				$pdf->Cell(30,6,$fd[2].'/'.$fd[1].'/'.$fd[0], 0, 1, 'C');

	
			}while($rowHis=mysql_fetch_array($bdHis));
		}		
		/* Fin Cuerpo Informe */
		
		/* Pie de Página */
		$pdf->SetFont('Arial','',9);
		$pdf->SetTextColor(192, 192, 192);
		$pdf->SetXY(220,186);
		$pdf->Cell(15,4,'Reg 2902-Rev.0',0,0,'R');
		$pdf->SetXY(220,190);
		$pdf->Cell(15,4,'Pág. 1 de 1',0,0,'R');
		$pdf->SetTextColor(0, 0, 0);

		
	}
	mysql_close($link);
	
	//$pdf->Output('F3B-00001.pdf','I'); //Para Descarga
	$NombreFormulario = "ProgMant-".$nSerie.".pdf";
	$pdf->Output($NombreFormulario,'D'); //Para Descarga
	//$pdf->Output('F3B-00001.pdf','F');

?>
