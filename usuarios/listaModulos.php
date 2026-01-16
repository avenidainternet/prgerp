<?php
	//header('Content-Type: text/html; charset=utf-8');

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
				<img src="../gastos/imagenes/data_filter_128.png" width="28" height="28">

				<!-- Fin Filtro -->
				Buscar...
				<input name="dBuscado" id="dBuscar" align="right" maxlength="80" size="80" placeholder="Módulo" title="Módulo a Buscar...">
				<button name="Buscar" onClick="realizaProceso($('#dBuscar').val())">
					<img src="../gastos/imagenes/buscar.png"  width="32" height="32">
				</button>
					
			</div>
			<div id="BarraOpciones">
				<div id="ImagenBarraLeft">
					<a href="plataformaUsuarios.php" title="Usuarios">
						<img src="../imagenes/class_128.png">
					</a>
				</div>
				<div id="ImagenBarraLeft" title="Perfiles">
					<a href="Perfiles.php" title="Perfiles de Usuarios">
						<img src="../imagenes/single_class.png">
					</a>
				</div>
				<?php if($_SESSION['Perfil'] == 'WebMaster'){?>
					<div id="ImagenBarraLeft" title="Módulos">
						<a href="Modulos.php" title="Módulos">
							<img src="../imagenes/soft.png">
						</a>
					</div>
				<?php } ?>
				
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