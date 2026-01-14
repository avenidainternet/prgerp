<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<?php 	
	include_once("conexion.php"); 
	$nEnc 		= 0;
	$nomEnc 	= '';
	$infoEnc	= '';
	$Estado		= '';
	
	if(isset($_GET['nEnc'])) 	{ $nEnc 	= $_GET['nEnc']; }
	if(isset($_GET['accion'])) 	{ $accion = $_GET['accion']; }
	
	$encNew = 'Si';
	if($nEnc == 0){
		$link=Conectarse();
		$sql = "SELECT * FROM Encuestas";  // sentencia sql
		$result = mysql_query($sql);
		$nEnc = mysql_num_rows($result) +1; // obtenemos el número de filas
		mysql_close($link);
		$accion = 'Guardar';
	}else{
		$link=Conectarse();
		$bdEnc=mysql_query("SELECT * FROM Encuestas Where nEnc = '".$nEnc."'");
		if($rowEnc=mysql_fetch_array($bdEnc)){
			$nomEnc 	= $rowEnc['nomEnc'];
			$infoEnc 	= $rowEnc['infoEnc'];
			$Estado 	= $rowEnc['Estado'];
		}
		mysql_close($link);
		$encNew = 'No';
	}
?>

<div id="bloqueoTrasperente">
	<div id="cajaRegistraPruebas">
		<center>
		<form name="form" action="plataformaEncuesta.php" method="post">
		<table width="95%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
			<tr>
				<td colspan="2" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
					<span style="color:#FFFFFF; font-size:18px; font-weight:700;">
						Registro de Encuesta
						<div id="botonImagen">
							<a href="plataformaEncuesta.php" style="float:right;"><img src="../imagenes/no_32.png"></a>
						</div>
					</span>
				</td>
			</tr>
			<tr>
				<td width="20%">Encuesta N°:</td>
				<td width="80%">
					<span style="font-size:24px; font-weight:700;">
					<?php
				 		echo $nEnc; 
					?>
					</span>
					<input name="nEnc" 		id="nEnc" 	type="hidden" value="<?php echo $nEnc; ?>">
					<input name="accion" 	id="accion" type="hidden" value="<?php echo $accion; ?>">
				</td>
			</tr>
			<tr>
				<td>Nombre Encuesta :</td>
				<td><input name="nomEnc" id="nomEnc" type="text" size="70" maxlength="70" value="<?php echo $nomEnc; ?>"></td>
			</tr>
			<tr>
				<td>Información :</td>
				<td>
					<textarea name="infoEnc" id="infoEnc" cols="80" rows="5"><?php echo $infoEnc; ?></textarea>
				</td>
			</tr>
			<tr>
				<td>Estado :</td>
				<td>
					<select name="Estado" id="Estado">
						<?php 
						if($Estado == 'on'){?>
							<option 			value="">Inactivo</option>
							<option selected 	value="on">Activo</option>
						<?php }else{ ?>
							<option selected	value="">Inactivo</option>
							<option 			value="on">Activo</option>
						<?php
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px; ">
					<?php
						if($accion == 'Guardar' || $accion == 'Agrega' || $accion == 'Actualizar'){?>
							<div id="botonImagen">
								<button name="confirmarGuardar" style="float:right;">
									<img src="../gastos/imagenes/guardar.png" width="40" height="40">
								</button>
							</div>
							<?php
						}
						if($accion == 'Borrar'){?>
							<button name="confirmarBorrar" style="float:right;">
								<img src="../gastos/imagenes/inspektion.png" width="40" height="40">
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