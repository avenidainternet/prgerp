<?php 	
	header('Content-Type: text/html; charset=utf-8');
	include_once("../conexionli.php"); 
	$IdPerfil 	= $_GET[IdPerfil];
	$accion 	= $_GET[accion];
	$encNew 	= 'Si';
	if($_GET[IdPerfil] == '' or $_GET[IdPerfil] == 0){
		$link=Conectarse();
		$sql = "SELECT * FROM Perfiles";  // sentencia sql
		$result = $link->query($sql);
		$IdPerfil = $result->num_rows +1; // obtenemos el número de filas
		$link->close();
		$accion 	= 'Guardar';
	}else{
		$link=Conectarse();
		$bdEnc=$link->query("SELECT * FROM Perfiles Where IdPerfil = '".$IdPerfil."'");
		if($rowEnc=mysqli_fetch_array($bdEnc)){
			$IdPerfil 	= $rowEnc[IdPerfil];
			$Perfil 	= $rowEnc[Perfil];
		}
		$link->close();
		$encNew = 'No';
	}
?>

<div id="bloqueoTrasperente">
	<div id="cajaRegistraPruebas">
		<center>
		<form name="form" action="Perfiles.php" method="post">
		<table width="95%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
			<tr>
				<td colspan="2" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
					<span style="color:#FFFFFF; font-size:18px; font-weight:700;">
						Registro de Usuario
						<div id="botonImagen">
							<a href="Perfiles.php" style="float:right;"><img src="../imagenes/no_32.png"></a>
						</div>
					</span>
				</td>
			</tr>
			<tr>
				<td width="20%">Id.Perfil :</td>
				<td width="80%">
					<span style="font-size:24px; font-weight:700;">
						<input name="IdPerfil" id="IdPerfil" size="40" maxlength="40" type="text" value="<?php echo $IdPerfil; ?>">
					</span>
					<input name="accion" 	id="accion" type="hidden" value="<?php echo $accion; ?>">
				</td>
			</tr>
			<tr>
				<td>Nombre Perfil :</td>
				<td><input name="Perfil" id="Perfil" type="text" size="50" maxlength="50" value="<?php echo $Perfil; ?>"></td>
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