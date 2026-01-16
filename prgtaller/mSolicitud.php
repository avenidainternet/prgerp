<!doctype html>
 
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../cssboot/bootstrap.min.css">
  <script src="../jquery/jquery-3.3.1.min.js"></script>
  <script src="../jquery/ajax/popper.min.js"></script>
  <script src="../jsboot/bootstrap.min.js"></script>
	<!-- <meta content="30" http-equiv="REFRESH"> </meta> -->

	<meta name="description" 	content="Laboratorio Universidad Santiago de Chile Metalurgica" />
	<meta name="keywords" 		content="Laboratorio Materiales, USACH, Simet, Ensayos de Traccóon, Ensayos de Impacto, " />
	<meta name="author" 		content="Francisco Olivares">
	<meta name="robots" 		content="índice, siga" />
	<meta name="revisit-after" 	content="3 mes" />

	<link rel="shortcut icon" href="favicon.ico" />
	<link rel="apple-touch-icon" href="touch-icon-iphone.png" />
	<link rel="apple-touch-icon" href="touch-icon-ipad.png" />
	<link rel="apple-touch-icon" href="touch-icon-iphone4.png" />

	<title>Simet Ingeniería y Servicios Tecnológicos :: Laboratorio de Ensayos de Materiales</title>

	<link href="tpv.css" 		rel="stylesheet" type="text/css">
	<link href="stylesTv.css" 	rel="stylesheet" type="text/css">

	<script>
		$(document).ready(function(){
			$("#volver").click(function(){
				history.go(-1);
			});
			$("#Terminado").click(function(){
				var RAM = $("#RAM").val();
				$.get('cerrarTrabajo.php?RAM='+RAM, function(data){
					if(data){
						$('#respuesta').text('Guardado...');
					}
				});
				//window.open('cerrarTrabajo.php?RAM='+RAM);
				history.go(-1);
			});
		});
	</script>
	<style>
		#tituloSolicitud {
			width			: 100%;
			border-bottom	: 2px solid #000;
			border-top		: 2px solid #000;
			text-align		: center;
			background-color: LightGray;
		}
		#tituloSolicitud tit{
			color			: #000;
			font-family		: Arial;
			font-size		: 40px;
		}
		#formatoEnsayos {
			font-family		: Arial;
			font-weight		: bold;
			padding			: 10px;
			font-size		: 16px;
		}
		#formatoEnsayos .lineaSeparador {
			border-bottom	: 1px solid #000;
			padding-bottom	: 10px;
		}
		#formatoEnsayos .lineaSeparador.izq {
			float			: right;
		}
		
	</style>
</head>

<body>
	
<?php
include_once("../conexionli.php");
include_once("../inc/funciones.php");
if(isset($_GET['RAM'])){ $RAM = $_GET['RAM']; }
?>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <a class="navbar-brand" href="#">Menú</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="#"id="Terminado"><img src="../imagenes/Confirmation_32.png" width="40"></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#"><img src="../imagenes/printer_128_hot.png" width="40"></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="volver" href="#"><img src="../imagenes/volver.png" width="40"></a>
      </li>
    </ul>
  </div>  
</nav>

<div class="container" style="margin-top:30px">


	<div id="cajaRegistraPrueba">
		<div id="tablaDatosAjax">
			<div id="tituloSolicitud" style="height:45px;">
				<?php
					$link=Conectarse();
					$SQL = "Select * From formram Where RAM = $RAM";
					//echo $SQL;
					$bdCot=$link->query($SQL);
					if($rowCot=mysqli_fetch_array($bdCot)){?>
					
						<h1><p class="text-white-50 bg-dark">Solicitud Servicio de Taller N° <?php echo $rowCot['nSolTaller']; ?></p></h1>
						<div style="float:right; padding-right:10px;">
							<input type="hidden" id="RAM" value="<?php echo $RAM; ?>">
							<!--
							<button title="Imprimir">
								<img src="../imagenes/printer_128_hot.png" width="50">
							</button>
							<button id="Terminado" title="Terminado">
								<img src="../imagenes/Confirmation_32.png" width="50">
							</button>
							<button id="volver" title="Volver">
								<img src="../imagenes/volver.png" width="50">
							</button>
							-->
						</div>
						<?php 
					} 
					?>
			</div>
			<div id="formatoEnsayos">
				<div class="lineaSeparador">
					<?php
						$link=Conectarse();
						$SQL = "Select * From cotizaciones Where RAM = $RAM";
						//echo $SQL;
						$bdCot=$link->query($SQL);
						if($rowCot=mysqli_fetch_array($bdCot)){?>
							RAM: <?php echo $RAM; ?>
							<span style="float: right;">Fecha Programación : <input name="fechaTaller" type="date" value="<?php echo $rowCot['fechaInicio']; ?>"></span>
						<?php
						}
						$link->close();
						?>
				</div>
				<div class="lineaSeparador">
				<?php
					//Responsables
						$link=Conectarse();
						$SQLfr = "Select * From formram Where RAM = $RAM";
						//echo $SQL;
						$bdfr=$link->query($SQLfr);
						if($rowfr=mysqli_fetch_array($bdfr)){?>
							Solicitado por: 
							<?php 
								$SQLus = "Select * From usuarios Where usr = '".$rowfr['ingResponsable']."'";
								$bdus=$link->query($SQLus);
								if($rowus=mysqli_fetch_array($bdus)){
									echo $rowus['usuario']; 
								}
								$SQLus = "Select * From usuarios Where usr = '".$rowfr['cooResponsable']."'";
								$bdus=$link->query($SQLus);
								if($rowus=mysqli_fetch_array($bdus)){
									echo ' - '.$rowus['usuario']; 
								}
							?>
						<?php
						}
						$link->close();
				?>
				</div>
				<?php
					//Muestras
						$nMuestra = 0;
						$link=Conectarse();
						$SQLot = "Select * From ammuestras Where idItem like '%".$RAM."%'";
						$bdot=$link->query($SQLot);
						if($rowot=mysqli_fetch_array($bdot)){
							do{
								echo '<div class="lineaSeparador">';
								$nMuestra++;
								echo 'Muestra '.$nMuestra.' : '.$rowot['idItem'];
								echo '</div>';
								$SQLmu = "Select * From ammuestras Where idItem like '%$RAM%' and Taller = 'on'";
								$bdmu=$link->query($SQLmu);
								if($rowmu=mysqli_fetch_array($bdmu)){
									echo '<div class="lineaSeparador" style="padding-bottom: 100px;">';
									echo 'Objetivo : ';

									$SQLce = "SELECT * FROM amtabensayos Where idItem = '".$rowmu['idItem']."'";
									$bdce=$link->query($SQLce);
									if($rowce=mysqli_fetch_array($bdce)){
										do{
											echo $rowce['idEnsayo']."(".$rowce['cEnsayos'].")";
										}while($rowce=mysqli_fetch_array($bdce));
									}

									echo '<br><span style="padding-left:20px;">'.$rowmu['Objetivo'].'</span>';
									echo '</div>';
								}
							}while ($rowot=mysqli_fetch_array($bdot));
						}
						$link->close();
				?>
				<div class="lineaSeparador">
				Observación:
				</div>
				<div class="lineaSeparador">
				Fecha de entrega de muestra preparada :
				</div>
				<div class="lineaSeparador">
				Nombre del técnico responsable :
				</div>
				<div class="lineaSeparador">
				Persona que recibe el trabajo :
				</div>
				<div style="padding:10px;">
					<span style="float: right;">Reg 2402-V.03</span>
					<div id="Respuesta"></div>
				</div>
				
			</div>
		</div>
	</div>



</div>
</body>
</html>