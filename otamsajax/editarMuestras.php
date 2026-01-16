<?php

	$Estado = array(
					1 => 'Todos', 
					2 => 'Pendientes',
					3 => 'Terminados',
					4 => 'Sin Informe'
				);

	$Mes = array(
					1 => 'Enero', 
					2 => 'Febrero',
					3 => 'Marzo',
					4 => 'Abril',
					5 => 'Mayo',
					6 => 'Junio',
					7 => 'Julio',
					8 => 'Agosto',
					9 => 'Septiembre',
					10 => 'Octubre',
					11 => 'Noviembre',
					12 => 'Diciembre'
				);
				
	$MesNum = array(	
					'Enero' 		=> '01', 
					'Febrero' 		=> '02',
					'Marzo' 		=> '03',
					'Abril' 		=> '04',
					'Mayo' 			=> '05',
					'Junio' 		=> '06',
					'Julio' 		=> '07',
					'Agosto' 		=> '08',
					'Septiembre'	=> '09',
					'Octubre' 		=> '10',
					'Noviembre' 	=> '11',
					'Diciembre'		=> '12'
				);
	
	$dBuscado = '';
	if(isset($_POST['dBuscado'])) 	{ $dBuscado  	= $_POST['dBuscado']; 	}
	if(isset($_GET['RAM']))  		{ $RAM 			= $_GET['RAM']; 		}
	
	if(isset($_POST['RAM']))  		{ $RAM 			= $_POST['RAM']; 		}
	
	if(isset($_POST['RAM'])) 		{ $RAM 		= $_POST['RAM']; 	}
	if(isset($_POST['accion']))  	{ $accion 	= $_POST['accion']; }

	if(isset($_GET['RAM']))  		{ $RAM 		= $_GET['RAM']; 	}
	if(isset($_GET['accion']))  	{ $accion 	= $_GET['accion']; 	}

?>

<form name="form" action="idMuestras2.php" method="post">
			<div id="BarraOpciones">
				<div id="ImagenBarraLeft">
					<a href="pOtams.php" title="RAMs">
						<img src="../imagenes/consulta.png"></a>
					<br>
					RAMs
				</div>
				<div id="ImagenBarraLeft">
					<a href="../cotizaciones/plataformaCotizaciones.php" title="Procesos">
						<img src="../imagenes/other_48.png"></a>
					<br>
					Proceso
				</div>
				<div id="ImagenBarraLeft">
					<a href="idMuestras.php?RAM=<?php echo $RAM;?>&accion=Ver&CAM=" title="Muestras">
						<img src="../imagenes/Tablas.png"></a>
					<br>
					Muestras
				</div>

				<?php if($nSolTaller > 0){?>
					<div id="ImagenBarraLeft">
						<a href="" title="Servicio de Taller">
							<img src="../imagenes/herramientas.png"></a>
						<br>
						<?php echo 'ST.'.$nSolTaller; ?>
					</div>
				<?php } ?>
				<?php
					
					$link=Conectarse();
					$sqlOtams	= "SELECT * FROM OTAMs Where RAM = '".$RAM."'";  // sentencia sql
					$result 	= mysql_query($sqlOtams);
					$tOtams 	= mysql_num_rows($result); // obtenemos el número de Otams

					$sqlOtams	= "SELECT * FROM OTAMs Where RAM = '".$RAM."' and tpMuestra != ''";  // sentencia sql
					$result 	= mysql_query($sqlOtams);
					$tOtamsOk 	= mysql_num_rows($result); // obtenemos el n�mero de Otams
					
					mysql_close($link);
					
					//if($tOtams == $tOtamsOk){
					if($tOtams > 0){
						?>
						<div id="ImagenBarraLeft">
							<a href="formularios/iRAM.php?accion=Imprimir&RAM=<?php echo $RAM; ?>&CAM=&accion=" title="Imprimr RAM <?php echo $RAM; ?>">
								<img src="../imagenes/newPdf.png"></a>
							<br>
							RAM
						</div>
					<?php
					}else{
					?>
						<div id="ImagenBarraLeft">
							<img src="../imagenes/desactivadoPdf.png">
							<br>
							Imprimir
						</div>
						<?php
						
						}
					?>
				<?php
					$link=Conectarse();
					$bdIN=mysql_query("Select * From amInformes Where CodInforme Like '%".$RAM."%'");
					if($rowIN=mysql_fetch_array($bdIN)){
						?>
						<div id="ImagenBarraLeft">
							<a href="../generarinformes/nominaInformes.php?accion=Actualizar&CodInforme=<?php echo 'AM-'.$RAM; ?>&RAM=<?php echo $RAM; ?>" title="Ver Informes">
								<img src="../imagenes/actividades.png"></a>
							<br>
							Informes
						</div>
						<?php
					}else{
						?>
						<div id="ImagenBarraLeft">
							<a href="../generarinformes/plataformaGenInf.php" title="Generar Informes">
								<img src="../imagenes/actividades.png"></a>
							<br>
							Informes
						</div>
						<?php
					}
					mysql_close($link);
				?>
				<div id="ImagenBarraLeft">
					<button name="guardarIdMuestra222" style="float:right;" title="Guardar Muestras Mantención">
						<img src="../gastos/imagenes/guardar.png" width="55" height="55">
						<br>
						Guardar
					</button>
				</div>
				
			</div>

			<?php include_once('despliegaMuestrasEnsayos.php'); ?>
</form>
