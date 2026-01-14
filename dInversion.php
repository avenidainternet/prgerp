<?php
	session_start(); 
	include_once("Mobile-Detect-2.3/Mobile_Detect.php");
 	$Detect = new Mobile_Detect();
	date_default_timezone_set("America/Santiago");
		//if ($Detect->IsMobile()) {
		//	header("Location: http://simet.cl/mobil/");
		//}
	$maxCpo = '100%';
	include_once("conexionli.php");

		$link=Conectarse();
		$bdCli=$link->query("SELECT * FROM SolFactura Where valorUF > 0 Order By valorUF Desc");
		if($rowCli=mysqli_fetch_array($bdCli)){
			$ultUF = $rowCli['valorUF'];
		}
		$link->close();

	if(isset($_GET['CAM'])) 		{	$CAM 	= $_GET['CAM']; 		}
	if(isset($_GET['RAM'])) 		{	$RAM 	= $_GET['RAM']; 		}
	if(isset($_GET['accion'])) 		{	$accion = $_GET['accion']; 		}
	
	if(isset($_POST['CAM'])) 		{	$CAM 	= $_POST['CAM']; 		}
	if(isset($_POST['RAM'])) 		{	$RAM 	= $_POST['RAM']; 		}
	if(isset($_POST['accion'])) 	{	$accion = $_POST['accion']; 	}
	
	if(isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']		= $rowPer['Perfil'];
			$_SESSION['IdPerfil']	= $rowPer['IdPerfil'];
		}
		$link->close();
	}else{
		//header("Location: http://simet.cl");
		header("Location: index.php");
	}
	if(isset($_POST['Cerrar'])){
		header("Location: cerrarsesion.php");
	}
?>
<!doctype html>
 
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

	<link rel="shortcut icon" href="favicon.ico" />
	<link rel="apple-touch-icon" href="touch-icon-iphone.png" />
	<link rel="apple-touch-icon" href="touch-icon-ipad.png" />
	<link rel="apple-touch-icon" href="touch-icon-iphone4.png" />

	<title>Plataforma ERP de Simet</title>

	<link href="css/styles.css" rel="stylesheet" type="text/css">
	<link href="estilos.css" 	rel="stylesheet" type="text/css">
	<link href="css/tpv.css" 	rel="stylesheet" type="text/css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	
  	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
 	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	
</head>

<body>
	<?php 
		include_once('head.php');
	?>
	<!-- <table width="99%"  border="0" cellspacing="0" cellpadding="0" style="margin:5px;"> -->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="200px" rowspan="5" valign="top">
				<?php include_once('menulateral.php')?>
			</td>
			<td width="<?php echo $maxCpo; ?>" valign="top">
				<span id="resultadoAM"></span>
			</td>
	  	</tr>
	  	<tr>
			<td valign="top">
				<?php listaVentas(); ?>
			</td>
	  	</tr>
	  	<tr>
			<td>&nbsp;</td>
	  	</tr>
	  	<tr>
			<td>&nbsp;</td>
	  	</tr>
	  	<tr>
			<td>&nbsp;</td>
	  	</tr>
	</table>
	<div style="clear:both; "></div>
	<br>
</body>
</html>
<?php
function listaVentas(){

	$Orden = 'Asc';
	$Campo = 'Run';
	if(isset($_GET['Orden']))  	{ $Orden  	= $_GET['Orden']; 	}
	if(isset($_GET['Campo']))  	{ $Campo  	= $_GET['Campo']; 	}
	if($Orden == 'Asc'){
		$Orden = 'Desc';
	}else{
		$Orden = 'Asc';
	}
	?>
	<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo" style="margin-top:10px;">
		<tr>
			<td  width="10%" align="center" height="40"><strong>Item<br>Inv.  		</strong></td>
			<td  width="10%" align="center" height="40"><strong>N° Sol.<br>Proy.  		</strong></td>
			<td  width="10%" align="center">			
				<strong>
					Fecha<br> de Inv.	
				</strong>
			</td>
			<td  width="10%" align="center">
				<strong>
					Documento				
				</strong>
			</td>
			<td  width="10%" align="center">
				<strong>
					Reembolso				
				</strong>
			</td>
			<td  width="30%" align="center">			
				<strong>
					Proveedor
				</strong>
			</td>
			<td  width="10%" align="center"> 			<strong>Monto<br>Inv.		</strong></td>
			<td  width="10%" align="center"> 			<strong>Total<br>Inv.		</strong></td>
		</tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="0" id="CajaListado">
		<?php
			$tGral 		= 0;
			$tSueldos 	= 0;
			$tPersona	= 0;
			$Run		= '';
			
			$filtroSQL = " Where Modulo = 'G' and IdGasto = 2 and year(FechaGasto) = '".$_GET['ageGastos']."' and month(FechaGasto) = '".$_GET['mesGastos']."' ";

			if($_GET['Gastos'] == 'AgnoProy'){
				$filtroSQL = " Where Modulo = 'G' and IdGasto = 2 and year(FechaGasto) = '".$_GET['ageGastos']."' and month(FechaGasto) <= '".$_GET['mesGastos']."' ";
			}			
			if($_GET['Gastos'] == 'Agno'){
				$filtroSQL = " Where Modulo = 'G' and IdGasto = 2 and year(FechaGasto) = '".$_GET['ageGastos']."' and month(FechaGasto) <= '".$_GET['mesGastos']."' ";
			}			
			if(isset($_GET['IdProyecto'])) {
				$IdProyecto = $_GET['IdProyecto'];
				if(!empty($IdProyecto)){
					$filtroSQL .= " and IdProyecto = '".$_GET['IdProyecto']."'";
				}
			}
			$link=Conectarse();

			$n = 0;
			$SQL = "SELECT * FROM ItemsGastos Order By nItem";
			$bdHon=$link->query($SQL);
			if($row=mysqli_fetch_array($bdHon)){
				do{
					$n 		= 0;
					$tItems = 0;
					$bdGas=$link->query("SELECT * FROM MovGastos $filtroSQL and nItem = '".$row['nItem']."' Order By IdGasto, nInforme");
					if($rowGas=mysqli_fetch_array($bdGas)){
						do{

							$n++;
							$tr = "barraVerde";
							if($rowGas['Reembolso'] == 'on'){
								$tr = 'barraPagada';
							}
							?>
							<tr id="<?php echo $tr; ?>">
								<td width="10%" style="font-size:16px;" align="right">
									<?php 
										if($n == 1){
											echo $row['Items'];
										}
									?>
								</td>
								<td  width="10%" align="center">			
									<?php 
										echo $rowGas['nInforme'].'<br>';
										echo $rowGas['IdProyecto']; 
									?>
								</td>
								<td width="10%" style="font-size:16px;">
									<?php 
										$fd = explode('-', $rowGas['FechaGasto']);
										echo $fd[2].'-'.$fd[1].'-'.$fd[0]; 
									?>
								</td>
								<td width="10%" style="font-size:16px;">
									<?php 
										if($rowGas['TpDoc'] == 'F'){
											echo 'Factura '.'<br> N° '.$rowGas['nDoc']; 
										}else{
											echo 'Boleta '.'<br> N° '.$rowGas['nDoc']; 
										}
									?>
								</td>
								<td width="10%" style="font-size:16px;">
									<?php
										if($rowGas['Reembolso'] == 'on'){ 
											$fd = explode('-', $rowGas['fechaReembolso']);
											echo $fd[2].'-'.$fd[1].'-'.$fd[0]; 
										}
									?>
								</td>
								<td width="30%">
									<?php 
										echo $rowGas['Proveedor'].'<br>'; 
										echo '('.$rowGas['Bien_Servicio'].')'; 
									?>
								</td>
								<td width="10%" align="center">
									<?php
										echo number_format($rowGas['Bruto'], 0, ',', '.');
										$tItems 	+= $rowGas['Bruto'];
										$tGral 		+= $rowGas['Bruto'];
										//if($Run != $row['Run']){
										//	$tPersona = 0;
										//	$Run	  = $row['Run'];
										//}
										//$tPersona		+= $row['Liquido'];
									?>
								</td>
								<td width="10%" align="center">
									<?php
										echo number_format($tItems, 0, ',', '.');
										//echo number_format($tSueldos, 0, ',', '.');
										//echo number_format($tPersona, 0, ',', '.');
									?>
								</td>
							</tr>
							<?php
						}while ($rowGas=mysqli_fetch_array($bdGas));
					}
				}while ($row=mysqli_fetch_array($bdHon));
			}
			
			// Honorarios
			$PeriodoPago = $_GET['mesGastos'].'.'.$_GET['ageGastos'];
			
			$filtroSQL = " Where PeriodoPago = '".$PeriodoPago."' and TpCosto = 'I' ";

			if($_GET['Gastos'] == 'AgnoProy'){
				$filtroSQL = " Where PeriodoPago <= '".$PeriodoPago."' and PeriodoPago Like '%".$_GET['ageGastos']."%' and TpCosto = 'I' ";
			}			
			if($_GET['Gastos'] == 'Agno'){
				$filtroSQL = " Where PeriodoPago <= '".$PeriodoPago."' and PeriodoPago Like '%".$_GET['ageGastos']."%' and TpCosto = 'I'";
			}			
			if(isset($_GET['IdProyecto'])) {
				$IdProyecto = $_GET['IdProyecto'];
				if(!empty($IdProyecto)){
					$filtroSQL .= " and IdProyecto = '".$_GET['IdProyecto']."'";
				}
			}

			$tHonorarios = 0;
			$tPersona	 = 0;
			$Run		 = '';
			$n = 0;
			$Campo = 'TpCosto';
			$Orden = 'Desc';
			$TpCosto = '';
			$SQL = "SELECT * FROM Honorarios $filtroSQL Order By TpCosto Desc, Run, PeriodoPago";
			$bdHon=$link->query($SQL);
			if($row=mysqli_fetch_array($bdHon)){
				do{
					$n++;
					$tr 	= "barraVerde";
					if($row['Cancelado']=='on'){
						$tr = 'barraPagada';
					}
					?>
					<tr id="<?php echo $tr; ?>">
						<td width="10%" style="font-size:16px;" align="center">
							<?php 
								if($n == 1){
									echo 'HONORARIOS ';
								}
							?>
						</td>
						<td  width="10%" align="center">			
							<?php echo $row['IdProyecto']; ?>
						</td>
						<td width="10%" style="font-size:16px;">
							<?php 
								if($row['FechaPago'] != '0000-00-00'){
									$fd = explode('-', $row['FechaPago']);
									echo $fd[2].'-'.$fd[1].'-'.$fd[0]; 
								}
							?>
						</td>
						<td width="10%" style="font-size:16px;">
							<?php
								echo number_format($row['nBoleta'], 0, ',', '.');
							?>
						</td>
						<td width="10%">&nbsp;
							
						</td>
						<td width="30%">
							<?php
								$bdPer=$link->query("SELECT * FROM PersonalHonorarios Where Run = '".$row['Run']."'");
								if($rowP=mysqli_fetch_array($bdPer)){
									echo '<strong>'.$rowP['Paterno'].' '.$rowP['Materno'].' '.$rowP['Nombres'].'</strong>';
								}
							?>
						</td>
						<td width="10%" align="center">
							<?php
								$tHonorarios 	+= $row['Total'];
								$tGral 			+= $row['Total'];
								if($Run != $row['Run']){
									$tPersona = 0;
									$Run	  = $row['Run'];
								}
								$tPersona		+= $row['Total'];
								echo number_format($row['Total'], 0, ',', '.');
								
							?>
						</td>
						<td width="10%" align="center">
							<?php
								//echo number_format($tHonorarios, 0, ',', '.');
								echo number_format($tPersona, 0, ',', '.');
							?>
						</td>
					</tr>
					<?php
				}while ($row=mysqli_fetch_array($bdHon));
			}

			// Facturas
			$tFacturas  = 0;
			$tProveedor = 0;
			$RutProv 	= '';
			
			$n = 0;
			$Campo = 'TpCosto';
			$Orden = 'Desc';
			$TpCosto = '';
			$SQL = "SELECT * FROM Facturas $filtroSQL Order By RutProv";
			$bdHon=$link->query($SQL);
			if($row=mysqli_fetch_array($bdHon)){
				do{
					$n++;
					$tr 	= "barraVerde";
					if($row['Estado']=='P'){
						$tr = 'barraPagada';
					}
					?>
					<tr id="<?php echo $tr; ?>">
						<td width="10%" style="font-size:16px;" align="center">
							<?php 
								if($n == 1){
									echo 'FACTURAS';
								}
							?>
						</td>
						<td  width="10%" align="center">			
							<?php echo $row['IdProyecto']; ?>
						</td>
						<td width="10%" style="font-size:16px;">
							<?php 
								if($row['FechaPago'] != '0000-00-00'){
									$fd = explode('-', $row['FechaPago']);
									echo $fd[2].'-'.$fd[1].'-'.$fd[0]; 
								}
							?>
						</td>
						<td width="10%" style="font-size:16px;">
							<?php
								echo number_format($row['nFactura'], 0, ',', '.');
							?>
						</td>
						<td width="10%">&nbsp;
							
						</td>
						<td width="30%">
							<?php
								$bdPer=$link->query("SELECT * FROM Proveedores Where RutProv = '".$row['RutProv']."'");
								if($rowP=mysqli_fetch_array($bdPer)){
									echo '<strong>'.$rowP['Proveedor'].'</strong>';
								}
							?>
						</td>
						<td width="10%" align="center">
							<?php
								echo number_format($row['Bruto'], 0, ',', '.');
								$tFacturas 	+= $row['Bruto'];
								$tGral 		+= $row['Bruto'];
								if($RutProv != $row['RutProv']){
									$tProveedor = 0;
									$RutProv    = $row['RutProv'];
								}
								$tProveedor	+= $row['Bruto'];
							?>
						</td>
						<td width="10%" align="center">
							<?php
								echo number_format($tProveedor, 0, ',', '.');
							?>
						</td>
					</tr>
					<?php
				}while ($row=mysqli_fetch_array($bdHon));
			}
			
			$link->close();
		?>
	</table>
	<table width="99%"  border="0" cellspacing="0" cellpadding="0" id="CajaPieInfos">
		<tr>
			<td  width="10%" align="center" height="40">&nbsp;</td>
			<td  width="10%" align="center">&nbsp;</td>
			<td  width="10%" align="center">&nbsp;</td>
			<td  width="40%" align="center">&nbsp;</td>
			<td  width="10%" align="center"> 			
				<strong>
					<?php echo number_format($tGral, 0, ',', '.'); ?>
				</strong>
			</td>
		</tr>
	</table>
		
	<?php
}
?>











