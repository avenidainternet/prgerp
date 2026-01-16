<?php
	session_start();
	$_SESSION['Grabado'] = "NO";
	$MsgUsr ="";	
	include_once("../conexionli.php");
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

	/* Declaraci�n de Variables */	
	$Run 				= "";
	$Paterno 			= "";
	$Materno			= "";
	$Nombres			= "";
	$Sexo				= "";
	$FechaNac			= "";
	$ProfesionOficio	= "";
	$Direccion			= "";
	$Comuna				= "";
	$Ciudad				= "";
	$Cargo				= "";
	$LugarTrabajo		= "";
	$TipoContrato		= "H";
	$FechaContrato		= date('Y-m-d');
	$TerminoContrato	= date('Y-m-d');
	$ServicioIntExt		= "";
	$SueldoBase			= "";
	$PeriodoPago		= "";
	$Banco				= "";
	$nCuenta			= "";
	$Fonos				= "";
	$Celular			= "";
	$Email				= "";
	$Estado				= "";
	$tNetos				= 0;
	$FuncionCargo 		= '';
	$Proyecto 			= '';
	$UltimaBoleta 		= '';

	$Proceso = 1;
	
	if(isset($_GET['Proceso'])) 	{ $Proceso  = $_GET['Proceso']; }
	if(isset($_GET['Run'])) 		{ $Run  	= $_GET['Run']; 	}

	if($Proceso == 2 or $Proceso == 3){
		$link=Conectarse();
		$bdProv=$link->query("SELECT * FROM PersonalHonorarios WHERE Run = '".$Run."'");
		if ($row=mysqli_fetch_array($bdProv)){
   			$Paterno 			= $row['Paterno'];
   			$Materno 			= $row['Materno'];
   			$Nombres 			= $row['Nombres'];
   			//$Sexo	 			= $row['Sexo'];
   			//$FechaNac			= $row['FechaNac'];
   			$ProfesionOficio	= $row['ProfesionOficio'];
			$Direccion			= $row['Direccion'];
			$Comuna				= $row['Comuna'];
			$Ciudad				= $row['Ciudad'];
			$Cargo				= $row['Cargo'];
			$FuncionCargo		= $row['FuncionCargo'];
			$Proyecto			= $row['IdProyecto'];
			$LugarTrabajo		= $row['LugarTrabajo'];
			$TipoContrato		= $row['TipoContrato'];
			//$FechaContrato		= $row['FechaContrato'];
			//$TerminoContrato	= $row['TerminoContrato'];
			$ServicioIntExt		= $row['ServicioIntExt'];
			$SueldoBase			= $row['SueldoBase'];
			$UltimaBoleta		= $row['UltimaBoleta'];
			$PeriodoPago		= $row['PeriodoPago'];
			$Banco				= $row['Banco'];
			$nCuenta			= $row['nCuenta'];
			$Fonos				= $row['Fonos'];
			$Celular			= $row['Celular'];
			$Email				= $row['Email'];
			$Estado				= $row['Estado'];
		}
		$link->close();
		if($_GET['Proceso']==3){
			$MsgUsr = "Se eliminara Registro...";
		}
	}

	$sw = false;
	if(isset($_POST['Proceso'])){ 
		$Proceso 	= $_POST['Proceso'];
		if(isset($_POST['Paterno'])){
			$Paterno 	= $_POST['Paterno'];
			if(isset($_POST['Materno'])){
				$Materno 	= $_POST['Materno'];
				if(isset($_POST['Nombres'])){
					$Nombres 	= $_POST['Nombres'];
					if(isset($_POST['Run'])){
						$Run 	= $_POST['Run'];
						if(isset($_POST['Direccion'])){ 
							$Direccion 			= $_POST['Direccion']; 
							$Comuna				= $_POST['Comuna'];
							$Ciudad				= $_POST['Ciudad'];
							$Cargo				= $_POST['Cargo'];
							$FuncionCargo		= $_POST['FuncionCargo'];
							$Proyecto			= $_POST['Proyecto'];
   							$ProfesionOficio	= $_POST['ProfesionOficio'];
   							//$Sexo	 			= $_POST['Sexo'];
   							//$FechaNac			= $_POST['FechaNac'];
							$LugarTrabajo		= $_POST['LugarTrabajo'];
							$TipoContrato		= $_POST['TipoContrato'];
							//$FechaContrato		= $_POST['FechaContrato'];
							//$TerminoContrato	= $_POST['TerminoContrato'];
							$ServicioIntExt		= $_POST['ServicioIntExt'];
							if($ServicioIntExt=="I"){
								$SueldoBase			= $_POST['SueldoBase'];
							}else{
								$SueldoBase			= 0;
							}
							$UltimaBoleta		= $_POST['UltimaBoleta'];
							$PeriodoPago		= substr($_POST['PeriodoPago'],0,1);
							$Banco				= $_POST['Banco'];
							$nCuenta			= $_POST['nCuenta'];
							$Fonos				= $_POST['Fonos'];
							$Celular			= $_POST['Celular'];
							$Email				= $_POST['Email'];
							$Estado				= $_POST['Estado'];
							$sw = true;
						}
					}
				}
			}
		}
	}
	
	if($sw == true){
		$sw = false;
		
		if($Proceso == 1 || $Proceso == 2 || $Proceso == 3){ /* Agregar */
			$link=Conectarse();
			$bdProv=$link->query("SELECT * FROM PersonalHonorarios WHERE Run = '".$Run."'");
			if ($row=mysqli_fetch_array($bdProv)){
				if($Proceso == 2){
	   				$MsgUsr = 'Registro Actualizado...';
					$bdProv=$link->query("SELECT * FROM PersonalHonorarios WHERE Run = '".$Run."'");
					if ($row=mysqli_fetch_array($bdProv)){
/*
						$actSQL.="Sexo				='".$Sexo."',";
						$actSQL.="FechaNac			='".$FechaNac."',";
*/					
						$actSQL="UPDATE PersonalHonorarios SET ";
						$actSQL.="Paterno			='".$Paterno."',";
						$actSQL.="Materno			='".$Materno."',";
						$actSQL.="Nombres			='".$Nombres."',";
						$actSQL.="Direccion			='".$Direccion."',";
						$actSQL.="Comuna			='".$Comuna."',";
						$actSQL.="Ciudad			='".$Ciudad."',";
						$actSQL.="Cargo				='".$Cargo."',";
						$actSQL.="FuncionCargo		='".$FuncionCargo."',";
						$actSQL.="IdProyecto		='".$Proyecto."',";
						$actSQL.="ProfesionOficio	='".$ProfesionOficio."',";
						$actSQL.="Fonos				='".$Fonos."',";
						$actSQL.="Celular			='".$Celular."',";
						$actSQL.="TipoContrato		='".$TipoContrato."',";
						$actSQL.="LugarTrabajo		='".$LugarTrabajo."',";
						$actSQL.="TipoContrato		='".$TipoContrato."',";
						$actSQL.="ServicioIntExt	='".$ServicioIntExt."',";
						$actSQL.="SueldoBase		='".$SueldoBase."',";
						$actSQL.="UltimaBoleta		='".$UltimaBoleta."',";
						$actSQL.="PeriodoPago		='".$PeriodoPago."',";
						$actSQL.="Banco				='".$Banco."',";
						$actSQL.="nCuenta			='".$nCuenta."',";
						$actSQL.="Email				='".$Email."',";
						$actSQL.="Estado			='".$Estado."'";
						$actSQL.="WHERE Run			= '".$Run."'";
						$bdProv=$link->query($actSQL);
					}
				}
				if($Proceso == 3){
					$bdProv=$link->query("DELETE FROM PersonalHonorarios WHERE Run = '".$Run."'");
					$link->close();
					header("Location: phonorarios.php");
				}
			}else{
				$link->query("insert into PersonalHonorarios(
														Run,
														Paterno,
														Materno,
														Nombres,
														Direccion,
														Comuna,
														Ciudad,
														Cargo,
														FuncionCargo,
														IdProyecto,
														ProfesionOficio,
														LugarTrabajo,
														TipoContrato,
														ServicioIntExt,
														SueldoBase,
														UltimaBoleta,
														PeriodoPago,
														Banco,
														nCuenta,
														Fonos,
														Celular,
														Email,
														Estado
														) 
										values 		(	'$Run',
														'$Paterno',
														'$Materno',
														'$Nombres',
														'$Direccion',
														'$Comuna',
														'$Ciudad',
														'$Cargo',
														'$FuncionCargo',
														'$Proyecto',
														'$ProfesionOficio',
														'$LugarTrabajo',
														'$TipoContrato',
														'$ServicioIntExt',
														'$SueldoBase',
														'$UltimaBoleta',
														'$PeriodoPago',
														'$Banco',
														'$nCuenta',
														'$Fonos',
														'$Celular',
														'$Email',
														'$Estado'
														)");
   				$MsgUsr = 'Se ha registrado un nueva Ficha de Personal Honorario...';
				$link->close();
				header("Location: phonorarios.php");
			}
			$link->close();
		}
	}
	
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Modulo de Sueldos</title>

<link href="styles.css" rel="stylesheet" type="text/css">

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

<body onLoad="inicioformulario()">
	<?php include_once('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<form name="form" action="mphonorarios.php" method="post">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<img src="../gastos/imagenes/send_48.png" width="28" height="28" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					Personal Honorarios
				</strong>
				<?php include_once('barramenu.php'); ?>
			</div>
			
			<div id="BarraOpciones">
				<div id="ImagenBarraLeft">
					<a href="../plataformaErp.php" title="Menú Principal">
						<img src="../gastos/imagenes/Menu.png"><br>
					</a>
					Principal
				</div>
				<div id="ImagenBarraLeft">
					<a href="personal.php" title="Personal">
						<img src="../gastos/imagenes/subst_student.png" width="48"><br>
					</a>
					Personal
				</div>
				<div id="ImagenBarraLeft" title="Prestadores">
					<a href="phonorarios.php" title="Prestadores">
						<img src="../gastos/imagenes/send_48.png"><br>
					</a>
					Prestadores
				</div>
				<div id="ImagenBarraLeft" title="Proveedores">
					<a href="proveedores.php" title="Proveedores">
						<img src="../gastos/imagenes/contactus_128.png"><br>
					</a>
					Proveedores
				</div>
				<div id="ImagenBarraLeft" title="Cálculo de Sueldos">
					<a href="CalculoSueldos.php" title="Cálculo de Sueldos">
						<img src="../gastos/imagenes/purchase_128.png"><br>
					</a>
					Sueldos
				</div>
				<div id="ImagenBarraLeft" title="Cálculo de Honorarios">
					<a href="CalculoHonorarios.php" title="Servicios de Honorarios">
						<img src="../gastos/imagenes/blank_128.png"><br>
					</a>
					Honorarios
				</div>
				<div id="ImagenBarraLeft" title="Pago Factura Proveedores">
					<a href="CalculoFacturas.php" title="Pago con Factura">
						<img src="../gastos/imagenes/crear_certificado.png"><br>
					</a>
					Facturas
				</div>
				<div id="ImagenBarraLeft" title="Informes Emitidos">
					<a href="ipdf.php" title="Informes Emitidos">
						<img src="../gastos/imagenes/pdf.png"><br>
					</a>
					Emitidos
				</div>
			</div>
			
			<!-- Fin Caja Cuerpo -->
			<?php
				echo '<div align="center">';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td><strong style="font-size:14px;">Ficha de Personal</strong>';
				echo '				<div id="ImagenBarra">';
				if($Proceso == 1 || $Proceso == 2){
            		echo '			<input name="Grabar" type="image" id="Grabar" src="../gastos/imagenes/save_32.png" width="28" height="28" title="Guardar">';
				}else{
            		echo '			<input name="Eliminar" type="image" id="Grabar" src="../gastos/imagenes/inspektion.png" width="28" height="28" title="Eliminar">';
				}
				echo '				</div>';
				echo '			</td>';
				echo '		</tr>';
				echo '	</table>';
				

				echo '<div id="RegistroFactura">';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaDocumentos">';
				echo '		<tr>';
				echo '			<td>Rut: </td>';
				echo '			<td>';
									if($Run){
										echo $Run;
										echo '<input name="Run" 	type="hidden" size="10" maxlength="10" value="'.$Run.'">';
									}else{
										echo '<input name="Run" 	type="text" size="10" maxlength="10" value="'.$Run.'">';
									}
				echo '				<input name="Proceso"  	type="hidden" value="'.$Proceso.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Ap.Paterno: </td>';
				echo '			<td>';
				echo '				<input name="Paterno" 	type="text" size="50" maxlength="50" value="'.$Paterno.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Ap.Materno: </td>';
				echo '			<td>';
				echo '				<input name="Materno" 	type="text" size="50" maxlength="50" value="'.$Materno.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Nombres: </td>';
				echo '			<td>';
				echo '				<input name="Nombres" 	type="text" size="50" maxlength="50" value="'.$Nombres.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Profesión u Oficio: </td>';
				echo '			<td>';
				echo '				<input name="ProfesionOficio" 	type="text" size="50" maxlength="50" value="'.$ProfesionOficio.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Dirección: </td>';
				echo '			<td>';
				echo '				<input name="Direccion" 	type="text" size="50" maxlength="50" value="'.$Direccion.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Comuna: </td>';
				echo '			<td>';
				echo '				<input name="Comuna" 	type="text" size="25" maxlength="25" value="'.$Comuna.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Ciudad: </td>';
				echo '			<td>';
				echo '				<input name="Ciudad" 	type="text" size="25" maxlength="25" value="'.$Ciudad.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Email: </td>';
				echo '			<td>';
				echo '				<input name="Email" 	type="email" size="50" maxlength="50" value="'.$Email.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Telefono: </td>';
				echo '			<td>';
				echo '				<input name="Fonos" 	type="text" size="40" maxlength="40" value="'.$Fonos.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Celular: </td>';
				echo '			<td>';
				echo '				<input name="Celular" 	type="text" size="30" maxlength="30" value="'.$Celular.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr height=50px>';
				echo '			<td>Estado: </td>';
				echo '			<td>';
	  								echo '<select name="Estado" id="Estado">';
										if($Estado==""){
											echo '<option selected></option>';
											echo '<option  			value="A">Activo</option>';
											echo '<option  			value="I">Inactivo</option>';
										}
										if($Estado=="A"){
											echo '<option selected 	value="A">Activo</option>';
											echo '<option  			value="I">Inactivo</option>';
										}
										if($Estado=="I"){
											echo '<option  			value="A">Activo</option>';
											echo '<option selected 	value="I">Inactivo</option>';
										}
									echo '</select>';
				echo '			</td>';
				echo '		</tr>';
				echo '</table>';
				

				echo '<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td><strong style="font-size:14px;">Datos Laborales</strong></td>';
				echo '		</tr>';
				echo '</table>';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaDocumentos">';
				echo '		<tr style="margin-top:10px;">';
				echo '			<td>Tipo de Contrato: </td>';
				echo '			<td>';
	  								echo '<select name="TipoContrato" id="TipoContrato">';
										if($TipoContrato==""){
											echo '<option selected></option>';
											echo '<option  			value="P">Planta</option>';
											echo '<option  			value="C">Contrata</option>';
											echo '<option  			value="H">Honorarios</option>';
										}
										if($TipoContrato=="P"){
											echo '<option selected 	value="P">Planta</option>';
											echo '<option  			value="C">Contrata</option>';
											echo '<option  			value="H">Honorarios</option>';
										}
										if($TipoContrato=="C"){
											echo '<option  			value="P">Planta</option>';
											echo '<option selected 	value="C">Contrata</option>';
											echo '<option  			value="C">Honorarios</option>';
										}
										if($TipoContrato=="H"){
											echo '<option  			value="P">Planta</option>';
											echo '<option  			value="C">Contrata</option>';
											echo '<option  selected	value="H">Honorarios</option>';
										}
									echo '</select>';
				echo '			</td>';
				echo '		</tr>';

				echo '		<tr style="margin-top:10px;">';
				echo '			<td>Periodo de Pago: </td>';
				echo '			<td>';
	  								echo '<select name="PeriodoPago">';
										if($PeriodoPago==""){
											echo '<option selected></option>';
											echo '<option  			value="M">Mensual</option>';
											echo '<option  			value="E">Esporadico</option>';
										}
										if($PeriodoPago=="M"){
											echo '<option></option>';
											echo '<option selected 	value="M">Mensual</option>';
											echo '<option  			value="E">Esporadico</option>';
										}
										if($PeriodoPago=="E"){
											echo '<option></option>';
											echo '<option  			value="M">Mensual</option>';
											echo '<option selected 	value="E">Esporadico</option>';
										}
									echo '</select>';
				echo '			</td>';
				echo '		</tr>';


				echo '		<tr>';
				echo '			<td>Lugar de Trabajo: </td>';
				echo '			<td>';
				echo '				<input name="LugarTrabajo" 	type="text" size="50" maxlength="50" value="'.$LugarTrabajo.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Tipo de Servicio: </td>';
				echo '			<td>';
	  								echo '<select name="ServicioIntExt" id="ServicioIntExt">';
										if($ServicioIntExt==""){
											echo '<option selected></option>';
											echo '<option  			value="I">Interno</option>';
											echo '<option  			value="E">Externo</option>';
										}
										if($ServicioIntExt=="I"){
											echo '<option selected 	value="I">Interno</option>';
											echo '<option  			value="E">Externo</option>';
										}
										if($ServicioIntExt=="E"){
											echo '<option  			value="I">Interno</option>';
											echo '<option selected 	value="E">Externo</option>';
										}
									echo '</select>';
				echo '			</td>';
				echo '		</tr>';

				echo '		<tr>';
				echo '			<td>Cargo: </td>';
				echo '			<td>';
				echo '				<input name="Cargo" 	type="text" size="50" maxlength="50" value="'.$Cargo.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Funcion del Cargo: </td>';
				echo '			<td>';
				echo '				<input name="FuncionCargo" 	type="text" size="80" maxlength="80" value="'.$FuncionCargo.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Proyecto Asociado: </td>';
				echo '			<td>';
		  								echo '<select name="Proyecto" id="Proyecto">';
													$link=Conectarse();
													$bdPr=$link->query("SELECT * FROM Proyectos");
													if ($row=mysqli_fetch_array($bdPr)){
														DO{
						    								if($Proyecto == $row['IdProyecto']){
																echo "<option selected 	value='".$row['IdProyecto']."'>".$row['IdProyecto']."</option>";
															}else{
																echo "	<option 		value='".$row['IdProyecto']."'>".$row['IdProyecto']."</option>";
															}
														}WHILE ($row=mysqli_fetch_array($bdPr));
													}
													$link->close();
										echo '</select>';
				echo '			</td>';
				echo '		</tr>';
				
					echo '		<tr>';
					echo '			<td>Monto último Pago: </td>';
					echo '			<td>';
					echo '				<input name="SueldoBase" 			type="text" 	size="9" maxlength="9" 	value="'.$SueldoBase.'">';
					echo '			</td>';
					echo '		</tr>';
					echo '		<tr>';
					echo '			<td>Última Boleta Emitida: </td>';
					echo '			<td>';
					echo '				<input name="UltimaBoleta" 	type="text" 	size="9" maxlength="9" value="'.$UltimaBoleta.'">';
					echo '			</td>';
					echo '		</tr>';
				
				echo '		<tr>';
				echo '			<td>Banco: </td>';
				echo '			<td>';
				echo '				<input name="Banco" 	type="text" size="25" maxlength="25" value="'.$Banco.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Número de Cuenta: </td>';
				echo '			<td>';
				echo '				<input name="nCuenta" 	type="text" size="20" maxlength="20" value="'.$nCuenta.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '	</table>';
				echo '</div>';


				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaOpcDoc">';
				echo '		<tr>';
				echo '			<td>Mensaje al Usuario... ';
				if($MsgUsr){
					echo '<div id="Saldos">'.$MsgUsr.'</div>';
				}else{
					echo '<div id="Saldos" style="display:none; ">'.$MsgUsr.'</div>';
				}
				echo '			</td>';
				echo '		</tr>';
				echo '	</table>';


				if($tNetos > 0){
					echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaFinal">';
					echo '		<tr>';
					echo '			<td width=" 5%">&nbsp;</td>';
					echo '			<td width=" 8%">&nbsp;</td>';
					echo '			<td width="15%">&nbsp;</td>';
					echo '			<td width="10%">&nbsp;</td>';
					echo '			<td width=" 7%">&nbsp;</td>';
					echo '			<td width="15%">Total Página</td>';
					echo '			<td width="10%">'.number_format($tNeto , 0, ',', '.').'			</td>';
					echo '			<td width="10%">'.number_format($tIva  , 0, ',', '.').'			</td>';
					echo '			<td width="10%">'.number_format($tBruto, 0, ',', '.').'			</td>';
    				echo '			<td></td>';
    				echo '			<td></td>';
					echo '		</tr>';
					echo '		<tr>';
					echo '			<td>&nbsp;</td>';
					echo '		</tr>';
					echo '		<tr>';
					echo '			<td width=" 5%">&nbsp;</td>';
					echo '			<td width=" 8%">&nbsp;</td>';
					echo '			<td width="15%">&nbsp;</td>';
					echo '			<td width="10%">&nbsp;</td>';
					echo '			<td width=" 7%">&nbsp;</td>';
					echo '			<td width="15%">Total General</td>';
					echo '			<td width="10%">'.number_format($tNetos , 0, ',', '.').'			</td>';
					echo '			<td width="10%">'.number_format($tIvas  , 0, ',', '.').'			</td>';
					echo '			<td width="10%">'.number_format($tBrutos, 0, ',', '.').'			</td>';
    				echo '			<td></td>';
    				echo '			<td></td>';
					echo '		</tr>';
					echo '	</table>';
				}
				echo '</div>';
			?>

		</div>
		</form>
	</div>
	<div style="clear:both; "></div>
	<br>
</body>
</html>