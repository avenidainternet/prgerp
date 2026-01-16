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

/*
		if($rowH['Estado']!="P"){
			$actSQL="UPDATE Honorarios SET ";
			$actSQL.="FechaPago		='".date('Y-m-d')."',";
			$actSQL.="Estado		='P'";
			$actSQL.="WHERE Run		='".$Run."' && nBoleta = '".$nBoleta."'";
			$bdH=mysql_query($actSQL);
		}
*/

	$pdf=new FPDF('P','mm','Letter');

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
	$pdf->Cell(125,7,utf8_decode('SOCIEDAD DE DESARROLLO TECNOLÓGICO DE LA'),0,2,'C');
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
	$mPago = explode('.',$Periodo);
	
	$Fecha = $fd[2].' de '.$Mes[intval($mPago[0])].' de '.$fd[0];
	//$Fecha = $fd[2].' de '.$Mes[9].' de '.$fd[0];
	
	if(strlen($LinTxt)<133){
		$pdf->Ln(8);
		$LinTxt = 'En Santiago, a '.$Fecha.', comparecen don '.$NomDirector.' en  su';
	}else{
	}
	$pdf->Cell(196,5,$LinTxt,0,0);
	$pdf->Ln(5);
	$LinTxt = 'calidad de Director de Departamento, en nombre y representaci�n de la Sociedad  de';
	$pdf->Cell(196,5,$LinTxt,0,0);
	$pdf->Ln(5);
	$LinTxt = 'Desarrollo Tecnol�gico de la Universidad de Santiago de Chile Ltda., en adelante �SDT';
	$pdf->Cell(196,5,$LinTxt,0,0);

	$lenRun = strlen($Run);
	if($lenRun=10){
		$RunF 	= number_format(substr($Run,0,8), 0, ',', '.');
		$Dv		= substr($Run,8,2);
	}else{
		$RunF = number_format(substr($Run,0,7), 0, ',', '.');
		$Dv		= substr($Run,7,2);
	}

	$LinTxt = 'USACH Ltda.�, y don '.$Nombre.', '.$RunF.$Dv.', '.$Profesion.', Domiciliado en '.$Direccion.', '.$Comuna.' y exponen lo siguiente:';
	if(strlen($LinTxt)<85){
		$pdf->Ln(5);
		$pdf->Cell(196,5,$LinTxt,0,0);
	}else{
		do {
			$l = strlen($LinTxt);
			if(strlen($LinTxt)>85){
				for($i=76; $i<=85; $i++){
					if(substr($LinTxt,$i,1)==" "){
						$t = substr($LinTxt,0,$i);
						break;
					}
				}
			}else{
				$t = $LinTxt;
			}
			$pdf->Ln(5);
			$pdf->Cell(196,5,$t,0,0);
			
			$LinTxt = substr($LinTxt,$i+1);

			//$pdf->Ln(5);
			//$pdf->Cell(196,5,$LinTxt,0,0);
		} while (strlen($LinTxt)>0);
	}
		
/* Primer Parrafo Contrato */

/* Articulo Primero */

	$pdf->SetFont('Arial','B',12);

	$pdf->Ln(8);
	$pdf->Cell(196,5,'PRIMERO: ANTECEDENTES.',0,0);
	$pdf->Ln(5);

	$pdf->SetFont('Arial','',12);
	
	$LinTxt  = 'SDT USACH Ltda. es una persona jur�dica de derecho privado que tiene por objeto el ';
	$LinTxt .= 'desarrollo, coordinaci�n, promoci�n y apoyo a las actividades que realice la Universidad ';
	$LinTxt .= 'de Santiago de Chile en materias de adaptaci�n y desarrollo de tecnolog�a, asistencia ';
	$LinTxt .= 't�cnica, educaci�n continua y prestaci�n de servicios t�cnicos orientados hacia la ';
	$LinTxt .= 'comunidad en general, y el sector empresarial en particular, as� como la administraci�n ';
	$LinTxt .= 'contable y financiera de los programas, servicios y cursos de nivel acad�mico que ';
	$LinTxt .= 'desarrolla la Universidad.';
	if(strlen($LinTxt)<85){
		$pdf->Ln(5);
		$pdf->Cell(196,5,$LinTxt,0,0);
	}else{
		do {
			$l = strlen($LinTxt);
			if(strlen($LinTxt)>85){
				for($i=85; $i>=0; $i--){
					if(substr($LinTxt,$i,1)==" "){
						$t = substr($LinTxt,0,$i);
						break;
					}
				}
			}else{
				$t = $LinTxt;
			}
			$pdf->Ln(5);
			$pdf->Cell(196,5,$t,0,0);
			$LinTxt = substr($LinTxt,$i+1);
		} while (strlen($LinTxt)>0);
	}
	
	$pdf->Ln(5);

	$LinTxt  = 'El Departamento de Ingenier�a Metal�rgica, se encuentra realizando el siguiente proyecto ';
	$LinTxt .= 'a trav�s de la Sociedad de Desarrollo Tecnol�gico de la Universidad de Santiago de Chile ';
	$LinTxt .= 'limitada: �Mejora en las propiedades de productos de acero�, bajo la direcci�n del Profesor ';
	$LinTxt .= 'don '.$JefeProyecto.'.';
	if(strlen($LinTxt)<85){
		$pdf->Ln(5);
		$pdf->Cell(196,5,$LinTxt,0,0);
	}else{
		do {
			$l = strlen($LinTxt);
			if(strlen($LinTxt)>85){
				for($i=85; $i>=0; $i--){
					if(substr($LinTxt,$i,1)==" "){
						$t = substr($LinTxt,0,$i);
						break;
					}
				}
			}else{
				$t = $LinTxt;
			}
			$pdf->Ln(5);
			$pdf->Cell(196,5,$t,0,0);
			$LinTxt = substr($LinTxt,$i+1);
		} while (strlen($LinTxt)>0);
	}

/* Fin Articulo Primero */

/* Articulo Tercero HONORARIOS. */

	$pdf->SetFont('Arial','B',12);

	$pdf->Ln(8);
	$pdf->Cell(196,5,'TERCERO: HONORARIOS.',0,0);
	$pdf->Ln(5);

	$pdf->SetFont('Arial','',12);
	
	$LinTxt  = 'Por la prestaci�n de los servicios don ';
	$LinTxt .= $Nombre;
	$LinTxt .= ', contra la presentaci�n de su boleta de honorarios percibir� de parte de la ';
	$LinTxt .= 'Sociedad de Desarrollo Tecnol�gico la suma de $ '.number_format($Total, 0, ',', '.');
	$LinTxt .= ', global de la cual se retendr� un 10% por concepto de retenci�n de impuestos a la renta.';

	if(strlen($LinTxt)<85){
		$pdf->Ln(5);
		$pdf->Cell(196,5,$LinTxt,0,0);
	}else{
		do {
			$l = strlen($LinTxt);
			if(strlen($LinTxt)>85){
				for($i=85; $i>=0; $i--){
					if(substr($LinTxt,$i,1)==" "){
						$t = substr($LinTxt,0,$i);
						break;
					}
				}
			}else{
				$t = $LinTxt;
			}
			$pdf->Ln(5);
			$pdf->Cell(196,5,$t,0,0);
			$LinTxt = substr($LinTxt,$i+1);
		} while (strlen($LinTxt)>0);
	}
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
	$LinTxt  .= 'es funcionario de la Universidad de Santiago, por lo que la prestaci�n de los servicios deber� realizarse sin interferir ni afectar las funciones que debe ejecutar en su calidad de empleado p�blico.';

	if(strlen($LinTxt)<85){
		$pdf->Ln(5);
		$pdf->Cell(196,5,$LinTxt,0,0);
	}else{
		do {
			$l = strlen($LinTxt);
			if(strlen($LinTxt)>85){
				for($i=85; $i>=0; $i--){
					if(substr($LinTxt,$i,1)==" "){
						$t = substr($LinTxt,0,$i);
						break;
					}
				}
			}else{
				$t = $LinTxt;
			}
			$pdf->Ln(5);
			$pdf->Cell(196,5,$t,0,0);
			$LinTxt = substr($LinTxt,$i+1);
		} while (strlen($LinTxt)>0);
	}
/* Fin Cuarto */	

/* Articulo Quinto */

	$pdf->SetFont('Arial','B',12);

	$pdf->Ln(8);
	$pdf->Cell(196,5,'QUINTO.',0,0);
	$pdf->Ln(5);

	$pdf->SetFont('Arial','',12);

	$LinTxt  = 'Don ';
	$LinTxt .= $Nombre;
	$LinTxt .= ', acepta que el Director del departamento de Ingenier�a Metal�rgica puede poner t�rmino a sus servicios sin expresi�n de causa, sin ';
	$LinTxt .= 'derecho a indemnizaci�n, percibiendo el prestador del servicio sus honorarios ';
	$LinTxt .= 'proporcionales al servicio otorgado a la fecha de t�rmino.';
	

	if(strlen($LinTxt)<85){
		$pdf->Ln(5);
		$pdf->Cell(196,5,$LinTxt,0,0);
	}else{
		do {
			$l = strlen($LinTxt);
			if(strlen($LinTxt)>85){
				for($i=85; $i>=0; $i--){
					if(substr($LinTxt,$i,1)==" "){
						$t = substr($LinTxt,0,$i);
						break;
					}
				}
			}else{
				$t = $LinTxt;
			}
			$pdf->Ln(5);
			$pdf->Cell(196,5,$t,0,0);
			$LinTxt = substr($LinTxt,$i+1);
		} while (strlen($LinTxt)>0);
	}
/* Fin Cuarto */	

/* Pie de Contrato */

	$pdf->SetFont('Arial','B',10);

	$pdf->Line(35, 228, 110, 228);
	$pdf->SetXY(35,233);
	//Cell(LargoMarco ,AltoMarco, Txt, VerMarco, ,Centro)
	$pdf->Cell(70,5,$NomDirector,0,0,"C");
	$pdf->SetXY(35,238);
	$pdf->Cell(70,5,"DIRECTOR UNIDAD MENOR O MAYOR",0,0,"C");

	$pdf->Line(115, 228, 190, 228);
	$pdf->SetXY(120,233);
	$pdf->Cell(70,5,$Nombre,0,0,"C");
	$pdf->SetXY(120,238);
	$pdf->Cell(70,5,"PRESTADOR DEL SERVICIO",0,0,"C");
/* Fin Cuarto */	








	}WHILE ($rowH=mysql_fetch_array($bdH));
}
mysql_close($link);

/* Imprime Contrato */
	$NombreFormulario = "Contratos.pdf";
	//$pdf->Output($NombreFormulario,'I'); //Para Imprimir Pantalla
	$pdf->Output($NombreFormulario,'D'); //Para Descarga
	//$pdf->Output($NombreFormulario,'F');

?>
