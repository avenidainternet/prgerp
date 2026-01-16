<?php
	require_once('../fpdf/fpdf.php');
	include_once("conexion.php");

	$nInformeCorrectiva = $_GET['nInformeCorrectiva'];
	$accion 			= $_GET['acion'];
		
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
	$bdCAM=mysql_query("SELECT * FROM accionesCorrectivas WHERE nInformeCorrectiva = '".$nInformeCorrectiva."'");
	if($rowCAM=mysql_fetch_array($bdCAM)){

		$pdf=new FPDF('P','mm','Letter');

		// Encabezado 
		$pdf->AddPage();
		$pdf->SetXY(10,5);
		$pdf->Image('../imagenes/logoSimetCam.png',10,5,43,16);

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
		$pdf->Cell(10,5,'Acreditado NCh-ISO 17.025.',0,0);

		$pdf->SetXY(10,17);
		$pdf->Image('../gastos/logos/logousach.png',195,5,15,23);

		
		$pdf->SetDrawColor(200, 200, 200);
		$pdf->Line(190, 30, 190, 270);
		$pdf->SetDrawColor(0, 0, 0);
		$pdf->Image('../imagenes/logoSimetCam.png',185,245,20,8);
		// Fin Encabezado

		$pdf->SetFont('Arial','B',10);
		$fd 	= explode('-', $rowCAM[fechaApertura]);
		$pdf->SetXY(12,25);
		$pdf->Cell(5,5,'N° AC : '.$nInformeCorrectiva,0,0);

		$pdf->SetXY(130,25);
		$pdf->Cell(50,5,'Fecha : '.$fd[2].' / '.$Mes[$fd[1]-1].' / '.$fd[0],0,0);

		$pdf->SetXY(10,30);
		$pdf->SetFillColor(51, 51, 255);
		$pdf->Cell(90,10,'1. Fuente',1,0,'L',true);
		
		$pdf->Cell(90,10,'2. Origen',1,0,'L',true);
		$pdf->SetFillColor(0, 0, 0);

		$pdf->SetXY(10,40);
		$pdf->Cell(90,27,'',1,0,'L');
		$pdf->Cell(90,27,'',1,0,'L');

		// *****************************
		// Primer Bloque  
		// *****************************

		// Primera Linea
		
		$pdf->SetXY(12,41);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(4,4,'',1,0,'L');
		if($rowCAM[fteRecCliExt]=='on'){
			$pdf->SetXY(12,41);
			$pdf->Cell(4,4,'X',0,0,'C');
		}
		//$pdf->Image('../imagenes/visto_bueno.png',13,41.5,3,3);
		$txt = 'Reclamo de Cliente Externo ';
		if($rowCAM[fteRecCliExt]=='on'){
			$txt .= '(N° Reclamo '.$rowCAM[fteNroRecCliExt].')';
		}else{
			$txt .= '(N° Reclamo ';
			$largoStr 	= strlen($txt);
			$nCarRep	= $largoMaxA - $largoStr;
			$txt .= str_repeat('_',$nCarRep);
			$txt .= ')';
		}
		$pdf->Cell(50,5,$txt,0,0,'L');

		$pdf->SetXY(102,41);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(4,4,'',1,0,'L');
		if($rowCAM[oriSisGes]=='on'){
			$pdf->SetXY(12,41);
			$pdf->Cell(4,4,'X',0,0,'C');
		}
		$txt = 'Sistema de Gestión ';
		if($rowCAM[oriSisGes]=='on'){
			$fd 	= explode('-', $rowCAM[oriSisGesFecha]);
			$txt .= '(Fecha '.$fd[2].'/'.$fd[1].'/'.$fd[0].')';
		}else{
			$txt .= '(Fecha';
			$largoStr 	= strlen($txt);
			$nCarRep	= $largoMaxB - $largoStr;
			$txt .= str_repeat('_',$nCarRep);
			$txt .= ')';
		}
		$pdf->Cell(50,5,$txt,0,0,'L');

		// 2da Linea
		
		$pdf->SetXY(12,46);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(4,4,'',1,0,'L');
		if($rowCAM[fteRecCliInt]=='on'){
			$pdf->SetXY(12,46);
			$pdf->Cell(4,4,'X',0,0,'C');
		}
		//$pdf->Image('../imagenes/visto_bueno.png',13,41.5,3,3);
		$txt = 'Reclamo de Cliente Interno ';
		if($rowCAM[fteRecCliInt]=='on'){
			$txt .= '(N° Reclamo '.$rowCAM[fteNroRecCliInt].')';
		}else{
			$txt .= '(N° Reclamo';
			$largoStr 	= strlen($txt);
			$nCarRep	= $largoMaxA - $largoStr;
			$txt .= str_repeat('_',$nCarRep);
			$txt .= ')';
		}
		$pdf->Cell(50,5,$txt,0,0,'L');

		$pdf->SetXY(102,46);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(4,4,'',1,0,'L');
		if($rowCAM[oriEnsayos]=='on'){
			$pdf->SetXY(12,46);
			$pdf->Cell(4,4,'X',0,0,'C');
		}
		$txt = 'Ensayos ';
		if($rowCAM[oriEnsayos]=='on'){
			$txt .= '(N° Asociado '.$rowCAM[oriNroAso].')';
		}else{
			$txt .= '(N° Asociado';
			$largoStr 	= strlen($txt);
			$nCarRep	= $largoMaxB - $largoStr;
			$txt .= str_repeat('_',$nCarRep);
			$txt .= ')';
		}
		
		$pdf->Cell(50,5,$txt,0,0,'L');

		// 3ra Linea
		
		$pdf->SetXY(12,51);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(4,4,'',1,0,'L');
		if($rowCAM[fteAut ]=='on'){
			$pdf->SetXY(12,51);
			$pdf->Cell(4,4,'X',0,0,'C');
		}
		//$pdf->Image('../imagenes/visto_bueno.png',13,41.5,3,3);
		$txt = 'Autodetectada  ';
		if($rowCAM[fteAut]=='on'){
			$fd 	= explode('-', $rowCAM[fteAutFecha]);
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
		if($rowCAM[oriLeyReg]=='on'){
			$pdf->SetXY(12,51);
			$pdf->Cell(4,4,'X',0,0,'C');
		}
		$txt = 'Leyes / Reglamentos ';
		if($rowCAM[oriLeyReg]=='on'){
			$fd 	= explode('-', $rowCAM[oriLeyRegFecha]);
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
		$pdf->Cell(4,4,'',1,0,'L');
		if($rowCAM[fteAudInt ]=='on'){
			$pdf->SetXY(12,56);
			$pdf->Cell(4,4,'X',0,0,'C');
		}
		//$pdf->Image('../imagenes/visto_bueno.png',13,41.5,3,3);
		$txt = 'Auditoría Interna ';
		if($rowCAM[fteAudInt]=='on'){
			$fd 	= explode('-', $rowCAM[fteAudIntFecha]);
			$txt .= '(Fecha '.$fd[2].'/'.$fd[1].'/'.$fd[0].')';
		}else{
			$txt .= '(Fecha';
			$largoStr 	= strlen($txt);
			$nCarRep	= $largoMaxA - $largoStr;
			$txt .= str_repeat('_',$nCarRep);
			$txt .= ')';
		}
		$pdf->Cell(50,5,$txt,0,0,'L');

		$pdf->SetXY(102,56);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(4,4,'',1,0,'L');
		if($rowCAM[oriTnc]=='on'){
			$pdf->SetXY(12,56);
			$pdf->Cell(4,4,'X',0,0,'C');
		}
		$txt = 'TNC, ';
		if($rowCAM[oriTnc]=='on'){
			$fd 	= explode('-', $rowCAM[oriTncFecha]);
			$txt .= '(Fecha '.$fd[2].'/'.$fd[1].'/'.$fd[0].')';
		}else{
			$txt .= '(Fecha';
			$largoStr 	= strlen($txt);
			$nCarRep	= $largoMaxB - $largoStr;
			$txt .= str_repeat('_',$nCarRep);
			$txt .= ')';
		}
		$pdf->Cell(50,5,$txt,0,0,'L');

		// 5ta Linea
		
		$pdf->SetXY(12,61);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(4,4,'',1,0,'L');
		if($rowCAM[fteOtros ]=='on'){
			$pdf->SetXY(12,61);
			$pdf->Cell(4,4,'X',0,0,'C');
		}
		//$pdf->Image('../imagenes/visto_bueno.png',13,41.5,3,3);
		$txt = 'OTROS ';
		if($rowCAM[fteOtros]=='on'){
			$txt .= '('.$rowCAM[fteOtrosTxt].')';
		}else{
			$txt .= '(';
			$largoStr 	= strlen($txt);
			$nCarRep	= $largoMaxA - $largoStr;
			$txt .= str_repeat('_',$nCarRep);
			$txt .= ')';
		}
		$pdf->Cell(50,5,$txt,0,0,'L');

		$pdf->SetXY(102,61);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(4,4,'',1,0,'L');
		if($rowCAM[oriOtros]=='on'){
			$pdf->SetXY(12,61);
			$pdf->Cell(4,4,'X',0,0,'C');
		}
		$txt = 'OTROS ';
		if($rowCAM[oriOtros]=='on'){
			$txt .= '('.$rowCAM[oriOtrosTxt].')';
		}else{
			$txt .= '(';
			$largoStr 	= strlen($txt);
			$nCarRep	= $largoMaxB - $largoStr;
			$txt .= str_repeat('_',$nCarRep);
			$txt .= ')';
		}
		$pdf->Cell(50,5,$txt,0,0,'L');

		// *****************************
		// Fin Primer Bloque  
		// *****************************
		

		// *****************************
		// Segundo Bloque  
		// *****************************

		$pdf->SetXY(10,67);
		$pdf->SetFillColor(51, 51, 255);
		$pdf->Cell(180,10,'3. Descripción del Hallazgo',1,0,'L',true);
		
		$pdf->SetFillColor(0, 0, 0);


		// 1ra Linea
		
		$pdf->SetXY(12,78);
		$pdf->SetFont('Arial','B',9);
		$txt = 'a) Clasificación ';
		$pdf->Cell(180,5,$txt,0,0,'L');

		$pdf->SetXY(12,84);
		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(17,84);
		$pdf->Cell(4,4,'',1,0,'L');
		if($rowCAM[desClasNoConf]=='on'){
			$pdf->SetXY(17,84);
			$pdf->Cell(4,4,'X',0,0,'C');
		}
		$txt = 'No Conformidad; ';
		$pdf->Cell(40,5,$txt,0,0,'L');
		$pdf->Cell(4,4,'',1,0,'L');
		if($rowCAM[desClasObs]=='on'){
			$pdf->SetXY(61,84);
			$pdf->Cell(4,4,'X',0,0,'C');
		}
		$txt = 'Observación ';
		$pdf->Cell(40,5,$txt,0,0,'L');

		$pdf->SetXY(12,89);
		$pdf->SetFont('Arial','B',9);
		$txt = 'b)  Identificación del requerimiento normativo, legal o reglamentario afectado: ';
		$pdf->Cell(180,5,$txt,0,0,'L');

		$pdf->SetXY(12,94);
		$pdf->SetFont('Arial','',9);
		$txt = $rowCAM[desIdentificacion];
		$pdf->SetXY(17,94);
		$pdf->MultiCell(170,4,$txt,0,'J');

		$ln = $pdf->GetY()+1;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','B',9);
		$txt = 'c)  Hallazgo detectado: ';
		$pdf->Cell(180,5,$txt,0,0,'L');

		$ln = $pdf->GetY()+5;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','',9);
		$txt = $rowCAM[desHallazgo];
		$pdf->SetXY(17,$ln);
		$pdf->MultiCell(170,4,$txt,0,'J');

		$ln = $pdf->GetY()+1;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','B',9);
		$txt = 'd)  Evidencia objetiva del hallazgo: ';
		$pdf->Cell(180,5,$txt,0,0,'L');

		$ln = $pdf->GetY()+5;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','',9);
		$txt = $rowCAM[desEvidencia];
		$pdf->SetXY(17,$ln);
		$pdf->MultiCell(170,4,$txt,0,'J');

		$pdf->SetXY(10,67);
		$pdf->Cell(180,130,'',1,0,'L');

		// *****************************
		// Tercer Bloque  
		// *****************************

		$pdf->SetY(196);
		$ln = $pdf->GetY();
		$pdf->SetXY(10,$ln);
		$pdf->SetFillColor(51, 51, 255);
		$pdf->Cell(180,10,'4. Causa raíz del hallazgo: ',1,0,'L',true);
		
		$pdf->SetFillColor(0, 0, 0);

		$ln = $pdf->GetY()+12;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','',9);
		$txt = $rowCAM[Causa];
		$pdf->SetXY(17,$ln);
		$pdf->MultiCell(170,4,$txt,0,'J');

		$pdf->SetXY(10,196);
		$pdf->Cell(180,50,'',1,0,'L');
		
		// Pie de Página
		$ln = 250;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','',9);
		$txt = 'Reg 0901 Rev.03';
		$pdf->SetXY(17,$ln);
		$pdf->Cell(170,4,$txt,0,0,'R');

		$ln = 255;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','',9);
		$txt = 'Pag. '.$pdf->PageNo().' de 2';
		$pdf->SetXY(17,$ln);
		$pdf->Cell(170,4,$txt,0,0,'R');
		
		//*******************
		// Salto de Página
		
		// Encabezado 
		$pdf->AddPage();
		$pdf->SetXY(10,5);
		$pdf->Image('../imagenes/logoSimetCam.png',10,5,43,16);

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
		$pdf->Cell(10,5,'Acreditado NCh-ISO 17.025.',0,0);

		$pdf->SetXY(10,17);
		$pdf->Image('../gastos/logos/logousach.png',195,5,15,23);

		
		$pdf->SetDrawColor(200, 200, 200);
		$pdf->Line(190, 30, 190, 270);
		$pdf->SetDrawColor(0, 0, 0);
		$pdf->Image('../imagenes/logoSimetCam.png',185,245,20,8);
		// Fin Encabezado

		$ln = $pdf->GetY()+10;
		$pdf->SetXY(10,30);
		$pdf->SetFillColor(51, 51, 255);
		$pdf->Cell(180,10,'5. Acciones Correctivas: ',1,0,'L',true);
		$pdf->SetFillColor(0, 0, 0);

		$ln = $pdf->GetY()+12;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','B',9);
		$txt = 'Corrección: ';
		$pdf->Cell(180,5,$txt,0,0,'L');

		$ln = $pdf->GetY()+5;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','',9);
		$txt = $rowCAM[accCorrecion];
		$pdf->SetXY(17,$ln);
		$pdf->MultiCell(170,4,$txt,0,'J');

		$ln = $pdf->GetY()+5;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','B',9);
		$txt = 'Acción Correctiva: ';
		$pdf->Cell(180,5,$txt,0,0,'L');

		$ln = $pdf->GetY()+5;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','',9);
		$txt = $rowCAM[accAccionCorrectiva];
		$pdf->SetXY(17,$ln);
		$pdf->MultiCell(170,4,$txt,0,'J');

		$ln = 110;
		$pdf->SetXY(10,$ln);
		$txt = 'Fecha de implementación de la acción correctiva';
		$pdf->Cell(100,10,$txt,0,0,'L');
		$pdf->SetXY(100,$ln);
		$txt = ': ';
		$fd  = explode('-', $rowCAM[accFechaImp]);
		if($fd[0]>0){
			$txt .= $fd[2].'/'.$fd[1].'/'.$fd[0];
		}
		$pdf->Cell(100,10,$txt,0,0,'L');

		$ln = 115;
		$pdf->SetXY(10,$ln);
		$txt = 'Fecha tentativa de verificación  acción correctiva';
		$pdf->Cell(100,10,$txt,0,0,'L');
		$pdf->SetXY(100,$ln);
		$txt = ': ';
		$fd  = explode('-', $rowCAM[accFechaTen]);
		if($fd[0]>0){
			$txt .= $fd[2].'/'.$fd[1].'/'.$fd[0];
		}
		$pdf->Cell(100,10,$txt,0,0,'L');

		$ln = 120;
		$pdf->SetXY(10,$ln);
		$txt = 'Fecha de verificación de la acción correctiva';
		$pdf->Cell(100,10,$txt,0,0,'L');
		$pdf->SetXY(100,$ln);
		$txt = ': ';
		$fd  = explode('-', $rowCAM[accFechaApli]);
		if($fd[0]>0){
			$txt .= $fd[2].'/'.$fd[1].'/'.$fd[0];
		}
		$pdf->Cell(100,10,$txt,0,0,'L');


		$ln = 130;
		$pdf->SetXY(10,$ln);
		$pdf->SetFillColor(51, 51, 255);
		$pdf->Cell(180,10,'6.  Verificación de la implementación, efectividad y cierre de la AC ',1,0,'L',true);
		$pdf->SetFillColor(0, 0, 0);

		$ln = $pdf->GetY()+12;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','B',9);
		$txt = 'RESULTADO DE LA ACCIÓN CORRECTIVA: ';
		$pdf->Cell(180,5,$txt,0,0,'L');

		$ln = $pdf->GetY()+5;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','',9);
		$txt = $rowCAM[verResAccCorr];
		$pdf->SetXY(17,$ln);
		$pdf->MultiCell(170,4,$txt,0,'J');

		$ln = 190;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','B',9);
		$txt = 'CIERRE ACCIÓN CORRECTIVA: ';
		$pdf->Cell(35,5,$txt,0,0,'L');

		$txt = 'SI ';
		$pdf->SetXY(70,$ln);
		$pdf->Cell(5,5,$txt,0,0,'L');
		$pdf->Cell(4,4,'',1,0,'L');
		if($rowCAM[verCierreAccion]=='on'){
			$pdf->SetXY(75,$ln);
			$pdf->Cell(4,4,'X',0,0,'C');
		}

		$txt = 'NO ';
		$pdf->SetXY(90,$ln);
		$pdf->Cell(7,5,$txt,0,0,'L');
		$pdf->Cell(4,4,'',1,0,'L');
		if($rowCAM[verCierreAccion]!='on'){
			$pdf->SetXY(97,$ln);
			$pdf->Cell(4,4,'X',0,0,'C');
		}

		$ln = $pdf->GetY()+5;
		$pdf->SetXY(10,$ln);
		$pdf->Cell(90,50,'',1,0,'L');
		$pdf->Cell(90,50,'',1,0,'L');

		$pdf->SetXY(12,$ln+2);
		$pdf->SetFont('Arial','B',9);
		$txt = 'Firma Encargado de Calidad: ';
		$pdf->Cell(90,5,$txt,0,0,'L');

		$txt = 'Firma Responsable del Proceso: ';
		$pdf->Cell(102,5,$txt,0,0,'L');


		$ln = $pdf->GetY()+5;
		$pdf->SetXY(17,$ln);
		$pdf->SetFont('Arial','B',9);

		$txt = '';
		$bdUsr=mysql_query("SELECT * FROM Usuarios WHERE usr = '".$rowCAM[usrApertura]."'");
		if($rowUsr=mysql_fetch_array($bdUsr)){
			$txt = $rowUsr[usuario];
		}
		$pdf->Cell(90,5,$txt,0,0,'L');

		$txt = '';
		$bdUsr=mysql_query("SELECT * FROM Usuarios WHERE usr = '".$rowCAM[usrResponsable]."'");
		if($rowUsr=mysql_fetch_array($bdUsr)){
			$txt = $rowUsr[usuario];
		}
		$pdf->Cell(102,5,$txt,0,0,'L');

		$pdf->SetXY(10,30);
		$pdf->Cell(180,215,'',1,0,'L');

		// Pie de Página
		$ln = 250;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','',9);
		$txt = 'Reg 0901 Rev.03';
		$pdf->SetXY(17,$ln);
		$pdf->Cell(170,4,$txt,0,0,'R');

		$ln = 255;
		$pdf->SetXY(12,$ln);
		$pdf->SetFont('Arial','',9);
		$txt = 'Pag. '.$pdf->PageNo().' de 2';
		$pdf->SetXY(17,$ln);
		$pdf->Cell(170,4,$txt,0,0,'R');
	}
	//$pdf->Output('F3B-00001.pdf','I'); //Para Descarga
	$NombreFormulario = "AC-".$nInformeCorrectiva.".pdf";
	$pdf->Output($NombreFormulario,'D'); //Para Descarga
	//$pdf->Output('F3B-00001.pdf','F');

?>
