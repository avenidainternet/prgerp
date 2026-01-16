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

	$fd 	= explode('-', date('Y-m-d'));

	$Agno     	= date('Y');
	
	$dBuscado = '';
	if(isset($_GET['dBuscado'])) 	{ $dBuscado  = $_GET['dBuscado']; 	}
	
?>

			<div id="BarraFiltro">
				<img src="../gastos/imagenes/data_filter_128.png" width="28" height="28">

				<!-- Fin Filtro -->
				Buscar...
				<input name="dBuscado" id="dBuscar" align="right" maxlength="80" size="80" placeholder="Servicio a Buscar" title="Ingrese CAM o Nombre Cliente...">
				<button name="Buscar" onClick="realizaProceso($('#dBuscar').val())">
					<img src="../gastos/imagenes/buscar.png"  width="32" height="32">
				</button>
					
			</div>
			<div id="BarraOpciones">
				<div id="ImagenBarraLeft">
					<a href="plataformaCotizaciones.php" title="Cotizaciones">
						<img src="../imagenes/other_48.png" width="50" height="50">
					</a>
				</div>
				<div id="ImagenBarraLeft" title="Servicios">
					<a href="Servicios.php" title="Servicios">
						<img src="../imagenes/Taller.png" width="50" height="50">
					</a>
				</div>
				<div id="ImagenBarraLeft" title="Procesos">
					<a href="seguimientoProcesos.php" title="RAM En Procesos">
						<img src="../imagenes/servicios.png" width="50" height="50">
					</a>
				</div>
			</div>
			<?php
			if($dBuscado==''){?>
				<script>
					var dBuscar = '';
					realizaProceso(dBuscar);
				</script>					
			<?php
			}
			?>
			<span id="resultado"></span>
			<span id="resultadoRegistro"></span>