<?php
if(!isset($_POST['Reg'])){
	header("Location: CalculoHonorarios.php");
}else{
include('../conexionli.php');
require('../fpdf/fpdf.php');
/* Variables */
	if(isset($_POST['Proyecto'])) { $Proyecto = $_POST['Proyecto']; }
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

	$pdf=new FPDF('P','mm','Letter');

/********************** Imprime Solicitudes     *****************************/

	$link=Conectarse();
	$bdDep=$link->query("SELECT * FROM Departamentos");
	if ($rowDep=mysqli_fetch_array($bdDep)){
		$NomDirector = $rowDep['NomDirector'];
	}
	$bd=$link->query("SELECT * FROM Proyectos Where IdProyecto = '".$Proyecto."'");
	if ($row=mysqli_fetch_array($bd)){
		$NomProyecto 		= $row['Proyecto'];
		$JefeProyecto 		= $row['JefeProyecto'];
		$Rut_JefeProyecto 	= $row['Rut_JefeProyecto'];
	}
	$link->close();

	$pdf->AddPage();
	$pdf->Image('../gastos/logos/sdt.png',10,10,33,25);
	$pdf->Image('../gastos/logos/logousach.png',170,10,18,25);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(40);
	$pdf->Cell(100,10,'UNIVERSIDAD DE SANTIAGO DE CHILE',0,2,'C');
	$pdf->Cell(100,1,utf8_decode('SOCIEDAD DE DESARROLLO TECNOLÓGICO'),0,2,'C');
	$pdf->Ln(20);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(50,10,utf8_decode('FORMULARIO Nº 5'),1,0,'C');
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
	$pdf->Cell(110,5,utf8_decode('SEÑOR '). utf8_decode($NomDirector).' (Jefe Centro de Costo)',0,0);

	$pdf->Ln(5);
	$pdf->Cell(70,5,'A:',0,0);
	//$pdf->Cell(2,5,':',0,0);
	$pdf->Cell(110,5,utf8_decode('DIRECTOR EJECUTIVO SOCIEDAD DE DESARROLLO TECNOLÓGICO  (SDT)'),0,0);

	$pdf->Ln(5);
	$pdf->Cell(70,10,'Solicito a Ud. efectuar el pago de honorarios, con cargo a:',0,0);

	$pdf->Ln(10);
	$pdf->Cell(70,10,'NOMBRE DEL PROYECTO:',0,0);
	$pdf->Cell(110,10,$NomProyecto,1,0);
	$pdf->Ln(12);
	$pdf->Cell(70,10,utf8_decode('CÓDIGO DEL PROYECTO:'),0,0);
	$pdf->Cell(110,10,$Proyecto,1,0);

	$pdf->SetFont('Arial','B',7);
	$pdf->Ln(10);
	$pdf->Cell(196,10,'DETALLE DE HONORARIOS',0,0,'C');

	$pdf->SetFont('Arial','',7);
	$pdf->Ln(8);
	$pdf->Cell(40,5,'NOMBRE',1,0,'C');
	$pdf->Cell(40,5,utf8_decode('CORREO ELECTRÓNICO'),1,0,'C');
	$pdf->Cell(22,5,'BANCO',1,0,'C');
	$pdf->Cell(20,5,'CTA.CTE.',1,0,'C');
	$pdf->Cell(13,5,'RUT',1,0,'C');
	$pdf->Cell(16,5,utf8_decode('ACADÉMICA'),1,0,'C');
	$pdf->Cell(12,5,'BOLETA',1,0,'C');
	$pdf->Cell(20,5,'VALOR BRUTO',1,0,'C');

	$sTotal = 0;
	foreach ($_POST['Reg'] as $valor) {
		//list($Run, $nBoleta, $Proyecto, $Periodo) = split('[,]', $valor);
		list($Run, $nBoleta, $Proyecto, $Periodo) = explode(',', $valor);
		
			//$bdH=$link->query("SELECT * FROM Honorarios WHERE IdProyecto = '".$Proyecto."' && PeriodoPago = '".$Periodo."' && Estado != 'P'");
			$link=Conectarse();
			$bdH=$link->query("SELECT * FROM Honorarios WHERE IdProyecto = '".$Proyecto."' && PeriodoPago = '".$Periodo."' && Run = '".$Run."' && nBoleta = '".$nBoleta."'");
			if ($rowH=mysqli_fetch_array($bdH)){
					$Run	 		= $rowH['Run'];
					$nBoleta 		= $rowH['nBoleta'];
					$Descripcion 	= $rowH['Descripcion'];
					$PerIniServ 	= $rowH['PerIniServ'];
					$PerTerServ 	= $rowH['PerTerServ'];
					$Total 			= $rowH['Total'];
					$sTotal			+= $Total;

					$bdP=$link->query("SELECT * FROM PersonalHonorarios WHERE Run = '".$Run."'");
					if ($rowP=mysqli_fetch_array($bdP)){
						$Nombre 		= $rowP['Nombres'].' '.$rowP['Paterno'].' '.$rowP['Materno'];
						$Email 			= $rowP['Email'];
						$Banco 			= $rowP['Banco'];
						$nCuenta 		= $rowP['nCuenta'];
						$ServicioIntExt	= $rowP['ServicioIntExt'];
					}

					$pdf->SetFont('Arial','',6);
					$pdf->Ln(5);
					$pdf->Cell(40,5, utf8_decode($Nombre),1,0);
					$pdf->Cell(40,5,$Email,1,0);
					$pdf->Cell(22,5,$Banco,1,0);
					$pdf->Cell(20,5,$nCuenta,1,0,'C');
					$pdf->Cell(13,5,$Run,1,0,'C');
					$pdf->Cell(16,5,'NO',1,0,'C');
					$pdf->Cell(12,5,$nBoleta,1,0,'C');
					$pdf->Cell(20,5,'$ '.number_format($Total, 0, ',', '.'),1,0,'R');

			}
			$link->close();
	}
	$pdf->Ln(5);
	$pdf->Cell(40,5,'',0,0);
	$pdf->Cell(40,5,'',0,0);
	$pdf->Cell(22,5,'',0,0);
	$pdf->Cell(20,5,'',0,0);
	$pdf->Cell(13,5,'',0,0);
	$pdf->Cell(16,5,'',0,0);
	$pdf->Cell(12,5,'TOTAL',0,0,'R');
	$pdf->Cell(20,5,'$ '.number_format($sTotal, 0, ',', '.'),1,0,'R');

	$ln = $pdf->GetY()+10;
	$pdf->SetXY(10,$ln);
	$pdf->SetFont('Arial','',10);
	$LinTxt  = "NOTA: La dirección de SDT USACH es Av. Libertador Bernardo O'Higgins Nº1611, ";
	$LinTxt  .= "sin embargo, para dar inicio a la tramitación de este Formulario, lo debe ";
	$LinTxt  .= "entregar en la dirección Av. Libertador Bernardo O'Higgins Nº2229, Oficina ";
	$LinTxt  .= "de Ingreso de Requerimientos";
	$pdf->MultiCell(185,5,utf8_decode($LinTxt),0,'J');

	$firmaJefe = 'aaa.png';
	$pdf->Image('../ft/'.$firmaJefe,30,190,40,40);
	$pdf->SetXY(20,220);
	if($Rut_JefeProyecto != '11845057-4'){
		$pdf->Cell(20,5,'pp',0,0,"C");
	}
	

	$pdf->SetFont('Arial','B',10);
	// Line(Col, FilaDesde, ColHasta, FilaHasta) 
	$pdf->Line(20, 228, 90, 228);
	$pdf->SetXY(20,233);

	//Cell(LargoMarco ,AltoMarco, Txt, VerMarco, ,Centro)
	$pdf->Cell(70,5, utf8_decode($JefeProyecto),0,0,"C");
	$pdf->SetXY(20,238);
	$pdf->Cell(70,5,"Jefe de Proyecto",0,0,"C");

	$pdf->Line(120, 228, 190, 228);
	$pdf->SetXY(120,233);
	$pdf->Cell(70,5, utf8_decode($NomDirector),0,0,"C");
	$pdf->SetXY(120,238);
	$pdf->Cell(70,5,"Director de Departamento o Jefe Centro Costo",0,0,"C");

	/********************** Fin Imprime Solicitudes *****************************/

	/********************** 	Imprime Prestadores *****************************/

	$link=Conectarse();
	$bdDep=$link->query("SELECT * FROM Departamentos");
	if ($rowDep=mysqli_fetch_array($bdDep)){
		$NomDirector 			= $rowDep['NomDirector'];
		$SubDirectorProyectos 	= $rowDep['SubDirectorProyectos'];
	}
	$bd=$link->query("SELECT * FROM Proyectos Where IdProyecto = '".$Proyecto."'");
	if ($row=mysqli_fetch_array($bd)){
		$NomProyecto 		= $row['Proyecto'];
		$JefeProyecto 		= $row['JefeProyecto'];
		$Rut_JefeProyecto 	= $row['Rut_JefeProyecto'];
	}
	$link->close();

	$sTotal 		= 0;
	$RunControl 	= "";
	$ImprimeLinea 	= "No";
	$nBoletas		= 0;
	$tTotal			= 0;
	$tRetencion		= 0;
	$tLiquido		= 0;
	$nDoc			= 0;
	
	foreach ($_POST['Reg'] as $valor) {
		list($Run, $nBoleta, $Proyecto, $Periodo) = explode(',', $valor);
		$nDoc++;
		$link=Conectarse();
		$bdH=$link->query("SELECT * FROM Honorarios WHERE Run = '".$Run."' && nBoleta = '".$nBoleta."' && IdProyecto = '".$Proyecto."'");
		if ($rowH=mysqli_fetch_array($bdH)){
			$Total 			= $rowH['Total'];
			$sTotal			+= $Total;
			$tTotal			+= $rowH['Total'];
			$tRetencion		+= $rowH['Retencion'];
			$tLiquido		+= $rowH['Liquido'];
		}
		$link->close();
	}

	$link=Conectarse();
	$sql = "SELECT * FROM Formularios Where Formulario = 'F5'";  
	$result = $link->query($sql);
	$nInf = mysqli_num_rows($result); // obtenemos el n�mero de filas
	$nInf = $nInf +1;
	$link->close();

	$nDoc = 0;
	$link=Conectarse();
	foreach ($_POST['Reg'] as $valor) {
		list($Run, $nBoleta, $Proyecto, $Periodo) = explode(',', $valor);
		$nDoc++;

		$actSQL="UPDATE Honorarios SET ";
		$actSQL.="FechaPago		='".date('Y-m-d')."',";
		$actSQL.="Estado		='P',";
		$actSQL.="nInforme		='".$nInf."'";
		$actSQL.="WHERE Run		='".$Run."' && nBoleta = '".$nBoleta."'";
		$bdH=$link->query($actSQL);
	}
	$link->close();
	$f 			= "F5";
	$fecha 		= date('Y-m-d');
	
	$fd 	= explode('-', date('Y-m-d'));
	$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
	
	$Concepto 	= 'Solicitud de Pagos de Honorarios '.$Fecha;

	$link=Conectarse();
	$link->query("insert into Formularios (	nInforme,
											Formulario,
											nDocumentos,
											Fecha,
											Concepto,
											IdProyecto,
											Total,
											Retencion,
											Liquido) 
							values 		 (	'$nInf',
											'$f',
											'$nDoc',
											'$fecha',
											'$Concepto',
											'$Proyecto',
											'$tTotal',
											'$tRetencion',
											'$tLiquido'
											)");

	$link->close();

	$NombreFormulario = "Formularios.pdf";
	$pdf->Output($NombreFormulario,'D'); //Para Descarga
}
?>
