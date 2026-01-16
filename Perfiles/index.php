<?php
	session_start(); 
	include_once("../conexionli.php");
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
	$usuario 			= $_SESSION['usuario'];

	$usrApertura 		= $_SESSION['usr'];

	if(isset($_GET['accion'])){
		if(isset($_GET['IdPerfil'])){ $IdPerfil = $_GET['IdPerfil']; 	}
		if(isset($_GET['nMenu']))	{ $nModulo 	= $_GET['nMenu']; 	}

		$link=Conectarse();
		$bdProv=$link->query("DELETE FROM modperfil WHERE IdPerfil = '$IdPerfil' and nMenu = '$nMenu'");
		$link->close();
	}

	if(isset($_POST['IdPerfil'])){ $firstUsr = $_POST['IdPerfil']; }

	if(isset($_POST['agregarModulo'])){
		if(isset($_POST['IdPerfil']))	{ $IdPerfil = $_POST['IdPerfil']; 	}
		if(isset($_POST['nMenu']))		{ $nMenu 	= $_POST['nMenu']; 		}

		$link=Conectarse();
		$bd=$link->query("SELECT * FROM modperfil WHERE IdPerfil = '$IdPerfil' and nMenu = '$nMenu'");
		if ($row=mysqli_fetch_array($bd)){
			$actSQL="UPDATE modperfil SET ";
			$actSQL.="IdPerfil			= '".$Perfil.	"',";
			$actSQL.="nMenu				= '".$nMenu.	"'";
			$actSQL.="Where IdPerfil 	= '".$IdPerfil."' and nMenu = '$nMenu'";
			$bdAct = $link->query($actSQL);
		}else{
				$link->query("insert into modperfil(	IdPerfil 				,
														nMenu
														) 
										values 		(	'$IdPerfil' 			,
														'$nMenu'
														)");
		}
		$link->close();

	}

	if(isset($_POST['EliminarUsuario'])){
		$link=Conectarse();
		$bdProv=$link->query("DELETE FROM perfiles WHERE IdPerfil = '$firstUsr'");
		$link->close();
	}

	if(isset($_POST['GuardarUsuario'])){
		if(isset($_POST['Perfil']))			{ $Perfil 				= $_POST['Perfil']; 			}

		$link=Conectarse();
		$bd=$link->query("SELECT * FROM perfiles WHERE IdPerfil = '$firstUsr'");
		if ($row=mysqli_fetch_array($bd)){
			$actSQL="UPDATE perfiles SET ";
			$actSQL.="Perfil				= '".$Perfil.				"'";
			$actSQL.="Where IdPerfil				= '".$firstUsr."'";
			$bdAct = $link->query($actSQL);
		}else{
				$link->query("insert into perfiles(		IdPerfil 				,
														Perfil
														) 
										values 		(	'$firstUsr' 			,
														'$Perfil'
														)");
		}
		$link->close();
		
	}
?>
<!doctype html>
 
<html lang="es">
<head>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Perfiles</title>
	
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	


	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

</head>

<body>
	<?php include('head.php'); ?>
	<div id="linea"></div>

	<!-- Navigation -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-danger static-top">
		<div class="container-fluid">
  	    	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
	          <span class="navbar-toggler-icon"></span>
	        </button>
	    	<div class="collapse navbar-collapse" id="navbarResponsive">
	      		<ul class="navbar-nav ml-auto">
	        		<li class="nav-item active">
	          			<a class="nav-link fa fa-home" href="../plataformaErp.php"> Principal
	                	<span class="sr-only">(current)</span>
	              		</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-desktop" href="../modulos"> Módulos</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-stream" href="../menus"> Menú</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-cog" href="../Perfiles"> Perfiles</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-user" href="../usr"> Usuarios</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-cogs" href="index.php?Accion=Agregar"> Agregar</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="cerrarsesion.php"> Cerrar</a>
	        		</li>

	      		</ul>
	    	</div>
	  	</div>
	</nav>



<!--
	<div class="row bg-danger text-white" style="padding: 5px;">
		<div class="col-1 text-center">
			<img src="../imagenes/about_us_close_128.png" width="40">
		</div>
		<div class="col-10">
			<h4>Usuarios</h4>
		</div>
		<div class="col-1">
				<a href="cerrarsesion.php" title="Cerrar Sesión">
					<img src="../gastos/imagenes/preview_exit_32.png" width="32" height="32">
				</a>
		</div>
	</div>
-->
	<?php include_once('listaPerfiles.php'); ?>
	
	<script src="../jsboot/bootstrap.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script>
		$(document).ready(function() {
    		$('#usuarios').DataTable({
    			"order": [[ 0, "asc" ]]
    		});
    		$('#modulos').DataTable({
    			"order": [[ 0, "asc" ]]
    		});

		} );	
	</script>
</body>
</html>
