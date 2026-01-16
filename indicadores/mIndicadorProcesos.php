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
<h3 class="bg-light text-dark">Tabla Indicador Procesos</h3>
<table class="table table-hover">
	<thead class="thead-light">
	<tr>
		<th style="padding-left:10px;" width="20%">
			Items
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
	</tr>
	</thead>
	</tbody>
	<tr style="background-color:#fff;">
		<td style="padding-left:10px;">
			PAM
		<td>
		<?php
			for($i=1; $i<=12; $i++){
				?>
				<td align="center">
					<?php
						$link=Conectarse();
						$ultUF = 27044.52;
						if($i < 10){
							$fechaProc = '0'.$i.'.'.$pAgno;
						}else{
							$fechaProc = $i.'.'.$pAgno;
						}
						$bdProc  = $link->query("SELECT * FROM movProc Where fechaProc = '".$fechaProc."'");
						if($rowProc=mysqli_fetch_array($bdProc)){
							$calculo = ($ultUF*$rowProc['enProceso'])/1000000;
							echo number_format($calculo, 2, ',', '.');
						}
						$link->close();
					?>
				<td>
				<?php
			}
		?>
	</tr>
	<tr style="background-color:#fff;">
		<td style="padding-left:10px;">
			PAM - AF
		<td>
		<?php
			for($i=1; $i<=12; $i++){
				?>
				<td align="center">
					<?php
						$link=Conectarse();
						$ultUF = 26350.52;
						if($i < 10){
							$fechaProc = '0'.$i.'.'.$pAgno;
						}else{
							$fechaProc = $i.'.'.$pAgno;
						}
						$bdProc  = $link->query("SELECT * FROM movProc Where fechaProc = '".$fechaProc."'");
						if($rowProc=mysqli_fetch_array($bdProc)){
							$calculo = ($ultUF*$rowProc['AF'])/1000000;
							echo number_format($calculo, 2, ',', '.');
						}
						$link->close();
					?>
				<td>
				<?php
			}
		?>
	</tr>
	<tr style="background-color:#fff;">
		<td style="padding-left:10px;">
			No Facturado
		<td>
		<?php
			for($i=1; $i<=12; $i++){
				?>
				<td align="center">
					<?php
						$link=Conectarse();
						$ultUF = 26350.52;
						if($i < 10){
							$fechaProc = '0'.$i.'.'.$pAgno;
						}else{
							$fechaProc = $i.'.'.$pAgno;
						}
						$bdProc  = $link->query("SELECT * FROM movProc Where fechaProc = '".$fechaProc."'");
						if($rowProc=mysqli_fetch_array($bdProc)){
							$calculo = ($ultUF*$rowProc['noFacturado'])/1000000;
							echo number_format($calculo, 2, ',', '.');
						}
						$link->close();
					?>
				<td>
				<?php
			}
		?>
	</tr>
	<tr style="background-color:#fff;">
		<td style="padding-left:10px;">
			Sin Informes
		<td>
		<?php
			for($i=1; $i<=12; $i++){
				?>
				<td align="center">
					<?php
						$link=Conectarse();
						$ultUF = 26350.52;
						if($i < 10){
							$fechaProc = '0'.$i.'.'.$pAgno;
						}else{
							$fechaProc = $i.'.'.$pAgno;
						}
						$bdProc  = $link->query("SELECT * FROM movProc Where fechaProc = '".$fechaProc."'");
						if($rowProc=mysqli_fetch_array($bdProc)){
							$calculo = ($ultUF*$rowProc['sinInforme'])/1000000;
							echo number_format($calculo, 2, ',', '.');
						}
						$link->close();
					?>
				<td>
				<?php
			}
		?>
	</tr>
	</tbody>
</table>