<?php 	
	header('Content-Type: text/html; charset=utf-8');
	include_once("../conexionli.php"); 
	$nModulo 	= $_GET['nModulo'];
	$accion 	= $_GET['accion'];
	$iconoMod	= '';
	$Modulo		= '';
	$dirProg	= '';
	$nMenu		= '';
	$encNew 	= 'Si';
	if($_GET['nModulo'] == '' or $_GET['nModulo'] == 0){
		$link=Conectarse();
		$sql = "SELECT * FROM Modulos";  // sentencia sql
		$result = $link->query($sql);
		$nModulo = $result->num_rows + 1; // obtenemos el n�mero de filas
		$link->close();
		$accion 	= 'Guardar';
	}else{
		$link=Conectarse();
		$bdEnc=$link->query("SELECT * FROM Modulos Where nModulo = $nModulo");
		if($rowEnc=mysqli_fetch_array($bdEnc)){
			$Modulo 	= $rowEnc['Modulo'];
			$nMenu 		= $rowEnc['nMenu'];
			$dirProg 	= $rowEnc['dirProg'];
			$iconoMod 	= $rowEnc['iconoMod'];
		}
		$link->close();
		$encNew = 'No';
	}
?>

<div id="bloqueoTrasperente">
	<div id="cajaRegistraPruebas"> 
		<center>
		<form name="form" action="Modulos.php" method="post" enctype="multipart/form-data">
		<table width="95%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
			<tr>
				<td colspan="2" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
					<span style="color:#FFFFFF; font-size:18px; font-weight:700;">
						Registro de Aplicaciones (Módulos)
						<div id="botonImagen">
							<a href="Modulos.php" style="float:right;"><img src="../imagenes/no_32.png"></a>
						</div>
					</span>
				</td>
			</tr>
			<tr>
				<td width="20%">nModulo :</td>
				<td width="80%">
					<span style="font-size:24px; font-weight:700;">
						<input name="nModulo" id="nModulo" size="10" maxlength="10" type="text" value="<?php echo $nModulo; ?>" readonly>
					</span>
					<input name="accion" 	id="accion" type="hidden" value="<?php echo $accion; ?>">
					<input name="iconoMod" 	id="iconoMod" type="hidden" value="<?php echo $iconoMod; ?>">
				</td>
			</tr>
			<tr>
				<td width="20%">Grupo Menú :</td>
				<td width="80%">
					<span style="font-size:24px; font-weight:700;">
						<select name="nMenu">
							<option></option>
							<?php
							$link=Conectarse();
							$bdMg=$link->query("SELECT * FROM menugrupos Order By nMenu");
							if ($rowMg=mysqli_fetch_array($bdMg)){
								do{
									if($nMenu == $rowMg['nMenu']){ ?>
										<option selected value="<?php echo $rowMg['nMenu']; ?>"><?php echo $rowMg['nomMenu']; ?></option>
									<?php }else{ ?>
										<option value="<?php echo $rowMg['nMenu']; ?>"><?php echo $rowMg['nomMenu']; ?></option>
										<?php
									}
								}while ($rowMg=mysqli_fetch_array($bdMg));
							}
							$link->close();
							?>
						</select>
					</span>
					<input name="accion" 	id="accion" type="hidden" value="<?php echo $accion; ?>">
				</td>
			</tr>
			<tr>
				<td>Nombre Aplicación :</td>
				<td><input name="Modulo" id="Modulo" type="text" size="50" maxlength="50" value="<?php echo $Modulo; ?>"></td>
			</tr>
			<tr>
				<td>Links :</td>
				<td><input name="dirProg" id="dirProg" type="text" size="100" maxlength="100" value="<?php echo $dirProg; ?>"></td>
			</tr>
			<tr>
				<td>Icono :
					<?php
					if($iconoMod){
						$mIcono = 'iconos/'.$iconoMod;
						?>
						<img style="padding-left:5px;" src="<?php echo $mIcono; ?>" width="32">
						<?php
					}
					?>
				</td>
				<td>
					<input type="hidden" name="MAX_FILE_SIZE" value="20480000"> 
					<input name="icono" type="file" id="icono">
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