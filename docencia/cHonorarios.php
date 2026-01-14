<?php
	session_start();
	$_SESSION['Grabado'] = "NO";
	$MsgUsr ="Despues de registrar e ingresar todos los datos de la Boleta se podrá IMPRIMIR CONTRATO...";	
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
	$TipoContrato		= "";
	$TpCosto			= "";
	$FechaContrato		= date('Y-m-d');
	$TerminoContrato	= date('Y-m-d');
	$ServicioIntExt		= "";
	$SueldoBase			= "";
	$PeriodoPago		= "M";
	$Banco				= "";
	$nCuenta			= "";
	$Fonos				= "";
	$Celular			= "";
	$Email				= "";
	$Estado				= "";
	$FechaPago			= "";
	$Prestador			= "";
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
		echo $Periodo;
	}else{
		$Mm = $Mes[ intval($fd[1]) ];
		$Periodo = $fd[1].".".$fd[0];
	}


	if($_GET['Proceso']) 	{ $Proceso  	= $_GET['Proceso']; 	}
	if($_GET['Run']) 		{ $Run  		= $_GET['Run']; $Prestador = $_GET['Run']; }
	if($_GET['Periodo']) 	{ $Periodo  	= $_GET['Periodo']; 	}
	if($_GET['nBoleta']) 	{ $nBoleta  	= $_GET['nBoleta']; 	}
	if($_GET['FechaPago']) 	{ $FechaPago  	= $_GET['FechaPago']; 	}

	if($_POST['Run'])		{ $Run  		= $_POST['Run']		; }else{ $TxtErr  = "Rut"; 				}
	if($_POST['Periodo']) 	{ $Periodo  	= $_POST['Periodo']	; }else{ $TxtErr .= ",Periodo"; 			}
	if($_POST['nBoleta']) 	{ $nBoleta  	= $_POST['nBoleta']	; }else{ $TxtErr .= ",Boleta"; 			}

	$m = substr($Periodo,0,2);
	$Mm = $Mes[ intval($m) ];
	$pPago = $Mm.'.'.$fd[0];

	if($Run){
		$link=Conectarse();
		$bdProv=mysql_query("SELECT * FROM PersonalHonorarios WHERE Run = '".$Run."'");
		if ($row=mysql_fetch_array($bdProv)){
   			$Paterno 			= $row['Paterno'];
   			$Materno 			= $row['Materno'];
   			$Nombres 			= $row['Nombres'];
			$Cargo				= $row['Cargo'];
			$FuncionCargo		= $row['FuncionCargo'];
			$LugarTrabajo		= $row['LugarTrabajo'];
			$TipoContrato		= $row['TipoContrato'];
			$TpCosto			= $row['PeriodoPago'];
			$FechaContrato		= $row['FechaContrato'];
			$TerminoContrato	= $row['TerminoContrato'];
			$ServicioIntExt		= $row['ServicioIntExt'];
			$ProfesionOficio	= $row['ProfesionOficio'];
			$Liquido			= $row['SueldoBase'];		/* Liquido */
			$Banco				= $row['Banco'];
			$nCuenta			= $row['nCuenta'];
			$Fonos				= $row['Fonos'];
			$Celular			= $row['Celular'];
			$Email				= $row['Email'];
			$Estado				= $row['Estado'];
		}
		$bdH=mysql_query("SELECT * FROM Honorarios WHERE Run = '".$Run."' && PeriodoPago = '".$Periodo."' && nBoleta = '".$nBoleta."'");
		if ($rowH=mysql_fetch_array($bdH)){
   			$nLinea 		= $rowH['nLinea'];
   			$Descripcion 	= $rowH['Descripcion'];
   			$Total 			= $rowH['Total'];
   			$Retencion 		= $rowH['Retencion'];
   			$Liquido 		= $rowH['Liquido'];
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

	
	if($_POST['Run'])			{ $Run  		= $_POST['Run']			; }else{ $TxtErr = "Rut"; 				}
	if($_POST['Periodo']) 		{ $Periodo  	= $_POST['Periodo']		; }else{ $TxtErr .= ",Periodo"; 			}
	if($_POST['nBoleta']) 		{ $nBoleta  	= $_POST['nBoleta']		; }else{ $TxtErr .= ",Boleta"; 			}
	if($_POST['Proyecto']) 		{ $Proyecto  	= $_POST['Proyecto']	; }else{ $TxtErr .= ",Proyecto"; 		}
	if($_POST['PerIniServ'])	{ $PerIniServ  	= $_POST['PerIniServ']	; }else{ $TxtErr .= ",Periodo Inicio"; 	}
	if($_POST['PerTerServ'])	{ $PerTerServ  	= $_POST['PerTerServ']	; }else{ $TxtErr .= ",Periodo Termino"; 	}
	if($_POST['LugarTrabajo'])	{ $LugarTrabajo	= $_POST['LugarTrabajo']; }else{ $TxtErr .= ",Lugar de Trabajo"; }
	if($_POST['FuncionCargo'])	{ $FuncionCargo	= $_POST['FuncionCargo']; }else{ $TxtErr .= ",Función"; 			}
	if($_POST['Descripcion'])	{ $Descripcion	= $_POST['Descripcion']	; }else{ $TxtErr .= ",Descripcion"; 		}
	if($_POST['Total'])			{ $Total		= $_POST['Total']		; }else{ $TxtErr .= ",Total"; 			}
	if($_POST['Retencion'])		{ $Retencion	= $_POST['Retencion']	; }else{ $TxtErr .= ",Retencion"; 		}
	if($_POST['Liquido'])		{ $Liquido		= $_POST['Liquido']		; }else{ $TxtErr .= ",Liquido"; 			}
	if($_POST['TpCosto'])		{ $TpCosto		= $_POST['TpCosto']		; }else{ $TxtErr .= ",Tipo Costo"; 		}

	if(isset($_POST['Proceso'])){ 
		$Proceso 	= $_POST['Proceso'];
		if(isset($_POST['Total'])){
			if(isset($_POST['Retencion'])){
				if(isset($_POST['Liquido'])){
					if(isset($_POST['Run'])){
						if(isset($_POST['nBoleta'])){
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
		}
	}
	
	if($sw == true){
		$sw = false;
		
		if($Proceso == 1 || $Proceso == 2 || $Proceso == 3){ /* Agregar */
			$link=Conectarse();
			$bdProv=mysql_query("SELECT * FROM Honorarios WHERE Run = '".$Run."' && PeriodoPago = '".$Periodo."' && nBoleta = '".$nBoleta."'");
			//$bdProv=mysql_query("SELECT * FROM Honorarios WHERE Run = '".$Run."' && PeriodoPago = '".$Periodo."'");
			if ($row=mysql_fetch_array($bdProv)){
				if($Proceso == 2){
	   				$MsgUsr = 'Ok';
					$link=Conectarse();
					$bdHon=mysql_query("SELECT * FROM Honorarios WHERE Run = '".$Run."' && PeriodoPago = '".$Periodo."' && nBoleta = '".$nBoleta."'");
					if ($rowHon=mysql_fetch_array($bdHon)){
						$TotalOld		= $rowHon['Total'];
						$RetencionOld	= $rowHon['Retencion'];
						$LiquidoOld		= $rowHon['Liquido'];
						
						$nInforme 		= $rowHon['nInforme'];
						$Total			= round(($Liquido/0.9),0);
						$Retencion 		= round(($Total * 0.1),0);
						$actSQL="UPDATE Honorarios SET ";
						$actSQL.="TpCosto		='".$TpCosto."',";
						$actSQL.="FuncionCargo	='".$FuncionCargo."',";
						$actSQL.="LugarTrabajo	='".$LugarTrabajo."',";
						$actSQL.="IdProyecto	='".$Proyecto."',";
						$actSQL.="nBoleta		='".$nBoleta."',";
						$actSQL.="PerIniServ	='".$PerIniServ."',";
						$actSQL.="PerTerServ	='".$PerTerServ."',";
						$actSQL.="Descripcion	='".$Descripcion."',";
						$actSQL.="Total			='".$Total."',";
						$actSQL.="Retencion		='".$Retencion."',";
						$actSQL.="Liquido		='".$Liquido."'";
						$actSQL.="WHERE Run		= '".$Run."' && PeriodoPago = '".$Periodo."' && nBoleta = '".$nBoleta."'";
						$bdHon=mysql_query($actSQL);
					}
					if($nInforme){
						$bdForm=mysql_query("SELECT * FROM Formularios WHERE nInforme = '".$nInforme."' && Formulario = 'F5'");
						if ($rowForm=mysql_fetch_array($bdForm)){
							$TotOld = ($rowForm['Total'] 		- $TotalOld) 		+ $Total;
							$RetOld = ($rowForm['Retencion'] 	- $RetencionOld) 	+ $Retencion;
							$LiqOld = ($rowForm['Liquido'] 		- $LiquidoOld) 		+ $Liquido;

							$actSQL="UPDATE Formularios SET ";
							$actSQL.="Total				='".$TotOld."',";
							$actSQL.="Retencion			='".$RetOld."',";
							$actSQL.="Liquido			='".$LiqOld."'";
							$actSQL.="WHERE  nInforme 	= '".$nInforme."' && Formulario = 'F5'";
							$bdForm=mysql_query($actSQL);
							
						}
					}
					$bdPer=mysql_query("SELECT * FROM PersonalHonorarios WHERE Run = '".$Run."'");
					if ($rowPer=mysql_fetch_array($bdPer)){
						if($rowPer['ServicioIntExt']=="I"){
							$actSQL="UPDATE PersonalHonorarios SET ";
							$actSQL.="SueldoBase	='".$Liquido."'";
							$actSQL.="WHERE Run		= '".$Run."'";
							$bdPer=mysql_query($actSQL);
						}
					}
					header("Location: CalculoHonorarios.php?Mm=".$Mm);
					//header("Location: CalculoHonorarios.php");
				}
				if($Proceso == 3){
					$bdHon=mysql_query("SELECT * FROM Honorarios WHERE Run = '".$Run."' && PeriodoPago = '".$Periodo."' && nBoleta = '".$nBoleta."'");
					if ($rowHon=mysql_fetch_array($bdHon)){
						$nInforme 	= $rowHon['nInforme'];
						$Total 		= $rowHon['Total'];
						$Retencion	= $rowHon['Retencion'];
						$Liquido	= $rowHon['Liquido'];
						$bdProv=mysql_query("DELETE FROM Honorarios WHERE Run = '".$Run."' && PeriodoPago = '".$Periodo."' && nBoleta = '".$nBoleta."'");
						if($nInforme){
							$bdForm=mysql_query("SELECT * FROM Formularios WHERE nInforme = '".$nInforme."' && Formulario = 'F5'");
							if ($rowForm=mysql_fetch_array($bdForm)){
								$nDocumentos 	= $rowForm['nDocumentos'] - 1;
								if($nDocumentos>0){
									$TotAct	= $rowForm['Total'] 	- $Total;
									$RetAct	= $rowForm['Retencion'] - $Retencion;
									$LiqAct	= $rowForm['Liquido'] 	- $Liquido;
									$actSQL="UPDATE Formularios SET ";
									$actSQL.="nDocumentos		='".$nDocumentos."',";
									$actSQL.="Total				='".$TotAct."',";
									$actSQL.="Retencion			='".$RetAct."',";
									$actSQL.="Liquido			='".$LiqAct."'";
									$actSQL.="WHERE  nInforme 	= '".$nInforme."' && Formulario = 'F5'";
									$bdForm=mysql_query($actSQL);
								}else{
									$bdProv=mysql_query("DELETE FROM Formularios WHERE nInforme = '".$nInforme."' && Formulario = 'F5'");
								}
							}
						}
					}
					mysql_close($link);
					header("Location: CalculoHonorarios.php?Mm=".$Mm);
				}
			}else{
				$Total		= round(($Liquido/0.9),0);
				$Retencion 	= round(($Total * 0.1),0);
				mysql_query("insert into Honorarios(
														Run,
														PeriodoPago,
														nBoleta,
														nLinea,
														IdProyecto,
														PerIniServ,
														PerTerServ,
														LugarTrabajo,
														FuncionCargo,
														Descripcion,
														Total,
														Retencion,
														Liquido,
														TpCosto
														) 
										values 		(	
														'$Run',
														'$Periodo',
														'$nBoleta',
														'$nLinea',
														'$Proyecto',
														'$PerIniServ',
														'$PerTerServ',
														'$LugarTrabajo',
														'$FuncionCargo',
														'$Descripcion',
														'$Total',
														'$Retencion',
														'$Liquido',
														'$TpCosto'
														)",$link);
				header("Location: CalculoHonorarios.php?Mm=".$Mm);
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
<title>Módulo de Sueldos</title>

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
		<form name="form" action="cHonorarios.php" method="post">

		
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<img src="../gastos/imagenes/subst_student.png" width="28" height="28" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; ">
					<?php
					if($Run){
						echo 'Cálculo de Honorarios - '.$Nombres.' '.$Paterno.' - <span id="BoxPeriodo">'.$pPago.'</span>';
					}else{
						echo 'Cálculo de Honorarios <span id="BoxPeriodo">'.$pPago.'</span>';
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
					<a href="CalculoHonorarios.php" title="Volver">
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
				echo '			<td><strong style="font-size:14px;">Individualización Prestador de Servicio</strong>';
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
				echo '			<td width="15%">Rut: </td>';
				echo '			<td width="45%">';
									if($Run){
										echo '<strong>'.$Run.'</stong>';
										echo '<input name="Run" 	type="hidden" size="10" maxlength="10" value="'.$Run.'">';
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
											echo '<a href="formularios/contrato.php?Run='.$Run.'&nBoleta='.$nBoleta.'"><img src="../gastos/imagenes/pdf.png" width="32" height="32" title="Imprimir Contrato"></a>';
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
				echo '			<td>Prestador: </td>';
				echo '			<td>';
								if($Run){
									echo '<strong>'.$Paterno.' '.$Materno.' '.$Nombres.'</strong>';
								}else{
	  								echo '<select name="Prestador" id="Prestador" onChange="window.location = this.options[this.selectedIndex].value; return true;">';
									$link=Conectarse();
									$bdPh=mysql_query("SELECT * FROM PersonalHonorarios");
									if ($row=mysql_fetch_array($bdPh)){
										DO{
			    							if($Prestador == $row['Run']){
												echo "		<option selected 	value='cHonorarios.php?Proceso=".$Proceso."&Run=".$row['Run']."&Periodo=".$Periodo."'>".$row['Paterno'].' '.$row['Materno'].' '.$row['Materno']."</option>";
											}else{
			    								if($Prestador == ""){
													$Prestador = "X";
													echo "	<option selected></option>";
												}
												echo "	<option  			value='cHonorarios.php?Proceso=".$Proceso."&Run=".$row['Run']."&Periodo=".$Periodo."'>".$row['Paterno'].' '.$row['Materno'].' '.$row['Materno']."</option>";
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

				if($Run){

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
					echo '			<td>Tipo de Costo: </td>';
					echo '			<td>';

		  			echo '				<select name="TpCosto" id="TpCosto">';
						    					if($TpCosto == 'M'){
													echo "<option  			value='I'>Inversión</option>";
													echo "<option 			value='E'>Esporadico</option>";
													echo "<option  selected	value='M'>Mensual</option>";
												}
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
					echo '			<td><strong style="font-size:14px;">Detalle Boleta de Honorarios - Prestación de Servicio</strong></td>';
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
					echo '			<td>Boleta</td>';
					echo '			<td align="center">Fecha Inicio</td>';
					echo '			<td align="center">Fecha Termino</td>';
					echo '			<td>&nbsp;</td>';
					echo '			<td>&nbsp;</td>';
					echo '			<td>Contrato</td>';
					echo '		</tr>';
					echo '		<tr>';
					echo '			<td>';
										echo '<input name="nBoleta" 	type="text" size="3" maxlength="3" value="'.$nBoleta.'"><br>';
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
					echo '			<td>Total </td>';
					echo '			<td>Retención </td>';
					echo '			<td>Liquido </td>';
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
					echo '				<input name="Descripcion" id="Descripcion"	type="text" 	size="80" maxlength="80" value="'.$Descripcion.'">';
					echo '			</td>';
					echo '			<td>';
										$Total		= round(($Liquido/0.9),0);
										$Retencion 	= round(($Total * 0.1),0);
					echo '				<input name="Total" 	id="Total"		type="text" size="11" maxlength="11" value="'.$Total.'">';
					echo '			</td>';
					echo '			<td>';
					echo '				<input name="Retencion" id="Retencion"	type="text" size="11" maxlength="11" value="'.$Retencion.'">';
					echo '			</td>';
					echo '			<td>';
					echo '				<input name="Liquido" 	id="Liquido"	type="text" size="11" maxlength="11" value="'.$Liquido.'">';
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

