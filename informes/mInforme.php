<?php
	session_start();
	$_SESSION['Grabado'] = "NO";
	date_default_timezone_set("America/Santiago");
	$MsgUsr ="";	
	include_once("../conexionli.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		$link->close();
	}else{
		header("Location: ../index.php");
	}

	$CodigoVerificacion = '';
	$Detalle			= '';
	$CodInforme 		= '';
	$accion				= '';
	$informePDF			= '';
	$Estado				= '';
	$CodigoVerificacion	= '';
	$IdProyecto			= '';
	$Situacion 			= '';
	$RutCli				= '';
	$nomCliente			= '';
	$fechaInforme 		= date('Y-m-d');

	if(isset($_GET['accion']))		{ $accion 		= $_GET['accion']; 		}
	if(isset($_GET['CodInforme']))	{ $CodInforme   = $_GET['CodInforme'];	}
	if(isset($_GET['IdInforme']))	{ $IdInforme   	= $_GET['IdInforme'];	}
	if(isset($_GET['RutCli']))		{ $RutCli   	= $_GET['RutCli'];		}
	if(isset($_GET['nomCliente']))	{ $nomCliente   = $_GET['nomCliente'];		}

	if(isset($_GET['Situacion']))	{ $Situacion   	= $_GET['Situacion'];	}
	if(isset($_GET['informePDF']))	{ $informePDF   = $_GET['informePDF'];	}

	if(isset($_POST['accion'])) 	{ $accion 		= $_POST['accion']; 	}
	if(isset($_POST['CodInforme']))	{ $CodInforme   = $_POST['CodInforme'];	}
	if(isset($_POST['IdInforme']))  { $IdInforme   	= $_POST['IdInforme'];	}
	if(isset($_POST['RutCli']))  	{ $RutCli   	= $_POST['RutCli'];		}
	if(isset($_POST['nomCliente'])) { $nomCliente   = $_POST['nomCliente'];	}

	echo $Situacion;
	if($Situacion) {
		echo 'Entra...';
		$link=Conectarse();
		$bdInf=$link->query("SELECT * FROM Informes WHERE CodInforme = '".$CodInforme."'");
		if($rowInf=mysqli_fetch_array($bdInf)){
			$fechaUp 	= date('Y-m-d');
			$Estado		= 2;
			$actSQL="UPDATE Informes SET ";
			$actSQL.="informePDF		= '".$informePDF.	"',";
			$actSQL.="Estado			= '".$Estado.		"',";
			$actSQL.="fechaUp			='".$fechaUp.		"'";
			$actSQL.="WHERE CodInforme 	= '".$CodInforme."'";
			$bdCot=$link->query($actSQL);
			
			$CodInf	 		= substr($CodInforme,0,7);
			$RAM	 		= substr($CodInforme,3,4);
			$rr				= explode('-', $CodInforme);
			$RAM			= $rr[1];
			$infoNumero 	= 0;
			$infoSubidos 	= 0;
			
			$bdInfN=$link->query("SELECT * FROM Informes Where CodInforme Like '%".$RAM."%'");
			if($rowInfN=mysqli_fetch_array($bdInfN)){
				do{
					$infoNumero++;
					if($rowInfN['informePDF']){
						$infoSubidos++;
					}
				}while ($rowInfN=mysqli_fetch_array($bdInfN));
			}

			$fechaInformeUP = '0000-00-00';
			$informeUP 		= '';
			if($infoNumero == $infoSubidos){
				$fechaInformeUP = date('Y-m-d');
				$informeUP 		= 'on';
			}
			$bdCot=$link->query("SELECT * FROM Cotizaciones WHERE RAM = '".$RAM."'");
			if($rowCot=mysqli_fetch_array($bdCot)){
				$actSQL="UPDATE Cotizaciones SET ";
				$actSQL.="fechaInformeUP	= '".$fechaInformeUP.	"',";
				$actSQL.="informeUP			= '".$informeUP.		"',";
				$actSQL.="infoNumero		= '".$infoNumero.		"',";
				$actSQL.="infoSubidos		= '".$infoSubidos.		"'";
				$actSQL.="WHERE RAM 		= '".$RAM."'";
				$bdCot=$link->query($actSQL);
			}
		}
		$link->close();
	}
	if(isset($_POST['Generar'])) {
		$CodigoVerificacion   	= $_POST['CodigoVerificacion'];		

		$i=0; 
		$password=""; 
		$pw_largo = 12; 
		$desde_ascii = 50; // "2" 
		$hasta_ascii = 122; // "z" 
		$no_usar = array (58,59,60,61,62,63,64,73,79,91,92,93,94,95,96,108,111); 
		while ($i < $pw_largo) { 
			mt_srand ((double)microtime() * 1000000); 
			$numero_aleat = mt_rand ($desde_ascii, $hasta_ascii); 
			if (!in_array ($numero_aleat, $no_usar)) { 
				$password = $password . chr($numero_aleat); 
				$i++; 
			} 
		}
		$CodigoVerificacion = $password;
	}

	if(isset($_POST['subirGuardarInforme'])){
		$nombre_archivo = $_FILES['Informe']['name'];
		$tipo_archivo 	= $_FILES['Informe']['type'];
		$tamano_archivo = $_FILES['Informe']['size'];
		$desde 			= $_FILES['Informe']['tmp_name'];

		$directorio="../../intranet/informes";
		$fichero="../../intranet/informes/".$nombre_archivo;
/*
		$directorio="informes";
*/
		if(!file_exists($directorio)){
			mkdir($directorio,0755);
		}
		if($nombre_archivo){
			if ($tipo_archivo == "application/pdf" and $tamano_archivo <= 20480000) {
				if(file_exists($fichero)){
					unlink($fichero);
				}
				if(move_uploaded_file($desde, $directorio."/".$nombre_archivo)){ 
					$MsgUsr="El Informe ".$nombre_archivo." ha sido cargado correctamente....";
					$link=Conectarse();
					$bdInf=$link->query("SELECT * FROM Informes WHERE CodInforme = '".$CodInforme."'");
					if ($rowInf=mysqli_fetch_array($bdInf)){
						$fechaUp = date('Y-m-d');
						$actSQL="UPDATE Informes SET ";
						$actSQL.="informePDF		= '".$nombre_archivo."',";
						$actSQL.="fechaUp			='".$fechaUp."'";
						$actSQL.="WHERE CodInforme 	= '".$CodInforme."'";
						$bdInf=$link->query($actSQL);
					}
					$link->close();
					chmod($directorio.'/'.$nombre_archivo, 0400);
					$CodInf	 		= substr($CodInforme,0,7);
					$RAM	 		= substr($CodInforme,3,4);
					$infoNumero 	= 0;
					$infoSubidos 	= 0;
					$link=Conectarse();
					$bdInf=$link->query("SELECT * FROM Informes Where CodInforme Like '%".$RAM."%'");
					if($rowInf=mysqli_fetch_array($bdInf)){
						do{
							$infoNumero++;
							if($rowInf['informePDF']){
								$infoSubidos++;
							}
						}while ($rowInf=mysqli_fetch_array($bdInf));
					}
					$fechaInformeUP = '0000-00-00';
					$informeUP 		= '';
					if($infoNumero == $infoSubidos){
						$fechaInformeUP = date('Y-m-d');
						$informeUP 		= 'on';
					}
					$bdCot=$link->query("SELECT * FROM Cotizaciones WHERE RAM = '".$RAM."'");
					if ($rowCot=mysqli_fetch_array($bdCot)){
						$actSQL="UPDATE Cotizaciones SET ";
						$actSQL.="fechaInformeUP	= '".$fechaInformeUP.	"',";
						$actSQL.="informeUP			= '".$informeUP.		"',";
						$actSQL.="infoNumero		= '".$infoNumero.		"',";
						$actSQL.="infoSubidos		= '".$infoSubidos.		"'";
						$actSQL.="WHERE RAM 		= '".$RAM."'";
						$bdCot=$link->query($actSQL);
					}
					$link->close();
					$MsgUsr="Informe ".$RAM.': '.$infoNumero."/".$infoSubidos;
				}else{ 
					$MsgUsr="Ocurrió algún error al subir el fichero ".$nombre_archivo." No pudo guardar.... ";
				} 
			}else{
				$MsgUsr="Se permite subir un documento PDF <br>"; 
			}
		}
	}
	if(isset($_POST['guardarInforme'])){
		$fechaInforme = date('Y-m-d');
				
		$CodigoVerificacion   	= $_POST['CodigoVerificacion'];		
		if($CodigoVerificacion){
		}else{
			$i=0; 
			$password=""; 
			$pw_largo = 12; 
			$desde_ascii = 50; // "2" 
			$hasta_ascii = 122; // "z" 
			$no_usar = array (58,59,60,61,62,63,64,73,79,91,92,93,94,95,96,108,111); 
			while ($i < $pw_largo) { 
				mt_srand ((double)microtime() * 1000000); 
				$numero_aleat = mt_rand ($desde_ascii, $hasta_ascii); 
				if (!in_array ($numero_aleat, $no_usar)) { 
					$password = $password . chr($numero_aleat); 
					$i++; 
				} 
			}
			$CodigoVerificacion = $password;
		}
		
		$IdProyecto = 'IGT-1118';
		$Detalle = '';
		if(isset($_POST['RutCli']))			{ $RutCli 		= $_POST['RutCli']; 		}
		if(isset($_POST['nomCliente']))		{ $nomCliente	= $_POST['nomCliente']; 	}
		if(isset($_POST['fechaInforme']))	{ $fechaInforme	= $_POST['fechaInforme']; 	}
		if(isset($_POST['Estado']))			{ $Estado		= $_POST['Estado']; 		}
		if(isset($_POST['Detalle']))		{ $Detalle		= trim($_POST['Detalle']); 		}
		if(empty(trim($Detalle))){
			//echo 'Debe ingresar detalle...'.$Detalle;
		}

		$fd = explode('-', $fechaInforme);

		$DiaInforme 	= $fd[2];
		$MesInforme 	= $fd[1];
		$AgnoInforme 	= $fd[0];

		$link=Conectarse();
		$bdCli=$link->query("SELECT * FROM Clientes WHERE Cliente = '".$nomCliente."'");
		if($rowCli=mysqli_fetch_array($bdCli)){
			$RutCli = $rowCli['RutCli'];
		}
		$bdInf=$link->query("SELECT * FROM Informes WHERE CodInforme = '".$CodInforme."'");
		if($rowInf=mysqli_fetch_array($bdInf)){
			$actSQL="UPDATE Informes SET ";
			$actSQL.="RutCli				='".$RutCli.			"',";
			$actSQL.="CodigoVerificacion	='".$CodigoVerificacion."',";
			$actSQL.="DiaInforme			='".$DiaInforme.		"',";
			$actSQL.="MesInforme			='".$MesInforme.		"',";
			$actSQL.="AgnoInforme			='".$AgnoInforme.		"',";
			$actSQL.="Estado				='".$Estado.			"',";
			$actSQL.="Detalle				='".trim($Detalle).			"'";
			$actSQL.="WHERE CodInforme		= '".$CodInforme."'";
			$bdInf=$link->query($actSQL);
		}else{
			$link->query("insert into Informes(	CodInforme,
												RutCli,
												CodigoVerificacion,
												DiaInforme,
												MesInforme,
												AgnoInforme,
												IdProyecto,
												Estado,
												Detalle
											) 
								values 		(	'$CodInforme',
												'$RutCli',
												'$CodigoVerificacion',
												'$DiaInforme',
												'$MesInforme',
												'$AgnoInforme',
												'$IdProyecto',
												'$Estado',
												'$Detalle'
			)");
		}
		
		// Revisiones
		$bdIm=$link->query("SELECT * FROM ItemsMod");
		if ($rowIm=mysqli_fetch_array($bdIm)){
			do{
				if(isset($_POST[$rowIm['nMod']])){
					$nMod 		= $_POST[$rowIm['nMod']];
					$fechaMod 	= date('Y-m-d');
					if($nMod < 8){
						$bdRev=$link->query("SELECT * FROM regRevisiones WHERE CodInforme = '".$CodInforme."' && nMod = '".$nMod."'");
						if($rowRev=mysqli_fetch_array($bdRev)){
							$actSQL="UPDATE regRevisiones SET ";
							$actSQL.="nMod				='".$nMod."', ";
							$actSQL.="fechaMod			='".$fechaInforme."' ";
							$actSQL.="WHERE CodInforme = '".$CodInforme."' && nMod = '".$nMod."'";
							$bdRev=$link->query($actSQL);
						}else{
							$link->query("insert into regRevisiones (CodInforme,
																	nMod,	
																	fechaMod) 
															values ('$CodInforme',
																	'$nMod',
																	'$fechaMod')"
							);
						}
					}
					if($rowIm['eCorreo'] == 'on'){

						$msgCorreo  = '
									<html>
									<head>
									<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
									<title>Problemas con el resultado del ensayo  Acreditado</title>
									</head>
									<body>
										<a href="http://enigrup.cl/home3.php"><img src="http://simet.cl/imagenes/simet.png"></a>
										<br>
										<h1>Problemas con el resultado del ensayo  Acreditado</h1>
										<br>
										
										Informe: '.$CodInforme.'<br>
										Descripción:
										<hr>
										'.$Detalle.'
										<hr>
										<br>
										<br>
										Atentamente<br>
										Laboratorio Ensayos<br>
										SIMET-USACH
									</body>
									</html>
									';
						$empresa 	= 'SIMET ';
						$email		= 'simet@usach.cl'; 
									
						$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
						$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						
						// Cabeceras adicionales
						$cabeceras .= 'To: Problema Ensayo Acreditado SIMET <simet@usach.cl>' . "\r\n";
						$cabeceras .= 'From: Laboratorio <simet@usach.cl>' . "\r\n";
						$cabeceras .= 'Cc: alfredo.artigas@usach.cl' . "\r\n";
						$cabeceras .= 'Bcc: francisco.olivares.rodriguez@gmail.com' . "\r\n";
						
						// Enviarlo
						$mail_destinatario = 'reclamos.simet@usach.cl';
						$titulo = 'Problemas Ensayo Acreditado - SIMET';
														
/*				
						if(mail ($mail_destinatario, $titulo, $msgCorreo, $cabeceras )){
						//if(mail ($_POST[mail_destinatario], 'Capacitaciones', $msgCorreo, $cabeceras )){
						
							echo "<script>alert('Se ha enviado correo a ...".$mail_destinatario."')</script>";
										
						}else{
						
							echo "<script>alert('Error...')</script>";
							
						}
*/
						
					}
				}else{
					$nMod 		= $rowIm['nMod'];
					$bdRev=$link->query("SELECT * FROM regRevisiones WHERE CodInforme = '".$CodInforme."' && nMod = '".$nMod."'");
					if($rowRev=mysqli_fetch_array($bdRev)){
						$bdProv=$link->query("DELETE FROM regRevisiones WHERE CodInforme = '".$CodInforme."' && nMod = '".$nMod."'");
					}
				}
			}while ($rowIm=mysqli_fetch_array($bdIm));
		}
		// Fin Revisiones
		
		
		$link->close();
	}

	if(isset($_POST['borrarInforme'])){
		$link=Conectarse();
		$Estado 	= '';
		$informePDF = '';
		$fechaUP	= '0000-00-00';
		$bdInf=$link->query("DELETE FROM Informes WHERE CodInforme = '".$CodInforme."'");
/*
		$bdInf=$link->query("SELECT * FROM Informes WHERE CodInforme = '".$CodInforme."'");
		if($rowInf=mysqli_fetch_array($bdInf)){
			if($rowInf['informePDF']){
				$infoBorrar = '../../intranet/informes/'.$rowInf['informePDF'];
				if(file_exists($infoBorrar)){
					unlink($infoBorrar);
					$actSQL="UPDATE Informes SET ";
					$actSQL.="Estado			='".$nMod.		"', ";
					$actSQL.="fechaUP			='".$fechaUP.	"', ";
					$actSQL.="informePDF		='".$informePDF."' ";
					$actSQL.="WHERE CodInforme = '".$CodInforme."'";
					$bdRev=$link->query($actSQL);
				}
			}			
		}		
*/					
		$link->close();
		header("Location: plataformaInformes.php");
		
	}

	if(isset($_POST['descargarInforme'])){
		$link=Conectarse();
		//$bdInf=$link->query("DELETE FROM Informes WHERE CodInforme = '".$CodInforme."'");
		
		$Estado 	= '';
		$informePDF = '';
		$fechaUP	= '0000-00-00';
		$bdInf=$link->query("SELECT * FROM Informes WHERE CodInforme = '".$CodInforme."'");
		if($rowInf=mysqli_fetch_array($bdInf)){
			if($rowInf['informePDF']){
				$infoBorrar = '../../intranet/informes/'.$rowInf['informePDF'];
				if(file_exists($infoBorrar)){
					unlink($infoBorrar);
					$actSQL="UPDATE Informes SET ";
					$actSQL.="Estado			='".$nMod.		"', ";
					$actSQL.="fechaUP			='".$fechaUP.	"', ";
					$actSQL.="informePDF		='".$informePDF."' ";
					$actSQL.="WHERE CodInforme = '".$CodInforme."'";
					$bdRev=$link->query($actSQL);
				}
			}			
		}		
		
		$link->close();
	}
	$fechaInforme = date('Y-m-d');
	if($CodInforme){
		$link=Conectarse();
		$bdInf=$link->query("SELECT * FROM Informes WHERE CodInforme = '".$CodInforme."'");
		if ($rowInf=mysqli_fetch_array($bdInf)){
			$IdProyecto			= $rowInf['IdProyecto'];
			$RutCli 			= $rowInf['RutCli'];
			$informePDF 		= $rowInf['informePDF'];
			$DiaInforme			= $rowInf['DiaInforme'];
			$MesInforme			= $rowInf['MesInforme'];
			$AgnoInforme		= $rowInf['AgnoInforme'];
			$Estado  			= $rowInf['Estado'];
			$Detalle  			= trim($rowInf['Detalle']);
			$CodigoVerificacion = $rowInf['CodigoVerificacion'];
			
			if($MesInforme<10) { $MesInforme = '0'.$MesInforme; }
			if($DiaInforme<10) { $DiaInforme = '0'.$DiaInforme; }
			if($AgnoInforme){
				$fechaInforme	= $AgnoInforme.'-'.$MesInforme.'-'.$DiaInforme;
			}
		}
		$nomCliente	= '';
		$bdCli=$link->query("SELECT * FROM Clientes WHERE RutCli = '".$rowInf['RutCli']."'");
		if ($rowCli=mysqli_fetch_array($bdCli)){
			$nomCliente = $rowCli['Cliente'];
		}
		
		$link->close();
	}
?>
<!doctype html>
 
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Módulo Informes</title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

	<link href="styles.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="../angular/angular.js"></script>
	<!--<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css"> -->
	<link rel="stylesheet" type="text/css" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">

	<script src="../jquery/jquery-1.6.4.js"></script>
	<style type="text/css">
			* {
				box-sizing: border-box;
			}
			.verde-class{
			background-color 	: green;
			color 			: #fff;
			font-weight 		: bold;
			}
			.verdechillon-class{
			background-color 	: #33FFBE;
			color 			: #fff;
			font-weight 		: bold;
			}
			.azul-class{
			background-color 	: blue;
			color 			: #fff;
			font-weight 		: bold;
			}
			.amarillo-class{
			background-color 	: yellow;
			color 			: black;
			}
			.rojo-class{
			background-color 	: red;
			color 			: black;
			}
			.default-color{
			background-color 	: #fff;
			color 			: black;
			}	
	</style>

</head>

<body ng-app="myApp" ng-controller="CtrlInformes" ng-init="buscarInforme('<?php echo $CodInforme; ?>')" >
	<?php include('head.php'); ?>
	<nav class="navbar navbar-expand-lg navbar-dark bg-danger static-top">
		<div class="container-fluid">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarResponsive">

					<ul class="navbar-nav ml-auto">
						<li class="nav-item">
							<a class="nav-link fas fa-power-off" href="../cerrarsesion.php"> Cerrar</a>
						</li>
					</ul>
				</div>
		</div>
	</nav>

	<div id="Cuerpo">
		<div id="CajaCpo">
			<div id="BarraOpciones">
				<div id="ImagenBarraLeft">
					<a href="../plataformaErp.php" title="Menú Principal">
						<img src="../gastos/imagenes/Menu.png"></a>
					<br>
					Principal
				</div>
				<div id="ImagenBarraLeft">
					<a href="plataformaInformes.php" title="Informes">
						<img src="../imagenes/pdf.png"></a>
					<br>
					Informes
				</div>
				<div id="ImagenBarraLeft" title="Procesos">
					<!-- <a href="mInforme.php" title="Nuevo Informe" onClick="registraEncuesta(0, 'Agrega')"> -->
					<a href="mInforme.php?accion=Agregar&CodInforme=" title="Nuevo Informe">
						<img src="../imagenes/newPdf.png"></a>
					<br>
					Cód.QR
				</div>
				<div id="ImagenBarraLeft" title="Volver">
					<!-- <a href="mInforme.php" title="Nuevo Informe" onClick="registraEncuesta(0, 'Agrega')"> -->
					<a href="plataformaInformes.php?CodInforme=<?php echo $CodInforme; ?>" title="Volver">
						<img src="../gastos/imagenes/preview_back_32.png"></a>
					<br>
					Volver
				</div>
			</div>
			<!-- Fin Caja Cuerpo -->

			<div class="container">
				<div class="card m-2">
					<div class="card-header">
						<h5 class="card-title">FICHA INFORME AM</h5>
  					</div>
  					<div class="card-body">
						<div class="row">
    						<label for="CodInforme" class="col-sm-2">Cód.Informe:</label>
    						<div class="col-sm-5">
      							<input type="text" class="form-control" id="CodInforme" ng-model="CodInforme">
    						</div>
    						<div class="col-sm-5">
								<button class="btn btn-primary mb-3">Buscar</button>
    						</div>
  						</div>
						<br>				  
						<div class="row">
    						<label for="CodigoVerificacion" class="col-sm-2">Cód.Verificación:</label>
    						<div class="col-sm-5">
								<input type="text" class="form-control" id="CodigoVerificacion" ng-model="CodigoVerificacion" readonly>
							</div>
							<div class="col-sm-5">
								<button class="btn btn-primary mb-3" ng-click="generaCodVer()">Generar Código de Verificación</button>
							</div>
							
							<?php
									if(isset($CodInforme)) {
										if(isset($CodigoVerificacion)) {
											$dirinfo  = "http://www.simet.cl/mostrarPdf.php";
											$dirinfo .= '?CodInforme='.$CodInforme.'&amp;CodigoVerificacion='.$CodigoVerificacion;
											//$dirinfo="http://www.simet.cl/verpdf.php?CodInforme=".$CodInforme."&CodigoVerificacion=".$CodigoVerificacion;
											//$dirinfo="http://www.simet.cl/muestrapdf.php?S13jUs425nSch17769T87653812_foAa=".$CodigoVerificacion;
											echo "<iframe scrolling='no' src='http://servidorerp/erp/codigoqr/phpqrcode/index.php?data=".$dirinfo."' width='100%' height='200px' frameborder='0' marginheight='0' marginwidth='0'></iframe>";
										}else{
											echo "<iframe scrolling='no' src='../codigoqr/phpqrcode/index.php?data=http://www.simet.cl' width='100%' height='200px' frameborder='0' marginheight='0' marginwidth='0'></iframe>";
										}
									}else{
										echo "<iframe scrolling='no' src='../codigoqr/phpqrcode/index.php?data=http://www.simet.cl' width='100%' height='200px' frameborder='0' marginheight='0' marginwidth='0'></iframe>";
									}
							?>

  						</div>
						<hr>


						<div class="row">
							<label for="informePDF" class="col-sm-2">Cliente:</label>
    						<div class="col-sm-5">
								<b>{{RutCli}} {{Cliente}}</b>
    						</div>
						</div>
						<br>
						<div class="row">
							<label for="informePDF" class="col-sm-2">PDF:</label>
    						<div class="col-sm-5">
								<input type="text" class="form-control" id="informePDF" ng-model="informePDF" readonly>
							</div>
							<label for="informePDF" class="col-sm-2">Fecha UP:</label>
    						<div class="col-sm-3">
      							<input type="date" class="form-control" id="fechaUp" ng-model="fechaUp">
    						</div>
						</div>
						<br>
						<div class="row">

							<label for="informePDF" class="col-sm-2">Situación:</label>
    						<div class="col-sm-7">
								<li  ng-repeat="x in regModificaciones"
									ng-class="verColorTexto(x.nMod, x.Modificacion)">
									<!-- {{x.nMod}} -->
									<button ng-click="marcarChek(x.nMod, x.Estado)" ng-model="botonModi" ng-class="claseModi(x.nMod, x.Estado)">{{x.Estado}}</i></button>
									<!-- <input  ng-value="valorModi(x.Estado, x.nMod)" ng-model="estModi" type="checkbox" ng-click="marcarChek(x.nMod, estModi)"> {{x.Estado}}	-->
									{{x.Modificacion}}
								</li>
    						</div>
						</div>
						<br>

						<div class="row">
							<label for="Detalle" class="col-sm-2">Estado Servicio:</label>
    						<div class="col-sm-2">
								<select class     = "form-control"
                      					ng-model  = "estadoSituacion" 
                      					ng-options  = "estadoSituacion.codSituacion as estadoSituacion.descripcion for estadoSituacion in Situacion" >
                					<option value="P">{{estadoSituacion}}</option>
            					</select>
    						</div>
						</div>
						<br>
						<div class="row">
							<label for="Detalle" class="col-sm-2">Observaciones:</label>
    						<div class="col-sm-10">
								<textarea class="form-control" ng-model="Detalle" id="Detalle" rows="10">{{Detalle}}</textarea>
    						</div>
						</div>
  					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-sm-2">
								<button type="button" class="btn btn-primary" ng-click="Guardar()">Guardar</button>
							</div>
							<div class="col-sm-10">
								<div class="alert alert-success alert-dismissible fade show" role="alert" ng-show="msgOk">
									  <strong>MENSAJE USUARIO!</strong> Registrado correctamente...
									  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								</div>
								<div class="alert alert-danger alert-dismissible fade show" role="alert" ng-show="msgNoOk">
									  <strong>MENSAJE USUARIO!</strong> {{msgError}}.
									  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								</div>
							</div>
						</div>
					</div>
				</div>				
			</div>


<!--
			<form name="form" action="mInforme.php" method="post">
				<div align="center">
					<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
						<tr>
							<td height="40"><span style="padding:5px;">Ficha Informe AM</span>
								<div style="margin:5px; float:right; ">
									<?php if($accion == 'Agregar' or $accion == 'Actualizar' or $accion == 'SubirPdf'){?>
											<button name="guardarInforme">
												<img src="../gastos/imagenes/guardar.png" width="32" height="32" title="Guardar Informe">
											</button>
											<button name="descargarInforme">
												<img src="../imagenes/pdf_download.png" width="32" height="32" title="Descargar Informe">';
											</button>
									<?php }else{ 
											if($accion == 'Descargar'){	?>
												<button name="descargarInforme">
													<img src="../imagenes/pdf_download.png" width="32" height="32" title="Descargar Informe">';
												</button>
											<?php }else{ ?>
												<button name="borrarInforme">
													<img src="../gastos/imagenes/inspektion.png" width="32" height="32" title="Eliminar Informe">';
												</button>
											<?php } 
										} ?>
								</div>
							</td>
						</tr>
					</table>
					<div id="RegistroFactura">
						<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaDocumentos">
							<tr>
							<td colspan="2" align="right"class="tituloficha" >Mensaje</td>
							<td colspan="4"><?php echo $MsgUsr; ?></td>
							</tr>
							<tr>
								<td colspan="2" align="right"class="tituloficha" >Cód. Informe</td>
								<td width="84%" colspan="4">
									<?php 
										$Foco = 'autofocus';
										if($CodInforme){
											$Foco = '';
										}
									?>
								<input name="CodInforme" type="text" size="20" maxlength="20" value="<?php echo $CodInforme; ?>" <?php echo $Foco; ?> />								
								<input name="accion"  	type="hidden" value="<?php echo $accion; ?>">
									<button name="consultaInforme">
										<img src="../gastos/imagenes/buscar.png" width="32" height="32">
									</button>
							</td>
							</tr>
							<?php if($CodInforme){?>
								<tr>
								<td colspan="2">C&oacute;digo de Verificaci&oacute;n: </td>
								<td colspan="4">
									<input name="CodigoVerificacion" type="text" id="CodigoVerificacion" size="20" maxlength="20"  value="<?php echo $CodigoVerificacion; ?>">
									<?php if($CodigoVerificacion){
										echo $CodigoVerificacion;
									}else{ ?>
										<input name="Generar" type="submit" id="Generar" value="Generar C&oacute;digo">
									<?php } ?>
								</td>
								</tr>
		
								<?php if($CodigoVerificacion) {?>
								<tr>
								<td colspan="2">C&oacute;digo QR: </td>
								<td colspan="4">
									<?php
										if(isset($CodInforme)) {
											if(isset($CodigoVerificacion)) {
												$dirinfo  = "http://www.simet.cl/mostrarPdf.php";
												$dirinfo .= '?CodInforme='.$CodInforme.'&amp;CodigoVerificacion='.$CodigoVerificacion;
												//$dirinfo="http://www.simet.cl/verpdf.php?CodInforme=".$CodInforme."&CodigoVerificacion=".$CodigoVerificacion;
												//$dirinfo="http://www.simet.cl/muestrapdf.php?S13jUs425nSch17769T87653812_foAa=".$CodigoVerificacion;
												echo "<iframe scrolling='no' src='http://servidordata/erp/codigoqr/phpqrcode/index.php?data=".$dirinfo."' width='100%' height='200px' frameborder='0' marginheight='0' marginwidth='0'></iframe>";
											}else{
												echo "<iframe scrolling='no' src='../codigoqr/phpqrcode/index.php?data=http://www.simet.cl' width='100%' height='200px' frameborder='0' marginheight='0' marginwidth='0'></iframe>";
											}
										}else{
											echo "<iframe scrolling='no' src='../codigoqr/phpqrcode/index.php?data=http://www.simet.cl' width='100%' height='200px' frameborder='0' marginheight='0' marginwidth='0'></iframe>";
										}
									?>
								</td>
								</tr>
								<?php } ?>
								
								<tr>
									<td colspan="2">Cliente: </td>
									<td colspan="4">
										<select name="RutCli" id="RutCli">
											<option></option>
											<?php
											$link=Conectarse();
											$bdCli=$link->query("SELECT * FROM Clientes Order By Cliente");
											if($rowCli=mysqli_fetch_array($bdCli)){
												do{
													if($RutCli == $rowCli['RutCli']){
														echo "<option selected 	value='".$rowCli['RutCli']."'>".$rowCli['Cliente']."</option>";
													}else{
														echo "<option  			value='".$rowCli['RutCli']."'>".$rowCli['Cliente']."</option>";
													}
												}while ($rowCli=mysqli_fetch_array($bdCli));
											}
											$link->close();
											?>
										</select>
										<?php 
											$Foco = 'autofocus';
											if($nomCliente){
												$Foco = '';
											}
										?>
										<input name="nomCliente" type="text" list="nClientes" size="80" maxlength="80" value="<?php echo $nomCliente; ?>" <?php echo $Foco; ?> />
										<datalist id="nClientes">
											<?php
												$link=Conectarse();
												$bdCli=$link->query("SELECT * FROM Clientes where Estado != 'off' Order By Cliente");
												if($rowCli=mysqli_fetch_array($bdCli)){
													do{?>
															<option value="<?php echo $rowCli['Cliente']; ?>">
														<?php
													}while ($rowCli=mysqli_fetch_array($bdCli));
												}
												$link->close();
											?>
										</datalist>									
									</td>
								</tr>
								<tr>
									<td colspan="2">Fecha Informe: </td>
									<td colspan="4">
										<input name="fechaInforme" 	type="date" value="<?php echo $fechaInforme; ?>" required />
									</td>
								</tr>
								<?php if($CodInforme){?>
									<tr>
									<td colspan="2">Informe:</td>
									<td colspan="4">
										<?php
											if($informePDF != ''){
												echo '<a href="mostrarPdfLocal.php?accion=Actualizar&CodInforme='.$CodInforme.'&RutCli='.$RutCli.'"	><img src="../imagenes/informeUP.png"  title="Informe Subido (VER INFORME)">	</a>';
												echo '<a href="http://erp.simet.cl/informes/plataformaSubeInformes.php?accion=SubirPdf&CodInforme='.$CodInforme.'&RutCli='.$RutCli.'&IdProyecto='.$IdProyecto.'&CodigoVerificacion='.$CodigoVerificacion.'"	><img src="../imagenes/upload2.png" width="70" height="70" title="SUBIR INFORME">	</a>';
											}else{
												echo '<a href="http://erp.simet.cl/informes/plataformaSubeInformes.php?accion=SubirPdf&CodInforme='.$CodInforme.'&RutCli='.$RutCli.'&IdProyecto='.$IdProyecto.'&CodigoVerificacion='.$CodigoVerificacion.'"	><img src="../imagenes/upload2.png" width="70" height="70" title="SUBIR INFORME">	</a>';
											}
										?>
									</td>
									</tr>
								<?php } ?>
								<tr>
								<td colspan="2">Situaci&oacute;n:</td>
								<td colspan="4">
								
										<?php
										$link=Conectarse();
											
										$bdIm=$link->query("SELECT * FROM ItemsMod Order By nMod");
										if ($rowIm=mysqli_fetch_array($bdIm)){
											do{
												$css = "color:#000";
												if($rowIm['eCorreo'] == 'on'){
													$css = "color:#FF0000; font-weight:700;";
												}
												$bdRev=$link->query("SELECT * FROM regRevisiones WHERE CodInforme = '".$CodInforme."' && nMod = '".$rowIm['nMod']."'");
												if($rowRev=mysqli_fetch_array($bdRev)){
												//if($rowIm[nMod]){
													echo ' <span style='.$css.'><input name="'.$rowIm['nMod'].'" type="checkbox" value="'.$rowIm['nMod'].'" checked>'.$rowIm['Modificacion'].'</span><br>';
												}else{
													echo ' <span style='.$css.'><input name="'.$rowIm['nMod'].'" type="checkbox" value="'.$rowIm['nMod'].'">'.$rowIm['Modificacion'].'</span><br>';
												}
											}while ($rowIm=mysqli_fetch_array($bdIm));
										}
										$link->close();
										?>


								</td>
								</tr>
								<tr>
									<td colspan="2">Estado Servicio: </td>
									<td colspan="4">
										<select name="Estado" id="Estado">
											<option></option>
											<?php if($Estado == 1){?>
												<option selected 	value="1">Pendiente</option>
											<?php }else{ ?>
												<option  			value="1">Pendiente</option>
											<?php } ?>
											<?php if($Estado == 2){?>
												<option selected 	value="2">Terminado</option>
											<?php }else{ ?>
												<option  			value="2">Terminado</option>
											<?php } ?>
										</select>
									</td>
								</tr>
								<tr>
									<td colspan="2">Detalle/Descripci&oacute;n: </td>
									<td colspan="4">
										<textarea class="form-control" ng-model="Detalle" ng-change="cambia()" name="Detalle" cols="80" rows="10" required><?php echo $Detalle;?></textarea>
									</td>
								</tr>
							<?php } ?>
						</table>
					</div>
				</div>
			</form>
-->
		</div>
	</div>
	<!-- <script src="../jsboot/bootstrap.min.js"></script> -->
	<script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

	<script src="informes.js"></script>

</body>
</html>