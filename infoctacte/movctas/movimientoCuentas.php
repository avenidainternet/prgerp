	<div>
		<div style="font-family:Arial; font-size:30px; color:#000; padding:15px; align:center;"> Cartola Cuenta Corriente 
		<?php
			$nombreTitular 		= '';
			$idRecurso			= 0;
			$Descripcion		= '';
			$Monto				= '';
			$fechaTransaccion 	= date('Y-m-d');
			//$nTransaccion 		= '';
			$SQL = 'NADA';
			if($nCuenta){
				$link=Conectarse();
				$bdPer=$link->query("SELECT * FROM ctasctescargo Where nCuenta = '".$fCta[0]."'");
				if ($rowP=mysqli_fetch_array($bdPer)){
					$nombreTitular = $rowP['nombreTitular'];
					echo $rowP['nCuenta'].' '.$rowP['Banco'].' Titular: '.$rowP['nombreTitular'];
					$idRecurso = $rowP['aliasRecurso'];
					if($accion != "Agregar"){
						$bdMov=$link->query("SELECT * FROM ctasctesmovi Where nCuenta = '".$fCta[0]."' and nTransaccion = $nTransaccion");
						if($rowMov=mysqli_fetch_array($bdMov)){
							$fechaTransaccion 	= $rowMov['fechaTransaccion'];
							$tpTransaccion 		= $rowMov['tpTransaccion'];
							$Descripcion 		= $rowMov['Descripcion'];
							$Monto 				= $rowMov['Monto'];
						}
					}else{
						$SQL = "SELECT * FROM ctasctesmovi Where nCuenta = '".$fCta[0]."' Order By nTransaccion Desc";
						$bdMov=$link->query($SQL);
						if($rowMov=mysqli_fetch_array($bdMov)){
							$nTransaccion = $rowMov['nTransaccion'] + 1;
						}
					}
					
				}
				$link->close();
			}
		?>
		</div>
		<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
			<tr>
				<td colspan=2 width="100%" style="font-family:Arial; font-size=14px;padding:15px;">Formulario de Movimientos a la Cuenta Corriente</td>
			</tr>
		</table>
		<table cellspacing="0" cellpadding="0" id="CajaListado" style="border: 1px solid #ccc;">
			<tr style="font-family:Arial; font-size=12px;">
				<td width="20%" style="padding:10px;border: 1px solid #ccc;">Fecha Transacción: </td>
				<td width="30%" style="padding:10px;border: 1px solid #ccc;"><input name="fechaTransaccion" type="date" value="<?php echo $fechaTransaccion; ?>"></td>
				<td width="20%" style="padding:10px;border: 1px solid #ccc;">Tipo de Movimiento: </td>
				<td width="30%" style="padding:10px;border: 1px solid #ccc;">
					<select name="tpTransaccion">
						<option value="DBC">GR Cajero		</option>
						<option value="DB">DB Debito		</option>
						<option value="TR">TR Transferencia</option>
						<option value="CH">CH Cheque		</option>
					</select>
				</td>
			</tr>
			<tr style="font-family:Arial; font-size=12px;">
				<td width="20%" style="padding:10px;border: 1px solid #ccc;">Descripción: </td>
				<td colspan=3 width="80%" style="padding:10px;border: 1px solid #ccc;">
					<textarea name="Descripcion" rows="5" cols="100" required ><?php echo $Descripcion; ?></textarea>
				</td>
			</tr>
			<tr style="font-family:Arial; font-size=12px;">
				<td width="20%" style="padding:10px;border: 1px solid #ccc;">N° Transacción: </td>
				<td colspan=3 width="80%" style="padding:10px;border: 1px solid #ccc;">
					<input name="nTransaccion" type="hidden" value="<?php echo $nTransaccion;?>" readonly />
					<?php echo $nTransaccion; ?>
				</td>
			</tr>
			<tr style="font-family:Arial; font-size=12px;">
				<td width="20%" style="padding:10px;border: 1px solid #ccc;">Monto Transacción: </td>
				<td colspan=3 width="80%" style="padding:10px;border: 1px solid #ccc;">
					<input name="Monto" type="text" value="<?php echo $Monto; ?>" required />
				</td>
			</tr>
		</table>
	</div>
