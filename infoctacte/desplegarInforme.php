	<div>
		<div style="font-family:Arial; font-size:30px; color:#000; padding:15px; align:center;"> Cartola Cuenta Corriente 
		<?php
			$nombreTitular 	= '';
			$idRecurso		= 0;
			if($nCuenta){
				$link=Conectarse();
				$bdPer=$link->query("SELECT * FROM ctasctescargo Where nCuenta = '".$fCta[0]."'");
				if ($rowP=mysqli_fetch_array($bdPer)){
					$nombreTitular = $rowP['nombreTitular'];
					echo $rowP['nCuenta'].' '.$rowP['Banco'].' Titular: '.$rowP['nombreTitular'];
					$idRecurso = $rowP['aliasRecurso'];
				}
				$bd=$link->query("DELETE FROM librobanco");
				
				$filtroSQL = "Where Reembolso = 'on' and year(fechaReembolso) = $Agno and month(fechaReembolso) = $MesFiltro";
				$SQL = "SELECT * FROM formularios $filtroSQL Order By fechaReembolso Desc";
				$bdRe=$link->query($SQL);
				if($rowRe=mysqli_fetch_array($bdRe)){
					do{
						$SQLm = "SELECT * FROM movgastos Where nInforme = '".$rowRe['nInforme']."' and idRecurso = '".$idRecurso."'";
						$bdMov=$link->query($SQLm);
						if($rowMov=mysqli_fetch_array($bdMov)){
							$Abono = 0;
							if($rowRe['Iva'] > 0){
								$Abono = $rowRe['Bruto'];
							}else{
								$Abono = $rowRe['Bruto'];
							}
							$nInforme 			= $rowRe['nInforme'];
							$fechaTransaccion 	= $rowRe['fechaReembolso'];
							$Descripcion 		= $rowRe['Concepto'];
							$SQLLB = "SELECT * FROM librobanco Where nCuenta = '".$fCta[0]."' and nInforme = '".$rowRe['nInforme']."'";
							$bdLB=$link->query($SQLLB);
							if($rowLB=mysqli_fetch_array($bdLB)){
								$actSQL="UPDATE librobanco SET ";
								$actSQL.="fechaTransaccion		='".$fechaTransaccion.	"',";
								$actSQL.="Descripcion			='".$Descripcion.		"',";
								$actSQL.="Abono					='".$Abono.				"'";
								$actSQL.="WHERE nCuenta	= '".$fCta[0]."' and nInforme = $nInforme";
								$bdCot=$link->query($actSQL);
							}else{
								$nCuentaG = $fCta[0];
								$link->query("insert into librobanco(	
																		nCuenta,
																		fechaTransaccion,
																		nInforme,
																		Descripcion,
																		Abonos
																	) 
															values 	(	
																		'$nCuentaG',
																		'$fechaTransaccion',
																		'$nInforme',
																		'$Descripcion',
																		'$Abono'
									)");
							}
						}
					}while ($rowRe=mysqli_fetch_array($bdRe));
				}
				
				
				$filtroSQL = "Where nCuenta = '".$fCta[0]."' and year(fechaTransaccion) = $Agno and month(fechaTransaccion) = $MesFiltro";
				$SQL = "SELECT * FROM ctasctesmovi $filtroSQL Order By fechaTransaccion Desc";
				$bdCm=$link->query($SQL);
				if($rowCm=mysqli_fetch_array($bdCm)){
					do{
						$nTransaccion 		= $rowCm['nTransaccion'];
						$fechaTransaccion 	= $rowCm['fechaTransaccion'];
						$Descripcion 		= $rowCm['Descripcion'];
						$Cargos 			= $rowCm['Monto'];
						$SQLLB = "SELECT * FROM librobanco Where nCuenta = '".$fCta[0]."' and nTransaccion = '".$rowCm['nTransaccion']."'";
						$bdLB=$link->query($SQLLB);
						if($rowLB=mysqli_fetch_array($bdLB)){
							$actSQL="UPDATE librobanco SET ";
							$actSQL.="fechaTransaccion		='".$fechaTransaccion.	"',";
							$actSQL.="Descripcion			='".$Descripcion.		"',";
							$actSQL.="Cargos				='".$Cargos.			"'";
							$actSQL.="WHERE nCuenta	= '".$fCta[0]."' and nTransaccion = $nTransaccion";
							$bdCot=$link->query($actSQL);
						}else{
							$nCuentaG = $fCta[0];
							$link->query("insert into librobanco(	
																		nCuenta,
																		fechaTransaccion,
																		nTransaccion,
																		Descripcion,
																		Cargos
																	) 
															values 	(	
																		'$nCuentaG',
																		'$fechaTransaccion',
																		'$nTransaccion',
																		'$Descripcion',
																		'$Cargos'
							)");
						}
					}while ($rowCm=mysqli_fetch_array($bdCm));
				}
				$link->close();
			}
		?>
		</div>
		<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
			<tr>
				<td  width="10%" align="center"><strong>Fecha<br>Transacción</strong></td>
				<td  width="10%" align="center"><strong>N°<br>Transacción	</strong></td>
				<td  width="10%" align="center"><strong>N°<br>Informe		</strong></td>
				<td  width="40%" align="center"><strong>Descripción			</strong></td>
				<td  width="15%" align="center"><strong>Abonos				</strong></td>
				<td  width="15%" align="center"><strong>Cargos				</strong></td>
			</tr>
		</table>
		<table border="0" cellspacing="0" cellpadding="0" id="CajaListado">
			<?php
				$n 		= 0;
				$tBruto = 0;
				/* Inicio Filtros */

				$filtroSQL = "Where nCuenta = '".$fCta[0]."' and year(fechaTransaccion) = $Agno and month(fechaTransaccion) = $MesFiltro";

				$tMesAbonos = 0;
				$tMesCargos = 0;
				$link=Conectarse();
				$SQL = "SELECT * FROM librobanco $filtroSQL Order By fechaTransaccion Desc";
				$bdHon=$link->query($SQL);
				if($row=mysqli_fetch_array($bdHon)){
					do{
						$fd = explode('-', $row['fechaTransaccion']);
						$tr  	= 'barraVerde';?>
						<tr id="<?php echo $tr; ?>">
							<td width="10%">
								<?php
									$fd = explode('-', $row['fechaTransaccion']);
									echo $fd[2].'-'.$fd[1].'-'.$fd[0];
								?>
							</td>
							<td width="10%">
								<?php echo $row['nTransaccion']; ?>
							</td>
							<td width="10%" align="center">
								<?php
									if($row['nInforme'] > 0){
										echo $row['nInforme'];
									}
								?>
							</td>
							<td width="40%">
								<?php echo $row['Descripcion']; ?>
							</td>
							<td width="15%" align="center">
								<?php
									if($row['Abonos'] > 0){
										echo number_format($row['Abonos'], 0, ',', '.');
										$tMesAbonos +=  $row['Abonos'];
									}
								?>
								</td>
								<td width="15%" align="center">
									<?php
										if($row['Cargos'] > 0){
											echo number_format($row['Cargos'], 0, ',', '.');
											$tMesCargos +=  $row['Cargos'];
										}
									?>
								</td>
							</tr>
						<?php
					}while ($row=mysqli_fetch_array($bdHon));
				}
				$link->close();
				$tr = 'barraAzul';
				echo '<tr id="'.$tr.'">';
					echo '<td colspan=4 align="right">';
						echo 'Total Mes';
					echo '</td>';
					echo '<td align="center">';
							echo number_format($tMesAbonos, 0, ',', '.');
					echo '</td>';
					echo '<td align="center">';
							echo number_format($tMesCargos, 0, ',', '.');
					echo '</td>';
				echo '</tr>';
			?>
		</table>
	</div>
