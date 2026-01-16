<?php
include('../conexion.php');
require('../../fpdf/fpdf.php');

/* Variables Gets recividas */
$Run 		= $_GET['Run'];
$nBoleta 	= $_GET['nBoleta'];


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
$bdH=mysql_query("SELECT * FROM Honorarios WHERE Run = '".$Run."' && nBoleta = '".$nBoleta."'");
if ($rowH=mysql_fetch_array($bdH)){
	$Proyecto 		= $rowH['IdProyecto'];
	$Descripcion 	= $rowH['Descripcion'];
	$PerIniServ 	= $rowH['PerIniServ'];
	$PerTerServ 	= $rowH['PerTerServ'];
	$Total 			= $rowH['Total'];
	$fechaContrato	= $rowH['fechaContrato'];
/*
	if($rowH['Estado']!="P"){
		$actSQL="UPDATE Honorarios SET ";
		$actSQL.="FechaPago		='".date('Y-m-d')."',";
		$actSQL.="Estado		='P'";
		$actSQL.="WHERE Run		='".$Run."' && nBoleta = '".$nBoleta."'";
		$bdH=mysql_query($actSQL);
	}
*/

}
$bdH=mysql_query("SELECT * FROM PersonalHonorarios WHERE Run = '".$Run."'");
if ($rowH=mysql_fetch_array($bdH)){
	$Nombre 		= $rowH['Nombres'].' '.$rowH['Paterno'].' '.$rowH['Materno'];
	$Profesion 		= $rowH['ProfesionOficio'];
	$Direccion 		= $rowH['Direccion'];
	$Comuna 		= $rowH['Comuna'];
	$ServicioIntExt	= $rowH['ServicioIntExt'];
}
$bd=mysql_query("SELECT * FROM Proyectos Where IdProyecto = '".$Proyecto."'");
if ($row=mysql_fetch_array($bd)){
	$JefeProyecto 	= $row['JefeProyecto'];
	$nomProyecto 	= $row['Proyecto'];
}
$bdDep=mysql_query("SELECT * FROM Departamentos");
if ($rowDep=mysql_fetch_array($bdDep)){
	$NomDirector = $rowDep['NomDirector'];
}
mysql_close($link);

/* Encabezado Contrato */
	$pdf=new FPDF('P','mm','Letter');
	$pdf->AddPage();
	$pdf->Ln(3);
	$pdf->Image('../../gastos/logos/logousachcontrato.png',20,5,23,30);
	$pdf->SetFont('Arial','B',12);
	$pdf->Ln(2);
	$pdf->Cell(35);
	$pdf->Cell(125,7,'SOCIEDAD DE DESARROLLO TECNOLÓGICO DE LA',0,2,'C');
	$pdf->Cell(125,7,'UNIVERSIDAD DE SANTIAGO DE CHILE LIMITADA',0,2,'C');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(196,8,'CONTRATO HONORARIOS',0,0,'C');
	$pdf->Ln(7);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(70,4,'UNIVERSIDAD DE SANTIAGO DE CHILE:',0,0);
	$pdf->Ln(4);
	$pdf->Cell(70,4,'FACULTAD DE INGENIERIA:',0,0);
	$pdf->Ln(4);
	$pdf->Cell(70,4,'DEPARTAMENTO DE METALURGIA:',0,0);
	$pdf->Ln(4);
	$pdf->Cell(70,4,$Proyecto,0,0);
/* Fin Encabezado Contrato */

	$pdf->SetFont('Arial','',9);

/* Primer Parrafo Contrato */
	
	//$fd 	= explode('-', date('Y-m-d'));
	$fd 	= explode('-', $fechaContrato);
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

	$pdf->SetFont('Arial','B',9);

	$pdf->Ln(3);
	$pdf->Cell(196,5,'PRIMERO: ANTECEDENTES.',0,0);
	$pdf->Ln(3);

	$pdf->SetFont('Arial','',9);
	
	$LinTxt  = 'SDT USACH Ltda. es una persona jurídica de derecho privado que tiene por objeto el ';
	$LinTxt .= 'desarrollo, coordinación, promoción y apoyo a las actividades que realice la Universidad ';
	$LinTxt .= 'de Santiago de Chile en materias de adaptación y desarrollo de tecnología, asistencia ';
	$LinTxt .= 'técnica, educación continua y prestación de servicios técnicos orientados hacia la ';
	$LinTxt .= 'comunidad en general, y el sector empresarial en particular, así como la administración ';
	$LinTxt .= 'contable y financiera de los programas, servicios y cursos de nivel académico que ';
	$LinTxt .= 'desarrolla la Universidad.';
	$pdf->Ln(2);
	$pdf->MultiCell(175,5,$LinTxt,0,'J');
	
	$LinTxt  = 'El Departamento de Ingeniería Metalúrgica, se encuentra realizando el siguiente proyecto ';
	$LinTxt .= 'a través de la Sociedad de Desarrollo Tecnológico de la Universidad de Santiago de Chile ';
	$LinTxt .= 'limitada: “'.$nomProyecto.'”, bajo la dirección del Profesor ';
	$LinTxt .= 'don '.$JefeProyecto.'.';
	$pdf->Ln(2);
	$pdf->MultiCell(175,5,$LinTxt,0,'J');

/* Fin Articulo Primero */

	$pdf->Ln(3);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(196,5,'SEGUNDO: OBJETO.',0,0);
	$pdf->Ln(2);
	$pdf->SetFont('Arial','',9);

	$fd 	= explode('-', $PerIniServ);
	$fIni 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
	$fIni 	= $fd[2].' de '.$Mes[intval($fd[1])].' de '.$fd[0];

	$fd 	= explode('-', $PerTerServ);
	$fTer 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
	$fTer 	= $fd[2].' de '.$Mes[intval($fd[1])].' de '.$fd[0];
	
	$LinTxt  = 'Por el presente instrumento don '.$Nombre.' se compromete a prestar para SDT USACH Ltda. ';
	$LinTxt .= 'Las siguientes funciones: '.$Descripcion.' a partir de '.$fIni.' hasta '.$fTer.'.';
	$pdf->Ln(3);
	$pdf->MultiCell(175,5,$LinTxt,0,'J');
	
/* Articulo Tercero HONORARIOS. */

	$pdf->SetFont('Arial','B',9);

	$pdf->Ln(3);
	$pdf->Cell(196,5,'TERCERO: HONORARIOS.',0,0);
	$pdf->Ln(3);

	$pdf->SetFont('Arial','',9);
	
	$LinTxt  = 'Por la prestación de los servicios don ';
	$LinTxt .= $Nombre;
	$LinTxt .= ', contra la presentación de su boleta de honorarios percibirá de parte de la ';
	$LinTxt .= 'Sociedad de Desarrollo Tecnológico la suma de $ '.number_format($Total, 0, ',', '.');
	$LinTxt .= ', global de la cual se retendrá un 10% por concepto de retención de impuestos a la renta.';

	$pdf->MultiCell(175,5,$LinTxt,0,'J');

/* Fin Tercero */	

/*	$pdf->AddPage(); */
	
/* Articulo Cuarto HONORARIOS. */

	$pdf->SetFont('Arial','B',9);

	$pdf->Ln(3);
	$pdf->Cell(196,5,'CUARTO: CONSTANCIA.',0,0);
	$pdf->Ln(3);

	$pdf->SetFont('Arial','',9);
	
	$LinTxt  = 'Se deja expresa constancia que el prestador del servicio ';
	if($ServicioIntExt=="E"){
		$LinTxt  .= 'si ';
	}
	$LinTxt  .= 'es funcionario de la Universidad de Santiago, por lo que la prestación de los servicios deberá realizarse sin interferir ni afectar las funciones que debe ejecutar en su calidad de empleado público.';

	$pdf->MultiCell(175,5,$LinTxt,0,'J');

/* Fin Cuarto */	

/* Articulo Quinto */

	$pdf->SetFont('Arial','B',9);

	$pdf->Ln(3);
	$pdf->Cell(196,5,'QUINTO.',0,0);
	$pdf->Ln(3);

	$pdf->SetFont('Arial','',9);

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

/* Imprime Contrato */
	//$pdf->Output('Contrato.pdf','I'); //Para Descarga
	$NombreFormulario = "Contrato-".$Run."-".$nBoleta.".pdf";
	$pdf->Output($NombreFormulario,'D'); //Para Descarga
	//$pdf->Output('F3B-00001.pdf','F');
	header("Location: CalculoHonorarios.php");

function Justifica($t){
	if(strlen($t)<85){
		$i = 0;
		while (strlen($t)<85){
			if(substr($t,$i,1)==" "){
				$t = trim(substr($t,0,$i+1)." ".substr($t,$i+1));
				$i++;
			}
			$i++;
			if(strlen(trim($t))<=$i){
				   $i = 0;
			}
		}
	}
	return $t;
}
?>
