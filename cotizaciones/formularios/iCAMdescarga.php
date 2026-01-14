<?php
	require_once('../../fpdf/fpdf.php');
	include_once("../../conexion.php");

	$accion = '';
	if(isset($_GET['CAM'])) 	{ $CAM 	= $_GET['CAM']; 	}
	if(isset($_GET['Rev'])) 	{ $Rev 	= $_GET['Rev'];		}
	if(isset($_GET['Cta'])) 	{ $Cta 	= $_GET['Cta'];		}
	if(isset($_GET['accion'])) 	{ $accion = $_GET['accion'];}
		
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
	$bdCAM=mysql_query("SELECT * FROM Cotizaciones WHERE CAM = '".$CAM."' and Rev = '".$Rev."'");
	if($rowCAM=mysql_fetch_array($bdCAM)){

		$pdf=new FPDF('P','mm','Letter');

		// Encabezado 
		$pdf->AddPage();
		$pdf->SetXY(10,5);
		$pdf->Image('../../imagenes/logoSimetCam.png',10,5,43,16);

		$pdf->SetXY(110,12);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(10,5,'FECHA:',0,0);
		
		$fd 	= explode('-', $rowCAM['fechaCotizacion']);
		$pdf->SetXY(130,12);
		$pdf->Cell(50,5,$fd[2].' de '.$Mes[$fd[1]-1].' de '.$fd[0],0,0);

		$pdf->SetXY(50,17);
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(10,5,'Acreditado NCh-ISO 17.025.',0,0);

		$pdf->SetXY(110,17);
		$pdf->Cell(10,5,'Rev:',0,0);

		$Revision = $rowCAM['Rev'];
		if($rowCAM['Rev']<9){
			$Revision = '0'.$rowCAM['Rev'];
		}
		$pdf->SetXY(130,17);
		$pdf->Cell(50,5,$Revision.'.-',0,0);

		// Line(Col, FilaDesde, ColHasta, FilaHasta) 
		$pdf->Line(10, 23, 184, 23);

		$pdf->SetXY(10,17);
		$pdf->Image('../../gastos/logos/logousach.png',195,5,15,23);

		$pdf->SetFont('Arial','I',14);
		$pdf->SetXY(10,25);
		$pdf->Cell(170,5,'COTIZACIÓN CAM-'.$CAM,0,0,'C');
		$pdf->Line(10, 30, 184, 30);
		$pdf->Line(10, 30.7, 184, 30.7);
		
		$pdf->SetDrawColor(200, 200, 200);
		$pdf->Line(190, 30, 190, 270);
		$pdf->SetDrawColor(0, 0, 0);
		$pdf->Image('../../imagenes/logoSimetCam.png',185,245,20,8);
		// Fin Encabezado
		
		$ln = 32;
		$bdCli=mysql_query("SELECT * FROM Clientes WHERE RutCli = '".$rowCAM['RutCli']."'");
		if($rowCli=mysql_fetch_array($bdCli)){
			$pdf->SetFont('Arial','',8);
			$pdf->SetXY(10,$ln);
			$pdf->Cell(30,4,'EMPRESA',1,0,'L');

			$pdf->SetFont('Arial','B',8);
			$pdf->SetXY(40,$ln);
			$pdf->Cell(144,4,strtoupper($rowCli['Cliente']),1,0,'L');

			$ln += 4;
			
			$bdCon=mysql_query("SELECT * FROM contactosCli WHERE RutCli = '".$rowCAM['RutCli']."' and Contacto = '".$rowCAM['Atencion']."'");
			if($rowCon=mysql_fetch_array($bdCon)){
				$pdf->SetFont('Arial','',9);
				$pdf->SetXY(10,$ln);
				$pdf->Cell(30,4,'ATENCIÓN',1,0,'L');

				$pdf->SetFont('Arial','B',9);
				$pdf->SetXY(40,$ln);
				$pdf->Cell(144,4,strtoupper($rowCon['Contacto']),1,0,'L');

				$ln += 4;

				$pdf->SetFont('Arial','',9);
				$pdf->SetXY(10,$ln);
				$pdf->Cell(30,4,'TELÉFONO',1,0,'L');
	
				$pdf->SetFont('Arial','B',9);
				$pdf->SetXY(40,$ln);
				$pdf->Cell(144,4,$rowCon['Telefono'],1,0,'L');

				$ln += 4;

				$pdf->SetFont('Arial','',9);
				$pdf->SetXY(10,$ln);
				$pdf->Cell(30,4,'MAIL',1,0,'L');
	
				$pdf->SetFont('Arial','B',9);
				$pdf->SetXY(40,$ln);
				$pdf->Cell(144,4,strtoupper($rowCon['Email']),1,0,'L');
				$mail_destinatario = strtoupper($rowCon['Email']);
			}
			
			$ln += 5;

			$pdf->SetFont('Arial','B',9);
			$pdf->SetXY(10,$ln);
			$pdf->Cell(155,4,'Estimado(a) Sr(a). '.strtoupper($rowCon['Contacto']),0,0,'L').':';

			$ln += 5;
			$lnTxt = '        Informo a usted que el valor de los servicios solicitados, '.$rowCAM['obsServicios'].' es el siguiente:';
			
			$pdf->SetFont('Arial','',9);
			$pdf->SetXY(10,$ln);
			$pdf->MultiCell(175,4,$lnTxt,0,'J');

			$ln += 10;
			$pdf->SetFont('Arial','B',8);
			
			$pdf->SetXY(10,$ln);
			$pdf->MultiCell(20,8,'Cantidad',1,'C');
			
			$pdf->SetXY(30,$ln);
			$pdf->MultiCell(115,8,'ITEM',1,'C');

			$pdf->SetXY(145,$ln);
			$pdf->MultiCell(20,8,'',1,'C');
			$pdf->SetXY(145,$ln);
			$pdf->Cell(20,4,'Valor',0,0,'C');
			$pdf->SetXY(145,$ln+4);
			if($rowCAM['Moneda']=='U'){
				$pdf->Cell(20,4,'Unitario UF',0,0,'C');
			}else{
				$pdf->Cell(20,4,'Unitario $',0,0,'C');
			}

			$pdf->SetXY(165,$ln);
			$pdf->MultiCell(20,8,'',1,'C');
			$pdf->SetXY(165,$ln);
			$pdf->Cell(20,4,'Valor',0,0,'C');
			$pdf->SetXY(165,$ln+4);
			if($rowCAM['Moneda']=='U'){
				$pdf->Cell(20,4,'Total UF',0,0,'C');
			}else{
				$pdf->Cell(20,4,'Total $',0,0,'C');
			}			
			$pdf->SetFont('Arial','',8);
			$totalCot 	= 0;
			$nlineas  	= 0;
			$totalUF	= 0;
			$totalPesos	= 0;
			
			$ln += 2;
			$nLineas = 0;
			$bddCAM=mysql_query("SELECT * FROM dCotizacion WHERE CAM = '".$CAM."' Order By nLin Asc");
			if($rowdCAM=mysql_fetch_array($bddCAM)){
				do{
					$nLineas++;
					if($rowCAM['Moneda']=='U'){
						$totalUF 	+= $rowdCAM['NetoUF'];
					}else{
						$totalPesos += $rowdCAM['Neto'];
					}
					$ln += 6;
					$pdf->SetXY(10,$ln);
					$pdf->Cell(20,6,'',1,0,'C');
					$pdf->SetXY(10,$ln);
					$pdf->MultiCell(20,6,$rowdCAM['Cantidad'],0,'C');
	
					$pdf->SetXY(30,$ln);
					$pdf->Cell(115,6,'',1,0,'C');
					$bdSer=mysql_query("SELECT * FROM Servicios WHERE nServicio = '".$rowdCAM['nServicio']."'");
					if($rowSer=mysql_fetch_array($bdSer)){
						$Servicio 	= $rowSer['Servicio'];
						$ValorUF 	= $rowSer['ValorUF'];
					}
					$pdf->SetXY(30,$ln);
					$pdf->MultiCell(115,6,$Servicio,0,'L');
	
					$pdf->SetXY(145,$ln);
					$pdf->Cell(20,6,'',1,0,'C');
					$pdf->SetXY(145,$ln);
					if($rowCAM['Moneda']=='U'){
						$pdf->MultiCell(20,6,number_format($rowdCAM['unitarioUF'], 2, '.', ','),0,'R');
						//$pdf->MultiCell(20,6,number_format($ValorUF, 2, '.', ','),0,'R');
					}else{
						$pdf->MultiCell(20,6,number_format($rowdCAM['unitarioP'], 0, '.', ','),0,'R');
						//$pdf->MultiCell(20,6,number_format(intval($ValorUF * $rowCAM[valorUF]), 0, '.', ','),0,'R');
					}
	
					$pdf->SetXY(165,$ln);
					$pdf->Cell(20,6,'',1,0,'C');
					$pdf->SetXY(165,$ln);
					if($rowCAM['Moneda']=='U'){
						$pdf->MultiCell(20,6,number_format($rowdCAM['NetoUF'], 2, '.', ','),0,'R');
					}else{
						$pdf->MultiCell(20,6,number_format($rowdCAM['Neto'], 0, '.', ','),0,'R');
					}
				}while ($rowdCAM=mysql_fetch_array($bddCAM));
			}
			if($nLineas<11){
				for($i=$nLineas; $i<11; $i++){
					$ln += 6;
					$pdf->SetXY(10,$ln);
					$pdf->Cell(20,6,'',1,0,'C');

					$pdf->SetXY(30,$ln);
					$pdf->Cell(115,6,'',1,0,'C');

					$pdf->SetXY(145,$ln);
					$pdf->Cell(20,6,'',1,0,'C');

					$pdf->SetXY(165,$ln);
					$pdf->Cell(20,6,'',1,0,'C');
				}
			}
			$ln += 6;
			$pdf->SetFont('Arial','B',8);
			$pdf->SetXY(145,$ln);
			if($rowCAM['Moneda']=='U'){
				$pdf->Cell(20,5,'NETO UF',1,0,'R');
			}else{
				$pdf->Cell(20,5,'NETO $',1,0,'R');
			}
			
			$pdf->SetFont('Arial','',8);
			$pdf->SetXY(165,$ln);
			$pdf->Cell(20,5,'',1,0,'C');
			$pdf->SetXY(165,$ln);
			if($rowCAM['Moneda']=='U'){
				$pdf->MultiCell(20,5,number_format($totalUF, 2, '.', ','),0,'R');
			}else{
				$pdf->MultiCell(20,5,number_format($totalPesos, 0, '.', ','),0,'R');
			}
			
			if($rowCAM['pDescuento']>0){
				$pdf->SetFont('Arial','B',8);
				$ln += 5;
				$pdf->SetXY(145,$ln);
				$pdf->Cell(20,10,'',1,0,'R');
				$pdf->SetXY(145,$ln);
				$pdf->Cell(20,5,$rowCAM['pDescuento'].'% Desc.',0,0,'C');
				$pdf->SetXY(145,$ln+5);
				$pdf->Cell(20,5,'A.Artigas',0,0,'C');
				$pdf->SetFont('Arial','',8);
				
				if($rowCAM['Moneda']=='U'){
					$tDes = $totalUF - $rowCAM['NetoUF'];
				}else{
					$tDes = $totalPesos - $rowCAM['Neto'];
				}
								
				$pdf->SetXY(165,$ln);
				$pdf->Cell(20,10,'',1,0,'C');
				$pdf->SetXY(165,$ln);
				if($rowCAM['Moneda']=='U'){
					$pdf->MultiCell(20,10,number_format($tDes, 2, '.', ','),0,'R');
				}else{
					$pdf->MultiCell(20,10,number_format($tDes, 0, '.', ','),0,'R');
				}
				$ln += 10;
				$pdf->SetFont('Arial','B',8);
				$pdf->SetXY(145,$ln);
				$pdf->Cell(20,5,'Sub total',1,0,'R');
				$pdf->SetFont('Arial','',8);
		
				$pdf->SetXY(165,$ln);
				$pdf->Cell(20,5,'',1,0,'C');
				$pdf->SetXY(165,$ln);
				if($rowCAM['Moneda']=='U'){
					$pdf->MultiCell(20,5,number_format($rowCAM['NetoUF'], 2, '.', ','),0,'R');
				}else{
					$pdf->MultiCell(20,5,number_format($rowCAM['Neto'], 0, '.', ','),0,'R');
				}
			}
			$ln += 5;
			$pdf->SetFont('Arial','B',8);
			$pdf->SetXY(145,$ln);
			if($rowCAM['Moneda']=='U'){
				$pdf->Cell(20,5,'IVA UF',1,0,'R');
			}else{
				$pdf->Cell(20,5,'IVA $',1,0,'R');
			}
			$pdf->SetFont('Arial','',8);
					
			$pdf->SetXY(165,$ln);
			$pdf->Cell(20,5,'',1,0,'C');
			$pdf->SetXY(165,$ln);
			if($rowCAM['Moneda']=='U'){
				$pdf->MultiCell(20,5,number_format($rowCAM['IvaUF'], 2, '.', ','),0,'R');
			}else{
				$pdf->MultiCell(20,5,number_format($rowCAM['Iva'], 0, '.', ','),0,'R');
			}

			$ln += 5;
			$pdf->SetFont('Arial','B',8);
			$pdf->SetXY(145,$ln);
			if($rowCAM['Moneda']=='U'){
				$pdf->Cell(20,5,'TOTAL UF',1,0,'R');
			}else{
				$pdf->Cell(20,5,'TOTAL $',1,0,'R');
			}
			$pdf->SetFont('Arial','',8);
		
			$pdf->SetXY(165,$ln);
			$pdf->Cell(20,5,'',1,0,'C');
			$pdf->SetXY(165,$ln);
			if($rowCAM['Moneda']=='U'){
				$pdf->MultiCell(20,5,number_format($rowCAM['BrutoUF'], 2, '.', ','),0,'R');
			}else{
				$pdf->MultiCell(20,5,number_format($rowCAM['Bruto'], 0, '.', ','),0,'R');
			}
			
//			$pdf->MultiCell(25,10,$rowCAM[NetoUF],0,'C');
			
		}
		$Observacion = $rowCAM['Observacion'];
		if($Observacion){
			$ln += 4;
			$lnTxt = 'Observaciónes Generales: ';
				
			$pdf->SetFont('Arial','BU',9);
			$pdf->SetXY(10,$ln);
			$pdf->MultiCell(175,4,$lnTxt,0,'L');
	
			$ln += 5;
			$lnTxt = '• '.$rowCAM['Observacion'];
			$pdf->SetFont('Arial','',9);
			$pdf->SetXY(10,$ln);
			$pdf->MultiCell(175,4,$lnTxt,0,'J');
		}		
		$ln = 193;
		$lnTxt = 'Tiempo Estimado: ';
			
		$pdf->SetFont('Arial','BU',9);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(175,4,$lnTxt,0,'L');
		
		$ln += 5;
		$lnTxt = '• '.$rowCAM['dHabiles'].' días hábiles una vez recibida las muestras y la orden de compra, sujeto a confirmación ';
		$lnTxt .= 'por carga de trabajo.';
		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(175,4,$lnTxt,0,'L');

		$ln += 7.5;
		$lnTxt = '• La entrega de resultados y/o informes queda sujeta a regularización de pago.';
		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(175,4,$lnTxt,0,'L');

		$ln += 5;
		$lnTxt = 'Envío de muestras y horario:';
		$pdf->SetFont('Arial','BU',9);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(175,4,$lnTxt,0,'L');

		$bdLab=mysql_query("SELECT * FROM Laboratorio");
		if($rowLab=mysql_fetch_array($bdLab)){
			$entregaMuestras 	= $rowLab['entregaMuestras'];
			$nombreLaboratorio	= $rowLab['nombreLaboratorio'];
		}

		$bdDep=mysql_query("SELECT * FROM Departamentos");
		if($rowDep=mysql_fetch_array($bdDep)){
			$nombreDepto 	= $rowDep['nombreDepto'];
		}

		$ln += 5;
		$lnTxt = '• '.$entregaMuestras.' '.$rowDep['nombreDepto'].', '.$rowDep['nomSector'].', '.$nombreLaboratorio.'.';
		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(175,4,$lnTxt,0,'L');

		$ln += 7.5;
		$lnTxt = '• Horario de Atención:';
		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(175,4,$lnTxt,0,'L');

		$ln += 5;
		$lnTxt = '                        Lunes a Jueves 9:00 a 13:00 hrs // 14:00 a 18:00 hrs';
		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(175,4,$lnTxt,0,'L');

		$ln += 5;
		$lnTxt = '                        Viernes        9:00 a 13:00 hrs // 14:00 a 16:30 hrs';
		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(175,4,$lnTxt,0,'L');

		// Pie de Pagina
		$bdIns=mysql_query("SELECT * FROM Empresa");
		if($rowIns=mysql_fetch_array($bdIns)){
			$nombreFantasia 	= $rowIns['nombreFantasia'];
		}
		$pdf->SetTextColor(128, 128, 128);

		$ln = 238;
		$lnTxt = $nombreFantasia;
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(175,3.5,$lnTxt,0,'R');

		$ln += 3.5;
		$lnTxt = $rowDep['nombreDepto'];
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(175,3.5,$lnTxt,0,'R');

		$ln += 3.5;
		$lnTxt = $rowLab['nombreLaboratorio'];
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(175,3.5,$lnTxt,0,'R');

		$ln += 3.5;
		$lnTxt = $rowLab['Direccion'];
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(175,3.5,$lnTxt,0,'R');

		$ln += 3.5;
		$lnTxt = 'Fono: '.$rowLab['Telefono'].', Email: '.$rowLab['correoLaboratorio'];
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(175,3.5,$lnTxt,0,'R');

		$ln += 3.5;
		$lnTxt = 'www.simet.cl ';
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(175,3.5,$lnTxt,0,'R');

		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetFont('Arial','',9);
		// Fin Pie de Pagina

////////////////////////////////////////////////////////////////////////////////// 
//  Segunda Hoja 
////////////////////////////////////////////////////////////////////////////////// 

		// Encabezado 
		$pdf->AddPage();
		$pdf->SetXY(10,5);
		$pdf->Image('../../imagenes/logoSimetCam.png',10,5,43,16);

		$pdf->SetXY(110,12);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(10,5,'FECHA:',0,0);
		
		$fd 	= explode('-', $rowCAM['fechaCotizacion']);
		$pdf->SetXY(130,12);
		$pdf->Cell(50,5,$fd[2].' de '.$Mes[$fd[1]-1].' de '.$fd[0],0,0);

		$pdf->SetXY(50,17);
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(10,5,'Acreditado NCh-ISO 17.025.',0,0);

		$pdf->SetXY(110,17);
		$pdf->Cell(10,5,'Rev:',0,0);

		$Revision = $rowCAM['Rev'];
		if($rowCAM['Rev']<9){
			$Revision = '0'.$rowCAM['Rev'];
		}
		$pdf->SetXY(130,17);
		$pdf->Cell(50,5,$Revision.'.-',0,0);

		// Line(Col, FilaDesde, ColHasta, FilaHasta) 
		$pdf->Line(10, 23, 184, 23);

		$pdf->SetXY(10,17);
		$pdf->Image('../../gastos/logos/logousach.png',195,5,15,23);

		$pdf->SetFont('Arial','I',14);
		$pdf->SetXY(10,25);
		$pdf->Cell(170,5,'COTIZACIÓN CAM-'.$CAM,0,0,'C');
		$pdf->Line(10, 30, 184, 30);
		$pdf->Line(10, 30.7, 184, 30.7);
		
		$pdf->SetDrawColor(200, 200, 200);
		$pdf->Line(190, 30, 190, 270);
		$pdf->SetDrawColor(0, 0, 0);
		$pdf->Image('../../imagenes/logoSimetCam.png',185,245,20,8);
		// Fin Encabezado
		
		$ln = 35;

		$lnTxt = 'Tiempo de validez: ';
		$pdf->SetFont('Arial','BU',9);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(155,4,$lnTxt,0,'L');
		
		$ln += 5;
		$lnTxt = '• La oferta económica tiene un tiempo de validez de '.$rowCAM['Validez'].' días.';
		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(155,4,$lnTxt,0,'J');

		$ln += 7;
		$lnTxt = 'Forma de Pago: ';
		$pdf->SetFont('Arial','BU',9);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(155,4,$lnTxt,0,'L');
		
		$ln += 5;
		$lnTxt = '• Tipo de moneda, en pesos, según valor de la UF correspondiente al día de emisión de la Orden de Compra o Factura';
		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(155,4,$lnTxt,0,'J');

		$ln += 8;
		$lnTxt = '• La forma de pago será ';
		$lnTxt .= 'contra factura:';
		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(155,4,$lnTxt,0,'J');

		$ln += 5;
		$lnTxt = '•  Pago en efectivo o cheque en '.$rowIns['Direccion'].', '.$rowIns['Comuna'].'.';
		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(18,$ln);
		$pdf->MultiCell(155,4,$lnTxt,0,'J');
		//$pdf->MultiCell(155,4,$lnTxt,0,'J');

		$ln += 5;
		$lnTxt  = '• Pago mediante depósito o transferencia a nombre de '.$rowIns['razonSocial'].', '.$rowIns['Banco'].' cuenta corriente '.$rowIns['CtaCte'].' Rut: '.$rowIns['RutEmp'];
		$lnTxt .= '. Enviar confirmación a '.$rowDep['EmailDepto'].'.';
		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(18,$ln);
		$pdf->MultiCell(155,5,$lnTxt,0,'J');

		$ln += 11;
		$lnTxt = '• Clientes nuevos, sólo pago anticipado.';
		$pdf->SetFont('Arial','B',9);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(155,4,$lnTxt,0,'J');

		$ln += 7;
		$lnTxt = 'Observaciones: ';
		$pdf->SetFont('Arial','BU',9);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(155,4,$lnTxt,0,'L');
		
		
		$ln += 5;
		$lnTxt = '• Después de 10 días de corridos de la emisión de este informe se entenderá como ';
		$lnTxt .= 'aceptado en su versión final, cualquier modificación posterior tendrá un recargo ';
		$lnTxt .= 'adicional de 1 UF + IVA.';
		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(155,4,$lnTxt,0,'J');
		
		$ln += 8;
		$lnTxt = '• Se solicita indicar claramente la identificación de la muestra al momento de la recepción, para no rehacer informes. ';
		$lnTxt .= 'Cada informe rehecho por razones ajenas a SIMET-USACH tiene un costo de 1,00 UF + IVA.';
		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(155,4,$lnTxt,0,'J');

		$ln += 8;
		$lnTxt = '• Visitas a terreno en Santiago, explicativas de informes de análisis de falla o de retiro de muestras en terreno';
		$lnTxt .= ', tienen un costo adicional de 6,0 UF + IVA, visitas fuera de la región metropolitana consultar.';
		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(155,4,$lnTxt,0,'J');

		$ln += 12;
		$lnTxt = '• En caso de realizar análisis de falla, el laboratorio se reserva el derecho de modificar el tipo y/o cantidad de ensayos.';
		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(155,4,$lnTxt,0,'J');

		$ln += 9;
		$lnTxt = 'FAVOR EMITIR ORDEN DE COMPRA A NOMBRE DE:';
		$pdf->SetFont('Arial','B',9);
		$pdf->SetFillColor(197,190,151);
		$pdf->SetXY(10,$ln);
		$pdf->Cell(155,36,'',1,0,'L');
		$ln += 1;
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(155,4,$lnTxt,0,'J');
		$pdf->SetFillColor(0,0,0);

		$ln += 5;
		$lnTxt = strtoupper($rowIns['NombreEmp']);
		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(155,4,$lnTxt,0,'J');

		$ln += 5;
		$lnTxt = 'GIRO: '.$rowIns['Giro'];
		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(155,4,$lnTxt,0,'J');

		$ln += 5;
		$lnTxt = 'RUT: '.$rowIns['RutEmp'];
		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(155,4,$lnTxt,0,'J');

		$ln += 5;
		$lnTxt = 'DIRECCIÓN: '.$rowIns['Direccion'].', '.$rowIns['Comuna'];
		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(155,4,$lnTxt,0,'J');

		$ln += 5;
		$lnTxt = 'NOMBRE: '.$rowLab['contactoLaboratorio'];
		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(155,4,$lnTxt,0,'J');

		$ln += 5;
		$lnTxt = 'FONO: '.$rowIns['Fax'].' // Mail: '.$rowDep['EmailDepto'];
		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(155,4,$lnTxt,0,'J');

		$ln += 7;
		$lnTxt = 'En caso de dudas favor comunicarse con: ';
		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(155,4,$lnTxt,0,'J');

		$ln += 5;
		$lnTxt = '• Ingeniero César Segovia C.; mail: cesar.segovia@usach.cl;';
		$pdf->SetFont('Arial','B',9);
		$pdf->SetXY(20,$ln);
		$pdf->MultiCell(145,4,$lnTxt,0,'J');

		$ln += 5;
		$lnTxt = '• Ingeniero Alejandro Castillo A.; mail: alejandro.castillo.a@usach.cl;';
		$pdf->SetFont('Arial','B',9);
		$pdf->SetXY(20,$ln);
		$pdf->MultiCell(145,4,$lnTxt,0,'J');

		$ln += 5;
		$lnTxt = '• Teléfonos +56 2 2323 47 80 o +56 2 2718 32 21.';
		$pdf->SetFont('Arial','B',9);
		$pdf->SetXY(20,$ln);
		$pdf->MultiCell(145,4,$lnTxt,0,'J');

		$ln += 7;
		$lnTxt = 'Quedamos a la espera de su confirmación, saluda cordialmente.';
		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(20,$ln);
		$pdf->MultiCell(145,4,$lnTxt,0,'J');

		$bdUsr=mysql_query("SELECT * FROM Usuarios Where usr Like '%".$rowCAM['usrCotizador']."%'");
		if($rowUsr=mysql_fetch_array($bdUsr)){
			$nomCotizador 	= $rowUsr['usuario'];
		}

		$ln = 228;
		$lnTxt = $nomCotizador;
		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(130,$ln);
		$pdf->MultiCell(50,4,$lnTxt,0,'C');

		$ln += 4;
		$lnTxt = 'Laboratorio '.$rowLab['idLaboratorio'];
		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(130,$ln);
		$pdf->MultiCell(50,4,$lnTxt,0,'C');


		// Pie de Pagina
		$bdIns=mysql_query("SELECT * FROM Empresa");
		if($rowIns=mysql_fetch_array($bdIns)){
			$nombreFantasia 	= $rowIns['nombreFantasia'];
		}
		$pdf->SetTextColor(128, 128, 128);

		$ln = 238;
		$lnTxt = $nombreFantasia;
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(175,3.5,$lnTxt,0,'R');

		$ln += 3.5;
		$lnTxt = $rowDep['nombreDepto'];
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(175,3.5,$lnTxt,0,'R');

		$ln += 3.5;
		$lnTxt = $rowLab['nombreLaboratorio'];
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(175,3.5,$lnTxt,0,'R');

		$ln += 3.5;
		$lnTxt = $rowLab['Direccion'];
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(175,3.5,$lnTxt,0,'R');

		$ln += 3.5;
		$lnTxt = 'Fono: '.$rowLab['Telefono'].', Email: '.$rowLab['correoLaboratorio'];
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(175,3.5,$lnTxt,0,'R');

		$ln += 3.5;
		$lnTxt = 'www.simet.cl ';
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(175,3.5,$lnTxt,0,'R');

		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetFont('Arial','',9);
		// Fin Pie de Pagina

	}
	$fechaHoy 			= date('Y-m-d');
	$proxRecordatorio 	= strtotime ( '+10 day' , strtotime ( $rowCAM['fechaCotizacion'] ) );
	//$proxRecordatorio 	= strtotime ( '+10 day' , strtotime ( $fechaHoy ) );
	$proxRecordatorio 	= date ( 'Y-m-d' , $proxRecordatorio );

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
		$bdCot=mysql_query($actSQL);
		mysql_close($link);
	}
	//$pdf->Output('F3B-00001.pdf','I'); //Para Descarga
	$NombreFormulario = "CAM-".$CAM.".pdf";
	//$pdf->Output($NombreFormulario,'D'); //Para Descarga
	$pdf->Output($NombreFormulario,'F');
	
	$loc = "Location: http://erp.simet.cl/cotizaciones/enviarCotizacion.php?my_file=$NombreFormulario&mail_destinatario=$mail_destinatario";
	header($loc);
	//header("Location: ../modCotizacion.php?CAM=$CAM&Cta=0&Rev=0&accion=Actualizar");

?>
