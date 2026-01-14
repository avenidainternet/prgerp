<?php
require_once('../../fpdf/fpdf.php');
include_once("../../conexionli.php");
header('Content-Type: text/html; charset=utf-8');

$accion = '';

class PDF extends FPDF{
	// Cabecera de p醙ina
	function Header()
	{
		if($this->PageNo() > 1){
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
	
			if(isset($_GET['CAM'])) 	{ $CAM 	= $_GET['CAM']; 	}
			$link=Conectarse();
			$bdCo=$link->query("SELECT * FROM cotizaciones WHERE CAM = '".$CAM."'");
			if($rowCo=mysqli_fetch_array($bdCo)){
				$nContacto 		= $rowCo['nContacto'];
				$RutCli 		= $rowCo['RutCli'];
				$Habiles 		= $rowCo['dHabiles'];
				$totalOfertaUF 	= $rowCo['NetoUF'];
				if($rowCo['IvaUF'] == 0) { 
					$totalOfertaUF .= ' exento de IVA'; 
				}else{
					$totalOfertaUF .= utf8_decode(' m谩s IVA'); 
				}
			}
			$bdCli=$link->query("SELECT * FROM Clientes WHERE RutCli = '".$RutCli."'");
			if($rowCli=mysqli_fetch_array($bdCli)){
				$Cliente = $rowCli['Cliente'];
			}
			//$link->close();
			$this->Image('../../imagenes/logoSimetCam.png',10,5,43,16);
			$this->SetFont('Arial','',10);
	
			$ln = 5;
			$this->SetXY(70,$ln);
			$this->Cell(50,4,utf8_decode('Oferta T茅cnico Econ贸mica'),0,0,'C');
	
			$fe = date('Y-m-d');
			$fd 	= explode('-', $fe);
			$this->SetXY(137,$ln);
			$this->Cell(10,4,'Fecha : '.$fd[2].' de '.$Mes[$fd[1]-1].' de '.$fd[0],0,0);
	
			$this->SetXY(70,5);
			$this->Cell(50,4,utf8_decode('Oferta T茅cnico Econ贸mica'),0,0,'C');
	
			// Arial bold 15
			$ln += 4;
			$this->SetXY(70,$ln);
			$this->Cell(50,4,'OFE-'.$CAM,0,0,'C');
			
			$this->SetXY(137,$ln);
			$this->Cell(10,4,utf8_decode('Revisi贸n : 0'),0,0);
												
			$ln += 4;
			$this->SetXY(53,$ln);
			$this->SetFont('Arial','B',10);
			$this->MultiCell(84,4,$Cliente,0,'C');

			$this->SetFont('Arial','',10);
			$this->SetXY(137,$ln);
			$this->Cell(10,4,utf8_decode('P谩gina : ').$this->PageNo().' de {nb}',0,0);
	
			$ln += 5;
			$this->SetDrawColor(200, 200, 200);
			$this->Line(190, 30, 190, 270);
			$this->SetDrawColor(0, 0, 0);
	
			$this->Ln(20);
			$this->Image('../../gastos/logos/logousach.png',195,5,15,23);
		}
	}
	
	// Pie de p醙ina
	function Footer()
	{
		if($this->PageNo() > 1){
			$link=Conectarse();
			$bdLab=$link->query("SELECT * FROM Laboratorio");
			if($rowLab=mysqli_fetch_array($bdLab)){
				$entregaMuestras 	= $rowLab['entregaMuestras'];
				$nombreLaboratorio	= $rowLab['nombreLaboratorio'];
				$Direccion 			= $rowLab['Direccion'];
				$Telefono			= $rowLab['Telefono'];
				$correoLaboratorio	= $rowLab['correoLaboratorio'];
			}
			$bdDep=$link->query("SELECT * FROM departamentos");
			if($rowDep=mysqli_fetch_array($bdDep)){
				$nombreDepto 	= $rowDep['nombreDepto'];
														}
			$bdIns=$link->query("SELECT * FROM Empresa");
			if($rowIns=mysqli_fetch_array($bdIns)){
				$nombreFantasia 	= $rowIns['nombreFantasia'];
			}
			//$link->close();
	
			$this->SetTextColor(128, 128, 128);
												
			$ln = 250;
			$lnTxt = $nombreFantasia;
			$this->SetFont('Arial','',8);
			$this->SetXY(10,$ln);
			$this->MultiCell(175,3.5,$lnTxt,0,'R');
												
			$ln += 3.5;
			$lnTxt = $nombreDepto;
			$this->SetXY(10,$ln);
			$this->MultiCell(175,3.5,$lnTxt,0,'R');
												
			$ln += 3.5;
			$lnTxt = $nombreLaboratorio;
			$this->SetXY(10,$ln);
			$this->MultiCell(175,3.5,$lnTxt,0,'R');
												
			$ln += 3.5;
			$lnTxt = $Direccion;
			$this->SetXY(10,$ln);
			$this->MultiCell(175,3.5,$lnTxt,0,'R');
												
			$ln += 3.5;
			$lnTxt = 'Fono: '.$Telefono.', Email: '.$correoLaboratorio;
			$this->SetXY(10,$ln);
			$this->MultiCell(175,3.5,$lnTxt,0,'R');
												
			$ln += 3.5;
			$lnTxt = 'www.simet.cl ';
			$this->SetXY(10,$ln);
			$this->MultiCell(175,3.5,$lnTxt,0,'R');
												
			$this->SetTextColor(0, 0, 0);
			$this->SetFont('Arial','',9);
		
			// Posici髇: a 1,5 cm del final
			//$this->SetY(-15);
			// Arial italic 8
			//$this->SetFont('Arial','I',8);
			// N鷐ero de p醙ina
			//$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
		}
	}
}

// Creaci髇 del objeto de la clase heredada
$pdf = new PDF('P','mm','Letter');
//$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

	if(isset($_GET['CAM'])) 	{ $CAM 	= $_GET['CAM']; 	}

	$ln = 30;
	$link=Conectarse();
	$bdCo=$link->query("SELECT * FROM cotizaciones WHERE CAM = '".$CAM."'");
	if($rowCo=mysqli_fetch_array($bdCo)){
		$nContacto 		= $rowCo['nContacto'];
		$RutCli 		= $rowCo['RutCli'];
		$Habiles 		= $rowCo['dHabiles'];
		$totalOfertaUF 	= $rowCo['NetoUF'];
		if($rowCo['IvaUF'] == 0) { 
			$totalOfertaUF .= ' exento de IVA'; 
		}else{
			$totalOfertaUF .= ' m獬營VA'; 
		}
	}

	$bdOF=$link->query("SELECT * FROM propuestaeconomica Where OFE = '".$CAM."'");
	if($rowOF=mysqli_fetch_array($bdOF)){
		$pdf->SetXY(10,$ln);
		//$pdf->Image('../../imagenes/UDS-CNRJ.png',10,5,43,16);
		$pdf->Image('../../imagenes/UDS-CNRJ.png');
		$pdf->SetXY(40,$ln);
		//$pdf->Image('../../imagenes/TRANSPARENTE.png');
	
		$ln = 160;
		$pdf->SetXY(10,$ln);
		$pdf->SetFont('Arial','',30);
		$pdf->MultiCell(130,10,utf8_decode($rowOF['tituloOferta']),0,'C');

		$bdCli=$link->query("SELECT * FROM Clientes WHERE RutCli = '".$rowOF['RutCli']."'");
		if($rowCli=mysqli_fetch_array($bdCli)){
			$Cliente = $rowCli['Cliente'];

			$ln += 25;
			$pdf->SetXY(10,$ln);
			$pdf->SetFont('Arial','B',14);
			$pdf->Cell(25,5,'Empresa: ',0,0);
			$pdf->MultiCell(148,5,utf8_decode($rowCli['Cliente']),0,'C');

			$ln += 15;
			$pdf->SetXY(85,$ln);
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(100,5,'Ref: OFE-'.$CAM,0,0);

			$pdf->SetXY(150,$ln);
			$pdf->Cell(100,5,utf8_decode('N掳 P谩ginas ').'{nb}',0,0);

			$ln += 5;
			$pdf->Line(65, $ln, 185, $ln);
			$ln++;
			$pdf->Line(65, $ln, 185, $ln);
			//$pdf->SetDrawColor(200, 200, 200);
			$pdf->Line(145, $ln-7, 145, 240);

			$ln += 1;
			$pdf->SetXY(65,$ln);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(100,5,'Elaborado',0,0);

			$pdf->SetXY(148,$ln);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(100,5,'Fecha:',0,0);

			$ln += 5;
			$pdf->SetFont('Arial','',10);
			$bdUs=$link->query("SELECT * FROM usuarios WHERE usr = '".$rowOF['usrElaborado']."'");
			if($rowUs=mysqli_fetch_array($bdUs)){
				$pdf->SetXY(68,$ln);
				$pdf->Cell(90,5,utf8_decode($rowUs['usuario']),0,0);
			}
			$fd = explode('-',$rowOF['fechaElaboracion']);
			$pdf->SetXY(147,$ln);
			$pdf->Cell(90,5,$fd[1].'/'.$fd[2].'/'.$fd[0],0,0);
			$ln += 5;
			$pdf->Line(65, $ln, 185, $ln);

			$ln += 1;
			$pdf->SetXY(65,$ln);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(100,5,'Revisado y Aprobado',0,0);

			$pdf->SetXY(148,$ln);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(100,5,'Fecha:',0,0);

			$ln += 5;
			$pdf->SetFont('Arial','',10);
			$bdUs=$link->query("SELECT * FROM usuarios WHERE usr = '".$rowOF['usrAprobado']."'");
			if($rowUs=mysqli_fetch_array($bdUs)){
				$pdf->SetXY(68,$ln);
				$pdf->Cell(85,5,utf8_decode($rowUs['usuario']),0,0);
			}

			$pdf->SetXY(147,$ln);
			$fd = explode('-',$rowOF['fechaAprobacion']);
			$pdf->Cell(90,5,$fd[1].'/'.$fd[2].'/'.$fd[0],0,0);
			$ln += 5;
			$pdf->Line(65, $ln, 185, $ln);

			$ln += 1;
			$pdf->SetXY(65,$ln);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(100,5,'Empresa Destinataria',0,0);

			$pdf->SetXY(148,$ln);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(100,5,'Atenci贸n:',0,0);

			$ln += 5;
			$pdf->SetXY(68,$ln);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(70,5,utf8_decode($rowCli['Cliente']),0,0);

			$bdCc=$link->query("SELECT * FROM contactosCli Where RutCli = '".$rowCli['RutCli']."' and nContacto = '".$nContacto."'");
			if($rowCc=mysqli_fetch_array($bdCc)){
				$pdf->SetFont('Arial','',10);
				$pdf->SetXY(147,$ln);
				$pdf->Cell(90,5,utf8_decode($rowCc['Contacto']),0,0);
			}
		}		

		$pdf->AddPage();
		$ln = 30;

		$bdCli=$link->query("SELECT * FROM Clientes WHERE RutCli = '".$rowOF['RutCli']."'");
		if($rowCli=mysqli_fetch_array($bdCli)){
			$pdf->SetXY(10,$ln);
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(170,5,'El servicio es solicitado por: ',0,0);

			$ln += 5;
			$pdf->SetXY(15,$ln);
			$pdf->Cell(30,5,utf8_decode('Raz贸n Social'),0,0,'L');
			$pdf->SetXY(40,$ln);
			$pdf->Cell(50,4,': '.utf8_decode(strtoupper($rowCli['Cliente'])),0,0,'L');

			$ln += 5;
			$pdf->SetXY(15,$ln);
			$pdf->Cell(30,5,'RUT',0,0,'L');
			$pdf->SetXY(40,$ln);
			$pdf->Cell(50,4,': '.$rowCli['RutCli'],0,0,'L');

			$ln += 5;
			$pdf->SetXY(15,$ln);
			$pdf->Cell(30,5,'Contacto',0,0,'L');
			$pdf->SetXY(40,$ln);
			$bdCc=$link->query("SELECT * FROM contactosCli Where RutCli = '".$rowCli['RutCli']."' and nContacto = '".$nContacto."'");
			if($rowCc=mysqli_fetch_array($bdCc)){
				$pdf->Cell(50,5,': '.utf8_decode($rowCc['Contacto']),0,0,'L');
				$ln += 5;
				$pdf->SetXY(15,$ln);
				$pdf->Cell(30,5,'Contacto',0,0,'L');
				$pdf->SetXY(40,$ln);
				$pdf->Cell(50,5,': '.$rowCc['Email'],0,0,'L');
			}

		}

		$pdf->Ln(5);
		$bdDp=$link->query("SELECT * FROM descripcionpropuesta Order By itemPropuesta");
		if($rowDp=mysqli_fetch_array($bdDp)){
			do{
				$nLn = $pdf->GetY();
				//$pdf->Cell(30,5,$rowDp['itemPropuesta'].'.- '.strtoupper($rowDp['titPropuesta']).' X '.$pdf->GetX().' Y '.$pdf->GetY(),0,0,'L');
				if($nLn >= 215){
					$pdf->AddPage();
					$ln = 30;
					$pdf->SetXY(10,$ln);
				}else{
					$pdf->Ln(5);
				}
				$pdf->SetFont('Arial','B',10);
				$pdf->SetX(10);
				$pdf->Cell(30,5,utf8_decode($rowDp['itemPropuesta']).'.- '.utf8_decode(strtoupper($rowDp['titPropuesta'])),0,0,'L');

				$pdf->Ln(5);
				$pdf->SetFont('Arial','',10);
				if(strpos($rowDp['descripcion'], '$objetivoGeneral')){
					$descripcion = '';
					$objetivoGeneral = $rowDp['descripcion'];
					$descripcion = utf8_decode(str_replace('$objetivoGeneral',$rowOF['objetivoGeneral'],$rowDp['descripcion']));
				}else{
					if(strpos($rowDp['descripcion'], '$Habiles')){
						$descripcion = '';
						$objetivoGeneral = $rowOF['objetivoGeneral'];
						$descripcion = utf8_decode(str_replace('$Habiles',$Habiles,$rowDp['descripcion']));
					}else{
						if(strpos($rowDp['descripcion'], '$totalOfertaUF')){
							$objetivoGeneral = utf8_decode($rowOF['objetivoGeneral']);
							$descripcion = '';
							$objetivoGeneral = utf8_decode($rowDp['descripcion']);
							$descripcion = str_replace('$totalOfertaUF',$totalOfertaUF,utf8_decode($rowDp['descripcion']));
						}else{
							$descripcion = utf8_decode($rowDp['descripcion']);
						}
					}
				}
				$pdf->SetX(15);
				$pdf->MultiCell(170,5,$descripcion,0,'J');

				if(strpos($rowDp['descripcion'], '$objetivoGeneral')){
					$bdObj=$link->query("SELECT * FROM objetivospropuestas where OFE = '".$CAM."' Order By nObjetivo");
					if($rowObj=mysqli_fetch_array($bdObj)){
						do{
							$pdf->SetFont('Arial','',10);
							$pdf->SetX(20);
							$pdf->MultiCell(165,5,'- '.utf8_decode($rowObj['Objetivos']),0,'J');
							$pdf->Ln(3);
						}while ($rowObj=mysqli_fetch_array($bdObj));
					}
				}

				$bdIp=$link->query("SELECT * FROM itempropuesta where itemPropuesta = '".$rowDp['itemPropuesta']."'");
				if($rowIp=mysqli_fetch_array($bdIp)){
					do{
						$nLn = $pdf->GetY();
						if($nLn >= 225){
							$pdf->AddPage();
							$ln = 30;
							$pdf->SetXY(10,$ln);
						}else{
							$pdf->Ln(5);
						}
						//$pdf->Ln(5);
						$pdf->SetFont('Arial','B',10);
						$pdf->SetX(15);
						$pdf->Cell(30,5,utf8_decode($rowDp['itemPropuesta'].'.'.$rowIp['subItem']).' '.utf8_decode($rowIp['titSubItem']),0,0,'L');

						$nLn = $pdf->GetY();
						if($nLn >= 225){
							$pdf->AddPage();
							$ln = 30;
							$pdf->SetXY(10,$ln);
						}else{
							$pdf->Ln(5);
						}
						
						//$pdf->Ln(5);
						$pdf->SetFont('Arial','',10);
						$pdf->SetX(20);
						$pdf->MultiCell(165,5,utf8_decode($rowIp['descripcionSubItem']),0,'J');

						if($rowIp['Ensayos'] == 'on'){
							$nIdEnsayos = 0;
							$bdEns=$link->query("SELECT * FROM ensayosofe Where OFE = '".$CAM."' Order By nDescEnsayo");
							if($rowEns=mysqli_fetch_array($bdEns)){
								do{
									$bdIe=$link->query("SELECT * FROM ofensayos Where nDescEnsayo = '".$rowEns['nDescEnsayo']."'");
									if($rowIe=mysqli_fetch_array($bdIe)){
											$nLn = $pdf->GetY();
/*											
											if($nLn >= 225){
												$pdf->AddPage();
											}
*/											
											$nIdEnsayos++;
											$nLn = $pdf->GetY();
											//$pdf->Cell(30,5,$rowDp['itemPropuesta'].'.'.$rowIp['subItem'].'.'.$nIdEnsayos.'.- '.$rowIe['nomEnsayo'].' X '.$pdf->GetX().' Y '.$pdf->GetY(),0,0,'L');
											if($nLn >= 223){
												$pdf->AddPage();
												$ln = 30;
												$pdf->SetXY(10,$ln);
											}else{
												$pdf->Ln(5);
											}
											$pdf->SetFont('Arial','B',10);
											$pdf->SetX(20);
											$pdf->Cell(30,5,$rowDp['itemPropuesta'].'.'.$rowIp['subItem'].'.'.$nIdEnsayos.'.- '.utf8_decode($rowIe['nomEnsayo']),0,0,'L');
										
											$pdf->Ln(5);
											$pdf->SetFont('Arial','',10);
											$pdf->SetX(35);
											$pdf->MultiCell(150,5,utf8_decode($rowIe['Descripcion']),0,'J');
											if($rowIe['Generico'] != 'on'){
												$i = 0;
												$bdEA=$link->query("SELECT * FROM otrosensayos where OFE = '".$CAM."' Order By nOtro");
												if($rowEA=mysqli_fetch_array($bdEA)){
													do{
														$i++;
														if($i > 1){
															$pdf->Ln(5);
														}
														$pdf->SetFont('Arial','',10);
														$pdf->SetX(35);
														$pdf->MultiCell(150,5,'掳 '.utf8_decode($rowEA['Descripcion']),0,'J');
													}while ($rowEA=mysqli_fetch_array($bdEA));
												}
											}
		
									}
								}while ($rowEns=mysqli_fetch_array($bdEns));
							}
						}

					}while ($rowIp=mysqli_fetch_array($bdIp));
				}

			}while ($rowDp=mysqli_fetch_array($bdDp));
		}		

	}

	$nItem = 5;
	$nLn = $pdf->GetY();
	if($nLn >= 225){
		$pdf->AddPage();
		$ln = 30;
		$pdf->SetXY(10,$ln);
	}else{
		$pdf->Ln(2);
	}
	$pdf->SetFont('Arial','B',10);
	$pdf->SetX(15);
	$pdf->Cell(30,5,$nItem.utf8_decode('.1.- Env铆o de Muestras y Horario:'),0,0,'L');
	
	$nLn = $pdf->GetY();
	if($nLn >= 225){
		$pdf->AddPage();
		$ln = 30;
		$pdf->SetXY(10,$ln);
	}else{
		$pdf->Ln(5);
	}
	$pdf->SetFont('Arial','',10);
	$pdf->SetX(20);
	$pdf->MultiCell(160,5,utf8_decode(' Av. El belloto N掳 3735, Estaci贸n Central, Santiago.'),0);

	$nLn = $pdf->GetY();
	if($nLn >= 225){
		$pdf->AddPage();
		$ln = 30;
		$pdf->SetXY(10,$ln);
	}else{
		$pdf->Ln(2);
	}
	$pdf->SetX(20);
	$pdf->MultiCell(160,5,utf8_decode('- Departamento de Ingenier铆a Metalurgia, Sector Fundici贸n, Laboratorio de Ensayos e Investigaci贸n de Materiales SIMET-USACH.'),0);

	$nLn = $pdf->GetY();
	if($nLn >= 225){
		$pdf->AddPage();
		$ln = 30;
		$pdf->SetXY(10,$ln);
	}else{
		$pdf->Ln(2);
	}
	$pdf->SetX(20);
	$pdf->MultiCell(160,5,utf8_decode('- Horario de Atenci贸n: Lunes a Jueves 9:00 a 13:00 hrs // 14:00 a 18:00 hrs Viernes 9:00 a 13:00 hrs // 14:00 a 16:30 hrs., previa coordinaci贸n para piezas grandes.'),0);

	$nLn = $pdf->GetY();
	if($nLn >= 225){
		$pdf->AddPage();
		$ln = 30;
		$pdf->SetXY(10,$ln);
	}else{
		$pdf->Ln(5);
	}
	$pdf->SetFont('Arial','B',10);
	$pdf->SetX(15);
	$pdf->Cell(30,5,$nItem.'.2.- Condiciones de Pago:',0,0,'L');

	$nLn = $pdf->GetY();
	if($nLn >= 225){
		$pdf->AddPage();
		$ln = 30;
		$pdf->SetXY(10,$ln);
	}else{
		$pdf->Ln(5);
	}
	$pdf->SetFont('Arial','',10);
	$pdf->SetX(20);
	$pdf->MultiCell(160,5,utf8_decode('- Tipo de moneda, en pesos, seg煤n valor de la UF correspondiente al d铆a de emisi贸n de la Orden de Compra o Factura.'),0);

	$nLn = $pdf->GetY();
	if($nLn >= 225){
		$pdf->AddPage();
		$ln = 30;
		$pdf->SetXY(10,$ln);
	}else{
		$pdf->Ln(2);
	}
	$pdf->SetFont('Arial','',10);
	$pdf->SetX(20);
	$pdf->MultiCell(160,5,utf8_decode('- La forma de pago ser谩 contra factura:'),0);

	$nLn = $pdf->GetY();
	if($nLn >= 225){
		$pdf->AddPage();
		$ln = 30;
		$pdf->SetXY(10,$ln);
	}else{
		$pdf->Ln(2);
	}
	$pdf->SetFont('Arial','',10);
	$pdf->SetX(25);
	$pdf->MultiCell(160,5,utf8_decode("- Pago en efectivo o cheque en Avenida Libertador Bernardo O'Higgins 1611, Santiago."),0);

	$nLn = $pdf->GetY();
	if($nLn >= 225){
		$pdf->AddPage();
		$ln = 30;
		$pdf->SetXY(10,$ln);
	}else{
		$pdf->Ln(2);
	}
	$pdf->SetFont('Arial','',10);
	$pdf->SetX(25);
	$pdf->MultiCell(160,5,utf8_decode("- Pago mediante dep贸sito o transferencia a nombre de SDT USACH, Banco BCI cuenta corriente 10358391 Rut: 78172420-3. Enviar confirmaci贸n a simet@usach.cl."),0);

	$nLn = $pdf->GetY();
	if($nLn >= 225){
		$pdf->AddPage();
		$ln = 30;
		$pdf->SetXY(10,$ln);
	}else{
		$pdf->Ln(2);
	}
	$pdf->SetFont('Arial','',10);
	$pdf->SetX(25);
	$pdf->MultiCell(160,5,utf8_decode("- Clientes nuevos, s贸lo pago anticipado."),0);

	$nLn = $pdf->GetY();
	if($nLn >= 225){
		$pdf->AddPage();
		$ln = 30;
		$pdf->SetXY(10,$ln);
	}else{
		$pdf->Ln(5);
	}
	$pdf->SetFont('Arial','B',10);
	$pdf->SetX(15);
	$pdf->Cell(30,5,$nItem.'.3.- Observaciones Generales:',0,0,'L');

	$nLn = $pdf->GetY();
	if($nLn >= 225){
		$pdf->AddPage();
		$ln = 30;
		$pdf->SetXY(10,$ln);
	}else{
		$pdf->Ln(5);
	}
	$pdf->SetFont('Arial','',10);
	$pdf->SetX(20);
	$pdf->MultiCell(160,5,utf8_decode('- Despu茅s de 10 d铆as de corridos de la emisi贸n de este informe se entender谩 como aceptado en su versi贸n final, cualquier modificaci贸n posterior tendr谩 un recargo adicional de 1UF + IVA.'),0);

	$nLn = $pdf->GetY();
	if($nLn >= 225){
		$pdf->AddPage();
		$ln = 30;
		$pdf->SetXY(10,$ln);
	}else{
		$pdf->Ln(5);
	}
	$pdf->SetFont('Arial','',10);
	$pdf->SetX(20);
	$pdf->MultiCell(160,5,utf8_decode('- Se solicita indicar claramente la identificaci贸n de la muestra al momento de la recepci贸n, para no rehacer informes. Cada informe rehecho por razones ajenas a SIMET-USACH tiene un costo de 1,00 UF + IVA.'),0);

	$nLn = $pdf->GetY();
	if($nLn >= 225){
		$pdf->AddPage();
		$ln = 30;
		$pdf->SetXY(10,$ln);
	}else{
		$pdf->Ln(5);
	}
	$pdf->SetFont('Arial','',10);
	$pdf->SetX(20);
	$pdf->MultiCell(160,5,utf8_decode('- Visitas a terreno en Santiago, explicativas de informes de an谩lisis de falla o de retiro de muestras en terreno, tienen un costo adicional de 6,0 UF + IVA, visitas fuera de la regi贸n metropolitana consultar.'),0);

	$nLn = $pdf->GetY();
	if($nLn >= 225){
		$pdf->AddPage();
		$ln = 30;
		$pdf->SetXY(10,$ln);
	}else{
		$pdf->Ln(5);
	}

	$pdf->SetFont('Arial','',10);
	$pdf->SetX(20);
	$pdf->MultiCell(160,5,utf8_decode('- En caso de realizar an谩lisis de falla, el laboratorio se reserva el derecho de modificar el tipo y/o cantidad de ensayos.'),0);


	$pdf->AddPage();
	$ln = 30;
	$pdf->SetXY(10,$ln);

	$pdf->SetFont('Arial','B',10);
	$pdf->SetXY(10, $ln);
	$pdf->Cell(30,5,'FAVOR EMITIR ORDEN DE COMPRA A NOMBRE DE:',0,0,'L');

	$ln += 5;
	$pdf->SetFont('Arial','',10);
	$pdf->SetXY(20, $ln);
	$pdf->Cell(60,5,utf8_decode('RAZ脫N SOCIAL'),0,0,'L');
	$pdf->SetXY(60, $ln);
	$pdf->Cell(100,5,utf8_decode(': SOCIEDAD DE DESARROLLO T脫CNOLOGICO USACH LTDA.'),0,0,'L');

	$ln += 5;
	$pdf->SetFont('Arial','',10);
	$pdf->SetXY(20, $ln);
	$pdf->Cell(60,5,'GIRO',0,0,'L');
	$pdf->SetXY(60, $ln);
	$pdf->Cell(100,5,utf8_decode(': Educaci贸n, Capacitaci贸n y Publicidad'),0,0,'L');

	$ln += 5;
	$pdf->SetFont('Arial','',10);
	$pdf->SetXY(20, $ln);
	$pdf->Cell(60,5,'RUT',0,0,'L');
	$pdf->SetXY(60, $ln);
	$pdf->Cell(100,5,': 78172420-3',0,0,'L');

	$ln += 5;
	$pdf->SetFont('Arial','',10);
	$pdf->SetXY(20, $ln);
	$pdf->Cell(60,5,utf8_decode('DIRECCI脫N'),0,0,'L');
	$pdf->SetXY(60, $ln);
	$pdf->Cell(100,5,utf8_decode(": Avenida Libertador Bernardo O'Higgins 1611"),0,0,'L');

	$ln += 5;
	$pdf->SetFont('Arial','',10);
	$pdf->SetXY(20, $ln);
	$pdf->Cell(60,5,'NOMBRE',0,0,'L');
	$pdf->SetXY(60, $ln);
	$pdf->Cell(100,5,utf8_decode(": Emma Barcel贸 Araos"),0,0,'L');

	$ln += 5;
	$pdf->SetFont('Arial','',10);
	$pdf->SetXY(20, $ln);
	$pdf->Cell(60,5,'FONO',0,0,'L');
	$pdf->SetXY(60, $ln);
	$pdf->Cell(100,5,": +56 2 2324780",0,0,'L');

	$ln += 5;
	$pdf->SetFont('Arial','',10);
	$pdf->SetXY(20, $ln);
	$pdf->Cell(60,5,'Mail',0,0,'L');
	$pdf->SetXY(60, $ln);
	$pdf->Cell(100,5,": simet@usach.cl",0,0,'L');
	

	$NombreFormulario = "OFE-".$rowOF['OFE'].".pdf";
	$pdf->Output($NombreFormulario,'D'); //Para Descarga
	$link->close();
//$pdf->Output();
?>