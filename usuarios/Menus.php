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
	
	$nModulo 	= '';
	$accion	= '';
	
	if(isset($_GET['nModulo'])) 	{	$nModulo 	= $_GET['nModulo']; }
	if(isset($_GET['accion'])) 		{	$accion 	= $_GET['accion']; 	}
	
	if(isset($_POST['nModulo'])) 	{	$nModulo 	= $_POST['nModulo'];}
	if(isset($_POST['accion'])) 	{	$accion 	= $_POST['accion']; }
	
	if(isset($_POST['confirmarBorrar'])){
		$link=Conectarse();
		$bdEnc=$link->query("Delete From Modulos Where nModulo = '".$nModulo."'");
		$link->close();
		$nModulo 	= '';
		$accion		= '';
	}
	if(isset($_POST['confirmarGuardar'])){
		if(isset($_POST['nModulo'])) 	{ $nModulo 	 = $_POST['nModulo']; 	}
		if(isset($_POST['Modulo'])) 	{ $Modulo 	 = $_POST['Modulo'];	}
		if(isset($_POST['dirProg'])) 	{ $dirProg 	 = $_POST['dirProg'];	}

		$nombre_archivo = $_FILES['icono']['name'];
		$tipo_archivo 	= $_FILES['icono']['type'];
		$tamano_archivo = $_FILES['icono']['size'];
		$desde 			= $_FILES['icono']['tmp_name'];
		
		echo $tipo_archivo;
		if($nombre_archivo){
			$Logo = $nombre_archivo;
			$directorio="iconos";
			if (($tipo_archivo == "image/jpeg" || $tipo_archivo == "image/png" || $tipo_archivo == "image/gif") ) { 
				if (move_uploaded_file($desde, $directorio."/".$nombre_archivo)){ 
					
				}
			}
		}else{
			if(isset($_POST['Logo']))			{ $Logo 			= $_POST['Logo']; 						}
		}
		
		$link=Conectarse();
		$bdEnc=$link->query("Select * From Modulos Where nModulo = $nModulo");
		if($rowEnc=mysqli_fetch_array($bdEnc)){
			$actSQL="UPDATE Modulos SET ";
			$actSQL.="Modulo		='".$Modulo."',";
			$actSQL.="iconoMod		='".$nombre_archivo."',";
			$actSQL.="dirProg		='".$dirProg."'";
			$actSQL.="WHERE nModulo	= '".$nModulo."'";
			$bdEnc=$link->query($actSQL);
		}else{
			$link->query("insert into Modulos(	nModulo,
												Modulo,
												iconoMod,
												dirProg
												) 
									values 	(	'$nModulo',
												'$Modulo',
												'$nombre_archivo',
												'$dirProg'
			)");
			$nModulo 	= '';
			$accion		= '';
		}
		$link->close();
		$nModulo 	= '';
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
	<link href="../css/menuLateral.css" rel="stylesheet" type="text/css">

	<script>
	
	function realizaProceso(dBuscar){
		var parametros = {
			"dBuscar" 	: dBuscar
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'menulateral.php',
			type: 'get',
			beforeSend: function () {
				$("#resultado").html("<div id='cajaRegistraPruebas'><img src='../imagenes/ajax-loader.gif'></div>");
			},
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}
	
	function registraEncuesta(nModulo, accion){
		var parametros = {
			"nModulo" 	: nModulo,
			"accion"	: accion
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'regModulo.php',
			type: 'get',
			beforeSend: function () {
				$("#resultadoRegistro").html("<div style='position:absolute; left:159px; top:66px; width:470px; height:187px; z-index:1; border: 5px solid #000; background-color: #fff; border-radius: 5px 5px 0px 0px; -moz-border-radius: 5px 0px 5px 0px; '><img src='../imagenes/ajax-loader.gif'></div>");
			},
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}
	
	function muestraMenu(){
		$("#mMenu").load('menulateral.php');		
		$("#mOpcMenu").load('OpcionesMenu.php');		
	}

	function seleccionaOpcMenu(nMenu, nModulo){
		$("#mOpcMenu").load("OpcionesMenu.php?nMenu="+nMenu+"&nModulo="+nModulo);		
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
					Módulo Aplicaciones
				</strong>

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
					<a href="#" title="Agregar Módulo" onClick="registraEncuesta(0, 'Agrega')">
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
			<div id="BarraOpciones">
				<div id="ImagenBarraLeft">
					<a href="plataformaUsuarios.php" title="Usuarios">
						<img src="../imagenes/class_128.png">
					</a>
				</div>
				<div id="ImagenBarraLeft" title="Perfiles">
					<a href="Perfiles.php" title="Perfiles de Usuarios">
						<img src="../imagenes/single_class.png">
					</a>
				</div>
				<?php if($_SESSION['Perfil'] == 'WebMaster'){?>
					<div id="ImagenBarraLeft" title="Módulos">
						<a href="Modulos.php" title="Módulos">
							<img src="../imagenes/soft.png">
						</a>
					</div>
				<?php } ?>
			</div>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="20%" valign="top" class="bordeDerechoMenu">
						<div id="mMenu"></div>
					</td>
					<td width="80%" valign="top">
						<div id="mOpcMenu"></div>
					</td>
				</tr>
			</table>
			<script> 
				muestraMenu(); 
			</script>
			
		</div>
		<div style="clear:both;"></div>
				
	</div>
	
	<br>
	
	
</body>
</html>
