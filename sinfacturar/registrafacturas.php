<?php
	session_start();

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

	$MsgUsr 	= "";	
	$TpDoc 		= "F";
	$Proceso 	= "1";
	$nMov		= 0;
	$nFactura 	= 0;
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

	if(isset($_POST['Proceso'])){ 
		$Proceso 	= $_POST['Proceso'];
	}else{
		$Proveedor 		= "";
		$nFactura		= "";
		$Descripcion	= "";
		$Bruto			= "";
		$nMov			= "";
		$FechaFactura   = date('Y-m-d');

		$IdProyecto 	= "";
		$IdAuoriza		= "";
		$TpDoc 			= "F";
	}
	$fd 	= explode('-', date('Y-m-d'));
	$Periodo = $fd[1].'.'.$fd[0];

	if($_GET['Proceso']) 	{ $Proceso  = $_GET['Proceso'];  	}
	if($_GET['RutProv']) 	{ 
		$RutProv 	= $_GET['RutProv']; 	
		$link=Conectarse();
		$bdProv=mysql_query("SELECT * FROM Proveedores Where RutProv = '".$RutProv."'");
		if ($row=mysql_fetch_array($bdProv)){
			$Proveedor = $row['Proveedor'];
		}
		mysql_close($link);
	}
	if($_GET['nFactura']) 	{ $nFactura = $_GET['nFactura']; 	}
	if($_GET['Periodo']) 	{ $Periodo 	= $_GET['Periodo']; 	}

	if($_POST['Periodo']) 	{ $Periodo 	= $_POST['Periodo']; 	}

	$m = substr($Periodo,0,2);
	$Mm = $Mes[ intval($m) ];
	$pPago = $Mm.'.'.$fd[0];
	
	if($_GET['Proceso']==2 || $_GET['Proceso']==3){
		$link=Conectarse();
		$bdFact=mysql_query("SELECT * FROM Facturas WHERE RutProv = '".$RutProv."' && nFactura = '".$nFactura."'");
		if ($row=mysql_fetch_array($bdFact)){
	   		$PeriodoPago 	= $row['PeriodoPago'];
			$nLinea			= $row['nLinea'];
	   		$IdProyecto		= $row['IdProyecto'];
	   		$FechaFactura  	= $row['FechaFactura'];
			$Descripcion	= $row['Descripcion'];
			$TpCosto		= $row['TpCosto'];
			$Bruto			= $row['Bruto'];
			$Recurso 		= '5';
			$IdProyecto 	= $row['IdProyecto'];
			$IdAutoriza 	= $row['IdAutoriza'];
			$bdProv=mysql_query("SELECT * FROM Proveedores Where RutProv = '".$RutProv."'");
			if ($row=mysql_fetch_array($bdProv)){
				$Proveedor = $row['Proveedor'];
			}
			
		}
		mysql_close($link);
		if($_GET['Proceso']==3){
			$MsgUsr = "Se eliminara Registro...";
		}
	}

	$sw = false;
	if(isset($_POST['Proveedor'])) { $Proveedor = $_POST['Proveedor'];	}
	if(isset($_POST['nFactura'])){
		$TpDoc 		= $_POST['TpDoc'];
		$nFactura	= $_POST['nFactura'];
		$Proceso	= $_POST['Proceso'];
		$nMov		= $_POST['nMov']; // nFactura = Numero de Factura Control Secuencial
		$RutProv	= $_POST['RutProv'];
		$Periodo	= $_POST['Periodo'];
		$TpCosto	= $_POST['TpCosto'];
		if(isset($_POST['FechaFactura']))	{ $FechaFactura = $_POST['FechaFactura'];	}
		if(isset($_POST['Descripcion']))	{ $Descripcion 	= $_POST['Descripcion'];	}
		if(isset($_POST['Proveedor'])){
			if(isset($_POST['FechaFactura'])){
				if(isset($_POST['Descripcion'])){
					if(isset($_POST['Bruto'])){
						if(isset($_POST['IdProyecto'])){
							if(isset($_POST['IdAutoriza'])){
								$sw = true;
							}
						}
					}
				}
			}
		}
		$Recurso = "5";
		if(isset($_POST['IdProyecto']))		{ $IdProyecto 	  = $_POST['IdProyecto']; 	 }
		if(isset($_POST['IdAutoriza']))		{ $IdAutoriza 	  = $_POST['IdAutoriza']; 	 }

		if($sw==false){
   			$MsgUsr = 'Error de Ingreso: Debe ingresar todos los campos ...';
		}
	}
	if(isset($_POST['Proveedor'])){
		$RutProv = $_POST['Proveedor'];
		$link=Conectarse();
		$bdProv=mysql_query("SELECT * FROM Proveedores Where RutProv = '".$RutProv."'");
		if ($row=mysql_fetch_array($bdProv)){
			$Proveedor 	= $row['Proveedor'];
			$RutProv 	= $row['RutProv'];
		}else{
			$bdProv=mysql_query("SELECT * FROM Proveedores Where Proveedor = '".$Proveedor."'");
			if ($row=mysql_fetch_array($bdProv)){
				$Proveedor 	= $row['Proveedor'];
				$RutProv 	= $row['RutProv'];
			}else{
				$sw = false;
			}
		}
		mysql_close($link);
	}
	if($sw == true){
		$sw = false;
		$nFactura		= $_POST['nFactura'];
		$FechaFactura	= $_POST['FechaFactura'];
		$Descipcion		= $_POST['Descripcion'];
		$Bruto			= $_POST['Bruto'];
		$IdProyecto		= $_POST['IdProyecto'];
		$IdRecurso 		= "5";
		
		if($Proceso == 1 || $Proceso == 2 || $Proceso == 3 ){ /* Agregar */
			If($Proceso==1){ $nMov = 0; }
			$link=Conectarse();
			$bdFact=mysql_query("SELECT * FROM Facturas WHERE RutProv = '".$RutProv."' && nFactura = '".$nFactura."'");
			if ($rowFact=mysql_fetch_array($bdFact)){
				$nInforme = $rowFact ['nInforme'];
				$BrutoOld = $rowFact['Bruto'];
				if($Proceso == 2){
					$actSQL="UPDATE Facturas SET ";
					$actSQL.="FechaFactura  ='".$FechaFactura."',";
					$actSQL.="PeriodoPago	='".$Periodo."',";
					$actSQL.="Descripcion	='".$Descripcion."',";
					$actSQL.="Bruto		    ='".$Bruto."',";
					$actSQL.="IdRecurso		='".$IdRecurso."',";
					$actSQL.="TpCosto		='".$TpCosto."',";
					$actSQL.="IdProyecto	='".$IdProyecto."',";
					$actSQL.="IdAutoriza	='".$IdAutoriza."'";
					$actSQL.="WHERE RutProv = '".$RutProv."' && nFactura = '".$nFactura."'";
					$bdFact=mysql_query($actSQL);
	   				$MsgUsr = 'Registro de Gastos Actualizado...';
					if($nInforme>0){
						$bdForm=mysql_query("SELECT * FROM Formularios WHERE nInforme = '".$nInforme."' && Formulario = 'F7(Factura)'");
						if ($rowForm=mysql_fetch_array($bdForm)){
							$actSQL="UPDATE Formularios SET ";
							$actSQL.="Bruto		    	='".$Bruto."'";
							$actSQL.="WHERE nInforme 	= '".$nInforme."' && Formulario = 'F7(Factura)'";
							$bdForm=mysql_query($actSQL);
						}
					}
					header("Location: CalculoFacturas.php?Mm=".$Mm);
				}
				if($Proceso == 3){
					$bdGas=mysql_query("DELETE FROM Facturas WHERE RutProv = '".$RutProv."' && nFactura = '".$nFactura."'");
					mysql_close($link);
					header("Location: CalculoFacturas.php?Mm=".$Mm);
				}
				
			}else{
				$result = mysql_query('SELECT * FROM Facturas');
				$nMov = mysql_num_rows($result) + 1;
				mysql_query("insert into Facturas (		nMov,
														PeriodoPago,
														FechaFactura,
														RutProv,
														nFactura,
														Descripcion,
														Bruto,
														IdRecurso,
														TpCosto,
														IdProyecto,
														IdAutoriza) 
										values 		(	'$nMov',
														'$Periodo',
														'$FechaFactura',
														'$RutProv',
														'$nFactura',
														'$Descripcion',
														'$Bruto',
														'$IdRecurso',
														'$TpCosto',
														'$IdProyecto',
														'$IdAutoriza')",$link);
				header("Location: CalculoFacturas.php?Mm=".$Mm);
   				$MsgUsr = 'Se ha registrado un nuevo Sueldo Honorario Factura...';

				$Proveedor 		= "";
				$nFactura		= 0;
				$Descripcion	= "";
				$Bruto			= 0;
				$FechaFactura   = date('Y-m-d');

				$Items 		= "";
				$TpGasto 	= "";
				$Recurso 	= "Pago de Factura";
				$IdProyecto = "";
				$IdAuoriza	= "";
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
<script src="../jquery/jquery-1.6.4.js"></script>
<style type="text/css">
<!--
body {
	
	margin-top: 0px;
	margin-bottom: 0px;
	background: url(../gastos/imagenes/Usach.jp) no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
	max-width:100%;
	width:100%;
	margin-left:auto;
	margin-right:auto;	

	
}
-->
</style>
<script language="javascript" src="../gastos/validaciones.js"></script> 
<script src="../jquery/jquery-1.6.4.js"></script>
</head>

<body onLoad="inicioformulario()">
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<form name="form" action="registrafacturas.php" method="post">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<img src="../gastos/imagenes/crear_certificado.png" width="28" height="28" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					<?php echo 'Registro de Facturas Honorarios <span id="BoxPeriodo">'.$pPago.'</span>'; ?>
				</strong>
				<?php include('barramenu.php'); ?>
				<div id="ImagenBarra">
					<a>
					<img src="../gastos/imagenes/r_x.png"  width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="registrafacturas.php?Proceso=1" title="Nueva Factura">
						<img src="../gastos/imagenes/export_32.png" width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="CalculoFacturas.php" title="Volver">
						<img src="../gastos/imagenes/preview_back_32.png" width="28" height="28">
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
				echo '			<td>Registro Facturas Honorarios';
				echo '				<div id="ImagenBarra">';
				if($Proceso == 1 || $Proceso == 2){
            		echo '			<input name="Grabar" type="image" id="Grabar" src="../gastos/imagenes/save_32.png" width="28" height="28" title="Guardar">';
				}else{
            		echo '			<input name="Eliminar" type="image" id="Eliminar" src="../gastos/imagenes/inspektion.png" width="28" height="28" title="Eliminar">';
				}
				echo '				</div>';
				echo '			</td>';
				echo '		</tr>';
				echo '	</table>';
				
				echo '<div id="RegistroFactura">';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaDocumentos">';
				echo '		<tr>';
				echo '			<td>Proveedor</td>';
				echo '			<td>N° Factura</td>';
				echo '			<td>Fecha</td>';
				echo '			<td>Bien o Servicio</td>';
				echo '			<td>Bruto</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>';

				if($Proveedor){
					echo '<strong>'.$Proveedor.'</strong>';
				}else{
	  				echo '<select name="Proveedor" id="Proveedor" onChange="window.location = this.options[this.selectedIndex].value; return true;">';
					$link=Conectarse();
					$bdPp=mysql_query("SELECT * FROM Proveedores");
					if ($rowPp=mysql_fetch_array($bdPp)){
						DO{
			    			if($Proveedor == $rowPp['Proveedor']){
								echo "<option selected 	value='registrafacturas.php?Proceso=".$Proceso."&Periodo=".$Periodo."&RutProv=".$rowPp['RutProv']."'>".$rowPp['Proveedor']."</option>";
							}else{
			    				if($Prestador == ""){
									$Prestador = "X";
									echo "<option selected></option>";
								}
								echo "	<option  			value='registrafacturas.php?Proceso=".$Proceso."&Periodo=".$Periodo."&RutProv=".$rowPp['RutProv']."'>".$rowPp['Proveedor']."</option>";
							}
						}WHILE ($rowPp=mysql_fetch_array($bdPp));
					}
					mysql_close($link);
				echo '</select>';
								}

				echo '				<input name="Proveedor" 	 	type="hidden" value="'.$Proveedor.'">';
				echo '				<input name="Proceso"  			type="hidden" value="'.$Proceso.'">';
				echo '				<input name="Periodo"  			type="hidden" value="'.$Periodo.'">';
			    echo '				<input name="Recurso"			type="hidden" value="5">';
				echo '			</td>';
				echo '			<td><input name="nFactura" 			type="text" size="15" maxlength="15" value="'.$nFactura.'">		</td>';
				echo '			<td>';
				echo '				<input name="FechaFactura"		type="date"   size="10" maxlength="10" value="'.$FechaFactura.'">';
				echo '			</td>';
				echo '			<td><input name="Descripcion" 		type="text" size="30" maxlength="100" value="'.$Descripcion.'">	</td>';
				echo '			<td><input name="Bruto" 			type="text" size="10" maxlength="10" value="'.$Bruto.'">			</td>';
				echo '		</tr>';
				echo '	</table>';
				echo '</div>';

				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaOpcDoc">';
				echo '		<tr>';
				echo '			<td>Opciones';
				if($MsgUsr){
					echo '<div id="Saldos">'.$MsgUsr.'</div>';
				}else{
					echo '<div id="Saldos" style="display:none; ">'.$MsgUsr.'</div>';
				}
				echo '			</td>';
				echo '		</tr>';
				echo '	</table>';

				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaDocumentos">';
				echo '		<tr>';
				echo '			<td id="CajaOpc">';
				echo '				Costo';
				echo '			</td>';
				echo '			<td id="CajaOpc">';
				echo '				Proyectos';
				echo '			</td>';
				echo '			<td id="CajaOpc">';
				echo '				Autoriza';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';


				echo '			<td id="CajaOpcDatos" valign="top">';
				if($TpCosto=='M'){
			    	echo '				<input type="radio" name="TpCosto" value="M" checked>Mensual<br>';
			    	echo '				<input type="radio" name="TpCosto" value="E" 		>Esporadico<br>';
			    	echo '				<input type="radio" name="TpCosto" value="I" 		>Inversión<br>';
				}
				if($TpCosto=='E'){
			    	echo '				<input type="radio" name="TpCosto" value="M" 		>Mensual<br>';
			    	echo '				<input type="radio" name="TpCosto" value="E" checked>Esporadico<br>';
			    	echo '				<input type="radio" name="TpCosto" value="I" 		>Inversión<br>';
				}
				if($TpCosto=='I'){
			    	echo '				<input type="radio" name="TpCosto" value="M" 		>Mensual<br>';
			    	echo '				<input type="radio" name="TpCosto" value="E" 		>Esporadico<br>';
			    	echo '				<input type="radio" name="TpCosto" value="I" checked>Inversión<br>';
				}
				if($TpCosto==''){
			    	echo '				<input type="radio" name="TpCosto" value="M" checked>Mensual<br>';
			    	echo '				<input type="radio" name="TpCosto" value="E" 		>Esporadico<br>';
			    	echo '				<input type="radio" name="TpCosto" value="I" 		>Inversión<br>';
				}
				echo '			</td>';


				echo '			<td id="CajaOpcDatos" valign="top">';
				$link=Conectarse();
				$bdPr=mysql_query("SELECT * FROM Proyectos Order By IdProyecto");
				if ($row=mysql_fetch_array($bdPr)){
					DO{
						if(isset($IdProyecto)){
							if($IdProyecto==$row['IdProyecto']){
			    				echo '<input type="radio" name="IdProyecto" value="'.$row['IdProyecto'].'" checked>'.$row['IdProyecto'].'<br>';
							}else{
			    				echo '<input type="radio" name="IdProyecto" value="'.$row['IdProyecto'].'">'.$row['IdProyecto'].'<br>';
							}
						}else{
			    			echo '<input type="radio" name="IdProyecto" value="'.$row['IdProyecto'].'">'.$row['IdProyecto'].'<br>';
						}
					}WHILE ($row=mysql_fetch_array($bdPr));
				}
				mysql_close($link);
				echo '			</td>';

				echo '			<td id="CajaOpcDatos" valign="top">';
				$link=Conectarse();
				$bdAu=mysql_query("SELECT * FROM Autoriza");
				if ($row=mysql_fetch_array($bdAu)){
					DO{
						if(isset($IdAutoriza)){
							if($IdAutoriza==$row['IdAutoriza']){
			    				echo '<input type="radio" name="IdAutoriza" value="'.$row['IdAutoriza'].'" checked>'.$row['IdAutoriza'].'<br>';
							}else{
			    				echo '<input type="radio" name="IdAutoriza" value="'.$row['IdAutoriza'].'">'.$row['IdAutoriza'].'<br>';
							}
						}else{
			    			echo '<input type="radio" name="IdAutoriza" value="'.$row['IdAutoriza'].'">'.$row['IdAutoriza'].'<br>';
						}
					}WHILE ($row=mysql_fetch_array($bdAu));
				}
				mysql_close($link);
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