<style>
.linkRevisiones{
	color:#000;
}
.linkRevisiones a{
	text-decoration:none;
}
.linkRevisiones a:hover{
	font-size				:18px;
	font-weight				:800;
}
</style>
<h3 class="bg-light text-dark">Tabla Indicador Revisiones</h3>
<table class="table table-hover">
	<thead class="thead-light">
	<tr>
		<th style="padding-left:10px;" width="20%">
			Revisiones
		<th>
		<?php
			for($i=1; $i<=12; $i++){
				?>
				<th align="center">
					<?php echo substr($Mes[$i],0,3).'.'; ?>
				<th>
				<?php
			}
		?>
		<th align="center">
			Tot.
		</th>
	</tr>
	</thead>
	<tbody>
	<?php
		$tRevMes = array(
						1 => 0, 
						2 => 0,
						3 => 0,
						4 => 0,
						5 => 0,
						6 => 0,
						7 => 0,
						8 => 0,
						9 => 0,
						10 => 0,
						11 => 0,
						12 => 0
					);
		$link=Conectarse();
		$bdIm=$link->query("SELECT * FROM ItemsMod Order By nMod");
		if($rowIm=mysqli_fetch_array($bdIm)){
			do{?>
				<tr style="background-color:#fff;">
					<td style="padding-left:10px;" class="linkRevisiones">
						<a class="linkRevisiones" href="mRevisiones.php?nMod=<?php echo $rowIm['nMod'];?>&agnoMod=<?php echo $pAgno; ?>">
							<?php echo $rowIm['Modificacion']; ?>
						</a>
					<td>
					<?php
						$tRevAnual = 0;
						for($i=1; $i<=12; $i++){
							?>
							<td align="center" class="linkRevisiones">
								<?php
									$cRevisiones = 0;
									$SQL = "SELECT Count(*) as cRev FROM regRevisiones Where nMod = '".$rowIm['nMod']."' and year(fechaMod) = $pAgno and month(fechaMod) = '".$i."'";
									$result  = $link->query($SQL);  
									$rowRev	 = mysqli_fetch_array($result);
									if($rowRev['cRev'] > 0){
										?>
											<a href="mRevisiones.php?nMod=<?php echo $rowIm['nMod']; ?>&agnoMod=<?php echo $pAgno; ?>&mesMod=<?php echo $i; ?>">
											<?php
												echo number_format($rowRev['cRev'], 0, ',', '.');
											?>
											</a>
										<?php
										$cRevisiones += $rowRev['cRev'];
										$tRevAnual 	 += $rowRev['cRev'];
										$tRevMes[$i] += $rowRev['cRev'];
									}
								?>
								
							<td>
							<?php
						}
					?>
					<td align="center" class="linkRevisiones">
						<?php
							if($tRevAnual > 0){
								?>
								<a class="linkRevisiones" href="mRevisiones.php?nMod=<?php echo $rowIm['nMod']; ?>&agnoMod=<?php echo $pAgno; ?>">
								<?php
									echo $tRevAnual; 
								?>
								</a>
								<?php
							}
						?>
					</td>
				</tr>
				<?php
			}while ($rowIm=mysqli_fetch_array($bdIm));
		}
		$link->close();
	?>
	</tbody>
	<tfoot class="thead-light">
	<tr style="background-color:#ccc;">
		<th style="padding-left:10px;" width="20%">
			Tot. Revisiones Mes
		<th>
		<?php
			$tAnualEnsayos = 0;
			for($i=1; $i<=12; $i++){
				?>
				<th align="center" class="linkRevisiones">
					<?php 
						if($tRevMes[$i] > 0){
							?>
							<a class="linkRevisiones" href="mRevisiones.php?agnoMod=<?php echo $pAgno; ?>&mesMod=<?php echo $i; ?>&porMes=1">
							<?php
								echo $tRevMes[$i];
							?>
							</a>
							<?php
							$tAnualEnsayos += $tRevMes[$i];
						}
					?>
				<th>
				<?php
			}
		?>
		<th align="center">
			<a class="linkRevisiones" href="mRevisiones.php?agnoMod=<?php echo $pAgno; ?>">
				<?php echo $tAnualEnsayos; ?>
			</a>
		</th>
	</tr>
	</tfoot>
</table>