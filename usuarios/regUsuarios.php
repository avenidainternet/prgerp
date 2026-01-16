<?php 	
	header('Content-Type: text/html; charset=utf-8');
	include_once("../conexionli.php"); 
	$Login 	= $_GET['Login'];
	$accion = $_GET['accion'];
	$encNew = 'Si';
	$msgUsr	= '';
	if($Login){
		$link=Conectarse();
		$bdEnc=$link->query("SELECT * FROM Usuarios Where usr = '".$Login."'");
		if($rowEnc=mysqli_fetch_array($bdEnc)){
			$pwd 		= $rowEnc['pwd'];
			$usuario 	= $rowEnc['usuario'];
			$nPerfil 	= $rowEnc['nPerfil'];
			$email 		= $rowEnc['email'];
		}
		$link->close();
		$encNew = 'No';
	}else{
		$Login 	= '';
		$accion = 'Guardar';
		$msgUsr	= 'Nuevo';
	}
?>

<div id="bloqueoTrasperente">
	<div id="cajaRegistraPruebas">
		<center>
		<form name="form" action="plataformaUsuarios.php" method="post">
		<table width="95%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
			<tr>
				<td colspan="2" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
					<span style="color:#FFFFFF; font-size:18px; font-weight:700;">
						Registro de Usuario <?php echo $msgUsr; ?>
						<div id="botonImagen">
							<a href="plataformaUsuarios.php" style="float:right;"><img src="../imagenes/no_32.png"></a>
						</div>
					</span>
				</td>
			</tr>
			<tr>
				<td width="20%">Login :</td>
				<td width="80%">
					<span style="font-size:24px; font-weight:700;">
						<input name="Login" id="Login" size="40" maxlength="40" type="text" value="<?php echo $Login; ?>">
					</span>
					<input name="accion" 	id="accion" type="hidden" value="<?php echo $accion; ?>">
				</td>
			</tr>
			<tr>
				<td>Contraseña :</td>
				<td><input name="pwd" id="pwd" type="password" size="20" maxlength="20" value="<?php echo $pwd; ?>"></td>
			</tr>
			<tr>
				<td>Nombre Usuario :</td>
				<td><input name="usuario" id="usuario" type="text" size="50" maxlength="50" value="<?php echo $usuario; ?>"></td>
			</tr>
				<td>Correo :</td>
				<td><input name="email" id="email" type="email" size="50" maxlength="50" value="<?php echo $email; ?>"></td>
			</tr>
			<tr>
				<td>Perfil :</td>
				<td>
					<select name="nPerfil" id="nPerfil">
						<?php
						$link=Conectarse();
						$bdEnc=$link->query("SELECT * FROM Perfiles Order By IdPerfil");
						if($row=mysqli_fetch_array($bdEnc)){
							do{
								if($row['IdPerfil'] == $nPerfil){
									echo '<option value="'.$row['IdPerfil'].'" selected>'.$row['Perfil'].'</option>';
								}else{
									echo '<option value="'.$row['IdPerfil'].'" 		 >'.$row['Perfil'].'</option>';
								}
							}while ($row=mysqli_fetch_array($bdEnc));
						}
						$link->close();
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