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
	
	?>
<h3 class="bg-light text-dark">Tabla Indicador Productividad Informes RESPONSABLES</h3>
<table class="table table-hover">
	<thead class="thead-light">
	<tr>
		<th style="padding-left:10px;" width="20%">
			Ingeniero
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
	</tbody>
	<?php
		$valorUFRef = 0;
		$link=Conectarse();
		$bdTab=$link->query("SELECT * FROM tablaRegForm");
		if($rowTab=mysqli_fetch_array($bdTab)){
			$valorUFRef = $rowTab['valorUFRef'];
		}
		$bdUsr=$link->query("SELECT * FROM Usuarios");
		if($rowUsr=mysqli_fetch_array($bdUsr)){
			do{
				if($rowUsr['responsableInforme'] == 'on'){
					?>
					<tr style="background-color:#fff;">
						<td style="padding-left:10px;">
							<?php echo $rowUsr['usr']; ?>
						<td>
						<?php
							$tAgno 	= 0;
							$tMes	= 0;
							for($i=1; $i<=12; $i++){
								?>
								<td align="center">
									<?php 
									
										$Mm = $Mes[intval($i)];
										$tNeto = 0;
										$valor = 12;
										$CodInforme = '';
										$SQL = "SELECT * FROM AmInformes Where ingResponsable = '".$rowUsr['usr']."' and month(fechaInforme) = '".$i."' and year(fechaInforme) = '".$pAgno."' Order By CodInforme";
										$bdAm=$link->query($SQL);
										if($rowAm=mysqli_fetch_array($bdAm)){
											do{
												if($rowAm['ingResponsable'] != $rowAm['cooResponsable']){
													if($CodInforme != $rowAm['CodInforme']){
														$CodInforme = $rowAm['CodInforme'];
														$fr = explode('-', $CodInforme);
														$RAM = $fr[1];
														$Facturado = 'No';
														$SQLSol = "SELECT * FROM solfactura Where informesAM like '%".$RAM."%'";
														$bdSol=$link->query($SQLSol);
														if($rowSol=mysqli_fetch_array($bdSol)){
															do{
																$Facturado = 'Si';
																$tNeto += $rowSol['Neto'];
																//echo number_format(($tNeto/1000000),2);
															}while ($rowSol=mysqli_fetch_array($bdSol));
														}
														if($Facturado == 'No'){
															$SQLCot = "SELECT * FROM Cotizaciones Where RAM = '".$RAM."'";
															$bdCot=$link->query($SQLCot);
															if($rowCot=mysqli_fetch_array($bdCot)){
																if($rowCot['Neto'] > 0){
																	$tNeto += $rowCot['Neto'];
																}else{
																	$SQLSol = "SELECT * FROM solfactura Where month(fechaFactura) = '".$i."' and year(fechaFactura) = '".$pAgno."' Order By valorUF Desc";
																	$bdSol=$link->query($SQLSol);
																	if($rowSol=mysqli_fetch_array($bdSol)){
																		if($rowSol['valorUF'] > 0){
																			$valorUFRef = $rowSol['valorUF'];
																		}
																	}
																	$tNeto += ($rowCot['NetoUF'] * $valorUFRef);
																}
															}
														}
													}	
												}	
											}while ($rowAm=mysqli_fetch_array($bdAm));
										}
										if($tNeto > 0){
											echo number_format(($tNeto/1000000),2);
											$tAgno += $tNeto;
											$tEnsMes[$i] += $tNeto;
										}	
									?>
								<td>
								<?php
							}
						?>
						<td align="center">
							<?php 
								if($tAgno > 0){
									echo number_format(($tAgno/1000000),2); 
								}
							?>
						</td>
					</tr>
					<?php
				}
			}while ($rowUsr=mysqli_fetch_array($bdUsr));
		}
		$link->close();
	?>
	</tbody>
	<tfoot class="thead-light">
	<tr style="background-color:#ccc;">
		<th style="padding-left:10px;" width="20%">
			Tot. Productividad Mes
		<th>
		<?php
			$tAnualProd = 0;
			$thAnual	= '00:00:00';
			for($i=1; $i<=12; $i++){
				?>
				<th align="center">
					<?php 
						if($tEnsMes[$i] > 0){
							echo number_format(($tEnsMes[$i]/1000000),2);
							$tAnualProd += $tEnsMes[$i];
						}
					?>
				<th>
				<?php
			}
		?>
		<th align="center">
			<?php 
				echo number_format(($tAnualProd/1000000),2); 
			?>
		</th>
	</tr>
	</tfoot>
</table>