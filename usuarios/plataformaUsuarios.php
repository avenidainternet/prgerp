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
	
	$Login 	= '';
	$accion	= '';
	
	if(isset($_GET['Login'])) 	{	$Login 	= $_GET['Login']; 	}
	if(isset($_GET['accion'])) 	{	$accion = $_GET['accion']; 	}
	
	if(isset($_POST['Login'])) 	{	$Login 	= $_POST['Login']; 	}
	if(isset($_POST['accion'])) {	$accion = $_POST['accion']; 	}
	
	if(isset($_POST['confirmarBorrar'])){
		$link=Conectarse();
		$bdEnc=$link->query("Delete From Usuarios Where usr = '".$Login."'");
		$link->close();
		$Login 	= '';
		$accion	= '';
	}
	if(isset($_POST['confirmarGuardar'])){
		if(isset($_POST['Login'])) 		{ $Login 	= $_POST['Login'];	}
		if(isset($_POST['pwd'])) 		{ $pwd 	 	= $_POST['pwd'];	}
		if(isset($_POST['usuario'])) 	{ $usuario 	= $_POST['usuario'];}
		if(isset($_POST['email'])) 		{ $email 	= $_POST['email'];	}
		if(isset($_POST['nPerfil'])) 	{ $nPerfil 	= $_POST['nPerfil'];}

		$link=Conectarse();
		$bdEnc=$link->query("Select * From Usuarios Where usr = '".$Login."'");
		if($rowEnc=mysqli_fetch_array($bdEnc)){
			$actSQL="UPDATE Usuarios SET ";
			$actSQL.="pwd		='".$pwd.		"',";
			$actSQL.="usuario	='".$usuario.	"',";
			$actSQL.="email		='".$email.		"',";
			$actSQL.="nPerfil	='".$nPerfil.	"'";
			$actSQL.="WHERE usr	= '".$Login."'";
			$bdEnc=$link->query($actSQL);
		}else{
			$link->query("insert into Usuarios(	usr,
												pwd,
												usuario,
												email,
												nPerfil
												) 
									values 	(	'$Login',
												'$pwd',
												'$usuario',
												'$email',
												'$nPerfil'
			)");
			$Login 	= '';
			$accion	= '';
		}
		$link->close();
		$Login 	= '';
		$accion	= '';
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
			url: 'muestraUsuarios.php',
			type: 'get',
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}
	
	function registraEncuesta(Login, accion){
		var parametros = {
			"Login" 	: Login,
			"accion"	: accion
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'regUsuarios.php',
			type: 'get',
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}
	</script>

</head>

<body>
	<?php include_once('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<img src="../imagenes/class_128.png" width="32" height="32" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					Módulo Control de Usuarios
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
					<a href="#" title="Agregar Usuario" onClick="registraEncuesta(' ', 'Agrega')">
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
			<?php include_once('listaUsuarios.php'); 
			if($Login){?>
				<script>
					var Login 	= "<?php echo $Login; ?>" ;
					var accion 	= "<?php echo $accion; ?>" ;
					registraEncuesta(Login, accion);
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
