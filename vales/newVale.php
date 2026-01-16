<?php
	session_start(); 
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
	include_once("conexion.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=mysql_query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysql_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		mysql_close($link);
	}else{
		header("Location: index.php");
	}

	$nVale 			= 0;
	$Usuario		= '';
	$Descripcion	= '';
	$Ingreso		= 0;
	$fechaVale 		= date('Y-m-d');
	$usrResponsable = $_SESSION['usr'];

	$accion		= 'Agregar';
	if(isset($_GET['nVale'])) 		{ $nVale 	= $_GET['nVale']; 		}
	if(isset($_GET['accion'])) 		{ $accion 	= $_GET['accion']; 		}

	if(isset($_POST['Borrar'])){
		$link=Conectarse();
		if(isset($_POST['nVale'])) 			{ $nVale 			= $_POST['nVale'];			}
		$bdVa=mysql_query("DELETE FROM vales Where nVale = '".$nVale."'");
		mysql_close($link);
		header("Location: index.php");
	}
	if(isset($_POST['guardar'])){
		if(isset($_POST['nVale'])) 			{ $nVale 			= $_POST['nVale'];			}
		if(isset($_POST['fechaVale'])) 		{ $fechaVale 		= $_POST['fechaVale'];		}
		if(isset($_POST['usrResponsable'])) { $usrResponsable 	= $_POST['usrResponsable'];	}
		if(isset($_POST['Descripcion'])) 	{ $Descripcion		= $_POST['Descripcion'];	}
		if(isset($_POST['Ingreso'])) 		{ $Ingreso	 		= $_POST['Ingreso'];		}
		$accion = 'Actualiza';
		$link=Conectarse();
		$bdVa=mysql_query("SELECT * FROM vales Where nVale = '".$nVale."'");
		if($rowVa=mysql_fetch_array($bdVa)){
			$actSQL="UPDATE vales SET ";
			$actSQL.="fechaVale			='".$fechaVale.		"',";
			$actSQL.="Descripcion		='".$Descripcion.	"',";
			$actSQL.="Ingreso			='".$Ingreso.		"'";
			$actSQL.="Where nVale		= '".$nVale."'";
			$bdVa=mysql_query($actSQL);
		}else{
			mysql_query("insert into vales	(	nVale,
												fechaVale,
												Descripcion,
												Ingreso,
												usrResponsable
												) 
									values 	(	'$nVale',
												'$fechaVale',
												'$Descripcion',
												'$Ingreso',
												'$usrResponsable'
				)",$link);
		}
		mysql_close($link);
		header("Location: index.php");
	}
	$link=Conectarse();
	$bdVa=mysql_query("SELECT * FROM vales Where nVale = '".$nVale."'");
	if($rowVa=mysql_fetch_array($bdVa)){
		$nVale			= $rowVa['nVale'];
		$fechaVale		= $rowVa['fechaVale'];
		$Descripcion	= $rowVa['Descripcion'];
		$Ingreso		= $rowVa['Ingreso'];
		$usrResponsable	= $rowVa['usrResponsable'];
	}
	if($accion == 'Agregar'){
		$bdVal=mysql_query("SELECT * FROM vales Order By nVale Desc");
		if ($rowVal=mysql_fetch_array($bdVal)){
			$nVale = $rowVal['nVale'] + 1;
		}
		if($nVale == 0){
			$nVale = 1;
		}
	}
	mysql_close($link);
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Registro de Vales</title>

	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	<link rel="stylesheet" href="/resources/demos/style.css">
	
	<link href="estilos.css" 		rel="stylesheet" type="text/css">
	<link href="../css/styles.css" 	rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" 	rel="stylesheet" type="text/css">
	<script>
	  $(function() {
		$( "#accordion" ).accordion({
		  collapsible: true,
		  icons: { "header": "ui-icon-plus", "activeHeader": "ui-icon-minus" },
		  active: false
		});
	  });
	</script>

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
</head>

<body>
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<div id="CajaCpo">
				<?php 
				$nomModulo = 'Vales';
				include_once('menuIconos.php'); 
				?>
				<form name="form" action="newVale.php" method="post">
					<?php
					include_once('barraOpcionesValesNew.php');
					include_once('ingVale.php'); 
					?>
				</form>
		</div>
	</div>
	<div style="clear:both; "></div>
</body>
</html>
