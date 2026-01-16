<?php
	require_once('../../fpdf/fpdf.php');
	include_once("../conexion.php");

	$idVisita	= $_GET['idVisita'];
	$accion 	= $_GET['accion'];

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
	$bdEq=mysql_query("SELECT * FROM Visitas WHERE idVisita = '".$idVisita."'");
	if($rowEq=mysql_fetch_array($bdEq)){
		
		$pdf=new FPDF('L','mm','Letter');

		// Encabezado 
		$pdf->AddPage();
		$pdf->SetXY(10,5);
		$pdf->Image('../../imagenes/logoSimetCam.png',10,5,43,16);

		$pdf->SetFont('Arial','B',10);
		$pdf->SetTextColor(0, 0, 0);
		//$pdf->SetTextColor(192, 192, 192);
		$pdf->SetXY(50,12);
		$pdf->Cell(120,5,'REGISTRO DE VISITAS',0,0,'C');

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

		$bdCli=mysql_query("SELECT * FROM Clientes WHERE RutCli = '".$rowEq['RutCli']."'");
		if($rowCli=mysql_fetch_array($bdCli)){
			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(10,$ln);
			$pdf->Cell(30,4,'CLIENTE',0,0,'L');

			$pdf->SetFont('Arial','B',10);
			$pdf->SetXY(40,$ln);
			$pdf->Cell(144,4,': '.$rowCli['Cliente'],0,0,'L');

			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(150,$ln);
			$pdf->Cell(10,4,'FECHA',0,0,'L');
			
			$pdf->SetFont('Arial','B',10);
			$fd = explode('-', $rowEq['fechaRegAct']); 

			$pdf->SetXY(164,$ln);
			$pdf->Cell(15,4,': '.$fd[2].'/'.$fd[1].'/'.$fd[0],0,0,'L');

			$ln += 5;
			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(10,$ln);
			$pdf->Cell(30,4,'Responsable',0,0,'L');

			$bdUs=mysql_query("SELECT * FROM Usuarios WHERE usr = '".$rowEq['usrResponsable']."'");
			if($rowUs=mysql_fetch_array($bdUs)){
				$pdf->SetFont('Arial','B',10);
				$pdf->SetXY(40,$ln);
				$pdf->Cell(150,4,': '.$rowUs['usuario'],0,0,'L');
			}
			
			$ln += 5;
			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(10,$ln);
			$pdf->Cell(30,4,'Objetivo',0,0,'L');

			$pdf->SetFont('Arial','B',10);
			$pdf->SetXY(40,$ln);
			$pdf->MultiCell(150,4,': '.$rowEq['Actividad'],0,'L');

			// Line(Col, FilaDesde, ColHasta, FilaHasta) 
			$ln += 5;
			$pdf->Line(10, $ln, 184, $ln);

		}

		/* Fin Encabezado Columna */

		/* Cuerpo Informe */
		$ln += 5;
		$pdf->SetFillColor(0, 0, 0);
		$pdf->SetFont('Arial','',10);
		$pdf->SetXY(10,$ln);
		$pdf->Cell(30,4,'Conclusión:',0,0,'L');
		
		$ln += 10;
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(175,5,$rowEq['Conclusion'],0,'J');

		$Impresa = 'on';
		$actSQL="UPDATE Visitas SET ";
		$actSQL.="Impresa			='".$Impresa.	"'";
		$actSQL.="Where idVisita	= '".$idVisita."'";
		$bdRv=mysql_query($actSQL);

	}
	mysql_close($link);
	
	//$pdf->Output('F3B-00001.pdf','I'); //Para Descarga
	$NombreFormulario = "RegistroVisita-".$idVisita.".pdf";
	$pdf->Output($NombreFormulario,'D'); //Para Descarga
	//$pdf->Output('F3B-00001.pdf','F');

?>
