<?php

	$Estado = array(
					1 => 'Estado', 
					2 => 'Fotocopia',
					3 => 'Factura',
					4 => 'Canceladas'
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

	$fd 	= explode('-', date('Y-m-d'));

	$Agno     	= date('Y');
	
	$dBuscado = '';
	if(isset($_GET['dBuscado'])) 	{ $dBuscado  = $_GET['dBuscado']; 	}
	
?>

			<div id="BarraFiltro">
			</div>
			<div id="BarraOpciones">
				<div id="ImagenBarraLeft">
					<a href="accionesCorrectivas.php" title="Cotizaciones">
						<img src="../imagenes/about_us_close_128.png">
					</a>
				</div>
				<div id="ImagenBarraLeft" title="Procesos">
					<a href="#" title="Abrir Acción Correctiva" onClick="registraEncuesta(0, 'Agrega')">
						<img src="../imagenes/open_48.png">
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