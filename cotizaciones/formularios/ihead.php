<?php
require_once('../../fpdf/fpdf.php');
include_once("../../conexion.php");

$accion = '';

class PDF extends FPDF{
	// Cabecera de página
	function Header()
	{
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
		$bdCo=mysql_query("SELECT * FROM cotizaciones WHERE CAM = '".$CAM."'");
		if($rowCo=mysql_fetch_array($bdCo)){
			$nContacto 		= $rowCo['nContacto'];
			$RutCli 		= $rowCo['RutCli'];
			$Habiles 		= $rowCo['dHabiles'];
			$totalOfertaUF 	= $rowCo['NetoUF'];
		}
		$bdCli=mysql_query("SELECT * FROM Clientes WHERE RutCli = '".$RutCli."'");
		if($rowCli=mysql_fetch_array($bdCli)){
			$Cliente = $rowCli['Cliente'];
		}
		//mysql_close($link);
		$this->Image('../../imagenes/logoSimetCam.png',10,5,43,16);
		$this->SetFont('Arial','',10);

		$ln = 5;
		$this->SetXY(70,$ln);
		$this->Cell(50,4,'Oferta Técnico Económica',0,0,'C');

		$fe = date('Y-m-d');
		$fd 	= explode('-', $fe);
		$this->SetXY(130,$ln);
		$this->Cell(10,4,'Fecha : '.$fd[2].' de '.$Mes[$fd[1]-1].' de '.$fd[0],0,0);

		$this->SetXY(70,5);
		$this->Cell(50,4,'Oferta Técnico Económica',0,0,'C');

		// Arial bold 15
		$ln += 4;
		$this->SetXY(70,$ln);
		$this->Cell(50,4,'OFE-'.$CAM,0,0,'C');
		
		$this->SetXY(130,$ln);
		$this->Cell(10,4,'Revisión : 0',0,0);
											
		$ln += 4;
		$this->SetFont('Arial','',10);
		$this->SetXY(130,$ln);
		$this->Cell(10,4,'Página : '.$this->PageNo().'/{nb}',0,0);

		$ln += 5;
		$this->SetXY(70,$ln);
		$this->SetFont('Arial','B',10);
		$this->Cell(50,4,$Cliente,0,0,'C');

		$this->SetDrawColor(200, 200, 200);
		$this->Line(190, 30, 190, 270);
		$this->SetDrawColor(0, 0, 0);

		$this->Ln(20);
		$this->Image('../../gastos/logos/logousach.png',195,5,15,23);
	}
	
	// Pie de página
	function Footer()
	{
	
		
		$link=Conectarse();
		$bdLab=mysql_query("SELECT * FROM Laboratorio");
		if($rowLab=mysql_fetch_array($bdLab)){
			$entregaMuestras 	= $rowLab['entregaMuestras'];
			$nombreLaboratorio	= $rowLab['nombreLaboratorio'];
			$Direccion 			= $rowLab['Direccion'];
			$Telefono			= $rowLab['Telefono'];
			$correoLaboratorio	= $rowLab['correoLaboratorio'];
		}
		$bdDep=mysql_query("SELECT * FROM departamentos");
		if($rowDep=mysql_fetch_array($bdDep)){
			$nombreDepto 	= $rowDep['nombreDepto'];
													}
		$bdIns=mysql_query("SELECT * FROM Empresa");
		if($rowIns=mysql_fetch_array($bdIns)){
			$nombreFantasia 	= $rowIns['nombreFantasia'];
		}
		//mysql_close($link);

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
	
		// Posición: a 1,5 cm del final
		//$this->SetY(-15);
		// Arial italic 8
		//$this->SetFont('Arial','I',8);
		// Número de página
		//$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
}

// Creación del objeto de la clase heredada
$pdf = new PDF('P','mm','Letter');
//$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

	if(isset($_GET['CAM'])) 	{ $CAM 	= $_GET['CAM']; 	}

	$ln = 30;
	$link=Conectarse();
	$bdCo=mysql_query("SELECT * FROM cotizaciones WHERE CAM = '".$CAM."'");
	if($rowCo=mysql_fetch_array($bdCo)){
		$nContacto 		= $rowCo['nContacto'];
		$RutCli 		= $rowCo['RutCli'];
		$Habiles 		= $rowCo['dHabiles'];
		$totalOfertaUF 	= $rowCo['NetoUF'];
	}

	$bdOF=mysql_query("SELECT * FROM propuestaeconomica Where OFE = '".$CAM."'");
	if($rowOF=mysql_fetch_array($bdOF)){
		$pdf->SetXY(10,$ln);
		//$pdf->Image('../../img/UDS-CNRJ.png',10,5,43,16);
		$pdf->Image('../../../img/UDS-CNRJ.png');
		$pdf->SetXY(40,$ln);
		//$pdf->Image('../../img/TRANSPARENTE.png');
		$pdf->Image('../../../img/TRANSPARENTE.png');
	
		$ln = 160;
		$pdf->SetXY(10,$ln);
		$pdf->SetFont('Arial','',30);
		$pdf->MultiCell(100,10,$rowOF['tituloOferta'],0);

		$bdCli=mysql_query("SELECT * FROM Clientes WHERE RutCli = '".$rowOF['RutCli']."'");
		if($rowCli=mysql_fetch_array($bdCli)){
			$Cliente = $rowCli['Cliente'];

			$ln += 25;
			$pdf->SetXY(10,$ln);
			$pdf->SetFont('Arial','B',14);
			$pdf->Cell(100,5,'Empresa: '.$rowCli['Cliente'],0,0);

			$ln += 15;
			$pdf->SetXY(100,$ln);
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(100,5,'Ref: OFE-'.$CAM,0,0);

			$pdf->SetXY(165,$ln);
			$pdf->Cell(100,5,'N° Páginas '.'{nb}',0,0);

			$ln += 5;
			$pdf->Line(80, $ln, 200, $ln);
			$ln++;
			$pdf->Line(80, $ln, 200, $ln);
			//$pdf->SetDrawColor(200, 200, 200);
			$pdf->Line(160, $ln-7, 160, 250);

			$ln += 1;
			$pdf->SetXY(80,$ln);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(100,5,'Elaborado',0,0);

			$pdf->SetXY(163,$ln);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(100,5,'Fecha:',0,0);

			$ln += 5;
			$pdf->SetFont('Arial','B',10);
			$bdUs=mysql_query("SELECT * FROM usuarios WHERE usr = '".$rowOF['usrElaborado']."'");
			if($rowUs=mysql_fetch_array($bdUs)){
				$pdf->SetXY(83,$ln);
				$pdf->Cell(90,5,$rowUs['usuario'],0,0);
			}
			$fd = explode('-',$rowOF['fechaElaboracion']);
			$pdf->SetXY(170,$ln);
			$pdf->Cell(90,5,$fd[1].'/'.$fd[2].'/'.$fd[0],0,0);
			$ln += 5;
			$pdf->Line(80, $ln, 200, $ln);

			$ln += 1;
			$pdf->SetXY(80,$ln);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(100,5,'Revisado y Aprobado',0,0);

			$pdf->SetXY(163,$ln);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(100,5,'Fecha:',0,0);

			$ln += 5;
			$pdf->SetFont('Arial','B',10);
			$bdUs=mysql_query("SELECT * FROM usuarios WHERE usr = '".$rowOF['usrAprobado']."'");
			if($rowUs=mysql_fetch_array($bdUs)){
				$pdf->SetXY(83,$ln);
				$pdf->Cell(85,5,$rowUs['usuario'],0,0);
			}

			$pdf->SetXY(170,$ln);
			$fd = explode('-',$rowOF['fechaAprobacion']);
			$pdf->Cell(90,5,$fd[1].'/'.$fd[2].'/'.$fd[0],0,0);
			$ln += 5;
			$pdf->Line(80, $ln, 200, $ln);

			$ln += 1;
			$pdf->SetXY(80,$ln);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(100,5,'Empresa Destinataria',0,0);

			$pdf->SetXY(163,$ln);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(100,5,'Atención:',0,0);

			$ln += 5;
			$pdf->SetXY(83,$ln);
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(90,5,$rowCli['Cliente'],0,0);

			$bdCc=mysql_query("SELECT * FROM contactosCli Where RutCli = '".$rowCli['RutCli']."' and nContacto = '".$nContacto."'");
			if($rowCc=mysql_fetch_array($bdCc)){
				$pdf->SetXY(170,$ln);
				$pdf->Cell(90,5,$rowCc['Contacto'],0,0);
			}
		}		

		$pdf->AddPage();
		$ln = 30;

		$bdCli=mysql_query("SELECT * FROM Clientes WHERE RutCli = '".$rowOF['RutCli']."'");
		if($rowCli=mysql_fetch_array($bdCli)){
			$pdf->SetXY(10,$ln);
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(170,5,'El servicio es solicitado por: ',0,0);

			$ln += 5;
			$pdf->SetXY(15,$ln);
			$pdf->Cell(30,5,'Razón Social',0,0,'L');
			$pdf->SetXY(40,$ln);
			$pdf->Cell(50,4,': '.strtoupper($rowCli['Cliente']),0,0,'L');

			$ln += 5;
			$pdf->SetXY(15,$ln);
			$pdf->Cell(30,5,'RUT',0,0,'L');
			$pdf->SetXY(40,$ln);
			$pdf->Cell(50,4,': '.$rowCli['RutCli'],0,0,'L');

			$ln += 5;
			$pdf->SetXY(15,$ln);
			$pdf->Cell(30,5,'Contacto',0,0,'L');
			$pdf->SetXY(40,$ln);
			$bdCc=mysql_query("SELECT * FROM contactosCli Where RutCli = '".$rowCli['RutCli']."' and nContacto = '".$nContacto."'");
			if($rowCc=mysql_fetch_array($bdCc)){
				$pdf->Cell(50,5,': '.$rowCc['Contacto'],0,0,'L');
				$ln += 5;
				$pdf->SetXY(15,$ln);
				$pdf->Cell(30,5,'Contacto',0,0,'L');
				$pdf->SetXY(40,$ln);
				$pdf->Cell(50,5,': '.$rowCc['Email'],0,0,'L');
			}

		}

		$pdf->Ln(5);
		$bdDp=mysql_query("SELECT * FROM descripcionpropuesta Order By itemPropuesta");
		if($rowDp=mysql_fetch_array($bdDp)){
			do{
				if($rowDp['itemPropuesta'] == 5){
					$pdf->AddPage();
					$ln = 30;
					$pdf->SetXY(10,$ln);
				}else{
					$pdf->Ln(5);
				}
				$pdf->SetFont('Arial','B',10);
				$pdf->SetX(10);
				$pdf->Cell(30,5,$rowDp['itemPropuesta'].'.- '.strtoupper($rowDp['titPropuesta']),0,0,'L');

				$pdf->Ln(5);
				$pdf->SetFont('Arial','',10);
				if(strpos($rowDp['descripcion'], '$objetivoGeneral')){
					$descripcion = '';
					$objetivoGeneral = $rowDp['descripcion'];
					$descripcion = str_replace('$objetivoGeneral',$rowOF['objetivoGeneral'],$rowDp['descripcion']);
				}else{
					if(strpos($rowDp['descripcion'], '$Habiles')){
						$descripcion = '';
						$objetivoGeneral = $rowOF['objetivoGeneral'];
						$descripcion = str_replace('$Habiles',$Habiles,$rowDp['descripcion']);
					}else{
						if(strpos($rowDp['descripcion'], '$totalOfertaUF')){
							$objetivoGeneral = $rowOF['objetivoGeneral'];
							$descripcion = '';
							$objetivoGeneral = $rowDp['descripcion'];
							$descripcion = str_replace('$totalOfertaUF',$totalOfertaUF,$rowDp['descripcion']);
						}else{
							$descripcion = $rowDp['descripcion'];
						}
					}
				}
				$pdf->SetX(15);
				$pdf->MultiCell(170,5,$descripcion,0,'J');

				if(strpos($rowDp['descripcion'], '$objetivoGeneral')){
					$bdObj=mysql_query("SELECT * FROM objetivospropuesta where OFE = '".$CAM."' Order By nObjetivo");
					if($rowObj=mysql_fetch_array($bdObj)){
						do{
							$pdf->SetFont('Arial','',10);
							$pdf->SetX(20);
							$pdf->MultiCell(165,5,'• '.$rowObj['Objetivos'],0,'J');
							$pdf->Ln(3);
						}while ($rowObj=mysql_fetch_array($bdObj));
					}
				}

				$bdIp=mysql_query("SELECT * FROM itempropuesta where itemPropuesta = '".$rowDp['itemPropuesta']."'");
				if($rowIp=mysql_fetch_array($bdIp)){
					do{
						$pdf->Ln(5);
						$pdf->SetFont('Arial','B',10);
						$pdf->SetX(15);
						$pdf->Cell(30,5,$rowDp['itemPropuesta'].'.'.$rowIp['subItem'].' '.$rowIp['titSubItem'],0,0,'L');

						$pdf->Ln(5);
						$pdf->SetFont('Arial','',10);
						$pdf->SetX(20);
						$pdf->MultiCell(165,5,$rowIp['descripcionSubItem'],0,'J');

/*
						$nLn = $pdf->GetY();
						if($nLn >= 225){
							$pdf->AddPage();
						}
*/						
						if($rowIp['Ensayos'] == 'on'){
							$nIdEnsayos = 0;
							$bdEns=mysql_query("SELECT * FROM ensayosofe Where OFE = '".$CAM."' Order By nDescEnsayo");
							if($rowEns=mysql_fetch_array($bdEns)){
								do{
									$bdIe=mysql_query("SELECT * FROM ofensayos Where nDescEnsayo = '".$rowEns['nDescEnsayo']."'");
									if($rowIe=mysql_fetch_array($bdIe)){
											$nLn = $pdf->GetY();
/*											
											if($nLn >= 225){
												$pdf->AddPage();
											}
*/											
											$nIdEnsayos++;
											$pdf->Ln(5);
											$pdf->SetFont('Arial','B',10);
											$pdf->SetX(20);
											$pdf->Cell(30,5,$rowDp['itemPropuesta'].'.'.$rowIp['subItem'].'.'.$nIdEnsayos.'.- '.$rowIe['nomEnsayo'],0,0,'L');
										
											$pdf->Ln(5);
											$pdf->SetFont('Arial','',10);
											$pdf->SetX(35);
											$pdf->MultiCell(150,5,$rowIe['Descripcion'],0,'J');
		
									}
								}while ($rowEns=mysql_fetch_array($bdEns));
							}
						}

					}while ($rowIp=mysql_fetch_array($bdIp));
				}

			}while ($rowDp=mysql_fetch_array($bdDp));
		}		

	}

	$nItem = 5;
	$pdf->SetFont('Arial','B',10);
	$pdf->SetX(15);
	$pdf->Cell(30,5,$nItem.'.1.- Envío de Muestras y Horario:',0,0,'L');
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetX(20);
	$pdf->MultiCell(160,5,'• Av. El belloto N° 3735, Estación Central, Santiago.',0);

	$pdf->Ln(2);
	$pdf->SetX(20);
	$pdf->MultiCell(160,5,'• Departamento de Ingeniería Metalurgia, Sector Fundición, Laboratorio de Ensayos e Investigación de Materiales SIMET-USACH.',0);

	$pdf->Ln(2);
	$pdf->SetX(20);
	$pdf->MultiCell(160,5,'• Horario de Atención: Lunes a Jueves 9:00 a 13:00 hrs // 14:00 a 18:00 hrs Viernes 9:00 a 13:00 hrs // 14:00 a 16:30 hrs., previa coordinación para piezas grandes.',0);

	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',10);
	$pdf->SetX(15);
	$pdf->Cell(30,5,$nItem.'.2.- Condiciones de Pago:',0,0,'L');

	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetX(20);
	$pdf->MultiCell(160,5,'• Tipo de moneda, en pesos, según valor de la UF correspondiente al día de emisión de la Orden de Compra o Factura.',0);

	$pdf->Ln(2);
	$pdf->SetFont('Arial','',10);
	$pdf->SetX(20);
	$pdf->MultiCell(160,5,'• La forma de pago será contra factura:',0);

	$pdf->Ln(2);
	$pdf->SetFont('Arial','',10);
	$pdf->SetX(25);
	$pdf->MultiCell(160,5,"• Pago en efectivo o cheque en Avenida Libertador Bernardo O'Higgins 1611, Santiago.",0);

	$pdf->Ln(2);
	$pdf->SetFont('Arial','',10);
	$pdf->SetX(25);
	$pdf->MultiCell(160,5,"• Pago mediante depósito o transferencia a nombre de SDT USACH, Banco BCI cuenta corriente 10358391 Rut: 78172420-3. Enviar confirmación a simet@usach.cl.",0);

	$pdf->Ln(2);
	$pdf->SetFont('Arial','',10);
	$pdf->SetX(25);
	$pdf->MultiCell(160,5,"• Clientes nuevos, sólo pago anticipado.",0);

	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',10);
	$pdf->SetX(15);
	$pdf->Cell(30,5,$nItem.'.3.- Observaciones Generales:',0,0,'L');

	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetX(20);
	$pdf->MultiCell(160,5,'• Después de 10 días de corridos de la emisión de este informe se entenderá como aceptado en su versión final, cualquier modificación posterior tendrá un recargo adicional de 1UF + IVA.',0);

	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetX(20);
	$pdf->MultiCell(160,5,'• Se solicita indicar claramente la identificación de la muestra al momento de la recepción, para no rehacer informes. Cada informe rehecho por razones ajenas a SIMET-USACH tiene un costo de 1,00 UF + IVA.',0);

	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetX(20);
	$pdf->MultiCell(160,5,'• Visitas a terreno en Santiago, explicativas de informes de análisis de falla o de retiro de muestras en terreno, tienen un costo adicional de 6,0 UF + IVA, visitas fuera de la región metropolitana consultar.',0);

	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetX(20);
	$pdf->MultiCell(160,5,'• En caso de realizar análisis de falla, el laboratorio se reserva el derecho de modificar el tipo y/o cantidad de ensayos.',0);


	$pdf->AddPage();
	$ln = 30;
	$pdf->SetXY(10,$ln);

	$pdf->SetFont('Arial','B',10);
	$pdf->SetXY(10, $ln);
	$pdf->Cell(30,5,'FAVOR EMITIR ORDEN DE COMPRA A NOMBRE DE:',0,0,'L');

	$ln += 5;
	$pdf->SetFont('Arial','',10);
	$pdf->SetXY(20, $ln);
	$pdf->Cell(60,5,'RAZÓN SOCIAL',0,0,'L');
	$pdf->SetXY(60, $ln);
	$pdf->Cell(100,5,': SOCIEDAD DE DESARROLLO TÉCNOLOGICO USACH',0,0,'L');

	$ln += 5;
	$pdf->SetFont('Arial','',10);
	$pdf->SetXY(20, $ln);
	$pdf->Cell(60,5,'GIRO',0,0,'L');
	$pdf->SetXY(60, $ln);
	$pdf->Cell(100,5,': Educación, Capacitación y Publicidad',0,0,'L');

	$ln += 5;
	$pdf->SetFont('Arial','',10);
	$pdf->SetXY(20, $ln);
	$pdf->Cell(60,5,'RUT',0,0,'L');
	$pdf->SetXY(60, $ln);
	$pdf->Cell(100,5,': 78172420-3',0,0,'L');

	$ln += 5;
	$pdf->SetFont('Arial','',10);
	$pdf->SetXY(20, $ln);
	$pdf->Cell(60,5,'DIRECCIÓN',0,0,'L');
	$pdf->SetXY(60, $ln);
	$pdf->Cell(100,5,": Avenida Libertador Bernardo O'Higgins 1611",0,0,'L');

	$ln += 5;
	$pdf->SetFont('Arial','',10);
	$pdf->SetXY(20, $ln);
	$pdf->Cell(60,5,'NOMBRE',0,0,'L');
	$pdf->SetXY(60, $ln);
	$pdf->Cell(100,5,": Emma Barceló Araos",0,0,'L');

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
	
	mysql_close($link);

$pdf->Output();
?>