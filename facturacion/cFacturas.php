<?php
	session_start();
	$_SESSION['Grabado'] = "NO";
	$MsgUsr ="Despues de registrar e ingresar todos los datos de la Factura se podrá IMPRIMIR FORULARIO 7...";	
	include("conexion.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=mysql_query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysql_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		mysql_close($link);
	}else{
		header("Location: index.php");
	}

	/* Declaración de Variables */	
	$RutProv			= "";
	$Prov				= "";
	$Proveedor 			= "";
	$ProfesionOficio	= "";
	$Cargo				= "";
	$TpCosto			= "";
	$LugarTrabajo		= "";
	$TipoContrato		= "";
	$FechaContrato		= date('Y-m-d');
	$TerminoContrato	= date('Y-m-d');
	$ServicioIntExt		= "";
	$PeriodoPago		= "M";
	$Banco				= "";
	$nCuenta			= "";
	$Email				= "";
	$Estado				= "";
	$FechaPago			= "";
	$nLinea				= 1;

	$Mes = array(
					1 => 'Enero', 
					2 => 'Febrero',
					3 => 'Marzo',
					4 => 'Abril',
					5 => 'Mayo',
					6 => 'Junio',
					7 => 'Julio',
					8 => 'Agosto',
					9 => 'Septiembre',
					10 => 'Octubre',
					11 => 'Noviembre',
					12 => 'Diciembre'
				);
				
	
	$MesNum = array(	
					'Enero' 		=> '01', 
					'Febrero' 		=> '02',
					'Marzo' 		=> '03',
					'Abril' 		=> '04',
					'Mayo' 			=> '05',
					'Junio' 		=> '06',
					'Julio' 		=> '07',
					'Agosto' 		=> '08',
					'Septiembre'	=> '09',
					'Octubre' 		=> '10',
					'Noviembre' 	=> '11',
					'Diciembre'		=> '12'
				);

	$fd 	= explode('-', date('Y-m-d'));
	if(isset($_GET['Mm'])) { 
		$Mm = $_GET['Mm']; 
		$Periodo = $MesNum[$Mm].".".$fd[0];
	}else{
		$Mm = $Mes[ intval($fd[1]) ];
		$Periodo = $fd[1].".".$fd[0];
	}

	if($_GET['Proceso']) 	{ $Proceso  	= $_GET['Proceso']; 	}
	if($_GET['RutProv']) 	{ $RutProv 		= $_GET['RutProv']; $Prov = $_GET['RutProv']; }
	if($_GET['Periodo']) 	{ $Periodo  	= $_GET['Periodo']; 	}
	if($_GET['nFactura']) 	{ $nFactura  	= $_GET['nFactura']; 	}
	if($_GET['FechaPago']) 	{ $FechaPago  	= $_GET['FechaPago']; 	}

	if($_POST['RutProv'])	{ $RutProv 		= $_POST['RutProv']	; }else{ $TxtErr = "RutProv"; 				}
	if($_POST['Periodo']) 	{ $Periodo  	= $_POST['Periodo']	; }else{ $TxtErr .= ",Periodo"; 			}
	if($_POST['nFactura']) 	{ $nFactura  	= $_POST['nFactura']; }else{ $TxtErr .= ",Factura"; 			}

	$m = substr($Periodo,0,2);
	$Mm = $Mes[ intval($m) ];
	$pPago = $Mm.'.'.$fd[0];

	if($RutProv){
		$link=Conectarse();
		$bdProv=mysql_query("SELECT * FROM Proveedores WHERE RutProv = '".$RutProv."'");
		if ($row=mysql_fetch_array($bdProv)){
   			$Proveedor 			= $row['Proveedor'];
			$Banco				= $row['Banco'];
			$nCuenta			= $row['NumCta'];
			$Email				= $row['Email'];
			$UltimoPago			= $row['UltimoPago'];
			$TpCosto			= $row['TpCosto'];
			$ProfesionOficio	= $row['ProfesionOficio'];
		}
		$bdH=mysql_query("SELECT * FROM Facturas WHERE RutProv = '".$RutProv."' && PeriodoPago = '".$Periodo."' && nFactura = '".$nFactura."'");
		if ($rowH=mysql_fetch_array($bdH)){
   			$nLinea 		= $rowH['nLinea'];
   			$Descripcion 	= $rowH['Descripcion'];
   			$Bruto 			= $rowH['Bruto'];
   			$Proyecto 		= $rowH['IdProyecto'];
   			$FechaPago 		= $rowH['FechaPago'];
   			$Estado 		= $rowH['Estado'];
			$LugarTrabajo	= $rowH['LugarTrabajo'];
			$PerIniServ		= $rowH['PerIniServ'];
			$PerTerServ		= $rowH['PerTerServ'];
			$FuncionCargo	= $rowH['FuncionCargo'];
			$TpCosto		= $rowH['TpCosto'];
			$Descipcion		= $rowH['Descripcion'];
			$MsgUsr = "Ok";
		}
		mysql_close($link);
	}

	$sw = false;
	$TxtErr = "";
	if($_POST['Proceso'])		{ $Proceso 		= $_POST['Proceso']		; }

	
	if($_POST['RutProv'])		{ $RutProv 		= $_POST['RutProv']		; }else{ $TxtErr = "RutProv"; 				}
	if($_POST['Periodo']) 		{ $Periodo  	= $_POST['Periodo']		; }else{ $TxtErr .= ",Periodo"; 			}
	if($_POST['nFactura']) 		{ $nFactura  	= $_POST['nFactura']	; }else{ $TxtErr .= ",Factura"; 			}
	if($_POST['Proyecto']) 		{ $Proyecto  	= $_POST['Proyecto']	; }else{ $TxtErr .= ",Proyecto"; 		}
	if($_POST['PerIniServ'])	{ $PerIniServ  	= $_POST['PerIniServ']	; }else{ $TxtErr .= ",Periodo Inicio"; 	}
	if($_POST['PerTerServ'])	{ $PerTerServ  	= $_POST['PerTerServ']	; }else{ $TxtErr .= ",Periodo Termino"; 	}
	if($_POST['LugarTrabajo'])	{ $LugarTrabajo	= $_POST['LugarTrabajo']; }else{ $TxtErr .= ",Lugar de Trabajo"; }
	if($_POST['FuncionCargo'])	{ $FuncionCargo	= $_POST['FuncionCargo']; }else{ $TxtErr .= ",Función"; 			}
	if($_POST['Descripcion'])	{ $Descripcion	= $_POST['Descripcion']	; }else{ $TxtErr .= ",Descripcion"; 		}
	if($_POST['Bruto'])			{ $Bruto		= $_POST['Bruto']		; }else{ $TxtErr .= ",Bruto"; 			}
	if($_POST['TpCosto'])		{ $TpCosto		= $_POST['TpCosto']		; }else{ $TxtErr .= ",Tipo Costo"; 		}

	if(isset($_POST['Proceso'])){ 
		$Proceso 	= $_POST['Proceso'];
		if(isset($_POST['Bruto'])){
			if(isset($_POST['RutProv'])){
				if(isset($_POST['nFactura'])){
					if(isset($_POST['PerIniServ'])){
						if(isset($_POST['PerTerServ'])){
							if(isset($_POST['LugarTrabajo'])){
								if(isset($_POST['FuncionCargo'])){
									if(isset($_POST['Descripcion'])){
										if(isset($_POST['TpCosto'])){
											$sw = true;
										}
									}
								}
							}
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
			$bdProv=mysql_query("SELECT * FROM Facturas WHERE RutProv = '".$RutProv."' && PeriodoPago = '".$Periodo."' && nFactura = '".$nFactura."'");
			if ($row=mysql_fetch_array($bdProv)){
				if($Proceso == 2){
	   				$MsgUsr = 'Ok';
					$link=Conectarse();
					$bdProv=mysql_query("SELECT * FROM Facturas WHERE RutProv = '".$RutProv."' && PeriodoPago = '".$Periodo."' && nFactura = '".$nFactura."'");
					if ($row=mysql_fetch_array($bdProv)){
						$actSQL="UPDATE Facturas SET ";
						$actSQL.="TpCosto		='".$TpCosto."',";
						$actSQL.="FuncionCargo	='".$FuncionCargo."',";
						$actSQL.="LugarTrabajo	='".$LugarTrabajo."',";
						$actSQL.="IdProyecto	='".$Proyecto."',";
						$actSQL.="nFactura		='".$nFactura."',";
						$actSQL.="PerIniServ	='".$PerIniServ."',";
						$actSQL.="PerTerServ	='".$PerTerServ."',";
						$actSQL.="Descripcion	='".$Descripcion."',";
						$actSQL.="Bruto			='".$Bruto."'";
						$actSQL.="WHERE RutProv	= '".$RutProv."' && PeriodoPago = '".$Periodo."' && nFactura = '".$nFactura."'";
						$bdProv=mysql_query($actSQL);
					}
					$bdPer=mysql_query("SELECT * FROM Proveedores WHERE RutProv = '".$RutProv."'");
					if ($rowPer=mysql_fetch_array($bdPer)){
						if($rowPer['ServicioIntExt']=="I"){
							$actSQL="UPDATE Proveedores SET ";
							$actSQL.="TpCosto			='".$TpCosto.",'";
							$actSQL.="ProfesionOficio	='".$TpCosto.",'";
							$actSQL.="UtimoPago			='".$UltimoPago."'";
							$actSQL.="WHERE RutProv		= '".$RutProv."'";
							$bdPer=mysql_query($actSQL);
						}
					}
					header("Location: CalculoFacturas.php?Mm=".$Mm);
				}
				if($Proceso == 3){
					//$bdProv=mysql_query("DELETE FROM Honorarios WHERE Run = '".$Run."' && PeriodoPago = '".$Periodo."' && nBoleta = '".$nBoleta."'");
					mysql_close($link);
					header("Location: CalculoFacturas.php?Mm=".$Mm);
				}
			}else{
				echo "RutProv. ".$RutProv;
				mysql_query("insert into Facturas(
														RutProv,
														PeriodoPago,
														nFactura,
														nLinea,
														IdProyecto,
														PerIniServ,
														PerTerServ,
														LugarTrabajo,
														FuncionCargo,
														Descripcion,
														Bruto,
														TpCosto
														) 
										values 		(	
														'$RutProv',
														'$Periodo',
														'$nFactura',
														'$nLinea',
														'$Proyecto',
														'$PerIniServ',
														'$PerTerServ',
														'$LugarTrabajo',
														'$FuncionCargo',
														'$Descripcion',
														'$Bruto',
														'$TpCosto'
														)",$link);
				header("Location: CalculoFacturas.php?Mm=".$Mm);
   				$MsgUsr = 'Ok';
			}
			mysql_close($link);
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
	//$("#Total").bind('keydown', function(event)

		
	$("#Total").change(function()
	{
		//alert(event.keyCode);
		//if (event.keyCode == '9')
			//{
	  		var To   = $(this).val();
			var Re = Math.round(To * 0.1);
			var Li = Math.round(To - Re);
			$("#Retencion").val(Re);
			$("#Liquido").val(Li);
			return 0;
			//}
	});
	$("#Liquido").bind('keydown', function(event)
	{
		//alert(event.keyCode);
		if (event.keyCode == '9')
			{
	  		var Li   = $(this).val();
			var To = Math.round(Li / 0.9);
			var Re = Math.round(To * 0.1);
			$("#Retencion").val(Re);
			$("#Total").val(To);
			$("#Total").focus();
			return 0;
			}
	});

});
</script>


</head>

<body onLoad="document.form.SueldoBase.focus()">
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<form name="form" action="cFacturas.php" method="post">

		
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<img src="../gastos/imagenes/subst_student.png" width="28" height="28" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; ">
					<?php
					if($RutProv){
						echo 'Factura  - '.$Proveedor.' - Periodo <span id="BoxPeriodo">'.$Periodo.'</span>';
					}else{
						echo 'Factura <span id="BoxPeriodo">'.$Periodo.'</span>';
					}
					?>
				</strong>
				<?php include('barramenu.php'); ?>
				<div id="ImagenBarra">
					<a>
					<img src="../gastos/imagenes/r_x.png"  width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="CalculoFacturas.php" title="Volver">
						<img src="../gastos/imagenes/preview_back_32.png" width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a>
					<img src="../gastos/imagenes/r_x.png"  width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="sueldos.php" title="Principal">
						<img src="../gastos/imagenes/room_32.png" width="28" height="28">
					</a>
				</div>
				
			</div>
			<!-- Fin Caja Cuerpo -->
			<?php
				echo '<div align="center">';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td><strong style="font-size:14px;">Identificación del Proveedor</strong>';
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
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaId">';
				echo '		<tr>';
				echo '			<td width="15%">Rut Proveedor: </td>';
				echo '			<td width="45%">';
									if($RutProv){
										echo '<strong>'.$RutProv.'</stong>';
										echo '<input name="RutProv" 	type="hidden" size="10" maxlength="10" value="'.$RutProv.'">';
									}
				echo '				<input name="Proceso"  	type="hidden" value="'.$Proceso.'">';
				echo '				<input name="Periodo"  	type="hidden" value="'.$Periodo.'">';
				echo '			</td>';
				echo '			<td width="40%" rowspan="3" >';
									if($MsgUsr=="Ok"){
										echo '<div style="	color:#fff;
															background-color:#E8F188;
															margin:4px 1px 0px 5px;
															padding:10px;
															font-size:14px;
															font-family:Verdana, Arial, Helvetica, sans-serif;
															border: 1px solid #aaa;
															border-radius: 5px 5px 5px 5px;
															box-shadow: 0 0 3px #aaa;
															opacity:.5;
															">';
											echo '<a href="formularios/F7exento.php?RutProv='.$RutProv.'&nFactura='.$nFactura.'"><img src="../gastos/imagenes/pdf.png" width="32" height="32" title="Formulario 7: Solicitud de Pago de Factura"></a>';
										echo '</div';
									}else{
										echo '<div style="	color:#fff;
															background-color:#FF0000;
															margin:4px 1px 0px 5px;
															padding:10px;
															font-size:14px;
															font-family:Verdana, Arial, Helvetica, sans-serif;
															border: 1px solid #aaa;
															border-radius: 5px 5px 5px 5px;
															box-shadow: 0 0 3px #aaa;
															opacity:.5;
															">';
											echo $MsgUsr;
										echo '</div>';
									}
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Proveedor: </td>';
				echo '			<td>';
								if($RutProv){
									echo '<strong>'.$Proveedor.'</strong>';
								}else{
	  								echo '<select name="Proveedor" id="Proveedor" onChange="window.location = this.options[this.selectedIndex].value; return true;">';
									$link=Conectarse();
									$bdPh=mysql_query("SELECT * FROM Proveedores");
									if ($row=mysql_fetch_array($bdPh)){
										DO{
			    							if($Prov == $row['RutProv']){
												echo "		<option selected 	value='cFacturas.php?Proceso=".$Proceso."&RutProv=".$row['RutProv']."'>".$row['Proveedor']."</option>";
											}else{
			    								if($Prov == ""){
													$Prov = "X";
													echo "	<option selected></option>";
												}
												echo "	<option  			value='cFacturas.php?Proceso=".$Proceso."&RutProv=".$row['RutProv']."'>".$row['Proveedor']."</option>";
											}
										}WHILE ($row=mysql_fetch_array($bdPh));
									}
									mysql_close($link);
									echo '</select>';
/*									echo '<input name="Paterno" 	type="text" size="50" maxlength="50" value="'.$Paterno.'"><br>';
									echo '<input name="Materno" 	type="text" size="50" maxlength="50" value="'.$Materno.'"><br>';
									echo '<input name="Nombres" 	type="text" size="50" maxlength="50" value="'.$Nombres.'">';
*/
								}
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Profesion/Oficio </td>';
				echo '			<td>';
									if($ProfesionOficio){
										echo $ProfesionOficio;
									}else{
										echo '<input name="ProfesionOficio" 	type="text" size="50" maxlength="50" value="'.$ProfesionOficio.'"><br>';
									}
				echo '			</td>';
				echo '		</tr>';
				echo '</table>';

				if($RutProv){

					echo '<div align="center">';
					echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
					echo '		<tr>';
					echo '			<td><strong style="font-size:14px;">Descripción del Servicio</strong>';
					echo '			</td>';
					echo '		</tr>';
					echo '	</table>';
					echo '<div id="RegistroFactura">';
					echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaDocumentos">';
					echo '		<tr>';
					echo '			<td width="15%">Proyecto: </td>';
					echo '			<td>';
										// <!-- Fitra por Proyecto -->
		  								echo '<select name="Proyecto" id="Proyecto">';
													$link=Conectarse();
													$bdPr=mysql_query("SELECT * FROM Proyectos");
													if ($row=mysql_fetch_array($bdPr)){
														DO{
						    								if($Proyecto == $row['IdProyecto']){
																echo "<option selected 	value='".$row['IdProyecto']."'>".$row['IdProyecto']."</option>";
															}else{
																echo "	<option 		value='".$row['IdProyecto']."'>".$row['IdProyecto']."</option>";
															}
														}WHILE ($row=mysql_fetch_array($bdPr));
													}
													mysql_close($link);
										echo '</select>';
					echo '			</td>';
					echo '			<td>Tipo Costo: </td>';
					echo '			<td>';
		  			echo '				<select name="TpCosto" id="TpCosto">';
						    				if($TpCosto == "I"){
												echo "<option selected 	value='I'>Inversión</option>";
												echo "<option  			value='E'>Esporadico</option>";
												echo "<option  			value='M'>Mensual</option>";
											}
						    				if($TpCosto == "E"){
												echo "<option  			value='I'>Inversión</option>";
												echo "<option selected	value='E'>Esporadico</option>";
												echo "<option  			value='M'>Mensual</option>";
											}
						    				if($TpCosto == "M"){
												echo "<option  			value='I'>Inversión</option>";
												echo "<option 			value='E'>Esporadico</option>";
												echo "<option  selectd	value='M'>Mensual</option>";
											}
						    				if($TpCosto == ""){
												echo "<option  selected></option>";
												echo "<option  			value='I'>Inversión</option>";
												echo "<option 			value='E'>Esporadico</option>";
												echo "<option  			value='M'>Mensual</option>";
											}
					echo '				</select>';
					echo '			</td>';
					echo '		</tr>';
					echo '		<tr>';
					echo '			<td>Función/Cargo: </td>';
					echo '			<td>';
										if($Cargo) { $FuncionCargo = $Cargo; }
					echo '				<input name="FuncionCargo"  	type="text" size="50" maxlength="50" value="'.$FuncionCargo.'">';
					echo '			</td>';
					echo '			<td>Lugar de Trabajo: </td>';
					echo '			<td>';
					echo '				<input name="LugarTrabajo"  	type="text" size="50" maxlength="50" value="'.$LugarTrabajo.'">';
					echo '			</td>';
					echo '		</tr>';
					echo '</table>';
				

					echo '<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
					echo '		<tr>';
					echo '			<td><strong style="font-size:14px;">Detalle Factura - Prestación de Servicio</strong></td>';
					echo '		</tr>';
					echo '</table>';
					echo '<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaId" style="background-color:#E8F188;">';
					echo '		<tr style="font-size:16px;">';
					echo '			<td>Número</td>';
					echo '			<td colspan="2" align="center">Periodo en que se desarrolla el Servicio </td>';
					echo '			<td>Estado</td>';
					echo '			<td>Fecha Firma Contrato</td>';
					echo '			<td>Imprimir</td>';
					echo '		</tr>';
					echo '		<tr>';
					echo '			<td>Factura</td>';
					echo '			<td align="center">Fecha Inicio</td>';
					echo '			<td align="center">Fecha Termino</td>';
					echo '			<td>&nbsp;</td>';
					echo '			<td>&nbsp;</td>';
					echo '			<td>Contrato</td>';
					echo '		</tr>';
					echo '		<tr>';
					echo '			<td>';
										echo '<input name="nFactura" 	type="text" size="3" maxlength="3" value="'.$nFactura.'"><br>';
					echo '			</td>';
					echo '			<td  align="center">';
										if($SueldoBase){
											$fd 	= explode('-', date('Y-m-d'));
											$PerIniServ = $fd[0].'-'.$fd[1].'-01';
										}
					echo '				<input name="PerIniServ"  	type="date" size="50" maxlength="50" value="'.$PerIniServ.'">';
					echo '			</td>';
					echo '			<td  align="center">';
										if($SueldoBase){
											$fd 	= explode('-', date('Y-m-d'));
											if(intval($fd[1])==1 || intval($fd[1])==3 || intval($fd[1])==5 || intval($fd[1])==7 || intval($fd[1])==8 || intval($fd[1])==10 || intval($fd[1])==12){
												$f = '31';
											}											
											if(intval($fd[1])==4 || intval($fd[1])==6 || intval($fd[1])==9 || intval($fd[1])==11){
												$f = '30';
											}
											if(intval($fd[1])==2){
												$f = '28';
												$d = intval($fd[0]);
												if( (intval($d/4)*4) == $d ){
													$f = '29';
												}
											}
											$PerTerServ = $fd[0].'-'.$fd[1].'-'.$f;
										}
					echo '				<input name="PerTerServ"  	type="date" size="50" maxlength="50" value="'.$PerTerServ.'">';
					echo '			</td>';
					echo '			<td align="center">';
										if($Estado=='P'){
											echo '<img src="../gastos/imagenes/Confirmation_32.png" width="32" height="32" title="Informado">';
										}else{
											echo '<img src="../gastos/imagenes/no_32.png" width="32" height="32" title="Contrato Pendiente de Firma">';
										}
					echo '			</td>';
					echo '			<td>';
					echo '				<input name="FechaPago" id="FechaPago"		type="date" size="10" maxlength="10" value="'.$FechaPago.'">';
					echo '			</td>';
					echo '			<td align="center">';
										if($FechaPago){
											echo '<a href="formularios/contrato.php?Run='.$Run.'&nBoleta='.$nBoleta.'"><img src="../gastos/imagenes/pdf.png" width="32" height="32" title="Imprimir Contrato"></a>';
										}else{
											echo '&nbsp;';
										}
					echo '			</td>';
					echo '		</tr>';
					echo '</table>';
					echo '<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaDocumentos">';
					echo '		<tr>';
					echo '			<td>N° </td>';
					echo '			<td>Descripción </td>';
					echo '			<td>Bruto </td>';
					echo '		</tr>';
					echo '		<tr>';
					echo '			<td>';
					echo 				$nLinea;
					echo '				<input name="nLinea" id="nLinea"	type="hidden" 	size="3" maxlength="3" value="'.$nLinea.'">';
					echo '			</td>';
					echo '			<td>';
										//if($ServicioIntExt=="I"){
										//	$Descripcion = $FuncionCargo;
										//}
					echo '				<input name="Descripcion" id="Descripcion"	type="text" 	size="50" maxlength="50" value="'.$Descripcion.'">';
					echo '			</td>';
					echo '			<td>';
					echo '				<input name="Bruto" 	id="Bruto"	type="text" size="11" maxlength="11" value="'.$Bruto.'">';
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

