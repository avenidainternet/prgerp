<?php
	session_start();
	include_once("Mobile-Detect-2.3/Mobile_Detect.php");
 	$Detect = new Mobile_Detect();

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
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

	<title>Módulo Institución</title>
	
	<link href="css/tpv.css" 	rel="stylesheet" type="text/css">
	<link href="css/styles.css" rel="stylesheet" type="text/css">
	<link href="estilos.css" 	rel="stylesheet" type="text/css">

	<style type="text/css">
	<!--
	body {
		margin-left: 0px;
		margin-top: 0px;
		margin-right: 0px;
		margin-bottom: 0px;
	}
	-->
	</style>
	<script language="javascript" src="gastos/validaciones.js"></script> 
	<script src="../jquery/jquery-1.6.4.js"></script>
	<script>
	$(document).ready(function(){
	   $("#dFactura").click(function(){
			$("#RegistroFactura").css("display", "block");
			$("#RegistroBoleta").css("display", "none");
	   });
	   $("#dBoleta").click(function(){
			$("#RegistroFactura").css("display", "none");
			$("#RegistroBoleta").css("display", "block");
	   });
		
		$("#NetoF").bind('keypress', function(event)
		{
		// alert(event.keyCode);
		if (event.keyCode == '9')
			{
			neto  = document.form.NetoF.value;
			iva	  = neto * 0.19;
			bruto = neto * 1.19;
			document.form.IvaF.value 	= iva;
			document.form.BrutoF.value 	= bruto;
			// document.form.Iva.focus();
			return 0;
			}
		});
	});
	</script>
	
</head>

<body>
	<?php include('head.php'); ?>
	<table width="99%"  border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="200px" valign="top" style="padding:5px; ">		
				<?php include_once('menulateral.php')?>	
			</td>
			<td width="100%" valign="top">	
				<?php include_once('mNotas.php');?>	
			</td>
	  	</tr>
	</table>

	<div style="clear:both; "></div>
	<br>
</body>
</html>