<?php
	date_default_timezone_set("America/Santiago");
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
	$usuario = $_SESSION['usuario'];

	$OFE 			= 0;
	$accion			= '';
	$accionEnsayo	= '';

	if(isset($_POST['OFE'])) 			{	$OFE 			= $_POST['OFE']; 			}
	if(isset($_POST['accion'])) 		{	$accion 		= $_POST['accion']; 		}
	if(isset($_POST['accionEnsayo'])) 	{	$accionEnsayo	= $_POST['accionEnsayo']; 	}
	if(isset($_POST['nDescEnsayo'])) 	{	$nDescEnsayo 	= $_POST['nDescEnsayo']; 	}

	if(isset($_GET['OFE'])) 			{	$OFE 			= $_GET['OFE']; 			}
	if(isset($_GET['accion'])) 			{	$accion 		= $_GET['accion']; 			}
	if(isset($_GET['accionEnsayo'])) 	{	$accionEnsayo 	= $_GET['accionEnsayo']; 	}
	if(isset($_GET['nDescEnsayo'])) 	{	$nDescEnsayo 	= $_GET['nDescEnsayo']; 	}

	if($nDescEnsayo == 0){
		$link=Conectarse();
		$bdOFE=$link->query("Select * From ofensayos Order By nDescEnsayo Desc");
		if($rowOFE=mysqli_fetch_array($bdOFE)){
			$nDescEnsayo = $rowOFE['nDescEnsayo'] + 1;
		}
		$link->close();
	}
	
	if(isset($_POST['borrarEnsayo'])){
		$link=Conectarse();
		$bdEn =$link->query("Delete From ofensayos Where nDescEnsayo = '".$nDescEnsayo."'");
		$link->close();
		header("Location: mEnsayos.php?OFE=$OFE&accion=OFE");
	}
	if(isset($_POST['guardarEnsayo'])){
		
		if(isset($_POST['nomEnsayo']))		{	$nomEnsayo 		= $_POST['nomEnsayo'];		}
		if(isset($_POST['Descripcion']))	{	$Descripcion 	= $_POST['Descripcion'];	}
		
		$link=Conectarse();
		$bdOFE=$link->query("Select * From ofensayos Where nDescEnsayo = '".$nDescEnsayo."'");
		if($rowOFE=mysqli_fetch_array($bdOFE)){
			$actSQL="UPDATE ofensayos SET ";
			$actSQL.="nomEnsayo	 	='".$nomEnsayo.		"',";
			$actSQL.="Descripcion	='".$Descripcion.	"'";
			$actSQL.="WHERE nDescEnsayo	= '".$nDescEnsayo."'";
			$bdOFE=$link->query($actSQL);

		}else{
			$link->query("insert into ofensayos	(
													nDescEnsayo,
													nomEnsayo,
													Descripcion
												)	 
										values 	(	'$nDescEnsayo',
										  			'$nomEnsayo',
										  			'$Descripcion'
										  		)");
		}
		$link->close();
		//header("Location: mEnsayos.php?OFE=$OFE&accion=OFE");
	}
	
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Intranet Simet</title>
	
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	

	<link href="../styles.css" rel="stylesheet" type="text/css">
	<link href="../../css/tpv.css" rel="stylesheet" type="text/css">

  	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  	<link rel="stylesheet" href="/resources/demos/style.css">

	<script>
	  $(function() {
		$( "#accordion" ).accordion({
		  collapsible: true,
		  icons: { "header": "ui-icon-plus", "activeHeader": "ui-icon-minus" },
		  active: false
		});
	  });

		function realizaProceso(dBuscar){
			var parametros = {
				"dBuscar" 	: dBuscar
			};
			//alert(Proyecto);
			$.ajax({
				data: parametros,
				url: 'muestraCotizacion.php',
				type: 'get',
				success: function (response) {
					$("#resultado").html(response);
				}
			});
		}
	</script>

</head>

<body>
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="CuerpoTitulo">
		<img src="../../imagenes/other_48.png" width="32" height="32" align="middle">
		<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
			Oferta Económica 
		</strong>
		<div id="ImagenBarra">
			<a href="../cerrarsesion.php" title="Cerrar Sesión">
					<img src="../../gastos/imagenes/preview_exit_32.png" width="32" height="32">
			</a>
		</div>
	</div>
	<form name="form" action="edEnsayo.php" method="post">
		<input name="OFE" 			value="<?php echo $OFE; ?>" 		type="hidden">
		<input name="accion" 		value="OFE" 						type="hidden">
		<input name="nDescEnsayo" 	value="<?php echo $nDescEnsayo; ?>" type="hidden">
		<?php 
			include_once('BarraEnsAct.php');
			$link=Conectarse();
			include_once('edicionEnsayo.php');
			$link->close(); 
		?>
	</form>
</body>
</html>
