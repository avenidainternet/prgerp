<?php
include('../conexion.php');
require('../../fpdf/fpdf.php');

$tBruto 	= 0;
$Iva		= 0;
$Concepto	= '';

if(isset($_GET['RutProv'])) 	{ $RutProv 	= $_GET['RutProv'];		}
if(isset($_GET['nFactura'])) 	{ $nFactura = $_GET['nFactura'];	}
if(isset($_GET['Periodo'])) 	{ $Periodo 	= $_GET['Periodo'];		}
$nInforme 	= "";

$link=Conectarse();
$bdFact=mysql_query("SELECT * FROM Facturas Where RutProv = '".$RutProv."' && nFactura = '".$nFactura."'");
if ($rowFact=mysql_fetch_array($bdFact)){
	$IdProyecto 	= $rowFact['IdProyecto'];
	$Descripcion	= $rowFact['Descripcion'];
	$nInforme		= $rowFact['nInforme'];
}
$nInf = 0;

$sql = "SELECT * FROM Formularios Where Formulario = 'F7(Factura)' Order By nInforme Desc";  // sentencia sql
$bdFact=mysql_query($sql);
if($rowFact=mysql_fetch_array($bdFact)){
	$nInf = $rowFact['nInforme'] +1;
}

$Fecha 	= date('Y-m-d');
$fd 	= explode('-', $Fecha);
$Fec 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
$Fec 	= $fd[2].'/'.$fd[1].'/'.$fd[0];
$f 		= "F7(Factura)";

if($nInforme > 0){
	$nInf = $nInforme;
	$bdFact=mysql_query("SELECT * FROM Formularios Where nInforme = '".$nInforme."' && Formulario = '".$f."'");
	if($rowFact=mysql_fetch_array($bdFact)){
		$Fecha 		= $rowFact['Fecha'];
		$fd 		= explode('-', $Fecha);
		$Fec		= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
		$Fec 		= $fd[2].'/'.$fd[1].'/'.$fd[0];
		$nInforme 	=  $rowFact['nInforme'];
	}
}

$bdDep=mysql_query("SELECT * FROM Departamentos");
if ($rowDep=mysql_fetch_array($bdDep)){
	$NomDirector = $rowDep['NomDirector'];
}
mysql_close($link);

	$pdf=new FPDF('P','mm','A4');
	$pdf->AddPage();
	$pdf->Image('../../gastos/logos/sdt.png',10,10,33,25);
	$pdf->Image('../../gastos/logos/logousach.png',170,10,18,25);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(40);
	$pdf->Cell(300,10,$nInf,0,2,'C');
	$pdf->Cell(100,10,'UNIVERSIDAD DE SANTIAGO DE CHILE',0,2,'C');
	$pdf->Cell(100,1,'SOCIEDAD DE DESARROLLO TECNOLÓGICO',0,2,'C');
	$pdf->Ln(20);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(50,10,'FORMULARIO F7',1,0,'C');
	//$pdf->Cell(50,10,'FORMULARIO '.$_POST['Formulario'],1,0,'C');
	$pdf->Cell(130,10,'SOLICITUD DE PAGO DE FACTURAS',1,0,'L');

	$pdf->Ln(13);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(70,5,'FECHA:',0,0);
	//$pdf->Cell(2,5,':',0,0);
	$pdf->Cell(110,5,$Fec,0,0);

	$pdf->Ln(5);
	$pdf->Cell(70,5,'DE:',0,0);
	//$pdf->Cell(2,5,':',0,0);
	$pdf->Cell(110,5,'SEÑOR '.$NomDirector.' (Jefe Centro de Costo)',0,0);

	$pdf->Ln(5);
	$pdf->Cell(70,5,'A:',0,0);
	//$pdf->Cell(2,5,':',0,0);
	$pdf->Cell(110,5,'DIRECTOR EJECUTIVO SOCIEDAD DE DESARROLLO TECNOLOGICO  (SDT)',0,0);

	$link=Conectarse();
	$bdPr=mysql_query("SELECT * FROM Proyectos Where IdProyecto = '".$IdProyecto."'");
	if($row=mysql_fetch_array($bdPr)){
		$JefeProyecto = $row['JefeProyecto'];
		$pdf->Ln(5);
		$pdf->Cell(70,10,'NOMBRE DEL PROYECTO:',0,0);
		//$pdf->Cell(2,5,':',0,0);
		$pdf->Cell(110,10,$row['Proyecto'],1,0);
		$pdf->Ln(12);
		$pdf->Cell(70,10,'CÓDIGO DEL PROYECTO:',0,0);
		//$pdf->Cell(2,5,':',0,0);
		$pdf->Cell(110,10,$IdProyecto,1,0);

		$pdf->Ln(12);
		$pdf->Cell(70,10,'CONCEPTO O MOTIVO DE LOS GASTOS REALIZADOS:',0,0);
		//$pdf->Cell(2,5,':',0,0);
		$pdf->Cell(110,10,$Descripcion,1,0);

	}
	mysql_close($link);


	$pdf->SetFont('Arial','',7);

	$pdf->Ln(10);
	$pdf->Cell(180,5,'DETALLE DE FACTURAS',0,0,"C");

	$pdf->SetFont('Arial','B',6);
	$pdf->Ln(5);
	$pdf->Cell(55,17,'PROVEEDOR',1,0,'C');
	$pdf->Cell(45,17,'CORREO ELECTRÓNICO',1,0,'C');
	$pdf->Cell(20,17,'BANCO',1,0,'C');
	$pdf->Cell(20,17,'CTA. CTE.',1,0,'C');
	$pdf->Cell(20,17,'RUT',1,0,'C');
	$pdf->Cell(20,17,'VALOR TOTAL',1,0,'C');

	$filtroSQL = "Where IdProyecto ='".$IdProyecto."' && RutProv = '".$RutProv."' && nFactura = '".$nFactura."'"; 

	$pdf->SetFont('Arial','',6);
	$tBrupo = 0;
	$pdf->Ln(12);
	$link=Conectarse();
	$bdGto=mysql_query("SELECT * FROM Facturas ".$filtroSQL." Order By RutProv");
	if ($row=mysql_fetch_array($bdGto)){
		DO{
			// Inicio Linea de Detalle
			$bdProv=mysql_query("SELECT * FROM Proveedores Where RutProv = '".$RutProv."'");
			if ($rowProv=mysql_fetch_array($bdProv)){
				$pdf->Cell(55,5,$rowProv['Proveedor'],1,0);
				$pdf->Cell(45,5,$rowProv['Email'],1,0,'L');
				$pdf->Cell(20,5,$rowProv['Banco'],1,0,'L');
				$pdf->Cell(20,5,$rowProv['NumCta'],1,0,'C');
				$pdf->Cell(20,5,$rowProv['RutProv'],1,0,'C');
			}
			$pdf->Cell(20,5,number_format($row['Bruto'], 0, ',', '.'),1,0,'R');
			$tBruto += $row['Bruto'];
			$pdf->Ln(5);
			// Termino Linea de Detalle
		}WHILE ($row=mysql_fetch_array($bdGto));
	}

	$FechaPago    = date('Y-m-d');

	$actSQL="UPDATE Facturas SET ";
	$actSQL.="FechaPago  	='".$FechaPago."',";
	$actSQL.="nInforme  	='".$nInf."'";
	$actSQL.="WHERE RutProv	='".$RutProv."' && nFactura = '".$nFactura."'";
	$bdH=mysql_query($actSQL);

	$f = "F7(Factura)";
	$bdFact=mysql_query("SELECT * FROM Formularios Where nInforme = '".$nInf."' && Formulario = '".$f."'");
	if ($rowFact=mysql_fetch_array($bdFact)){
	}else{
		mysql_query("insert into Formularios (	nInforme,
											Formulario,
											Impuesto,
											Fecha,
											Concepto,
											IdProyecto,
											Bruto) 
							values 		 (	'$nInf',
											'$f',
											'$Iva',
											'$Fecha',
											'$Concepto',
											'$IdProyecto',
											'$tBruto')",$link);

	}
	mysql_close($link);

	// Linea Total
	$pdf->Cell(55,5,'',0,0,'C');
	$pdf->Cell(45,5,'',0,0,'C');
	$pdf->Cell(20,5,'',0,0,'C');
	$pdf->Cell(20,5,'',0,0,'C');
	$pdf->Cell(20,5,'TOTAL',0,0,'R');
	$pdf->Cell(20,5,"$ ".number_format($tBruto, 0, ',', '.'),1,0,'R');

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
	$pdf->Cell(70,5,$NomDirector,0,0,"C");
	$pdf->SetXY(120,263);
	$pdf->Cell(70,5,"Director de Departamento",0,0,"C");

	//$pdf->Output('F7-00001.pdf','I');
	$NombreFormulario = "F7Exenta-".$nInf.".pdf";
	$pdf->Output($NombreFormulario,'D'); //Para Descarga
	//$pdf->Output('F7-00001.pdf','D');
	//$pdf->Output('F7-00001.pdf','F');

?>
