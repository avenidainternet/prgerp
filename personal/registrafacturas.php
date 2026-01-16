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
	$RutProv	= '';
	$Periodo	= '';
	$Prestador	= '';
	$TpCosto	= '';
	$tNetos		= 0;
	$Proceso	= '';
	$TpDoc		= '';
	$nMov		= '';
	$RutProv	= '';
	
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
	if(isset($_GET['Proceso'])) 	{ $Proceso  = $_GET['Proceso'];  	}
	if(isset($_GET['RutProv'])) 	{ 
		$RutProv 	= $_GET['RutProv']; 	
		$link=Conectarse();
		$bdProv=$link->query("SELECT * FROM Proveedores Where RutProv = '".$RutProv."'");
		if ($row=mysqli_fetch_array($bdProv)){
			$Proveedor = $row['Proveedor'];
		}
		$link->close();
	}
	if(isset($_GET['nFactura'])) 	{ $nFactura = $_GET['nFactura']; 	}
	if(isset($_GET['Periodo'])) 	{ $Periodo 	= $_GET['Periodo']; 	}

	if(isset($_POST['Periodo'])) 	{ $Periodo 	= $_POST['Periodo']; 	}

	$m = substr($Periodo,0,2);
	$Mm = $Mes[ intval($m) ];
	$pPago = $Mm.'.'.$fd[0];
	
	if(isset($_GET['Proceso'])==2 || isset($_GET['Proceso'])==3){
		$link=Conectarse();
		$bdFact=$link->query("SELECT * FROM facturas WHERE RutProv = '".$RutProv."' and nFactura = '".$nFactura."' and PeriodoPago = '".$Periodo."'");
		if ($row=mysqli_fetch_array($bdFact)){
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
			$bdProv=$link->query("SELECT * FROM Proveedores Where RutProv = '".$RutProv."'");
			if ($row=mysqli_fetch_array($bdProv)){
				$Proveedor = $row['Proveedor'];
			}
			
		}
		$link->close();
		if($_GET['Proceso']==3){
			$MsgUsr = "Se eliminara Registro...";
		}
	}

	$sw = false;
	$TpDoc		= '';
	$nMov		= '';
	$RutProv	= '';
	if(isset($_POST['Proveedor'])) { $Proveedor = $_POST['Proveedor'];	}
	if(isset($_POST['nFactura'])){
		if(isset($_POST['TpDoc'])) 			{ $TpDoc 		= $_POST['TpDoc']; }
		if(isset($_POST['nFactura'])) 		{ $nFactura		= $_POST['nFactura'];	}
		if(isset($_POST['Proceso'])) 		{ $Proceso		= $_POST['Proceso'];	}
		if(isset($_POST['nMov'])) 			{ $nMov			= $_POST['nMov']; 		}
		if(isset($_POST['RutProv'])) 		{ $RutProv		= $_POST['RutProv'];	}
		if(isset($_POST['Periodo'])) 		{ $Periodo		= $_POST['Periodo'];	}
		if(isset($_POST['TpCosto'])) 		{ $TpCosto		= $_POST['TpCosto'];	}
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
		$bdProv=$link->query("SELECT * FROM Proveedores Where RutProv = '".$RutProv."'");
		if ($row=mysqli_fetch_array($bdProv)){
			$Proveedor 	= $row['Proveedor'];
			$RutProv 	= $row['RutProv'];
		}else{
			$bdProv=$link->query("SELECT * FROM Proveedores Where Proveedor = '".$Proveedor."'");
			if ($row=mysqli_fetch_array($bdProv)){
				$Proveedor 	= $row['Proveedor'];
				$RutProv 	= $row['RutProv'];
			}else{
				$sw = false;
			}
		}
		$link->close();
	}
	if(isset($_POST['Grabar']))		{ $sw 	  = true; 	 }
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
			$SQLf = "SELECT * FROM Facturas WHERE PeriodoPago = '".$Periodo."' and RutProv = '".$RutProv."' and nFactura = '".$nFactura."'";
			$bdFact=$link->query($SQLf);
			if ($rowFact=mysqli_fetch_array($bdFact)){
			echo $SQLf;
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
					$bdFact=$link->query($actSQL);
	   				$MsgUsr = 'Registro de Gastos Actualizado...';
					if($nInforme>0){
						$bdForm=$link->query("SELECT * FROM Formularios WHERE nInforme = '".$nInforme."' && Formulario = 'F7(Factura)'");
						if ($rowForm=mysqli_fetch_array($bdForm)){
							$actSQL="UPDATE Formularios SET ";
							$actSQL.="Bruto		    	='".$Bruto."'";
							$actSQL.="WHERE nInforme 	= '".$nInforme."' && Formulario = 'F7(Factura)'";
							$bdForm=$link->query($actSQL);
						}
					}
					header("Location: CalculoFacturas.php?Mm=".$Mm);
				}
				if($Proceso == 3){
					$bdGas=$link->query("DELETE FROM Facturas WHERE RutProv = '".$RutProv."' && nFactura = '".$nFactura."'");
					$link->close();
					header("Location: CalculoFacturas.php?Mm=".$Mm);
				}
				
			}else{
				$result = $link->query('SELECT * FROM Facturas');
				$nMov = $result->num_rows + 1;
				$link->query("insert into Facturas (		nMov,
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
														'$IdAutoriza')");
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
			$link->close();
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
	<?php include_once('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<form name="form" action="registrafacturas.php" method="post">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<img src="../gastos/imagenes/crear_certificado.png" width="28" height="28" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					<?php echo 'Registro de Facturas Honorarios <span id="BoxPeriodo">'.$pPago.'</span>'; ?>
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
			<?php
				echo '<div align="center">';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td>Registro Facturas Honorarios';
				echo '				<div id="ImagenBarra">';
				if($Proceso == 1 || $Proceso == 2){?>
					<button name="Grabar">
						<img src="../gastos/imagenes/save_32.png" width="28" title="Guardar Factura">
					</button>
				<?php }else{?>
					<button name="Eliminar">
						<img src="../gastos/imagenes/inspektion.png" width="28" title="Eliminar Factura">
					</button>
					<?php
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
					$bdPp=$link->query("SELECT * FROM Proveedores");
					if ($rowPp=mysqli_fetch_array($bdPp)){
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
						}WHILE ($rowPp=mysqli_fetch_array($bdPp));
					}
					$link->close();
				echo '</select>';
								}

				echo '				<input name="Proveedor" 	 	type="hidden" value="'.$Proveedor.'">';
				echo '				<input name="Proceso"  			type="hidden" value="'.$Proceso.'">';
				echo '				<input name="Periodo"  			type="hidden" value="'.$Periodo.'">';
			    echo '				<input name="Recurso"			type="hidden" value="5">';
				echo '			</td>';
				echo '			<td><input name="nFactura" 			type="text" size="15" maxlength="15" value="'.$nFactura.'" required />		</td>';
				echo '			<td>';
				echo '				<input name="FechaFactura"		type="date"   size="10" maxlength="10" value="'.$FechaFactura.'" required />';
				echo '			</td>';
				echo '			<td><input name="Descripcion" 		type="text" size="30" maxlength="100" value="'.$Descripcion.'" required />	</td>';
				echo '			<td><input name="Bruto" 			type="text" size="10" maxlength="10" value="'.$Bruto.'" required>			</td>';
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
				$bdPr=$link->query("SELECT * FROM Proyectos Order By IdProyecto");
				if ($row=mysqli_fetch_array($bdPr)){
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
					}WHILE ($row=mysqli_fetch_array($bdPr));
				}
				$link->close();
				echo '			</td>';

				echo '			<td id="CajaOpcDatos" valign="top">';
				$link=Conectarse();
				$bdAu=$link->query("SELECT * FROM Autoriza");
				if ($row=mysqli_fetch_array($bdAu)){
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
					}WHILE ($row=mysqli_fetch_array($bdAu));
				}
				$link->close();
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