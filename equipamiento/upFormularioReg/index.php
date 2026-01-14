<?php
	session_start(); 
	
	include_once("../../conexionli.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']		= $rowPer['Perfil'];
			$_SESSION['IdPerfil']	= $rowPer['IdPerfil'];
		}
		$link->close();
	}else{
		header("Location: ../index.php");
	}
	$codigo 						= 0;
	$nDocGes 						= '';
	
	
/*
	if($_SESSION[Perfil] != 'WebMaster'){
		header("Location: ../enConstruccion.php");
	}
*/
	$usuario 		= $_SESSION['usuario'];
	
	if(isset($_GET['codigo']))				{ $codigo				= $_GET['codigo']; 				}
	if(isset($_GET['nDocGes']))				{ $nDocGes				= $_GET['nDocGes']; 			}
	if(isset($_GET['FormularioCal']))		{ $FormularioCal		= $_GET['FormularioCal']; 		}
	if(isset($_GET['FormularioVer']))		{ $FormularioVer		= $_GET['FormularioVer']; 		}
	if(isset($_GET['FormularioMan']))		{ $FormularioMan		= $_GET['FormularioMan']; 		}
	if(isset($_GET['AccionEquipo']))		{ $AccionEquipo			= $_GET['AccionEquipo']; 		}

	if(isset($_POST['codigo']))				{ $codigo				= $_POST['codigo']; 			}
	if(isset($_POST['nDocGes']))			{ $nDocGes				= $_POST['nDocGes']; 			}
	if(isset($_POST['FormularioCal']))		{ $FormularioCal		= $_POST['FormularioCal']; 		}
	if(isset($_POST['FormularioVer']))		{ $FormularioVer		= $_POST['FormularioVer']; 		}
	if(isset($_POST['FormularioMan']))		{ $FormularioMan		= $_POST['FormularioMan']; 		}
	if(isset($_POST['AccionEquipo']))		{ $AccionEquipo			= $_POST['AccionEquipo']; 		}

	$nomEquipo 	= '';

	if(isset($_POST['guardarSeguimiento'])){
		if(isset($_POST['codigo']))				{ $codigo			= $_POST['codigo']; 			}
		if(isset($_POST['realizadaCal']))		{ $realizadaCal 	= $_POST['realizadaCal'];		}
		if(isset($_POST['fechaAccionCal']))		{ $fechaAccionCal	= $_POST['fechaAccionCal'];		}
		if(isset($_POST['registradaCal']))		{ $registradaCal	= $_POST['registradaCal'];		}
		if(isset($_POST['fechaRegCal']))		{ $fechaRegCal		= $_POST['fechaRegCal'];		}

		if(isset($_POST['realizadaVer']))		{ $realizadaVer 	= $_POST['realizadaVer'];		}
		if(isset($_POST['fechaAccionVer']))		{ $fechaAccionVer	= $_POST['fechaAccionVer'];		}
		if(isset($_POST['registradaVer']))		{ $registradaVer	= $_POST['registradaVer'];		}
		if(isset($_POST['fechaRegVer']))		{ $fechaRegVer		= $_POST['fechaRegVer'];		}

		if(isset($_POST['realizadaMan']))		{ $realizadaMan 	= $_POST['realizadaMan'];		}
		if(isset($_POST['fechaAccionMan']))		{ $fechaAccionMan	= $_POST['fechaAccionMan'];		}
		if(isset($_POST['registradaMan']))		{ $registradaMan	= $_POST['registradaMan'];		}
		if(isset($_POST['fechaRegMan']))		{ $fechaRegMan		= $_POST['fechaRegMan'];		}

		$link=Conectarse();
		$bdCot=$link->query("Select * From equipos Where nSerie = '".$nSerie."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$usrResponsable 	= $rowCot['usrResponsable'];
			$fechaTentativaCal 	= $rowCot['fechaProxCal'];
			$fechaTentativaVer 	= $rowCot['fechaProxVer'];
			$fechaTentativaMan 	= $rowCot['fechaProxMan'];
			
			if($realizadaCal=='on'){
				$tpoProxCal 	= $rowCot['tpoProxCal'];
				$fechaProxCal 	= strtotime ( '+'.$tpoProxCal.' day' , strtotime ( $fechaAccionCal ) );
				$fechaProxCal 	= date ( 'Y-m-d' , $fechaProxCal );
			}
			$actSQL="UPDATE equipos SET ";
			$actSQL.="realizadaCal		='".$realizadaCal.	"',";
			$actSQL.="fechaAccionCal	='".$fechaAccionCal."',";
			$actSQL.="registradaCal		='".$registradaCal.	"',";
			$actSQL.="fechaRegCal		='".$fechaRegCal.	"',";

			if($realizadaCal=='on'){
				$actSQL.="fechaCal		='".$fechaAccionCal	."',";
				$actSQL.="fechaProxCal	='".$fechaProxCal	."',";
			}

			if($realizadaVer=='on'){
				$tpoProxVer 	= $rowCot['tpoProxVer'];
				$fechaProxVer 	= strtotime ( '+'.$tpoProxVer.' day' , strtotime ( $fechaAccionVer ) );
				$fechaProxVer 	= date ( 'Y-m-d' , $fechaProxVer );
			}
			$actSQL.="realizadaVer		='".$realizadaVer.	"',";
			$actSQL.="fechaAccionVer	='".$fechaAccionVer."',";
			$actSQL.="registradaVer		='".$registradaVer.	"',";
			$actSQL.="fechaRegVer		='".$fechaRegVer.	"',";


			if($realizadaVer=='on'){
				$actSQL.="fechaVer		='".$fechaAccionVer	."',";
				$actSQL.="fechaProxVer	='".$fechaProxVer	."',";
			}
			if($realizadaMan=='on'){
				$tpoProxMan 	= $rowCot['tpoProxMan'];
				$fechaProxMan 	= strtotime ( '+'.$tpoProxMan.' day' , strtotime ( $fechaAccionMan ) );
				$fechaProxMan 	= date ( 'Y-m-d' , $fechaProxMan );
			}
			if($realizadaMan=='on'){
				$actSQL.="fechaMan		='".$fechaAccionMan	."',";
				$actSQL.="fechaProxMan	='".$fechaProxMan	."',";
			}
			$actSQL.="realizadaMan		='".$realizadaMan.	"',";
			$actSQL.="fechaAccionMan	='".$fechaAccionMan."',";
			$actSQL.="registradaMan		='".$registradaMan.	"',";
			$actSQL.="fechaRegMan		='".$fechaRegMan.	"'";

			$actSQL.="WHERE 	nSerie	= '".$nSerie."'";
			$bdCot=$link->query($actSQL);

			if($fechaRegCal > '000-00-00'){
				$Accion = 'Cal';
				$bdHis=$link->query("Select * From equiposHistorial Where nSerie = '".$nSerie."' and fechaTentativa = '".$fechaTentativaCal."' and Accion = '".$Accion."'");
				if($rowHis=mysqli_fetch_array($bdHis)){

				}else{
					$link->query("insert into equiposHistorial(	
																nSerie,
																fechaTentativa,
																fechaAccion,
																Accion,
																fechaRegistro,
																usrResponsable
																) 
													values 	(	
																'$nSerie',
																'$fechaTentativaCal',
																'$fechaAccionCal',
																'$Accion',
																'$fechaRegCal',
																'$usrResponsable'
						)");
				}
			}

			if($fechaRegVer > '000-00-00'){
				$Accion = 'Ver';
				$bdHis=$link->query("Select * From equiposHistorial Where nSerie = '".$nSerie."' and fechaTentativa = '".$fechaTentativaVer."' and Accion = '".$Accion."'");
				if($rowHis=mysqli_fetch_array($bdHis)){

				}else{
					$link->query("insert into equiposHistorial(	
																nSerie,
																fechaTentativa,
																fechaAccion,
																Accion,
																fechaRegistro,
																usrResponsable
																) 
													values 	(	
																'$nSerie',
																'$fechaTentativaVer',
																'$fechaAccionVer',
																'$Accion',
																'$fechaRegVer',
																'$usrResponsable'
						)");
				}
			}
			
			if($fechaRegMan > '000-00-00'){
				$Accion = 'Man';
				$bdHis=$link->query("Select * From equiposHistorial Where nSerie = '".$nSerie."' and fechaTentativa = '".$fechaTentativaMan."' and Accion = '".$Accion."'");
				if($rowHis=mysqli_fetch_array($bdHis)){

				}else{
					$link->query("insert into equiposHistorial(	
																nSerie,
																fechaTentativa,
																fechaAccion,
																Accion,
																fechaRegistro,
																usrResponsable
																) 
													values 	(	
																'$nSerie',
																'$fechaTentativaMan',
																'$fechaAccionMan',
																'$Accion',
																'$fechaRegMan',
																'$usrResponsable'
						)");
				}
			}
			
		}
		$link->close();
		$nSerie	= '';
		$accion	= '';
	}
	
	if(isset($_POST['guardarEquipo'])){
		$Acreditado = '';
		
		if(isset($_POST['nSerie'])) 		{ $nSerie 			= $_POST['nSerie'];			}
		if(isset($_POST['nomEquipo'])) 		{ $nomEquipo 		= $_POST['nomEquipo'];		}
		if(isset($_POST['lugar'])) 			{ $lugar	 		= $_POST['lugar'];			}
		if(isset($_POST['tipoEquipo'])) 	{ $tipoEquipo		= $_POST['tipoEquipo'];		}
		if(isset($_POST['Acreditado'])) 	{ $Acreditado		= $_POST['Acreditado'];		}

		if(isset($_POST['necesitaCal']))	{ $necesitaCal 		= $_POST['necesitaCal'];	}
		if(isset($_POST['fechaCal'])) 		{ $fechaCal	 		= $_POST['fechaCal'];		}
		if(isset($_POST['tpoProxCal'])) 	{ $tpoProxCal	 	= $_POST['tpoProxCal'];		}
		if(isset($_POST['tpoAvisoCal']))	{ $tpoAvisoCal		= $_POST['tpoAvisoCal'];	}
		if(isset($_POST['fechaProxCal'])) 	{ $fechaProxCal		= $_POST['fechaProxCal'];	}

		if(isset($_POST['necesitaVer'])) 	{ $necesitaVer 		= $_POST['necesitaVer'];	}
		if(isset($_POST['fechaVer'])) 		{ $fechaVer	 		= $_POST['fechaVer'];		}
		if(isset($_POST['tpoProxVer'])) 	{ $tpoProxVer	 	= $_POST['tpoProxVer'];		}
		if(isset($_POST['tpoAvisoVer'])) 	{ $tpoAvisoVer		= $_POST['tpoAvisoVer'];	}
		if(isset($_POST['fechaProxVer'])) 	{ $fechaProxVer		= $_POST['fechaProxVer'];	}
		
		if(isset($_POST['necesitaMan'])) 	{ $necesitaMan 		= $_POST['necesitaMan'];	}
		if(isset($_POST['fechaMan'])) 		{ $fechaMan	 		= $_POST['fechaMan'];		}
		if(isset($_POST['tpoProxMan'])) 	{ $tpoProxMan	 	= $_POST['tpoProxMan'];		}
		if(isset($_POST['tpoAvisoMan'])) 	{ $tpoAvisoMan		= $_POST['tpoAvisoMan'];	}
		if(isset($_POST['fechaProxMan'])) 	{ $fechaProxMan		= $_POST['fechaProxMan'];	}
		
		if(isset($_POST['usrResponsable'])) { $usrResponsable	= $_POST['usrResponsable'];	}

		$link=Conectarse();
		$bdCot=$link->query("Select * From equipos Where nSerie = '".$nSerie."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$actSQL="UPDATE equipos SET ";
			$actSQL.="nomEquipo			='".$nomEquipo.		"',";
			$actSQL.="lugar				='".$lugar.			"',";
			$actSQL.="tipoEquipo		='".$tipoEquipo.	"',";
			$actSQL.="Acreditado		='".$Acreditado.	"',";
			$actSQL.="necesitaCal		='".$necesitaCal.	"',";
			$actSQL.="fechaCal			='".$fechaCal.		"',";
			$actSQL.="tpoProxCal		='".$tpoProxCal.	"',";
			$actSQL.="tpoAvisoCal		='".$tpoAvisoCal.	"',";
			$actSQL.="fechaProxCal		='".$fechaProxCal.	"',";
			$actSQL.="necesitaVer		='".$necesitaVer.	"',";
			$actSQL.="fechaVer			='".$fechaVer.		"',";
			$actSQL.="tpoProxVer		='".$tpoProxVer.	"',";
			$actSQL.="tpoAvisoVer		='".$tpoAvisoVer.	"',";
			$actSQL.="fechaProxVer		='".$fechaProxVer.	"',";
			$actSQL.="necesitaMan		='".$necesitaMan.	"',";
			$actSQL.="fechaMan			='".$fechaMan.		"',";
			$actSQL.="tpoProxMan		='".$tpoProxMan.	"',";
			$actSQL.="tpoAvisoMan		='".$tpoAvisoMan.	"',";
			$actSQL.="fechaProxMan		='".$fechaProxMan.	"',";
			$actSQL.="usrResponsable	='".$usrResponsable."'";
			$actSQL.="WHERE 	nSerie	= '".$nSerie."'";
			$bdCot=$link->query($actSQL);
		}else{
			$link->query("insert into equipos(	
															nSerie,
															nomEquipo,
															lugar,
															tipoEquipo,
															Acreditado,
															necesitaCal,
															fechaCal,
															tpoProxCal,
															tpoAvisoCal,
															fechaProxCal,
															necesitaVer,
															fechaVer,
															tpoProxVer,
															tpoAvisoVer,
															fechaProxVer,
															necesitaMan,
															fechaMan,
															tpoProxMan,
															tpoAvisoMan,
															fechaProxMan,
															usrResponsable
															) 
												values 	(	
															'$nSerie',
															'$nomEquipo',
															'$lugar',
															'$tipoEquipo',
															'$Acreditado',
															'$necesitaCal',
															'$fechaCal',
															'$tpoProxCal',
															'$tpoAvisoCal',
															'$fechaProxCal',
															'$necesitaVer',
															'$fechaVer',
															'$tpoProxVer',
															'$tpoAvisoVer',
															'$fechaProxVer',
															'$necesitaMan',
															'$fechaMa',
															'$tpoProxMan',
															'$tpoAvisoMan',
															'$fechaProxMan',
															'$usrResponsable'
					)");
		}
		$link->close();
		$nSerie	= '';
		$accion	= '';
	}

	$SQL = "Select * From equipos Where nSerie = '$nDocGes'";
	$link=Conectarse();
	$bdEq=$link->query($SQL);
	if($rowEq=mysqli_fetch_array($bdEq)){
		//$nSerie = $rowdCot['nSerie'];
		$nomEquipo 		= $rowEq['nomEquipo'];
		$usrResponsable = $rowEq['usrResponsable'];
		$FormularioCal  = $rowEq['FormularioCal'];
		$FormularioVer  = $rowEq['FormularioVer'];
		$FormularioMan  = $rowEq['FormularioMan'];
		$codigo			= $rowEq['codigo'];
	}

	if(isset($_POST['upFormularios'])){
		$fechaRegistro = date('Y-m-d');
		/* Documento PDF MANTENCION DE EQUIPOS listo */

		$sql = "SELECT * FROM equiposForm Where nSerie = '".$nDocGes."' and AccionEquipo = 'Cal'";
		$bdEnc=$link->query($sql);
		if($row=mysqli_fetch_array($bdEnc)){
			do{
				$nForm = 'FCal'.$row['Formulario'];
				if(isset($_FILES[$nForm]['name'])){
					$nombre_pdf 	= $_FILES[$nForm]['name'];
					$tipo_pdf 		= $_FILES[$nForm]['type'];
					$tamano_pdf 	= $_FILES[$nForm]['size'];
					$desde_pdf		= $_FILES[$nForm]['tmp_name'];
					if($nombre_pdf){
						$host = gethostname();

						$sqlPOC = "SELECT * FROM equipos Where nSerie = '".$row['nSerie']."'";
						$bdPOC=$link->query($sqlPOC);
						if($rowPOC=mysqli_fetch_array($bdPOC)){
							$directorioPOC='../../archivo/';
							$directorioPOC=$directorioPOC.$rowPOC['Referencia'].'/Registros/';
							$directorioAAA='y:/AAA/Documentos/'.$rowPOC['Referencia'].'/Registros/';
							if(!file_exists($directorioPOC)){
								mkdir($directorioPOC);
							}

							if($tipo_pdf == "application/pdf" or $tipo_pdf == "application/vnd.openxmlformats-officedocument.wordprocessingml.document" or $tipo_pdf == "application/msword") {
								if($tipo_pdf == "application/pdf") {
									$newpdf = 'Cal-'.$row['nSerie'].'-'.$row['Formulario'].'-'.date('Y-m-d').'.pdf';
								}
								if($tipo_pdf == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
									$newpdf = 'Cal-'.$row['nSerie'].'-'.$row['Formulario'].'-'.date('Y-m-d').'.docx';
								}
								if($tipo_pdf == "application/msword") {
									$newpdf = 'Cal-'.$row['nSerie'].'-'.$row['Formulario'].'-'.date('Y-m-d').'.doc';
								}
								if(move_uploaded_file($desde_pdf, $directorioPOC."/".$newpdf)){ 
								
									if(copy($directorioPOC."/".$newpdf, $directorioAAA."/".$newpdf)){
										echo ' Copiado ...'.$directorioAAA;
									}; 
									$txtPDF = 'Documento $newPdf Subido...';
									$AccionEquipo = 'Cal';
									$Formulario = $row['Formulario'];

									$sqlEQ = "SELECT * FROM equipos Where nSerie = '".$nDocGes."'";
									$bdEQ=$link->query($sqlEQ);
									if($rowEQ=mysqli_fetch_array($bdEQ)){
										$fechaCal 		= $rowEQ['fechaCal'];
										$fechaTentativa = $rowEQ['fechaProxCal'];
										$fechaAccion	= date('Y-m-d');

										$tpoProxCal 	= $rowEQ['tpoProxCal'];
										$fechaAccionCal	= $fechaAccion;
										$fechaProxCal 	= strtotime ( '+'.$tpoProxCal.' day' , strtotime ( $fechaAccionCal ) );
										$fechaProxCal 	= date ( 'Y-m-d' , $fechaProxCal );
										
										$fechaCal		= $fechaAccion;
										
										$actSQL="UPDATE equipos SET ";
										$actSQL.="fechaCal			='".$fechaCal.		"',";
										$actSQL.="fechaAccionCal	='".$fechaAccionCal."',";
										$actSQL.="fechaProxCal		='".$fechaProxCal.	"'";
										$actSQL.="WHERE 	nSerie	= '".$nDocGes.		"'";
										$bdCot=$link->query($actSQL);
										
										$sqlEQH = "SELECT * FROM equiposHistorial Where nSerie = '".$nDocGes."' and Accion = 'Cal' and Formulario = '".$row['Formulario']."'";
										$bdEQH=$link->query($sqlEQH);
										if($rowEQH=mysqli_fetch_array($bdEQH)){
											$actSQL="UPDATE equiposHistorial SET ";
											$actSQL.="nSerie			='".$nDocGes.		"',";
											$actSQL.="Accion			='".$AccionEquipo.	"',";
											$actSQL.="fechaTentativa	='".$fechaTentativa."',";
											$actSQL.="fechaAccion		='".$fechaAccion.	"',";
											$actSQL.="pdf				='".$newpdf.		"',";
											$actSQL.="Formulario		='".$Formulario.	"'";
											$actSQL.="WHERE 	nSerie	= '".$nDocGes."' and Accion = 'Cal'";
											$bdCot=$link->query($actSQL);
										}else{
											$link->query("insert into equiposHistorial(	
																							codigo,
																							nSerie,
																							fechaTentativa,
																							fechaAccion,
																							Accion,
																							Formulario,
																							fechaRegistro,
																							usrResponsable,
																							pdf
																							) 
																			values 	(	
																							'$codigo',
																							'$nDocGes',
																							'$fechaTentativa',
																							'$fechaAccion',
																							'$AccionEquipo',
																							'$Formulario',
																							'$fechaRegistro',
																							'$usrResponsable',
																							'$newpdf'
																			)"
														);
										}
									}
								}
							}
						}
					}
				}
				//echo $row['Formulario'];
			}while ($row=mysqli_fetch_array($bdEnc));
		}

		
		
/* Verificacion */
		$sql = "SELECT * FROM equiposForm Where nSerie = '".$nDocGes."' and AccionEquipo = 'Ver'";
		$bdEnc=$link->query($sql);
		if($row=mysqli_fetch_array($bdEnc)){
			do{
				$nForm = 'FVer'.$row['Formulario'];
				if(isset($_FILES[$nForm]['name'])){
					$nombre_pdf 	= $_FILES[$nForm]['name'];
					$tipo_pdf 		= $_FILES[$nForm]['type'];
					$tamano_pdf 	= $_FILES[$nForm]['size'];
					$desde_pdf		= $_FILES[$nForm]['tmp_name'];
					
					if($nombre_pdf){
						$host = gethostname();

						$directorioPOC='../../archivo/';
						$sqlPOC = "SELECT * FROM equipos Where nSerie = '".$row['nSerie']."'";
						$bdPOC=$link->query($sqlPOC);
						if($rowPOC=mysqli_fetch_array($bdPOC)){
							
							$directorioPOC=$directorioPOC.$rowPOC['Referencia'].'/Registros/';
							$directorioAAA='y:/AAA/Documentos/'.$rowPOC['Referencia'].'/Registros/';
							if(!file_exists($directorioPOC)){
								mkdir($directorioPOC);
							}
							if($tipo_pdf == "application/pdf" or $tipo_pdf == "application/vnd.openxmlformats-officedocument.wordprocessingml.document" or $tipo_pdf == "application/msword") {
								if($tipo_pdf == "application/pdf") {
									$newpdf = 'Ver-'.$row['nSerie'].'-'.$row['Formulario'].'-'.date('Y-m-d').'.pdf';
								}
								if($tipo_pdf == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
									$newpdf = 'Ver-'.$row['nSerie'].'-'.$row['Formulario'].'-'.date('Y-m-d').'.docx';
								}
								if($tipo_pdf == "application/msword") {
									$newpdf = 'Ver-'.$row['nSerie'].'-'.$row['Formulario'].'-'.date('Y-m-d').'.doc';
								}
								if(move_uploaded_file($desde_pdf, $directorioPOC."/".$newpdf)){ 
								
									if(copy($directorioPOC."/".$newpdf, $directorioAAA."/".$newpdf)){
										echo ' Copiado ...'.$directorioAAA;
									}; 
									$txtPDF = 'Documento $newPdf Subido...';
									$AccionEquipo = 'Ver';
									$Formulario = $row['Formulario'];

									$sqlEQ = "SELECT * FROM equipos Where nSerie = '".$nDocGes."'";
									$bdEQ=$link->query($sqlEQ);
									if($rowEQ=mysqli_fetch_array($bdEQ)){
										$fechaVer 		= $rowEQ['fechaVer'];
										$fechaTentativa = $rowEQ['fechaProxVer'];
										$fechaAccion	= date('Y-m-d');

										$tpoProxVer 	= $rowEQ['tpoProxVer'];
										$fechaAccionVer	= $fechaAccion;
										$fechaProxVer 	= strtotime ( '+'.$tpoProxVer.' day' , strtotime ( $fechaAccionVer ) );
										$fechaProxVer 	= date ( 'Y-m-d' , $fechaProxVer );
										
										$fechaVer		= $fechaAccion;
										
										$actSQL="UPDATE equipos SET ";
										$actSQL.="fechaVer			='".$fechaVer.		"',";
										$actSQL.="fechaAccionVer	='".$fechaAccionVer."',";
										$actSQL.="fechaProxVer		='".$fechaProxVer.	"'";
										$actSQL.="WHERE 	nSerie	= '".$nDocGes.		"'";
										$bdCot=$link->query($actSQL);
										
										$sqlEQH = "SELECT * FROM equiposHistorial Where nSerie = '".$nDocGes."' and Accion = 'Ver' and Formulario = '".$row['Formulario']."'";
										$bdEQH=$link->query($sqlEQH);
										if($rowEQH=mysqli_fetch_array($bdEQH)){
											$actSQL="UPDATE equiposHistorial SET ";
											$actSQL.="nSerie			='".$nDocGes.		"',";
											$actSQL.="Accion			='".$AccionEquipo.	"',";
											$actSQL.="fechaTentativa	='".$fechaTentativa."',";
											$actSQL.="fechaAccion		='".$fechaAccion.	"',";
											$actSQL.="pdf				='".$newpdf.		"',";
											$actSQL.="Formulario		='".$Formulario.	"'";
											$actSQL.="WHERE 	nSerie	= '".$nDocGes."' and Accion = 'Ver'";
											$bdCot=$link->query($actSQL);
										}else{
											$link->query("insert into equiposHistorial(	
																							codigo,
																							nSerie,
																							fechaTentativa,
																							fechaAccion,
																							Accion,
																							Formulario,
																							fechaRegistro,
																							usrResponsable,
																							pdf
																							) 
																			values 	(	
																							'$codigo',
																							'$nDocGes',
																							'$fechaTentativa',
																							'$fechaAccion',
																							'$AccionEquipo',
																							'$Formulario',
																							'$fechaRegistro',
																							'$usrResponsable',
																							'$newpdf'
																			)"
														);
										}
									}
								}
							}
						}else{
							/*
							$link->query("insert into docformdoc(	
																	Formulario,
																	fechaRegistro,
																	usrResponsable,
																	pdf
																) 
														values 	(	
																	'$Formulario',
																	'$fechaRegistro',
																	'$usrResponsable',
																	'$newpdf'
																)"
														);
							*/
						}
					}
				}
				//echo $row['Formulario'];
			}while ($row=mysqli_fetch_array($bdEnc));
		}
/* Fin Verificacion */

/* MAntencion */
		$sql = "SELECT * FROM equiposForm Where nSerie = '".$nDocGes."' and AccionEquipo = 'Man'";
		$bdEnc=$link->query($sql);
		if($row=mysqli_fetch_array($bdEnc)){
			do{
				$nForm = 'FMan'.$row['Formulario'];
				if(isset($_FILES[$nForm]['name'])){
					$nombre_pdf 	= $_FILES[$nForm]['name'];
					$tipo_pdf 		= $_FILES[$nForm]['type'];
					$tamano_pdf 	= $_FILES[$nForm]['size'];
					$desde_pdf		= $_FILES[$nForm]['tmp_name'];
					if($nombre_pdf){
						$sqlPOC = "SELECT * FROM equipos Where nSerie = '".$row['nSerie']."'";
						$bdPOC=$link->query($sqlPOC);
						if($rowPOC=mysqli_fetch_array($bdPOC)){
							
							$directorioPOC='../../archivo/';
							$directorioPOC=$directorioPOC.$rowPOC['Referencia'].'/Registros/';
							$directorioAAA='y:/AAA/Documentos/'.$rowPOC['Referencia'].'/Registros/';
							if(!file_exists($directorioPOC)){
								mkdir($directorioPOC);
							}
							if($tipo_pdf == "application/pdf" or $tipo_pdf == "application/vnd.openxmlformats-officedocument.wordprocessingml.document" or $tipo_pdf == "application/msword") {
								if($tipo_pdf == "application/pdf") {
									$newpdf = 'Man-'.$row['nSerie'].'-'.$row['Formulario'].'-'.date('Y-m-d').'.pdf';
								}
								if($tipo_pdf == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
									$newpdf = 'Man-'.$row['nSerie'].'-'.$row['Formulario'].'-'.date('Y-m-d').'.docx';
								}
								if($tipo_pdf == "application/msword") {
									$newpdf = 'Man-'.$row['nSerie'].'-'.$row['Formulario'].'-'.date('Y-m-d').'.doc';
								}
								if(move_uploaded_file($desde_pdf, $directorioPOC."/".$newpdf)){ 
								
									if(copy($directorioPOC."/".$newpdf, $directorioAAA."/".$newpdf)){
										echo ' Copiado ...'.$directorioAAA;
									}; 
									$txtPDF = 'Documento $newPdf Subido...';
									$AccionEquipo = 'Man';
									$Formulario = $row['Formulario'];

									$sqlEQ = "SELECT * FROM equipos Where nSerie = '".$nDocGes."'";
									$bdEQ=$link->query($sqlEQ);
									if($rowEQ=mysqli_fetch_array($bdEQ)){
										$fechaMan 		= $rowEQ['fechaMan'];
										$fechaTentativa = $rowEQ['fechaProxMan'];
										$fechaAccion	= date('Y-m-d');

										$tpoProxMan 	= $rowEQ['tpoProxMan'];
										$fechaAccionMan	= $fechaAccion;
										$fechaProxMan 	= strtotime ( '+'.$tpoProxMan.' day' , strtotime ( $fechaAccionMan ) );
										$fechaProxMan 	= date ( 'Y-m-d' , $fechaProxMan );
										
										$fechaMan		= $fechaAccion;
										
										$actSQL="UPDATE equipos SET ";
										$actSQL.="fechaMan			='".$fechaMan.		"',";
										$actSQL.="fechaAccionMan	='".$fechaAccionMan."',";
										$actSQL.="fechaProxMan		='".$fechaProxMan.	"'";
										$actSQL.="WHERE 	nSerie	= '".$nDocGes.		"'";
										$bdCot=$link->query($actSQL);
										
										$sqlEQH = "SELECT * FROM equiposHistorial Where nSerie = '".$nDocGes."' and Accion = 'Man' and Formulario = '".$row['Formulario']."'";
										$bdEQH=$link->query($sqlEQH);
										if($rowEQH=mysqli_fetch_array($bdEQH)){
											$actSQL="UPDATE equiposHistorial SET ";
											$actSQL.="nSerie			='".$nDocGes.		"',";
											$actSQL.="Accion			='".$AccionEquipo.	"',";
											$actSQL.="fechaTentativa	='".$fechaTentativa."',";
											$actSQL.="fechaAccion		='".$fechaAccion.	"',";
											$actSQL.="pdf				='".$newpdf.		"',";
											$actSQL.="Formulario		='".$Formulario.	"'";
											$actSQL.="WHERE 	nSerie	= '".$nDocGes."' and Accion = 'Man'";
											$bdCot=$link->query($actSQL);
										}else{
											$link->query("insert into equiposHistorial(	
																							codigo,
																							nSerie,
																							fechaTentativa,
																							fechaAccion,
																							Accion,
																							Formulario,
																							fechaRegistro,
																							usrResponsable,
																							pdf
																							) 
																			values 	(	
																							'$codigo',
																							'$nDocGes',
																							'$fechaTentativa',
																							'$fechaAccion',
																							'$AccionEquipo',
																							'$Formulario',
																							'$fechaRegistro',
																							'$usrResponsable',
																							'$newpdf'
																			)"
														);
										}
									}
								}
							}
						}
					}
				}
				//echo $row['Formulario'];
			}while ($row=mysqli_fetch_array($bdEnc));
		}
/* Fin Mantencion */
		
		
	}

	$link->close();

?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Intranet Simet -> Subir Registro</title>
	
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	
	<script src="../../jquery/jquery-1.6.4.js"></script>
	<link rel="stylesheet" type="text/css" href="../../cssboot/bootstrap.min.css">

	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../../css/tpv.css" rel="stylesheet" type="text/css">


</head>

<body>
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<img src="../../imagenes/equipamiento.png" width="40" height="40" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Arial; font-size:14px; ">
					Subir Registro Equipo <?php echo $nomEquipo; ?> 
				</strong>

				<div id="ImagenBarra">
					<a href="cerrarsesion.php" title="Cerrar Sesión">
						<img src="../../gastos/imagenes/preview_exit_32.png" width="32" height="32">
					</a>
				</div>
			</div>

			<form name="form" action="index.php" method="post" enctype="multipart/form-data">

				<div id="BarraOpciones">
					<div id="ImagenBarraLeft">
						<a href="../../plataformaErp.php" title="Menú Principal">
							<img src="../../gastos/imagenes/Menu.png"><br> 
						</a>
						Principal
					</div>
					<div id="ImagenBarraLeft" title="Procesos">
						<a href="../plataformaEquipos.php" title="Equipos"">
							<img src="../../imagenes/equipamiento.png"><br>
						</a>
						Equipos
					</div>
					<div id="ImagenBarraLeft" title="Subir Formularios">
						<button name="upFormularios">
							<img src="../../imagenes/upload2.png"><br>
							Up REG.
						</button>
					</div>
				</div>
				
				<?php include_once('regFormularios.php'); ?>
			
			</form>
		</div>
		<div style="clear:both;"></div>
				
	</div>
	<br>
	<script src="../../jsboot/bootstrap.min.js"></script>	
	
	
</body>
</html>
