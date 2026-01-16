<?php
	require('../../fpdf/fpdf.php');
	include_once("../../conexionli.php");
	$ln = 100;
	$nCuenta 	= $_GET['nCuenta'];
	$MesFiltro 	= intval($_GET['MesFiltro']);
	$Agno 		= $_GET['Agno'];
	$fCta 		= explode('|',$nCuenta);
	$nCuenta 	= $fCta[0];
	
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
	$fechaHoy = date('Y-m-d');
	$link=Conectarse();

	$pdf=new FPDF('P','mm','A4');
	$pdf->AddPage();
		

	$pdf->Image('../../imagenes/simet.png',10,10,30,20);
	$pdf->Image('../../gastos/logos/logousach.png',170,10,15,23);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(40);

	$pdf->Cell(100,10,'UNIVERSIDAD DE SANTIAGO DE CHILE',0,2,'C');
	$pdf->Cell(100,1,'LABORATORIO SIMET-USACH',0,2,'C');

	$pdf->SetXY(10,30);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(200,5,'REEMBOLSOS A LA CUENTA '.$nCuenta,0,0,'C');
	
	$pdf->SetXY(10,35);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(200,5,'MES: '.$Mes[intval($MesFiltro)-1],0,0,'C');
	
	$fd 	= explode('-', $fechaHoy);
	$pdf->SetXY(10,40);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(70,5,'FECHA: Santiago, '.$fd[2].' de '.$Mes[$fd[1]-1].' de '.$fd[0],0,0);

	$bdCli=$link->query("SELECT * FROM ctasctescargo Where nCuenta = '".$nCuenta."'");
	if($rowCli=mysqli_fetch_array($bdCli)){
		$pdf->SetXY(10,45);
		$pdf->Cell(40,5,'Titular: ',0,0);
		$pdf->Cell(115,5,strtoupper($rowCli['nombreTitular']),0,0);

		$pdf->SetXY(10,50);
		$pdf->Cell(40,5,'Banco:',0,0);
		$pdf->Cell(115,5,$rowCli['Banco'],0,0);
		$idRecurso = $rowCli['aliasRecurso'];
	}		

	$filtroSQL = "Where nCuenta = $nCuenta and year(fechaTransaccion) = '".$Agno."' and month(fechaTransaccion) = '".$MesFiltro."'";

	$pdf->SetFont('Arial','B',7);
	$pdf->SetXY(10,70);
	$pdf->Cell(15,5,'Fecha',1,0,'C');
	$pdf->Cell(14,5,'Transaccion',1,0,'C');
	$pdf->Cell(14,5,'Informe',1,0,'C');
	$pdf->Cell(70,5,'Descripción',1,0,'C');
	$pdf->Cell(15,5,'Abonos',1,0,'C');
	$pdf->Cell(15,5,'Cargos',1,0,'C');
	$ln = 70;
	$pdf->SetFont('Arial','',7);

	$tMesAbonos = 0;
	$tMesCargos = 0;
	$fReembolso = '0000-00-00';
	$link=Conectarse();
	$SQL = "SELECT * FROM librobanco $filtroSQL Order By fechaTransaccion Desc";
	$bdHon=$link->query($SQL);
	if ($row=mysqli_fetch_array($bdHon)){
		do{
				$ln += 5;
				$pdf->SetXY(10,$ln);
				$fd 	= explode('-', $row['fechaTransaccion']);
				$pdf->Cell(15,5,$fd[2].'-'.$fd[1].'-'.$fd[0],1,0,'C');
				$pdf->Cell(14,5,$row['nTransaccion'],1,0,'R');
				$pdf->Cell(14,5,$row['nInforme'],1,0,'C');
				$pdf->SetFont('Arial','',6);
				$pdf->Cell(70,5,$row['Descripcion'],1,0,'L');
				$pdf->SetFont('Arial','',7);
				$pdf->Cell(15,5,number_format($row['Abonos'], 0, ',', '.'),1,0,'C');
				$tMesAbonos += $row['Abonos'];
				$pdf->Cell(15,5,number_format($row['Cargos'], 0, ',', '.'),1,0,'C');
				$tMesCargos += $row['Cargos'];
				//$tBruto += $row['Bruto'];
		}while ($row=mysqli_fetch_array($bdHon));
		$ln += 5;
		$pdf->SetFont('Arial','B',8);
		$pdf->SetXY(10,$ln);
		$pdf->Cell(125,5,number_format($tMesAbonos, 0, ',', '.'),0,0,'R');
		$pdf->Cell(15,5,number_format($tMesCargos, 0, ',', '.'),0,0,'R');
	}

	$link->close();

	$NombreFormulario = "Cartola-".$nCuenta.'-'.$MesFiltro.'-'.$Agno.".pdf";
	$pdf->Output($NombreFormulario,'D'); //Para Descarga
?>
