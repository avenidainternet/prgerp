<?php
	//header('Content-Type: text/html; charset=utf-8');

	$dBuscado = '';
	if(isset($_GET['dBuscado'])) 	{ $dBuscado  = $_GET['dBuscado']; 	}
	
?>

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