<?php
	session_start();
	$_SESSION['Grabado'] = "NO";
	$MsgUsr ="";	
	include_once("conexionli.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		$link->close();
	}else{
		header("Location: index.php");
	}

		
	$RutCli 		= "";
	$Cliente 		= "";
	$Giro 			= "";
	$Direccion		= "";
	$Telefono		= "";
	$Celular		= "";
	$Email			= "";
	$Sitio			= "";
	$Publicar		= "";
	$Contacto		= "";
	$FonoContacto	= "";
	$EmailContacto	= "";
	$DeptoContacto	= "";
	$Contacto2		= "";
	$FonoContacto2	= "";
	$EmailContacto2	= "";
	$DeptoContacto2	= "";
	$Contacto3		= "";
	$FonoContacto3	= "";
	$EmailContacto3	= "";
	$DeptoContacto3	= "";
	$Contacto4		= "";
	$FonoContacto4	= "";
	$EmailContacto4	= "";
	$DeptoContacto4	= "";

	$Proceso = 1;
	
	if($_GET['Proceso']) { $Proceso  = $_GET['Proceso']; }
	if($_GET['RutCli'])  { $RutCli   = $_GET['RutCli']; }

	if(isset($_POST['consultaCliente'])){
		if($_POST['RutCli'])  { $RutCli   = $_POST['RutCli']; }
		$link=Conectarse();
		$bdProv=$link->query("SELECT * FROM Clientes WHERE RutCli = '".$RutCli."'");
		if ($row=mysqli_fetch_array($bdProv)){
			$Proceso = 2;
		}
		$link->close();
	}else{
		$sw = false;
		if(isset($_POST['Proceso'])){ 
			$Proceso 	= $_POST['Proceso'];
			if(isset($_POST['Cliente'])){
				$Cliente 	= $_POST['Cliente'];
				if(isset($_POST['RutCli'])){
					$RutCli 	= $_POST['RutCli'];
					if(isset($_POST['Giro']))			{ $Giro 			= $_POST['Giro']; }
					if(isset($_POST['Direccion']))		{ $Direccion 		= $_POST['Direccion']; }
					if(isset($_POST['Telefono']))		{ $Telefono  		= $_POST['Telefono']; 	}
					if(isset($_POST['Email']))			{ $Email  			= $_POST['Email']; 		}
					if(isset($_POST['Sitio']))			{ $Sitio  			= $_POST['Sitio']; 		}
					if(isset($_POST['Publicar']))		{ $Publicar			= $_POST['Publicar']; 		}
					if(isset($_POST['Celular']))		{ $Celular  		= $_POST['Celular']; 	}
					if(isset($_POST['Contacto']))		{ $Contacto  		= $_POST['Contacto']; 	}
					if(isset($_POST['DeptoContacto']))	{ $DeptoContacto  	= $_POST['DeptoContacto']; 	}
					if(isset($_POST['FonoContacto']))	{ $FonoContacto  	= $_POST['FonoContacto']; 	}
					if(isset($_POST['EmailContacto']))	{ $EmailContacto  	= $_POST['EmailContacto']; 	}
					if(isset($_POST['Contacto2']))		{ $Contacto2  		= $_POST['Contacto2']; 	}
					if(isset($_POST['DeptoContacto2']))	{ $DeptoContacto2  	= $_POST['DeptoContacto2']; 	}
					if(isset($_POST['FonoContacto2']))	{ $FonoContacto2  	= $_POST['FonoContacto2']; 	}
					if(isset($_POST['EmailContacto2']))	{ $EmailContacto2  	= $_POST['EmailContacto2']; 	}
					if(isset($_POST['Contacto3']))		{ $Contacto3  		= $_POST['Contacto3']; 	}
					if(isset($_POST['DeptoContacto3']))	{ $DeptoContacto3  	= $_POST['DeptoContacto3']; 	}
					if(isset($_POST['FonoContacto3']))	{ $FonoContacto3  	= $_POST['FonoContacto3']; 	}
					if(isset($_POST['EmailContacto3']))	{ $EmailContacto3  	= $_POST['EmailContacto3']; 	}
					if(isset($_POST['Contacto4']))		{ $Contacto4  		= $_POST['Contacto4']; 	}
					if(isset($_POST['DeptoContacto4']))	{ $DeptoContacto4  	= $_POST['DeptoContacto4']; 	}
					if(isset($_POST['FonoContacto4']))	{ $FonoContacto4  	= $_POST['FonoContacto4']; 	}
					if(isset($_POST['EmailContacto4']))	{ $EmailContacto4  	= $_POST['EmailContacto4']; 	}
					$sw = true;
				}
			}
		}
	
		if($sw == true){
			$sw = false;
			
			if($Proceso == 1 || $Proceso == 2 || $Proceso == 3){ /* Agregar */
				$link=Conectarse();
				$bdProv=$link->query("SELECT * FROM Clientes WHERE RutCli = '".$RutCli."'");
				if ($row=mysqli_fetch_array($bdProv)){
					if($Proceso == 2){
						$MsgUsr = 'Registro Actualizado...';
						$bdProv=$link->query("SELECT * FROM Clientes WHERE RutCli = '".$RutCli."'");
						if ($row=mysqli_fetch_array($bdProv)){
							$actSQL="UPDATE Clientes SET ";
							$actSQL.="Cliente		='".$Cliente."',";
							$actSQL.="Giro			='".$Giro."',";
							$actSQL.="Direccion		='".$Direccion."',";
							$actSQL.="Telefono		='".$Telefono."',";
							$actSQL.="Celular		='".$Celular."',";
							$actSQL.="Sitio			='".$Sitio."',";
							$actSQL.="Publicar		='".$Publicar."',";
							$actSQL.="Email		    ='".$Email."',";
							$actSQL.="Contacto	    ='".$Contacto."',";
							$actSQL.="DeptoContacto	='".$DeptoContacto."',";
							$actSQL.="FonoContacto	='".$FonoContacto."',";
							$actSQL.="EmailContacto	='".$EmailContacto."',";
							$actSQL.="Contacto2	    ='".$Contacto2."',";
							$actSQL.="DeptoContacto2='".$DeptoContacto2."',";
							$actSQL.="FonoContacto2	='".$FonoContacto2."',";
							$actSQL.="EmailContacto2='".$EmailContacto2."',";
							$actSQL.="Contacto3	    ='".$Contacto3."',";
							$actSQL.="DeptoContacto3='".$DeptoContacto3."',";
							$actSQL.="FonoContacto3	='".$FonoContacto3."',";
							$actSQL.="EmailContacto3='".$EmailContacto3."',";
							$actSQL.="Contacto4	    ='".$Contacto4."',";
							$actSQL.="DeptoContacto4='".$DeptoContacto4."',";
							$actSQL.="FonoContacto4	='".$FonoContacto4."',";
							$actSQL.="EmailContacto4='".$EmailContacto4."'";
							$actSQL.="WHERE RutCli	= '".$RutCli."'";
							$bdProv=$link->query($actSQL);
						}
					}
					if($Proceso == 3){
						$bdProv=$link->query("DELETE FROM Clientes WHERE RutCli = '".$RutCli."'");
						$link->close();
						header("Location: clientes.php");
					}
				}else{
					$link->query("insert into Clientes(		RutCli,
															Cliente,
															Giro,
															Direccion,
															Telefono,
															Celular,
															Email,
															Sitio,
															Publicar,
															Contacto,
															DeptoContacto,
															FonoContacto,
															EmailContacto,
															Contacto2,
															DeptoContacto2,
															FonoContacto2,
															EmailContacto2,
															Contacto3,
															DeptoContacto3,
															FonoContacto3,
															EmailContacto3,
															Contacto4,
															DeptoContacto4,
															FonoContacto4,
															EmailContacto4
															) 
											values 		(	'$RutCli',
															'$Cliente',
															'$Giro',
															'$Direccion',
															'$Telefono',
															'$Celular',
															'$Email',
															'$Sitio',
															'$Publicar',
															'$Contacto',
															'$DeptoContacto',
															'$FonoContacto',
															'$EmailContacto',
															'$Contacto2',
															'$DeptoContacto2',
															'$FonoContacto2',
															'$EmailContacto2',
															'$Contacto3',
															'$DeptoContacto3',
															'$FonoContacto3',
															'$EmailContacto3',
															'$Contacto4',
															'$DeptoContacto4',
															'$FonoContacto4',
															'$EmailContacto4'
															)",$link);
				}
				$link->close();
			}
		}

	}	
		$link=Conectarse();
		$bdProv=$link->query("SELECT * FROM Clientes WHERE RutCli = '".$RutCli."'");
		if ($row=mysqli_fetch_array($bdProv)){
   			$Cliente 		= $row['Cliente'];
			$Giro			= $row['Giro'];
			$Direccion		= $row['Direccion'];
   			$Telefono  		= $row['Telefono'];
   			$Celular  		= $row['Celular'];
			$Email 			= $row['Email'];
			$Sitio 			= $row['Sitio'];
			$Publicar		= $row['Publicar'];
			$Contacto 		= $row['Contacto'];
			$DeptoContacto 	= $row['DeptoContacto'];
			$FonoContacto 	= $row['FonoContacto'];
			$EmailContacto 	= $row['EmailContacto'];
			$Contacto2 		= $row['Contacto2'];
			$DeptoContacto2	= $row['DeptoContacto2'];
			$FonoContacto2 	= $row['FonoContacto2'];
			$EmailContacto2	= $row['EmailContacto2'];
			$Contacto3 		= $row['Contacto3'];
			$DeptoContacto3	= $row['DeptoContacto3'];
			$FonoContacto3 	= $row['FonoContacto3'];
			$EmailContacto3	= $row['EmailContacto3'];
			$Contacto4 		= $row['Contacto4'];
			$DeptoContacto4	= $row['DeptoContacto4'];
			$FonoContacto4 	= $row['FonoContacto4'];
			$EmailContacto4	= $row['EmailContacto4'];
		}
		$link->close();

	
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Modulo de Sueldos</title>

<link href="facturacion/styles.css" rel="stylesheet" type="text/css">

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
<script language="javascript" src="facturacion/validaciones.js"></script> 
<script src="jquery/jquery-1.6.4.js"></script>
<script>
$(document).ready(function(){
   $("#dFactura").click(function(){
	    $("#RegistroFactura").css("display", "block");
	    $("#RegistroBoleta").css("display", "none");
   });
   $("#dBoleta").click(function(){
	    $("#RegistroFactura").css("display", "none");
	    $("#RegistroBoleta").css("display", "block");
   });
	
	$("#NetoF").bind('keypress', function(event)
	{
	// alert(event.keyCode);
	if (event.keyCode == '9')
		{
		neto  = document.form.NetoF.value;
		iva	  = neto * 0.19;
		bruto = neto * 1.19;
		document.form.IvaF.value 	= iva;
		document.form.BrutoF.value 	= bruto;
		// document.form.Iva.focus();
		return 0;
		}
	});
});
</script>
</head>

<body onLoad="document.form.RutCli.focus();">
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<form name="form" action="mClientes.php" method="post">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				Mantención Clientes <!-- <img src="imagenes/room_32.png" width="28" height="28"> -->
				<?php include('facturacion/barramenu.php'); ?>
				<div id="ImagenBarra">
					<a href="facturacion/cerrarsesion.php" title="Cerrar Sesión">
						<img src="gastos/imagenes/preview_exit_32.png" width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="plataformaErp.php" title="Menú Principal">
						<img src="gastos/imagenes/Menu.png" width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a>
					<img src="gastos/imagenes/r_x.png"  width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="facturacion/formSolicitaFactura.php?RutCli=<?php echo $RutCli; ?>" title="Solicitud de Factura">
						<img src="gastos/imagenes/crear_certificado.png" width="32" height="32">
					</a><br>
				</div>
				<div id="ImagenBarra">
					<a href="facturacion/clientes.php" title="Volver">
						<img src="gastos/imagenes/preview_back_32.png" width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a>
					<img src="gastos/imagenes/r_x.png"  width="28" height="28">
					</a>
				</div>
			</div>
			<!-- Fin Caja Cuerpo -->
			<div align="center">
				<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
					<tr>
						<td height="40"><span style="padding:5px;">Ficha Registro de Clientes</span>
							<div id="ImagenBarra" style="margin:5px; ">
								<?php 
									if($Proceso == 1 || $Proceso == 2){
            							echo '<input name="Grabar" type="image" id="Grabar" src="../gastos/imagenes/guardar.png" width="32" height="32" title="Guardar">';
									}else{
            							echo '<input name="Eliminar" type="image" id="Grabar" src="../gastos/imagenes/inspektion.png" width="32" height="32" title="Eliminar">';
									}
								?>
							</div>
						</td>
					</tr>
				</table>
				<div id="RegistroFactura">
					<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaDocumentos">
						<tr>
							<td colspan="2">Rut: </td>
						  	<td colspan="4">
								<input name="RutCli" 	type="text" size="10" maxlength="10" value="<?php echo $RutCli; ?>">
								<input name="Proceso"  	type="hidden" value="<?php echo $Proceso; ?>">
								<button name="consultaCliente">
                                	<img src="gastos/imagenes/buscar.png" width="50" height="50">
								</button>
							</td>
						</tr>
						<tr>
							<td colspan="2">Cliente: </td>
							<td colspan="4">
								<input name="Cliente" 	type="text" size="50" maxlength="50" value="<?php echo $Cliente; ?>">
							</td>
						</tr>
						<tr>
							<td colspan="2">Giro: </td>
							<td colspan="4">
								<input name="Giro" 	type="text" size="100" maxlength="100" value="<?php echo $Giro; ?>">
							</td>
						</tr>
						<tr>
							<td colspan="2">Dirección: </td>
							<td colspan="4">
								<input name="Direccion" 	type="text" size="50" maxlength="50" value="<?php echo $Direccion;?>">
							</td>
						</tr>
						<tr>
							<td colspan="2">Email: </td>
							<td colspan="4">
								<input name="Email" 	type="email" size="50" maxlength="50" value="<?php echo $Email; ?>">
							</td>
						</tr>
						<tr>
							<td colspan="2">Teléfono: </td>
							<td colspan="4">
								<input name="Telefono" 	type="text" size="30" maxlength="30" value="<?php echo $Telefono;?>">
							</td>
						</tr>
						<tr>
						  <td height="20" colspan="2">Celular: </td>
						  <td colspan="4"><input name="Celular" 	type="text" size="13" maxlength="13" value="<?php echo $Celular; ?>"></td>
					  </tr>
						<tr>
						  <td height="25" colspan="2">Sitio:</td>
						  <td colspan="4"><input name="Celular" 	type="text" size="50" maxlength="50" value="<?php echo $Sitio; ?>"></td>
					  </tr>
						<tr>
							<td height="25" colspan="2">Publicar:</td>
							<td colspan="4">&nbsp;
							</td>
						</tr>
						<tr>
						  	<td height="35" colspan="6" class="tituloficha">Contactos					      </td>
					  	</tr>
						<tr class="titulo">
					  	  <td width="2%" height="25" align="center" >N&deg;</td>
						  	<td colspan="2" align="center">Contacto</td>
					  	  <td width="35%" align="center">Correo</td>
					      	<td width="23%" align="center">Departamento</td>
					      	<td width="20%" align="center">Tel&eacute;fonos</td>
					  	</tr>
						<tr>
							<td height="24" align="center">1</td>
							<td colspan="2">
								<input name="Contacto" 	type="text" size="25" maxlength="50" value="<?php echo $Contacto;?>">
							</td>
							<td>
								<input name="EmailContacto" 	type="email" size="50" maxlength="50" value="<?php echo $EmailContacto;?>">
							</td>
						    <td><input name="DeptoContacto" 	type="text" size="25" maxlength="50" value="<?php echo $DeptoContacto;?>"></td>
						    <td>
								<input name="FonoContacto" 	type="text" size="20" maxlength="30" value="<?php echo $FonoContacto;?>">
							</td>
						</tr>
						<tr>
							<td height="24" align="center">2</td>
							<td colspan="2">
								<input name="Contacto2" 	type="text" size="25" maxlength="50" value="<?php echo $Contacto2;?>">
							</td>
							<td>
								<input name="EmailContacto2" 	type="email" size="50" maxlength="50" value="<?php echo $EmailContacto2;?>">
							</td>
						    <td><input name="DeptoContacto2" 	type="text" size="25" maxlength="50" value="<?php echo $DeptoContacto2;?>"></td>
						    <td>
								<input name="FonoContacto2" 	type="text" size="20" maxlength="30" value="<?php echo $FonoContacto2;?>">
							</td>
						</tr>
						<tr>
							<td height="24" align="center">3</td>
							<td colspan="2">
								<input name="Contacto3" 	type="text" size="25" maxlength="50" value="<?php echo $Contacto3;?>">
							</td>
							<td>
								<input name="EmailContacto3" 	type="email" size="50" maxlength="50" value="<?php echo $EmailContacto3;?>">
							</td>
						    <td><input name="DeptoContacto3" 	type="text" size="25" maxlength="50" value="<?php echo $DeptoContacto3;?>"></td>
						    <td>
								<input name="FonoContacto3" 	type="text" size="20" maxlength="30" value="<?php echo $FonoContacto3;?>">
							</td>
						</tr>
						<tr>
							<td height="24" align="center">4</td>
							<td colspan="2">
								<input name="Contacto4" 	type="text" size="25" maxlength="50" value="<?php echo $Contacto4;?>">
							</td>
							<td>
								<input name="EmailContacto4" 	type="email" size="50" maxlength="50" value="<?php echo $EmailContacto4;?>">
							</td>
						    <td><input name="DeptoContacto4" 	type="text" size="25" maxlength="50" value="<?php echo $DeptoContacto4;?>"></td>
						    <td>
								<input name="FonoContacto4" 	type="text" size="20" maxlength="30" value="<?php echo $FonoContacto4;?>">
							</td>
						</tr>
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