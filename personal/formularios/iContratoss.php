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

/********************** Fin Imprime Solicitudes *****************************/

/********************** Imprime Contratos 		*****************************/

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

			$bdP=mysql_query("SELECT * FROM PersonalHonorarios WHERE Run = '".$Run."'");
			if ($rowP=mysql_fetch_array($bdP)){
				$Nombre 		= $rowP['Nombres'].' '.$rowP['Paterno'].' '.$rowP['Materno'];
				$Profesion 		= $rowP['ProfesionOficio'];
				$Direccion 		= $rowP['Direccion'];
				$Comuna 		= $rowP['Comuna'];
				$ServicioIntExt	= $rowP['ServicioIntExt'];
			}
			$bd=mysql_query("SELECT * FROM Proyectos Where IdProyecto = '".$Proyecto."'");
			if ($row=mysql_fetch_array($bd)){
				$JefeProyecto = $row['JefeProyecto'];
			}
			$bdDep=mysql_query("SELECT * FROM Departamentos");
			if ($rowDep=mysql_fetch_array($bdDep)){
				$NomDirector = $rowDep['NomDirector'];
			}

			/* Encabezado Contrato */
			$pdf->AddPage();
			$pdf->Ln(10);
			$pdf->Image('../../gastos/logos/logousachcontrato.png',20,30,23,30);
			$pdf->SetFont('Arial','B',14);
			$pdf->Ln(22);
			$pdf->Cell(35);
			$pdf->Cell(125,7,'SOCIEDAD DE DESARROLLO TECNOLÓGICO DE LA',0,2,'C');
			$pdf->Cell(125,7,'UNIVERSIDAD DE SANTIAGO DE CHILE LIMITADA',0,2,'C');
			$pdf->Ln(10);
			$pdf->SetFont('Arial','B',14);
			$pdf->Cell(196,8,'CONTRATO HONORARIOS',0,0,'C');
			$pdf->Ln(13);
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(70,4,'UNIVERSIDAD DE SANTIAGO DE CHILE:',0,0);
			$pdf->Ln(4);
			$pdf->Cell(70,4,'FACULTAD DE INGENIERIA:',0,0);
			$pdf->Ln(4);
			$pdf->Cell(70,4,'DEPARTAMENTO DE METALURGIA:',0,0);
			$pdf->Ln(4);
			$pdf->Cell(70,4,$Proyecto,0,0);
			/* Fin Encabezado Contrato */

			$pdf->SetFont('Arial','',12);

			/* Primer Parrafo Contrato */
	
			$fd 	= explode('-', date('Y-m-d'));
			$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
	
			$Fecha = $fd[2].' de '.$Mes[intval($fd[1])].' de '.$fd[0];
			//$Fecha = $fd[2].' de '.$Mes[9].' de '.$fd[0];
	
			$LinTxt  = 'En Santiago, a '.$Fecha.', comparecen don '.$NomDirector.' en  su ';
			$LinTxt .= 'calidad de Director de Departamento, en nombre y representación de la Sociedad de ';
			$LinTxt .= 'Desarrollo Tecnológico de la Universidad de Santiago de Chile Ltda., en adelante “SDT ';
			if(substr($Run,8,1)=="-"){
				$RunF 	= number_format(substr($Run,0,8), 0, ',', '.');
				$Dv		= substr($Run,8,2);
			}else{
				$RunF 	= number_format(substr($Run,0,7), 0, ',', '.');
				$Dv		= substr($Run,7,2);
			}
			$LinTxt .= 'USACH Ltda.”, y don '.$Nombre.', '.$RunF.$Dv.', '.$Profesion.', Domiciliado en '.$Direccion.', '.$Comuna.' y exponen lo siguiente:';
			$pdf->Ln(5);
			$pdf->MultiCell(175,5,$LinTxt,0,'J');
		
			/* Primer Parrafo Contrato */

			/* Articulo Primero */

			$pdf->SetFont('Arial','B',12);

			$pdf->Ln(8);
			$pdf->Cell(196,5,'PRIMERO: ANTECEDENTES.',0,0);
			$pdf->Ln(5);

			$pdf->SetFont('Arial','',12);
	
			$LinTxt  = 'SDT USACH Ltda. es una persona jurídica de derecho privado que tiene por objeto el ';
			$LinTxt .= 'desarrollo, coordinación, promoción y apoyo a las actividades que realice la Universidad ';
			$LinTxt .= 'de Santiago de Chile en materias de adaptación y desarrollo de tecnología, asistencia ';
			$LinTxt .= 'técnica, educación continua y prestación de servicios técnicos orientados hacia la ';
			$LinTxt .= 'comunidad en general, y el sector empresarial en particular, así como la administración ';
			$LinTxt .= 'contable y financiera de los programas, servicios y cursos de nivel académico que ';
			$LinTxt .= 'desarrolla la Universidad.';
			$pdf->Ln(5);
			$pdf->MultiCell(175,5,$LinTxt,0,'J');
		
			$pdf->Ln(5);

			$LinTxt  = 'El Departamento de Ingeniería Metalúrgica, se encuentra realizando el siguiente proyecto ';
			$LinTxt .= 'a través de la Sociedad de Desarrollo Tecnológico de la Universidad de Santiago de Chile ';
			$LinTxt .= 'limitada: “Mejora en las propiedades de productos de acero”, bajo la dirección del Profesor ';
			$LinTxt .= 'don '.$JefeProyecto.'.';
			$pdf->Ln(5);
			$pdf->MultiCell(175,5,$LinTxt,0,'J');

			/* Fin Articulo Primero */

			/* Articulo Tercero HONORARIOS. */

			$pdf->SetFont('Arial','B',12);

			$pdf->Ln(8);
			$pdf->Cell(196,5,'TERCERO: HONORARIOS.',0,0);
			$pdf->Ln(5);

			$pdf->SetFont('Arial','',12);
	
			$LinTxt  = 'Por la prestación de los servicios don ';
			$LinTxt .= $Nombre;
			$LinTxt .= ', contra la presentación de su boleta de honorarios percibirá de parte de la ';
			$LinTxt .= 'Sociedad de Desarrollo Tecnológico la suma de $ '.number_format($Total, 0, ',', '.');
			$LinTxt .= ', global de la cual se retendrá un 10% por concepto de retención de impuestos a la renta.';

			$pdf->MultiCell(175,5,$LinTxt,0,'J');

			/* Fin Tercero */	

			$pdf->AddPage();
	
			/* Articulo Cuarto HONORARIOS. */

			$pdf->SetFont('Arial','B',12);

			$pdf->Ln(8);
			$pdf->Cell(196,5,'CUARTO: CONSTANCIA.',0,0);
			$pdf->Ln(5);

			$pdf->SetFont('Arial','',12);
	
			$LinTxt  = 'Se deja expresa constancia que el prestador del servicio ';
			if($ServicioIntExt=="E"){
				$LinTxt  .= 'si ';
			}
			$LinTxt  .= 'es funcionario de la Universidad de Santiago, por lo que la prestación de los servicios deberá realizarse sin interferir ni afectar las funciones que debe ejecutar en su calidad de empleado público.';

			$pdf->MultiCell(175,5,$LinTxt,0,'J');

			/* Fin Cuarto */	

			/* Articulo Quinto */

			$pdf->SetFont('Arial','B',12);

			$pdf->Ln(8);
			$pdf->Cell(196,5,'QUINTO.',0,0);
			$pdf->Ln(5);

			$pdf->SetFont('Arial','',12);

			$LinTxt  = 'Don ';
			$LinTxt .= $Nombre;
			$LinTxt .= ', acepta que el Director del departamento de Ingeniería Metalúrgica puede poner término a sus servicios sin expresión de causa, sin ';
			$LinTxt .= 'derecho a indemnización, percibiendo el prestador del servicio sus honorarios ';
			$LinTxt .= 'proporcionales al servicio otorgado a la fecha de término.';
	

			$pdf->MultiCell(175,5,$LinTxt,0,'J');

			/* Fin Cuarto */	

			/* Pie de Contrato */
	
			$pdf->SetFont('Arial','B',10);

			$pdf->Line(35, 228, 110, 228);
			$pdf->SetXY(35,233);
			//Cell(LargoMarco ,AltoMarco, Txt, VerMarco, ,Centro)
			$pdf->Cell(70,5,$NomDirector,0,0,"C");
			$pdf->SetXY(35,238);
			$pdf->Cell(70,5,"DIRECTOR DE DEPARTAMENTO",0,0,"C");

			$pdf->Line(115, 228, 190, 228);
			$pdf->SetXY(120,233);
			$pdf->Cell(70,5,$Nombre,0,0,"C");
			$pdf->SetXY(120,238);
			$pdf->Cell(70,5,"PRESTADOR DEL SERVICIO",0,0,"C");
			/* Fin Cuarto */	

		}WHILE ($rowH=mysql_fetch_array($bdH));
	}
	mysql_close($link);
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
		$NombreFormulario = "Contratos.pdf";
		//$pdf->Output($NombreFormulario,'I'); //Para Imprimir Pantalla
		$pdf->Output($NombreFormulario,'D'); //Para Descarga
		//$pdf->Output($NombreFormulario,'F');
	header("Location: CalculoHonorarios.php");

?>
