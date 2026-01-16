<?php
require('../fpdf/fpdf.php');

	$pdf=new FPDF('P','mm','A4');
	$pdf->AddPage();
	$pdf->Image('logos/sdt.png',10,10,33,25);
	$pdf->Image('logos/logousach.png',170,10,18,25);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(40);
	$pdf->Cell(100,10,'UNIVERSIDAD DE SANTIAGO DE CHILE',0,2,'C');
	$pdf->Cell(100,1,'SOCIEDAD DE DESARROLLO TECNOLÓGICO',0,2,'C');
	$pdf->Ln(20);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(50,10,'FORMULARIO '.substr($_POST['Formulario'],1,2),1,0,'C');
	//$pdf->Cell(50,10,'FORMULARIO '.$_POST['Formulario'],1,0,'C');
	$pdf->Cell(130,10,'SOLICITUD DE REEMBOLSO',1,0,'L');
	$pdf->Ln(13);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(70,5,'FECHA:',0,0);
	//$pdf->Cell(2,5,':',0,0);
	$pdf->Cell(110,5,date('d').'/'.date('m').'/'.date('Y'),0,0);

	$pdf->Ln(5);
	$pdf->Cell(70,5,'DE:',0,0);
	//$pdf->Cell(2,5,':',0,0);
	$pdf->Cell(110,5,'SEÑOR CRISTIAN VARGAS RIQUELME (Jefe Centro de Costo)',0,0);

	$pdf->Ln(5);
	$pdf->Cell(70,5,'A:',0,0);
	//$pdf->Cell(2,5,':',0,0);
	$pdf->Cell(110,5,'DIRECTOR EJECUTIVO SOCIEDAD DE DESARROLLO TECNOLOGICO  (SDT)',0,0);

	$pdf->Ln(5);
	$pdf->Cell(70,10,'NOMBRE DEL PROYECTO:',0,0);
	//$pdf->Cell(2,5,':',0,0);

	$link=Conectarse();
	$bdPr=mysql_query("SELECT * FROM Proyectos Where IdProyecto = '".$_POST['IdProyecto']."'");
	if($row=mysql_fetch_array($bdPr)){
		$pdf->Cell(110,10,$row['Proyecto'],1,0);
		$pdf->Ln(12);
		$pdf->Cell(70,10,'CÓDIGO DEL PROYECTO:',0,0);
		//$pdf->Cell(2,5,':',0,0);
		$pdf->Cell(110,10,$_POST['IdProyecto'],1,0);

		$pdf->Ln(12);
		$pdf->Cell(70,10,'SE SOLICITA REEMBOLSO A NOMBRE DE:',0,0);
		//$pdf->Cell(2,5,':',0,0);

		// F3B(Itau) - IGT-1118 - Sin Iva -  Itau    Ok
		// F3B(Itau) - IGT-1118 - Con Iva -
		// F3B(Itau) - IGT-19   - Sin Iva -  Itau    Ok
		// F3B(Itau) - IGT-19   - Con Iva -
		if($Formulario=="F3B1"){
			$pdf->Cell(110,10,$row['JefeProyecto'].", Cta.Cte. N° ".$row['Cta_Corriente'].", Banco ".$row['Banco'],1,0);
			$JefeProyecto = $row['JefeProyecto'];
		}

		// F3B(AAA) - IGT-1118 - Sin Iva - Edwards     	Ok
		// F3B(AAA) - IGT-1118 - Con Iva -
		// F3B(AAA) - IGT-19   - Sin Iva - 				Ok
		// F3B(AAA) - IGT-19   - Con Iva -
		if($Formulario=="F3B2"){
			if($_POST['IdProyecto']=="IGT-1118"){
				$pdf->Cell(110,10,$row['JefeProyecto'].", Cta.Cte. N° ".$row['Cta_Corriente2'].", Banco ".$row['Banco2'],1,0);
				$JefeProyecto = $row['JefeProyecto'];
			}else{
				$pdf->Cell(110,10,$row['JefeProyecto'].", Cta.Cte. N° ".$row['Cta_Corriente'].", Banco ".$row['Banco'],1,0);
				$JefeProyecto = $row['JefeProyecto'];
			}
		}
		$pdf->Ln(12);
		$pdf->Cell(70,10,'RUT:',0,0);
		//$pdf->Cell(2,5,':',0,0);
		$pdf->Cell(110,10,$row['Rut_JefeProyecto'],1,0);

		$pdf->Ln(12);
		$pdf->Cell(70,10,'CONCEPTO O MOTIVO  DE LOS GASTOS REALIZADOS:',0,0);
		//$pdf->Cell(2,5,':',0,0);
		$pdf->Cell(110,10,$Concepto,1,0);

		$pdf->Ln(12);
		$pdf->Cell(70,10,'CORREO ELECTRÓNICO:',0,0);
		//$pdf->Cell(2,5,':',0,0);
		$pdf->Cell(110,10,$row['Email'],1,0);

	}

	mysql_close($link);

	$pdf->SetFont('Arial','',7);

	$pdf->Ln(10);
	$pdf->Cell(70,5,'La relación de gastos es la siguiente::',0,0);
	//$pdf->Cell(2,5,':',0,0);

	$pdf->SetFont('Arial','B',7);
	$pdf->Ln(5);
	if($Iva=="sIva"){
		$pdf->Cell(55,17,'Proveedor',1,0,'C');
		$pdf->Cell(18,17,'N° Factura',1,0,'C');
		$pdf->Cell(17,17,'Fecha',1,0,'C');
		$pdf->Cell(70,17,'Bien o Servicio Adquirido',1,0,'C');
		$pdf->Cell(20,17,'Monto',1,0,'C');
		$pdf->Ln(2);
		$pdf->Cell(55,18,'',0,0,'C');
		$pdf->Cell(18,18,'o Boleta',0,0,'C');
		$pdf->Cell(17,18,'Factura o',0,0,'C');
		$pdf->Ln(2);
		$pdf->Cell(55,20,'',0,0,'C');
		$pdf->Cell(18,20,'',0,0,'C');
		$pdf->Cell(17,20,'o Boleta',0,0,'C');
	}
	if($Iva=="cIva"){
		$pdf->Cell(50,17,'Proveedor',1,0,'C');
		$pdf->Cell(16,17,'N° Factura',1,0,'C');
		$pdf->Cell(17,17,'Fecha',1,0,'C');
		$pdf->Cell(60,17,'Bien o Servicio Adquirido',1,0,'C');
		$pdf->Cell(15,17,'Neto',1,0,'C');
		$pdf->Cell(15,17,'IVA',1,0,'C');
		$pdf->Cell(15,17,'Bruto',1,0,'C');
		$pdf->Ln(2);
		$pdf->Cell(50,18,'',0,0,'C');
		$pdf->Cell(16,18,'o Boleta',0,0,'C');
		$pdf->Cell(17,18,'Factura o',0,0,'C');
		$pdf->Ln(2);
		$pdf->Cell(50,20,'',0,0,'C');
		$pdf->Cell(16,20,'',0,0,'C');
		$pdf->Cell(17,20,'o Boleta',0,0,'C');
	}
	if($Formulario=="F3B1"){
		if($Iva=="sIva"){
			$filtroSQL = "Where IdProyecto ='".$_POST['IdProyecto']."' && IdRecurso <= 3 && Iva = 0 && Neto = 0 && Estado != 'I'"; 
		}
		if($Iva=="cIva"){
			$filtroSQL = "Where IdProyecto ='".$_POST['IdProyecto']."' && IdRecurso <= 3 && Iva > 0 && Neto > 0 && Estado != 'I'"; 
		}
	}
	if($Formulario=="F3B2"){
		if($Iva=="sIva"){
			$filtroSQL = "Where IdProyecto ='".$_POST['IdProyecto']."' && IdRecurso = 4 && Iva = 0 && Neto = 0 && Estado != 'I'"; 
		}
		if($Iva=="cIva"){
			$filtroSQL = "Where IdProyecto ='".$_POST['IdProyecto']."' && IdRecurso = 4 && Iva > 0 && Neto > 0 && Estado != 'I'"; 
		}
	}
	$pdf->SetFont('Arial','',6);

	$tBrupo = 0;
	$pdf->Ln(13);
	$link=Conectarse();
	$bdGto=mysql_query("SELECT * FROM MovGastos ".$filtroSQL." Order By FechaGasto Desc");
	if ($row=mysql_fetch_array($bdGto)){
		DO{
			// Inicio Linea de Detalle
			if($Iva=="sIva"){
				$pdf->Cell(55,5,$row['Proveedor'],1,0);
				$pdf->Cell(18,5,$row['nDoc'],1,0,'R');
				$pdf->Cell(17,5,$row['FechaGasto'],1,0,'C');
				$pdf->Cell(70,5,$row['Bien_Servicio'],1,0);
				$pdf->Cell(20,5,number_format($row['Bruto'], 0, ',', '.'),1,0,'R');
				$tBruto += $row['Bruto'];
				$pdf->Ln(5);
			}else{
				$pdf->Cell(50,5,$row['Proveedor'],1,0);
				$pdf->Cell(16,5,$row['nDoc'],1,0,'R');
				$pdf->Cell(17,5,$row['FechaGasto'],1,0,'C');
				$pdf->Cell(60,5,$row['Bien_Servicio'],1,0);
				$pdf->Cell(15,5,number_format($row['Neto'], 0, ',', '.'),1,0,'R');
				$pdf->Cell(15,5,number_format($row['Iva'], 0, ',', '.'),1,0,'R');
				$pdf->Cell(15,5,number_format($row['Bruto'], 0, ',', '.'),1,0,'R');
				$tNeto 	+= $row['Neto'];
				$tIva 	+= $row['Iva'];
				$tBruto += $row['Bruto'];
				$pdf->Ln(5);
			}
			//$nLn = $nLn + 1;
			// Termino Linea de Detalle
		}WHILE ($row=mysql_fetch_array($bdGto));
	}
	
	$FechaInforme = date('Y-m-d');
	$actSQL="UPDATE MovGastos SET ";
	$actSQL.="Estado	    ='I',";
	$actSQL.="FechaInforme  ='".$FechaInforme."',";
	$actSQL.="nInforme  	='".$nInf."'";
	$actSQL.=$filtroSQL;
	$bdGto=mysql_query($actSQL);
	$f = "F3B";
	$IdProyecto = $_POST['IdProyecto'];
	if($_POST['Formulario'] == "F3B1"){
		$f = "F3B(Itau)";
	}
	if($_POST['Formulario'] == "F3B2"){
		$f = "F3B(AAA)";
	}
	mysql_query("insert into Formularios (	nInforme,
											Formulario,
											Impuesto,
											Fecha,
											Concepto,
											IdProyecto,
											Neto,
											Iva,
											Bruto) 
							values 		 (	'$nInf',
											'$f',
											'$Iva',
											'$FechaInforme',
											'$Concepto',
											'$IdProyecto',
											'$tNeto',
											'$tIva',
											'$tBruto')",$link);

	mysql_close($link);

	// Linea Total
	if($Iva=="sIva"){
		$pdf->Cell(55,5,'',0,0,'C');
		$pdf->Cell(18,5,'',0,0,'C');
		$pdf->Cell(17,5,'',0,0,'C');
		$pdf->Cell(70,5,'TOTAL',0,0,'R');
		$pdf->Cell(20,5,"$ ".number_format($tBruto, 0, ',', '.'),1,0,'R');
	}else{
		$pdf->Cell(50,5,'',0,0,'C');
		$pdf->Cell(16,5,'',0,0,'C');
		$pdf->Cell(17,5,'',0,0,'C');
		$pdf->Cell(60,5,'TOTAL',0,0,'R');
		$pdf->Cell(15,5,"$ ".number_format($tNeto, 0, ',', '.'),1,0,'R');
		$pdf->Cell(15,5,"$ ".number_format($tIva, 0, ',', '.'),1,0,'R');
		$pdf->Cell(15,5,"$ ".number_format($tBruto, 0, ',', '.'),1,0,'R');
	}

	$pdf->SetXY(10,230);
	$Nota = "Nota: Especifique claramente el motivo que generó los gastos detallados, evitando la devolución de este formulario a su Unidad de origen";
	$pdf->Cell(180,5,$Nota,0,0,"L");

	// Line(Col, FilaDesde, ColHasta, FilaHasta) 
	$pdf->Line(20, 258, 90, 258);
	$pdf->SetXY(20,259);
	//Cell(LargoMarco ,AltoMarco, Txt, VerMarco, ,Centro)
	$pdf->Cell(70,5,$JefeProyecto,0,0,"C");
	$pdf->SetXY(20,263);
	$pdf->Cell(70,5,"Jefe de Proyecto",0,0,"C");

	$pdf->Line(120, 258, 190, 258);
	$pdf->SetXY(120,259);
	$pdf->Cell(70,5,"CRISTIAN VARGAS RIQUELME",0,0,"C");
	$pdf->SetXY(120,263);
	$pdf->Cell(70,5,"Director de Departamento",0,0,"C");

	//$pdf->Output('F3B-00001.pdf','I'); //Para Descarga
	$NombreFormulario = "F4-".$nInf.".pdf";
	$pdf->Output($NombreFormulario,'D'); //Para Descarga
	//$pdf->Output('F3B-00001.pdf','F');

header("Location: plataformaintranet.php");

?>
