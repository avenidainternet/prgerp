<?php
	session_start();
	$_SESSION['Grabado'] = "NO";
	$MsgUsr ="";	
	include("../conexionli.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		$link->close();
	}else{
		header("Location: ../index.php");
	}

	$nContacto 	= 0;
	$Contacto   = '';
	$Depto   	= '';
	$Email   	= '';
	$Telefono	= '';

	if(isset($_GET['Proceso'])) 	{ $Proceso  	= $_GET['Proceso']; 	}
	if(isset($_GET['accion']))  	{ $accion   	= $_GET['accion']; 		}
	if(isset($_GET['RutCli']))  	{ $RutCli   	= $_GET['RutCli']; 		}
	if(isset($_GET['nContacto']))  	{ $nContacto	= $_GET['nContacto']; 	}

	if(isset($_POST['nContacto'])) 	{ $nContacto   	= $_POST['nContacto']; 	}
	if(isset($_POST['RutCli']))  	{ $RutCli   	= $_POST['RutCli']; 	}
	if(isset($_POST['Contacto']))  	{ $Contacto   	= $_POST['Contacto']; 	}
	if(isset($_POST['Depto']))  	{ $Depto   		= $_POST['Depto']; 		}
	if(isset($_POST['Email']))  	{ $Email   		= $_POST['Email']; 		}
	if(isset($_POST['Telefono'])) 	{ $Telefono		= $_POST['Telefono']; 	}
	if(isset($_POST['accion']))  	{ $accion		= $_POST['accion']; 	}
	if(isset($_POST['Proceso']))  	{ $Proceso		= $_POST['Proceso']; 	}

	if(isset($_POST['confirmarGuardar'])){
		$accion = "Editar";
		$link=Conectarse();
		$bdCont=$link->query("SELECT * FROM contactosCli WHERE RutCli = '".$RutCli."' and nContacto = '".$nContacto."'");
		if($rowCont=mysqli_fetch_array($bdCont)){
			$actSQL="UPDATE contactosCli SET ";
			$actSQL.="Contacto	    ='".$Contacto.		"',";
			$actSQL.="Depto			='".$Depto.			"',";
			$actSQL.="Email			='".$Email.			"',";
			$actSQL.="Telefono		='".$Telefono.		"'";
			$actSQL.="WHERE RutCli	= '".$RutCli."' and nContacto = '".$nContacto."'";
			$bdCont=$link->query($actSQL);
		}else{
			$link->query("insert into contactosCli(		RutCli,
														nContacto,
														Contacto,
														Depto,
														Email,
														Telefono
														) 
											values 	(	'$RutCli',
														'$nContacto',
														'$Contacto',
														'$Depto',
														'$Email',
														'$Telefono'
			)");
		}
		$link->close();
	}
			
	if(isset($_POST['confirmarBorrar'])){
		$link=Conectarse();
		$bdProv=$link->query("DELETE FROM contactosCli WHERE RutCli = '".$RutCli."' and nContacto = '".$nContacto."'");
		$link->close();
		header("Location: mClientes.php?Proceso=2&RutCli=".$RutCli);
	}

	$link=Conectarse();

	$bdCli=$link->query("SELECT * FROM Clientes WHERE RutCli = '".$RutCli."'");
	if ($rowCli=mysqli_fetch_array($bdCli)){
		$Cliente = $rowCli['Cliente'];
	}
	
	if($accion == "Agregar"){
		$bdCon=$link->query("SELECT * FROM contactosCli Where RutCli = '".$RutCli."' Order By nContacto Desc");
		if ($row=mysqli_fetch_array($bdCon)){
			$nContacto = $row['nContacto'] + 1;
		}else{
			$nContacto = 1;
		}
	}

	$bdCon=$link->query("SELECT * FROM contactosCli Where RutCli = '".$RutCli."' and nContacto = '".$nContacto."'");
	if ($row=mysqli_fetch_array($bdCon)){
		$Contacto 		= $row['Contacto'];
		$Depto 			= $row['Depto'];
		$Telefono 		= $row['Telefono'];
		$Email 			= $row['Email'];
	}

	$link->close();

	
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Módulo de Clientes - Contactos</title>

<link href="styles.css" rel="stylesheet" type="text/css">
<link href="../css/tpv.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<script language="javascript" src="validaciones.js"></script> 
<script src="../jquery/jquery-1.6.4.js"></script>
</head>

<body>
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<form name="form" action="mContacto.php" method="post">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				Mantención Contactos Clientes <?php echo $Cliente; ?>
				<div id="ImagenBarra">
					<a href="cerrarsesion.php" title="Cerrar Sesión">
						<img src="../gastos/imagenes/preview_exit_32.png" width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="../plataformaErp.php" title="Menú Principal">
						<img src="../gastos/imagenes/Menu.png" width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a>
					<img src="../gastos/imagenes/r_x.png"  width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="mClientes.php?Proceso=2&RutCli=<?php echo $RutCli;?>" title="Volver">
						<img src="../gastos/imagenes/preview_back_32.png" width="28" height="28">
					</a>
				</div>
			</div>
			<!-- Fin Caja Cuerpo -->
			<div align="center">
				<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
					<tr>
						<td height="40"><span style="padding:5px;">Ficha Registro de Clientes</span>
							<div style="margin:5px; float:right; ">
								<?php 
									if($accion == 'Editar' or $accion == 'Agregar'){?>
										<button name="confirmarGuardar">
											<img src="../gastos/imagenes/guardar.png" width="50" height="50">
										</button>
									<?php }else{ ?>
										<button name="confirmarBorrar">
											<img src="../gastos/imagenes/inspektion.png" width="50" height="50">
										</button>
									<?php } ?>
							</div>
						</td>
					</tr>
				</table>
				<div id="RegistroFactura">
					<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaDocumentos">
						<tr>
							<td colspan="2">nContacto: </td>
						  	<td colspan="2">
								<input name="nContacto" type="text" 	size="10" maxlength="10" value="<?php echo $nContacto; ?>">
								<input name="Proceso"  	type="hidden" 	value="<?php echo $Proceso; ?>">
								<input name="RutCli" 	type="hidden" 	size="10" maxlength="10" value="<?php echo $RutCli; ?>">
								<input name="accion"  	type="hidden" 	value="<?php echo $accion; ?>">
							</td>
						    <td colspan="2" rowspan="4" align="center">
								
								<?php
									if($rowCli['Logo']){
										//$logoEmp = 'http://simet.cl/intranet/logos/'.$rowCli['Logo'];
										$logoEmp = '../imagenes/testnoimg.png';
										$size 		= GetImageSize("$logoEmp");
										$anchura	= $size[0]/2; 
										$altura		= $size[1]/2;
									}else{
										$logoEmp = '../imagenes/testnoimg.png';
										$size 		= GetImageSize("$logoEmp");
										$anchura	= $size[0]; 
										$altura		= $size[1];
									}
									echo '<img src="'.$logoEmp.'" class="imgCli" width="'.$anchura.'" height="'.$altura.'" title="">';
								?>
							</td>
					    </tr>
						<tr>
							<td colspan="2">Contacto: </td>
							<td colspan="2">
								<input name="Contacto" 	type="text" size="50" maxlength="50" value="<?php echo $Contacto; ?>">
							</td>
					    </tr>
						<tr>
						  <td height="20" colspan="2">Correo: </td>
						  <td colspan="4"><input name="Email" 	type="email" size="50" maxlength="50" value="<?php echo $Email; ?>"></td>
					   </tr>
						<tr>
						  <td height="20" colspan="2">Departamento: </td>
						  <td colspan="4"><input name="Depto" 	type="text" size="50" maxlength="50" value="<?php echo $Depto; ?>"></td>
					   </tr>
						<tr>
						  <td height="20" colspan="2">Teléfono: </td>
						  <td colspan="4"><input name="Telefono" 	type="text" size="50" maxlength="50" value="<?php echo $Telefono; ?>"></td>
					   </tr>
<!--					  
						<tr>
							<td height="25" colspan="2">Observaci&oacute;n:</td>
							<td colspan="4">
								<textarea name="Msg" cols="90" rows="10"><?php echo $Msg; ?></textarea>
							</td>
						</tr>
-->
					</table>
				</div>
			</div>
		</div>
		</form>
	</div>
	<div style="clear:both; "></div>
	<br>
</body>
</html>