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

<div class="row bg-dark text-white">
	<div class="col-3">
		<a class="btn btn-danger btn-lg btn-block" href="#" id="Terminado">Termino Trabajo</a>
	</div>
	<div class="col-1">
	</div>
	<div class="col-3">
		<a class="btn btn-info btn-lg btn-block" href="formularios/iRam.php?RAM=<?php echo $RAM; ?>" id="Imprimir">Imprimir</a>
	</div>
	<div class="col-1">
	</div>
	<div class="col-4">
		<a class="btn btn-success btn-lg btn-block" href="#" id="volver">Volver</a>
	</div>
</div>
<!--
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <a class="navbar-brand" href="#">Menú</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="btn btn-primary btn-lg" href="#"id="Terminado">Matar</a>
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
-->
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
				<div class="row">
					<div class="col-4">
						<h4>RAM: <b><?php echo $RAM; ?></b></h4>
					</div>
					<div class="col-2">
					</div>
					<div class="col-3 text-center">
						Inicio
					</div>
					<div class="col-3 text-center">
						Termino
					</div>
				</div>
				<?php
					$link=Conectarse();
					$SQL = "Select * From ammuestras Where idItem like '%$RAM%'";
					//echo $SQL;
					$bd=$link->query($SQL);
					if($row=mysqli_fetch_array($bd)){
					}
					$link->close();
				?>
				<div class="row">
					<div class="col-6">
					</div>
					<div class="col-3 text-center">
						<?php 
							$fd = explode('-',$row['fechaTaller']);
							echo '<h4>'.$fd[2].'-'.$fd[1].'-'.$fd[0].'<h4>'; 
						?>
					</div>
					<div class="col-3 text-center">
						<?php 
							$fd = explode('-',$row['fechaHasta']);
							echo '<h4>'.$fd[2].'-'.$fd[1].'-'.$fd[0].'<h4>'; 
						?>
					</div>
				</div>

				<hr>

				<div class="row">
					<div class="col-3">
						<h4>Solicitado por:</h4>
					</div>
					<div class="col-9">
						<?php
							//Responsables
								$link=Conectarse();
								$SQLfr = "Select * From formram Where RAM = $RAM";
								//echo $SQL;
								$bdfr=$link->query($SQLfr);
								if($rowfr=mysqli_fetch_array($bdfr)){?>
									<h4>
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
									</h4>
								<?php
								}
								$link->close();
						?>
					</div>
				</div>


				<?php
					//Muestras
						$nMuestra = 0;
						$link=Conectarse();
						$SQLot = "Select * From ammuestras Where idItem like '%".$RAM."%'";
						$bdot=$link->query($SQLot);
						while($rowot=mysqli_fetch_array($bdot)){?>
								<hr>
								<div class="row">
									<div class="col-3">
										<?php $nMuestra++; ?>
										<h5><b>Muestra <?php echo $nMuestra; ?> : <?php echo $rowot['idItem']; ?></b></h5>   
									</div>
									<div class="col-9">
										<b><?php echo $rowot['idMuestra']; ?></b>
									</div>
								</div>

								<hr>

								<div class="row">
									<div class="col">
										Objetivo:
									</div>
								</div>
								<div class="row">
									<div class="col-1">
									</div>
									<div class="col-11">
										<?php 
											if($rowot['Objetivo']){
												echo $rowot['Objetivo']; 
											}else{
												echo 'Sin Definir';
											}
										?>
									</div>
								</div>
								<hr>
								<?php
									if($rowot['Plano']){?>
										<div class="row">
											<div class="col">
												<?php
													$imgPlano = '../otamsajax/Planos/AM-'.$RAM.'/'.$rowot['Plano'];
													//echo $imgPlano;
												?>
												<a href="<?php echo $imgPlano; ?>" target="_blank"><img width="50%" src="<?php echo $imgPlano; ?>"></a>
											</div>
										</div>
										<?php
									}
								?>
								<div class="row">
									<div class="col">
										Ensayos:
									</div>
								</div>
								<div class="row">
									<div class="col">
										<?php
											$SQLce = "SELECT * FROM amtabensayos Where idItem = '".$rowot['idItem']."'";
											$bdce=$link->query($SQLce);
											while($rowce=mysqli_fetch_array($bdce)){
												echo $rowce['idEnsayo']."(".$rowce['cEnsayos'].")";
											}
										?>
									</div>
								</div>
							<?php
						}
						$link->close();
				?>
				<hr>
				Observación:
				
				<hr>
				Fecha de entrega de muestra preparada :
				
				<hr>
				Nombre del técnico responsable :

				<hr>
				Persona que recibe el trabajo :
				<div class="row">
					<div class="col-10">
					</div>
					<div class="col-2">
						Reg 2402-V.03
					</div>	
				</div>


			</div>
		</div>
	</div>



</div>
</body>
</html>