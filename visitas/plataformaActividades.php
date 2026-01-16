<?php
	ini_set("session.cookie_lifetime",60);
	ini_set("session.gc_maxlifetime",60);
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
	$idActividad	= '';
	$accion			= '';
	$usrApertura 	= $_SESSION['usr'];
	$usrRes 		= $_SESSION['usr'];
	$actRepetitiva 	= '';
	$prgActividad 	= '';
	$tpoProx 		= '';
	$tpoAvisoAct 	= '';
	
	if(isset($_GET['idVisita']))	{ $idVisita	= $_GET['idVisita']; 	}
	if(isset($_GET['accion']))	 	{ $accion	= $_GET['accion']; 		}
	if(isset($_GET['tpAccion']))	{ $tpAccion	= $_GET['tpAccion']; 	}

	if(isset($_POST['idVisita']))	{ $idVisita = $_POST['idVisita'];	}
	if(isset($_POST['accion']))	  	{ $accion	= $_POST['accion']; 	}
	if(isset($_POST['tpAccion']))	{ $tpAccion	= $_POST['tpAccion']; 	}

	$link=Conectarse();
	$bddCot=mysql_query("Select * From Visitas Order By idVisita");
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
		$bdCot =mysql_query("Delete From Visitas Where idVisita = '".$idVisita."'");
		mysql_close($link);
		$idVisita 	= '';
		$accion		= '';
	}
	
	if(isset($_POST['guardarSeguimiento'])){
		if(isset($_POST['idVisita']))		{ $idVisita			= $_POST['idVisita'];		}
		if(isset($_POST['realizadaAct']))	{ $realizadaAct 	= $_POST['realizadaAct'];	}
		if(isset($_POST['fechaAccionAct']))	{ $fechaAccionAct	= $_POST['fechaAccionAct'];	}
		if(isset($_POST['registradaAct']))	{ $registradaAct	= $_POST['registradaAct'];	}
		if(isset($_POST['fechaRegAct']))	{ $fechaRegAct		= $_POST['fechaRegAct'];	}
		if(isset($_POST['RutCli']))			{ $RutCli			= $_POST['RutCli'];			}

		$link=Conectarse();
		$bdCot=mysql_query("Select * From Visitas Where idVisita = '".$idVisita."'");
		if($rowCot=mysql_fetch_array($bdCot)){
			$Actividad 			= $rowCot['Actividad'];
			$usrResponsable 	= $rowCot['usrResponsable'];
			$fechaTentativaAct 	= $rowCot['fechaProxAct'];
			$prgHistorial 		= $rowCot['fechaProxAct'];
			$prgActividad 		= date('Y-m-d');
			
			if($realizadaAct=='on'){
				$Estado = 'T';
				if($rowCot['actRepetitiva']=='on'){
					$Estado = 'P';
					$tpoProx 		= $rowCot['tpoProx'];
					$fechaProxAct 	= strtotime ( '+'.$tpoProx.' day' , strtotime ( $fechaRegAct ) );
					$fechaProxAct 	= date ( 'Y-m-d' , $fechaProxAct );
				}
			}

			$actSQL="UPDATE Visitas SET ";
			$actSQL.="realizadaAct		='".$realizadaAct.	"',";
			$actSQL.="fechaAccionAct	='".$fechaAccionAct."',";
			$actSQL.="registradaAct		='".$registradaAct.	"',";
			$actSQL.="fechaRegAct		='".$fechaRegAct.	"',";
			$actSQL.="prgActividad		='".$fechaRegAct.	"',";
			$actSQL.="fechaProxAct		='".$fechaProxAct.	"',";
			$actSQL.="Estado			='".$Estado.		"'";
			$actSQL.="Where idVisita	= '".$idVisita."'";
			$bdCot=mysql_query($actSQL);

			if($fechaRegAct > '000-00-00'){
				$bdHis=mysql_query("Select * From visitasHistorial Where idVisita = '".$idVisita."' and prgActividad = '".$prgHistorial."'");
				if($rowHis=mysql_fetch_array($bdHis)){

				}else{
					mysql_query("insert into visitasHistorial(	
																idVisita,
																prgActividad,
																fechaActividad,
																Actividad,
																fechaRegistro,
																RutCli,
																usrResponsable
																) 
													values 	(	
																'$idVisita',
																'$prgHistorial',
																'$fechaAccionAct',
																'$Actividad',
																'$fechaRegAct',
																'$RutCli',
																'$usrResponsable'
						)",$link);
				}
			}
		}
		mysql_close($link);
		$idVisita	= '';
		$accion		= '';
	}
	
	if(isset($_POST['guardarActividad'])){
		if(isset($_POST['idVisita'])) 	{ $idVisita		= $_POST['idVisita'];	}
		if(isset($_POST['Actividad'])) 	{ $Actividad 	= $_POST['Actividad'];	}
		if(isset($_POST['RutCli'])) 	{ $RutCli 		= $_POST['RutCli'];		}
		if(isset($_POST['Cliente'])) 	{ $Cliente 		= $_POST['Cliente'];	}

		if(isset($_POST['actRepetitiva'])) 	{ $actRepetitiva 	= $_POST['actRepetitiva'];	}
		if(isset($_POST['prgActividad'])) 	{ $prgActividad 	= $_POST['prgActividad'];	}
		if(isset($_POST['tpoProx'])) 		{ $tpoProx			= $_POST['tpoProx'];		}
		if(isset($_POST['tpoAvisoAct'])) 	{ $tpoAvisoAct		= $_POST['tpoAvisoAct'];	}
		if(isset($_POST['fechaRegAct'])) 	{ $fechaRegAct 		= $_POST['fechaRegAct'];	}
		if(isset($_POST['Conclusion'])) 	{ $Conclusion 		= $_POST['Conclusion'];		}
		if(isset($_POST['usrResponsable'])) { $usrResponsable	= $_POST['usrResponsable'];	}

		$link=Conectarse();
		$bdCl=mysql_query("Select * From Clientes Where Cliente = '".$Cliente."'");
		if($rowCl=mysql_fetch_array($bdCl)){
			$RutCli = $rowCl['RutCli'];
		}
		
		$bdCot=mysql_query("Select * From Visitas Where idVisita = '".$idVisita."'");
		if($rowCot=mysql_fetch_array($bdCot)){
			$actSQL="UPDATE Visitas SET ";
			$actSQL.="Actividad			='".$Actividad.		"',";
			$actSQL.="RutCli			='".$RutCli.		"',";
			$actSQL.="actRepetitiva		='".$actRepetitiva.	"',";
			$actSQL.="prgActividad		='".$prgActividad.	"',";
			$actSQL.="tpoProx			='".$tpoProx.		"',";
			$actSQL.="tpoAvisoAct		='".$tpoAvisoAct.	"',";
			$actSQL.="fechaRegAct		='".$fechaRegAct.	"',";
			$actSQL.="Conclusion		='".$Conclusion.	"',";
			$actSQL.="usrResponsable	='".$usrResponsable."'";
			$actSQL.="WHERE idVisita	= '".$idVisita."'";
			$bdCot=mysql_query($actSQL);
		}else{
			mysql_query("insert into Visitas(	
															idVisita,
															Actividad,
															RutCli,
															actRepetitiva,
															prgActividad,
															tpoProx,
															tpoAvisoAct,
															fechaRegAct,
															Conclusion,
															usrResponsable
															) 
												values 	(	
															'$idVisita',
															'$Actividad',
															'$RutCli',
															'$actRepetitiva',
															'$prgActividad',
															'$tpoProx',
															'$tpoAvisoAct',
															'$fechaRegAct',
															'$Conclusion',
															'$usrResponsable'
					)",
			$link);
		}
		mysql_close($link);
		$idVisita	= '';
		$accion		= '';
	}

?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Registro de Visitas</title>
	
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	
	<script src="../jquery/jquery-1.6.4.js"></script>

	<link href="styles.css" rel="stylesheet" type="text/css">
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
			url: 'muestraActividades.php',
			type: 'get',
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}
	
	function registraActividad(idVisita, accion){
		var parametros = {
			"idVisita"	: idVisita,
			"accion"	: accion
		};
		//alert(nSerie);
		$.ajax({
			data: parametros,
			url: 'regActividad.php',
			type: 'get',
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}
	
	function seguimientoActividad(idVisita, accion, tpAccion){
		var parametros = {
			"idVisita" 	: idVisita,
			"accion"	: accion,
			"tpAccion"	: tpAccion
		};
		//alert(idVisita);
		$.ajax({
			data: parametros,
			url: 'segActividad.php',
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
				<img src="../imagenes/contactus_128.png" width="40" height="40" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					Visitas 
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
			<?php include_once('listaActividad.php'); 
			if($accion == 'Seguimiento'){?>
				<script>
					var idVisita	= "<?php echo $idVisita; 	?>" ;
					var accion 		= "<?php echo $accion; 		?>" ;
					var tpAccion 	= "<?php echo $tpAccion; 	?>" ;
					seguimientoActividad(idVisita, accion, tpAccion);
				</script>
				<?php
			}
			if($accion == 'Actualizar' or $accion == 'Borrar' or $accion == 'Vacio'){
				?>
				<script>
					var idVisita	= "<?php echo $idVisita; 	?>" ;
					var accion 		= "<?php echo $accion; 		?>" ;
					registraActividad(idVisita, accion);
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
