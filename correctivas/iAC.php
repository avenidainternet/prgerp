<?php
	require_once('../fpdf/fpdf.php');
	//include_once("conexion.php");
	include_once("../conexionli.php");


	if(isset($_GET['nInformeCorrectiva'])) 	{ $nInformeCorrectiva 	= $_GET['nInformeCorrectiva']; 	}
	if(isset($_GET['accion'])) 				{ $accion 				= $_GET['accion'];				}
		
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
	
	$largoMaxA 	= 45;
	$largoMaxB 	= 45;

	$link=Conectarse();
	$bdCAM=$link->query("SELECT * FROM accionesCorrectivas WHERE nInformeCorrectiva = '".$nInformeCorrectiva."'");
	if($rowCAM=mysqli_fetch_array($bdCAM)){

		$pdf=new FPDF('P','mm','Letter');

		// Encabezado 
		$pdf->AddPage();
		$pdf->SetXY(10,5);
		$pdf->Image('../imagenes/logonewsimet.jpg',10,5,43,16);

		$pdf->SetXY(10,3);
		$pdf->SetDrawColor(200, 200, 200);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(180,20,'',1,0,'L');
		$pdf->SetDrawColor(0, 0, 0);

		$pdf->SetFont('Arial','B',14);
		$pdf->SetXY(50,10);
		$pdf->Cell(110,5,'ACCIONES CORRECTIVAS',0,0,'R');
		
		$pdf->SetXY(50,17);
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(10,5,'',0,0);

		$pdf->SetXY(10,17);
		$pdf->Image('../gastos/logos/logousach.png',195,5,15,23);

		
		$pdf->SetDrawColor(200, 200, 200);
		$pdf->Line(190, 30, 190, 270);
		$pdf->SetDrawColor(0, 0, 0);
		$pdf->Image('../imagenes/logonewsimet.jpg',185,245,20,8);
		// Fin Encabezado

		$pdf->SetFont('Arial','B',10);
		$fd 	= explode('-', $rowCAM['fechaApertura']);
		$pdf->SetXY(12,25);
		$pdf->Cell(5,5, utf8_decode('Nº AC : ').$nInformeCorrectiva,0,0);

		$pdf->SetXY(130,25);
		$pdf->Cell(50,5,'Fecha : '.$fd[2].' / '.$Mes[$fd[1]-1].' / '.$fd[0],0,0);

		$pdf->SetXY(10,30);
		$pdf->SetFillColor(102, 153, 204);
		$pdf->Cell(90,10,'1. Fuente',1,0,'L',true);		
		$pdf->Cell(90,10,'2. Origen',1,0,'L',true);
		$pdf->SetFillColor(0, 0, 0);

		$pdf->SetXY(10,40);
		$pdf->Cell(90,32,'',1,0,'L');
		$pdf->Cell(90,32,'',1,0,'L');

		// *****************************
		// Primer Bloque  
		// *****************************

		// Primera Linea
		
		$pdf->SetXY(12,41);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(4,4,'',1,0,'L');
		if($rowCAM['fteRecCliExt']=='on'){
			$pdf->SetXY(12,41);
			$pdf->Cell(4,4,'X',0,0,'C');
		}
		//$pdf->Image('../imagenes/visto_bueno.png',13,41.5,3,3);
		$txt = 'Reclamo de Cliente Externo ';
		if($rowCAM['fteRecCliExt']=='on'){
			$txt .= '(Nº Reclamo '.$rowCAM['fteNroRecCliExt'].')';
		}else{
			$txt .= '(Nº Reclamo ';
			$largoStr 	= strlen($txt);
			$nCarRep	= $largoMaxA - $largoStr;
			$txt .= str_repeat('_',$nCarRep);
			$txt .= ')';
		}
		$pdf->Cell(50,5,utf8_decode($txt),0,0,'L');

		$pdf->SetXY(102,41);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(4,4,'',1,0,'L');
		if($rowCAM['oriSisGes']=='on'){
			$pdf->SetXY(102,41);
			$pdf->Cell(4,4,'X',0,0,'C');
		}
		$txt = 'Sistema de Gestión ';
		if($rowCAM['oriSisGes']=='on'){
			$fd 	= explode('-', $rowCAM['oriSisGesFecha']);
			$txt .= '(Fecha '.$fd[2].'/'.$fd[1].'/'.$fd[0].')';
		}else{
			$txt .= '(Fecha';
			$largoStr 	= strlen($txt);
			$nCarRep	= $largoMaxB - $largoStr;
			$txt .= str_repeat('_',$nCarRep);
			$txt .= ')';
		}
		$pdf->Cell(50,5,utf8_decode($txt),0,0,'L');

		// 2da Linea
		
		$pdf->SetXY(12,46);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(4,4,'',1,0,'L');
		if($rowCAM['fteRecCliInt']=='on'){
			$pdf->SetXY(12,46);
			$pdf->Cell(4,4,'X',0,0,'C');
		}
		//$pdf->Image('../imagenes/visto_bueno.png',13,41.5,3,3);
		$txt = 'Reclamo de Cliente Interno ';
		if($rowCAM['fteRecCliInt']=='on'){
			$txt .= '(Nº Reclamo '.$rowCAM['fteNroRecCliInt'].')';
		}else{
			$txt .= '(Nº Reclamo';
			$largoStr 	= strlen($txt);
			$nCarRep	= $largoMaxA - $largoStr;
			$txt .= str_repeat('_',$nCarRep);
			$txt .= ')';
		}
		$pdf->Cell(50,5,utf8_decode($txt),0,0,'L');

		$pdf->SetXY(102,46);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(4,4,'',1,0,'L');
		if($rowCAM['oriEnsayos']=='on'){
			$pdf->SetXY(102,46);
			$pdf->Cell(4,4,'X',0,0,'C');
		}
		$txt = 'Ensayos ';
		if($rowCAM['oriEnsayos']=='on'){
			$txt .= '(Nº Asociado '.$rowCAM['oriNroAso'].')';
		}else{
			$txt .= '(Nº Asociado';
			$largoStr 	= strlen($txt);
			$nCarRep	= $largoMaxB - $largoStr;
			$txt .= str_repeat('_',$nCarRep);
			$txt .= ')';
		}
		
		$pdf->Cell(50,5,utf8_decode($txt),0,0,'L');

		// 3ra Linea
		
		$pdf->SetXY(12,51);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(4,4,'',1,0,'L');
		if($rowCAM['fteAut']=='on'){
			$pdf->SetXY(12,51);
			$pdf->Cell(4,4,'X',0,0,'C');
		}
		//$pdf->Image('../imagenes/visto_bueno.png',13,41.5,3,3);
		$txt = 'Autodetectada  ';
		if($rowCAM['fteAut']=='on'){
			$fd 	= explode('-', $rowCAM['fteAutFecha']);
			$txt .= '(Fecha '.$fd[2].'/'.$fd[1].'/'.$fd[0].')';
		}else{
			$txt .= '(Fecha';
			$largoStr 	= strlen($txt);
			$nCarRep	= $largoMaxA - $largoStr;
			$txt .= str_repeat('_',$nCarRep);
			$txt .= ')';
		}
		$pdf->Cell(50,5,$txt,0,0,'L');

		$pdf->SetXY(102,51);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(4,4,'',1,0,'L');
		if($rowCAM['oriLeyReg']=='on'){
			$pdf->SetXY(102,51);
			$pdf->Cell(4,4,'X',0,0,'C');
		}
		$txt = 'Leyes / Reglamentos ';
		if($rowCAM['oriLeyReg']=='on'){
			$fd 	= explode('-', $rowCAM['oriLeyRegFecha']);
			$txt .= '(Fecha '.$fd[2].'/'.$fd[1].'/'.$fd[0].')';
		}else{
			$txt .= '(Fecha';
			$largoStr 	= strlen($txt);
			$nCarRep	= $largoMaxB - $largoStr;
			$txt .= str_repeat('_',$nCarRep);
			$txt .= ')';
		}
		$pdf->Cell(50,5,$txt,0,0,'L');

		// 4ta Linea
		
		$pdf->SetXY(12,56);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(4,4,'',1,0,'L'); // +++
		if($rowCAM['fteAudInt']=='on'){
			$pdf->SetXY(12,56);
			$pdf->Cell(4,4,'X',0,0,'C');
		}
		$txt = 'Auditoría Interna ';
		if($rowCAM['fteAudInt']=='on'){
			$fd 	= explode('-', $rowCAM['fteAudIntFecha']);
			$txt .= '(Fecha '.$fd[2].'/'.$fd[1].'/'.$fd[0].')';
		}else{
			$txt .= '(Fecha';
			$largoStr 	= strlen($txt);
			$nCarRep	= $largoMaxA - $largoStr;
			$txt .= str_repeat('_',$nCarRep);
			$txt .= ')';
		}
		$pdf->Cell(50,5,utf8_decode($txt),0,0,'L');

		$pdf->SetXY(102,56);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(4,4,'',1,0,'L');
		if($rowCAM['oriTnc']=='on'){
			$pdf->SetXY(102,56);
			$pdf->Cell(4,4,'X',0,0,'C');
		}
		$txt = 'TNC, ';
		if($rowCAM['oriTnc']=='on'){
			$fd 	= explode('-', $rowCAM['oriTncFecha']);
			$txt .= '(Fecha '.$fd[2].'/'.$fd[1].'/'.$fd[0].')';
		}else{
			$txt .= '(Fecha';
			$largoStr 	= strlen($txt);
			$nCarRep	= $largoMaxB - $largoStr;
			$txt .= str_repeat('_',$nCarRep);
			$txt .= ')';
		}
		$pdf->Cell(50,5,$txt,0,0,'L');


		// 5ta Linea Faltante
		// 4ta Linea
		
		$pdf->SetXY(12,61);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(4,4,'',1,0,'L');
		if($rowCAM['fteAudExt']=='on'){
			$pdf->SetXY(12,61);
			$pdf->Cell(4,4,'X',0,0,'C');
		}
		$txt = 'Auditoría Externa ';
		if($rowCAM['fteAudExt']=='on'){
			$fd 	= explode('-', $rowCAM['fteAudExtFecha']);
			$txt .= '(Fecha '.$fd[2].'/'.$fd[1].'/'.$fd[0].')';
		}else{
			$txt .= '(Fecha';
			$largoStr 	= strlen($txt);
			$nCarRep	= $largoMaxA - $largoStr;
			$txt .= str_repeat('_',$nCarRep);
			$txt .= ')';
		}
		$pdf->Cell(50,5,utf8_decode($txt),0,0,'L');

		$pdf->SetXY(102,61);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(4,4,'',1,0,'L');
		if($rowCAM['oriTnc']=='on'){
			$pdf->SetXY(102,61);
			$pdf->Cell(4,4,'X',0,0,'C');
		}
		$txt = 'Interlaboratorios, ';
		if($rowCAM['oriInterLab']=='on'){
			$fd 	= explode('-', $rowCAM['oriInterLabFecha']);
			$txt .= '(Fecha '.$fd[2].'/'.$fd[1].'/'.$fd[0].')';
		}else{
			$txt .= '(Fecha';
			$largoStr 	= strlen($txt);
			$nCarRep	= $largoMaxB - $largoStr;
			$txt .= str_repeat('_',$nCarRep);
			$txt .= ')';
		}
		$pdf->Cell(50,5,$txt,0,0,'L');

/* +++ */
		$pdf->SetXY(12,66);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(4,4,'',1,0,'L');

		$txt = 'Apelación ';
		$txt .= $rowCAM['Apelacion'];
		if($rowCAM['fteApelacion'] == 'on'){
			$pdf->SetXY(12,66);
			$pdf->Cell(4,4,'X',0,0,'C');
		}
		$pdf->Cell(50,5,utf8_decode($txt),0,0,'L');

		$pdf->SetXY(102,66);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(4,4,'',1,0,'L');
		if($rowCAM['oriCertificacion']=='on'){
			$pdf->SetXY(102,66);
			$pdf->Cell(4,4,'X',0,0,'C');
		}
		$txt = 'Certificación ';
		$txt .= utf8_decode($rowCAM['Certificacion']);
		$pdf->Cell(50,5, utf8_decode($txt),0,0,'L');

		// 5ta Linea

		
		$pdf->SetXY(10,72);
		$pdf->Cell(180,23,'',1,0,'L');
		$pdf->SetXY(10,72);
		$txt = 'En caso de tener otra fuente u origen, indicar a continuación:  '. $rowCAM['fteOtrosTxt'];
		$pdf->Cell(50,10,utf8_decode($txt),0,0,'L');
		$pdf->SetXY(11,73);
		//$pdf->Cell(50,10,utf8_decode($txt),0,0,'L');
		//$pdf->MultiCell(50,10,utf8_decode($txt),0,'J');



		// *****************************
		// Fin Primer Bloque  
		// *****************************
		

		// *****************************
		// Segundo Bloque  
		// *****************************

		$pdf->SetXY(10,90);
		$pdf->Cell(180,110,'',1,0,'L');

		$pdf->SetXY(10,90);
		$pdf->SetFillColor(102, 153, 204);
		$pdf->Cell(180,10, utf8_decode('3. Descripción del Hallazgo'),1,0,'L',true);
		$pdf->SetFillColor(0, 0, 0);

		$ln = 100;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','B',9);
		$txt = '¿El hallazgo es similar a otros ya existentes o es potencialmente probable de ocurrir? ';
		$pdf->Cell(180,10,utf8_decode($txt),0,0,'L');

		$ln += 5;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','',9);
		$txt = '   SI            NO        , en caso de ser similar, indique la AC relacionada N° AC ';
		$pdf->Cell(180,10,utf8_decode($txt),0,0,'L');
		
		$pdf->SetXY(20,$ln+3);
		$pdf->Cell(4,4,'',1,0,'L');
		if($rowCAM['hallazgo']=='SI'){
			$pdf->SetXY(20,$ln+3);
			$pdf->Cell(4,4,'X',0,0,'C');
		}

		$pdf->SetXY(35,$ln+3);
		$pdf->Cell(4,4,'',1,0,'L');
		if($rowCAM['hallazgo']=='NO'){
			$pdf->SetXY(35,$ln+3);
			$pdf->Cell(4,4,'X',0,0,'C');
		}

		$pdf->SetXY(128,$ln+3);
		$pdf->Cell(30,4,'',1,0,'L');
		if($rowCAM['hallazgo']=='SI'){
			$pdf->SetXY(130,$ln+3);
			$pdf->Cell(4,4,$rowCAM['nCorrectiva'],0,0,'C');
		}



		// 1ra Linea
		if($nInformeCorrectiva <= 120){
			$pdf->SetXY(12,81);
			$pdf->SetFont('Arial','B',9);
			$txt = 'a) Clasificación ';
			$pdf->Cell(180,5,$txt,0,0,'L');

			$pdf->SetXY(12,86);
			$pdf->SetFont('Arial','',9);
			$pdf->SetXY(17,86);
			$pdf->Cell(4,4,'',1,0,'L');
			if($rowCAM['desClasNoConf']=='on'){
				$pdf->SetXY(17,86);
				$pdf->Cell(4,4,'X',0,0,'C');
			}
			$txt = 'No Conformidad; ';
			$pdf->Cell(40,5,$txt,0,0,'L');
			$pdf->Cell(4,4,'',1,0,'L');
			if($rowCAM['desClasObs']=='on'){
				$pdf->SetXY(61,86);
				$pdf->Cell(4,4,'X',0,0,'C');
			}
			$txt = 'Observación ';
			$pdf->Cell(40,5,$txt,0,0,'L');
			$ln = 91;
		}	
		$ln += 10;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','B',9);
		$txt = 'a)  Identificación del requerimiento normativo, legal o reglamentario afectado: ';
		$pdf->Cell(180,10,utf8_decode($txt),0,0,'L');

		$ln += 7;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','',9);
		$txt = $rowCAM['desIdentificacion'];
		$pdf->SetXY(17,$ln);
		$pdf->MultiCell(170,4,utf8_decode($txt),0,'J');

		$ln = $pdf->GetY()+1;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','B',9);
		$txt = 'b)  Hallazgo detectado: ';
		$pdf->Cell(180,5,$txt,0,0,'L');

		$ln = $pdf->GetY()+5;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','',9);
		$txt = $rowCAM['desHallazgo'];
		$pdf->SetXY(17,$ln);
		$pdf->MultiCell(170,4,utf8_decode($txt),0,'J');

		$ln = $pdf->GetY()+1;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','B',9);
		$txt = 'c)  Evidencia objetiva del hallazgo: ';
		$pdf->Cell(180,5,$txt,0,0,'L');

		$ln = $pdf->GetY()+5;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','',9);
		$txt = $rowCAM['desEvidencia'];
		$pdf->SetXY(17,$ln);
		$pdf->MultiCell(170,4,utf8_decode($txt),0,'J');


		// *****************************
		// Tercer Bloque  
		// *****************************

		$pdf->SetY(196);
		$ln = $pdf->GetY();
		$pdf->SetXY(10,$ln);
		$pdf->SetFillColor(102, 153, 204);
		$pdf->Cell(180,10,utf8_decode('4. Causa raíz del hallazgo: '),1,0,'L',true);
		
		$pdf->SetFillColor(0, 0, 0);

		$ln = $pdf->GetY()+12;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','',9);
		$txt = $rowCAM['Causa'];
		$pdf->SetXY(17,$ln);
		$pdf->MultiCell(170,4,utf8_decode($txt),0,'J');

		$pdf->SetXY(10,196);
		$pdf->Cell(180,50,'',1,0,'L');
		
		// Pie de P�gina
		$ln = 250;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','',9);
		$txt = 'Reg 0901 V.06';
		$pdf->SetXY(17,$ln);
		$pdf->Cell(170,4,$txt,0,0,'R');

		$ln = 255;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','',9);
		$txt = 'Pag. '.$pdf->PageNo().' de 2';
		$pdf->SetXY(17,$ln);
		$pdf->Cell(170,4,$txt,0,0,'R');
		
		//*******************
		// Salto de P�gina
		
		// Encabezado 
		$pdf->AddPage();
		$pdf->SetXY(10,5);
		$pdf->Image('../imagenes/logonewsimet.jpg',10,5,43,16);

		$pdf->SetXY(10,3);
		$pdf->SetDrawColor(200, 200, 200);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(180,20,'',1,0,'L');
		$pdf->SetDrawColor(0, 0, 0);

		$pdf->SetFont('Arial','B',14);
		$pdf->SetXY(50,10);
		$pdf->Cell(110,5,'ACCIONES CORRECTIVAS',0,0,'R');
		
		$pdf->SetXY(50,17);
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(10,5,'',0,0);

		$pdf->SetXY(10,17);
		$pdf->Image('../gastos/logos/logousach.png',195,5,15,23);

		
		$pdf->SetDrawColor(200, 200, 200);
		$pdf->Line(190, 30, 190, 270);
		$pdf->SetDrawColor(0, 0, 0);
		$pdf->Image('../imagenes/logonewsimet.jpg',185,245,20,8);
		// Fin Encabezado

		$ln = $pdf->GetY()+10;
		$pdf->SetXY(10,30);
		$pdf->SetFillColor(102, 153, 204);
		$pdf->Cell(180,10,'5. Acciones Correctivas: ',1,0,'L',true);
		$pdf->SetFillColor(0, 0, 0);

		$ln = $pdf->GetY()+12;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','B',9);
		$txt = 'Corrección: ';
		$pdf->Cell(180,5,utf8_decode($txt),0,0,'L');

		$ln = $pdf->GetY()+5;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','',9);
		$txt = $rowCAM['accCorrecion'];
		$pdf->SetXY(17,$ln);
		$pdf->MultiCell(170,4,utf8_decode($txt),0,'J');

		$ln = $pdf->GetY()+5;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','B',9);
		$txt = 'Acción Correctiva: ';
		$pdf->Cell(180,5,utf8_decode($txt),0,0,'L');

		$ln = $pdf->GetY()+5;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','',9);
		$txt = $rowCAM['accAccionCorrectiva'];
		$pdf->SetXY(17,$ln);
		$pdf->MultiCell(170,4,utf8_decode($txt),0,'J');

		$ln = 110;
		$pdf->SetXY(10,$ln);
		$txt = 'Fecha de implementación de la acción correctiva';
		$pdf->Cell(100,10,utf8_decode($txt),0,0,'L');
		$pdf->SetXY(100,$ln);
		$txt = ': ';
		$fd  = explode('-', $rowCAM['accFechaImp']);
		if($fd[0]>0){
			$txt .= $fd[2].'/'.$fd[1].'/'.$fd[0];
		}
		$pdf->Cell(100,10,$txt,0,0,'L');

		$ln = 115;
		$pdf->SetXY(10,$ln);
		$txt = 'Fecha tentativa de verificación  acción correctiva';
		$pdf->Cell(100,10,utf8_decode($txt),0,0,'L');
		$pdf->SetXY(100,$ln);
		$txt = ': ';
		$fd  = explode('-', $rowCAM['accFechaTen']);
		if($fd[0]>0){
			$txt .= $fd[2].'/'.$fd[1].'/'.$fd[0];
		}
		$pdf->Cell(100,10,$txt,0,0,'L');

		$ln = 120;
		$pdf->SetXY(10,$ln);
		$txt = 'Fecha de verificación de la acción correctiva';
		$pdf->Cell(100,10,utf8_decode($txt),0,0,'L');
		$pdf->SetXY(100,$ln);
		$txt = ': ';
		$fd  = explode('-', $rowCAM['accFechaApli']);
		if($fd[0]>0){
			$txt .= $fd[2].'/'.$fd[1].'/'.$fd[0];
		}
		$pdf->Cell(100,10,$txt,0,0,'L');


		$ln = 140;
		$pdf->SetXY(10,$ln);
		$pdf->SetFillColor(102, 153, 204);
		$pdf->Cell(180,10,utf8_decode('6.  Verificación de la implementación, efectividad y cierre de la AC '),1,0,'L',true);
		$pdf->SetFillColor(0, 0, 0);

		$ln = $pdf->GetY()+12;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','B',9);
		$txt = 'RESULTADO DE LA ACCIÓN CORRECTIVA: ';
		$pdf->Cell(180,5,utf8_decode($txt),0,0,'L');

		$ln = $pdf->GetY()+5;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','',9);
		$txt = $rowCAM['verResAccCorr'];
		$pdf->SetXY(17,$ln);
		$pdf->MultiCell(170,4,utf8_decode($txt),0,'J');

		$ln = 180;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','B',9);
		$txt = 'CIERRE ACCIÓN CORRECTIVA: ';
		$pdf->Cell(35,5,utf8_decode($txt),0,0,'L');

		$txt = 'SI ';
		$pdf->SetXY(150,$ln);
		$pdf->Cell(5,5,$txt,0,0,'L');
		$pdf->Cell(4,4,'',1,0,'L');
		if($rowCAM['verCierreAccion']=='on'){
			$pdf->SetXY(155,$ln);
			$pdf->Cell(4,4,'X',0,0,'C');
		}

		$txt = 'NO ';
		$pdf->SetXY(170,$ln);
		$pdf->Cell(7,5,$txt,0,0,'L');
		$pdf->Cell(4,4,'',1,0,'L');
		if($rowCAM['verCierreAccion']!='on'){
			$pdf->SetXY(177,$ln);
			$pdf->Cell(4,4,'X',0,0,'C');
		}

		/*  */ 
		$ln += 5;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','B',9);
		$txt = '¿ES NECESARIO ACTUALIZAR LOS RIESGOS Y OPORTUNIDADES? ';
		$pdf->Cell(35,5,utf8_decode($txt),0,0,'L');

		$txt = 'SI ';
		$pdf->SetXY(150,$ln);
		$pdf->Cell(5,5,$txt,0,0,'L');
		$pdf->Cell(4,4,'',1,0,'L');
		if($rowCAM['actRiesgos']=='SI'){
			$pdf->SetXY(155,$ln);
			$pdf->Cell(4,4,'X',0,0,'C');
		}

		$txt = 'NO ';
		$pdf->SetXY(170,$ln);
		$pdf->Cell(7,5,$txt,0,0,'L');
		$pdf->Cell(4,4,'',1,0,'L');
		if($rowCAM['actRiesgos']=='NO'){
			$pdf->SetXY(177,$ln);
			$pdf->Cell(4,4,'X',0,0,'C');
		}

		/*    */
		$ln = $pdf->GetY()+10;
		$pdf->SetXY(10,$ln);
		$pdf->Cell(90,50,'',1,0,'L');
		$pdf->Cell(90,50,'',1,0,'L');

		$pdf->SetXY(10,$ln+40);
		$txt = '';
		$firmaEnc = '';
		$firmaRes = '';
		$bdUsr=$link->query("SELECT * FROM Usuarios WHERE usr = '".$rowCAM['usrCalidad']."'");
		if($rowUsr=mysqli_fetch_array($bdUsr)){
			$txt = $rowUsr['usuario'];
			$firmaEnc = $rowUsr['firmaUsr'];
		}
		$pdf->Cell(90,5,utf8_decode($txt),0,0,'C');

		$txt = '';
		$bdUsr=$link->query("SELECT * FROM Usuarios WHERE usr = '".$rowCAM['usrResponsable']."'");
		if($rowUsr=mysqli_fetch_array($bdUsr)){
			$txt = $rowUsr['usuario'];
			$firmaRes = $rowUsr['firmaUsr'];
		}
		$pdf->Cell(90,5,utf8_decode($txt),0,0,'C');


		$ln = $pdf->GetY()+5;

		if($firmaEnc){
			$pdf->Image('../ft/'.$firmaEnc,40,215,43,16);
		}
		if($firmaRes){
			$pdf->Image('../ft/'.$firmaRes,120,215,43,16);
		}


		$pdf->SetXY(17,$ln);
		$pdf->SetFont('Arial','B',9);
		$txt = 'Firma Encargado de Calidad: ';
		$pdf->Cell(90,5,$txt,0,0,'C');

		$pdf->SetXY(100,$ln);
		$txt = 'Firma Responsable del Proceso: ';
		$pdf->Cell(90,5,$txt,0,0,'C');


		$pdf->SetXY(10,30);
		$pdf->Cell(180,215,'',1,0,'L');

		// Pie de P�gina
		$ln = 250;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','',9);

		$txt = 'Reg 0901 V.06';
		if($nInformeCorrectiva <= 120){
			$txt = 'Reg 0901 V.06';
		}
		$pdf->SetXY(17,$ln);
		$pdf->Cell(170,4,$txt,0,0,'R');

		$ln = 255;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','',9);
		$txt = 'Pag. '.$pdf->PageNo().' de 2';
		$pdf->SetXY(17,$ln);
		$pdf->Cell(170,4,$txt,0,0,'R');
	}
	$link->close();

	$ruta = 'Y://AAA/LE/CALIDAD/AC/AC-'.$nInformeCorrectiva.'/'; 
	$NombreFormulario = "AC-".$nInformeCorrectiva.".pdf";
	$pdf->Output($NombreFormulario,'D'); //Para Descarga
	$pdf->Output($ruta.$NombreFormulario,'F'); //Para Directorio o Carpeta
	//$pdf->Output('F3B-00001.pdf','F');

?>
