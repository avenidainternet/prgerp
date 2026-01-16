<?php

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
	
	if(isset($_GET['IdProyecto']))  { $IdProyecto	= $_GET['IdProyecto'];  }
	if(isset($_POST['IdProyecto'])) { $IdProyecto	= $_POST['IdProyecto']; }
	
?>

			<div id="BarraOpciones">
				<div id="ImagenBarraLeft">
					<a href="plataformaProyectos.php" title="Proyectos">
						<img src="../imagenes/viewtimetables_48.png"></a>
					<br>
					Proyectos
				</div>

				<div id="ImagenBarraLeft">
					<a href="" title="+Proyecto">
						<img src="../gastos/imagenes/add_32.png"></a>
					<br>
					+Proyecto
				</div>
				
			</div>

			<span id="resultado"></span>

			
			<?php
			if($dBuscado==''){?>
				<script>
					var usrRes 		= '<?php echo $usrRes; ?>';
					var tpAccion 	= '<?php echo $tpAccion; ?>';
					realizaProceso(usrRes, tpAccion);
				</script>					
			<?php
			}
			?>
			<span id="resultadoRegistro"></span>
			<span id="resultadoSubir"></span>
