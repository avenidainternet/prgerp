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

	if(isset($_POST['usr'])){ $firstUsr = $_POST['usr']; }

	if(isset($_POST['EliminarUsuario'])){
		$status = 'off';
		$link=Conectarse();
		$actSQL="UPDATE usuarios SET ";
		$actSQL.="status				= '".$status.				"'";
		$actSQL.="Where usr				= '".$firstUsr."'";
		$bdAct = $link->query($actSQL);
/*
		$bdProv=$link->query("DELETE FROM usuarios WHERE usr = '$firstUsr'");
		$link->close();
*/
	}
	
	if(isset($_POST['ActivarUsuario'])){
		$status = 'on';
		$link=Conectarse();
		$actSQL="UPDATE usuarios SET ";
		$actSQL.="status				= '".$status.				"'";
		$actSQL.="Where usr				= '".$firstUsr."'";
		$bdAct = $link->query($actSQL);
/*
		$bdProv=$link->query("DELETE FROM usuarios WHERE usr = '$firstUsr'");
		$link->close();
*/
	}

	if(isset($_POST['GuardarUsuario'])){

/*		$nombre_archivo = $_FILES['imgFirma']['name'];
		$tipo_archivo 	= $_FILES['imgFirma']['type'];
		$tamano_archivo = $_FILES['imgFirma']['size'];
		$desde 			= $_FILES['imgFirma']['tmp_name'];
*/		

			echo $_FILES['imagen']['name'];

		$Firma = '';
		if(isset($_FILES['imagen']['name'])){
			$directorio="../ft";

			if (($_FILES['imagen']['type'] == "image/jpeg" or $_FILES['imagen']['type'] == "image/png" or $_FILES['imagen']['type'] == "image/gif") ) { 
				if($_FILES['imagen']['type'] == "image/jpeg")	{ $firmaPie = $firstUsr.'.jpg'; }
				if($_FILES['imagen']['type'] == "image/png")	{ $firmaPie = $firstUsr.'.png'; }
				if($_FILES['imagen']['type'] == "image/gif")	{ $firmaPie = $firstUsr.'.gif'; }

				if (move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio."/".$firmaPie)){ 
					$Firma = $firmaPie;
				}
			}
		}

		if(isset($_POST['usuario']))			{ $usuario 				= $_POST['usuario']; 			}
		if(isset($_POST['cargoUsr']))			{ $cargoUsr 			= $_POST['cargoUsr']; 			}
		if(isset($_POST['nPerfil']))			{ $nPerfil 				= $_POST['nPerfil']; 			}
		if(isset($_POST['email']))				{ $email 				= $_POST['email']; 				}
		if(isset($_POST['celular']))			{ $celular 				= $_POST['celular']; 			}
		if(isset($_POST['responsableInforme']))	{ $responsableInforme 	= $_POST['responsableInforme']; 	}
		if(isset($_POST['titPie']))				{ $titPie 				= $_POST['titPie']; 			}
		if(isset($_POST['apruebaOfertas']))		{ $apruebaOfertas 		= $_POST['apruebaOfertas']; 			}
		if(isset($_POST['pwd']))				{ $pwd 					= $_POST['pwd']; 				}

		$link=Conectarse();
		$bd=$link->query("SELECT * FROM usuarios WHERE usr = '$firstUsr'");
		if ($row=mysqli_fetch_array($bd)){
			if($row['firmaUsr']){
				$Firma = $row['firmaUsr'];
			}
			$actSQL="UPDATE usuarios SET ";
			$actSQL.="usuario				= '".$usuario.				"',";
			$actSQL.="cargoUsr				= '".$cargoUsr.				"',";
			$actSQL.="nPerfil				= '".$nPerfil.				"',";
			$actSQL.="email					= '".$email.				"',";
			$actSQL.="celular				= '".$celular.				"',";
			$actSQL.="responsableInforme	= '".$responsableInforme.	"',";
			$actSQL.="titPie				= '".$titPie.				"',";
			$actSQL.="apruebaOfertas		= '".$apruebaOfertas.		"',";
			$actSQL.="pwd					= '".$pwd.					"',";
			$actSQL.="firmaUsr				= '".$Firma.				"'";
			$actSQL.="Where usr				= '".$firstUsr."'";
			$bdAct = $link->query($actSQL);
		}else{
				$link->query("insert into usuarios(		usr 					,
														usuario 				,
														cargoUsr 				,
														nPerfil 				,
														email 					,
														celular 				,
														responsableInforme 		,
														titPie 					,
														apruebaOfertas 			,
														pwd
														) 
										values 		(	'$firstUsr' 			,
														'$usuario' 				,
														'$cargoUsr' 			,
														'$nPerfil' 				,
														'$email' 				,
														'$celular' 				,
														'$responsableInforme' 	,
														'$titPie' 				,
														'$apruebaOfertas' 		,
														'$pwd'
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

	<title>Usuarios</title>
	
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



				<a class="navbar-brand" href="#">
					<img src="../imagenes/simet.png" alt="logo" style="width:40px;">
				</a>



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
	          			<a class="nav-link fas fa-user-plus" href="index.php?Accion=Agregar"> Agregar</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="cerrarsesion.php"> Cerrar</a>
	        		</li>


    <!-- Dropdown -->
    <!--
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle fas fa-power-off" href="#" id="navbardrop" data-toggle="dropdown">
        Dropdown link
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="#">Link 1</a>
        <a class="dropdown-item" href="#">Link 2</a>
        <a class="dropdown-item" href="#">Link 3</a>
      </div>
    </li>
	-->

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
	<?php include_once('listaUsuarios.php'); ?>
	
	<script src="../jsboot/bootstrap.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script>
		$(document).ready(function() {
    		$('#usuarios').DataTable({
    			"order": [[ 0, "asc" ]]
    		});

		} );	
	</script>
</body>
</html>
