<?php 	
	session_start(); 
	header('Content-Type: text/html; charset=utf-8');
	include_once("../conexionli.php"); 
	
	$situacionMuestra = 'R';
	$RutCli = '';
	$nContacto = '';
	$CAM = 0;
	$Descripcion = '';
	
	if(isset($_GET['RutCli'])) 	{ $RutCli	= $_GET['RutCli']; 	}
	if(isset($_GET['RAM'])) 	{ $RAM 		= $_GET['RAM']; 	}
	if(isset($_GET['accion']))	{ $accion 	= $_GET['accion'];	}

	if(isset($_POST['RutCli'])) { $RutCli	= $_POST['RutCli']; }
	if(isset($_POST['RAM'])) 	{ $RAM 		= $_POST['RAM']; 	}
	if(isset($_POST['accion']))	{ $accion 	= $_POST['accion'];	}

	$fechaHoy 		= date('Y-m-d');
	$fechaRegistro 	= date('Y-m-d');

	if($accion == 'Agrega'){
		$link=Conectarse();
		$RAM = 1;
		$bdCot=$link->query("SELECT * FROM registroMuestras Order By RAM Desc");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$RAM = $rowCot['RAM'] + 1;
		}
/*
		$bdCot=$link->query("SELECT * FROM Cotizaciones Order By RAM Desc");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$RAM = $rowCot[RAM] + 1;
		}
*/		
		$link->close();
		$accion = 'Guardar';
	}
	$Copias = 0;
	$link=Conectarse();
	$bdRAM=$link->query("SELECT * FROM registroMuestras Where RAM = '".$RAM."'");
	if($rowRAM=mysqli_fetch_array($bdRAM)){
		$fechaRegistro 		= $rowRAM['fechaRegistro'];
		$CAM 				= $rowRAM['CAM'];
		$Copias				= $rowRAM['Copias'];
		$Fan 				= $rowRAM['Fan'];
		$RutCli				= $rowRAM['RutCli'];
		$nContacto			= $rowRAM['nContacto'];
		$usrRecepcion		= $rowRAM['usrRecepcion'];
		$Descripcion		= $rowRAM['Descripcion'];
		$situacionMuestra	= $rowRAM['situacionMuestra'];
	}

	$siCAM = 'NO';
	$bdCot=$link->query("SELECT * FROM Cotizaciones Where RutCli = '".$RutCli."' and Estado = 'E'");
	if($rowCot=mysqli_fetch_array($bdCot)){
		$siCAM = 'SI';
	}
	$link->close();
?>
<!doctype html>
 
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

	<link rel="shortcut icon" href="favicon.ico" />
	<link rel="apple-touch-icon" href="touch-icon-iphone.png" />
	<link rel="apple-touch-icon" href="touch-icon-ipad.png" />
	<link rel="apple-touch-icon" href="touch-icon-iphone4.png" />

	<title>SIMET - Recepción de Muestras</title>

	<link href="../css/stylesTv.css" rel="stylesheet" type="text/css">
	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<script type="text/javascript" src="../jquery/libs/1/jquery.min.js"></script>	

</head>

<body>

<div id="bloqueoTrasperente">
	<div id="cajaRegistraPruebas">
		<center>
		<form name="form" action="recepcionMuestras.php" method="post">
		<table width="59%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
			<tr>
				<td colspan="2" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
					<span style="color:#FFFFFF; font-size:18px; font-weight:700;">
						REGISTRO DE MUESTRAS (RAM) <?php echo $_GET['accion']; ?>
						<div id="botonImagen">
							<?php 
								$prgLink = 'recepcionMuestras.php';
								echo '<a href="'.$prgLink.'" style="float:right;"><img src="../imagenes/no_32.png"></a>';
							?>
						</div>
				  </span>
			  </td>
			</tr>
		  <tr>
		    <td colspan="2" class="lineaDerBot">
		  	  	<strong style=" font-size:20px; font-weight:700; margin-left:5px;">
				  	RAM-
				  	<input name="RAM" 	 			id="RAM" 	 			type="text"   	value="<?php echo $RAM; ?>" size="7" maxlength="7" style="font-size:18px; font-weight:700;"  />
				  	<input name="accion" 			id="accion" 			type="hidden" 	value="<?php echo $accion; ?>">
				  	<input name="situacionMuestra" 	id="situacionMuestra" 	type="hidden" 	value="<?php echo $situacionMuestra; ?>">
					N° Clones
					<input name="Copias" type="text" maxlength="2" size="2" value="<?php echo $Copias; ?>">
<!-- 
					<select name="Copias">
						<?php 
						if($Copias > 0){?>
							<option value='<?php echo $Copias; ?>'><?php echo $Copias; ?></option>
						<?php
						}
						?>
						<option value='0'>0</option>
						<option value='1'>1</option>
						<option value='2'>2</option>
						<option value='3'>3</option>
						<option value='4'>4</option>
						<option value='5'>5</option>
						<option value='6'>6</option>
						<option value='7'>7</option>
						<option value='8'>8</option>
						<option value='9'>9</option>
					</select>
-->
			  	</strong>
				(0 a 99)
  			</td>
		  </tr>
			<tr>
				<td width="19%">Fecha RAM </td>
				<td class="lineaDer">Responzable Registro de Muestras:
			  </td>
		    </tr>
			<tr>
				<td class="lineaDerBot">
					<span>
				  	<input name="fechaRegistro" 	id="fechaRegistro" type="date"  value="<?php echo $fechaRegistro; ?>" style="font-size:12px; font-weight:700;" autofocus>
					</span>
				</td>
				<td class="lineaDerBot">
					<?php $usrCotizador = $_SESSION['usr']; ?>
					<select name="usrRecepcion" id="usrRecepcion" style="font-size:12px; font-weight:700;">
						<?php
						$link=Conectarse();
						$bdCli=$link->query("SELECT * FROM Usuarios Order By usuario");
						if($rowCli=mysqli_fetch_array($bdCli)){
							do{
								if($rowCli['nPerfil']  == 1 or $rowCli['nPerfil']  == '01' or $rowCli['nPerfil']  == '02'){
								
									if($usrCotizador){
										if($usrCotizador == $rowCli['usr']){
											echo '<option selected value='.$rowCli['usr'].'>'.$rowCli['usuario'].'</option>';
										}else{
											echo '<option value='.$rowCli['usr'].'>'.$rowCli['usuario'].'</option>';
										}
									}else{
										if($_SESSION['usr'] == $rowCli['usr']){
											echo '<option selected value='.$rowCli['usr'].'>'.$rowCli['usuario'].'</option>';
										}else{
											echo '<option value='.$rowCli['usr'].'>'.$rowCli['usuario'].'</option>';
										}
									}
								}
							}while ($rowCli=mysqli_fetch_array($bdCli));
						}
						$link->close();
						?>
					</select>
		        </td>
	        </tr>
			<tr>
				<td class="lineaDerBot">Empresa / Cliente  :</td>
				<td class="lineaDerBot">
					<select name="RutCli" Id="RutCli" onChange="buscarContactos($('#RutCli').val(), $('#nContacto').val(), $('#RAM').val())" style="font-size:12px; font-weight:700;">
						<option></option>
						<?php
						$link=Conectarse();
						$bdCli=$link->query("SELECT * FROM Clientes Order By Cliente");
						if($rowCli=mysqli_fetch_array($bdCli)){
							do{
								if($rowCli['RutCli'] == $RutCli){
									echo '<option selected 	value='.$rowCli['RutCli'].'>'.$rowCli['Cliente'].'</option>';
								}else{
									echo '<option 			value='.$rowCli['RutCli'].'>'.$rowCli['Cliente'].'</option>';
								}
							}while ($rowCli=mysqli_fetch_array($bdCli));
						}
						$link->close();
						?>
				</select>				
				</td>
            </tr>
			<tr>
			  <td valign="top" class="lineaDerBot">Atenci&oacute;n:</td>
			  <td height="25" valign="top" class="lineaDerBot">
					<?php
						if($RutCli){?>
							<select name="nContacto" Id="nContacto" style="font-size:12px; font-weight:700;">
								<option></option>
								<?php
								$link=Conectarse();
								$bdCli=$link->query("SELECT * FROM contactosCli Where RutCli = '".$RutCli."'Order By nContacto");
								if($rowCli=mysqli_fetch_array($bdCli)){
									do{
										if($rowCli['nContacto'] == $nContacto){
											echo '<option selected 	value='.$rowCli['nContacto'].'>'.$rowCli['Contacto'].'</option>';
										}else{
											echo '<option 			value='.$rowCli['nContacto'].'>'.$rowCli['Contacto'].'</option>';
										}
									}while ($rowCli=mysqli_fetch_array($bdCli));
								}
								$link->close();
								?>
						</select>				
						<?php
						}
					?>
                <!-- 					<input name="Atencion" 		id="Atencion" 		type="text" size="50" value="<?php echo $Atencion; ?>" 		style="font-size:12px; font-weight:700;"> -->		  		</td>
		    </tr>
		    <tr>
		      <td valign="top" class="lineaDer">Códigos: </td>
		      <td class="lineaDer">
			  </td>
	      </tr>
	      <tr>
			  <td valign="top" class="lineaDer">Descripción</td>
			  <td class="lineaDer">
			  	<textarea name="Descripcion" id="Descripcion" cols="50" rows="3" style="font-size:12px; font-weight:700;" placeholder="Descripción Muestra ..."><?php echo $Descripcion; ?></textarea>
			  </td>
		  </tr>
		  <tr>
				<td colspan="2" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px; ">
					<?php
						//echo $accion;
						if($accion == 'Guardar' || $accion == 'Agrega' || $accion == 'Editar'){?>
							<div id="botonImagen">
								<button name="confirmarGuardar" style="float:right;" title="Guardar">
									<img src="../gastos/imagenes/guardar.png" width="55" height="55">
								</button>
							</div>
							<?php if($CAM > 0){?>
								<div id="botonImagen">
									<button name="imprimirRAM" style="float:right;" title="Imprimir RAM...">
										<img src="../imagenes/printer_128_hot.png" width="55" height="55">
									</button>
								</div>
							<?php } ?>
							<?php
						}
						if($accion == 'Borrar'){?>
							<button name="confirmarBorrar" style="float:right;" title="Borrar...">
								<img src="../gastos/imagenes/inspektion.png" width="55" height="55">
							</button>
							<button name="dardeBaja" style="float:right;" title="Dar de Baja...">
								<img src="../imagenes/open_edupage_64.png" width="55" height="55">
							</button>
							<?php
						}
					?>
			  		<span id="CodigoDeBarra"></span>

				</td>
			</tr>
		</table>
		</form>
		</center>
	</div>
</div>
</body>
</html>