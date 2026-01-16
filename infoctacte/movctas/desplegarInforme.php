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
				$link->close();
			}
		?>
		</div>
		<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
			<tr>
				<td  width="10%" align="center"><strong>Fecha<br>Cargo			</strong></td>
				<td  width="10%" align="center"><strong>Tipo<br>Movimiento		</strong></td>
				<td  width="45%" align="center"><strong>Descripción				</strong></td>
				<td  width="10%" align="center"><strong>Transacción				</strong></td>
				<td  width="15%" align="center"><strong>Cargo					</strong></td>
				<td  width="10%" align="center"><strong>Acción					</strong></td>
			</tr>
		</table>
		<table border="0" cellspacing="0" cellpadding="0" id="CajaListado">
			<?php
				$n 		= 0;
				$tBruto = 0;
				/* Inicio Filtros */
				$mMesFiltro = $MesFiltro;
				if($MesFiltro){
					//$mMesFiltro = $Mes[intval($MesFiltro)];
					$mMesFiltro = $MesNum[$MesFiltro];
				}
				$filtroSQL = "Where month(fechaTransaccion) = ".$MesNum[$MesFiltro]." and year(fechaTransaccion) = $Agno and nCuenta = '".$fCta[0]."'";
				if($_SESSION['usr'] == 'CMS'){
					$filtroSQL = "Where month(fechaTransaccion) = ".$MesNum[$MesFiltro]." and year(fechaTransaccion) = $Agno and nCuenta = '".$fCta[0]."' and usr = '".$_SESSION['usr']."'";
				}
				
				//echo $filtroSQL;
				$tDia = 0;
				$tMes = 0;
				$fTransaccion = '0000-00-00';
				$link=Conectarse();
				$SQL = "SELECT * FROM ctasctesmovi $filtroSQL Order By fechaTransaccion Desc";
				$bdHon=$link->query($SQL);
				if ($row=mysqli_fetch_array($bdHon)){
					do{
							$fd = explode('-', $row['fechaTransaccion']);
							$tr  	= 'barraVerde';
							echo '	<tr id="'.$tr.'">';
							echo '			<td width="10%">';
												//if($fTransaccion != $row['fechaTransaccion']){
													$fd = explode('-', $row['fechaTransaccion']);
													echo $fd[2].'-'.$fd[1].'-'.$fd[0];
												//}
							echo '			</td>';
							echo '			<td width="10%">';
												echo $row['tpTransaccion'];
							echo ' 			</td>';
							echo '			<td width="45%">';
												echo $row['Descripcion'];
							echo ' 			</td>';
							echo '			<td width="10%" align="center">';
												if($row['nTransaccion'] > 0){
													echo $row['nTransaccion'];
												}
							echo ' 			</td>';
							echo '			<td width="15%" align="right">';
												if($fTransaccion != $row['fechaTransaccion']){
													$tDia = 0;
													$fTransaccion = $row['fechaTransaccion'];
												}
												echo number_format($row['Monto'], 0, ',', '.');
												$tMes +=  $row['Monto'];
												$tDia +=  $row['Monto'];
							echo ' 			</td>';
							echo '			<td width="10%">';?>
												<a href="index.php?nCuenta=<?php echo $nCuenta; ?>&MesFiltro=<?php echo $MesNum[$MesFiltro]; ?>&Agno=<?php echo $Agno; ?>&nTransaccion=<?php echo $row['nTransaccion']; ?>&accion=Actualizar" title="Actualizar Cargo"><img src="../../imagenes/corel_draw_128.png" 	width="40" title="Editar"></a>
												<a href="index.php?nCuenta=<?php echo $nCuenta; ?>&MesFiltro=<?php echo $MesNum[$MesFiltro]; ?>&Agno=<?php echo $Agno; ?>&nTransaccion=<?php echo $row['nTransaccion']; ?>&accion=Borrar" 	 title="Borrar Cargo"	 ><img src="../../imagenes/inspektion.png" 			width="40" title="Borrar"></a>
							<?php
							echo '			</td>';
							echo '		</tr>';
					}while ($row=mysqli_fetch_array($bdHon));
						$tr = 'barraAzul';
						echo '<tr id="'.$tr.'">';
							echo '<td colspan=4 align="right">';
								echo 'Total Mes';
							echo '</td>';
							echo '<td align="center">';
									echo number_format($tMes, 0, ',', '.');
							echo '</td>';
							echo '<td align="center">';
									echo ' ';
							echo '</td>';
						echo '</tr>';
				}
				$link->close();
			?>
		</table>
	</div>
