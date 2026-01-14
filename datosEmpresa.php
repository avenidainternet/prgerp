<?php
	session_start(); 
	date_default_timezone_set("America/Santiago");

	include_once("Mobile-Detect-2.3/Mobile_Detect.php");
 	$Detect = new Mobile_Detect();

	 $colorHead = "degradado";
	 $nomservidor = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	 if($nomservidor == 'servidordata'){
		 $colorHead = "degradadoRojo";
	 }
 
	$_SESSION['Grabado'] = "NO";
	$MsgUsr ="";	
	include_once("conexionli.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		$link->close();
	}else{
		header("Location: index.php");
	}

	/* Declaraci�n de Variables */	
	$RunEmp			  	  = "";
	$NombreEmp 			  = "";
	$Direccion			  = "";
	$Comuna				  = "";

	$nDepartamento		  = "";
	$NomDpto			  = "";
	$RutDirector		  = "";
	$NomDirector		  = "";
	$Cargo				  = "";
	$SubDirectorProyectos = "";
	$EmailDepto			  = "";
	$fechaInicio		  = date('Y-m-d');
	$maxCpo = "100%";
	
	$Proceso = 1;
	
	if(isset($_GET['Proceso'])) 	{ $Proceso  = $_GET['Proceso']; 	}
	if(isset($_GET['RutEmp'])) 		{ $RutEmp  	= $_GET['RutEmp']; 		}

	if(isset($_POST['Proceso'])) 	{ $Proceso  = $_POST['Proceso']; 	}
	if(isset($_POST['RutEmp'])) 	{ $RutEmp  	= $_POST['RutEmp']; 	}
	
	$link=Conectarse();
	if(isset($_POST['Guardar'])){
		if(isset($_POST['NombreEmp']))	{ $NombreEmp 	= $_POST['NombreEmp'];	}
		if(isset($_POST['Direccion']))	{ $Direccion 	= $_POST['Direccion'];	}
		if(isset($_POST['Comuna']))		{ $Comuna 		= $_POST['Comuna'];		}
		if(isset($_POST['Banco']))		{ $Banco 		= $_POST['Banco'];		}
		if(isset($_POST['CtaCte']))		{ $CtaCte 		= $_POST['CtaCte'];		}

		$actSQL="UPDATE Empresa SET ";
		$actSQL.="NombreEmp			='".$NombreEmp.	"',";
		$actSQL.="Direccion			='".$Direccion.	"',";
		$actSQL.="Comuna			='".$Comuna.	"',";
		$actSQL.="Banco				='".$Banco.		"',";
		$actSQL.="CtaCte			='".$CtaCte.	"'";
		$actSQL.="WHERE RutEmp 		= '".$RutEmp."'";
		$bdEmp=$link->query($actSQL);

		if(isset($_POST['nDepartamento'])) 			{ $nDepartamento		= $_POST['nDepartamento'];			}
		if(isset($_POST['NomDpto'])) 				{ $NomDpto 				= $_POST['NomDpto'];				}
		if(isset($_POST['RutDirector'])) 			{ $RutDirector			= $_POST['RutDirector'];			}
		if(isset($_POST['NomDirector'])) 			{ $NomDirector			= $_POST['NomDirector'];			}
		if(isset($_POST['fechaInicio'])) 			{ $fechaInicio			= $_POST['fechaInicio'];			}
		if(isset($_POST['Cargo'])) 					{ $Cargo				= $_POST['Cargo'];					}
		if(isset($_POST['SubDirectorProyectos'])) 	{ $SubDirectorProyectos	= $_POST['SubDirectorProyectos'];	}
		if(isset($_POST['EmailDepto'])) 			{ $EmailDepto			= $_POST['EmailDepto'];				}

		$actSQL="UPDATE Departamentos SET ";
		$actSQL.="NomDpto				='".$NomDpto."',";
		$actSQL.="RutDirector			='".$RutDirector."',";
		$actSQL.="NomDirector			='".$NomDirector."',";
		$actSQL.="Cargo					='".$Cargo."',";
		$actSQL.="SubDirectorProyectos	='".$SubDirectorProyectos."',";
		$actSQL.="EmailDepto			='".$EmailDepto."'";
		$actSQL.="WHERE nDepartamento 	= '".$nDepartamento."'";
		$bdDp=$link->query($actSQL);

		$bdD=$link->query("SELECT * FROM director Where RutDirector = '$RutDirector'");
		if($rowD=mysqli_fetch_array($bdD)){
			$actSQL="UPDATE director SET ";
			$actSQL.="NomDirector			='".$NomDirector.	"',";
			$actSQL.="fechaInicio			='".$fechaInicio.	"',";
			$actSQL.="Cargo					='".$Cargo.			"'";
			$actSQL.="WHERE RutDirector 	= '".$RutDirector.	"'";
			$bdDp=$link->query($actSQL);
		}else{
			$link->query("insert into director(		RutDirector,
													NomDirector,
													fechaInicio
													) 
									values 		(	'$RutDirector',
													'$NomDirector',
													'$fechaInicio'
													)");
			
		}	
		$bdObj=$link->query("SELECT * FROM ctasctescargo Order By aliasRecurso");
		if($rowObj=mysqli_fetch_array($bdObj)){
			do{
				$nCuenta 	= '';
				$Banco		= '';
				$rutTitular	= '';
				$aliasRecurso = $rowObj['aliasRecurso'];
				$nCta 	= 'nCuenta-'.$rowObj['aliasRecurso'];
				$nBco	= 'Banco-'.$rowObj['aliasRecurso'];
				$rTit	= 'rutTitular-'.$rowObj['aliasRecurso'];
				
				if(isset($_POST[$nCta])) 			{ $nCuenta		= $_POST[$nCta];			}
				if(isset($_POST[$nBco])) 			{ $Banco		= $_POST[$nBco];			}
				if(isset($_POST[$rTit])) 			{ $rutTitular	= $_POST[$rTit];			}
				
				$actSQL="UPDATE ctasctescargo SET ";
				$actSQL.="nCuenta				='".$nCuenta.	"',";
				$actSQL.="Banco					='".$Banco.		"',";
				$actSQL.="rutTitular			='".$rutTitular."'";
				$actSQL.="WHERE aliasRecurso 	= '".$aliasRecurso."'";
				$bdDp=$link->query($actSQL);
			}while ($rowObj=mysqli_fetch_array($bdObj));
		}
		
	}

	$bdDp=$link->query("SELECT * FROM Departamentos");
	if($rowDp=mysqli_fetch_array($bdDp)){
		$nDepartamento 			= $rowDp['nDepartamento'];
		$NomDpto 				= $rowDp['NomDpto'];
		$RutDirector			= $rowDp['RutDirector'];
		$NomDirector			= $rowDp['NomDirector'];
		$Cargo					= $rowDp['Cargo'];
		$SubDirectorProyectos	= $rowDp['SubDirectorProyectos'];
		$EmailDepto				= $rowDp['EmailDepto'];
	}
	$bdEmp=$link->query("SELECT * FROM Empresa");
	if($rowEmp=mysqli_fetch_array($bdEmp)){
		$RutEmp 	= $rowEmp['RutEmp'];
		$NombreEmp 	= $rowEmp['NombreEmp'];
		$Direccion 	= $rowEmp['Direccion'];
		$Comuna 	= $rowEmp['Comuna'];
		$Banco 		= $rowEmp['Banco'];
		$CtaCte 	= $rowEmp['CtaCte'];
	}
	$link->close();

?>
<!doctype html>
 
<html lang="es">
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Configuración Datos Institucionales</title>

	<link rel="shortcut icon" href="favicon.ico" />
	<link rel="apple-touch-icon" href="touch-icon-iphone.png" />
	<link rel="apple-touch-icon" href="touch-icon-ipad.png" />
	<link rel="apple-touch-icon" href="touch-icon-iphone4.png" />

	<link href="css/tpv.css" 	rel="stylesheet" type="text/css">
	<link href="css/styles.css" rel="stylesheet" type="text/css">
	<link href="estilos.css" 	rel="stylesheet" type="text/css">

	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="app/css/coloresbarra.css">

	<style type="text/css">
	
	body {
		margin-left: 0px;
		margin-top: 0px;
		margin-right: 0px;
		margin-bottom: 0px;
	}
	</style>
	<script language="javascript" src="validaciones.js"></script> 
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

<body ng-app="myApp" ng-controller="personCtrl" ng-init="loadConfig('<?php echo $_SESSION['usr']; ?>')" ng-cloak>

	<?php 
		include_once('head.php'); 
	?>

	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="200px" valign="top" style="padding:5px; ">		
				<?php include_once('menulateral.php')?>	
			</td>
			<td width="100%" valign="top">	
				<?php include_once('mEmpresa.php');?>	 
			</td>
	  	</tr>
	</table>

	<script type="text/javascript" src="angular/angular.js"></script>
	<script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
	<script type="text/javascript" src="bootstrap/js/bootstrap.bundle.min.js"></script>
	<script type="text/javascript" src="bootstrap/js/jquery.slim.min.js"></script>
	<script src="plataforma.js"></script>

</body>
</html>