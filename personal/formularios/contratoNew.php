<?php
include('../../conexionli.php');
require('../../fpdf/fpdf.php'); 

/* Variables Gets recibidas */
if(isset($_GET['Run'])) 	{ $Run 		= $_GET['Run']; 	}
if(isset($_GET['nBoleta'])) { $nBoleta 	= $_GET['nBoleta'];	}


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
$bdH=$link->query("SELECT * FROM Honorarios WHERE Run = '".$Run."' && nBoleta = '".$nBoleta."'");
if ($rowH=mysqli_fetch_array($bdH)){
	$PeriodoPago	= $rowH['PeriodoPago'];
	$Proyecto 		= $rowH['IdProyecto'];
	$Descripcion 	= $rowH['Descripcion'];
	$PerIniServ 	= $rowH['PerIniServ'];
	$PerTerServ 	= $rowH['PerTerServ'];
	$Total 			= $rowH['Total'];
	$fechaContrato	= $rowH['fechaContrato'];
	
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
	$JefeProyecto 		= $row['JefeProyecto'];
	$nomProyecto 		= $row['Proyecto'];
	$Rut_JefeProyecto 	= $row['Rut_JefeProyecto'];
	$firmaJefe 			= $row['firmaJefe'];
}

		$bdDep=$link->query("SELECT * FROM Departamentos");
		if($rowDep=mysqli_fetch_array($bdDep)){
			$bdDi=$link->query("SELECT * FROM Director Where RutDirector = '".$rowDep['RutDirector']."'");
			if($rowDi=mysqli_fetch_array($bdDi)){
				if($fechaContrato >= $rowDi['fechaInicio']){
					$NomDirector = $rowDep['NomDirector'];
					$Cargo		 = $rowDep['Cargo'];
					$RutDirector = $rowDep['RutDirector'];
				}else{
					$bdDi=$link->query("SELECT * FROM Director Where fechaTermino > '0000-00-00'");
					if($rowDi=mysqli_fetch_array($bdDi)){
						do{
							if($fechaContrato >= $rowDi['fechaInicio'] and $fechaContrato <= $rowDi['fechaTermino']){
								$NomDirector = $rowDi['NomDirector'];
								$Cargo		 = $rowDi['Cargo'];
								$RutDirector = $rowDep['RutDirector'];
							}	
						}while($rowDi=mysqli_fetch_array($bdDi));
					}	
				}	
			}	
		}

$bdDep=$link->query("SELECT * FROM Departamentos");
if ($rowDep=mysqli_fetch_array($bdDep)){
	$NomDirector = $rowDep['NomDirector'];
	$RutDirector = $rowDep['RutDirector'];
}

$bdSup=$link->query("SELECT * FROM supervisor");
if ($rowSup=mysqli_fetch_array($bdSup)){
	$rutSuper 		= $rowSup['rutSuper'];
	$nombreSuper 	= $rowSup['nombreSuper'];
	$cargoSuper 	= $rowSup['cargoSuper'];
	$firmaSuper 	= $rowSup['firmaSuper'];
}

$bdEmp=$link->query("SELECT * FROM Empresa");
if($rowEmp=mysqli_fetch_array($bdEmp)){
	$RutEmp = $rowEmp['RutEmp'];
}
$link->close();

/* Encabezado Contrato */
	$cLeft 	= 48;
	$cRigth	= 58;
	$mLeft	= 20;
	$ln = 25;

	$pdf=new FPDF('P','mm','Letter');
	$pdf->AddPage();
	$pdf->SetLeftMargin($mLeft);
	$pdf->Image('../../logossdt/formulariosolicitudes2022.png',10,10);

	$pdf->SetFont('Arial','B',12);

	$pdf->SetXY($mLeft,$ln);
	$pdf->Cell(170,7,utf8_decode('CONTRATO DE PRESTACIÓN'),0,2,'C');
	$pdf->Cell(170,7,'DE SERVICIOS PROFESIONALES',0,2,'C');

	$pdf->SetFont('Arial','',10);

	$ln += 14;
	$pdf->SetXY($mLeft,$ln);
	$pdf->Cell(70,5,utf8_decode('FACULTAD DE INGENIERÍA:'),0,0);
	$ln += 5;
	$pdf->SetXY($mLeft,$ln);
	$pdf->Cell(70,5,'DEPARTAMENTO DE METALURGIA:',0,0);
	$ln += 5;
	$pdf->SetXY($mLeft,$ln);
	$pdf->Cell(70,5,$Proyecto,0,0);
	
/* Fin Encabezado Contrato */

	$pdf->SetFont('Arial','',9);

/* Primer Parrafo Contrato */
	
	//$fd 	= explode('-', $PerIniServ);
	$fd 	= explode('-', $fechaContrato);
	$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
	
	$Fecha = $fd[2].' de '.$Mes[intval($fd[1])].' de '.$fd[0];
	//$Fecha = $fd[2].' de '.$Mes[intval($fd[1])].' de '.$fd[0];

	$fd 	= explode('-', $PerIniServ);
	$fIni 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
	$fIni 	= $fd[2].' de '.$Mes[intval($fd[1])].' de '.$fd[0];

	$fd 	= explode('-', $PerTerServ);
	$fTer 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
	$fTer 	= $fd[2].' de '.$Mes[intval($fd[1])].' de '.$fd[0];

	$ln += 7;
	$pdf->SetY($ln);
	$LinTxt  = 'En Santiago, a '.$Fecha.', comparecen don '. utf8_decode($JefeProyecto).utf8_decode(', cédula nacional de identidad ').$Rut_JefeProyecto.utf8_decode(', en  nombre y representación de ');
	$LinTxt .= utf8_decode('Sociedad de Desarrollo Tecnológico de la Universidad de Santiago de Chile Ltda.,');

/*
	$pdf->SetFont('Arial','B',10);
	$ln = $pdf->GetY();
	$pdf->SetXY(49,$ln-5);
	$LinTxt = 'Sociedad de Desarrollo Tecnol�gico de la Universidad de Santiago de Chile Ltda.,';
	$pdf->MultiCell(170,5,$LinTxt,0,'J');
*/
	$pdf->SetFont('Arial','',9);

	if(substr($RutEmp,8,1)=="-"){
		$RunF 	= number_format(substr($RutEmp,0,8), 0, ',', '.');
		$Dv		= substr($RutEmp,8,2);
	}else{
		$RunF 	= number_format(substr($RutEmp,0,7), 0, ',', '.');
		$Dv		= substr($RutEmp,7,2);
	}
	
	$LinTxt .= utf8_decode('en adelante "SDT USACH", RUT ').$RunF.$Dv;
	if(substr($Run,8,1)=="-"){
		$RunF 	= number_format(substr($Run,0,8), 0, ',', '.');
		$Dv		= substr($Run,8,2);
	}else{
		$RunF 	= number_format(substr($Run,0,7), 0, ',', '.');
		$Dv		= substr($Run,7,2);
	}
	$LinTxt .= ' y don '.utf8_decode($Nombre).', '.$RunF.$Dv.', '.$Profesion.', Domiciliado en '.utf8_decode($Direccion).', '.utf8_decode($Comuna).', en adelante "el prestador" y exponen lo siguiente :';
	$pdf->MultiCell(170,5,$LinTxt,0,'J');
	//$pdf->MultiCell(170,5,$LinTxt,0,'J');
		
/* Primer Parrafo Contrato */

/* Articulo Primero */

	$pdf->SetFont('Arial','B',10);
	
	$ln = $pdf->GetY()+2;
	$pdf->SetXY($mLeft,$ln);
	$pdf->MultiCell(170,5,'PRIMERO: ANTECEDENTES. ',0,'J');
	$ln = $pdf->GetY()+2;
	$pdf->SetXY($mLeft,$ln);
	$pdf->SetFont('Arial','',9);
	$LinTxt  = 'SDT USACH es una persona jurídica de derecho privado que tiene ';
	$LinTxt .= 'por objeto el desarrollo, coordinación, promoción y apoyo a las actividades que realice la ';
	$LinTxt .= 'Universidad de Santiago de Chile en materias de adaptación y desarrollo de tecnología, asistencia ';
	$LinTxt .= 'técnica, educación continua y prestación de servicios técnicos orientados hacia la ';
	$LinTxt .= 'comunidad en general, y el sector empresarial en particular, así como la administración ';
	$LinTxt .= 'contable y financiera de los programas, servicios y cursos de nivel académico que ';
	$LinTxt .= 'desarrolla la Universidad.';
	$pdf->MultiCell(170,5,utf8_decode($LinTxt),0,'J');

	$ln = $pdf->GetY()+2;
	$pdf->SetXY($mLeft,$ln);
	$LinTxt  = utf8_decode('El Departamento de Ingeniería Metalúrgica de la Universidad de Santiago de Chile, se encuentra ');
	$LinTxt .= utf8_decode('realizando el siguiente proyecto a través de la SDT  Usach: "').$nomProyecto.'" ';
	
	if($Run == $Rut_JefeProyecto){
		$LinTxt .= utf8_decode('bajo la dirección del Director don ').$NomDirector.'.';
	}else{
		$LinTxt .= utf8_decode('bajo la dirección del Profesor don ').$JefeProyecto.'.';
	}
	$pdf->MultiCell(170,5,$LinTxt,0,'J');

	$ln = $pdf->GetY()+2;
	$pdf->SetXY($mLeft,$ln);
	$pdf->SetFont('Arial','B',10);
	$pdf->MultiCell(196,5,'SEGUNDO: OBJETO:',0,'J');

	$ln = $pdf->GetY()+2;
	$pdf->SetXY($mLeft,$ln);
	$pdf->SetFont('Arial','',9);
	$LinTxt  = 'Por el presente instrumento don '. utf8_decode($Nombre).' se compromete a prestar para SDT USACH ';
	$LinTxt .= 'los siguientes servicios: '.utf8_decode($Descripcion).' a partir de '.$fIni.' hasta '.$fTer.'.';
	$pdf->MultiCell(170,5,$LinTxt,0,'J');

	$ln = $pdf->GetY()+2;
	$pdf->SetXY($mLeft,$ln);
	$LinTxt  = 'En la prestación de sus servicios, el prestador deberá respetar las normas internas definidas por SDT USACH y el jefe del proyecto.';
	$pdf->MultiCell(170,5,utf8_decode($LinTxt),0,'J');

	$ln = $pdf->GetY()+2;
	$pdf->SetXY($mLeft,$ln);
	$pdf->SetFont('Arial','B',9);
	$pdf->MultiCell(196,5,'TERCERO: HONORARIOS.',0,'J');
	$ln = $pdf->GetY()+2;
	$pdf->SetXY($mLeft,$ln);
	$pdf->SetFont('Arial','',9);
	$LinTxt  = utf8_decode('Por la prestación de los servicios don ');
	$LinTxt .= utf8_decode($Nombre).', ';
	$LinTxt .= utf8_decode('contra la presentación de su boleta de honorarios percibirá de parte de ');
	$LinTxt .= 'SDT USACH la suma de $ '.number_format($Total, 0, ',', '.').', ';
	// $LinTxt .= utf8_decode('global de la cual se retendrá un 11.5% por concepto de retención de impuestos a la renta.');
	// $LinTxt .= utf8_decode('global de la cual se retendrá un 12.25% por concepto de retención de impuestos a la renta.');
	// $LinTxt .= utf8_decode('global de la cual se retendrá un 13.75.5% por concepto de retención de impuestos a la renta.');
	// $LinTxt .= utf8_decode('global de la cual se retendrá un 14.5% por concepto de retención de impuestos a la renta.');
	$LinTxt .= utf8_decode('global de la cual se retendrá un 15.25% por concepto de retención de impuestos a la renta.');
	$pdf->MultiCell(170,5,$LinTxt,0,'J');

	$ln = $pdf->GetY()+2;
	$pdf->SetXY($mLeft,$ln);
	$pdf->SetFont('Arial','B',9);
	$pdf->MultiCell(196,5,utf8_decode('CUARTO: CONFIDENCIALIDAD Y ÉTICA.'),0,'J');
	$ln = $pdf->GetY()+2;
	$pdf->SetXY($mLeft,$ln);
	$pdf->SetFont('Arial','',9);
	$LinTxt  = 'El Prestador declara conocer y aceptar que toda información que, con motivo del contrato ';
	$LinTxt .= 'de prestación de servicios profesionales antes señalado, le sea entregada o resulte de ';
	$LinTxt .= 'la ejecución de este (ambas en adelante, la información "Confidencial"), sólo podrá ser ';
	$LinTxt .= 'utilizada para los fines señalados en dicho contrato, lo que deberá interpretarse siempre ';
	$LinTxt .= 'en sentido restrictivo, de modo tal, que la información recabada, recibida o a la que ';
	$LinTxt .= 'tenga acceso, deberá aplicarse o destinarse exclusiva y únicamente al objeto materia del ';
	$LinTxt .= 'señalado contrato de prestación de servicios profesionales. ';
	$pdf->MultiCell(170,5,utf8_decode($LinTxt),0,'J');


	// CAMBIO DE PAGINA
	// Pie
	$pdf->SetFillColor(234, 80, 55);
	// $pdf->SetDrawColor(234, 80, 55);
	$pdf->SetTextColor(255, 255, 255);

	$fila = 234;
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

	// CAMBIO DE PAGINA




	$pdf->AddPage();
	$pdf->Image('../../logossdt/formulariosolicitudes2022.png',10,10);
	$ln = $pdf->GetY()+25;
	$pdf->SetXY($mLeft,$ln);

	$LinTxt  = 'Por información "Confidencial", se entenderá toda información que no sea de conocimiento ';
	$LinTxt .= 'público, tales como los documentos, programas de trabajo, procedimientos, contratos de los ';
	$LinTxt .= 'trabajadores, manuales operativos o protocolares de las Empresas Asociadas a SDT USACH, ó ';
	$LinTxt .= 'cualquier otro que documente los antecedentes previos, desarrollo y resultados de los ';
	$LinTxt .= 'servicios contratados y en general, toda la información que se genere, con ocasión del ';
	$LinTxt .= 'referido contrato de prestación de servicios. ';
	$LinTxt .= 'Dicha información deberá mantenerse bajo la más estricta confidencialidad en los términos ';
	$LinTxt .= 'establecidos en la Ley Nº 19.628. ';
	$pdf->MultiCell(170,5,utf8_decode($LinTxt),0,'J');

	$ln = $pdf->GetY()+2;
	$pdf->SetXY($mLeft,$ln);
	$LinTxt  = 'A no ser que de otro modo fuese específicamente estipulado en el presente acuerdo, los ';
	$LinTxt .= 'Prestadores no podrán, sin contar con el permiso previo manifestado por escrito por SDT ';
	$LinTxt .= 'USACH, suministrar ninguna copia de la información Confidencial a ninguna persona o entidad, ';
	$LinTxt .= 'que no participe directa y efectivamente del proceso de evaluación a realizar. Además, las ';
	$LinTxt .= 'Partes harán sus mejores esfuerzos en limitar el conocimiento, y el acceso a dicha información, ';
	$LinTxt .= 'solamente a aquellos profesionales quienes, dentro del curso y alcance ordinario del trabajo, ';
	$LinTxt .= 'requieren tener conocimiento de ella.';
	$pdf->MultiCell(170,5,utf8_decode($LinTxt),0,'J');

	$ln = $pdf->GetY()+2;
	$pdf->SetXY($mLeft,$ln);
	$LinTxt  = 'El prestador, por el presente acuerdo, se obliga a: (i) usar la Información Confidencial ';
	$LinTxt .= 'única y exclusivamente para los efectos de cumplir en forma adecuada con sus obligaciones ';
	$LinTxt .= 'y realización de actos bajo el Contrato de Prestación de Servicios que lo vincula con SDT ';
	$LinTxt .= 'USACH; (ii) mantener en estricta reserva y manejar confidencialmente respecto de cualquier ';
	$LinTxt .= 'persona natural o jurídica, la Información Confidencial a que acceda; (iii) custodiar y ';
	$LinTxt .= 'proteger diligentemente toda la Información Confidencial a que tenga acceso o conocimiento ';
	$LinTxt .= 'o que se encuentre en su poder; así como custodiar y proteger diligentemente, de igual forma, ';
	$LinTxt .= 'todos y cada uno de los soportes, de cualquier especie o formato, en los que conste o se ';
	$LinTxt .= 'contenga parte cualquiera de la Información Confidencial; iv) abstenerse de hacer copias o ';
	$LinTxt .= 'reproducciones de la Información Confidencial que no sean estrictamente necesarias para los ';
	$LinTxt .= 'efectos de la prestación de sus servicios profesionales; v) no impugnar ni pretender ';
	$LinTxt .= 'titularidad o autoría de ninguna especie sobre la Información Confidencial; vi) no solicitar ';
	$LinTxt .= 'privilegio de propiedad intelectual o industrial alguna relativo a la Información Confidencial; ';
	$LinTxt .= 'vii) no impugnar las solicitudes y tramitaciones de obtención de privilegios de propiedad ';
	$LinTxt .= 'intelectual o industrial de la otra Parte;viii) comunicar inmediatamente y por escrito a la ';
	$LinTxt .= 'otra Parte acerca de la ocurrencia de cualquier acto, hecho u omisión que constituya una ';
	$LinTxt .= 'infracción a las obligaciones asumidas precedentemente, sea por acciones u omisiones propias ';
	$LinTxt .= 'o de terceros; e, ix) impetrar todas las medidas que fueren necesarias o convenientes y cooperar ';
	$LinTxt .= 'para que, en el evento que por un acto, hecho u omisión suya o de los terceros antes señalados, ';
	$LinTxt .= 'todo o parte de la Información Confidencial hubiere sido divulgada en contravención a lo establecido ';
	$LinTxt .= 'en este Acuerdo.';
	$pdf->MultiCell(170,5,utf8_decode($LinTxt),0,'J');

	$ln = $pdf->GetY()+2;
	$pdf->SetXY($mLeft,$ln);
	$LinTxt  = 'El deber de confidencialidad que debe guardar el Prestador tiene el carácter de permanente, incluso ';
	$LinTxt .= 'en el evento que no se firme contrato alguno, en el futuro.';
	$pdf->MultiCell(170,5,utf8_decode($LinTxt),0,'J');

	$ln = $pdf->GetY()+2;
	$pdf->SetXY($mLeft,$ln);
	$LinTxt  = 'En lo que al aspecto ótico se refiere, el Prestador deberá respetar el secreto profesional y de no ';
	$LinTxt .= 'revelar, por ningún motivo, en beneficio propio o de terceros, los hechos, datos o circunstancias ';
	$LinTxt .= 'de que tenga o hubiese tenido conocimiento en el ejercicio de sus labores relativas al contrato de ';
	$LinTxt .= 'prestación de servicios que lo vincula con SDT USACH.';
	$pdf->MultiCell(170,5,utf8_decode($LinTxt),0,'J');


		// CAMBIO DE PAGINA
	// Pie
	$pdf->SetFillColor(234, 80, 55);
	// $pdf->SetDrawColor(234, 80, 55);
	$pdf->SetTextColor(255, 255, 255);

	$fila = 234;
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

	// CAMBIO DE PAGINA


	$pdf->AddPage();
	$pdf->Image('../../logossdt/formulariosolicitudes2022.png',10,10);
	$ln = $pdf->GetY()+25;
	$pdf->SetXY($mLeft,$ln);



	$ln = $pdf->GetY()+2;
	$pdf->SetXY($mLeft,$ln);
	$pdf->SetFont('Arial','B',9);
	$pdf->MultiCell(196,5,'QUINTO: PROPIEDAD INTELECTUAL E INDUSTRIAL.',0,'J');
	$ln = $pdf->GetY()+2;
	$pdf->SetXY($mLeft,$ln);
	$pdf->SetFont('Arial','',9);
	$LinTxt   = 'Las partes reconocen que como parte de la naturaleza de las funciones encomendadas, la realización ';
	$LinTxt  .= 'de labores creativas o inventivas. Por lo anterior, la propiedad intelectual e industrial de los ';
	$LinTxt  .= 'productos y resultados del servicio contratado, incluyendo aquellos productos que el prestador haya ';
	$LinTxt  .= 'contribuido a crear o perfeccionar, sean éstos libros, programas computacionales, artículos, memorándum, ';
	$LinTxt  .= 'notas o materiales gráficos, informes, estudios, bases de datos, diseños, memorias o, en general, ideas, ';
	$LinTxt  .= 'marcas, invenciones, procesos, mejoras, entre otros,  que sean patentables o protegibles por las leyes de ';
	$LinTxt  .= 'propiedad intelectual o industrial, y que el prestador, sus dependientes y subcontratistas hayan creado o ';
	$LinTxt  .= 'desarrollado durante el curso del presente Contrato o con ocasión de él, son de propiedad de la Universidad ';
	$LinTxt  .= 'de Santiago de Chile, y no podrá ser traspasada a terceros.';
	$pdf->MultiCell(170,5,utf8_decode($LinTxt),0,'J');

	$ln = $pdf->GetY()+2;
	$pdf->SetXY($mLeft,$ln);
	$LinTxt  = 'Al término del presente contrato el prestador entregará íntegramente los documentos físicos o electrónicos, normativas, procedimientos, bases de datos, estudios, especificaciones técnicas, términos de referencia, y cualquier otro tipo de información que le hayan sido entregados para los efectos de este Contrato o producidos a causa de este.';
	$pdf->MultiCell(170,5,utf8_decode($LinTxt),0,'J');


	$ln = $pdf->GetY()+2;
	$pdf->SetXY($mLeft,$ln);
	$LinTxt  = 'El prestador se obliga a no registrar como propiedad intelectual y/o industrial suya, patentes, ';
	$LinTxt .= 'creaciones u otras formas de obtener derechos sobre los bienes intelectuales e industriales señalados ';
	$LinTxt .= 'en el párrafo primero de esta cláusula, aun cuando en dichos productos haya intervenido el trabajador. ';
	$LinTxt .= 'Si el trabajador ha registrado sobre tales o partes que lo componen, propiedad de alguna naturaleza ';
	$LinTxt .= 'bajo su nombre, deberá ceder dicha propiedad a la Universidad de Santiago de Chile. Lo anterior se ';
	$LinTxt .= 'entiende sin  perjuicio de las acciones legales que pueda impetrar la Universidad de Santiago de Chile ';
	$LinTxt .= 'como tercera beneficiaria de esta cláusula, o SDT Usach como contratante, para exigir el cumplimiento ';
	$LinTxt .= 'de este contrato y/o resarcirse de los daños que pudiere haber sufrido, y perseguir las sanciones ';
	$LinTxt .= 'civiles y penales que correspondan.';
	$pdf->MultiCell(170,5,utf8_decode($LinTxt),0,'J');

	$ln = $pdf->GetY()+2;
	$pdf->SetXY($mLeft,$ln);
	$pdf->SetFont('Arial','B',9);
	$pdf->MultiCell(196,5,'SEXTO: CONSTANCIA.',0,'J');
	$ln = $pdf->GetY()+2;
	$pdf->SetXY($mLeft,$ln);
	$pdf->SetFont('Arial','',9);
	$LinTxt  = 'Se deja expresa constancia que en el caso en que el prestador del servicio sea funcionario de la Universidad de Santiago de Chile, o que durante la vigencia de este contrato adquiera tal calidad, los servicios independientes y específicos a que se compromete por este contrato deberán realizarse sin interferir ni afectar las funciones que debe ejecutar en su calidad de empleado público ni tampoco su jornada de trabajo en dicha institución.';
	$pdf->MultiCell(170,5,utf8_decode($LinTxt),0,'J');

	$ln = $pdf->GetY()+2;
	$pdf->SetXY($mLeft,$ln);
	$pdf->SetFont('Arial','B',9);
	$pdf->MultiCell(196,5,utf8_decode('SÉPTIMO: CLÁUSULA DE SALIDA.'),0,'J');
	$ln = $pdf->GetY()+2;
	$pdf->SetXY($mLeft,$ln);
	$pdf->SetFont('Arial','',9);
	$LinTxt  = 'SDT USACH podrá poner término al presente contrato en forma unilateral sin expresión de causa y sin derecho a indemnización a favor del prestador, a través de la sola comunicación escrita o enviada por correo electrónico, percibiendo el prestador del servicio sus honorarios proporcionales al servicio otorgado a la fecha de término según los servicios efectivamente prestados.';
	$pdf->MultiCell(170,5,utf8_decode($LinTxt),0,'J');

	$ln = $pdf->GetY()+2;
	$pdf->SetXY($mLeft,$ln);
	$pdf->SetFont('Arial','B',9);
	$pdf->MultiCell(196,5,'OCTAVO: ARBITRAJE.',0,'J');
	$ln = $pdf->GetY()+2;
	$pdf->SetXY($mLeft,$ln);
	$pdf->SetFont('Arial','',9);
	$LinTxt  = 'Cualquier dificultad o controversia que se produzca entre los contratantes respecto de la aplicación, interpretación, duración, validez o ejecución de este contrato o cualquier otro motivo será sometida a arbitraje, conforme al Reglamento Procesal de Arbitraje del Centro de Arbitraje y Mediación de Santiago, vigente al momento de solicitarlo.';
	$pdf->MultiCell(170,5,utf8_decode($LinTxt),0,'J');




		// CAMBIO DE PAGINA
	// Pie
	$pdf->SetFillColor(234, 80, 55);
	// $pdf->SetDrawColor(234, 80, 55);
	$pdf->SetTextColor(255, 255, 255);

	$fila = 234;
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

	// CAMBIO DE PAGINA


	$pdf->AddPage();
	$pdf->Image('../../logossdt/formulariosolicitudes2022.png',10,10);
	$ln = $pdf->GetY()+25;
	$pdf->SetXY($mLeft,$ln);







	$ln = $pdf->GetY()+2;
	$pdf->SetXY($mLeft,$ln);
	$pdf->SetFont('Arial','',9);
	$LinTxt  = 'Las partes confieren poder especial irrevocable a la Cámara de Comercio de Santiago A.G., para que, a petición escrita de cualquiera de ellas, designe a un árbitro arbitrador en cuanto al procedimiento y de derecho en cuanto al fallo, de entre los integrantes del cuerpo arbitral del Centro de Arbitraje y Mediación de Santiago.';
	$pdf->MultiCell(170,5,utf8_decode($LinTxt),0,'J');

	$ln = $pdf->GetY()+2;
	$pdf->SetXY($mLeft,$ln);
	$pdf->SetFont('Arial','',9);
	$LinTxt  = 'En contra de las resoluciones del árbitro no procederá recurso alguno. El árbitro queda especialmente facultado para resolver todo asunto relacionado con su competencia y/o jurisdicción.';
	$pdf->MultiCell(170,5,utf8_decode($LinTxt),0,'J');
 
	$ln = $pdf->GetY()+2;
	$pdf->SetXY($mLeft,$ln);
	$pdf->SetFont('Arial','B',9);
	$pdf->MultiCell(196,5,utf8_decode('NOVENO: PERSONERÍA.'),0,'J');
	$ln = $pdf->GetY()+2;
	$pdf->SetXY($mLeft,$ln);
	$pdf->SetFont('Arial','',9);
	$LinTxt  = 'La personería del representante del SDT Usach consta en convenio general de administración de proyectos otorgado por ecritura pública de 12 de agosto de 2015, de la Notaría de don Félix Jara Cadot, Santiago, repertorio Nº 24299-2015.';
	$pdf->MultiCell(170,5,utf8_decode($LinTxt),0,'J');

/* Pie de Contrato */

	$pdf->SetFont('Arial','B',9);

	//$firmaSuper = 'aaa.png';
	$pdf->Image('../../ft/'.$firmaJefe,50,170,40,40);
	//$pdf->Image('../../ft/TimbreDirector.png',60,180,20,20);

	$pdf->Line(35, 200, 110, 200);
	$pdf->SetXY(35,205);
	$pdf->Cell(70,5,"REPRESENTANTE",0,0,"C");
	$pdf->SetXY(35,210);
	$pdf->Cell(70,5,utf8_decode("SOCIEDAD DE DESARROLLO TECNOLÓGICO"),0,0,"C");
	$pdf->SetXY(35,215);
	$pdf->Cell(70,5,"DE LA UNIVERSIDAD DE SANTIAGO DE CHILE LTDA.",0,0,"C");

	if($firmaPrestador){
		$pdf->Image('../../ft/'.$firmaPrestador,130,170,40,40);
	}
	

	$pdf->Line(115, 200, 190, 200);
	$pdf->SetXY(120,205);
	$pdf->Cell(70,5, utf8_decode($Nombre),0,0,"C");
	$pdf->SetXY(120,210);
	$pdf->Cell(70,5,"PRESTADOR DEL SERVICIO",0,0,"C");




		// CAMBIO DE PAGINA
	// Pie
	
	$pdf->SetFillColor(234, 80, 55);
	$pdf->SetTextColor(255, 255, 255);
	
	$fila = 234;
	$pdf->SetXY(10,$fila);
	$pdf->SetDrawColor(234, 80, 55);
	$pdf->MultiCell(185,25,'',1,'L', true);
	/*
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
	*/
	// CAMBIO DE PAGINA


	
/* Imprime Contrato */
	//$pdf->Output('Contrato.pdf','I'); //Para Descarga
	$agnoActual = date('Y');
	$vDir = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/HONORARIOS/';;

	$NombreFormulario = "Contrato-".$Run."-".$nBoleta.".pdf";
	$pdf->Output($NombreFormulario,'D'); //Para Descarga Directa
	$pdf->Output($vDir.$NombreFormulario,'F'); //Para Descarga Directa



?>
