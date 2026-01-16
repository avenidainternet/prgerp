<?php
include('../conexion.php');
require('../../fpdf/fpdf.php');

/* Variables Gets recibidas */
$Proyecto	= $_GET['IdProyecto'];
$nInforme	= $_GET['nInforme'];
$Fecha		= $_GET['Fecha'];
$fd 		= explode('-', $Fecha);
$Fecha 		= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
$Periodo	= $fd[1].".".$fd[0];

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


$pdf=new FPDF('P','mm','Letter');

/********************** Imprime Solicitudes     *****************************/

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
	$pdf->Cell(110,5,$Fecha,0,0);

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
	//$bdH=mysql_query("SELECT * FROM Honorarios WHERE IdProyecto = '".$Proyecto."' && PeriodoPago = '".$Periodo."' && Estado = 'P' && nInforme = ".$nInforme."");
	$bdH=mysql_query("SELECT * FROM Honorarios WHERE IdProyecto = '".$Proyecto."' && Estado = 'P' && nInforme = ".$nInforme."");
	if ($rowH=mysql_fetch_array($bdH)){
		do{
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

/********************** Fin Imprime Solicitudes *****************************/

	$link=Conectarse();
	$bdDep=mysql_query("SELECT * FROM Departamentos");
	if ($rowDep=mysql_fetch_array($bdDep)){
		$NomDirector 			= $rowDep['NomDirector'];
		$SubDirectorProyectos 	= $rowDep['SubDirectorProyectos'];
	}
	$bd=mysql_query("SELECT * FROM Proyectos Where IdProyecto = '".$Proyecto."'");
	if ($row=mysql_fetch_array($bd)){
		$NomProyecto 	= $row['Proyecto'];
		$JefeProyecto 	= $row['JefeProyecto'];
	}
	mysql_close($link);

	$pdf->AddPage('L');
	$pdf->Image('../../gastos/logos/sdt.png',10,10,33,25);
	$pdf->Image('../../gastos/logos/logousach.png',170,10,18,25);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(40);
	$pdf->Cell(100,10,'UNIVERSIDAD DE SANTIAGO DE CHILE',0,2,'C');
	$pdf->Cell(100,1,'SOCIEDAD DE DESARROLLO TECNOLÓGICO',0,2,'C');
	$pdf->Ln(20);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(50,10,'FORMULARIO 1C',1,0,'C');
	//$pdf->Cell(50,10,'FORMULARIO '.$_POST['Formulario'],1,0,'C');
	$pdf->Cell(130,10,'NOMINA DE PRESTADORES DEL PROYECTO',1,0,'L');

	$pdf->Ln(15);
	$pdf->Cell(70,5,'NOMBRE DEL PROYECTO :',0,0);
	//$pdf->Cell(2,5,':',0,0);
	$pdf->Cell(110,5,$NomProyecto,0,0);

	$pdf->Ln(5);
	$pdf->Cell(70,5,'CÓDIGO DEL PROYECTO :',0,0);
	//$pdf->Cell(2,5,':',0,0);
	$pdf->Cell(110,5,$Proyecto,0,0);

	$pdf->Ln(5);
	$pdf->Cell(70,5,'DURACIÓN (meses) :',0,0);
	//$pdf->Cell(2,5,':',0,0);
	$pdf->Cell(110,5,'INDEFINIDO',0,0);

	$pdf->SetFont('Arial','B',6);
	$pdf->Ln(10);
	
	$pdf->Cell(50,20,'',1,0,'C');
	$pdf->Cell(14,20,'',1,0,'C');
	$pdf->Cell(13,20,'',1,0,'C');
	$pdf->Cell(14,20,'',1,0,'C');
	$pdf->Cell(25,20,'',1,0,'C');
	$pdf->Cell(18,20,'',1,0,'C');
	$pdf->Cell(35,20,'',1,0,'C');
	$pdf->Cell(70,20,'',1,0,'C');
	$pdf->Cell(14,20,'',1,0,'C');
	$pdf->Cell(8,20,'',1,0,'C');
	$pdf->Ln(1);
	$pdf->Cell(50,5,'Nombre del Profesinal',0,0,'C');
	$pdf->Cell(14,5,'Rut',0,0,'C');
	$pdf->Cell(13,5,'Contrato de',0,0,'C');
	$pdf->Cell(14,5,'Contrato a',0,0,'C');
	$pdf->Cell(25,5,'Periodo de',0,0,'C');
	$pdf->Cell(18,5,'Lugar de',0,0,'C');
	$pdf->Cell(35,5,'Función o',0,0,'C');
	$pdf->Cell(70,5,'Descripción de Tarea Principal',0,0,'C');
	$pdf->Cell(14,5,'Monto a',0,0,'C');
	$pdf->Cell(8,5,'N° de',0,0,'C');
	$pdf->Ln(3);
	$pdf->Cell(50,5,'(Apellidos - Nombres)',0,0,'C');
	$pdf->Cell(14,5,'',0,0,'C');
	$pdf->Cell(13,5,'Planta',0,0,'C');
	$pdf->Cell(14,5,'Contrata',0,0,'C');
	$pdf->Cell(25,5,'Contrato',0,0,'C');
	$pdf->Cell(18,5,'Desempeño',0,0,'C');
	$pdf->Cell(35,5,'Cargo',0,0,'C');
	$pdf->Cell(70,5,'',0,0,'C');
	$pdf->Cell(14,5,'Cancelar',0,0,'C');
	$pdf->Cell(8,5,'Pagos',0,0,'C');
	$pdf->Ln(3);
	$pdf->Cell(50,5,'',0,0,'C');
	$pdf->Cell(14,5,'',0,0,'C');
	$pdf->Cell(13,5,'USACH',0,0,'C');
	$pdf->Cell(14,5,'USACH',0,0,'C');
	$pdf->Cell(25,5,'Honorarios',0,0,'C');
	$pdf->Cell(18,5,'(Oficina Usach -',0,0,'C');
	$pdf->Cell(35,5,'',0,0,'C');
	$pdf->Cell(70,5,'',0,0,'C');
	$pdf->Cell(14,5,'Mensual',0,0,'C');
	$pdf->Cell(8,5,'',0,0,'C');
	$pdf->Ln(3);
	$pdf->Cell(50,5,'',0,0,'C');
	$pdf->Cell(14,5,'',0,0,'C');
	$pdf->Cell(13,5,'(si o no)',0,0,'C');
	$pdf->Cell(14,5,'(Indicar hasta',0,0,'C');
	$pdf->Cell(25,5,'(Desde - Hasta)',0,0,'C');
	$pdf->Cell(18,5,'En Terreno)',0,0,'C');
	$pdf->Cell(35,5,'',0,0,'C');
	$pdf->Cell(70,5,'',0,0,'C');
	$pdf->Cell(14,5,'',0,0,'C');
	$pdf->Cell(8,5,'',0,0,'C');
	$pdf->Ln(3);
	$pdf->Cell(50,5,'',0,0,'C');
	$pdf->Cell(14,5,'',0,0,'C');
	$pdf->Cell(13,5,'',0,0,'C');
	$pdf->Cell(14,5,'que fecha)',0,0,'C');
	$pdf->Cell(25,5,'',0,0,'C');
	$pdf->Cell(18,5,'',0,0,'C');
	$pdf->Cell(35,5,'',0,0,'C');
	$pdf->Cell(70,5,'',0,0,'C');
	$pdf->Cell(14,5,'',0,0,'C');
	$pdf->Cell(8,5,'',0,0,'C');

	$pdf->Ln(2);

	$sTotal 		= 0;
	$RunControl 	= "";
	$ImprimeLinea 	= "No";
	$nBoletas		= 0;
	
	$link=Conectarse();
	//$bdH=mysql_query("SELECT * FROM Honorarios WHERE IdProyecto = '".$Proyecto."' && PeriodoPago = '".$Periodo."' && Estado = 'P' && nInforme = '".$nInforme."'");
	$bdH=mysql_query("SELECT * FROM Honorarios WHERE IdProyecto = '".$Proyecto."' && Estado = 'P' && nInforme = '".$nInforme."'");
	if ($rowH=mysql_fetch_array($bdH)){
	DO{
		$Run	 		= $rowH['Run'];
		$nBoleta 		= $rowH['nBoleta'];
		$Descripcion 	= $rowH['Descripcion'];
		$PerIniServ 	= $rowH['PerIniServ'];
		$PerTerServ 	= $rowH['PerTerServ'];
		$LugarTrabajo 	= $rowH['LugarTrabajo'];
		$FuncionCargo 	= $rowH['FuncionCargo'];
		$Descripcion 	= $rowH['Descripcion'];
		$Total 			= $rowH['Total'];
		$sTotal			+= $Total;

		$bdP=mysql_query("SELECT * FROM PersonalHonorarios WHERE Run = '".$Run."'");
		if ($rowP=mysql_fetch_array($bdP)){
			$Nombre 		= $rowP['Paterno'].' '.$rowP['Materno'].' '.$rowP['Nombres'];
			$Run 			= $rowP['Run'];
			$ServicioIntExt	= $rowP['ServicioIntExt'];
			$Banco 			= $rowP['Banco'];
			$nCuenta 		= $rowP['nCuenta'];
			$LugarTrabajo	= $rowP['LugarTrabajo'];
			$Cargo	 		= $rowP['Cargo'];
			$TipoContrato	= $rowP['TipoContrato'];
			$ServicioIntExt	= $rowP['ServicioIntExt'];
			//if($ServicioIntExt=="I"){
				if(substr($Run,8,1)=="-"){
					$RunF 	= number_format(substr($Run,0,8), 0, ',', '.');
					$Dv		= substr($Run,8,2);
				}else{
					$RunF 	= number_format(substr($Run,0,7), 0, ',', '.');
					$Dv		= substr($Run,7,2);
				}
				$pdf->SetFont('Arial','',6);
				$pdf->Ln(5);
				$pdf->Cell(50,5,$Nombre,1,0);
				$pdf->Cell(14,5,$RunF.$Dv,1,0,'R');
				if($TipoContrato=="P"){
					$pdf->Cell(13,5,'Si',1,0,'C');
				}else{
					$pdf->Cell(13,5,'No',1,0,'C');
				}

				// ¿Contrato a Contrata, hasta que fecha?
				if($TipoContrato=="P"){
					$pdf->Cell(14,5,'No',1,0,'C');
				}else{
					if($TipoContrato=="C"){ // Indicar la Fecha
						$pdf->Cell(14,5,'No',1,0,'C');
					}else{
						$pdf->Cell(14,5,'No',1,0,'C');
					}
				}
				$fd 	= explode('-', $PerIniServ);
				$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
				$ft 	= explode('-', $PerTerServ);
				$FechaT	= "{$ft[2]}-{$ft[1]}-{$ft[0]}";
				$pdf->Cell(25,5,$fd[2].' al '.$ft[2].' de '.$Mes[intval($ft[1])],1,0);
				$pdf->Cell(18,5,$LugarTrabajo,1,0);
				$pdf->Cell(35,5,$Cargo,1,0);
				$pdf->Cell(70,5,$Descripcion,1,0);
				$pdf->Cell(14,5,number_format($Total, 0, ',', '.'),1,0,'R');
				$pdf->Cell(8,5,'1',1,0,'R');
			//}
		}

	}WHILE ($rowH=mysql_fetch_array($bdH));
	}
	mysql_close($link);

	$pdf->SetFont('Arial','B',10);
	// Line(Col, FilaDesde, ColHasta, FilaHasta) 
	$pdf->Line(20, 180, 90, 180);
	$pdf->SetXY(20,181);
	//Cell(LargoMarco ,AltoMarco, Txt, VerMarco, ,Centro)
	$pdf->Cell(70,5,$JefeProyecto,0,0,"C");
	$pdf->SetXY(20,186);
	$pdf->Cell(70,5,"Jefe de Proyecto",0,0,"C");

	$pdf->Line(120, 180, 190, 180);
	$pdf->SetXY(120,181);
	$pdf->Cell(70,5,$NomDirector,0,0,"C");
	$pdf->SetXY(120,186);
	$pdf->Cell(70,5,"Director de Departamento",0,0,"C");

	$pdf->Line(200, 180, 270, 180);
	$pdf->SetXY(200,181);
	$pdf->Cell(70,5,$SubDirectorProyectos,0,0,"C");
	$pdf->SetXY(200,186);
	$pdf->Cell(70,5,"Vº Bº SubDirectora de Proyectos",0,0,"C");
	$pdf->SetXY(200,190);
	$pdf->Cell(70,5,"SDT- USACH",0,0,"C");

/*************************************************************************/


/*
	$link=Conectarse();
	$actSQL="UPDATE Honorarios SET ";
	$actSQL.="FechaPago		='".date('Y-m-d')."',";
	$actSQL.="Estado		='P'";
	$actSQL.="WHERE IdProyecto = '".$Proyecto."' && PeriodoPago = '".$Periodo."' && Estado != 'P'";
	$bdH=mysql_query($actSQL);
	mysql_close($link);
*/
	/* Imprime Contrato */
		$NombreFormulario = "Formularios.pdf";
		//$pdf->Output($NombreFormulario,'I'); //Para Imprimir Pantalla
		$pdf->Output($NombreFormulario,'D'); //Para Descarga
		//$pdf->Output($NombreFormulario,'F');
	header("Location: CalculoHonorarios.php");

?>
