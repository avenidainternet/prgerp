<?php 	
	header('Content-Type: text/html; charset=utf-8');
	include_once("../conexionli.php"); 
	$nServicio 	= $_GET[nServicio];
	$accion 	= $_GET[accion];
	$tpServicio = '';
	$encNew = 'Si';
	$ValorUF = 0;
	$Servicio = '';
	if($nServicio == 0){
		$link=Conectarse();
		$bdSer=$link->query("Select * From Servicios Order By nServicio Desc");
		if($rowSer=mysqli_fetch_array($bdSer)){
			$nServicio 	= $rowSer[nServicio] + 1;
			$Estado 	= 'on';
		}
/*		
		$sql = "SELECT * FROM Servicios";  // sentencia sql
		$result = $link->query($sql);
		$nServicio = mysql_num_rows($result) +1; // obtenemos el número de filas
*/		
		
		$link->close();
		$accion = 'Guardar';
	}else{
		$link=Conectarse();
		$bdEnc=$link->query("SELECT * FROM Servicios Where nServicio = '".$nServicio."'");
		if($rowEnc=mysqli_fetch_array($bdEnc)){
			$Servicio 	= $rowEnc['Servicio'];
			$ValorUF 	= $rowEnc['ValorUF'];
			$ValorPesos	= $rowEnc['ValorPesos'];
			$tpServicio	= $rowEnc['tpServicio'];
			$Estado		= $rowEnc['Estado'];
		}
		$link->close();
		$encNew = 'No';
	}
?>

<div id="bloqueoTrasperente">
	<div id="cajaRegistraPruebas">
		<center>
		<form name="form" action="Servicios.php" method="post">
		<table width="95%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
			<tr>
				<td colspan="2" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
					<span style="color:#FFFFFF; font-size:20px; font-weight:700;">
						Registro de Servicios
						<div id="botonImagen">
							<a href="Servicios.php" style="float:right;"><img src="../imagenes/no_32.png"></a>
						</div>
					</span>
				</td>
			</tr>
			<tr>
				<td width="20%" style="font-size:20px;">N°:</td>
				<td width="80%">
					<span style="font-size:24px; font-weight:700;">
					<?php
				 		echo $nServicio; 
					?>
					</span>
					<input name="nServicio" id="nServicio" 	type="hidden" value="<?php echo $nServicio; ?>">
					<input name="accion" 	id="accion" type="hidden" value="<?php echo $accion; ?>">
				</td>
			</tr>
			<tr>
				<td style="font-size:20px;">Servicio :</td>
				<td>
					<textarea style="font-size:20px; font-weight:700;" name="Servicio" id="Servicio" cols="70" rows="5"><?php echo $Servicio; ?></textarea>
				</td>
			</tr>
			<tr>
				<td style="font-size:20px;">Valor UF :</td>
				<td>
					<input style="font-size:24px; font-weight:700;" name="ValorUF" id="ValorUF" type="text" size="10" maxlength="10" value="<?php echo $ValorUF; ?>">
				</td>
			</tr>
			<tr>
				<td style="font-size:20px;">Tipo Servicio :</td>
				<td>
					<select name="tpServicio" style="font-size:24px; font-weight:700;">
						<?php if($tpServicio=='O' or $tpServicio = ''){?>
							<option value="O" selected>Ordinario</option>
						<?php }else{?>
							<option value="O" 		  >Ordinario</option>
						<?php } ?>
						<?php if($tpServicio=='E'){?>
							<option value="E" selected>Especial</option>
						<?php }else{?>
							<option value="E" 		  >Especial</option>
						<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td style="font-size:20px;">Estado Servicio :</td>
				<td>
					<select name="Estado" style="font-size:24px; font-weight:700;">
						<?php if($Estado == 'on'){?>
							<option value="on" selected>Activo		</option>
							<option value="off" 		>Inactivo	</option>
						<?php } ?>
						<?php if($Estado == 'off'){?>
							<option value="off" selected>Inactivo</option>
							<option value="on" 		    >Activo	</option>
						<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px; ">
					<?php
						if($accion == 'Guardar' || $accion == 'Agrega' || $accion == 'Actualizar'){?>
							<div id="botonImagen">
								<button name="confirmarGuardar" style="float:right;">
									<img src="../gastos/imagenes/guardar.png" width="60" height="60">
								</button>
							</div>
							<?php
						}
						if($accion == 'Borrar'){?>
							<button name="confirmarBorrar" style="float:right;">
								<img src="../gastos/imagenes/inspektion.png" width="60" height="60">
							</button>
							<?php
						}
					?>
				</td>
			</tr>
		</table>
		</form>
		</center>
	</div>
</div>