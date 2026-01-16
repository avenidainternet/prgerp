<?php
	session_start(); 
	include_once("../conexionli.php");
	include_once("../clases/clases.php");
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

	if(isset($_GET['RAM'])){	
		$RAM 		= $_GET['RAM']; 	
		$link=Conectarse();
		$bdRAM=$link->query("Select * From Cotizaciones Where RAM = '".$RAM."'");
		if($rowRAM=mysqli_fetch_array($bdRAM)){
			$RAMarchivada = 'on';
			if($rowRAM['RAMarchivada']){
				if($rowRAM['RAMarchivada'] == 'on'){
					$RAMarchivada = 'off';
				}else{
					$RAMarchivada = 'on';
				}
			}
			$actSQL="UPDATE Cotizaciones SET ";
			$actSQL.="RAMarchivada	='".$RAMarchivada.	"'";
			$actSQL.="WHERE RAM = '".$RAM."'";
			$bdRAM=$link->query($actSQL);
		}
		$link->close();
	}

	
?>
<!doctype html>
 
<html lang="es">
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Taller Propiedades Mecánicas</title>
	
	<link href="styles.css" 	rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">

	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../">

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

	<script type="text/javascript" src="../angular/angular.js"></script>


	<script>
	function realizaProceso(accion){
		var parametros = {
			"accion" 		: accion
		};
		//alert(accion);
		$.ajax({
			data: parametros,
			url: 'mRAMs.php',
			type: 'get',
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}

	function registraOtams(Otam, accion){
		var parametros = {
			"Otam"			: Otam,
			"accion"		: accion
		};
		//alert(RAM);
		$.ajax({
			data: parametros,
			url: 'rValoresOtam.php',
			type: 'get',
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}
	
	</script>

</head>

<body ng-app="myApp" ng-controller="CtrlCotizaciones" ng-cloak>
	<?php include('head.php'); ?> 
	<div id="linea"></div>
	<div id="Cuerpo">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<img src="../imagenes/talleres.png" width="40" height="40" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					RAM Terminadas
				</strong>
				
				<div id="ImagenBarra">
					<a href="cerrarsesion.php" title="Cerrar Sesión">
						<img src="../gastos/imagenes/preview_exit_32.png" width="32" height="32">
					</a>
				</div>
			</div>
			<?php 
				include_once('listaRAMs.php');
				include_once('mRAMs.php');
			?>
		</div>
		<div style="clear:both;"></div>
				
	</div>
	<br>
	
	<script src="../jsboot/bootstrap.min.js"></script>
	<script src="rams.js"></script>
	
</body>
</html>
