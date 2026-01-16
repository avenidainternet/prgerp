<?php
include('../conexion.php');
require('../../fpdf/fpdf.php');

/* Variables Gets recividas */
$Proyecto	= $_GET['Proyecto'];
$Periodo	= $_GET['Periodo'];

/* Variables */
	$Mes = array(
					1 => 'Enero', 
					2 => 'Febrero',
					3 => 'Marzo',
					4 => 'Abril',
					5 => 'Mayo',
					6 => 'Junio',
					7 => 'Julio',
					8 => 'Agosto',
					9 => 'Septiembre',
					10 => 'Octubre',
					11 => 'Noviembre',
					12 => 'Diciembre'
				);

/*
		if($rowH['Estado']!="P"){
			$actSQL="UPDATE Honorarios SET ";
			$actSQL.="FechaPago		='".date('Y-m-d')."',";
			$actSQL.="Estado		='P'";
			$actSQL.="WHERE Run		='".$Run."' && nBoleta = '".$nBoleta."'";
			$bdH=mysql_query($actSQL);
		}
*/

	$link=Conectarse();
	$bdDep=mysql_query("SELECT * FROM Departamentos");
	if ($rowDep=mysql_fetch_array($bdDep)){
		$NomDirector = $rowDep['NomDirector'];
	}
	$bd=mysql_query("SELECT * FROM Proyectos Where IdProyecto = '".$Proyecto."'");
	if ($row=mysql_fetch_array($bd)){
		$NomProyecto 	= $row['Proyecto'];
		$JefeProyecto 	= $row['JefeProyecto'];
	}
	mysql_close($link);

	$pdf=new FPDF('P','mm','Letter');
	$pdf->AddPage();
	$pdf->Image('../../gastos/logos/sdt.png',10,10,33,25);
	$pdf->Image('../../gastos/logos/logousach.png',170,10,18,25);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(40);
	$pdf->Cell(100,10,'UNIVERSIDAD DE SANTIAGO DE CHILE',0,2,'C');
	$pdf->Cell(100,1,'SOCIEDAD DE DESARROLLO TECNOLÓGICO',0,2,'C');
	$pdf->Ln(20);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(50,10,'FORMULARIO N° 5',1,0,'C');
	//$pdf->Cell(50,10,'FORMULARIO '.$_POST['Formulario'],1,0,'C');
	$pdf->Cell(130,10,'SOLICITUD DE PAGO DE HONORARIOS',1,0,'L');

	$pdf->Ln(13);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(70,5,'FECHA:',0,0);
	//$pdf->Cell(2,5,':',0,0);
	$pdf->Cell(110,5,date('d').'/'.date('m').'/'.date('Y'),0,0);

	$pdf->Ln(5);
	$pdf->Cell(70,5,'DE:',0,0);
	//$pdf->Cell(2,5,':',0,0);
	$pdf->Cell(110,5,'SEÑOR '.$NomDirector.' (Jefe Centro de Costo)',0,0);

	$pdf->Ln(5);
	$pdf->Cell(70,5,'A:',0,0);
	//$pdf->Cell(2,5,':',0,0);
	$pdf->Cell(110,5,'DIRECTOR EJECUTIVO SOCIEDAD DE DESARROLLO TECNOLOGICO  (SDT)',0,0);

	$pdf->Ln(5);
	$pdf->Cell(70,10,'Solicito a Ud. efectuar el pago de honorarios, con cargo a:',0,0);

	$pdf->Ln(10);
	$pdf->Cell(70,10,'NOMBRE DEL PROYECTO:',0,0);
	$pdf->Cell(110,10,$NomProyecto,1,0);
	$pdf->Ln(12);
	$pdf->Cell(70,10,'CÓDIGO DEL PROYECTO:',0,0);
	$pdf->Cell(110,10,$Proyecto,1,0);

	$pdf->SetFont('Arial','B',7);
	$pdf->Ln(10);
	$pdf->Cell(196,10,'DETALLE DE HONORARIOS',0,0,'C');

	$pdf->SetFont('Arial','',7);
	$pdf->Ln(8);
	$pdf->Cell(55,5,'NOMBRE',1,0,'C');
	$pdf->Cell(55,5,'CORREO ELECTRÓNICO',1,0,'C');
	$pdf->Cell(25,5,'BANCO',1,0,'C');
	$pdf->Cell(25,5,'CTA.CTE.',1,0,'C');
	$pdf->Cell(16,5,'RUT',1,0,'C');
	$pdf->Cell(20,5,'VALOR BRUTO',1,0,'C');

$sTotal = 0;
$link=Conectarse();
$bdH=mysql_query("SELECT * FROM Honorarios WHERE IdProyecto = '".$Proyecto."' && PeriodoPago = '".$Periodo."' && Estado != 'P'");
if ($rowH=mysql_fetch_array($bdH)){
	DO{
		$Run	 		= $rowH['Run'];
		$nBoleta 		= $rowH['nBoleta'];
		$Descripcion 	= $rowH['Descripcion'];
		$PerIniServ 	= $rowH['PerIniServ'];
		$PerTerServ 	= $rowH['PerTerServ'];
		$Total 			= $rowH['Total'];
		$sTotal			+= $Total;

		$bdP=mysql_query("SELECT * FROM PersonalHonorarios WHERE Run = '".$Run."'");
		if ($rowP=mysql_fetch_array($bdP)){
			$Nombre 		= $rowP['Nombres'].' '.$rowP['Paterno'].' '.$rowP['Materno'];
			$Email 			= $rowP['Email'];
			$Banco 			= $rowP['Banco'];
			$nCuenta 		= $rowP['nCuenta'];
			$ServicioIntExt	= $rowP['ServicioIntExt'];
		}

		$pdf->SetFont('Arial','',6);
		$pdf->Ln(5);
		$pdf->Cell(55,5,$Nombre,1,0);
		$pdf->Cell(55,5,$Email,1,0);
		$pdf->Cell(25,5,$Banco,1,0);
		$pdf->Cell(25,5,$nCuenta,1,0,'C');
		$pdf->Cell(16,5,$Run,1,0,'C');
		$pdf->Cell(20,5,'$ '.number_format($Total, 0, ',', '.'),1,0,'R');
		

	}WHILE ($rowH=mysql_fetch_array($bdH));
}
mysql_close($link);

		$pdf->Ln(5);
		$pdf->Cell(55,5,'',0,0);
		$pdf->Cell(55,5,'',0,0);
		$pdf->Cell(25,5,'',0,0);
		$pdf->Cell(25,5,'',0,0);
		$pdf->Cell(16,5,'TOTAL',0,0,'R');
		$pdf->Cell(20,5,'$ '.number_format($sTotal, 0, ',', '.'),1,0,'R');

		$pdf->SetFont('Arial','B',10);
		// Line(Col, FilaDesde, ColHasta, FilaHasta) 
		$pdf->Line(20, 228, 90, 228);
		$pdf->SetXY(20,233);
		//Cell(LargoMarco ,AltoMarco, Txt, VerMarco, ,Centro)
		$pdf->Cell(70,5,$JefeProyecto,0,0,"C");
		$pdf->SetXY(20,238);
		$pdf->Cell(70,5,"Jefe de Proyecto",0,0,"C");

		$pdf->Line(120, 228, 190, 228);
		$pdf->SetXY(120,233);
		$pdf->Cell(70,5,$NomDirector,0,0,"C");
		$pdf->SetXY(120,238);
		$pdf->Cell(70,5,"Director de Departamento o Jefe Centro Costo",0,0,"C");

/* Imprime Contrato */
	$NombreFormulario = "Solicitudes.pdf";
	//$pdf->Output($NombreFormulario,'I'); //Para Imprimir Pantalla
	$pdf->Output($NombreFormulario,'D'); //Para Descarga
	//$pdf->Output($NombreFormulario,'F');

?>
