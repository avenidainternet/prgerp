<?php
	$link=Conectarse();
	$nPreCam 	= 0;
	$bdEq=$link->query("SELECT * FROM precam Where Estado = 'on'");
	if($rowEq=mysqli_fetch_array($bdEq)){
		do{
			$nPreCam++;
		}while ($rowEq=mysqli_fetch_array($bdEq));
	}
	$link->close();
	

?>

<div id="MenuCuerpo" style="background-color:#FFFFFF;">
	<?php
		$IdPerfil = $_SESSION['IdPerfil'];
		$link=Conectarse();
		$SQL = "SELECT * FROM modperfil Where IdPerfil = '$IdPerfil' Order By nMenu";
		$bd=$link->query($SQL);
		while($row=mysqli_fetch_array($bd)){?>
			<div id="MenuCuerpoTitulo" class="degradado">
				<?php
				$SQLm = "SELECT * FROM menugrupos Where nMenu = '".$row['nMenu']."'";
				$bdm=$link->query($SQLm);
				if($rowm=mysqli_fetch_array($bdm)){
					echo $rowm['nomMenu'];
				}?>
			</div>

			<?php
			$SQLi = "SELECT * FROM menuitems Where nMenu = '".$row['nMenu']."'";
			$bdi=$link->query($SQLi);
			while($rowi=mysqli_fetch_array($bdi)){?>

				<ul>
					<?php
					$SQLp = "SELECT * FROM modulos Where nModulo = '".$rowi['nModulo']."'";
					//echo $SQLp;
					$bdp=$link->query($SQLp);
					while($rowp=mysqli_fetch_array($bdp)){

						?>
						<li>
							<span class="<?php echo $rowp['iconoMod']; ?>"></span>
							<?php
								if($rowp['Modulo'] == 'Redbank'){
									$rb = $rowp['dirProg'].'?nCuenta=76884210|BCI&MesFiltro='.date('m');
									?>
									<a href="<?php echo $rb; ?>" title="<?php echo $rowp['Modulo']; ?>"> <?php echo $rowp['Modulo']; ?></a>
									<?php
								}else{?>
									<a href="<?php echo $rowp['dirProg']; ?>" title="<?php echo $rowp['Modulo']; ?>"> <?php echo $rowp['Modulo']; ?></a>
									<?php
								}
							?>
						</li>
					<?php
				}?>
				</ul>
				<?php
			}
		}
		$link->close();
	?>
</div>	