			<div id="CuerpoTituloNegro">
				<img src="../imagenes/carpeta-negra.png" width="32" height="32" style="padding:5px;" align="middle">
				<span style=" font-family:Arial, Helvetica, sans-serif; font-size:24px; color:#FFFFFF;"><?php echo $nomModulo; ?></span>
				<div id="ImagenBarra">
					<a href="cerrarsesion.php" title="Cerrar Sesión">
						<img src="../imagenes/preview_exit_32.png" width="32" height="32">
					</a>
				</div>
				<?php
				if(isset($_GET['Estado'])){ 	$Estado 	= $_GET['Estado']; 	}else{ $Estado 	= "N"; 	}
				?>
			</div>