	<?php

	$tEnsMes = array(
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
	
	contarEnsayosDelMes($mesInd, $agnoInd);

	?>
<h3 class="bg-light text-dark">Tabla Indicador Ensayos</h3>
<table class="table table-hover">
	<thead class="thead-light">
	<tr>
		<th style="padding-left:10px;" width="20%">
			Ensayos
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
		$tEnsMes = array(
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
		$bdEn=$link->query("SELECT * FROM amEnsayos Order By nEns");
		if($rowEn=mysqli_fetch_array($bdEn)){
			do{
				if($rowEn['idEnsayo'] == 'Tr') {
					$bdMu=$link->query("SELECT * FROM amTpsMuestras Where idEnsayo = '".$rowEn['idEnsayo']."'");
					if($rowMu=mysqli_fetch_array($bdMu)){
						do{?>
							<tr style="background-color:#fff;">
								<td style="padding-left:10px;">
									<?php echo $rowEn['Ensayo'].' '.$rowMu['Muestra']; ?>
								<td>
								<?php
									$cEnsayosAnual = 0;
									for($i=1; $i<=12; $i++){
										?>
										<td align="center">
											<?php
												if($i < 10){
													$Periodo = '0'.$i.'-'.$pAgno;
												}else{
													$Periodo = $i.'-'.$pAgno;
												}
/*												
												$SQL = "SELECT * FROM estEnsayos Where idEnsayo = '".$rowEn['idEnsayo']."' and tpMuestra = '".$rowMu['tpMuestra']."' and Periodo = '$Periodo'";
												//echo $SQL;
												$bdEs=$link->query($SQL);
												if($rowEs=mysqli_fetch_array($bdEs)){
													do{
														if($rowEs['nEnsayos'] > 0){
															echo $rowEs['nEnsayos']; 
															$cEnsayosAnual 	+= $rowEs['nEnsayos'];
															$tEnsMes[$i] 	+= $rowEs['nEnsayos'];
														}
													}while ($rowEs=mysqli_fetch_array($bdEs));
												}
*/												
												$row_ens = 0;
												$SQL = "SELECT * FROM Otams Where idEnsayo = '".$rowEn['idEnsayo']."' and tpMuestra = '".$rowMu['tpMuestra']."' and year(fechaCreaRegistro) = $pAgno and month(fechaCreaRegistro) = $i";
												$bdEs=$link->query($SQL);
												if($rowEs=mysqli_fetch_array($bdEs)){
													do{
														$row_ens++;
														$cEnsayosAnual++;
														$tEnsMes[$i]++;
													}while ($rowEs=mysqli_fetch_array($bdEs));
												}
												if($row_ens > 0){
													echo $row_ens;
												}	
												
											?>
										<td>
										<?php
									}
								?>
								<td align="center">
									<?php echo $cEnsayosAnual; ?>
								</td>
							</tr>
							<?php
						}while ($rowMu=mysqli_fetch_array($bdMu));
					}
				}else{?>
					<tr style="background-color:#fff;">
						<td style="padding-left:10px;">
							<?php echo $rowEn['Ensayo']; ?>
						<td>
						<?php
							$cEnsayosAnual = 0;
							for($i=1; $i<=12; $i++){
								?>
								<td align="center">
											<?php
												if($i < 10){
													$Periodo = '0'.$i.'-'.$pAgno;
												}else{
													$Periodo = $i.'-'.$pAgno;
												}
/*												
												$SQL = "SELECT * FROM estEnsayos Where idEnsayo = '".$rowEn['idEnsayo']."' and Periodo = '$Periodo'";
												//echo $SQL;
												$bdEs=$link->query($SQL);
												if($rowEs=mysqli_fetch_array($bdEs)){
													do{
														if($rowEs['nEnsayos'] > 0){
															echo $rowEs['nEnsayos']; 
															$cEnsayosAnual 	+= $rowEs['nEnsayos'];
															$tEnsMes[$i] 	+= $rowEs['nEnsayos'];
														}
													}while ($rowEs=mysqli_fetch_array($bdEs));
												}
*/												
												$row_ens = 0;
												$SQL = "SELECT * FROM Otams Where idEnsayo = '".$rowEn['idEnsayo']."' and year(fechaCreaRegistro) = $pAgno and month(fechaCreaRegistro) = $i";
												$bdEs=$link->query($SQL);
												if($rowEs=mysqli_fetch_array($bdEs)){
													do{
														$row_ens++;
														$cEnsayosAnual++;
														$tEnsMes[$i] ++;
													}while ($rowEs=mysqli_fetch_array($bdEs));
												}
												if($row_ens > 0){
													echo $row_ens;
												}	
											?>
									
								<td>
								<?php
							}
						?>
						<td align="center">
							<?php echo $cEnsayosAnual; ?>
						</td>
					</tr>
					<?php
				}
			}while ($rowEn=mysqli_fetch_array($bdEn));
		}
		$link->close();
	?>
	</tbody>
	<tfoot class="thead-light">
	<tr style="background-color:#ccc;">
		<th style="padding-left:10px;" width="20%">
			Tot. Ensayos Mes
		<th>
		<?php
			$tAnualEnsayos = 0;
			for($i=1; $i<=12; $i++){
				?>
				<th align="center">
					<?php 
						if($tEnsMes[$i] > 0){
							echo $tEnsMes[$i];
							$tAnualEnsayos += $tEnsMes[$i];
						}
					?>
				<th>
				<?php
			}
		?>
		<th align="center">
			<?php echo $tAnualEnsayos; ?>
		</th>
	</tr>
	<tfoot>
</table>