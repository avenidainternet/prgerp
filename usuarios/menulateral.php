<?php
	include_once("../conexionli.php");
?>	
	<div id="CuerpoMenuLateral">
		<?php
		$link=Conectarse();
		$bdMg=$link->query("SELECT * FROM menugrupos Order By nMenu");
		if ($rowMg=mysqli_fetch_array($bdMg)){
			do{
				$iconoMenu = "../imagenes/".$rowMg['iconoMenu'];
				?>
				<div id="EncabezadosTitulosMenuLateral" class="degradado">
					<img src="<?php echo $iconoMenu; ?>" style="margin:2px;" align="absmiddle" width="20px" height="20px">				
					<?php echo $rowMg['nomMenu']; ?>
				</div>
					<ul>
						<?php
						$iconoMenu = '';
						$bdMo=$link->query("SELECT * FROM menuItems Where nMenu = '".$rowMg['nMenu']."' Order By nMenu, nModulo");
						if ($rowMo=mysqli_fetch_array($bdMo)){
							do{
								$iconoMenu = "../imagenes/".$rowMo['iconoMod'];
								?>
								<li><a href="#" onclick="seleccionaOpcMenu(<?php echo $rowMo['nMenu']; ?>,<?php echo $rowMo['nModulo']; ?>);" title="<?php echo $rowMo['titulo']; ?>"><img src="<?php echo $iconoMenu; ?>"style="margin:2px;" align="absmiddle" width="22px" height="22px"> <?php echo $rowMo['titulo']; ?></a></li>
								<?php
							}while ($rowMo=mysqli_fetch_array($bdMo));
						}
						?>
					</ul>
					<?php
			}while ($rowMg=mysqli_fetch_array($bdMg));
		}
		$link->close();
		?>
