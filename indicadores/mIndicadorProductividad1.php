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
	$thEnsMes = array(
					1 	=> '00:00:00', 
					2 	=> '00:00:00',
					3 	=> '00:00:00',
					4 	=> '00:00:00',
					5 	=> '00:00:00',
					6 	=> '00:00:00',
					7 	=> '00:00:00',
					8 	=> '00:00:00',
					9 	=> '00:00:00',
					10 	=> '00:00:00',
					11 	=> '00:00:00',
					12 	=> '00:00:00'
				);
	
	?>
<h3 class="bg-light text-dark">Tabla Indicador Productividad</h3>
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
		$link=Conectarse();
		$bdUsr=$link->query("SELECT * FROM Usuarios");
		if($rowUsr=mysqli_fetch_array($bdUsr)){
			do{
				if(intval($rowUsr['nPerfil'])  === 1 or $rowUsr['nPerfil']  === '01' or $rowUsr['nPerfil']  === '02'){
					?>
					<tr style="background-color:#fff;">
						<td style="padding-left:10px;">
							<?php echo $rowUsr['usr']; ?>
						<td>
						<?php
							$tAgno = 0;
							$thAgno = '00:00:00';
							for($i=1; $i<=12; $i++){
								?>
								<td align="center">
									<?php 
										$Mm = $Mes[intval($i)];
										$tNetoUF = 0;
										$SQLPrAf = "SELECT sum(NetoUF) as tNetoAM FROM Cotizaciones Where RAM > 0 and Estado = 'T' and usrResponzable = '".$rowUsr['usr']."' and month(fechaTermino)='".$MesNum[$Mm]."' and year(fechaTermino) = '".$pAgno."'";
										//echo $SQLPrAf;
										$bdAM	= $link->query($SQLPrAf);
										$rowAM	= mysqli_fetch_array($bdAM);
										$tAMs	= $rowAM['tNetoAM'];
										$sHorasMes = '00:00:00';
										$SQL = "SELECT * FROM relojcontrol Where usr = '".$rowUsr['usr']."' and month(fecha) = '".$MesNum[$Mm]."' and year(fecha) = '".$pAgno."'";
										$bdHh=$link->query($SQL);
										if($rowHh=mysqli_fetch_array($bdHh)){
											do{
												//$sHorasMes 	+= $rowHh['horasDia'];
												//$thAgno 	+= $rowHh['horasDia'];
											}while ($rowHh=mysqli_fetch_array($bdHh));
										}
										
										if($tAMs>0){
											$calculo = ($ultUF*$tAMs)/1000000;
											echo number_format($calculo, 2, ',', '.');
											$tAgno 			+= $calculo;
											$tEnsMes[$i] 	+= $calculo;
										}
										if($sHorasMes > '00:00:00'){
											echo '<br>'.$sHorasMes;
											$thEnsMes[$i] 	+= $sHorasMes;
										}
									?>
								<td>
								<?php
							}
						?>
						<td align="center">
							<?php 
								if($tAgno > 0){
									echo number_format($tAgno,2); 
								}
								if($thAgno > 0){
									echo '<br>'.$thAgno; 
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
							echo number_format($tEnsMes[$i],2);
							$tAnualProd += $tEnsMes[$i];
						}
						if($thEnsMes[$i] > 0){
							//echo '<br>'.number_format($thEnsMes[$i],2);
							//$thAnual += $thEnsMes[$i];
						}
					?>
				<th>
				<?php
			}
		?>
		<th align="center">
			<?php 
				echo number_format($tAnualProd,2); 
				echo '<br>'.$thAnual; 
			?>
		</th>
	</tr>
	</tfoot>
</table>