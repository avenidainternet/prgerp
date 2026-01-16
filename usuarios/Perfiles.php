<?php
	session_start(); 
	include_once("../conexionli.php");
	date_default_timezone_set("America/Santiago");
	if(isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		$link->close();
	}else{
		header("Location: ../index.php");
	}
	
	$IdPerfil 	= '';
	$accion	= '';
	
	if(isset($_GET['IdPerfil'])) 	{	$IdPerfil 	= $_GET['IdPerfil']; 	}
	if(isset($_GET['accion'])) 		{	$accion 	= $_GET['accion']; 		}
	
	if(isset($_POST['IdPerfil'])) 	{	$IdPerfil 	= $_POST['IdPerfil']; 	}
	if(isset($_POST['accion'])) 	{	$accion 	= $_POST['accion']; 	}
	
	if(isset($_POST['confirmarBorrar'])){
		$link=Conectarse();
		$bdEnc=$link->query("Delete From Perfiles Where IdPerfil = '".$IdPerfil."'");
		$link->close();
		$IdPerfil 	= '';
		$accion	= '';
	}
	if(isset($_POST['confirmarGuardar'])){
		if(isset($_POST['IdPerfil']))	{ $IdPerfil = $_POST['IdPerfil'];	}
		if(isset($_POST['Perfil']))		{ $Perfil 	= $_POST['Perfil'];		}

		$link=Conectarse();
		$bdEnc=$link->query("Select * From Perfiles Where IdPerfil = '".$IdPerfil."'");
		if($rowEnc=mysqli_fetch_array($bdEnc)){
			$actSQL="UPDATE Perfiles SET ";
			$actSQL.="Perfil			='".$Perfil."'";
			$actSQL.="WHERE IdPerfil	= '".$IdPerfil."'";
			$bdEnc=$link->query($actSQL);
		}else{
			$link->query("insert into Perfiles(	IdPerfil,
												Perfil
												) 
									values 	(	'$IdPerfil',
												'$Perfil'
			)");
			$IdPerfil 	= '';
			$accion		= '';
		}
		$link->close();
		$IdPerfil 	= '';
		$accion		= '';
	}
	
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Intranet Simet</title>
	
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	

	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<script>
	function realizaProceso(dBuscar){
		var parametros = {
			"dBuscar" 	: dBuscar
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'muestraPerfiles.php',
			type: 'get',
			beforeSend: function () {
				$("#resultado").html("<div id='cajaRegistraPruebas'><img src='../imagenes/ajax-loader.gif'></div>");
			},
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}
	
	function registraEncuesta(IdPerfil, accion){
		var parametros = {
			"IdPerfil" 	: IdPerfil,
			"accion"	: accion
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'regPerfil.php',
			type: 'get',
			beforeSend: function () {
				$("#resultadoRegistro").html("<div style='position:absolute; left:159px; top:66px; width:470px; height:187px; z-index:1; border: 5px solid #000; background-color: #fff; border-radius: 5px 5px 0px 0px; -moz-border-radius: 5px 0px 5px 0px; '><img src='../imagenes/ajax-loader.gif'></div>");
			},
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}
	</script>

</head>

<body>
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<img src="../imagenes/class_128.png" width="32" height="32" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					Módulo Control de Usuarios (Perfiles de Usuarios)
				</strong>
				<?php //include('barramenu.php'); ?>

				<div id="ImagenBarra">
					<a href="cerrarsesion.php" title="Cerrar Sesión">
						<img src="../gastos/imagenes/preview_exit_32.png" width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a>
					<img src="../gastos/imagenes/r_x.png"  width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="#" title="Agregar Perfil" onClick="registraEncuesta(0, 'Agrega')">
						<img src="../imagenes/add_32.png" width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a>
					<img src="../gastos/imagenes/r_x.png"  width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="../plataformaErp.php" title="Menú Principal">
						<img src="../gastos/imagenes/Menu.png" width="32" height="32">
					</a>
				</div>
			</div>
			<?php include_once('listaPerfiles.php'); 
			if($IdPerfil){?>
				<script>
					var IdPerfil 	= "<?php echo $IdPerfil; ?>" ;
					var accion 		= "<?php echo $accion; ?>" ;
					registraEncuesta(IdPerfil, accion);
				</script>
				<?php
			}
			?>
		</div>
		<div style="clear:both;"></div>
				
	</div>
	<br>
	
	
</body>
</html>
