<?php
include('../../conexionli.php');
require('../../fpdf/fpdf.php');

/* Variables Gets recividas */
$Run 		= $_GET['Run'];
$nBoleta 	= $_GET['nBoleta'];
$Periodo 	= $_GET['Periodo'];
$NomDirector  = '';


/* Variables */
	$Mes = array(
					1 => 'Enero		', 
					2 => 'Febrero	',
					3 => 'Marzo		',
					4 => 'Abril		',
					5 => 'Mayo		',
					6 => 'Junio		',
					7 => 'Julio		',
					8 => 'Agosto	',
					9 => 'Septiembre',
					10 => 'Octubre	',
					11 => 'Noviembre',
					12 => 'Diciembre'
				);


$link=Conectarse();
//$bdH=$link->query("SELECT * FROM Honorarios WHERE Run = '".$Run."' && nBoleta = '".$nBoleta."'");
$bdH=$link->query("SELECT * FROM Honorarios WHERE Run = '".$Run."' and PeriodoPago = '".$Periodo."' and nBoleta = '".$nBoleta."'");
if ($rowH=mysqli_fetch_array($bdH)){
	$PeriodoPago	= $rowH['PeriodoPago'];
	$Proyecto 		= $rowH['IdProyecto'];
	$Descripcion 	= $rowH['Descripcion'];
	$actRealizada 	= $rowH['actRealizada'];
	$fechaContrato 	= $rowH['fechaContrato'];
	$PerIniServ 	= $rowH['PerIniServ'];
	$PerTerServ 	= $rowH['PerTerServ'];
	$fechaInforme 	= $rowH['fechaInforme'];
	$Total 			= $rowH['Total'];
	
	$mPago 			= explode('.',$PeriodoPago);
	
/*
	if($rowH['Estado']!="P"){
		$actSQL="UPDATE Honorarios SET ";
		$actSQL.="FechaPago		='".date('Y-m-d')."',";
		$actSQL.="Estado		='P'";
		$actSQL.="WHERE Run		='".$Run."' && nBoleta = '".$nBoleta."'";
		$bdH=$link->query($actSQL);
	}
*/

}
$bdH=$link->query("SELECT * FROM PersonalHonorarios WHERE Run = '".$Run."'");
if ($rowH=mysqli_fetch_array($bdH)){
	$Nombre 		= $rowH['Nombres'].' '.$rowH['Paterno'].' '.$rowH['Materno'];
	$Profesion 		= $rowH['ProfesionOficio'];
	$Direccion 		= $rowH['Direccion'];
	$Comuna 		= $rowH['Comuna'];
	$firmaPrestador = $rowH['firma'];
	$ServicioIntExt	= $rowH['ServicioIntExt'];
}
$bd=$link->query("SELECT * FROM Proyectos Where IdProyecto = '".$Proyecto."'");
if ($row=mysqli_fetch_array($bd)){
	$JefeProyecto 	= $row['JefeProyecto'];
	$firmaJefe 		= $row['firmaJefe'];
	$nomProyecto 	= $row['Proyecto'];
	$Rut_JefeProyecto 	= $row['Rut_JefeProyecto'];
}
		$bdDep=$link->query("SELECT * FROM Departamentos");
		if($rowDep=mysqli_fetch_array($bdDep)){
			$bdDi=$link->query("SELECT * FROM Director Where RutDirector = '".$rowDep['RutDirector']."'");
			if($rowDi=mysqli_fetch_array($bdDi)){
				if($fechaInforme >= $rowDi['fechaInicio']){
					$NomDirector = $rowDep['NomDirector'];
					$Cargo		 = $rowDep['Cargo'];
					$RutDirector = $rowDep['RutDirector'];
				}else{
					$bdDi=$link->query("SELECT * FROM Director Where fechaTermino > '0000-00-00'");
					if($rowDi=mysqli_fetch_array($bdDi)){
						do{
							if($fechaInforme >= $rowDi['fechaInicio'] and $fechaInforme <= $rowDi['fechaTermino']){
								$NomDirector = $rowDi['NomDirector'];
								$Cargo		 = $rowDi['Cargo'];
								$RutDirector = $rowDep['RutDirector'];
							}	
						}while($rowDi=mysqli_fetch_array($bdDi));
					}	
				}	
			}	
		}
/*
$bdDep=$link->query("SELECT * FROM Departamentos");
if ($rowDep=mysqli_fetch_array($bdDep)){
	$NomDirector = $rowDep['NomDirector'];
}
*/
$link->close();
	$cLeft 	= 70;
	$cRigth	= 58;
	$mLeft	= 10;

/* Encabezado Contrato */
	$pdf=new FPDF('P','mm','Legal');
	$pdf->AddPage();

	$pdf->Image('../../logossdt/formulariosolicitudes2022.png',10,10);

	// $pdf->Image('../../gastos/logos/sdt.png',$mLeft,10);

	$ln = 30;
	$pdf->SetFont('Arial','B',12);
	$pdf->SetXY(10,$ln);
	$pdf->Cell(180,7,'INFORME DE ACTIVIDADES',0,1,'C');
/* Fin Encabezado Contrato */

/* Cuerpo Informe */
	
	$pdf->SetFont('Arial','',8);
	$ln += 15;
	$pdf->SetXY($mLeft,$ln);
	$pdf->MultiCell($cLeft,10,'',1,'L');
	$pdf->SetXY($mLeft+2,$ln);
	$pdf->MultiCell($cLeft-2,5, utf8_decode('FECHA DE EMISIÓN DEL INFORME'),0,'L');
	$fd 	= explode('-', $fechaInforme);
	$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
	$pdf->SetXY(($cLeft+$mLeft),$ln);
	$pdf->MultiCell(128,10,$Fecha,1,'L');
	
	$ln += 10;
	$pdf->SetXY($mLeft,$ln);
	$pdf->MultiCell($cLeft,10,'',1,'L');
	$pdf->SetXY($mLeft+2,$ln);
	$pdf->MultiCell($cLeft-2,10,utf8_decode('CÓDIGO DEL PROYECTO'),0,'L');
	$pdf->SetXY(($cLeft+$mLeft),$ln);
	$pdf->MultiCell(128,10,$Proyecto,1,'L');

	$ln += 10;
	$pdf->SetXY($mLeft,$ln);
	$pdf->MultiCell($cLeft,10,'',1,'L');
	$pdf->SetXY($mLeft+2,$ln);
	$pdf->MultiCell($cLeft-2,5,'NOMBRE DEL PRESTADOR DE SERVICIOS',0,'L');
	$pdf->SetXY(($cLeft+$mLeft),$ln);
	$pdf->MultiCell(128,10,utf8_decode($Nombre),1,'L');

	$ln += 10;
	$pdf->SetXY($mLeft,$ln);
	$pdf->MultiCell($cLeft,10,'',1,'L');
	$pdf->SetXY($mLeft+2,$ln);
	$pdf->MultiCell($cLeft-2,5,utf8_decode('FECHA DE SUSCRIPCIÓN DEL CONTRATO'),0,'L');
	$fd 	= explode('-', $fechaContrato);
	$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
	$pdf->SetXY(($cLeft+$mLeft),$ln);
	$pdf->MultiCell(128,10,$Fecha,1,'L');

	$lm = 140;
	$ln += 10;
	$pdf->SetXY($mLeft,$ln);
	$pdf->MultiCell($cLeft,$lm,'',1,'L');
	$pdf->SetXY($mLeft+2,$ln);
	$pdf->MultiCell($cLeft-2,5,'DESCRIBA LAS ACTIVIDADES REALIZADAS',0,'L');
	$pdf->SetXY(($cLeft+$mLeft),$ln);
	$pdf->MultiCell(128,$lm,'',1,'L');
	$pdf->SetFont('Arial','',10);
	$pdf->SetXY(($cLeft+$mLeft)+2,$ln);
	$pdf->MultiCell(125,5,utf8_decode($actRealizada),0,'J');

	if($firmaPrestador){
		$pdf->Image('../../ft/'.$firmaPrestador,100,195,40,40);
	}

	$ln += $lm;
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY($mLeft,$ln);
	$pdf->MultiCell($cLeft,10,'',1,'L');
	$pdf->SetXY($mLeft+2,$ln);
	$pdf->MultiCell($cLeft-2,5,'FIRMA DEL PRESTADOR',0,'L');
	$pdf->SetXY(($cLeft+$mLeft),$ln);
	$pdf->MultiCell(128,10,'',1,'L');

	$ln += 10;
	$pdf->SetXY($mLeft,$ln);
	$pdf->MultiCell($cLeft,10,'',1,'L');
	$pdf->SetXY($mLeft+2,$ln);
	$pdf->MultiCell($cLeft-2,5,'JEFE DE PROYECTO',0,'L');
	$pdf->SetXY(($cLeft+$mLeft),$ln);
	$pdf->MultiCell(128,10,'',1,'L');
	$pdf->SetXY(($cLeft+$mLeft),$ln);
	
	if($Run == $Rut_JefeProyecto){
		$pdf->MultiCell(128,10, utf8_decode($NomDirector),1,'L');
		// $firmaJefe = '';
	}else{
		$pdf->MultiCell(128,10, utf8_decode($JefeProyecto),1,'L');
	}

	if($firmaJefe){
		//$firmaJefe = 'aaa.png';
		$pdf->Image('../../ft/'.$firmaJefe,100,235,40,40);
	}

	//$firmaJefe = 'aaa.png';
	// $pdf->Image('../../ft/'.$firmaJefe,100,235,40,40);

	$ln += 10;
	$pdf->SetXY($mLeft,$ln);
	$pdf->MultiCell($cLeft,10,'',1,'L');
	$pdf->SetXY($mLeft+2,$ln);
	$pdf->MultiCell($cLeft-2,5,utf8_decode('FIRMA DE ACEPTACIÓN DE LOS SERVICIOS'),0,'L');
	$pdf->SetXY(($cLeft+$mLeft),$ln);
	$pdf->MultiCell(128,10,'                      ',1,'L');



	// Pie
	$pdf->SetFillColor(234, 80, 55);
	$pdf->SetTextColor(255, 255, 255);

	$fila = 310;
	$pdf->SetXY(10,$fila);
	$pdf->SetDrawColor(234, 80, 55);
	$pdf->MultiCell(185,25,'',1,'L', true);

	$fila += 2;
	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(240,240,240);
	$pdf->SetXY(120,$fila);
	$pdf->Cell(70,5,"Alameda Libertador",0,0,"L");

	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(162,$fila);
	$pdf->Cell(70,5, utf8_decode("Trece Oriente Nº2211"),0,0,"L");

	$fila += 5;
	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(240,240,240);
	$pdf->SetXY(120,$fila);
	$pdf->Cell(70,5, utf8_decode("Bernardo O'higgins 1611"),0,0,"L");

	$pdf->SetXY(162,$fila);
	$pdf->Cell(70,5, utf8_decode("Piso 1, Iquique"),0,0,"L");

	$fila += 5;
	$pdf->SetTextColor(240,240,240);
	$pdf->SetXY(120,$fila);
	$pdf->Cell(70,5, utf8_decode("Santiago"),0,0,"L");

	$pdf->SetXY(162,$fila);
	$pdf->Cell(70,5, utf8_decode("+57 22 488 84(85)"),0,0,"L");

	$fila += 5;
	$pdf->SetTextColor(240,240,240);
	$pdf->SetXY(120,$fila);
	$pdf->Cell(70,5, utf8_decode("+562 2718 1400"),0,0,"L");

	$pdf->SetXY(162,$fila);
	$pdf->Cell(70,5, utf8_decode("+569 4409 2070"),0,0,"L");

	$pdf->SetDrawColor(255, 255, 255);
	$pdf->Line(160, 312, 160, 333);


	$pdf->SetTextColor(0, 0, 0);



	$fd 	= explode('-', date('Y-m-d'));
	$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
	
	$Fecha = $fd[2].' de '.$Mes[intval($mPago[0])].' de '.$fd[0];
	//$Fecha = $fd[2].' de '.$Mes[intval($fd[1])].' de '.$fd[0];

/* Pie de Contrato */


/* Imprime Contrato */
	//$pdf->Output('Contrato.pdf','I'); //Para Descarga
	$agnoActual = date('Y');
	$vDir = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/HONORARIOS/';;

	$NombreFormulario = "InformeAct".$Run."_".$nBoleta.".pdf";
	$pdf->Output($NombreFormulario,'D'); //Para Descarga
	$pdf->Output($vDir.$NombreFormulario,'F'); //Para Descarga
?>
