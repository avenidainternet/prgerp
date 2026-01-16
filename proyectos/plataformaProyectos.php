<?php
	//ini_set("session.cookie_lifetime",7200);
	//ini_set("session.gc_maxlifetime",7200);
	session_start(); 
	
	include_once("conexion.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=mysql_query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysql_fetch_array($bdPer)){
			$_SESSION['Perfil']		= $rowPer['Perfil'];
			$_SESSION['IdPerfil']	= $rowPer['IdPerfil'];
		}
		mysql_close($link);
	}else{
		header("Location: ../index.php");
	}
/*
	if($_SESSION[Perfil] != 'WebMaster'){
		header("Location: ../enConstruccion.php");
	}
*/
	$usuario 		= $_SESSION['usuario'];
	$idProyecto		= '';
	$accion			= '';
	$usrApertura 	= $_SESSION['usr'];
	$usrRes 		= $_SESSION['usr'];
	$tpAccion 		= 'Ver';
	
	if(isset($_GET['idProyecto'])) 	{ $idProyecto	= $_GET['idProyecto']; 	}
	if(isset($_GET['accion']))	 	{ $accion		= $_GET['accion']; 		}
	if(isset($_GET['tpAccion']))	{ $tpAccion		= $_GET['tpAccion']; 	}

	if(isset($_POST['idProyecto'])) { $idProyecto 	= $_POST['idProyecto'];	}
	if(isset($_POST['accion']))	  	{ $accion		= $_POST['accion']; 	}
	if(isset($_POST['tpAccion']))	{ $tpAccion		= $_POST['tpAccion']; 	}

	$link=Conectarse();
	$bddCot=mysql_query("Select * From Proyectos Order By idProyecto");
	if($rowdCot=mysql_fetch_array($bddCot)){
		//$nSerie = $rowdCot[nSerie];
	}else{
		$accion = 'Vacio';
	}
	mysql_close($link);

	if($accion=='Imprimir'){
		//header("Location: formularios/fichaEquipo.php?nSerie=$nSerie");
	}
	
	if(isset($_POST['confirmarBorrar'])){
		$link=Conectarse();
		$bdCot =mysql_query("Delete From Proyectos Where idProyecto = '".$idProyecto."'");
		mysql_close($link);
		$idProyecto = '';
		$accion		 = '';
	}
	
	if(isset($_POST['guardarProyecto'])){
		if(isset($_POST['idProyecto'])) 		{ $idProyecto			= $_POST['idProyecto'];			}
		if(isset($_POST['Proyecto'])) 			{ $Proyecto 			= $_POST['Proyecto'];			}
		if(isset($_POST['JefeProyecto'])) 		{ $JefeProyecto 		= $_POST['JefeProyecto'];		}
		if(isset($_POST['Rut_JefeProyecto'])) 	{ $Rut_JefeProyecto		= $_POST['Rut_JefeProyecto'];	}
		if(isset($_POST['Email'])) 				{ $Email 				= $_POST['Email'];				}
		if(isset($_POST['Banco'])) 				{ $Banco				= $_POST['Banco'];				}
		if(isset($_POST['Cta_Corriente'])) 		{ $Cta_Corriente		= $_POST['Cta_Corriente'];		}
		if(isset($_POST['Banco2'])) 			{ $Banco2				= $_POST['Banco2'];				}
		if(isset($_POST['Cta_Corriente2'])) 	{ $Cta_Corriente2		= $_POST['Cta_Corriente2'];		}

		$link=Conectarse();
		$bdCot=mysql_query("Select * From Proyectos Where idProyecto = '".$idProyecto."'");
		if($rowCot=mysql_fetch_array($bdCot)){
			$actSQL="UPDATE Proyectos SET ";
			$actSQL.="Proyecto			='".$Proyecto.			"',";
			$actSQL.="JefeProyecto		='".$JefeProyecto.		"',";
			$actSQL.="Rut_JefeProyecto	='".$Rut_JefeProyecto.	"',";
			$actSQL.="Email				='".$Email.				"',";
			$actSQL.="Banco				='".$Banco.				"',";
			$actSQL.="Cta_Corriente		='".$Cta_Corriente.		"',";
			$actSQL.="Banco2			='".$Banco2.			"',";
			$actSQL.="Cta_Corriente2	='".$Cta_Corriente2.	"'";
			$actSQL.="WHERE idProyecto	= '".$idProyecto."'";
			$bdCot=mysql_query($actSQL);
		}else{
			mysql_query("insert into Proyectos(	
															idProyecto,
															Proyecto,
															JefeProyecto,
															Rut_JefeProyecto,
															Email,
															Banco,
															Cta_Corriente,
															Banco2,
															Cta_Corriente2
															) 
												values 	(	
															'$idProyecto',
															'$Proyecto',
															'$JefeProyecto',
															'$Rut_JefeProyecto',
															'$Email',
															'$Banco',
															'$Cta_Corriente',
															'$Banco2',
															'$Cta_Corriente2'
					)",
			$link);
		}
		mysql_close($link);
		$idProyecto		= '';
		$accion			= '';
	}

?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Intranet Simet -> Gestion de Actividades</title>
	
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	
	<script src="../jquery/jquery-1.6.4.js"></script>

	<link href="styles.css" 	rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<script>
	function realizaProceso(usrRes, tpAccion){
		var parametros = {
			"usrRes" 	: usrRes,
			"tpAccion"  : tpAccion
		};
		//alert(tpAccion);
		$.ajax({
			data: parametros,
			url: 'muestraProyectos.php',
			type: 'get',
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}
	
	function registraProyectos(idProyecto, accion){
		var parametros = {
			"idProyecto"	: idActividad,
			"accion"		: accion
		};
		//alert(nSerie);
		$.ajax({
			data: parametros,
			url: 'regProyecto.php',
			type: 'get',
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
				<img src="../imagenes/viewtimetables_48.png" width="40" height="40" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					Proyectos 
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
					<a href="../plataformaErp.php" title="Menú Principal">
						<img src="../gastos/imagenes/Menu.png" width="32" height="32">
					</a>
				</div>
			</div>
			<?php include_once('listaProyectos.php'); 
			if($accion == 'Actualizar' or $accion == 'Borrar' or $accion == 'Vacio'){
				?>
				<script>
					var idProyecto	= "<?php echo $idProyecto; ?>" ;
					var accion 		= "<?php echo $accion; ?>" ;
					registraProyectos(idProyecto, accion);
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
