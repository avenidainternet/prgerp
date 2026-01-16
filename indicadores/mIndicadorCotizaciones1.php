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
<h3 class="bg-light text-dark">Tabla Indicador Cotizaciones </h3>
<table class="table table-hover">
	<thead class="thead-light">
	<tr>
		<th style="padding-left:10px;" width="20%">
			Cotizaciones
		<th>
		<?php
			for($i=1; $i<=12; $i++){
				?>
				<th align="center">
					<?php echo substr($Mes[$i],0,3).'.'; ?>
				</th>
				<?php
			}
		?>
		<th align="center">
			Tot.
		<td>
		
	</tr>
	</thead>
	<tbody>
	<tr style="background-color:#fff;">
		<td style="padding-left:10px;">
			Premium c/Seguimiento
		<td>
		<?php
			$tAgno = 0;
			$tCotEje 	= array(0,0,0,0,0,0,0,0,0,0,0,0,0);
			$tCotPrSeg 	= array(0,0,0,0,0,0,0,0,0,0,0,0,0);
			$tCotPr  	= array(0,0,0,0,0,0,0,0,0,0,0,0,0);
			for($i=1; $i<=12; $i++){
				?>
				<td align="center">
					<?php
						//if($i <= $mesInd){
							$tCotPre = 0;
							$tCotSeg = 0;
							$m = $i;
							if($i < 10){
								$m = '0'.$i;
							}
							$link=Conectarse();
							$SQLt = "SELECT * FROM Cotizaciones Where BrutoUF >= 40 and year(fechaCotizacion) = $pAgno and month(fechaCotizacion) = $m";
							//echo $SQLt.'<br>';
							$bdCp=$link->query($SQLt);
							if($rowCp=mysqli_fetch_array($bdCp)){
								do{
									$tCotPre++;
									$tCotPr[$i]++;
									if($rowCp['proxRecordatorio'] > '0000-00-00'){
										$tCotSeg++;
										$tCotPrSeg[$i]++;
									}
									if($rowCp['Estado'] == 'T'){
										$tCotEje[$i]++;
									}
								}while ($rowCp=mysqli_fetch_array($bdCp));
							}
							if($tCotPre > 0){
								echo number_format(($tCotSeg/$tCotPre), 2, ',', '.');
								echo '<br><span style="font-size:9px;">'.$tCotSeg.' / '.$tCotPre.'</span>';
							}
/*							
							$SQLt = "SELECT * FROM tablaindicadores Where mesInd = $i and agnoInd = $pAgno";
							$bdTi=$link->query($SQLt);
							if($rowTi=mysqli_fetch_array($bdTi)){
								echo '<br>'.$rowTi['cPremiumSeg'];
							}
*/							
							$link->close();
						//}
					?>
				</td>
				<?php
			}
		?>
		<td align="center">
			<?php
				$tSegAgno 	= 0;
				$tAgno 		= 0;
				for($i=1; $i<=12; $i++){
					//if($i <= $mesInd){
						$tSegAgno 	+= $tCotPrSeg[$i];
						$tAgno 		+= $tCotPr[$i];
					//}
				}
				if($tAgno > 0){
					if($tSegAgno > 0){
						echo number_format(($tSegAgno/$tAgno), 2, ',', '.');
						echo '<br><span style="font-size:9px;">'.$tSegAgno.' / '.$tAgno.'</span>';
					}
				}
			?>
		</td>
	</tr>
	<tr style="background-color:#fff;">
		<td style="padding-left:10px;">
			Premium Ejecutadas
		<td>
		<?php
			$tEjeAgno 	= 0;
			$tAgno 		= 0;
			for($i=1; $i<=12; $i++){
				?>
				<td align="center">
					<?php
						//if($i <= $mesInd){
							if($tCotPr[$i] > 0){
								echo number_format(($tCotEje[$i]/$tCotPr[$i]), 2, ',', '.');
							}
							$tEjeAgno 	+= $tCotEje[$i];
							$tAgno 		+= $tCotPr[$i];
							if($tCotPr[$i] > 0){
								echo '<br><span style="font-size:9px;">'.$tCotEje[$i].' / '.$tCotPr[$i].'</span>';
							}
						//}
					?>
				</td>
				<?php
			}
		?>
		<td align="center">
			<?php 
				if($tAgno > 0){
					echo number_format(($tEjeAgno/$tAgno), 2, ',', '.');
					echo '<br><span style="font-size:9px;">'.$tEjeAgno.' / '.$tAgno.'</span>';
				}
			?>
		</td>
	</tr>
	<tr style="background-color:#fff;">
		<td style="padding-left:10px;">
			Informes con Revisión
		<td>
		<?php
			$tInf = array(0,0,0,0,0,0,0,0,0,0,0,0,0);
			$tRev = array(0,0,0,0,0,0,0,0,0,0,0,0,0);
			for($i=1; $i<=12; $i++){
				?>
				<td align="center">
					<?php
						//if($i <= $mesInd){
							$link=Conectarse();
							$SQLt = "SELECT * FROM Informes Where month(fechaUp) = $i and year(fechaUp) = $pAgno";
							$bdTi=$link->query($SQLt);
							if($rowTi=mysqli_fetch_array($bdTi)){
								do{
									$tInf[$i]++;
								}while ($rowTi=mysqli_fetch_array($bdTi));
							}
							$SQL = "SELECT Count(*) as cRev FROM regRevisiones Where year(fechaMod) = '".$pAgno."' and month(fechaMod) = '".$i."'";
							$result  = $link->query($SQL);  
							$rowRev	 = mysqli_fetch_array($result);
							$tRev[$i] = $rowRev['cRev'];
							$link->close();
							$rRev = 0;
							if($tInf[$i] > 0){
								$rRev = ($tRev[$i] / $tInf[$i]);
							}
							if($rRev > 0){
								echo number_format(1 - $rRev,2);
								echo '<br><span style="font-size:9px;">'.$tRev[$i].' / '.$tInf[$i].'</span>';
							}	
						//}
					?>
				</td>
				<?php
			}
		?>
		<td align="center">
		<?php
			$tRevAgno 	= 0;
			$tAgno 		= 0;
			for($i=1; $i<=12; $i++){
				//if($i <= $mesInd){
					$tRevAgno 	+= $tRev[$i];
					$tAgno 		+= $tInf[$i];
				//}
			}
			if($tAgno > 0){
				echo number_format(1-($tRevAgno/$tAgno), 2, ',', '.');
				echo '<br><span style="font-size:9px;">'.$tRevAgno.' / '.$tAgno.'</span>';
			}	
		?>
		</td>
	</tr>
	<tr style="background-color:#fff;">
		<td style="padding-left:10px;">
			PAM Atrazadas
		<td>

		<?php
			$tAgno 		= 0;
			$tCotAtrAnu	= array(0,0,0,0,0,0,0,0,0,0,0,0,0);
			$tCotAnu	= array(0,0,0,0,0,0,0,0,0,0,0,0,0);
			for($i=1; $i<=12; $i++){
				?>
				<td align="center">
					<?php
					//if($i <= $mesInd){
							$tCot 	 = 0;
							$tCotAtr = 0;
							$m = $i;
							if($i < 10){
								$m = '0'.$i;
							}
							$Periodo 	= $m.'-'.$pAgno;
							
							$link=Conectarse();

							$PAMAtrSal  	= 0;
							$PAMAtr			= 0;
							
							
							$actSQL="UPDATE ClientesEstrellas SET ";
							$actSQL.="PAMAtrSal		= '".$PAMAtrSal."',";
							$actSQL.="PAMAtr		= '".$PAMAtr.	"'";
							$actSQL.="WHERE Periodo = '".$Periodo."'";
							$bdDoc=$link->query($actSQL);
							
							$SQLt = "SELECT * FROM Cotizaciones Where Estado = 'T' and year(fechaInicio) = $pAgno and month(fechaInicio) = $m";
							//echo $SQLt;
							$bdCp=$link->query($SQLt);
							if($rowCp=mysqli_fetch_array($bdCp)){
								do{
										$tCot++;
										$tCotAnu[$i]++;

			$fechaInicio = $rowCp['fechaInicio'];
			$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
			$ft = $fechaInicio;
			$dh	= $rowCp['dHabiles'] - 1;

			$dd	= 0;
			for($j=1; $j<=$dh; $j++){
				$ft	= strtotime ( '+'.$j.' day' , strtotime ( $fechaInicio ) );
				$ft	= date ( 'Y-m-d' , $ft );
				//echo $ft.'<br>';
				$dia_semana = date("w",strtotime($ft));
				if($dia_semana == 0 or $dia_semana == 6){
					$dh++;
					$dd++;
				}
				$SQL = "SELECT * FROM diasferiados Where fecha = '".$ft."'";
				$bdDf=$link->query($SQL);
				if($row=mysqli_fetch_array($bdDf)){
					$dh++;
					$dd++;
				}
			}
			$fechaTermino = $ft;
/*
										
										$fechaTermino 	= strtotime ( '+'.$rowCp['dHabiles'].' day' , strtotime ( $rowCp['fechaInicio'] ) );
										$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );
*/
										$PAMAtr = 0;
										$SQLEst = "SELECT * FROM ClientesEstrellas Where RutCli = '".$rowCp['RutCli']."' and Periodo = '".$Periodo."'";
										$bdEst=$link->query($SQLEst);
										if($rowEst=mysqli_fetch_array($bdEst)){
											if($rowEst['PAMAtr'] > 0){
												$PAMAtr = $rowEst['PAMAtr'];
											}
											$PAMAtr++;
											$actSQL="UPDATE ClientesEstrellas SET ";
											$actSQL.="PAMAtr		= '".$PAMAtr.	"'";
											$actSQL.="WHERE RutCli  = '".$rowCp['RutCli']."' and Periodo = '".$Periodo."'";
											$bdDoc=$link->query($actSQL);
										}else{
											$PAMAtrSal++;
											$RutCli = $rowCp['RutCli'];
											$PAMAtr = 1;
											$link->query("insert into ClientesEstrellas(RutCli,
																						Periodo,
																						PAMAtr
																					)	 
																		  values 	(	'$RutCli',
																						'$Periodo',
																						'$PAMAtr'
																					)");
										}
/*										
										if($rowCp['fechaTermino'] > '0000-00-00'){
*/												
										if($rowCp['fechaTermino'] > '0000-00-00'){
											if($rowCp['fechaTermino'] > $fechaTermino){
												//echo $rowCp['fechaTermino'].' - '.$fechaTermino.'<br>';
												$tCotAtr++;
												$tCotAtrAnu[$i]++;
												
												$PAMAtrSal = 0;
												$SQLcli = "SELECT * FROM Clientes Where RutCli = '".$rowCp['RutCli']."'";
												$bdCli=$link->query($SQLcli);
												if($rowCli=mysqli_fetch_array($bdCli)){
													$SQLEst = "SELECT * FROM ClientesEstrellas Where RutCli = '".$rowCp['RutCli']."' and Periodo = '".$Periodo."'";
													$bdEst=$link->query($SQLEst);
													if($rowEst=mysqli_fetch_array($bdEst)){
														if($rowEst['PAMAtrSal'] > 0){
															$PAMAtrSal = $rowEst['PAMAtrSal'];
														}
														$PAMAtrSal++;
														$actSQL="UPDATE ClientesEstrellas SET ";
														$actSQL.="PAMAtrSal		= '".$PAMAtrSal."'";
														$actSQL.="WHERE RutCli  = '".$rowCp['RutCli']."' and Periodo = '".$Periodo."'";
														$bdDoc=$link->query($actSQL);
													}else{
														$PAMAtrSal++;
														$RutCli = $rowCp['RutCli'];
														$link->query("insert into ClientesEstrellas(RutCli,
																									Periodo,
																									PAMAtrSal
																								)	 
																					  values 	(	'$RutCli',
																									'$Periodo',
																									'$PAMAtrSal'
																								)");
													}
												}
											}
									}
								}while ($rowCp=mysqli_fetch_array($bdCp));
							}
							//echo 'T Cot'.$tCot;

							if($tCot > 0){
								echo number_format(($tCotAtr/$tCot), 2, ',', '.');
								?>
								<a href="PAMatrazadas.php?AgnoAtr=<?php echo $pAgno; ?>&MesAtr=<?php echo $m; ?>&Clasificacion=0" id="indCotiza" style="text-decoration: none;">
									<?php echo '<br><span style="font-size:12px; font-weight: bold;">'.$tCotAtr.' / '.$tCot.'</span>'; ?>
								</a>
								<?php
							}
							$actSQL="UPDATE ClientesEstrellas SET ";
							$actSQL.="RegHis		= 'on'";
							$actSQL.="WHERE Periodo = '".$Periodo."'";
							$bdDoc=$link->query($actSQL);
							$link->close();
					//}
					?>
				</td>
				<?php
			}
		?>
		
		<td align="center">
			<?php
				$tCotAtr 	= 0;
				$tAgno 		= 0;
				for($i=1; $i<=12; $i++){
					//if($i <= $mesInd){
						$tAgno 		+= $tCotAnu[$i];
						$tCotAtr 	+= $tCotAtrAnu[$i];
					//}
				}
				if($tCotAtr > 0){
					echo number_format(($tCotAtr/$tAgno), 2, ',', '.');
					echo '<br><span style="font-size:9px;">'.$tCotAtr.' / '.$tAgno.'</span>';
				}
			?>
		</td>
	</tr>
	
	<tr style="background-color:#fff;">
		<td style="padding-left:10px;">
			PAM Atrazadas <img src="../imagenes/estrella.png" width="20"> <img src="../imagenes/estrella.png" width="20"> <img src="../imagenes/estrella.png" width="20">
		<td>

		<?php
			$tAgno 		= 0;
			$tCotAtrAnu	= array(0,0,0,0,0,0,0,0,0,0,0,0,0);
			$tCotAnu	= array(0,0,0,0,0,0,0,0,0,0,0,0,0);
			for($i=1; $i<=12; $i++){
				?>
				<td align="center">
					<?php
					//if($i <= $mesInd){
							$tCot 	 = 0;
							$tCotAtr = 0;
							$m = $i;
							if($i < 10){
								$m = '0'.$i;
							}
							$link=Conectarse();
							$SQLt = "SELECT * FROM Cotizaciones Where Estado = 'T' and year(fechaInicio) = $pAgno and month(fechaInicio) = $m";
							$bdCp=$link->query($SQLt);
							if($rowCp=mysqli_fetch_array($bdCp)){
								do{
									$Periodo = $m.'-'.$pAgno;
									$SQLcli = "SELECT * FROM Clientes Where RutCli = '".$rowCp['RutCli']."' and Clasificacion = '1'";
									//$SQLcli = "SELECT * FROM ClientesEstrellas Where RutCli = '".$rowCp['RutCli']."' Periodo = $Periodo and Clasificacion = '1'";
									$bdCli=$link->query($SQLcli);
									if($rowCli=mysqli_fetch_array($bdCli)){

										$tCot++;
										$tCotAnu[$i]++;
										$fechaTermino 	= strtotime ( '+'.$rowCp['dHabiles'].' day' , strtotime ( $rowCp['fechaInicio'] ) );
										$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );

										$fechaInicio = $rowCp['fechaInicio'];
			$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
			$ft = $fechaInicio;
			$dh	= $rowCp['dHabiles'] - 1;

			$dd	= 0;
			for($j=1; $j<=$dh; $j++){
				$ft	= strtotime ( '+'.$j.' day' , strtotime ( $fechaInicio ) );
				$ft	= date ( 'Y-m-d' , $ft );
				//echo $ft.'<br>';
				$dia_semana = date("w",strtotime($ft));
				if($dia_semana == 0 or $dia_semana == 6){
					$dh++;
					$dd++;
				}
				$SQL = "SELECT * FROM diasferiados Where fecha = '".$ft."'";
				$bdDf=$link->query($SQL);
				if($row=mysqli_fetch_array($bdDf)){
					$dh++;
					$dd++;
				}
			}
			$fechaTermino = $ft;
													
										if($rowCp['fechaTermino'] > '0000-00-00'){
											//if($rowCp['fechaTermino'] > $rowCp['fechaEstimadaTermino']){
											if($rowCp['fechaTermino'] > $fechaTermino){
												$tCotAtr++;
												$tCotAtrAnu[$i]++;
												
												$PAMAtrSal  = 0;
												$PAMAtr		= 0;
												
											}
										}
									}
								}while ($rowCp=mysqli_fetch_array($bdCp));
							}
							if($tCot > 0){
								echo number_format(($tCotAtr/$tCot), 2, ',', '.');
								?>
								<a href="PAMatrazadas.php?AgnoAtr=<?php echo $pAgno; ?>&MesAtr=<?php echo $m; ?>&Clasificacion=1" id="indCotiza" style="text-decoration: none;">
									<?php echo '<br><span style="font-size:12px; font-weight: bold;">'.$tCotAtr.' / '.$tCot.'</span>'; ?>
								</a>
								<?php
							}
							
							$link->close();
					//}
					?>
				</td>
				<?php
			}
		?>
		
		<td align="center">
			<?php
				$tCotAtr 	= 0;
				$tAgno 		= 0;
				for($i=1; $i<=12; $i++){
					//if($i <= $mesInd){
						$tAgno 		+= $tCotAnu[$i];
						$tCotAtr 	+= $tCotAtrAnu[$i];
					//}
				}
				if($tCotAtr > 0){
					echo number_format(($tCotAtr/$tAgno), 2, ',', '.');
					echo '<br><span style="font-size:9px;">'.$tCotAtr.' / '.$tAgno.'</span>';
				}
			?>
		</td>
	</tr>

	<tr style="background-color:#fff;">
		<td style="padding-left:10px;">
			PAM Atrazadas <img src="../imagenes/estrella.png" width="20"> <img src="../imagenes/estrella.png" width="20">
		<td>

		<?php
			$tAgno 		= 0;
			$tCotAtrAnu	= array(0,0,0,0,0,0,0,0,0,0,0,0,0);
			$tCotAnu	= array(0,0,0,0,0,0,0,0,0,0,0,0,0);
			for($i=1; $i<=12; $i++){
				?>
				<td align="center">
					<?php
					//if($i <= $mesInd){
							$tCot 	 = 0;
							$tCotAtr = 0;
							$m = $i;
							if($i < 10){
								$m = '0'.$i;
							}
							$link=Conectarse();
							$SQLt = "SELECT * FROM Cotizaciones Where Estado = 'T' and year(fechaInicio) = $pAgno and month(fechaInicio) = $m";
							$bdCp=$link->query($SQLt);
							if($rowCp=mysqli_fetch_array($bdCp)){
								do{
									$SQLcli = "SELECT * FROM Clientes Where RutCli = '".$rowCp['RutCli']."' and Clasificacion = '2'";
									$bdCli=$link->query($SQLcli);
									if($rowCli=mysqli_fetch_array($bdCli)){

										$tCot++;
										$tCotAnu[$i]++;
										$fechaTermino 	= strtotime ( '+'.$rowCp['dHabiles'].' day' , strtotime ( $rowCp['fechaInicio'] ) );
										$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );
			$fechaInicio = $rowCp['fechaInicio'];
			$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
			$ft = $fechaInicio;
			$dh	= $rowCp['dHabiles'] - 1;

			$dd	= 0;
			for($j=1; $j<=$dh; $j++){
				$ft	= strtotime ( '+'.$j.' day' , strtotime ( $fechaInicio ) );
				$ft	= date ( 'Y-m-d' , $ft );
				//echo $ft.'<br>';
				$dia_semana = date("w",strtotime($ft));
				if($dia_semana == 0 or $dia_semana == 6){
					$dh++;
					$dd++;
				}
				$SQL = "SELECT * FROM diasferiados Where fecha = '".$ft."'";
				$bdDf=$link->query($SQL);
				if($row=mysqli_fetch_array($bdDf)){
					$dh++;
					$dd++;
				}
			}
			$fechaTermino = $ft;
													
										if($rowCp['fechaTermino'] > '0000-00-00'){
											//if($rowCp['fechaTermino'] > $rowCp['fechaEstimadaTermino']){
											if($rowCp['fechaTermino'] > $fechaTermino){
												$tCotAtr++;
												$tCotAtrAnu[$i]++;
											}
										}
									}
								}while ($rowCp=mysqli_fetch_array($bdCp));
							}
							if($tCot > 0){
								echo number_format(($tCotAtr/$tCot), 2, ',', '.');
								?>
								<a href="PAMatrazadas.php?AgnoAtr=<?php echo $pAgno; ?>&MesAtr=<?php echo $m; ?>&Clasificacion=2" id="indCotiza" style="text-decoration: none;">
									<?php echo '<br><span style="font-size:12px; font-weight: bold;">'.$tCotAtr.' / '.$tCot.'</span>'; ?>
								</a>
								<?php
							}
/*							
							$Periodo = $m.'-'.$pAgno;
							$tPAMAtrSal = 0;
							$tPAMAtr 	= 0;
							$SQLcli = "SELECT * FROM Clientes Where Clasificacion = '2'";
							$bdCli=$link->query($SQLcli);
							if($rowCli=mysqli_fetch_array($bdCli)){
								$SQLcc = "SELECT * FROM ClientesEstrellas Where Periodo = '".$Periodo."' and Clasificacion = '2'";
								$bdcc = $link->query($SQLcc);
								if($rowcc=mysqli_fetch_array($bdcc)){
									do{
										$tPAMAtrSal += $rowcc['PAMAtrSal'];
										$tPAMAtr 	+= $rowcc['PAMAtr'];
									}while ($rowcc=mysqli_fetch_array($bdcc));
								}
								if($tPAMAtr > 0){
									if($tPAMAtrSal > $tPAMAtr){
										echo '<div style="color:#FE642E;">'.$tPAMAtrSal.'/'.$tPAMAtr;
									}else{
										echo '<div style="color:#0080FF;">'.$tPAMAtrSal.'/'.$tPAMAtr;
									}
								}
							}
*/							
							$link->close();
					//}
					?>
				</td>
				<?php
			}
		?>
		
		<td align="center">
			<?php
				$tCotAtr 	= 0;
				$tAgno 		= 0;
				for($i=1; $i<=12; $i++){
					//if($i <= $mesInd){
						$tAgno 		+= $tCotAnu[$i];
						$tCotAtr 	+= $tCotAtrAnu[$i];
					//}
				}
				if($tCotAtr > 0){
					echo number_format(($tCotAtr/$tAgno), 2, ',', '.');
					echo '<br><span style="font-size:9px;">'.$tCotAtr.' / '.$tAgno.'</span>';
				}
			?>
		</td>
	</tr>

	<tr style="background-color:#fff;">
		<td style="padding-left:10px;">
			PAM Atrazadas <img src="../imagenes/estrella.png" width="20">
		<td>

		<?php
			$tAgno 		= 0;
			$tCotAtrAnu	= array(0,0,0,0,0,0,0,0,0,0,0,0,0);
			$tCotAnu	= array(0,0,0,0,0,0,0,0,0,0,0,0,0);
			for($i=1; $i<=12; $i++){
				?>
				<td align="center">
					<?php
					//if($i <= $mesInd){
							$tCot 	 = 0;
							$tCotAtr = 0;
							$m = $i;
							if($i < 10){
								$m = '0'.$i;
							}
							$link=Conectarse();
							$SQLt = "SELECT * FROM Cotizaciones Where Estado = 'T' and year(fechaInicio) = $pAgno and month(fechaInicio) = $m";
							$bdCp=$link->query($SQLt);
							if($rowCp=mysqli_fetch_array($bdCp)){
								do{
									$SQLcli = "SELECT * FROM Clientes Where RutCli = '".$rowCp['RutCli']."' and Clasificacion = '3'";
									$bdCli=$link->query($SQLcli);
									if($rowCli=mysqli_fetch_array($bdCli)){

										$tCot++;
										$tCotAnu[$i]++;
										$fechaTermino 	= strtotime ( '+'.$rowCp['dHabiles'].' day' , strtotime ( $rowCp['fechaInicio'] ) );
										$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );
			$fechaInicio = $rowCp['fechaInicio'];
			$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
			$ft = $fechaInicio;
			$dh	= $rowCp['dHabiles'] - 1;

			$dd	= 0;
			for($j=1; $j<=$dh; $j++){
				$ft	= strtotime ( '+'.$j.' day' , strtotime ( $fechaInicio ) );
				$ft	= date ( 'Y-m-d' , $ft );
				//echo $ft.'<br>';
				$dia_semana = date("w",strtotime($ft));
				if($dia_semana == 0 or $dia_semana == 6){
					$dh++;
					$dd++;
				}
				$SQL = "SELECT * FROM diasferiados Where fecha = '".$ft."'";
				$bdDf=$link->query($SQL);
				if($row=mysqli_fetch_array($bdDf)){
					$dh++;
					$dd++;
				}
			}
			$fechaTermino = $ft;
													
										if($rowCp['fechaTermino'] > '0000-00-00'){
											//if($rowCp['fechaTermino'] > $rowCp['fechaEstimadaTermino']){
											if($rowCp['fechaTermino'] > $fechaTermino){
												$tCotAtr++;
												$tCotAtrAnu[$i]++;
											}
										}
									}
								}while ($rowCp=mysqli_fetch_array($bdCp));
							}
							if($tCot > 0){
								echo number_format(($tCotAtr/$tCot), 2, ',', '.');
								?>
								<a href="PAMatrazadas.php?AgnoAtr=<?php echo $pAgno; ?>&MesAtr=<?php echo $m; ?>&Clasificacion=3" id="indCotiza" style="text-decoration: none;">
									<?php echo '<br><span style="font-size:12px; font-weight: bold;">'.$tCotAtr.' / '.$tCot.'</span>'; ?>
								</a>
								<?php
							}
/*							
							$Periodo = $m.'-'.$pAgno;
							$tPAMAtrSal = 0;
							$tPAMAtr 	= 0;
							$SQLcli = "SELECT * FROM Clientes Where Clasificacion = '1'";
							$bdCli=$link->query($SQLcli);
							if($rowCli=mysqli_fetch_array($bdCli)){
								$SQLcc = "SELECT * FROM ClientesEstrellas Where Periodo = '".$Periodo."' and Clasificacion = '1'";
								$bdcc = $link->query($SQLcc);
								if($rowcc=mysqli_fetch_array($bdcc)){
									do{
										$tPAMAtrSal += $rowcc['PAMAtrSal'];
										$tPAMAtr 	+= $rowcc['PAMAtr'];
									}while ($rowcc=mysqli_fetch_array($bdcc));
								}
								if($tPAMAtr > 0){
									if($tPAMAtrSal > $tPAMAtr){
										echo '<div style="color:#FE642E;">'.$tPAMAtrSal.'/'.$tPAMAtr;
									}else{
										echo '<div style="color:#0080FF;">'.$tPAMAtrSal.'/'.$tPAMAtr;
									}
								}
							}
*/							
							
							$link->close();
					//}
					?>
				</td>
				<?php
			}
		?>
		
		<td align="center">
			<?php
				$tCotAtr 	= 0;
				$tAgno 		= 0;
				for($i=1; $i<=12; $i++){
					//if($i <= $mesInd){
						$tAgno 		+= $tCotAnu[$i];
						$tCotAtr 	+= $tCotAtrAnu[$i];
					//}
				}
				if($tCotAtr > 0){
					echo number_format(($tCotAtr/$tAgno), 2, ',', '.');
					echo '<br><span style="font-size:9px;">'.$tCotAtr.' / '.$tAgno.'</span>';
				}
			?>
		</td>
	</tr>
	</tbody>
</table>