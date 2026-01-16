<?php
	session_start(); 
	date_default_timezone_set("America/Santiago");
	//header('Content-Type: text/html; charset=utf-8'); 
	
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
/*
	if($_SESSION['Perfil'] != 'WebMaster'){
		header("Location: ../enConstruccion.php");
	}
*/
	$usuario 	= $_SESSION['usuario'];
	$accion 	= '';

	$fechaHoy 		= date('Y-m-d');
	$fd 			= explode('-', $fechaHoy);
	$AgnoAtr		= 0;
	$MesAtr			= 'No';
	$Clasificacion	= 0;
	
	if(isset($_GET['AgnoAtr'])) 		{ $AgnoAtr 			= $_GET['AgnoAtr']; 		}
	if(isset($_GET['MesAtr'])) 			{ $MesAtr 			= $_GET['MesAtr']; 			}
	if(isset($_GET['Clasificacion'])) 	{ $Clasificacion 	= $_GET['Clasificacion']; 	}
	
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>
	PAM Atrazadas
</title>
	
	<link href="../css/styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">
	<link href="../estilos.css" 	rel="stylesheet" type="text/css">

</head>

<body>
	<?php include_once('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<img src="../imagenes/indicador.png" width="40" height="40" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					<?php
					if($Clasificacion == 0){?>
						PAM Atrazadas
						<?php
					}
					if($Clasificacion == 1){?>
						PAM Atrazadas <img src="../imagenes/estrella.png" width="20"> <img src="../imagenes/estrella.png" width="20"> <img src="../imagenes/estrella.png" width="20">
						<?php
					}
					if($Clasificacion == 2){?>
						PAM Atrazadas <img src="../imagenes/estrella.png" width="20"> <img src="../imagenes/estrella.png" width="20">
						<?php
					}
					if($Clasificacion == 3){?>
						PAM Atrazadas <img src="../imagenes/estrella.png" width="20">
						<?php
					}
					?>
				</strong>

				<div id="ImagenBarra">
					<a href="cerrarsesion.php" title="Cerrar Sesión">
						<img src="../gastos/imagenes/preview_exit_32.png" width="32" height="32">
					</a>
				</div>
			</div>
			<?php include_once('barraSupIconosRev.php'); ?>
		</div>
	</div>
	
	<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloSel">
		<tr>
			<td  width="02%" align="center" height="40">N°							</td>
			<td  width="08%" align="center" height="40">RAM	/ CAM					</td>
			<td  width="13%">							Fecha <br>Cotización		</td>
			<td  width="25%">							Cliente						</td>
			<td  width="13%">							Fecha Ingreso <br>a PAM				</td>
			<td  width="13%">							Días<br>Habiles				</td>
			<td  width="13%">							Fecha Prometida <br>Fecha Término			</td>
			<!-- <td  width="13%" align="center">			Atrazo						</td> -->
		</tr>
		<?php
			$tr = 'bVerdeSel';
			$i = 0;
			$link=Conectarse();
			$SQL = "SELECT * FROM Cotizaciones Where Estado = 'T' and year(fechaInicio) = $AgnoAtr and month(fechaInicio) = $MesAtr";
			$bdIm=$link->query($SQL);
			if($rowIm=mysqli_fetch_array($bdIm)){
				do{
/*					
					$fechaTermino 	= strtotime ( '+'.$rowIm['dHabiles'].' day' , strtotime ( $rowIm['fechaInicio'] ) );
					$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );
*/
			$fechaInicio = $rowIm['fechaInicio'];
			$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
			$ft = $fechaInicio;
			$dh	= $rowIm['dHabiles'] - 1;

			$dd	= 0;
			for($j=1; $j<=$dh; $j++){
				$ft	= strtotime ( '+'.$j.' day' , strtotime ( $fechaInicio ) );
				$ft	= date ( 'Y-m-d' , $ft );
				//echo $ft.'<br>';
				$dia_semana = date("w",strtotime($ft));
				if($dia_semana == 0 or $dia_semana == 6){
					$dh++;
					$dd++;
				}
				$SQL = "SELECT * FROM diasferiados Where fecha = '".$ft."'";
				$bdDf=$link->query($SQL);
				if($row=mysqli_fetch_array($bdDf)){
					$dh++;
					$dd++;
				}
			}
			$fechaTermino = $ft;

					
					if($rowIm['fechaTermino'] > $fechaTermino){
						$bdIR=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowIm['RutCli']."'");
						if($Clasificacion > 0){
							$bdIR=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowIm['RutCli']."' and Clasificacion = $Clasificacion");
						}
						if($rowIR=mysqli_fetch_array($bdIR)){
							$i++;
							?>
							<tr class="<?php echo $tr; ?>">
								<td><?php echo $i; ?>	</td>
								<td><?php echo 'R'.$rowIm['RAM'].'<br>'.'C'.$rowIm['CAM']; ?>	</td>
								<td><?php echo $rowIm['fechaCotizacion']; ?>					</td>
								<td>
									<?php 
										echo $rowIR['Cliente'];
										if($Clasificacion == 0){
											if($rowIR['Clasificacion'] == 1){?>
												<img src="../imagenes/estrella.png" width="10"> <img src="../imagenes/estrella.png" width="10"> <img src="../imagenes/estrella.png" width="10">
												<?php
											}	
											if($rowIR['Clasificacion'] == 2){?>
												<img src="../imagenes/estrella.png" width="10"> <img src="../imagenes/estrella.png" width="10">
												<?php
											}	
											if($rowIR['Clasificacion'] == 3){?>
												<img src="../imagenes/estrella.png" width="10">
												<?php
											}	
										}
									?>
								</td>
								<td><?php echo $rowIm['fechaInicio']; ?>						</td>
								<td><?php echo $rowIm['dHabiles']; ?>							</td>
								<td>
									<?php echo 'Prom. '.$fechaTermino.'<br>Term. '.$rowIm['fechaTermino']; ?>		
								</td>
								<!-- <td>
									<?php 
/*									
										$fechaTermino 	= strtotime ( '+'.$rowIm['dHabiles'].' day' , strtotime ( $rowIm['fechaInicio'] ) );
										$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );
										$diff = abs(strtotime($rowIm['fechaTermino']) - strtotime($fechaTermino));
										$years = floor($diff / (365*60*60*24));
										$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
										$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
										echo $days; 
*/										
									?>
								</td> -->
							</tr>
						<?php
						}
					}
				}while ($rowIm=mysqli_fetch_array($bdIm));
			} 
			$link->close();
		?>
		
	</table>
</body>
</html>


