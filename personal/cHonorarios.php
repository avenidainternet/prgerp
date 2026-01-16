<?php
	session_start();
	date_default_timezone_set("America/Santiago");
	$_SESSION['Grabado'] = "NO";
	$MsgUsr ="Despues de registrar e ingresar todos los datos de la Boleta se podrá IMPRIMIR CONTRATO...";	
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
	$fechaContrato		= date('Y-m-d');
	$FechaContrato		= date('Y-m-d');
	$fechaContratoB		= date('Y-m-d');
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
	$nBoleta			= '';
	$Proyecto			= '';
	$PerIniServ 		= date('Y-m-d');
	$PerTerServ 		= date('Y-m-d');
	$fechaInforme 		= date('Y-m-d');
	$Descripcion		= '';
	$actRealizada		= '';
	$Liquido			= 0;
								$Total = 0;
								$Retencion = 0;
								$Liquido = 0;
	  

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


	if(isset($_GET['Proceso'])) 	{ $Proceso  	= $_GET['Proceso']; 	}
	if(isset($_GET['Run'])) 		{ $Run  		= $_GET['Run']; $Prestador = $_GET['Run']; }
	if(isset($_GET['Periodo'])) 	{ $Periodo  	= $_GET['Periodo']; 	}
	if(isset($_GET['nBoleta'])) 	{ $nBoleta  	= $_GET['nBoleta']; 	}
	if(isset($_GET['FechaPago'])) 	{ $FechaPago  	= $_GET['FechaPago']; 	}

	if(isset($_POST['Run']))		{ $Run  		= $_POST['Run']		; }else{ $TxtErr  = "Rut"; 				}
	if(isset($_POST['Periodo'])) 	{ $Periodo  	= $_POST['Periodo']	; }else{ $TxtErr .= ",Periodo"; 			}
	if(isset($_POST['nBoleta'])) 	{ $nBoleta  	= $_POST['nBoleta']	; }else{ $TxtErr .= ",Boleta"; 			}

	$m = substr($Periodo,0,2);
	$Mm = $Mes[ intval($m) ];
	$pPago = $Mm.'.'.$fd[0];

	$sw = false;
	$TxtErr = "";
	if(isset($_POST['Proceso']))		{ $Proceso 		= $_POST['Proceso']		; }

	
	if(isset($_POST['Run']))			{ $Run  		= $_POST['Run']				; }else{ $TxtErr = "Rut"; 					}
	if(isset($_POST['Periodo'])) 		{ $Periodo  	= $_POST['Periodo']			; }else{ $TxtErr .= ",Periodo"; 			}
	if(isset($_POST['nBoleta'])) 		{ $nBoleta  	= $_POST['nBoleta']			; }else{ $TxtErr .= ",Boleta"; 				}
	if(isset($_POST['Proyecto'])) 		{ $Proyecto  	= $_POST['Proyecto']		; }else{ $TxtErr .= ",Proyecto"; 			}
	if(isset($_POST['fechaContrato']))	{ $fechaContrato= $_POST['fechaContrato']	; }else{ $TxtErr .= ",Fecha de Contrato"; 	}
	if(isset($_POST['fechaInforme']))	{ $fechaInforme	= $_POST['fechaInforme']	; }else{ $TxtErr .= ",Fecha de Informe"; 	}
	if(isset($_POST['PerIniServ']))		{ $PerIniServ  	= $_POST['PerIniServ']		; }else{ $TxtErr .= ",Periodo Inicio"; 		}
	if(isset($_POST['PerTerServ']))		{ $PerTerServ  	= $_POST['PerTerServ']		; }else{ $TxtErr .= ",Periodo Termino"; 	}
	if(isset($_POST['LugarTrabajo']))	{ $LugarTrabajo	= $_POST['LugarTrabajo']	; }else{ $TxtErr .= ",Lugar de Trabajo"; 	}
	if(isset($_POST['FuncionCargo']))	{ $FuncionCargo	= $_POST['FuncionCargo']	; }else{ $TxtErr .= ",FunciÃ³n"; 			}
	if(isset($_POST['Descripcion']))	{ $Descripcion	= $_POST['Descripcion']		; }else{ $TxtErr .= ",DescripciÃ³n"; 		}
	if(isset($_POST['Total']))			{ $Total		= $_POST['Total']			; }else{ $TxtErr .= ",Total"; 				}
	if(isset($_POST['Retencion']))		{ $Retencion	= $_POST['Retencion']		; }else{ $TxtErr .= ",Retencion"; 			}
	if(isset($_POST['Liquido']))		{ $Liquido		= $_POST['Liquido']			; }else{ $TxtErr .= ",Liquido"; 			}
	if(isset($_POST['TpCosto']))		{ $TpCosto		= $_POST['TpCosto']			; }else{ $TxtErr .= ",Tipo Costo"; 			}

	if(isset($_POST['actRealizada']))	{ $actRealizada	= $_POST['actRealizada']; }else{ $TxtErr .= ",Actividades"; 		}
	
	if(isset($_POST['Eliminar'])){ 
		echo 'Entra a Eliminar...';
		$link=Conectarse();
					$bdHon=$link->query("SELECT * FROM Honorarios WHERE IdProyecto = '".$Proyecto."' and Run = '".$Run."' && PeriodoPago = '".$Periodo."' && nBoleta = '".$nBoleta."'");
					if ($rowHon=mysqli_fetch_array($bdHon)){
						$nInforme 	= $rowHon['nInforme'];
						$Total 		= $rowHon['Total'];
						$Retencion	= $rowHon['Retencion'];
						$Liquido	= $rowHon['Liquido'];
						$bdProv=$link->query("DELETE FROM Honorarios WHERE IdProyecto = '".$Proyecto."' and Run = '".$Run."' && PeriodoPago = '".$Periodo."' && nBoleta = '".$nBoleta."'");
						if($nInforme){
							$bdForm=$link->query("SELECT * FROM Formularios WHERE nInforme = '".$nInforme."' && Formulario = 'F5'");
							if ($rowForm=mysqli_fetch_array($bdForm)){
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
									$bdForm=$link->query($actSQL);
								}else{
									$bdProv=$link->query("DELETE FROM Formularios WHERE nInforme = '".$nInforme."' && Formulario = 'F5'");
								}
							}
						}
					}
		$link->close();
		header("Location: CalculoHonorarios.php?Mm=".$Mm);
	}
	
	if(isset($_POST['Grabar'])){ 
		$sw = false;
		
		if($Proceso == 1 || $Proceso == 2 || $Proceso == 3){ /* Agregar */
			$link=Conectarse();
			$bdProv=$link->query("SELECT * FROM Honorarios WHERE IdProyecto = '".$Proyecto."' and Run = '".$Run."' and PeriodoPago = '".$Periodo."' and nBoleta = '".$nBoleta."'");
			if ($row=mysqli_fetch_array($bdProv)){
				if($Proceso == 2){
	   				$MsgUsr = 'Ok';
					$link=Conectarse();
					$bdHon=$link->query("SELECT * FROM Honorarios WHERE IdProyecto = '".$Proyecto."' and Run = '".$Run."' && PeriodoPago = '".$Periodo."' && nBoleta = '".$nBoleta."'");
					if ($rowHon=mysqli_fetch_array($bdHon)){
						$TotalOld		= $rowHon['Total'];
						$RetencionOld	= $rowHon['Retencion'];
						$LiquidoOld		= $rowHon['Liquido'];
/*						
						$nInforme 		= $rowHon['nInforme'];
						$Retencion 		= round(($Total * 0.115),0);
						$Liquido		= $Total - $Retencion;
*/						
						$actSQL="UPDATE Honorarios SET ";
						$actSQL.="TpCosto		='".$TpCosto.		"',";
						$actSQL.="FuncionCargo	='".$FuncionCargo.	"',";
						$actSQL.="LugarTrabajo	='".$LugarTrabajo.	"',";
						$actSQL.="IdProyecto	='".$Proyecto.		"',";
						$actSQL.="nBoleta		='".$nBoleta.		"',";
						$actSQL.="fechaContrato	='".$fechaContrato.	"',";
						$actSQL.="fechaInforme	='".$fechaInforme.	"',";
						$actSQL.="PerIniServ	='".$PerIniServ.	"',";
						$actSQL.="PerTerServ	='".$PerTerServ.	"',";
						$actSQL.="Descripcion	='".$Descripcion.	"',";
						$actSQL.="actRealizada	='".$actRealizada.	"',";
						$actSQL.="Total			='".$Total.			"',";
						$actSQL.="Retencion		='".$Retencion.		"',";
						$actSQL.="Liquido		='".$Liquido.		"'";
						$actSQL.="WHERE Run		= '".$Run."' and PeriodoPago = '".$Periodo."' and nBoleta = '".$nBoleta."'";
						$bdHon=$link->query($actSQL);
					}
					if($nInforme){
						$bdForm=$link->query("SELECT * FROM Formularios WHERE nInforme = '".$nInforme."' && Formulario = 'F5'");
						if ($rowForm=mysqli_fetch_array($bdForm)){
							$TotOld = ($rowForm['Total'] 		- $TotalOld) 		+ $Total;
							$RetOld = ($rowForm['Retencion'] 	- $RetencionOld) 	+ $Retencion;
							$LiqOld = ($rowForm['Liquido'] 		- $LiquidoOld) 		+ $Liquido;

							$actSQL="UPDATE Formularios SET ";
							$actSQL.="Total				='".$TotOld."',";
							$actSQL.="Retencion			='".$RetOld."',";
							$actSQL.="Liquido			='".$LiqOld."'";
							$actSQL.="WHERE  nInforme 	= '".$nInforme."' && Formulario = 'F5'";
							$bdForm=$link->query($actSQL);
							
						}
					}
					$bdPer=$link->query("SELECT * FROM PersonalHonorarios WHERE Run = '".$Run."'");
					if ($rowPer=mysqli_fetch_array($bdPer)){
						if($rowPer['ServicioIntExt']=="I"){
							$actSQL="UPDATE PersonalHonorarios SET ";
							$actSQL.="SueldoBase	='".$Liquido."'";
							$actSQL.="WHERE Run		= '".$Run."'";
							$bdPer=$link->query($actSQL);
						}
					}
					header("Location: CalculoHonorarios.php?Mm=".$Mm);
				}
			}else{
				/*
				$Total		= round(($Liquido/0.9),0);
				$Retencion 	= round(($Total * 0.1),0);
				*/
				$link->query("insert into Honorarios(
														Run,
														PeriodoPago,
														nBoleta,
														nLinea,
														IdProyecto,
														fechaContrato,
														fechaInforme,
														PerIniServ,
														PerTerServ,
														LugarTrabajo,
														FuncionCargo,
														Descripcion,
														actRealizada,
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
														'$fechaContrato',
														'$fechaInforme',
														'$PerIniServ',
														'$PerTerServ',
														'$LugarTrabajo',
														'$FuncionCargo',
														'$Descripcion',
														'$actRealizada',
														'$Total',
														'$Retencion',
														'$Liquido',
														'$TpCosto'
														)");
				header("Location: CalculoHonorarios.php?Mm=".$Mm);
   				$MsgUsr = 'Ok';
			}
			$link->close();
		}
	}
	$link=Conectarse();
	$bdProv=$link->query("SELECT * FROM PersonalHonorarios WHERE Run = '".$Run."'");
	if ($row=mysqli_fetch_array($bdProv)){
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

	
	$bdH=$link->query("SELECT * FROM Honorarios WHERE Run = '".$Run."' && PeriodoPago = '".$Periodo."' && nBoleta = '".$nBoleta."'");
	if ($rowH=mysqli_fetch_array($bdH)){
   			$nLinea 		= $rowH['nLinea'];
   			$Descripcion 	= $rowH['Descripcion'];
   			$Total 			= $rowH['Total'];
   			$Retencion 		= $rowH['Retencion'];
   			$Liquido 		= $rowH['Liquido'];
   			$Proyecto 		= $rowH['IdProyecto'];
   			$FechaPago 		= $rowH['FechaPago'];
   			$Estado 		= $rowH['Estado'];
			$LugarTrabajo	= $rowH['LugarTrabajo'];
   			$fechaContrato	= $rowH['fechaContrato'];
   			$fechaContratoB	= $rowH['fechaContrato'];
   			$fechaInforme	= $rowH['fechaInforme'];
			$PerIniServ		= $rowH['PerIniServ'];
			$PerTerServ		= $rowH['PerTerServ'];
			$FuncionCargo	= $rowH['FuncionCargo'];
			$TpCosto		= $rowH['TpCosto'];
			$Descipcion		= $rowH['Descripcion'];
			$actRealizada	= $rowH['actRealizada'];
			$MsgUsr = "Ok";
	}
	$link->close();
	
?>
<!doctype html>
 
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Módulo de Sueldos</title>
<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
<script type="text/javascript" src="../angular/angular.js"></script>

<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	font-family:Arial, Helvetica, sans-serif;
}
-->
</style>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<!-- <link rel="stylesheet" href="/resources/demos/style.css"> -->
<link href="styles.css" rel="stylesheet" type="text/css">

<script language="javascript" src="validaciones.js"></script> 
<script>
$(document).ready(function(){
		

	$("#fechaContrato").change(function()
	{
	  	var fc  = $(this).val();
			
		$("#PerIniServ").val(fc);
		$("#PerTerServ").val(fc);
		$("#fechaInforme").val(fc);
		$("#PerIniServ").focus();
		return 0;
	});

	$("#PerIniServ").change(function()
	{
	  	var ft  = $(this).val();
			
		$("#PerTerServ").val(ft);
		$("#fechaInforme").val(ft);
		$("#PerTerServ").focus();
		return 0;
	});

	$("#PerTerServ").change(function()
	{
	  	var ft  = $(this).val();
			
		$("#fechaInforme").val(ft);
		$("#fechaInforme").focus();
		return 0;
	});


});
</script>

<script>
	$(function() {
		$( "#datepicker" ).datepicker();
	});
</script>

</head>

<body ng-app="myApp" ng-controller="CtrlPersonal">
	<?php include_once('head.php'); ?>
	<div id="linea"></div>
	<div class="container-fluid">
		<form name="form" action="cHonorarios.php" method="post">
			<div class="row bg-primary text-white">
				<div class="col-md-11">
					<h2>
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
					</h2>
				</div>
				<div class="col-md-1">
						<?php include("barramenu.php"); ?>
				</div>
			</div>

			<div class="row bg-secondary text-white p-1">

				<div id="ImagenBarraLeft">
					<a href="../plataformaErp.php" title="Menú Principal">
						<img src="../gastos/imagenes/Menu.png"><br>
					</a>
					Principal
				</div>
				<div id="ImagenBarraLeft">
					<a href="personal.php" title="Personal">
						<img src="../gastos/imagenes/subst_student.png"><br>
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
			<div align="center">
				<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
					<tr>
						<td>
							<strong style="font-size:14px;">Individualización Prestador de Servicio</strong>
							<?php 
								if($Proceso == 1 or $Proceso == 2){?>
									<button name="Grabar">
										<img src="../gastos/imagenes/save_32.png" width="28">
									</button>
									<?php
								}
							?>
							<?php 
								if($Proceso == 3){?>
									<button name="Eliminar">
										<img src="../gastos/imagenes/inspektion.png" width="28">
									</button>
									<?php
								}
							?>
						</td>
					</tr>
				</table>
				<div>
					<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaId">
						<tr>
							<td width="15%">
								<?php if($Run){ ?>
										<strong><?php echo 'Run: '; ?></stong>
								<?php } ?>
							</td>
							<td width="45%">
								<?php if($Run){ ?>
										<strong><?php echo $Run; ?></stong>
								<?php } ?>
								<input name="Run" 		type="hidden" value="<?php echo $Run; ?>" />
								<input name="Proceso"  	type="hidden" value="<?php echo $Proceso; ?>">
								<input name="Periodo"  	type="hidden" value="<?php echo $Periodo; ?>">
							</td>
							<td width="40%" rowspan="3" >
							</td>
						</tr>
						<tr>
							<td>Prestador: </td>
							<td>
								<?php if($Run){?>
									<strong><?php echo $Paterno.' '.$Materno.' '.$Nombres; ?></strong>
								<?php }else{ ?>
									<select name="Prestador" id="Prestador" onChange="window.location = this.options[this.selectedIndex].value; return true;">
										<option></option>
										<?php
											$link=Conectarse();
											$bdPh=$link->query("SELECT * FROM PersonalHonorarios Where Estado = 'A' Order By Paterno");
											if($row=mysqli_fetch_array($bdPh)){
												do{?>
													<option value="cHonorarios.php?Proceso=<?php echo $Proceso; ?>&Run=<?php echo $row['Run']; ?>&Periodo=<?php echo $Periodo; ?>"><?php echo $row['Paterno'].' '.$row['Materno'].' '.$row['Nombres']; ?></option>
													<?php
												}while ($row=mysqli_fetch_array($bdPh));
											}
											$link->close();
										?>
									</select>
									<?php
									}
									?>
							</td>
						</tr>
						<?php if($Run){?>
							<tr>
								<td>Profesion/Oficio </td>
								<td><?php echo $ProfesionOficio; ?></td>
							</tr>
						<?php } ?>
					</table>
				<?php
				if($Run){?>
					<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
						<tr>
							<td>
								<strong style="font-size:14px;">Descripción del Servicio</strong>
							</td>
						</tr>
					</table>
					<table border="0" cellspacing="0" cellpadding="0" id="CajaDocumentos">
						<tr>
							<td width="15%">Proyecto: </td>
								<td>
										<!-- Fitra por Proyecto -->
										<select name="Proyecto" id="Proyecto">
											<?php
												$link=Conectarse();
												$bdPr=$link->query("SELECT * FROM Proyectos");
												if($row=mysqli_fetch_array($bdPr)){
													do{
						    							if($Proyecto == $row['IdProyecto']){
																echo "<option selected 	value='".$row['IdProyecto']."'>".$row['IdProyecto']."</option>";
															}else{
																echo "	<option 		value='".$row['IdProyecto']."'>".$row['IdProyecto']."</option>";
														}
													}while ($row=mysqli_fetch_array($bdPr));
												}
												$link->close();
											?>
										</select>
									</td>
									<td>Tipo de Costo: </td>
									<td>
										<select name="TpCosto" id="TpCosto">
											<option></option>
											<?php
						    					if($TpCosto == 'M'){?>
													<option  			value='I'>Inversión</option>
													<option 			value='E'>Esporadico</option>
													<option  selected	value='M'>Mensual</option>
											<?php } ?>
											<?php
						    					if($TpCosto == "I"){?>
													<option selected 	value='I'>Inversión</option>
													<option  			value='E'>Esporadico</option>
													<option  			value='M'>Mensual</option>
											<?php } ?>
											<?php 
						    					if($TpCosto == "E"){?>
													<option  			value='I'>Inversión</option>
													<option selected	value='E'>Esporadico</option>
													<option  			value='M'>Mensual</option>
											<?php } ?>
											<?php 
						    					if($TpCosto == ""){?>
													<option  			value='I'>Inversión</option>
													<option 			value='E'>Esporadico</option>
													<option  			value='M'>Mensual</option>
											<?php } ?>
										</select>
									</td>
								</tr>
							<tr>
								<td>Función/Cargo: </td>
								<td>
									<?php if($Cargo) { $FuncionCargo = $Cargo; } ?>
									<input name="FuncionCargo"  	type="text" size="50" maxlength="50" value="<?php echo $FuncionCargo; ?>">
								</td>
								<td>Lugar de Trabajo: </td>
								<td>
									<input name="LugarTrabajo"  	type="text" size="50" maxlength="50" value="<?php echo $LugarTrabajo; ?>">
								</td>
							</tr>
						</table>
					<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
						<tr>
							<td><strong style="font-size:14px;">Detalle Boleta de Honorarios - Prestación de Servicios</strong></td>
						</tr>
					</table>
					<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaId" style="background-color:#E8F188;">
						<tr style="font-size:16px;">
							<td rowspan="2" align="center">Número<br>Boleta</td>
							<td rowspan="2" align="center">Fecha <br> Contrato</td>
							<td colspan="2" align="center" height="40">Periodo de Prestaciones </td>
							<td rowspan="2">Estado</td>
							<td rowspan="2" align="center">Fecha <br>Informe</td>
							<td rowspan="2" align="center">Imprimir<br>Contrato</td>
							<td rowspan="2" align="center">Imprimir<br>Actividades</td>
						</tr>
						<tr>
							<td align="center"> Inicio</td>
							<td align="center"> Término</td>
						</tr>
						<tr>
							<td height="40" align="center">
								<input name="nBoleta" 	type="text" size="3" maxlength="3" value="<?php echo $nBoleta; ?>" required /><br>
							</td>
							<td align="center">
								<?php
									if($fechaContrato == '0000-00-00'){
										$fd 		= explode('-', date('Y-m-d'));
										$fechaContrato = $fd[0].'-'.$fd[1].'-'.$fd[2];
									}
								?>
								<input style="background-color:#66CC99;" name="fechaContrato" id="fechaContrato"	type="date" value="<?php echo $fechaContrato; ?>" required />
								<!-- <input name="FechaPago" id="FechaPago"		type="date" size="10" maxlength="10" value="<?php echo $FechaPago; ?>"> -->
							</td>
							<td  align="center">
								<?php
									if($PerIniServ == '0000-00-00'){
										$fd 		= explode('-', date('Y-m-d'));
										$PerIniServ = $fd[0].'-'.$fd[1].'-'.$fd[2];
									}
								?>
								<!-- <input name="PerIniServ" id="datepicker" type="date" size="10" maxlength="10" value="<?php echo $PerIniServ; ?>"> -->
								<input name="PerIniServ" id="PerIniServ" type="date" size="10" maxlength="10" value="<?php echo $PerIniServ; ?>" required />
							</td>
							<td  align="center">
								<?php
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
									if($PerTerServ == '0000-00-00'){
										$PerTerServ 	= strtotime ( '+30 day' , strtotime ( $PerIniServ ) );
										$PerTerServ 	= date ( 'Y-m-d' , $PerTerServ );
									}
									
									
								?>
								<input name="PerTerServ" id="PerTerServ" style="background-color:#66CC99;" type="date" size="10" maxlength="10" value="<?php echo $PerTerServ; ?>"  required />
							</td>
							<td align="center">
								<?php 
									if($Estado=='P'){
										echo '<img src="../gastos/imagenes/Confirmation_32.png" width="32" height="32" title="Informado">';
									}else{
										echo '<img src="../gastos/imagenes/no_32.png" width="32" height="32" title="Contrato Pendiente de Firma">';
									}
									if($fechaInforme == '0000-00-00'){
										$fechaInforme 	= $PerTerServ;
									}
								?>
							</td>
							<td>
								<!-- <input name="FechaPago" id="FechaPago"		type="date" size="10" maxlength="10" value="<?php echo $FechaPago; ?>"> -->
								<input name="fechaInforme" id="fechaInforme" type="date" size="10" maxlength="10" value="<?php echo $fechaInforme; ?>"  required />
							</td>
							<td align="center">
								<?php 
									if($fechaContratoB > '0000-00-00'){
										echo '<a href="formularios/contratoNew.php?Run='.$Run.'&nBoleta='.$nBoleta.'"><img src="../gastos/imagenes/pdf.png" width="32" height="32" title="Imprimir Contrato"></a>';
									}else{
										echo '&nbsp;';
									}
								?>
							</td>
							<td align="center">
								<?php 
									if($fechaContratoB > '0000-00-00'){?>
										<a href="formularios/informeAct.php?Run=<?php echo $Run; ?>&Periodo=<?php echo $Periodo; ?>&nBoleta=<?php echo $nBoleta; ?>">
											<img src="../imagenes/newPdf.png" width="32" height="32" title="Imprimir Informe de Actividades">
										</a>
										<?php
									}else{
										echo '&nbsp;';
									}
								?>
							</td>
						</tr>
					</table>

					<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaDocumentos">
						<tr>
							<td>N° </td>
							<td>Descripción </td>
							<td>Bruto </td>
							<td>Retención </td>
							<td>Liquido </td>
						</tr>
						<tr>
							<td>
								<?php echo $nLinea; ?>
								<input name="nLinea" id="nLinea"	type="hidden" 	size="3" maxlength="3" value="<?php echo $nLinea; ?>">
							</td>
							<td>
								<input name="Descripcion" id="Descripcion"	type="text" 	size="80" maxlength="80" value="<?php echo $Descripcion; ?>" required />
							</td>
							<td>
								<?php
									//$Total		= round(($Liquido/0.9),0);
									//$Retencion 	= round(($Total * 0.1),0);
								?>
								<input 	name="Total" 	
										id="Total"
										ng-model="Total"
										ng-init="Total='<?php echo $Total; ?>'"	
										ng-change="CalcularRetencion()" 
										type="text" 
										size="11"
										maxlength="11" 
										value="<?php echo $Total; ?>">
										
							</td>
							<td>
								<input 	name="Retencion" 
										ng-model="Retencion"
										id="Retencion"
										ng-init="Retencion='<?php echo $Retencion; ?>'"
										type="text" 
										size="11"
										maxlength="11" 
										value="<?php echo $Retencion; ?>">
							</td>
							<td>
								<input 	name="Liquido"
										ng-model="Liquido"
										ng-init="Liquido='<?php echo $Liquido; ?>'"
										id="Liquido"	
										type="text" 
										size="11"
										maxlength="11" 
										value="<?php echo $Liquido; ?>">
							</td>
						</tr>
					</table>
				</div>
				<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaOpcDoc">
					<tr>
						<td>Mensaje al Usuario...
							<?php
								if($MsgUsr){
									echo '<div id="Saldos">'.$MsgUsr.'</div>';
								}else{
									echo '<div id="Saldos" style="display:none; ">'.$MsgUsr.'</div>';
								}
							?>
						</td>
					</tr>
				</table>
					
					<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
						<tr>
							<td>
								<strong style="font-size:14px;">
									Detalle de Actividades
								</strong>
							</td>
						</tr>
					</table>
					
					<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaId" style="background-color:#E8F188;">
						<tr>
							<td>Registre las actividades realizadas por el Prestador</td>';
						</tr>
						<tr>
							<td>
								<textarea name="actRealizada" id="actRealizada" cols="130" rows="20" placeholder="Registre las actividades desarrolladas por el Prestador..."><?php echo $actRealizada; ?></textarea>
							</td>
						</tr>
					</table>
			<?php } ?>
		</form>
	</div>
	<div style="clear:both; "></div>


	<script src="../jsboot/bootstrap.min.js"></script>
	<script src="personal.js"></script>

</body>
</html>

