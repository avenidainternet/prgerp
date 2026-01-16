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
	$fechaHoy = date('Y-m-d');
	$fdMes = explode('-', $fechaHoy);
	?>
<h3 class="bg-light text-dark">Tabla Indicadores </h3>
<table class="table table-hover">
	<thead class="thead-light">
		<tr>
			<th style="padding-left:10px;" width="20%">
				Indicador
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
			<th align="center"> Tot. </td>
		</tr>
		</thead>
		<tbody>
		<tr style="background-color:#fff;">
			<td style="padding-left:10px;">
				Mínimo
			<td>
			<?php
				$tAgno 	= 0;
				$mMes	= 0;
				$mAgno	= 0;
				$cMeses	= 0;
				for($i=1; $i<=12; $i++){
					?>
					<td align="center">
						<?php
							$link=Conectarse();
							$bdTi=$link->query("SELECT * FROM tablaindicadores Where agnoInd = $pAgno and mesInd = $i");
							while($rowTi=mysqli_fetch_array($bdTi)){
									echo $rowTi['indMin'];
									$tAgno += $rowTi['indMin'];
									$cMeses++;
							}
							$link->close();
						?>
					<td>
					<?php
				}
			?>
			<td align="center" style="padding-top:5px; padding-botton:5px;">
				<?php 
					if($cMeses > 0 and $tAgno > 0){
						echo number_format($tAgno,1); 
						echo '</br>'.number_format($tAgno/$cMeses,1); 
					}
				?>
			</td>
		</tr>
		<tr style="background-color:#fff;">
			<td style="padding-left:10px;">
				Meta
			<td>
			<?php
				$tAgno 	= 0;
				$mMes	= 0;
				$mAgnoM	= 0;
				$cMeses	= 0;
				for($i=1; $i<=12; $i++){
					?>
					<td align="center">
						<?php
							$link=Conectarse();
							$bdTi=$link->query("SELECT * FROM tablaindicadores Where agnoInd = $pAgno and mesInd = $i");
							while($rowTi=mysqli_fetch_array($bdTi)){
									echo $rowTi['indMeta'];
									$tAgno += $rowTi['indMeta'];
									$cMeses++;
							}
							$link->close();
						?>
					<td>
					<?php
				}
			?>
			<td align="center" style="padding-top:5px; padding-botton:5px;">
				<?php 
					if($tAgno > 0 and $cMeses > 0){
						$mAgnoM = $tAgno/$cMeses;
						echo number_format($tAgno,1); 
						echo '</br>'.number_format($mAgnoM,1); 
					}
				?>
			</td>
		</tr>
		<tr style="background-color:#fff;">
			<td style="padding-left:10px;">
				Indice
			<td>
			<?php
				$tAgno 	= 0;
				$mMes	= 0;
				$mAgnoI	= 0;
				$cMeses	= 0;
				
				
				$vcIva = array(0,0,0,0,0,0,0,0,0,0,0,0);

				$tVtas = array(
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
					12 => 0,
					'totalVtas' => 0
				);
				
				for($i=1; $i<=12; $i++){
					?>
					<td align="center">
						<?php
							$link=Conectarse();
							$SQL = "SELECT * FROM tabIndices Where year(fechaIndice) = $pAgno and month(fechaIndice) = $i Order By fechaIndice Desc";
							//echo $SQL;
							$bdTi=$link->query($SQL);
							if($rowTi=mysqli_fetch_array($bdTi)){
								$colorIndice = "";
								if($rowTi['indVtas'] >= $rowTi['iMeta']){
									$colorIndice = "indicadorIndiceVerde";
								}
								if($rowTi['indVtas'] < $rowTi['iMeta']){
									$colorIndice = "indicadorIndiceRojo";
								}
								$tAgno += $rowTi['indVtas'];
								$cMeses++;
								
								$fdIn = explode('-',$rowTi['fechaIndice']);
								$ii = $fdIn[1] - 1;
								$vcIva[$ii] = $rowTi['indVtas'];//*0.775;

								$tVtas[$i] = $rowTi['indVtas'];
								$tVtas['totalVtas'] += $rowTi['indVtas'];
								echo '<span class='.$colorIndice.'>'.$rowTi['indVtas'].'</span>';
								echo '<br>'.number_format($tAgno,2);
							}
							$link->close();
						?>
					<td>
					<?php
				}
			?>
			<td align="center" style="padding-top:5px; padding-botton:5px;">
				<?php 
					$mAgnoI = $tAgno/$cMeses;
					$colorIndice = "";
					if($mAgnoI >= $mAgnoM){
						$colorIndice = "indicadorIndiceVerde";
					}
					if($mAgnoI < $mAgnoM){
						$colorIndice = "indicadorIndiceRojo";
					}
					echo '<span class='.$colorIndice.'>'.number_format($mAgnoI,2).'</span>';
					echo '<br>'.number_format($tAgno,2); 
				?>
			</td>
		</tr>


		<tr style="background-color:#fff;">
			<td style="padding-left:10px;">
				Descuentos
			<td>
			<?php
				$tDesc = array(
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
					12 => 0,
					'totalDesc' => 0
				);
				for($i=1; $i<=12; $i++){
					?>
					<td align="center">
						<?php
							$link=Conectarse();
							$SQL = "SELECT * FROM tablaindicadores Where agnoInd = $pAgno and mesInd = $i";
							//echo $SQL;
							$bdTi=$link->query($SQL);
							if($rowTi=mysqli_fetch_array($bdTi)){
								echo number_format($rowTi['indDesc']+$rowTi['indDesc2']+$rowTi['indDesc3'],2);
								$tDesc[$i] = ($rowTi['indDesc']+$rowTi['indDesc2']+$rowTi['indDesc3']);
								$tDesc['totalDesc'] += $tDesc[$i];
							}
							$link->close();
						?>
					<td>
					<?php
				}
			?>
			<td align="center" style="padding-top:5px; padding-botton:5px;">
				<?php
					echo number_format($tDesc['totalDesc'],2);
				?>
			</td>
		</tr>



		<tr style="background-color:#fff;">
			<td style="padding-left:10px;">
				Indice - Descuentos
			<td>
			<?php
				for($i=1; $i<=12; $i++){
					?>
					<td align="center">
						<?php
						if($tVtas[$i] > 0){
							echo number_format(($tVtas[$i] - $tDesc[$i]),2);
						}
						?>
					<td>
					<?php
				}
			?>
			<td align="center" style="padding-top:5px; padding-botton:5px;">
				<?php
					echo number_format(($tVtas['totalVtas'] - $tDesc['totalDesc']),2);
				?>
			</td>
		</tr>




		<tr style="background-color:#fff;">
			<td style="padding-left:10px;">
				Productividad
			<td>
			<?php
				$tAgno 	= 0;
				$mMes	= 0;
				$mAgno	= 0;
				$cMeses	= 0;
				for($i=1; $i<=12; $i++){
					?>
					<td align="center">
						<?php
							$link=Conectarse();
							$SQL = "SELECT * FROM tabIndices Where year(fechaIndice) = $pAgno and month(fechaIndice) = $i Order By fechaIndice Desc";
							//echo $SQL;
							$bdTi=$link->query($SQL);
							if($rowTi=mysqli_fetch_array($bdTi)){
								$colorIndice = "";
								$tAgno += $rowTi['iProductividad'];
								$cMeses++;
								echo $rowTi['iProductividad'];
								echo '<br>'.number_format($tAgno,2);
							}
							$link->close();
						?>
					<td>
					<?php
				}
			?>
			<td align="center" style="padding-top:5px; padding-botton:5px;">
				<?php 
					echo number_format($tAgno/$cMeses,1); 
					echo '</br>'.number_format($tAgno,1); 
				?>
			</td>
		</tr>


		<tr style="background-color:#fff;">
			<td style="padding-left:10px;">
				Descuentos
			<td>
			<?php
				$tAgno 	= 0;
				$mMes	= 0;
				$mAgno	= 0;
				$cMeses	= 0;
				for($i=1; $i<=12; $i++){
					?>
					<td align="center">
						<?php
							$link=Conectarse();
							$SQL = "SELECT * FROM tablaindicadores Where agnoInd = $pAgno and mesInd = $i";
							//echo $SQL;
							$bdTi=$link->query($SQL);
							if($rowTi=mysqli_fetch_array($bdTi)){
								$colorIndice = "";
								$tAgno += $rowTi['indDesc'];
								$cMeses++;
								echo $rowTi['indDesc'];
								echo '<br>'.number_format($tAgno,2);
							}
							$link->close();
						?>
					<td>
					<?php
				}
			?>
			<td align="center" style="padding-top:5px; padding-botton:5px;">
				<?php 
					if($tAgno > 0){
						echo number_format($tAgno/$cMeses,1); 
						echo '</br>'.number_format($tAgno,1); 
					}
				?>
			</td>
		</tr>






<!-- AF -->
		<tr style="background-color:#fff;">
			<td style="padding-left:10px;">
				Productividad AF
			<td>
			<?php
				$tAgno 	= 0;
				$mMes	= 0;
				$mAgno	= 0;
				$cMeses	= 0;
				for($i=1; $i<=12; $i++){
					?>
					<td align="center">
						<?php
							$link=Conectarse();
							$ultUF	= 0;

							$bdUfRef=$link->query("Select * From tablaRegForm");
							if($rowUfRef=mysqli_fetch_array($bdUfRef)){
								$ultUF = $rowUfRef['valorUFRef'];
							}
							$ultUF = 1;
							$bdTi=$link->query("SELECT * FROM tablaindicadores Where agnoInd = $pAgno and mesInd = $i");
							if($rowTi=mysqli_fetch_array($bdTi)){
								if($rowTi['ProductividadAF'] == 0){
									$tProdAF		= 0;
									$tProduccionP	= 0;
									$tProductividad	= 0;
									$link	= Conectarse();
									$bdCot  = $link->query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'T' and fechaInicio > '0000-00-00' and year(fechaTermino) = $pAgno and month(fechaTermino) = '".$i."'");
									while($rowCot=mysqli_fetch_array($bdCot)){
											$bdPer=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowCot['RutCli']."'");
											if($rowP=mysqli_fetch_array($bdPer)){
												$cFree = $rowP['cFree'];
												if($rowP['cFree'] != 'on'){
													if($rowCot['NetoUF']>0 and $rowCot['Neto'] == 0){
														$tProductividad += $rowCot['NetoUF'];
														if($rowCot['tpEnsayo'] == 2){
															$tProdAF += ($rowCot['NetoUF'] * $ultUF);
														}
													}else{
														$tProduccionP += $rowCot['Neto'];
														if($rowCot['tpEnsayo'] == 2){
															$tProdAF += $rowCot['Neto'];
														}
													}
												}
											}
									}
									//echo $tProductividad.' '.$tProduccionP;
									if($tProdAF > 0){
										$ProductividadAF  	= $tProdAF;
										$tProdAF  			= round($tProdAF/1000000,2);
										echo $tProdAF;
										$actSQL="UPDATE tablaindicadores SET ";
										$actSQL.="ProductividadAF	= '".$ProductividadAF.	"'";
										$actSQL.="WHERE agnoInd = $pAgno and mesInd = $i";
										$bdProc=$link->query($actSQL);
									}
								}else{
									$tProdAF  = round($rowTi['ProductividadAF']/1000000,2);
									$tAgno += $tProdAF;
									echo $tProdAF;
									if($rowTi['nInfoAF'] > 0){
										echo '<sup><span class="badge badge-success">'.$rowTi['nInfoAF'].'</span></sup>';
									}

									echo '<br>'.$tAgno;
								}
							}
							$link->close();
						?>
					<td>
					<?php
					$cMeses++;
				}
			?>
			<td align="center" style="padding-top:5px; padding-botton:5px;">
				<?php 
					echo number_format($tAgno/$cMeses,1); 
					echo '</br>'.number_format($tAgno,1); 
				?>
			</td>
		</tr>
<!-- AF -->



<!--  Nuevo IC -->
		<tr style="background-color:#fff;">
			<td style="padding-left:10px;">
				Productividad IC
			<td>
			<?php
				$tAgno 	= 0;
				$mMes	= 0;
				$mAgno	= 0;
				$cMeses	= 0;
				$tProdIC = 0;
				for($i=1; $i<=12; $i++){
					?>
					<td align="center">
						<?php
							$link=Conectarse();
							$ultUF	= 0;

							$bdUfRef=$link->query("Select * From tablaRegForm");
							if($rowUfRef=mysqli_fetch_array($bdUfRef)){
								$ultUF = $rowUfRef['valorUFRef'];
							}
							$ultUF = 1;
							$bdTi=$link->query("SELECT * FROM tablaindicadores Where agnoInd = $pAgno and mesInd = $i");
							if($rowTi=mysqli_fetch_array($bdTi)){
								if($rowTi['ProductividadIC'] == 0){
									$tProdIC		= 0;
									$tProduccionP	= 0;
									$tProductividad	= 0;
									$link	= Conectarse();
									$bdCot  = $link->query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'T' and fechaInicio > '0000-00-00' and year(fechaTermino) = $pAgno and month(fechaTermino) = '".$i."'");
									while($rowCot=mysqli_fetch_array($bdCot)){
											$bdPer=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowCot['RutCli']."'");
											if($rowP=mysqli_fetch_array($bdPer)){
												$cFree = $rowP['cFree'];
												if($rowP['cFree'] != 'on'){
													if($rowCot['NetoUF']>0 and $rowCot['Neto'] == 0){
														$tProductividad += $rowCot['NetoUF'];
														if($rowCot['tpEnsayo'] == 1){
															$tProdIC += ($rowCot['NetoUF'] * $ultUF);
														}
													}else{
														$tProduccionP += $rowCot['Neto'];
														if($rowCot['tpEnsayo'] == 1){
															$tProdIC += $rowCot['Neto'];
														}
													}
												}
											}
									}
									//echo $tProductividad.' '.$tProduccionP;
									if($tProdIC > 0){
										$ProductividadIC  	= $tProdIC;
										$tProdIC  			= round($tProdIC/1000000,2);
										echo $tProdIC;
										$actSQL="UPDATE tablaindicadores SET ";
										$actSQL.="ProductividadIC	= '".$ProductividadIC.	"'";
										$actSQL.="WHERE agnoInd = $pAgno and mesInd = $i";
										$bdProc=$link->query($actSQL);
									}
								}else{
									$tProdIC  = round($rowTi['ProductividadIC']/1000000,2);
									$tAgno += $tProdIC;
									echo $tProdIC;
									if($rowTi['nInfoIC'] > 0){
										echo '<sup><span class="badge badge-success">'.$rowTi['nInfoIC'].'</span></sup>';
									}

									echo '<br>'.$tAgno;
								}
							}
							$link->close();
						?>
					<td>
					<?php
					$cMeses++;
				}
			?>
			<td align="center" style="padding-top:5px; padding-botton:5px;">
				<?php 
					echo number_format($tAgno/$cMeses,1); 
					echo '</br>'.number_format($tAgno,1); 
				?>
			</td>
		</tr>
<!--  Nuevo IC -->



<!--  Nuevo CF -->
		<tr style="background-color:#fff;">
			<td style="padding-left:10px;">
				Productividad CE
			<td>
			<?php
				$tAgno 	= 0;
				$mMes	= 0;
				$mAgno	= 0;
				$cMeses	= 0;
				$tProdCF = 0;
				for($i=1; $i<=12; $i++){
					?>
					<td align="center">
						<?php
							$link=Conectarse();
							$ultUF	= 0;

							$bdUfRef=$link->query("Select * From tablaRegForm");
							if($rowUfRef=mysqli_fetch_array($bdUfRef)){
								$ultUF = $rowUfRef['valorUFRef'];
							}
							$ultUF = 1;
							$bdTi=$link->query("SELECT * FROM tablaindicadores Where agnoInd = $pAgno and mesInd = $i");
							if($rowTi=mysqli_fetch_array($bdTi)){
								if($rowTi['ProductividadCF'] == 0){
									$tProdCF		= 0;
									$tProduccionP	= 0;
									$tProductividad	= 0;
									$link	= Conectarse();
									$bdCot  = $link->query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'T' and fechaInicio > '0000-00-00' and year(fechaTermino) = $pAgno and month(fechaTermino) = '".$i."'");
									while($rowCot=mysqli_fetch_array($bdCot)){
											$bdPer=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowCot['RutCli']."'");
											if($rowP=mysqli_fetch_array($bdPer)){
												$cFree = $rowP['cFree'];
												if($rowP['cFree'] != 'on'){
													if($rowCot['NetoUF']>0 and $rowCot['Neto'] == 0){
														if($rowCot['tpEnsayo'] == 3){
															$tProdCF += ($rowCot['NetoUF'] * $ultUF);
														}
													}else{
														if($rowCot['tpEnsayo'] == 3){
															$tProdCF += $rowCot['Neto'];
														}
													}
												}
											}
									}
									//echo $tProductividad.' '.$tProduccionP;
									if($tProdCF > 0){
										$ProductividadCF  	= $tProdCF;
										$tProdCF  			= round($tProdCF/1000000,2);
										echo $tProdIC;
										$actSQL="UPDATE tablaindicadores SET ";
										$actSQL.="ProductividadCF	= '".$ProductividadCF.	"'";
										$actSQL.="WHERE agnoInd = $pAgno and mesInd = $i";
										$bdProc=$link->query($actSQL);
									}
								}else{
									$tProdCF  = round($rowTi['ProductividadCF']/1000000,2);
									$tAgno += $tProdCF;
									echo $tProdCF;
									if($rowTi['nInfoCE'] > 0){
										echo '<sup><span class="badge badge-success">'.$rowTi['nInfoCE'].'</span></sup>';
									}
									echo '<br>'.$tAgno;
								}
							}
							$link->close();
						?>
					<td>
					<?php
					$cMeses++;
				}
			?>
			<td align="center" style="padding-top:5px; padding-botton:5px;">
				<?php 
					echo number_format($tAgno/$cMeses,1); 
					echo '</br>'.number_format($tAgno,1); 
				?>
			</td>
		</tr>
<!--  Nuevo CF -->

<!--  Nuevo IC -->
		<tr style="background-color:#fff;">
			<td style="padding-left:10px;">
				Productividad IR
			<td>
			<?php
				$tAgno 	= 0;
				$mMes	= 0;
				$mAgno	= 0;
				$cMeses	= 0;
				$tProdIR = 0;
				for($i=1; $i<=12; $i++){
					?>
					<td align="center">
						<?php
							$link=Conectarse();
							$ultUF	= 0;

							$bdUfRef=$link->query("Select * From tablaRegForm");
							if($rowUfRef=mysqli_fetch_array($bdUfRef)){
								$ultUF = $rowUfRef['valorUFRef'];
							}
							$ultUF = 1;
							$bdTi=$link->query("SELECT * FROM tablaindicadores Where agnoInd = $pAgno and mesInd = $i");
							if($rowTi=mysqli_fetch_array($bdTi)){
								if($rowTi['ProductividadIR'] == 0){
									$tProdIR		= 0;
									$link	= Conectarse();
									$bdCot  = $link->query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'T' and fechaInicio > '0000-00-00' and year(fechaTermino) = $pAgno and month(fechaTermino) = '".$i."'");
									while($rowCot=mysqli_fetch_array($bdCot)){
											$bdPer=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowCot['RutCli']."'");
											if($rowP=mysqli_fetch_array($bdPer)){
												$cFree = $rowP['cFree'];
												if($rowP['cFree'] != 'on'){
													if($rowCot['NetoUF']>0 and $rowCot['Neto'] == 0){
														if($rowCot['tpEnsayo'] == 4){
															$tProdIR += ($rowCot['NetoUF'] * $ultUF);
														}
													}else{
														if($rowCot['tpEnsayo'] == 4){
															$tProdIR += $rowCot['Neto'];
														}
													}
												}
											}
									}
									//echo $tProductividad.' '.$tProduccionP;
									if($tProdIR > 0){
										$ProductividadIR  	= $tProdIR;
										$tProdIR  			= round($tProdIR/1000000,2);
										echo $tProdIR;
										$actSQL="UPDATE tablaindicadores SET ";
										$actSQL.="ProductividadIR	= '".$ProductividadIR.	"'";
										$actSQL.="WHERE agnoInd = $pAgno and mesInd = $i";
										$bdProc=$link->query($actSQL);
									}
								}else{
									$tProdIR  = round($rowTi['ProductividadIR']/1000000,2);
									$tAgno += $tProdIR;
									echo $tProdIR;
									if($rowTi['nInfoIR'] > 0){
										echo '<sup><span class="badge badge-success">'.$rowTi['nInfoIR'].'</span></sup>';
									}
									echo '<br>'.$tAgno;
								}
							}
							$link->close();
						?>
					<td>
					<?php
					$cMeses++;
				}
			?>
			<td align="center" style="padding-top:5px; padding-botton:5px;">
				<?php 
					echo number_format($tAgno/$cMeses,1); 
					echo '</br>'.number_format($tAgno,1); 
				?>
			</td>
		</tr>
<!--  Nuevo IC -->
<!--  Nuevo IO -->
		<tr style="background-color:#fff;">
			<td style="padding-left:10px;">
				Productividad IO
			<td>
			<?php
				$tAgno 	= 0;
				$mMes	= 0;
				$mAgno	= 0;
				$cMeses	= 0;
				$tProdIO = 0;
				$nInfoIO = 0;
				for($i=1; $i<=12; $i++){
					?>
					<td align="center">
						<?php
							$link=Conectarse();
							$ultUF	= 0;

							$bdUfRef=$link->query("Select * From tablaRegForm");
							if($rowUfRef=mysqli_fetch_array($bdUfRef)){
								$ultUF = $rowUfRef['valorUFRef'];
							}
							//$ultUF = 1;
							$bdTi=$link->query("SELECT * FROM tablaindicadores Where agnoInd = $pAgno and mesInd = $i");
							if($rowTi=mysqli_fetch_array($bdTi)){
								if($rowTi['ProductividadIO'] == 0){
									$tProdIO	= 0;
									$nInfoIO 	= 0;
									$link	= Conectarse();
									$bdCot  = $link->query("SELECT * FROM Cotizaciones Where tpEnsayo = 5 and RAM > 0 and Estado = 'T' and fechaInicio > '0000-00-00' and year(fechaTermino) = $pAgno and month(fechaTermino) = '".$i."'");
									while($rowCot=mysqli_fetch_array($bdCot)){
										$nInfoIO++;
										if($rowCot['NetoUF']>0 and $rowCot['Neto'] == 0){
											$tProdIO += ($rowCot['NetoUF'] * $ultUF);	
										}else{
											$tProdIO += $rowCot['Neto'];
										}
									}
									//echo $tProductividad.' '.$tProduccionP;
									if($tProdIO > 0){
										$ProductividadIO  	= $tProdIO;
										$tProdIO  			= round($tProdIO/1000000,2);
										echo $tProdIO;
										$actSQL="UPDATE tablaindicadores SET ";
										$actSQL.="nInfoIO			= '".$nInfoIO			.	"',";
										$actSQL.="ProductividadIO	= '".$ProductividadIO	.	"'";
										$actSQL.="WHERE agnoInd = $pAgno and mesInd = $i";
										$bdProc=$link->query($actSQL);
									}
								}else{
									$tProdIO  = round($rowTi['ProductividadIO']/1000000,2);
									$tAgno += $tProdIO;
									echo $tProdIO;
									
									if($rowTi['nInfoIO'] > 0){
										echo '<sup><span class="badge badge-success">'.$rowTi['nInfoIO'].'</span></sup>';
									}
									
									echo '<br>'.$tAgno;
								}
							}
							$link->close();
						?>
					<td>
					<?php
					$cMeses++;
				}
			?>
			<td align="center" style="padding-top:5px; padding-botton:5px;">
				<?php 
					echo number_format($tAgno/$cMeses,1); 
					echo '</br>'.number_format($tAgno,1); 
				?>
			</td>
		</tr>
<!--  Nuevo IO -->





		<tr style="background-color:#fff;">
			<td style="padding-left:10px;">
				Saldo Sin Iva
			<td>
			<?php
				$vcIva  = array(0,0,0,0,0,0,0,0,0,0,0,0);
				$tIva	= array(0,0,0,0,0,0,0,0,0,0,0,0);
				
				$link=Conectarse();
				
				$bd  = $link->query("SELECT * FROM SolFactura WHERE Estado = 'I' and year(fechaSolicitud) = $pAgno and Eliminado != 'on'");
				if($row=mysqli_fetch_array($bd)){
					do{
						$bdPer=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
						if($rowP=mysqli_fetch_array($bdPer)){
							if($rowP['cFree'] != 'on'){
								$fd = explode('-',$row['fechaSolicitud']);
								$i = $fd[1] - 1;
								$vcIva[$i] += $row['Neto'];
							}
						}
					}while ($row=mysqli_fetch_array($bd));
				}
				
				$tGastosMes  = array(0,0,0,0,0,0,0,0,0,0,0,0);
				
				
				$SQLgto = "SELECT * FROM MovGastos WHERE Modulo = 'G' and year(FechaGasto) = $pAgno ";
				$bd  = $link->query($SQLgto);
				if($row=mysqli_fetch_array($bd)){
					do{
						$fdGto = explode('-',$row['FechaGasto']);
						$i = $fdGto[1] - 1;
						$tGastosMes[$i] += $row['Bruto'];
						$tIva[$i]  += $row['Iva'];
					}while ($row=mysqli_fetch_array($bd));
				}

				$tSueldosMes  = array(0,0,0,0,0,0,0,0,0,0,0,0);
				
				
				$SQLgto = "SELECT * FROM Sueldos WHERE PeriodoPago Like '%".$pAgno."%'";
				$bd  = $link->query($SQLgto);
				if($row=mysqli_fetch_array($bd)){
					do{
						$fdSdo = explode('-',$row['PeriodoPago']);
						$i = $fdSdo[0] - 1;
						$tSueldosMes[$i] += $row['Liquido'];
					}while ($row=mysqli_fetch_array($bd));
				}

				$tHonorariosMes  = array(0,0,0,0,0,0,0,0,0,0,0,0);
				
				$SQLgto = "SELECT * FROM Honorarios WHERE PeriodoPago Like '%".$pAgno."%'";
				$bd  = $link->query($SQLgto);
				if($row=mysqli_fetch_array($bd)){
					do{
						//if($row['Cancelado'] == 'on'){
							$fdSdo = explode('-',$row['PeriodoPago']);
							$i = $fdSdo[0] - 1;
							$tHonorariosMes[$i] += $row['Total'];
						//}
					}while ($row=mysqli_fetch_array($bd));
				}

				$tFacturasSueldosMes  = array(0,0,0,0,0,0,0,0,0,0,0,0);
				
				$SQLgto = "SELECT * FROM Facturas WHERE PeriodoPago Like '%".$pAgno."%'";
				$bd  = $link->query($SQLgto);
				if($row=mysqli_fetch_array($bd)){
					do{
						if($row['Estado'] == 'P'){
							$fdSdo = explode('-',$row['PeriodoPago']);
							$i = $fdSdo[0] - 1;
							$tFacturasSueldosMes[$i] += $row['Bruto'];
						}
					}while ($row=mysqli_fetch_array($bd));
				}
				
				$link->close();
				$tAgnoGral = 0;
				$tAgnoGralCon = 0;
				$uAgnoGralSin = 0;
				$totSaldoMesCon = array(0,0,0,0,0,0,0,0,0,0,0,0);
				$SaldoMeses 	= array(0,0,0,0,0,0,0,0,0,0,0,0);
				$SaldoMesesCon 	= array(0,0,0,0,0,0,0,0,0,0,0,0);
				for($i=0; $i<=11; $i++){
					?>
					<td align="center">
						<?php
							if($tGastosMes[$i] 			> 0) { $tGastosMes[$i] 			= $tGastosMes[$i] 			/ 1000000; }
							if($tSueldosMes[$i] 		> 0) { $tSueldosMes[$i] 		= $tSueldosMes[$i] 			/ 1000000; }
							if($tHonorariosMes[$i] 		> 0) { $tHonorariosMes[$i] 		= $tHonorariosMes[$i] 		/ 1000000; }
							if($tFacturasSueldosMes[$i] > 0) { $tFacturasSueldosMes[$i] = $tFacturasSueldosMes[$i] 	/ 1000000; }
							$valConIva = (($vcIva[$i]/1000000)*0.775);
							$totSaldoMes = $valConIva - ($tGastosMes[$i] + $tSueldosMes[$i] + $tHonorariosMes[$i] + $tFacturasSueldosMes[$i]);
							$totSaldoMesCon[$i] = $totSaldoMes + ($tIva[$i] / 1000000);
							$tAgnoGralCon += $totSaldoMesCon[$i];
							//$totSaldoMes = $valConIva - ($tSueldosMes[$i] + $tHonorariosMes[$i] + $tFacturasSueldosMes[$i]);
							//$totSaldoMes = $valConIva - ($tGastosMes[$i] + $tSueldosMes[$i] + $tHonorariosMes[$i]);
							$tAgnoGral += $totSaldoMes;
							$SaldoMeses[$i] = $totSaldoMes;
							if($i <= $fdMes[1]-1){
								//echo number_format($valConIva,2).'<br>';
								//echo number_format($tSueldosMes[$i],2).'<br>';
								//echo number_format($tHonorariosMes[$i],2).'<br>';
								//echo number_format($tFacturasSueldosMes[$i],2).'<br>';
								//echo number_format($tGastosMes[$i],2).'<br>';
								echo number_format($totSaldoMes,2).'<br>';
								if($i == 0){
									echo number_format($totSaldoMes,2);
								}else{
									//echo number_format($SaldoMeses[$i-1],2).'<br>';
									//echo number_format($SaldoMeses[$i],2).'<br>';
									echo number_format($SaldoMeses[$i-1] + $SaldoMeses[$i],2);
									$uAgnoGralSin = $SaldoMeses[$i-1] + $SaldoMeses[$i];
									$SaldoMeses[$i] = $SaldoMeses[$i-1] + $SaldoMeses[$i];
								}
							}
						?>
					<td>
					<?php
				}
			?>
			<td align="center" style="padding-top:5px; padding-botton:5px;">
				<?php 
					echo number_format($tAgnoGral,2).'<br>';
					echo number_format($uAgnoGralSin,2);
				?>
			</td>
		</tr>
		<tr style="background-color:#fff;">
			<td style="padding-left:10px;">
				Saldo Con Iva
			<td>
			<?php
				$tAgnoGralCon = 0;
				$uAgnoGralCon = 0;
				for($i=0; $i<=11; $i++){
					?>
					<td align="center">
						<?php 
							if($i <= $fdMes[1]-1){
								//echo number_format($valIva,2).'<br>';
								echo number_format($totSaldoMesCon[$i],2).'<br>';
								$tAgnoGralCon += $totSaldoMesCon[$i];
								if($i == 0){
									echo number_format($totSaldoMesCon[$i],2);
								}else{
									echo number_format($totSaldoMesCon[$i-1] + $totSaldoMesCon[$i],2);
									$uAgnoGralCon = $totSaldoMesCon[$i-1] + $totSaldoMesCon[$i];
									$totSaldoMesCon[$i] = $totSaldoMesCon[$i-1] + $totSaldoMesCon[$i];
								}
							}
						?>
					<td>
					<?php
				}
			?>
			<td align="center" style="padding-top:5px; padding-botton:5px;">
				<?php 
					echo number_format($tAgnoGralCon,2).'<br>';
					echo number_format($uAgnoGralCon,2);
				?>
			</td>
		</tr>
		
		</tbody>
</table>
